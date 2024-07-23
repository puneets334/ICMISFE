<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class IcmisFaqs extends Entity
{
    
    protected $table      = 'master.icmis_faqs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'question', 'answer', 'main_menu', 'sub_menu', 'created_on', 'updated_on', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}