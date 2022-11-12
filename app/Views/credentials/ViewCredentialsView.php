<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5  text-white">

    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-big  text-white"><?= $credentials->credential_name ?></p>
    </div>
    <?= form_open_multipart('') ?>

    <div class="flex flex-col gap-3">
        <section class="flex flex-col gap-2">
            <div class="w-full flex gap-2">
                <div class="flex flex-col gap-2 w-full" id="dynamicFields">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                        <?php foreach ($credentials->credential_fields as $credential_field): ?>
                            <div class="flex flex-col gap-1 w-full font-inter-medium">
                                <label for="field_name[]"
                                       class=" text-gray-400"><?= $credential_field->field_name ?></label>
                                <div class="flex gap-2 w-full">
                                    <p class="bg-slate-900 p-3 rounded truncate flex-1" id="fieldValue"><?= $credential_field->field_value ?></p>
                                    <button type="button" id="copyValue" class="bg-blue-600 p-3 rounded text-white "><?= lang('buttons.copy') ?></button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </section>


    </div>
    </form>


</main>

<script src="<?= base_url('assets/js/DynamicFields.js') ?>" defer>
</script>




