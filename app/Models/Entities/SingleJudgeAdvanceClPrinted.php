<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SingleJudgeAdvanceClPrinted extends Entity
{
    protected $db;
    protected $table      = 'single_judge_advance_cl_printed';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'from_dt', 'to_dt', 'weekly_no', 'weekly_year', 'usercode', 'ent_time', 'is_active', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}