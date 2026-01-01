<div class="row">
    <div class="text-center">
        <h1><?= lang('studentManagement.headline') ?></h1>
    </div>

    <div class="col-lg-12">
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <table class="table table-striped table-bordered"
                       data-locale="<?= service('request')->getLocale(); ?>"
                       data-toolbar="#toolbar" data-toggle="table" data-search="true" data-height="800"
                       data-pagination="true"
                       data-page-size="50" data-show-columns="true" data-cookie="true" data-cookie-id-table="students"
                       data-search-highlight="true" data-show-columns-toggle-all="true">
                    <thead>
                    <tr>
                        <th data-field="username" data-sortable="true"
                            scope="col"><?= lang('studentManagement.username') ?></th>
                        <th data-field="name" data-sortable="true"
                            scope="col"><?= lang('studentManagement.name') ?></th>
                        <th data-field="actions" data-sortable="true"
                            scope="col"><?= lang('studentManagement.actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($students as $student) : ?>
                        <tr data-id="<?= $student['samaccountname'][0] ?>">
                            <td><?= $student['samaccountname'][0] ?></td>
                            <td><?= $student['cn'][0] ?></td>
                            <td>
                                <a class="btn btn-danger btn-sm"
                                   href="<?= base_url('students/') . $student['samaccountname'][0] . '/password_reset' ?>">
                                    <i class="fas fa-key"></i> <?= lang('studentManagement.passwordReset') ?>
                                </a>
                                <?php if ($student['lockouttime'][0] ?? 0 > 0) : ?>
                                    <a class="btn btn-success btn-sm"
                                       href="<?= base_url('students/') . $student['samaccountname'][0] . '/unlock' ?>">
                                        <i class="fas fa-lock-open"></i> <?= lang('studentManagement.unlock') ?>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>