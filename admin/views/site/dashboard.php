<?php
/**
 * @var $this      \calamity\View
 * @var $userCount integer
 * @var $user      \calamity\common\models\Users
 */

use calamity\Calamity;

$this->title = Calamity::t('general', 'Dashboard');
?>
<div class="row mb-2">
    <div class="col-12">
        <h3><?= Calamity::t('general', 'Welcome,') ?> <?= $user->firstName ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-xl-3">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?= $userCount ?></h3>
                <p class="mb-0"><?= Calamity::t('general', 'Users') ?></p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>
</div>
