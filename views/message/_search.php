<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MessageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'msg_id') ?>

    <?= $form->field($model, 'msg_type') ?>

    <?= $form->field($model, 'msg_dep_id') ?>

    <?= $form->field($model, 'msg_created') ?>

    <?= $form->field($model, 'msg_person') ?>

    <?php // echo $form->field($model, 'msg_email') ?>

    <?php // echo $form->field($model, 'msg_phone') ?>

    <?php // echo $form->field($model, 'msg_subject') ?>

    <?php // echo $form->field($model, 'msg_child') ?>

    <?php // echo $form->field($model, 'msg_child_birth') ?>

    <?php // echo $form->field($model, 'msg_ekis_id') ?>

    <?php // echo $form->field($model, 'msg_text') ?>

    <?php // echo $form->field($model, 'msg_user_id') ?>

    <?php // echo $form->field($model, 'msg_user_setted') ?>

    <?php // echo $form->field($model, 'msg_answer_period') ?>

    <?php // echo $form->field($model, 'msg_answer') ?>

    <?php // echo $form->field($model, 'msg_answer_time') ?>

    <?php // echo $form->field($model, 'msg_comment') ?>

    <?php // echo $form->field($model, 'msg_status') ?>

    <?php // echo $form->field($model, 'msg_talk_start') ?>

    <?php // echo $form->field($model, 'msg_talk_finish') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
