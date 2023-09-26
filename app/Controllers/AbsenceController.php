<?php

namespace App\Controllers;

use App\Models\AuthException;
use Aspera\Spreadsheet\XLSX\Reader;
use Aspera\Spreadsheet\XLSX\ReaderConfiguration;
use CodeIgniter\HTTP\RedirectResponse;
use DateTime;
use function App\Helpers\getCurrentUser;
use function App\Helpers\getImportKeys;
use function App\Helpers\readCsvToArray;
use function App\Helpers\storeFile;
use function Symfony\Component\Translation\t;

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

    /**
     * @throws AuthException
     */
    public function absent(): RedirectResponse
    {
        $studentId = $this->request->getPost('studentId');
        $now = new DateTime();
        insertAbsence($studentId, $now, session('DISPLAYNAME'), $now, '');

        return redirect()->to(previous_url());
    }

    /**
     * @throws AuthException
     */
    public function view(int $gradeId): string
    {
        return $this->render('absences/AbsencesGradeView', ['gradeId' => $gradeId]);
    }

    /**
     * @throws \Exception
     */
    public function uploadAbsences(): RedirectResponse
    {
        $filePath = storeFile($this->request);
        $config = new ReaderConfiguration();
        $config->setForceDateFormat('d.m.Y');
        $reader = new Reader($config);
        $reader->open($filePath);

        // Delete all absences
        removeAllAbsences();

        foreach ($reader as $absence) {
            if ($reader->key() <= 1) continue;

            $studentId = intval($absence[1]);
            $absenceDate = DateTime::createFromFormat('d.m.Y', $absence[2]);
            $note = $absence[6];

            // Insert absences from uploaded .csv
            insertAbsence($studentId, $absenceDate, "Import", new DateTime(), $note);
        }

        $reader->close();

        return redirect('absences/admin');
    }

    /**
     * @throws \Exception
     */
    public function uploadStudents(): RedirectResponse
    {
        $filePath = storeFile($this->request);
        $reader = new Reader();
        $reader->open($filePath);

        // Delete all students
        removeAllStudents();

        // Insert students from uploaded .csv
        foreach ($reader as $student) {
            if ($reader->key() <= 1) continue;

            $id = intval($student[0]);
            $firstName = $student[7];
            $lastName = $student[5];
            $gradeId = intval($student[47]);
            insertStudent($id, $firstName, $lastName, $gradeId);
        }

        $reader->close();

        return redirect('absences/admin');
    }
}