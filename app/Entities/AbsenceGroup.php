<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AbsenceGroup extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
    ];

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
    ];

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    public function setId(string $id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }
}