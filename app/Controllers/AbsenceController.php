<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\Database\Exceptions\DataException;
use ReflectionException;
use function App\Helpers\getAllRoles;
use function App\Helpers\getUserRoles;
use Ramsey\Uuid\Uuid;

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
    public function view(int $gradeId): string
    {
        return $this->render('absences/AbsencesGradeView', ['gradeId' => $gradeId]);
    }
}