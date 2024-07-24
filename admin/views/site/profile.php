<?php
/**
 * @var $this \calamity\common\models\core\View
 * @var $user \calamity\common\models\Users
 */

use calamity\common\components\form\Form;
use calamity\common\components\text\Text;
use calamity\common\models\core\Calamity;

$this->title = Calamity::t('general', 'Profile');
?>
<!--<script src="https://www.google.com/recaptcha/enterprise.js?render=6LeA4bUpAAAAANkhGiTJlx9z7h4B6BhNLrpetG2l"></script>-->
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
                <h3 class="card-title"><?= Calamity::t('general', 'Profile') ?></h3>
            </div>
            <div class="card-body">
                <?php $form = Form::begin('post', ['id' => 'submit-profile']) ?>

                <?= $form->field($user, 'email')->required(); ?>
                <?= $form->field($user, 'firstName')->required(); ?>
                <?= $form->field($user, 'lastName')->required(); ?>

                <?= $form->captchaSubmitButton('submit-profile', Calamity::t('general', 'Save'), 'btn-success', 'fa-floppy-disk') ?>

                <p class="fs-7 mb-0 mt-3 fst-italic text-end">
                    <?= Calamity::t('general', 'Created') ?>: <?= $user->created_at ?>
                </p>
                <p class="fs-7 mb-0 fst-italic text-end">
                    <?= Calamity::t('general', 'Edited') ?>: <?= ($user->updated_at != null) ? $user->updated_at : Text::notSetText() ?>
                </p>
            </div>
        </div>
    </div>
</div>