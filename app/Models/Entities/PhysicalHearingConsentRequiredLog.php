<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class PhysicalHearingConsentRequiredLog extends Entity
{
    protected $db;
    protected $table      = 'physical_hearing_consent_required_log';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'conn_key', 'is_fixed', 'next_dt', 'is_deleted', 'updated_by', 'updated_on', 'updated_from_ip', 'vacation_list_year', 'mainhead', 'consent', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}