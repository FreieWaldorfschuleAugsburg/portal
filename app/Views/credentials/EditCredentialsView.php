<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 text-white">

    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-big text-white"><?= lang('credential.headings.edit') ?></p>
    </div>


    <?= form_open_multipart('') ?>

    <div class="flex flex-col gap-3">
        <section class="flex flex-col gap-2">
            <div class="flex flex-col gap-1 text-gray-400 font-inter-medium">
                <label for="name" class=""><?= lang('credential.fields.title') ?></label>
                <input type="text" name="name" id="name" value="<?= $credentials->credential_name ?>"
                       class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none">
            </div>


            <div class="w-full flex gap-2">
                <div class="flex flex-col gap-2 w-full" id="dynamicFields">
                    <?php foreach ($credentials->credential_fields as $credential_field): ?>
                        <div class="grid grid-cols-2 gap-3" id="credentialInputField">
                            <div class="flex flex-col gap-1 w-full">
                                <label for="field_name[]"
                                       class="font-inter-medium text-gray-400"><?= lang('credential.fields.fieldname') ?></label>
                                <input type="text" name="field_name[]" id="field_name[]"
                                       value="<?= $credential_field->field_name ?>"
                                       class="rounded p-2.5 lg:p-3 bg-slate-900 border-none
                                   focus:outline-none">
                            </div>

                            <div class="flex flex-col gap-1 w-full font-inter-medium">
                                <label for="field_value[]"
                                       class=" text-gray-400"><?= lang('credential.fields.value') ?></label>
                                <div class="flex flex-col lg:flex-row gap-3 w-full">
                                    <input type="text" name="field_value[]" id="field_value[]"
                                           value="<?= $credential_field->field_value ?>"
                                           class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none flex-1">
                                    <button type="button" id="removeField"
                                            class="p-3 bg-red-600 rounded removeField"><?= lang('buttons.remove') ?></button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

                <button class="bg-blue-600 text-white p-3 rounded font-inter-medium flex-grow" id="addField"
                        type="button">
                    <?= lang('buttons.add') ?>
                </button>
            <div class="flex flex-col gap-1 text-gray-400 font-inter-medium">
                <label for="role" class=""><?= lang('entry.role') ?></label>
                <select name="role" id="role"
                        class=" p-2.5 lg:p-3 select rounded w-full :bg-slate-900 border-none appearance-non focus:outline-none hover:bg-ye">
                    <option class="rounded p-2.5 lg:p-3" value="">
                        Alle
                    </option>
                    <?php foreach ($roles

                                   as $role): ?>
                        <option class="rounded  p-2.5 lg:p-3"
                                value="<?= $role->role_id ?>" <?= $credentials->role_id === $role->role_id ? 'selected' : '' ?>>
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

<script src="<?= base_url('assets/js/DynamicFields.js') ?>" defer>
</script>




