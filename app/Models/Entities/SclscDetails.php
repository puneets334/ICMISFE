<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SclscDetails extends Entity
{
    protected $db;
    protected $table      = 'sclsc_details';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'sclsc_diary_no', 'sclsc_diary_year', 'sclsc_ent_dt', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}