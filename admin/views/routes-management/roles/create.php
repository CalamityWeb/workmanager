<?php
/**
 * @var $this \calamity\common\models\core\View
 * @var $role \calamity\common\models\Roles
 */

use calamity\common\components\form\Form;
use calamity\common\models\core\Calamity;

$this->title = Calamity::t('general', 'Create Role');
?>

<div class="row">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Calamity::t('general', 'Role') ?></h3>
            </div>
            <div class="card-body">
                <?php $form = Form::begin('post') ?>

                <?= $form->field($role, 'roleName')->required() ?>
                <?= $form->textareaField($role, 'roleIcon') ?>
                <?= $form->textareaField($role, 'description') ?>

                <?= $form->submitButton(Calamity::t('general', 'Save'), 'btn-success', 'fa-floppy-disk') ?>

                <?php Form::end() ?>
            </div>
        </div>
    </div>
</div>
