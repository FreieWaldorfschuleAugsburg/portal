<main class="px-5 xl:px-24 2xl:px-60 space-y-3 mt-5 min-h-screen">
    <div class="flex gap-5 items-center">
        <p class="font-inter-semibold text-h1-small text-white"><?= ($grade = getGradeById($gradeId))->getName() ?></p>
        <a href="<?= base_url('absences') ?>" class="font-inter-medium text-white bg-blue-600 rounded">
            <button class="p-3">Zurück</button>
        </a>
    </div>

    <?php
    $absences = getAbsencesByDate(new DateTime());
    if (count($absences) > 0): ?>
        <p class="text-white">Anwesende Schüler sind grün, halbtags entschuldigte oder verspätete orange und ganztags
            entschuldigte rot hinterlegt. Nähere Informationen entnehmen Sie dem ggf. angezeigten Mitteilungsfeld.<br>Sofern
            ein Schüler <u>zu Beginn</u> einer Unterrichtsstunde nicht anwesend ist, können Sie durch Drücken der roten
            Schaltfläche "Abwesend" den fehlenden Schüler dem Schulbüro melden.<br>Vom Schulbüro werden dann alle
            notwendigen Schritte veranlasst!
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-5">
            <?php foreach (getStudents($gradeId) as $student): ?>
                <?php if ($absence = getAbsence($absences, $student->getId())): ?>
                    <?php if (str_starts_with($absence->getNote(), ';;')): ?>
                        <div class="bg-orange-600 text-white font-inter-regular px-5 py-3 rounded-lg flex justify-between">
                            <div class="flex flex-col items-start gap-1">
                                <div class="w-52 mt-3 mb-5">
                                    <p class="text-h2-small text-ellipsis overflow-hidden whitespace-nowrap mb-2"><?= $student->getLastName() . ", " . $student->getFirstName() ?></p>
                                    <p class="bg-blue-600/50 text-white p-1.5 px-3 text-xs rounded font-inter-regular bg-blue-400">
                                        <?= substr($absence->getNote(), 3) ?>
                                    </p>
                                </div>
                            </div>

                            <?php if (!session('ABSENCE_READ')): ?>
                                <?= form_open('absences/absent', ["onsubmit" => "return confirm('Möchten Sie " . $student->getFirstName() . " " . $student->getLastName() . " abwesend melden?');"]) ?>
                                <?= form_hidden('studentId', $student->getId()); ?>
                                <button type="submit"
                                        class="text-category text-white text-center bg-red-600 mt-3 p-3 rounded">
                                    Abwesend
                                </button>
                                <?= form_close() ?>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="bg-red-600 text-white font-inter-regular px-5 py-3 rounded-lg flex justify-between">
                            <div>
                                <div class="flex flex-col items-start gap-1">
                                    <div class="w-52 mt-3 mb-5">
                                        <p class="text-h2-small text-ellipsis overflow-hidden whitespace-nowrap mb-2"><?= $student->getLastName() . ", " . $student->getFirstName() ?></p>
                                        <?php if (!empty($absence->getNote())): ?>
                                            <p class="bg-blue-600/50 text-white p-1.5 px-3 text-xs rounded font-inter-regular bg-blue-400">
                                                <?= $absence->getNote() ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="bg-green-600 text-white font-inter-regular px-5 py-3 rounded-lg flex justify-between">
                        <div>
                            <div class="flex flex-col items-start gap-1">
                                <div class="w-52 mt-3 mb-5">
                                    <p class="text-h2-small text-ellipsis overflow-hidden whitespace-nowrap"><?= $student->getLastName() . ", " . $student->getFirstName() ?></p>
                                </div>
                            </div>
                        </div>

                        <?php if (!session('ABSENCE_READ')): ?>
                            <?= form_open('absences/absent', ["onsubmit" => "return confirm('Möchten Sie " . $student->getFirstName() . " " . $student->getLastName() . " abwesend melden?');"]) ?>
                            <?= form_hidden('studentId', $student->getId()); ?>
                            <button type="submit"
                                    class="text-category text-white text-center bg-red-600 mt-3 p-3 rounded">
                                Abwesend
                            </button>
                            <?= form_close() ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center">
            <p class="text-h2-big text-white">Für heute wurden noch keine Abwesenheiten eingestellt. <br>Bitte versuchen
                Sie es später erneut!</p>
        </div>
    <?php endif; ?>
</main>