<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\commands;

use app\database\seeders\RbacSeeder;
use app\database\seeders\UserSeeder;
use manchenkov\yii\console\Command;

/**
 * Seeder for load fake or prepared data into a database
 * @package App\Commands
 */
class SeedController extends Command
{
    /**
     * List of actions which provides data to seeding
     * @return array
     */
    public function actions()
    {
        return [
            // application seeders
            'user' => UserSeeder::class,
            'rbac' => RbacSeeder::class,
        ];
    }
}