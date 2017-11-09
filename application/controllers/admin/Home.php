<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('admin/Mod_Login');
		if (!isset($this->session->userdata['id'])) {
			redirect(base_url("admin/Login"));
		}
	}

	public function index() {
		$jp = $this->Mod_Login->jumproduk();
		$js = $this->Mod_Login->jumtransaksi();

		$data['produk'] = count($jp);
		$data['transaksi'] = count($js);
		
		$this->load->view('admin/Dashboard1',$data);
	}
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('admin/Login'));
	}
}
