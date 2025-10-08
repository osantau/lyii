<?php

use app\models\Payment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\PaymentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->registerCssFile('https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css');
$this->registerJsFile('https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->title = 'Plati Parteneri';
$baseUrl = Url::base(true);
?>
<div class="payment-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Creeaza Plata', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php echo Html::input('hidden','baseUrl',Url::base(true),['id'=>'baseUrl']);?>
 <ul class="nav nav-tabs" id="dataTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="dt15-tab" data-bs-toggle="tab" data-bs-target="#dt15" type="button" role="tab">15 zile</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="dt30-tab" data-bs-toggle="tab" data-bs-target="#dt30" type="button" role="tab">30 zile</button>
    </li>
     <li class="nav-item" role="presentation">
      <button class="nav-link" id="dt45-tab" data-bs-toggle="tab" data-bs-target="#dt45" type="button" role="tab">45 zile</button>
    </li>
     <li class="nav-item" role="presentation">
      <button class="nav-link" id="dt60-tab" data-bs-toggle="tab" data-bs-target="#dt60" type="button" role="tab">60 zile</button>
    </li>
  </ul>
   <div class="tab-content mt-3" id="dataTabsContent">
     <?php foreach ([15, 30, 45, 60] as $days): ?>
      <div class="tab-pane fade <?= $days === 15 ? 'show active' : '' ?>" id="dt<?= $days ?>">
        <table id="dt<?= $days ?>Table" class="display" style="width:100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Partener</th>
              <th>Suma</th>
              <th>Data Creării</th>
            </tr>
          </thead>
        </table>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php 
$this->registerJs(<<<JS
 $(document).ready(function() {
    const baseUrl = '$baseUrl';
      // Initialize DataTables
    const initTable = (days) => {
    return $('#dt' + days + 'Table').DataTable({
      ajax: baseUrl + '/payment/data?days=' + days,
      columns: [
        { data: 'id' },
        { data: 'partner' },
        { data: 'amount' },
        { data: 'created_at' }
      ],
      pageLength: 10,
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/ro.json'
      }
    });
  };
   let tables = { 15: initTable(15) };    
   // Lazy-load tables when tabs are clicked
  $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    const days = $(e.target).data('bs-target').replace('#dt', '');
    if (!tables[days]) {
      tables[days] = initTable(days);
    } else {
      tables[days].ajax.reload(null, false);
    }

    $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
  });
});


      // Recalculate column widths when switching tabs
      $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
      });
    });
JS);

?>