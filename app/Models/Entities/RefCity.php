<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefCity extends Entity
{
    protected $db;
    protected $table      = 'master.ref_city';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'city_code', 'city_name', 'ref_district_id', 'ref_state_id', 'is_deleted', 'adm_updated_by', 'updated_on', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}