<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii;
use yii\console\Controller;

/**
 *
 */
class RolesController extends Controller
{
    /**
     *
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        $rule = new \app\rbac\UserGroupRule;
        $auth->add($rule);

        $createMsg = $auth->createPermission('createMessage');
        $createMsg->description = 'Create a message';
        $auth->add($createMsg);

        $updateMsg = $auth->createPermission('updateMessage');
        $updateMsg->description = 'Update message';
        $auth->add($updateMsg);

        $user = $auth->createRole('user');
        $user->ruleName = $rule->name;
        $auth->add($user);
        $auth->addChild($user, $createMsg);
        echo "Create user\n";

        $admin = $auth->createRole('admin');
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $updateMsg);
        $auth->addChild($admin, $user);
        echo "Create admin\n";
    }
}
