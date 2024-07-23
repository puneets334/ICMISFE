<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefDefectCode extends Entity
{
    protected $db;
    protected $table      = 'master.ref_defect_code';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'defect_code_main', 'description', 'adm_updated_by', 'updated_on', 'defect_code_sub', 'is_deleted', 'defect_code_display', 'other_info', 'description_display', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}