<?php $this->load->view('header');?>

<script type="text/javascript">
var DOMAIN = document.domain;
var WDURL = "";
var SCHEME= "<?php echo sys_skin()?>";
try{
	document.domain = 'youshang.com';
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
.backup-status{margin: 10px 0 20px;}
</style>
</head>

<body>
<div class="wrapper setting-wrap">
    <div class="mod-toolbar-top cf">
        <a class="ui-btn ui-btn-sp fl mrb" id="start-backup" herf="#">開始備份</a>
        <!--<a class="ui-btn fl" id="auto-backup" herf="#">自動備份</a>-->
        <a herf="#" class="ui-btn fl local-recover" id="localRecover">上傳本地備份</a>
    </div>
    <div class="grid-wrap">
    	<div id="backup-status" class="backup-status"></div>
    </div> 
</div>
<script src="<?php echo base_url()?>statics/js/dist/backup.js?ver=20140430"></script>
</body>
</html>


 