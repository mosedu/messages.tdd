<?php

namespace app\models;

use yii;
use app\components\Storage;

class User extends \yii\base\Model implements \yii\web\IdentityInterface
{
    public $_user = false;

//    public $remoteHost = '';
/*
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
*/
    /*
    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];
*/

    /**
     * Получаем данны из хранилища; текущее хранилище - сессия
     *
     * @param boolean $throwExcaptionOnEmpty бросать исключение при отсуттсвии ключа в сессии
     * @return array
     */
    public function getData($throwExcaptionOnEmpty = false) {
        if( $this->_user === false ) {
            if( $throwExcaptionOnEmpty && !Yii::$app->session->has(self::SESSION_DATA_KEY) ) {
                throw new InvalidValueException('User data not found');
            }
            $this->_user = Storage; // Yii::$app->session->get(self::SESSION_DATA_KEY, []);
        }
        return $this->_user;
    }

    /**
     * При изменении данных пишем их в сессию
     *
     * @param $key
     * @param $val
     */
    public function setData($key, $val) {
        if( $this->_user !== false ) {
            $this->_user[$key] = $val;
            Yii::$app->session->set(self::SESSION_DATA_KEY, $this->_user);
        }
    }

    /**
     * @param string $name
     * @return mixed
     * @throws yii\base\UnknownPropertyException
     */
    public function __get($name)
    {
        $aData = $this->getData();
        if( count($aData) === null ) {
            throw new InvalidParamException('Trying to get property of non-object');
//            return null;
        } elseif( array_key_exists($name, $aData) ) {
            return $aData[$name];
        } else {
            return parent::__get($name);
        }
    }

    public function __set($name, $value)
    {
        $aData = $this->getData();
        if( count($aData) === null ) {
            throw new InvalidParamException('Trying to set property of non-object');
        } elseif( array_key_exists($name, $aData) ) {
            $this->setData($name, $value);
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

}
