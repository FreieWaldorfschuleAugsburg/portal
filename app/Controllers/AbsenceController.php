<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\HTTP\RedirectResponse;
use Mpdf\Mpdf;
use function App\Helpers\createAbsenceFollowUp;
use function App\Helpers\getProcuratGroup;

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

    public function printAbsence(string $groupId): RedirectResponse|string
    {
        $group = getProcuratGroup($groupId);
        if (!$group) {
            return redirect('absences')->with('error', 'Ungültige Gruppe.');
        }

        $mpdf = $this->createMPDF();
        $mpdf->WriteHTML(view('absences/print/AbsencesPrintView', ['group' => $group]));
        $mpdf->Output();
        exit;
    }

    public function printPresence(string $groupId): RedirectResponse|string
    {
        $group = getProcuratGroup($groupId);
        if (!$group) {
            return redirect('absences')->with('error', 'Ungültige Gruppe.');
        }

        $mpdf = $this->createMPDF();
        $mpdf->WriteHTML(view('absences/print/PresencePrintView', ['group' => $group]));
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
        $reportedBy = session('DISPLAYNAME');

        createAbsenceFollowUp($studentId, $reportedBy);

        return redirect()->to(previous_url());
    }

    /**
     * @throws AuthException
     */
    public function view(int $groupId): string
    {
        return $this->render('absences/AbsencesGroupView', ['groupId' => $groupId]);
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