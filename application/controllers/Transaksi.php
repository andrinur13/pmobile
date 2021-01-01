<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Transaksi extends REST_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
    }

    public function index_get()
    {
        $this->response([
            'status' => true,
            'messages' => 'connected to Transaksi API'
        ], REST_Controller::HTTP_OK);
    }

    public function gettransaksi_get()
    {
        $data = $this->Transaksi_model->gettransaksi();
        $this->response([
            'status' => true,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function gettransaksibyid_get()
    {
        $id = $this->input->get('id_transaksi');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $data = $this->Transaksi_model->gettransaksibyid($id);

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

    public function addtransaksi()
    {
        $id_pemesanan = $this->post('id_pemesanan');
        $waktu_konfirmasi = date('Y-m-d');
        $konfirmasi = 1;

        $data = [
            'id_transaksi' => '',
            'id_pemesanan' => $id_pemesanan,
            'waktu_konfirmasi' => $waktu_konfirmasi,
            'konfirmasi' => $konfirmasi
        ];

        if ($this->Transaksi_model->addtransaksi($data) > 0) {
            $this->response([
                'status' => true,
                'messages' => 'data has been added!'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'messages' => 'data failed to created!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deletetransaksi_delete()
    {
        $id = $this->delete('id_transaksi');

        if ($id == null) {
            $this->response([
                'status' => true,
                'messages' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        if ($this->Transaksi_model->deletetransaksi($id) > 0) {
            $this->response([
                'status' => true,
                'messages' => 'data has been deleted!'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'messages' => 'data failed to deleted. Id not fond!'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function edittransaksi_put()
    {
        $id = $this->put('id_transaksi');

        if ($id === null) {
            $this->response([
                'status' => false,
                'messages' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $id_pemesanan = $this->put('id_pemesanan');
        $waktu_konfirmasi = date('Y-m-d');
        $konfirmasi = 1;

        $data = [
            'id_pemesanan' => $id_pemesanan,
            'waktu_konfirmasi' => $waktu_konfirmasi,
            'konfirmasi' => $konfirmasi
        ];

        if ($this->Transaksi_model->edittransaksi($data, $id) > 0) {
            $this->response([
                'status' => true,
                'messages' => 'data has been modified!'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'messages' => 'data failed to modified. id not found!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getpendapatan_get()
    {
        $data = $this->Transaksi_model->getpendapatan();
        $this->response([
            'status' => true,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }
}
