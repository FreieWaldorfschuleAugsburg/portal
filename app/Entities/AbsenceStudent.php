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

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->attributes['first_name'];
    }

    public function setFirstName(string $firstName): void
    {
        $this->attributes['first_name'] = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->attributes['last_name'];
    }

    public function setLastName(string $lastName): void
    {
        $this->attributes['last_name'] = $lastName;
    }

    /**
     * @return ?int
     */
    public function getGradeId(): ?int
    {
        return $this->attributes['grade_id'];
    }

    public function setGradeId(int $gradeId): void
    {
        $this->attributes['grade_id'] = $gradeId;
    }
}