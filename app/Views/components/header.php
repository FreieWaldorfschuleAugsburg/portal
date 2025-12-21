<?php

use App\Models\OAuthException;
use function App\Helpers\user;

?>
<!DOCTYPE html>
<html lang="<?= service('request')->getLocale(); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="theme-color" content="#111111" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#eeeeee" media="(prefers-color-scheme: dark)">

    <title><?= lang('app.name.short') ?></title>

    <link href="<?= base_url('/') ?>/assets/img/logo.png" rel="icon">
    <meta name="color-scheme" content="light dark">

    <link href="<?= base_url('/') ?>/assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url('/') ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('/') ?>/assets/css/bootstrap-dark-plugin.min.css" rel="stylesheet">
    <link href="<?= base_url('/') ?>/assets/img/logo.png" rel="icon">
    <link rel="stylesheet" href="<?= base_url('/') ?>/assets/css/fontawesome.min.css"/>
</head>

<body>