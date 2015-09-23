<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 17.09.2015
 * Time: 13:57
 */

namespace app\components;

use yii;
use yii\base\InvalidValueException;
use yii\base\InvalidParamException;
use yii\web\Session;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;

/*
token data:
    'access_token' => $sToken,
    'tocken_type' => 'tocken_type',
    'expires_in' => 600, // в секундах
    'refresh_token' => $sRefresh,
*/

class Storage extends yii\base\Object
{
    const SESSION_DATA_KEY = 'user-data-key'; // ключик для сохранения данных в сессии
    const SESSION_API_KEY = 'user-api-key'; // ключик для сохранения api key в сессии
    const SESSION_PASS_KEY = 'user-pass-key'; // ключик для сохранения api key в сессии

    public $remoteHost = 'http://rbactest.design';
    public $authPath = '/oauthmodule/credential/token';
    public $dataPath = '/v1/user/info';

    public $store = null;

    public function __construct() {
        try {
            $sess = Yii::$app->session;
        }
        catch(\Exception $e) {
            $sess = null;
        }
        $this->store = ( $sess === null ) ? new Session() : Yii::$app->session;
//        Yii::info('Storage::__construct() Yii::app->session = ' . var_dump());
    }

    public function getUser($id = null)
    {
        $bExpired = false;
        try {
            $aTokenData = $this->getTokenData();
            $bExpired = $this->isTokenExpired($aTokenData);
        }
        catch( \Exception $e ) {
            return [];
        }

        if( $bExpired || !$this->store->has(self::SESSION_DATA_KEY) ) {
            $aData = $this->loadUser();
        }
        else {
            $aData = $this->store->get(self::SESSION_DATA_KEY);
            if( ($id !== null) && ($aData['us_id'] != $id) ) {
                $aData = [];
            }
        }

        return $aData;
    }

    public function loadUser($id = null)
    {
        $aUserData = [];
        try {
            $res = $this->makeRequest([
                'method' => 'GET',
                'url' => $this->remoteHost . $this->dataPath,
                'data' => [
                    'access_token' => $this->getApiToken(),
                ]
            ]);
        }
        catch(\Exception $e) {
            return $aUserData;
        }

        if ($res['statuscode'] == 200) {
            $aUserData = json_decode($res['response']->getBody()->getContents(), true);
//            Yii::info('loadUser('.$id.'): aUserData = ' . print_r($aUserData, true));
            if( ($id !== null) && ($aUserData['us_id'] != $id) ) {
//                Yii::info('loadUser('.$id.'): '.$aUserData['us_id'].' != ' . $id);
                $aUserData = [];
            }
            else {
//                Yii::info('loadUser('.$id.'): store');
                $this->store->set(self::SESSION_DATA_KEY, $aUserData);
            }
        } else {
            if ($res['statuscode'] < 500) {
                // тут пользователь отключен, нужно убить все права
                $aUserData = [];
            } else {
                // тут что-то с сервером, нужно будет подождать До очередного запроса
                $aUserData = [];
            }
        }
        return $aUserData;
    }

    public function getUserByUsername($name, $pass)
    {
        $keyData = [];
/*

        try {
            $keyData = $this->getTokenData();
        }
        catch(\Exception $e) {
*/
            $keyData = $this->remoteLogin($name, $pass);
            try {
                $this->setTokenData($keyData);
            }
            catch(\Exception $e) {
                //
            }
//        }

        if( !isset($keyData['access_token']) ) {
            return [];
        }
        return $this->loadUser();
    }

    /**
     * Получаем данные по токену из хранилища
     * @return string
     */
    public function getTokenData()
    {
        if ($this->store === null) {
            Yii::info('getTokenData(): error no storage for API token');
            throw new InvalidValueException('Not found storage for API token');
        }

        if (!$this->store->has(self::SESSION_API_KEY)) {
            Yii::info('getTokenData(): error Not found Api token');
            throw new InvalidValueException('Not found Api token');
        }

        return $this->store->get(self::SESSION_API_KEY);
    }

    public function comparePassword($pass)
    {
        $b = false;
        if( ($this->store !== null) && $this->store->has(self::SESSION_PASS_KEY) ) {
            $b = ($this->store->get(self::SESSION_PASS_KEY) == $pass);
        }
        return $b;
    }

    /**
     * Кладем данные по токену в хранилище
     * @param array $aData
     * @return string
     */
    public function setTokenData($aData)
    {
        if ($this->store === null) {
            Yii::info('setTokenData($aData): error no storage');
            throw new InvalidValueException('Not found storage for API token');
        }

//        Yii::info('setTokenData(): ' . print_r($aData, true));
        return $this->store->set(self::SESSION_API_KEY, $aData);
    }

    /**
     * Удаляем данные по токену в хранилище
     * @return string
     */
    public function removeTokenData()
    {
        if ($this->store !== null) {
//            Yii::info('removeTokenData()');
            $this->store->remove(self::SESSION_API_KEY);
        }

    }

    /**
     * Получаем текущий token из сессии или обновляем его
     * @return string
     */
    public function getApiToken()
    {
        $aKey = $this->getTokenData();

        if( $this->isTokenExpired($aKey) ) {
            // TODO: обработать 'expires_in'
            $aKey = $this->refreshToken($aKey);
            $this->setTokenData($aKey);
            if( !isset($aKey['access_token']) ) {
                throw new InvalidValueException('Not found token');
            }
        }
        return $aKey['access_token'];
    }

    /**
     * Токен протух?
     * @param array $aData
     * @return string
     */
    public function isTokenExpired($aData)
    {
        if( !isset($aData['expires_in']) ) {
            throw new InvalidValueException('Not found token expired time');
        }
//        Yii::info('isTokenExpired(): ' . $aData['expires_in'] . ' < ' . time() . ' -> ' . ($aData['expires_in'] < time() ? 'true' : 'false'));
        return ($aData['expires_in'] < time());
    }

    /**
     *
     */
    public function expireToken()
    {
        try {
            $aData = $this->getTokenData();
            $aData['expires_in'] = time() - 10;
            $this->setTokenData($aData);
        }
        catch(\Exception $e) {
            //
        }
    }

    /**
     *
     * Обновление токена
     *
     * @param array $aData
     * @return array
     */
    public function refreshToken($aData) {
        if( !isset($aData['refresh_token']) ) {
            throw new InvalidValueException('Not found refresh token');
        }

        $parameters = array(
            'grant_type' => 'refresh_token',
            'type' => 'web_server',
            'client_id' => $_SERVER['HTTP_HOST'],
            'client_secret' => '',
            'refresh_token' => $aData['refresh_token'],
        );

        $aKey = $aData;

        $res = $this->makeRequest([
            'method' => 'GET',
            'url' => $this->remoteHost . $this->authPath,
            'data' => $parameters,
        ]);

        if ($res['statuscode'] == 200) {
            $aKey = json_decode($res['response']->getBody()->getContents(), true);
//            Yii::info('refreshToken(): refresh token aKey = ' . print_r($aKey, true));
            $aKey['expires_in'] = time() + $aKey['expires_in'];
        } else {
            if ($res['statuscode'] < 500) {
                // тут пользователь отключен, нужно убить все права
                $aKey = [];
            } else {
                // тут что-то с сервером, нужно будет подождать До очередного запроса
            }
        }
        return $aKey;
    }

    /**
     *
     * Получение токена по логину и паролю
     *
     * @param $username
     * @param $password
     * @return array
     */
    public function remoteLogin($username, $password) {
//        Yii::info('remoteLogin('.$username.', '.$password.')');

        $bodyParams = array(
            'client_id'     => $_SERVER['HTTP_HOST'],
            'client_secret' => '',
            'username' => $username,
            'password' => $password,
            'grant_type'    => 'password',
        );

        $aKey = [];

        $aData = $this->makeRequest([
            'method' => 'POST',
            'url' => $this->remoteHost . $this->authPath,
            'data' => $bodyParams,
        ]);

        if( $aData['statuscode'] == 200 ) {
            $aKey = json_decode($aData['response']->getBody()->getContents(), true);
//            Yii::info('remoteLogin() aKey = ' . print_r($aKey, true));
            $aKey['expires_in'] = time() + $aKey['expires_in'];
            $this->store->set(self::SESSION_PASS_KEY, $password);
        }
        else  if($aData['statuscode'] < 500) {
            // тут пользователь отключен, нужно убить все права
            $aKey = [];
            $this->store->remove(self::SESSION_PASS_KEY);
        }
        else {
            // тут что-то с сервером, нужно будет подождать До очередного запроса
        }

        return $aKey;
    }


    /**
     *
     * @param array $param
     *                     data
     *                     url
     *                     method = 'GET'
     *                     headers = []
     * @return array
     */
    public function makeRequest($param) {
//        Yii::info('makeRequest() ' . print_r($param, true));
        $aData = [
            'response' => null,
            'statuscode' => 0,
        ];

        if( !isset($param['url']) ) {
            return $aData;
        }

        $defaultParam = [
            'method' => 'GET',
            'data' => [],
            'headers' => [],
        ];

        foreach( $defaultParam As $k=>$v ) {
            if( !isset($param[$k]) ) {
                $param[$k] = $v;
            }
        }

        $client = new Client();
//        Yii::info('makeRequest('.$param['method'].', '.$param['url'].')' . "\n" . print_r($param['data'], true) . "\n" . print_r($param['headers'], true));

        try{
            $aDop = [];

            if( count($param['data']) > 0 ) {
                $sName = 'form_params';
                if( strtolower($param['method']) !== 'post' ) {
                    $sName = 'query';
                }
                $aDop[$sName] = $param['data'];
            }

            if( count($param['headers']) > 0 ) {
                $aDop['headers'] = $param['headers'];
            }


//            Yii::info('makeRequest('.$param['method'].', '.$param['url'].') ' . print_r($aDop, true));
            $res = $client->request(
                $param['method'],
                $param['url'],
                $aDop
            );

            $aData = [
                'response' => $res, // $res->getBody()->getContents()
                'statuscode' => $res->getStatusCode(),
            ];
        }

        catch(ServerException $e) {
            Yii::error('Error makeRequest(): ServerException ' . $e->getMessage());
            // тут что-то с сервером, нужно будет подождать До очередного запроса
            $res = $e->getResponse();
            $aData = [
                'response' => $res,
                'statuscode' => $res->getStatusCode(),
            ];
        }

        catch(ClientException $e) {
            // тут ошибка при запросе - когда нет прав на доступ
            Yii::error('Error makeRequest(): ClientException ' . $e->getMessage());
            $res = $e->getResponse();
            $aData = [
                'response' => $res,
                'statuscode' => $res->getStatusCode(),
            ];
        }

        catch(\Exception $e) {
            Yii::error('Error makeRequest(): Exception ' . $e->getMessage());
        }

//        Yii::info('makeRequest(): return data = ' . print_r($aData, true));

        return $aData;
    }
}