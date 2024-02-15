<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-small text-white">Abwesenheiten / Administration /
            Gruppenkonfiguration</p>
        <?php if (session('ABSENCE_ADMIN')): ?>
            <a href="<?= base_url('absences/admin') ?>" class="font-inter-medium text-white bg-blue-600 rounded">
                <button class="p-3">Zurück</button>
            </a>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-5">
        <?php foreach (getAbsenceGroups() as $group): ?>
            <div class="bg-gray-900 text-white font-inter-regular px-5 py-3 rounded-lg flex justify-between"
                 style="color: black; background-color: #FFD032;">
                <div>
                    <div class="flex flex-col items-start gap-1">
                        <div class="w-52 mt-3 mb-5">
                            <p class="text-h2-small text-ellipsis overflow-hidden whitespace-nowrap"><?= $group->getName() ?></p>
                        </div>
                    </div>
                </div>

                <button class="text-category text-white text-center">
                    <a href="<?= base_url('absences/admin/groups/edit/' . $group->getId()) ?>" class="bg-blue-600 p-3 rounded">
                        <?= lang('buttons.edit') ?>
                    </a>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</main>