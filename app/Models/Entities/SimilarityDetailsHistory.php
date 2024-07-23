<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SimilarityDetailsHistory extends Entity
{
    protected $db;
    protected $table      = 'similarity_details_history';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'sim_diary_no', 'status', 'remarks', 'propose_for', 'ent_by', 'ent_on', 'mod_by', 'mod_on', 'or_remarks', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}