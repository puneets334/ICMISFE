<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Msg extends Entity
{
    protected $db;
    protected $table      = 'msg';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'to_user', 'from_user', 'msg', 'display', 'display2', 'trash', 'trash2', 'time', 'ipadd', 'r_unr', 'seen', 'seen_time', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
