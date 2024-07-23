<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TwNotPenSta extends Entity
{
    protected $db;
    protected $table      = 'master.tw_not_pen_sta';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'ck_rec_dt', 'ck_cl_dt', 'ck_hd', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}