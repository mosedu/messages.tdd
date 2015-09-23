<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 22.09.2015
 * Time: 18:10
 */

namespace app\models;

use yii;
use app\components\Storage;

trait RapidTrait {

    public $_storage = null;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = null;
        $ob = new Storage();
        $aData = $ob->getUser();
        if( count($aData) != 0 ) {
            $user = new static();
            $user->_storage = $ob;
        }
        Yii::info('findIdentity('.$id.'): ' . ($user === null ? 'null' : 'USER'));
        return $user;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = null;
        $ob = new Storage();
        try {
            if( $ob->getApiToken() == $token ) {
                $user = new static();
                $user->_storage = $ob;
            }
        }
        catch(\Exception $e) {
            //
        }
        Yii::info('findIdentityByAccessToken('.$token.', '.$type.'): ' . ($user === null ? 'null' : 'USER'));

        return $user;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username, $password)
    {
        $user = null;
        $ob = new Storage();
        try {
            $aData = $ob->getUserByUsername($username, $password);
            $user = new static();
            $user->_storage = $ob;
        }
        catch(\Exception $e) {
            //
        }
        Yii::info('findByUsername('.$username.', '.$password.'): ' . ($user === null ? 'null' : 'USER'));

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        try {
            $id = $this->us_id;
        }
        catch(\Exception $e) {
            $id = 0;
        }
        Yii::info('getId(): ' . $id);
        return $id;
    }

    /**
     * @inheritdoc
     */
    public function getUsername()
    {
        try {
            $id = $this->us_login;
        }
        catch(\Exception $e) {
            $id = '';
        }
        Yii::info('getUsername(): ' . $id);
        return $id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        try {
            $token = $this->_storage->getApiToken();
        }
        catch(\Exception $e) {
            $token = '';
        }
        Yii::info('getAuthKey(): ' . $token);
        return $token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
//        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        try {
            $b = $this->_storage->comparePassword($password);
        }
        catch(\Exception $e) {
            $b = false;
        }

        Yii::info('validatePassword('.$password.'): ' . ($b ? 'true' : 'false'));
        return $b;
//        return $this->password === $password;
    }


}