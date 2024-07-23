<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class LowerctJudgesA extends Entity
{
    protected $db;
    protected $table      = 'lowerct_judges_a';
    // protected $primaryKey = 'true';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'lowerct_id', 'judge_id', 'lct_display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}