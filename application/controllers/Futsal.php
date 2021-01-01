<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Futsal extends REST_Controller
{
    public function index_get()
    {
        $this->response([
            'status' => true,
            'messages' => 'this API from futsaloka!'
        ], REST_Controller::HTTP_OK);
    }
}
