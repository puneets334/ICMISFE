<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class OriginalRecordsFile extends Entity
{
    protected $db;
    protected $table      = 'original_records_file';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'file_name', 'usercode', 'updated_on', 'display', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}