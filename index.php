<?php
$entries = json_decode(file_get_contents('./entries.json'));
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Portal der Freien Waldorfschule und Waldorfkindergärten Augsburg</title>

    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="assets/img/logo.png">

    <script src="assets/js/jquery.min.js"></script>
</head>

<body>

<div class="flex px-5 xl:px-24 2xl:px-60 py-5 justify-center">
    <div class="flex items-center gap-3">
        <img src="assets/img/logo.png" class="w-10 animate-pulse" alt="">
        <a href="/" class="text-white font-inter-semibold text-h1-small">
            Portal
        </a>
    </div>
</div>

<div class="flex xl:px-24 2xl:px-60 py-3 justify-center">
    <span id="brand" class="text-white text-center font-inter-semibold text-body">Freie Waldorfschule Augsburg</span>
</div>

<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-5">
        <?php foreach ($entries as $entry): ?>
            <?php $id = md5(rand()) ?>

            <a class="bg-gray-900 text-white px-5 py-8 rounded-xl text-center text-h2-big link-<?= $id ?> flex-shrink-0 transition hover:scale-95 ease-in-out shadow self-start"
               href="<?= $entry->url ?>">
                <p class="text-h2-small md:text-h2-big tracking-tight font-inter-semibold">
                    <?= $entry->name ?></p>
            </a>

            <style>
                .link-<?= $id ?> {
                    color: white;
                    text-align: start;
                    line-height: 0.5rem !important;
                    background: url("<?= $entry->image ?>") no-repeat 150px 0, linear-gradient(to bottom right,<?= $entry->color1 ?>, <?= $entry->color2 ?>);
                    background-blend-mode: luminosity;
                    background-size: 250px, cover;
                    height: 145px;
                }
            </style>
        <?php endforeach; ?>
    </div>
</main>

<div class="text-center mt-6 mb-5 text-white">
    <p class="font-inter-regular">&copy; <?= date("Y") ?> Freie Waldorfschule und Waldorfkindergärten Augsburg e. V.<br><a
                href="https://waldorf-augsburg.de/impressum">Impressum</a>
        &ndash; <a href="https://waldorf-augsburg.de/datenschutz">Datenschutz</a>
        &ndash; <a href="https://get.anydesk.com/mOI6IRH1/FWAFernwartung.exe">Fernwartung</a><br>
    </p>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        setInterval(changeText, 2500)

        const texts = ["Freie Waldorfschule Augsburg", "Waldorfhaus für Kinder Hammerschmiede", "Waldorfhaus für Kinder an den Lechauen"]
        let textIndex = 0;

        function changeText() {
            let element = document.getElementById("brand");
            $(element).fadeOut(
                1000,
                function(){
                    element.innerHTML = texts[textIndex];
                    $(element).fadeIn();
                }
            );

            textIndex++;
            if (textIndex >= texts.length) {
                textIndex = 0;
            }
        }
    });
</script>

</body>
</html>