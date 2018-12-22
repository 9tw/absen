<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modIT extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	//cek akun karyawan (log-in & log-out)
    function getAkun($username){
		$this->db->select("*");
		$this->db->from("karyawan");
        $this->db->where("KarUsername",$username);
        $query = $this->db->get();
        return $query;
    }

	//firebase
    function update_fcm($username,$fcm){
		$data=array("fcm"=>$fcm);
		$this->db->set($data);
        $this->db->where('KarUsername',$username);
        return $this->db->update('karyawan');
    }

	//menampilkan data karyawan
	function gets($Id){
		$this->db->select("*");
		$this->db->from("absensi");
		$this->db->where("karId",$Id);
		$query=$this->db->get();
		return $query->row();
	}	
	
	//cek ID karyawan
	function cekU($Id)
	{
		$this->db->select("*");
		$this->db->from("karyawan");
		$this->db->where("karId",$Id);
		$query=$this->db->get();
		return ($query->num_rows()>0);
	}	
	
	//cek absen karyawan
	function cekH($Id,$Tgl)
	{
		$this->db->select("*");
		$this->db->from("absensi");
		$this->db->where("karId",$Id);
		$this->db->where("absTglAbsen",$Tgl);
		$query=$this->db->get();
		return ($query->num_rows()>0);
	}
	
	//menyimpan absen karyawan
	function save($data)
	{
		return $this->db->insert('absensi',$data);
	}
}