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
                <?= lang('studentReset.headline') ?>
            </div>
            <div class="card-body text-center">

            </div>
        </div>
    </div>
</div>