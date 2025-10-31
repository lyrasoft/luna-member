# LYRASOFT Member Package

![p-001-2021-11-23-03-12-35](https://user-images.githubusercontent.com/1639206/142921263-19599c30-8baa-4a69-83f4-376e3d33b6a6.jpg)

## Installation

Install from composer

```shell
composer require lyrasoft/member
```

Then copy files to project

```shell
php windwalker pkg:install lyrasoft/member -t routes -t migrations -t seeders
```

Seeders

- Add `member.seeder.php` to `resources/seeders/main.seeder.php`
- Add `member` type to `category.seeder.php`

### Languages

Add this line to admin & front middleware:

```php
$this->lang->loadAllFromVendor(\Lyrasoft\Member\MemberPackage::class, 'ini');
```

If you want to copy language files, use this command:

```shell
php windwalker pkg:install lyrasoft/member -t lang
```

## Register Admin Menu

Edit `resources/menu/admin/sidemenu.menu.php`

```php
// Category
$menu->link('成員分類')
    ->to($nav->to('category_list', ['type' => 'member']))
    ->icon('fal fa-sitemap');

// Portfolio
$menu->link('成員管理')
    ->to($nav->to('member_list'))
    ->icon('fal fa-person');
```
