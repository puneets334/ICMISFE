<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class DiaryMovementHistory extends Entity
{
    
    protected $table      = 'diary_movement_history';
    // protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'diary_copy_set', 'disp_by', 'disp_to', 'disp_dt', 'rece_by', 'rece_dt', 'c_l', 'remark', 'flag', 'ent_dt', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
