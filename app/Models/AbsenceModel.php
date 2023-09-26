<?php

namespace App\Models;

use App\Entities\Absence;
use CodeIgniter\Model;

class AbsenceModel extends Model
{
    protected $table = 'portal_absences';
    protected $primaryKey = "id";
    protected $returnType = Absence::class;

    protected $allowedFields = [
        'student_id', 'absence_date', 'reported_by', 'reported_at', 'note'
    ];
}