<?php
/**
 * @var $this \calamity\View
 */

use calamity\common\components\alert\Sweetalert;
use calamity\common\models\Users;
use calamity\Calamity;

/** @var \calamity\common\models\Users $sessionUser */
$sessionUser = Users::findOne([Users::primaryKey() => Calamity::$app->session->get('sessionUser')]);

?>

<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="color-scheme" content="light dark">

    <title><?= $this->title ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/modules/adminlte/adminlte.css">
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/af-2.7.0/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/date-1.5.2/fh-4.0.1/r-3.0.1/sc-2.4.1/sb-1.7.0/sp-2.3.0/datatables.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <?php if (!empty(Calamity::$config['google'])): ?>
        <script src="https://www.google.com/recaptcha/api.js"></script>
    <?php endif; ?>
    <link rel="stylesheet" href="/assets/site.css?v=<?= time() ?>">

    {{css}}
</head>
<body class="layout-fixed">
<div id="preloader">
    <div id="loader"></div>
</div>
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-light">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                <span class="nav-link" data-lte-toggle="sidebar-full" role="button">
                    <i class="fa-solid fa-bars"></i>
                </span>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown user-menu">
                <span class="nav-link dropdown-toggle cursor-pointer" data-bs-toggle="dropdown">
                    <img src="<?= $sessionUser->getPicture() ?>" class="user-image img-circle shadow"
                         alt="User">
                    <span class="d-none d-md-inline">
                        <?= $sessionUser->getFullName() ?>
                    </span>
                    <?php if (!empty($sessionUser->getActiveRole()->roleIcon)): ?>
                        <span class="d-none d-md-inline">
                        <?= $sessionUser->getActiveRole()->roleIcon ?>
                    </span>
                    <?php endif; ?>
                </span>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <li class="user-header text-bg-primary">
                            <img src="<?= $sessionUser->getPicture() ?>" class="img-circle shadow" alt="User">
                            <p>
                                <?= $sessionUser->getFullName() ?>
                                <small><?= $sessionUser->getActiveRole()->roleIcon ?><?= $sessionUser->getActiveRole()->roleName ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <a href="/site/profile" class="btn btn-outline-primary btn-flat">
                                <i class="fa-solid fa-user me-1"></i>Profile
                            </a>
                            <a href="/auth/logout" class="btn btn-outline-danger btn-flat float-end">
                                <i class="fa-solid fa-right-from-bracket me-1"></i>Logout
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <button class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center"
                            id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
                        <span class="theme-icon-active">
                            <i class="my-1"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme" style="--bs-dropdown-min-width: 8rem;">
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light">
                                <i class="fa-solid fa-sun me-2 opacity-50"></i>
                                Light
                                <i class="fa-solid fa-check ms-auto d-none"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">
                                <i class="fa-solid fa-moon me-2 opacity-50"></i>
                                Dark
                                <i class="fa-solid fa-check ms-auto d-none"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto">
                                <i class="fa-solid fa-circle-half-stroke me-2 opacity-50"></i>
                                Auto
                                <i class="fa-solid fa-check ms-auto d-none"></i>
                            </button>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">
        <div class="brand-container">
            <a href="/site/dashboard" class="brand-link">
                <img src="/assets/images/tframe-logo.png" alt="Logo" class="brand-image shadow">
                <span class="brand-text fw-light"><?= Calamity::$GLOBALS['APP_NAME'] ?></span>
            </a>
            <span class="pushmenu mx-1" data-lte-toggle="sidebar-mini" role="button">
            <i class="fa-solid fa-angles-left"></i>
        </span>
        </div>
        <div class="sidebar">
            <nav>
                <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="menu"
                    data-accordion="false">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="<?= $sessionUser->getPicture() ?>" class="img-circle elevation-2"
                                 alt="User" style="width: 2.1rem">
                        </div>
                        <div class="info">
                            <span><?= $sessionUser->getFullName() ?></span>
                        </div>
                    </div>
                    <li class="nav-item">
                        <a href="/site/dashboard" class="nav-link">
                            <i class="nav-icon fa-solid fa-table-cells"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/site/profile" class="nav-link">
                            <i class="nav-icon fa-solid fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                    <li class="nav-header">User Management</li>
                    <li class="nav-item">
                        <a class="nav-link cursor-pointer" href="/users/list-all">
                            <i class="nav-icon fa-solid fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-header">Routes Management</li>
                    <li class="nav-item">
                        <a class="nav-link cursor-pointer" href="/routes-management/items/list-all">
                            <i class="nav-icon fa-solid fa-route"></i>
                            <p>Route Items</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cursor-pointer" href="/routes-management/roles/list-all">
                            <i class="nav-icon fa-solid fa-shield-halved"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                    <li class="nav-header">Miscellaneous</li>
                    <li class="nav-item">
                        <a class="nav-link cursor-pointer" href="/auth/logout">
                            <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                            <p>Log out</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <main class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3><?= $this->title ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                {{content}}
            </div>
        </section>
    </main>
    <footer class="main-footer">
        <strong>
            Copyright &copy; <?= date('Y') ?> |
            <a href="<?= Calamity::$URL['@public'] ?>"><?= Calamity::$GLOBALS['APP_NAME'] ?></a> |
            All Rights Reserved.
        </strong>

        <div class="float-end d-none d-sm-inline-block">
            <b>Version</b> v2.0
        </div>
    </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="/assets/modules/adminlte/adminlte.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/af-2.7.0/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/date-1.5.2/fh-4.0.1/r-3.0.1/sc-2.4.1/sb-1.7.0/sp-2.3.0/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

{{js}}

<script src="/assets/site.js?v=<?= time() ?>"></script>

<?php if (Calamity::$app->session->getFlash('success')): ?>
    <?= Sweetalert::generateToastAlert('success', Calamity::$app->session->getFlash('success')) ?>
<?php endif; ?>
<?php if (Calamity::$app->session->getFlash('error')): ?>
    <?= Sweetalert::generateToastAlert('error', Calamity::$app->session->getFlash('error')) ?>
<?php endif; ?>

</body>
</html>