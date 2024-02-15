<?php

namespace App\Models;

use App\Entities\AbsenceGrade;
use App\Entities\AbsenceGroup;
use CodeIgniter\Model;

class AbsenceGroupModel extends Model
{
    protected $table = 'portal_absences_groups';
    protected $primaryKey = "id";
    protected $returnType = AbsenceGroup::class;

    protected $allowedFields = [
        'name'
    ];
}