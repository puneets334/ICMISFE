<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FinalEliminationClPrinted extends Entity
{
    
    protected $table      = 'final_elimination_cl_printed';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'next_dt', 'board_type', 'usercode', 'ent_time', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}