<?php

class Riwayat_model extends CI_Model
{
    public function getRiwayat($id = null)
    {
        if ($id == null) {
            return $this->db->get('riwayat_pembelian')->result_array();
        } else {
            return $this->db->get_where('riwayat', ['id_pembelian' => $id])->result_array();
        }
    }


    public function createRiwayat($data)
    {
        $this->db->insert('riwayat_pembelian', $data);
        return $this->db->affected_rows();
    }
}
