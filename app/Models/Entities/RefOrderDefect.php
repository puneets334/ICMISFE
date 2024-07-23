<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefOrderDefect extends Entity
{
    protected $db;
    protected $table      = 'master.ref_order_defect';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'code', 'description', 'adm_updated_by', 'updated_on', 'is_deleted', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}