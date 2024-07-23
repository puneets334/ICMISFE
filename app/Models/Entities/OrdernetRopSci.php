<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class OrdernetRopSci extends Entity
{
    protected $db;
    protected $table      = 'ordernet_rop_sci';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'diary_year', 'c_type', 'c_no', 'c_yr', 'rop', 'file_path', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}