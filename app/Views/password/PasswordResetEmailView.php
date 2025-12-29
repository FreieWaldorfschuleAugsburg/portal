<div class="row">
    <div class="text-center">
        <h1><?= lang('password.reset.headline') ?></h1>
        <h4><?= lang('password.reset.method.email.headline') ?></h4>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 mb-3">
        <a class="btn btn-primary" href="<?= base_url('reset_password') ?>">
            <i class="fas fa-arrow-left"></i> <?= lang('password.reset.back') ?>
        </a>
    </div>

    <p>
        <?= lang('password.reset.method.email.text') ?>
    </p>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?= form_open() ?>
                <div class="input-group row mb-3">
                    <label for="inputUsername" class="col-form-label col-md-4 col-lg-3">Dein Benutzername</label>
                    <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="inputUsername" name="username"
                               value="<?= old('username') ?>" autocomplete="username" placeholder="z. B. fwa1mamu" required>
                    </div>
                </div>

                <div class="input-group row mb-3">
                    <label for="inputEmail" class="col-form-label col-md-4 col-lg-3">E-Mail-Adresse</label>
                    <div class="col-md-8 col-lg-9">
                        <input type="email" class="form-control" id="inputEmail" name="email"
                               value="<?= old('email') ?>" autocomplete="email" placeholder="privat@beispiel.de"
                               aria-describedby="emailHelp" required>
                        <span id="emailHelp">Gib hier entweder deine eigene, oder die E-Mail-Adresse eines Erziehungsberechtigten an. Beachte bitte, dass die angegebene E-Mail-Adresse bei uns hinterlegt sein muss.</span>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Passwort zurücksetzen</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>