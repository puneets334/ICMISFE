<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EliminatedCasesA extends Entity
{
    
    protected $table      = 'eliminated_cases_a';
    // protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['diary_no', 'next_dt_old', 'next_dt_new', 'tentative_cl_dt_old', 'tentative_cl_dt_new', 'listorder', 'conn_key', 'ent_dt', 'test2', 'listorder_new', 'board_type', 'listtype', 'reason', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}