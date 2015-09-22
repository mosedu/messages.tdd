<?php

// namespace models;
namespace tests\codeception\unit\models;

use app\components\Storage;
use yii\codeception\TestCase;
use yii\web\Session;

// class StorageTest extends \PHPUnit_Framework_TestCase
class StorageTest extends TestCase
{

    // *******************************************************************************************************
    /**
     */
/*
     * @dataProvider badRequestDataProvider
    public function testRequestReturnArrayData($badData) {
        $ob = new Storage();
        $response = $ob->makeRequest($badData);

        $this->assertInternalType(
            'array',
            $response,
            'Request have to return array data'
        );

        $this->assertArrayHasKey(
            'statuscode',
            $response,
            'Request must have statuscode field'
        );

        $this->assertArrayHasKey(
            'response',
            $response,
            'Request must have response field'
        );
    }

    public function badRequestDataProvider() {
        return [
            [
                [
                    'url' => 'http://rbactest.design' . '/oauthmodule/credential/token',
                    'method' => 'POST',
                    'data' => [],
                ]
            ],
            [
                [
                    'url' => 'http://rbactest.design' . '/oauthmodule/credential/token',
                    'method' => 'POST',
                    'data' => [
                        'username' => 'username',
                        'password' => 'password',
                    ],
                ]
            ],
            [
                [
                    'url' => 'http://non-existance-api-host.ru' . '/oauthmodule/credential/token',
                    'method' => 'POST',
                    'data' => [],
                ]
            ],
            [
                []
            ],
        ];
    }
*/
    // *******************************************************************************************************

    /**
     * @dataProvider goodRequestDataProvider
     */
    public function testPostUserCredential($username, $password) {
        // \Yii::info('test: ' . $username . ' + ' . $password);
        $ob = new Storage();
        if( $ob->store === null ) {
            $ob->store = new Session();
        }
        $response = $ob->remoteLogin($username, $password);
        \Yii::info('test: ' . $username . ' + ' . $password);

        $this->assertEquals(4, count($response), 'Answer need to has 4 fields');
        $this->assertTrue(isset($response['access_token']), 'Answer need to has access_token');

        $ob->setTokenData($response);
        $a = $ob->getTokenData();

        $this->assertEquals($ob->getApiToken(), $a['access_token'], 'Get token string');

        $a['expires_in'] -= 36000;
        $ob->setTokenData($a);

        $this->assertFalse($ob->getApiToken() == $a['access_token'], 'Get new token string after refresh');

        $ob->removeTokenData();

//        \Yii::info(' ---------------------------------- Clear session api token data ---------------------------------- ');

        $aData = $ob->getUserByUsername($username, $password);

//        \Yii::info('getUserByUsername() = '. print_r($aData, true));

        $this->assertGreaterThan(2, count($aData), 'User data need to has mare then 2 fields');
        $this->assertContains($username, [$aData['us_login'], $aData['us_email']], 'Login or email in returned data');

        $aData1 = $ob->getUser($aData['us_id']);
        $this->assertEquals(count($aData), count($aData1), 'User has same elements as logged user');
        $this->assertEquals($aData['us_id'], $aData1['us_id'], 'User is same');

        $ob->expireToken();
        $aData2 = $ob->getUser($aData['us_id']);
        $this->assertEquals(count($aData), count($aData1), 'User has same elements as logged user after expared');
        $this->assertEquals($aData['us_id'], $aData1['us_id'], 'User is same after expared');
    }

    public function goodRequestDataProvider() {
        return [
            ['alfmaster@alfmaster.ru', '7876765', ],
            ['lioly', '1123581321', ],
        ];
    }

    // *******************************************************************************************************

    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

}
