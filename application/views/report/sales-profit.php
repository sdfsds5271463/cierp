<?php if(!defined('BASEPATH')) exit('No direct script access allowed');?>
<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<title>線上進銷存</title>
<link href="<?php echo base_url()?>statics/css/common.css?ver=20140430" rel="stylesheet">
<link href="<?php echo base_url()?>statics/css/<?php echo sys_skin()?>/ui.min.css?ver=20140430" rel="stylesheet">
<script src="<?php echo base_url()?>statics/js/common/seajs/2.1.1/sea.js?ver=20140430" id="seajsnode"></script>
<script src="<?php echo base_url()?>statics/js/common/libs/jquery/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
var WDURL = "";
var SCHEME= "<?php echo sys_skin()?>";
try{
	document.domain = '<?php echo base_url()?>';
}catch(e){
	//console.log(e);
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
<link rel="stylesheet" href="<?php echo base_url()?>statics/css/report.css?2" />
<style type="text/css">
.filter-menu .mod-choose-input{position: relative;*zoom: 1;}
.filter-menu .mod-choose-input .ui-input{padding-right: 25px;width:226px; font-family:"細明體";}
.filter-menu .ui-datepicker-input{width:105px; font-family:"細明體";}
.ui-icon-ellipsis{ right:3px; }
.ul-inline li{position:relative;}
#goodsAuto{width:200px;}
.no-query {
    background: url("<?php echo base_url()?>statics/css/img/no_query.png") no-repeat scroll 100px 60px #fff;
    border: 1px solid #ddd;
    height: 402px;
    margin-right: 18px;
}
#chk-wrap{line-height: 30px;}
.frozen-sdiv{ display: none;}
th.ui-th-column div{
        white-space:normal !important;
        height:auto !important;
        padding:0px;
    }
</style>
</head>
<body>
<div class="wrapper">
  <div class="mod-search cf">
    <div class="l">
      <ul class="ul-inline fix">
      	<li>
          <label>日期:</label>
          <input type="text" value="" class="ui-input ui-datepicker-input" name="filter-fromDate" id
="filter-fromDate" /> - <input type="text" value="" class="ui-input ui-datepicker-input" name="filter-toDate"
 id="filter-toDate" />
        </li>
        <li>
            <label class="tit">客戶:</label>
            <span class="mod-choose-input" id="filter-customer"><input type="text" class="ui-input" id="customerAuto"/><span class="ui-icon-ellipsis"></span></span>
          </li>
        <li>
            <label class="tit">銷售人員:</label>
            <span class="mod-choose-input" id="filter-saler"><input type="text" class="ui-input" id="salerAuto"><span class="ui-icon-ellipsis"></span></span>
          </li>
        <li><a class="ui-btn mrb" id="filter-submit">查詢</a></li>
      </ul>
    </div>
    <div class="r"><a href="#" class="ui-btn ui-btn-sp fl" id="btn-export">導出</a></div>
  </div>
  
  <div class="ui-print">
    <span id="config" class="ui-icon ui-state-default ui-icon-config"></span>
    <div class="grid-wrap" id="grid-wrap">
			<div class="grid-title">銷售利潤表</div>
			<div class="grid-subtitle"></div>
	    	<table id="grid"></table>
	   	</div>
	</div>
    <div class="no-query"></div>
</div>
 <!--
  <div class="grid-wrap">
    <div class="grid">
      <table width=100% class="caption">
        <tr>
          <td class='H'>銷售彙總表（按商品）</td>
        </tr>
        <tr>
          <td>日期：至</td>
        </tr>
      </table>
      <table width="1128px" class="list">
        <thead>
          <tr>
            <td>商品編號</td>
            <td width="150px">商品名稱</td>
            <td>規格型號</td>
            <td>單位</td>
            <td>倉庫</td>
            <td>數量</td>
            <td>單價</td>
            <td>銷售收入</td>
            
          </tr>
        </thead>
        <tbody>
          
          <tr>
            <td colspan="5" class="R B">合計：</td>
            <td class="R B"></td>
            <td class="R B"></td>
            <td class="R B"></td>
            
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  -->
  
<script>
	seajs.use("dist/salesProfit");
</script>
</body>
</html>




 