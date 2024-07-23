<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class DraftList extends Entity
{
    
    protected $table      = 'draft_list';
    // protected $primaryKey = 'dcode';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['diary_no', 'next_dt_old', 'conn_key', 'list_type', 'board_type', 'usercode', 'ent_time', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
