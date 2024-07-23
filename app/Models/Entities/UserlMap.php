<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class UserlMap extends Entity
{
    protected $db;
    protected $table      = 'master.user_l_map';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'udept', 'utype', 'ucode', 'l_type', 'f_auth', 'a_auth', 'display', 'user', 'ent_dt', 'up_user', 'up_entdt', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}