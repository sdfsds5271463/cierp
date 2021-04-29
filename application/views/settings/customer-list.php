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

<style>
.matchCon{width:280px;}
</style>
</head>
<body>
<div class="wrapper">
	<div class="mod-search cf">
	    <div class="fl">
	      <ul class="ul-inline">
	      	<li>
	        	<span id="catorage"></span>
	        </li>
	        <li>
	          <input type="text" id="matchCon" class="ui-input ui-input-ph matchCon" value="輸入客戶編號/ 名稱/ 聯繫人/ 電話查詢">
	        </li>
	        <li><a class="ui-btn mrb" id="search">查詢</a></li>
	      </ul>
	    </div>
	    <div class="fr"><a href="#" class="ui-btn ui-btn-sp mrb" id="btn-add">新增</a><a class="ui-btn mrb"
 id="btn-disable">禁用</a><a class="ui-btn mrb" id="btn-enable">啟用</a><!--<a href="#" class="ui-btn mrb"
 id="btn-print">列印</a>--><a href="#" class="ui-btn mrb" id="btn-import">匯入</a><a href="#" class="ui-btn
 mrb" id="btn-export">導出</a><a href="#" class="ui-btn" id="btn-batchDel">刪除</a></div>
	  </div>
    <div class="grid-wrap">
	    <table id="grid">
	    </table>
	    <div id="page"></div>
	  </div>
</div>
<script src="<?php echo base_url()?>statics/js/dist/customerList.js?ver=2017071101"></script>
</body>
</html>


 