<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class JumpedFilno extends Entity
{
    protected $db;
    protected $table      = 'jumped_filno';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diaryno', 'year', 'usercode', 'ent_dt', 'reason', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}