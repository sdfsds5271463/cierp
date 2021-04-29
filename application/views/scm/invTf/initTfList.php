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
.ui-jqgrid tr.jqgrow td{ height: 24px;padding: 3px 2px; }
</style>
</head>

<body>
<div class="wrapper">
  <div class="mod-search cf">
    <div class="fl">
      <ul class="ul-inline">
        <li>
          <input type="text" id="matchCon" class="ui-input ui-input-ph con" value="請輸入單據號或客戶名或備註">
        </li>
        <li>
          <label>日期:</label>
          <input type="text" id="beginDate" value="2015-04-10" class="ui-input ui-datepicker-input">

          <span>-</span>
          <input type="text" id="endDate" value="2015-04-16" class="ui-input ui-datepicker-input">
        </li>
        <li><a class="mrb more" id="moreCon">(高級搜索)</a><a class="ui-btn mrb" id="search">查詢</a></li>

      </ul>
    </div>
	<div class="fr"><a class="ui-btn ui-btn-sp mrb" id="add">新增</a><a class="ui-btn mrb" id="print" target="_blank">列印</a><a class="ui-btn mrb" id="export" target="_blank">導出</a> </div>
  </div>
    
  <div class="grid-wrap">
    <table id="grid">
    </table>
    <div id="page"></div>
  </div>
</div>
<script src="<?php echo base_url()?>statics/js/dist/transfersList.js?ver=20150430"></script>
</body>
</html>

 