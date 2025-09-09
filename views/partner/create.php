<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Partner $model */

$this->title = 'Create Partner';
$this->params['breadcrumbs'][] = ['label' => 'Partners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
