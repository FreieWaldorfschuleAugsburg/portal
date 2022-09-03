<?php

namespace App\Models;

class UserModel
{
    public string $username;
    public string $displayName;
    public array $userGroups;
    public bool $admin;

    function __construct($username, $displayName, $userGroups, $admin)
    {
        $this->username = $username;
        $this->displayName = $displayName;
        $this->userGroups = $userGroups;
        $this->admin = $admin;
    }
}