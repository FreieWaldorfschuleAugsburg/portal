<?php

namespace App\Models;


use App\Entities\Credentials;
use CodeIgniter\Model;

class CredentialModel extends Model
{
    protected $table = 'portal_credentials';
    protected $primaryKey = 'credential_id';
    protected $returnType = Credentials::class;
    protected $allowedFields = [
        'credential_id', 'credential_name', 'role_id', 'show_on_home', 'documentation_url'
    ];


}
