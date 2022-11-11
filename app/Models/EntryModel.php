<?php

namespace App\Models;

use App\Entities\Entry;
use CodeIgniter\Model;
use Michalsn\Uuid\UuidModel;

class EntryModel extends Model
{
    protected $table = 'portal_entries';
    protected $primaryKey = 'entry_id';

    protected $allowedFields = [
        'entry_id',
        'entry_name',
        'entry_url',
        'entitled_role',
        'category_id',
        'entry_color_1',
        'entry_color_2'
    ];
    protected $useTimestamps = false;

    protected $returnType = Entry::class;

}