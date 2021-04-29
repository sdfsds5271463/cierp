/**
*密碼檢測
*@param {String, Object} 密碼輸入框的選擇符
*@param {Object} 參數設定
*/
var checkPassword = function(obj,cfg){
	typeof obj == 'string' ? (this.obj = $(obj)) : (this.obj = obj);
	var def_cfg = {
		error_cls : ['tip_error'],
		correct_cls : ['tip_correct'],
		lowest_level : 5,
		tips : ['#password_tip'], //tip元素的選擇符
		strength : '#pwdStrTip', //顯示密碼強度的元素
		if_show : false //是否顯示密碼強度
	};
	cfg = cfg || {};
	this.cfg = $.extend({},def_cfg,cfg);
	this.init();
};

checkPassword.reg = {
	nums : /^\d+$/, //純數字
	letters : /^[a-zA-Z]+$/, //純字母
	space : /[\u0020\uA1A1\u3000]/,  //存在空格符
	chinese : /[\u4E00-\u9FA5]/, //存在中文 
	num : /\d/, //存在數字
	letter : /[a-zA-Z]/, //存在字母
	special : /[^a-zA-Z0-9]/  //存在特殊符
};

checkPassword.txt = ['請輸入密碼',
	'長度8~20位，同時包含數字、字母(區分大小寫)，可使用特殊符號',
	'長度8~20位，同時包含數字、字母(區分大小寫)，可使用特殊符號',
	'密碼不能包含中文',
	'密碼必須同時包含數字、字母(區分大小寫)，可使用特殊符號',
	'',
	''] ;//每個密碼級別的提示語

/**
*阻止空格符輸入（結合keypress使用）
*/
checkPassword.blockSpace = function(_event){
	if(_event.keyCode){
		var char = String.fromCharCode(_event.keyCode);
	}else{
		var char = String.fromCharCode(_event.charCode);
	}
	return !checkPassword.reg.space.test(char);
};

/**
*檢測密碼強度
*@param {String, Number} 密碼
*/
checkPassword.level = function(val){
	//密碼為空時返回0
	//密碼小於8位或大於20位時返回1
	//密碼包含空格符時返回2
	//密碼包含中文時返回3
	//密碼為純數字或純字母時為4
	//密碼為數字+字母時為5
	//密碼為數字、字母、特殊符號組合時為6
	if(val.length == 0) return 0;
	if(val.length < 8 || val.length > 20) return 1;
	if(checkPassword.reg.space.test(val)) return 2;
	if(checkPassword.reg.chinese.test(val)) return 3;
	if(checkPassword.reg.nums.test(val) || checkPassword.reg.letters.test(val)) return 4;
	if(checkPassword.reg.num.test(val) && checkPassword.reg.letter.test(val) && !checkPassword.reg.special.test(val)) return 5;
	if(checkPassword.reg.special.test(val)) return 6;
};


checkPassword.prototype = {
	init : function(){
		var level = checkPassword.level(this.obj.val());
		this.showTip(level);
		this.cfg.if_show && this.setState(level);
		this.isCorrect = level >= this.cfg.lowest_level; //密碼輸入正確與否
	},

	/**
	*檢測結果顯示
	*@param {String, Number} 密碼強度
	*/
	showTip : function(level){
		if(this.cfg.tips.length == 1){
			var error = this.cfg.error_cls[0], correct = this.cfg.correct_cls[0], tip = $(this.cfg.tips[0]);

			if(level >= this.cfg.lowest_level){
				tip.removeClass(error).addClass(correct);
				tip.html(checkPassword.txt[level]);
			}else{
				tip.removeClass(correct).addClass(error);
				tip.html(checkPassword.txt[level]);
			}
		}else if(this.cfg.tips.length == 2){
			var error1 = this.cfg.error_cls[0], correct1 = this.cfg.correct_cls[0], tip1 = $(this.cfg.tips[0]), //tip1顯示提示用語
				  error2 = error1, correct2 = correct1, tip2 = $(this.cfg.tips[1]); //tip2顯示圖示

			this.cfg.error_cls.length == 2 && (error2 = this.cfg.error_cls[1]);
			this.cfg.correct_cls.length == 2 && (correct2 = this.cfg.correct_cls[1]);

			if(level >= this.cfg.lowest_level){
				tip1.removeClass(error1).addClass(correct1);
				tip1.html(checkPassword.txt[level]);
				tip2.removeClass(error2).addClass(correct2);
			}else{
				tip1.removeClass(correct1).addClass(error1);
				tip1.html(checkPassword.txt[level]);
				tip2.removeClass(correct2).addClass(error2);
			}
		}
	},//end of showTip
	
	/**
	*顯示密碼強度
	*@param {String, Number} 密碼強度
	*/
	setState : function(level){
		var pwdStrTip = $(this.cfg.strength), pwdInfo = pwdStrTip.find('.pwdInfo');
		if(level >= this.cfg.lowest_level){
			pwdStrTip.show();
			switch(level){
			case 4:
				this.setStyle("#FF0000","#FFFFFF","#FFFFFF");
				pwdInfo.text("：弱");
				break;
			case 5:
				this.setStyle("#FFD35E","#FFD35E","#FFFFFF");
				pwdInfo.text("：一般");
				break;
			case 6:
				this.setStyle("#95EB81","#95EB81","#95EB81");
				pwdInfo.text("：強");
				break;
			default:
				this.setStyle("#FFFFFF","#FFFFFF","#FFFFFF");
				pwdInfo.text("");
			}
		}else{
			pwdStrTip.hide();
			this.setStyle("#FFFFFF","#FFFFFF","#FFFFFF");
			pwdInfo.text("");
		}
	},
	
	/**
	*設定密碼強度條的顏色
	*@param {RGB}
	*@param {RGB}
	*@param {RGB}
	*/
	setStyle : function(st1,st2,st3){
		var s1 = $(this.cfg.strength).find('.s1'),
			s2 = $(this.cfg.strength).find('.s2'),
			s3 = $(this.cfg.strength).find('.s3');
		s1.css('background-color',st1);
		s2.css('background-color',st2);
		s3.css('background-color',st3);
	}
}