<?php

namespace App\Controllers;

use App\Models\AuthException;
use Aspera\Spreadsheet\XLSX\Reader;
use Aspera\Spreadsheet\XLSX\ReaderConfiguration;
use CodeIgniter\HTTP\RedirectResponse;
use DateTime;
use Exception;
use function App\Helpers\getImportKeys;
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
    public function table(): string
    {
        return $this->render('absences/AbsencesTableView');
    }

    /**
     * @throws AuthException
     */
    public function tablePrint(): string
    {
        return $this->render('absences/AbsencesTablePrintView', ['grades' => $this->request->getPost('grade')], false);
    }

    /**
     * @throws AuthException
     */
    public function admin(): string
    {
        return $this->render('absences/AbsencesAdminView');
    }

    /**
     */
    public function absent(): RedirectResponse
    {
        $studentId = $this->request->getPost('studentId');
        $now = new DateTime();
        insertAbsence($studentId, $now, session('DISPLAYNAME'), $now, ';; Von ' . session('DISPLAYNAME') . ' um ' . $now->format('H:i') . ' fehlend gemeldet. !! Diese Absenz ist vom Schulbüro noch nicht bearbeitet worden !!');

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
     * @throws Exception
     */
    public function uploadAbsences(): RedirectResponse
    {
        $filePath = storeFile($this->request);
        if (!str_ends_with($filePath, '.xlsx')) {
            return redirect('absences/admin')->with('error', 'Hochgeladene Datei ist keine XLSX.');
        }

        $config = new ReaderConfiguration();
        $config->setForceDateFormat('d.m.Y');
        $reader = new Reader($config);
        $reader->open($filePath);

        $firstRow = $reader->current();
        if ($firstRow[1] != 'Personen_ID' ||
            $firstRow[2] != 'Fehlt_Datum' ||
            $firstRow[6] != 'Bemerkung') {
            return redirect('absences/admin')->with('error', 'Hochgeladene Daten ungültig.');
        }

        // Delete all absences
        removeAllAbsences();

        $count = 0;
        foreach ($reader as $absence) {
            if ($reader->key() <= 1) continue;

            $studentId = intval($absence[1]);
            $student = getStudent($studentId);
            if (is_null($student)) {
                return redirect('absences/admin')->with('error', 'Schüler mit der Nummer #' . $studentId . ' nicht bekannt! Bitte den aktuellen Schülerdatensatz hochladen.');
            }

            $absenceDate = DateTime::createFromFormat('d.m.Y', $absence[2]);
            $note = $absence[6];

            // Insert absences from uploaded .csv
            insertAbsence($studentId, $absenceDate, "Import", new DateTime(), $note);
            $count++;
        }

        $reader->close();

        return redirect('absences/admin')->with('success', $count . ' Datensätze importiert');
    }

    /**
     * @throws Exception
     */
    public function uploadStudents(): RedirectResponse
    {
        $filePath = storeFile($this->request);
        if (!str_ends_with($filePath, '.xlsx')) {
            return redirect('absences/admin')->with('error', 'Hochgeladene Datei ist keine XLSX.');
        }

        $reader = new Reader();
        $reader->open($filePath);

        $firstRow = $reader->current();
        if ($firstRow[0] != 'Personen_ID' ||
            $firstRow[7] != 'Vorname' ||
            $firstRow[5] != 'Nachname' ||
            $firstRow[47] != 'Klassenwert') {
            return redirect('absences/admin')->with('error', 'Hochgeladene Daten ungültig.');
        }

        // Delete all absences and students
        removeAllAbsences();
        removeAllStudents();

        // Insert students from uploaded .csv
        $count = 0;
        foreach ($reader as $student) {
            if ($reader->key() <= 1) continue;

            $id = intval($student[0]);
            $firstName = $student[7];
            $lastName = $student[5];
            $gradeId = intval($student[47]);
            insertStudent($id, $firstName, $lastName, $gradeId);
            $count++;
        }

        $reader->close();

        return redirect('absences/admin')->with('success', $count . ' Datensätze importiert');
    }
}