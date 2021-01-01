<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;


class User extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index_get()
    {
        $this->response([
            'status' => true,
            'messages' => 'Connected User API'
        ], REST_Controller::HTTP_OK);
    }

    public function getuser_get()
    {
        $data = $this->User_model->getuser();
        $this->response([
            'status' => true,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function getusername_post()
    {
        $username = $this->post('username');

        if ($username === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an username!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $data = $this->User_model->getuserbyname($username);

        if ($data == null) {
            $this->response([
                'status' => false,
                'message' => 'username not found!'
            ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }
    }

    public function getuserbyid_get()
    {
        $id = $this->get('id');

        var_dump($id);
        die;

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $data = $this->User_model->getuserbyid($id);

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

    public function adduser_post()
    {
        $username = $this->post('username');
        $name = $this->post('name');
        $password = password_hash($this->post('password'), PASSWORD_DEFAULT);
        $email = $this->post('email');
        $level = $this->post('user_type');
        $user_created = date('Y-m-d');

        $data = [
            'id' => '',
            'username' => $username,
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'user_type' => $level,
        ];


        if ($this->User_model->adduser($data) > 0) {
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

    public function edituser_put()
    {
        $id = $this->put('id');

        if($id == null) {
            return $this->response([
                'status' => 'failed',
                'messages' => 'provide an id!'
            ]);
        } else {
            $query = $this->User_model->getuserbyid($id);

            if($query == null) {
                return $this->response([
                    'status' => 'failed',
                    'messages' => 'id not found!'
                ], REST_Controller::HTTP_NOT_FOUND);
            } else {

                $data = [
                    'username' => $this->put('username'),
                    'email' => $this->put('email'),
                    'name' => $this->put('name'),
                    'password' => password_hash($this->put('password'), PASSWORD_DEFAULT),
                    'user_type' => $this->put('user_type')
                ];

                if($this->User_model->edituser($data, $id)>0) {
                    return $this->response([
                        'status' => 'success',
                        'data' => $query
                    ], REST_Controller::HTTP_OK);
                }                
            }
        }


        if ($this->User_model->edituser($data, $id) > 0) {
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

    public function deleteuser_delete()
    {
        $id = $this->delete('id');
        
        if ($id === null) {
            $this->response([
                'status' => false,
                'messages' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        if ($this->User_model->deleteuser($id) > 0) {
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
