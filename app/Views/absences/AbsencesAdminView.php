<style>
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>

<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-small text-white">Abwesenheiten / Administration</p>
        <?php use function App\Helpers\getAbsencesByDate;
        use function App\Helpers\getFirstImportedAbsence;
        use function App\Helpers\getStudent;

        if (session('ABSENCE_ADMIN')): ?>
            <a href="<?= base_url('absences') ?>" class="font-inter-medium text-white bg-blue-600 rounded">
                <button class="p-3">Zurück</button>
            </a>
            <a href="<?= base_url('absences/admin/groups') ?>" class="font-inter-medium text-white bg-red-600 rounded">
                <button class="p-3">Gruppenkonfiguration</button>
            </a>
        <?php endif; ?>
    </div>

    <?php
    $now = new DateTime();
    $yesterday = $now->modify('-1 day');

    $absences = getAbsencesByDate(new DateTime());
    $yesterdayAbsences = getAbsencesByDate($yesterday);
    $absences = array_merge($absences, $yesterdayAbsences);
    ?>

    <?php if (count($yesterdayAbsences) > 0): ?>
        <div id="yesterdayAlert"
             class="flex gap-3 bg-red-600 rounded-xl justify-between px-3 py-5 transition hover:scale-95 ease-in-out">
            <div>
                <div class="text-white r outline-1 flex flex-col flex-1">
                    <a class="text-h4-small md:text-h4-big tracking-tight font-inter-semibold leading-6 md:leading-8 lg:leading-8"><b>Achtung!</b>
                        Es gibt noch unbearbeitete Absenzen vom Vortag! Wenn jetzt hochgeladen wird, werden
                        diese überschrieben und gehen verloren.<br><small>(Die untenstehenden Absenzen bitte zuerst in
                            Procurat! aufnehmen.)</small></a>
                </div>
            </div>
        </div>
    <?php endif; ?>

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
                        <?= $student->getFirstName() . ' ' . $student->getLastName() ?>
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

    <?php if ($error = session('error')): ?>
        <div class="flex gap-3 bg-red-600 rounded-xl justify-between px-3 py-5 transition hover:scale-95 ease-in-out">
            <div>
                <div class="text-white r outline-1 flex flex-col flex-1">
                    <a class="text-h4-small md:text-h4-big tracking-tight font-inter-semibold leading-6 md:leading-8 lg:leading-8"><?= $error ?></a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($success = session('success')): ?>
        <div class="flex gap-3 bg-green-600 rounded-xl justify-between px-3 py-5 transition hover:scale-95 ease-in-out">
            <div>
                <div class="text-white r outline-1 flex flex-col flex-1">
                    <a class="text-h4-small md:text-h4-big tracking-tight font-inter-semibold leading-6 md:leading-8 lg:leading-8"><?= $success ?></a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg text-white font-inter-medium">
        <?= form_open_multipart(base_url('absences/admin/upload/absences_p4'), ["onsubmit" => "return confirm('Möchten Sie die Abwesenheiten wirklich hochladen? ACHTUNG! Hierdurch werden die aktuellen Abwesenheitsdaten überschrieben.');"]) ?>
        <p class="font-inter-semibold text-h2-small"><b>Procurat!4</b> Abwesenheiten hochladen</p>
        <input type="file" name="userUploadFile" class="rounded p-3 bg-slate-900 border-none focus:outline-none flex-1"
               required>
        <button type="submit" class="bg-blue-600 text-white text-body rounded py-3 p-3">
            Upload
        </button>
        <?= form_close() ?>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg text-white font-inter-medium">
        <?= form_open_multipart(base_url('absences/admin/upload/absences_p5'), ["onsubmit" => "return confirm('Möchten Sie die Abwesenheiten wirklich hochladen? ACHTUNG! Hierdurch werden die aktuellen Abwesenheitsdaten überschrieben.');"]) ?>
        <p class="font-inter-semibold text-h2-small"><b>Procurat!5</b> Abwesenheiten hochladen</p>
        <input type="file" name="userUploadFile" class="rounded p-3 bg-slate-900 border-none focus:outline-none flex-1"
               required>
        <button type="submit" class="bg-blue-600 text-white text-body rounded py-3 p-3">
            Upload
        </button>
        <?= form_close() ?>
    </div>

    <?php if (!is_null($absence = getFirstImportedAbsence())): ?>
        <p class="text-white">Letzter Upload: <?= $absence->getReportedAt()->format('d.m.Y H:i') ?></p>
    <?php endif; ?>

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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alert = document.getElementById('yesterdayAlert');
        if (alert != null) {
            setInterval(() => blink(alert), 500)
        }
    });

    function blink(alert) {
        const status = alert.classList.contains('bg-red-600')
        alert.classList.toggle('bg-red-600', !status)
        alert.classList.toggle('bg-orange-600', status)
    }
</script>