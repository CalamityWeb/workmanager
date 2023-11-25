<?php
/**
 * @var $this \tframe\core\View
 * @var $groupItem \tframe\core\auth\AuthGroup
 */

use tframe\common\components\form\Form;
use tframe\core\Application;

$this->title = 'Create Authentication Group';
?>

<div class="row">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Authentication Group</h3>
            </div>
            <div class="card-body">
                <?php $form = Form::begin('post') ?>

                <?= $form->field($groupItem, 'code')->required(); ?>
                <?= $form->field($groupItem, 'groupName')->required(); ?>
                <?= $form->textareaField($groupItem, 'description') ?>

                <?= $form->submitButton(Application::t('general', 'Save'), 'btn-success', 'fa-floppy-disk') ?>

                <?php Form::end() ?>
            </div>
        </div>
    </div>
</div>
