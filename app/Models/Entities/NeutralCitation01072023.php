<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NeutralCitation01072023 extends Entity
{
    protected $db;
    protected $table      = 'neutral_citation_01072023';
    //protected $primaryKey = 'id';
    //protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['national_code', 'case_type', 'type_name', 'ci_cr', 'short_name', 'relief_type', 'relief_code', 'type_of_jurisdiction', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}