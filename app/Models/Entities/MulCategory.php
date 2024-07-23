<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class MulCategory extends Entity
{
    protected $db;
    protected $table      = 'mul_category';

    // protected $primaryKey = 'diary_no';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'submaster_id', 'mul_category_idd', 'display', 'od_cat', 'e_date', 'mul_cat_user_code', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip', 'new_submaster_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
