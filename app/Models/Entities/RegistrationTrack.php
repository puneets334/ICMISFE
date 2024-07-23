<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RegistrationTrack extends Entity
{
    protected $db;
    protected $table      = 'registration_track';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'num_to_register', 'registration_number_alloted', 'usercode', 'reg_date', 'registration_year', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}