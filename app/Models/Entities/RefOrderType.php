<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class RefOrderType extends Entity
{
    protected $db;
    protected $table      = 'master.ref_order_type';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'order_type', 'adm_updated_by', 'updated_on', 'is_deleted', 'is_for_proceedings', 'is_for_decree', 'is_for_notice', 'mandate_date_of_order_type', 'mandate_remark_of_order_type', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}