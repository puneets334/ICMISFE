<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EefiledCasesTransferStatus extends Entity
{
    
    protected $table      = 'efiled_cases_transfer_status';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'diary_no', 'updated_by', 'updated_on', 'updated_by_ip', 'diary_update_by', 'diary_update_on', 'party_update_by', 'party_update_on', 'create_modify'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}