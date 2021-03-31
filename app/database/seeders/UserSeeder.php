<?php

declare(strict_types=1);

namespace app\database\seeders;

use app\models\auth\User;
use Exception;
use manchenkov\yii\console\command\Command;
use yii\base\Action;

/**
 * Class UserSeeder
 * @package App\Database\Seeders
 *
 * @property-read Command $controller
 */
final class UserSeeder extends Action
{
    /**
     * Creates a default admin user
     * @throws \yii\base\Exception
     */
    public function run(): void
    {
        $admin = new User(
            [
                'email' => config('email.admin'),
                'first_name' => 'super',
                'last_name' => 'user',
                'is_active' => true,
            ]
        );

        $admin->generateToken();
        $admin->password = '123123#';

        try {
            if ($admin->save()) {
                $this->controller->info("User: {$admin->email} was created");
            } else {
                $this->controller->error("An error occurred while creating a user");
            }
        } catch (Exception $exception) {
            $this->controller->error($exception->getMessage());
        }
    }
}