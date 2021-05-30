<?php $this->load->view('header');?>

<script type="text/javascript">
var DOMAIN = document.domain;
var WDURL = "<?php echo site_url()?>";
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

<link href="<?php echo base_url()?>statics/service/css/global.css?v=20120213" rel="stylesheet" type="text/css">
<style type="text/css">
.service-header{position:fixed;width:100%;background: none repeat scroll 0 0 #F4F4F4;z-index:99999;}

.holder{padding:25px 0;}
</style>
</head>
<body>
<div id="Wrapper">
  <div>
    <dl id="Service" class="service">
      <dt class="type cf service-header"><!--<a>自助服務</a>|<a  data-tab="news">系統訊息</a>|
<a data-tab="problems">我的提問</a>|<a data-tab="question">線上提問</a>|<a class="cur">服務通道</a>--><!--|<a>專家服務</a>--></dt>

      <dd class="holder">
      <dd class="con">
        <div class="service-box news dn">
        	<div class="service-list">
        		<div class="load-place">
	              <table>
	                <thead>
	                    <tr>
	                      <th>標題</th>
	                      <td width="120">發送者</td>
	                      <td width="180">發佈時間</td>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	              </table>
	          </div>
	          <p class="tr paging"></p>
        	</div>
          	<div class="service-con news-con dn">
          		<div class="service-hd">
          			<h3 class="title"></h3>
          			<a href="" class="back"><i></i>返回</a>
          		</div>
          		<div class="con">
          			
          		</div>
          		<p class="skip"><a class="prev">&lt;&lt; 上一條</a> | <a class="next">下一條 &gt;&gt;</a></p>

          	</div>
        </div>
        <div class="service-box problems dn">
        	<div class="service-list">
        		<div class="load-place">
	              <table>
	                <thead>
	                    <tr>
	                      <th>標題</th>
	                      <td width="80">狀態</td>
	                      <td width="160" align="center">建立時間</td>
	                      <td width="160" align="center">最後回覆</td>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	              </table>
	          </div>
	          <p class="tr paging"></p>
        	</div>
        	<div class="service-con problems-con dn">
        		<div class="service-hd">
          			<h3 class="title"></h3>
          			<a href="" class="back"><i></i>返回</a>
          		</div>
          		<div class="con aq-list">
          		</div>
          		<div class="continue-ask" id="continue-ask">
          			<!--<textarea name="question"></textarea>-->
                    <div><script id="continueAsk" type="text/plain"></script></div>
          			<p class="tr"><input type="button" class="ui-btn ui-btn-sp m0" value="繼續提問" /></p>
          		</div>
          		<p class="skip"><a class="prev">&lt;&lt; 上一條</a> | <a class="next">下一條 &gt;&gt;</a></p>

        	</div>
        </div>
        <div class="service-box question dn">
          <h3 class="service-hd"><i></i>歡迎您給我們提出意見和建議，您的問題我們會在工作日內儘快回覆，敬請留意<a href="javascript:;" id
="TabProblems">我的提問</a>，謝謝！</h3>
          <div class="service-bd">
          	  <div class="m20">
	            <label>標題：</label><input type="text" class="txt_fw" id="QTitle">
	          </div>
	          <div class="m20 cf">
	            <label class="fl">內容：</label>
	            <script id="editor" type="text/plain"></script>
	          </div>
	          <p class="tr">
	            <input type="button" class="ui-btn ui-btn-sp" value="提 交" id="submit">
	          </p>
          </div>
        </div>
        <div class="service-box contact">
    		<div class="service-hd contact-txt">
    			<p>若您在使用過程中遇到問題，您可以通過以下方式聯繫我們，我們將線上為您提供服務！</p>
    		</div>
    		<ul class="list cf">
    			<li class="weixin">
    				<div class="inner">
    					<i></i>
	    				<p class="tit">售後熱線：0912-345-678</p>
	    				<p>通過熱線&遠端協控，為您提供產品應用和操作問題諮詢、疑難業務指導和故障診斷等服務。</p>
	    				<p class="tit">服務響應：</p>
	    				<p>工作日（週一至週五）</p>
	    				<p>8:30-12:00、13:00-20:00</p>
	    				<p>週六</p>
	    				<p>9:00-12:00、13:30-17:30</p>
	    				<p>週日及其他法定假日除外，詳見系統訊息</p>
    				</div>
    			</li>
    			<li class="qq-club">
    				<div class="inner">
    					<i></i>
	    				<p class="tit">售後服務QQ：<a  title="線上QQ客服" id="wpa_shouhou" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=999999999&site=qq&menu=yes">999999999</a></p
>
	    				<p>您只需登錄QQ即可線上溝通，通過文字應答&遠端協控，為您提供產品應用操作問題指導和諮詢服務。</p>
                        <p class="tit">服務響應：</p>
                        <p>工作日（週一至週五）</p>
                        <p>8:30-12:00、13:00-20:00</p>
                        <p>週六、週日</p>
                        <p>9:00-12:00、13:30-17:30</p>
                        <p>其他法定節假日除外，詳見系統訊息</p>
    				</div>
    			</li>
    			<li class="email">
    				<div class="inner">
    					<i></i>
	    				<p class="tit">客服郵箱：<a href="mailto:sample@cierp.sytes.net">sample@cierp.sytes.net</a></p>
                        <p>通過郵件提交您的事務性申請，如：密碼修改申請、友盾掛失申請、補寄發票申請、產品升級申請等服務。</p>
                        <p class="tit">服務響應：</p>
                        <p>工作日24小時處理完畢</p>
    				</div>
    			</li>
    			<li class="qrCode">
                	<div class="inner">二維碼</div>
    			</li>
    		</ul>
		</div>
<!--        <div class="added-service dn">
          <iframe id="IframeAdded" name="IframeAdded" scrolling="no" frameborder="0" height="600" width
="100%"></iframe>
        </div>-->
      </dd>
    </dl>
  </div>
</div>

 
<script type="text/javascript">
var $_tab = $('#Service > dt > a');
function openTab(index) {
	$_tab.eq(index -1).trigger('click');
};
$(function(){
	var Q_CONTENT = UE.getEditor('editor', { initialFrameWidth:627, initialFrameHeight:300, initialContent
:'' });
	var continueAsk;
	
	var param = Public.getRequest();
  	var system = SYSTEM = parent.SYSTEM;
	var URL = parent.CONFIG.SERVICE_URL;
	var CUR_TAB = param.tab || 1;
	var version;
	switch (system.siVersion) {
		case 3:
		  version = '1';
		  break;
		case 4:
		  version = '3';
		  break;
		default:
		  version = '2';
	};
	var CUR_INFO = {
		version: version,
		cur_type: '',
		news: { cur_page: 1 },
		problems: { cur_page: 1, cur_id: '' }
	};
	function getList(type, $_obj, pageIndex){
	  $.getJSON( URL+ "asy/Services.ashx?callback=?", {coid : system.DBID, loginuserno: system.userName
, version: CUR_INFO.version, pageIndex: pageIndex, pagesize: 12, type: type}, function(data){
		  if(data.status === 200) {
			  var tr = [];
			  if(data.data.recordes > 0) {
			  	  CUR_INFO.cur_type = type;
				  if(type === 'getsystemnews' + SYSTEM.servicePro) {
				  	CUR_INFO.news.cur_page = pageIndex;
					  $.each(data.data.items, function(i, data){
						  var flag = '';
						  flag = data.action === 'addrecord' ? ' class = "title unread"' : ' class="title"';
						  
						  var temp =  '<tr><td' + flag + ' rel="news' + data.id + '"><a href="" rel="news" data-id="' 
+ data.id + '" data-action="' + data.action + '">' + data.title + '</a></td><td>' + data.publisherno
 + '</td><td>' + data.publishtime + '</td></tr>';
						  tr.push(temp);
					  });
				  } else {
				  	CUR_INFO.problems.cur_page = pageIndex;
					  $.each(data.data.items, function(i, data){
						  var flag = '';
						  flag = data.action === 'addrecord' ? ' class = "title unread"' : ' class="title"';
						  
						  var temp =  '<tr><td' + flag + ' rel="problems' + data.no + '"><a href="" rel="problems" data-id
="' + data.no + '" data-action="' + data.action + '">' + data.title + '</a></td><td>' + data.state +
 '</td><td>' + data.uploadtime + '</td><td>' + data.ansertime + '</td></tr>';
						  tr.push(temp);
					  }); 
				  };
				  
				  var total = data.data.total;
				  var page = data.data.page;
				  $_obj.find('.paging').html('<a href="javascript:;" data-page="1" class="ser-first">首頁</a> <a href
="#" class="ser-prev">&lt;&lt; 上一頁</a> | <a href="#" class="ser-next">下一頁 &gt;&gt;</a> 跳轉<input type
="text" class="txt-go"><span class="btn-go">GO</span> 頁碼：<span class="page-info"></span>');
				  
				  $_obj.find('.load-place tbody').html(tr.join('')); 
				  $_obj.find('.page-info').text(page + '/' + total);
				  $_obj.find('.page-info').data('total', total);
				  if(total > page) {
					 $_obj.find('.ser-next').removeClass('dis').data('page', page + 1); 
				  } else {
					 $_obj.find('.ser-next').addClass('dis');
				  };
				  if(page > 1) {
					 $_obj.find('.ser-first').removeClass('dis'); 
					 $_obj.find('.ser-prev').removeClass('dis').data('page', page - 1);
				  } else {
					 $_obj.find('.ser-first').addClass('dis'); 
					 $_obj.find('.ser-prev').addClass('dis'); 
				  }
			  } else {
			  	  $_obj.find('.paging').html('&nbsp;');
			  }
		  }
	  });
	};
	
	function showDetail(type, id, action) {
		var $service_list, $service_con;
		if(type == 'getsystemnewsbyno' + SYSTEM.servicePro){
			$service_list = $('.news .service-list'); 
			$service_con = $('.news .service-con');
		}else if(type == 'getfeebackrecord' + SYSTEM.servicePro){
			$service_list = $('.problems .service-list'); 
			$service_con = $('.problems .service-con');
		}
		$service_list.hide();
		$service_con.show();
	  $.getJSON( URL+ "/asy/Services.ashx?callback=?", {coid : system.DBID, loginuserno: system.userName
, version: CUR_INFO.version, id: id, action: action, type: type},function(data){
		  if(type == 'getsystemnewsbyno' + SYSTEM.servicePro){
			var $news = $('.news-con'),
				$prev = $('.prev', $news),
				$next = $('.next', $news);
			$('.title', $news).text(data.title);
			$('.con', $news).html(data.htmlBody);
			if(data.preNo) {
				 $prev.removeClass('dis').data('action', 'addrecord' );
				 $prev.data('id', data.preNo);
			  } else {
				 $prev.addClass('dis').removeData('id');
				 $prev.removeData('action');
			  };
			  
			  if(data.nextNo) {
				 $next.removeClass('dis').data('action', 'addrecord');
				 $next.data('id', data.nextNo);
			  } else {
				 $next.addClass('dis').removeData('id');
				 $next.removeData('action');
			  };
		  }else if(type == 'getfeebackrecord' + SYSTEM.servicePro){
			if(!continueAsk) {
				continueAsk = UE.getEditor('continueAsk', { initialFrameWidth:'100%', initialContent:'' });
			}

		  	var $problems = $('.problems-con'),
				$prev = $('.prev', $problems),
				$next = $('.next', $problems),
				content = ['<ul>'];
		  	$.each(data.data, function(i, row){	
			  	  var temp = '';
			      if(i === 0) {
					  $('.title', $problems).text(row.title);
					  temp = '<li><h4><i></i>反饋內容：</h4><div class="ctn">' + row.body + '</div><p class="time">時間：' 
+ row.ansertime + '</p></li>';
					  if(row.preno) {
						 $prev.removeClass('dis').data('action', 'addrecord' );
				 		$prev.data('id', row.preno); 
					  } else {
						 $prev.addClass('dis').removeData('id');
				 		$prev.removeData('action');
					  };
					  
					  if(row.nextno) {
						 $next.removeClass('dis').data('action', 'addrecord');
				 		$next.data('id', row.nextno);
					  } else {
						 $next.addClass('dis').removeData('id');
				 		$next.removeData('action');
					  };
				  } else {
					  if(row.type === 'answer') {
					  	temp = '<li class="answer"><h4><i></i>客服答覆：</h4><div class="ctn">' + row.body + '</div><p class
="time">時間：' + row.ansertime + '</p></li>';
					  } else {
					  	temp = '<li><h4><i></i>補充內容：</h4><div class="ctn">' + row.body + '</div><p class="time">時間：'
 + row.ansertime + '</p></li>';
					  }
				  }
				  content.push(temp);
			  }); 
			content.push('</ul>');
			$('.aq-list', $problems).html(content.join(''));
		  }
		  
	  });
    };

    function showServiceList(){
    	var $service_con;
    	if(CUR_INFO.cur_type == 'getsystemnews' + SYSTEM.servicePro){
    		$service_con = $('.news .service-con');
    		$service_con.hide();
			$service_con.find('.service-hd .title').text('');
    		$service_con.find('.con').html('');
			$('.news .service-list').show();
    	}else if(CUR_INFO.cur_type == 'getfeedback' + SYSTEM.servicePro){
    		$('.problems .service-con').hide();
    		$('.problems .service-list').show();
    	}
    }

	$("#Service").artTab({
		newsPage: false,
		problemsPage: false,
		addedPage: false,
		callback: function (curTab, curCon, opts) {
			if (curTab.html() === '系統訊息') {
				CUR_INFO.cur_type = 'getsystemnews' + SYSTEM.servicePro;
				getList('getsystemnews' + SYSTEM.servicePro, curCon, CUR_INFO.news.cur_page);
				showServiceList();
				return;
			};
			
			if (curTab.html() === '我的提問') {
				CUR_INFO.cur_type = 'getfeedback' + SYSTEM.servicePro;
				getList('getfeedback' + SYSTEM.servicePro, curCon, CUR_INFO.problems.cur_page);
				showServiceList();
				return;
			};
			
			if (curTab.html() === '專家服務') {
				if(!opts.addedPage) {
					$('#IframeAdded').attr('src', 'added-service.html');
					opts.addedPage = true;
				}
				return;
			};
		}
	});
	$_tab.eq(CUR_TAB - 1).trigger('click');
	if(param.newsId){
		var $td = $('td[rel=news' + param.newsId + ']');
		showDetail('getsystemnewsbyno' + SYSTEM.servicePro, param.newsId, 'addrecord');		
		$td.length > 0 && $td.removeClass('unread');
	}

	$('#Service').on('click', '.ser-prev, .ser-next, .ser-first', function(){
		var $_obj = $(this).parent().parent();
		getList(CUR_INFO.cur_type, $_obj, $(this).data('page'));	
		$_obj.find('.txt-go').val('');
	});

	$('.txt-go').blur(function(){
		var total = $(this).siblings('.page-info').data('total');
		if(!total) return;
		if(this.value > total){
			this.value = total;
		}else if(this.value == 0){
			this.value = 1;
		}
	}).digital();
	
	$('.btn-go').click(function(){
		var $_obj = $(this).parent().parent();
		var pageIndex = $.trim($(this).siblings('.txt-go').val());
		getList(CUR_INFO.cur_type, $_obj, pageIndex);	
	});
	
	$('#Service').on('click', 'a[rel=news],a[rel=problems],.skip a', function(e){
		e.preventDefault();
		var $td,
			id = $(this).data('id');
		if(CUR_INFO.cur_type == 'getsystemnews' + SYSTEM.servicePro){
			showDetail('getsystemnewsbyno' + SYSTEM.servicePro, id, $(this).data('action'));
			$td = $('td[rel=news' + id + ']');
		}else if(CUR_INFO.cur_type == 'getfeedback' + SYSTEM.servicePro){
			showDetail('getfeebackrecord' + SYSTEM.servicePro, id, $(this).data('action'));
			CUR_INFO.problems.cur_id = id;
			$td = $('td[rel=problems' + id + ']');
		}
		if($td.hasClass('unread')) {
			$td.removeClass('unread');
			var $_notice = parent.$('#SysNews span');
			if(Number($_notice.text()) - 1 > 0) {
				$_notice.text(Number($_notice.text()) - 1);
			} else {
				$_notice.remove();
			}
			
		}
	});

	$('.service-con .back').click(function(e){
		e.preventDefault();
		showServiceList();
	});
	
	$('#continue-ask input').click(function(){
		var $this = $(this);
		if($this.data('sending')) return;
		var answerbody = continueAsk.getContent();
		var bodytext = answerbody;
		if(answerbody === ""){
		 parent.Public.tips({ type: 1, content: '請填寫內容！'});
		 continueAsk.focus();
		 return;
		}
		$this.val('提交中...').data('sending', true);
		$.ajax({
			url: URL+ "asy/Services.ashx?callback=?",
			type: 'POST',
			data: {id:CUR_INFO.problems.cur_id, coid: system.DBID, loginuserno: system.userName, version: CUR_INFO
.version, type: 'addfeedbackrecord' + SYSTEM.servicePro, feedbackbody: answerbody, feedbackbodytext:
 bodytext},
			dataType:"jsonp",
			success: function(data){
				$this.val('繼續提問').removeData('sending');
			  if(data.status === 200) {
				  var temp = '';
				  parent.Public.tips({content : '問題提交成功！'});
				  temp = '<li><h4><i></i>補充內容：</h4><div class="ctn">' + answerbody + '</div><p class="time">時間：'
 + data.answertime + '</p></li>';
				  $('.problems-con .con > ul').append(temp);
				  continueAsk.setContent('');
			  }
			}
		});
	});

	$("#submit").click(function(){
		if($(this).data('sending')) return;
		var $this = $(this),
			$title = $('#QTitle'),
			$contact = $('#QContact'),
			answertitle = $.trim($title.val()),
			answerbody = Q_CONTENT.getContent(),
			contactinfo = '';
		if(answertitle === ""){
			$title.focus();
			parent.Public.tips({type: 1, content: '請填寫標題！'});
			return;
		}
		if(answerbody === ""){
			Q_CONTENT.focus();
			parent.Public.tips({type: 1, content: '請填寫內容！'});
			return;
		}

		$this.val('提交中...').data('sending', true);
		$.ajax({
		  url: URL+ "asy/Services.ashx?callback=?",
		  type: 'POST',
		  data: {coid: system.DBID, loginuserno: system.userName, version: CUR_INFO.version, type: 'addfeedback'
 + SYSTEM.servicePro, answertitle: answertitle, answerbody: answerbody, bodytext: '', contactinfo: contactinfo
},
		  dataType:"jsonp",
		  success: function(data){
		  	$this.val('提 交').removeData('sending');
		  	if(data.msg == 'success'){
		  		parent.Public.tips({content : '問題提交成功！'});
		  		$title.val('');
		  		Q_CONTENT.setContent('');
		  		$contact.val('');
		  	}
		  }
		});
	});

	$('#TabProblems').click(function(){
		$_tab.filter("[data-tab='problems']").trigger('click');
	});
})
</script>
<!-- 營銷QQ -->
<!--<script type="text/javascript" charset="utf-8" src="http://wpa.b.qq.com/cgi/wpa.php"></script>-->
<script type="text/javascript">
var QQnum = $('#wpa_shouhou').html();;
BizQQWPA.addCustom([{
	  nameAccount: QQnum,
	  aty: '1',
	  a:'1001',
	  selector: "wpa_shouhou"
}]);
</script>
<!-- 營銷QQ end -->
</body>
</html>