<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EfiledDocs extends Entity
{
    
    protected $table      = 'efiled_docs';
   
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'efiling_no', 'efiled_type', 'diary_no', 'doc_id', 'docnum', 'docyear', 'created_at', 'created_by', 'display', 'docd_id', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}