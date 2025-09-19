<?php

use yii\bootstrap5\Modal;
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
function populateComandaSelect(select, currentComanda){
    $.ajax({
        url: 'transport-order/order-list',
        success: function(options){
            select.empty(); // remove old options
            options.forEach(function(opt){
                var selected = (opt.id === currentComanda) ? 'selected' : '';
                select.append('<option value=\"'+opt.id+'\" '+selected+'>'+opt.text+'</option>');
            });
        }
    });
}

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
            
        cell.off('click').on('click', function() {
        // Load form via Ajax
        $.ajax({
            url: 'vehicle/info',
            data: { id: rowData[0] },
            success: function(html) {
                $('#editInfoModal .modal-body').html(html);                
                var modal = new bootstrap.Modal(document.getElementById('editInfoModal'));
                modal.show();
            }
        });
    });
        });
    // editare info
    $('#editInfoModal').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: 'vehicle/info-ajax',
        method: 'POST',
        data: $('#editInfoForm').serialize(),
        success: function(response) {
            if (response.success) {
                // Close modal
                var modalEl = document.getElementById('editInfoModal');
                var modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
                // Reload DataTable
                table.ajax.reload(null, false);
            } else {
                alert(response.message);
            }
        }
    });
});

    }      
    });
");
?>
</div>
<!-- Edit Info Modal -->
<div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editInfoForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editInfoModalLabel">Editare Info vehicul</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Form fields will be loaded via Ajax -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Inchide</button>
          <button type="submit" class="btn btn-primary">Salveaza</button>
        </div>
      </form>
    </div>
  </div>
</div>
