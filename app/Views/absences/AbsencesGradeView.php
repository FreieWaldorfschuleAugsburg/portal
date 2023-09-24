<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h1-small text-white"><?= ($grade = getGradeById($gradeId))->getName() ?></p>
        <a href="<?= base_url('absences') ?>" class="font-inter-medium text-white bg-blue-600 rounded">
            <button class="p-3">Zurück</button>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-5">
        <?php foreach (getStudents($gradeId) as $student): ?>
            <div class="bg-green-600 text-white font-inter-regular px-5 py-3 rounded-lg flex justify-between">
                <div>
                    <div class="flex flex-col items-start gap-1">
                        <div class="w-52 mt-3 mb-5">
                            <p class="text-h2-small text-ellipsis overflow-hidden whitespace-nowrap"><?= $student->getLastName() . ", " . $student->getFirstName() ?></p>
                        </div>
                    </div>
                </div>

                <?= form_open('absences/absent') ?>
                <?= form_hidden('id', $student->getId()); ?>
                <button type="submit" class="text-category text-white text-center bg-red-600 mt-3 p-3 rounded">
                    Abwesend
                </button>
                <?= form_close() ?>
            </div>

            <!--<div class="bg-red-600 text-white font-inter-regular px-5 py-3 rounded-lg flex justify-between">
                <div>
                    <div class="flex flex-col items-start gap-1">
                        <div class="w-52 mt-3 mb-5">
                            <p class="text-h2-small text-ellipsis overflow-hidden whitespace-nowrap"><?= $student->getLastName() . ", " . $student->getFirstName() ?></p>
                        </div>
                    </div>
                </div>
            </div>-->
        <?php endforeach; ?>
    </div>
</main>