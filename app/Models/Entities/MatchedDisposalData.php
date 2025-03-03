<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MatchedDisposalData extends Entity
{
    protected $db;
    protected $table      = 'matched_disposal_data';

    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['case_type', 'case_number', 'case_year', 'date_of_decision', 'diary_no', 'disp_dt', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
