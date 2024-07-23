<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MasterBanks extends Entity
{
    protected $db;
    protected $table      = 'master.master_banks';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'bank_name', 'updated_by', 'updated_datetime', 'contact_person', 'email_id', 'ph_no', 'create_modify', 'updated_on', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    // protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
