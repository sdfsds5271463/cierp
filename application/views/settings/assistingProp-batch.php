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
</style>
</head>

<body>
<div class="container" style="margin:20px;">
  <div class="mod-search m0 cf">
     <ul class="ul-inline">
       <li>
         <input type="text" id="matchCon" class="ui-input ui-input-ph" value="輸入規格、屬性名稱查詢">
       </li>
       <li><a class="ui-btn" id="search">查詢</a></li>
       <li><a class="ui-btn ui-btn-sp" id="add">新增</a></li>
     </ul>
  </div>
  <div class="grid-wrap">
    <table id="grid">
    </table>
    <div id="page"></div>
  </div>
</div>
<script src="<?php echo base_url()?>/statics/js/dist/assistingPropBatch.js?ver=20140430"></script>
</body>
</html>

 