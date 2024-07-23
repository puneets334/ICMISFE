<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class PartyA extends Entity
{
    protected $db;
    protected $table      = 'party_a';
    // protected $primaryKey = 'id';
    // protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'pet_res', 'sr_no', 'sr_no_show', 'ind_dep', 'partysuff', 'partyname', 'sonof', 'authcode', 'state_in_name', 'prfhname', 'age', 'sex', 'caste', 'addr1', 'addr2', 'state', 'city', 'pin', 'email', 'contact', 'usercode', 'ent_dt', 'pflag', 'dstname', 'deptcode', 'pan_card', 'adhar_card', 'country', 'education', 'occ_code', 'edu_code', 'lowercase_id', 'auto_generated_id', 'remark_lrs', 'remark_del', 'cont_pro_info', 'last_dt', 'last_usercode'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}