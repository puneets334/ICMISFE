<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RecalledMatters21122018 extends Entity
{
    protected $db;
    protected $table      = 'master.recalled_matters_21122018';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'ord_dt', 'disp_dt', 'disp_type', 'transferred_on', 'transferred_reason', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}