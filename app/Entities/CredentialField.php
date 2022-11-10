<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CredentialField extends Entity
{

    public string|int|bool|array|null|object|\Ramsey\Uuid\UuidInterface|float|\CodeIgniter\I18n\Time $field_id;
    /**
     * @var array|bool|\CodeIgniter\I18n\Time|float|int|mixed|object|string|null
     */
    public mixed $field_name;
    /**
     * @var array|bool|\CodeIgniter\I18n\Time|float|int|mixed|object|string|null
     */
    public mixed $field_value;
    public string|int|bool|array|null|object|float|\CodeIgniter\I18n\Time $credential_id;
}