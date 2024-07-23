<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use eftec\bladeone\BladeOne;
use CodeIgniter\Exceptions\PageNotFoundException;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $db;
    protected $eservicesdb;
    protected $request;
    protected $session;
    protected $security;
    protected $validation;
    private $templateEngine;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url', 'form', 'functions', 'common'];
    //protected $helpers = [];

    /**
     * Constructor.
     */

    public function __construct()
    {
        // Preload any models, libraries, etc, here.
        $this->db = \Config\Database::connect();
        $this->eservicesdb = \Config\Database::connect('eservices');
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->security = \Config\Services::security();
        $this->validation = \Config\Services::validation();
        $this->request = \Config\Services::request();
        date_default_timezone_set('Asia/Calcutta');
    }
    // public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    // {
    //     // Do Not Edit This Line
    //     parent::initController($request, $response, $logger);


    //     if (isset($_SESSION['login'])) {
    //         //header('Location:'.base_url('Signout'));exit();
    //     }else {
    //         header('Location:'.base_url('Signout'));exit();
    //     }
    // }

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $views = APPPATH . 'Views';
        $cache = WRITEPATH . 'cache';

        // if (ENVIRONMENT === 'production') {
        //     $this->templateEngine = new BladeOne(
        //         $views,
        //         $cache,
        //         BladeOne::MODE_AUTO
        //     );
        // } else {
        //     $this->templateEngine = new BladeOne(
        //         $views,
        //         $cache,
        //         BladeOne::MODE_DEBUG
        //     );
        // }

        // $this->templateEngine->pipeEnable = true;
        // $this->templateEngine->setBaseUrl(base_url());

        // $ref = isset($_SERVER['HTTP_REFERER']);
        // $refData = parse_url($ref);
        // if (isset($refData['host']) != $_SERVER['SERVER_NAME'] && isset($refData['host']) != NULL) {
        //     redirect("login");
        //     exit(0);
        // }
        // if (count($_POST) > 0) {
        //     print_r($_POST);die;
        //     if ($_POST['CSRF_TOKEN'] != $_SESSION['csrf_to_be_checked']) {
        //         $this->session->set_flashdata('msg', 'Captcha expired !');
        //         redirect('login');
        //         exit(0);
        //     }
        // }
    }
    public function render($view, $data = [])
    {
        $views = APPPATH . 'Views'; // Path to your views directory
        $cache = WRITEPATH . 'cache'; // Path to your cache directory

        $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

        echo $blade->run($view, $data);
    }
}
