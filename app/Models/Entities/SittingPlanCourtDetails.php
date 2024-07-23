<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SittingPlanCourtDetails extends Entity
{
    protected $db;
    protected $table      = 'master.sitting_plan_court_details';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'sitting_plan_details_id', 'court_number', 'board_type', 'if_special_bench', 'header_remark', 'footer_remark', 'mainhead', 'bench_start_time', 'if_in_printed', 'usercode', 'updated_on', 'display', 'roster_id_misc', 'roster_id_regular', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}