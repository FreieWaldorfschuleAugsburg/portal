<?php

use App\Models\OAuthException;
use function App\Helpers\user;

?>
<!DOCTYPE html>
<html lang="<?= service('request')->getLocale(); ?>" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= lang('app.name.short') ?></title>

    <link href="<?= base_url('/') ?>/assets/img/logo.png" rel="icon">
    <link href="<?= base_url('/') ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('/') ?>/assets/css/fontawesome.min.css"/>

    <link href="<?= base_url('/') ?>/assets/css/style.css" rel="stylesheet">
</head>

<body>