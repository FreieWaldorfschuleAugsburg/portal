<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-small text-white">Abwesenheitsgruppe bearbeiten</p>
        <a href="<?= base_url('absences/admin/groups') ?>" class="font-inter-medium text-white bg-blue-600 rounded">
            <button class="p-3">Zurück</button>
        </a>
    </div>

    <?= form_open_multipart('') ?>

    <section class="font-inter-medium flex flex-col gap-3">

        <div class="flex flex-col gap-1  text-gray-400  font-inter-medium">
            <label for="name" class="">Name</label>
            <input type="text" name="name" id="name" value="<?= $group->getName() ?>"
                   class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none">
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg text-white font-inter-medium">
            <div class="boxes">
                <?php foreach (getAllStudents() as $student): ?>
                    <?php if (isAbsenceGroupMember($group->getId(), $student->getId())): ?>
                        <input id="student<?= $student->getId() ?>" name="student[]" value="<?= $student->getId() ?>"
                               type="checkbox" required checked>
                    <?php else: ?>
                        <input id="student<?= $student->getId() ?>" name="student[]" value="<?= $student->getId() ?>"
                               type="checkbox" required>
                    <?php endif; ?>

                    <label for="student<?= $student->getId() ?>"><?= $student->getLastName() . ', ' . $student->getFirstName() ?></label>
                    <br>
                <?php endforeach; ?>
            </div>
        </div>

    </section>
    <button type="submit" class="mt-3 bg-blue-600 text-white text-body font-inter-semibold rounded py-5">
        <?= lang('entry.button.save') ?>
    </button>

    <?= form_close() ?>
</main>

<script>
    $(function () {
        const requiredCheckboxes = $(':checkbox[required]');
        requiredCheckboxes.change(function () {
            if (requiredCheckboxes.is(':checked')) {
                requiredCheckboxes.removeAttr('required');
            } else {
                requiredCheckboxes.attr('required', 'required');
            }
        });
    });
</script>
