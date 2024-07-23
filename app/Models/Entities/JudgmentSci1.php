<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class JudgmentSci1 extends Entity
{
    protected $db;
    protected $table      = 'judgment_sci1';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'diary_year', 'c_type', 'c_no', 'c_yr', 'dated', 'file_path', 'file_type', 'judgment_on', 'judge1', 'judge2', 'judge3', 'judge4', 'judge5', 'if_reportable', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}