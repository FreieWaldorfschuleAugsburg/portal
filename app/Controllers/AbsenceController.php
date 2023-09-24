<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\getImportKeys;
use function App\Helpers\readCsvToArray;
use function App\Helpers\storeFile;

class AbsenceController extends BaseController
{
    /**
     * @throws AuthException
     */
    public function index(): string
    {
        return $this->render('absences/AbsencesView');
    }

    /**
     * @throws AuthException
     */
    public function admin(): string
    {
        return $this->render('absences/AbsencesAdminView');
    }

    public function absent(): RedirectResponse
    {

    }

    /**
     * @throws AuthException
     */
    public function view(int $gradeId): string
    {
        return $this->render('absences/AbsencesGradeView', ['gradeId' => $gradeId]);
    }

    public function uploadAbsences(): RedirectResponse
    {
        $filePath = storeFile($this->request);
        $absences = readCsvToArray($filePath);

        foreach ($absences as $absence) {
            $studentId = $absence['Personen_ID'];
            $absenceDate = $absence['Fehlt_Datum'];
            $note = $absence['Bemerkung'];

        }

        return redirect('absences/admin');
    }

    public function uploadStudents(): RedirectResponse
    {
        $filePath = storeFile($this->request);
        $students = readCsvToArray($filePath);

        echo 'TOTAL: ' . count($students);
        foreach ($students as $student) {
            $id = intval($student['Personen_ID']);
            echo 'PID:' . $id . '<br><br>';

            $firstName = $student['Vorname'];
            $lastName = $student['Nachname'];
            $gradeId = intval($student['Klassenwert']);
            echo 'GRADE:' . $gradeId . '<br><br>';

            insertStudent($id, $firstName, $lastName, $gradeId);
        }

        return redirect('absences/admin');
    }
}