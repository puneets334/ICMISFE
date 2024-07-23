<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class ListingPurpose extends Entity
{
    protected $db;
    protected $table      = 'listing_purpose';
    //protected $primaryKey = 'id';

    //protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['code', 'purpose', 'priority', 'displayable', 'display', 'transfer_pur', 'fx_wk', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}