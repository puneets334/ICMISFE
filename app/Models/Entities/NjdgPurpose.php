<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NjdgPurpose extends Entity
{
    protected $db;
    protected $table      = 'njdg_purpose';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['purpose_code', 'purpose_name', 'national_code', 'short_name', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}