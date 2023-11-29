<?php
/**
 * @var $this \tframe\core\View
 * @var $groupItem \tframe\core\auth\AuthGroup
 */

use tframe\common\components\form\Form;
use tframe\common\components\text\Text;
use tframe\core\Application;

$this->title = 'Manage Authentication Group';
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
                <?= $form->textareaField($groupItem, 'description'); ?>

                <?= $form->submitButton(Application::t('general', 'Save'), 'btn-success', 'fa-floppy-disk') ?>

                <?php Form::end() ?>
                <p class="fs-7 mb-0 mt-3 fst-italic text-end">
                    <?= Application::t('general', 'Created') ?>: <?= $groupItem->created_at ?>
                </p>
                <p class="fs-7 mb-0 fst-italic text-end">
                    <?= Application::t('general', 'Edited') ?>: <?= ($groupItem->updated_at != null) ? $groupItem->updated_at  : Text::notSetText() ?>
                </p>
            </div>
        </div>
    </div>
</div>