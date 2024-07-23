<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SingleJudgeNominate extends Entity
{
    protected $db;
    protected $table      = 'master.single_judge_nominate';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'jcode', 'day_type', 'from_date', 'to_date', 'entry_date', 'usercode', 'is_active', 'updated_on', 'update_by', 'delete_reason', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}