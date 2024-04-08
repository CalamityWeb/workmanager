<?php
/**
 * @var $this  \tframe\core\View
 * @var $items array
 */

use tframe\common\components\button\Button;
use tframe\common\components\table\DataTable;
use tframe\common\components\table\GenerateTableData;
use tframe\common\components\text\Text;
use tframe\common\models\Users;
use tframe\core\Application;
use tframe\core\auth\AuthItem;

/** @var \tframe\common\models\Users $sessionUser */
$sessionUser = Users::findOne([Users::primaryKey() => Application::$app->session->get('sessionUser')]);

$this->title = Application::t('general', 'Route Items');

$columns = GenerateTableData::generateColumns(AuthItem::class,
    [
        'columns' =>
            [
                'ID' => ['place' => 1, 'data' => '"id"'],
                'description' => ['data' => 'function (data) { return (!data.description ) ? \'' . Text::notSetText() . '\' : data.description}'],
                'Modify' => ['place' => 'latest', 'data' => 'function (data) { return getButtons(data)}'],
            ],
    ],
);

?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?= Button::generateClickButton('/routes-management/items/create', 'btn-primary', Application::t('general', 'New Route Item'), 'fa-plus') ?>
                </div>
                <div class="card-body">
                    <?= DataTable::init(['data' => $items, 'columns' => $columns]) ?>
                </div>
            </div>
        </div>
    </div>

<?php
$canManage = Users::canRoute($sessionUser, '@admin/routes-management/items/manage/0') ? 'true' : 'false';
$canDelete = Users::canRoute($sessionUser, '@admin/routes-management/items/delete/0') ? 'true' : 'false';
$edit = Application::t('general', 'Edit');
$delete = Application::t('general', 'Delete');

$this->registerJS(<<<JS
function getButtons(data) {
    let manage = '';
    let del = '';
    if(!$canManage) {
        manage = 'disabled';
    }
    if(!$canDelete) {
        del = 'disabled';
    }
    let buttons = '<div class="btn-group btn-group-sm" role="group">' +
                    '<a class="btn btn-primary '+manage+'" data-bs-toggle="tooltip" data-bs-title="$edit"'+
                        'href="/routes-management/items/manage/'+data.id+'">' +
                            '<i class="fa-solid fa-gear"></i>' +
                    '</a>' +
                    '<a class="btn btn-danger '+del+'" data-bs-toggle="tooltip" data-bs-title="$delete"'+
                        'href="/routes-management/items/delete/'+data.id+'">' +
                            '<i class="fa-solid fa-trash"></i>' +
                    '</a>' +
                   '</div>';
    return buttons;
}
JS,
);

?>