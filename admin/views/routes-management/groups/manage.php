<?php
/**
 * @var $this \tframe\core\View
 * @var $groupItem \tframe\core\auth\AuthGroup
 * @var $authAssignments array
 * @var $adminAuthItems array
 * @var $publicAuthItems array
 */

use tframe\common\components\form\Form;
use tframe\common\components\text\Text;
use tframe\core\Application;
use tframe\core\auth\AuthItem;

$this->title = 'Manage Authentication Group';
?>

<div class="row">
    <div class="col-12 col-md-4">
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


                <p class="fs-7 mb-0 mt-3 fst-italic text-end">
                    <?= Application::t('general', 'Created') ?>: <?= $groupItem->created_at ?>
                </p>
                <p class="fs-7 mb-0 fst-italic text-end">
                    <?= Application::t('general', 'Edited') ?>: <?= ($groupItem->updated_at != null) ? $groupItem->updated_at : Text::notSetText() ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Public routes</h3>
            </div>
            <div class="card-body">
                <?php /* @var $authItem \tframe\core\auth\AuthItem */ ?>
                <?php foreach ($publicAuthItems as $authItem): ?>
                    <?php
                    $checked = false;
                    /* @var $assignment \tframe\core\auth\AuthAssignments */
                    foreach ($authAssignments as $assignment) {
                        if($authItem->id == $assignment->code) {
                            $checked = true;
                        }
                    }
                    ?>
                    <div class="icheck-primary">
                        <input type="checkbox" id="<?= $authItem->id ?>" name="routes[]" value="<?= $authItem->id ?>" <?= ($checked) ? 'checked' : '' ?>>
                        <label for="<?= $authItem->id ?>"><?= $authItem->item ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Admin Routes</h3>
            </div>
            <div class="card-body">
                <?php /* @var $authItem \tframe\core\auth\AuthItem */ ?>
                <?php foreach ($adminAuthItems as $authItem): ?>
                    <?php
                    $checked = false;
                    /* @var $assignment \tframe\core\auth\AuthAssignments */
                    foreach ($authAssignments as $assignment) {
                        if($authItem->id == $assignment->item) {
                            $checked = true;
                        }
                    }
                    ?>
                    <div class="icheck-primary">
                        <input type="checkbox" id="<?= $authItem->id ?>" name="routes[]" value="<?= $authItem->id ?>" <?= ($checked) ? 'checked' : '' ?>>
                        <label for="<?= $authItem->id ?>"><?= $authItem->item ?></label>
                    </div>
                <?php endforeach; ?>
                <?php Form::end() ?>
            </div>
        </div>
    </div>
</div>
