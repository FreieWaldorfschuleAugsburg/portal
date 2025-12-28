<div class="row portal-grid">
    <?php foreach ($entries as $entry): ?>
        <?php $id = md5(rand()) ?>

        <a class="col portal-button background-<?= $id ?>"
           href="<?= $entry->url ?>">
            <p><?= $entry->name ?></p>
        </a>

        <style>
            .background-<?= $id ?> {
                background: url("<?= $entry->image ?>") no-repeat 150px 0px, linear-gradient(to bottom right,<?= $entry->color1 ?>, <?= $entry->color2 ?>);
            }
        </style>
    <?php endforeach; ?>
</div>

<style>

</style>