<?php
/**
 * @var $this \tframe\core\View
 */

use calamity\common\components\alert\Sweetalert;
use calamity\core\Calamity;

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?= $this->title ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/modules/adminlte/adminlte.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/assets/site.css?v=<?= time() ?>">

    {{css}}
</head>
<body class="hold-transition login-page">
<div class="login-box">

    {{content}}

</div>

<script src="/assets/modules/adminlte/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{js}}

<script src="/assets/site.js"></script>

<?php if (Calamity::$app->session->getFlash('success')): ?>
    <?= Sweetalert::generateToastAlert('success', Calamity::$app->session->getFlash('success'), 1500, Calamity::$app->session->getFlashContent('success')['redirectUrl']) ?>
<?php endif; ?>

</body>
</html>