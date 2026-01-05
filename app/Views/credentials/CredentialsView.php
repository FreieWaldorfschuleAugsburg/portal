<div class="row justify-content-center">
    <div class="text-center">
        <h1><?= lang('credentials.headline') ?></h1>
    </div>

    <?php if ($threemaCredentials): ?>
        <div class="col-lg-8">
            <div class="card mt-3 mb-3">
                <div class="card-header">
                    <?= lang('credentials.threema') ?>
                </div>
                <div class="card-body">
                    <div class="input-group row mb-3">
                        <label for="inputUsername"
                               class="col-form-label col-md-4 col-lg-3"><?= lang('credentials.username') ?></label>
                        <div class="col-md-8 col-lg-9">
                            <input class="form-control" id="inputUsername" name="username"
                                   value="<?= $threemaCredentials->getUsername() ?>" required disabled>
                        </div>
                    </div>
                    <div class="input-group row mb-3">
                        <label for="inputPassword"
                               class="col-form-label col-md-4 col-lg-3"><?= lang('credentials.password') ?></label>
                        <div class="col-md-8 col-lg-9">
                            <input class="form-control" id="inputPassword" name="password"
                                   value="<?= $threemaCredentials->getPassword() ?>" required disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>