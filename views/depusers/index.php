<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DepusersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Depusers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="depusers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Depusers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'dus_id',
            'dus_us_id',
            'dus_dep_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
