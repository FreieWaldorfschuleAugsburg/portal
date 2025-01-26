<?php

use App\Entities\AbsenceStudent;
use function App\Helpers\getAbsence;
use function App\Helpers\getAbsencesByDate;
use function App\Helpers\getAllStudents;
use function App\Helpers\getCurrentUser;
use function App\Helpers\getGradeById;
use function App\Helpers\isAbsenceGroupMember;

$absences = getAbsencesByDate(new DateTime());

$students = getAllStudents();
usort($students, function (AbsenceStudent $a, AbsenceStudent $b) {
    return
        ($a->getGradeId() <=> $b->getGradeId()) * 1000 +
        ($a->getLastName() <=> $b->getLastName()) +
        ($a->getFirstName() <=> $b->getFirstName());
})
?>
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<h2><b><u>Anwesenheitsliste vom <?= (new DateTime())->format('d.m.Y H:i') ?> Uhr</u></b></h2>
<b>Klasse:</b> <?= $group->getName() ?><br>
<b>Erstellt von:</b> <?= getCurrentUser()->displayName ?>

<hr>

<small><b>Das Fälschen einer Unterschrift wird schwer geahndet!</b></small><br><br>

<table>
    <tr>
        <th style="width: 40%">
            Schüler/in
        </th>
        <th>
            Unterschrift Schüler/in
        </th>
    </tr>
    <?php foreach ($students as $student): ?>
        <?php if ($student->getGradeId() != $group->getId()): continue; endif; ?>
        <?php $absence = getAbsence($absences, $student->getId()) ?>
        <?php if ($absence && !$absence->isHalfDay() && !$absence->isSystem()): continue; endif; ?>
        <tr>
            <td>
                <b><?= $student->getLastName() . ', ' . $student->getFirstName() ?></b>
                <?php if ($absence): ?>
                    <br><span style="font-size: 10px">Bemerkung: <?= $absence->getNote() ?></span>
                <?php endif; ?>
            </td>
            <td>

            </td>
        </tr>
    <?php endforeach; ?>
</table>