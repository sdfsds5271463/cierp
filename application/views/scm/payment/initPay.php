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
<link href="<?php echo base_url()?>statics/css/<?php echo sys_skin()?>/bills.css?ver=20150427" rel="stylesheet" type="text/css">
 
</head>

<body>
<div class="wrapper">
  <span id="config" class="ui-icon ui-state-default ui-icon-config"></span>
  <div class="mod-toolbar-top mr0 cf dn" id="toolTop"></div>
  <div class="bills">
    <div class="con-header">
      <dl class="cf">
        <dd class="pct40">
          <label>購貨單位：</label>
          <span class="ui-combo-wrap" id="customer">
          <input type="text" name="" class="input-txt" autocomplete="off" value="" data-ref="date">
          <i class="ui-icon-ellipsis"></i></span></dd>
        <dd class="pct30 tc">
          <label>單據日期：</label>
          <input type="text" id="date" class="ui-input ui-datepicker-input" value="2015-10-27">
        </dd>
        <dd id="identifier" class="fl pct30 tr">
          <label>單據編號：</label>
          <span id="number"><?php echo str_no('FKD')?></span></dd>
      </dl>
    </div>
    <div class="grid-wrap mb10" id="acGridWrap">
      <table id="accountGrid">
      </table>
    </div>
    <div id="standardVersion" class="dn">
        <div class="tr" style="margin:0 -10px 10px 0; "><a class="ui-btn" id="selectSource">選擇源單</a></div>
        <div class="grid-wrap" id="billGridWrap">
          <table id="grid">
          </table>
        </div>
        <!-- <div class="con-footer cf">
            <label id="paymentTxt">整單折扣:</label>
            <input type="text" id="discount" class="ui-input">&emsp;
            <span>
            <label>本次預付款:</label>
            <input type="text" id="payment" class="ui-input ui-input-dis" disabled>
            </span>
        </div> -->
    </div>
    <!-- <div class="con-footer cf pt">
    		<div class="mb10">
	      	<div class="label-wrap">
	        	<label>備註:</label>
	        </div>
	        <div class="ctn-wrap">
	        	<input type="text" id="note" class="ui-input" data-ref="discount" style="width:100%; margin:0 -6px; ">
	        </div>
	      </div>
	</div> -->
    <div class="con-footer cf">
      <div class="mb10">
          <textarea type="text" id="note" class="ui-input ui-input-ph">暫無備註資訊</textarea>
      </div>
      <ul id="amountArea" class="cf">
        <li>
          <label id="paymentTxt">整單折扣:</label>
          <input type="text" id="discount" class="ui-input">&emsp;
        </li>
        <li id="accountWrap">
          <label>本次預付款:</label>
          <input type="text" id="payment" class="ui-input ui-input-dis" disabled>
        </li>
      </ul>
      <ul class="c999 cf">
        <li>
          <label class="dn">制單人:</label>
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
          <label class="dn">最後修改時間:</label>
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
    <input type="text" class="textbox accountAuto" name="account" autocomplete="off">
    <input type="text" class="textbox paymentAuto" name="payment" autocomplete="off">
    <input type="text" class="textbox billAuto" name="goods" autocomplete="off">
  </div>
</div>
<script src="<?php echo base_url()?>statics/js/dist/payment.js?ver=201510141132"></script>
</body>
</html>
 