<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EcPostalDispatchTransactions extends Entity
{
    
    protected $table      = 'ec_postal_dispatch_transactions';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'ec_postal_dispatch_id', 'ref_letter_status_id', 'remarks', 'usercode', 'updated_on', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}