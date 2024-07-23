<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TransferToDetails extends Entity
{
    protected $db;
    protected $table      = 'transfer_to_details';
    protected $primaryKey = 'transfer_to_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['transfer_to_id', 'lowerct_id', 'transfer_court', 'transfer_case_type', 'transfer_case_no', 'transfer_case_year', 'transfer_state', 'transfer_district', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}