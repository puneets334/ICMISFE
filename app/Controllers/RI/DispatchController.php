<?php
namespace App\Controllers\RI;
use App\Controllers\BaseController;
use App\Models\RI\RIModel;
use CodeIgniter\Controller;

class DispatchController extends BaseController
{

    public $RIModel;
    public function __construct()
    {
        $this->RIModel = new RIModel();

    }

    public function showCreateLetterGroup()
    {
//        echo "HHHHH";
//        die;
        return view('RI/Dispatch/showCreateLetterGroup');

    }

    public function searchMainLetter(){
        $processId = $_POST['pid'];
        $processYear = $_POST['pyr'];
        $result = $this->RIModel->getProcessIdDetails($processId,$processYear);
//        echo "<pre>";
//        print_r($result);
//        die;
        if(!empty($result))
        {
            $data['processIdDetails']= $result;
//            echo "<pre>";
//            print_r($data);
//            die;

            $result_view =  view('RI/Dispatch/dataSearchMainLetter',$data);

            echo $result_view;
//            exit;
        }else{
            echo '';
        }
    }

    public function goToNextPage()
    {
        $selectedCase = $_POST['selectedCase'];
//        echo "LLL".$selectedCase;
//        die;
        $resultLetter = $this->RIModel->getMainLetterDetails($selectedCase);
//        echo "<pre>";
//        print_r($resultLetter);
//        die;
        if(!empty($resultLetter))
        {
            $data['mainLetterDetail']= $resultLetter;
//              echo "<pre>";
//             print_r($data);
//             die;
            $result_view =  view('RI/Dispatch/connectLetters',$data);
            echo $result_view;
            exit;
        }else{
            echo '';
        }


//       return view('RI/dispatch/connectLetters',$data);
    }

    public function searchConnectedLetter(){
//        var_dump($_POST);
//        die;
        $processIdConnected = $_POST['pid'];
        $processYearConnected = $_POST['pyr'];
        $mainLetterId = $_POST['mainLetterId'];
        $usercode=$_SESSION['login']['usercode'];
        $processIdDetails=$this->RIModel->getProcessIdDetails($processIdConnected,$processYearConnected);
//        echo "<pre>";
//        print_r(gettype($processIdDetails));
//        die;
        if($processIdDetails){
//            var_dump($processIdDetails);
//            die;
            $i=0;$exit=0;
            foreach ($processIdDetails as $details){
                $dataToConnect=$this->RIModel->getMainLetterDetails($details['ec_postal_dispatch_id']);
//                echo "<pre>";
//                print_r($dataToConnect);
//                die;
                echo "YYY";
                if(empty($dataToConnect[0]['connected_id'])){
                    $this->RIModel->addConnectedLetter($details['ec_postal_dispatch_id'],$mainLetterId,$usercode);
                    $i++;
                }
                else{
                    echo "<span class='text-danger'>Letter Already Added!</span>";
                    $exit=1;
                }
            }
            if($exit==0){
                if($i!=0){
                    echo "<span class='text-success'>$i letters added to group Successfully!</span>";
                }
                else{
                    echo "<span class='text-danger'>Nothing added!</span>";
                }
            }
        }
        else{
            echo "<span class='text-danger'>Letter Not available to dispatch!</span>";
        }
    }

    public function dispatchDakFromRI(){
//        extract($_POST);
//        echo "hello";
        $usercode = session()->get('login')['usercode'];
        $data=[];


        $section = $this->RIModel->getSection();
        if(!empty($section))
        {
            $data['dealingSections'] = $section;

        }
        $casetype = $this->RIModel->getCaseType();
        if(!empty($casetype))
        {
            $data['caseTypes'] = $casetype;

        }
        $rmode = $this->RIModel->getReceiptMode();
        if(!empty($rmode))
        {
            $data['dispatchModes'] = $rmode;

        }
//        if(!isset($_SESSION['dcmis_user_idd'])){
//            $this->session->set_userdata('dcmis_user_idd', $usercode);
//        }
//
//        echo "<pre>";
//        print_r($data);
//        die;
        return view('RI/Dispatch/dispatchDakFromRI',$data);
    }

    public function getDataToDispatch()
    {
        echo "hhh";
        var_dump($_POST);
        die;

    }

}



?>