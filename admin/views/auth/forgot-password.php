<?php
/**
 * @var $forgotPasswordForm \tframe\core\auth\ForgotPasswordForm
 * @var $this \tframe\core\View
 */

use tframe\common\components\form\Form;
use tframe\core\Application;

$this->title = 'Reset password to ' . Application::$GLOBALS['APP_NAME'];

?>

<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <img class="img-fluid d-inline-block text-right" src="/assets/images/tframe-logo.png" alt="Logo" style="width: 2.5rem">
        <span class="h3 mb-0 d-inline-block text-lefts align-middle"><?= Application::$GLOBALS['APP_NAME'] ?></span>
    </div>
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?= Application::t('auth', 'Give us your email to reset your password') ?></p>

        <?php $form = Form::begin('post') ?>

        <?= $form->fieldWithIcon($forgotPasswordForm, 'email', 'fa-solid fa-envelope')->required() ?>
        <?= $form->submitButton(Application::t('auth', 'Send me my new password!'), 'btn-primary d-block w-100') ?>

        <?php Form::end() ?>

        <p class="mb-0">
            <a href="/auth/login"><?= Application::t('auth', 'I log in instead') ?></a>
        </p>
    </div>
</div>
