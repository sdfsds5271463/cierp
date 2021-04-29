<?php $this->load->view('header');?>
<script type="text/javascript">
var DOMAIN = document.domain;
var WDURL = "";
var SCHEME= "<?php echo sys_skin()?>";
try{
	document.domain = '<?php echo base_url()?>';
}catch(e){
}
</script>

<link href="<?php echo base_url()?>statics/css/<?php echo sys_skin()?>/index.css?2" rel="stylesheet" type="text/css" id="indexFile">
<script src="<?php echo base_url()?>statics/js/dist/template.js?2"></script>

</head>
<body>
<div id="hd" class="cf">
  <div class="fl welcome cf">
	  <strong><span id="greetings"></span>，<span id="username"></span></strong>
	  <a href="javascrip:void(0);" id="manageAcct">賬號管理</a>
	  <!--<a href="" target="_blank" id="newGuide" title="新手入門">新手入門</a>-->
  </div>
  
  
  
  <div class="fr storages-search"><label><a class="b" id="invWarning">庫存預警</a></label><label for="">庫存查詢</label><span class="ui-search"><input type="text" id="goodsAuto" class="ui-input" /></span><span id="stockSearch"></span></div>
</div>
<script>
var greetings = "", cur_time = new Date().getHours();
if(cur_time >= 0 && cur_time <= 4 ) {
	greetings = "已經夜深了，請注意休息"
} else if (cur_time > 4 && cur_time <= 7 ) {
	greetings = "早上好";
} else if (cur_time > 7 && cur_time < 12 ) {
	greetings = "上午好";
} else if (cur_time >= 12 && cur_time <= 18 ) {
	greetings = "下午好";
} else {
	greetings = "晚上好";
};
$("#greetings").text(greetings);
$("#username").text(parent.SYSTEM.realName);
</script>
<div id="bd" class="index-body cf">
  <div class="col-main">
    <div class="main-wrap cf">
      <div class="m-top cf" id="profileDom">
      <!-- 
      	<div class="fr" id="interval">
          	<label class="radio"><input type="radio" name="interval" value="month" checked="checked">本月</label>
          	<label class="radio"><input type="radio" name="interval" value="year">本年</label>
      		<label class="radio"><input type="radio" name="interval" value="today">今日</label>
          	<label class="radio"><input type="radio" name="interval" value="yesterday">昨日</label>
        </div>
       -->
		<table width="100%" border="0" cellspacing="0" cellpadding="20">
		  <tr>
		    <td><a class="ta t1" tabid="report-initialBalance" data-right="InvBalanceReport_QUERY" tabTxt="商品庫存餘額" parentOpen="true" rel="pageTab" href="<?php echo site_url('report/goods_balance')?>">商品庫存餘額</a></td>
		    <td><a class="ta t2" tabid="report-cashBankJournal" data-right="SettAcctReport_QUERY" tabTxt="現金銀行報表" parentOpen="true" rel="pageTab" href="<?php echo site_url('report/bankBalance_detail?action=detail')?>">現金銀行報表</a></td>
		    <td><a class="ta t3" tabid="report-contactDebt" data-right="ContactDebtReport_QUERY" tabTxt="往來單位欠款表" parentOpen="true" rel="pageTab" href="<?php echo site_url('report/contact_debt_new?action=detail')?>">往來單位欠款表</a></td>
		    <td><a class="ta t4" tabid="report-salesSummary" data-right="SAREPORTINV_QUERY" tabTxt="銷售彙總表（按商品）" parentOpen="true" rel="pageTab" href="<?php echo site_url('report/sales_summary')?>">銷售彙總表</a></td>
		    <td><a class="ta t5" tabid="report-puSummary" data-right="PUREPORTINV_QUERY" tabTxt="採購彙總表（按商品）" parentOpen="true" rel="pageTab" href="<?php echo site_url('report/puDetail_inv')?>">採購彙總表</a></td>  
		  </tr>
		</table>
      </div>
      <ul class="quick-links">
        <li class="purchase-purchase">
        	<a tabid="purchase-purchase" data-right="PU_ADD" tabTxt="購貨單" parentOpen="true" rel="pageTab" href="<?php echo site_url('scm/invPu?action=initPur')?>"><span></span>採購入庫</a>
        </li>
        <li class="sales-sales">
        	<a tabid="sales-sales" data-right="SA_ADD" tabTxt="銷貨單" parentOpen="true" rel="pageTab" href="<?php echo site_url('scm/invSa?action=initSale')?>"><span></span>銷貨出庫</a>
        </li>
        <li class="storage-transfers">
        	<a tabid="storage-transfers" data-right="TF_ADD" tabTxt="調撥單" parentOpen="true" rel="pageTab" href="<?php echo site_url('scm/invTf?action=initTf')?>"><span></span>倉庫調撥</a>
        </li>
        <li class="storage-inventory">
        	<a tabid="storage-inventory" data-right="PD_GENPD" tabTxt="盤點" parentOpen="true" rel="pageTab" href="<?php echo site_url('storage/inventory')?>"><span></span>庫存檔點</a>
        </li>
        <li class="storage-otherWarehouse">
        	<a tabid="storage-otherWarehouse" data-right="IO_ADD" tabTxt="其他入庫" parentOpen="true" rel="pageTab" href="<?php echo site_url('scm/invOi?action=initOi&type=in')?>"><span></span>其他入庫</a>
        </li>
        <li class="storage-otherOutbound">
        	<a tabid="storage-otherOutbound" data-right="OO_ADD" tabTxt="其他出庫" parentOpen="true" rel="pageTab" href="<?php echo site_url('scm/invOi?action=initOi&type=out')?>"><span></span>其他出庫</a>
        </li>
        <li class="added-service">
        	<!--<a tabid="setting-addedServiceList" tabTxt="增值服務" parentOpen="true" rel="pageTab" href="<?php echo site_url('settings/addedServiceList')?>"><span></span>增值服務</a>-->
			<a href="#" id="feedback"><span></span>增值服務</a>
        </li>
        <li class="feedback">
        	<a href="#" id="feedback"><span></span>意見反饋</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="col-extra">
    <div class="extra-wrap">
      <h2>快速檢視</h2>
      <div class="list">
        <ul>
            <li><!--<span class="bulk-import">匯入</span>--><a tabid="setting-goodsList" data-right="INVENTORY_QUERY" tabTxt="商品管理" parentOpen="true" rel="pageTab" href="<?=site_url('settings/goods_list')?>">商品管理</a></li>
            <li><!--<span class="bulk-import">匯入</span>--><a tabid="setting-customerList" data-right="BU_QUERY" tabTxt="客戶管理" parentOpen="true" rel="pageTab" href="<?=site_url('settings/customer_list')?>">客戶管理</a></li>
            <li><!--<span class="bulk-import">匯入</span>--><a tabid="setting-vendorList" data-right="PUR_QUERY" tabTxt="供應商管理" parentOpen="true" rel="pageTab" href="<?=site_url('settings/vendor_list')?>">供應商管理</a></li>
            <li><a tabid="sales-salesList" data-right="SA_QUERY" tabTxt="銷貨記錄" parentOpen="true" rel="pageTab" href="<?=site_url('scm/invSa?action=initSaleList')?>">銷售記錄</a></li>
            <li><a tabid="purchase-salesList" data-right="PU_QUERY" tabTxt="採購記錄" parentOpen="true" rel="pageTab" href="<?=site_url('scm/invPu?action=initPurList')?>">採購記錄</a></li>
        	<li><a href="<?=site_url('scm/receipt?action=initReceipt')?>" rel="pageTab" tabid="money-receiptList" tabTxt="收款記錄" data-right="RECEIPT_QUERY" parentOpen="true">收款記錄</a></li>
            <li><a href="<?=site_url('scm/payment?action=initPay')?>" rel="pageTab" tabid="money-paymentList" tabTxt="付款記錄" data-right="PAYMENT_QUERY" parentOpen="true">付款記錄</a></li>
        	<li><a href="<?=site_url('report/sales_detail')?>" rel="pageTab" tabid="report-salesDetail" tabTxt="銷售明細表" data-right="SAREPORTDETAIL_QUERY" parentOpen="true">銷售明細表</a></li>
            <li><a href="<?=site_url('report/pu_detail_new')?>" rel="pageTab" tabid="report-puDetail" tabTxt="採購明細表" data-right="PUREOORTDETAIL_QUERY" parentOpen="true">採購明細表</a></li>
        	<li style="border-bottom:none; line-height: 42px; "><a tabid="storage-transfersList" data-right="TF_QUERY" tabTxt="調撥記錄" parentOpen="true" rel="pageTab" href="<?=site_url('scm/invTf?action=initTfList')?>">調撥記錄</a></li>
        	<!--
        	<li><a tabid="storage-otherWarehouseList" data-right="IO_QUERY" tabTxt="其他入庫記錄" parentOpen="true" rel="pageTab" href="/scm/invOi.do?action=initOiList&type=in">其他入庫記錄</a></li>
        	<li><a tabid="storage-otherOutboundList" data-right="OO_QUERY" tabTxt="其他出庫記錄" parentOpen="true" rel="pageTab" href="/scm/invOi.do?action=initOiList&type=out">其他出庫記錄</a></li>
        	<li><a tabid="report-initialBalance" data-right="InvBalanceReport_QUERY" tabTxt="商品庫存餘額" parentOpen="true" rel="pageTab" href="/report/invBalance.do?action=detail">商品庫存餘額</a></li>
        	<li><a tabid="report-contactDebt" data-right="ContactDebtReport_QUERY" tabTxt="往來單位欠款表" parentOpen="true" rel="pageTab" href="/report/contactDebt.do?action=detail">往來單位欠款</a></li>
        	-->
        </ul>
      </div>
    </div>
  </div> 
</div>
<script id="profile" type="text/html">
		<table width="100%" border="0" cellspacing="0" cellpadding="20">
		  <tr>
		    <td><a class="tad t1" tabid="report-initialBalance" data-right="InvBalanceReport_QUERY" tabTxt="商品庫存餘額" parentOpen="true" rel="pageTab" href="<?php echo site_url('report/goods_balance')?>?search=true"><span>庫存總量:<b><#= items[0].total1 #></b></span><span>庫存成本:<b><#= items[0].total2 #></b></span></a></td>
		    <td><a class="tad t2" tabid="report-cashBankJournal" data-right="SettAcctReport_QUERY" tabTxt="現金銀行報表" parentOpen="true" rel="pageTab" href="<?php echo site_url('report/cash_bank_journal_new')?>"><span>現金:<b><#= items[1].total1 #></b></span><span>銀行存款:<b><#= items[1].total2 #></b></span></a></td>
		    <td><a class="tad t3" tabid="report-contactDebt" data-right="ContactDebtReport_QUERY" tabTxt="往來單位欠款表" parentOpen="true" rel="pageTab" href="<?php echo site_url('report/contact_debt_new')?>"><span>客戶欠款:<b><#= items[2].total1 #></b></span><span>供應商欠款:<b><#= items[2].total2 #></b></span></a></td>
		    <td><a class="tad t4" tabid="report-salesSummary" data-right="SAREPORTINV_QUERY" tabTxt="銷售彙總表（按商品）" parentOpen="true" rel="pageTab" href="<?php echo site_url('report/sales_summary')?>"><span>銷售收入(本月):<b><#= items[3].total1 #></b></span><span>商品毛利(本月):<b><#= items[3].total2 #></b></span></a></td>
		    <td><a class="tad t5" tabid="report-puSummary" data-right="PUREPORTINV_QUERY" tabTxt="採購彙總表（按商品）" parentOpen="true" rel="pageTab" href="<?php echo site_url('report/pu_summary_new')?>"><span>採購金額(本月):<b><#= items[4].total1 #></b></span><span>商品種類(本月):<b><#= items[4].total2 #></b></span></a></td>  
		  </tr>
		</table>
		<i></i>  
</script>

<script>
parent.dataReflush = function(){
	if(parent.SYSTEM.isAdmin || parent.SYSTEM.rights.INDEXREPORT_QUERY) {
		template.openTag = '<#';
		template.closeTag = '#>';
		Public.ajaxGet('../report/index?action=getInvData', {finishDate: parent.SYSTEM.endDate, beginDate: parent.SYSTEM.beginDate, endDate: parent.SYSTEM.endDate }, function(data){
			if(data.status === 200) {
				var html = template.render('profile', data.data);
				document.getElementById('profileDom').innerHTML = html;
				reportParam();
			} else {
				parent.Public.tips({type: 1, content : data.msg});
			}
		});
	};
};
parent.dataReflush();
$('#profileDom').on('click','i',function(){
	parent.dataReflush();
});
</script>

<script>
Public.pageTab();
reportParam();
function reportParam(){
	$("[tabid^='report']").each(function(){
		var dateParams = "beginDate="+parent.SYSTEM.beginDate+"&endDate="+parent.SYSTEM.endDate;
		var href = this.href;
		href += (this.href.lastIndexOf("?")===-1) ? "?" : "&";
		if($(this).html() === '商品庫存餘額表'){
			this.href = href + "beginDate="+parent.SYSTEM.startDate+"&endDate="+parent.SYSTEM.endDate;
		}
		else{
			this.href = href + dateParams;
		}
	});
}

var goodsCombo = Business.goodsCombo($('#goodsAuto'), {
	extraListHtml: ''
});

$('#goodsAuto').click(function(){
	var _self = this;
	setTimeout(function(){
		_self.select();
	}, 50);
});

$('#invWarning').click(function(){
	if (!Business.verifyRight('INVENTORY_WARNING')) {
		return ;
	};
	$.dialog({
		width: 800,
		height: 410,
		title: '商品庫存預警',
		//content: 'url:/inventory-warning.jsp',
		content: 'url:../settings/inventory_warning',
		cancel: true,
		lock: true,
		cancelVal: '關閉'
	});
});

$('#stockSearch').click(function(e){
	e.preventDefault();
	var id = goodsCombo.getValue();
	var text = $('#goodsAuto').val();
	Business.forSearch(id, text);
	$('#goodsAuto').val('');
});

$("#feedback").click(function(e){
	e.preventDefault();
	parent.tab.addTabItem({tabid: 'myService', text: '服務支援', url: '../service', callback: function(){
		parent.document.getElementById('myService').contentWindow.openTab(3);
	}});
});

$('.bulk-import').click(function(e){
  e.preventDefault();
  if (!Business.verifyRight('BaseData_IMPORT')) {
	  return ;
  };
  parent.$.dialog({
	  width: 560,
	  height: 300,
	  title: '批量匯入',
	  content: 'url:../import',
	  data: {
		  callback: function(row){

		  }
	  },
	  lock: true
  });
});

$('#manageAcct').click(function(e){
	e.preventDefault();
    var updateUrl = location.protocol + '//' + location.host + '/update_info';
    $.dialog({
        min: false,
        max: false,
        cancle: false,
        lock: true,
        width: 500,
        height: 380,
        title: '賬號管理',
        //content: 'url:' + url
		content: 'url:../home/set_password'
    });
});

//公告
(function (){
	var URL = parent.CONFIG.SERVICE_URL, SYSTEM = parent.SYSTEM;
	var version;
	switch (SYSTEM.siVersion) {
		case 3:
		  version = '1';
		  break;
		case 4:
		  version = '3';
		  break;
		default:
		  version = '2';
	};
	var param = '?eventType=2&serviceId=' + SYSTEM.DBID;	//自帶參數
	$.getJSON("../home/Services?callback=?", {coid : SYSTEM.DBID, loginuserno: SYSTEM.UserName, version: version, type: 'getsystemmsg' + SYSTEM.servicePro}, function(data){ 
		if(data.msg == 'success'){
			if(data.data.length == 0){
				return;
			}
			var $notices = $('<span class="notices" id="notices"></span>'), 
				html = [], 
				notice,
				li = '';
			data = data.data;
			for(var i=0; i<data.length; i++){
				notice = data[i];
				if(notice.msglink){
					li = '<li><a target="_blank" href="' + notice.msglink + param + '" title="' + notice.msgtitle + '" data-id="' + notice.msgid + '"><i></i>' + notice.msgtitle + '</a></li>'
				}else{
					li = '<li><a href="../home/Services?newsId=' + notice.msgid + '" rel="pageTab" tabId="myService" tabTxt="服務支援" parentOpen="true" title="' + notice.msgtitle + '" data-id="' + notice.msgid + '"><i></i>' + notice.msgtitle + '</a></li>'
				}
				html.push(li);
			}
			$notices.append('<ul>' + html.join('') + '</ul>').appendTo('.welcome');
			Public.txtSlide();
		}
	});
})();
</script>
</body>
</html>