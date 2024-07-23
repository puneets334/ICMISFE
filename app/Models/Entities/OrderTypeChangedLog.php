<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class OrderTypeChangedLog extends Entity
{
    protected $db;
    protected $table      = 'order_type_changed_log';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'tbl_name', 'tbl_id', 'user_id', 'ent_dt', 'order_type', 'modified_by', 'modified_date', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}