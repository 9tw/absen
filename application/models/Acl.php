<?php

class Acl extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database('baca');
    }

    function cek_akses_module($role, $modul, $hak) {
        $this->db->select('role');
        if($role != "mahasiswa" || $role != "dosen"){
            $this->db->where('role', $role);
            $this->db->where('modul', $modul);
            $this->db->where('hak', $hak);
            $this->db->from('reg_hak_akses');
            if ($this->db->count_all_results() == 1)
                return true;
            else
                return false;
        }
        return false;
    }

    function cek_nip($nip) {
        $this->db->select('nip');
        $this->db->where('nip', $nip);
        $this->db->from('dosen');
        if ($this->db->count_all_results() == 1)
            return true;
        else
            return false;
    }

    function get_all($limit = 20) {
        $this->db->select('nip, nama, jml_anak');
        $this->db->from('dosen');
        $this->db->limit($limit);
        $this->db->order_by('nip', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function get($nip) {
        $query = $this->db->get_where('dosen', array('nip' => $nip));
        return $query->row();
    }

    function save($data_dosen) {
        return $this->db->insert('dosen', $data_dosen);
    }

    function update($nip, $data_dosen) {
        $this->db->where('nip', $nip);
        return $this->db->update('dosen', $data_dosen);
    }

    function delete($nip) {
        $this->db->where('nip', $nip);
        return $this->db->delete('dosen');
    }

    function get_all_grid($start, $limit, $sidx, $sord, $where) {
        if ($where != NULL)
            $this->db->where($where, NULL, FALSE);
        $this->db->order_by($sidx, $sord);
        $query = $this->db->get('dosen', $limit, $start);

        return $query->result();
    }

}

?>
