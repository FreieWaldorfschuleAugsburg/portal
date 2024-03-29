<main class="px-5 xl:px-24 2xl:px-60 space-y-5 mt-5">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h1-small text-white"><?= lang('role.headings.view') ?></p>
        <a href="<?= base_url('roles/new') ?>" class="font-inter-medium text-white bg-blue-600 rounded ">
            <button class="p-3">Neu erstellen</button>
        </a>
    </div>

    <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-5 mt-5">
        <?php foreach ($roles as $role): ?>
            <div class="bg-gray-900  text-white font-inter-regular px-5 py-5 rounded-lg flex flex-col gap-3 ">
                <div class="flex justify-between items-center w-full">
                    <p class="text-h2-small"><?= $role->role_name ?></p>
                    <button class="text-category">
                        <a href="<?= base_url('roles/edit/' . $role->role_id) ?>"
                           class="bg-blue-600/50 text-indigo-200 py-2 px-3 text-category rounded">
                            <?= lang('entry.button.edit') ?>
                        </a>
                    </button>
                </div>
                <div class="max-h-20 overflow-scroll">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 items-start">
                        <?php foreach ($role->groups as $group): ?>
                            <p class="bg-blue-600/50 text-white p-1.5 px-3 text-2xs rounded text-ellipsis overflow-hidden whitespace-nowrap font-inter-regular">
                                <?= $group->internal_name ?> </p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>