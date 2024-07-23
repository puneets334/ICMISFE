<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NjrsMails extends Entity
{
    protected $db;
    protected $table      = 'njrs_mails';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'to_sender', 'from_date', 'to_date', 'subject', 'display', 'usercode', 'created_on', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}