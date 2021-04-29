<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Settacct extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
	//結算賬戶列表
	public function index(){
		$list = $this->mysql_model->get_results('account',array('isDelete'=>0),'id desc');  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['date']        = $row['date'];
			$v[$arr]['amount']      = (float)$row['amount'];
			$v[$arr]['del']         = false;
			$v[$arr]['id']          = intval($row['id']);
			$v[$arr]['name']        = $row['name'];
			$v[$arr]['number']      = $row['number'];
			$v[$arr]['type']        = intval($row['type']);
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['items']      = isset($v) ? $v : array();
		$json['data']['totalsize']  = count($list);
		die(json_encode($json)); 
	}
	
	//查詢
	public function query(){
	    $id = intval($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_rows('account',array('id'=>$id,'isDelete'=>0)); 
		if (count($data)>0) {
			$v = array();
			$json['status'] = 200;
			$json['msg']    = 'success'; 
			$json['data']['date']     = $data['date'];
			$json['data']['amount']   = (float)$data['amount'];
			$json['data']['del']      = false;
			$json['data']['id']       = intval($data['id']);
			$json['data']['name']     = $data['name'];
			$json['data']['number']   = $data['number'];
			$json['data']['type']     = intval($data['type']);
			die(json_encode($json)); 
		}	
	}
	
	//目前餘額
	public function findAmountOver(){
	    $ids = str_enhtml($this->input->post('ids',TRUE));
		if (strlen($ids)>0) { 
			$list = $this->data_model->get_account('','a.isDelete=0 and a.id in('.$ids.')');  
			foreach ($list as $arr=>$row) {
				$v[$arr]['id']          = intval($row['id']);
				$v[$arr]['amountOver']  = (float)$row['amount'];
			}
			$json['status'] = 200;
			$json['msg']    = 'success';
			$json['data']['items']      = isset($v) ? $v : array();
			$json['data']['totalsize']  = count($list);  
			die(json_encode($json));  
		} else {
		    str_alert(200,'');
		} 
	}
 
    //新增
	public function add(){
		$this->common_model->checkpurview(160);
		$data = str_enhtml($this->input->post(NULL,TRUE));
		if (count($data)>0) {
			$data = $this->validform($data);
			$info = elements(array('name','number','amount','date','type'),$data);
			$sql  = $this->mysql_model->insert('account',$info);
			if ($sql) {
				$data['id'] = $sql;
				$this->common_model->logs('新增賬戶:'.$data['number'].$data['name']);
				str_alert(200,'success',$data);
			}
		}
		str_alert(-1,'新增失敗');
	}
	
	//修改
	public function update(){
		$this->common_model->checkpurview(161);
		$data = str_enhtml($this->input->post(NULL,TRUE));
		if (count($data)>0) {
			$data = $this->validform($data);
			$info = elements(array('name','number','amount','date','type'),$data);
			$sql  = $this->mysql_model->update('account',$info,array('id'=>$data['id']));
			if ($sql) {
				$this->common_model->logs('更新賬戶:'.$data['number'].$data['name']);
				str_alert(200,'success',$data);
			}
		}
		str_alert(-1,'更新失敗');
	}
	
	//刪除
	public function delete(){
		$this->common_model->checkpurview(162);
		$id = intval($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_rows('account',array('id'=>$id,'isDelete'=>0)); 
		if (count($data)>0) {
		    $this->mysql_model->get_count('account_info',array('accId'=>$id,'isDelete'=>0))>0 && str_alert(-1,'賬戶資料已經被使用');
			$sql = $this->mysql_model->update('account',array('isDelete'=>1),array('id'=>$id));       
		    if ($sql) {
				$this->common_model->logs('刪除賬戶:ID='.$id.' 名稱:'.$data['name']);
				str_alert(200,'success',array('msg'=>'成功刪除'));
			}
		}
		str_alert(-1,'刪除失敗');
	}
	
	
	//公共驗證
	private function validform($data) {
	    $data['id']     = isset($data['id']) ? intval($data['id']) :0;
	    $data['amount'] = (float)$data['amount'];
		$data['type']   = intval($data['type']);
        strlen($data['name']) < 1 && str_alert(-1,'名稱不能為空');
		strlen($data['number']) < 1 && str_alert(-1,'編號不能為空');
		$where = $data['id']>0 ? ' and (id<>'.$data['id'].')' : '';
		$this->mysql_model->get_count('account','(isDelete=0) and name="'.$data['name'].'" '.$where) > 0 && str_alert(-1,'名稱重複');
		$this->mysql_model->get_count('account','(isDelete=0) and number="'.$data['number'].'" '.$where) > 0 && str_alert(-1,'編號重複');
		return $data;
	}  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */