<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MLimitationPeriod extends Entity
{
    protected $db;
    protected $table      = 'master.m_limitation_period';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'casetype_id', 'submaster_id', 'category_subcode', 'category_subcode1', 'category_subcode2', 'case_law', 'limitation', 'order_cof', 'display', 'from_date', 'to_date', 'order_by', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
