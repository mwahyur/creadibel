<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Barang_model','barang');
    }

    public function index()
    {
        $this->load->helper('url');
        $datakatbarang = $this->barang->getDatakatbarang();
        $datasubkatbarang = $this->barang->getDatasubkatbarang();
        $data['katbarang'] = $datakatbarang;
        $data['subkatbarang'] = $datasubkatbarang;
        $this->load->view('admin/Barang_view',$data);
    }

    public function formatrp($angka){
        $format_angka = number_format($angka, "2", ",", ".");
        echo "Rp ".$format_angka;
    }

    public function ajax_list()
    {
        $list = $this->barang->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $barang) {
            $no++;
            $row = array();
            $format_angka = number_format($barang->harga_barang, "2", ",", ".");
            $harga = "Rp ".$format_angka;
            $row[] = $barang->nama_barang;
            $row[] = $barang->nama_kategori_barang;
            $row[] = $barang->nama_subkategori;
            // $row[] = $barang->diskripsi_barang;
            $row[] = $harga;
            $row[] = $barang->stok_barang;
            if($barang->foto1_barang)
                $row[] = '<a href="'.base_url('asset/galery/'.$barang->foto1_barang).'" target="_blank"><img src="'.base_url('asset/galery/'.$barang->foto1_barang).'" class="img-responsive" /></a>';
            else
                $row[] = '(No photo)';
 

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_barang('."'".$barang->id_barang."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_barang('."'".$barang->id_barang."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->barang->count_all(),
            "recordsFiltered" => $this->barang->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    private function _do_upload()
    {
        $config['upload_path']          = 'asset/galery/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1000; //set max size allowed in Kilobyte
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
 
        $this->load->library('upload', $config);
 
        if(!$this->upload->do_upload('foto1_barang')) //upload and validate
        {
            $data['inputerror'][] = 'foto1_barang';
            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }

        return $this->upload->data('file_name');
    }

    private function _do_upload2()
    {
        $config['upload_path']          = 'asset/galery/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1000; //set max size allowed in Kilobyte
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
 
        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('foto2_barang')) //upload and validate
        {
            $data['inputerror'][] = 'foto2_barang';
            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }

        return $this->upload->data('file_name');
    }

    private function _do_upload3()
    {
        $config['upload_path']          = 'asset/galery/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1000; //set max size allowed in Kilobyte
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
 
        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('foto3_barang')) //upload and validate
        {
            $data['inputerror'][] = 'foto3_barang';
            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

    public function ajax_edit($id)
    {
        $data = $this->barang->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();
        $data = array(
            'nama_barang' => $this->input->post('nama_barang'),
            'id_kategori_barang' => $this->input->post('id_kategori_barang'),
            'id_subkategori' => $this->input->post('id_subkategori'),
            'diskripsi_barang' => $this->input->post('diskripsi_barang'),
            'berat_barang' => $this->input->post('berat_barang'),
            'harga_barang' => $this->input->post('harga_barang'),
            'stok_barang' => $this->input->post('stok_barang'),
        );

        if(!empty($_FILES['foto1_barang']['name']))
        {
            $upload1 = $this->_do_upload();
            $data['foto1_barang'] = $upload1;
        }

        if(!empty($_FILES['foto2_barang']['name']))
        {
            $upload2 = $this->_do_upload2();
            $data['foto2_barang'] = $upload2;
        }

        if(!empty($_FILES['foto3_barang']['name']))
        {
            $upload3 = $this->_do_upload3();
            $data['foto3_barang'] = $upload3;
        }
 
        $insert = $this->barang->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();
        $data = array(
            'nama_barang' => $this->input->post('nama_barang'),
            'id_kategori_barang' => $this->input->post('id_kategori_barang'),
            'id_subkategori' => $this->input->post('id_subkategori'),
            'diskripsi_barang' => $this->input->post('diskripsi_barang'),
            'berat_barang' => $this->input->post('berat_barang'),
            'harga_barang' => $this->input->post('harga_barang'),
            'stok_barang' => $this->input->post('stok_barang'),
        );

        if($this->input->post('remove_photo1')) // if remove photo checked
        {
            if(file_exists('asset/galery/'.$this->input->post('remove_photo1')) && $this->input->post('remove_photo1'))
                unlink('asset/galery/'.$this->input->post('remove_photo1'));
            $data['foto1_barang'] = '';
        }

        if($this->input->post('remove_photo2')) // if remove photo checked
        {
            if(file_exists('asset/galery/'.$this->input->post('remove_photo2')) && $this->input->post('remove_photo2'))
                unlink('asset/galery/'.$this->input->post('remove_photo2'));
            $data['foto2_barang'] = '';
        }

        if($this->input->post('remove_photo3')) // if remove photo checked
        {
            if(file_exists('asset/galery/'.$this->input->post('remove_photo3')) && $this->input->post('remove_photo3'))
                unlink('asset/galery/'.$this->input->post('remove_photo3'));
            $data['foto3_barang'] = '';
        }
 
        if(!empty($_FILES['foto1_barang']['name']))
        {
            $upload = $this->_do_upload();
             
            //delete file
            $barang = $this->barang->get_by_id($this->input->post('id_barang'));
            if(file_exists('asset/galery/'.$barang->foto1_barang) && $barang->foto1_barang)
                unlink('asset/galery/'.$barang->foto1_barang);
 
            $data['foto1_barang'] = $upload;
        }

        if(!empty($_FILES['foto2_barang']['name']))
        {
            $upload2 = $this->_do_upload2();
             
            //delete file
            $barang = $this->barang->get_by_id($this->input->post('id_barang'));
            if(file_exists('asset/galery/'.$barang->foto2_barang) && $barang->foto2_barang)
                unlink('asset/galery/'.$barang->foto2_barang);
 
            $data['foto2_barang'] = $upload2;
        }

        if(!empty($_FILES['foto3_barang']['name']))
        {
            $upload3 = $this->_do_upload3();
             
            //delete file
            $barang = $this->barang->get_by_id($this->input->post('id_barang'));
            if(file_exists('asset/galery/'.$barang->foto3_barang) && $barang->foto3_barang)
                unlink('asset/galery/'.$barang->foto3_barang);
 
            $data['foto3_barang'] = $upload3;
        }

        $this->barang->update(array('id_barang' => $this->input->post('id_barang')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $barang = $this->barang->get_by_id($id);
        if(file_exists('asset/galery/'.$barang->foto1_barang) && $barang->foto1_barang)
            unlink('asset/galery/'.$barang->foto1_barang);
        if(file_exists('asset/galery/'.$barang->foto2_barang) && $barang->foto2_barang)
            unlink('asset/galery/'.$barang->foto2_barang);
        if(file_exists('asset/galery/'.$barang->foto3_barang) && $barang->foto3_barang)
            unlink('asset/galery/'.$barang->foto3_barang);
        
        $this->barang->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }


    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('nama_barang') == '')
        {
            $data['inputerror'][] = 'nama_barang';
            $data['error_string'][] = 'Nama barang is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('diskripsi_barang') == '')
        {
            $data['inputerror'][] = 'diskripsi_barang';
            $data['error_string'][] = 'Diskripsi barang is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}
