<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Depusers */

$this->title = 'Update Depusers: ' . ' ' . $model->dus_id;
$this->params['breadcrumbs'][] = ['label' => 'Depusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dus_id, 'url' => ['view', 'id' => $model->dus_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="depusers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
