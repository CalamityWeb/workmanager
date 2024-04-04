<?php

namespace tframe\common\components\table;

use tframe\core\Application;
use tframe\core\exception\InvalidConfigException;

class DataTable {
    public static string $identification = "#dataTable";
    public static string $js = '';

    public static function init (array $config): string {
        if (!isset($config['data'], $config['columns'])) {
            throw new InvalidConfigException("DataTables configuration is invalid. 'Data' or 'Columns' options are missing!");
        }

        self::configure($config);
        return self::render($config);
    }

    private static function configure (array $config) {
        $data = $config['data'];
        $columns = $config['columns'];

        $id = self::$identification;
        self::$js .= <<<JS
			$("$id").DataTable({
				paging: true,
				searching: true,
				ordering: true,
				info: true,
				responsive: true,
				dom: "QB<\"row justify-content-between mt-3 mb-3\"<\"col-auto\"l><\"col-auto\"f>>rtip",
				buttons: [ "copyHtml5", "excelHtml5", "pdfHtml5", "print", ],
				processing: true,
				data: $data,
				columns: $columns,
			});
		JS;
    }

    private static function render (array $config): string {
        if (isset($config['identification'])) {
            self::$identification = $config['identification'];
        }
        if (isset($config['class'])) {
            $class = $config['class'];
        } else {
            $class = 'table table-bordered table-hover table-striped dataTable dtr-inline';
        }
        if (str_contains(self::$identification, '#')) {
            $id = str_replace('#', '', self::$identification);
        } else if (str_contains(self::$identification, '.')) {
            $class .= ' ' . str_replace('.', '', self::$identification);
            $id = '';
        }

        Application::$app->view->registerJS(self::$js);

        return '
        <table class="' . $class . '" id="' . $id . '">
        </table>
        ';
    }
}