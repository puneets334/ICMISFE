<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Users extends Entity
{
    protected $db;
    protected $table      = 'master.users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['usercode', 'userpass', 'name', 'empid', 'service', 'usertype', 'section', 'udept', 'log_in', 'logout', 'display', 'jcode', 'nm_alias', 'entdt', 'entuser', 'attend', 'upuser', 'updt', 'mobile_no', 'email_id', 'ip_address', 'is_courtmaster', 'dob', 'mobile', 'uphoto', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}