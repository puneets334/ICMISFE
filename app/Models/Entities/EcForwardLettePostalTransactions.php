<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EcForwardLettePostalTransactions extends Entity
{
    
    protected $table      = 'ec_forward_letter_postal_transactions';
    // protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['transactions_id', 'image_id', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}