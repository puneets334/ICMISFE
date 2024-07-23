<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class VerifyDigitalSignature extends Entity
{
    protected $db;
    protected $table      = 'verify_digital_signature';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['dsc_name', 'dsc_serial_no', 'dsc_public_key', 'dsc_expirey_date', 'cmis_user', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}