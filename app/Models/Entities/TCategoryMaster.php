<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TCategoryMaster extends Entity
{
    protected $db;
    protected $table      = 'master.t_category_master';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'name', 'parent_id', 'destination_id', 'cis_causelist_type_id', 'access_id', 'access_dated', 'record_status', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}