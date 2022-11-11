<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Group extends Entity
{
    protected string $group_id;
    protected string $internal_name;
    protected string $role_id;


    public function __construct(?array $data = null)
    {

        parent::__construct($data);
    }


}