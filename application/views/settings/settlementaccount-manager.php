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
body{background: #fff;}
.manage-wrap{margin: 20px auto 10px;width: 600px;}
.manage-wrap .ui-input{width: 185px;font-size:12px;}
.row-item{float:left ; width:50%;}
#balance{text-align:right;}
.mod-form-rows .label-wrap {font-size: 12px;}
</style>
</head>
<body>
<div id="manage-wrap" class="manage-wrap">
	<form id="manage-form" action="#">
		<ul class="mod-form-rows cf">
			<li class="row-item">
				<div class="label-wrap"><label for="number">賬戶編號</label></div>
				<div class="ctn-wrap"><input type="text" value="" class="ui-input" name="number" id="number"></div
>
			</li>
			<li class="row-item">
				<div class="label-wrap"><label for="name">賬戶名稱</label></div>
				<div class="ctn-wrap"><input type="text" value="" class="ui-input" name="name" id="name"></div>

			</li>
			<li class="row-item">
				<div class="label-wrap"><label for="name">餘額日期</label></div>
				<div class="ctn-wrap"><input type="text" value="" class="ui-input ui-datepicker-input" name="name"
 id="date"></div>
			</li>
			<li class="row-item">
				<div class="label-wrap"><label for="name">賬戶餘額</label></div>
				<div class="ctn-wrap"><input type="text" value="" class="ui-input" name="name" id="balance"></div
>
			</li>
			<li class="row-item row-category">
    				<div class="label-wrap"><label for="category">賬戶類別</label></div>
    				<div class="ctn-wrap"><span id="category"></span></div>
    		</li>
		</ul>
	</form>
</div>
<script src="<?php echo base_url()?>/statics/js/dist/settlementAccountManager.js?ver=20140430"></script>
</body>
</html>

 