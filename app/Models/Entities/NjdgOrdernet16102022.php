<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NjdgOrdernet16102022 extends Entity
{
    protected $db;
    protected $table      = 'njdg_ordernet_16102022';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'url_flag', 'cino', 'file_name', 'is_active', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}