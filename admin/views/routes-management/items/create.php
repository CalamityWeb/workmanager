<?php
/**
 * @var $this \tframe\core\View
 * @var $routeItem \tframe\core\auth\AuthItem
 */

use tframe\common\components\form\Form;
use tframe\common\components\text\Text;
use tframe\core\Application;

$this->title = 'Create Route Item';
?>

<div class="row">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Route Item</h3>
            </div>
            <div class="card-body">
                <?php $form = Form::begin('post') ?>

                <?= $form->field($routeItem, 'item')->required(); ?>
                <p>
                    Please use <strong>@public</strong>, <strong>@admin</strong> or <strong>@api</strong> aliases for the routes start
                </p>
                <?= $form->textareaField($routeItem, 'description') ?>

                <?= $form->submitButton(Application::t('general', 'Save'), 'btn-success', 'fa-floppy-disk') ?>

                <?php Form::end() ?>
            </div>
        </div>
    </div>
</div>