<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class IdpStats extends Entity
{
    
    protected $table      = 'idp_stats';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'date', 'total_institution', 'misc_institution', 'regular_institution', 'civil_institution', 'criminal_institution', 'total_disposed', 'misc_disp', 'regular_disp', 'civil_disp', 'criminal_disp', 'total_pendency', 'regular_pendency', 'misc_pendency', 'civil_pendency', 'criminal_pendency', 'complete_pendency', 'incomplete_pendency', 'ready_pendency', 'not_ready_pendency', 'updated_on', 'display', 'recalled', 'recalled_dismissed', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}