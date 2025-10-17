<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile('https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css');
$this->registerJsFile('https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->title = 'Plati Parteneri';
$baseUrl = Url::base(true);
?>
<div class="payment-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Adauga Plata', ['create'], ['class' => 'btn btn-success']) ?>
        <button id="refreshAll" class="btn btn-primary">
            <i class="fa fa-sync"></i> Reîncarcă
        </button>
    </p>
    
    <?php echo Html::input('hidden','baseUrl',Url::base(true),['id'=>'baseUrl']);?>

    <table id="paymentTable" class="display" style="width:100%">
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
              <th>Cont RON</th>
              <th>Cont EUR</th>
              <th>Data Achitarii</th>
              <th>Banca</th>
              <th>Mentiuni</th>            
              <th>Actiuni</th>
            </tr>
        </thead>
    </table>
</div>
<?php
$this->registerJs(<<<JS
$(document).ready(function() {
    const baseUrl = '$baseUrl';
    
    const table = $('#paymentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: baseUrl + '/payment/data', // server-side URL
        ordering: true,
        autoWidth: false,
        responsive: true,        
        columns: [
            { data : 'id', visible:false },
            { data : 'dateinvoiced' },
            { data : 'duedate' },
            { data : 'nr_cmd_trs' },
            { data : 'nr_factura' },
            { data : 'partener' },
            { data : 'valoare_ron' },
            { data : 'suma_achitata_ron' },
            { data : 'sold_ron' },
            { data : 'valoare_eur' },
            { data : 'suma_achitata_eur' },
            { data : 'sold_eur' },
            { data : 'ron', orderable:false },
            { data : 'eur', orderable:false },
            { data : 'paymentdate', orderable:false },
            { data : 'bank', orderable:false },
            { data : 'mentiuni', orderable:false },
            { data: null, orderable:false,
                render: function(data, type, row) {
                    const editUrl = baseUrl + '/payment/update?id=' + row.id;
                    return '<div class="btn-group" role="group">'
                        +'<a href="'+editUrl+'" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>'
                        +'<button class="btn btn-sm btn-primary duplicate-btn" data-id="'+row.id+'"><i class="fa fa-copy"></i></button>'
                        +'<button class="btn btn-sm btn-danger delete-btn" data-id="'+row.id+'"><i class="fa fa-trash"></i></button>'
                        +'</div>';
                }
            }
        ],
        pageLength: 25,
        order: [[1, 'desc']],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/ro.json'
        }
    });

    const editableColumns = {
  /*'dateinvoiced':'date', 
  'duedate':'date',   */      
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
  'mentiuni':'text',
  'credit_note':'text',
  'diferenta':'number'
};

// Editare inline
$(document).on('dblclick', '#paymentTable td', function () {
  const baseUrl = '$baseUrl';  
  const cell = $(this);
  const table = cell.closest('table').DataTable();
  const cellIndex = table.cell(this).index();
  const rowData = table.row(this).data();
  const colName = table.settings().init().columns[cellIndex.column].data;

  // Skip non-editable columns
  const nonEditable = ['id', null]; // adjust as needed
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
    input = $('<input type="number" class="form-control form-control-sm" min="0">').val(oldValue);
  }  

  cell.html(input);
  input.focus();

  // When losing focus or pressing Enter, save
  input.on('blur keypress', function (e) {
    console.log(e.key);
if (e.type === 'keydown' && e.key === 'Escape') {
        cell.text(oldValue);
        return;
    }

    if (e.type === 'blur' || e.key ==='Enter' ) {
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
               if (colName === 'suma_achitata_ron' || colName === 'suma_achitata_eur' ||colName === 'valoare_ron' || colName === 'valoare_eur' ||  colName==='paymentdate' || colName==='dateinvoiced' || colName==='duedate' ) {
            // Refresh the entire row from the server
            table.ajax.reload(null, false); 
    }
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
  }).on('keydown', function(e){
    if(e.key === 'Escape'){
        cell.text(oldValue);
    }
});
});

    // Refresh button
    $(document).on('click', '#refreshAll',function () {
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Reîncarcă...');
        table.ajax.reload(() => {
            btn.prop('disabled', false).html('<i class="fa fa-sync"></i> Reîncarcă');
        }, false);
        table.columns.adjust().responsive.recalc();
    });

    // Duplicate button
    $(document).on('click','.duplicate-btn', function(){
        const id = $(this).data('id');
        if (!confirm('Sigur doriți să duplicați această plată?')) return;
        $.post(baseUrl + '/payment/duplicate', { id: id, _csrf: yii.getCsrfToken() }, function(res){
            if(res.success){
                alert('Plata a fost duplicată cu succes.');
                table.ajax.reload(null, false);
            } else {
                alert('Eroare: ' + res.message);
            }
        });
    });

    // Delete button
    $(document).on('click','.delete-btn', function(){
        const id = $(this).data('id');
        if (!confirm('Sigur doriți să ștergeți această plată?')) return;
        $.post(baseUrl + '/payment/delete', { id: id, _csrf: yii.getCsrfToken() }, function(res){
            if(res.success){
                alert('Plata a fost ștearsă cu succes.');
                table.ajax.reload(null, false);
            } else {
                alert('Eroare: ' + res.message);
            }
        });
    });

    // Inline editing logic can stay as-is
});
JS
);
?>
