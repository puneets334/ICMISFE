<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class ModuleEntrySession extends Entity
{
    protected $db;
    protected $table      = 'module_entry_session';

    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['session_id', 'user_id', 'diary_no', 'entry_time', 'module_id', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
