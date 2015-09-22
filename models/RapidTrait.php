<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 22.09.2015
 * Time: 18:10
 */

namespace app\models;

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

        return $b;
//        return $this->password === $password;
    }


}