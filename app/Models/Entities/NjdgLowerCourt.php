<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NjdgLowerCourt extends Entity
{
    protected $db;
    protected $table      = 'njdg_lower_court';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['cino', 'diary_no', 'court_type_code', 'court_type_name', 'court_state_code', 'court_state_name', 'court_name', 'case_type_code', 'case_type_name', 'case_number', 'case_year', 'order_date', 'is_judgement_challenged', 'is_active', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}