<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modIT extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
    function getAkun($username){
		$this->db->select("*");
		$this->db->from("karyawan");
        $this->db->where("KarUsername",$username);
        $query = $this->db->get();
        return $query;
    }

    function update_fcm($username,$fcm){
		$data=array("fcm"=>$fcm);
		$this->db->set($data);
        $this->db->where('KarUsername',$username);
        return $this->db->update('karyawan');
    }

	function gets($Id){
		$this->db->select("*");
		$this->db->from("absensi");
		$this->db->where("absKarId",$Id);
		$query=$this->db->get();
		return $query->row();
	}	
	
	function cekU($Id)
	{
		$this->db->select("*");
		$this->db->from("karyawan");
		$this->db->where("karId",$Id);
		$query=$this->db->get();
		return ($query->num_rows()>0);
	}	
	
	function cekH($Id,$Tgl)
	{
		$this->db->select("*");
		$this->db->from("absensi");
		$this->db->where("absKarId",$Id);
		$this->db->where("absTglAbsen",$Tgl);
		$query=$this->db->get();
		return ($query->num_rows()>0);
	}
	
	function save($data)
	{
		return $this->db->insert('absensi',$data);
	}
}