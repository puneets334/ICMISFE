<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class HybridPhysicalHearingConsentFreeze extends Entity
{
    
    protected $table      = 'hybrid_physical_hearing_consent_freeze';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'list_type_id', 'list_number', 'list_year', 'user_id', 'entry_date', 'user_ip', 'is_active', 'unfreezed_by', 'unfreezed_date', 'unfreezed_user_ip', 'to_date', 'court_no', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}