<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MarkAllForHc extends Entity
{
    protected $db;
    protected $table      = 'mark_all_for_hc';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'mark_all', 'display', 'ent_dt', 'upd_dt', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    // protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}