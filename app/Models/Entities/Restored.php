<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Restored extends Entity
{
    protected $db;
    protected $table      = 'restored';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['entry_date', 'diary_no', 'fil_no', 'res_by_diary_no', 'fil_no_res_by', 'diary_next_dt', 'conn_next_dt', 'judges', 'pet', 'res', 'disp_month', 'disp_year', 'dispjud', 'disp_dt', 'disp_type', 'disp_judges', 'disp_crtstat', 'disp_camnt', 'disp_ent_dt', 'disp_ord_dt', 'disp_usercode', 'reg_dt', 'restore_reason', 'disp_rj_dt', 'diary_rec_dt', 'usercode', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}