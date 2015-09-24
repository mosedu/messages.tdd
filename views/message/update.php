<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = $model->isNewRecord ? 'Создать обращение' : ('Изменить : ' . $model->dep_title);
$this->params['breadcrumbs'][] = ['label' => 'Обращения', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->msg_id, 'url' => ['view', 'id' => $model->msg_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
