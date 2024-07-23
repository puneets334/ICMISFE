<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EmpDetailsT extends Entity
{
    
    protected $table      = 'master.emp_details_t';
    
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['empid', 'name', 'fath_hus_name', 'relation', 'address', 'paddress', 'gender', 'dob', 'post', 'mobile', 'display', 'service', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
