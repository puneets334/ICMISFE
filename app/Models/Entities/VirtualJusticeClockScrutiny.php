<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class VirtualJusticeClockScrutiny extends Entity
{
    protected $db;
    protected $table      = 'virtual_justice_clock_scrutiny';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['flag', 'empid', 'employee_name', 'total', 'efiled_total', 'pfiling_total',  '0_3_days_efile','0_3_days_pfile','4_7_days_efile','4_7_days_pfile','7_1_month_efile','7_1_month_pfile','above_month_efile', 'above_month_pfile','last_week_comp_pfile','last_week_comp_efile','is_active','ason','create_modify','updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}