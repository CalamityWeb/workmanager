<?php

namespace tframe\common\components\table;

class DataTable {
    public static function init(string $table, string $AJAXurl = ''): string {
        return <<<JS
            $(function () {
                const table = $("$table").DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "responsive": true,
                    "dom": "QB<\"row justify-content-between mt-3\"<\"col-auto\"l><\"col-auto\"f>>rtip",
                    "buttons": [
                        "copyHtml5", "excelHtml5", "pdfHtml5", "print"
                    ]
                });
            
                setTimeout(table.draw, 1000);
            });
        JS;
    }
}