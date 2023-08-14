<section class="px-5 text-white flex flex-col justify-center items-center">


    <div class="w-full sm:w-4/6 lg:w-6/12">
        <div class="pt-16">
            <div class="flex flex-col justify-center items-center">
                <p class="font-inter-semibold text-h2-big leading-8 text-center lg:text-h1-small"><?= lang('login.title') ?></p>
                <span class="font-inter-regular text-category leading-8 text-center">Oder <a
                            class="text-center text-indigo-400" href="<?= base_url() ?>">kehren Sie zurück</a></span>
            </div>

            <div class="p-2 flex justify-center rounded bg-red-800/50 border border-red-500 <?= is_null(session('error')) ? "hidden" : '' ?>">
                <div class="text-center">
                    <p class="font-inter-semibold">Fehler</p>
                    <p><?= lang('login.error.' . session('error')) ?></p>
                </div>

            </div>
            <?= form_open('', 'class="px-5 py-8 bg-gray-900 border border-gray-700 rounded-lg mt-5 space-y-5"') ?>
            <div class="flex flex-col gap-1">
                <label class="font-inter-medium text-gray-300 text-category lg:text-body"
                       for="username"><?= lang('login.username') ?></label>
                <input class="rounded p-1.5 lg:p-3 bg-transparent border-gray-300 border border-gray-600 outline-none focus:outline-none"
                       type="text"
                       name="username"
                       id="username">
            </div>
            <div class="flex flex-col gap-1 font-inter-medium">
                <label class="font-inter-medium text-gray-300 text-category lg:text-body"
                       for="password"><?= lang('login.password') ?></label>
                <input class="rounded p-1.5 lg:p-3 bg-transparent border-gray-300 border border-gray-600 outline-none focus:outline-none"
                       type="password"
                       name="password"
                       id="password">
            </div>

            <div class="flex flex-col">
                <button type="submit"
                        class="bg-blue-600 text-white p-2.5 lg:p-4 rounded font-inter-regular"><?= lang('login.button') ?></button>
            </div>


            <?= form_close() ?>

        </div>
    </div>

</section>


