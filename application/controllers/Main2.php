<?php
/**
 * Created by PhpStorm.
 * User: PDH
 * Date: 2022-07-28
 * Time: 오후 2:41
 */

class Main2 extends CI_Controller{
    public function __construct(){
        parent::__construct();
        error_reporting(-1);
        ini_set('display_errors', 1);

        $this->yield    = false;
    }

    function index(){
	define('CURRENT_URI', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        echo "<pre>";
        print_r($this->session->userdata());
        echo "</pre>";
        $this->load->view('main2');
    }

}
