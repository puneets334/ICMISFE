<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Stampreg extends Entity
{
    protected $db;
    protected $table      = 'master.stampreg';
    // protected $primaryKey = 'id';

    // protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['desc1', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}