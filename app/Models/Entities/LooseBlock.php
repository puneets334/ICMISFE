<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class LooseBlock extends Entity
{
    protected $db;
    protected $table      = 'loose_block';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'reason_blk', 'usercode', 'ent_dt', 'display', 'up_user', 'up_dt', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}