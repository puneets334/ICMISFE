<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EfiledPdfs extends Entity
{
    
    protected $table      = 'efiled_pdfs';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'diary_no', 'diary_year', 'file_name', 'full_path', 'is_deleted', 'updated_by', 'updated_on', 'deleted_on', 'create_modify', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
     
}
