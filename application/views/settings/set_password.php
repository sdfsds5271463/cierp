<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<!doctype html>
<html>
<head>
	<title>設定獨立密碼</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="http://images.youshang.com/resources/v7/css/phone_validate.css" />
	<script src="http://images.youshang.com/resources/v7/js/jquery.min.js"></script>
	<script type="text/javascript" src="http://images.youshang.com/resources/v7/js/checkPassword.js"></script>
	<script src="http://images.youshang.com/resources/v7/js/phone_validate.js?ver=201403201104"></script>
<style>
.tips{color: #eba434;border-color: #f5d193;box-shadow: 0 0 5px rgba(248,171,58,0.35);padding: 5px 30px 5px 10px;font-size: 12px;border: 1px solid #F5D4A0;border-radius: 2px;}
.tips a{margin: 0 5px;color: #eba434;font-weight: bolder;text-decoration: none;}
.mod-form{margin-top:10px;}
.mod-form li label{margin-bottom:5px;float:left; width:80px;height:32px; line-height:32px;}
.mod-form li span{display:inline-block;height:32px; line-height:32px;}
.mod-form li p{padding-left:80px;}
.wrapper{margin:0 auto;padding: 5px;width:420px;font-size:14px;}
.set-password .steps,.set-password .warning{padding:5px 0;}
.set-password .steps em{color:#eba434;font-weight: bold;}
.set-password .warning{margin-bottom: 10px;font-weight: bold;}
#btn-wrap .ui-btn{bottom: 5px;position: absolute;right: 10px;margin-left:5px;}
.tip{font-size: 12px;}
#success .tit{color:#689800;}
#success p{line-height:24px;}
</style>
</head>
<body>
<div class="wrapper">
	<div class="set-password">
		<p class="steps"></p>
		<p class="warning"></p>
		<p class="set-result hide"></p>
		<form action="" id="set-password-form">
			<ul class="mod-form">
				<li>
					<label>使用者名稱:</label>
					<span id="user-name"><?php echo $username?></span>
				</li>
				<li>
					<label for="real-name">真實姓名:</label>
					<input type="text" class="ui-input" placeholder="請輸入真實姓名" id="real-name" ></input>
				</li>
				<li>
					<label for="phone">手機號碼:</label>
					<input type="text" class="ui-input" id="phone" value="<?php echo $mobile?>"></input>
				</li>
				 
				<li>
					<label for="password">密碼:</label>
					<input type="password" class="ui-input" placeholder="設定登錄密碼" id="password"/>
					<p class="tip">長度8~20位，同時包含數字、字母（區分大小寫），可使用特殊符號</p>
				</li>
				<li>
					<label>確認密碼:</label>
					<input type="password" class="ui-input" placeholder="請再次輸入密碼" id="confirm-password" />
				</li>
				<li id="btn-wrap">
					<button class="ui-btn" id = "cancel">取消</button>
					<button class="ui-btn ui-btn-blue" type="submit">確定</button>
				</li>
			</ul>
		</form>
	</div>
	<div class="success hide" id="success">
		<h3 class="tit">恭喜您，帳號資訊修改成功！</h3>
		<p>您現在可以通過使用者名稱(<span class="userName"></span>)或手機號(<span class="phone"></span>)登錄使用！</p>
	</div>
	<iframe src="" frameborder="0" class="hide" id="update-iframe"></iframe>
</div>

<script type="text/javascript">
var PARAMS = getUrlParams();
var USERID = <?php echo $uid?>;
var realname = '<?php echo $name?>';
$(function(){
	$('#real-name').val(realname);
	initField();
	initEvent();
});

function initField(){
	PARAMS.warning ? $('.set-password .warning').html(PARAMS.warning) : $('.set-password .warning').remove();
	PARAMS.loginPage && $('#success .login-page').html(PARAMS.loginPage);
}

function initEvent(){
	$('#get-code').click(function(e){
		e.preventDefault();
		if($(this).data('sending') || $(this).hasClass('ui-btn-dis') || !checkPhone()){
			return;
		}
		getActiveCode($(this));
		countDown();
	});
	
	$('#real-name').blur(function(){
		checkRealName();
	});
	
	$('#phone').blur(function(){
		checkPhone();
	});
	
	//$('#active-code').blur(function(){
//		checkActiveCode();
//	});
	
	$('#password').blur(function(){
		checkPwd();
	});
	
	$('#confirm-password').blur(function(){
		checkConfirmPwd();
	});
	
	$('#set-password-form').submit(function(){
		var btn = $('#btn-wrap button'),
			phone = $.trim($("#phone").val()),
			userName = $.trim($("#user-name").html()),
			realName = $.trim($('#real-name').val());
		$('.set-result').hide().html('');
		if(btn.data('sending') || !checkRealName() || !checkPhone() || !checkPwd() || !checkConfirmPwd()){
			return false;
		}
		btn.html('處理中……');
		btn.data('sending',true);
		$.post('http://service.youshang.com/commonservice/ajaxChecking.do?action=updateBuyerNameForRenew',{
			buyerId: USERID,
			userType: 2,
			buyerMobile: phone,
			buyerName: encodeURIComponent(realName)
		},function(data){
			if(data && data.toLowerCase() == 'ok'){
				$.post('http://service.youshang.com/user/modifyPassword.do',{
					action: 'modifyPassword.do',
					act: 'update',
					writeBack: true,
					newPassword: $('#password').val()
				},function(data){
					btn.html('確定');
					btn.data('sending',false);
					if(data && data.toLowerCase() == 'ok'){
						$('.set-password').hide();
						$('#success .phone').html(phone);
						$('#success .userName').html(userName);
						$('#success').show();
						if(PARAMS.updateUrl){
							var url = PARAMS.updateUrl;
							url += (url.search(/\?/) != -1 ? '&' : '?') + 'phone=' + phone + '&realName=' + encodeURIComponent(realName);
							$('#update-iframe').attr('src',url);
						}
					}else{
						$('.set-result').html('設定密碼失敗，請稍候重試！').show();
					}
				});
			}else{
				btn.html('確定');
				btn.data('sending',false);
				$('.set-result').html('設定獨立密碼失敗，請稍候重試！').show();
			}
		});
		return false;
	});
	$('#cancel').hide();
};
</script>
</body>
</html>