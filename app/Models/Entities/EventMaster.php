<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EventMaster extends Entity
{
    
    protected $table      = 'event_master';

    protected $primaryKey = 'event_code';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['event_code', 'event_name', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
 
}
