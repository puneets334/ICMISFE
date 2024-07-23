<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RenewedCaveat extends Entity
{
    protected $db;
    protected $table      = 'renewed_caveat';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'old_caveat_no', 'new_caveat_no', 'renew_date', 'renew_user', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}