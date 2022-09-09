<?php

namespace App\Models;

class UserModel
{
    public string $username;
    public string $displayName;
    /** @var GroupModel[] */
    public array $groups;

    function __construct($username, $displayName, $groups)
    {
        $this->username = $username;
        $this->displayName = $displayName;
        $this->groups = $groups;
    }

    public function isAdmin(): bool
    {
        foreach ($this->groups as $group) {
            if ($group->admin)
                return true;
        }

        return false;
    }
}