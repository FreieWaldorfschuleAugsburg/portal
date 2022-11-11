<?php

namespace App\Models;


use App\Entities\CredentialField;
use CodeIgniter\Model;

class CredentialFieldModel extends Model
{
    protected $table = 'portal_credentials_custom_fields';
    protected $primaryKey = 'field_id';
    protected $returnType = CredentialField::class;
    protected $allowedFields = [
        'field_id', 'field_name', 'field_value', 'credential_id'
    ];
}
