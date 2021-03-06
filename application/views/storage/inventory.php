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

<style>
.mod-search{ position:relative; }
#custom{ position:absolute; top:0; right:0; }
.ui-jqgrid-bdiv .ui-state-highlight { background: none; }
#manager li{margin: 8px 0;}
.ui-label{width: 204px;display: inline-block;line-height: 18px;font-size: 14px;text-align: center;}

.ui-label-warning:hover{background-color: #FFBA5A;}
.no-query{border: none;}
</style>
</head>

<body class="min-w">
<div class="wrapper">
  <div class="mod-search cf">
    <div class="fl">
      <ul class="ul-inline cf">
        <li>
          <span id="storage"></span>
        </li>
        <li>
          <span id="category"></span>
        </li>
        <li>
          <label>商品:</label>
          <input type="text" id="goods" class="ui-input w200">
        </li>
        <li id="chkField">
          <label class="chk" style="margin-top:6px; " title="顯示零庫存"><input type="checkbox" name="box"
 value='showZero'>零庫存</label>
          <label class="chk" style="margin-top:6px; " title="顯示含序列號商品"><input type="checkbox" name="box"
 value='isSerNum'>序列號商品</label>
        </li>
        <li><a class="ui-btn ui-btn-sp mrb" id="search">查詢</a></li>
      </ul>
    </div>
    <div class="fr dn">
        <a class="ui-btn mrb" id="export">導出系統庫存</a><!--<a class="ui-btn mrb" id="import">匯入盤點庫存</a>--><a class
="ui-btn" id="save">產生盤點單據</a>
    </div>
  </div>
  <div class="grid-wrap">
    <table id="grid">
    </table>
    <div id="page"></div>
  </div>
  <div style="margin:10px 18px 0 0; " class="dn"  id="handleDom">
    <div class="fl">
      <label>備註:</label>
      <input type="text" id="note" class="ui-input" style="width:560px;">
    </div>
  </div>
</div>
<script src="<?php echo base_url()?>statics/js/dist/inventory.js?ver=20140430"></script>
</body>
</html>


 