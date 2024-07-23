<?php

namespace App\Controllers\MasterManagement;
use App\Controllers\BaseController;
use App\Models\Entities\Model_menu;
use App\Models\MenuModel;
use CodeIgniter\Controller;
use CodeIgniter\Model;

class MenuAssign extends BaseController
{
public $Model_menu;
public $MenuModel;
    function __construct()
    {
        ini_set('memory_limit','51200M'); 
        // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        $this->Model_menu = new Model_menu();
        $this->MenuModel = new MenuModel();
        //error_reporting(0);
    }

    public function index()
    {
        $data['get_menus_rs']=$this->Model_menu->select("menu_nm,substr(menu_id,1,2),url as menu_id")->where(['substr(menu_id,3)'=>'0000000000','display'=>'Y','menu_id is not'=>null])->orderBy('priority')->get()->getResultArray();
        $data['action_permission_allotment']=$this->MenuModel->get_action_permission_allotment();
        $data['menu_list']=$this->MenuModel->get_menu_list();
        $data['role_master_list']=$this->MenuModel->get_role_master_with_role_menu_mapping_list();
        //echo '<pre>';print_r($data['role_master_list']);exit();
        return view('MasterManagement/menu_assign/index',$data);

    }
    public function upd_umpermission(){
        if ($this->request->getMethod() === 'post'){
            date_default_timezone_set('Asia/Kolkata');
            $action=htmlentities(trim($_POST['action']));
            $menu_id=(int)$_POST['menu_id'];
            switch ($action) {
                case 'getAlotmentMenu':

                    $count=1;
                    /*$qsel='select GROUP_CONCAT(role_master_id) from user_role_master_mapping where usercode=? AND display="Y";';
                    $qselRs=$dbo->prepare($qsel);
                    $qselRs->bindParam(1, $menu_id, PDO::PARAM_INT);
                    $qselRs->execute();
                    $menuIds=$qselRs->fetchColumn();
                    $menuIds=explode(',', $menuIds);

                    $query="select id,role_desc,updated_on from role_master where display='Y' order by id;";
                    $rs=$dbo->prepare($query);
                    $rs->execute();
                    while ($rows=$rs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT)) {

                        foreach ($menuIds as $GetmId) {
                            $checked=''; $fontColor='text-danger';
                            if($rows[0] == $GetmId) {
                                $checked=' checked="checked"';
                                $fontColor='text-success'; break;
                            }
                        }

                        echo'<tr>
								<td>
									<input type="checkbox" name="mRoleId" value="'.$rows[0].'" id="'.$count.'"'.$checked.'>&nbsp;&nbsp;
									<label class="'.$fontColor.' font-weight-bold" for="'.$count.'">'.$rows[1].'</label>
								</td>
								<td><div class="lupdon"><i class="fa fa-calendar text-warning">&nbsp;Last updated on : </i>'.$rows[2].'</div></td>
							</tr>';
                        $count++;
                    }*/

                    break;

                case 'UpdUserDisplay_uy':
                    /*$ip = $_SERVER['REMOTE_ADDR']; $now=date('Y-m-d H:i:s');
                    $qupd='update users set display=?, updt=?, ip_address=? where usercode=?;'; $display='N';
                    $qrs=$dbo->prepare($qupd);
                    $qrs->bindParam(1, $display, PDO::PARAM_STR);
                    $qrs->bindParam(2, $now, PDO::PARAM_STR);
                    $qrs->bindParam(3, $ip, PDO::PARAM_STR);
                    $qrs->bindParam(4, $menu_id, PDO::PARAM_INT);
                    if($qrs->execute() == 1) echo json_encode(array('data'=>'success'));
                    else 					 echo json_encode(array('data'=>'failed'));*/
                    break;

                case 'UpdUserDisplay_un':
                    $ip = $_SERVER['REMOTE_ADDR']; $now=date('Y-m-d H:i:s');
                    /*$qupd='update users set display=?, updt=?, ip_address=? where usercode=?;'; $display='Y';
                    $qrs=$dbo->prepare($qupd);
                    $qrs->bindParam(1, $display, PDO::PARAM_STR);
                    $qrs->bindParam(2, $now, PDO::PARAM_STR);
                    $qrs->bindParam(3, $ip, PDO::PARAM_STR);
                    $qrs->bindParam(4, $menu_id, PDO::PARAM_INT);
                    if($qrs->execute() == 1) echo json_encode(array('data'=>'success'));
                    else 					 echo json_encode(array('data'=>'failed'));*/
                    break;

                case 'mn':
                    /*$qupd='update menu set display=? where id=?;'; $display='Y';
                    $qrs=$dbo->prepare($qupd);
                    $qrs->bindParam(1, $display, PDO::PARAM_STR);
                    $qrs->bindParam(2, $menu_id, PDO::PARAM_INT);
                    if($qrs->execute() == 1) echo json_encode(array('data'=>'success'));
                    else 					 echo json_encode(array('data'=>'failed'));*/
                    break;

                case 'my':
                   /* $qupd='update menu set display=? where id=?;'; $display='N';
                    $qrs=$dbo->prepare($qupd);
                    $qrs->bindParam(1, $display, PDO::PARAM_STR);
                    $qrs->bindParam(2, $menu_id, PDO::PARAM_INT);
                    if($qrs->execute() == 1) echo json_encode(array('data'=>'success'));
                    else 					 echo json_encode(array('data'=>'failed'));*/
                    break;

                case 'editMenu':
                    $menu_list=$this->MenuModel->get_menu_by_id($menu_id);
                    if(!empty($menu_list)) {
                        echo json_encode(array('data'=>$menu_list));
                    }
                    break;
            }
            exit();
        }

    }
    public function addMenu()
    {
        if ($this->request->getMethod() === 'post')
        {
            if($_POST['action']=='GrantPermission')
            {

            }elseif($_POST['action']=='Update') {

            }
            elseif($_POST['action']=='menuUpdate') {
                $menu_nm=htmlentities(trim($_POST['caption']));
                $priority=htmlentities(trim($_POST['priority']));
                $url=htmlentities(trim($_POST['url']));
                $menu_id=htmlentities(trim($_POST['menu_id']));
                $oldsmid=(int)$_POST['oldsmid'];
                $update_menu = [
                    'menu_nm'=>$menu_nm,
                    'priority'=>$priority,
                    'url' => $url,
                    'old_smenu_id' => $oldsmid,

                    'updated_on' => date("Y-m-d H:i:s"),
                    'updated_by'=>$_SESSION['login']['usercode'],
                    'updated_by_ip'=>getClientIP(),
                ];
                $is_update_menu = update('master.menu',$update_menu,['id'=>$menu_id]);
                if ($is_update_menu){
                    echo 'Updated';exit();
                }else{
                    echo 'Failed';exit();
                }
            }

            $menu_id=htmlentities(trim($_POST['mnid']));

            if($menu_id !='')
            {
                $disabled='';
                switch (strlen($menu_id)) {
                    case 2:
                        $squery="";
                        break;

                    case 4:
                        $squery="";
                        break;
                    case 6:
                        $squery="";
                        break;
                    case 8:
                        $squery="";
                        break;
                    case 10:
                        $squery="";
                        $disabled=' disabled';
                        break;
                }

            }
            else {
                $menuId=htmlentities(trim($_POST['menu']));
                $caption=htmlentities(trim($_POST['caption']));
                $priority=(int)$_POST['priority'];
                $display=htmlentities(trim(strtoupper($_POST['display'])));
                $url=htmlentities(trim($_POST['url']));
                if($url==null || $url=='') $url='#';
                $oldsmid=(int)$_POST['oldsmid'];
                if(!is_numeric($oldsmid)) $oldsmid=0;

                $child='child';
                for($i=1; $i<=5; $i++) 
                {
                    $childVar=$child.$i;
                    $$childVar=htmlentities(trim($_POST[$childVar]));
                    if(!$$childVar) break;
                }
                if(strstr($child5,'addNew')) 
                {
                    $preMenu=strtr($child5,array('addNew'=>''));
                }
                elseif(strstr($child4,'addNew')) 
                {
                    $preMenu=strtr($child4,array('addNew'=>''));
                }
                elseif(strstr($child3,'addNew')) 
                {
                    $preMenu=strtr($child3,array('addNew'=>''));
                }
                elseif(strstr($child2,'addNew')) 
                {
                    $preMenu=strtr($child2,array('addNew'=>''));
                }
                elseif(strstr($child1,'addNew')) 
                {
                    $preMenu=strtr($child1,array('addNew'=>''));
                }
                elseif(strstr($menuId,'addNew')) {

                }
            }
        }
    }
}
