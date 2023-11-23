<?php
/**
 * @var $this \tframe\core\View
 * @var $registerForm tframe\core\auth\RegisterForm
 */

use tframe\common\components\form\Form;
use tframe\common\components\text\Text;
use tframe\core\Application;

$this->title = 'Create User';
?>

<div class="row">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Users Data</h3>
            </div>
            <div class="card-body">
                <?php $form = Form::begin('post') ?>

                <?= $form->field($registerForm, 'email')->required(); ?>
                <?= $form->field($registerForm, 'firstName')->required(); ?>
                <?= $form->field($registerForm, 'lastName')->required(); ?>
                <?= $form->field($registerForm, 'password')->passwordField(); ?>
                <?= $form->field($registerForm, 'passwordConfirmation')->passwordField(); ?>

                <?= $form->submitButton(Application::t('general', 'Save'), 'btn-success', 'fa-floppy-disk') ?>

                <?php Form::end() ?>
            </div>
        </div>
    </div>
</div>
