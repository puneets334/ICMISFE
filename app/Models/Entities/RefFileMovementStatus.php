<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefFileMovementStatus extends Entity
{
    protected $db;
    protected $table      = 'master.ref_file_movement_status';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'movement_status', 'updated_on', 'usercode', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}