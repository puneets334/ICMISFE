<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class JoAlottmentPaps extends Entity
{
    protected $db;
    protected $table      = 'jo_alottment_paps';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['usercode', 'cl_date', 'filno', 'display', 'court', 'uid', 'ent_dt', 'mainhead', 'clno', 'diary_no', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}