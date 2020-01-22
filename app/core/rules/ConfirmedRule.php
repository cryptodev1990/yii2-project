<?php

declare(strict_types=1);

namespace app\core\rules;

use app\models\auth\User;
use yii\rbac\Item;
use yii\rbac\Rule;

class ConfirmedRule extends Rule
{
    public $name = 'isActive';

    /**
     * Determines user confirmation status
     *
     * @param int|string $user
     * @param Item $item
     * @param array $params
     *
     * @return bool
     */
    public function execute($user, $item, $params): bool
    {
        $model = User::findOne($user);

        if ($model) {
            return $model->is_active;
        }

        return false;
    }
}