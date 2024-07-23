<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Tribunal extends Entity
{
    protected $db;
    protected $table      = 'master.tribunal';
    // protected $primaryKey = 'transfer_to_id';

    // protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'agency_name', 'state_id', 'short_agency_name', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}