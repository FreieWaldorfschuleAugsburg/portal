<?php

namespace App\Controllers;

use App\Models\AuthException;
use Aspera\Spreadsheet\XLSX\Reader;
use Aspera\Spreadsheet\XLSX\ReaderConfiguration;
use CodeIgniter\HTTP\RedirectResponse;
use DateTime;
use Exception;
use Mpdf\Mpdf;
use Ramsey\Uuid\Uuid;
use function App\Helpers\deleteAbsenceGroup;
use function App\Helpers\getAbsenceGroupById;
use function App\Helpers\getGradeById;
use function App\Helpers\getStudent;
use function App\Helpers\insertAbsence;
use function App\Helpers\insertAbsenceGroup;
use function App\Helpers\insertStudent;
use function App\Helpers\removeAllAbsences;
use function App\Helpers\removeAllStudents;
use function App\Helpers\storeFile;
use function App\Helpers\updateAbsenceGroup;

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
    public function printGroupAbsence(string $groupId): RedirectResponse|string
    {
        $group = getAbsenceGroupById($groupId);
        if (!$group) {
            return redirect('absences')->with('error', 'Ungültige Gruppe.');
        }

        $mpdf = $this->createMPDF();
        $mpdf->WriteHTML(view('absences/print/AbsencesPrintGroupView', ['group' => $group]));
        $mpdf->Output();
        exit;
    }

    public function printGroupPresence(string $groupId): RedirectResponse|string
    {
        $group = getAbsenceGroupById($groupId);
        if (!$group) {
            return redirect('absences')->with('error', 'Ungültige Gruppe.');
        }

        $mpdf = $this->createMPDF();
        $mpdf->WriteHTML(view('absences/print/PresencePrintGroupView', ['group' => $group]));
        $mpdf->Output();
        exit;
    }

    /**
     * @throws AuthException
     */
    public function printGradeAbsence(int $gradeId): RedirectResponse|string
    {
        $grade = getGradeById($gradeId);
        if (!$grade) {
            return redirect('absences')->with('error', 'Ungültige Klasse.');
        }

        $mpdf = $this->createMPDF();
        $mpdf->WriteHTML(view('absences/print/AbsencesPrintGradeView', ['grade' => $grade]));
        $mpdf->Output();
        exit;
    }

    public function printGradePresence(int $gradeId): RedirectResponse|string
    {
        $grade = getGradeById($gradeId);
        if (!$grade) {
            return redirect('absences')->with('error', 'Ungültige Klasse.');
        }

        $mpdf = $this->createMPDF();
        $mpdf->WriteHTML(view('absences/print/PresencePrintGradeView', ['grade' => $grade]));
        $mpdf->Output();
        exit;
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
        $reportedBy = $this->request->getPost('reportedBy');
        $now = new DateTime();

        if (!$reportedBy) {
            $reportedBy = session('DISPLAYNAME');
        }

        insertAbsence($studentId, $now, $reportedBy, $now, ';; Von ' . $reportedBy . ' um ' . $now->format('H:i') . ' fehlend gemeldet. !! Diese Absenz ist vom Sekretariat noch nicht bearbeitet worden !!');

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
    public function uploadP4Absences(): RedirectResponse
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
                // Scrum everything if one entry is broken
                removeAllAbsences();
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
    public function uploadP5Absences(): RedirectResponse
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
        if ($firstRow[0] != 'Abwesenheitsdatum' ||
            $firstRow[1] != 'Person_ID' ||
            $firstRow[7] != 'Bemerkung') {
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
                // Scrum everything if one entry is broken
                removeAllAbsences();
                return redirect('absences/admin')->with('error', 'Schüler mit der Nummer #' . $studentId . ' nicht bekannt! Bitte den aktuellen Schülerdatensatz hochladen.');
            }

            $absenceDate = DateTime::createFromFormat('d.m.Y', $absence[0]);
            $note = $absence[7];

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

    /**
     * @throws Exception
     */
    public function groups(): string
    {
        return $this->render('absences/group/AbsencesGroupsView');
    }

    /**
     * @throws Exception
     */
    public function createGroup(): string
    {
        return $this->render('absences/group/AbsencesGroupCreateView');
    }

    /**
     * @throws Exception
     */
    public function storeGroup(): RedirectResponse
    {
        $id = Uuid::uuid4()->toString();
        $name = $this->request->getPost('name');
        $students = $this->request->getPost('student');

        insertAbsenceGroup($id, $name, $students);
        return redirect('absences/admin/groups');
    }

    /**
     * @throws Exception
     */
    public function editGroup(string $groupId): RedirectResponse|string
    {
        $group = getAbsenceGroupById($groupId);
        if (is_null($group)) {
            return redirect('absences/admin/groups')->with('error', 'Ungültige Abwesenheitsgruppe');
        }

        return $this->render('absences/group/AbsencesGroupEditView', ['group' => $group]);
    }

    /**
     * @throws Exception
     */
    public function updateGroup(string $groupId): RedirectResponse
    {
        $group = getAbsenceGroupById($groupId);
        if (is_null($group)) {
            return redirect('absences/admin/groups')->with('error', 'Ungültige Abwesenheitsgruppe');
        }

        $name = $this->request->getPost('name');
        $students = $this->request->getPost('student');

        updateAbsenceGroup($group->getId(), $name, $students);
        return redirect('absences/admin/groups');
    }

    /**
     * @throws Exception
     */
    public function deleteGroup(string $groupId): RedirectResponse
    {
        $group = getAbsenceGroupById($groupId);
        if (is_null($group)) {
            return redirect('absences/admin/groups')->with('error', 'Ungültige Abwesenheitsgruppe');
        }

        deleteAbsenceGroup($group->getId());
        return redirect('absences/admin/groups');
    }

    /**
     * @throws Exception
     */
    public function viewGroup(string $groupId): RedirectResponse|string
    {
        $group = getAbsenceGroupById($groupId);
        if (is_null($group)) {
            return redirect('/')->with('error', 'Ungültige Abwesenheitsgruppe');
        }

        return $this->render('absences/group/AbsencesGroupView', ['group' => $group]);
    }

    private function createMPDF(): Mpdf
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 19,
            'margin_right' => 19,
            'margin_top' => 14,
            'margin_bottom' => 45,
            'margin_header' => 19,
            'margin_footer' => 19,
            'orientation' => 'P']);
        $mpdf->setHTMLFooter(view('absences/print/PrintFooter'));
        return $mpdf;
    }
}