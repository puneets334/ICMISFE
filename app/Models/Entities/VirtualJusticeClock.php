<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class VirtualJusticeClock extends Entity
{
    protected $db;
    protected $table      = 'virtual_justice_clock';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['flag', 'counted_data', 'list_date', 'is_active', 'ason', 'to_dt', 'create_modify','updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}