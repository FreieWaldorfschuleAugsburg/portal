<div class="row mt-3 justify-content-center">
    <div class="col-lg-12">
        <?= isset($error) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('index.error') . '</b> ' . $error . '</div>' : '' ?>
        <?= !empty(session('error')) ? '<div class="alert alert-danger mb-3"> <i class="fas fa-exclamation-triangle"></i> <b>' . lang('index.error') . '</b> ' . session('error') . '</div>' : '' ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card mt-3 mb-3">
            <div class="card-header">
                <?= lang('profile.headline') ?>
            </div>
            <div class="card-body">
                <?= form_open_multipart('profile') ?>

                <div class="input-group row mb-3">
                    <label for="inputUsername" class="col-form-label col-md-4 col-lg-3">Benutzername</label>
                    <div class="col-md-8 col-lg-9">
                        <input class="form-control" id="inputUsername" name="username"
                               value="<?= $user->getUsername() ?>" required disabled>
                    </div>
                </div>

                <div class="input-group row mb-3">
                    <label id="inputName" class="col-form-label col-md-4 col-lg-3">Vor- und Nachname</label>
                    <div class="col-md-8 col-lg-9">
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control" id="inputFirstName" name="firstName" autocomplete="name"
                                       placeholder="Vorname(n)" value="<?= $user->getFirstName() ?>"
                                       aria-labelledby="inputName"
                                       required disabled>
                            </div>
                            <div class="col-6">
                                <input class="form-control" id="inputLastName" name="lastName" autocomplete="name"
                                       placeholder="Nachname" value="<?= $user->getLastName() ?>"
                                       aria-labelledby="inputName"
                                       required disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="input-group row mb-3">
                    <label for="inputEmail" class="col-form-label col-md-4 col-lg-3">E-Mail</label>
                    <div class="col-md-8 col-lg-9">
                        <input type="email" class="form-control" id="inputEmail" name="email" autocomplete="email"
                               placeholder="E-Mail" value="<?= $user->getEmail() ?>" required disabled>
                    </div>
                </div>

                <button class="btn btn-primary btn-block" type="submit">Speichern</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>