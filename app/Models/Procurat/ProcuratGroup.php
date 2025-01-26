<?php

namespace App\Models\Procurat;

class ProcuratGroup
{
    private int $id;
    private string $name;

    function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    function getId(): string
    {
        return $this->id;
    }

    function getName(): string
    {
        return $this->name;
    }
}