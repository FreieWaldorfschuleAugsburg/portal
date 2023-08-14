<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5  text-white">

    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-big  text-white"><?= lang('role.headings.edit') ?></p>
    </div>


    <?= form_open(base_url('roles/edit/' . $role->role_id), 'class="font-inter-medium flex flex-col gap-3"') ?>
    <div class="flex flex-col gap-1">
        <label for="name" class="text-gray-400"><?= lang('entry.name') ?></label>
        <input type="text" name="name" id="name" value="<?= $role->role_name ?>"
               class="rounded p-2.5 lg:p-3 bg-slate-900  border-gray-700 focus:outline-none">
    </div>

    <div class="flex flex-col gap-1">
        <p class="text-gray-400"><?= lang('role.form.groups') ?></p>
        <section
                class="p-5 text-category bg-slate-900 border border-gray-700 rounded gap-1 h-72 overflow-scroll">

            <fieldset class="grid grid-cols-1 md:grid-cols-2 ">
                <?php foreach ($groups

                               as $group): ?>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="<?= $group ?>" name="group[]"
                               class="h-4 w-4 appearance-none rounded  bg-slate-900 focus:outline-none"
                               value="<?= $group ?>" <?php foreach ($role->groups as $role_group) {
                            if ($group === $role_group->internal_name) {
                                echo "checked=checked";
                            }
                        } ?>>
                        <label for="<?= $group ?>"
                               class="text-ellipsis overflow-hidden whitespace-nowrap"><?= $group ?></label></div>
                <?php endforeach; ?>
            </fieldset>
        </section>

    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
        <button type="submit" class="bg-red-600 rounded py-3 mt-3 text-white">
            <a href="<?= base_url('roles/delete') . "/" . $role->role_id ?>"
               class="bg-red-600 text-white rounded text-center">
                <?= lang('entry.button.delete') ?>
            </a>
        </button>
        <button type="submit" class="bg-blue-600 rounded py-3 mt-3 text-white">
            <?= lang('role.button.save') ?>
        </button>
    </div>
    <?= form_close() ?>


</main>