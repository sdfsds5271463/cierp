<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backup extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
		$this->load->helper(array('directory','download')); 
		$this->backup_path = $this->config->item('backup_path');
		$this->filename    = str_no().'.sql';
    }
	
	//備份
	public function index(){
		$this->load->dbutil();
		$query  = $this->db->query('SHOW TABLE STATUS'); 
		$prefs = array(
                'tables'      => array_column($query->result_array(),'Name'),  
                'ignore'      => array(),            
                'format'      => 'txt',              
                'filename'    => $this->filename,     
                'add_drop'    => TRUE,               
                'add_insert'  => TRUE,               
                'newline'     => "\n"               
              );
		$info = &$this->dbutil->backup($prefs); 
		$path = $this->backup_path.$this->filename;
		$this->create_folders($this->backup_path);//add my michen 20170818
		if (write_file($path, $info)) {
			$this->common_model->logs('備份與恢復,備份檔名:'.$this->filename);
			$data['createTime']  = date('Y-m-d H:i:s');
			$data['username']    = $this->filename;
			$data['filename']    = $this->filename;
			$data['dbid']        = 0;
			$data['fid']         = $this->filename;
			$data['size']        = filesize($path);
			str_alert(200,'success',$data);     
		}
		str_alert(-1,'檔案寫入失敗');   
	}
	
    //備份列表
	public function queryBackupFile(){
	    $v = array();
	    $list = get_dir_file_info($this->backup_path);
		$data['status'] = 200;
		$data['msg'] = 'success';
		$i = 0;
		count($list)<1 && str_alert(250,'暫無查詢結果');   
		foreach ($list as $arr=>$row) {
		    $v[$i]['fid']        = $row['name']; 
			$v[$i]['createTime'] = date("Y-m-d H:i:s", $row['date']); 
			$v[$i]['username']   = $row['date']; 
			$v[$i]['filename']   = $row['name']; 
			$v[$i]['dbid']       = 0; 
			$v[$i]['size']       = $row['size']; 
			$i++;
		}
		$data['data']['items']   = $v;
		$data['totalsize']       = 1;
		die(json_encode($data)); 
	}
	
	
	//刪除
	public function deleteBackupFile(){
	    $data['id'] = str_enhtml($this->input->get_post('id',TRUE));
		if (@unlink($this->backup_path.$data['id'])) {
		    $this->common_model->logs('備份與恢復,刪除檔名:'.$data['id']);
			str_alert(200,'刪除成功',$data);   
		} else {
		    str_alert(-1,'刪除失敗');   
		} 
	}
	
	//還原
	public function recover(){
	    $id = str_enhtml($this->input->get_post('id',TRUE));
	    $data = read_file($this->backup_path.$id);
		if ($data) {
		    $this->db->trans_begin();
			$list = explode(";\n",$data);
			foreach ($list as $sql) {
			    //add by michen 20170723 for 修復恢復 begin
			    if(strrpos($sql, '#',0)!=false)
			        $msql = substr($sql, strrpos($sql, '#',0)+1);
			    else
			        $msql=$sql;
			    $msql = trim($msql);
			    if(!empty($msql))//只要empty沒有isempty，且只能檢測變數，不能檢測函式
			    //add by michen 20170723 for 修復恢復 end
				    $this->db->query($msql);
			}
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'恢復失敗');   
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('備份與恢復,恢復檔名:'.$id);
			    str_alert(200,'恢復成功');   
			}
		}
		str_alert(-1,'恢復失敗');  
	}
	
	 
	//下載
	public function download() {
		$fid  = str_enhtml($this->input->get_post('fid',TRUE));
		$data = read_file($this->backup_path.$fid);
		if ($data) {
		    $this->common_model->logs('備份與恢復,下載檔名:'.$fid);
			force_download($fid, $data); 
		} else {
		    str_alert(-1,'下載失敗');   
		}
	}
	 
	function create_folders($dir) {
	    return is_dir($dir) or ($this->create_folders(dirname($dir)) and mkdir($dir, 0777));
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */