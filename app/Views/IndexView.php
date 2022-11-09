<header class="px-5 lg:px-60">
    <div class="bg-red-100 dark:bg-red-600/20 dark:text-red-300 rounded outline outline-red-600 outline-1 px-5 py-3 mt-3 font-inter-medium">
        <?= lang('app.tooltip.preview') ?>
    </div>

</header>
<div class="flex w-full px-5 lg:px-60 py-5 ">
    <section class="flex flex-col gap-1 w-full">
        <?php foreach ($entries

                       as $category): ?>

            <h1 class="font-inter-semibold text-h2-big dark:text-white"><?= $category->categoryName ?></h1>
            <section
                    class="w-full rounded-xl overflow-x-scroll gap-3 wrapper ">
                <?php foreach ($category->categoryItems as $entry): ?>
                    <a href="<?= $entry->entry_url ?>" target="_blank"
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
