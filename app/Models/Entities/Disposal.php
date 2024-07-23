<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Disposal extends Entity
{
    
    protected $table      = 'disposal';
    protected $primaryKey = 'dispcode';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['dispcode', 'dispname', 'display', 'spk', 'sc_code', 'short_name', 'national_code', 'ndisposal_type_short', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
