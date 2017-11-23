<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_user extends CI_Controller {

     public function __construct()
    {
        parent::__construct();
        $this->load->model('Loginuser_model','loginuser');
    }

    public function index()
    {
    	
    }

    public function proseslogin(){
        $usr = $this->input->post('username');
        $psw = $this->input->post('password');
        $u = $usr;
        $p = md5($psw);
        // echo $p;
        // exit;
        $cek = $this->loginuser->cek($u, $p);
        if ($cek->num_rows() > 0) {
        //Login berhasil, buat session
        foreach ($cek->result() as $qad) {
          $sess_data['id_user'] = $qad->id_user;
          $sess_data['username_user'] = $qad->username_user;
          $sess_data['nama_user'] = $qad->nama_user;
          $this->session->set_userdata($sess_data);
        }
        $this->session->set_flashdata('success', 'Login Berhasil !');
        // echo "<pre>";
        // var_dump($sess_data);
        // echo "</pre>";
        // exit;
        redirect(base_url('Home'));
        } else {
        $this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
        echo "salah";
        }
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url('Home'));
    }
}