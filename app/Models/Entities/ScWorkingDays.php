<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class ScWorkingDays extends Entity
{
    protected $db;
    protected $table      = 'sc_working_days';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'working_date', 'is_nmd', 'is_holiday', 'holiday_description', 'updated_by', 'updated_on', 'display', 'misc_dt', 'nmd_dt', 'sec_list_dt', 'misc_dt1', 'misc_dt2', 'holiday_for_registry', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}