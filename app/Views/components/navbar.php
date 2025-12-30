<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <img src="<?= base_url('/') ?>/assets/img/logo.png" width="30" height="30" class="d-inline-block align-top"
                 alt="">
            <?= lang('app.name.short') ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobileToggle"
                aria-controls="navbarMobileToggle" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMobileToggle">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
            <ul class="navbar-nav">
                <?php if (isset($user)): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> <?= $user->getDisplayName() ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="<?= base_url('profile') ?>">
                                    <i class="fas fa-user-cog"></i>&nbsp; <?= lang('navbar.profile') ?>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('change_password') ?>">
                                    <i class="fas fa-key"></i>&nbsp; <?= lang('navbar.changePassword') ?>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                    <i class="fas fa-sign-out-alt"></i>&nbsp; <?= lang('navbar.logout') ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('login') ?>">
                            <i class="fas fa-sign-in"></i> <?= lang('navbar.login') ?>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?= base_url('reset_password') ?>">
                            <i class="fas fa-question-circle"></i> <?= lang('navbar.resetPassword') ?>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($appName && $appUrl): ?>
                    <li>
                        <a class="nav-link" href="<?= $appUrl ?>">
                            <i class="fas fa-external-link"></i> <?= sprintf(lang('navbar.return'), $appName) ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container px-4 mt-4">
    <div class="row mt- 3justify-content-center">
        <div class="col-lg-12">
            <?php if (!empty(session('error'))): ?>
                <div class="alert alert-danger mb-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <b><?= lang('app.error.alert') ?></b> <?= session('error') ?>
                </div>
            <?php endif; ?>

            <?php if (!empty(session('success'))): ?>
                <div class="alert alert-danger mb-3">
                    <i class="fas fa-check-square"></i> <b> <?= session('success') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>