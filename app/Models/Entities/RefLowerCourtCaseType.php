<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefLowerCourtCaseType extends Entity
{
    protected $db;
    protected $table      = 'master.ref_lower_court_case_type';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['lccasecode', 'lccasename', 'corttyp', 'display', 'type_sname', 'case_type', 'id', 'is_deleted', 'ref_agency_state_id', 'ref_agency_code_id', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}