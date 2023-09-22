<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5  text-white">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h2-big text-white"><?= lang('entry.headings.create') ?></p>
    </div>

    <?= form_open_multipart('') ?>

    <div class="flex flex-col gap-3">
        <section class="flex flex-col gap-2">
            <div class="flex flex-col gap-1 text-gray-400 font-inter-medium">
                <label for="name" class=""><?= lang('entry.name') ?></label>
                <input type="text" name="name" id="name"
                       class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none">
            </div>

            <div class="flex flex-col gap-1  text-gray-400 font-inter-medium">
                <label for="url" class=""><?= lang('entry.url') ?></label>
                <input type="text" name="url" id="url"
                       class="rounded p-2.5 lg:p-3 bg-slate-900 border-none focus:outline-none">
            </div>

            <div class="flex flex-col gap-1  text-gray-400 font-inter-medium ">
                <label for="category" class=""><?= lang('entry.category') ?></label>
                <select name="category" id="category"
                        class=" p-2.5 lg:p-3 select rounded w-full   bg-slate-900 border-none focus:outline-none">
                    <?php foreach ($categories

                                   as $category): ?>
                        <option class="rounded p-2.5 lg:p-3" value="<?= $category->category_id ?>">
                            <?= $category->category_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex flex-col gap-1  text-gray-400  font-inter-medium">
                <label for="role"><?= lang('entry.role') ?></label>
                <select name="role" id="role"
                        class="p-2.5 lg:p-3 select rounded w-full bg-slate-900 border-none appearance-non focus:outline-none">
                    <option class="rounded p-2.5 lg:p-3" value="">
                        Alle
                    </option>
                    <?php foreach ($roles as $role): ?>
                        <option class="rounded  p-2.5 lg:p-3" value="<?= $role->role_id ?>">
                            <?= $role->role_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <section>
                <p class="text-gray-400  font-inter-medium">Thumbnail</p>
                <div class="bg-slate-900 rounded p-3 grid grid-cols-2 place-items-center gap-3">
                    <div class="flex items-center gap-3  text-gray-400  font-inter-medium">
                        <label for="color1" class=""><?= lang('entry.color.1') ?></label>
                        <input type="color" name="color1" id="color1"
                               class="rounded-full w-8 h-8 bg-transparent border-none appearance-none">
                    </div>

                    <div class="flex items-center gap-3 text-gray-400  font-inter-medium">
                        <label for="color2" class=""><?= lang('entry.color.2') ?></label>
                        <input type="color" name="color2" id="color2"
                               class="rounded-full w-8 h-8 bg-transparent border-none appearance-none">
                    </div>

                    <div class="col-span-2 rounded bg-dark w-full flex items-center justify-center p-3">
                        <label class="text-gray-400 flex flex-col justify-center items-center" for="image">
                            <img src="<?= base_url('assets/img/upload.png') ?>" class="w-10" alt="">
                            <span class="font-inter-regular text-category"><?= lang('entry.image.label') ?></span>
                            <input id="image" name="image" class="hidden" type="file" accept="image/png">
                        </label>
                    </div>
                </div>
            </section>
        </section>
        <button type="submit" class="bg-blue-600 text-white text-body font-inter-semibold rounded py-5">
            <?= lang('entry.button.save') ?>
        </button>
    </div>
    </form>
</main>