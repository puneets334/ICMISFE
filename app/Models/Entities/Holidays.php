<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Holidays extends Entity
{
    
    protected $table      = 'master.holidays';
    // protected $primaryKey = 'hf_id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['hdate', 'hname', 'emp_hol', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}