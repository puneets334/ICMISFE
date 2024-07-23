<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefPilActionTaken extends Entity
{
    protected $db;
    protected $table      = 'master.ref_pil_action_taken';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'action_code', 'pil_sub_action_code', 'sub_action_description', 'is_deleted', 'adm_updated_by', 'updated_on', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}