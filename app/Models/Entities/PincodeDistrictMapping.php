<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class PincodeDistrictMapping extends Entity
{
    protected $db;
    protected $table      = 'master.pincode_district_mapping';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['post_office_id', 'district_name', 'taluk_name', 'post_office_name', 'pincode', 'distance_from_sci', 'is_local', 'state'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}