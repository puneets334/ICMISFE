<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Deptt extends Entity
{
    
    protected $table      = 'master.deptt';
    // protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [ 'deptcode', 'deptype','deptname', 'dm', 'd1', 'd2', 'd3' ,'display','dept_code_sc','deptemail' ,'deptmobile','drupal_id','create_modify','updated_on' ,'updated_by','updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
