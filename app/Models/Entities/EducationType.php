<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EducationType extends Entity
{
    
    protected $table      = 'education_type';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'letter_no', 'letter_subject', 'initiated_on', 'initiated_by', 'user_section', 'is_deleted', 'updated_on', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
