<?php


function createLinkCard($category, $title, $image_url, $color_1, $color_2)
{
    return '
    <section class="flex w-full items-center justify-center h-screen gap-5">
    <div class="flex w-40 h-48 md:w-80 md:h-36 rounded-xl link">
        <div class="text-white px-5 py-3 overflow-hidden break-all auto">
            <p class="text-category sm:text-category font-poppins-light text-white opacity-50"></p>
            <p class="text-h2-small md:text-h2-big tracking-wide font-poppins-medium leading-8"> MensaMax</p>
        </div>
    </div>
    </section>';
}