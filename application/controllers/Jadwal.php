<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use PhpParser\Node\Stmt\Return_;
use Restserver\Libraries\REST_Controller;


class Jadwal extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Jadwal_model');
    }

    function index_get()
    {
        $this->response([
            'status' => true,
            'message' => 'connected to API Jadwal'
        ], REST_Controller::HTTP_OK);
    }

    function getjadwal_get()
    {
        $jadwal = $this->Jadwal_model->getAllJadwal();

        $this->response([
            'status' => true,
            'data' => $jadwal
        ], REST_Controller::HTTP_OK);
    }

    function getjadwalbyid_get()
    {
        $id = $this->get('id');

        $jadwal = $this->Jadwal_model->getJadwalById($id);

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($jadwal == null) {
                $this->response([
                    'status' => false,
                    'message' => 'Id Not Found'
                ], REST_Controller::HTTP_NOT_FOUND);
            } else {
                $this->response([
                    'status' => true,
                    'data' => $jadwal
                ], REST_Controller::HTTP_OK);
            }
        }
    }

    public function addjadwal_post()
    {
        $jam = $this->post('jam');
        $tarif  = $this->post('tarif');

        $data = [
            'id_jadwal' => '',
            'jam' => $jam,
            'tarif' => $tarif
        ];

        if ($this->Jadwal_model->addJadwal($data)) {
            $this->response([
                'status' => true,
                'messages' => 'jadwal has been added!'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'messages' => 'jadwal failed to added!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deletejadwal_delete()
    {
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => false,
                'messages' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        if ($this->Jadwal_model->deleteJadwal($id) > 0) {
            $this->response([
                'status' => true,
                'messages' => 'data has been deleted!'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'messages' => 'id not found!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editjadwal_put()
    {
        $id = $this->put('id');

        if ($id === null) {
            $this->response([
                'status' => false,
                'messages' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $data = [
            'jam' => $this->put('jam'),
            'tarif' => $this->put('tarif')
        ];

        if ($this->Jadwal_model->editJadwal($data, $id) > 0) {
            $this->response([
                'status' => true,
                'messages' => 'jadwal has been modified!'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'messages' => 'jadwal failed to modified!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
