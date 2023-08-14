<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5  text-white">

    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-big text-white"><?= lang('entry.headings.edit') ?></p>
    </div>


    <?= form_open_multipart('') ?>

    <section class="font-inter-medium flex flex-col gap-3">

        <div class="flex flex-col gap-1  text-gray-400  font-inter-medium">
            <label for="name" class=""><?= lang('entry.name') ?></label>
            <input type="text" name="name" id="name" value="<?= $entry->entry_name ?>"
                   class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none">
        </div>

        <div class="flex flex-col gap-1  text-gray-400  font-inter-medium">
            <label for="url" class="text-gray-400"><?= lang('entry.url') ?></label>
            <input type="text" name="url" id="url" value="<?= $entry->entry_url ?>"
                   class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none">
        </div>

        <div class="flex flex-col gap-1  text-gray-400 font-inter-medium">
            <label for="category" class="text-gray-400"><?= lang('entry.category') ?></label>
            <div class="flex gap-2">
                <select name="category" id="category"
                        class=" p-2.5 lg:p-3 select rounded w-full flex-1 bg-slate-900 border-none focus:outline-none">
                    <?php foreach ($categories

                                   as $category): ?>
                        <option class="rounded p-2.5 lg:p-3" value="<?= $category->category_id ?>"  <?= $entry->category_id === $category->category_id ? 'selected' : '' ?>>

                            <?= $category->category_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="flex flex-col gap-2" id="category_input_container">
                    <div id="category_input_template" class="flex gap-2">
                        <input type="text" name="category_input[]" id="category_input[]" hidden placeholder="Name eingeben..."
                               class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none flex-1">
                        <button class="bg-blue-600 rounded p-3 text-white" id="addCategory"
                                type="button"><?= lang('buttons.add.default') ?></button>
                        <button type="button" id="removeCategory" hidden
                                class="p-3 bg-red-600 rounded removeField"><?= lang('buttons.remove') ?></button>

                    </div>
                </div>
            </div>
        </div>


        <div class="flex flex-col gap-1  text-gray-400 font-inter-medium">
            <label for="role" class="text-gray-400"><?= lang('entry.role') ?></label>
            <select name="role" id="role"
                    class=" p-2.5 lg:p-3 select rounded w-full bg-slate-900 border-none appearance-non focus:outline-none">
                <option class="rounded p-2.5 lg:p-3" value=""
                        selected="<?= $entry->role_id === null ? 'selected' : '' ?>">
                    Alle
                </option>
                <?php foreach ($roles

                               as $role): ?>
                    <option class="rounded p-2.5 lg:p-3" value="<?= $role->role_id ?>">
                        <?= $entry->role_id === $role->role_id ? 'selected' : '' ?>
                        <?= $role->role_name ?>
                    </option>
                <?php endforeach; ?>
            </select>


        </div>

        <section>
            <p class=" text-gray-400   font-inter-medium">Thumbnail</p>

            <div class=" bg-slate-900 rounded p-3 grid grid-cols-2 place-items-center gap-3">

                <div class="flex items-center gap-3">
                    <label for="color1" class="text-gray-400"><?= lang('entry.color.1') ?></label>
                    <input type="color" name="color1" id="color1" value="<?= $entry->entry_color_1 ?>"
                           class=" rounded-full w-8 h-8 bg-transparent border-none appearance-none">
                </div>

                <div class="flex items-center gap-3">
                    <label for="color2" class="text-gray-400"><?= lang('entry.color.2') ?></label>
                    <input type="color" name="color2" id="color2" value="<?= $entry->entry_color_2 ?>"
                           class=" rounded-full w-8 h-8 bg-transparent border-none appearance-none">
                </div>

                <div class="col-span-2 rounded bg-dark w-full flex gap-5 items-center justify-center p-3">
                    <div>
                        <img class="w-12 h-12" src="<?= base_url("uploads/$entry->entry_id.png") ?>" alt="">
                    </div>

                    <label class=" text-gray-400 flex flex-col justify-center items-center" for="image">
                        <img src="<?= base_url('assets') ?>img/upload.png" class="w-10" alt="">
                        <span class="font-inter-regular text-category"><?= lang('entry.image.label') ?></span>
                        <input id="image" name="image" class="hidden" type="file">
                    </label>

                </div>


            </div>


        </section>

        <section class="flex flex-col gap-3">
            <button type="submit" class="bg-blue-600 text-white rounded py-5">
                <?= lang('entry.button.save') ?>
            </button>

            <a href="<?= base_url('entries/delete') . "/" . $entry->entry_id ?>"
               class="bg-red-600 text-white rounded py-5 text-center">
                <?= lang('entry.button.delete') ?>
            </a>

        </section>


    </section>
    </form>

</main>
<script src="<?= base_url('assets/js/Category.js') ?>" defer></script>