<?php

/** @var yii\web\View $this */
/** @var app\models\Vehicle $model */
use yii\jui\DatePicker;
?>
<form id="editDatesForm">
<input type="hidden" name="id" value="<?= $model->id ?>">
<input type="hidden" name="tip" value="<?= $tip ?>">
<div>
    <div class="mb-3">
        <label class="form-label">Data <?= $tip=='di'?'Incarcare' :'Descarcare'?></label>       
    </div>
    <div class="mb-3">
        <input type="date" value="<?= $tip=='di'?$model->start_date:$model->end_date?>" id="dataID" name="dataID">
    </div>
</div>
</form>