<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RequistionUpload extends Entity
{
    protected $db;
    protected $table      = 'requistion_upload';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'req_id', 'file_path', 'usercode', 'entry_date', 'ip', 'remarks', 'is_active', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}