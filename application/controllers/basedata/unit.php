<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
	//單位列表
	public function index(){
		$unittypeid   = intval($this->input->get_post('unitTypeId',TRUE));
		if ($unittypeid>0) {
		    $where['unittypeid'] = $unittypeid;
		}
		$where['isDelete'] = 0;
		$list = $this->mysql_model->get_results('unit',$where,'id desc');
		foreach ($list as $arr=>$row) {
		    $v[$arr]['default']    = $row['default']==1 ? true : false;
			$v[$arr]['guid']       = $row['guid'];
			$v[$arr]['id']         = intval($row['id']);
			$v[$arr]['name']       = $row['name'];
			$v[$arr]['rate']       = intval($row['rate']);
			$v[$arr]['isDelete']   = intval($row['isDelete']);
			$v[$arr]['unitTypeId'] = intval($row['unitTypeId']);
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['items']     = isset($v) ? $v : array();
		$json['data']['totalsize'] = count($list);
		die(json_encode($json));	 
	}
	
	//新增
	public function add(){
		$this->common_model->checkpurview(78);
		$data = $this->validform(str_enhtml($this->input->post(NULL,TRUE)));
		$sql  = $this->mysql_model->insert('unit',elements(array('name','default'),$data));
		if ($sql) {
			$data['id'] = $sql;
			$this->common_model->logs('新增單位:'.$data['name']);
			die('{"status":200,"msg":"success","data":{"default":false,"guid":"","id":'.$sql.',"isdelete":0,"name":"'.$data['name'].'","rate":1,"unitTypeId":0}}');
			str_alert(200,'success',$data);
		}
		str_alert(-1,'新增失敗');
	}
	
	//修改
	public function update(){
		$this->common_model->checkpurview(79);
		$data = $this->validform(str_enhtml($this->input->post(NULL,TRUE)));
		$this->mysql_model->get_count('goods',array('isDelete'=>0,'unitId'=>$data['id']))>0 && str_alert(-1,'該單位已經被使用，不允許更改組');
		$sql  = $this->mysql_model->update('unit',elements(array('name','default'),$data),array('id'=>$data['id']));
		if ($sql) {
			$this->mysql_model->update('goods',array('unitName'=>$data['name']),array('baseUnitId'=>$data['id']));
			$this->common_model->logs('更新單位:'.$data['name']);
			str_alert(200,'success',$data);
		}
		str_alert(-1,'更新失敗');
	}
	
	//刪除
	public function delete(){
		$this->common_model->checkpurview(80);
		$id = intval($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_rows('unit',array('isDelete'=>0,'id'=>$id)); 
		if (count($data)>0) {
		    $this->mysql_model->get_count('goods',array('isDelete'=>0,'unitId'=>$id))>0 && str_alert(-1,'該單位已經被使用，不允許刪除');
			$sql = $this->mysql_model->update('unit',array('isDelete'=>1),array('id'=>$id));        
		    if ($sql) {
				$this->common_model->logs('刪除單位:ID='.$id.' 名稱:'.$data['name']);
				str_alert(200,'success',array('msg'=>'成功刪除','id'=>'['.$id.']'));
			}
		}
		str_alert(-1,'刪除失敗');
	}
	
	//公共驗證
	private function validform($data) {
        strlen($data['name']) < 1 && str_alert(-1,'單位名稱不能為空');
		$data['id']         = isset($data['id']) ? intval($data['id']) :0;
		$data['rate']       = isset($data['rate']) ? intval($data['rate']) :0;
		$data['default']    = isset($data['default']) ? $data['default'] :'';
		$data['unitTypeId'] = isset($data['unitTypeId']) ? intval($data['unitTypeId']):0;
		$data['default']    = $data['default']== 'true' ? 1 : 0;
		$where['isDelete']  = 0;
		$where['name']      = $data['name'];
		$where['id !=']     = $data['id']>0 ? $data['id'] :0;
		$this->mysql_model->get_count('unit',$where) && str_alert(-1,'單位名稱重複');
		return $data;
	}  

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */