<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-small text-white">Abwesenheiten</p>
        <?php

        use function App\Helpers\getAbsenceGroups;
        use function App\Helpers\getAbsencesByDate;
        use function App\Helpers\getGrades;

        if (session('ABSENCE_ADMIN')): ?>
            <a href="<?= base_url('absences/admin') ?>" class="font-inter-medium text-white bg-blue-600 rounded">
                <button class="p-3">Administration</button>
            </a>
        <?php endif; ?>
        <a href="<?= base_url('absences/table') ?>" class="font-inter-medium text-white bg-blue-600 rounded">
            <button class="p-3">Tabellenansicht</button>
        </a>
    </div>

    <?php
    $absences = getAbsencesByDate(new DateTime());
    if (count($absences) > 0): ?>
        <div class="text-center">
            <p class="text-h2-big text-white">Bitte wählen Sie eine Klasse oder Gruppe!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-5">
            <?php foreach (getAbsenceGroups() as $absenceGroup): ?>
                <div class="bg-gray-900 text-white font-inter-regular px-5 py-3 rounded-lg flex justify-between"
                     style="color: black; background-color: #6aa84f;">
                    <div>
                        <div class="flex flex-col items-start gap-1">
                            <div class="w-52 mt-3 mb-5">
                                <p class="text-h2-small text-ellipsis overflow-hidden whitespace-nowrap"><?= $absenceGroup->getName() ?></p>
                            </div>
                        </div>
                    </div>

                    <button class="text-category text-white text-center">
                        <a href="<?= base_url('absences/groups/' . $absenceGroup->getId()) ?>"
                           class="bg-blue-600 p-3 rounded">
                            <?= lang('buttons.view') ?>
                        </a>
                    </button>

                    <button class="text-category text-white text-center">
                        <a href="<?= base_url('absences/print/absence/group/' . $absenceGroup->getId()) ?>"
                           class="bg-blue-600 p-3 rounded">
                            Abw. drucken
                        </a>
                    </button>
                    <button class="text-category text-white text-center">
                        <a href="<?= base_url('absences/print/presence/group/' . $absenceGroup->getId()) ?>"
                           class="bg-blue-600 p-3 rounded">
                            Anw. drucken
                        </a>
                    </button>
                </div>
            <?php endforeach; ?>
            <?php foreach (getGrades() as $grade): ?>
                <div class="bg-gray-900 text-white font-inter-regular px-5 py-3 rounded-lg flex justify-between"
                     style="color: black; background-color: #FFD032;">
                    <div>
                        <div class="flex flex-col items-start gap-1">
                            <div class="w-52 mt-3 mb-5">
                                <p class="text-h2-small text-ellipsis overflow-hidden whitespace-nowrap"><?= $grade->getName() ?></p>
                            </div>
                        </div>
                    </div>

                    <button class="text-category text-white text-center">
                        <a href="<?= base_url('absences/view/' . $grade->getId()) ?>" class="bg-blue-600 p-3 rounded">
                            <?= lang('buttons.view') ?>
                        </a>
                    </button>
                    <button class="text-category text-white text-center">
                        <a href="<?= base_url('absences/print/absence/grade/' . $grade->getId()) ?>"
                           class="bg-blue-600 p-3 rounded">
                            Abw. drucken
                        </a>
                    </button>
                    <button class="text-category text-white text-center">
                        <a href="<?= base_url('absences/print/presence/grade/' . $grade->getId()) ?>"
                           class="bg-blue-600 p-3 rounded">
                            Anw. drucken
                        </a>
                    </button>
                </div>
            <?php endforeach; ?>

        </div>
    <?php else: ?>
        <div class="text-center">
            <p class="text-h2-big text-white">Für heute wurden noch keine Abwesenheiten eingestellt. <br>Bitte versuchen
                Sie es später erneut!</p>
        </div>
    <?php endif; ?>
</main>