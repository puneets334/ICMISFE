<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class LdMove30102018 extends Entity
{
    protected $db;
    protected $table      = 'ld_move_30102018';
    //protected $primaryKey = 'id';

    //protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'fil_no', 'doccode', 'doccode1', 'docnum', 'docyear', 'disp_by', 'disp_to', 'disp_dt', 'remarks', 'rece_by', 'rece_dt', 'other', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}