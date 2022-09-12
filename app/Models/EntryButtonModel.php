<?php

namespace App\Models;

class EntryButtonModel
{
    public int $id;
    public string $name;
    public EntryButtonColor $color;
    /** @var GroupModel[] */
    public array $entitledGroups;
    public string $url;

    function __construct($id, $name, $color, $entitledGroups, $url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
        $this->entitledGroups = $entitledGroups;
        $this->url = $url;
    }
}