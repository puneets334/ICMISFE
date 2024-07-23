<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class OldOr extends Entity
{
    protected $db;
    protected $table      = 'old_or';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['pno', 'typecode', 'caseno', 'caseyr', 'reportdate', 'petname', 'resname', 'cn_from', 'cn_to', 'dn', 'new_casecode', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}