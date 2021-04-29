;(function( $, window, undefined ){

var _ie6 = window.ActiveXObject && !window.XMLHttpRequest,
	_fn = function(){},
	_count = 0,
	_rurl = /^url:/,
	_singleton,
	onKeyDown,
	document = window.document,
	expando = 'JDG' + (+new Date),

dialogTpl =
'<table class="ui_border">' +
	'<tbody>' +
		'<tr>' +
			'<td class="ui_lt"></td>' +
			'<td class="ui_t"></td>' +
			'<td class="ui_rt"></td>' +
		'</tr>' +
		'<tr>' +
			'<td class="ui_l"></td>' +
			'<td class="ui_c">' +
				'<div class="ui_inner">' +
				'<table class="ui_dialog">' +
					'<tbody>' +
						'<tr>' +
							'<td colspan="2">' +
								'<div class="ui_title_bar">' +
									'<div class="ui_title" unselectable="on"></div>' +
									'<div class="ui_title_buttons">' +
										'<a class="ui_min" href="javascript:void(0);" title="\u6700\u5C0F\u5316"><b class="ui_min_b"></b></a>' +
										'<a class="ui_max" href="javascript:void(0);" title="\u6700\u5927\u5316"><b class="ui_max_b"></b></a>' +
										'<a class="ui_res" href="javascript:void(0);" title="\u8FD8\u539F"><b class="ui_res_b"></b><b class="ui_res_t"></b></a>' +
										'<a class="ui_close" href="javascript:void(0);" title="\u5173\u95ED(esc\u952E)">\xd7</a>' +
									'</div>' +
								'</div>' +
							'</td>' +
						'</tr>' +
						'<tr>' +
							'<td class="ui_icon"></td>' +
							'<td class="ui_main">' +
								'<div class="ui_content"></div>' +
							'</td>' +
						'</tr>' +
						'<tr>' +
							'<td colspan="2">' +
								'<div class="ui_buttons"></div>' +
							'</td>' +
						'</tr>' +
					'</tbody>' +
				'</table>' +
				'</div>' +
			'</td>' +
			'<td class="ui_r"></td>' +
		'</tr>' +
		'<tr>' +
			'<td class="ui_lb"></td>' +
			'<td class="ui_b"></td>' +
			'<td class="ui_rb"></td>' +
		'</tr>' +
	'</tbody>' +
'</table>',
	
/*!
 * _path 獲取元件核心檔案lhgdialog.js所在的絕對路徑
 * _args 獲取lhgdialog.js檔案后的url參數組，如：lhgdialog.js?self=true&skin=aero中的?後面的內容
 */
_args, _path = (function( script, i, me )
{
    var l = script.length;
	
	for( ; i < l; i++ )
	{
		me = !!document.querySelector ?
		    script[i].src : script[i].getAttribute('src',4);
		
		if( me.substr(me.lastIndexOf('/')).indexOf('jquery.dialog') !== -1 )
		    break;
	}
	
	me = me.split('?'); _args = me[1];
	
	return me[0].substr( 0, me[0].lastIndexOf('/') + 1 );
})(document.getElementsByTagName('script'),0),        

/*!
 * 獲取url參數值函式
 * @param  {String}
 * @return {String||null}
 * @demo lhgdialog.js?skin=aero | _getArgs('skin') => 'aero'
 */
_getArgs = function( name )
{
    if( _args )
	{
	    var p = _args.split('&'), i = 0, l = p.length, a;
		for( ; i < l; i++ )
		{
		    a = p[i].split('=');
			if( name === a[0] ) return a[1];
		}
	}
	return null;
},

/*! 取面板樣式名，預設為 default */
_skin = _getArgs('skin') || 'default',

/*! 獲取 lhgdialog 可跨級呼叫的最高層的 window 對像和 document 對像 */
_doc, _top = (function(w)
{
	try{
	    _doc = w['top'].document;  // 跨域|無許可權
		_doc.getElementsByTagName; // chrome 瀏覽器本地安全限制
	}catch(e){
	    _doc = w.document; return w;
	};
	
	// 如果指定參數self為true則不跨框架彈出，或為框架集則無法顯示第三方元素
	if( _getArgs('self') === 'true' ||
	    _doc.getElementsByTagName('frameset').length > 0 )
	{
	    _doc = w.document; return w;
	}
	
	return w['top'];
})(window),

_root = _doc.documentElement, _doctype = _doc.compatMode === 'BackCompat';

_$doc = $(_doc), _$top = $(_top), _$html = $(_doc.getElementsByTagName('html')[0]);

/*! 開啟IE6 CSS背景圖片快取 */
try{
	_doc.execCommand( 'BackgroundImageCache', false, true );
}catch(e){};

/*! 在最頂層頁面新增樣式檔案 */
/*(function(style){
	if(!style)
	{
	    var head = _doc.getElementsByTagName('head')[0],
		    link = _doc.createElement('link');
			
		link.href = _path + 'skins/' + _skin + '.css';
	    link.rel = 'stylesheet';
		link.id = 'lhgdialoglink';
		head.insertBefore(link, head.firstChild);
	}
})(_doc.getElementById('lhgdialoglink'));*/

/*!
 * IE6下Fixed無抖動靜止定位
 * 如果你的頁面的html元素設定了背景圖片請把設定背景圖片的css寫到body元素上
 * 如果你不需要元件靜止定位（也就是隨屏滾動）或此段程式碼影響了你的頁面佈局可將此段程式碼刪除
 */
_ie6 && (function(bg){
	if( _$html.css(bg) !== 'fixed' )
	{
		_$html.css({
			zoom: 1,// 避免偶爾出現body背景圖片異常的情況
			backgroundImage: 'url(about:blank)',
			backgroundAttachment: 'fixed'
		});
	}
})('backgroundAttachment');

/*!----------------------------------以下為lhgdialog核心程式碼部分----------------------------------*/

var lhgdialog = function( config )
{
	config = config || {};
	
	var api, setting = lhgdialog.setting;
		
	// 合併預設配置
	for( var i in setting )
	{
		if( config[i] === undefined ) config[i] = setting[i];
	}
	
	config.id = config.id || expando + _count;
	
	// 如果定義了id參數則返回存在此id的視窗對像
	api = lhgdialog.list[config.id];
	if(api) return api.zindex().focus();
	
	// 按鈕佇列
	config.button = config.button || [];
	
	config.ok &&
	config.button.push({
	    id: 'ok',
		name: config.okVal,
		callback: config.ok,
		focus: config.focus
	});
	
	config.cancel &&
	config.button.push({
	    id: 'cancel',
		name: config.cancelVal,
		callback: config.cancel
	});
	
	// zIndex全域性配置
	lhgdialog.setting.zIndex = config.zIndex;
	
	_count++;
	
	return lhgdialog.list[config.id] = _singleton ?
	    _singleton._init(config) : new lhgdialog.fn._init( config );
};

lhgdialog.fn = lhgdialog.prototype =
{
    constructor: lhgdialog,
	
	_init: function( config )
	{
	    var that = this, DOM,
		    content = config.content,
			isIfr = _rurl.test(content);
			
		that.opener = window;
		that.config = config;
		
		that.DOM = DOM = that.DOM || that._getDOM();
		that.closed = false;
		that.data = config.data;
		
		// 假如提示性圖示為真預設不顯示最小化和最大化按鈕
		if( config.icon && !isIfr )
		{
		    config.min = false;
			config.max = false;
			
			DOM.icon[0].style.display = '';
			DOM.icon[0].innerHTML = '<img src="../../statics/css/base/dialog/icons/' + config.icon + '" class="ui_icon_bg"/>';
		}
		else
		    DOM.icon[0].style.display = 'none';

		DOM.wrap.addClass( config.skin ); // 多面板共存
		DOM.rb[0].style.cursor = config.resize ? 'se-resize' : 'auto';
		DOM.title[0].style.cursor = config.drag ? 'move' : 'auto';
		DOM.max[0].style.display = config.max ? 'inline-block' : 'none';
		DOM.min[0].style.display = config.min ? 'inline-block' : 'none';
		DOM.close[0].style.display = config.cancel === false ? 'none' : 'inline-block'; //當cancel參數為false時隱藏關閉按鈕
		DOM.content[0].style.padding = config.padding;
		
		that.button.apply( that, config.button );
		
		that.title( config.title )
		.content( content, true, isIfr )
		.size( config.width, config.height )
		.position( config.left, config.top )
		.time( config.time )
		[config.show?'show':'hide'](true).zindex();
		
		config.focus && that.focus();
		config.lock && that.lock();
		that._ie6PngFix()._addEvent();
		
		_singleton = null;
		
		// 假如載入的是單獨頁面的內容頁config.init函式會在內容頁載入完成後執行，這裡就不執行了
		if( !isIfr && config.init )
		    config.init.call( that, window );
		
		return that;
	},
	
	/**
	 * 自定義按鈕
	 * @example
		button({
			name: 'login',
			callback: function(){},
			disabled: false,
			focus: true,
			defClass:''
		}, .., ..)
	 */
	button: function()
	{
	    var that = this, DOM = that.DOM,
		    buttons = DOM.buttons[0],
			focusButton = 'ui_state_highlight',
			listeners = that._listeners = that._listeners || {},
			ags = [].slice.call(arguments),
			i = 0, item, value, id, isNewButton, button;
			
		for( ; i < ags.length; i++ )
		{
		    item = ags[i];
			
			value = item.name;
			id = item.id || value;
			isNewButton = !listeners[id];
			button = !isNewButton ? listeners[id].elem : _doc.createElement('input');
			
			button.type = 'button';
			
            if( !listeners[id] )
                listeners[id] = {};
				
			if( value )
			    button.value = value;
			
			if( item.callback )
			    listeners[id].callback = item.callback;
				
			if( item.focus )
			{
			    that._focus && that._focus.removeClass(focusButton);
				that._focus = $(button).addClass(focusButton);
				that.focus();
			}
			
			if(item.defClass){
				$(button).addClass(item.defClass);
			}
			
			button[expando + 'callback'] = id;
			button.disabled = !!item.disabled;
			
			if( isNewButton )
			{
			    listeners[id].elem = button;
			    if(i + 1 < ags.length){
			    	//判斷後一個按鈕是否是新按鈕，不是新的則
			    	var _item  = ags[i+1];
			    	var _value = _item.name;
					var _id = _item.id || _value;
					var _isNewButton = !listeners[_id];
					if(!_isNewButton){
						$(listeners[_id].elem).before(button);
					}else{
						buttons.appendChild(button);
					}
			    }else{
			    	buttons.appendChild(button);
			    }
			    //buttons.appendChild(button);
			}
		}
		
		buttons.style.display = ags.length ? '' : 'none';
		that._ie6SelectFix();
		
		return that;
	},
	
	/**
	 * 設定標題
	 * @param	{String, Boolean}	標題內容. 為false則隱藏標題欄
	 * @return	{this}	如果無參數則返回對像本身
	 */
	title: function( text )
	{
		if( text === undefined ) return this;
		
		var DOM = this.DOM,
			border = DOM.border,
			title = DOM.title[0];
			
		if( text === false )
		{
			title.style.display = 'none';
			title.innerHTML = '';
			border.addClass('ui_state_tips');
		}
		else
		{
			title.style.display = '';
			title.innerHTML = text;
			border.removeClass('ui_state_tips');
		};
		
		return this;
	},
	
	/*!
	 * 設定內容
	 * @param	{String}	內容 (如果內容前3個字元為『url:』就載入單獨頁面的內容頁)
	 * @param   {Boolean}   是否為后增加的內容
	 * @param   {Boolean}   是否使用iframe方式載入內容頁
	 * @return	{this}		如果無參數則返回對像本身
	 */
	content: function( msg, add, frm )
	{
	    if( msg === undefined ) return this;
		
		var that = this, DOM = that.DOM,
		    wrap = DOM.wrap[0],
			width = wrap.offsetWidth,
			height = wrap.offsetHeight,
			left = parseInt(wrap.style.left),
			top = parseInt(wrap.style.top),
			cssWidth = wrap.style.width,
			$content = DOM.content,
			loading = lhgdialog.setting.content;
		
		    // 假如內容中前3個字元為'url:'就載入相對路徑的單獨頁面的內容頁
		if( frm )
		{
			$content[0].innerHTML = loading;
			that._iframe( msg.split('url:')[1] );
		}
		else
			$content.html( msg );
		
		// 新增內容后調整位置
		if( !add )
		{
			width = wrap.offsetWidth - width;
			height = wrap.offsetHeight - height;
			left = left - width / 2;
			top = top - height / 2;
			wrap.style.left = Math.max(left, 0) + 'px';
			wrap.style.top = Math.max(top, 0) + 'px';
			
			if( cssWidth && cssWidth !== 'auto' )
				wrap.style.width = wrap.offsetWidth + 'px';
			
			that._autoPositionType();
		}
		
		that._ie6SelectFix();
		
		return that;
	},
	
	/**
	 *	尺寸
	 *	@param	{Number, String}	寬度
	 *	@param	{Number, String}	高度
	 */
	size: function( width, height )
	{
		var that = this, DOM = that.DOM,
			wrap = DOM.wrap[0],
			style = DOM.main[0].style;
		
		wrap.style.width = 'auto';
		
		if( typeof width === 'number' )
		    width = width + 'px';
		
		if( typeof height === 'number' )
		    height = height + 'px';
		if(width != 'auto'){
			wrap.style.width = (Number(width.replace('px','')) + 4) + 'px';//去掉框架的border
		}
		style.width = width;
		style.height = height;
		
		if( width !== 'auto' )  // 防止未定義寬度的表格遇到瀏覽器右邊邊界伸縮
		    wrap.style.width = wrap.offsetWidth + 'px';
		
		that._ie6SelectFix();
		
		return that;
	},
	
	/**
	 * 位置(相對於可視區域)
	 * @param	{Number, String}
	 * @param	{Number, String}
	 */
	position: function( left, top )
	{
		var that = this,
			config = that.config,
			wrap = that.DOM.wrap[0],
			style = wrap.style,
			isFixed = _ie6 ? false : config.fixed,
			ie6Fixed = _ie6 && config.fixed,
			docLeft = _$top.scrollLeft(),
			docTop = _$top.scrollTop(),
			dl = isFixed ? 0 : docLeft,
			dt = isFixed ? 0 : docTop,
			ww = _$top.width(),
			wh = _$top.height(),
			ow = wrap.offsetWidth,
			oh = wrap.offsetHeight;
		
        if( left || left === 0 )
		{
			that._left = left.toString().indexOf('%') !== -1 ? left : null;
			left = that._toNumber(left, ww - ow);
			
			if( typeof left === 'number' )
			{
				left = ie6Fixed ? (left += docLeft) : left + dl;
				left = Math.max(left,dl) + 'px';
			}
			
			style.left = left;
		}
		
		if( top || top === 0 )
		{
			that._top = top.toString().indexOf('%') !== -1 ? top : null;
			top = that._toNumber(top, wh - oh);
			
			if( typeof top === 'number' )
			{
				top = ie6Fixed ? (top += docTop) : top + dt;
				top = Math.max(top,dt) + 'px';
			}
			
			style.top = top;
		}
		
		if( left !== undefined && top !== undefined )
		    that._autoPositionType();
		
		return that;
	},
	
	/*!
	 * 定時關閉
	 * @param	{Number}	單位為秒, 無參數則停止計時器
	 * @param   {Function}  關閉視窗前執行的回撥函式
	 */
	time: function( second, callback )
	{
		var that = this,
			timer = that._timer;
			
		timer && clearTimeout(timer);
		callback && callback.call(that);
		
		if(second)
		{
			that._timer = setTimeout(function(){
				that._click('cancel');
			}, 1000 * second);
		}
		
		return that;
	},
	
	/*! 顯示對話方塊 */
	show: function( args )
	{
		this.DOM.wrap[0].style.visibility = 'visible';
		this.DOM.border.addClass('ui_state_visible');
		
		if( !args && this._lock )
		    $('#ldg_lockmask',_doc)[0].style.display = '';
			
		return this;
	},
	
	/*! 隱藏對話方塊 */
	hide: function( args )
	{
		this.DOM.wrap[0].style.visibility = 'hidden';
		this.DOM.border.removeClass('ui_state_visible');
		
		if( !args && this._lock )
		    $('#ldg_lockmask',_doc)[0].style.display = 'none';
			
		return this;
	},
	
	/*! 置頂對話方塊 */
	zindex: function()
	{
		var that = this, DOM = that.DOM,
		    load = that._load,
			top = lhgdialog.focus,
			index = lhgdialog.setting.zIndex++;
		
		// 設定疊加高度
		DOM.wrap[0].style.zIndex = index;
		
		// 設定最高層的樣式
		top && top.DOM.border.removeClass('ui_state_focus');
		lhgdialog.focus = that;
		DOM.border.addClass('ui_state_focus');
		
		// 擴充套件視窗置頂功能，只用在iframe方式載入內容
		// 或跨域載入內容頁時點視窗內容主體部分置頂視窗
		if( load && load.style.zIndex )
		    load.style.display = 'none';
		if( top && top !== that && top.iframe )
		    top._load.style.display = '';
		
		return that;
	},
	
	/*! 設定焦點 */
	focus: function()
	{
	    try{
		    elemFocus = this._focus && this._focus[0] || this.DOM.close[0];
			elemFocus && elemFocus.focus();
		}catch(e){};
		
		return this;
	},
	
	/*! 鎖屏 */
	lock: function()
	{
		var that = this, frm,
		    index = lhgdialog.setting.zIndex - 1,
			config = that.config,
			mask = $('#ldg_lockmask',_doc)[0],
			style = mask ? mask.style : '',
			positionType = _ie6 ? 'absolute' : 'fixed';
		
		if( !mask )
		{
			frm = '<iframe src="javascript:\'\'" style="width:100%;height:100%;position:absolute;' +
			    'top:0;left:0;z-index:-1;filter:alpha(opacity=0)"></iframe>';
				
			mask = _doc.createElement('div');
			mask.id = 'ldg_lockmask';
			mask.onselectstart = function(){
				return false
			};//解決雙擊選中元素后的影響
			mask.style.cssText = 'position:' + positionType + ';left:0;top:0;width:100%;height:100%;overflow:hidden;';
			
			style = mask.style;
			if( _ie6 ) mask.innerHTML = frm;
			
			_doc.body.appendChild( mask );

		}
		
		if( positionType === 'absolute' )
		{
		    style.width = _$top.width();
			style.height = _$top.height();
			style.top = _$top.scrollTop();
			style.left = _$top.scrollLeft();
			
			that._setFixed( mask );
		}

		style.zIndex = index;
		style.display = '';
		
		that.zindex();
		that.DOM.border.addClass('ui_state_lock');
		
		that._lock = true;
			
		return that;
	},
	
	/*! 解除鎖屏 */
	unlock: function()
	{
		var that = this,
		    config = that.config,
			mask = $('#ldg_lockmask',_doc)[0];
		
		if( mask && that._lock )
		{
		    // 無限級鎖屏
			if( config.parent && config.parent._lock )
			{
			    var index = config.parent.DOM.wrap[0].style.zIndex;
				mask.style.zIndex = parseInt(index,10) - 1;
			}
			else
			    mask.style.display = 'none';
			
			that.DOM.border.removeClass('ui_state_lock');
		}
		
		that._lock = false;
		
		return that;
	},
	
	/*! 關閉對話方塊 */
	close: function()
	{
		var that = this, DOM = that.DOM,
			wrap = DOM.wrap,
			list = lhgdialog.list,
			fn = that.config.close;
		
		that.time();
		
		// 當使用iframe方式載入內容頁時的處理程式碼
		if( that.iframe )
		{
			if( typeof  fn === 'function' && fn.call(that, that.iframe.contentWindow, window) === false )
			    return that;
			
			// 重要！需要重置iframe地址，否則下次出現的對話方塊在IE6、7無法聚焦input
			// IE刪除iframe后，iframe仍然會留在記憶體中出現上述問題，置換src是最容易解決的方法
			$(that.iframe).unbind('load',that._fmLoad).attr('src',"javascript:'';").remove();
			
			DOM.content.removeClass('ui_state_full');
			if( that._frmTimer ) clearTimeout(that._frmTimer);
		}
		else
		{
		    if( typeof fn === 'function' && fn.call(that, window) === false )
			    return that;
		}
		
		that.unlock();
		
		if( that._maxState )
		{
			_$html.removeClass('ui_lock_scroll');
		    DOM.res[0].style.display = 'none';
		}
		
		if( lhgdialog.focus === that ) lhgdialog.focus = null;
		
		that._removeEvent();
		delete list[that.config.id];
		
		// 移除HTMLElement或重用
		if( _singleton )
		    wrap.remove();
		else
		{
		    _singleton = that;
			
			if( that._minState )
			{
				DOM.main[0].style.display = '';
				DOM.buttons[0].style.display = '';
				DOM.dialog[0].style.width = '';
			}
			
			DOM.wrap[0].style.cssText = 'left:0;top:0;';
			DOM.wrap[0].className = '';
		    DOM.border.removeClass('ui_state_focus');
		    DOM.title[0].innerHTML = '';
		    DOM.content.html('');
			DOM.icon[0].innerHTML = '';
		    DOM.buttons[0].innerHTML = '';
			
			that.hide(true)._setAbsolute();
		
		    // 清空除this.DOM之外臨時對象，恢復到初始狀態，以便使用單例模式
		    for( var i in that )
		    {
			    if(that.hasOwnProperty(i) && i !== 'DOM') delete that[i];
		    };
		}
		
		that.closed = true;
		return that;
	},
	
	/*! 最大化視窗 */
	max: function()
	{
		var that = this, maxSize,
		    DOM = that.DOM,
			wrapStyle = DOM.wrap[0].style,
			mainStyle = DOM.main[0].style,
			rbStyle = DOM.rb[0].style,
			titleStyle = DOM.title[0].style,
			config = that.config,
		    top = _$top.scrollTop(),
		    left = _$top.scrollLeft();
		
		if( !that._maxState )
		{
		
			_$html.addClass('ui_lock_scroll');
			
			if( that._minState )
			    that.min();
			
			// 儲存最大化視窗前的狀態
			that._or = {
				t: wrapStyle.top,
				l: wrapStyle.left,
				w: mainStyle.width,
				h: mainStyle.height,
				d: config.drag,
				r: config.resize,
				rc: rbStyle.cursor,
				tc: titleStyle.cursor
			};
			
			wrapStyle.top = top + 'px';
			wrapStyle.left = left + 'px';
			
			maxSize = that._maxSize();
			that.size( maxSize.w, maxSize.h )._setAbsolute();
			
			if( _ie6 && _doctype )
			    wrapStyle.width = _$top.width() + 'px';
			
			config.drag = false;
			config.resize = false;
			rbStyle.cursor = 'auto';
			titleStyle.cursor = 'auto';
			
			DOM.max[0].style.display = 'none';
			DOM.res[0].style.display = 'inline-block';
			
			that._maxState = true;
		}
		else
		{
			_$html.removeClass('ui_lock_scroll');
			
			wrapStyle.top = that._or.t;
			wrapStyle.left = that._or.l;
			that.size( that._or.w, that._or.h )._autoPositionType();
			config.drag = that._or.d;
		    config.resize = that._or.r;
		    rbStyle.cursor = that._or.rc;
		    titleStyle.cursor = that._or.tc;
		
		    DOM.res[0].style.display = 'none';
			DOM.max[0].style.display = 'inline-block';
			
			delete that._or;
			
			that._maxState = false;
		}
		
		return that;
	},
	
	/*! 最小化視窗 */
	min: function()
	{
		var that = this,
		    DOM = that.DOM,
			main = DOM.main[0].style,
			buttons = DOM.buttons[0].style,
			dialog = DOM.dialog[0].style,
			rb = DOM.rb[0].style.cursor,
			resize = that.config.resize;
			
		if( !that._minState )
		{
		    if( that._maxState )
				that.max();
			
			that._minRz = {rzs:resize,btn:buttons.display};
			main.display = 'none';
		    buttons.display = 'none';
		    dialog.width = main.width;
			rb.cursor = 'auto';
			resize = false;
		
		    that._minState = true;
		}
		else
		{
		    main.display = '';
			buttons.display = that._minRz.btn;
			dialog.width = '';
			resize = that._minRz;
			rb.cursor = that._minRz.rzs ? 'se-resize' : 'auto';
			
			delete that._minRz;
			
			that._minState = false;
		}
		
		that._ie6SelectFix();
		
		return that;
	},
	
	/*!
	 * 獲取指定id的視窗對像或視窗中iframe載入的內容頁的window對像
	 * @param {String} 指定的id
	 * @param {String} 是否返回的為指定id的視窗對像
	 *        用數字1來表示真，如果不寫或寫其它為false
	 * @return {Object|null}
	 */
	get: function( id, object )
	{
		if( lhgdialog.list[id] )
		{
			if( object === 1 )
			    return lhgdialog.list[id];
			else
			    return lhgdialog.list[id].content || null;
		}
		
		return null;
	},
	
	/**
	 * 重新整理或跳轉指定頁面
	 * @param	{Object, 指定頁面的window對像}
	 * @param	{String, 要跳轉到的頁面地址}
	 */
	reload: function( win, url, callback )
	{
	    win = win || window;
		
		try{
		    win.location.href = url ? url : win.location.href;
		}
		catch(e){ // 跨域
			url = this.iframe.src;
			$(this.iframe).attr('src', url);
		};
		
		callback && callback.call( this );
		
		return this;
	},
	
	/*!
	 * 設定iframe方式載入內容頁
	 */
	_iframe: function( url )
	{
	    var that = this, iframe, $iframe, iwin, $idoc, $ibody, iWidth, iHeight,
		    $content = that.DOM.content,
			config = that.config,
			loading = that._load = $('.ui_loading',$content[0])[0],
		    initCss = 'position:absolute;left:-9999em;border:none 0;background:transparent',
		    loadCss = 'width:100%;height:100%;border:none 0;';
		
		// 是否允許快取. 預設true
		if( config.cache === false )
		{
			var ts = (new Date).getTime(),
				ret = url.replace(/([?&])_=[^&]*/, '$1_=' + ts );
			url = ret + ((ret === url) ? (/\?/.test(url) ? '&' : '?') + '_=' + ts : '');
		}
			
		iframe = that.iframe = _doc.createElement('iframe');
		iframe.name = config.id;
		iframe.style.cssText = initCss;
		iframe.setAttribute('frameborder', 0, 0);
		
		$iframe = $(iframe);
		$content[0].appendChild( iframe );
		
		// 延遲載入iframe的src屬性，IE6下不延遲載入會出現載入進度條的BUG
		that._frmTimer = setTimeout(function(){
		    $iframe.attr('src', url);
		}, 1);
		
		// iframe中頁面載入完成後執行的函式
		var load = that._fmLoad = function()
		{
			$content.addClass('ui_state_full');
			
			// 增強視窗置頂功能，iframe方式載入內容或跨域載入內容頁時點視窗內容部分置頂視窗
			// 通過使用重置loading層來優雅的完成此功能，在focus方法中有此功能的相關程式碼
			var DOM = that.DOM, ltSize,
			    lt = DOM.lt[0].offsetHeight,
				main = DOM.main[0].style;
				
			loading.style.cssText = 'display:none;position:absolute;background:#FFF;opacity:0;' + 
			    'filter:alpha(opacity=0);z-index:1;width:' + main.width + ';height:' + main.height + ';';
			// 此部分程式碼結束，在拖動改變大小的_dragEvent.onmove方法中還有此功能的相關程式碼
			
			try{
			    iwin = that.content = iframe.contentWindow; // 定義視窗對像content屬性為內容頁的window對像
				$idoc = $(iwin.document);
				$ibody = $(iwin.document.body);
			}catch(e){// 跨域
			    iframe.style.cssText = loadCss;
				return;
			}
			
			// 適應iframe尺寸
			setTimeout(function(){
			    iframe.style.cssText = loadCss;
			},0);// setTimeout: 防止IE6~7對話方塊樣式渲染異常
		
			// 視窗最大化時這裡不用再計算視窗的尺寸和位置了，如果再計算視窗會出現錯位
			if( !that._maxState )
			{
				//相容js在ready之後才顯示的元素的寬高
			    setTimeout(function(){
			    	// 獲取iframe內部尺寸
					iWidth = config.width === 'auto'
					? $idoc.width() + (_ie6 ? 0 : parseInt($ibody.css('marginLeft')))
					: config.width;
					
					iHeight = config.height === 'auto'
					? $idoc.height() : config.height;

			    	that.size( iWidth, iHeight)
			    	.position( config.left, config.top );
			    },1);
			}
			
			// 非跨域時還要對loading層重設大小，要不寬和度都為'auto'
			loading.style.width = main.width;
			loading.style.height = main.height;
			
			config.init && config.init.call( that, iwin, _top );
		};
		
		// 繫結iframe元素api屬性為視窗自身對象，在內容頁中此屬性很重要
		that.iframe.api = that;
		$iframe.bind( 'load', load );
	},
	
	/*! 獲取視窗元素 */
	_getDOM: function()
	{
		var wrap = _doc.createElement('div'),
		    body = _doc.body;
		
		wrap.style.cssText = 'position:absolute;left:0;top:0;visibility:hidden;';
		wrap.innerHTML = dialogTpl;
		
        var name, i = 0,
			DOM = { wrap: $(wrap) },
			els = wrap.getElementsByTagName('*'),
			len = els.length;
			
		for( ; i < len; i ++ )
		{
			name = els[i].className.split('ui_')[1];
			if(name) DOM[name] = $(els[i]);
		};
		
		//body.insertBefore(wrap, body.firstChild);
		body.appendChild(wrap);
		return DOM;
	},
	
	/*!
	 * px與%單位轉換成數值 (百分比單位按照最大值換算)
	 * 其他的單位返回原值
	 */
	_toNumber: function( thisValue, maxValue )
	{
		if( typeof thisValue === 'number' )
			return thisValue;
		
		if( thisValue.indexOf('%') !== -1 )
			thisValue = parseInt(maxValue * thisValue.split('%')[0] / 100);
		
		return thisValue;
	},
	
	/*! 計算最大化視窗時視窗的尺寸 */
	_maxSize: function()
	{
	    var that = this, DOM = that.DOM,
		    wrap = DOM.wrap[0],
			main = DOM.main[0],
			maxWidth, maxHeight;
			
		maxWidth = _$top.width() - wrap.offsetWidth + main.offsetWidth;
		maxHeight = _$top.height() - wrap.offsetHeight + main.offsetHeight;
		
		return { w: maxWidth, h: maxHeight };
	},
	
	/*! 讓IE6 CSS支援PNG背景 */
	_ie6PngFix: function()
	{
	    if( _ie6 )
		{
			var i = 0, elem, png, pngPath, runtimeStyle,
				path = lhgdialog.setting.path + '/skins/',
				list = this.DOM.wrap[0].getElementsByTagName('*');
			
			for( ; i < list.length; i ++ )
			{
				elem = list[i];
				png = elem.currentStyle['png'];
				if( png )
				{
					pngPath = path + png;
					runtimeStyle = elem.runtimeStyle;
					runtimeStyle.backgroundImage = 'none';
					runtimeStyle.filter = "progid:DXImageTransform.Microsoft." +
						"AlphaImageLoader(src='" + pngPath + "',sizingMethod='scale')";
				};
			}
		}
		
		return this;
	},
	
	/*! 強制覆蓋IE6下拉控制元件 */
	_ie6SelectFix: _ie6 ? function(){
		var $wrap = this.DOM.wrap,
			wrap = $wrap[0],
			expando = expando + 'iframeMask',
			iframe = $wrap[expando],
			width = wrap.offsetWidth,
			height = wrap.offsetHeight;

		width = width + 'px';
		height = height + 'px';
		if(iframe)
		{
			iframe.style.width = width;
			iframe.style.height = height;
		}else{
			iframe = wrap.appendChild(_doc.createElement('iframe'));
			$wrap[expando] = iframe;
			iframe.src = "javascript:''";
			iframe.style.cssText = 'position:absolute;z-index:-1;left:0;top:0;'
			+ 'filter:alpha(opacity=0);width:' + width + ';height:' + height;
		}
	} : _fn,
	
	/*! 自動切換定位型別 */
	_autoPositionType: function()
	{
		this[this.config.fixed ? '_setFixed' : '_setAbsolute']();
	},
	
	/*! 設定靜止定位 */
	_setFixed: function( el )
	{
		var style = el ? el.style : this.DOM.wrap[0].style;
		
		if( _ie6 )
		{
			var sLeft = _$top.scrollLeft(),
				sTop = _$top.scrollTop(),
				left = parseInt(style.left) - sLeft,
				top = parseInt(style.top) - sTop,
				txt = _doctype ? 'this.ownerDocument.body' :
				    'this.ownerDocument.documentElement';
			
			this._setAbsolute();
			
			style.setExpression( 'left', txt + '.scrollLeft +' + left );
			style.setExpression( 'top', txt + '.scrollTop +' + top );
		}
		else
			style.position = 'fixed';
	},
	
	/*! 設定絕對定位 */
	_setAbsolute: function()
	{
		var style = this.DOM.wrap[0].style;
			
		if(_ie6)
		{
			style.removeExpression('left');
			style.removeExpression('top');
		}

		style.position = 'absolute';
	},
	
	/*! 按鈕回撥函式觸發 */
	_click: function( name )
	{ 
		var that = this,
			fn = that._listeners[name] && that._listeners[name].callback;
		return typeof fn !== 'function' || fn.call(that, window) !== false ?
			that.close() : that;
	},
	
	/*! 重置位置與尺寸 */
	_reset: function()
	{
		var test = !!window.ActiveXObject,
		    newSize,
			that = this,
			tw = _$top.width(),
			tt = _$top.height(),
			oldSize = that._winSize || tw * tt,
			oldWidth = that._lockDocW || tw,
			left = that._left,
			top = that._top;
		
		if(test)
		{
			//IE6下遮罩大小改變
			if( that._lock && _ie6 )
			    $('#ldg_lockmask',_doc).css({ width:tw + 'px', height:tt + 17 + 'px' });
			
			newWidth = that._lockDocW = tw;
			//IE6~7 window.onresize bug
			newSize = that._winSize =  tw * tt;
			if( oldSize === newSize ) return;
		};
		
		if( that._maxState )
		{
		    var size = that._maxSize();
			that.size( size.w, size.h );
		}
		
		//IE6~8會出現最大化還原後窗口重新定位，鎖定滾動條在IE下就會觸發resize事件BUG 
		if( test && Math.abs(oldWidth - newWidth) === 17 ) return;
		
		if( left || top )
			that.position( left, top );
	},
	
	_addEvent: function()
	{
		var resizeTimer,
			that = this,
			config = that.config,
			DOM = that.DOM;
		
		// 視窗調節事件
		that._winResize = function()
		{
			resizeTimer && clearTimeout(resizeTimer);
			resizeTimer = setTimeout(function()
			{
				that._reset();
			}, 140);
		};
		_$top.bind('resize', that._winResize);
		
		// 監聽點選
		DOM.wrap.bind('click', function(event){
			var target = event.target, callbackID;
			
			if( target.disabled ) return false; // IE BUG
			
			if( target === DOM.close[0] )
			{
				that._click('cancel');
				return false;
			}
			else if( target === DOM.max[0] || target === DOM.res[0] || target === DOM.max_b[0]
			    || target === DOM.res_b[0] || target === DOM.res_t[0] )
			{
			    that.max();
				return false;
			}
			else if( target === DOM.min[0] || target === DOM.min_b[0] )
			{
				that.min();
				return false;
			}
			else
			{
				event.stopPropagation();
				callbackID = target[expando + 'callback'];
				callbackID && that._click(callbackID);
			}
		}).bind('mousedown',function(event){
		    that.zindex();
			
			var target = event.target;
			
			if( config.drag !== false && target === DOM.title[0]
			|| config.resize !== false && target === DOM.rb[0] )
			{
				_use(event);
				return false;
			}
		});
		
		// 雙擊標題欄最大化還視窗事件
		if( config.max )
		    DOM.title.bind('dblclick',function(){ that.max(); return false; });
	},
	
	/*!  解除安裝事件代理 */
	_removeEvent: function()
	{
		var that = this,
			DOM = that.DOM;
		
		DOM.wrap.unbind();
		DOM.title.unbind();
		_$top.unbind('resize', that._winResize);
	}
};

lhgdialog.fn._init.prototype = lhgdialog.fn;

/*! 此對像用來儲存獲得焦點的視窗對像實例 */
lhgdialog.focus = null;

/*! 儲存視窗實例的對象列表 */
lhgdialog.list = {};

/*!
 * 全域性快捷鍵
 * 由於跨框架時事件是繫結到最頂層頁面，所以噹噹前頁面解除安裝時必須要除移此事件
 * 所以必須unbind此事件繫結的函式，所以這裡要給繫結的事件定義個函式
 * 這樣在目前頁面解除安裝時就可以移此事件繫結的相應函式，不而不影響頂層頁面此事件繫結的其它函式
 */
onKeyDown = function(event)
{
	var target = event.target,
		api = lhgdialog.focus,
		keyCode = event.keyCode;

	if( !api || !api.config.esc || api.config.cancel === false ) return;
		
	keyCode === 27 && api._click(api.config.cancelVal);
};

_$doc.bind('keydown',onKeyDown);

/*!
 * 框架頁面解除安裝前關閉所有穿越的對話方塊
 * 同時移除拖動層和遮罩層
 */
_top != window && $(window).bind('unload',function()
{
    var list = lhgdialog.list;
	for( var i in list )
	{
	    if(list[i])
		    list[i].close();
	}
	_singleton && _singleton.DOM.wrap.remove();
	
	_$doc.unbind('keydown',onKeyDown);
	
	$('#ldg_lockmask',_doc)[0] && $('#ldg_lockmask',_doc).remove();
	$('#ldg_dragmask',_doc)[0] && $('#ldg_dragmask',_doc).remove();
});

/*! lhgdialog 的全域性預設配置 */
lhgdialog.setting =
{
    content: '<div class="ui_loading"><span>loading...</span></div>',
	title: '\u89C6\u7A97 ',     // 標題,預設'視窗'
	button: null,	     		// 自定義按鈕
	ok: null,					// 確定按鈕回撥函式
	cancel: null,				// 取消按鈕回撥函式
	init: null,					// 對話方塊初始化后執行的函式
	close: null,				// 對話方塊關閉前執行的函式
	okVal: '\u786E\u5B9A',		// 確定按鈕文字,預設'確定'
	cancelVal: '\u53D6\u6D88',	// 取消按鈕文字,預設'取消'
	skin: '',					// 多面板共存預留介面
	esc: true,					// 是否支援Esc鍵關閉
	show: true,					// 初始化后是否顯示對話方塊
	width: 'auto',				// 內容寬度
	height: 'auto',				// 內容高度
	icon: null,					// 訊息圖示名稱
	path: _path,                // lhgdialog路徑
	lock: false,				// 是否鎖屏
	focus: true,                // 視窗是否自動獲取焦點
	parent: null,               // 打開子視窗的父視窗對象，主要用於多層鎖屏視窗
	padding: '10px',		    // 內容與邊界填充距離
	fixed: false,				// 是否靜止定位
	left: '50%',				// X軸座標
	top: '38.2%',				// Y軸座標
	max: false,                  // 是否顯示最大化按鈕
	min: false,                  // 是否顯示最小化按鈕
	zIndex: 1976,				// 對話方塊疊加高度值(重要：此值不能超過瀏覽器最大限制)
	resize: false,				// 是否允許使用者調節尺寸
	drag: true, 				// 是否允許使用者拖動位置
	cache: true,                // 是否快取視窗內容頁
	data: null,                 // 傳遞各種數據
	extendDrag: false           // 增加lhgdialog拖拽體驗
};

/*!
 *------------------------------------------------
 * 對話方塊模組-拖拽支援（可選外接模組）
 *------------------------------------------------
 */
var _use, _isSetCapture = 'setCapture' in _root,
	_isLosecapture = 'onlosecapture' in _root;

lhgdialog.dragEvent =
{
    onstart: _fn,
	start: function(event)
	{
	    var that = lhgdialog.dragEvent;
		
		_$doc
		.bind( 'mousemove', that.move )
		.bind( 'mouseup', that.end );
		
		that._sClientX = event.clientX;
		that._sClientY = event.clientY;
		that.onstart( event.clientX, event.clientY );
		
		return false;
	},
	
	onmove: _fn,
	move: function(event)
	{
	    var that = lhgdialog.dragEvent;
		
		that.onmove(
		    event.clientX - that._sClientX,
			event.clientY - that._sClientY
		);
		
		return false;
	},
	
	onend: _fn,
	end: function(event)
	{
	    var that = lhgdialog.dragEvent;
		
		_$doc
		.unbind('mousemove', that.move)
		.unbind('mouseup', that.end);
		
		that.onend(  event.clientX, event.clientY );
		return false;
	}
};

_use = function(event)
{
	var limit, startWidth, startHeight, startLeft, startTop, isResize,
		api = lhgdialog.focus,
		config = api.config,
		DOM = api.DOM,
		wrap = DOM.wrap[0],
		title = DOM.title,
		main = DOM.main[0],
		_dragEvent = lhgdialog.dragEvent,
	
	// 清除文字選擇
	clsSelect = 'getSelection' in _top ?
	function(){
		_top.getSelection().removeAllRanges();
	}:function(){
		try{_doc.selection.empty();}catch(e){};
	};
	
	// 對話方塊準備拖動
	_dragEvent.onstart = function( x, y )
	{
		if( isResize )
		{
			startWidth = main.offsetWidth;
			startHeight = main.offsetHeight;
		}
		else
		{
			startLeft = wrap.offsetLeft;
			startTop = wrap.offsetTop;
		};
		
		_$doc.bind( 'dblclick', _dragEvent.end );
		
		!_ie6 && _isLosecapture
		? title.bind('losecapture',_dragEvent.end )
		: _$top.bind('blur',_dragEvent.end);
		
		_isSetCapture && title[0].setCapture();
		
		DOM.border.addClass('ui_state_drag');
		api.focus();
	};
	
	// 對話方塊拖動進行中
	_dragEvent.onmove = function( x, y )
	{
		if( isResize )
		{
			var wrapStyle = wrap.style,
				style = main.style,
				width = x + startWidth,
				height = y + startHeight;
			
			wrapStyle.width = 'auto';
			config.width = style.width = Math.max(0,width) + 'px';
			wrapStyle.width = wrap.offsetWidth + 'px';
			
			config.height = style.height = Math.max(0,height) + 'px';
			//api._ie6SelectFix();
		    // 使用loading層置頂視窗時視窗大小改變相應loading層大小也得改變
			api._load && $(api._load).css({width:style.width, height:style.height});
		}
		else
		{
			var style = wrap.style,
				left = x + startLeft,
				top = y + startTop;

			config.left = Math.max( limit.minX, Math.min(limit.maxX,left) );
			config.top = Math.max( limit.minY, Math.min(limit.maxY,top) );
			style.left = config.left + 'px';
			style.top = config.top + 'px';
		}
			
		clsSelect();
	};
	
	// 對話方塊拖動結束
	_dragEvent.onend = function( x, y )
	{
		_$doc.unbind('dblclick',_dragEvent.end);
		
		!_ie6 && _isLosecapture
		? title.unbind('losecapture',_dragEvent.end)
		: _$top.unbind('blur',_dragEvent.end);
		
		_isSetCapture && title[0].releaseCapture();
		
		_ie6 && api._autoPositionType();
		
		DOM.border.removeClass('ui_state_drag');
	};
	
	isResize = event.target === DOM.rb[0] ? true : false;
	
	limit =	(function(fixed)
	{
		var	ow = wrap.offsetWidth,
			// 向下拖動時不能將標題欄拖出可視區域
			oh = title[0].offsetHeight || 20,
			ww = _$top.width(),
			wh = _$top.height(),
			dl = fixed ? 0 : _$top.scrollLeft(),
			dt = fixed ? 0 : _$top.scrollTop();
		    // 座標最大值限制(在可視區域內)	
		    maxX = ww - ow + dl;
		    maxY = wh - oh + dt;
		
		return {
			minX: dl,
			minY: dt,
			maxX: maxX,
			maxY: maxY
		};
	})(wrap.style.position === 'fixed');
	
	_dragEvent.start(event);
};

/*! 
 * 頁面DOM載入完成執行的程式碼
 */
$(function(){
	// 觸發瀏覽器預先快取背景圖片
	setTimeout(function()
	{
	    if(_count) return;
		lhgdialog({left:'-9999em',time:9,fixed:false,lock:false,focus:false});
	},150);
	
	// 增強lhgdialog拖拽體驗（可選外接模組，如不需要可刪除）
	// 防止滑鼠落入iframe導致不流暢，對超大對話方塊拖動優化
	lhgdialog.setting.extendDrag &&
	(function(dragEvent){
	    var mask = _doc.createElement('div'),
		    style = mask.style,
			positionType = _ie6 ? 'absolute' : 'fixed';
		mask.id = 'ldg_dragmask';
		
		style.cssText = 'display:none;position:' + positionType + ';left:0;top:0;width:100%;height:100%;'
		+ 'cursor:move;filter:alpha(opacity=0);opacity:0;background:#FFF;pointer-events:none;';
		
		_doc.body.appendChild(mask);
		
		dragEvent._start = dragEvent.start;
		dragEvent._end = dragEvent.end;
		
		dragEvent.start = function()
		{
			var api = lhgdialog.focus,
				main = api.DOM.main[0],
				iframe = api.iframe;
			
			dragEvent._start.apply(this, arguments);
			style.display = 'block';
			style.zIndex = lhgdialog.setting.zIndex + 3;
			
			if(positionType === 'absolute')
			{
				style.width = _$top.width() + 'px';
				style.height = _$top.height() + 'px';
				style.left = _$doc.scrollLeft() + 'px';
				style.top = _$doc.scrollTop() + 'px';
			};
			
			if( iframe && main.offsetWidth * main.offsetHeight > 307200 )
				main.style.visibility = 'hidden';
		};
		
		dragEvent.end = function()
		{
			var api = lhgdialog.focus;
			dragEvent._end.apply(this, arguments);
			style.display = 'none';
			if(api) api.DOM.main[0].style.visibility = 'visible';
		};
	})(lhgdialog.dragEvent);
});

/*! 使用jQ方式呼叫視窗 */
$.fn.dialog = function()
{
	var config = arguments;
	this.bind('click',function(){ lhgdialog.apply(this,config); return false; });
	return this;
};
		
window.lhgdialog = $.dialog = lhgdialog;

})( this.jQuery || this.lhgcore, this );

/*!
 *------------------------------------------------
 * 對話方塊其它功能擴充套件模組（可選外接模組）
 *------------------------------------------------
 */
;(function( $, lhgdialog, undefined ){

var _zIndex = function()
{
    return lhgdialog.setting.zIndex;
};

/**
 * 警告
 * @param	{String}	訊息內容
 */
lhgdialog.alert = function( content, callback, parent )
{
	return lhgdialog({
		title: '警告',
		id: 'Alert',
		zIndex: _zIndex(),
		icon: 'alert.gif',
		fixed: true,
		lock: true,
		content: content,
		ok: true,
		resize: false,
		close: callback,
		parent: parent || null
	});
};

/**
 * 確認
 * @param	{String}	訊息內容
 * @param	{Function}	確定按鈕回撥函式
 * @param	{Function}	取消按鈕回撥函式
 */
lhgdialog.confirm = function( content, yes, no, parent )
{
	return lhgdialog({
		title: '系統提示',
		id: 'confirm.gif',
		width: 210,
		zIndex: _zIndex(),
		icon: 'confirm.gif',
		fixed: true,
		lock: true,
		content: content,
		resize: false,
		parent: parent || null,
		ok: function(here){
			return yes.call(this, here);
		},
		cancel: function(here){
			return no && no.call(this, here);
		}
	});
};

/**
 * 提問
 * @param	{String}	提問內容
 * @param	{Function}	回撥函式. 接收參數：輸入值
 * @param	{String}	預設值
 */
lhgdialog.prompt = function( content, yes, value, parent )
{
	value = value || '';
	var input;
	
	return lhgdialog({
		title: '提問',
		id: 'Prompt',
		zIndex: _zIndex(),
		icon: 'prompt.gif',
		fixed: true,
		lock: true,
		parent: parent || null,
		content: [
			'<div style="margin-bottom:5px;font-size:12px">',
				content,
			'</div>',
			'<div>',
				'<input value="',
					value,
				'" style="width:18em;padding:6px 4px" />',
			'</div>'
			].join(''),
		init: function(){
			input = this.DOM.content[0].getElementsByTagName('input')[0];
			input.select();
			input.focus();
		},
		ok: function(here){
			return yes && yes.call(this, input.value, here);
		},
		cancel: true
	});
};

/**
 * 短暫提示
 * @param	{String}	提示內容
 * @param   {Number}    顯示時間 (預設1.5秒)
 * @param	{String}	提示圖示 (注意要加副檔名)
 * @param   {Function}  提示關閉時執行的回撥函式
 */
lhgdialog.tips = function( content, time, icon, lock, callback )
{	
	return lhgdialog({
		id: 'Tips',
		zIndex: _zIndex(),
		title: false,
		icon: icon,
		content: content,
		cancel: false,
		fixed: true,
		lock: !!lock,
		resize: false
	}).time(time || 1.5, function(){
		if( callback ) this.config.close = callback;
	});
};

})( this.jQuery||this.lhgcore, this.lhgdialog );



