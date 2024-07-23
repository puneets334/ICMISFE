<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class SubMaster extends Entity
{
    protected $db;
    protected $table      = 'master.submaster';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'subcode1', 'subcode2', 'subcode3', 'subcode4', 'sub_name1', 'short_description', 'sub_name2', 'sub_name3', 'sub_name4', 'subject_description', 'category_description', 'display', 'flag', 'list_display', 'updated_on', 'id_sc_old', 'subject_sc_old', 'category_sc_old', 'subcode1_hc', 'subcode2_hc', 'subcode3_hc', 'subcode4_hc', 'match_id', 'main_head', 'flag_use', 'old_sc_c_kk', 'create_modify', 'updated_by', 'updated_by_ip', 'is_old', 'old_submaster_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}