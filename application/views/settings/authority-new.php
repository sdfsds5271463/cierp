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

<link href="<?php echo base_url()?>/statics/css/authority.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="wrapper authority-wrap">
  <div class="mod-inner">
       
      <div class="authority-ctn-wrap">
         
        <div class="register-wrap">
            <h3>新建使用者</h3>
            <form action="#" id="registerForm" class="register-form">
              <ul class="mod-form-rows">
                <li class="row-item">
                  <div class="label-wrap">
                    <label for="userName">使用者名稱</label>
                  </div>
                  <div class="ctn-wrap">
                    <input type="text" class="ui-input" id="userName" name="userName"/>
                    <p class="msg">使用者名稱由4-20個英文字母或數字組成（不支援中文，不區分大小寫字母）。一旦建立成功，不可修改。</p>
                  </div>
                </li>
                <li class="row-item">
                  <div class="label-wrap">
                    <label for="password">密碼</label>
                  </div>
                  <div class="ctn-wrap">
                    <input type="password" class="ui-input" id="password" name="password" style="ime-mode
:disabled;" onpaste="return false;"/>
                    <div class="pswStrength" id="pswStrength" style="display:none;">
                      <p>密碼強度</p>
                      <b></b>
                      <b></b>
                      <b></b>
                    </div>
                    <p class="msg">密碼由6-20個英文字母（區分大小寫）或數字或特殊符號組成。</p>
                  </div>
                </li>
                <li class="row-item">
                  <div class="label-wrap">
                    <label for="pswConfirm">確認密碼</label>
                  </div>
                  <div class="ctn-wrap">
                    <input type="password" class="ui-input" id="pswConfirm" name="pswConfirm" style="ime-mode
:disabled;" onpaste="return false;"/>
                  </div>
                </li>
                <li class="row-item">
                  <div class="label-wrap">
                    <label for="realName">真實姓名</label>
                  </div>
                  <div class="ctn-wrap">
                      <input type="text" class="ui-input" id="realName" name="realName"/>
                      <p class="msg">真實姓名將應用在單據和賬表列印中，請如實填寫</p>
                  </div>
                </li>
                <li class="row-item">
                  <div class="label-wrap">
                    <label for="">常用手機</label>
                  </div>
                  <div class="ctn-wrap">
                      <input type="text" class="ui-input" id="userMobile" name="userMobile"/>
                      <p class="msg">手機將作為找回密碼的重要依據</p>
                  </div>
                </li>
              </ul>
              <div class="btn-row">
                <a href="authority" class="ui-btn mrb">返回列表</a><a href="#" class="ui-btn ui-btn-sp" id="registerBtn">下一步</a>
              </div>
            </form>
        </div>
      <div>
  </div>
</div>
<script src="<?php echo base_url()?>/statics/js/dist/register.js?ver=20140430"></script>
</body>
</html>

 