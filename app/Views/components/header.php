<?php

use function App\Helpers\getCurrentUser;

?>
<!DOCTYPE html>
<html lang="<?= service('request')->getLocale(); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= lang('app.name.full') ?></title>

    <link href="<?= base_url('assets/css/output.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/script.js') ?>" defer></script>
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

    <!-- Matomo -->
    <script>
        var _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function () {
            var u = "//matomo.waldorf-augsburg.de/";
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', '3']);

            <?php if($user = getCurrentUser()): ?>
                _paq.push(['setUserId', '<?= $user->username ?>'])
            <?php endif; ?>

            var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
            g.async = true;
            g.src = u + 'matomo.js';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <!-- End Matomo Code -->
</head>

<body>