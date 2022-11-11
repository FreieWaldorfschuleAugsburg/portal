<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 ">

    <div class="flex gap-5 items-center">

        <p class="font-inter-semibold text-h2-big lg:text-h1-small  text-white"><?= lang('credential.headings.view') ?></p>

        <a href="<?= base_url('credentials/new') ?>"
           class="font-inter-medium  text-white bg-blue-600 rounded text-white ">
            <button class="p-3" <?= session('ADMIN') ? '' : 'hidden' ?>><?= lang('buttons.createNew') ?></button>
        </a>
    </div>
    <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-5">
        <?php foreach ($credentials

                       as $credential): ?>
            <div class=" bg-gray-900 text-white font-inter-regular px-5 py-3 rounded-lg flex-col md:flex gap-5">
                <div class="space-y-2">
                    <div>
                        <div class="flex flex-col items-start gap-3 mb-2">
                            <p class=" bg-blue-700/50 text-indigo-200 p-1.5 px-3 text-xs rounded font-inter-regular bg-blue-400">
                                <?= $credential->role_name ?: "Alle" ?></p>
                        </div>
                        <div class="w-30 lg:w-52">
                            <p class="text-h2-small text-ellipsis overflow-hidden whitespace-nowrap"><?= $credential->credential_name ?></p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="<?= base_url('credentials/edit/' . $credential->credential_id) ?>"
                           class="bg-blue-600 text-xs md:text-category text-white text-center p-3 rounded" <?= \App\Helpers\hideForNonAdmin() ?>>
                            <?= lang('entry.button.edit') ?>
                        </a>

                        <a href="<?= base_url('credentials/' . $credential->credential_id) ?>"
                           class="bg-blue-600 text-xs md:text-category text-white text-center p-3 rounded">
                            <?= lang('buttons.view') ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

</main>