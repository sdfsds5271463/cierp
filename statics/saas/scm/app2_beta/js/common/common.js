var Public = Public || {};
var Business = Business || {};
Public.isIE6 = !window.XMLHttpRequest;	//ie6

$(function(){
	//菜單按鈕
	$('.ui-btn-menu .menu-btn').on('mouseenter.menuEvent',function(e){
		if($(this).hasClass("ui-btn-dis")) {
			return false;
		}
		$(this).parent().addClass('ui-btn-menu-cur');
		$(this).blur();
		e.preventDefault();
	});
	$(document).on('click.menu',function(e){
		var target  = e.target || e.srcElement;
		$('.ui-btn-menu').each(function(){
			var menu = $(this);
			if($(target).closest(menu).length == 0 && $('.con',menu).is(':visible')){
				 menu.removeClass('ui-btn-menu-cur');
			}
		})
	});
});

//設定表格寬高
Public.setGrid = function(adjustH, adjustW){
	var defaultPage = Public.getDefaultPage();
	if(defaultPage.SYSTEM.skin === 'green'){
		var adjustH = adjustH || 70;
	} else {
		var adjustH = adjustH || 65;
	};
	var adjustW = adjustW || 20;
	var gridW = $(window).width() - adjustW, gridH = $(window).height() - $(".grid-wrap").offset().top - adjustH;
	return {
		w : gridW,
		h : gridH
	}
};
//重設表格寬高
Public.resizeGrid = function(adjustH, adjustW){
	var grid = $("#grid");
	var gridWH = Public.setGrid(adjustH, adjustW);
	grid.jqGrid('setGridHeight', gridWH.h);
	grid.jqGrid('setGridWidth', gridWH.w);
};
//表格寬度自適應
Public.autoGrid = function($grid){
	$grid.jqGrid('setGridWidth', $grid.closest('.grid-wrap').innerWidth() -2 );//去掉border的寬度
}
//自定義報表寬高初始化以及自適應
Public.initCustomGrid = function(tableObj){
	//去除報表原始定義的寬度
	$(tableObj).css("width") && $(tableObj).attr("width","auto");
	//獲取報表寬度當做最小寬度
	var _minWidth = $(tableObj).outerWidth();
	$(tableObj).css("min-width",_minWidth+"px");
	//獲取目前window對象的寬度作為報表原始的寬度
	$(tableObj).width($(window).width() - 74);
	$(tableObj).closest('.mod-report').height($(window).height() - 66);
	//設定resize事件
	var _throttle = function(method,context){
		clearTimeout(method.tid);
		method.tid = setTimeout(function(){
			method.call(context);
		},100)
	};
	var _resize = function(){
		$(tableObj).width($(window).width() - 74);
		$(tableObj).closest('.mod-report').height($(window).height() - 66);
	};
	$(window).resize(function() {
		_throttle(_resize);
	});
}
/**
 * 節點賦100%高度
 *
 * @param {object} obj 賦高的對象
*/
Public.setAutoHeight = function(obj){
if(!obj || obj.length < 1){
	return ;
}

Public._setAutoHeight(obj);
$(window).bind('resize', function(){
	Public._setAutoHeight(obj);
});

}

Public._setAutoHeight = function(obj){
obj = $(obj);
//parent = parent || window;
var winH = $(window).height();
var h = winH - obj.offset().top - (obj.outerHeight() - obj.height());
obj.height(h);
}
//操作項格式化，適用於有「修改、刪除」操作的表格
Public.operFmatter = function (val, opt, row) {
	var html_con = '<div class="operating" data-id="' + row.id + '"><span class="ui-icon ui-icon-pencil" title="修改"></span><span class="ui-icon ui-icon-trash" title="刪除"></span></div>';
	return html_con;
};

Public.billsOper = function (val, opt, row) {
	var html_con = '<div class="operating" data-id="' + opt.rowId + '"><span class="ui-icon ui-icon-plus" title="新增行"></span><span class="ui-icon ui-icon-trash" title="刪除行"></span></div>';
	return html_con;
};
Public.billsOper_goods = function (val, opt, row) {
	var html_con = '<div class="operating" data-id="' + opt.rowId + '"><span class="ui-icon ui-icon-plus" title="新增行"></span><span class="ui-icon ui-icon-trash" title="刪除行"></span><span class="ui-icon ui-icon-cart" title="商品庫存查詢"></span></div>';
	return html_con;
};
Public.dateCheck = function(){
	$('.ui-datepicker-input').bind('focus', function(e){
		$(this).data('original', $(this).val());
	}).bind('blur', function(e){
		var reg = /((^((1[8-9]\d{2})|([2-9]\d{3}))(-)(10|12|0?[13578])(-)(3[01]|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(11|0?[469])(-)(30|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(0?2)(-)(2[0-8]|1[0-9]|0?[1-9])$)|(^([2468][048]00)(-)(0?2)(-)(29)$)|(^([3579][26]00)(-)(0?2)(-)(29)$)|(^([1][89][0][48])(-)(0?2)(-)(29)$)|(^([2-9][0-9][0][48])(-)(0?2)(-)(29)$)|(^([1][89][2468][048])(-)(0?2)(-)(29)$)|(^([2-9][0-9][2468][048])(-)(0?2)(-)(29)$)|(^([1][89][13579][26])(-)(0?2)(-)(29)$)|(^([2-9][0-9][13579][26])(-)(0?2)(-)(29)$))/;
		var _self = $(this);
		setTimeout(function(){
			if(!reg.test(_self.val())) {
				parent.Public.tips({type:1, content : '日期格式有誤！如：2013-08-08。'});
				_self.val(_self.data('original'));
			};
		}, 10)

	});
}
//日期格式化
Date.prototype.format = function(format){ 
	if(!format){
		format = 'yyyy-MM-dd';//預設1997-01-01這樣的格式
	}
	var o = { 
		"M+" : this.getMonth()+1, //month 
		"d+" : this.getDate(), //day 
		"h+" : this.getHours(), //hour 
		"m+" : this.getMinutes(), //minute 
		"s+" : this.getSeconds(), //second 
		"q+" : Math.floor((this.getMonth()+3)/3), //quarter 
		"S" : this.getMilliseconds() //millisecond 
	} 

	if(/(y+)/.test(format)) { 
		format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length)); 
	} 

	for(var k in o) { 
		if(new RegExp("("+ k +")").test(format)) { 
			format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length)); 
		} 
	} 
	return format; 
} 
Date.prototype.addMonths= function(m)
{
    var d = this.getDate();
    this.setMonth(this.getMonth() + m);
    if (this.getDate() < d)
        this.setDate(0);
};
Date.prototype.addDays = function(d)
{
    this.setDate(this.getDate() + d);
};
Public.getHostName = function(){
	var defaultPage = Public.getDefaultPage();
	var result = defaultPage.location.hostname;
	if(!/.com/.test(result)){
		//是IP形式的，相容內網
		result += ':'+defaultPage.location.port;
	}
	return result
};
//根據之前的編碼產生下一個編碼
Public.getSuggestNum = function(prevNum){
	if (prevNum == '' || !prevNum) {
		return '';
	}
	var reg = /^([a-zA-Z0-9\-_]*[a-zA-Z\-_]+)?(\d+)$/;
	var match = prevNum.match(reg);
	if (match) {
		var prefix = match[1] || '';
		var prevNum = match[2];
		var num = parseInt(prevNum, 10) + 1;
		var delta = prevNum.toString().length - num.toString().length;
		if (delta > 0) {
			for (var i = 0; i < delta; i++) {
				num = '0' + num;
			}
		}
		return prefix + num;
	} else {
		return '';
	}
};

Public.bindEnterSkip = function(obj, func){
	var args = arguments;
	$(obj).on('keydown', 'input:visible:not(:disabled)', function(e){
		if (e.keyCode == '13') {
			var inputs = $(obj).find('input:visible:not(:disabled)');
			var idx = inputs.index($(this));
			idx = idx + 1;
			if (idx >= inputs.length) {
				if (typeof func == 'function') {
					var _args = Array.prototype.slice.call(args, 2 );
					func.apply(null,_args);
				}
			} else {
				inputs.eq(idx).focus();
			}
		}
	});
};

/*獲取URL參數值*/
Public.getRequest = Public.urlParam = function() {
   var param, url = location.search, theRequest = {};
   if (url.indexOf("?") != -1) {
      var str = url.substr(1);
      strs = str.split("&");
      for(var i = 0, len = strs.length; i < len; i ++) {
		 param = strs[i].split("=");
         theRequest[param[0]]=decodeURIComponent(param[1]);
      }
   }
   return theRequest;
};
/**
 * [ajax description]
 * @param  {[type]} ajaxOpts [description]
 * 預設json格式
 * 預設post方式
 * @return {[type]}          [description]
 */
Public.ajax = function(ajaxOpts){    
	var opts = {
	   type: "POST",
	   dataType: "json",  
	   error: function(err){  
			parent.Public.tips({type: 1, content : '服務端響應錯誤！'});
	   }
	};
	$.extend(true, opts, ajaxOpts);
	var success = ajaxOpts.success;
	opts.success = function(data, status){
		/*if(data.status != 200){
		   		var defaultPage = Public.getDefaultPage();
		   		var msg = data.msg || '出錯了=. =||| ,請點選這裡拷貝錯誤資訊 :)';
				var errorStr = msg;
				if(data.data.error){
		   			var errorStr = '<a id="myText" href="javascript:window.clipboardData.setData("Text",data.error);alert("詳細資訊已經複製到剪下板，請拷貝給管理員！");"'+msg+'</a>'
				}
		   		defaultPage.Public.tips({type:1, content:errorStr});
		   		return;
		   	}*/
			success && success(data, status); 
	}
	$.ajax(opts);  
};  
/*
  通用post請求，返回json
  url:請求地址， params：傳遞的參數{...}， callback：請求成功回撥

*/ 
Public.ajaxPost = function(url, params, callback, errCallback){    
	$.ajax({  
	   type: "POST",
	   url: url,
	   data: params, 
	   dataType: "json",  
	   success: function(data, status){ 
		   	/*if(data.status != 200){
		   		var defaultPage = Public.getDefaultPage();
		   		var msg = data.msg || '出錯了=. =||| ,請點選這裡拷貝錯誤資訊 :)';
				var errorStr = msg;
				if(data.data.error){
		   			var errorStr = '<a id="myText" href="javascript:window.clipboardData.setData("Text",data.error);alert("詳細資訊已經複製到剪下板，請拷貝給管理員！");"'+msg+'</a>'
				}
		   		defaultPage.Public.tips({type:1, content:errorStr});
		   		return;
		   	}*/
			callback(data);  
	   },  
	   error: function(err,ms){  
			parent.Public.tips({type: 1, content : '服務端響應錯誤！'});
			errCallback && errCallback(err);
	   }  
	});  
};  
//擴充套件對像方法
$.fn.extend({
	//為對像新增ajaxPost方法
	ajaxPost:function(url, params, callback, errCallback){
		var $this = $(this);
		var loading;
		var myTimer;
		var preventTooFast = 'ui-btn-dis';
		var ajaxOpts = {  
		   type: "POST",
		   url: url,
		   data: params, 
		   dataType: "json",  
		   success: function(data, status){  
			   callback(data);  
		   },  
		   error: function(err){  
				parent.Public.tips({type: 1, content : '服務端響應錯誤！'});
				errCallback && errCallback(err);
		   }  
		}
		$.extend(true, ajaxOpts, {
			timeout : 20000,
			beforeSend : function(){
				$this.addClass(preventTooFast);
				myTimer = setTimeout(function(){
					$this.removeClass(preventTooFast);
				},2000)
				loading = $.dialog.tips('提交中，請稍候...', 1000, 'loading.gif', true);
			},
			success : function(data){
				/*if(data.status != 200){
			   		var defaultPage = Public.getDefaultPage();
			   		var msg = data.msg || '出錯了=. =||| ,請點選這裡拷貝錯誤資訊 :)';
					var errorStr = msg;
					if(data.data.error){
			   			var errorStr = '<a id="myText" href="javascript:window.clipboardData.setData("Text",data.error);alert("詳細資訊已經複製到剪下板，請拷貝給管理員！");"'+msg+'</a>'
					}
			   		defaultPage.Public.tips({type:1, content:errorStr});
			   		return;
			   	}*/
				callback(data);  
			},
			complete : function(){
				loading.close();
			},
			error: function(err){  
				parent.Public.tips({type: 1, content : '操作無法成功，請稍後重試！'});
				try{
					console.log(err)
				}catch(e){

				}
				errCallback && errCallback(err);
		   	}
		});
		if($this.hasClass(preventTooFast)){
			return;
		}
		$.ajax(ajaxOpts); 
	}
});
Public.ajaxGet = function(url, params, callback, errCallback){    
	$.ajax({  
	   type: "GET",
	   url: url,
	   dataType: "json",  
	   data: params,
	   success: function(data, status){  
		   /*if(data.status != 200){
		   		var defaultPage = Public.getDefaultPage();
		   		var msg = data.msg || '出錯了=. =||| ,請點選這裡拷貝錯誤資訊 :)';
				var errorStr = msg;
				if(data.data.error){
		   			var errorStr = '<a id="myText" href="javascript:window.clipboardData.setData("Text",data.error);alert("詳細資訊已經複製到剪下板，請拷貝給管理員！");"'+msg+'</a>'
				}
		   		defaultPage.Public.tips({type:1, content:errorStr});
		   		return;
		   	}*/
			callback(data);   
	   },   
	   error: function(err){  
			parent.Public.tips({type: 1, content : '服務端響應錯誤！'});
			errCallback && errCallback(err);
	   }  
	});  
};
/*操作提示*/
Public.tips = function(options){ return new Public.Tips(options); }
Public.Tips = function(options){
	var defaults = {
		renderTo: 'body',
		type : 0,
		autoClose : true,
		removeOthers : true,
		time : undefined,
		top : 10,
		onClose : null,
		onShow : null
	}
	this.options = $.extend({},defaults,options);
	this._init();
	
	!Public.Tips._collection ?  Public.Tips._collection = [this] : Public.Tips._collection.push(this);
	
}

Public.Tips.removeAll = function(){
	try {
		for(var i=Public.Tips._collection.length-1; i>=0; i--){
			Public.Tips._collection[i].remove();
		}
	}catch(e){}
}

Public.Tips.prototype = {
	_init : function(){
		var self = this,opts = this.options,time;
		if(opts.removeOthers){
			Public.Tips.removeAll();
		}

		this._create();

		if(opts.autoClose){
			time = opts.time || opts.type == 1 ? 5000 : 3000;
			window.setTimeout(function(){
				self.remove();
			},time);
		}

	},
	
	_create : function(){
		var opts = this.options, self = this;
		if(opts.autoClose) {
			this.obj = $('<div class="ui-tips"><i></i></div>').append(opts.content);
		} else {
			this.obj = $('<div class="ui-tips"><i></i><span class="close"></span></div>').append(opts.content);
			this.closeBtn = this.obj.find('.close');
			this.closeBtn.bind('click',function(){
				self.remove();
			});
		};
		
		switch(opts.type){
			case 0 : 
				this.obj.addClass('ui-tips-success');
				break ;
			case 1 : 
				this.obj.addClass('ui-tips-error');
				break ;
			case 2 : 
				this.obj.addClass('ui-tips-warning');
				break ;
			default :
				this.obj.addClass('ui-tips-success');
				break ;
		}
		
		this.obj.appendTo('body').hide();
		this._setPos();
		if(opts.onShow){
				opts.onShow();
		}

	},

	_setPos : function(){
		var self = this, opts = this.options;
		if(opts.width){
			this.obj.css('width',opts.width);
		}
		var h =  this.obj.outerHeight(),winH = $(window).height(),scrollTop = $(window).scrollTop();
		//var top = parseInt(opts.top) ? (parseInt(opts.top) + scrollTop) : (winH > h ? scrollTop+(winH - h)/2 : scrollTop);
		var top = parseInt(opts.top) + scrollTop;
		this.obj.css({
			position : Public.isIE6 ? 'absolute' : 'fixed',
			left : '50%',
			top : top,
			zIndex : '9999',
			marginLeft : -self.obj.outerWidth()/2	
		});

		window.setTimeout(function(){
			self.obj.show().css({
				marginLeft : -self.obj.outerWidth()/2
			});
		},150);

		if(Public.isIE6){
			$(window).bind('resize scroll',function(){
				var top = $(window).scrollTop() + parseInt(opts.top);
				self.obj.css('top',top);
			})
		}
	},

	remove : function(){
		var opts = this.options;
		this.obj.fadeOut(200,function(){
			$(this).remove();
			if(opts.onClose){
				opts.onClose();
			}
		});
	}
};
//數值顯示格式轉化
Public.numToCurrency = function(val, dec) {
	val = parseFloat(val);	
	dec = dec || 2;	//小數位
	if(val === 0 || isNaN(val)){
		return '';
	}
	val = val.toFixed(dec).split('.');
	var reg = /(\d{1,3})(?=(\d{3})+(?:$|\D))/g;
	return val[0].replace(reg, "$1,") + '.' + val[1];
};
//數值顯示
Public.currencyToNum = function(val){
	var val = String(val);
	if ($.trim(val) == '') {
		return '';
	}
	val = val.replace(/,/g, '');
	val = parseFloat(val);
	return isNaN(val) ? 0 : val;
};
//只允許輸入數字
Public.numerical = function(e){
	var allowed = '0123456789.-', allowedReg;
	allowed = allowed.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&');
	allowedReg = new RegExp('[' + allowed + ']');
	var charCode = typeof e.charCode != 'undefined' ? e.charCode : e.keyCode; 
	var keyChar = String.fromCharCode(charCode);
	if(!e.ctrlKey && charCode != 0 && ! allowedReg.test(keyChar)){
		e.preventDefault();
	};
};

//限制只能輸入允許的字元，不支援中文的控制
Public.limitInput = function(obj, allowedReg){
    var ctrlKey = null;
    obj.css('ime-mode', 'disabled').on('keydown',function(e){
        ctrlKey = e.ctrlKey;
    }).on('keypress',function(e){
        allowedReg = typeof allowedReg == 'string' ? new RegExp(allowedReg) : allowedReg;
        var charCode = typeof e.charCode != 'undefined' ? e.charCode : e.keyCode; 
        var keyChar = $.trim(String.fromCharCode(charCode));
        if(!ctrlKey && charCode != 0 && charCode != 13 && !allowedReg.test(keyChar)){
            e.preventDefault();
        } 
    });
};
//限制輸入的字元長度
Public.limitLength = function(obj, count){
	obj.on('keyup',function(e){
        if(count < obj.val().length){
        	e.preventDefault();
        	obj.val(obj.val().substr(0,count));
        }
    });
};
/*批量繫結頁簽打開*/
Public.pageTab = function() {
	$(document).on('click', '[rel=pageTab]', function(e){
		e.preventDefault();
		var right = $(this).data('right');
		if (right && !Business.verifyRight(right)) {
			return false;
		};
		var tabid = $(this).attr('tabid'), url = $(this).attr('href'), showClose = $(this).attr('showClose'), text = $(this).attr('tabTxt') || $(this).text(),parentOpen = $(this).attr('parentOpen');
		if(parentOpen){
			parent.tab.addTabItem({tabid: tabid, text: text, url: url, showClose: showClose});
		} else {
			tab.addTabItem({tabid: tabid, text: text, url: url, showClose: showClose});
		}
	});
};

$.fn.artTab = function(options) {
  var defaults = {};
  var opts = $.extend({}, defaults, options);
  var callback = opts.callback || function () {};
  this.each(function(){
	  var $tab_a =$("dt>a",this);
	  var $this = $(this);
	  $tab_a.bind("click", function(){
		  var target = $(this);
		  target.siblings().removeClass("cur").end().addClass("cur");
		  var index = $tab_a.index(this);
		  var showContent = $("dd>div", $this).eq(index);
		  showContent.siblings().hide().end().show();
		  callback(target, showContent, opts);
	  });
	  if(opts.tab)
		  $tab_a.eq(opts.tab).trigger("click");
	  if(location.hash) {
		  var tabs = location.hash.substr(1);
		  $tab_a.eq(tabs).trigger("click");
	  }
  });	  
};

//文字列表滾動
Public.txtSlide = function(opt){
	var def = {
		notice: '#notices > ul',
		size: 1, //顯示出來的條數
		pause_time: 3000, //每次滾動后停留的時間
		speed: 'fast', //滾動動畫執行的時間
		stop: true //滑鼠移到列表時停止動畫
	};
	opt = opt || {};
	opt = $.extend({}, def, opt);

	var $list = $(opt.notice),
		$lis = $list.children(),
		height = $lis.eq(0).outerHeight() * opt.size,
		interval_id;
	if($lis.length <= opt.size) return;
	interval_id = setInterval(begin, opt.pause_time);

	opt.stop && $list.on({
		'mouseover': function(){
			clearInterval(interval_id);
			$list.stop(true,true);
		},
		'mouseleave': function(){
			interval_id = setInterval(begin, opt.pause_time);
		}
	});

	function begin(){
		$list.stop(true, true).animate({marginTop: -height}, opt.speed, function(){
			for(var i=0; i<opt.size; i++){
				$list.append($list.find('li:first'));
			}
			$list.css('margin-top', 0);
		});
	}
};

$.fn.enterKey = function() {
	this.each(function() {
		$(this).keydown(function(e) {
			if (e.which == 13) {
				var ref = $(this).data("ref");
				if (ref) {
					$('#' + ref).select().focus().click();
				}
				else {
					eval($(this).data("enterKeyHandler"));
				}
			}
		});
	});
};


//input佔位符
$.fn.placeholder = function(){
	this.each(function() {
		$(this).focus(function(){
			if($.trim(this.value) == this.defaultValue){
				this.value = '';
			}
			$(this).removeClass('ui-input-ph');
		}).blur(function(){
			var val = $.trim(this.value);
			if(val == '' || val == this.defaultValue){
				$(this).addClass('ui-input-ph');
			}
			val == '' && $(this).val(this.defaultValue);
		});
	});
};

//單選框外掛
$.fn.cssRadio = function(opts){
	var opts = $.extend({}, opts);
	var $_radio = $('label.radio', this), $_this = this;
	$_radio.each(function() {
		var self = $(this);
		if (self.find("input")[0].checked) {
			self.addClass("checked");
		};

	}).hover(function() {
		$(this).addClass("over");
	}, function() {
		$(this).removeClass("over");
	}).click(function(event) {
		$_radio.find("input").removeAttr("checked");
		$_radio.removeClass("checked");
		$(this).find("input").attr("checked", "checked");
		$(this).addClass("checked");
		opts.callback($(this));
	});
	return {
		getValue: function() {
			return $_radio.find("input[checked]").val();
		},
		setValue: function(index) {
			return $_radio.eq(index).click();
		}
	}
};
//覈取方塊外掛
$.fn.cssCheckbox = function() {
	var $_chk = $(".chk", this);
	$_chk.each(function() {
		if ($(this).find("input")[0].checked) {
			$(this).addClass("checked");
		};
		if ($(this).find("input")[0].disabled) {
			$(this).addClass("dis_check");
		};
	}).hover(function() {
		$(this).addClass("over")
	}, function() {
		$(this).removeClass("over")
	}).click(function(event) {
		if ($(this).find("input")[0].disabled) {
			return;
		};
		$(this).toggleClass("checked");
		$(this).find("input")[0].checked = !$(this).find("input")[0].checked;
		event.preventDefault();
	});
	
	return {
		chkAll:function(){
			$_chk.addClass("checked");
			$_chk.find("input").attr("checked","checked");
		},	
		chkNot:function(){
			$_chk.removeClass("checked");
			$_chk.find("input").removeAttr("checked");
		},
		chkVal:function(){
			var val = [];
			$_chk.find("input:checked").each(function() {
            	val.push($(this).val());
        	});
			return val;
		}
	}
};

Public.getDefaultPage = function(){
	var win = window.self;
	var i = 20;//最多20層，防止無限巢狀
	try{
		do{
			if (/default.jsp/.test(win.location.href)) {
				return win;
			}
			win = win.parent;
			i--;
		} while(i>0);
	}catch(e){
		return win;
	}
	return win;
};

//許可權驗證
Business.verifyRight = function(right){
	var system = Public.getDefaultPage().SYSTEM;
	var isAdmin = system.isAdmin;
	var siExperied = system.siExpired;
	var rights = system.rights;
	if (isAdmin && !siExperied) {
		//return true;
	};
    //alert(right);
	if(siExperied) {
		if(rights[right]) {
			return true;
		} else {
			var html = [
				'<div class="ui-dialog-tips">',
				'<p>謝謝您使用本產品，您的當前服務已經到期，到期3個月后數據將被自動清除，如需繼續使用請購買/續費！</p>',
				'<p style="color:#AAA; font-size:12px;">(續費後請重新整理頁面或重新登錄。)</p>',
				'</div>'
			].join('');
			$.dialog({
				width: 280,
				title: '系統提示',
				icon: 'alert.gif',
				fixed: true,
				lock: true,
				resize: false,
				ok: true,
				content: html
			});
			return false;
		}
	} else {
		if (rights[right]) {
			return true;
		} else {
			var html = [
				'<div class="ui-dialog-tips">',
				'<h4 class="tit">您沒有該功能的使用許可權哦！</h4>',
				'<p>請聯繫管理員為您授權！</p>',
				'</div>'
			].join('');
			$.dialog({
				width: 240,
				title: '系統提示',
				icon: 'alert.gif',
				fixed: true,
				lock: true,
				resize: false,
				ok: true,
				content: html
			});
			return false;
		}
	};
};

//獲取檔案
Business.getFile = function(url, args, isNewWinOpen){
	if (typeof url != 'string') {
		return ;
	}
	var url = url.indexOf('?') == -1 ? url += '?' : url;
	if(args.id) {
		url += '&id=' + args.id + '&random=' + new Date().getTime();
	} else {
		url += '&random=' + new Date().getTime();
	};
	
	var downloadForm = parent.$('form#downloadForm');
	if (downloadForm.length == 0) {
		downloadForm = parent.$('<form method="post" />').attr('id', 'downloadForm').hide().appendTo('body');
	} else {
		downloadForm.empty();
	}
	downloadForm.attr('action', url);
	for( k in args){
		$('<input type="hidden" />').attr({name: k, value: args[k]}).appendTo(downloadForm);
	}
	if (isNewWinOpen) {
		downloadForm.attr('target', '_blank');
	} else{
		var downloadIframe = $('iframe#downloadIframe');
		if (downloadIframe.length == 0) {
			downloadIframe = $('<iframe />').attr('id', 'downloadIframe').hide().appendTo('body');
		}
		downloadForm.attr('target', 'downloadIframe');
	}
	downloadForm.trigger('submit');
};
Business.billCustomerCombo = function($_obj, opts){
	var defaultPage = Public.getDefaultPage();
	opts = $.extend(true, {
		data: function(){
			if(defaultPage.SYSTEM.customerInfo) {
				var usingData = []//獲取啟用狀態的;
				for (var i = 0; i < defaultPage.SYSTEM.customerInfo.length; i++) {
					var g = defaultPage.SYSTEM.customerInfo[i];
					if(!g['delete']){
						usingData.push(g);
					}
				};
				return usingData;
			} else {
				return '../basedata/contact?action=list$simple=1';
			}
		}
	}, opts);
	return Business.customerCombo($_obj, opts);
}
Business.customerCombo = function($_obj, opts){
	if ($_obj.length == 0) { return };
	var defaultPage = Public.getDefaultPage();
	var opts = $.extend(true, {
		data: function(){
			return defaultPage.SYSTEM.customerInfo;
		},
		ajaxOptions: {
			formatData: function(data){
				defaultPage.SYSTEM.customerInfo = data.data.rows;	//更新
				return data.data.rows;
			}	
		},
		width: 200,
		height: 300,
		formatText: function(row){
			return row.number + ' ' + row.name;
		},
		//formatResult: 'name',
		text: 'name',
		value: 'id',
		defaultSelected: 0,
		editable: true,
		extraListHtml: '<a href="javascript:void(0);" id="quickAddCustomer" class="quick-add-link"><i class="ui-icon-add"></i>新增客戶</a>',
		maxListWidth: 500,
		cache: false,
		forceSelection: false,
		maxFilter: 100,
		trigger: false,	
		callback: {
			onChange: function(data){
				if(data) {
					$_obj.data('contactInfo', data);
					this.input.trigger('nextAction');
				} else {
					$_obj.removeData('contactInfo');
					$_obj.removeData('priceList');
				}
			},
			onEnter:function(e){
				//e.stopPropagation();
				var skey = $_obj.find('input').val();
				if(!$_obj.data('contactInfo')){
					$_obj.find('.ui-icon-ellipsis').data('skey',skey).data('type','customerInfo').trigger('click');
				}
			}
		}
	}, opts);
	
	var customerCombo = $_obj.combo(opts).getCombo();	
	//新增客戶
	$('#quickAddCustomer').on('click', function(e){
		e.preventDefault();
		if (!Business.verifyRight('BU_ADD')) {
			return ;
		};
		$.dialog({
			title : '新增客戶',
			content : 'url:../settings/customer_manage',
			data: {oper: 'add', callback: function(data, oper, dialogWin){
				//parent.getCustomer();
				//_self.customerCombo.selectByValue(data.id, false);
				//customerCombo.loadData('/basedata/contact.do?action=list', ['id', data.id]);
				if(data && data.id) {
					$_obj.data('contactInfo', data);	//儲存
					$_obj.find('input').val(data.number + ' ' + data.name);	//回填數據
					defaultPage.SYSTEM.customerInfo.push(data);	//增加進快取
					customerCombo.collapse();	//關閉下拉
				}
				dialogWin && dialogWin.api.close();
			}},
			width : 640,
			height : 460,
			max : false,
			min : false,
			cache : false,
			lock: true
		});
	});
	
	customerCombo.input.focus(function() {
		var $_this = $(this);
		setTimeout(function(){
			$_this.select();
		}, 15);
	});
	
	return customerCombo;
};
Business.billSalesCombo = function($_obj, opts){
	var defaultPage = Public.getDefaultPage();
	opts = $.extend(true, {
		data: function(){
			if(defaultPage.SYSTEM.salesInfo) {
				var usingData = []//獲取啟用狀態的;
				for (var i = 0; i < defaultPage.SYSTEM.salesInfo.length; i++) {
					var g = defaultPage.SYSTEM.salesInfo[i];
					if(!g['delete']){
						usingData.push(g);
					}
				};
				return usingData;
			} else {
				return '../basedata/employee?action=list';
			}
		}
	}, opts);
	return Business.salesCombo($_obj, opts);
}
Business.salesCombo = function($_obj, opts){
	if ($_obj.length == 0) { return };
	var defaultPage = Public.getDefaultPage();
	var opts = $.extend(true, {
		data: function(){
			if(defaultPage.SYSTEM.salesInfo) {
				return defaultPage.SYSTEM.salesInfo;
			} else {
				return '../basedata/employee?action=list';
			}
		},
		ajaxOptions: {
			formatData: function(data){
				defaultPage.SYSTEM.salesInfo = data.data.items;	//更新
				return data.data.items;
			}	
		},
		width: 120,
		height: 300,
		text: 'name',
		value: 'id',
		defaultSelected: 0,
		defaultFlag: false,
		cache: false,
		editable: true,
		emptyOptions: true,
		callback: {
			onChange: function(data){
			}
		},
		extraListHtml: '<a href="javascript:void(0);" id="quickAddSales" class="quick-add-link"><i class="ui-icon-add"></i>新增職員</a>'
	}, opts);
	
	var salesCombo = $_obj.combo(opts).getCombo();	
	//新增客戶
	$('#quickAddSales').on('click', function(e){
		e.preventDefault();
		if (!Business.verifyRight('BU_ADD')) {
			return ;
		};
		$.dialog({
			title : '新增職員',
			content : 'url:../settings/staff_manage',
			data: {oper: 'add', callback: function(data, oper, dialogWin){
				//parent.getCustomer();
				//_self.customerCombo.selectByValue(data.id, false);
				salesCombo.loadData('../basedata/employee?action=list', ['id', data.id]);
				dialogWin && dialogWin.api.close();
			}},
			width : 400,
			height : 160,
			max : false,
			min : false,
			cache : false,
			lock: true
		});
	});
	return salesCombo;
};
Business.billSupplierCombo = function($_obj, opts){
	var defaultPage = Public.getDefaultPage();
	opts = $.extend(true, {
		data: function(){
			if(defaultPage.SYSTEM.supplierInfo) {
				var usingData = []//獲取啟用狀態的;
				for (var i = 0; i < defaultPage.SYSTEM.supplierInfo.length; i++) {
					var g = defaultPage.SYSTEM.supplierInfo[i];
					if(!g['delete']){
						usingData.push(g);
					}
				};
				return usingData;
			} else {
				return '../basedata/contact?action=listt&simple=1&type=10';
			}
		}
	}, opts);
	return Business.supplierCombo($_obj, opts);
}
Business.supplierCombo = function($_obj, opts){
	if ($_obj.length == 0) { return };
	var defaultPage = Public.getDefaultPage();
	var opts = $.extend(true, {
		data: function(){
			return defaultPage.SYSTEM.supplierInfo;;
		},
		ajaxOptions: {
			formatData: function(data){
				defaultPage.SYSTEM.supplierInfo = data.data.rows;	//更新
				return data.data.rows;
			}	
		},			
		width: 200,
		height: 300,
		formatText: function(row){
			return row.number + ' ' + row.name;
		},
		//formatResult: 'name',
		text: 'name',
		value: 'id',
		defaultSelected: 0,
		editable: true,
		extraListHtml: '<a href="javascript:void(0);" id="quickAddVendor" class="quick-add-link"><i class="ui-icon-add"></i>新增供應商</a>',
		maxListWidth: 500,
		cache: false,
		forceSelection: false,
		maxFilter: 10,
		trigger: false,	
		callback: {
			onChange: function(data){
				if(data) {
					$_obj.data('contactInfo', data);
					this.input.trigger('nextAction');
				} else {
					$_obj.removeData('contactInfo');
				}
			},
			onEnter:function(e){
				//e.stopPropagation();
				var skey = $_obj.find('input').val();
				if(!$_obj.data('contactInfo')){
					$_obj.find('.ui-icon-ellipsis').data('skey',skey).data('type','supplierInfo').trigger('click');
				}
			}
		}			
	}, opts);
	
	var supplierCombo = $_obj.combo(opts).getCombo();	
	//新增供應商
	$('#quickAddVendor').on('click', function(e){
		e.preventDefault();
		if (!Business.verifyRight('PUR_ADD')) {
			return ;
		};
		$.dialog({
			title : '新增供應商',
			content : 'url:../settings/vendor_manage',
			data: {oper: 'add', callback: function(data, oper, dialogWin){
				//parent.getCustomer();
				//_self.customerCombo.selectByValue(data.id, false);
				supplierCombo.loadData('../basedata/contact?type=10&action=list', ['id', data.id]);
				dialogWin && dialogWin.api.close();
			}},
			width : 640,
			height : 460,
			max : false,
			min : false,
			cache : false,
			lock: true
		});
	});
	
	supplierCombo.input.focus(function() {
		var $_this = $(this);
		setTimeout(function(){
			$_this.select();
		}, 15);
	});
	return supplierCombo;
};
Business.billSettlementAccountCombo = function($_obj, opts){
	var defaultPage = Public.getDefaultPage();
	opts = $.extend(true, {
		data: function(){
			if(defaultPage.SYSTEM.settlementAccountInfo) {
				var usingData = []//獲取啟用狀態的;
				for (var i = 0; i < defaultPage.SYSTEM.settlementAccountInfo.length; i++) {
					var g = defaultPage.SYSTEM.settlementAccountInfo[i];
					if(!g['delete']){
						usingData.push(g);
					}
				};
				return usingData;
			} else {
				return '../basedata/settAcct?action=list';
			}
		}
	}, opts);
	return Business.settlementAccountCombo($_obj, opts);
}
//結算賬戶下拉框初始化
Business.settlementAccountCombo = function($_obj, opts){
	if ($_obj.length == 0) { return };
	var defaultPage = Public.getDefaultPage();
	var getInfo=(function(){
		Public.ajaxGet('../basedata/settAcct?action=list', {}, function(data){
			if(data.status === 200) {
				defaultPage.SYSTEM.settlementAccountInfo = data.data.items;
			} else if (data.status === 250){
				defaultPage.SYSTEM.settlementAccountInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	})();
	var opts = $.extend(true, {
		data: function(){
			return defaultPage.SYSTEM.settlementAccountInfo || [];
		},
		ajaxOptions: {
			formatData: function(data){
				defaultPage.SYSTEM.settlementAccountInfo = data.data.items;	//更新
				return data.data.items;
			}	
		},
		width: 200,
		height: 300,
/*			formatText: function(row){
			return row.number + ' ' + row.name;
		},*/
		//formatResult: 'name',
		text: 'name',
		value: 'id',
		defaultSelected: -1,
		defaultFlag: false,
		cache: false,
		editable: true,
		callback: {
			onChange: function(data){
			}
		},
		extraListHtml: '<a href="javascript:void(0);" id="quickAddVendor" class="quick-add-link"><i class="ui-icon-add"></i>新增結算賬戶</a>'
	}, opts);
	
	var settlementAccountCombo = $_obj.combo(opts).getCombo();	
	//新增結算賬戶
	$('#quickAddVendor').on('click', function(e){
		e.preventDefault();
		if (!Business.verifyRight('SettAcct_ADD')) {
			return ;
		};
		$.dialog({
			title : '新增結算賬戶',
			content : 'url:../settings/settlementAccount_manage',
			data: {oper: 'add', callback: function(data, oper, dialogWin){
				defaultPage.SYSTEM.settlementAccountInfo.push(data);
				settlementAccountCombo.loadData('../basedata/settAcct/query?action=query', ['id', data.id]);
				dialogWin && dialogWin.api.close();
			}},
			width : 640,
			height : 205,
			max : false,
			min : false,
			cache : false,
			lock: true
		});
	});
	return settlementAccountCombo;
};
Business.formatGoodsName = function(good){
	var number = good.number;
	var name = good.name;
	var spec = good.spec ? '_' + good.spec : '';
	return number + ' ' + name + spec;
}
Business.cacheManage = {
	init : function(){
		if(this.inited) return;
		this.inited = 1;//只啟用一次
		this.defaultPage = Public.getDefaultPage();
		this.goodsInfo = this.defaultPage.SYSTEM.goodsInfo;
	},
	getGoodInfo:function(params, callback, effective){
		if(!params)return;
		var defaultPage = Public.getDefaultPage();
		var _self = this;
		_self.init();
		var _prop = '';
		var val = '';
		switch(params.action){
			case 'queryByMatchCon':_prop = 'number';val = params.matchCon; break;
			case 'queryByBarcode':_prop = 'barCode';val = params.barCode; break;
			default:return;
		}
		if(!val){
			callback({});
			return {};
		};
		//本地匹配多一次
		for (var i = _self.goodsInfo.length - 1; i >= 0; i--) {
			var good = _self.goodsInfo[i];
			delete good.amount;
			if(good[_prop] === val){
				/*$('#' + rowid).data('goodsInfo',good);
				var number = good.number;
				var name = good.name;
				var spec = good.spec ? '_' + good.spec : '';
				var barCode  = good.barCode ? '_' + good.barCode : '';
				return number + name + spec;*/
				if(good['delete'] && effective){
					defaultPage.Public.tips({type:2 , content:'該商品已經被禁用！'});
					return {};
				}
				if(typeof callback === 'function'){
					callback(good);
				}
				return good;
			}
		};
		//本地匹配不到，則去後端查詢
		defaultPage.$.ajax({
			url: '../basedata/inventory',
			type: 'post',
			dataType: 'json',
			data: params,
			async:false,//勿修改該屬性
			success:function(data){
				if(data.status === 200 && data.data){
					var good = {};
					if(data.data.items){
						if(data.data.items.length == 1){//精確匹配到的才需要,這個介面後面需要改成精確匹配編碼&名稱
							good = data.data.items[0];
						}else{
							return good;
						}
					}else{
						good = data.data;
					}
					delete good.amount;
					good.unitId = good.unitId || good.baseUnitId;
					if(good.unitId){
						for (var i = _self.defaultPage.SYSTEM.unitInfo.length - 1; i >= 0; i--) {
							var unit = _self.defaultPage.SYSTEM.unitInfo[i];
							if(unit.id == good.unitId){
								good.mainUnit = unit.name;
								good.unitName = unit.name;
							}
						};
					}
					// 加入快取
					defaultPage.SYSTEM.goodsInfo.push(good);
					if(good['delete'] && effective){
						defaultPage.Public.tips({type:2 , content:'該商品已經被禁用！'});
						return {};
					}
					//_self.goodsInfo.push(good);
					if(typeof callback === 'function'){
						callback(good);
					}
					return good;
				}else{
					//_self.defaultPage.Public.tips({type: 1, content : data.msg});
				}
			}
		})
		.done(function() {
			//console.log("success");
		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
	},
	getGoodsInfoByNumber:function(number, callback,effective){
		this.getGoodInfo({
			action:'queryByMatchCon',
			matchCon:number
		},callback, effective);
	},
	getGoodsInfoByBarCode:function(barCode, callback,effective){
		this.getGoodInfo({
			action:'queryByBarcode',
			barCode:barCode
		},callback, effective);
	}
}
Business.serNumManage = function(opts){
	var parentTr = opts.row,
	goodsInfo = opts.data || parentTr.data('goodsInfo') || {},
	serNumUsedList = goodsInfo.serNumList,
	isCreate = opts.isCreate,
	enableStorage = opts.enableStorage,
	enableSku = opts.enableSku,
	view = opts.view,
	$grid = parentTr.closest('table'),
	defaultPage = Public.getDefaultPage();

	
	var oldData = {
		goodsInfo: goodsInfo,
		storageInfo : parentTr.data('storageInfo') || {},
		unitInfo : parentTr.data('unitInfo')||{},
		skuInfo: parentTr.data('skuInfo')||{}
	} 
	/*if(!view){
		//非查詢模式
		$grid.jqGrid("restoreCell", curRow, curCol);
		parentTr.data('goodsInfo', null).data('storageInfo', null).data('unitInfo', null);
	}*/
	var params = {
		width: 650,
		height: 400,
		title: (serNumUsedList ? '修改' : '錄入') + '【'+goodsInfo.name+''+ (oldData.skuInfo && oldData.skuInfo.name ? '_'+ oldData.skuInfo.name : '') +'】的序列號',
		content: 'url:../settings/serNumBatch',
		data: {
			invId: goodsInfo.id,
			isCreate:isCreate,
			enableStorage : enableStorage,
			enableSku : enableSku,
			serNumUsedList : serNumUsedList,
			storageInfo : oldData.storageInfo,
			skuInfo:oldData.skuInfo,
			goodsInfo:oldData.goodsInfo,
			view : view,
			callback: function(serNumList,win){
				var curID = THISPAGE.curID;
				// $grid.jqGrid("restoreCell", curRow, curCol);
				//根據倉庫分組
				var storageList = {};
				if(!$.isArray(serNumList)){
					var _serNumList = [];
					for(var item in serNumList){
						_serNumList.push(serNumList[item]);
					}
					serNumList = _serNumList;
				}
				//出庫的時候，有輔助屬性的需要帶出來
				if(false && !isCreate && oldData.goodsInfo.invSkus && oldData.goodsInfo.invSkus.length){
					//從後臺獲取對應的sku
					$.fn.ajaxPost('../series/invSerNumAction/findSkuForSerNums?action=findSkuForSerNums',{serNums: serNumList.join()},function(data){
						if(data.status === 200){
							for (var i = 0; i < data.data.items.length; i++) {
								var thisSku = data.data.items[i];
								//如果後端返回的順序和條數和前端提交的相同就可以直接用i作為指針去改序列號列表中的數據，不然應該用下面這段被註釋掉的程式碼
								/*for (var j = 0; j < serNumList.length; j++) {
									if(serNumList[j].serNum == thisSku.serNum){
										serNumList[j].skuInfo = {
											skuId: thisSku.skuId,
											skuName: thisSku.skuName
										}
									}
								};*/
								serNumList[i].skuInfo = thisSku ? {} : {
									id: thisSku.skuId,
									name: thisSku.skuName
								}
							};
							rowHandle();
						}else{
							defaultPage.Public.tips({type:1,content:data.msg || '服務端響應錯誤！'})
							return;
						}
					});
				}else{
					rowHandle();
				}
				function rowHandle(){
					//根據sku和倉庫分組
					for (var i = 0; i < serNumList.length; i++) {
						var _sernum = serNumList[i];
						if(isCreate && !$.isEmptyObject(oldData.storageInfo)){
							//新增的時候檢查，不新增分錄
							//如果已經指定的倉庫,序列號全部入到目前倉庫
							var locationId = oldData.storageInfo.id || 0;
						}else{
							var locationId = _sernum.locationId || -1;
						}
						if(isCreate && !$.isEmptyObject(oldData.skuInfo)){
							//新增的時候檢查，不新增分錄
							//如果已經指定的sku,序列號全部入到目前sku
							var skuId = oldData.skuInfo.id || 0;
						}else{
							var skuId = _sernum.skuId || -1;
						}
						storageList[locationId + '_' + skuId] = storageList[locationId + '_' + skuId] || [];
						storageList[locationId + '_' + skuId].push(_sernum);
					};
					for(item in storageList){
						if(typeof storageList[item] === 'function') continue;
						var serNums = storageList[item];
						var addId = curID || THISPAGE.newId;
						if(curID) {
							//$('#'+curID).data('goodsInfo', null).data('storageInfo',null).data('unitInfo',null);
							var su = $grid.jqGrid('setRowData', Number(curID), {});
						} else {
							var su = $grid.jqGrid('addRowData', Number(THISPAGE.newId), {}, 'last');
							THISPAGE.newId++;
						};	
						var rowData = $grid.jqGrid('getRowData',curID);
						var tempRowData = $.extend(true, {}, goodsInfo);//克隆對象，不然會污染combo的數據
						tempRowData.goods = goodsInfo.number + ' ' + goodsInfo.name + (goodsInfo.spec ? '_' + goodsInfo.spec: '');
						tempRowData.qty = serNums.length;
						tempRowData.serNumList = serNums;
						
						//計算金額和稅率start
						if(tempRowData.qty >0 && rowData.goods){
							var _qty = parseFloat(tempRowData.qty);
							var _price = parseFloat(rowData.price);
							var _discountRate = parseFloat(rowData.discountRate);
							if($.isNumeric(_price)) {
								if($.isNumeric(_discountRate)) {
									tempRowData.deduction = _qty * _price * _discountRate / 100;//重新計算折扣額會導致PROJECT-15589
									tempRowData.amount = _qty * _price - tempRowData.deduction;
								} else {
									tempRowData.amount = _qty * _price;
								};
							};
							//tempRowData.amount = rowData.price * tempRowData.qty;
							var amount = Number(tempRowData.amount);
							if(defaultPage.SYSTEM.taxRequiredCheck) {
								var taxRate = rowData.taxRate;
								var tax = amount * taxRate / 100;
								var taxAmount = amount + tax;
								tempRowData.tax = tax;
								tempRowData.taxAmount = taxAmount;
							};
						}
						//計算金額和稅率end
						if(!isCreate){
							tempRowData.locationId = serNums[0].locationId;
							tempRowData.locationName = serNums[0].locationName;
							tempRowData.skuName = serNums[0].skuName;
							tempRowData.skuId = serNums[0].skuId;
						}else{
							tempRowData.locationId = oldData.storageInfo.id;
							tempRowData.locationName = oldData.storageInfo.name;
							tempRowData.skuName = oldData.skuInfo.name;
							tempRowData.skuId = oldData.skuInfo.id;
						}
						if(typeof opts.beforeSet === 'function'){
							opts.beforeSet(tempRowData);
						}
						if(su){
							$('#' + addId).data('goodsInfo',tempRowData)
							.data('storageInfo', { 
								id: tempRowData.locationId, 
								name: tempRowData.locationName
							}).data('unitInfo',{
								unitId: tempRowData.unitId,
								name: tempRowData.unitName
							}).data('skuInfo',{
								name:tempRowData.skuName,
								id: tempRowData.skuId
							});
						}
						$grid.jqGrid('setRowData', addId, tempRowData);
						if(serNumUsedList){
							//有使用過的說明是修改狀態
						}else{
							curRow && curRow++;
						}
						var $_nextTr = $('#' + curID).next();
						if($_nextTr.length > 0) {
							curID = $('#' + curID).next().attr('id');
						} else {
							curID = '';
						};
						if(curID === '') {
							if($grid[0].id === 'fixedGrid'){
								//組裝拆卸單的特殊處理,不需要新增一行
								win.close();
								return;
							}
							$grid.jqGrid('addRowData', THISPAGE.newId, {}, 'last');
							THISPAGE.newId = THISPAGE.newId + 1;
						};
						THISPAGE.calTotal();	
						/*if(serNumUsedList){
							//有使用過的說明是修改狀態 
							setTimeout( function() { $grid.jqGrid("nextCell") }, 10);
						}else{
							setTimeout( function() { $grid.jqGrid("editCell", curRow, 2, true) }, 10);
						}*/
					}
					typeof opts.afterSelected === 'function' && opts.afterSelected(); 
					win.close();
				}
			}
		},
		init:function(){
		},
		lock: true,
		ok:false,
		focus:false,//很奇葩，不設定這個按回車會觸發該控制元件上close按鈕的click事件~~~
		/*cancel:function(){
			$('#' + THISPAGE.curID).data('goodsInfo',oldData.goodsInfo)
			.data('storageInfo', { 
				id: oldData.storageInfo.id, 
				name: oldData.storageInfo.name
			}).data('unitInfo',{
				unitId: oldData.unitInfo.unitId,
				name: oldData.unitInfo.name
			});
		},*/
		esc:false,//外掛的BUG，在自定義按鈕之後，esc不觸發cancel事件, 需要設定cancelVal="cancel",才能找到cancel方法，看原始碼
		//cancelVal:'cancel',
		cancel:function(){
			//console.log(111)
			$grid.jqGrid("saveCells");
		}
	};
	if(!isCreate && (!serNumUsedList || (enableSku || enableStorage))){
		//出庫,沒有選序列號或者要更換倉庫或者屬性的時候 
		params.title = '選擇【'+goodsInfo.name+'】的序列號',
		params.content = 'url:../settings/serNumList';
		params.button = [{name: '確認',defClass:'ui_state_highlight', callback: function () {
							this.content.callback();
							//this.close();
					        return false;
						}}];
		params.width = 800;
		params.height = 460;
		params.data.enableStorage = true;
		params.data.enableSku = true;
	}
	if(view){
		//查詢模式
		params.cancel = true;
		params.cancelVal = '關閉';
		params.ok = false;
	}
	$grid.jqGrid("saveCells");
	$.dialog(params);
}
/**
 * isSkuSingle 可以為回撥的執行函式
 */
Business.billSkuManage = function(parentTr , data, isSkuSingle){
	var $grid = parentTr.closest('table');
	var defaultPage = Public.getDefaultPage();
	$grid.jqGrid("restoreCell", curRow, curCol);
	// parentTr.data('goodsInfo', null);
	$.dialog({
		width: 470,
		height: 410,
		title: '選擇【'+data.name+'】的屬性',
		content: 'url:http://'+Public.getHostName()+'/settings/assistingProp_batch',
		data: {
			//skey:_self.skey,
			isSingle : isSkuSingle,
			skuClassId:data.skuClassId,
			invId: data.id,
			invNumber: data.number,
			skuCombo:THISPAGE.skuCombo,
			goodsInfo:data,
			callback: function(goodsPropList,win){
				var curID = THISPAGE.curID;
				$grid.jqGrid("restoreCell", curRow, curCol);
				if(isSkuSingle){
					var tempData = goodsPropList[0];
					var addId = curID;
					var tempRowData = $.extend(true, {}, data);//克隆對象，不然會污染combo的數據
					if(typeof isSkuSingle === 'function'){
						isSkuSingle(addId,tempRowData,tempData);
					}else{
						tempRowData.qty = tempData.qty;
						tempRowData.skuName = tempData.skuName;
						tempRowData.skuId = tempData.skuId;
						$('#' + addId).data('goodsInfo',tempRowData)
						/*.data('storageInfo', { 
							id: tempRowData.locationId, 
							name: tempRowData.locationName
						})
						.data('unitInfo',{
							unitId: tempRowData.unitId,
							name: tempRowData.unitName
						})*/
						.data('skuInfo',{
							id: tempRowData.skuId,
							name: tempRowData.skuName
						});
						var goodsData = $.extend(true, {}, tempRowData);
						delete goodsData.id;
						$grid.jqGrid('setRowData', addId, goodsData);	
					}					
				}else{
					for(var i = 0 ,len = goodsPropList.length; i<len; i++){
						var addId = curID || THISPAGE.newId;
						var $thisRow = $('#' + addId);
						var tempData = goodsPropList[i];
						if(curID) {
							// $('#'+curID).data('goodsInfo', null).data('storageInfo',null).data('unitInfo',null);
							var su = $grid.jqGrid('setRowData', Number(curID), {});
						} else {
							var su = $grid.jqGrid('addRowData', Number(THISPAGE.newId), {}, 'last');
							THISPAGE.newId++;
						};
						var tempRowData = $.extend(true, {}, data);//克隆對象，不然會污染combo的數據
						tempRowData.goods = data.number + ' ' + data.name + (data.spec ? '_' + data.spec: '');
						tempRowData.qty = tempData.qty;
						tempRowData.skuName = tempData.skuName;
						tempRowData.skuId = tempData.skuId;
						if(tempRowData.qty>0){
							var _qty = parseFloat(tempData.qty);
							var _price = parseFloat(tempRowData.price);
							var _discountRate = parseFloat(tempRowData.discountRate);
							if($.isNumeric(_price)) {
								if($.isNumeric(_discountRate)) {
									tempRowData.deduction =  _qty * _price * _discountRate / 100;//重新計算折扣額會導致PROJECT-15589
									tempRowData.amount = _qty * _price - tempRowData.deduction;
								} else {
									tempRowData.amount = _qty * _price;
								};
							};
							var amount = Number(tempRowData.amount);
							if(defaultPage.SYSTEM.taxRequiredCheck) {
								var taxRate = tempRowData.taxRate;
								var tax = amount * taxRate / 100;
								var taxAmount = amount + tax;
								tempRowData.tax = tax;
								tempRowData.taxAmount = taxAmount;
							};
						}
						if(su){
							$('#' + addId)
							.data('goodsInfo',tempRowData)
							.data('skuInfo',{
								id: tempRowData.skuId,
								name: tempRowData.skuName
							});
							!$('#' + addId).data('storageInfo') && $('#' + addId).data('storageInfo', { 
								id: tempRowData.locationId, 
								name: tempRowData.locationName
							});
							!$('#' + addId).data('unitInfo') && $('#' + addId).data('unitInfo',{
								unitId: tempRowData.unitId,
								name: tempRowData.unitName
							});
						}
						$grid.jqGrid('setRowData', addId, tempRowData);
						curRow && curRow++;
						var $_nextTr = $('#' + curID).next();
						if($_nextTr.length > 0) {
							curID = $('#' + curID).next().attr('id');
						} else {
							curID = '';
						};
						if($grid[0].id === 'fixedGrid'){
							//組裝拆卸單的特殊處理,只要處理第一條
							break;
						}
					}
					if(curID === '') {
						if($grid[0].id === 'fixedGrid'){
							//組裝拆卸單的特殊處理,不需要新增一行
							win.close();
							return;
						}
						$grid.jqGrid('addRowData', THISPAGE.newId, {}, 'last');
						THISPAGE.newId = THISPAGE.newId + 1;
					};
					THISPAGE.calTotal();	
					// setTimeout( function() { $grid.jqGrid("editCell", curRow, 2, true) }, 10);
				}
				win.close();
			}
		},
		init:function(){
			//_self.skey = '';
			// $grid.jqGrid("editCell", curRow, 2, true);
		},
		close:function(){
			//console.log(123)
		},
		lock: true,
		ok:false,
		focus:false,//很奇葩，不設定這個按回車會觸發該控制元件上close按鈕的click事件~~~
		cancle:false
	});
}
Business.billGoodsCombo = function($_obj, opts , isSkuSingle){
	var defaultPage = Public.getDefaultPage();
	opts = $.extend(true, {
		// autoSelectFirst:false//變來變去的。。。
		data: function(){
			if(defaultPage.SYSTEM.goodsInfo) {
				var usingData = []//獲取啟用狀態的;
				for (var i = 0; i <  defaultPage.SYSTEM.goodsInfo.length; i++) {
					var g = defaultPage.SYSTEM.goodsInfo[i];
					if(!g['delete']){
						usingData.push(g);
					}
				};
				return usingData;
			} else {
				return '../basedata/inventory?action=list';
			}
		}
	}, opts);
	opts.callback = {
			onChange : function(data){
				var _self = this;
				_self.addQuery = true;
				var defaultPage = Public.getDefaultPage();
				var SYSTEM = defaultPage.SYSTEM;
				var parentTr = this.input.parents('tr');
				var $thisTd = this.input.closest('td');
				var $grid = parentTr.closest('table');
				var goodsInfo = parentTr.data('goodsInfo')||{};
				opts.userData = opts.userData || {};
				if(data) {
					if(data.id != goodsInfo.id){
						//如果有商品資訊
						delete data.amount;//商品的amount標示的是期初總額，這個欄位沒用
						/*if(!opts.disSerNum  && SYSTEM.ISSERNUM && data.isSerNum){
							//如果啟用序列號
							parentTr.find('td:gt('+$thisTd.index()+')').html('');
							Business.serNumManage({
								row : parentTr,
								data : data,
								creatable : opts.userData.creatable,
								beforeSet : opts.userData.beforeSet
							});
						}
						else{
							parentTr.data('goodsInfo', data);
							parentTr.data('storageInfo', { id: data.locationId, name: data.locationName});
							parentTr.data('unitInfo', { unitId: data.unitId, name: data.unitName});
						}*/
						parentTr.data('goodsInfo', data);
						parentTr.data('storageInfo', { id: data.locationId, name: data.locationName});
						parentTr.data('unitInfo', { unitId: data.unitId, name: data.unitName});
						parentTr.data('skuInfo',null);
					}else{
						//no changes
					}
				}else{
					parentTr.data('goodsInfo', null);
					parentTr.data('storageInfo',null);
					parentTr.data('unitInfo',null);
					parentTr.data('skuInfo',null);
				}
			}
	};
	return Business.goodsCombo($_obj, opts);
}
Business.goodsCombo = function($_obj, opts){
	var defaultPage = Public.getDefaultPage();
	if ($_obj.length == 0) { return };
	var opts = $.extend(true, {
		data: function(){
			if(defaultPage.SYSTEM.goodsInfo) {
				return defaultPage.SYSTEM.goodsInfo;
			} else {
				return '../basedata/inventory?action=list';
			}
		},
		ajaxOptions: {
			formatData: function(data){
				defaultPage.SYSTEM.goodsInfo = data.data.rows;	//更新
				return data.data.rows;
			}	
		},
		formatText: function(data){
			return Business.formatGoodsName(data);
		},
		value: 'id',
		defaultSelected: -1,
		editable: true,
		extraListHtml: '<a href="javascript:void(0);" class="quick-add-link quickAddGoods"><i class="ui-icon-add"></i>新增商品</a>',
		maxListWidth: 500,
		cache: false,
		forceSelection: true,
		trigger: false,
		listHeight: 182,
		listWrapCls: 'ui-droplist-wrap',
		customMatch:function(item,query){
			var reg = new RegExp(query.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&'), 'i');
			var text = item.text + (item.rawData.pinYin || '');
			if(text.search(reg) == -1){
				return false;
			}
			return true;
		},
		callback: {
			onChange: function(data){
				var _self = this;
				_self.addQuery = true;
				var parentTr = this.input.parents('tr');
				var goodsInfo = parentTr.data('goodsInfo')||{};
				if(data) {
					if(data.id != goodsInfo.id){
						parentTr.data('goodsInfo', data);
						parentTr.data('storageInfo', { id: data.locationId, name: data.locationName});
						parentTr.data('unitInfo', { unitId: data.unitId, name: data.unitName});
					}
				}else{
					parentTr.data('goodsInfo', null);
					parentTr.data('storageInfo',null);
					parentTr.data('unitInfo',null);
				}
			},
			incrementalSearch: function(pos, callback){
				var _self = this;
				var query = $_obj.val()
				Public.ajaxGet('../basedata/inventory?action=list', { rows: 20, skey: query }, function(data){
					if(data.status === 200 || data.status === 250) {
						//SYSTEM.goodsInfo.push(data.data.rows);				
						_self.rawData = _self.addData = data.data.rows;	
						if(data.data.rows.length < _self.opts.maxFilter) {
							_self.addQuery = false;
						} else {
							_self.addQuery = true;
						};
						callback.call(_self);
						var addId = [];
						$.each(data.data.rows, function(i, n){
							addId.push(n.id);	
						});
						$.each(pos, function(i, n){
							if($.inArray(n.value, addId) !== -1) {
								if(i === 0) {
									defaultPage.SYSTEM.goodsInfo.splice(i, 1);
								} else {
									defaultPage.SYSTEM.goodsInfo.splice(i - 1, 1);
								};
							};	
						});
						$.merge(defaultPage.SYSTEM.goodsInfo, data.data.rows);
						var goodsInfo = defaultPage.SYSTEM.goodsInfo;
						if(goodsInfo.length > 100) {
							goodsInfo.splice(0, goodsInfo.length - 100);
						}
					};
				});
			},
			onListClick: function(){

			},
			onEnter:function(){
				setTimeout(function(){
					if(goodsCombo.isExpanded){
						goodsCombo.collapse();
					}
				},50)
			}
		},
		forceSelection : false,
		queryDelay: 0,
		inputCls: 'edit_subject',
		wrapCls: 'edit_subject_wrap',
		focusCls: '',
		disabledCls: '',
		activeCls: ''
	}, opts);
	
	var goodsCombo = $_obj.combo(opts).getCombo();
	
	//新增商品
	$('.quickAddGoods').unbind('click').on('click', function(e){
		e.preventDefault();
		if (!Business.verifyRight('INVENTORY_ADD')) {
			return ;
		};
		var _w = 1020,
		_h = defaultPage.SYSTEM.enableStorage?480:370;
		_h = defaultPage.SYSTEM.enableAssistingProp?_h:_h-100;
		_h = defaultPage.SYSTEM.ISSERNUM?_h + 40:_h;
		$.dialog({
			title : '新增商品',
			content : 'url:../settings/goods_manage',
			data: {oper: 'add', callback: function(data, oper, dialogWin){
				var goodID = data.id;
				//_self.goodsCombo.getAllRawData().push(data);
				defaultPage.SYSTEM.goodsInfo.push(data);
				data.unitId = data.unitId || data.baseUnitId;
				dialogWin && dialogWin.api.close();
				//var allRawData = _self.goodsCombo.getAllRawData();
				goodsCombo.loadData(defaultPage.SYSTEM.goodsInfo, '-1', false);
				setTimeout( function() {
					 //$("#grid").jqGrid("editCell", editRow, 2, true)
					 goodsCombo.selectByValue(goodID, true);
					 $_obj.focus();
				}, 10);
				
			}},
			width : _w,
			height : _h,
			max : false,
			min : false,
			cache : false,
			lock: true
		});
	});
	return goodsCombo;
};
Business.categoryCombo = function($_obj, opts, type){
	if ($_obj.length == 0) { return };
	var typeNumber = type||'';
	if(typeof opts != 'object'){
		typeNumber = opts;
		opts = {};
	}
	if(!typeNumber) { return };
	var defaultPage = Public.getDefaultPage();
	var opts = $.extend(true, {
		data: function(){
			if(defaultPage.SYSTEM.categoryInfo && defaultPage.SYSTEM.categoryInfo[typeNumber]) {
				return defaultPage.SYSTEM.categoryInfo[typeNumber];
			} else {
				return '../basedata/assist?action=list&isDelete=2&typeNumber='+typeNumber;
			}
		},
		ajaxOptions: {
			formatData: function(data){
				defaultPage.SYSTEM.categoryInfo = defaultPage.SYSTEM.categoryInfo ||{};
				defaultPage.SYSTEM.categoryInfo[typeNumber] = data.data.items;	//更新
				return data.data.items;
			}	
		},
		text: 'name',
		value: 'id',
		defaultSelected: -1,
		editable: true,
		extraListHtml: '<a href="javascript:void(0);" id="quickAddCategory" class="quick-add-link"><i class="ui-icon-add"></i>新增類別</a>',
		maxListWidth: 500,
		cache: false,
		forceSelection: true,
		maxFilter: 10,
		trigger: false,
		callback: {
			onChange: function(data){
				var parentTr = this.input.parents('tr');
				if(data) {
					parentTr.data('categoryInfo', data);
				}
			},
			onListClick: function(){

			}
		},
		queryDelay: 0
	}, opts);
	
	var categoryCombo = $_obj.combo(opts).getCombo();
	var rights = {
			'customertype' : 'BUTYPE_ADD',// '客戶',
			'supplytype' : 'SUPPLYTYPE_ADD',// '供應商',
			'trade' : 'TRADETYPE_ADD'// '商品'
		};
	//新增分類
	$('#quickAddCategory').on('click', function(e){
		e.preventDefault();
		if (rights[typeNumber] && !Business.verifyRight(rights[typeNumber])) {
			return ;
		};
		var callback=function(data,dialogWin){
			categoryCombo.loadData(function(){return defaultPage.SYSTEM.categoryInfo[typeNumber]}, '-1', false);
			dialogWin.close();
			setTimeout( function() {
				categoryCombo.selectByValue(data.id, true);
				$_obj.focus();
			}, 10);
		};
		Public.categoryPop(typeNumber,window.parent,callback);
	});
	return categoryCombo;
};
Business.forSearch = function(id, text){
	if(id) {
		$.dialog({
			width: 470,
			height: 410,
			title: '商品庫存查詢',
			content: 'url:../inventory',
			data: { id: id, text: text},
			cancel: true,
			lock: true,
			cancelVal: '關閉'
			
		});
		//goodsCombo.removeSelected(false);
	} else {
		parent.Public.tips({type: 2, content : '請先選擇一個商品！'});
	};
};
Business.billStorageCombo = function($_obj, opts){
	var defaultPage = Public.getDefaultPage();
	opts = $.extend(true, {
		data: function(){
			if(defaultPage.SYSTEM.storageInfo) {
				var usingData = []//獲取啟用狀態的;
				for (var i = 0; i < defaultPage.SYSTEM.storageInfo.length; i++) {
					var g = defaultPage.SYSTEM.storageInfo[i];
					if(!g['delete']){
						usingData.push(g);
					}
				};
				return usingData;
			} else {
				return '../basedata/invlocation?action=list&isDelete=2';
			}
		}
	}, opts);
	return Business.storageCombo($_obj, opts);
}
Business.storageCombo = function($_obj, opts){
	var defaultPage = Public.getDefaultPage();
	if ($_obj.length == 0) { return };
	var opts = $.extend(true, {
			//data: parent.SYSTEM.storageInfo/*'/basedata/invlocation.do?action=list&isEnable=1'*/,
			data: function(){
				return defaultPage.SYSTEM.storageInfo;
			},
/*			ajaxOptions: {
				formatData: function(data){
					return data.data.items;
				}	
			},*/
			text: 'name',
			value: 'id',
			defaultSelected: 0,
			cache: false,
			editable: true,
			trigger: false,
			defaultFlag: false,
			callback: {
				onChange: function(data){
					var parentTr = this.input.parents('tr');
					//var storageInfo = parentTr.data('storageInfo');
					//console.log(parentTr.data('storageInfo'))
/*					if(!storageInfo) {
						storageInfo = {};
					};*/
					if(data) {
						parentTr.data('storageInfo', {id: data.id, name: data.name});
						//storageInfo.id = data.id;
						//storageInfo.name = data.name;
					}
				}
			}
		}, opts);
	
	var storageCombo = $_obj.combo(opts).getCombo();
	return storageCombo;
};
Business.billskuCombo = function($_obj, opts){
	var defaultPage = Public.getDefaultPage();
	opts = $.extend(true, {
		data: function(){
			if(!this.input) return [];
			var parentTr = this.input.closest('tr');
			var goodsInfo = parentTr.data('goodsInfo');
			if(!goodsInfo)return;
			return goodsInfo.invSkus || [];
		},
		callback: {
			onChange: function(data){
				if(data){
					var parentTr = this.input.closest('tr');
					var goodsInfo = parentTr.data('goodsInfo');
					if(!goodsInfo)return;
					parentTr.data('skuInfo',{
						name:data.skuName,
						id: data.skuId
					});
				}else{
					
				}
			}
		}
	}, opts);
	return Business.skuCombo($_obj, opts);
}
Business.skuCombo = function($_obj, opts){
	var defaultPage = Public.getDefaultPage();
	if ($_obj.length == 0) { return };
	var $extraListHtml = $('<a href="javascript:void(0);" id="quickAddSku" class="quick-add-link quickAddSku"><i class="ui-icon-add"></i>新增輔助屬性</a>');
	var opts = $.extend(true, {
			data: function(){
				return defaultPage.SYSTEM.skuInfo || [];
			},
			text: 'skuName',
			value: 'skuId',
			defaultSelected: 0,
			cache: false,
			editable: true,
			trigger: false,
			defaultFlag: false,
			extraListHtml: $extraListHtml,
			callback: {
				onChange: function(data){
					
				}
			}
		}, opts);
	var skuCombo = $_obj.combo(opts).getCombo();
	//新增屬性
	$extraListHtml.on('click', function(e){
		e.preventDefault();
		if (!Business.verifyRight('FZSX_ADD')) {
			return ;
		};
		var good = $('#' + THISPAGE.curID).data('goodsInfo');
		if(!SYSTEM.enableAssistingProp)return;
			if(!good){
				return;
			}else{
				if(good.skuId || good.skuClassId){
					$.dialog({
						title : '新增輔助屬性',
						content: 'url:../settings/assistingPropGroupManage',
						data: {
							invId: good.id,
							invNumber: good.number,
							skuId : good.skuId,
							skuClassId:good.skuClassId,
							callback: function(data,win){
								if(data) {
									$('#' + THISPAGE.curID).data('goodsInfo').invSkus.push(data);
									skuCombo.loadData($('#' + THISPAGE.curID).data('goodsInfo').invSkus);
									$_obj.val(data.skuName);	//回填數據
									$('#' + THISPAGE.curID).data('skuInfo',{
										name:data.skuName,
										id: data.skuId
									});
									skuCombo.collapse();	//關閉下拉
								}								
								// win && win.close();
							}
						},
						width : 400,
						height : 180,
						max : false,
						min : false,
						cache : false,
						lock: true
					});					
				}
			}
	});
	return skuCombo;
};
Business.batchCombo = function($_obj, opts){
	var defaultPage = Public.getDefaultPage();
	if ($_obj.length == 0) { return };
	var opts = $.extend(true, {
			data: function(){
				return defaultPage.SYSTEM.batchInfo;
			},
			text: 'name',
			value: 'id',
			defaultSelected: 0,
			cache: false,
			editable: true,
			trigger: false,
			defaultFlag: false,
			forceSelection:false,
			callback: {
				onChange: function(data){
				}
			}
		}, opts);
	
	var batchCombo = $_obj.combo(opts).getCombo();
	return batchCombo;
};
Business.unitCombo = function($_obj, opts){
	if ($_obj.length == 0) { return };
	var defaultPage = Public.getDefaultPage();
	var opts = $.extend(true, {
			//data: parent.SYSTEM.storageInfo/*'/basedata/invlocation.do?action=list&isEnable=1'*/,
			data: function(){
				return (defaultPage.SYSTEM || opts.userData.system).unitInfo;
			},
/*			ajaxOptions: {
				formatData: function(data){
					return data.data.items;
				}	
			},*/
			text: 'name',
			value: 'id',
			defaultSelected: 0,
			cache: false,
			editable: true,//這個會在grid.celledit.js裡面的//edit 修復自定義編輯獲取焦點 --arenp 這裡導致頁面一次錄很多分錄之後出現頁面定位錯誤
			trigger: false,
			defaultFlag: false,
			forceSelection:false,
			callback: {
				onChange: function(data){
					var parentTr = this.input.parents('tr');
					//var storageInfo = parentTr.data('storageInfo');
					//console.log(parentTr.data('storageInfo'))
/*					if(!storageInfo) {
						storageInfo = {};
					};*/
					if(data) {
						data.id = data.id || data.unitId;
						parentTr.data('unitInfo', {unitId: data.id, name: data.name});
						//storageInfo.id = data.id;
						//storageInfo.name = data.name;
					}
				}
			}
		}, opts);
	
	var unitCombo = $_obj.combo(opts).getCombo();
	return unitCombo;
};
Business.accountCombo = function($_obj, opts){
	if ($_obj.length == 0) { return };
	var opts = $.extend(true, {
		data: function(){
			if(SYSTEM.accountInfo) {
				return SYSTEM.accountInfo;
			} else {
				return '../basedata/settAcct?action=list';
			}
		},
		ajaxOptions: {
			formatData: function(data){
				SYSTEM.accountInfo = data.data.items;	//更新
				return data.data.items;
			}	
		},
		formatText: function(data){
			return data.number + ' ' + data.name;
		},
		value: 'id',
		defaultSelected: 0,
		defaultFlag: false,
		cache: false,
		editable: true
	}, opts);	
	var accountCombo = $_obj.combo(opts).getCombo();
	return accountCombo;
};

Business.paymentCombo = function($_obj, opts){
	if ($_obj.length == 0) { return };
	var opts = $.extend(true, {
		data: function(){
			if(SYSTEM.paymentInfo) {
				return SYSTEM.paymentInfo;
			} else {
				return '../basedata/assist?action=list&typeNumber=PayMethod&isDelete=2';
			}
		},
		ajaxOptions: {
			formatData: function(data){
				SYSTEM.paymentInfo = data.data.items;	//更新快取
				return data.data.items;
			}	
		},
		emptyOptions: true,
		text: 'name',
		value: 'id',
		defaultSelected: 0,
		cache: false,
		editable: false,
		trigger: false,
		defaultFlag: false
		
	}, opts);
	var paymentCombo = $_obj.combo(opts).getCombo();	
	return paymentCombo;
};
/*
 * 網店下拉框
 */
Business.storeCombo = function($_obj, opts){
	if ($_obj.length == 0) { return };
	var defaultPage = Public.getDefaultPage();
	var SYSTEM = SYSTEM || defaultPage.SYSTEM || opts.system;
	var opts = $.extend(true, {
		data: function(){
			if(SYSTEM.storeInfo) {
				return SYSTEM.storeInfo;
			} else {
				return '/bs/cloudStore.do?action=list';
			}
		},
		ajaxOptions: {
			formatData: function(data){
				SYSTEM.storeInfo = data.data.items;	//更新
				return data.data.items;
			}	
		},
		formatText: function(data){
			return data.name;
		},
		value: 'id',
		defaultSelected: 0,
		addOptions : {text : '(所有)',value : -1	},
		defaultFlag: false,
		cache: false,
		editable: true
	}, opts);	
	var storeCombo = $_obj.combo(opts).getCombo();
	return storeCombo;
};
/*
 * 物流公司下拉框
 */
Business.logisticCombo = function($_obj, opts){
	if ($_obj.length == 0) { return };
	var defaultPage = Public.getDefaultPage();
	var SYSTEM = SYSTEM || defaultPage.SYSTEM || opts.system;
	var opts = $.extend(true, {
		data: function(){
			if(SYSTEM.logisticInfo) {
				return SYSTEM.logisticInfo;
			} else {
				return '/bs/express.do?action=list';
			}
		},
		ajaxOptions: {
			formatData: function(data){
				SYSTEM.logisticInfo = data.data.items;	//更新
				return data.data.items;
			}	
		},
		formatText: function(data){
			return data.number + ' ' + data.name;
		},
		value: 'id',
		defaultSelected: 0,
		addOptions : {text : '(空)',value : 0	},
		defaultFlag: false,
		cache: false,
		editable: true
	}, opts);	
	var logisticCombo = $_obj.combo(opts).getCombo();
	return logisticCombo;
};
Business.billsEvent = function(obj, type, flag){
	var _self = obj;
	var defaultPage = Public.getDefaultPage();
	//新增分錄
	$('.grid-wrap').on('click', '.ui-icon-plus', function(e){
		var rowId = $(this).parent().data('id');
		var newId = $('#grid tbody tr').length;
		var datarow = { id: _self.newId };
		var su = $("#grid").jqGrid('addRowData', _self.newId, datarow, 'before', rowId);
		if(su) {
			$(this).parents('td').removeAttr('class');
			$(this).parents('tr').removeClass('selected-row ui-state-hover');
			$("#grid").jqGrid('resetSelection');
			_self.newId++;
		}
	});
	//刪除分錄
	$('.grid-wrap').on('click', '.ui-icon-trash', function(e){
		if($('#grid tbody tr').length === 2) {
			parent.Public.tips({type: 2, content: '至少保留一條分錄！'});
			return false;
		}
		var rowId = $(this).parent().data('id');
		var su = $("#grid").jqGrid('delRowData', rowId);
		if(su) {
			_self.calTotal();
		};
	});
	//查詢庫存
	$('.grid-wrap').on('click', '.ui-icon-cart', function(e){
		e.preventDefault();
		var goodsInfo = $(this).closest('tr').data('goodsInfo');
		if(!goodsInfo){
			parent.Public.tips({type: 2, content: '請先錄入商品！'});
			return;
		}
		Business.forSearch(goodsInfo.id, '');
	});

	//區分組裝拆卸單
	if(type !== 'assemble') {
		$('#customer').on('click', '.ui-icon-ellipsis', function(e){	
			var skey = $(this).data('skey');
			var lable = $('#customer').prev().text().slice(0, -1);
			var title = '選擇' + lable;
			if(lable === '供應商' || lable === '購貨單位') {
				var content = 'url:../settings/select_customer?type=10';
			} else {
				var content = 'url:../settings/select_customer';
			}
			_self.customerDialog = $.dialog({
				width: 775,
				height: 510,
				title: title,
				content: content,
				data: {
					skey : skey
				},
				lock: true,
				ok: function(){
					if(typeof this.content.callback === 'function'){
						this.content.callback();
						this.close();
					}
			        return false;
				},
				cancel: function(){
			        return true;
				}
			});
		});
		//批量新增屬性
		$('.grid-wrap').on('click', '.skuInfo .ui-icon-ellipsis', function(e){
			if(!SYSTEM.enableAssistingProp)return;
			var good = $('#' + THISPAGE.curID).data('goodsInfo');
			if(!good){
				return;
			}else{
				if(good.skuId || good.skuClassId){
					Business.billSkuManage($('#' + THISPAGE.curID),good);
				}
			}
		});
		//批量新增
		$('.grid-wrap').on('click', '.goods .ui-icon-ellipsis', function(e){
			var skuMult = false;
			if(!$(this).hasClass('disableSku')){
				skuMult = $(this).data('skuMult') || defaultPage.SYSTEM.enableAssistingProp;
			}
			$.dialog({
					width: 775,
					height: 510,
					title: '選擇商品',
					content: 'url:../settings/goods_batch',
					data: {
						skuMult: skuMult,
						skey:_self.skey,
						callback: function(newId, curID, curRow){
							if(curID === '') {
								$("#grid").jqGrid('addRowData', newId, {}, 'last');
								_self.newId = newId + 1;
							};
							setTimeout( function() { $("#grid").jqGrid("editCell", curRow, 2, true) }, 10);
							_self.calTotal();
						}
					},
					lock: true,
					button:[{name: '選中',defClass:'ui_state_highlight fl', callback: function () {
						this.content.callback(type);
				        return false;
					}},
					{name: '選中並關閉',defClass:'ui_state_highlight', callback: function () {
						this.content.callback(type);
						this.close();
				        return false;
					}},
					{name: '關閉', callback: function () {
				        return true;
					}}]
				});
				$(this).data('hasInstance', true);
		});
		
		//取消分錄編輯狀態
		$(document).bind('click.cancel', function(e){
			if(!$(e.target).closest(".ui-jqgrid-bdiv").length > 0 && $(e.target).closest(".pika-single").length == 0 && curRow !== null && curCol !== null){
			   $("#grid").jqGrid("saveCell", curRow, curCol);
			   curRow = null;
			   curCol = null;
			};
		});
	};	
	//批量新增批次
		$('.grid-wrap').on('click', '.batch .ui-icon-ellipsis', function(e){
			var _$this = $(this);
			var _$grid = _$this.closest('.ui-jqgrid-btable');
			var _$tr = _$this.closest('tr');
			var goodsInfo = _$tr.data('goodsInfo');
			var storageInfo = _$tr.data('storageInfo');
			var isSingle = _$this.closest('td').hasClass('isSingle');
			if(!goodsInfo){
				defaultPage.Public.tips({type:2, content:"請先選擇一個商品！"});
				return;
			}
			$.dialog({
					width: 570,
					height: 500,
					title: '選擇商品【'+ goodsInfo.number +' ' + goodsInfo.name +'】的批號',
					content: 'url:http://'+Public.getHostName()+'/settings/batch_batch',
					data: {
						isSingle: isSingle,
						skey:_self.skey,
						goodsInfo:goodsInfo,
						storageInfo:storageInfo,
						callback: function(batchList){
							if(!batchList)return;
							var rowId = _$tr[0].id;
							var isfirst = true;
							var firstItem = _$grid.jqGrid('getRowData', rowId);
							for (batchId in batchList){
								var batchData = batchList[batchId];
								if(batchId != 'function'){
									if(isfirst){
										storageInfo = {
											id: batchData.locationId, 
											name: batchData.locationName
										};
										var editData = $.extend(true, {
											batch: batchData.batch,
											prodDate: batchData.prodDate,
											safeDays: goodsInfo.safeDays,
											validDate: batchData.validDate,
											locationId: batchData.locationId, 
											locationName: batchData.locationName,
											outLocationId: batchData.locationId, //調撥單中使用
											outLocationName: batchData.locationName //調撥單中使用
										});
										_$grid.jqGrid('setRowData', rowId, editData);
										_$tr.data('storageInfo',storageInfo);
										var _lastId = rowId;
										isfirst = false;
									}else{
										var nextId = (function(rowId){
											var $nextRow = $('#'+rowId).next();
											if($nextRow.length){
												if($nextRow.data('goodsInfo')){
													return arguments.callee($nextRow[0].id);
												}else{
													return $nextRow[0].id;
												}
											}else{
												var newId = Number(rowId) + 1;
												_$grid.jqGrid('addRowData', newId, 'last');
												_$grid.jqGrid('addRowData', newId + 1, {}, 'last');
												_self.newId = newId + 	2;
												return newId;
											}
										})(rowId);
										firstItem.locationId = batchData.locationId;
										firstItem.locationName = batchData.locationName;
										firstItem.outLocationId = batchData.locationId;//調撥單中使用
										firstItem.outLocationName = batchData.locationName;//調撥單中使用
										var _rowData = $.extend(true, goodsInfo, firstItem );
										$.extend(true, _rowData, {
											batch: batchData.batch,
											prodDate: batchData.prodDate,
											safeDays: goodsInfo.safeDays,
											validDate: batchData.validDate
										});
										_$grid.jqGrid('setRowData', nextId, _rowData);
										$('#'+nextId).data('goodsInfo',_rowData)
										.data('storageInfo', { 
											id: _rowData.locationId, 
											name: _rowData.locationName
										}).data('unitInfo',{
											unitId: _rowData.unitId,
											name: _rowData.unitName
										});
										_lastId = nextId;
									}
								}
							}
							if(isSingle){
								//_$grid.jqGrid('editCellByColName', Number(_lastId) + 1, 'goods');
							}else{
								_$grid.jqGrid('editCellByColName', Number(_lastId) + 1, 'goods');
								_self.calTotal && _self.calTotal();
							}
						}
					},
					lock: true,
					button:[{name: '選中',defClass:'ui_state_highlight fl', callback: function () {
						this.content.callback(type);
				        return false;
					}},
					{name: '選中並關閉',defClass:'ui_state_highlight', callback: function () {
						this.content.callback(type);
						this.close();
				        return false;
					}},
					{name: '關閉', callback: function () {
				        return true;
					}}]
				});
				$(this).data('hasInstance', true);
		});
	initStorage();
	
	function initStorage() {
		var data = []//獲取啟用狀態的;
		for (var i = 0; i < defaultPage.SYSTEM.storageInfo.length; i++) {
			var g = defaultPage.SYSTEM.storageInfo[i];
			if(!g['delete']){
				data.push(g);
			}
		};
		var list = '<ul>';
		for(var i = 0, len = data.length; i < data.length; i++) {
			list += '<li data-id="' + data[i].id + '" data-name="' + data[i].name + '" >' + data[i].locationNo + ' ' +data[i].name + '</li>';
		};
		list += '</ul>';
		$("#storageBox").html(list);
	};

	if(type === 'transfers') {
		return;
	};
	
	$("#batchStorage").powerFloat({
		eventType: "click",
		hoverHold: false,
		reverseSharp: true,
		target: function(){
			if(curRow !== null && curCol !== null){
			   $("#grid").jqGrid("saveCell", curRow, curCol);
			   curRow = null;
			   curCol = null;
			};
			return $("#storageBox");
		}
	});

	$('.wrapper').on('click', '#storageBox li', function(e){
		var stoId = $(this).data('id');
		var stoName = $(this).data('name');
		var ids = $("#grid").jqGrid('getDataIDs');
		var batName = 'locationName';
		var batInfo = 'storageInfo';
		for(var i = 0, len = ids.length; i < len; i++){
			var id = ids[i], itemData;
			var row = $("#grid").jqGrid('getRowData',id);
			var $_id = $('#' + id);
			if(row.goods === '' || $_id.data('goodsInfo') === undefined) {
				continue;	//跳過無效分錄
			};
			var setData = {};
			setData[batName] = stoName;
			$("#grid").jqGrid('setRowData', id, setData);
			$('#' + id).data(batInfo, { id: stoId, name: stoName });
		};
		$.powerFloat.hide();
	});

};

Business.filterCustomer = function(){
	Business.customerCombo($('#customerAuto'), {
		width: '',
		formatText: function(data){
			return data.number + ' ' + data.name;
		},
		trigger: false,
		forceSelection: false,
		noDataText: '',
		extraListHtmlCls: '',
		extraListHtml: '', 
		callback: {
			onChange: function(data){
				if(data) {
					//this.input.data('ids', data.id);
					this.input.val(data.number);
				}
			}
		}
	});
	
	//客戶
	$('#filter-customer .ui-icon-ellipsis').on('click', function(){
		var $input = $(this).prev('input');
		$.dialog({
			width: 570,
			height: 500,
			title: '選擇客戶',
			content: 'url:../settings/customer_batch',
			data:{isDelete:2},
			lock: true,
			ok: function(){
				Business.setFilterData(this.content, $input);
			},
			cancel: function(){
				return true;
			}
		});
	});
};

Business.filterSupplier = function(){
	Business.supplierCombo($('#supplierAuto'), {
		width: '',
		formatText: function(data){
			return data.number + ' ' + data.name;
		},
		trigger: false,
		forceSelection: false,
		noDataText: '',
		extraListHtmlCls: '',
		extraListHtml: '', 
		callback: {
			onChange: function(data){
				if(data) {
					//this.input.data('ids', data.id);
					this.input.val(data.number);
				}
			}
		}
	});
	
	//客戶
	$('#filter-customer .ui-icon-ellipsis').on('click', function(){
		var $input = $(this).prev('input');
		$.dialog({
			width: 570,
			height: 500,
			title: '選擇供應商',
			content: 'url:../settings/supplier_batch',
			data:{isDelete:2},
			lock: true,
			ok: function(){
				Business.setFilterData(this.content, $input);
			},
			cancel: function(){
				return true;
			}
		});
	});
};
//結算賬戶查詢區域下拉框初始化
Business.filterSettlementAccount = function(){
	Business.settlementAccountCombo($('#settlementAccountAuto'), {
		width: '',
		formatText: function(data){
			return data.number + ' ' + data.name;
		},
		trigger: false,
		forceSelection: false,
		noDataText: '',
		extraListHtmlCls: '',
		extraListHtml: '', 
		callback: {
			onChange: function(data){
				if(data) {
					//this.input.data('ids', data.id);
					this.input.val(data.number);
				}
			}
		}
	});
	
	//結算賬戶
	$('#filter-settlementAccount .ui-icon-ellipsis').on('click', function(){
		var $input = $(this).prev('input');
		$.dialog({
			width: 470,
			height: 500,
			title: '選擇結算賬戶',
			content: 'url:../settings/settlementAccount_batch',
			data:{isDelete:2},
			lock: true,
			ok: function(){
				Business.setFilterData(this.content, $input);
			},
			cancel: function(){
				return true;
			}
		});
	});
};

Business.filterGoods = function(){
	Business.goodsCombo($('#goodsAuto'), { 
		forceSelection: false,
		noDataText: '',
		extraListHtmlCls: '',
		extraListHtml: '', 
		forceSelection: false,
		callback: {
			onChange: function(data){
				if(data) {
					this.input.data('ids', data.number);
					this.input.val(data.number);
				}
			}
		}
	});
	//商品	
	$('#filter-goods .ui-icon-ellipsis').on('click', function(){
		var $input = $(this).prev('input');
		$.dialog({
			width: 775,
			height: 500,
			title: '選擇商品',
			content: 'url:../settings/goods_batch',
			data:{
				isDelete:2//獲取全部商品要傳2。。。
			},
			lock: true,
			ok: function(){
				Business.setFilterGoods(this.content, $input);
			},
			cancel: function(){
				return true;
			}
		});
	});
};
Business.filterStorage = function(){
	var defaultPage = Public.getDefaultPage();
	Business.storageCombo($('#storageAuto'), { 
		data: function(){
			return defaultPage.SYSTEM.storageInfo;
		},
		formatText: function(data){
			return data.locationNo + ' ' + data.name;
		},
		editable: true,
		defaultSelected: -1,
		forceSelection: false,
		callback: {
			onChange: function(data){
				if(data) {
					//this.input.data('ids', data.id);
					this.input.val(data.locationNo);
				}
			}
		}
	});
	//倉庫
	$('#filter-storage .ui-icon-ellipsis').on('click', function(){
		var $input = $(this).prev('input');
		$.dialog({
			width: 510,
			height: 500,
			title: '選擇倉庫',
			content: 'url:../settings/storage_batch',
			data:{isDelete:2},
			lock: true,
			ok: function(){
				Business.setFilterData(this.content, $input);
			},
			cancel: function(){
				return true;
			}
		});
	});
};
Business.filterSaler = function(){
	Business.salesCombo($('#salerAuto'), {
			defaultSelected: -1,
			editable: true,
			extraListHtml: '',
			width:0,
			emptyOptions:false,
			forceSelection: false,
			formatText: function(row){
				return row.number + ' ' + row.name;
			},
			callback: {
				onChange: function(data){
					if(data) {
						//this.input.data('ids', data.id);
						this.input.val(data.number);
					}
				}
			},
			trigger:false
	});
	//銷售員
	$('#filter-saler .ui-icon-ellipsis').on('click', function(){
		var $input = $(this).prev('input');
		$.dialog({
			width: 510,
			height: 500,
			title: '選擇銷售員',
			content: 'url:../settings/saler_batch',
			data:{isDelete:2},
			lock: true,
			ok: function(){
				Business.setFilterData(this.content, $input);
			},
			cancel: function(){
				return true;
			}
		});
	});
};

//將彈窗中返回的數據記錄到相應的input中
Business.setFilterData = function(dialogCtn, $input){
	var numbers = [];
	var ids = [];
	for(rowid in dialogCtn.addList){
		var row = dialogCtn.addList[rowid];
		ids.push(rowid);
		numbers.push(row.number || row.locationNo || row.serNum);
	}
	$input.data('ids', ids.join(',')).val(numbers.join(','));
};

Business.setFilterGoods = function(dialogCtn, $input){
	var numbers = [];
	var ids = [];
	for(rowid in dialogCtn.addList){
		var row = dialogCtn.addList[rowid];
		ids.push(rowid);
		numbers.push(row.number || row.locationNo);
	}
	$input.data('ids', ids.join(',')).val(numbers.join(','));
};

Business.moreFilterEvent = function(){
	$('#conditions-trigger').on('click', function(e){
		e.preventDefault();
	  if (!$(this).hasClass('conditions-expand')) {
		  $('#more-conditions').stop().slideDown(200, function(){
			   $('#conditions-trigger').addClass('conditions-expand').html('收起更多<b></b>');
			   $('#filter-reset').css('display', 'inline');
		  });
	  } else {
		  $('#more-conditions').stop().slideUp(200, function(){
			  $('#conditions-trigger').removeClass('conditions-expand').html('更多條件<b></b>');
			  $('#filter-reset').css('display', 'none');
		  });
	  };
	});
};

Business.gridEvent = function(){
	$('.grid-wrap').on('mouseenter', '.list tbody tr', function(e){
		$(this).addClass('tr-hover');
		if($_curTr) {
			$_curTr.removeClass('tr-hover');
			$_curTr = null;
		}
	}).on('mouseleave', '.list tbody tr', function(e){
		$(this).removeClass('tr-hover');
	});
};

//判斷:目前元素是否是被篩選元素的子元素
$.fn.isChildOf = function(b){
    return (this.parents(b).length > 0);
};

//判斷:目前元素是否是被篩選元素的子元素或者本身
$.fn.isChildAndSelfOf = function(b){
    return (this.closest(b).length > 0);
};

//數字輸入框
$.fn.digital = function() {
	this.each(function(){
		$(this).keyup(function() {
			this.value = this.value.replace(/\D/g,'');
		})
	});
};

/** 
 1. 設定cookie的值，把name變數的值設為value   
example $.cookie(』name』, 『value』);
 2.新建一個cookie 包括有效期 路徑 域名等
example $.cookie(』name』, 『value』, {expires: 7, path: 『/』, domain: 『jquery.com』, secure: true});
3.新建cookie
example $.cookie(』name』, 『value』);
4.刪除一個cookie
example $.cookie(』name』, null);
5.取一個cookie(name)值給myvar
var account= $.cookie('name');
**/
$.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        var path = options.path ? '; path=' + options.path : '';
        var domain = options.domain ? '; domain=' + options.domain : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
Public.print = function (opt){
	var voucherIds = opt.$grid.jqGrid('getGridParam','selarrrow').join();
	var pdfUrl = opt.pdf;
	var sidx = opt.$grid.jqGrid('getGridParam','sortname');
	var sord = opt.$grid.jqGrid('getGridParam','sortorder');
	var billType = opt.billType;
	var data = {
		sidx: sidx,
		sord: sord,
		op: 2
	};
	if(opt.filterConditions){
		data = $.extend(true, data, opt.filterConditions);
	};
	if(voucherIds) {
		data.id = voucherIds;
	};
	$.dialog({
		title: opt.title,
		content : 'url:../prints/print_settings_voucher',
		data: {taodaData: data, pdfData: data, pdfUrl: pdfUrl, billType:billType ,opt:opt},
		width: 520,
		height: 400,
		min: false,
		max: false,
		lock: true,
		ok: function(){
			this.content.doPrint();
			return false;
		},
		okVal: '列印',
		cancel: true
	});
};
//產生樹
Public.zTree = {
    zTree: {},
    opts:{
    	showRoot:true,
    	defaultClass:'',
    	disExpandAll:false,//showRoot為true時無效
    	callback:'',
    	rootTxt:'全部'
    },
    setting: {
        view: {
            dblClickExpand: false,
            showLine: true,
            selectedMulti: false
        },
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parentId",
                rootPId: ""
            }
        },
        callback: {
            //beforeClick: function(treeId, treeNode) {}
        }
    },
    _getTemplate: function(opts) {
    	this.id = 'tree'+parseInt(Math.random()*10000);
        var _defaultClass = "ztree";
        if (opts) {
            if(opts.defaultClass){
                _defaultClass += ' ' + opts.defaultClass;
            }
        }
        return '<ul id="'+this.id+'" class="' + _defaultClass + '"></ul>';
    },
    init: function($target, opts, setting ,callback) {
        if ($target.length === 0) {
            return;
        }
        var self = this;
        self.opts = $.extend(true, self.opts, opts);
        self.container = $($target);
        self.obj = $(self._getTemplate(opts)); 
        self.container.append(self.obj);
        setting = $.extend(true, self.setting, setting);
        Public.ajaxPost(opts.url || '../basedata/assist?action=list&typeNumber=trade&isDelete=2', {}, function(data) {
            if (data.status === 200 && data.data) {
            	self._callback(data.data.items);
            } else {
            	Public.tips({
                    type: 2,
                    content: "載入失敗！"
                });
            }
        });
        return self;
    },
    _callback: function(data){
    	var self = this;
    	var callback = self.opts.callback;
    	if(self.opts.showRoot){
    		data.unshift({name:self.opts.rootTxt,id:0});
        	self.obj.addClass('showRoot');
    	}
    	if(!data.length) return;
    	self.zTree = $.fn.zTree.init(self.obj, self.setting, data);
    	//self.zTree.selectNode(self.zTree.getNodeByParam("id", 101));
    	self.zTree.expandAll(!self.opts.disExpandAll);
    	if(callback && typeof callback === 'function'){
    		callback(self, data);
    	}
    }
};
//分類下拉框
Public.categoryTree = function($obj, opts) {
	if ($obj.length === 0) {
        return;
    }
	opts = opts ? opts : opts = {};
	var opts = $.extend(true, {
		inputWidth:'145',
		width:'',//'auto' or int
		height:'240',//'auto' or int
		trigger:true,
		defaultClass:'ztreeCombo',
		disExpandAll:false,//展開全部
		defaultSelectValue:0,
		showRoot:true,//顯示root選擇
		rootTxt:'全部',
		treeSettings : {
			callback:{
				beforeClick: function(treeId, treeNode) {
					if(_Combo.obj){
						_Combo.obj.val(treeNode.name);
						_Combo.obj.data('id', treeNode.id);
						_Combo.hideTree();
					}
				}
			}
		}
	}, opts);
	var _Combo = {
		container:$('<span class="ui-tree-wrap" style="width:'+opts.inputWidth+'px"></span>'),
		obj : $('<input type="text" class="input-txt" style="width:'+(opts.inputWidth-26)+'px" id="'+$obj.attr('id')+'" autocomplete="off" readonly value="'+($obj.val()||$obj.text())+'">'),
		trigger : $('<span class="trigger"></span>'),
		data:{},
		init : function(){
			var _parent = $obj.parent();
			var _this = this;
			$obj.remove();
			this.obj.appendTo(this.container);
			if(opts.trigger){
				this.container.append(this.trigger);
			}
			this.container.appendTo(_parent);
			opts.callback = function(publicTree ,data){
				_this.zTree = publicTree;
				//_this.data = data;
				if(publicTree){
					publicTree.obj.css({
						'max-height' : opts.height
					});
					for ( var i = 0, len = data.length; i < len; i++){
						_this.data[data[i].id] = data[i];
					};
					if(opts.defaultSelectValue !== ''){
						_this.selectByValue(opts.defaultSelectValue);
					};
					_this._eventInit();
				}
			};
			this.zTree = Public.zTree.init($('body'), opts , opts.treeSettings);
			return this;
		},
		showTree:function(){
			if(!this.zTree)return;
			if(this.zTree){
				var offset = this.obj.offset();
				var topDiff = this.obj.outerHeight();
				var w = opts.width? opts.width : this.obj.width();
				var _o = this.zTree.obj.hide();
				_o.css({width:w, top:offset.top + topDiff,left:offset.left-1});
			}
			var _o = this.zTree.obj.show();
			this.isShow = true;
			this.container.addClass('ui-tree-active');
		},
		hideTree:function(){
			if(!this.zTree)return;
			var _o = this.zTree.obj.hide();
			this.isShow = false;
			this.container.removeClass('ui-tree-active');
		},
		_eventInit: function(){
			var _this = this;
			if(opts.trigger){
				_this.trigger.on('click',function(e){
					e.stopPropagation();
					if(_this.zTree && !_this.isShow){
						_this.showTree();
					}else{
						_this.hideTree();
					}
				});
			};
			_this.obj.on('click',function(e){
				e.stopPropagation();
				if(_this.zTree && !_this.isShow){
					_this.showTree();
				}else{
					_this.hideTree();
				}
			});
			if(_this.zTree){
				_this.zTree.obj.on('click',function(e){
					e.stopPropagation();
				});
			}
			$(document).click(function(){
				_this.hideTree();
			});
		},
		getValue:function(){
			var id = this.obj.data('id') || '';
			if(!id){
				var text = this.obj.val();
				if(this.data){
					for(var item in this.data){
						if(this.data[item].name === text){
							id = this.data[item].id;
						}
					}
				}
			}
			return id;
		},
		getText:function(){
			if(this.obj.data('id'))
				return this.obj.val();
			return '';
		},
		selectByValue:function(value){
			if(value !== ''){
				if(this.data){
					this.obj.data('id', value);
					this.obj.val(this.data[value].name);
				}
			}
			return this;
		}
	};
	return _Combo.init();
};
/*
 * 分類新增彈窗
 * 不支援多級結構（樹）
 * type string 分類型別
 * parentWin object 父視窗對像,決定彈窗的覆蓋範圍，預設目前視窗的parent
 */
Public.categoryPop = function(type,targetWin,callback){ 
	var defaultPage = Public.getDefaultPage();
	var self = {
			init:function(){
				var myParent = targetWin || parent;
				var showParentCategory = false;
				var content = $(['<form id="manage-form" action="" style="width: 282px;">',
				               '<ul class="mod-form-rows manage-wrap" id="manager">',
						           '<li class="row-item">',
						               '<div class="label-wrap"><label for="category">類別:</label></div>',
						               '<div class="ctn-wrap"><input type="text" value="" class="ui-input" name="category" id="category" style="width:190px;"></div>',
						           '</li>',
						       '</ul>',
					       '</form>'].join(''));
				var height = 90;
				var dialog = myParent.$.dialog({
					title : '新增類別',
					content : content,
					//data: data,
					width : 400,
					height : height,
					max : false,
					min : false,
					cache : false,
					lock: true,
					okVal:'確定',
					ok:function(){
						var	category = $.trim(content.find('#category').val());
						if(!category){
							defaultPage.Public.tips({content : '請輸入類別名稱！'});
							category.focus();
							return false;
						}
						var oper = 'add'; 
						var params = { name: category ,typeNumber: type};
						var msg = '新增類別';
						Public.ajaxPost('../basedata/assist/' + oper, params, function(data){
							if (data.status == 200) {
								defaultPage.Public.tips({content : msg + '成功！'});
								defaultPage.SYSTEM.categoryInfo[type].push(data.data);
								if(typeof callback ==='function'){
									callback(data.data,dialog);
								}
							} else {
								defaultPage.Public.tips({type:1, content : msg + '失敗！' + data.msg});
							}
						});
						return false;
					},
					cancelVal:'取消',
					cancel:function(){
						return true;
					}
				});
			}
	};
	self.init();
};
/*
 * 相容IE8 陣列對像不支援indexOf()
 * create by guoliang_zou ,20140812
 */
if (!Array.prototype.indexOf)
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length >>> 0;
    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;
    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}
$(function(){
	//菜單按鈕
	$('.ui-btn-menu .menu-btn').on('mouseenter.menuEvent',function(e){
		if($(this).hasClass("ui-btn-dis")) {
			return false;
		}
		$(this).parent().addClass('ui-btn-menu-cur');
		$(this).blur();
		e.preventDefault();
	});

	$(document).on('click.menu',function(e){
		var target  = e.target || e.srcElement;
		$('.ui-btn-menu').each(function(){
			var menu = $(this);
			if($(target).closest(menu).length == 0 && $('.con',menu).is(':visible')){
				 menu.removeClass('ui-btn-menu-cur');
			}
		})
	});

	/**
	 * 頁面配置模組
	 * @param  {string}  id               頁面ID ，標識
	 * @return {[type]}                   [description]
	 */
	Public.mod_PageConfig = (function(mod) {
		var	inited = false,//模組啟動開關
		defaultPage = Public.getDefaultPage(),
		SYSTEM = defaultPage.SYSTEM,
		conf;//目前頁配置

		mod.init = function(id){
			inited = true;
			mod.pageId = id;
			SYSTEM.pageConfigInfo = SYSTEM.pageConfigInfo || {};
			SYSTEM.pageConfigInfo[''+ id] = SYSTEM.pageConfigInfo[''+ id] || {};
			conf = SYSTEM.pageConfigInfo[''+ id];
			_eventReg();//頁面事件註冊
			mod.gridReg = _gridReg;
			mod.conf = conf;
			mod.config = _config;
			mod.updatePageConfig = _updatePageConfig;
			mod.setGridWidthByIndex = _setGridWidthByIndex;
			return mod;
		};
		function _config(){
			var content = [
				'<div class="content">',
					'<ul class="c_wrapper" id="c_wrapper">',
					'</ul>',
				'</div>'
			];
			$.dialog({
				title: '頁面配置',
				content: content.join(''),
				width: 500,
				height: 300,
				lock:true,
				init: function (){
					var $_tab = $('<ul class="ui-tab" id="c_tab" style="border-bottom: 1px solid #EBEBEB;  position: relative;  top: -10px;  left: -10px;  margin-right: -20px;"></ul>');
					var $_wrapper = $('#c_wrapper');
					for(var gridId in conf.grids){
						var conf_grid = conf.grids[gridId] || {};
						if(typeof conf.grids[gridId] != 'function' && conf_grid.isReg){
							var $grid = $('#' + gridId);
							var configGridId = 'c_'+gridId;
							var _caption = conf_grid.caption ? '（'+conf_grid.caption+'）' : '';
							$_tab.append('<li style="border-top: none;  border-bottom: none;  border-color: #EBEBEB;">表格'+_caption+'</li>');
							$_wrapper.append([
								'<li class="grid-wrap dn">',
							      '<table id="'+configGridId+'">',
							      '</table>',
							    '</li>'
							].join(''));
							var dataArr = conf_grid.colModel;//快取里的配置資訊
							var _dataArr=[];
							for (var i = 0; i < dataArr.length; i++) {
								var col = dataArr[i];
								if(!col)continue;
								if($.trim(col['label']) && !col.defhidden && !col.disConfigured){
									_dataArr.push(col);
								}
							};
							var $configGrid = $('#'+configGridId);
							$configGrid.jqGrid({
								data:_dataArr,
								datatype: "clientSide",
								width:480,
								// autowidth:true,
								height: 290,
								rownumbers: true,
								gridview: true,
								onselectrow: false,
								idPrefix: 'c_gridId_',	//表格id字首
								colModel: [
									{name:'name', label:'列名' ,hidden: true},
									{name:'defLabel', label:'列名稱' , width:100},
									{name:'label', label:'列名稱' , width:100 ,hidden:true},
									{name:'aname', label:'別名' , width:100 , editable:true ,formatter:function(val ,opts, row){
										if(!val){
											val = row['label'];
										}
										return val;
									}},
									{name:'hidden', label:'是否顯示' , width:50, align:'center', formatter:function(val ,opts, row){
										var text = val == true ? '已隱藏' : '已顯示';
										var cls = val == true ? 'ui-label-default' : 'ui-label-success';
										return '<span class="set-status ui-label ' + cls + '" data-delete="' + val + '" data-id="' + row.id + '">' + text + '</span>';
									}}
								],
								shrinkToFit: true,
								forceFit: true,
								cellEdit: true,
								cellsubmit: 'clientArray',
								afterSaveCell: function(rowid,name,val,iRow,iCol) {
									switch(name){
										case 'aname': 
										if(!$.trim(val)) {
											defaultPage.Public.tips({type:2 , content:'請輸入別名！'});
											return;
										}else{
											var rowData = $configGrid.jqGrid('getRowData',rowid);
											$grid.jqGrid('setColProp',rowData['name'], { label : rowData.aname });
											$configGrid.jqGrid('setRowData',rowid,{ label : rowData.aname });
											var $th = $('#jqgh_'+ $grid[0].id + '_' + rowData['name']);
											$th.html($th.html().replace(rowData['label'], rowData.aname));
											_updatePageConfig($grid[0].id, ['label' ,rowData.name, rowData['aname']]);
											return val;
										}
										break;
									}
								}
							});
							(function($grid, $configGrid){
								$configGrid.on('click', '.set-status', function(event) {
									event.preventDefault();
									/* Act on the event */
									var $this = $(this);
									var id = $this.closest('tr')[0].id;
									var rowData = $configGrid.jqGrid('getRowData',id);
									if($this.hasClass('ui-label-success')){
										_updatePageConfig($grid[0].id,['hidden',rowData.name,true]);
										$configGrid.jqGrid('setCell', id, 'hidden', true);
										$grid.jqGrid('hideCol', rowData['name']);
									}else{
										_updatePageConfig($grid[0].id,['hidden',rowData.name,false]);
										$configGrid.jqGrid('setCell', id, 'hidden', false);
										$grid.jqGrid('showCol', rowData['name']);
									}
								});
							})($grid, $configGrid);
						}
					};
					$('.ui_content').prepend($_tab);
					$_tab.on('click', 'li', function(event) {
						event.preventDefault();
						/* Act on the event */
						var $this = $(this);
						var _index = $this.index();
						$this.addClass('cur').siblings('.cur').removeClass('cur');
						$_wrapper.find('li:eq('+_index+')').show().siblings().hide();
					});
					//第一個tab選中
					$_tab.find('li:eq(0)').addClass('cur');
					$_wrapper.find('li:eq(0)').show();
				},
				button:[
					{name: '恢復預設設定',defClass:'ui_state_highlight fl', callback: function () {
						var thisPop = this;
                        _cancelGridEdit();
						$.dialog.confirm('該操作會重新整理目前頁簽，是否繼續?', function(){
							SYSTEM.pageConfigInfo[''+ mod.pageId] = null;
							_deleteConfig();
							$(window).unbind('unload');
							location.reload();
							thisPop.close();
						})
						return false;
					}},
					{name: '完成', callback: function () {
                        _cancelGridEdit();
				        return true;
					}}
				]
            });
		};
        function _cancelGridEdit(){
            for(var gridId in conf.grids){
                var conf_grid = conf.grids[gridId] || {};
                if(typeof conf.grids[gridId] != 'function' && conf_grid.isReg){
                    var $grid = $('#' + gridId);
                    var configGridId = 'c_'+gridId;
                    var $confGrid = $('#'+configGridId);
                    if($confGrid[0].p.savedRow.length != 0){
                        $confGrid.jqGrid("saveCell", $confGrid[0].p.savedRow[0].id, $confGrid[0].p.savedRow[0].ic);
                    }
                }
            }
        };
		function _updatePageConfig(gridId, prop){
			//爲了區分使用者修改，必須精確到每個欄位的每個屬性 prop = [propName, colName, propValue];
			if(!conf.grids || !conf.grids[gridId] || !conf.grids[gridId].isReg || !prop || prop.length != 3){
				return ;
			}
			prop = {
				propName : prop[0],
				colName : prop[1],
				propValue : prop[2]
			}
			var g = conf.grids[gridId];
			for (var i = 0; i < g.colModel.length; i++) {
				var c1 = g.colModel[i];
				if(c1.name == prop.colName){
					c1[prop.propName] = prop.propValue;
				}
			};
			conf.curTime = Date.parse(new Date());
		};
		function _gridReg(gridId , defColModel, caption){//表格一定要註冊預設配置資訊
			if(!defColModel){
				return;
			}
			conf.grids = conf.grids || {};
			conf.grids[gridId] = conf.grids[gridId] || {};
			var g = conf.grids[gridId];
			g.caption = caption;
			g.defColModel = defColModel;//儲存預設配置，這裡會儲存到伺服器，暫時不遮蔽
			g.colModel = g.colModel || defColModel;
			//將使用者配置合併到預設配置裡面去，使得預設配置可以擴充套件新的欄位
			for (var i = 0; i < defColModel.length; i++) {
				if(!defColModel[i]) continue;
				defColModel[i].defLabel = defColModel[i]['label'];
				defColModel[i].defhidden = defColModel[i].hidden;
				c1 = defColModel[i];
				if(g.colModel){
					for (var j = 0; j < g.colModel.length; j++) {
						var c = g.colModel[j];
						var c2 = {
							 name: c[0] || c['name']
							,label: c[1] || c['label']
							,hidden: c.defhidden ? c1.hidden : (c[2] || c['hidden']) //c有defhidden 就是從快取取的，因為數據庫沒有存def配置，處理因為快取導致重新整理子頁面而把新放開/許可權的欄位給預設隱藏了
							,width: c[3] || c['width']
						};
						if(c1['name'] === c2['name']){
							// c1 = $.extend(true, c1, c2); //這裡不能用這個方法，如果拷貝了裡面的方法會造成頁面執行的方法不一樣
							_modelClone(c1 , c2);
						}
					};
				}
			};
			g.colModel = defColModel;//使用者列配置擴充套件
			g.isReg = true;
		};
		function _modelClone(c1, c2 , propName){
			if(propName){
				c1[propName] = c2[propName];
			}else{
				// $.extend(true, c1, {//開放修改的列屬性
				// 	label: c2['label']//列名
				// 	,hidden: c2['hidden']//顯示與隱藏
				// 	,width: c2['width']//寬度
				// });
				$.extend(true, c1, c2);
			}
			return c1;
		}
		function _eventReg(){
			//列配置
			$(window).on('unload',function(){
				if(conf && conf.curTime && conf.modifyTime != conf.curTime){
					conf.modifyTime = conf.curTime;
					_updateConfig(_formatPostData());
				}
			});
		}
		function _updateConfig(value){
			//defaultPage.Public.tips({type:2, content:'儲存配置中，請稍候...'});
			defaultPage.$.ajax({
				url: '../basedata/userSetting/update?action=update',
				type: 'POST',
				dataType: 'json',
				data: {
					key : mod.pageId,
					value : value
				},
				async:false,//同步執行，防止出現執行不成功的問題
				timeout:3000
			})
			.done(function(data) {
				//console.log("success");
				//defaultPage.Public.tips({type:0, content:'儲存配置成功'});
			})
			.fail(function(data) {
				//console.log("error");
				//defaultPage.Public.tips({type:1, content:'儲存配置失敗！'});
			})
			.always(function() {
				//console.log("complete");
			});
		}
		function _deleteConfig(key){
			defaultPage.$.post('../basedata/userSetting/delete?action=delete',{
				key : mod.pageId
			})//關閉頁面之後回撥函式被釋放，所以這裡不要寫回調函式, ie7下會報錯
		}
		function _formatPostData(){//表格的列配置轉成陣列型別減少數據量
			var _conf = $.extend(true, {}, conf);//克隆conf
			for(var gridId in _conf.grids){
				var g = _conf.grids[gridId];
				if(typeof g != 'function' && g.isReg){
					var colModel = g.colModel;
					var tmpArr = [];
					for (var i = 0; i < colModel.length; i++) {
						var col = colModel[i];
						if(!col)continue;
						tmpArr.push([
							 col['name']//列名,唯一標識
							,col['label']//列名
							,col.defhidden ? null : col['hidden']//顯示與隱藏//預設是隱藏的就不受列配置的顯影控制
							,col['width']//寬度
						])
					};
					g.colModel = tmpArr;
					delete g.defColModel;//刪除克隆對像中的defColModel，這部分沒不要存入數據庫
				}
			}
			return JSON.stringify(_conf);
		}
		function _setGridWidthByIndex(newwidth, index, gridId){
			_updatePageConfig(gridId,['width', conf.grids[gridId].defColModel[index-1]['name'] , newwidth]);
		}
		return mod;
	})(Public.mod_PageConfig || {})
});

/**
 * 省市區
 * 省下拉框ID：provinceCombo
 * 市下拉框ID：cityCombo
 * 區下拉框ID：areaCombo
 * 需要搭配COMBO外掛
 * 預設值放在data('defaultValue')
 */	
var mod_AreasCombo = (function(mod) {
	var	_areasList = [],
		_capable = false,//模組啟動開關
		_provinceList = [],
		_cityList = [], 
		_areasCahe = {},
		_pCombo,_cCombo,_aCombo;

	mod.init = function(_provinceCombo,_cityCombo,_areaCombo ,callback){
		_pCombo = _provinceCombo;
		_cCombo = _cityCombo;
		_aCombo = _areaCombo;
		//快取省市數據
		if(!(_provinceCombo&&_cityCombo&&_areaCombo)){
			return;
		}
		Public.ajaxPost('../statics/js/common/areasData.php', {}, function(data){
			if(data) {
				_capable = true;
				_areasList = data.areas_get_response.areas.area;
				for (i = 0,len = _areasList.length; i < len; i++) {
					if (_areasList[i].type === 2 && _areasList[i].parent_id === 1) {
						_provinceList.push({name:_areasList[i].name,id:_areasList[i].id, type:2, parent_id:1});
					} //中國的省
					if (_areasList[i].type === 3) {
						_cityList.push({name:_areasList[i].name,id:_areasList[i].id,type:_areasList[i].type,parent_id:_areasList[i].parent_id});
					} //中國的市
				}
				mod.provinceCombo = _getCombo( _pCombo,_getProvinceData());
				mod.cityCombo = _getCombo( _cCombo,[]);
				mod.areaCombo = _getCombo( _aCombo,[]);
				//mod.provinceCombo.loadData(_getProvinceData(),-1,false);
				callback();
			} else {
				Public.tips({type: 1, content : '初始化省市區失敗！'});
			}
		});
		return mod;
	};
	function _getCombo(obj,data){
		var _disabled = $(obj).hasClass('disabled');
		return obj.combo({
			data: data,
			text: 'name',
			value: 'id',
			width: 112,
			defaultSelected: -1,
			//addOptions: {text:'', value: -1},
			cache: false,
			editable:true,
			disabled: _disabled,
			callback: {
				onFocus: null,
				onBlur: null,
				beforeChange: null,
				onChange: function(){
					switch(this){
					case mod.provinceCombo :
						mod.cityCombo.loadData(_getCityData(mod.provinceCombo.getValue()),-1,false);
						mod.areaCombo.loadData([],-1,false);
						break;
					case mod.cityCombo :
						mod.areaCombo.loadData(_getAreaData(mod.cityCombo.getValue()),-1,false);
						break;
					case mod.areaCombo :
						break;
					default:break;
					}
				},
				onExpand: null,
				onCollapse: null
			}
		}).getCombo();
	};
	function _getProvinceData (){
		var _data = [];
		for (i = 0,len = _provinceList.length; i < len; i++) {
			if (_provinceList[i].type === 2 && _provinceList[i].parent_id === 1) {
				_data.push({name:_provinceList[i].name,id:_provinceList[i].id});
			} 
		}
		return _data;
	};
	function _getCityData (PID){
		var _data = [];
		for (i = 0,len = _cityList.length; i < len; i++) {
			if (_cityList[i].parent_id === PID) {
				_data.push({name:_cityList[i].name,id:_cityList[i].id});
			} 
		}
		return _data;
	};
	function _getAreaData (PID){
		var _data = [];
		//查詢快取
		if(_areasCahe[PID]){
			_data = _areasCahe[PID].areaData;
		}
		//沒有快取則全表查詢
		else{
			for (i = 0, len = _areasList.length; i < len; i++) {
				if (_areasList[i].type === 4 && _areasList[i].parent_id === PID) {
					_data.push({name:_areasList[i].name,id:_areasList[i].id});
				}
			}
			//快取該次查詢結果
			_areasCahe[PID] ={areaData : _data} ;
		}
		return _data;
	};
	return mod;
})(mod_AreasCombo || {})

/**
 * 報表聯查方法
 * @param  {[type]} params [description] 必填
 * params.transferType 業務型別ID 必填
 * params.id 單據ID 必填
 * params.callback 執行之後的回撥
 * template gotoDetailItem({transferType:'001', id: 1, callback:fn})
 * @return void
 */
Public.gotoDetailItem = function(params){
	if(!params)return;
	if(!params.transferType)return;
	if(!params.id)return;
	var urls = {
		//SALE
		'150601' : {tabid : 'sales-sales',text : '銷貨單',right:'SA_QUERY', url : '../sales/sales.jsp?id='},
		//SALEBACK
		'150602' : {tabid : 'sales-salesBack',text : '銷貨退貨單',right:'SA_QUERY', url : '../sales/sales.jsp?transType=150602&id='},
		//PUR
		'150501' : {tabid : 'purchase-purchase',text : '購貨單',right:'PU_QUERY',url : '../purchase/purchase.jsp?id='},
		//PUR
		'150502' : {tabid : 'purchase-purchaseBack',text : '購貨退貨單',right:'PU_QUERY',url : '../purchase/purchase.jsp?transType=150502&id='},
		//TRANSFER
		'103091' : {tabid : 'storage-transfers',text : '調撥單',right:'TF_QUERY',url : '../storage/transfers.jsp?id='},
		//OO
		'150806' : {tabid : 'storage-otherOutbound',text : '其它出庫 ',right:'OO_QUERY',url : '../storage/other-outbound.jsp?id='},
		//OI
		'150706' : {tabid : 'storage-otherWarehouse',text : '其它入庫 ',right:'IO_QUERY',url : '../storage/other-warehouse.jsp?id='},
		//OO
		'150801' : {tabid : 'storage-otherOutbound',text : '盤虧',right:'OO_QUERY',url : '../storage/other-outbound.jsp?id='},
		//OI
		'150701' : {tabid : 'storage-otherWarehouse',text : '盤盈',right:'IO_QUERY',url : '../storage/other-warehouse.jsp?id='},
		//CADJ
		'150807' : {tabid : 'storage-adjustment',text : '成本調整',right:'CADJ_QUERY',url : '../storage/adjustment.jsp?id='},
		//PAYMENT
		'153101' : {tabid : 'money-payment',text : '付款單',right:'PAYMENT_QUERY',url : '../money/payment.jsp?id='},
		//RECEIPT
		'153001' : {tabid : 'money-receipt',text : '收款單',right:'RECEIPT_QUERY',url : '../money/receipt.jsp?id='},
		//PAYMENT
		'153301' : {tabid : 'storage-assemble',text : '組裝單',right:'ZZD_QUERY',url : '../storage/assemble.jsp?id='},
		//RECEIPT
		'153302' : {tabid : 'storage-disassemble',text : '拆卸單',right:'CXD_QUERY',url : '../storage/disassemble.jsp?id='}
		//VERIFICA //覈銷太噁心了，包含5種單據型別。。。
		//VERIFICA //覈銷太噁心了，包含5種單據型別。。。
		// : {tabid : 'money-verifica',text : '覈銷單 ',right:'VERIFICA_QUERY',url : '/money/verification.jsp?id='}
	};
	var item = urls[params.transferType + ''] ;
	if(item && Business.verifyRight(item.right)){
		parent.tab.addTabItem({
			tabid : item.tabid,
			text : item.text,
			url : item.url + params.id
		});
		typeof params.callback === 'function' && params.callback();
	}
}

