<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
/** @var yii\web\View $this */
/** @var app\models\Vehicle $model */

?>
<form id="editInfoForm"></form>
<input type="hidden" name="id" value="<?= $model->id ?>">
<div class="vehicle-form">
    <h4>Vehicul: <?= $model->regno ?></h4>
    <div class="mb-3">
        <label class="form-label">Info</label>
        <input type="text" class="form-control" name="info" value="<?= Html::encode($model->info) ?>">
    </div>
</div>
</form>