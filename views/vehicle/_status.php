<?php

/** @var yii\web\View $this */
/** @var app\models\Vehicle $model */
use yii\jui\DatePicker;
?>
<h5>Actualizare stare: <?=$model->regno?></h5>
<form id="statusForm">
    <input type="hidden" id="id" name="id" value="<?=$model->id?>">
<div>
    <div class="mb-3">
        <label class="form-label">Stare</label>       
    </div>
    <div class="mb-3">
        <select name="estatus" id="estatus" class="form-control">
            <?php foreach($model->getStatusList() as $k=>$v): ?>
                <option value="<?= $k?>" <?= $k==$model->status ?'selected="selected"':''  ?>><?=$v?></option>                
                <?php endforeach;?>
        </select>
    </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Inchide</button>
          <button type="submit" class="btn btn-primary">Salveaza</button>
        </div>
</div>
</form>