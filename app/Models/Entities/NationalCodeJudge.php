<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NationalCodeJudge extends Entity
{
    protected $db;
    protected $table      = 'master.national_code_judge';
    //protected $primaryKey = 'id';
    //protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['judge_code', 'judge_name', 'short_judge_name', 'uid', 'judge_priority', 'desg_code', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}