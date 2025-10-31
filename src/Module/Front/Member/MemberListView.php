<?php

declare(strict_types=1);

namespace Lyrasoft\Member\Module\Front\Member;

use Lyrasoft\Luna\Entity\Category;
use Lyrasoft\Member\Entity\Member;
use Lyrasoft\Member\Repository\MemberRepository;
use Lyrasoft\Luna\Module\Front\Category\CategoryViewTrait;
use Unicorn\Selector\ListSelector;
use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Attributes\ViewMetadata;
use Windwalker\Core\Attributes\ViewModel;
use Windwalker\Core\Attributes\ViewPrepare;
use Windwalker\Core\Html\HtmlFrame;
use Windwalker\Core\Language\TranslatorTrait;
use Windwalker\Core\View\View;
use Windwalker\Core\View\ViewModelInterface;
use Windwalker\Data\Collection;
use Windwalker\DI\Attributes\Autowire;

/**
 * The MemberListView class.
 */
#[ViewModel(
    layout: 'member-list',
    js: 'member-list.js'
)]
class MemberListView
{
    use CategoryViewTrait;
    use TranslatorTrait;

    /**
     * Constructor.
     */
    public function __construct(
        #[Autowire]
        protected MemberRepository $repository,
    ) {
        //
    }

    /**
     * Prepare View.
     *
     * @param  AppContext  $app   The web app context.
     * @param  View        $view  The view object.
     *
     * @return  mixed
     */
    #[ViewPrepare]
    public function prepare(AppContext $app, View $view): array
    {
        $path = $app->input('path');
        $category = $this->getCategory(['type' => 'member', 'path' => $path]);

        $view['category'] = $category;

        $limit = 10;
        $page = $app->input('page');

        $items = $this->repository->getListSelector()
            ->addFilter('member.state', 1)
            ->addFilter('category.state', 1)
            ->tapIf(
                (bool) $category,
                fn(ListSelector $selector) => $selector->where('category.lft', '>=', $category->lft)
                    ->where('category.rgt', '<=', $category->rgt)
            )
            ->ordering('member.created', 'DESC')
            ->page($page)
            ->limit($limit);

        $pagination = $items->getPagination();

        $items = $items->getIterator(Member::class);

        return compact('items', 'pagination');
    }

    #[ViewMetadata]
    public function viewMetadata(HtmlFrame $htmlFrame, ?Category $category = null): void
    {
        if ($category) {
            $htmlFrame->setTitle(
                $this->trans('member.meta.list.title', category: $category->title)
            );
        } else {
            $htmlFrame->setTitle(
                $this->trans('member.meta.list.title.root')
            );
        }
    }
}
