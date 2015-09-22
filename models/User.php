<?php

namespace app\models;

use yii;
use yii\base\InvalidValueException;
use yii\base\InvalidParamException;
use yii\db\ActiveQueryInterface;

use app\components\Storage;
use app\models\Department;
use app\models\Depusers;

class User extends \yii\base\Model implements \yii\web\IdentityInterface
{
    public $_storage = null;

    private $_related = [];

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
/*
    public function getData($throwExcaptionOnEmpty = false) {
        if( $this->_user === false ) {
            if( $throwExcaptionOnEmpty && !Yii::$app->session->has(self::SESSION_DATA_KEY) ) {
                throw new InvalidValueException('User data not found');
            }
            $this->_user = Storage; // Yii::$app->session->get(self::SESSION_DATA_KEY, []);
        }
        return $this->_user;
    }
*/
    /**
     * При изменении данных пишем их в сессию
     *
     * @param $key
     * @param $val
     */
/*
    public function setData($key, $val) {
        if( $this->_user !== false ) {
            $this->_user[$key] = $val;
            Yii::$app->session->set(self::SESSION_DATA_KEY, $this->_user);
        }
    }
*/
    /**
     * @param string $name
     * @return mixed
     * @throws yii\base\UnknownPropertyException
     */
    public function __get($name)
    {
//        Yii::info('User::__get('.$name.'): $this->_storage = ' . (($this->_storage === null) ? 'null' : get_class($this->_storage)));
        $aData = ($this->_storage === null) ? [] : $this->_storage->getUser();
        if( count($aData) === 0 ) {
            throw new InvalidParamException('Trying to get property of non-object');
//            return null;
        } elseif( array_key_exists($name, $aData) ) {
//            Yii::info('User::__get('.$name.') return '.$aData[$name]);
            return $aData[$name];
        } else {
//            Yii::info('User::__get('.$name.') -> parent::__get('.$name.')');
            if (isset($this->_related[$name]) || array_key_exists($name, $this->_related)) {
                return $this->_related[$name];
            }
            $value = parent::__get($name);
            if ($value instanceof ActiveQueryInterface) {
                return $this->_related[$name] = $value->findFor($name, $this);
            } else {
                return $value;
            }
//            return parent::__get($name);
        }
    }
/*
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
*/
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

    /**
     * Copy-past from BaseActiveRecord
     *
     * @param $class
     * @param $link
     * @return ActiveQuery
     */
    public function hasMany($class, $link)
    {
        /* @var $class ActiveRecordInterface */
        /* @var $query ActiveQuery */
        $query = $class::find();
        $query->primaryModel = $this;
        $query->link = $link;
        $query->multiple = true;
        return $query;
    }

    /**
     * Relation to departments
     *
     * @return ActiveQuery
     */
    public function getDepartments() {
        Yii::trace('User::getDepartments()');
        return $this->hasMany(
            Depusers::className(),
            ['dus_us_id' => 'us_id']
        );
    }
}
