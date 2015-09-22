<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Depusers */

$this->title = 'Create Depusers';
$this->params['breadcrumbs'][] = ['label' => 'Depusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="depusers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
