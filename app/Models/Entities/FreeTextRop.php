<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class FreeTextRop extends Entity
{
    
    protected $table      = 'free_text_rop';
    protected $primaryKey = 'diary_no';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['diary_no', 'diary_number', 'diary_year', 'case_type', 'case_number', 'case_year', 'dated', 'rop_text', 'file_type', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}