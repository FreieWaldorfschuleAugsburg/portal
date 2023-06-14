<?php

namespace App\Models;

enum CredentialFieldType: string
{
    case text = 'text';
    case file = 'file';
}