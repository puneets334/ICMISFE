<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NtlJudge extends Entity
{
    protected $db;
    protected $table      = 'master.ntl_judge';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['org_advocate_id', 'org_judge_id', 'userid', 'ent_dt', 'display', 'del_dt', 'del_user', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}