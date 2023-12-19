<?php
/**
 * @var $this \tframe\core\View
 */

use tframe\common\components\alert\Sweetalert;
use tframe\common\models\User;
use tframe\core\Application;

/** @var \tframe\common\models\User $sessionUser */
$sessionUser = User::findOne([User::primaryKey() => Application::$app->session->get('sessionUser')]);

?>

<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="color-scheme" content="light dark">

    <title><?= $this->title ?></title>

    <link rel="stylesheet" href="/assets/modules/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/modules/adminlte/adminlte.css">
    <link rel="stylesheet" href="/assets/modules/Datatables/datatables.css">
    <link rel="stylesheet" href="/assets/modules/fontawesome/all.css">
    <link rel="stylesheet" href="/assets/modules/icheck-bootstrap.css">
    <link rel="stylesheet" href="/assets/modules/select2/select2.css">
    <link rel="stylesheet" href="/assets/site.css?v=<?= time() ?>">

    {{css}}
</head>
<body class="layout-fixed">
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
                    <img src="<?= $sessionUser->getUserPicture() ?>" class="user-image img-circle shadow"
                         alt="User">
                    <span class="d-none d-md-inline">
                        <?= $sessionUser->getFullName() ?>
                    </span>
                </span>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <li class="user-header text-bg-primary">
                            <img src="<?= $sessionUser->getUserPicture() ?>" class="img-circle shadow" alt="User">
                            <p>
                                <?= $sessionUser->getFullName() ?>
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
                            id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown"
                            data-bs-display="static">
                      <span class="theme-icon-active">
                            <i class="my-1"></i>
                      </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme"
                        style="--bs-dropdown-min-width: 8rem;">
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center active"
                                    data-bs-theme-value="light">
                                <i class="fa-solid fa-sun me-2 opacity-50"></i>
                                Light
                                <i class="fa-solid fa-check ms-auto d-none"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center"
                                    data-bs-theme-value="dark">
                                <i class="fa-solid fa-moon me-2 opacity-50"></i>
                                Dark
                                <i class="fa-solid fa-check ms-auto d-none"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center"
                                    data-bs-theme-value="auto">
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
                <span class="brand-text fw-light"><?= Application::$GLOBALS['APP_NAME'] ?></span>
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
                            <img src="<?= $sessionUser->getUserPicture() ?>" class="img-circle elevation-2"
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
                    <li class="nav-header">Roles Management</li>
                    <li class="nav-item">
                        <a class="nav-link cursor-pointer" href="/roles/list-all">
                            <i class="nav-icon fa-solid fa-users-gear"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                    <li class="nav-header">Routes Management</li>
                    <li class="nav-item">
                        <a class="nav-link cursor-pointer" href="/routes-management/items/list-all">
                            <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                            <p>Route Items</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cursor-pointer" href="/routes-management/groups/list-all">
                            <i class="nav-icon fa-solid fa-users-rays"></i>
                            <p>Authentication Groups</p>
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
            <a href="<?= Application::$URL['PUBLIC'] ?>" ><?= Application::$GLOBALS['APP_NAME'] ?></a> |
            All Rights Reserved.
        </strong>

        <div class="float-end d-none d-sm-inline-block">
            <b>Version</b> DEV
        </div>
    </footer>
</div>

<script src="/assets/jQuery.js"></script>
<script src="/assets/modules/bootstrap/js/bootstrap.bundle.js"></script>
<script src="/assets/modules/adminlte/adminlte.js"></script>
<script src="/assets/modules/DataTables/datatables.js"></script>
<script src="/assets/modules/select2/select2.js"></script>
<script src="/assets/modules/sweetalert2.js"></script>

{{js}}

<script src="/assets/site.js"></script>

<?php if (Application::$app->session->getFlash('success')): ?>
    <?= Sweetalert::generateToastAlert('success', Application::$app->session->getFlash('success')) ?>
<?php endif; ?>

</body>
</html>