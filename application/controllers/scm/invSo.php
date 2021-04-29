<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class InvSo extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
		$this->jxcsys = $this->session->userdata('jxcsys');
    }
	
	public function index() {
	    $action = $this->input->get('action',TRUE);
		switch ($action) {
			case 'initSo':
			    $this->common_model->checkpurview(189);
			    $this->load->view('scm/invSo/initSo');	
				break;  
			case 'editSo':
			    $this->common_model->checkpurview(190);
			    $this->load->view('scm/invSo/initSo');	
				break;  	
			case 'initSoList':
			    $this->common_model->checkpurview(188);
			    $this->load->view('scm/invSo/initSoList');
				break; 
			default:  
			    $this->common_model->checkpurview(188);
			    $this->soList();	
		}
	}
	
	public function soList(){
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$sidx = str_enhtml($this->input->get_post('sidx',TRUE));
		$sord = str_enhtml($this->input->get_post('sord',TRUE));
		$transType = intval($this->input->get_post('transType',TRUE));
		$hxState   = intval($this->input->get_post('hxState',TRUE));
		$salesId   = intval($this->input->get_post('salesId',TRUE));
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$order = $sidx ? $sidx.' '.$sord :' a.id desc';
		$where = 'a.isDelete=0 and a.billType="SALE"'; 
		$where .= $transType ? ' and a.transType='.$transType : ''; 
		$where .= $salesId>0    ? ' and a.salesId='.$salesId : ''; 
		$where .= $matchCon  ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate   ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$offset = $rows * ($page-1);
		$list = $this->data_model->get_order($where.' order by '.$order.' limit '.$offset.','.$rows);  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['checkName']    = $row['checkName'];
			$v[$arr]['checked']      = intval($row['checked']);
			$v[$arr]['salesId']      = intval($row['salesId']);
			$v[$arr]['salesName']    = $row['salesName'];
			$v[$arr]['billDate']     = $row['billDate'];
			$v[$arr]['deliveryDate'] = $row['deliveryDate'];
			$v[$arr]['billStatus']   = intval($row['billStatus']);
			$v[$arr]['billStatusName']  = intval($row['billStatus'])==2 ? '全部出庫' :'未出庫';
 
			$v[$arr]['totalQty']     = (float)$row['totalQty'];
			$v[$arr]['id']           = intval($row['id']);
		    $v[$arr]['amount']       = (float)abs($row['amount']);
 
			$v[$arr]['transType']    = intval($row['transType']); 
			$v[$arr]['rpAmount']     = (float)abs($row['rpAmount']);
			$v[$arr]['contactName']  = $row['contactName'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['billNo']       = $row['billNo'];
			$v[$arr]['totalAmount']  = (float)abs($row['totalAmount']);
			$v[$arr]['userName']     = $row['userName'];
			$v[$arr]['transTypeName']= $row['transTypeName'];
		}
		$data['status'] = 200;
		$data['msg']    = 'success'; 
		$data['data']['page']        = $page;
		$data['data']['records']   = $this->data_model->get_order($where,3);                               
		$data['data']['total']     = ceil($data['data']['records']/$rows);                                
		$data['data']['rows']      = isset($v) ? $v : array();
		die(json_encode($data));
	}
	
	//導出
	public function exportInvSo(){
	    $this->common_model->checkpurview(192);
		$name = 'sales_order_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('導出銷售訂單單據:'.$name);
		$sidx = str_enhtml($this->input->get_post('sidx',TRUE));
		$sord = str_enhtml($this->input->get_post('sord',TRUE));
		$transType = intval($this->input->get_post('transType',TRUE));
		$hxState   = intval($this->input->get_post('hxState',TRUE));
		$salesId   = intval($this->input->get_post('salesId',TRUE));
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$order = $sidx ? $sidx.' '.$sord :' a.id desc';
		$where = 'a.isDelete=0 and a.billType="SALE"'; 
		$where .= $transType ? ' and a.transType='.$transType : ''; 
		$where .= $salesId>0    ? ' and a.salesId='.$salesId : ''; 
		$where .= $matchCon  ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate   ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$data['list'] = $this->data_model->get_order($where.' order by '.$order);  
		$this->load->view('scm/invSo/exportInvSo',$data);	
	}
	
	
	//新增
	public function add(){
	    $this->common_model->checkpurview(189);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
			$info = elements(array(
				'billNo','billType','transType','transTypeName','buId',
				'billDate','description','totalQty','amount','rpAmount','totalAmount',
				'hxStateCode','totalArrears','disRate','disAmount','postData',
				'salesId','uid','userName','accId','deliveryDate','modifyTime'),$data);
			$this->db->trans_begin();
			$iid = $this->mysql_model->insert('order',$info);
			$this->invso_info($iid,$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL錯誤或者提交的是空數據'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('新增銷貨 單據編號：'.$data['billNo']);
				str_alert(200,'success',array('id'=>intval($iid))); 
			}
		}
		str_alert(-1,'提交的是空數據'); 
    }
	
	//新增
	public function addNew(){
	    $this->add();
    }
	
	//修改
	public function updateinvSo(){
	    $this->common_model->checkpurview(190);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
		    $info = elements(array(
				'billNo','billType','transType','transTypeName','buId',
				'billDate','description','totalQty','amount','rpAmount','totalAmount',
				'hxStateCode','totalArrears','disRate','disAmount','postData',
				'salesId','uid','userName','accId','deliveryDate','modifyTime'),$data);
			$this->db->trans_begin();
			$this->mysql_model->update('order',$info,'(id='.$data['id'].')');
			$this->invso_info($data['id'],$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL錯誤或者提交的是空數據'); 
			} else {
			    $this->db->trans_commit(); 
				$this->common_model->logs('修改銷貨 單據編號：'.$data['billNo']);
				str_alert(200,'success',array('id'=>$data['id'])); 
			}
		}
		str_alert(-1,'提交的數據不為空'); 
    }
	
	//獲取修改資訊
	public function update() {
	    $this->common_model->checkpurview();
	    $id   = intval($this->input->get_post('id',TRUE));
		$data =  $this->data_model->get_order('a.isDelete=0 and a.id='.$id.' and a.billType="SALE"',1);
		if (count($data)>0) {
			$info['status'] = 200;
			$info['msg']    = 'success'; 
			$info['data']['id']                 = intval($data['id']);
			$info['data']['buId']               = intval($data['buId']);
			$info['data']['cLevel']             = 0;
			$info['data']['deliveryDate']       = $data['deliveryDate'];
			$info['data']['contactName']        = $data['contactName'];
			$info['data']['salesId']            = intval($data['salesId']);
			$info['data']['date']               = $data['billDate'];
			$info['data']['billNo']             = $data['billNo'];
			$info['data']['billType']           = $data['billType'];
			$info['data']['transType']          = intval($data['transType']);
			$info['data']['totalQty']           = (float)$data['totalQty'];
			$info['data']['modifyTime']         = $data['modifyTime'];
			$info['data']['checkName']          = $data['checkName'];
			$info['data']['disRate']            = (float)$data['disRate'];
			$info['data']['billStatus']         = intval($data['billStatus']);
			$info['data']['disAmount']          = (float)$data['disAmount'];
			$info['data']['amount']             = (float)abs($data['amount']);
			$info['data']['rpAmount']           = (float)abs($data['rpAmount']);
			$info['data']['customerFree']       = (float)$data['customerFree'];
			$info['data']['arrears']            = (float)abs($data['arrears']);
			$info['data']['userName']           = $data['userName'];
			$info['data']['checked']            = intval($data['checked']); 
			$info['data']['status']             = intval($data['checked'])==1 ? 'view' : 'edit'; //edit
			$info['data']['totalDiscount']      = (float)$data['totalDiscount'];
			$info['data']['totalAmount']        = (float)abs($data['totalAmount']); 
			$info['data']['description']        = $data['description']; 
			$list = $this->data_model->get_order_info('a.isDelete=0 and a.iid='.$id.' order by a.id');  
			foreach ($list as $arr=>$row) {
				$v[$arr]['invSpec']           = $row['invSpec'];
				$v[$arr]['taxRate']           = (float)$row['taxRate'];
				$v[$arr]['srcOrderEntryId']   = intval($row['srcOrderEntryId']);
				$v[$arr]['srcOrderNo']        = $row['srcOrderNo'];
				$v[$arr]['srcOrderId']        = intval($row['srcOrderId']);
				$v[$arr]['goods']             = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
				$v[$arr]['invName']      = $row['invName'];
				$v[$arr]['qty']          = (float)abs($row['qty']);
				$v[$arr]['locationName'] = $row['locationName'];
				$v[$arr]['amount']       = (float)abs($row['amount']);
				$v[$arr]['taxAmount']    = (float)$row['taxAmount'];
				$v[$arr]['price']        = (float)$row['price'];
				$v[$arr]['tax']          = (float)$row['tax'];
				$v[$arr]['mainUnit']     = $row['mainUnit'];
				$v[$arr]['deduction']    = (float)$row['deduction'];
				$v[$arr]['invId']        = intval($row['invId']);
				$v[$arr]['invNumber']    = $row['invNumber'];
				$v[$arr]['locationId']   = intval($row['locationId']);
				$v[$arr]['locationName'] = $row['locationName'];
				$v[$arr]['discountRate'] = $row['discountRate'];
				$v[$arr]['description']  = $row['description'];
				
				$v[$arr]['unitId']       = intval($row['unitId']);
				$v[$arr]['mainUnit']     = $row['mainUnit'];
			}

			$info['data']['entries']     = isset($v) ? $v : array();
			$info['data']['accId']       = (float)$data['accId'];
			 
			$info['data']['accounts']     = array();
			die(json_encode($info));
		}
		str_alert(-1,'單據不存在、或者已刪除');  
    }
	
	
	
	public function queryDetails() {
	    $this->common_model->checkpurview();
	    $id   = intval($this->input->get_post('id',TRUE));
		$data =  $this->data_model->get_order('a.isDelete=0 and a.id='.$id.' and a.billType="SALE"',1);
		if (count($data)>0) {
			$data['billStatus'] == 2 && str_alert(400,'訂單 '.$data['billNo'].' 已全部出庫，不能產生購貨單！');  
			$info['status'] = 200;
			$info['msg']    = 'success'; 
			$info['data']['id']                 = intval($data['id']);
			$info['data']['buId']               = intval($data['buId']);
			$info['data']['cLevel']             = 0;
			$info['data']['deliveryDate']       = $data['deliveryDate'];
			$info['data']['contactName']        = $data['contactName'];
			$info['data']['salesId']            = intval($data['salesId']);
			$info['data']['date']               = $data['billDate'];
			$info['data']['billNo']             = $data['billNo'];
			$info['data']['billType']           = $data['billType'];
			$info['data']['transType']          = intval($data['transType']);
			$info['data']['totalQty']           = (float)$data['totalQty'];
			$info['data']['modifyTime']         = $data['modifyTime'];
			$info['data']['checkName']          = $data['checkName'];
			$info['data']['disRate']            = (float)$data['disRate'];
			$info['data']['disAmount']          = (float)$data['disAmount'];
			$info['data']['amount']             = (float)abs($data['amount']);
			$info['data']['rpAmount']           = (float)abs($data['rpAmount']);
			$info['data']['customerFree']       = (float)$data['customerFree'];
			$info['data']['arrears']            = (float)abs($data['arrears']);
			$info['data']['userName']           = $data['userName'];
			$info['data']['status']             = intval($data['checked'])==1 ? 'view' : 'edit'; //edit
			$info['data']['totalDiscount']      = (float)$data['totalDiscount'];
			$info['data']['totalAmount']        = (float)abs($data['totalAmount']); 
			$list = $this->data_model->get_order_info('a.isDelete=0 and a.iid='.$id.' order by a.id');   
			foreach ($list as $arr=>$row) {
				$v[$arr]['invSpec']           = $row['invSpec'];
				$v[$arr]['taxRate']           = (float)$row['taxRate'];
				$v[$arr]['srcOrderEntryId']   = 1;
				$v[$arr]['srcOrderNo']        = $data['billNo'];
				$v[$arr]['srcOrderId']        = intval($id);
				$v[$arr]['goods']             = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
				$v[$arr]['invName']      = $row['invName'];
				$v[$arr]['qty']          = (float)abs($row['qty']);
				$v[$arr]['locationName'] = $row['locationName'];
				$v[$arr]['amount']       = (float)abs($row['amount']);
				$v[$arr]['taxAmount']    = (float)$row['taxAmount'];
				$v[$arr]['price']        = (float)$row['price'];
				$v[$arr]['tax']          = (float)$row['tax'];
				$v[$arr]['mainUnit']     = $row['mainUnit'];
				$v[$arr]['deduction']    = (float)$row['deduction'];
				$v[$arr]['invId']        = intval($row['invId']);
				$v[$arr]['invNumber']    = $row['invNumber'];
				$v[$arr]['locationId']   = intval($row['locationId']);
				$v[$arr]['locationName'] = $row['locationName'];
				$v[$arr]['discountRate'] = $row['discountRate'];
				$v[$arr]['description']  = $row['description'];
				
				$v[$arr]['unitId']       = intval($row['unitId']);
				$v[$arr]['mainUnit']     = $row['mainUnit'];
			}

			$info['data']['entries']     = isset($v) ? $v : array();
			$info['data']['accId']       = (float)$data['accId'];
			 
			$info['data']['accounts']    = array();
			die(json_encode($info));
		}
		str_alert(-1,'單據不存在、或者已刪除');  
    }
	
	
	
	//列印
    public function toPdf() {
	    $this->common_model->checkpurview(193);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->data_model->get_order('a.isDelete=0 and a.id='.$id.' and a.billType="SALE"',1);   
		if (count($data)>0) { 
			$data['num']    = 8;
			$data['system'] = $this->common_model->get_option('system'); 
			$postData = unserialize($data['postData']);
			foreach ($postData['entries'] as $arr=>$row) {
			    $v[$arr]['i']               = $arr + 1;
				$v[$arr]['invId']           = intval($row['invId']);
				$v[$arr]['invNumber']       = $row['invNumber'];
				$v[$arr]['invSpec']         = $row['invSpec'];
				$v[$arr]['invName']         = $row['invName'];
				$v[$arr]['goods']           = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
				$v[$arr]['qty']             = (float)abs($row['qty']);
				$v[$arr]['price']           = $row['price'];
				$v[$arr]['mainUnit']        = $row['mainUnit'];
				$v[$arr]['amount']          = $row['amount'];
				$v[$arr]['deduction']       = $row['deduction'];
				$v[$arr]['discountRate']    = $row['discountRate'];
				$v[$arr]['locationName']    = $row['locationName'];
			}  
			$data['countpage']  = ceil(count($postData['entries'])/$data['num']); ;   
			$data['list']       = isset($v) ? $v : array();  
		    ob_start();
			$this->load->view('scm/invSo/toPdf',$data);
			$content = ob_get_clean();
			require_once('./application/libraries/html2pdf/html2pdf.php');
			try {
			    $html2pdf = new HTML2PDF('P', 'A4', 'en');
				$html2pdf->setDefaultFont('javiergb');
				$html2pdf->pdf->SetDisplayMode('fullpage');
				$html2pdf->writeHTML($content, '');
				$html2pdf->Output('invSo_'.date('ymdHis').'.pdf');
			}catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}   	  
		}
		str_alert(-1,'單據不存在、或者已刪除');    
	}
	
	
	
	//刪除 
    public function delete() {
	    $this->common_model->checkpurview(191);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->mysql_model->get_rows('order','(id='.$id.') and billType="SALE"');  
		if (count($data)>0) {
		    $data['checked'] >0 && str_alert(-1,'已審覈的不可刪除'); 
		    $this->db->trans_begin();
			$this->mysql_model->delete('order','(id='.$id.')');   
			$this->mysql_model->delete('order_info','(iid='.$id.')'); 
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'刪除失敗'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('刪除銷貨訂單編號：'.$data['billNo']);
				str_alert(200,'success'); 	 
			}
		}
		str_alert(-1,'單據不存在、或者已刪除');  
	}
	
	public function batchClose() {
	    str_alert(-1,'暫無此功能'); 
	}
	
	//批量審覈
    public function batchcheckinvSo() {
	    $this->common_model->checkpurview(194);
	    $id   = str_enhtml($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_results('order','(id in('.$id.')) and billType="SALE" and checked=0 and isDelete=0');  
		if (count($data)>0) {
		    $this->mysql_model->get_count('invoice','(srcOrderId in('.$id.')) and isDelete=0')>0 && str_alert(-1,'有關聯的銷貨單，不能對它進行審覈！'); 
			$sql = $this->mysql_model->update('order',array('checked'=>1,'checkName'=>$this->jxcsys['name']),'(id in('.$id.'))'); 
			if ($sql) {
				foreach($data as $arr=>$row) {
				    $billno[]     = $row['billNo'];
					$srcOrderId[] = $row['srcOrderId'];
				}
				$billno     = join(',',$billno);
				$srcOrderId = join(',',$srcOrderId);
				//變更狀態
				if (strlen($srcOrderId)>0) {
				    $this->mysql_model->update('order',array('billStatus'=>2),'(id in('.$srcOrderId.'))');
				}
				$this->common_model->logs('銷貨訂單編號：'.$billno.'的單據已被審覈！');
				str_alert(200,'訂單編號：'.$billno.'的單據已被審覈！');
			} 
			str_alert(-1,'審覈失敗');  
		}
		str_alert(-1,'所選的單據都已被審覈，請選擇未審覈的單據進行審覈！'); 
	}
	
	//批量反審覈
    public function rsbatchcheckinvSo() {
	    $this->common_model->checkpurview(195);
	    $id   = str_enhtml($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_results('order','(id in('.$id.')) and billType="SALE" and checked=1 and (isDelete=0)');   
		if (count($data)>0) {
		    $this->mysql_model->get_count('invoice','(srcOrderId in('.$id.')) and isDelete=0')>0 && str_alert(-1,'有關聯的銷貨單，不能對它進行反審覈！'); 
			$sql = $this->mysql_model->update('order',array('checked'=>0,'checkName'=>''),'(id in('.$id.'))'); 
			if ($sql) {
				$billno = array_column($data,'billNo','id');
				$billno = join(',',$billno);
				$this->common_model->logs('銷貨訂單：'.$billno.'的單據已被反審覈！');
				str_alert(200,'訂單編號：'.$billno.'的單據已被反審覈！'); 
			} 
			str_alert(-1,'反審覈失敗');  
		}
		str_alert(-1,'所選的訂單都是未審覈，請選擇已審覈的訂單進行反審覈！'); 
	}
	

	
	//單個審覈 
	public function checkInvSo() {
	    $this->common_model->checkpurview(194);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
			$this->mysql_model->get_count('invoice',array('srcOrderId'=>$data['id'],'isDelete'=>0))>0 && str_alert(-1,'有關聯的銷貨單，不能對它進行反審覈！'); 
			$data['checked']         = 1;
			$data['checkName']       = $this->jxcsys['name']; 
			$info = elements(array(
				'billNo','billType','transType','transTypeName','buId','checked','checkName',
				'billDate','description','totalQty','amount','rpAmount','totalAmount',
				'hxStateCode','totalArrears','disRate','disAmount','postData',
				'salesId','accId','deliveryDate','modifyTime'),$data);
			$this->db->trans_begin();
			//特殊情況
			if ($data['id'] < 0) {
			    $info = elements(array(
					'billNo','billType','transType','transTypeName','buId','checked',
					'billDate','description','totalQty','amount','rpAmount','totalAmount',
					'hxStateCode','totalArrears','disRate','disAmount','checkName','postData',
					'salesId','uid','userName','accId','deliveryDate','modifyTime'),$data,NULL);
			    $iid = $this->mysql_model->insert('order',$info);
			    $this->invso_info($iid,$data);
				$data['id'] = $iid;
			} else {
				$this->mysql_model->update('order',$info,array('id'=>$data['id']));
			    $this->invso_info($data['id'],$data);
			}
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL錯誤或者提交的是空數據'); 
			} else {
			    $this->db->trans_commit(); 
				$this->common_model->logs('銷貨單編號：'.$data['billNo'].'的單據已被審覈！');
				str_alert(200,'success',array('id'=>$data['id'])); 
			}
		}
		str_alert(-1,'審覈失敗'); 
    }
	
 
	
	//單個反審覈
	public function revsCheckInvSo() {
	    $this->common_model->checkpurview(195);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
			$this->mysql_model->get_count('invoice',array('srcOrderId'=>$data['id'],'isDelete'=>0))>0 && str_alert(-1,'有關聯的銷貨單，不能對它進行反審覈！'); 
			$sql = $this->mysql_model->update('order',array('checked'=>0,'checkName'=>''),'(id='.$data['id'].')');
			if ($sql) {
				$this->common_model->logs('銷貨單號：'.$data['billNo'].'的單據已被反審覈！');
				str_alert(200,'success',array('id'=>$data['id'])); 
			}
		}
		str_alert(-1,'提交失敗'); 
    }
 
 
	public function findNearSoEmp() {
		die('{"status":200,"msg":"success","data":{"empId":0}}');
	}
	
	//公共驗證
	private function validform($data) {
	    $data['id']              = isset($data['id']) ? intval($data['id']) : 0;
	    $data['buId']            = intval($data['buId']);
		$data['salesId']         = intval($data['salesId']);
		$data['billType']        = 'SALE';
		$data['billDate']        = $data['date'];
		$data['transType']       = intval($data['transType']);
		$data['transTypeName']   = $data['transType']==150601 ? '訂貨' : '退貨';
		$data['description']     = $data['description'];
		$data['totalQty']        = (float)$data['totalQty'];
		$data['totalTax']        = isset($data['totalTax']) ? (float)$data['totalTax'] : 0;
		$data['totalTaxAmount']  = isset($data['totalTaxAmount']) ? (float)$data['totalTaxAmount'] : 0; 
		$data['amount']          = $data['transType']==150601 ? abs($data['amount']) : -abs($data['amount']);
		$data['totalAmount']     = $data['transType']==150601 ? abs($data['totalAmount']) : -abs($data['totalAmount']);
		$data['disRate']        = (float)$data['disRate'];
		$data['disAmount']      = (float)$data['disAmount'];
		$data['totalDiscount']  = (float)$data['totalDiscount'];
		$data['uid']            = $this->jxcsys['uid'];
		$data['userName']       = $this->jxcsys['name'];  
		$data['modifyTime']     = date('Y-m-d H:i:s');
		
		//修改的時候 
		if ($data['id']>0) {
		    $invoice = $this->mysql_model->get_rows('order',array('id'=>$data['id'],'billType'=>'SALE','isDelete'=>0));  
			count($invoice)<1 && str_alert(-1,'單據不存在、或者已刪除');
			$data['checked'] = $invoice['checked'];	
			$data['billNo']  = $invoice['billNo'];	
		} else {
		    $data['billNo']  = str_no('XSDD');    
		}
		
		$data['disRate'] < 0  && str_alert(-1,'折扣率要為數字，請輸入有效數字！'); 
		abs($data['amount']) < abs($data['disAmount']) && str_alert(-1,'折扣額不能大於合計金額！'); 
 
        //數據驗證
		if (is_array($data['entries'])) {
			count($data['entries']) < 1 && str_alert(-1,'提交的是空數據'); 
		} else {
		    str_alert(-1,'提交的是空數據'); 	
		}
		
		//供應商驗證
		$this->mysql_model->get_count('contact','(id='.intval($data['buId']).')')<1 && str_alert(-1,'客戶不存在'); 
			
		//商品錄入驗證
        $storage   = array_column($this->mysql_model->get_results('storage','(disable=0)'),'id');  
		foreach ($data['entries'] as $arr=>$row) {
			intval($row['invId'])<1 && str_alert(-1,'請選擇商品');    
			(float)$row['qty'] < 0  && str_alert(-1,'商品數量要為數字，請輸入有效數字！'); 
			(float)$row['price'] < 0  && str_alert(-1,'商品銷售單價要為數字，請輸入有效數字！'); 
			(float)$row['discountRate'] < 0  && str_alert(-1,'折扣率要為數字，請輸入有效數字！');
			intval($row['locationId']) < 1 && str_alert(-1,'請選擇相應的倉庫！'); 
			!in_array($row['locationId'],$storage) && str_alert(-1,$row['locationName'].'不存在或不可用！');
		}
		$data['postData'] = serialize($data);
		return $data;
		
	}  
	
	
	
	//組裝數據
	private function invso_info($iid,$data) {
		foreach ($data['entries'] as $arr=>$row) {
			$v[$arr]['iid']           = $iid;
			$v[$arr]['billNo']        = $data['billNo'];
			$v[$arr]['billDate']      = $data['billDate']; 
			$v[$arr]['buId']          = $data['buId'];
			$v[$arr]['transType']     = $data['transType'];
			$v[$arr]['transTypeName'] = $data['transTypeName'];
			$v[$arr]['billType']      = $data['billType'];
			$v[$arr]['salesId']       = $data['salesId'];
			$v[$arr]['invId']         = intval($row['invId']);
			$v[$arr]['skuId']         = intval($row['skuId']);
			$v[$arr]['unitId']        = intval($row['unitId']);
			$v[$arr]['locationId']    = intval($row['locationId']);
			$v[$arr]['qty']           = $data['transType']==150601 ? -abs($row['qty']) :abs($row['qty']); 
			$v[$arr]['amount']        = $data['transType']==150601 ? abs($row['amount']) :-abs($row['amount']); 
			$v[$arr]['price']         = abs($row['price']);  
			$v[$arr]['discountRate']  = $row['discountRate'];  
			$v[$arr]['deduction']     = $row['deduction'];  
			$v[$arr]['description']   = $row['description'];
			$v[$arr]['uid']           = $data['uid'];     
		} 
		if (isset($v)) {
			if (isset($data['id']) && $data['id']>0) {  
			    $this->mysql_model->delete('order_info','(iid='.$iid.')');                    
			}
			$this->mysql_model->insert('order_info',$v);
		}
	}
 
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */