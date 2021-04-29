<?php $this->load->view('header');?>
 

<script type="text/javascript">
var DOMAIN = document.domain;
var WDURL = "";
var SCHEME= "<?php echo sys_skin()?>";
try{
	document.domain = '<?php echo base_url()?>';
}catch(e){
}
//ctrl+F5 增加版本號來清空iframe的快取的
$(document).keydown(function(event) {
	/* Act on the event */
	if(event.keyCode === 116 && event.ctrlKey){
		var defaultPage = Public.getDefaultPage();
		var href = defaultPage.location.href.split('?')[0] + '?';
		var params = Public.urlParam();
		params['version'] = Date.parse((new Date()));
		for(i in params){
			if(i && typeof i != 'function'){
				href += i + '=' + params[i] + '&';
			}
		}
		defaultPage.location.href = href;
		event.preventDefault();
	}
});
</script>

<link href="<?php echo base_url()?>statics/css/<?php echo sys_skin()?>/bills.css?ver=20150522" rel="stylesheet" type="text/css">
<style>
#barCodeInsert{margin-left: 10px;font-weight: 100;font-size: 12px;color: #fff;background-color: #B1B1B1;padding: 0 5px;border-radius: 2px;line-height: 19px;height: 20px;display: inline-block;}
#barCodeInsert.active{background-color: #23B317;}
</style>
</head>

<body>
<div class="wrapper">
  <span id="config" class="ui-icon ui-state-default ui-icon-config"></span>
  <div class="mod-toolbar-top mr0 cf dn" id="toolTop"></div>
  <div class="bills cf">
    <div class="con-header">
      <dl class="cf">
        <dd class="pct25">
          <label>客&nbsp;&nbsp;&nbsp;&nbsp;戶：</label>
          <span class="ui-combo-wrap" id="customer">
          <input type="text" name="" class="input-txt" autocomplete="off" value="" data-ref="date">
          <i class="ui-icon-ellipsis"></i></span>
        </dd>
        <dd id="identifier" class="pct20 tc">
          <label>銷售人員:</label>
          <span class="ui-combo-wrap" id="sales">
              <input type="text" class="input-txt" autocomplete="off">
          <i class="trigger"></i></span>
        </dd>
        <dd class="pct20 tc">
          <label>單據日期:</label>
          <input type="text" id="date" class="ui-input ui-datepicker-input" value="2015-06-08">
        </dd>
        <dd id="identifier" class="pct20 tc">
          <label>單據編號:</label>
          <span id="number"><?php echo str_no('XS');?></span></dd>
        <!-- <dd id="classes" class="pct15 tr">
          <label class="radio">
            <input type="radio" name="classes" value="150601">
            銷貨</label>
          <label class="radio">
            <input type="radio" name="classes" value="150602">
            退貨</label>
        </dd> -->
      </dl>
      <!-- add by michen 20170724 begin -->
      <dl class="cf">
        <dd class="pct20">
          <label>聯繫人：</label>
          <span class="ui-combo-wrap" id="linkMan">
              <input type="text" name="" class="input-txt" autocomplete="off" value="">
              <i class="trigger"></i>
          </span>
        </dd>
        <dd class="pct25 tc">
          <label>地址:</label>
          <span id="linkAddress">
            <input type="text" class="ui-input" value=""  style="width:250px">
          </span>
        </dd>
        <dd class="pct20 tc">
          <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;電話:</label>
          <span id="linkPhone">
            <input type="text" class="ui-input" value="">
          </span>
        </dd>
      </dl>
      <!-- add by michen 20170724 end -->
    </div>
    <div class="grid-wrap">
      <table id="grid">
      </table>
      <div id="page"></div>
    </div>
    <div class="con-footer cf">
      <div class="mb10">
        	<textarea type="text" id="note" class="ui-input ui-input-ph">暫無備註資訊</textarea>
      </div>
      <ul id="amountArea" class="cf">
        <li>
          <label>優惠率:</label>
          <input type="text" id="discountRate" class="ui-input" data-ref="deduction">%
        </li>
        <li>
          <label>優惠金額:</label>
          <input type="text" id="deduction" class="ui-input" data-ref="payment">
        </li>
        <li>
          <label>優惠後金額:</label>
          <input type="text" id="discount" class="ui-input ui-input-dis" data-ref="discountRate" disabled>
        </li>
        <li>
          <label>客戶承擔費用:</label>
          <input type="text" id="customerFree" class="ui-input" data-ref="customerFree">
        </li>
        <li>
          <label id="paymentTxt">本次收款:</label>
          <input type="text" id="payment" class="ui-input">&emsp;
        </li>
        <li id="accountWrap" class="dn">
          <label>結算賬戶:</label>
          <span class="ui-combo-wrap" id="account" style="padding:0;">
          <input type="text" class="input-txt" autocomplete="off">
          <i class="trigger"></i></span><a id="accountInfo" class="ui-icon ui-icon-folder-open" style="display:none;"></a>
        </li>
        <li>
          <label>本次欠款:</label>
          <input type="text" id="arrears" class="ui-input ui-input-dis" disabled>
        </li>
        <li class="dn">
          <label>累計欠款:</label>
          <input type="text" id="totalArrears" class="ui-input ui-input-dis" disabled>
        </li>
      </ul>
      <ul class="c999 cf">
        <li>
          <label>制單人:</label>
          <span id="userName"></span>
        </li>
        <li>
          <label>審覈人:</label>
          <span id="checkName"></span>
        </li>
		<li>
          <label>錄單時間:</label>
          <span id="createTime"></span>
        </li>
        <li>
          <label>最後修改時間:</label>
          <span id="modifyTime"></span>
        </li>
      </ul>
    </div>
    <div class="cf" id="bottomField">
    	<div class="fr" id="toolBottom"></div>
    </div>
    <div id="mark"></div>
  </div>
  
  <div id="initCombo" class="dn">
    <input type="text" class="textbox goodsAuto" name="goods" autocomplete="off">
    <input type="text" class="textbox storageAuto" name="storage" autocomplete="off">
    <input type="text" class="textbox unitAuto" name="unit" autocomplete="off">
    <input type="text" class="textbox batchAuto" name="batch" autocomplete="off">
    <input type="text" class="textbox dateAuto" name="date" autocomplete="off">
    <input type="text" class="textbox priceAuto" name="price" autocomplete="off">
  </div>
  <div id="storageBox" class="shadow target_box dn">
  </div>
</div>
<script src="<?php echo base_url()?>statics/js/dist/sales.js?ver=2017082001"></script>
</body>
</html>



