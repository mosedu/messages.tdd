<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Depusers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="depusers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dus_us_id')->textInput() ?>

    <?= $form->field($model, 'dus_dep_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
