<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FilingRemark extends Entity
{
    
    protected $table      = 'filing_remark';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'diary_no', 'counter_remark_type', 'remark', 'usercode', 'entry_date', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}