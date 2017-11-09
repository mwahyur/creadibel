<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subkategori_barang extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Subkategoribarang_model','subkategori');
    }

    public function index()
    {
        $this->load->helper('url');
        $datasubkategori = $this->subkategori->getDatasubkategori();
        $datakategori = $this->subkategori->getDatakategori();
        $data['kategori'] = $datakategori;
        $data['subkategori'] = $datasubkategori;
        $this->load->view('admin/Subkategoribarang_view',$data);
    }

    public function ajax_list()
    {
        $list = $this->subkategori->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $subkategori) {
            $no++;
            $row = array();
            $row[] = $subkategori->nama_kategori_barang;
            $row[] = $subkategori->nama_subkategori;
            $row[] = $subkategori->deskripsi_subkategori;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_subkategori('."'".$subkategori->id_subkategori."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_subkategori('."'".$subkategori->id_subkategori."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->subkategori->count_all(),
            "recordsFiltered" => $this->subkategori->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->subkategori->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();
        $data = array(
            'id_kategori_barang' => $this->input->post('id_kategori_barang'),
            'nama_subkategori' => $this->input->post('nama_subkategori'),
            'deskripsi_subkategori' => $this->input->post('deskripsi_subkategori'),
        );
        $insert = $this->subkategori->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();
        $data = array(
            'id_kategori_barang' => $this->input->post('id_kategori_barang'),
            'nama_subkategori' => $this->input->post('nama_subkategori'),
            'deskripsi_subkategori' => $this->input->post('deskripsi_subkategori'),
        );
        $this->subkategori->update(array('id_subkategori' => $this->input->post('id_subkategori')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->subkategori->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }


    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('nama_subkategori') == '')
        {
            $data['inputerror'][] = 'nama_subkategori';
            $data['error_string'][] = 'Nama subkategori is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}
