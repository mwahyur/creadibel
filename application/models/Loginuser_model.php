<?php
  class Loginuser_model extends CI_Model {

      var $tb_barang = 'tb_barang';
      var $tbltransaksi = 'tb_transaksi_barang';

      public function __construct()
      {
          parent::__construct();
          $this->load->library('encrypt');
      }

      function cek($username, $password) {
        $this->db->where("username_user", $username);
        $this->db->where("pwd_user", $password);
        return $this->db->get("tb_user");
      }

      function getLoginData($usr, $psw) {
        $u = $usr;
        $p = $psw;
        $q_cek_login = $this->db->get_where('tb_user', array('username_user' => $u, 'pwd_user' => $p));
        if (count($q_cek_login->result()) > 0) {
          foreach ($q_cek_login->result() as $qck) {
            foreach ($q_cek_login->result() as $qad) {
              $sess_data['logged_in'] = TRUE;
              $sess_data['id_user'] = $qad->id_user;
              $sess_data['username_user'] = $qad->username_user;
              $sess_data['nama_user'] = $qad->nama_user;
              $this->session->set_userdata($sess_data);
            }
          redirect('Home');
          }
        } else {
            $this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
            header('location:' . base_url() . 'Home');
          }
      }
  }
?>
