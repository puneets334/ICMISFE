<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class HeadFooter extends Entity
{
    
    protected $table      = 'headfooter';
    protected $primaryKey = 'hf_id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['hf_id', 'next_dt', 'roster_id', 'h_f_note', 'h_f_flag', 'usercode', 'ent_dt', 'display', 'part', 'mainhead', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}