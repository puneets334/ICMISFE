<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SingleJudgeAdvancedDropNote extends Entity
{
    protected $db;
    protected $table      = 'single_judge_advanced_drop_note';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'cl_date', 'from_dt', 'to_dt', 'clno', 'diary_no', 'nrs', 'usercode', 'ent_dt', 'display', 'mf', 'update_time', 'update_user', 'so_user', 'so_time', 'part', 'board_type', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}