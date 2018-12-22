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

	function getToken($parameter){
		return JWT::encode($parameter,'THETOKEN');
	}
	
	function testoken_post(){
		$username=$this->post('KarUsername');
		$token_param['id'] = $username;
		$token_param['username'] = $username;
		echo $this->getToken($token_param);
	}
	
    function login_post(){
		$username=$this->post('KarUsername');
		$password=$this->post('KarPassword');
		if(!empty($username)&&!empty($password)){
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
    }

	function logout_post(){
		$token=$this->post('token');
		$username=$this->post('KarUsername');
		$token_param['id'] = $username;
		$token_param['username'] = $username;
		if ( $this->getToken($token_param)==$token){
			if ($this->user->update_fcm($email,NULL)){
				$feedback['status']=true;
			} else {
				$feedback['status']=false;
			}
		} else {
			$feedback['status']=false;
		}
        $this->set_response($feedback, REST_Controller::HTTP_OK);
    }	
	
    public function index_post(){	
		$data["absKarId"]		=$this->post('absKarId');
		$data["absTglAbsen"]	=$this->post('.date("Y-m-d").');
		$data["absJamAbsen"]	=$this->post('.date("h:i:s").');
		$data["absStatusAbsen"] =$this->post('absStatusAbsen');
		$cek=$this->user->cekU($data["absKarId"]);
		if($cek){
			$cek2=$this->user->cekH($data["absKarId"],$data["absTglAbsen"]);
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
	
	public function index_get(){
		$Id=$this->get('Id');
		$data=$this->user->gets($Id);
		$this->set_response($data, REST_Controller::HTTP_CREATED);		
    }
}
