<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 dark:text-white">

    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-big dark:text-white"><?= lang('credential.headings.create') ?></p>
    </div>


    <?= form_open_multipart('') ?>

    <div class="flex flex-col gap-3">
        <section class="flex flex-col gap-2">
            <div class="flex flex-col gap-1 dark:text-gray-400 text-gray-700 font-inter-medium">
                <label for="name" class=""><?= lang('credential.fields.title') ?></label>
                <input type="text" name="name" id="name""
                       class="rounded p-2.5 lg:p-3 bg-neutral-100 dark:bg-slate-900 border-none focus:outline-none">
            </div>


            <div class="w-full flex gap-2">
                <div class="flex flex-col gap-2 w-full" id="dynamicFields">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col gap-1 w-full">
                            <label for="title"
                                   class="font-inter-medium text-gray-400"><?= lang('credential.fields.fieldname') ?></label>
                            <input type="text" name="field_name[]" id="field_name[]"
                                   class="rounded p-2.5 lg:p-3 bg-neutral-100 dark:bg-slate-900 border-none focus:outline-none">
                        </div>

                        <div class="flex flex-col gap-1 w-full">
                            <label for="title"
                                   class="font-inter-medium text-gray-400"><?= lang('credential.fields.value') ?></label>
                            <input type="text" name="field_value[]" id="field_value[]"
                                   class="rounded p-2.5 lg:p-3 bg-neutral-100 dark:bg-slate-900 border-none focus:outline-none">
                        </div>
                    </div>
                </div>

            </div>
            <div class="grid grid-cols-2 gap-3">
                <button class="bg-blue-600 text-white p-3 rounded font-inter-medium flex-grow" id="addField"
                        type="button">
                    Hinzufügen
                </button>
                <button class="bg-red-600 text-white p-3 rounded font-inter-medium" id="removeField" type="button">
                    Entfernen
                </button>
            </div>
            <div class="flex flex-col gap-1 dark:text-gray-400 text-gray-700 font-inter-medium">
                <label for="role" class=""><?= lang('entry.role') ?></label>
                <select name="role" id="role"
                        class=" p-2.5 lg:p-3 select rounded w-full bg-neutral-100 dark:bg-slate-900 border-none appearance-non focus:outline-none hover:bg-ye">
                    <option class="rounded p-2.5 lg:p-3" value="">
                        Alle
                    </option>
                    <?php foreach ($roles

                                   as $role): ?>
                        <option class="rounded  p-2.5 lg:p-3" value="<?= $role->role_id ?>">
                            <?= $role->role_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </section>
        <button type="submit" class="bg-blue-600 text-white text-body font-inter-medium rounded py-5">
            <?= lang('entry.button.save') ?>
        </button>

    </div>
    </form>


</main>

<script src="public/assets/js/DynamicFields.js" defer>
</script>




