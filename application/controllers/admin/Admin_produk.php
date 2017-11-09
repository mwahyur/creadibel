<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_produk extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Produk_model','produk');
    }

    public function index()
    {
        $this->load->helper('url');
        $dataproduk = $this->produk->getDataproduk();
        $data['produk'] = $dataproduk;
        $this->load->view('admin/Produk_view',$data);
    }

    public function ajax_list()
    {
        $list = $this->produk->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $produk) {
            $no++;
            $row = array();
            $row[] = $produk->kodeproduk;
            $row[] = $produk->namaproduk;
            $row[] = $produk->jenisproduk;
            $row[] = $produk->stok;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="show_produk('."'".$produk->idproduk."'".')"><i class="glyphicon glyphicon-zoom-in"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->produk->count_all(),
            "recordsFiltered" => $this->produk->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_show($id)
    {
        $data = $this->produk->get_by_id($id);
        // $data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }

    public function ajax_update()
    {
        $this->_validate();
        $data = array(
            'nama_produk' => $this->input->post('nama_produk'),
            'jenis_produk' => $this->input->post('jenis_produk'),
            'harga' => $this->input->post('harga'),
            'stok' => $this->input->post('stok'),
            'status_produk' => $this->input->post('status_produk'),
        );
        $this->produk->update(array('kode_produk' => $this->input->post('kode_produk')), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('nama_produk') == '')
        {
            $data['inputerror'][] = 'nama_produk';
            $data['error_string'][] = 'nama_produk is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('jenis_produk') == '')
        {
            $data['inputerror'][] = 'jenis_produk';
            $data['error_string'][] = 'jenis_produk is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('harga') == '')
        {
            $data['inputerror'][] = 'harga';
            $data['error_string'][] = 'harga is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('stok') == '')
        {
            $data['inputerror'][] = 'stok';
            $data['error_string'][] = 'stok is required';
            $data['status'] = FALSE;
        }
        if($this->input->post('status_produk') == '')
        {
            $data['inputerror'][] = 'status_produk';
            $data['error_string'][] = 'status_produk is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}
