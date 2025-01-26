<?php

use function App\Helpers\getCurrentUser;
use function App\Helpers\getProcuratAbsencesByGroup;
use function App\Helpers\getProcuratPerson;

$absences = getProcuratAbsencesByGroup($group->getId());
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
<b>Gruppe/Klasse:</b> <?= $group->getName() ?><br>
<b>Erstellt von:</b> <?= getCurrentUser()->displayName ?>

<hr>

<table>
    <tr>
        <th style="width: 40%">
            Schüler/in
        </th>
        <!--<th>
            Klasse
        </th>-->
        <th>
            Bemerkung
        </th>
    </tr>
    <?php foreach ($absences as $absence): ?>
        <?php $student = getProcuratPerson($absence->getPersonId()); ?>

        <tr>
            <td>
                <?= $student->getLastName() . ', ' . $student->getFirstName() ?>
            </td>
            <!--<td>

            </td>-->
            <td>
                <?= $absence->getNote() ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>