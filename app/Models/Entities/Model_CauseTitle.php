<?php

namespace App\Models\Entities;
use CodeIgniter\Model;

class Model_CauseTitle extends Model
{
    
    protected $table      = 'cause_title';
    protected $primaryKey = 'cause_title_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [ 'diary_no', 'path', 'created_on', 'created_by', 'created_ip', 'updated_by', 'updated_ip', 'is_active', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}