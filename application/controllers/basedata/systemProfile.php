<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Systemprofile extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
	//單據編號
	public function generateDocNo() {
        $billType = str_enhtml($this->input->post('billType',TRUE));
		$info = array(
			'PUR'=>'CG',
			'SALE'=>'XS',
			'TRANSFER'=>'DB',
			'OO'=>'QTCK',
			'PO'=>'CGDD',
			'SO'=>'XSDD',
			'OI'=>'QTRK',
			'CADJ'=>'CBTZ',
			'PAYMENT'=>'FKD',
			'RECEIPT'=>'SKD',
			'QTSR'=>'QTSR',
			'QTZC'=>'QTZC'
		);
		if (isset($info[$billType])) {
		    str_alert(200,'success',array('billNo'=>str_no($info[$billType]))); 
		}
		str_alert(-1,'產生失敗'); 
	}	
	
	
	//系統設定
	public function update() {
	    $this->common_model->checkpurview(81);
		$data = str_enhtml($this->input->post(NULL,TRUE));
		if (is_array($data) && count($data)>0) { 
			if ($this->common_model->insert_option('system',$data)) {
			    $this->common_model->logs('系統設定成功');
				str_alert(200,'success');
			}
		}
		str_alert(-1,'設定失敗'); 
	}	
	 
	//切換面板 
	public function changeSysSkin() {
		$skin = $this->input->post('skin',TRUE) ? $this->input->post('skin',TRUE) : 'green';
		$this->input->set_cookie('skin',$skin,360000); 
		$this->common_model->logs('切換面板：'.$skin);
		str_alert(200,'success');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */