<?php


namespace App\Entities;

use CodeIgniter\Entity\Entity;
use Ramsey\Uuid\Uuid;

/**
 * @property \CodeIgniter\I18n\Time|mixed|\Ramsey\Uuid\UuidInterface|null $entry_id
 * @property array|\CodeIgniter\I18n\Time|mixed|null $entry_name
 * @property array|\CodeIgniter\I18n\Time|mixed|null $entry_url
 * @property array|\CodeIgniter\I18n\Time|mixed|null $entitled_role
 * @property array|\CodeIgniter\I18n\Time|mixed|null $category_id
 * @property array|\CodeIgniter\I18n\Time|mixed|null $entry_color_1
 * @property array|\CodeIgniter\I18n\Time|mixed|null $entry_color_2
 */
class Entry extends Entity
{
//    /**
//     */
//    public string $entry_id;
//    public string $entry_name;
//    public string $entry_url;
//    public string $entitled_role;
//    public string $category_id;

    /**
     * @var \CodeIgniter\Database\BaseResult|\CodeIgniter\I18n\Time|false|int|mixed|object|string|null
     */

    public function __construct(?array $data = null)
    {
        parent::__construct($data);
    }


//    public function createEntryId()
//    {
//        $this->entry_id = Uuid::uuid4();
//    }


}