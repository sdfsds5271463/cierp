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

<link rel="stylesheet" href="<?php echo base_url()?>statics/js/common/libs/uploader/jquery.uploader.css">
<script type="text/javascript" src="<?php echo base_url()?>statics/js/common/libs/uploader/jquery.uploader.js"></script>
</head>

<body class="bgwh">
<div class="wrapper">
	<div class="mod-inner"  style="width:480px; ">
      <h3>請注意匯入格式跟導出格式儲存一致！</h3>
      <div id="import-wrap" class="cf">
          <div id="import-step2" class="step-item">
              <div class="ctn file-import-ctn"> 
                  <span class="tit">請選擇要匯入檔案：</span>
                  <input type="text" name="file-path" id="file-path" class="ui-input" readonly autocomplete
="false" />
                  <a class="ui-btn" type="button" id="selectFile" style="width: 60px; height: 30px; "
>選擇檔案</a>
              </div>				
          </div>
      </div>
	</div>
</div>

<script type="text/javascript">
var callback = null;
var api = frameElement.api;
(function($){	
    $('#selectFile').uploader({
        action: "../scm/pdImport?jsessionid=F8FCE30624F78A4008DDA0A9F6E0374F",
        //mode: 'flash',        //上傳模式，html5/flash
        name: "file",           //欄位名
        formData: {},           //
        multiple: false,         //是否多選
        auto: false,            //是否自動上傳
        showQueue: '#queue',                        //顯示佇列的位置（傳遞jQuery選擇器自定義佇列顯示的元素，傳遞true自動產生佇列）
        fileSizeLimit: '1M',                        //檔案大小限制（'100kb' '5M' 等）
        fileTypeDesc: '選擇檔案',      //可選擇的檔案的描述，用中豎線分組。此字串出現在瀏覽檔案對話方塊的檔案型別下拉中
        fileTypeExts: 'xlsx,xls',        //允許上傳的檔案型別類表，用逗號分隔多個擴充套件，用中豎線分組（eg: 'jpg,jpeg,png,gif'）

        /*
        // 滑鼠點選觸發按鈕
        onMouseClick: function(){
            //log('onMouseClick')
        },
        // 滑鼠經過觸發按鈕
        onMouseOver: function(el){
            //log('onMouseOver')
        },
        // 滑鼠移出觸發按鈕
        onMouseOut: function(el){
            //log('onMouseOut')
        },*/
        
        // 上傳初始化完成
        onInit:function(){

        },
        // 選擇檔案
        onSelected: function(filelist){
        	if(filelist.length > 0) {
        		$('#file-path').val(filelist[0].name);
        	}
        },
        // 開始上傳
        onStart: function(e){
        },
        // 上傳進行中
        onProgress: function(e){
        },
        // 上傳發生錯誤
        onError: function(e){
        	api.data && api.data.callback && api.data.callback(e);
        },
        // 上傳成功
        onSuccess: function(e){
        	var data = JSON.parse(e.data);
        	api.data && api.data.callback && api.data.callback(data);
        	//parent.parent.Public.tips({content: '匯入成功！'});
        	//parent.$('#search').trigger('click');
        	//parent.loading.close();
        	//parent.import_dialog.close();
        	
        },
        // 單個檔案處理完成（error or success）
        onComplete: function(e){
        },
        // 全部檔案處理完成（error or success）
        onAllComplete: function(){
        },
        // 清空佇列
        onClearQueue: function(){
        }
    }); 
    
    callback = function (){
    	$('#selectFile').uploader('start');

    };
})(jQuery);

</script>
</body>
</html>

