<div class="px-5 xl:px-24 2xl:px-60 py-3 text-white bg-slate-900">
    <div class="flex w-full  justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="<?= base_url('assets/img') ?>/waldorf_logo.png" class="w-10 animate-pulse" alt="">
            <a href="<?= base_url() ?>"
               class="text-white font-inter-semibold text-h1-small"><?= lang('app.name.short') ?></a>
        </div>

        <!--If not logged in-->
        <div class="flex flex-col <?= \App\Helpers\isLoggedIn() ? "hidden" : '' ?>">
            <div class="relative inline-flex items-center justify-center p-0.5 ">
                <a href="<?= base_url('login') ?>"
                   class="relative px-5 py-2.5 bg-blue-600 rounded-md font-inter-medium text-white "><?= lang('menu.self.login') ?></a>
            </div>

        </div>

        <!--    If logged in-->
        <div class="flex flex-col <?= !\App\Helpers\isLoggedIn() ? "hidden" : '' ?>" id="nav-button">
            <div class="items-center justify-center p-0.5 flex gap-5 cursor-pointer">
                <p class="text-body font-inter-medium "><?= session('DISPLAYNAME') ?></p>
                <img class="lg:hidden h-8 w-auto" src="<?= base_url() ?>/assets/img/menu.png" alt="">
                <a class="hidden rounded p-2.5 bg-blue-600 rounded text-center text-white font-inter-medium  <?= \App\Helpers\isLoggedIn() ? 'lg:flex' : '' ?>"
                   href="<?= base_url('logout') ?>">Abmelden</a>
            </div>
        </div>

    </div>
</div>

<div class="hidden justify-between items-center px-5  xl:px-24 2xl:px-60 bg-slate-900 pb-5 <?= \App\Helpers\isLoggedIn() ? 'lg:flex' : '' ?>" id="navbar">

    <ul class="text-gray-300 font-inter-medium flex flex-col lg:flex-row gap-2 justify-center">
        <li class="rounded p-1.5" <?=\App\Helpers\hideForNonAdmin()?>>
            <a href="<?= base_url('entries') ?>">Einträge</a>
        </li>
        <li class="rounded p-1.5" <?=\App\Helpers\hideForNonAdmin()?>>
            <a href="<?= base_url('roles') ?>">Rollen</a>
        </li>
        <li class="rounded p-1.5" <?=\App\Helpers\hideForNonAdmin()?>>
            <a href="<?= base_url('categories') ?>">Kategorien</a>
        </li>

        <li class="rounded p-1.5">
            <a href="<?= base_url('credentials') ?>">Zugangsdaten</a>
        </li>
        <li class="lg:hidden rounded p-2.5 bg-blue-600 rounded text-center text-white">
            <a href="<?= base_url('logout') ?>">Ausloggen</a>
        </li>


    </ul>


</div>


<style>

    .button {

    }


</style>





