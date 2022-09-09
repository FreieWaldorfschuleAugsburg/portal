<?php

namespace App\Models;

class GroupModel
{
    public int $id;
    public string $name;
    public string $internalName;
    public bool $admin;

    function __construct($id, $name, $internalName, $admin)
    {
        $this->id = $id;
        $this->name = $name;
        $this->internalName = $internalName;
        $this->admin = $admin;
    }
}