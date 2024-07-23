<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NeutralCitation extends Entity
{
    protected $db;
    protected $table      = 'neutral_citation';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'nc_number', 'nc_year', 'nc_display', 'updated_by', 'updated_on', 'is_deleted', 'active_casetype_id', 'active_fil_no', 'active_reg_year', 'pet_name', 'res_name', 'dispose_order_date', 'reg_no_display', 'order_type', 'coram', 'no_of_judges', 'judgment_pronounced_by', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}