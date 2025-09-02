<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Vehicle $model */

$this->title = 'Adauga autovehicul';
?>
<div class="vehicle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
