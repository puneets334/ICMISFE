<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FilTrapUsers extends Entity
{
    
    protected $table      = 'fil_trap_users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'usertype', 'usercode', 'display', 'entuser', 'ent_dt', 'upuser', 'updt', 'user_type', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}