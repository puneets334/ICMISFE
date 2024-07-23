<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefPostalType extends Entity
{
    protected $db;
    protected $table      = 'master.ref_postal_type';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'postal_type_code', 'postal_type_description', 'updated_on', 'adm_updated_by', 'is_deleted', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}