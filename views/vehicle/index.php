<?php
use yii\helpers\Url;
use yii\helpers\Html;

// Register DataTables assets from CDN
$this->registerCssFile('https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css');
$this->registerJsFile('https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
// $this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css');
// $this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCss("
    #vehicleTable tbody td:nth-child(2) {
        cursor: pointer;
    }
");
?>
<div class="site-index">
<h1>Camioane</h1>
<p>
        <?= Html::a('Adauga', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<table id="vehicleTable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>          
            <th>#</th>  
            <th>Nr. Inmatriculare</th> 
            <th>Comanda Transport</th>
            <th>Data Incarcare</th>           
            <th>Data Descarcare</th>
            <th>Adresa Incarcare</th>
            <th>Adresa Descarcare</th>
            <th>Adresa Incarcare</th>
            <th>Adresa Descarcare</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>

<?php


$this->registerJs("
  var table=  $('#vehicleTable').DataTable({        
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '" . Url::to(['vehicle/data']) . "',            
     columns: [  
        {data: 0, visible: false },   //ID      
        {data: null,  // Contor
        defaultContent: '', // Set default content to empty      
      render: function (data, type, row, meta) {
        // 'meta.row' is the zero-based index of the row
        return meta.row + 1;
      }},    
        {data: 1}, // Nr. inmatriculare
        {data: 2}, // comanda transport
        {data: 3}, // Data incarcare
        {data: 4}, //Data descarcare 
        {data: 5}, // Adresa incarcare Exp
        {data: 6}, // Adresa Descarcare Exp
        {data: 7}, // Adresa incarcare Imp
        {data: 8}, // Adresa descarcare Imp
        {data: 9} // actions

  ]  ,
      drawCallback: function(settings) {
        $('#vehicleTable tbody td:nth-child(2)').each(function() { // Name column
            var cell = $(this);
            var rowData = table.row(cell.closest('tr')).data();
            var hoverTimeout;
            cell.attr('data-bs-toggle', 'tooltip')
                .attr('title', ''); // temporary placeholder

            // Remove any existing tooltip
            cell.tooltip('dispose');

            // On mouse enter, fetch tooltip content
         cell.off('mouseenter').on('mouseenter', function() {         
                hoverTimeout = setTimeout(function() {
                    $.ajax({
                        url: 'vehicle/summary',
                        data: { id: rowData[0] },
                        success: function(response) {
                            cell.attr('title', response.content)
                                .tooltip('dispose')
                                .tooltip({ html: true })
                                .tooltip('show');
                        }
                    });
                }, 300); // delay in milliseconds
            });

            // On mouse leave, hide tooltip
            cell.off('mouseleave').on('mouseleave', function() {
                clearTimeout(hoverTimeout);     
                cell.tooltip('hide');
            });
        });
    }      
    });
");
?>
</div>
