<?php
/**
 * @var $this      \calamity\common\models\core\View
 * @var $user      \calamity\common\models\Users
 * @var $roles     array
 * @var $userRoles array
 */

use calamity\common\components\form\Form;
use calamity\common\components\text\Text;
use calamity\common\models\core\Calamity;

$this->title = Calamity::t('general', 'Manage User');
?>

<div class="row">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img src="<?= $user->getPicture() ?>" id="profilePicture" alt="Your profile picture"
                         class="profile-user-img img-fluid img-circle">
                </div>
                <h3 class="profile-username text-center"><?= $user->getFullName() ?></h3>
                <p class="text-muted text-center mb-0"><?= $user->getActiveRole()->icon ?> <?= $user->getActiveRole()->name ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Calamity::t('general', 'Profile Data') ?></h3>
            </div>
            <div class="card-body">
                <?php $form = Form::begin('post') ?>
                <?php if ($user->id == Calamity::$app->user->id) $form->disabledFields('email_confirmed'); ?>

                <?= $form->field($user, 'email')->required(); ?>
                <?= $form->field($user, 'firstName')->required(); ?>
                <?= $form->field($user, 'lastName')->required(); ?>
                <?= $form->switchField($user, 'email_confirmed'); ?>

                <?= $form->submitButton(Calamity::t('general', 'Save'), 'btn-success', 'fa-floppy-disk') ?>

                <p class="fs-7 mb-0 mt-3 fst-italic text-end">
                    <?= Calamity::t('general', 'Created') ?>: <?= $user->created_at ?>
                </p>
                <p class="fs-7 mb-0 fst-italic text-end">
                    <?= Calamity::t('general', 'Edited') ?>: <?= ($user->updated_at != null) ? $user->updated_at : Text::notSetText() ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Calamity::t('general', 'Roles') ?></h3>
            </div>
            <div class="card-body">
                <?php /* @var $role \calamity\common\models\Roles */ ?>
                <?php foreach ($roles as $role): ?>
                    <?php
                    $hasRole = false;
                    $disabled = false;
                    /* @var $userRole \calamity\common\models\Roles */
                    foreach ($userRoles as $userRole) {
                        if ($role->id == $userRole->id) {
                            $hasRole = true;
                        }
                        if ($role->id == 1) {
                            $disabled = true;
                        }
                    }
                    ?>
                    <div class="icheck-primary">
                        <input type="checkbox" id="<?= $role->id ?>" name="roles[]"
                               value="<?= $role->id ?>" <?= ($hasRole) ? 'checked' : '' ?> <?= ($disabled) ? 'disabled' : '' ?>>
                        <label for="<?= $role->id ?>"><?= $role->name ?> <?= !empty($role->icon) ? $role->icon : '' ?></label>
                    </div>
                <?php endforeach; ?>
                <?php Form::end() ?>
            </div>
        </div>
    </div>
</div>
