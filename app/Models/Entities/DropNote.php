<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class DropNote extends Entity
{
    
    protected $table      = 'drop_note';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'cl_date', 'clno', 'diary_no', 'roster_id', 'nrs', 'usercode', 'ent_dt', 'display', 'mf', 'update_time', 'update_user', 'so_user', 'so_time', 'part', 'reason_id', 'reason_type_id', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
