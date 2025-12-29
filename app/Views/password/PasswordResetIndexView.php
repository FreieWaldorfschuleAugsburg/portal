<div class="row">
    <div class="text-center">
        <h1><?= lang('password.reset.headline') ?></h1>
    </div>

    <p>
        <?= lang('password.reset.text') ?>
    </p>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <div class="d-grid gap-2">
                    <a class="btn btn-primary btn-lg" href="<?= base_url('reset_password/email') ?>">
                        <i class="fas fa-envelope fa-2x mb-2"></i><br>
                        <b><?= lang('password.reset.method.email.headline') ?></b><br>
                        <small><?= lang('password.reset.method.email.description') ?></small>
                    </a>
                    <a class="btn btn-primary btn-lg" href="<?= base_url('reset_password/teacher') ?>">
                        <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i><br>
                        <b><?= lang('password.reset.method.teacher.headline') ?></b><br>
                        <small><?= lang('password.reset.method.teacher.description') ?></small>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>