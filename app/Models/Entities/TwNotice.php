<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class TwNotice extends Entity
{
    protected $db;
    protected $table      = 'master.tw_notice';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'name', 'nature', 'section', 'display', 'fly_rep', 'sig_authority', 'war_notice', 'notice_office', 'notice_status', 'doc_ia_type', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}