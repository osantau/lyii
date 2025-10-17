<?php

use app\models\Invoice;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\InvoiceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Facturi ' . strtoupper($moneda);
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css');
$this->registerJsFile('https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->title = 'Facturi ' . strtoupper($moneda);
$baseUrl = Url::base(true);
?>
<div class="invoice-index">
   <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Adauga Factura', ['create?moneda=' . $moneda], ['class' => 'btn btn-success']) ?>
        <button id="refreshAll" class="btn btn-primary">
            <i class="fa fa-sync"></i> Reîncarcă
        </button>
    </p>

    <?= Html::hiddenInput('baseUrl', Url::base(true), ['id' => 'baseUrl']) ?>
    <?= Html::hiddenInput('moneda', $moneda, ['id' => 'moneda']) ?>

    <table id="invoiceTable" class="display" style="width:100%">
        <?php if ($moneda === 'ron') { ?>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data Factura</th>
                    <th>Data Scadenta</th>
                    <th>Numar Factura</th>
                    <th>Partener</th>
                    <th>Valoare</th>
                    <th>Suma Achitata</th>
                    <th>Sold</th>
                    <th>Data Incasare</th>
                    <th>Mentiuni</th>
                    <th>Actiuni</th>
                </tr>
            </thead>
        <?php } else if ($moneda === 'eur') { ?>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data Factura</th>
                    <th>Data Scadenta</th>
                    <th>Numar Factura</th>
                    <th>Partener</th>
                    <th>Valoare EUR</th>
                    <th>Suma Achitata EUR</th>
                    <th>Sold EUR</th>
                    <th>Valoare RON</th>
                    <th>Suma Achitata RON</th>
                    <th>Sold RON</th>
                    <th>Data Incasare</th>
                    <th>Diferenta</th>
                    <th>Credit Note</th>
                    <th>Actiuni</th>
                </tr>
            </thead>
        <?php } ?>
    </table>
</div>
<?php
$this->registerJs(<<<JS
$(document).ready(function() {
    const moneda = $('#moneda').val();  
    const baseUrl = $('#baseUrl').val();

    let columns = [
        { data: 'id', visible: false },
        { data: 'dateinvoiced' },
        { data: 'duedate' },
        { data: 'nr_factura' },
        { data: 'partener' }
    ];

    if (moneda === 'eur') {
        columns.push(
            { data: 'valoare_eur' },
            { data: 'suma_achitata_eur' },
            { data: 'sold_eur' },
            { data: 'valoare_ron' },
            { data: 'suma_achitata_ron' },
            { data: 'sold_ron' }
        );
    } else {
        columns.push(
            { data: 'valoare_ron' },
            { data: 'suma_achitata_ron' },
            { data: 'sold_ron' }
        );
    }

    columns.push({ data: 'paymentdate' });

    if (moneda === 'eur') {
        columns.push({ data: 'diferenta', orderable: false });
        columns.push({ data: 'credit_note', orderable: false });
    }

    if (moneda === 'ron') {
        columns.push({ data: 'mentiuni', orderable: false });
    }

    columns.push({
        data: null,
        orderable: false,
        render: function(data, type, row) {
            const editUrl = baseUrl + '/invoice/update?id=' + row.id;
            return( 
               ' <div class="btn-group" role="group"> '
                 + '<a href="'+editUrl+'" class="btn btn-sm btn-warning"><i class="fa fa-pencil" title="Editeaza"></i></a></div>'
                 + '<button class="btn btn-sm btn-primary duplicate-btn" data-id="'+row.id+'" title="Duplicheaza"><i class="fa fa-copy"></i></button> '
                 + '<button class="btn btn-sm btn-danger delete-btn" data-id="'+row.id+'" title="Sterge"><i class="fa fa-trash"></i></button></div>');
        }
    }); 

    const table = $('#invoiceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: baseUrl + '/invoice/data?moneda=' + moneda,
        ordering: true,
        autoWidth: true,
        responsive: true,
        scrollX: true,
        columns: columns,
        pageLength: 25,
        order: [[1, 'desc']],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/ro.json'
        }
    });

    // Refresh button
    $('#refreshAll').on('click', function() {
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Reîncarcă...');
        table.ajax.reload(() => {
            btn.prop('disabled', false).html('<i class="fa fa-sync"></i> Reîncarcă');
        }, false);
    });

    // Inline editing (same as before)
    const editableColumns = {
        'dateinvoiced': 'date',
        'duedate': 'date',
        'nr_factura': 'text',
        'valoare_ron': 'number',
        'suma_achitata_ron': 'number',
        'sold_ron': 'number',
        'valoare_eur': 'number',
        'suma_achitata_eur': 'number',
        'sold_eur': 'number',
        'paymentdate': 'date',
        'mentiuni': 'text'
    };

    $(document).on('dblclick', '#invoiceTable td', function() {
        const cell = $(this);
        const cellIndex = table.cell(this).index();
        const rowData = table.row(this).data();
        const colName = table.settings().init().columns[cellIndex.column].data;
        if (!editableColumns[colName]) return;
        const type = editableColumns[colName];
        const oldValue = cell.text().trim();
        let input = $('<input type="' + (type === 'text' ? 'text' : type) + '" class="form-control form-control-sm">').val(oldValue);
        cell.html(input);
        input.focus();

        input.on('blur keydown', function(e) {
            if (e.key === 'Escape') {
                cell.text(oldValue);
                return;
            }
            if (e.type === 'blur' || e.key === 'Enter') {
                const newValue = input.val();
                if (newValue === oldValue) {
                    cell.text(oldValue);
                    return;
                }
                $.ajax({
                    url: baseUrl + '/invoice/update-inline',
                    type: 'POST',
                    data: {
                        id: rowData.id,
                        field: colName,
                        value: newValue,
                        _csrf: yii.getCsrfToken()
                    },
                    success: function(res) {
                        if (res.success) {
                            cell.text(newValue).css('background-color', '#d4edda');
                            setTimeout(() => cell.css('background-color', ''), 600);
                            table.ajax.reload(null, false);
                        } else {
                            alert('Eroare: ' + res.message);
                            cell.text(oldValue);
                        }
                    },
                    error: function() {
                        alert('Eroare la actualizare.');
                        cell.text(oldValue);
                    }
                });
            }
        });
    });

    // Duplicate button
    $(document).on('click', '.duplicate-btn', function() {
        const id = $(this).data('id');
        if (!confirm('Sigur doriți să duplicați această factură?')) return;
        $.ajax({
            url: baseUrl + '/invoice/duplicate',
            type: 'POST',
            data: { id: id, _csrf: yii.getCsrfToken() },
            success: function(response) {
                if (response.success) {
                    alert('Factura a fost duplicată cu succes.');
                    table.ajax.reload(null, false);
                } else {
                    alert('Eroare: ' + response.message);
                }
            },
            error: function() {
                alert('A apărut o eroare la duplicare.');
            }
        });
    });

    // Delete button
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        if (!confirm('Sigur doriți să ștergeți această factură? Aceasta acțiune este ireversibilă.')) return;
        $.ajax({
            url: baseUrl + '/invoice/delete',
            type: 'POST',
            data: { id: id, _csrf: yii.getCsrfToken() },
            success: function(response) {
                if (response.success) {
                    alert('Factura a fost ștearsă cu succes.');
                    table.ajax.reload(null, false);
                } else {
                    alert('Eroare: ' + response.message);
                }
            },
            error: function() {
                alert('A apărut o eroare la ștergere.');
            }
        });
    });
});

JS); ?>