<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-small text-white">Abwesenheiten</p>
        <?php if (session('ABSENCE_ADMIN')): ?>
            <a href="<?= base_url('absences') ?>" class="font-inter-medium text-white bg-blue-600 rounded">
                <button class="p-3">Zurück</button>
            </a>
        <?php endif; ?>
    </div>

    <?php
    $now = new DateTime();
    $yesterday = $now->modify('-1 day');

    $absences = getAbsencesByDate(new DateTime());
    $absences = array_merge($absences, getAbsencesByDate($yesterday))
    ?>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400 mb-5">
            <thead class="bg-white dark:bg-gray-800">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Schüler/in
                </th>
                <th scope="col" class="px-6 py-3">
                    Gemeldet am
                </th>
                <th scope="col" class="px-6 py-3">
                    Gemeldet von
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($absences as $absence): ?>
                <?php if ($absence->getReportedBy() == 'Import'): continue; endif; ?>
                <?php $student = getStudent($absence->getStudentId()); ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        <?= $student->getLastName() . ', ' . $student->getFirstName() ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $absence->getReportedAt()->format('d.m.Y H:i'); ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $absence->getReportedBy() ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg text-white font-inter-medium">
        <?= form_open_multipart(base_url('absences/admin/upload/absences'), ["onsubmit" => "return confirm('Möchten Sie die Abwesenheiten wirklich hochladen? ACHTUNG! Hierdurch werden die aktuellen Abwesenheitsdaten überschrieben.');"]) ?>
        <p class="font-inter-semibold text-h2-small">Abwesenheiten hochladen</p>
        <input type="file" name="userUploadFile" class="rounded p-3 bg-slate-900 border-none focus:outline-none flex-1"
               required>
        <button type="submit" class="bg-blue-600 text-white text-body rounded py-3 p-3">
            Upload
        </button>
        <?= form_close() ?>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg text-white font-inter-medium">
        <?= form_open_multipart(base_url('absences/admin/upload/students'), ["onsubmit" => "return confirm('Möchten Sie die Schülerdaten wirklich hochladen? ACHTUNG! Hiermit werden die aktuellen Abwesenheitsdaten gelöscht.');"]) ?>
        <p class="font-inter-semibold text-h2-small">Schülerdaten hochladen</p>
        <input type="file" name="userUploadFile" class="rounded p-3 bg-slate-900 border-none focus:outline-none flex-1"
               required>
        <button type="submit" class="bg-blue-600 text-white text-body rounded py-3 p-3">
            Upload
        </button>
        <?= form_close() ?>
    </div>
</main>