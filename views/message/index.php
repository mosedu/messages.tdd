<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Message;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Обращения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать обращение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'msg_id',
                'content' => function ($model, $key, $index, $column) {
                    /** @var Message $model */
                    return Html::encode($model->msg_id)
                    . '<br />'
                    . Html::encode($model->getType('short'));
                },
                'contentOptions' => [
                    'class' => 'griddate',
                    'style' => 'width: 70px;'
                ],
            ],

            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'msg_person',
                'content' => function ($model, $key, $index, $column) {
                    /** @var Message $model */
                    return Html::encode($model->msg_person)
                    . ($model->msg_email ? ('<br />' . $model->msg_email) : '')
                    . ($model->msg_phone ? ('<br />' . $model->msg_phone) : '');
                },
                'contentOptions' => [
                    'class' => 'griddate',
                    'style' => 'width: 70px;'
                ],
            ],

//            'msg_id',
//            'msg_type',
//            'msg_dep_id',
            'msg_created',
//            'msg_person',
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
