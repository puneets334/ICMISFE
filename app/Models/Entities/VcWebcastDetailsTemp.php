<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class VcWebcastDetailsTemp extends Entity
{
    protected $db;
    protected $table      = 'vc_webcast_details_temp';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'nofn_link', 'vcmeet_link', 'display', 'is_nofn', 'is_vcmeet', 'updated_on', 'courtno', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}