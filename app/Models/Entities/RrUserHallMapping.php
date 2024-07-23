<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RrUserHallMapping extends Entity
{
    protected $db;
    protected $table      = 'master.rr_user_hall_mapping';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'usercode', 'ref_hall_no', 'from_date', 'to_date', 'display', 'update_on', 'updated_by', 'create_modify', 'updated_on', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}