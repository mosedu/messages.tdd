<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Message', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'msg_id',
            'msg_type',
            'msg_dep_id',
            'msg_created',
            'msg_person',
            // 'msg_email:email',
            // 'msg_phone',
            // 'msg_subject',
            // 'msg_child',
            // 'msg_child_birth',
            // 'msg_ekis_id',
            // 'msg_text:ntext',
            // 'msg_user_id',
            // 'msg_user_setted',
            // 'msg_answer_period',
            // 'msg_answer:ntext',
            // 'msg_answer_time',
            // 'msg_comment:ntext',
            // 'msg_status',
            // 'msg_talk_start',
            // 'msg_talk_finish',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
