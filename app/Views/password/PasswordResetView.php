<div class="row">
    <div class="text-center">
        <h1><?= lang('password.reset.headline') ?></h1>
    </div>

    <p>
        <?= lang('password.reset.text') ?>
    </p>

    <div class="col-lg-12">
        <div class="card mt-3 mb-3">
            <div class="card-header">
                <i class="fas fa-code-branch"></i> <?= lang('password.reset.cardHeadline') ?>
            </div>
            <div class="card-body text-center">
                <div class="d-grid gap-2">
                    <a class="btn btn-primary btn-lg" href="<?= base_url('reset_password/email') ?>">
                        <i class="fas fa-envelope fa-2x mb-2"></i><br>
                        <b><?= lang('password.reset.method.email.headline') ?></b><br>
                        <small><?= lang('password.reset.method.email.description') ?></small>
                    </a>
                    <a class="btn btn-primary btn-lg" href="<?= base_url('reset_password/parent_email') ?>">
                        <i class="fas fa-square-envelope fa-2x mb-2"></i><br>
                        <b><?= lang('password.reset.method.parentEmail.headline') ?></b><br>
                        <small><?= lang('password.reset.method.parentEmail.description') ?></small>
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