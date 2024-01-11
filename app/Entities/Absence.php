<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use DateTime;

class Absence extends Entity
{
    protected $attributes = [
        'id' => null,
        'student_id' => null,
        'absence_date' => null,
        'reported_by' => null,
        'reported_at' => null,
        'note' => null
    ];

    protected $casts = [
        'id' => 'integer',
        'student_id' => 'integer',
        'absence_date' => 'string',
        'reported_by' => 'string',
        'reported_at' => 'string',
        'note' => 'string'
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

    public function setStudentId(int $studentId): void
    {
        $this->attributes['student_id'] = $studentId;
    }

    /**
     * @return DateTime
     */
    public function getAbsenceDate(): DateTime
    {
        return DateTime::createFromFormat('Y-m-d', $this->attributes['absence_date']);
    }

    public function setAbsenceDate(DateTime $absenceDate): void
    {
        $this->attributes['absence_date'] = $absenceDate->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function getReportedBy(): string
    {
        return $this->attributes['reported_by'];
    }

    public function setReportedBy(string $reportedBy): void
    {
        $this->attributes['reported_by'] = $reportedBy;
    }

    /**
     * @return DateTime
     */
    public function getReportedAt(): DateTime
    {
        return DateTime::createFromFormat('Y-m-d H:i:s', $this->attributes['reported_at']);
    }

    public function setReportedAt(DateTime $reportedAt): void
    {
        $this->attributes['reported_at'] = $reportedAt->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->attributes['note'];
    }

    public function setNote(string $note): void
    {
        $this->attributes['note'] = $note;
    }

    public function isSystem(): bool
    {
        return str_contains($this->getNote(), ';;');
    }

    public function isHalfDay(): bool
    {
        $lowercaseKeywords = mb_strtolower(getenv('absence.halfDayKeywords'));
        $lowercaseNote = mb_strtolower($this->getNote());
        $keywords = explode(',', $lowercaseKeywords);

        foreach ($keywords as $keyword) {
            if (str_contains($lowercaseNote, $keyword)) {
                return true;
            }
        }

        return false;
    }
}