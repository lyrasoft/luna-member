<?php

/**
 * Part of eva project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Member;

use Lyrasoft\Member\Entity\Member;
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
        // Admin + Front + Model
        $installer->installMVCModules(Member::class);
        // Admin + Front, no model
        $installer->installMVCModules(Member::class, model: false);
        // Only Admin + Model
        $installer->installMVCModules(Member::class, ['Admin'], true);
    }
}
