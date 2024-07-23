<?php
namespace App\Controllers\Judicial;
use App\Controllers\BaseController;
use App\Models\Common\DropdownListModel;
use App\Models\Judicial\IAModel;

class IA extends BaseController
{
    public $DropdownListModel;
    public $IAModel;

    function __construct(){
        $this->DropdownListModel= new DropdownListModel();
        $this->IAModel = new IAModel();
    }
    /*Start Judicial IA UPDATE*/
    public function index(){
        return view('Judicial/IA_view');
    }
    /*end Judicial IA UPDATE*/

    public function get_search(){

    }
    public function get_content_list(){
        $usercode=session()->get('login')['usercode'];
        $diary_no = $_SESSION['filing_details']['diary_no'];
        /*$t_fil_no=get_case_nos($diary_no,'&nbsp;&nbsp;');
        echo 't_fil_no='.$t_fil_no;exit();*/
        $row_fl = $this->IAModel->get_diary_details($diary_no);
        if (!empty($row_fl)){
            if($usercode!=$row_fl['dacode'] && $usercode!=1){
                $users = is_data_from_table('master.users', ['usercode' => $usercode, 'display' => 'Y'],'section','R');
                if (!empty($users)){
                    $usersection= $users['section'];
                    if($usersection!=62 and $usersection!=81 and $usersection!=11){
                        echo "<center> <p><font class='text-danger'>Only DA can Update IA</font></p> </center>";exit();
                    }
                }
            }
        }else{
            echo "<center> <p><font class='text-danger'>SORRY, NO RECORD FOUND !!!</font></p> </center>";exit();
        }
        $data['short_description']='';
        if (!empty($row_fl['casetype_id'])){
            $get_short_description = $this->IAModel->get_short_description($row_fl['casetype_id']);
            if (!empty($get_short_description)){$data['short_description']=$get_short_description['short_description']; }
        }


        $result=$this->IAModel->get_party_details($diary_no);

        $data['row_fl']=$row_fl;
        $data['IArec'] = $this->IAModel->getIArec();
        $data['getPartyName'] = $this->IAModel->getPartyName($diary_no);
        $data['result'] = $result;
        $data['diary_no'] = $diary_no;
        $data['dno_data'] = $_SESSION['filing_details'];
        //$data['ia_res'] = $is_docdetails;


        $get_view_result= view('Judicial/IA_get_content',$data);
        echo $get_view_result;exit();
        // echo "3@@@Diary No. or Case No. doesn't exist .";exit();
    }


}