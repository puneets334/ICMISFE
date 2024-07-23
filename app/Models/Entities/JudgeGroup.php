<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class JudgeGroup extends Entity
{
    protected $db;
    protected $table      = 'judge_group';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'p1', 'p2', 'p3', 'from_dt', 'to_dt', 'display', 'fresh_limit', 'old_limit', 'ent_dt', 'usercode', 'to_dt_ent_dt', 'to_dt_usercode', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}