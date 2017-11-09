<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  function __construct() {
    parent::__construct();
    if ($this->session->userdata('username')) {
      redirect(base_url('admin/Home'));
    }
    $this->load->model(array('admin/Mod_Login'));
    $this->load->library('encryption');
  }
  function index() {
    $this->load->view('admin/Login');
  }

  public function Proses() {
    $this->form_validation->set_rules('username', 'username', 'required|trim|xss_clean');
    $this->form_validation->set_rules('password', 'password', 'required|trim|xss_clean');
    if ($this->form_validation->run() == FALSE) {
      $this->load->view('admin/Login');
    } else {
      $usr = $this->input->post('username');
      $psw = $this->input->post('password');
      $u = $usr;
      $p = md5($psw);
      // echo $p;
      // exit;
      $cek = $this->Mod_Login->cek($u, $p);
      if ($cek->num_rows() > 0) {
        //Login berhasil, buat session
        foreach ($cek->result() as $qad) {
          $sess_data['id'] = $qad->id_admin;
          $sess_data['username'] = $qad->username;
          $sess_data['nama'] = $qad->nama_admin;
          $sess_data['id_level'] = $qad->id_level;
          $this->session->set_userdata($sess_data);
        }
        $this->session->set_flashdata('success', 'Login Berhasil !');
        redirect(base_url('admin/Home'));
      } else {
        $this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
        redirect(base_url('admin/Login'));
      }
    }
  }
}
