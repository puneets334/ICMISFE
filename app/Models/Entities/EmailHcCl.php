<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EmailHcCl extends Entity
{
    
    protected $table      = 'email_hc_cl';
    
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['title', 'name', 'email', 'diary_no', 'next_dt', 'mainhead', 'court', 'judges', 'roster_id', 'board_type', 'brd_slno', 'ent_time', 'cno', 'jnames', 'pname', 'rname', 'qry_from', 'sent_to_smspool', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}