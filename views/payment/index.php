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
         <button id="refreshAll" class="btn btn-primary">
    <i class="fa fa-sync"></i> Reîncarcă
  </button>
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
              <th>Data Factura</th>
              <th>Data Scadenta</th>
              <th>Nr CMD TRS</th>
              <th>Numar Factura</th>
              <th>FURNIZOR</th>
              <th>Valoare RON</th>
              <th>Suma Achitata RON</th>
              <th>Sold RON</th>
              <th>Valoare EUR</th>
              <th>Suma Achitata EUR</th>
              <th>Sold EUR</th>
              <th>Data Achitarii</th>
              <th>Banca</th>
              <th>Mentiuni</th>
              <th>Actiuni</th>
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
    const tables= {};
    function initTable (days) {
    return $('#dt' + days + 'Table').DataTable({
      processing: true,
      serverSide: true,
      ajax: baseUrl + '/payment/data?days=' + days,
      ordering: true,
      columns: [
        { data : 'id' , visible:false},
        { data : 'dateinvoiced' },
        { data : 'duedate' },        
        { data : 'nr_cmd_trs'},
        { data : 'nr_factura'},
        { data : 'partener'},
        { data : 'valoare_ron',orderable: false},
        { data : 'suma_achitata_ron',orderable: false},
        { data : 'sold_ron' ,orderable: false},
        { data : 'valoare_eur',orderable: false},
        { data : 'suma_achitata_eur' ,orderable: false},
        { data : 'sold_eur',orderable: false},
        { data : 'paymentdate',orderable: false},
        { data : 'bank',orderable: false},
        { data : 'mentiuni',orderable: false},
        {data: null, orderable: false,
           render: function(data, type, row) {  
            const baseUrl = $('#baseUrl').val();  
            const editUrl = baseUrl + '/payment/update?id=' + row.id;
            const deleteUrl = baseUrl + '/payment/delete?id=' + row.id;                 
          return '<div class="btn-group" role="group">'
                +'<a href="'+editUrl+'" class="btn btn-sm btn-warning"><i class="fa fa-pencil" title="Editeaza"></i></a>'
                +'<button class="btn btn-sm btn-primary duplicate-btn" data-id="'+row.id+'" title="Duplicheaza"><i class="fa fa-copy"></i></button>'
                +'<button class="btn btn-sm btn-danger delete-btn" data-id="'+row.id+'" title="Sterge"><i class="fa fa-trash"></i></button>'
                +'</div>';
              }}
      ],
      createdRow: function(row, data, dataIndex) {
    // Add data attributes for easy identification
          $(row).attr('data-id', data.id);
          },
      pageLength: 10,
        order: [[2, 'asc']],
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/ro.json'
      }
    });
  };
    tables[15] =  initTable(15) ;    
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
  $('#refreshAll').on('click', function () {
  const btn = $(this);
  btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Reîncarcă...');

  const activeTab = $('#dataTabs .nav-link.active');
  const days = activeTab.data('bs-target').replace('#dt', '');  
  if (tables[days]) {
    tables[days].ajax.reload(() => {
      btn.prop('disabled', false).html('<i class="fa fa-sync"></i> Reîncarcă');
    }, false);
  }
});
}); 
const editableColumns = {
  'dateinvoiced':'date', 
  'duedate':'date',         
  'nr_cmd_trs':'text',
  'nr_factura':'text',
  'partener':'text',
  'valoare_ron':'number',
  'suma_achitata_ron':'number',
  'sold_ron':'number', 
  'valoare_eur':'number',
  'suma_achitata_eur':'number',
  'sold_eur':'number',
  'paymentdate':'date', 
  'bank':'text',
  'mentiuni':'text'
};
// Editare inline
$(document).on('dblclick', '#dataTabsContent td', function () {
  const baseUrl = '$baseUrl';  
  const cell = $(this);
  const table = cell.closest('table').DataTable();
  const cellIndex = table.cell(this).index();
  const rowData = table.row(this).data();
  const colName = table.settings().init().columns[cellIndex.column].data;

  // Skip non-editable columns
  const nonEditable = ['id', null,'dateinvoiced','duedate']; // adjust as needed
  if (nonEditable.includes(colName)) return;
  const type = editableColumns[colName];
  // Get current value
  const oldValue = cell.text().trim();

  // Create input field
  let input;
  if(type==='text'){
     input = $('<input type="text" class="form-control form-control-sm">').val(oldValue);
  }else if (type === 'date') {
    input = $('<input type="date" class="form-control form-control-sm">').val(oldValue);
  } else if(type==='number')
  {
    input = $('<input type="number" class="form-control form-control-sm">').val(oldValue);
  }  

  cell.html(input);
  input.focus();

  // When losing focus or pressing Enter, save
  input.on('blur keypress', function (e) {
    if (e.type === 'blur' || e.which === 13) {
      const newValue = input.val();
      if (newValue === oldValue) {
        cell.text(oldValue);
        return;
      }

      // AJAX save
      $.ajax({
        url: baseUrl + '/payment/update-inline',
        type: 'POST',
        data: {
          id: rowData.id,
          field: colName,
          value: newValue,
          _csrf: yii.getCsrfToken()
        },
        success: function (res) {
          if (res.success) {
            cell.text(newValue);
             cell.css('background-color', '#d4edda');
            setTimeout(() => cell.css('background-color', ''), 600);
          } else {
            alert('Eroare: ' + res.message);
            cell.text(oldValue);
          }
        },
        error: function () {
          alert('Eroare la actualizare.');
          cell.text(oldValue);
        }
      });
    }
  });
});

$(document).on('click','.duplicate-btn', function(){
  const id = $(this).data('id');
  const baseUrl = $('#baseUrl').val();    
  if (!confirm('Sigur doriți să duplicați această plată?')) return;
  $.ajax({
    url: baseUrl + '/payment/duplicate',
    type: 'POST',
    data: { id: id, _csrf: yii.getCsrfToken() },
    success: function(response) {
      if (response.success) {
        alert('Plata a fost duplicată cu succes.');
        $.fn.dataTable.tables({visible: true, api: true}).ajax.reload(null, false);
      } else {
        alert('Eroare: ' + response.message);
      }
    },
    error: function() {
      alert('A apărut o eroare la duplicare.');
    }
  });
});
$(document).on('click', '.delete-btn', function() {
  const id = $(this).data('id');
  const baseUrl = $('#baseUrl').val();

  if (!confirm('Sigur doriți să ștergeți această plată? Aceasta acțiune este ireversibilă.')) return;

  $.ajax({
    url: baseUrl + '/payment/delete',
    type: 'POST',
    data: { id: id, _csrf: yii.getCsrfToken() },
    success: function(response) {
      if (response.success) {
        alert('Plata a fost ștearsă cu succes.');
        $.fn.dataTable.tables({visible: true, api: true}).ajax.reload(null, false);
      } else {
        alert('Eroare: ' + response.message);
      }
    },
    error: function() {
      alert('A apărut o eroare la ștergere.');
    }
  });
});
JS);?>