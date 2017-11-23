<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrasi extends CI_Controller {

     public function __construct()
    {
        parent::__construct();
        $this->load->model('Registrasi_model','registrasi');
    }

    public function index()
    {
    	$this->load->view('Registrasi_u');
    }

    public function Adduser(){
    	$data = array(
            'nama_user' => $this->input->post('nama_user'),
            'username_user' => $this->input->post('username_user'),
            'pwd_user' => md5($this->input->post('pwd_user')),
            'email_user' => $this->input->post('email_user'),
            'tlp_user' => $this->input->post('tlp_user'),
        );
        $this->registrasi->save($data);
        redirect(base_url("Home"));
    }

}
