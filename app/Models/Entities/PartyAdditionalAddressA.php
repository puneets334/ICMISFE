<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class PartyAdditionalAddressA extends Entity
{
    protected $db;
    protected $table      = 'party_additional_address_a';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'party_id', 'country', 'state', 'district', 'address', 'display', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}