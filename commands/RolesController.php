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

        $createDep = $auth->createPermission('createDepartment');
        $createDep->description = 'Create a department';
        $auth->add($createDep);

        $updateDep = $auth->createPermission('updateDepartment');
        $updateDep->description = 'Update a department';
        $auth->add($updateDep);

        $viewDep = $auth->createPermission('viewDepartment');
        $viewDep->description = 'View a department';
        $auth->add($viewDep);

        $workDep = $auth->createPermission('workDepartment');
        $workDep->description = 'Work with a department';
        $auth->add($workDep);
        $auth->addChild($workDep, $viewDep);
        $auth->addChild($workDep, $createDep);
        $auth->addChild($workDep, $updateDep);

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
        $auth->addChild($admin, $workDep);
        $auth->addChild($admin, $updateMsg);
        $auth->addChild($admin, $user);
        echo "Create admin\n";
    }
}
