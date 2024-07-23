<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class DiaryMovement extends Entity
{
    
    protected $table      = 'diary_movement';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'diary_copy_set', 'disp_by', 'disp_to', 'disp_dt', 'rece_by', 'rece_dt', 'c_l', 'remark', 'flag', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
