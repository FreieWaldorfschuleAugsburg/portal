<style>
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    table, th, td {
        border: 1px solid black;
    }
</style>

<?php

use function App\Helpers\countStudents;
use function App\Helpers\getAbsence;
use function App\Helpers\getAbsencesByDate;
use function App\Helpers\getAllStudents;
use function App\Helpers\getCurrentUser;
use function App\Helpers\getGradeById;
use function App\Helpers\getStudent;

$absences = getAbsencesByDate(new DateTime());
$studentCount = countStudents();
if (count($absences) > 0): ?>
    <p class="text-h2-small text-white"><b>Anwesende Schüler am <?= (new DateTime())->format('d.m.Y') ?></b></p>
    <p class="text-white">Erstellt von <?= getCurrentUser()->displayName ?>
        um <?= (new DateTime())->format('H:i') ?></p><br>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400 mb-5">
            <thead class="bg-white dark:bg-gray-800">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Schüler/in
                </th>
                <th scope="col" class="px-6 py-3">
                    Klasse
                </th>
                <th scope="col" class="px-6 py-3">
                    Unterschrift Schüler/in
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (getAllStudents() as $student): ?>
                <?php if (!in_array($student->getGradeId(), $grades)): continue; endif; ?>
                <?php if (getAbsence($absences, $student->getId())): continue; endif; ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        <?= $student->getFirstName() . ' ' . $student->getLastName() ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= getGradeById($student->getGradeId())->getName() ?>
                    </td>
                    <td>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="text-center">
        <p class="text-h2-big text-white">Für heute wurden noch keine Abwesenheiten eingestellt. <br>Bitte versuchen
            Sie es später erneut!</p>
    </div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        window.onafterprint = () => {
            window.location.href = "/absences/table";
        }

        window.print();
    });
</script>
