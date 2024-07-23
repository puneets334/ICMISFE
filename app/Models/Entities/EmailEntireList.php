<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EmailEntireList extends Entity
{
    
    protected $table      = 'email_entire_list';
    // protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['cl_date', 'm_j_1', 'm_j_2', 'f_j_1', 'f_j_2', 'm_c_1', 'm_c_2', 'm_r_1', 'm_r_2', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}