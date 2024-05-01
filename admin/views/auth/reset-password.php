<?php
/**
 * @var $resetPasswordForm \calamity\common\components\auth\ResetPasswordForm
 * @var $this              \calamity\common\models\core\View
 */

use calamity\common\components\form\Form;
use calamity\common\models\core\Calamity;

$this->title = Calamity::t('auth', 'Reset password') . ' | ' . Calamity::$GLOBALS['APP_NAME'];

?>

<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <img class="img-fluid d-inline-block text-right" src="/assets/images/tframe-logo.png" alt="Logo" style="width: 2.5rem">
        <span class="h3 mb-0 d-inline-block text-lefts align-middle"><?= Calamity::$GLOBALS['APP_NAME'] ?></span>
    </div>
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?= Calamity::t('auth', 'Create your new password') ?></p>

        <?php $form = Form::begin('post') ?>

        <?= $form->fieldWithIcon($resetPasswordForm, 'password', 'fa-solid fa-lock')->passwordField()->required() ?>
        <?= $form->fieldWithIcon($resetPasswordForm, 'passwordConfirmation', 'fa-solid fa-lock')->passwordField()->required() ?>

        <?= $form->submitButton(Calamity::t('auth', 'Change my password!'), 'btn-primary d-block w-100') ?>

        <?php Form::end() ?>
    </div>
</div>