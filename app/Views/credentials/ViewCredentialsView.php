<?php

use App\Models\CredentialFieldType;

?>
<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5  text-white">

    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-big  text-white"><?= $credentials->credential_name ?></p>
    </div>
    <?= form_open_multipart('') ?>

    <div class="flex flex-col gap-3">
        <section class="flex flex-col gap-2">
            <div class="w-full flex gap-2">
                <div class="flex flex-col gap-2 w-full" id="dynamicFields">
                    <div class="grid grid-cols-1 lg:grid-cols-1 gap-3">
                        <?php foreach ($credentials->credential_fields as $credential_field): ?>
                            <div class="flex flex-col gap-1 w-full font-inter-medium">
                                <label for="field_name[]"
                                       class=" text-gray-400"><?= $credential_field->field_name ?></label>
                                <div class="flex gap-2 w-full">
                                    <?php if ($credential_field->field_type == CredentialFieldType::text->value): ?>
                                        <p class="bg-slate-900 p-3 rounded truncate flex-1"
                                           id="fieldValue"><?= $credential_field->field_value ?></p>
                                        <button type="button" id="copyValue"
                                                class="bg-blue-600 p-3 rounded text-white"><?= lang('buttons.copy') ?></button>
                                    <?php elseif ($credential_field->field_type == CredentialFieldType::file->value): ?>
                                        <a type="button"
                                           class="bg-blue-600 p-3 rounded text-white"
                                           href="<?=base_url("uploads/$credential_field->field_id.png")?>"><?= lang('buttons.download') ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </section>


    </div>
    </form>

    <?php if ($credentials->documentation_url): ?>
        <div class="flex gap-5 items-center">
            <p class="font-inter-semibold text-h2-big  text-white"><?= lang('credential.headings.documentation') ?></p>
        </div>

        <div class="flex gap-5 items-center">
            <a href="<?= $credentials->documentation_url ?>" target="_blank"><p
                        class="font-inter-medium bg-blue-600 p-3 rounded text-white"><?= lang('credential.button.documentation') ?></p>
            </a>
        </div>
    <?php endif; ?>

</main>

<script src="<?= base_url('assets/js/DynamicFields.js') ?>" defer>
</script>




