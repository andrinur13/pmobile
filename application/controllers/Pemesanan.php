<?php

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Pemesanan extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pemesanan_model');
    }

    public function index_get()
    {
        $this->response([
            'status' => true,
            'messages' => 'Connected to API Pemesanan'
        ], REST_Controller::HTTP_OK);
    }

    public function getpemesanan_get()
    {
        $data = $this->Pemesanan_model->getpemesanan();
        $this->response([
            'status' => true,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function getpemesananbyid_get()
    {
        $id = $this->get('id_pemesanan');

        if ($id === null) {
            $this->response([
                'status' => false,
                'messages' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $data = $this->Pemesanan_model->getpemesananbyid($id);

        if ($data == null) {
            $this->response([
                'status' => false,
                'messages' => 'id not found!'
            ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }
    }

    public function getpemesananbyname_get()
    {
        $username = $this->input->get('username');

        if ($username === null) {
            $this->response([
                'status' => false,
                'message' => 'provide username'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $data = $this->Pemesanan_model->getpemesananbyname($username);
        if ($data == null) {
            $this->response([
                'status' => false,
                'message' => 'ordered by id not found!'
            ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }
    }

    public function getpemesananbydate_get()
    {
        $date_input = $this->get('date-input');
        if ($date_input === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an date!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        $data = $this->Pemesanan_model->getpemesananbydate($date_input);
        if ($data == null) {
            $this->response([
                'status' => false,
                'mesage' => 'pemesanan by date not found!'
            ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }
    }

    public function addpemesanan_post()
    {
        $id_jadwal = $this->input->post('id_jadwal');
        $id_user = $this->input->post('id_user');
        $nama_pemesan = $this->input->post('nama_pemesan');
        $hp_pemesan = $this->input->post('hp_pemesan');
        $tanggal_main = $this->input->post('tanggal_main');
        $tanggal_pesan = date('Y-m-d');

        $data = [
            'id_pemesanan' => '',
            'id_jadwal' => $id_jadwal,
            'id_user' => $id_user,
            'nama_pemesan' => $nama_pemesan,
            'hp_pemesan' => $hp_pemesan,
            'tanggal_main' => $tanggal_main,
            'tanggal_pesan' => $tanggal_pesan
        ];

        if ($this->Pemesanan_model->addpemesanan($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'pemesanan has been added.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'pemesanan failed to create'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deletepemesanan_delete()
    {
        $id = $this->delete('id_pemesanan');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            die;
        }

        if ($this->Pemesanan_model->deletepemesanan($id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data has been deleted!'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data failed to deleted'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editpemesanan_put()
    {
        $id = $this->put('id_pemesanan');

        if ($id === null) {
            $this->response([
                'status' => false,
                'messages' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $id_jadwal = $this->put('id_jadwal');
        $id_user = $this->put('id_user');
        $nama_pemesan = $this->put('nama_pemesan');
        $hp_pemesan = $this->put('hp_pemesan');
        $tanggal_main = $this->put('tanggal_main');

        $data = [
            'id_jadwal' => $id_jadwal,
            'id_user' => $id_user,
            'nama_pemesan' => $nama_pemesan,
            'hp_pemesan' => $hp_pemesan,
            'tanggal_main' => $tanggal_main,
        ];

        if ($this->Pemesanan_model->editpemesanan($data, $id) > 0) {
            $this->response([
                'status' => true,
                'messages' => 'data has been modified!'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'messages' => 'data failed to modified!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
