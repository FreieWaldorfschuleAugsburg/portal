<?php

namespace App\Models;

use App\Entities\AbsenceGrade;
use CodeIgniter\Model;

class AbsenceGradeModel extends Model
{
    protected $table = 'portal_absences_grades';
    protected $primaryKey = "id";
    protected $returnType = AbsenceGrade::class;

    protected $allowedFields = [
        'name'
    ];
}