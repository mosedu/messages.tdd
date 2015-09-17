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

class Storage extends yii\base\Object {
    const SESSION_DATA_KEY = 'user-data'; // ключик для сохранения данных в сессии
    const SESSION_API_KEY = 'user-api-key'; // ключик для сохранения api key в сессии

    public $remoteHost = 'http://rbactest.design';
    public $authPath = '/oauthmodule/credential/token';
    public $dataPath = '/v1/user/info';


    public function getUser($id = null) {
        if( $id === null ) {
            // возвращаем текущего пользователя
            if( !Yii::$app->session->has(self::SESSION_DATA_KEY) ) {
                throw new InvalidValueException('User data not found');
//                return Yii::$app->session->get(self::SESSION_DATA_KEY, []);
            }
            return Yii::$app->session->get(self::SESSION_DATA_KEY);
        }
        return $this->loadUser($id);
    }

    public function loadUser($id) {
        $client = new Client();
        try{
            $res = $client->request(
                'GET',
                $this->remoteHost . $this->dataPath,
                [
                    'auth' => $this->getApiKey(),
                ]
            );
        }

        catch(ServerException $e) {
            Yii::error('Error loadUser('.$id.'): ServerException ' . $e->getMessage());
            // тут что-то с сервером, нужно будет подождать До очередного запроса
            return 'Server error';
        }

        catch(ClientException $e) {
            Yii::error('Error loadUser('.$id.'): ClientException ' . $e->getMessage());
            $res = $e->getResponse();
            $aData = json_decode($res->getBody()->getContents(), true);
            if( is_array($aData) && isset($aData['status']) && ($aData['status'] < 500) ) {
                // тут пользователь отключен, нужно убить все права
            }
            return $aData;
        }

        catch(\Exception $e) {
            Yii::error('Error loadUser('.$id.'): Exception ' . $e->getMessage());
            return $e->getMessage();
        }

        return $res->getBody()->getContents();
    }

    /**
     * Получаем текущий token из сессии
     * @return string
     */
    public function getApiKey() {
        if( !Yii::$app->session->has(self::SESSION_API_KEY) ) {
            throw new InvalidValueException('Not found Api key');
        }

        $aKey = Yii::$app->session->get(self::SESSION_API_KEY);

        if( $aKey['expires_in'] > time() ) {
            // TODO: обработать 'expires_in'
            $client = new Client();
            $parameters = array(
                'grant_type'    => 'refresh_token',
                'type'          => 'web_server',
                'client_id'     => $_SERVER['HTTP_HOST'],
                'client_secret' => '',
                'refresh_token' => $aKey['refresh_token'],
            );

            try{
                $res = $client->request(
                    'GET',
                    $this->remoteHost . $this->authPath,
                    [
                        'form_params' => $parameters,
                    ]
                );
            }

            catch(ServerException $e) {
                Yii::error('Error getApiKey(): refresh token '.$aKey['refresh_token'].' ServerException ' . $e->getMessage());
                // тут что-то с сервером, нужно будет подождать До очередного запроса
                return 'Server error';
            }

            catch(ClientException $e) {
                Yii::error('Error getApiKey(): refresh token '.$aKey['refresh_token'].' ClientException ' . $e->getMessage());
                $res = $e->getResponse();
                $aData = json_decode($res->getBody()->getContents(), true);
                if( is_array($aData) && isset($aData['status']) && ($aData['status'] < 500) ) {
                    // тут пользователь отключен, нужно убить все права
                }
                return $aData;
            }

            catch(\Exception $e) {
                Yii::error('Error getApiKey(): refresh token '.$aKey['refresh_token'].' Exception ' . $e->getMessage());
                return $e->getMessage();
            }
        }

        return $aKey['access_token'];
    }

    public function remoteLogin($username, $password) {
        if( Yii::$app->session->has(self::SESSION_API_KEY) ) {
            return Yii::$app->session->get(self::SESSION_API_KEY);
        }

        $client = new Client();

        $bodyParams = array(
            'client_id'     => $_SERVER['HTTP_HOST'],
            'client_secret' => '',
            'username' => $username,
            'password' => $password,
            'grant_type'    => 'password',
        );

        try{
//            $res = $client->post(
            $res = $client->request(
                'POST',
                $this->remoteHost . $this->authPath,
                [
                    'form_params' => $bodyParams,
                ]
            );
        }

        catch(ServerException $e) {
            Yii::error('Error remoteLogin('.$username.'): ServerException ' . $e->getMessage());
            // тут что-то с сервером, нужно будет подождать До очередного запроса
            return 'Server error';
        }

        catch(ClientException $e) {
            Yii::error('Error remoteLogin('.$username.'): ClientException ' . $e->getMessage());
            $res = $e->getResponse();
            $aData = json_decode($res->getBody()->getContents(), true);
            if( is_array($aData) && isset($aData['status']) && ($aData['status'] < 500) ) {
                // тут пользователь отключен, нужно убить все права
            }
            return $aData;
        }

        catch(\Exception $e) {
            Yii::error('Error remoteLogin('.$username.'): Exception ' . $e->getMessage());
            return $e->getMessage();
        }
//        $aData = json_decode((string) $res->getBody(), true);
        $aData = json_decode($res->getBody()->getContents(), true);
        $aData['expires_in'] = time() + $aData['expires_in'];
        Yii::$app->session->set(self::SESSION_API_KEY, $aData);
        return $aData;
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
        $defaultParam = [
            'method' => 'GET',
            'headers' => [],
        ];

        foreach( $defaultParam As $k=>$v ) {
            if( !isset($param[$k]) ) {
                $param[$k] = $v;
            }
        }


        $client = new Client();
        Yii::trace('makeRequest('.$param['method'].', '.$param['url'].')' . "\n" . print_r($param['data'], true) . "\n" . print_r($param['headers'], true));

        try{
            $aDop = [];

            if( count($param['data']) > 0 ) {
                $aDop['form_params'] = $param['data'];
            }

            if( count($param['headers']) > 0 ) {
                $aDop['headers'] = $param['headers'];
            }


            $res = $client->request(
                $param['method'],
                $param['url'],
                $aDop
            );
        }

        catch(ServerException $e) {
            Yii::error('Error makeRequest(): ServerException ' . $e->getMessage());
            // тут что-то с сервером, нужно будет подождать До очередного запроса
            return 'Server error';
        }

        catch(ClientException $e) {
            Yii::error('Error makeRequest(): ClientException ' . $e->getMessage());
            $res = $e->getResponse();
            $aData = json_decode($res->getBody()->getContents(), true);
            if( is_array($aData) && isset($aData['status']) && ($aData['status'] < 500) ) {
                // тут пользователь отключен, нужно убить все права
            }
            return $aData;
        }

        catch(\Exception $e) {
            Yii::error('Error makeRequest(): Exception ' . $e->getMessage());
            return $e->getMessage();
        }
    }
}