<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class VacationAdvanceListAdvocate extends Entity
{
    protected $db;
    protected $table      = 'vacation_advance_list_advocate';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'conn_key', 'is_fixed', 'aor_code', 'is_deleted', 'updated_by', 'updated_on', 'updated_from_ip', 'vacation_list_year', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}