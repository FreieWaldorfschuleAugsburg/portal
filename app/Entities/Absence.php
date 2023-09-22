<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use DateTime;

class Absence extends Entity
{
    protected $attributes = [
        'id' => null,
        'student_id' => null,
        'missing_date' => null,
        'reported_by' => null,
        'reported_at' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'student_id' => 'integer',
        'missing_date' => 'date',
        'reported_by' => 'string',
        'reported_at' => 'datetime',
    ];

    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->attributes['id'];
    }

    /**
     * @return ?int
     */
    public function getStudentId(): ?int
    {
        return $this->attributes['student_id'];
    }

    /**
     * @return DateTime
     */
    public function getMissingDate(): DateTime
    {
        return $this->attributes['missing_date'];
    }

    /**
     * @return string
     */
    public function getReportedBy(): string
    {
        return $this->attributes['reported_by'];
    }

    /**
     * @return DateTime
     */
    public function getReportedAt(): DateTime
    {
        return $this->attributes['reported_at'];
    }
}