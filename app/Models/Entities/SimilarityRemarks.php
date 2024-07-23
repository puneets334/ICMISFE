<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SimilarityRemarks extends Entity
{
    protected $db;
    protected $table      = 'master.similarity_remarks';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'conditions', 'remarks', 'ent_on', 'ent_by', 'modified_on', 'modified_by', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}