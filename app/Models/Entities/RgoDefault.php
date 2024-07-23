<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RgoDefault extends Entity
{
    protected $db;
    protected $table      = 'rgo_default';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['fil_no', 'conn_key', 'reason', 'fil_no2', 'remove_def', 'remove_def_dt', 'ent_dt', 'rgo_updated_by', 'hcourt_no', 'court_type', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}