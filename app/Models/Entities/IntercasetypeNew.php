<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class IntercasetypeNew extends Entity
{
    
    protected $table      = 'master.intercasetype_new';
    // protected $primaryKey = 'diary_no';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['main_casecode', 'main_casename', 'lc_casecode', 'lc_casename', 'key', 'avail', 'old_code', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}