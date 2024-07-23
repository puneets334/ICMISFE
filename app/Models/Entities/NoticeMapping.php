<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class NoticeMapping extends Entity
{
    protected $db;
    protected $table      = 'master.notice_mapping';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'j1', 'notbef', 'usercode', 'ent_dt', 'old_u_ip', 'old_u_mac', 'cur_u_ip', 'cur_u_mac', 'cur_ucode', 'c_dt', 'enterby_old', 'action', 'old_res_add', 'old_res_id', 'del_reason', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}