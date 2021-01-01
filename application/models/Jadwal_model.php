<?php

class Jadwal_model extends CI_Model
{
    public function getAllJadwal()
    {
        $jadwal = $this->db->get('jadwal')->result_array();
        return $jadwal;
    }

    public function getJadwalById($id)
    {
        $jadwal = $this->db->get_where('jadwal', ['id_jadwal' => $id])->result_array();
        return $jadwal;
    }

    public function editJadwal($data, $id)
    {
        $this->db->update('jadwal', $data, ['id_jadwal' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteJadwal($id)
    {
        $this->db->delete('jadwal', ['id_jadwal' => $id]);
        return $this->db->affected_rows();
    }

    public function addJadwal($data)
    {
        $this->db->insert('jadwal', $data);
        return $this->db->affected_rows();
    }
}
