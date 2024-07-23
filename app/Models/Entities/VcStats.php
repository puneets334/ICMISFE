<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class VcStats extends Entity
{
    protected $db;
    protected $table      = 'vc_stats';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'date', 'filed', 'bench', 'listed_misc', 'listed_regular', 'disposed_misc', 'disposed_regular', 'updated_on', 'display', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}