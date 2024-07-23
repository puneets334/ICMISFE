<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SittingPlanDetails extends Entity
{
    protected $db;
    protected $table      = 'master.sitting_plan_details';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'next_dt', 'if_finalized', 'no_of_times_modified_before_finalization', 'no_of_times_modified_after_finalization', 'if_roster_generated_misc', 'if_roster_generated_regular', 'user_ip', 'display', 'usercode', 'updated_on', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}