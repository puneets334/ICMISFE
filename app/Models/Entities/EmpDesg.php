<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EmpDesg extends Entity
{
    
    protected $table      = 'emp_desg';
    // protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['desgcode', 'scale', 'oldscale', 'desgname', 'desgname1', 'payband', 'minpay', 'maxpay', 'gpay', 'ta', 'group', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}