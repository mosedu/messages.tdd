<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 23.09.2015
 * Time: 15:11
 */

namespace app\rbac;

use Yii;
use yii\rbac\Rule;

class UserGroupRule extends Rule {
    public $name = 'usergrouprule';

    public function execute($user, $item, $params) {
//        Yii::info('UserGroupRule::execute() : user = ' . print_r($user, true) . "\nitem = " . print_r($item, true) . "\nparams = " . print_r($params, true));
        if( !Yii::$app->user->isGuest ) {
            $groupId = Yii::$app->params['user.groups'];
//            Yii::info('UserGroupRule::execute() : groupId = ' . print_r($groupId, true));
            $itemName = $item->name;
            $groups = Yii::$app->user->identity->groups;
//            Yii::info('UserGroupRule::execute() : groupId['.$itemName.'] = ' . $groupId[$itemName]);
//            Yii::info('UserGroupRule::execute() : groups = ' . print_r($groups, true));
            Yii::info('UserGroupRule::execute() : user = ' . $user . ' item = ' . $itemName . ' = ' . (isset($groups[$groupId[$itemName]]) ? 'true' : 'false'));
            return isset($groups[$groupId[$itemName]]);
/*
            if( $itemName === 'admin' ) {
                return isset($groups[$groupsId[$itemName]]);
            } elseif ($item->name === 'leader') {
                return isset($groups[$groupsId['admin']]);
            }
*/
        }
        return false;
    }

}