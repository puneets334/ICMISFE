<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class VirtualJusticeClockMainSubjectCategory extends Entity
{
    protected $db;
    protected $table      = 'virtual_justice_clock_main_subject_category';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['subcode1', 'sub_name1', 'flag', 'counted_data', 'main_counted_data', '0_1_year_old',  'main_0_1_year_old','2_3_year_old','main_2_3_year_old','4_5_year_old','main_4_5_year_old','6_10_year_old','main_6_10_year_old', '11_20_year_old','main_11_20_year_old','21_30_year_old','main_21_30_year_old','above_30_year_old','main_above_30_year_old','is_active','ason','create_modify','updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}