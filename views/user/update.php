<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Actualizare Utilizator - '.$model->username;
$this->params['breadcrumbs'][] = ['label' => 'Utilizatori', 'url' => ['index']];
 $this->params['breadcrumbs'][] = $this->title; 
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
