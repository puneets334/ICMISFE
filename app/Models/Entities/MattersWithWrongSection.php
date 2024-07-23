<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MattersWithWrongSection extends Entity
{
    protected $db;
    protected $table      = 'matters_with_wrong_section';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'dacode', 'da_section_id', 'matter_section_id', 'ent_by', 'ent_on', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
