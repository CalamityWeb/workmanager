<?php
/**
 * @var $loginForm \tframe\core\auth\LoginForm
 * @var $this \tframe\core\View
 */

use tframe\common\components\form\Form;
use tframe\core\Application;

$this->title = 'Login to ' . Application::$GLOBALS['APP_NAME'];
?>

<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <img class="img-fluid d-inline-block text-right" src="/assets/images/tframe-logo.png" alt="Logo" style="width: 2.5rem">
        <span class="h3 mb-0 d-inline-block text-lefts align-middle"><?= Application::$GLOBALS['APP_NAME'] ?></span>
    </div>
    <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php $form = Form::begin('post') ?>

        <?php echo $form->fieldWithIcon($loginForm, 'email', 'fa-solid fa-envelope')->required();?>
        <?php echo $form->fieldWithIcon($loginForm, 'password', 'fa-solid fa-lock')->passwordField()->required();?>

        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="rememberMe" name="rememberMe">
                    <label for="rememberMe">
                        Remember Me
                    </label>
                </div>
            </div>
            <div class="col-4">
                <?php echo $form->submitButton('Log in', 'btn-primary d-block w-100');?>
            </div>
        </div>

        <?php Form::end() ?>

        <div class="social-auth-links text-center mt-2 mb-3">
            <a href="#" class="btn btn-block btn-danger">
                <i class="fa-brands fa-google mr-2"></i> Sign in using Google account
            </a>
        </div>

        <p class="mb-1">
            <a href=/auth/forgot-password>I forgot my password</a>
        </p>
        <p class="mb-0">
            <a href="/auth/register" class="text-center">Register a new membership</a>
        </p>
    </div>
</div>
