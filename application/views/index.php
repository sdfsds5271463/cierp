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

<link href="<?php echo base_url()?>statics/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url()?>statics/css/<?php echo sys_skin()?>/default.css?ver=20150522" rel="stylesheet" type="text/css" id="defaultFile">
<script src="<?php echo skin_url()?>/js/common/tabs.js?ver=20150522"></script>
<!-- author：209887082 -->


<script>
var CONFIG = {
	DEFAULT_PAGE: true,
	SERVICE_URL: '<?php echo base_url()?>'
};
//系統參數控制
var SYSTEM = {
	version: 1,
	skin: "<?php echo sys_skin()?>",
	language:"",
	site:"",
	curDate: "1033737952010",  //系統目前日期
	DBID: "88886683", //賬套ID
	serviceType: "12", //賬套型別，13：表示收費服務，12：表示免費服務
	realName: "<?php echo $name;?>", //真實姓名
	userName: "<?php echo $username;?>", //使用者名稱
	companyName: "<?php echo $system['companyName']?>",	//公司名稱
	companyAddr: "<?php echo $system['companyAddr']?>",	//公司地址
	phone: "<?php echo $system['phone']?>",	//公司電話
	fax: "<?php echo $system['fax']?>",	//公司傳真
	postcode: "<?php echo $system['postcode']?>",	//公司郵編
	startDate: "", //啟用日期
	currency: "RMB",	//本位幣
	qtyPlaces: "<?php echo $system['qtyPlaces']?>",	//數量小數位
	pricePlaces: "<?php echo $system['pricePlaces']?>",	//單價小數位
	amountPlaces: "<?php echo $system['amountPlaces']?>", //金額小數位
	valMethods:	"<?php echo $system['valMethods']?>",	//存貨計價方法
	invEntryCount: "",//試用版單據分錄數
	rights: <?php echo $rights?>,          //許可權列表
	billRequiredCheck: 1, //是否啟用單據審覈功能  1：是、0：否
	requiredCheckStore: <?php echo $system['requiredCheckStore']?>, //是否檢查負庫存  1：是、0：否
	hasOnlineStore: 0,	//是否啟用網店
	enableStorage: 0,	//是否啟用倉儲
	genvChBill: 0,	//產生憑證后是否允許修改單據
	requiredMoney: 1, //是否啟用資金功能  1：是、0：否
	taxRequiredCheck: 0,
	taxRequiredInput: 17,
	isAdmin:<?php echo $roleid==0 ? 'true' : 'false'?>, //是否管理員
	siExpired:false,//是否過期
	siType:2, //服務版本，1表示基礎版，2表示標準版
	siVersion:1, //1表示試用、2表示免費（百度版）、3表示收費，4表示體驗版
	Mobile:"",//目前使用者手機號碼
	isMobile:true,//是否驗證手機
	isshortUser:false,//是否聯邦使用者
	shortName:"",//shortName
	isOpen:false,//是否彈出手機驗證
	enableAssistingProp:0, //是否開啟輔助屬性功能  1：是、0：否
	ISSERNUM: 0, //是否啟用序列號 1：是、0：否 （與enableAssistingProp對立，只能啟用其一）
	ISWARRANTY: 0 //是否啟用保質期  1：是、0：否
};
//區分服務支援
SYSTEM.servicePro = SYSTEM.siType === 2 ? 'forbscm3' : 'forscm3';
var cacheList = {};	//快取列表查詢
//全域性基礎數據
(function(){
	/* 
	 * 判斷IE6，提示使用高級版本
	 */
	if(Public.isIE6) {
		 var Oldbrowser = {
			 init: function(){
				 this.addDom();
			 },
			 addDom: function() {
			 	var html = $('<div id="browser">您使用的瀏覽器版本過低，影響網頁效能，建議您換用<a href="http://www.google.cn/chrome/intl/zh-CN/landing_chrome.html" target="_blank">谷歌</a>、<a href="http://download.microsoft.com/download/4/C/A/4CA9248C-C09D-43D3-B627-76B0F6EBCD5E/IE9-Windows7-x86-chs.exe" target="_blank">IE9</a>、或<a href=http://firefox.com.cn/" target="_blank">火狐瀏覽器</a>，以便更好的使用！<a id="bClose" title="關閉">x</a></div>').insertBefore('#container').slideDown(500); 
			 	this._colse();
			 },
			 _colse: function() {
				  $('#bClose').click(function(){
						 $('#browser').remove();
				 });
			 }
		 };
		 Oldbrowser.init();
	};
	getPageConfig();
	getGoods();
	getStorage();
	getCustomer();
	getSupplier();
	getAddr();
	getUnit();
	getUnitGroup();
	getAccounts();
	getAssistingPropType();
	getAssistingProp();
	getAssistingPropGroup();
	getStaff();
	getBatch();
})();
//快取使用者配置
function getPageConfig(){
	//return;
	Public.ajaxGet('<?php echo site_url()?>/basedata/userSetting?action=list', {}, function(data){
		if(data.status === 200) {
			SYSTEM.pageConfigInfo = {};
			for (var i = 0; i < data.data.rows.length; i++) {
				var conf = data.data.rows[i];
				SYSTEM.pageConfigInfo[''+conf.key] = conf['value'] || {};
				for(var gridId in conf.grids){
					var g = conf.grids[gridId];
					if(typeof g != 'function' && g.isReg){
						var colModel = g.colModel;
						var tmpArr = [];
						for (var i = 0; i < colModel.length; i++) {
							var col = colModel[i];
							tmpArr.push({
								 name: col['name']//列名,唯一標識
								,label: col['label']//列名
								,hidden: col['hidden']//顯示與隱藏
								,width: col['width']//寬度
							})
						};
						g.colModel = tmpArr;
					}
				}
			};
		} else if (data.status === 250){
			SYSTEM.pageConfigInfo = {};
		} else {
			Public.tips({type: 1, content : data.msg});
		}
	});
};
//快取商品資訊
function getGoods() {
	if(SYSTEM.isAdmin || SYSTEM.rights.INVENTORY_QUERY) {
		//&isDelete=2 獲取全部，很奇葩的定義。。。
		Public.ajaxGet('<?php echo site_url()?>/basedata/inventory?action=list&isDelete=2', { rows: 5000 }, function(data){
			if(data.status === 200) {
				SYSTEM.goodsInfo = data.data.rows;
			} else if (data.status === 250){
				SYSTEM.goodsInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.goodsInfo = [];
	}
};
//快取倉庫資訊
function getStorage() {
	if(SYSTEM.isAdmin || SYSTEM.rights.INVLOCTION_QUERY) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/invlocation?action=list&isDelete=2', {}, function(data){
			if(data.status === 200) {
				SYSTEM.storageInfo = data.data.rows;
			} else if (data.status === 250){
				SYSTEM.storageInfo = [];
			}  else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.storageInfo = [];
	}
};
//快取客戶資訊
function getCustomer() {
	if(SYSTEM.isAdmin || SYSTEM.rights.BU_QUERY) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/contact?action=list&simple=1&isDelete=2', { rows: 5000 }, function(data){
			if(data.status === 200) {
				SYSTEM.customerInfo = data.data.rows;
			} else if (data.status === 250){
				SYSTEM.customerInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.customerInfo = [];
	}
};
//快取供應商資訊
function getSupplier() {
	if(SYSTEM.isAdmin || SYSTEM.rights.PUR_QUERY) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/contact?action=list&simple=1&type=10&isDelete=2', { rows: 5000 }, function(data){
			if(data.status === 200) {
				SYSTEM.supplierInfo = data.data.rows;
			} else if (data.status === 250){
				SYSTEM.supplierInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.supplierInfo = [];
	}
};
//快取地址資訊
function getAddr() {
	if(SYSTEM.isAdmin || SYSTEM.rights.DELIVERYADDR_QUERY) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/deliveryAddr?action=list&isDelete=2', { rows: 5000 }, function(data){
			if(data.status === 200) {
				SYSTEM.addrInfo = data.data.items;
			} else if (data.status === 250){
				SYSTEM.addrInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.addrInfo = [];
	}
};
//快取職員
function getStaff() {
	if(true) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/employee?action=list&isDelete=2', {}, function(data){
			if(data.status === 200) {
				SYSTEM.salesInfo = data.data.items;
			} else if (data.status === 250){
				SYSTEM.salesInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.salesInfo = [];
	}
};
//快取賬戶資訊
function getAccounts() {
	if(SYSTEM.isAdmin || SYSTEM.rights.SettAcct_QUERY) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/settAcct?action=list&isDelete=2', {}, function(data){
			if(data.status === 200) {
				SYSTEM.accountInfo = data.data.items;
			} else if (data.status === 250){
				SYSTEM.accountInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.accountInfo = [];
	}
};
//快取結算方式
function getPayments() {
	if(true) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/assist?action=list&typeNumber=PayMethod&isDelete=2', {}, function(data){
			if(data.status === 200) {
				SYSTEM.paymentInfo = data.data.items;
			} else if (data.status === 250){
				SYSTEM.paymentInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.paymentInfo = [];
	}
};
//快取計量單位
function getUnit(){
	if(SYSTEM.isAdmin || SYSTEM.rights.UNIT_QUERY) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/unit?action=list&isDelete=2', {}, function(data){
			if(data.status === 200) {
				SYSTEM.unitInfo = data.data.items;
			} else if (data.status === 250){
				SYSTEM.unitInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.unitInfo = [];
	}
}
//快取計量單位組
function getUnitGroup(){
	if(SYSTEM.isAdmin || SYSTEM.rights.UNIT_QUERY) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/unitType?action=list', {}, function(data){
			if(data.status === 200) {
				SYSTEM.unitGroupInfo = data.data.items;
			} else if (data.status === 250){
				SYSTEM.unitGroupInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.unitGroupInfo = [];
	}
}
//快取計量單位
function getAssistingProp(){
	if(SYSTEM.isAdmin || SYSTEM.rights.UNIT_QUERY) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/unitType?action=list', {}, function(data){
			if(data.status === 200) {
				SYSTEM.unitGroupInfo = data.data.items;
			} else if (data.status === 250){
				SYSTEM.unitGroupInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.unitGroupInfo = [];
	}
}
//快取輔助屬性分類
function getAssistingPropType(){
	if(SYSTEM.isAdmin || SYSTEM.rights.FZSX_QUERY) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/assistType?action=list', {}, function(data){
			if(data.status === 200) {
				SYSTEM.assistPropTypeInfo = data.data.items;
			} else if (data.status === 250){
				SYSTEM.assistPropTypeInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.assistPropTypeInfo = [];
	}
}
//快取輔助屬性
function getAssistingProp(){
	if(SYSTEM.isAdmin || SYSTEM.rights.FZSX_QUERY) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/assist?action=list&isDelete=2', {}, function(data){
			if(data.status === 200) {
				SYSTEM.assistPropInfo = data.data.items;
			} else if (data.status === 250){
				SYSTEM.assistPropInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.assistPropInfo = [];
	}
}
//快取輔助屬性組合
function getAssistingPropGroup(){
	if(SYSTEM.isAdmin || SYSTEM.rights.FZSX_QUERY) {
		Public.ajaxGet('<?php echo site_url()?>/basedata/assistSku?action=list', {}, function(data){
			if(data.status === 200) {
				SYSTEM.assistPropGroupInfo = data.data.items;
			} else if (data.status === 250){
				SYSTEM.assistPropGroupInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.assistPropGroupInfo = [];
	}
}
//快取輔助屬性組合
function getBatch(){
	return;
	if(SYSTEM.isAdmin || SYSTEM.ISWARRANTY) {
		Public.ajaxGet('/warranty.do?action=getBatchNoList', {}, function(data){
			if(data.status === 200) {
				SYSTEM.batchInfo = data.data.items;
			} else if (data.status === 250){
				SYSTEM.batchInfo = [];
			} else {
				Public.tips({type: 1, content : data.msg});
			}
		});
	} else {
		SYSTEM.batchInfo = [];
	}
}
//左上側版本標識控制
function markupVension(){
	var imgSrcList = {
				base:'<?php echo base_url()?>statics/css/<?php echo sys_skin()?>/img/icon_v_b.png',	//基礎版正式版
				baseExp:'<?php echo base_url()?>statics/css/<?php echo sys_skin()?>/img/icon_v_b_e.png',	//基礎版體驗版
				baseTrial:'<?php echo base_url()?>statics/css/<?php echo sys_skin()?>/img/icon_v_b_t.png',	//基礎版試用版
				standard:'<?php echo base_url()?>statics/css/<?php echo sys_skin()?>/img/icon_v_s.png', //標準版正式版
				standardExp:'<?php echo base_url()?>statics/css/<?php echo sys_skin()?>/img/icon_v_s_e.png', //標準版體驗版
				standardTrial :'<?php echo base_url()?>statics/css/<?php echo sys_skin()?>/img/icon_v_s_t.png' //標準版試用版
			};
	var imgModel = $("<img id='icon-vension' src='' alt=''/>");
	if(SYSTEM.siType === 1){
		switch(SYSTEM.siVersion){
			case 1:	imgModel.attr('src',imgSrcList.baseTrial).attr('alt','基礎版試用版');
				break;
			case 2:	imgModel.attr('src',imgSrcList.baseExp).attr('alt','免費版（百度版）');
				break;
			case 3: imgModel.attr('src',imgSrcList.base).attr('alt','基礎版');//標準版
				break;
			case 4: imgModel.attr('src',imgSrcList.baseExp).attr('alt','基礎版體驗版');//標準版
				break;
		};
	} else {
		switch(SYSTEM.siVersion){
			case 1:	imgModel.attr('src',imgSrcList.standardTrial).attr('alt','標準版試用版');
				break;
			case 3: imgModel.attr('src',imgSrcList.standard).attr('alt','標準版');//標準版
				break;
			case 4: imgModel.attr('src',imgSrcList.standardExp).attr('alt','標準版體驗版');//標準版
				break;
		};
	};
	
	$('#col-side').prepend(imgModel);
};

</script>
<!--<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?0613c265aa34b0ca0511eba4b45d2f5e";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>-->
</head>
<body>
<div id="container" class="cf">
  <div id="col-side">
    <ul id="nav" class="cf">
    <li class="item item-vip"> <a href="javascript:void(0);" class="vip main-nav">高級<span class="arrow">&gt;</span></a>
        <div class="sub-nav-wrap group-nav group-nav-t0 vip-nav cf">
          <div class="nav-item nav-onlineStore">
            <h3>網店</h3>
            <ul class="sub-nav" id="vip-onlineStore">
          	</ul>
          </div>
          <div class="nav-item nav-JDstore last">
            <h3>京東倉儲</h3>
            <ul class="sub-nav" id="vip-JDStorage">
          	</ul>
          </div>
          </div>
      </li>
      <li class="item item-purchase"> <a href="javascript:void(0);" class="purchase main-nav">購貨<span class="arrow">&gt;</span></a>
        <div class="sub-nav-wrap single-nav">
          <ul class="sub-nav" id="purchase">
          </ul>
        </div>
      </li>
      <li class="item item-sales"> <a href="javascript:void(0);" class="sales main-nav">銷貨<span class="arrow">&gt;</span></a>
        <div class="sub-nav-wrap single-nav">
          <ul class="sub-nav" id="sales">
          </ul>
        </div>
      </li>
      <li class="item item-storage"> <a href="javascript:void(0);" class="storage main-nav">倉庫<span class="arrow">&gt;</span></a>
        <div class="sub-nav-wrap single-nav">
          <ul class="sub-nav" id="storage">
          </ul>
        </div>
      </li>           
      <li class="item item-money"> <a href="javascript:void(0);" class="money main-nav">資金<span class="arrow">&gt;</span></a>
        <div class="sub-nav-wrap single-nav">
          <ul class="sub-nav" id="money"> 
          </ul>
        </div>
      </li>
      <li class="item item-report"> <a href="javascript:void(0);" class="report main-nav">報表<span class="arrow">&gt;</span></a>
        <div class="sub-nav-wrap group-nav group-nav-b0 report-nav cf">
          <div class="nav-item nav-pur">
            <h3>採購報表</h3>
            <ul class="sub-nav" id="report-purchase">
            </ul>
          </div>
          <div class="nav-item nav-sales">
            <h3>銷售報表</h3>
            <ul class="sub-nav" id="report-sales">
            </ul>
          </div>
          <div class="nav-item nav-fund">
            <h3>倉存報表</h3>
            <ul class="sub-nav" id="report-storage">
            </ul>
          </div>
          
          <div class="nav-item nav-fund last">
            <h3>資金報表</h3>
            <ul class="sub-nav" id="report-money">
            </ul>
          </div>
          
       </div>
      </li>
      <li class="item item-setting"> <a href="javascript:void(0);" class="setting main-nav">設定<span class="arrow">&gt;</span></a>
        <div class="sub-nav-wrap cf group-nav group-nav-b0 setting-nav">
          <div class="nav-item">
            <h3>基礎資料</h3>
            <ul class="sub-nav" id="setting-base">
            </ul>
          </div>
          <div class="nav-item">
            <h3>輔助資料</h3>
            <ul class="sub-nav" id="setting-auxiliary">
            </ul>
          </div>
          <div class="nav-item cf last">
            <h3>高級設定</h3>
            <ul class="sub-nav" id="setting-advancedSetting">
            </ul>
            <ul class="sub-nav" id="setting-advancedSetting-right">
            </ul>
          </div>
        </div>
      </li>
    </ul>
    <!--<div id="navScroll" class="cf"><span id="scollUp"><i>dd</i></span><span id="scollDown"><i>aa</i></span></div>-->
    <!--<a href="#" class="side_fold">收起</a>--> 
  </div>
  <div id="col-main">
    <div id="main-hd" class="cf">
      <div class="tit"> <a class="company" id="companyName" href="javascript:;" title=""></a> <span class="period" id="period"></span> </div>
      <ul class="user-menu">
      	<!--<li class="qq"><a href="" target="_blank" id="mobile" title="手機版">手機版</a></li>
      	<li class="space">|</li>-->
      	<li id="sysSkin">換膚</li>
        <li class="space">|</li>
        <!-- 
        <li><a href="javascript:void(0);" onClick="window.location.href='';return false;">返回助手</a></li>-->
        <!--<li class="space">|</li>-->
        <!-- 
        <li id="yswb-tab"><a href="" target="_blank">社區</a></li>
        <li class="space">|</li>
         -->
       <!-- <li><a href="" target="_blank">幫助</a></li>
        <li class="space">|</li>-->
        <li><a href="<?php echo site_url('login/out')?>">退出</a></li>
      </ul>  
    </div>
    <div id="main-bd">
      <div class="page-tab" id="page-tab"> 
        <!--<ul class="tab_hd">
					<li><a href="#">首頁</a></li>
					<li><a href="#">會計科目</a></li>
				</ul>
				<div class="tab_bd">
					內容
				</div>--> 
      </div>
    </div>
  </div>
</div>
<div id="selectSkin" class="shadow dn">
	<ul class="cf">
    	<li><a id="skin-default"><span></span><small>經典</small></a></li>
        <li><a id="skin-blue"><span></span><small>豐收</small></a></li>
        <li><a id="skin-green"><span></span><small>小清新</small></a></li>
    </ul>
</div>
<script src="<?php echo base_url()?>statics/js/dist/default.js?ver=20170711"></script>
</body>
</html>