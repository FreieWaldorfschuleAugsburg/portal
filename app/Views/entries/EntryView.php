<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h1-small text-white">Einträge</p>
        <a href="<?= base_url('entries/new') ?>" class="font-inter-medium  text-white bg-blue-600 rounded">
            <button class="p-3">Neu erstellen</button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-5">
        <?php foreach ($entries as $entry): ?>
            <div class="bg-gray-900 text-white font-inter-regular px-5 py-3 rounded-lg flex justify-between">
                <div>
                    <div class="flex flex-col items-start gap-1 ">
                        <p class="bg-blue-600/50 text-white p-1.5 px-3 text-xs rounded font-inter-regular bg-blue-400">
                            <?= $entry->role_name ?: "Alle" ?></p>
                        <p class="text-gray-500"><?= $entry->category_name ?></p>
                    </div>
                    <div class="w-52">
                        <p class="text-h2-small text-ellipsis overflow-hidden whitespace-nowrap"><?= $entry->entry_name ?></p>
                    </div>
                </div>

                <button class="text-category text-white">
                    <a href="<?= base_url('entries/edit/' . $entry->entry_id) ?>" class="bg-blue-600 p-3 rounded">
                        <?= lang('entry.button.edit') ?>
                    </a>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</main>