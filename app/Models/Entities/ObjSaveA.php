<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class ObjSaveA extends Entity
{
    protected $db;
    protected $table      = 'obj_save_a';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'org_id', 'org_id_old', 'save_dt', 'rm_dt', 'status', 'j1_date', 'j1_sn_dt', 'j1_tot_da', 'usercode', 'remark', 'mul_ent', 'display', 'rm_user_id', 'rm_on_back_date', 'refil_cancel_user', 'refil_cancel_date'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}