<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class JudgmentSummaryOld extends Entity
{
    protected $db;
    protected $table      = 'judgment_summary_old';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'summary', 'is_deleted', 'updated_by', 'updated_on', 'updated_by_ip', 'is_verified', 'verified_by', 'verified_on', 'verified_by_ip', 'orderdate', 'create_modify'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}