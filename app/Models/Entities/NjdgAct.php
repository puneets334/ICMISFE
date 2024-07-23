<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NjdgAct extends Entity
{
    protected $db;
    protected $table      = 'njdg_act';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['diary_no', 'nc_act_code_1', 'acts', 'nc_act_name_1', 'section_1', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];
    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}