<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TwOR extends Entity
{
    protected $db;
    protected $table      = 'tw_o_r';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'tw_org_id', 'del_type', 'display', 'sign_date', 'public_key', 'data', 'sign_data', 'dsc_serial_no', 'dsc_name', 'mode_path', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}