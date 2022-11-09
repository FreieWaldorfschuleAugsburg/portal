<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Role extends Entity
{
    protected string $role_id;
    protected string $role_name;
    protected array $groups;


}

