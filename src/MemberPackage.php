<?php

/**
 * Part of eva project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    __LICENSE__
 */

declare(strict_types=1);

namespace Lyrasoft\Member;

use Windwalker\Core\Package\AbstractPackage;
use Windwalker\Core\Package\PackageInstaller;

/**
 * The MemberPackage class.
 */
class MemberPackage extends AbstractPackage
{
    public function install(PackageInstaller $installer): void
    {
        $installer->installLanguages(static::path('resources/languages/**/*.ini'), 'lang');
        $installer->installMigrations(static::path('resources/migrations/**/*'), 'migrations');
        $installer->installSeeders(static::path('resources/seeders/**/*'), 'seeders');
        $installer->installRoutes(static::path('routes/**/*.php'), 'routes');

        // Modules
        $installer->installModules(
            [
                static::path("src/Module/Admin/Member/**/*") => "@source/Module/Admin/Member",
            ],
            ['Lyrasoft\\Luna\\Module\\Admin' => 'App\\Module\\Admin'],
            ['modules', 'member_admin'],
        );

        $installer->installModules(
            [
                static::path("src/Module/Front/Member/**/*") => "@source/Module/Front/Member",
            ],
            ['Lyrasoft\\Luna\\Module\\Front' => 'App\\Module\\Front'],
            ['modules', 'member_front'],
        );

        $installer->installModules(
            [
                static::path("src/Entity/Member.php") => '@source/Entity',
                static::path("src/Repository/MemberRepository.php") => '@source/Repository',
            ],
            [
                'Lyrasoft\\Luna\\Entity' => 'App\\Entity',
                'Lyrasoft\\Luna\\Repository' => 'App\\Repository',
            ],
            ['modules', 'member_model']
        );
    }
}
