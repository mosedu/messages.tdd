<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Depusers */

$this->title = $model->dus_id;
$this->params['breadcrumbs'][] = ['label' => 'Depusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="depusers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->dus_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->dus_id], [
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
            'dus_id',
            'dus_us_id',
            'dus_dep_id',
        ],
    ]) ?>

</div>
