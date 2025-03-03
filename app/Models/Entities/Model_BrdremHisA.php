<?php

namespace App\Models\Entities;
use CodeIgniter\Model;

class Model_BrdremHisA extends Model
{
    
    protected $table      = 'brdrem_his_a';
    // protected $primaryKey = '';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [ 'diary_no', 'remark', 'usercode', 'ent_dt', 'bh_usercode', 'bh_entdt', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}