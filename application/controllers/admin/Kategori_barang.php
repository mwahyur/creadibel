<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_barang extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Kategoribarang_model','kategori');
    }

    public function index()
    {
        $this->load->helper('url');
        $datakategori = $this->kategori->getDatakategori();
        $data['kategori'] = $datakategori;
        $this->load->view('admin/Kategoribarang_view',$data);
    }

    public function ajax_list()
    {
        $list = $this->kategori->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kategori) {
            $no++;
            $row = array();
            $row[] = $kategori->nama_kategori_barang;
            $row[] = $kategori->diskripsi_kategori_barang;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_kategori('."'".$kategori->id_kategori_barang."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_kategori('."'".$kategori->id_kategori_barang."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kategori->count_all(),
            "recordsFiltered" => $this->kategori->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->kategori->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();
        $data = array(
            'nama_kategori_barang' => $this->input->post('nama_kategori_barang'),
            'diskripsi_kategori_barang' => $this->input->post('diskripsi_kategori_barang'),
        );
        $insert = $this->kategori->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();
        $data = array(
            'nama_kategori_barang' => $this->input->post('nama_kategori_barang'),
            'diskripsi_kategori_barang' => $this->input->post('diskripsi_kategori_barang'),
        );
        $this->kategori->update(array('id_kategori_barang' => $this->input->post('id_kategori_barang')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->kategori->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }


    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('nama_kategori_barang') == '')
        {
            $data['inputerror'][] = 'nama_kategori_barang';
            $data['error_string'][] = 'Nama Kategori is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('diskripsi_kategori_barang') == '')
        {
            $data['inputerror'][] = 'diskripsi_kategori_barang';
            $data['error_string'][] = 'Diskripsi Kategori Barang is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}
