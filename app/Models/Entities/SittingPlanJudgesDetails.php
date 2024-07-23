<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SittingPlanJudgesDetails extends Entity
{
    protected $db;
    protected $table      = 'master.sitting_plan_judges_details';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'sitting_plan_court_details_id', 'jcode', 'updated_on', 'usercode', 'display', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}