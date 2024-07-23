<?php

namespace App\Models\Entities;
use CodeIgniter\Entity;

class EcPostalDispatch extends Entity
{
    
    protected $table      = 'ec_postal_dispatch';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'is_with_process_id', 'is_case', 'tw_notice_id', 'diary_no', 'reference_number', 'tw_tal_del_id', 'process_id', 'process_id_year', 'send_to_name', 'send_to_address', 'tal_state', 'tal_district', 'pincode', 'ref_postal_type_id', 'dispatched_by', 'serial_number', 'dispatched_on', 'postal_charges', 'weight', 'waybill_number', 'is_acknowledgeable', 'is_acknowledged', 'ref_letter_status_id', 'usersection_id', 'remarks', 'serve_stage', 'tw_serve_id', 'serve_remarks', 'usercode', 'updated_on', 'create_modify', 'updated_by', 'updated_by_ip'];

    protected $useTimestamps = true;
    protected $createdField  = 'create_modify';
    protected $updatedField  = 'updated_on'; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
        
}
