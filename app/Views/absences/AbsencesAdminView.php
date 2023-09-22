<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h1-small text-white">Abwesenheiten</p>
        <?php if (session('ABSENCE_ADMIN')): ?>
            <a href="<?= base_url('absences') ?>" class="font-inter-medium text-white bg-blue-600 rounded">
                <button class="p-3">Zurück</button>
            </a>
        <?php endif; ?>
    </div>
</main>