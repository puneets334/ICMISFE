<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class VcRoomDetails extends Entity
{
    protected $db;
    protected $table      = 'vc_room_details';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'next_dt', 'roster_id', 'vc_url', 'display', 'created_by', 'created_on', 'updated_by', 'updated_on', 'item_numbers_csv', 'item_numbers', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}