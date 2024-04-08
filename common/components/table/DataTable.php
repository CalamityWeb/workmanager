<?php

namespace tframe\common\components\table;

use tframe\core\Application;
use tframe\core\exception\InvalidConfigException;

class DataTable {
    public static string $identification = "#dataTable";
    public static string $js = '';

    public static function init(array $config): string {
        if (!isset($config['data'], $config['columns'])) {
            throw new InvalidConfigException(Application::t('table', "DataTables configuration is invalid. 'Data' or 'Columns' options are missing!"));
        }

        self::configure($config);
        return self::render($config);
    }

    private static function configure(array $config): void {
        $data = $config['data'];
        $columns = $config['columns'];

        $order = "[";
        if (isset($config['order'])) {
            foreach ($config['order'] as $key => $value) {
                $order .= "[$key, '$value']";
            }
        }
        $order .= "]";

        $columndefs = "[";
        if (isset($config['$columndefs'])) {
            $order .= "{";
            foreach ($config['$columndefs'] as $key => $value) {
                $order .= "targets: $key";
                $order .= "render: $value";
            }
            $order .= "},";
        }
        $columndefs .= "]";

        if (Application::$app->language !== 'en_EN') {
            $language = substr(Application::$app->language, 0, 2);
        } else {
            $language = 'en-GB';
        }

        $id = self::$identification;
        self::$js .= <<<JS
			new DataTable('$id', {
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
				order: $order,
				drawCallback: function () { 
				    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]'); 
				    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
				},
				columnDefs: $columndefs,
				language: {
				    url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/$language.json',
				},
			});
		JS;
    }

    private static function render(array $config): string {
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