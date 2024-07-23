<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TempTable extends Entity
{
    protected $db;
    protected $table      = 'temp_table';
    // protected $primaryKey = 'diary_no';

    // protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'dacode', 'section_id', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}