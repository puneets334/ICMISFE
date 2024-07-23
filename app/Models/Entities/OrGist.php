<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class OrGist extends Entity
{
    protected $db;
    protected $table      = 'or_gist';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'list_dt', 'gist_remark', 'usercode', 'ent_dt', 'display', 'deleted_by', 'deleted_on', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}