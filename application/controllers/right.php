<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Right extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview(82);
    }
	

	public function isMaxShareUser() {
		die('{"status":200,"data":{"totalUserNum":1000,"shareTotal":1},"msg":"success"}');	
	}
	 

	public function queryAllUser() {
		$list = $this->mysql_model->get_results('admin','(1=1)','roleid');  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['share']         = intval($row['status']) > 0 ? true : false;
			$v[$arr]['admin']         = $row['roleid'] > 0 ? false : true;
		    $v[$arr]['userId']        = intval($row['uid']);
			$v[$arr]['isCom']         = intval($row['status']);
			$v[$arr]['role']          = intval($row['roleid']);
			$v[$arr]['userName']      = $row['username'];
			$v[$arr]['realName']      = $row['name'];
			$v[$arr]['shareType']     = intval($row['status']);
			$v[$arr]['mobile']        = $row['mobile'];
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['items']        = isset($v) ? $v : array();
		$json['data']['shareTotal']   = count($list);
		$json['data']['totalsize']    = $json['data']['shareTotal'];
		$json['data']['corpID']       = 0;
		$json['data']['totalUserNum'] = 1000;
		die(json_encode($json));
	}
	

	public function queryUserByName() {
	    $userName = str_enhtml($this->input->get_post('userName',TRUE));
		$data = $this->mysql_model->get_rows('admin',array('username'=>$userName));
		if (count($data)>0) {
			$json['share']      = true;
			$json['email']      = '';
			$json['userId']     = $data['uid'];
			$json['userMobile'] = $data['mobile'];
			$json['userName']   = $data['username'];
			str_alert(200,'success',$json);  
		}
        str_alert(502,'使用者名稱不存在');   
	}
	
	 

	public function adduser() {
	    $data = str_enhtml($this->input->post(NULL,TRUE));
		if (is_array($data)&&count($data)>0) {
			strlen($data['userNumber'])<1 && str_alert(-1,'使用者名稱不能為空');  
			strlen($data['password'])<1 && str_alert(-1,'密碼不能為空');  
			$this->mysql_model->get_count('admin',array('username'=>$data['userNumber']))>0 && str_alert(-1,'使用者名稱已經存在');   
			$this->mysql_model->get_count('admin',array('mobile'=>$data['userMobile'])) >0 && str_alert(-1,'該手機號已被使用'); 
			$info = array(
				 'username' => $data['userNumber'],
				 'userpwd'  => md5($data['password']),
				 'name'     => $data['userName'],
				 'mobile'   => $data['userMobile']
			);
		    $sql = $this->mysql_model->insert('admin',$info);
			if ($sql) {
			    $this->common_model->logs('新增使用者:'.$data['userNumber']);
				die('{"status":200,"msg":"註冊成功","userNumber":"'.$data['userNumber'].'"}');
			}
		}	
		str_alert(-1,'新增失敗'); 
	}
	

	public function addrights2Outuser() {
	    $userName = str_enhtml($this->input->get_post('userName',TRUE));
		$rightid  = str_enhtml($this->input->get_post('rightid',TRUE));
		$data = $this->mysql_model->get_rows('admin',array('username'=>$userName));
		if (count($data)>0) {
		    $sql = $this->mysql_model->update('admin',array('lever'=>$rightid),array('username'=>$userName));  
			if ($sql) {
			    $this->common_model->logs('更新許可權:'. $userName);
				str_alert(200,'操作成功'); 
			}
		}	
		str_alert(-1,'操作失敗'); 
	}
	 

	public function queryalluserright() {
	    $userName = str_enhtml($this->input->get_post('userName',TRUE));
		$data = $this->mysql_model->get_rows('admin',array('username'=>$userName));
		if (count($data)>0) {
			$lever = explode(',',$data['lever']);
			$list  = $this->mysql_model->get_results('menu',array('isDelete'=>0),'path'); 
			$menu  = array_column($list,'name','id'); 
			foreach ($list as $arr=>$row) {
				$v[$arr]['fobjectid']  = $row['parentId']>0 ? $row['parentId'] : $row['id']; 
				$v[$arr]['fobject']    = $row['parentId']>0 ? @$menu[$row['parentId']] : $row['name'];
				$v[$arr]['faction']    = $row['level'] > 1 ? $row['name'] : '查詢';
				$v[$arr]['fright']     = in_array($row['id'],$lever) ? 1 : 0;
				$v[$arr]['frightid']   = intval($row['id']);
			}
			$json['status'] = 200;
			$json['msg']    = 'success';  
			$json['data']['totalsize'] = count($list);  
			$json['data']['items']     = isset($v) ? $v : array();
			die(json_encode($json));
		}
	}
	

	public function auth2UserCancel(){
	    $userName = str_enhtml($this->input->get_post('userName',TRUE));
		$data = $this->mysql_model->get_rows('admin',array('username'=>$userName));
		if (count($data)>0) {
		    $userName == 'admin' && str_alert(-1,'管理員不可操作');   
			$sql = $this->mysql_model->update('admin',array('status'=>0),array('username'=>$userName));		
			if ($sql) {
			    $this->common_model->logs('使用者停用:'.$userName);
				str_alert(200,'success',$data); 
			}
		}	
		str_alert(-1,'停用失敗'); 
	}
	

	public function auth2User(){
	    $userName = str_enhtml($this->input->get_post('userName',TRUE));
		$data = $this->mysql_model->get_rows('admin',array('username'=>$userName));
		if (count($data)>0) {
			$userName == 'admin' && str_alert(-1,'管理員不可操作');    
			$sql = $this->mysql_model->update('admin',array('status'=>1),array('username'=>$userName));		
			if ($sql) {
			    $this->common_model->logs('使用者啟用:'.$userName);
				str_alert(200,'success',$data); 
			}
		}	
		str_alert(-1,'啟用失敗'); 
	}
	 
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */