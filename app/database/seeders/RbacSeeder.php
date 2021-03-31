<?php

declare(strict_types=1);

namespace app\database\seeders;

use app\core\rules\ConfirmedRule;
use Exception;
use manchenkov\yii\console\command\Command;
use yii\base\Action;
use yii\rbac\ManagerInterface;

/**
 * Class RbacSeeder
 * @package app\database\seeders
 *
 * @property-read Command $controller
 */
final class RbacSeeder extends Action
{
    /**
     * Creates basic RBAC configuration
     * @throws Exception
     */
    public function run(): void
    {
        $rbac = app()->authManager;

        $this->baseRoles($rbac);
        $this->confirmedRule($rbac);

        $this->controller->info("RBAC initialized successfully");
    }

    /**
     * @param ManagerInterface $manager
     *
     * @throws \yii\base\Exception
     * @throws Exception
     */
    public function baseRoles(ManagerInterface $manager): void
    {
        $roleAdmin = $manager->createRole('admin');
        $roleUser = $manager->createRole('user');

        $manager->add($roleAdmin);
        $manager->add($roleUser);

        $manager->addChild($roleAdmin, $roleUser);

        $manager->assign($roleAdmin, 1);
    }

    /**
     * @param ManagerInterface $manager
     *
     * @throws Exception
     */
    public function confirmedRule(ManagerInterface $manager): void
    {
        // add custom rule to the RBAC
        $userConfirmedRule = new ConfirmedRule();
        $manager->add($userConfirmedRule);

        // create a permission to work with custom rule
        $confirmed = $manager->createPermission('confirmed');
        $confirmed->description = 'User is active';
        $confirmed->ruleName = $userConfirmedRule->name;

        $manager->add($confirmed);

        $manager->addChild(
            $manager->getRole('user'),
            $confirmed
        );
    }
}