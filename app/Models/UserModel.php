<?php

namespace App\Models;

class UserModel
{
    private string $username;
    private string $email;
    private string $firstName;
    private string $lastName;
    private string $idToken;
    private string $refreshToken;
    private array $groups;

    function __construct($username, $email, $firstName, $lastName, $idToken, $refreshToken, $groups)
    {
        $this->username = $username;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->idToken = $idToken;
        $this->refreshToken = $refreshToken;
        $this->groups = $groups;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getDisplayName(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getIdToken(): string
    {
        return $this->idToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }
}