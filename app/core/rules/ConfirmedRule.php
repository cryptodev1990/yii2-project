<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

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
    public function execute($user, $item, $params)
    {
        $model = User::findOne($user);

        if ($model) {
            return $model->is_active;
        }

        return false;
    }
}