<?php
/**
 * @var $this \tframe\core\View
 */

use tframe\common\components\button\Button;
use tframe\common\components\text\Text;

$this->title = 'Route Assignments';
?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?= Button::generateClickButton('/routes-management/assignments/create', 'btn-primary', 'New Route Assignment', 'fa-plus') ?>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-striped dataTable dtr-inline" id="dataTable">

                    </table>
                </div>
            </div>
        </div>
    </div>

<?php

$notset = Text::notSetText();

$this->registerJS(<<<JS

function getItem(id, callback) {
    $.get("/api/routes-management/get/item/" + id, function(response) {
        var parsedResponse = JSON.parse(response);
        var itemValue = parsedResponse.item;
        callback(itemValue);
    });
}

$("#dataTable").DataTable({
    "paging": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "responsive": true,
    "dom": "QB<\"row justify-content-between mt-3\"<\"col-auto\"l><\"col-auto\"f>>rtip",
    "buttons": [
        "copyHtml5", "excelHtml5", "pdfHtml5", "print"
    ],
    "processing": true,
    ajax: {
        url: '/api/routes-management/assignments/list',
        dataSrc: "",
    },
    columns: [
        { title:"Group code", data: 'code' },
        { title:"Route (URL)", data: 'item', render: function(data) { return '<div data-item="' + data + '"></div>'; } },
        { title:"Created at", data:  'created_at' },
        { title:"Updated at", data:  function (data) { return (!data.updated_at) ? '$notset' : data.updated_at } },
        { title:'Modify', data: function (data) { return '<a data-bs-toggle="tooltip" data-bs-placement="top"'+
        'data-bs-title="Edit" href="/routes-management/items/manage/'+data.id+'"><i class="fa-solid fa-gear"></i></a>'
         } }
    ],
    columnDefs: [
        {
            targets: 1,
            render: function (data, type, row) {
                if (type === 'display') {
                    return '<div data-item="' + data + '"></div>';
                }
                return data;
            },
            createdCell: function (td, cellData, rowData, row, col) {
                getItem(cellData, function (itemValue) {
                    $(td).html(itemValue);
                });
            }
        }
    ]
});

JS
);

?>