<?php

namespace tests\codeception\unit\models;

use yii\codeception\TestCase;
use app\models\User;

class UserTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        // uncomment the following to load fixtures for user table
        //$this->loadFixtures(['user']);
    }

    // TODO add test methods here
    /**
     * @dataProvider goodRequestDataProvider
     */

    public function testRemoteUser($username, $pass) {
        $user = User::findByUsername($username, $pass);

        $this->assertNotNull($user, 'User must not be NULL');

        $this->assertContains($username, [$user->us_login, $user->us_email], 'User has credential in login ore email fields');

        $this->assertTrue($user->id > 0, 'User Id must be grater then 0');

    }


    public function goodRequestDataProvider() {
        return [
            ['alfmaster@alfmaster.ru', '7876765', ],
            ['lioly', '1123581321', ],
        ];
    }

}
