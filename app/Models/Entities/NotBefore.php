<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NotBefore extends Entity
{
    protected $db;
    protected $table      = 'not_before';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'j1', 'notbef', 'usercode', 'ent_dt', 'u_ip', 'u_mac', 'enterby', 'res_add', 'res_id', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}