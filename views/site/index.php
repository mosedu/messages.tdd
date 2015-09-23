<?php

use app\components\Storage;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
/*
$ob = new Storage();
$username = 'alfmaster@alfmaster.ru';
$password = '7876765';
$res = $ob->remoteLogin($username, $password);
if( is_array($res) && isset($res['expires_in']) ) {
    $res['expires_in'] = date('d.m.Y H:i:s', $res['expires_in']);
}

$data = $ob->loadUser(47);
//        echo $res->getBody();
*/
$aPermission = [
    'createMessage',
    'updateMessage',
    'user',
    'admin',
];
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p><?= Yii::$app->user->isGuest ? 'guest' : 'user' ?></p>
                <p><?= implode(', ', Yii::$app->authManager->defaultRoles) ?></p>
                <?php

                foreach( $aPermission as $v ) {
                    echo '<p>' . $v . ' : ' . (Yii::$app->user->can($v) ? 'true' : 'false') . '</p>';
                }


                ?>
                <p><?= '' // nl2br(print_r($res, true)) ?></p>
                <p><?= '' // nl2br(print_r($data, true)) ?></p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
