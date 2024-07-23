<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SmsPool extends Entity
{
    protected $db;
    protected $table      = 'sms_pool';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'mobile', 'msg', 'table_name', 'c_status', 'ent_time', 'update_time', 'template_id', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}