<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EcKeyword extends Entity
{
    
    protected $table      = 'ec_keyword';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'diary_no', 'keyword_id', 'display', 'ent_dt', 'updated_from_ip', 'updatedfrommodule', 'user', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
     
}
