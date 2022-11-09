<?php

namespace App\Models;

use App\Entities\Role;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class RoleModel extends Model
{
    protected $table = 'portal_roles';
    protected $primaryKey = 'role_id';
    protected $returnType = Role::class;
    protected $allowedFields = [
        'role_id',
        'role_name'
    ];

}