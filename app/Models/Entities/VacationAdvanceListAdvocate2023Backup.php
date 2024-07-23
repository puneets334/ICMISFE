<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class VacationAdvanceListAdvocate2023Backup extends Entity
{
    protected $db;
    protected $table      = 'vacation_advance_list_advocate_2023_backup';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'conn_key', 'is_fixed', 'aor_code', 'is_deleted', 'updated_by', 'updated_on', 'updated_from_ip', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}