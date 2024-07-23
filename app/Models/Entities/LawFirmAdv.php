<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class LawFirmAdv extends Entity
{
    protected $db;
    protected $table      = 'law_firm_adv';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'law_firm_id', 'enroll_no', 'enroll_yr', 'state_id', 'from_date', 'to_date', 'display', 'entry_date', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}