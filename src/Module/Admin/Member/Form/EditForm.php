<?php

/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    __LICENSE__
 */

declare(strict_types=1);

namespace Lyrasoft\Member\Module\Admin\Member\Form;

use Lyrasoft\Luna\Field\CategoryListField;
use Lyrasoft\Luna\Field\UserModalField;
use Unicorn\Field\CalendarField;
use Unicorn\Field\SwitcherField;
use Unicorn\Field\TinymceEditorField;
use Windwalker\Core\Language\TranslatorTrait;
use Windwalker\Form\Field\EmailField;
use Windwalker\Form\Field\TextareaField;
use Unicorn\Field\SingleImageDragField;
use Windwalker\Form\Field\NumberField;
use Windwalker\Form\Field\HiddenField;
use Unicorn\Enum\BasicState;
use Windwalker\Form\Field\ListField;
use Windwalker\Form\Field\TextField;
use Windwalker\Form\FieldDefinitionInterface;
use Windwalker\Form\Form;

/**
 * The EditForm class.
 */
class EditForm implements FieldDefinitionInterface
{
    use TranslatorTrait;

    /**
     * Define the form fields.
     *
     * @param  Form  $form  The Windwalker form object.
     *
     * @return  void
     */
    public function define(Form $form): void
    {
        $form->add('name', TextField::class)
            ->label($this->trans('member.field.name'))
            ->addFilter('trim');

        $form->add('alias', TextField::class)
            ->label($this->trans('unicorn.field.alias'))
            ->addFilter('trim');

        $form->fieldset(
            'basic',
            function (Form $form) {
                $form->add('image', SingleImageDragField::class)
                    ->label($this->trans('unicorn.field.image'))
                    ->crop(true)
                    ->width(400)
                    ->height(400);

                $form->add('intro', TextareaField::class)
                    ->label($this->trans('member.field.intro'))
                    ->rows(7);

                $form->add('description', TinymceEditorField::class)
                    ->label($this->trans('unicorn.field.description'))
                    ->editorOptions(
                        [
                            'height' => 550
                        ]
                    );
            }
        );

        $form->fieldset(
            'detail',
            function (Form $form) {
                $form->add('category_id', CategoryListField::class)
                    ->label($this->trans('member.field.category'))
                    ->categoryType('member')
                    ->option($this->trans('unicorn.select.placeholder'));

                $form->add('job_title', TextField::class)
                    ->label($this->trans('member.field.job.title'));

                $form->add('email', EmailField::class)
                    ->label($this->trans('member.field.email'));

                $form->add('phone', TextField::class)
                    ->label($this->trans('member.field.phone'));
            }
        );

        $form->fieldset(
            'meta',
            function (Form $form) {
                $form->add('state', SwitcherField::class)
                    ->label($this->trans('unicorn.field.published'))
                    ->circle(true)
                    ->color('success')
                    ->defaultValue('1');

                $form->add('created', CalendarField::class)
                    ->label($this->trans('unicorn.field.created'))
                    ->disabled(true);

                $form->add('modified', CalendarField::class)
                    ->label($this->trans('unicorn.field.modified'))
                    ->disabled(true);

                $form->add('created_by', UserModalField::class)
                    ->label($this->trans('unicorn.field.created.by'))
                    ->disabled(true);

                $form->add('modified_by', UserModalField::class)
                    ->label($this->trans('unicorn.field.modified.by'))
                    ->disabled(true);
            }
        );

        $form->add('id', HiddenField::class);
    }
}
