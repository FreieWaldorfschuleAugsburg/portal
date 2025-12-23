<?php

use function App\Helpers\user;

?>
<div class="row">
    <div class="text-center">
        <h1><?= sprintf(lang('index.welcome'), user()->getDisplayName()) ?> </h1>
    </div>

    <div class="col-lg-12">
        <div class="card mt-3 mb-3">
            <div class="card-header">
                <?= lang('index.actions') ?>
            </div>
            <div class="card-body text-center">
                <div class="d-grid gap-2">
                    <a class="btn btn-primary btn-lg" href="<?= base_url('profile') ?>">
                        <i class="fas fa-user-cog fa-2x mb-2"></i><br>
                        Profil bearbeiten
                    </a>
                    <a class="btn btn-primary btn-lg" href="<?= base_url('change_password') ?>">
                        <i class="fas fa-key fa-2x mb-2"></i><br>
                        Passwort ändern
                    </a>
                    <a class="btn btn-primary btn-lg" href="<?= base_url('student_reset') ?>">
                        <i class="fas fa-user-graduate fa-2x mb-2"></i><br>
                        Schülerzugang zurücksetzen
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>