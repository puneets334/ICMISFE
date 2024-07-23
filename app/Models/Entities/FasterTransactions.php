<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FasterTransactions extends Entity
{
    
    protected $table      = 'faster_transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'ref_faster_steps_id', 'faster_cases_id', 'faster_shared_document_details_id', 'created_on', 'created_by', 'created_by_ip', 'is_deleted', 'verify_otp_id', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}