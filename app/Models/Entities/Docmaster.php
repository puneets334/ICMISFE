<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Docmaster extends Entity
{
    
    protected $table      = 'master.docmaster';
    // protected $primaryKey = 'dcode';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['doccode', 'doccode1', 'docdesc', 'docfee', 'kntgrp', 'doctype', 'display', 'old_id', 'relief_code', 'remark1', 'remark2', 'listable', 'sc_doc_code', 'not_reg_if_pen', 'doc_ia_type', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
