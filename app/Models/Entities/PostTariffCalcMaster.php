<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class PostTariffCalcMaster extends Entity
{
    protected $db;
    protected $table      = 'master.post_tariff_calc_master';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'distance_from', 'distance_to', 'weight_type', 'weight_from', 'weight_to', 'rate', 'from_date', 'to_date', 'tax', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}