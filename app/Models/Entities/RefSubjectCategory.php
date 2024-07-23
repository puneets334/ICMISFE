<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefSubjectCategory extends Entity
{
    protected $db;
    protected $table      = 'master.ref_subject_category';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'subject_sub_category_code', 'subject_subcategory_description', 'subject_category_code', 'subject_category_description', 'adm_updated_by', 'updated_on', 'is_deleted', 'is_heavy', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}