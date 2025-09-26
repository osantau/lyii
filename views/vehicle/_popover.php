<?php
$popoverContent = '<div class="text-light text-start">';

$popoverContent .= '<div><strong>Info:</strong> ' . $model->info . '</div>';

if (isset($model->end_date)) {
    $popoverContent .= '<div><strong>Data Descarcare:</strong> ' 
        . Yii::$app->formatter->asDate($model->end_date, 'dd.MM.yyyy') . '</div>';

/*    if (!empty($model->exp_adr_end)) {
        $popoverContent .= '<div class="list-group-item"><strong>Adresa Export:</strong> ' 
            . $model->exp_adr_end . '</div>';
    }

    if (!empty($model->imp_adr_end)) {
        $popoverContent .= '<div class="list-group-item"><strong>Adresa Import:</strong> ' 
            . $model->imp_adr_end . '</div>';
    } */
}

$popoverContent .= '</div>';
echo $popoverContent;
?>
