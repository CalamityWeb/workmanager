<?php
/**
 * @var $this  \tframe\core\View
 * @var $users string
 */

use calamity\common\components\button\Button;
use calamity\common\components\table\DataTable;
use calamity\common\components\table\GenerateTableData;
use calamity\common\components\text\Text;
use calamity\common\models\Users;
use calamity\core\Calamity;

$sessionUser = Calamity::$app->user;

$this->title = Calamity::t('general', 'Users');

$columns = GenerateTableData::generateColumns(Users::class,
    [
        'columns' =>
            [
                'ID' => ['place' => 1, 'data' => '"id"'],
                'name' => ['title' => 'Name', 'place' => 3, 'data' => 'function (data) { return data.firstName + " " + data.lastName }'],
                'email_confirmed' => ['data' => 'function (data) { return (data.email_confirmed) ? \'<i class="fa-solid fa-circle-check text-success"></i>\' : \'<i class="fa-solid fa-circle-xmark text-danger"></i>\' }'],
                'Modify' => ['place' => 'latest', 'data' => 'function (data) { return getButtons(data)}'],
            ],
        'remove' => ['firstName', 'lastName'],
    ],
);
?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?= Button::generateClickButton('/users/create', 'btn-primary', Calamity::t('general', 'New User'), 'fa-user-plus') ?>
                </div>
                <div class="card-body">
                    <?= DataTable::init(['data' => $users, 'columns' => $columns, 'order' => [1 => 'asc'],]) ?>
                </div>
            </div>
        </div>
    </div>

<?php

$canManage = Users::canRoute($sessionUser, '@admin/users/manage/0') ? 'true' : 'false';
$canDelete = Users::canRoute($sessionUser, '@admin/users/delete/0') ? 'true' : 'false';
$userId = $sessionUser->id;
$edit = Calamity::t('general', 'Edit');
$delete = Calamity::t('general', 'Delete');

$this->registerJS(<<<JS
function getButtons(data) {
    let manage = '';
    let del = '';
    if(!$canManage) {
        manage = 'disabled';
    }
    if(!$canDelete || data.id === $userId) {
        del = 'disabled';
    }
    
    return '<div class="btn-group btn-group-sm" role="group">' +
                '<a class="btn btn-primary '+manage+'" data-bs-toggle="tooltip" data-bs-title="$edit" href="/users/manage/'+data.id+'">' +
                        '<i class="fa-solid fa-gear"></i>' +
                    '</a>' +
                '<a class="btn btn-danger '+del+'" data-bs-toggle="tooltip" data-bs-title="$delete" href="/users/delete/'+data.id+'">' +
                        '<i class="fa-solid fa-trash"></i>' +
                '</a>' +
            '</div>';
}
JS,
);

?>