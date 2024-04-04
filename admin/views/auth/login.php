<?php
/**
 * @var $loginForm \tframe\core\auth\LoginForm
 * @var $this      \tframe\core\View
 */

use tframe\common\components\form\Form;
use tframe\core\Application;

$this->title = Application::t('auth', 'Login') . ' | ' . Application::$GLOBALS['APP_NAME'];
?>

<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <img class="img-fluid d-inline-block text-right" src="/assets/images/tframe-logo.png" alt="Logo" style="width: 2.5rem">
        <span class="h3 mb-0 d-inline-block text-lefts align-middle"><?= Application::$GLOBALS['APP_NAME'] ?></span>
    </div>
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?= Application::t('auth', 'Sign in to start your session') ?></p>

        <?php $form = Form::begin('post') ?>

        <?= $form->fieldWithIcon($loginForm, 'email', 'fa-solid fa-envelope')->required(); ?>
        <?= $form->fieldWithIcon($loginForm, 'password', 'fa-solid fa-lock')->passwordField()->required(); ?>

        <div class="row">
            <div class="col-8">
                <?= $form->icheckField($loginForm, 'rememberMe') ?>
            </div>
            <div class="col-4">
                <?= $form->submitButton('Log in', 'btn-primary d-block w-100'); ?>
            </div>
        </div>

        <?php Form::end() ?>

        <p class="mb-1">
            <a href=/auth/forgot-password><?= Application::t('auth', 'I forgot my password') ?></a>
        </p>
        <p class="mb-0">
            <a href="/auth/register"><?= Application::t('auth', 'Register a new membership') ?></a>
        </p>
    </div>
</div>
