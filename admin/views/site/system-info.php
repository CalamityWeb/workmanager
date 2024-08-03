<?php
/**
 * @var $this      \calamity\common\models\core\View
 * @var $userCount integer
 * @var $user      \calamity\common\models\Users
 */

use calamity\common\models\core\Calamity;
use calamity\common\models\Users;

$this->title = Calamity::t('general', 'System Information');

/** @var \calamity\common\models\Users $sessionUser */
$sessionUser = Users::findOne([Users::primaryKey() => Calamity::$app->session->get('sessionUser')]);
?>
<div class="row">
    <div class="col-12 col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Software Licencing</h3>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Licence Organization:</strong> <a href="">Elektromágneses Cikkek International Kft.</a>
                    </li>
                    <li class="list-group-item">
                        <strong>Licence Owner:</strong> <a href="">Robert Krcsma</a>
                    </li>
                    <li class="list-group-item">
                        <strong>Licence Type: </strong>WorkManager V1 Master HUN
                        <span data-bs-toggle="tooltip" data-bs-title="Verified Master Licence">
                            <i class="fa-solid fa-badge-check text-indigo-500"></i>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <strong>Licence Validity :</strong> 2026-12-31 (<?= round((strtotime("2026-12-31") - time()) / 86400) ?> days left)
                    </li>
                    <li class="list-group-item">
                        <strong>Licence Price :</strong> €1000/year
                    </li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="">Change Licence</a>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Software Information</h3>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Software Version: </strong>v0.0-dev
                    </li>
                    <li class="list-group-item">
                        <strong>Software Developer :</strong> CalamityWeb
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Server Information</h3>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>PHP Version:</strong> <?= phpversion() ?>
                    </li>
                    <li class="list-group-item">
                        <strong>SQL Version:</strong> <?= Calamity::$app->db->pdo->query('select version()')->fetchColumn() ?>
                    </li>
                    <li class="list-group-item">
                        <strong>WebServer:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>