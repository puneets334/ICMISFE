<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefSpecialCategoryFiling extends Entity
{
    protected $db;
    protected $table      = 'master.ref_special_category_filing';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'category_name', 'display', 'updated_by', 'updated_on', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}