<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TwProDesc extends Entity
{
    protected $db;
    protected $table      = 'tw_pro_desc';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'docnum', 'docyear', 'pet_res', 'sr_no', 'type', 'usercode', 'ent_dt', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}