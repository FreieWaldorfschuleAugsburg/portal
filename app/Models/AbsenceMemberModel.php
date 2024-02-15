<?php

namespace App\Models;

use App\Entities\AbsenceGrade;
use App\Entities\AbsenceGroup;
use App\Entities\AbsenceMember;
use CodeIgniter\Model;

class AbsenceMemberModel extends Model
{
    protected $table = 'portal_absences_members';
    protected $primaryKey = "id";
    protected $returnType = AbsenceMember::class;

    protected $allowedFields = [
        'student_id', 'group_id'
    ];
}