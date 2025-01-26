<?php

use function App\Helpers\getAbsencesByDate;
use function App\Helpers\getCurrentUser;
use function App\Helpers\getGradeById;
use function App\Helpers\getStudent;

$absences = getAbsencesByDate(new DateTime());
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

<h2><b><u>Abwesenheitsliste vom <?= (new DateTime())->format('d.m.Y H:i') ?> Uhr</u></b></h2>
<b>Klasse:</b> <?= $group->getName() ?><br>
<b>Erstellt von:</b> <?= getCurrentUser()->displayName ?>

<hr>

<table>
    <tr>
        <th style="width: 40%">
            Schüler/in
        </th>
        <th>
            Bemerkung
        </th>
    </tr>
    <?php foreach ($absences as $absence): ?>
        <?php if ($absence->getReportedBy() != 'Import'): continue; endif; ?>
        <?php $student = getStudent($absence->getStudentId()); ?>
        <?php if ($student->getGradeId() != $group->getId()): continue; endif; ?>

        <tr>
            <td>
                <?= $student->getLastName() . ', ' . $student->getFirstName() ?>
            </td>
            <td>
                <?= $absence->getNote() ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

