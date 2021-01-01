<?php

class Pegawai_model extends CI_Model
{
    public function getpegawai()
    {
        $pegawai = $this->db->get('pegawai')->result_array();
        return $pegawai;
    }

    public function getpegawaibyid($id)
    {
        $pegawai = $this->db->get_where('pegawai', ['id' => $id])->result_array();
        return $pegawai;
    }

    public function addpegawai($data)
    {
        $this->db->insert('pegawai', $data);
        return $this->db->affected_rows();
    }

    public function deletepegawai($id)
    {
        $this->db->delete('pegawai', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function editpegawai($data, $id)
    {
        $this->db->update('pegawai', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
