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
#matchCon { width: 220px; }
#print{margin-left:10px;}
a.ui-btn{margin-left:10px;}
#reAudit,#audit{display:none;}
</style>
</head>

<body>
<div class="wrapper">
  <div class="mod-search cf">
    <div class="fl">
      <ul class="ul-inline">
        <li>
          <input type="text" id="matchCon" class="ui-input ui-input-ph" value="請輸入單據號或客戶名或備註">
        </li>
        <li>
          <label>日期:</label>
          <input type="text" id="beginDate" value="2015-07-21" class="ui-input ui-datepicker-input">
          <i>-</i>
          <input type="text" id="endDate" value="2015-07-27" class="ui-input ui-datepicker-input">
        </li>
        <li><a class="mrb more" id="moreCon">(高級搜索)</a><a class="ui-btn" id="search">查詢</a><!--<a class="ui-btn ui-btn-refresh" id="refresh" title="重新整理"><b></b></a>--></li>
      </ul>
    </div>
    <div class="fr"><a class="ui-btn ui-btn-sp" id="add">新增</a>
	<a class="ui-btn" id="print" target="_blank" href="javascript:void(0);">列印</a>
 
	<a class="ui-btn" id="export" target="_blank" href="javascript:void(0);">導出</a>
	<a class="ui-btn dn" id="audit">審覈</a><a class="ui-btn" id="reAudit">反審覈</a></div>
  </div>
<!--  <div class="mod-toolbar-top cf">
    <div class="fl"><strong class="tit">倉庫</strong></div>
    <div class="fr"><a class="ui-btn ui-btn-sp mrb" id="search">新增</a><a class="ui-btn" id="export">導出</a></div>
  </div>-->
  <div class="grid-wrap">
    <table id="grid">
    </table>
    <div id="page"></div>
  </div>
</div>
<script src="<?php echo base_url()?>/statics/js/dist/salesOrderList.js?ver=201507241412"></script>
</body>
</html>
 