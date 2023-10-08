<?php
/**
 * @var $this \tframe\core\View
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?= $this->title ?></title>

    <link rel="stylesheet" href="/assets/adminlte/adminlte.css">
    <link rel="stylesheet" href="/assets/fontawesome/all.css">

    <?= $this->css ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">

{{content}}

</div>

<script src="/assets/adminlte/adminlte.js"></script>

<?= $this->js; ?>

</body>
</html>