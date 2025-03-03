<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class ContentForLatestupdates extends Entity
{
    
    protected $table      = 'content_for_latestupdates';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [ 'content_id', 'f_date', 't_date', 'memo_number', 'title_en', 'file_name', 'display', 'ent_dt', 'user', 'ip', 'mac_address', 'deleted_on', 'deleted_by', 'deleted_from_ip' ,'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}