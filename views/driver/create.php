<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Driver $model */

$this->title = 'Adauga Conducator Auto';
$this->params['breadcrumbs'][] = ['label' => 'Conducatori Auto', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="col-12">
    <div class="form-group">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
</div>
