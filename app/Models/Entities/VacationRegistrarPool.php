<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class VacationRegistrarPool extends Entity
{
    protected $db;
    protected $table      = 'vacation_registrar_pool';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'user_code', 'ent_dt', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}