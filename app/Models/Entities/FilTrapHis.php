<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FilTrapHis extends Entity
{
    
    protected $table      = 'fil_trap_his';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['uid', 'diary_no', 'd_by_empid', 'd_to_empid', 'disp_dt', 'remarks', 'r_by_empid', 'rece_dt', 'comp_dt', 'disp_dt_seq', 'thisdt', 'other', 'scr_lower', 'consignment_remark', 'token_no'];

    // protected $useTimestamps = true;
    // protected $createdField  = 'create_modify';
    // protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}