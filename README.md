# LYRASOFT Member Package

## Installation

Install from composer

```shell
composer require lyrasoft/member
```

Then copy files to project

```shell
php windwalker pkg:install lyrasoft/member -t routes -t lang -t migrations -t seeders
```

## Register Admin Menu

Edit `resources/menu/admin/sidemenu.menu.php`

```php
// Category
$menu->link(
    '成員分類',
    $nav->to('category_list', ['type' => 'member'])
)
    ->icon('fal fa-sitemap');

// Member
$menu->link(
    '成員管理',
    $nav->to('member_list')
)
    ->icon('fal fa-images');
```
