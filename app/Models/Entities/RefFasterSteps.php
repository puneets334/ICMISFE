<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefFasterSteps extends Entity
{
    protected $db;
    protected $table      = 'master.ref_faster_steps';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'description', 'created_on', 'created_by', 'is_deleted', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}