<?php
/**
 * @var $this \tframe\core\View
 * @var $user \tframe\common\models\User
 */

use tframe\common\components\form\Form;
use tframe\common\components\text\Text;
use tframe\core\Application;

$this->title = 'Manage User';
?>

<div class="row">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img src="<?= $user->getUserPicture() ?>" id="profilePicture" alt="Your profile picture" class="profile-user-img img-fluid img-circle">
                </div>
                <h3 class="profile-username text-center"><?= $user->getFullName() ?></h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Profile Data</h3>
            </div>
            <div class="card-body">
                <?php $form = Form::begin('post') ?>
                <?php //if($user->id == Application::$app->user->id) $form->disabledFields('email_confirmed'); ?>

                <?= $form->field($user, 'email')->required(); ?>
                <?= $form->field($user, 'firstName')->required(); ?>
                <?= $form->field($user, 'lastName')->required(); ?>
                <?= $form->switchField($user, 'email_confirmed'); ?>

                <?= $form->submitButton(Application::t('general', 'Save'), 'btn-success', 'fa-floppy-disk') ?>

                <?php Form::end() ?>
                <p class="fs-7 mb-0 mt-3 fst-italic text-end">
                    <?= Application::t('general', 'Created') ?>: <?= $user->created_at ?>
                </p>
                <p class="fs-7 mb-0 fst-italic text-end">
                    <?= Application::t('general', 'Edited') ?>: <?= ($user->updated_at != null) ? $user->updated_at  : Text::notSetText() ?>
                </p>
            </div>
        </div>
    </div>
</div>
