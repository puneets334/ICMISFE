<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class LawPoints extends Entity
{
    protected $db;
    protected $table      = 'law_points';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'question_of_law', 'catchwords', 'display', 'updated_by', 'updated_on', 'updated_from_ip', 'is_verified', 'verified_on', 'verified_by', 'verified_from_ip', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}