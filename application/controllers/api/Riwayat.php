<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Riwayat extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Riwayat_model', 'riwayat');
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id == null) {
            $riwayat = $this->riwayat->getRiwayat();
        } else {
            $riwayat = $this->riwayat->getRiwayat($id);
        }
        if ($riwayat) {
            $this->response([
                'status' => true,
                'data' => $riwayat
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $data = [
            'id_pembelian' => '',
            'id_user' => $this->post('id_user'),
            'nama_user' => $this->post('nama_user'),
            'id_headset' => $this->post('id_headset'),
            'nama_headset' => $this->post('nama_headset'),
            'saldo_awal' => $this->post('saldo_awal'),
            'saldo_akhir' => $this->post('saldo_akhir')
        ];

        if ($this->riwayat->createRiwayat($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new riwayat has been created'

            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
