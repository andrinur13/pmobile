<?php

class User_model extends CI_Model
{
    public function getuser()
    {
        $user = $this->db->get('user')->result_array();
        return $user;
    }

    public function getuserbyid($id)
    {
        $user = $this->db->get_where('user', ['id' => $id])->result_array();
        return $user;
    }

    public function getuserbyname($username)
    {
        $user = $this->db->get_where('user', ['username' => $username])->row_array();
        return $user;
    }

    public function adduser($data)
    {
        $this->db->insert('user', $data);
        return $this->db->affected_rows();
    }

    public function deleteuser($id)
    {
        $this->db->delete('user', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function edituser($data, $id)
    {
        $this->db->update('user', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
