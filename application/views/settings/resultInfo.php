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

<script src="<?php echo base_url()?>/statics/js/common/libs/swfupload/swfupload.js"></script>
<style>
body {min-width: 0;}
.link{color: #3A86B0;text-decoration: underline}
.state{color:red}
</style>
</head>
<body>
<a id="refresh" class="link" style="padding:10px;">重新整理狀態</a>
<div id="info" style="padding:10px;"></div>
<script>
Public.pageTab();
//獲取公告
function getResult(opt) {
	$.ajax({
		url: '../basedata/import/findDataImporter?action=findDataImporter',
		type: 'post',
		dataType: 'json',
		success: function(data){
			if(data.status == 200){
				if(data.data.items.length == 0) {
					$("#info").append("無匯入記錄！");
				}
				var uploadName = data.data.items[0].uploadName;
				var returnInfo = data.data.items[0].resultInfo;
				var status = data.data.items[0].status;
				var resultPath = data.data.items[0].resultPath;
				var state = '';
				if(status == 0) {
					state = '匯入被取消！';
				} else if(status == 1) {
					state = '匯入中。。。';
				} else if(status == 2) {
					state = '匯入完成！';
				} else if(status == 3) {
					state = '匯入完成！';
				} else {
					state = '匯入失敗！';
				}
				$("#info").append("狀態：");
				$("#info").append("<fron class='state'>" + state + "</fron><br/>");
				$("#info").append("時間：" +　data.data.items[0].date + "<br/>");
				$("#info").append("檔名稱：" +　uploadName + "<br/>");
				if(status != 1) {
					$("#info").append("詳細資訊:<br/>" + returnInfo);
					if(status != 0) {
						$("#info").append("<a href='/basedata/import.do?action=download&relativePath=" + encodeURIComponent(encodeURIComponent(resultPath)) + "' class='link'>下載錯誤數據檔案</a>");
					}
				} else {
					var dateStr = data.data.items[0].date;
					dateStr = dateStr.replace(/-/g,"/"); 
					var date = new Date(dateStr);
					var now = new Date();
					if(now.getTime() - date.getTime() > (1*60*60*1000)) {
						$("#info").append("<a class='link'>取消操作</a>").click(function(){
							$.ajax({
								url: '/basedata/import.do?action=deleteByStatus',
								type: 'post',
								success:function(data){
									if(opt && typeof opt.callback === 'function'){
										opt.callback();
									}
								}
							});
						});
						
					}
				}
			} else {
				Public.tips({ type:1,content : data.msg});
			}
		},
		error: function(){
			Public.tips({ type:1,content : '系統繁忙，請稍後重試！'});
		}
	});
}
(function(){
	var api = frameElement.api;
	var data = api.data || {};
	getResult(data);
	$('#refresh').click(function(){
		$("#info").html('');
		getResult(data);
	}); 
})();


</script>
</body>
</html>


