<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = $model->msg_id;
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->msg_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->msg_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'msg_id',
            'msg_type',
            'msg_dep_id',
            'msg_created',
            'msg_person',
            'msg_email:email',
            'msg_phone',
            'msg_subject',
            'msg_child',
            'msg_child_birth',
            'msg_ekis_id',
            'msg_text:ntext',
            'msg_user_id',
            'msg_user_setted',
            'msg_answer_period',
            'msg_answer:ntext',
            'msg_answer_time',
            'msg_comment:ntext',
            'msg_status',
            'msg_talk_start',
            'msg_talk_finish',
        ],
    ]) ?>

</div>
