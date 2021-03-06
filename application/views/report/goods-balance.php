<?php if(!defined('BASEPATH')) exit('No direct script access allowed');?>
<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable
=no">
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
<link rel="stylesheet" href="<?php echo base_url()?>statics/css/report.css" />
<style type='text/css'>
.filter-menu .mod-choose-input{position: relative;*zoom: 1;}
.filter-menu .mod-choose-input .ui-input{padding-right: 25px;width:226px; font-family:"細明體";}
.filter-menu .ui-datepicker-input{width:105px; font-family:"細明體";}
.ui-icon-ellipsis{ right:3px; }
.ul-inline li{position:relative;}
.grid-subtitle{height: 18px;}
#goodsAuto{width:200px;}
.no-query {
    background: url("<?php echo base_url()?>statics/css/img/no_query.png") no-repeat scroll 100px 60px #fff;
    border: 1px solid #ddd;
    height: 402px;
    margin-right: 18px;
}
#chk-wrap{line-height: 30px;}
</style>
</head>
<body>
<div class="wrapper">
  <div class="mod-search cf">
    <div class="l">
      <ul class="ul-inline fix">
      	<li>
          <label>日期:</label>
          <input type="text" value="" class="ui-input ui-input-dis dn" name="filter-fromDate" id="filter-fromDate"
 readonly disabled/>
          <input type="text" value="" class="ui-input ui-datepicker-input" name="filter-toDate" id="filter-toDate"
 />
        </li>
        <li>
          <label>倉庫:</label>
          <span class="mod-choose-input" id="filter-storage"><input type="text" class="ui-input" id="storageAuto"
/><span class="ui-icon-ellipsis"></span></span>
        </li>
        <li>
          <label>類別:</label>
          <input type="text" value="" class="ui-input" name="filterCat" id="filterCat" />
        </li>
        <li>
          <label>商品:</label>
          <span class="mod-choose-input" id="filter-goods"><input type="text" class="ui-input" id="goodsAuto"
/><span class="ui-icon-ellipsis"></span></span>
        </li>
        <li class="chk-list" id="chk-wrap">
          <label class="chk"><input type="checkbox" value="showSku" name="showSku" />顯示輔助屬性</label>

        </li>
        <li><a class="ui-btn mrb" id="refresh">查詢</a></li>
      </ul>
    </div>
    <div class="r"><!-- <a href="#" class="ui-btn ui-btn-sp mrb fl" id="btn-print">列印</a> --><a href
="#" class="ui-btn ui-btn-sp fl" id="btn-export">導出</a></div>
  </div>
  <div class="no-query"></div>
  	<!-- grid begin -->
	<div class="ui-print" style="display: none;">
		<div class="grid-wrap" id="grid-wrap">
			<div class="grid-title">商品庫存餘額表</div>
			<div class="grid-subtitle"></div>
	    	<table id="grid"></table>
	   	</div>
	</div>
	<!-- grid end -->
</div>
<script>
	seajs.use("dist/goodsBalance");
</script>
</body>
</html>

 