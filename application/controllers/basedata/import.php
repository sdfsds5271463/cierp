<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
		$this->load->helper('download'); 
		$this->load->library('excel/excel_reader2');
		$this->load->library('pinyin/getpinyin');
    }
	
	public function index() {
		$dir = './data/upfile/' . date('Ymd') . '/';
		//$path = '/data/upfile/' . date('Ymd') . '/';
		$err = json_encode(array('url' => '', 'title' => '', 'state' => '請登錄'));
		$info = upload('resume_file', $dir);
		if (is_array($info) && count($info) > 0) {
			//$array = array('url' => $path . $info['file'], 'title' => $path . $info['file'], 'state' => 'SUCCESS');
			print_r($info);
			die();
		} else {
			die($err);
		}
	}
	
	//客戶
	public function downloadtemplate1() {
		$info = read_file('./data/download/customer.xls');
		$this->common_model->logs('下載檔名:客戶匯入_'.date("YmdHis").'.xls');
		force_download('客戶匯入_'.date("YmdHis").'.xls', $info); 
	}
	
	//供應商
	public function downloadtemplate2() {
		$info = read_file('./data/download/vendor.xls');
		$this->common_model->logs('下載檔名:供應商匯入_'.date("YmdHis").'.xls');
		force_download('供應商匯入_'.date("YmdHis").'.xls', $info); 
	}
	
	//商品
	public function downloadtemplate3() {
		$info = read_file('./data/download/goods.xls');
		$this->common_model->logs('下載檔名:商品匯入_'.date("YmdHis").'.xls');
		force_download('商品匯入_'.date("YmdHis").'.xls', $info);  
	}
	
	//客戶匯入
	public function findDataImporter() {
	    $fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
		 print_r($fn);
		die();
		if ($fn) {
			file_put_contents(
				'upload/' . $fn,
				file_get_contents('php://input')
			);
			echo "http://119.10.11.187:82/AAAUPIMG/1/uploads/".$fn;
			exit();
		}
	    print_r($_FILES);
		die();
//	    $dir = './data/upfile/' . date('Ymd') . '/';
//		//$path = '/data/upfile/' . date('Ymd') . '/';
//		$err = json_encode(array('url' => '', 'title' => '', 'state' => '請登錄'));
//		$info = upload('resume_file', $dir);
//		if (is_array($info) && count($info) > 0) {
//			//$array = array('url' => $path . $info['file'], 'title' => $path . $info['file'], 'state' => 'SUCCESS');
//			print_r($info);
//			die();
//		} else {
//			die($err);
//		}
        die('{"status":200,"msg":"success","data":{"items":[{"id":1294598139109696,"date":"2015-04-25 14:41:35","uploadPath"
:"customer_20150425024011.xls","uploadName":"customer_20150425024011.xls","resultPath":"uploadfiles/88887901
/customer_20150425024011.xls","resultName":"customer_20150425024011.xls","resultInfo":"商品匯入完畢。<br/>商
品一共：0條數據，成功匯入：0條數據，失敗：0條數據。<br/>供應商匯入完畢。<br/>供應商一共：0條數據，成功匯入：0條數據，失敗：0條數據。<br/>客戶匯入完畢。<br/>客戶一共：10條數
據，成功匯入：10條數據，失敗：0條數據。<br/>","status":2,"spendTime":0},{"id":1294598139109659,"date":"2015-04-25 14:40
:49","uploadPath":"customer_20150425024011.xls","uploadName":"customer_20150425024011.xls","resultPath"
:"uploadfiles/88887901/customer_20150425024011.xls","resultName":"customer_20150425024011.xls","resultInfo"
:"商品匯入完畢。<br/>商品一共：0條數據，成功匯入：0條數據，失敗：0條數據。<br/>供應商匯入完畢。<br/>供應商一共：0條數據，成功匯入：0條數據，失敗：0條數據。<br/>客戶匯入完畢
。<br/>客戶一共：10條數據，成功匯入：10條數據，失敗：0條數據。<br/>","status":2,"spendTime":0},{"id":1294597559113847,"date":"2015-04-17
 16:54:39","uploadPath":"藍港新系統xls.xls","uploadName":"藍港新系統xls.xls","resultPath":"uploadfiles/88887901
/藍港新系統xls.xls","resultName":"藍港新系統xls.xls","resultInfo":"商品匯入完畢。<br/>商品一共：557條數據，成功匯入：0條數據，失敗：557條數據
。<br/>(請檢查模板是否匹配，建議重新下載模板匯入)<br/>供應商匯入完畢。<br/>供應商一共：0條數據，成功匯入：0條數據，失敗：0條數據。<br/>客戶匯入完畢。<br/>客戶一共：0條數
據，成功匯入：0條數據，失敗：0條數據。<br/>","status":2,"spendTime":0}],"totalsize":3}}');  
	    die('{"status":200,"msg":"success"}');  
	}
	
	//上傳檔案
	public function upload() {
		die('{"status":200,"msg":"success","data":{"items":[{"id":1294598139109696,"date":"2015-04-25 14:41:35","uploadPath"
:"customer_20150425024011.xls","uploadName":"customer_20150425024011.xls","resultPath":"uploadfiles/88887901
/customer_20150425024011.xls","resultName":"customer_20150425024011.xls","resultInfo":"商品匯入完畢。<br/>商
品一共：0條數據，成功匯入：0條數據，失敗：0條數據。<br/>供應商匯入完畢。<br/>供應商一共：0條數據，成功匯入：0條數據，失敗：0條數據。<br/>客戶匯入完畢。<br/>客戶一共：10條數
據，成功匯入：10條數據，失敗：0條數據。<br/>","status":2,"spendTime":0},{"id":1294598139109659,"date":"2015-04-25 14:40
:49","uploadPath":"customer_20150425024011.xls","uploadName":"customer_20150425024011.xls","resultPath"
:"uploadfiles/88887901/customer_20150425024011.xls","resultName":"customer_20150425024011.xls","resultInfo"
:"商品匯入完畢。<br/>商品一共：0條數據，成功匯入：0條數據，失敗：0條數據。<br/>供應商匯入完畢。<br/>供應商一共：0條數據，成功匯入：0條數據，失敗：0條數據。<br/>客戶匯入完畢
。<br/>客戶一共：10條數據，成功匯入：10條數據，失敗：0條數據。<br/>","status":2,"spendTime":0},{"id":1294597559113847,"date":"2015-04-17
 16:54:39","uploadPath":"藍港新系統xls.xls","uploadName":"藍港新系統xls.xls","resultPath":"uploadfiles/88887901
/藍港新系統xls.xls","resultName":"藍港新系統xls.xls","resultInfo":"商品匯入完畢。<br/>商品一共：557條數據，成功匯入：0條數據，失敗：557條數據
。<br/>(請檢查模板是否匹配，建議重新下載模板匯入)<br/>供應商匯入完畢。<br/>供應商一共：0條數據，成功匯入：0條數據，失敗：0條數據。<br/>客戶匯入完畢。<br/>客戶一共：0條數
據，成功匯入：0條數據，失敗：0條數據。<br/>","status":2,"spendTime":0}],"totalsize":3}}');  
	}
	
	public function uploadExcel() {
	    $path=$_FILES['file'];
	    if($path['error']!= 0)
	        str_alert(-1,'檔案上傳失敗！');
	    if($path['size']>20*1024*1024)
	        str_alert(-1,'上傳檔案大小超過限制！');
	    if($path['type']!='application/vnd.ms-excel' || strrchr($path['name'],'xls')!='xls')
	        str_alert(200,'上傳的檔案不是excel型別！');
        //$filePath = "data/upload/".$path["name"];
        //move_uploaded_file($path["tmp_name"],$filePath);
        
        //$reader = new Excel_reader2(); // 實例化解析類Spreadsheet_Excel_Reader
	    $reader = $this->excel_reader2;
        $reader->setOutputEncoding("utf-8");    // 設定編碼方式
        $reader->read("{$path['tmp_name']}");
        $data = $reader->sheets[0]['cells'];
        if(!isset($data[2])||!isset($data[2][1]))
            str_alert(-1,'無可匯入的數據！');
        $first = array_shift($data);
        $itype = "";
        $this->db->trans_begin();
        if($first[1]=='商品編號'){
            $itype = "商品";
            foreach ($data as $arr=>$row) {
                $good['number'] = $row[1];
                $good['name'] = $row[2];
                $good['barCode'] = $row[3];
                $good['spec'] = $row[4];
                //$good['categoryId'] = 1;
                //$good['categoryName'] = $row[5];
                //$good['locationId'] = $row[6];
                //$good['baseUnitId'] = $row[9];
                $good['purPrice'] = $row[12];
                $good['salePrice'] = $row[11];
                $good['pinYin'] = $this->getpinyin->getFirstPY($row[2]);
                $good['sonGoods'] = '[]';
                $good['dopey'] = 0;
                empty($row[5])&&str_alert(-1,'商品【'.$row[2].'】類別不能為空！');
                empty($row[6])&&str_alert(-1,'商品【'.$row[2].'】倉庫不能為空！');
                empty($row[9])&&str_alert(-1,'商品【'.$row[2].'】計量單位不能為空！');
                $list = $this->mysql_model->get_rows('storage',array('isDelete'=>0,'name'=>$row[6]));
                if (count($list) > 0) {
                    $good['locationId']= $list['id'];
                    $good['locationName']= $row[6];
                }else 
                    str_alert(-1,'倉庫【'.$row[6].'】不存在,請先新增倉庫后再匯入！');
                $list = $this->mysql_model->get_rows('category',array('name'=>$row[5],'typeNumber'=>'trade'));
                if (count($list) > 0) {
                    $good['categoryId']= $list['id'];
                    $good['categoryName']= $row[5];
                }else{
                    str_alert(-1,'商品類別【'.$row[5].'】不存在,請先新增商品類別再匯入！');
                }
                $list = $this->mysql_model->get_rows('unit',array('name'=>$row[9]));
                if (count($list) > 0) {
                    $good['baseUnitId']= $list['id'];
                    $good['unitName']= $row[9];
                }else{
                    str_alert(-1,'計量單位【'.$row[9].'】不存在,請先新增計量單位再匯入！');
                }
                
                $info = array(
                    'number','name','barCode','spec','categoryId','locationId','baseUnitId','purPrice','salePrice',
                    'locationName','unitName','categoryName','pinYin','sonGoods','dopey'
                );
                $info = elements($info,$good,NULL);
                
                if($this->mysql_model->get_count('goods',array('isDelete'=>0,'number'=>$good['number'])) <= 0){
                    $rtn['id'] = $this->mysql_model->insert('goods',$info);
                }else {
                    $this->mysql_model->update('goods',$info,array('number'=>$good['number']));
                }
            }
        }else if($first[1]=='客戶編號'){
            $itype = "客戶";
            foreach ($data as $arr=>$row) {
                $cust['number'] = $row[1];
                $cust['name'] = $row[2];
                //$cust['cCategory'] = $row[3];
                //$cust['cCategoryName'] = $row[4];
                $cust['cLevel'] = 0;
                $cust['remark'] = $row[8];
                $linkMan['linkName'] = $row[9];
                $linkMan['linkMobile'] = $row[10];
                $linkMan['linkPhone'] = $row[11];
                $linkMan['linkPlace'] = $row[12];
                $linkMan['linkIm'] = $row[13];
                $linkMan['linkFirst'] = 1;
                $linkMan['id'] = 0;
                $linkMans[0] = $linkMan;
                $cust['linkMans'] = json_encode($linkMans);
                $cust['type'] = -10;
                empty($row[1])&&str_alert(-1,'第'.$arr.'行客戶編號不能為空！');
                empty($row[2])&&str_alert(-1,'第'.$arr.'行客戶名稱不能為空！');
                empty($row[3])&&str_alert(-1,'第'.$arr.'行客戶類別不能為空！');
                $list = $this->mysql_model->get_rows('category',array('name'=>$row[3],'typeNumber'=>'customertype'));
                if (count($list) > 0) {
                    $cust['cCategory']= $list['id'];
                    $cust['cCategoryName']= $row[3];
                }else{
                    str_alert(-1,'第'.$arr.'行客戶類別【'.$row[3].'】不存在,請先新增客戶類別再匯入！');
                }
            
                $info = array(
                    'number','name','cLevel','remark','cCategory','cCategoryName','linkMans','type'
                );
                $info = elements($info,$cust,NULL);
            
                if($this->mysql_model->get_count('contact',array('isDelete'=>0,'number'=>$cust['number'])) <= 0){
                    $rtn['id'] = $this->mysql_model->insert('contact',$info);
                }else {
                    $this->mysql_model->update('contact',$info,array('number'=>$cust['number']));
                }
            }
        }else if($first[1]=='供應商編號'){
            $itype = "供應商";
            foreach ($data as $arr=>$row) {
                $sup['number'] = $row[1];
                $sup['name'] = $row[2];
                //$cust['cCategory'] = $row[3];
                //$cust['cCategoryName'] = $row[4];
                $sup['cLevel'] = 0;
                $sup['remark'] = $row[7];
                $linkMan['linkName'] = $row[8];
                $linkMan['linkMobile'] = $row[9];
                $linkMan['linkPhone'] = $row[10];
                $linkMan['linkPlace'] = $row[11];
                $linkMan['linkIm'] = $row[12];
                $linkMan['linkFirst'] = 1;
                $linkMan['id'] = 0;
                $linkMans[0] = $linkMan;
                $sup['linkMans'] = json_encode($linkMans);
                $sup['type'] = 10;
                empty($row[1])&&str_alert(-1,'第'.$arr.'行供應商編號不能為空！');
                empty($row[2])&&str_alert(-1,'第'.$arr.'行供應商名稱不能為空！');
                empty($row[3])&&str_alert(-1,'第'.$arr.'行供應商類別不能為空！');
                $list = $this->mysql_model->get_rows('category',array('name'=>$row[3],'typeNumber'=>'supplytype'));
                if (count($list) > 0) {
                    $sup['cCategory']= $list['id'];
                    $sup['cCategoryName']= $row[3];
                }else{
                    str_alert(-1,'第'.$arr.'行供應商類別【'.$row[3].'】不存在,請先新增供應商類別再匯入！');
                }
            
                $info = array(
                    'number','name','cLevel','remark','cCategory','cCategoryName','linkMans','type'
                );
                $info = elements($info,$sup,NULL);
            
                if($this->mysql_model->get_count('contact',array('isDelete'=>0,'number'=>$sup['number'])) <= 0){
                    $rtn['id'] = $this->mysql_model->insert('contact',$info);
                }else {
                    $this->mysql_model->update('contact',$info,array('number'=>$sup['number']));
                }
            }
        }
	    if ($this->db->trans_status() === FALSE) {
		    $this->db->trans_rollback();
			str_alert(-1,'SQL錯誤回滾');
		} else {
		    $this->db->trans_commit();
			str_alert(200,'恭喜您，匯入'.$itype.'資訊成功！');
		}
	}
	
 
	
	 
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */