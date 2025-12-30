<div class="row">
    <div class="text-center">
        <h1><?= lang('password.change.headline') ?> </h1>
    </div>

    <div class="col-lg-12">
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <?= form_open() ?>
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

                <button class="btn btn-primary btn-block" type="submit">Speichern</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>