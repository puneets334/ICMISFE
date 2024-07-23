<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TblUser extends Entity
{
    protected $db;
    protected $table      = 'tbl_user';
    // protected $primaryKey = 'diary_no';

    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // protected $allowedFields = ['diary_no', 'usercode', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}