<?php
/**
 * @var $resetPasswordForm \tframe\core\auth\ResetPasswordForm
 * @var $this              \tframe\core\View
 */

use tframe\common\components\form\Form;
use tframe\core\Application;

$this->title = Application::t('auth', 'Reset password') . ' | ' . Application::$GLOBALS['APP_NAME'];

?>

<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <img class="img-fluid d-inline-block text-right" src="/assets/images/tframe-logo.png" alt="Logo" style="width: 2.5rem">
        <span class="h3 mb-0 d-inline-block text-lefts align-middle"><?= Application::$GLOBALS['APP_NAME'] ?></span>
    </div>
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?= Application::t('auth', 'Create your new password') ?></p>

        <?php $form = Form::begin('post') ?>

        <?= $form->fieldWithIcon($resetPasswordForm, 'password', 'fa-solid fa-lock')->passwordField()->required() ?>
        <?= $form->fieldWithIcon($resetPasswordForm, 'passwordConfirmation', 'fa-solid fa-lock')->passwordField()->required() ?>

        <?= $form->submitButton(Application::t('auth', 'Change my password!'), 'btn-primary d-block w-100') ?>

        <?php Form::end() ?>
    </div>
</div>