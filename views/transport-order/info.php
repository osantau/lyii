<?php

use yii\helpers\Html;
use app\models\TransportOrder;

/** @var yii\web\View $this */
/** @var app\models\TransportOrder $model */

?>
<form id="editComandaForm">
<input type="hidden" name="id" value="<?= $c_id ?>">
<input type="hidden" name="v_id" value="<?= $v_id ?>">
<input type="hidden" name="remove_cmd" id="remove_cmd" value="0">
<div class="vehicle-form">
    <div class="mb-3">
        <label class="form-label">Comanda</label>
        
    </div>
    <div class="mb-3">
        <?= Html::textarea('documentno',$documentno,['rows'=>3,'cols'=>40]);?>
    </div>
</div>
</form>
</form>