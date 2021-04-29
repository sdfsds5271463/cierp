<?php
	$act_val = @$_POST['act_val'];
	if($act_val != ""){ //git 動作請求
		$act_val = substr($act_val, 3); //拿掉開頭的git
		exec('"D:\Program Files\Git\bin\git.exe" '.$act_val.' 2>&1',$out); //exec
		echo implode("\n", $out);
		exit;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>git_command</title>
	<meta charset="utf-8"/>
</head>
<body style="background-color: #333; color: white;">
	<div style="color: #888; font-size: 80%;">僅能輸入 git 開頭的指令，在cierp伺服器根目錄執行對應動作：</div>
	<input type="text" id="git_act" style="background-color: #222; color: #ffbb6b; border: 1px solid black; font-size: 20px; width: calc(100% - 90px);">
	<button id="Enter" style="font-size: 20px; width: 75px; cursor: pointer;">Enter</button>
	<pre id="log">
	</pre>
</body>

<script src="statics\resources\v7\js\jquery.min.js"></script>
<script type="text/javascript">
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