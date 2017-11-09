<?php
  class Mod_Login extends CI_Model {

      var $tb_barang = 'tb_barang';
      var $tbltransaksi = 'tb_transaksi_barang';

      public function __construct()
      {
          parent::__construct();
          $this->load->library('encrypt');
      }

      function cek($username, $password) {
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        return $this->db->get("tb_admin");
      }

      function getLoginData($usr, $psw) {
        $u = $usr;
        $p = $psw;
        $q_cek_login = $this->db->get_where('tb_admin', array('username' => $u, 'password' => $p));
        if (count($q_cek_login->result()) > 0) {
          foreach ($q_cek_login->result() as $qck) {
            foreach ($q_cek_login->result() as $qad) {
              $sess_data['logged_in'] = TRUE;
              $sess_data['id'] = $qad->id_admin;
              $sess_data['username'] = $qad->username;
              $sess_data['password'] = $qad->password;
              $sess_data['nama'] = $qad->nama_admin;
              $sess_data['id_level'] = $qad->id_level;
              // $sess_data['status'] = $qad->nama_pengguna;
              // $sess_data['level'] = $qad->level;
              $this->session->set_userdata($sess_data);
            }
          redirect('admin/Home');
          }
        } else {
            $this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
            header('location:' . base_url() . 'admin/Login');
          }
      }

      public function jumproduk(){
          $this->db->from($this->tb_barang);
          $query = $this->db->get();

          return $query->result();
      }
      public function jumtransaksi(){
          $this->db->from($this->tbltransaksi);
          $query = $this->db->get();

          return $query->result();
      }
  }
?>
