<?php

namespace App\Models;

use App\Entities\Group;
use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table = 'portal_groups';
    protected $primaryKey = 'group_id';

    protected $allowedFields = [
        'group_id',
        'internal_name',
        'role_id'
    ];
    protected $returnType = Group::class;

}