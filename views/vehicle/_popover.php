<div>
    <strong>Info:</strong><?= $model->info ?><br>
     <?= isset($model->end_date) ? '<b>Data Descarcare</b>: '.Yii::$app->formatter->asDate($model->end_date,'dd.MM.yyyy')
     .(isset($model->exp_adr_end) && !empty($model->exp_adr_end) ? '<br><b>Adresa Export</b>: '.$model->exp_adr_end :'')
     .'' .(isset($model->imp_adr_end) && !empty($model->imp_adr_end) ? '<br><b>Adresa Import</b>: '.$model->imp_adr_end :''):'' ?>
     
         
</div>
