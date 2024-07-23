<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class HybridPhysicalHearingConsentLog extends Entity
{
    
    protected $table      = 'hybrid_physical_hearing_consent_log';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'diary_no', 'conn_key', 'consent', 'hearing_from_time', 'hearing_to_time', 'from_dt', 'to_dt', 'list_type_id', 'list_number', 'list_year', 'mainhead', 'board_type', 'user_id', 'entry_date', 'user_ip', 'court_no', 'roster_id', 'main_supp_flag', 'part_no', 'judges', 'updated_by', 'updated_date', 'updated_user_ip', 'create_modify', 'updated_on', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}