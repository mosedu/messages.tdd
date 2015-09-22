<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 22.09.2015
 * Time: 16:03
 */

namespace tests\codeception\unit\models;

use yii;
use yii\codeception\TestCase;

use tests\codeception\unit\fixtures\DepusersFixture;

use app\models\User;
use app\models\Depusers;


class UserdepTest extends TestCase {

    protected function setUp()
    {
        parent::setUp();
        // uncomment the following to load fixtures for user table
        Depusers::deleteAll();
        $this->loadFixtures();
//        $this->loadFixtures(['depusers']);
    }

    public function fixtures() {
        return [
            'depusers' => [
                'class' => DepusersFixture::className(),
                'dataFile' => '@tests/codeception/unit/fixtures/data/depusers.php',
            ],
        ];
    }

    /**
     * @dataProvider goodRequestDataProvider
     */

    public function testRemoteUserDepartments($username, $pass) {

        Yii::trace('Fixtures count: ' . count(Depusers::findAll('dus_id > 0')) );

        $user = User::findByUsername($username, $pass);

        $this->assertNotNull($user, 'User must not be NULL');

        $this->assertContains($username, [$user->us_login, $user->us_email], 'User has credential in login ore email fields');

        $this->assertTrue($user->id > 0, 'User Id must be grater then 0');

        $aRel = [
            'lioly' => 3,
            'alfmaster' => 2,
        ];

        $this->assertEquals($aRel[$user->us_login], count($user->departments), 'User has relational records ('.$aRel[$user->us_login].')');
    }


    public function goodRequestDataProvider() {
        return [
            ['alfmaster@alfmaster.ru', '7876765', ],
            ['lioly', '1123581321', ],
        ];
    }


}