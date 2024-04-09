<?php
/**
 * @var $this     \tframe\core\View
 * @var $authItem \tframe\core\auth\AuthItem
 */

use calamity\common\components\form\Form;
use calamity\common\components\text\Text;
use calamity\core\Calamity;

$this->title = Calamity::t('general', 'Manage Route');
?>

<div class="row">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Calamity::t('general', 'Route Item') ?></h3>
            </div>
            <div class="card-body">
                <?php $form = Form::begin('post') ?>

                <?= $form->field($authItem, 'item')->required(); ?>
                <?= $form->textareaField($authItem, 'description'); ?>

                <?= $form->submitButton(Calamity::t('general', 'Save'), 'btn-success', 'fa-floppy-disk') ?>

                <?php Form::end() ?>
                <p class="fs-7 mb-0 mt-3 fst-italic text-end">
                    <?= Calamity::t('general', 'Created') ?>: <?= $authItem->created_at ?>
                </p>
                <p class="fs-7 mb-0 fst-italic text-end">
                    <?= Calamity::t('general', 'Edited') ?>: <?= ($authItem->updated_at != null) ? $authItem->updated_at : Text::notSetText() ?>
                </p>
            </div>
        </div>
    </div>
</div>
