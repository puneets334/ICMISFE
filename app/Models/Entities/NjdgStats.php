<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NjdgStats extends Entity
{
    protected $db;
    protected $table      = 'njdg_stats';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'source', 'main_flag', 'flag', 'total_count', 'display', 'created_by_ip', 'created_date', 'active_casetype_id', 'year', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}