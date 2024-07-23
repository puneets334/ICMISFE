<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class OldRop extends Entity
{
    protected $db;
    protected $table      = 'old_rop';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['pno', 'caseno', 'caseyr', 'typecode', 'orderdate', 'petname', 'resname', 'court_no', 'item_no', 'file_no', 'cn_from', 'cn_to', 'dn', 'new_casecode', 'display', 'order_type', 'usercode', 'ent_dt', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}