<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-small text-white">Abwesenheiten</p>
        <?php if (session('ABSENCE_ADMIN')): ?>
            <a href="<?= base_url('absences') ?>" class="font-inter-medium text-white bg-blue-600 rounded">
                <button class="p-3">Zurück</button>
            </a>
        <?php endif; ?>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400 mb-5">
            <thead class="bg-white dark:bg-gray-800">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Schüler/in
                </th>
                <th scope="col" class="px-6 py-3">
                    Klasse
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
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">
                    Peter Lustig
                </td>
                <td class="px-6 py-4">
                    Klasse 10
                </td>
                <td class="px-6 py-4">
                    24.09. 08:12 Uhr
                </td>
                <td class="px-6 py-4">
                    L. Groschke
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg text-white font-inter-medium">
        <?= form_open_multipart(base_url('absences/admin/upload/absences')) ?>
        <p class="font-inter-semibold text-h2-small">Abwesenheiten hochladen</p>
        <input type="file" name="userUploadFile" class="rounded p-3 bg-slate-900 border-none focus:outline-none flex-1">
        <button type="submit" class="bg-blue-600 text-white text-body rounded py-3 p-3">
            Upload
        </button>
        <?= form_close() ?>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg text-white font-inter-medium">
        <?= form_open_multipart(base_url('absences/admin/upload/students')) ?>
        <p class="font-inter-semibold text-h2-small">Schülerdaten hochladen</p>
        <input type="file" name="userUploadFile" class="rounded p-3 bg-slate-900 border-none focus:outline-none flex-1">
        <button type="submit" class="bg-blue-600 text-white text-body rounded py-3 p-3">
            Upload
        </button>
        <?= form_close() ?>
    </div>
</main>