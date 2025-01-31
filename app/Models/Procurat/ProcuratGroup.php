<?php

namespace App\Models\Procurat;

use function App\Helpers\getGroupNameOverride;

class ProcuratGroup
{
    private int $id;
    private string $name;
    private string $type;
    private array $grades;
    private ?string $schoolYear;

    function __construct($id, $name, $type, $grades, $schoolYear)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->grades = $grades;
        $this->schoolYear = $schoolYear;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        $override = getGroupNameOverride($this->getId());
        return $override ?: $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getGrades(): array
    {
        return $this->grades;
    }

    /**
     * @return ?string
     */
    public function getSchoolYear(): ?string
    {
        return $this->schoolYear;
    }
}