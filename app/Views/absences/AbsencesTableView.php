<?php


use function App\Helpers\getProcuratAbsences;
use function App\Helpers\getProcuratPerson; ?>
<style>
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>

<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-small text-white">Abwesenheiten / Tabellenansicht</p>
        <a href="<?= base_url('absences') ?>" class="font-inter-medium text-white bg-blue-600 rounded">
            <button class="p-3">Zurück</button>
        </a>
    </div>

    <?php
    $absences = getProcuratAbsences();
    usort($absences, fn($a, $b) => strcmp(getProcuratPerson($a->getPersonId())->getFirstName(), getProcuratPerson($b->getPersonId())->getFirstName()));

    //$studentCount = countStudents();
    $studentCount = 0;
    ?>

    <!--<div class="text-center">
        <p class="text-h4-big text-white">Es sind heute <b><?= count($absences) ?> von <?= $studentCount ?></b>
            SchülerInnen ganz- bzw. halbtags entschuldigt.</p>
    </div>-->

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400 mb-5">
            <thead class="bg-white dark:bg-gray-800">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Schüler/in
                </th>
                <!--<th scope="col" class="px-6 py-3">
                    Klasse
                </th>-->
                <th scope="col" class="px-6 py-3">
                    Bemerkung
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($absences as $absence): ?>
                <?php $student = getProcuratPerson($absence->getPersonId()); ?>

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        <?= $student->getFirstName() . ' ' . $student->getLastName() ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $absence->getNote() ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>