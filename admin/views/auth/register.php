<?php
/**
 * @var $registerForm \calamity\common\components\auth\RegisterForm
 * @var $this         \calamity\common\models\core\View
 * @var $googleClient false|\calamity\common\components\auth\GoogleAuth
 */

use calamity\common\components\form\Form;
use calamity\common\models\core\Calamity;

$this->title = Calamity::t('auth', 'Register') . ' | ' . Calamity::$GLOBALS['APP_NAME'];
?>

<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <img class="img-fluid d-inline-block text-right" src="/assets/images/tframe-logo.png" alt="Logo" style="width: 2.5rem">
        <span class="h3 mb-0 d-inline-block text-lefts align-middle"><?= Calamity::$GLOBALS['APP_NAME'] ?></span>
    </div>
    <div class="card-body register-card-body">
        <p class="login-box-msg"><?= Calamity::t('auth', 'Register a new membership') ?></p>

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
                <?= $form->submitButton(Calamity::t('auth', 'Register'), 'btn-primary d-block w-100'); ?>
            </div>
        </div>

        <?php Form::end() ?>

        <?php if ($googleClient): ?>
            <div class="social-auth-links text-center mb-3">
                <p>- OR -</p>
                <button class="gsi-material-button" onclick=location.href="<?= $googleClient->getRedirectUrl() ?>">
                    <div class="gsi-material-button-state"></div>
                    <div class="gsi-material-button-content-wrapper">
                        <div class="gsi-material-button-icon">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 style="display: block;">
                                <path fill="#EA4335"
                                      d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                                <path fill="#4285F4"
                                      d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                                <path fill="#FBBC05"
                                      d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                                <path fill="#34A853"
                                      d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                                <path fill="none" d="M0 0h48v48H0z"></path>
                            </svg>
                        </div>
                        <span class="gsi-material-button-contents">Continue with Google</span>
                        <span style="display: none;">Continue with Google</span>
                    </div>
                </button>
            </div>
        <?php endif; ?>

        <p class="mb-0">
            <a href="/auth/login"><?= Calamity::t('auth', 'I already have a membership') ?></a>
        </p>
    </div>
</div>
