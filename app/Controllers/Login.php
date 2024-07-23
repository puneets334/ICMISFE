<?php

namespace App\Controllers;
use App\Models\LoginModel;
use App\Models\MenuModel;
use CodeIgniter\Controller;

class Login extends Controller
{
    protected $session;

    function __construct()
    {   $session = session();
        $this->session = \Config\Services::session();
        $security = \Config\Services::security();
        $this->session->start();
        // $this->LoginModel = new LoginModel();
        helper(['url', 'form']);
        helper("functions");
    }

    public function index()
    {
        /*$MenuModel = new MenuModel();
        $MenuModel->get_Main_menus(1);*/
        $_SESSION['login_salt'] =$this->generateRandomString();
        unset($_SESSION['login_data']);
        unset($_SESSION['user_section']);
        //echo '<pre>';print_r($_SESSION);exit();
        return view('login');
    }
    private function generateRandomString($length = 10) {
        // generates random string for login salt
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function checkLogin()
    { // echo 'ssss';exit();
        //if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($this->request->getMethod() === 'post' && $this->validate([
                'txtuname' => ['label' => 'User Name', 'rules' => 'required|min_length[1]|max_length[8]'],
                'txtpass' => ['label' => 'User Password', 'rules' => 'required|min_length[8]'],
            ])) {
            $LoginModel = new LoginModel();
             $username = $this->request->getPost('txtuname');
             $password = $this->request->getPost('txtpass');
            //$password = $this->decode_password($password);
            $row_foruser =$LoginModel->checkLogin($username,$password);
            //echo '<pre>';print_r($row_foruser);exit();
            if($row_foruser){
                if ($row_foruser['attend'] == 'A') {
                    //$errorMessage = "User is Marked as Absent";
                    session()->setFlashdata("message_error", 'User is Marked as Absent');
                    return redirect()->to('Login');
                }
                else {
                    $is_login_in_update=$LoginModel->login_in_update($username);
                    if ($is_login_in_update) {
                        $is_login=$LoginModel->get_usertype_detials($row_foruser);
                        $login=session()->get('login');
                        if ($login && !empty($is_login)){
                            //return redirect()->to('Filing/Diary');
                            return redirect()->to('Supreme_court');
                        }else{
                            session()->setFlashdata("message_error", 'Please contact to Computer Cell.');
                        }

                        //return redirect()->to('Supreme_court');
                        // return view('login');
                        // header('Location: index.php');  exit();

                    }else{
                        session()->setFlashdata("message_error", 'Invalid credentials.');
                        //return redirect()->to('Login');
                    }
                }


            }else{
                unset($_SESSION['login_data']);
                unset($_SESSION['user_section']);
                session()->setFlashdata("message_error", 'Invalid credentials.');
                //$errorMessage = "Employee ID OR Password is Incorrect. Try again or contact to Computer Cell.";
                // return view('login');
            }
        }
        else
        {
            $_SESSION['login_salt'] =$this->generateRandomString();
            unset($_SESSION['login_data']);
            unset($_SESSION['user_section']);
            return view('login');
        }

        $_SESSION['login_salt'] =$this->generateRandomString();
        unset($_SESSION['login_data']);
        unset($_SESSION['user_section']);
        return view('login');
    }
    function redirect_on_login() {
        echo 'redirect_on_login';
        echo '<pre>'; print_r($_SESSION);//exit();
        return redirect()->to('Home');
        //return redirect()->to('dashboard');
    }
}
