<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MainCasetypeHistoryBackupDataCorrection extends Entity
{
    protected $db;
    protected $table      = 'main_casetype_history_backup_data_correction';

    protected $primaryKey = 'diary_no';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'id', 'old_registration_number', 'old_registration_year', 'new_registration_number', 'new_registration_year', 'order_date', 'ref_old_case_type_id', 'ref_new_case_type_id', 'adm_updated_by', 'updated_on', 'is_deleted', 'ec_case_id', 'remark', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
