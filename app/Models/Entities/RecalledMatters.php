<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RecalledMatters extends Entity
{
    protected $db;
    protected $table      = 'master.recalled_matters';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'ord_dt', 'disp_dt', 'disp_type', 'updated_on', 'updation_reason', 'updated_by', 'updated_by_ip', 'court_or_user', 'create_modify'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}