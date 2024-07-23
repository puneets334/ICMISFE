<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefCopyingStatus extends Entity
{
    protected $db;
    protected $table      = 'master.ref_copying_status';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'status_code', 'status_description', 'updated_by', 'updated_on', 'is_deleted', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}