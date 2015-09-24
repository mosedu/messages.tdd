<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Department;
use app\models\Message;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin([
        'id' => 'message-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnBlur' => false,
        'validateOnType' => false,
    ]); ?>

    <div class="col-md-4">
        <?= $form->field($model, 'msg_type')->dropDownList(Message::getAllTypes()) ?>
        <?= '' // $form->field($model, 'msg_type')->textInput() ?>
    </div>

    <?= '' // $form->field($model, 'msg_dep_id')->textInput() ?>

    <div class="col-md-4">
        <?= $form->field($model, 'msg_dep_id')->dropDownList(Department::getList()) ?>
    </div>

    <div class="clearfix"></div>

    <?= '' // $form->field($model, 'msg_created')->textInput() ?>

    <div class="col-md-4">
    <?= $form->field($model, 'msg_person')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'msg_email')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'msg_phone')->textInput(['maxlength' => true]) ?>
    </div>

    <?= $form->field($model, 'msg_subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'msg_child')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'msg_child_birth')->textInput() ?>

    <?= $form->field($model, 'msg_ekis_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'msg_text')->textarea(['rows' => 6]) ?>

    <?= '' // $form->field($model, 'msg_user_id')->textInput() ?>

    <?= '' // $form->field($model, 'msg_user_setted')->textInput() ?>

    <?= '' // $form->field($model, 'msg_answer_period')->textInput() ?>

    <?= '' // $form->field($model, 'msg_answer')->textarea(['rows' => 6]) ?>

    <?= '' // $form->field($model, 'msg_answer_time')->textInput() ?>

    <?= '' // $form->field($model, 'msg_comment')->textarea(['rows' => 6]) ?>

    <?= '' // $form->field($model, 'msg_status')->textInput() ?>

    <?= '' // $form->field($model, 'msg_talk_start')->textInput() ?>

    <?= '' // $form->field($model, 'msg_talk_finish')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
