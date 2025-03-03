<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class OrdernetOrg extends Entity
{
    protected $db;
    protected $table      = 'ordernet_org';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'diary_no', 'petn', 'resp', 'petadv', 'resadv', 'perj', 'orderdate', 'old_pdfname', 'pdfname', 'upload', 'usercode', 'ent_dt', 'type', 'h_p', 'afr', 'prnt_name', 'prnt_dt', 'subject', 'web_status', 'display', 'roster_id', 'pdf_generated_name', 'pdf_generated_date', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}