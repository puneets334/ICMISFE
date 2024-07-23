<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class ScanMovementHistory extends Entity
{
    protected $db;
    protected $table      = 'scan_movement_history';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'scan_movement_id', 'dairy_no', 'list_dt', 'roster_id', 'item_no', 'movement_flag', 'event_type', 'user_id', 'ip_address', 'is_active', 'entry_date_time', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}