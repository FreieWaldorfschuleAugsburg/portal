<?php

use App\Models\CredentialFieldType;

?>
<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 text-white">

    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-big text-white"><?= lang('credential.headings.edit') ?></p>
    </div>


    <?= form_open_multipart('') ?>

    <div class="flex flex-col gap-3">
        <section class="flex flex-col gap-3 ">
            <div class="flex flex-col gap-1 text-gray-400 font-inter-medium">
                <label for="name" class=""><?= lang('credential.fields.title') ?></label>
                <input type="text" name="name" id="name" value="<?= $credentials->credential_name ?>"
                       class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none">
            </div>

            <div class="flex items-center gap-2 font-inter-medium text-gray-400">
                <input type="checkbox" id="show_on_home" name="show_on_home" value="true"
                       class="h-4 w-4 appearance-none rounded bg-slate-900 focus:outline-none focus:bg-gray-900" <?= $credentials->show_on_home ? 'checked' : '' ?>
                <label for="show_on_home"
                       class="text-ellipsis overflow-hidden whitespace-nowrap ">Auf dem Startbildschirm anzeigen</label>
            </div>


            <div class="w-full flex gap-2 font-inter-medium">
                <div class="flex flex-col gap-2 w-full" id="dynamicFields">
                    <div class="grid grid-cols-2 gap-3" id="credentialInputFieldText" style="display: none">
                        <div class="flex flex-col gap-1 w-full">
                            <label for="field_name[]"
                                   class="font-inter-medium text-gray-400"><?= lang('credential.fields.fieldname') ?></label>
                            <input type="text" name="template_field_name[]" id="template_field_name[]"
                                   class="rounded p-2.5 lg:p-3 bg-slate-900 border-none
                                   focus:outline-none">
                        </div>

                        <div class="flex flex-col gap-1 w-full font-inter-medium">
                            <label for="field_value[]"
                                   class=" text-gray-400"><?= lang('credential.fields.value') ?></label>
                            <div class="flex flex-col lg:flex-row gap-3 w-full">
                                <input type="text" name="template_field_value[]" id="template_field_value[]"
                                       class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none flex-1">
                                <button type="button" id="removeField"
                                        class="p-3 bg-red-600 rounded removeField"><?= lang('buttons.remove') ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3" id="credentialInputFieldFile" style="display: none">
                        <div class="flex flex-col gap-1 w-full">
                            <label for="field_name[]"
                                   class="font-inter-medium text-gray-400"><?= lang('credential.fields.fieldname') ?></label>
                            <input type="text" name="template_field_name[]" id="template_field_name[]"
                                   class="rounded p-2.5 lg:p-3 bg-slate-900 border-none
                                   focus:outline-none">
                        </div>

                        <div class="flex flex-col gap-1 w-full font-inter-medium">
                            <label for="field_value[]"
                                   class=" text-gray-400"><?= lang('credential.fields.value') ?></label>
                            <div class="flex flex-col lg:flex-row gap-3 w-full">
                                <input type="file" name="template_field_value[]" id="template_field_value[]"
                                       class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none flex-1">
                                <button type="button" id="removeField"
                                        class="p-3 bg-red-600 rounded removeField"><?= lang('buttons.remove') ?></button>
                            </div>
                        </div>
                    </div>


                    <?php foreach ($credentials->credential_fields as $credential_field): ?>
                        <?php if ($credential_field->field_type == CredentialFieldType::text->value): ?>
                            <div class="grid grid-cols-2 gap-3">
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
                        <?php elseif ($credential_field->field_type == CredentialFieldType::file->value) : ?>
                            <div class="grid grid-cols-2 gap-3">
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
                                        <input type="file" name="field_value[]" id="field_value[]"
                                               class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none flex-1">
                                        <button type="button" id="removeField"
                                                class="p-3 bg-red-600 rounded removeField"><?= lang('buttons.remove') ?></button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

            </div>

            <button class="bg-blue-600 text-white p-3 rounded font-inter-medium flex-grow" id="addTextField"
                    type="button">
                <?= lang('buttons.add.text') ?>
            </button>
            <button class="bg-blue-600 text-white p-3 rounded font-inter-medium flex-grow" id="addFileField"
                    type="button">
                <?= lang('buttons.add.file') ?>
            </button>
            <div class="flex flex-col gap-1 text-gray-400 font-inter-medium">
                <label for="role" class=""><?= lang('entry.role') ?></label>
                <select name="role" id="role"
                        class=" p-2.5 lg:p-3 select rounded w-full bg-slate-900 border-none appearance-non focus:outline-none">
                    <option class="rounded p-2.5 lg:p-3" value="">
                        Alle
                    </option>
                    <?php foreach ($roles

                                   as $role): ?>
                        <option class="rounded p-2.5 lg:p-3"
                                value="<?= $role->role_id ?>" <?= $credentials->role_id === $role->role_id ? 'selected' : '' ?>>
                            <?= $role->role_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex flex-col gap-1 text-gray-400 font-inter-medium">
                <label for="documentation" class=""><?= lang('credential.fields.documentation') ?></label>
                <input type="text" name="documentation" id="documentation"
                       value="<?= $credentials->documentation_url ?>"
                       class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none">
            </div>

        </section>
        <button type="submit" class="bg-blue-600 text-white text-body font-inter-medium rounded py-3">
            <?= lang('entry.button.save') ?>
        </button>

        <a href="<?= base_url('credentials/delete/' . $credentials->credential_id) ?>"
           class="bg-red-600 text-white text-body font-inter-medium rounded py-3 text-center">
            <?= lang('entry.button.delete') ?>
        </a>


    </div>
    </form>


</main>

<script src="<?= base_url('assets/js/DynamicFields.js') ?>" defer>
</script>




