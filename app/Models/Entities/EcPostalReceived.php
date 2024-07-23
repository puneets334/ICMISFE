<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EcPostalReceived extends Entity
{
    
    protected $table      = 'ec_postal_received';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'ref_postal_type_id', 'is_openable', 'postal_no', 'postal_date', 'letter_no', 'letter_year', 'letter_date', 'subject', 'is_original_record', 'sender_name', 'address', 'ref_city_id', 'ref_state_id', 'pin_code', 'diary_no', 'diary_year', 'updated_on', 'adm_updated_by', 'is_deleted', 'postal_addressee', 'ec_case_id', 'pil_diary_number', 'remarks', 'received_on', 'is_ad_card', 'ec_postal_dispatch_id', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
