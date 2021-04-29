var intervalTime;

function checkRealName(){
	var realName = $('#real-name'),
		val = $.trim(realName.val());
	if(val.length == 0 || val == realName[0].defaultValue){
		showTip(realName,'真實姓名不能為空',0);
		return false;
	}
	showTip(realName,'');
	return true;
}

function checkPhone(){
	var phone = $('#phone'),
		val = $.trim(phone.val()),
		reg = /^(13|15|17|18)(\d){9}$/;
	if(val.length == 0){
		showTip(phone,'手機號碼不能為空',0);
		return false;
	}
	if(!reg.test(val)){
		showTip(phone,'請填寫正確的手機號碼',0);
		return false;
	}
	showTip(phone,'');
	return true;
}

function checkActiveCode(){
	var activeCode = $('#active-code'),
		val = $.trim(activeCode.val()),
		flag = true;
	if(val.length == 0){
		showTip(activeCode,'驗證碼不能為空',0);
		return false;
	}
	if(val.length < 6){
		showTip(activeCode,'請填寫正確的驗證碼',0);
		return false;
	}
	$.ajax({
		url: 'http://service.youshang.com/commonservice/ajaxChecking.do',
		type: 'GET',
		dataType:"text",
        async:false,
		data: 'action=checkActiveCode&mobile=' + $("#phone").val() + '&activeCode=' + val + '&userId=' + USERID,
		success: function(data){
			if(data.substring(0,2) == "OK"){	            		
				showTip(activeCode,'');
    			flag = true;
            }else{
    			showTip(activeCode,'驗證碼有誤或者已經過期',0);
    			flag = false;
            }
		}
	});
	return flag;
}

function getUrlParams() {
   var param, url = location.search, theRequest = {};
   if (url.indexOf("?") != -1) {
      var str = url.substr(1);
      strs = str.split("&");
      for(var i = 0, len = strs.length; i < len; i ++) {
		 param = strs[i].split("=");
		 param[0] && (theRequest[param[0]]=decodeURIComponent(decodeURIComponent(param[1])));
      }
   }
   return theRequest;
}

function getActiveCode(obj){
	if(typeof obj == 'string') obj = $(obj);
	obj.data('sending',true);
	showTip('#active-code','');
	$.post("http://service.youshang.com/commonservice/ajaxChecking.do",
		{action:"sendSmsActiveCode",
		 mobile:$("#phone").val(),
		 userId: USERID
		},
		function(data){
			obj.data('sending',false);
			if(data.status == "success"){	
				showTip('#active-code','驗證碼已經發送');
				var _obj = $('.timeoutToShowCode');
				_obj.data('code',data.code);
			}else if(data.status == "limited"){
				showTip('#active-code','10分鐘內只能發送3次',0);
			}else if(data.status == "failure"){
				showTip('#active-code','發送異常',0);
			}else if(data.status == "phoneExist"){
				showTip('#active-code','手機號碼已被佔用',0);
			}else{
				showTip('#active-code',data,0);
			}
		},
		"json"
	);
}

function countDown(time){
	clearInterval(intervalTime);
	time = time || 60;
	var btn = $('#get-code');
	btn.addClass('ui-btn-dis').html(time + '秒后可以重發');
	intervalTime = setInterval(function(){
		time--;
		if(time > 0){
			btn.html(time + '秒后可以重發');
		}else{
			clearInterval(intervalTime);
			btn.removeClass('ui-btn-dis').html('免費獲取驗證碼');
			var _obj = $('.timeoutToShowCode');
			var _code = _obj.data('code');
			_obj && _code && showTip(_obj,'目前驗證碼為：'+_code,0);
			
		}
	},1000);
}

function showTip(obj,ctn,type){
	obj = $(obj);
	var tip = obj.siblings('.tip').eq(0);
	if(tip.length == 0){
		tip = $('<p></p>').appendTo(obj.parents('li'));
		tip.addClass('tip');
	}
	if(type == 0){
		tip.html(ctn).addClass("tip-error").removeClass('tip-correct').show();
	}else{
		tip.removeClass("tip-error").addClass('tip-correct');
		ctn == '' ? tip.hide() : tip.html(ctn).show();
	}
}

function checkPwd(){
	var password = $('#password'),
		val = password.val(),
		level = checkPassword.level(val);
	if(level < 5){
		showTip(password,checkPassword.txt[level],0);
		return false;
	}
	showTip(password,'');
	return true;
}

function checkConfirmPwd(){
	var confirmPwd = $('#confirm-password'),
		val = confirmPwd.val(),
		passwordVal = $('#password').val();
	if(val.length == 0){
		showTip(confirmPwd,'確認密碼不能為空',0);
		return false;
	}
	if(val != passwordVal){
		showTip(confirmPwd,'兩次輸入的密碼不一致',0);
		return false;
	}
	showTip(confirmPwd,'');
	return true;
}