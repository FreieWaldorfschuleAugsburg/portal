<?php

namespace App\Models;

class EntryModel
{
    public int $id;
    public string $name;
    public string $description;
    /** @var GroupModel[] */
    public array $entitledGroups;
    /** @var EntryButtonModel[] */
    public array $buttons;

    function __construct($id, $name, $description, $entitledGroups, $buttons)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->entitledGroups = $entitledGroups;
        $this->buttons = $buttons;
    }
}