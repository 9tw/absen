<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require(APPPATH . '/libraries/JWT.php');

use \Firebase\JWT\JWT;

class Absen extends REST_Controller {

    function __construct()
    {
        parent::__construct();
		$this->load->model("modIT","user");
    }

	//mendapatkan token dengan enkripsi JWT
	function getToken($parameter){
		return JWT::encode($parameter,'THETOKEN');
	}
	
	//test token pada username dengan enkripsi JWT
	function testoken_post(){
		$username=$this->post('KarUsername');
		$token_param['id'] = $username;
		$token_param['username'] = $username;
		echo $this->getToken($token_param);
	}
	
	//log-in aplikasi
    function login_post(){
		$username=$this->post('KarUsername');
		$password=$this->post('KarPassword');
		$fcm=$this->post('fcm');
		$result = $this->user->getAkun($username)->row();
		$password = md5($password);
		if (count($result)>0){
			if ($password === $result->KarPassword) {
				$this->user->update_fcm($username,$fcm);
				$feedback['login_status']=true;
				$feedback['msg']="Login berhasil";
				$token['id'] = $username;
				$token['username'] = $username;
				$feedback['id_token'] = $this->getToken($token);
				//get Jadwal Akses Portal
				$feedback['username'] = $username;
				$feedback['password'] = $result->password;		
			} else {
				$feedback['login_status']=false;
				$feedback['msg']="Username dan Password anda salah, silahkan masukkan username dan password dengan benar";
			}
		} else {
			$feedback['login_status']=false;
			$feedback['msg']="Username dan Password anda salah, silahkan masukkan username dan password dengan benar.";
		}
		$this->set_response($feedback);
    }

	//log-out aplikasi
	function logout_post(){
		$token=$this->post('token');
		$username=$this->post('KarUsername');
		$token_param['id'] = $username;
		$token_param['username'] = $username;
		if ( $this->getToken($token_param)==$token){
			if ($this->user->update_fcm($username,NULL)){
				$feedback['status']=true;
			} else {
				$feedback['status']=false;
			}
		} else {
			$feedback['status']=false;
		}
        $this->set_response($feedback, REST_Controller::HTTP_OK);
    }	
	
	//operasi absen
    public function index_post(){	
		$data["karId"]			=$this->post('karId');				//ID karyawan
		$data["absTglAbsen"]	=$this->post('.date("Y-m-d").');	//tanggal absen
		$data["absJamAbsen"]	=$this->post('.date("h:i:s").');	//jam absen
		$data["absStatusAbsen"] =$this->post('absStatusAbsen');		//sudah absen atau belum
		$cek=$this->user->cekU($data["karId"]);						//mengecek ID karyawan
		if($cek){
			$cek2=$this->user->cekH($data["karId"],$data["absTglAbsen"]); //mengecek absen karyawan
			if($cek2){
				$feedback["status"]=false;
				$feedback["msg"]="Sudah ada";
			}else{
				$insert=$this->user->save($data);
				if($insert){
					$feedback["status"]=true;
					$feedback["msg"]="Berhasil";
				}else{
					$feedback["status"]=false;
					$feedback["msg"]="Gagal";
				}
			}			
		}else{
			$feedback["status"]=false;
			$feedback["msg"]="User belum terdaftar";
		}
        
		$this->set_response($feedback, REST_Controller::HTTP_CREATED);
    }
	
	//mengambil data karyawan
	public function index_get(){
		$Id=$this->get('Id');
		$token=$this->post('token');
		$email=$this->post('email');
		$token_param['id'] = $email;
		$token_param['email'] = $email;
		if ( $this->getToken($token_param)==$token){
		$data=$this->user->gets($Id);
		
		$this->set_response($data, REST_Controller::HTTP_CREATED);		
    }
}
