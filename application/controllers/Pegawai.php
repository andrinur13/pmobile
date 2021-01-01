<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;


class Pegawai extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Pegawai_model');
    }

    public function index_get()
    {
        $this->response([
            'status' => true,
            'messages' => 'Connected User API'
        ], REST_Controller::HTTP_OK);
    }

    public function getpegawai_get()
    {
        $data = $this->Pegawai_model->getpegawai();
        $this->response([
            'status' => true,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    

    public function getpegawaibyid_get()
    {
        $id = $this->get('id');


        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $data = $this->Pegawai_model->getpegawaibyid($id);

        if ($data == null) {
            $this->response([
                'status' => false,
                'message' => 'id not found!'
            ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }
    }

    public function addpegawai_post()
    {
        $email = $this->post('email');
        $name = $this->post('name');
        $alamat = $this->post('alamat');

        $data = [
            'id' => '',
            'name' => $name,
            'email' => $email,
            'alamat' => $alamat,
        ];


        if ($this->Pegawai_model->addpegawai($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Data has been added!'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data failed created!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editpegawai_put()
    {
        $id = $this->put('id');

        if($id == null) {
            return $this->response([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ]);
        } else {
            $query = $this->Pegawai_model->getpegawaibyid($id);

            if($query == null) {
                return $this->response([
                    'status' => 'failed',
                    'messages' => 'id not found!'
                ], REST_Controller::HTTP_NOT_FOUND);
            } else {

                $data = [
                    'email' => $this->put('email'),
                    'name' => $this->put('name'),
                    'alamat' => $this->put('alamat')
                ];

                if($this->Pegawai_model->editpegawai($data, $id)>0) {
                    return $this->response([
                        'status' => 'success',
                        'data' => $data
                    ], REST_Controller::HTTP_OK);
                }                
            }
        }

    }

    public function deletepegawai_delete()
    {
        $id = $this->delete('id');
        
        if ($id === null) {
            $this->response([
                'status' => false,
                'messages' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        if ($this->Pegawai_model->deletepegawai($id) > 0) {
            $this->response([
                'status' => true,
                'messages' => 'data has been deleted!'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'messages' => 'data failed to deleted!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
