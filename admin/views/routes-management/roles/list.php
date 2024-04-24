<?php
/**
 * @var $this  \calamity\common\models\core\View
 * @var $roles array
 */

use calamity\common\components\button\Button;
use calamity\common\components\table\DataTable;
use calamity\common\components\table\GenerateTableData;
use calamity\common\components\text\Text;
use calamity\common\models\core\Calamity;
use calamity\common\models\Roles;
use calamity\common\models\Users;

/** @var \calamity\common\models\Users $sessionUser */
$sessionUser = Users::findOne([Users::primaryKey() => Calamity::$app->session->get('sessionUser')]);

$this->title = Calamity::t('general', 'Roles');

$columns = GenerateTableData::generateColumns(Roles::class,
    [
        'columns' =>
            [
                'ID' => ['place' => 1, 'data' => '"id"'],
                'roleIcon' => ['data' => 'function (data) { return (!data.roleIcon ) ? \'' . Text::notSetText() . '\' : data.roleIcon}'],
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
                    <?= Button::generateClickButton('/routes-management/roles/create', 'btn-primary', Calamity::t('general', 'New Role'), 'fa-plus') ?>
                </div>
                <div class="card-body">
                    <?= DataTable::init(['data' => $roles, 'columns' => $columns]) ?>
                </div>
            </div>
        </div>
    </div>

<?php
$canManage = Users::canRoute($sessionUser, '@admin/routes-management/roles/manage/0') ? 'true' : 'false';
$canDelete = Users::canRoute($sessionUser, '@admin/routes-management/roles/delete/0') ? 'true' : 'false';
$edit = Calamity::t('general', 'Edit');
$delete = Calamity::t('general', 'Delete');

$this->registerJS(<<<JS
function getButtons(data) {
    let manage = '';
    let del = '';
    if(!$canManage) {
        manage = 'disabled';
    }
    if(!$canDelete || data.id === 1) {
        del = 'disabled';
    }
    let buttons = '<div class="btn-group btn-group-sm" role="group">' +
                    '<a class="btn btn-primary '+manage+'" data-bs-toggle="tooltip" data-bs-title="$edit"'+
                        'href="/routes-management/roles/manage/'+data.id+'">' +
                            '<i class="fa-solid fa-gear"></i>' +
                    '</a>' +
                    '<a class="btn btn-danger '+del+'" data-bs-toggle="tooltip" data-bs-title="$delete"'+
                        'href="/routes-management/roles/delete/'+data.id+'">' +
                            '<i class="fa-solid fa-trash"></i>' +
                    '</a>' +
                   '</div>';
    return buttons;
}
JS,
);

?>