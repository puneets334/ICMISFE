<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EcPostalTransactions extends Entity
{
    
    protected $table      = 'ec_postal_transactions';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'ec_postal_received_id', 'ec_postal_user_initiated_letter_id', 'dispatched_to_user_type', 'dispatched_to', 'dispatched_by', 'dispatched_on', 'action_taken', 'action_taken_on', 'action_taken_by', 'return_reason', 'last_updated_on', 'is_active', 'is_deleted', 'is_forwarded', 'letterpriority', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
