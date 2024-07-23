<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class Indexing extends Entity
{
    
    protected $table      = 'indexing';
    protected $primaryKey = 'diary_no';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['diary_no', 'doccode', 'doccode1', 'other', 'i_type', 'fp', 'tp', 'np', 'entdt', 'ucode', 'display', 'upd_tif_dt', 'upd_tif_id', 'ind_id', 'pdf_name', 'lowerct_id', 'src_of_ent', 'file_id', 'create_modify', 'updated_on', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}