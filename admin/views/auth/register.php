<?php
/**
 * @var $registerForm \tframe\core\auth\RegisterForm
 * @var $this \tframe\core\View
 */

use tframe\common\components\form\Form;
use tframe\core\Application;

$this->title = Application::t('auth', 'Register') . ' | ' . Application::$GLOBALS['APP_NAME'];
?>

<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <img class="img-fluid d-inline-block text-right" src="/assets/images/tframe-logo.png" alt="Logo" style="width: 2.5rem">
        <span class="h3 mb-0 d-inline-block text-lefts align-middle"><?= Application::$GLOBALS['APP_NAME'] ?></span>
    </div>
    <div class="card-body register-card-body">
        <p class="login-box-msg"><?= Application::t('auth','Register a new membership') ?></p>

        <?php $form = Form::begin('post') ?>

        <?= $form->fieldWithIcon($registerForm, 'firstName', 'fa-solid fa-user')->required() ?>
        <?= $form->fieldWithIcon($registerForm, 'lastName', 'fa-solid fa-user')->required() ?>

        <?= $form->fieldWithIcon($registerForm, 'email', 'fa-solid fa-envelope')->required() ?>
        <?= $form->fieldWithIcon($registerForm, 'password', 'fa-solid fa-lock')->passwordField()->required() ?>
        <?= $form->fieldWithIcon($registerForm, 'passwordConfirmation', 'fa-solid fa-lock')->passwordField()->required() ?>

        <div class="row">
            <div class="col-8">
                <?= $form->icheckField($registerForm, 'agreeTerms')->required() ?>
            </div>
            <div class="col-4">
                <?= $form->submitButton(Application::t('auth', 'Register'), 'btn-primary d-block w-100'); ?>
            </div>
        </div>

        <?php Form::end() ?>

        <p class="mb-0">
            <a href="/auth/login"><?= Application::t('auth', 'I already have a membership') ?></a>
        </p>
    </div>
</div>
