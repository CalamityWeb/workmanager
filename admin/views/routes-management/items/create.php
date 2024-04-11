<?php
/**
 * @var $this      \calamity\View
 * @var $routeItem \calamity\auth\AuthItem
 */

use calamity\common\components\form\Form;
use calamity\Calamity;

$this->title = Calamity::t('general', 'Create Route Item');
?>

<div class="row">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?= Calamity::t('general', 'Route Item') ?></h3>
            </div>
            <div class="card-body">
                <?php $form = Form::begin('post') ?>

                <?= $form->field($routeItem, 'item')->required() ?>
                <p>
                    Please use <strong>@public</strong> or <strong>@admin</strong> aliases for the routes start
                </p>
                <?= $form->textareaField($routeItem, 'description') ?>

                <?= $form->submitButton(Calamity::t('general', 'Save'), 'btn-success', 'fa-floppy-disk') ?>

                <?php Form::end() ?>
            </div>
        </div>
    </div>
</div>