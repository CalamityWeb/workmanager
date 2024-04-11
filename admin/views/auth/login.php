<?php
/**
 * @var $loginForm \calamity\auth\LoginForm
 * @var $this      \calamity\View
 */

use calamity\common\components\form\Form;
use calamity\Calamity;

$this->title = Calamity::t('auth', 'Login') . ' | ' . Calamity::$GLOBALS['APP_NAME'];
?>

<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <img class="img-fluid d-inline-block text-right" src="/assets/images/tframe-logo.png" alt="Logo" style="width: 2.5rem">
        <span class="h3 mb-0 d-inline-block text-lefts align-middle"><?= Calamity::$GLOBALS['APP_NAME'] ?></span>
    </div>
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?= Calamity::t('auth', 'Sign in to start your session') ?></p>

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
            <a href=/auth/forgot-password><?= Calamity::t('auth', 'I forgot my password') ?></a>
        </p>
        <p class="mb-0">
            <a href="/auth/register"><?= Calamity::t('auth', 'Register a new membership') ?></a>
        </p>
    </div>
</div>
