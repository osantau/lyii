<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Vehicle $model */
?>
<form id="driverForm">
    <input type="hidden" id="id" name="id" value="<?=$model->id?>">
<div>
    <div class="mb-3">
        <label class="form-label">Sofer</label>       
    </div>
    <div class="mb-3">
          <textarea rows="3" cols="10" maxlength="255" class="form-control" name="driver"><?= Html::encode($model->driver) ?></textarea>
    </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Inchide</button>
          <button type="submit" class="btn btn-primary">Salveaza</button>
        </div>
</div>
</form>