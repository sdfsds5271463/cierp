<?php
	session_start();

	//權限檢查
	$access_chk = @$_POST['access_chk'];
	if($access_chk != ""){ //權限檢查動作
		if(@$_SESSION['git_access_chk'] != "ok"){
			echo "no_access";
		}else{
			echo "ok";
		}
		exit;
	}

	//取得權限
	$access_get = @$_POST['access_get'];
	if($access_get != ""){ //git 動作請求
		if($access_get == "123qwe"){ //正確許可碼
			echo "ok";
			$_SESSION['git_access_chk'] = "ok";
		}else{
			echo "no_access";
			$_SESSION['git_access_chk'] = "no_access";
		}
		exit;
	}

	//執行GIT動作
	$act_val = @$_POST['act_val'];
	if($act_val != ""){ //git 動作請求
		if(@$_SESSION['git_access_chk'] == "ok"){ //具有權限
			$act_val = substr($act_val, 3); //拿掉開頭的git
			exec('"D:\Program Files\Git\bin\git.exe" '.$act_val.' 2>&1',$out); //exec
			echo implode("\n", $out);
		}
		exit;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>git_command</title>
	<meta charset="utf-8"/>
	<meta name="referrer" content="origin">
</head>
<body style="background-color: #333; color: white;">
	<div id="access_ok_msg" style="color: #888; font-size: 80%; display: none;">僅能輸入 git 開頭的指令，在cierp伺服器根目錄執行對應動作：</div>
	<div id="access_no_msg" style="color: red; font-size: 80%; display: none;">尚未獲得 git 指令權限，請先輸入許可碼獲得伺服器許可：</div>
	<input type="text" id="git_act" style="background-color: #222; color: #ffbb6b; border: 1px solid black; font-size: 20px; width: calc(100% - 90px);">
	<button id="Enter" style="font-size: 20px; width: 75px; cursor: pointer;">Enter</button>
	<pre id="log">
	</pre>
</body>

<script src="statics\resources\v7\js\jquery.min.js"></script>
<script type="text/javascript">
	//權限檢查
	var access_ok = false;
	access_chk();
	function access_chk(){
	    $.post('git_command.php','access_chk=access_chk',function(data){
	    	if(data == "ok"){ //有權限
	    		access_ok = true;
	    		$("#access_ok_msg").css("display", "");
	    		$("#access_no_msg").css("display", "none");
	    	}else{ //無權限
	    		access_ok = false;
	    		$("#access_ok_msg").css("display", "none");
	    		$("#access_no_msg").css("display", "");
	    	}
	    });
	}

	//初始化
	$("#git_act").focus();
	var log_var = "";
	var post_lock = false;

	//送出Enter
	$("#Enter").click(function(){
		postEnter();
	});
	window.onkeydown = function(e){
		if(e.key == 'Enter'){//按下鍵盤Enter
			postEnter();
		}
	};
	function postEnter(){ //實際執行
		if(post_lock){ //鎖定中
			return true;
		}

		var act_val = $("#git_act").val().trim(); //動作值

		$("#git_act").val(""); //清除欄位
		$("#git_act").focus();

		if(access_ok == false){ //尚無 git 權限
		    $.post('git_command.php','access_get=' + act_val,function(data){
		    	if(data == "ok"){ //有權限
		    		log_var = "<b style='color:green;'>取得git權限成功</b>\n" + log_var;
		    		access_ok = true;
		    		access_chk();
		    	}else{ //無權限
		    		log_var = "<b style='color:red;'>取得git權限失敗</b>\n" + log_var;
		    	}
		    	$("#log")[0].innerHTML = log_var;
		    });

		}else{ //已有權限
			if(act_val == ""){ //空行
				log_var = "\n" + log_var;
				$("#log")[0].innerHTML = log_var;
			}else if(act_val.substring(0, 4) != "git "){ //開頭不是git
				log_var = "<b style='color:#ffbb6b;'>" + act_val + "</b>\n系統只能處理 git 開頭的指令。\n\n" + log_var; //log
				$("#log")[0].innerHTML = log_var;
			}else{
				$("#log")[0].innerHTML = "<b style='color:#ffbb6b;'>" + act_val + "</b>\n<img src='statics/js/common/plugins/fileupload/img/loading.gif' style='width: 30px;'>\n" + log_var;
				post_lock = true;
				$.ajax({
					type: "post",
					url: 'git_command.php',
					data: "act_val=" + act_val,
					success: function(data) { 
						log_var = "<b style='color:#ffbb6b;'>" + act_val + "</b>\n"+htmlspecialchars(data)+"\n\n" + log_var; //log
						$("#log")[0].innerHTML = log_var;
						post_lock = false;
					},
					error: function(){
						log_var = "<b style='color:#ffbb6b;'>" + act_val + "</b>\n不知名的錯誤，指令沒有成功。\n\n" + log_var; //log
						$("#log")[0].innerHTML = log_var;
						post_lock = false;
					}
				});
			}
		}

	}

	function htmlspecialchars(ch) {
		if (ch===null) return '';
		ch = ch.replace(/&/g,"&amp;");
		ch = ch.replace(/\"/g,"&quot;");
		ch = ch.replace(/\'/g,"&#039;");
		ch = ch.replace(/</g,"&lt;");
		ch = ch.replace(/>/g,"&gt;");
		return ch;
	}

</script>

</html>