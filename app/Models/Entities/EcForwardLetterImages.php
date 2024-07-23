<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EcForwardLetterImages extends Entity
{
    
    protected $table      = 'ec_forward_letter_images';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'file_display_name', 'file_path', 'file_name', 'upload_time', 'upload_by', 'is_deleted', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
