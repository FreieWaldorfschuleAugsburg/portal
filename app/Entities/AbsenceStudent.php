<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AbsenceStudent extends Entity
{
    protected $attributes = [
        'id' => null,
        'first_name' => null,
        'last_name' => null,
        'grade_id' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'grade_id' => 'integer',
    ];

    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->attributes['id'];
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->attributes['first_name'];
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->attributes['last_name'];
    }

    /**
     * @return ?int
     */
    public function getGradeId(): ?int
    {
        return $this->attributes['grade_id'];
    }
}