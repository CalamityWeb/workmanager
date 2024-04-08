<?php
/**
 * @var $this            \tframe\core\View
 * @var $role            \tframe\core\auth\Roles
 * @var $users           array
 * @var $authAssignments array
 * @var $adminAuthItems  array
 * @var $publicAuthItems array
 * @var $apiAuthItems    array
 */

use tframe\common\components\form\Form;
use tframe\common\components\text\Text;
use tframe\core\Application;

$this->title = Application::t('general', 'Create Role');
?>

<div class="row">
    <div class="col-12 col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Application::t('general', 'Create Role') ?></h3>
            </div>
            <div class="card-body">
                <?php $form = Form::begin('post') ?>

                <?= $form->field($role, 'roleName')->required(); ?>
                <?= $form->textareaField($role, 'roleIcon') ?>
                <?= $form->textareaField($role, 'description'); ?>

                <?= $form->submitButton(Application::t('general', 'Save'), 'btn-success', 'fa-floppy-disk') ?>


                <p class="fs-7 mb-0 mt-3 fst-italic text-end">
                    <?= Application::t('general', 'Created') ?>: <?= $role->created_at ?>
                </p>
                <p class="fs-7 mb-0 fst-italic text-end">
                    <?= Application::t('general', 'Edited') ?>: <?= ($role->updated_at != null) ? $role->updated_at : Text::notSetText() ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Application::t('general', 'Users with this role') ?></h3>
            </div>
            <div class="card-body">
                <?php if (count($users) > 0): ?>
                    <?= implode(' | ', array_map(static function($item) { return '<a href="/users/manage/' . $item->id . '">' . $item->getFullName() . '</a>'; }, $users)) ?>
                <?php else: ?>
                    <p class="mb-0"><?= Application::t('general', 'No user has this role.') ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Application::t('general', 'Public routes') ?></h3>
            </div>
            <div class="card-body">
                <?php /* @var $authItem \tframe\core\auth\AuthItem */ ?>
                <?php foreach ($publicAuthItems as $authItem): ?>
                    <?php
                    $checked = false;
                    /* @var $assignment \tframe\core\auth\AuthAssignments */
                    foreach ($authAssignments as $assignment) {
                        if ($authItem->id == $assignment->item) {
                            $checked = true;
                        }
                    }
                    ?>
                    <div class="icheck-primary">
                        <input type="checkbox" id="<?= $authItem->id ?>" name="routes[]"
                               value="<?= $authItem->id ?>" <?= ($checked) ? 'checked' : '' ?>>
                        <label for="<?= $authItem->id ?>"><?= $authItem->item ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Application::t('general', 'Admin Routes') ?></h3>
            </div>
            <div class="card-body">
                <?php /* @var $authItem \tframe\core\auth\AuthItem */ ?>
                <?php foreach ($adminAuthItems as $authItem): ?>
                    <?php
                    $checked = false;
                    /* @var $assignment \tframe\core\auth\AuthAssignments */
                    foreach ($authAssignments as $assignment) {
                        if ($authItem->id == $assignment->item) {
                            $checked = true;
                        }
                    }
                    ?>
                    <div class="icheck-primary">
                        <input type="checkbox" id="<?= $authItem->id ?>" name="routes[]"
                               value="<?= $authItem->id ?>" <?= ($checked) ? 'checked' : '' ?>>
                        <label for="<?= $authItem->id ?>"><?= $authItem->item ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
