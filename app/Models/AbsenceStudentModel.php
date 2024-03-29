<?php

namespace App\Models;

use App\Entities\AbsenceStudent;
use CodeIgniter\Model;

class AbsenceStudentModel extends Model
{
    protected $table = 'portal_absences_students';
    protected $primaryKey = "id";
    protected $returnType = AbsenceStudent::class;

    protected $allowedFields = [
        'id', 'first_name', 'last_name', 'grade_id'
    ];
}