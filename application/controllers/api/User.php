<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class User extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->methods['index_get']['limit'] = 500;
        $this->methods['index_post']['limit'] = 500;
        $this->methods['index_put']['limit'] = 500;
        $this->methods['index_delete']['limit'] = 500;
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id == null) {
            $user = $this->user->getUser();
        } else {
            $user = $this->user->getUser($id);
        }
        if ($user) {
            $this->response([
                'status' => true,
                'data' => $user
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id == null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->user->deleteUser($id) > 0) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted'

                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'id_user' => $this->post('id_user'),
            'nama_user' => $this->post('nama_user'),
            'fullname_user' => $this->post('fullname_user'),
            'password_user' => $this->post('password_user'),
            'saldo_user' => $this->post('saldo_user'),
            'level' => $this->post('level')
        ];

        if ($this->user->createUser($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new user has been created'

            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $beli = $this->put('beli');
        $harga = $this->put('harga');
        if ($id != null && $beli == null) {
            $data = [
                'id_user' => $this->put('id_user'),
                'nama_user' => $this->put('nama_user'),
                'fullname_user' => $this->put('fullname_user'),
                'password_user' => $this->put('password_user'),
                'saldo_user' => $this->put('saldo_user'),
                'level' => $this->put('level')
            ];

            if ($this->user->updateUser($data, $id) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'user has been updated'

                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed to update data'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }elseif($id != null && $beli == 'beli' && $harga != null ){
            $data = [

                'saldo_user' => $this->put('saldo_user') - $this->put('harga'),
            ];

            if ($this->user->updateUser($data, $id) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'user has been updated'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed to update data'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
