<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SittingPlanJudgesLeaveDetails extends Entity
{
    protected $db;
    protected $table      = 'master.sitting_plan_judges_leave_details';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'next_dt', 'jcode', 'is_on_leave', 'usercode', 'updated_on', 'display', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}