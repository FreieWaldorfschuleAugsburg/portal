<?php if ($error = session('error')): ?>
    <div class="flex gap-3 bg-red-600 rounded-xl justify-between px-3 py-5 transition hover:scale-95 ease-in-out">
        <div>
            <div class="text-white r outline-1 flex flex-col flex-1">
                <a class="text-h4-small md:text-h4-big tracking-tight font-inter-semibold leading-6 md:leading-8 lg:leading-8"><?= $error ?></a>
            </div>
        </div>
    </div>
<?php endif; ?>

<header class="px-5 xl:px-24 2xl:px-60">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
        <?php foreach ($credentials

                       as $credential): ?>
            <div class="flex gap-3 bg-gradient-to-br from-[#0BAB64] to-[#3BB78F] rounded-xl justify-between px-3 py-5 transition hover:scale-95 ease-in-out">
                <div>
                    <div class=" text-white r outline-1 flex flex-col flex-1 ">
                        <p class="text-category sm:text-category font-inter-light text-white opacity-70 "><?= lang('flags.credentials.new') ?></p>
                        <a class="text-h2-small md:text-h2-big tracking-tight font-inter-semibold leading-6 md:leading-8 lg:leading-8"><?= $credential->credential_name ?></a>
                    </div>
                </div>
                <a class="bg-white bg-opacity-30 px-5 py-3 text-white text-center font-inter-medium rounded-xl flex items-center justify-center"
                   href="<?= base_url('credentials/' . $credential->credential_id) ?>"><p>Ansehen</p></a>
            </div>
        <?php endforeach; ?>
    </div>

</header>
<div class="flex w-full px-5 xl:px-24 2xl:px-60 py-5 ">
    <section class="flex flex-col gap-1 w-full">
        <?php foreach ($entries

                       as $category): ?>

            <h1 class="font-inter-semibold text-h2-big text-white"><?= $category->categoryName ?></h1>
            <section
                    class="w-full rounded-xl overflow-x-scroll gap-3 wrapper ">
                <?php foreach ($category->categoryItems as $entry): ?>
                    <a href="<?= $entry->entry_url ?>"
                       class="flex rounded-xl link-<?= $entry->entry_id ?> flex-shrink-0 transition hover:scale-95 ease-in-out shadow self-start ">
                        <div class="text-white px-3 py-3">
                            <p class="text-category sm:text-category font-inter-light text-white opacity-70 "><?= $entry->category_name ?></p>
                            <p class="text-h2-small md:text-h2-big tracking-tight font-inter-semibold leading-6 md:leading-8 lg:leading-8">
                                <?= $entry->entry_name ?></p>
                        </div>
                    </a>
                    <style>

                        .text-break {
                            word-break: break-all;
                            hyphens: auto;
                        }


                        @media (min-width: 768px) and (max-width: 1000px) {
                            .link-<?=$entry->entry_id?> {
                                background: url("<?=base_url("uploads/$entry->entry_id.png")?>") no-repeat 50px 0, linear-gradient(to bottom right,<?=$entry->entry_color_1?>,<?=$entry->entry_color_2?>);
                                background-blend-mode: luminosity;
                                background-size: 250px, cover;
                                height: 125px;
                            }

                            .wrapper {
                                display: grid;
                                grid-gap: 10px;
                                grid-template-columns: repeat(auto-fill, minmax(250px, 250px));
                            }

                        }

                        @media (min-width: 1000px) {
                            .link-<?=$entry->entry_id?> {
                                background: url("<?=base_url("uploads/$entry->entry_id.png")?>") no-repeat 150px 0, linear-gradient(to bottom right,<?=$entry->entry_color_1?>,<?=$entry->entry_color_2?>);
                                background-blend-mode: luminosity;
                                background-size: 250px, cover;
                                height: 145px;
                            }

                            .wrapper {
                                display: grid;
                                grid-gap: 10px;
                                grid-template-columns: repeat(auto-fill, minmax(300px, 300px));
                            }

                        }


                        @media (min-width: 300px) and (max-width: 768px) {
                            .link-<?=$entry->entry_id?> {
                                background: url("<?=base_url("uploads/$entry->entry_id.png")?>") no-repeat 0px 32px, linear-gradient(to bottom right,<?=$entry->entry_color_1?>,<?=$entry->entry_color_2?>);
                                background-blend-mode: luminosity;
                                background-size: 200px, cover;
                                width: 120px;
                                height: 145px;
                            }

                            .wrapper {
                                grid-auto-flow: column;
                                overflow-x: scroll;
                                display: grid;
                                grid-gap: 10px;
                                grid-template-columns: repeat(auto-fit, minmax(120px, 120px));
                                justify-items: start;
                            }
                        }
                    </style>
                <?php endforeach; ?>
            </section>
        <?php endforeach; ?>
    </section>
</div>
