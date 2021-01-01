<?php

class Transaksi_model extends CI_Model
{
    public function gettransaksi()
    {
        $data = $this->db->get('transaksi')->result_array();
        return $data;
    }

    public function gettransaksibyid($id)
    {
        $data = $this->db->get_where('transaksi', ['id_transaksi' => $id])->result_array();
        return $data;
    }

    public function addtransaksi($data)
    {
        $this->db->insert('transaksi', $data);
        return $this->db->affected_rows();
    }

    public function deletetransaksi($id)
    {
        $this->db->delete('transaksi', ['id_transaksi' => $id]);
        return $this->db->affected_rows();
    }

    public function edittransaksi($data, $id)
    {
        $this->db->update('transaksi', $data, ['id_transaksi' => $id]);
    }

    public function getpendapatan()
    {
        $this->db->select('jadwal.tarif, pemesanan.id_pemesanan');
        $this->db->from('transaksi');
        $this->db->join('pemesanan', 'transaksi.id_pemesanan = pemesanan.id_pemesanan');
        $this->db->join('jadwal', 'pemesanan.id_jadwal = jadwal.id_jadwal');
        $data = $this->db->get()->result_array();
        $hasil = 0;
        foreach ($data as $dt) {
            $hasil += $dt['tarif'];
        }

        return $hasil;
    }
}
