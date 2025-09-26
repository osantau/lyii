<?php
$popoverContent = '<div class="text-light text-start">';

$popoverContent .= '<div><strong>Nr. Comanda:</strong> ' . $model->documentno . '</div>';
$popoverContent .= '<div><strong>Data: </strong> ' . Yii::$app->formatter->asDate($model->dateordered, 'dd.MM.yyyy') . '</div>';
$popoverContent .= '<div><strong>Client:</strong> ' .$model->partner->name . '</div>';

$popoverContent .= '</div>';
echo $popoverContent;
?>