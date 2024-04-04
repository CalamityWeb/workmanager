<?php
/**
 * @var $this  \tframe\core\View
 * @var $users string
 */

use tframe\common\components\button\Button;
use tframe\common\components\table\DataTable;
use tframe\common\components\text\Text;
use tframe\common\models\Users;
use tframe\core\Application;

/** @var \tframe\common\models\Users $sessionUser */
$sessionUser = Users::findOne([Users::primaryKey() => Application::$app->session->get('sessionUser')]);

$this->title = Application::t('general', 'Users');

$notset = Text::notSetText();
$columns = <<<JS
[
    { title:"ID", data: 'id' },
    { title:"Email", data: 'email' },
    { title:"Name", data: function (data) { return data.firstName + ' ' + data.lastName } },
    { title:"Email confirmed", data:  function (data) { 
        return (data.email_confirmed) ? '<i class="fa-solid fa-circle-check text-success"></i>' : 
        '<i class="fa-solid fa-circle-xmark text-danger"></i>' } 
    },
    { title:"Created at", data:  'created_at' },
    { title:"Updated at", data:  function (data) { return (!data.updated_at) ? '$notset' : data.updated_at } },
    { title:'Modify', data: function (data) { return getButtons(data)} }
]
JS;
?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?= Button::generateClickButton('/users/create', 'btn-primary', Application::t('general', 'New User'), 'fa-user-plus') ?>
                </div>
                <div class="card-body">
                    <?= DataTable::init(['data' => $users, 'columns' => $columns]) ?>
                </div>
            </div>
        </div>
    </div>

<?php

$canManage = Users::canRoute($sessionUser, '@admin/users/manage/0') ? 'true' : 'false';
$canDelete = Users::canRoute($sessionUser, '@admin/users/delete/0') ? 'true' : 'false';
$userId = $sessionUser->id;
$edit = Application::t('general', 'Edit');
$delete = Application::t('general', 'Delete');

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