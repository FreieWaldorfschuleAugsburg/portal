<?php

namespace App\Models;

class EntryButtonModel
{
    public int $id;
    public string $name;
    public EntryButtonColor $color;
    public string $url;

    function __construct($id, $name, $color, $url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
        $this->url = $url;
    }
}