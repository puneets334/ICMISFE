<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class DefectsVerificationA extends Entity
{ 
    protected $table      = 'defects_verification_a';
    // protected $primaryKey = 'id'; 
    // protected $useAutoIncrement = true; 
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [ 'id', 'diary_no','verification_status', 'verification_date', 'user_id','remarks','user_ip','create_modify' ,'updated_on' ,'updated_by' ,'updated_by_ip' ];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false; 
}