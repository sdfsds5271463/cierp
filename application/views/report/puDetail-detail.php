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

<link rel="stylesheet" href="<?php echo base_url()?>statics/css/report.css" />
<style>
.filter-list li.chk-list{height: 20px;}
.mod-report{position: relative;*zoom: 1;padding:66px 0 0 18px;}
.mod-report .search-wrap{position: fixed;left: 0;top: 0;width: 100%;_position:absolute;_left:expression
(eval(document.documentElement.scrollLeft));_top:expression(eval(document.documentElement.scrollTop)
);background: #f5f5f5;}
.mod-report .search-wrap .s-inner{padding: 18px;}
.mod-report .search-wrap strong.tit{font-size:14px;line-height: 30px;}
.mod-report .search-wrap .txt{display: inline-block;*display: inline;*zoom: 1;font-size: 14px;line-height
: 30px;}

.mod-report .grid-wrap:after{content: '.';display: block;clear: both;visibility: hidden;overflow: hidden
;height: 0;}
.mod-report .grid-wrap{*zoom: 1;}
.mod-report .grid-wrap .grid{float: left;padding: 18px;border:1px solid #cfcfcf;background: #fff;box-shadow
:0 1px 3px rgba(0,0,0,0.2);}
.mod-report .grid-wrap .H{font-size:24px;font-weight:bold;text-align: center;}
.mod-report .grid-wrap .R{text-align: right;}
.mod-report .grid-wrap .B{font-weight: bold;}
.mod-report .grid-wrap table{border-collapse:collapse;}
.mod-report .grid-wrap table.caption{margin-bottom: 5px;}
.mod-report .grid-wrap table.list{border:1px solid #666;}
.mod-report .grid-wrap table.list td{padding: 5px 5px;border:1px solid #666;}
.mod-report .grid-wrap table.list thead td{text-align: center;font-weight: bold;}
.link{ cursor:pointer; }
.tr-hover{ background:#f8ff94;}

#filter-menu .mod-choose-input{position: relative;*zoom: 1;}
#filter-menu .mod-choose-input .ui-input{padding-right: 25px;width:226px; font-family:"細明體";}
#filter-menu .ui-datepicker-input{width:105px; font-family:"細明體";}
.ui-icon-ellipsis{ right:3px; }

thead{word-break: keep-all;white-space:nowrap;}

@media print{
body{background: #fff;}
.mod-report{padding: 0;}
.mod-report .search-wrap{display: none;}
.mod-report .grid-wrap .grid{float: none;padding: 0;border:none;background: none;box-shadow:none;}
.mod-report .grid-wrap table.caption{margin-bottom: 0;}
.mod-report .grid-wrap table.list{width:100%;}
.mod-report .grid-wrap table.list td{padding: 1px;}
}
</style>
<script>
var defParams = {
	beginDate: '2015-04-01',
	endDate: '2015-04-15'
};
/*$(function(){
	var SYSTEM = parent.SYSTEM;
	alert(SYSTEM.rights.SAREPORTDETAIL_COST);
	$('#lhtest').html("vvv");
    if(SYSTEM.rights.SAREPORTDETAIL_COST || SYSTEM.isAdmin){
        $('#lhtest').show();
    } else {
        $('#lhtest').hide();
    };
});
$(function(){
	$('.list').width($(window).width() - 74);
});
$(window).resize(function(){
	$('.list').width($(window).width() - 74);
});*/
</script>
</head>
<body>
<div class="mod-report">
  <div class="search-wrap" id="report-search">
    <div class="s-inner cf">
      <div class="fl"> <strong class="tit mrb fl">查詢條件</strong>
        <div class="ui-btn-menu fl" id="filter-menu"> <span class="ui-btn menu-btn"> <strong id="selected-period"
>請選擇查詢條件</strong><b></b> </span>
          <div class="con">
            <ul class="filter-list">
              <li>
                <label class="tit">日期:</label>
                <input type="text" value="" class="ui-input ui-datepicker-input" name="filter-fromDate"
 id="filter-fromDate" />
                <span>至</span>
                <input type="text" value="" class="ui-input ui-datepicker-input" name="filter-toDate"
 id="filter-toDate" />
              </li>
            </ul>
            <ul class="filter-list" id="more-conditions">
              <li>
                <label class="tit">供應商:</label>
                <span class="mod-choose-input" id="filter-customer"><input type="text" class="ui-input"
 id="supplierAuto"/><span class="ui-icon-ellipsis"></span></span>
              </li>
              <li style="height:60px; ">
                <label class="tit">商品:</label>
                <span class="mod-choose-input" id="filter-goods"><input type="text" class="ui-input"
 id="goodsAuto"/><span class="ui-icon-ellipsis"></span></span>
                <p style="color:#999; padding:3px 0 0 0; ">（可用,分割多個編碼如1001,1008,2001，或直接輸入編碼段如1001--1009
查詢）</p>
              </li>
              <li>
                <label class="tit">倉庫:</label>
                <span class="mod-choose-input" id="filter-storage"><input type="text" class="ui-input"
 id="storageAuto"/><span class="ui-icon-ellipsis"></span></span>
              </li>
            </ul>
            <div class="btns"> <a href="#" id="conditions-trigger" class="conditions-trigger" tabindex
="-1">更多條件<b></b></a> <a class="ui-btn ui-btn-sp" id="filter-submit" href="#">確定</a> <a class="ui-btn"
 id="filter-reset" href="#" tabindex="-1">重置</a> </div>
          </div>
        </div>
        <a id="refresh" class="ui-btn ui-btn-refresh fl mrb"><b></b></a> <span class="txt fl" id="cur-search-tip"
></span> </div>
      <div class="fr"><a href="#" class="ui-btn ui-btn-sp mrb fl" id="btn-print">列印</a><a href="#" class
="ui-btn fl" id="btn-export">導出</a></div>
    </div>
  </div>
  
  
  <div class="grid-wrap">
  	<div class="grid">
  		<table width=100% class="caption">
  			<tr><td class='H'>商品採購明細表</td></tr>
  			<tr><td>日期：<?php echo $beginDate?>至<?php echo $endDate?></td></tr>
  		</table>
  		<table width="1440px" class="list">
  			<thead>
  				<tr>
  				<td>採購日期</td>
  				<td>採購單據號</td>
  				<td>業務類別</td>
  				<td>供應商</td>
  				<td>商品編號</td>
  				<td>商品名稱</td>
  				<td>規格型號</td>
  				<td>單位</td>
  				<td>倉庫</td>
  				<td>數量</td>
  				<td>單價</td>
  				<td>採購金額</td>
  				</tr>
  			</thead>
  			<tbody>
				 <?php 
				 $qty    = 0;
				 $price  = 0;
				 $amount = 0;
				 foreach($list as $arr=>$row){
				 ?>
  			       <tr class="link" data-id="<?php echo $row['iid']?>" data-type="<?php echo $row['billType']?>">
  			       <td><?php echo $row['billDate']?></td>
  			       <td><?php echo $row['billNo']?></td>
  			       <td><?php echo $row['transTypeName']?></td>
  			       <td><?php echo $row['contactName']?></td>
  			       <td><?php echo $row['invNumber']?></td>
  			       <td><?php echo $row['invName']?></td>
  			       <td><?php echo $row['invSpec']?></td>
  			       <td><?php echo $row['mainUnit']?></td>
  			       <td><?php echo $row['locationName']?></td>
  			       <td class="R"><?php echo $row['qty']?></td>
  			       <td class="R"><?php echo $row['price']?></td>
  			       <td class="R"><?php echo $row['amount']?></td>
  			       </tr>
				 <?php 
				 $qty    += $row['qty'];
				 $price  += $row['price'];
				 $amount += $row['amount'];
				 }
				 ?>
  				<tr>
  				<td colspan="9" class="R B">合計：</td>
  				<td class="R B"><?php echo $qty?></td>
  				<td class="R B"><?php echo $price?></td>
  				<td class="R B"><?php echo $amount?></td>
  				</tr>
  			</tbody>
  		</table>
  	</div>
  </div>
  
  
  
</div>
<script src="<?php echo base_url()?>statics/js/dist/puDetail.js?ver=20140430"></script>
</body>
</html>


