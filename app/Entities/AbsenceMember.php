<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AbsenceMember extends Entity
{
    protected $attributes = [
        'id' => null,
        'student_id' => null,
        'group_id' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'student_id' => 'integer',
        'group_id' => 'string',
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    /**
     * @return int
     */
    public function getStudentId(): int
    {
        return $this->attributes['student_id'];
    }

    /**
     * @return string
     */
    public function getGroupId(): string
    {
        return $this->attributes['group_id'];
    }
}