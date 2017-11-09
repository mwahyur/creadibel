<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/User_admin_model','useradmin');
        $this->load->library('encrypt');
    }

    public function index()
    {
        $this->load->helper('url');
        $datauseradmin = $this->useradmin->getDatauseradmin();
        $datauserlevel = $this->useradmin->getDataLevel();
        $data['useradmin'] = $datauseradmin;
        $data['level'] = $datauserlevel;
        $this->load->view('admin/Useradmin_view',$data);
    }

    public function ajax_list()
    {
        $list = $this->useradmin->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $useradmin) {
            $no++;
            $row = array();
            $row[] = $useradmin->nama_admin;
            $row[] = $useradmin->username;
            $row[] = $useradmin->email;
            $row[] = $useradmin->diskripsi;
            $row[] = $useradmin->ket_level;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_useradmin('."'".$useradmin->id_admin."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_useradmin('."'".$useradmin->id_admin."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->useradmin->count_all(),
            "recordsFiltered" => $this->useradmin->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->useradmin->get_by_id($id);
        $datap = $this->useradmin->getDatauseradminbyid($id);
        foreach($datap as $d){
            $pwd = $d->password;
            $data1 = md5($pwd);
            echo $data1;
            exit;
        }
        echo json_encode(array("pass"=>$data1, "data" => $data));
    }

    public function ajax_add()
    {
        $this->_validate();
        $data = array(
            'nama_admin' => $this->input->post('nama_admin'),
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
            'email' => $this->input->post('email'),
            'diskripsi' => $this->input->post('diskripsi'),
            'id_level' => $this->input->post('id_level'),
            'status_admin' => 'Y',
        );
        $insert = $this->useradmin->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();
        $data = array(
            'nama_admin' => $this->input->post('nama_admin'),
            'username' => $this->input->post('username'),
            // 'password' => md5($this->input->post('password')),
            'email' => $this->input->post('email'),
            'diskripsi' => $this->input->post('diskripsi'),
            'id_level' => $this->input->post('id_level'),
            'status_admin' => 'Y',
        );
        $this->useradmin->update(array('id_admin' => $this->input->post('id_admin')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->useradmin->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }


    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}
