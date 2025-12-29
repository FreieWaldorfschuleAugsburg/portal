<div class="row">
    <div class="text-center">
        <h1><?= lang('password.reset.headline') ?></h1>
    </div>
</div>

<div class="row">
    <p>
        <?= lang('password.reset.text') ?>
    </p>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?= form_open() ?>
                <?= form_hidden('token', $token) ?>

                <div class="input-group row mb-3">
                    <label for="inputNewPassword" class="col-form-label col-md-4 col-lg-3">Neues Passwort</label>
                    <div class="col-md-8 col-lg-9">
                        <input type="password" class="form-control" id="inputNewPassword" name="newPassword"
                               autocomplete="new-password" required>
                    </div>
                </div>
                <div class="input-group row mb-3">
                    <label for="inputNewPasswordConfirm" class="col-form-label col-md-4 col-lg-3">Neues Passwort
                        wiederholen</label>
                    <div class="col-md-8 col-lg-9">
                        <input type="password" class="form-control" id="inputNewPasswordConfirm" name="newPasswordConfirm"
                               autocomplete="new-password" required>
                    </div>
                </div>

                <button class="btn btn-primary btn-block" type="submit">Passwort ändern</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>