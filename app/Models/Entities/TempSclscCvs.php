<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TempSclscCvs extends Entity
{
    protected $db;
    protected $table      = 'temp_sclsc_cvs';
    protected $primaryKey = 'sno';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['sno', 'sclsc_dno', 'sc_dno', 'sc_dyr', 'pet', 'res', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}