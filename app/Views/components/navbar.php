<div class="px-5 lg:px-60 py-3 dark:text-white dark:bg-slate-900 bg-neutral-100">
    <div class="flex w-full  justify-between items-center">
        <div class="flex items-center gap-3">
            <a  href="<?= base_url() ?>" class="dark:text-white font-inter-semibold text-h1-small"><?= lang('app.name.short') ?></a>
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
            <div class="items-center justify-center p-0.5 ">
                <img class="h-8 w-auto" src="<?= base_url() ?>/assets/img/menu.png" alt="">
            </div>
        </div>

    </div>
</div>

<div class="hidden px-5 bg-neutral-100 lg:px-60 pb-5 dark:bg-gray-900" id="navbar">
    <ul class=" dark:text-gray-300 font-inter-medium flex flex-col gap-2 ">
        <li class="rounded p-1.5">
            <a href="<?= base_url() ?>">Home</a>
        </li>
        <li class="rounded p-1.5">
            <a href="<?= base_url('entries') ?>">Einträge</a>
        </li>
        <li class="rounded p-1.5">
            <a href="<?= base_url('roles') ?>">Rollen</a>
        </li>

        <li class="rounded p-1.5">
            <a href="<?= base_url('credentials') ?>">Zugangsdaten</a>
        </li>
        <li class="rounded p-2.5 bg-blue-600 rounded text-center text-white">
            <a href="<?= base_url('logout') ?>">Ausloggen</a>
        </li>


    </ul>


</div>







