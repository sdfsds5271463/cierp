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

<style type="text/css">
#start{margin:0 20px 0 10px; }
#start:hover{color:#fff;}
#userName{font-weight:100;margin:0 20px 0 0;}
#matchCon{width:160px;}
</style>
</head>

<body>
<div class="wrapper">
  <div class="mod-toolbar-top cf">
    <div class="fl">
    	<p class="f14">
    		<lable>授權對像：</lable><span id="userName"></span>
    		<lable>數據類別：</lable><span id="type"></span><a class="ui-label ui-label-success dn" id="start"></a>
    		<span id='searchField'>
    			<input type="text" id="matchCon" class="ui-input matchCon ui-input-ph" value="按類別，編號名稱搜索">
    			<a class="ui-btn mrb" id="search">查詢</a>
    		</span>
		</p>
	</div>
    <div class="fr"><a class="ui-btn ui-btn-sp mrb" id="save">確定</a><a class="ui-btn" href="authority">返回</a></div>
  </div>
  <div class="grid-wrap">
    <table id="grid">
    </table>
    <div id="page"></div>
  </div>
</div>
<script>
$(function(){
	var thisPage = {},
	$typeCombo,
	$type = $('#type'), 
	$start = $('#start'),
	$grid = $("#grid"),
	$matchCon = $('#matchCon'),
	$search = $('#search'),
	$searchField = $('#searchField'),
	urlParam = Public.urlParam(), 
	userName = urlParam.userName, 
	height = Public.setGrid().h,
	typeList = [],
	rightData = [],
	changeList = {},
	queryConditions = {
		userName: userName
	},
	startSwitch = true;//模組點選開關
	$('#userName').text(userName);
	Public.ajaxPost('../dataright/dt?action=dt&userName='+userName, {}, function(data){
			if(data.status === 200) {
				if(data.data&&data.data.items.length){		
					typeList = data.data.items;
					//thisPage.init(data);
					thisPage.init(typeList);
					thisPage.eventHandle();
					thisPage.gridInit();
					$start.hide();
					$searchField.hide();
				}
			} else {
				//parent.Public.tips({type: 1, content : data.msg});
			}
	});  
	thisPage = {
		init : function(data){
			$typeCombo = $type.combo({
				    data: data,
					text: 'FNAME',
					value: 'FRIGHTID',
					width: 160,
					defaultSelected: 0,
					addOptions: {text:'（請選擇數據模組）', value: -1},
					cache: false,
					editable: false,
					listWrapCls:'ui-droplist-wrap f14',
					callback: {
						onChange: function(){
							$grid.jqGrid('clearGridData');
							var _index = this.getSelectedIndex()-1;
							var _selectRow = typeList[_index];	
							if(_selectRow){
								$start.show();
								if(_selectRow.FRIGHT != 0){
									$start.removeClass('ui-label-default').html('已啟用').attr('title','點選關閉該類別許可權');
									$searchField.show();
									$search.trigger('click');
								}else{
									$start.addClass('ui-label-default').html('未啟用').attr('title','點選開啟該類別許可權');
									$searchField.hide();
								}
							}else{
								$start.hide();
								$searchField.hide();
							}
						}
					}
			}).getCombo();
		},
		eventHandle : function(){
			$start.click(function(){
				if(!startSwitch)
					return;
				
				startSwitch = false;//關閉開關，防止使用者連續點選
				var _index = $typeCombo.getSelectedIndex()-1;
				if($start.hasClass('ui-label-default')){
					typeList[_index].FRIGHT = 1;
				}else{
					typeList[_index].FRIGHT = 0;
				}
				var rightids = [];
				for(var i = 0,len = typeList.length; i<len;i++){
					if(typeList[i].FRIGHT > 0 ){
						rightids.push(typeList[i].FRIGHTID);
					}
				}
				Public.ajaxPost('../dataright/ar?action=ar&userName=' + userName ,{rightid:'{"rightids":['+ rightids.join(',') + ']}'}, function(data){
					if(data.status === 200) {	
						if($start.hasClass('ui-label-default')){
							$search.trigger('click');
							$start.removeClass('ui-label-default').html('已啟用').attr('title','點選關閉該類別許可權');
							$searchField.show();
						}else{
							$grid.jqGrid('clearGridData');
							$start.addClass('ui-label-default').html('未啟用').attr('title','點選開啟該類別許可權');
							$searchField.hide();
						}
					} else {
						typeList[_index].FRIGHT = typeList[_index].FRIGHT ? 0 : 1;
						parent.Public.tips({type: 1, content : data.msg});
					}
					startSwitch = true;//重新開啟開關
				}); 
			});
			$('#save').click(function(e){
				  var type = $typeCombo.getValue();
				  var strRights = [];
				  //var ids = $("#grid").jqGrid('getDataIDs');
				  for(var item in changeList){
					  strRights.push('{"FITEMID":'+changeList[item].FITEMID+',"FRIGHT":'+changeList[item].FRIGHT+'}');
				  }
				  if(!strRights.length){
					  parent.Public.tips({type:2,content : '沒有改變！'});
					  return;
				  }
				  /*for(var i = 0, len = ids.length; i < len; i++){
						var id = ids[i], itemData;
						var row = $("#grid").jqGrid('getRowData',id);
						var _right;
						if($('#'+id).hasClass('ui-state-highlight')) {
							 _right = 1;
						} else {
					    	 _right = 0;
					    };
						strRights.push('{FITEMID:'+row.FITEMID+',FRIGHT:'+_right+'}');
				  }*/
				  Public.ajaxPost('../dataright/update?action=update&type='+ type +'&userName=' + userName , {rights:'['+ strRights.join() + ']'}, function(data){
					  if(data.status === 200) {
						  parent.Public.tips({content : '儲存成功！'});
						  changeList = {};//清空臨時許可權改變列表
					  } else {
						  parent.Public.tips({type: 1, content : data.msg});
					  }
				  });
			  });
			$matchCon.placeholder();
			//查詢
			$search.on('click', function(e){
				e.preventDefault();
				changeList = {};//清空臨時許可權改變列表，可以提醒使用者是否儲存變化
				queryConditions.skey = $matchCon.val() === '按類別，編號名稱搜索' ? '' : $.trim($matchCon.val());
				queryConditions.type = $typeCombo.getValue();
				$grid.jqGrid('setGridParam',{page: 1, url:'../dataright/query?action=query', datatype: "json", postData: queryConditions}).trigger("reloadGrid");
			});
			$(window).resize(function(){
				Public.resizeGrid();
			});
		},
		gridInit:function(){
			queryConditions.type = $typeCombo.getValue();
			$grid.jqGrid({
				  url: '../dataright/query?action=query', 
				  postData: queryConditions,
				  datatype: "json",
				  autowidth: true,//如果為ture時，則當表格在首次被建立時會根據父元素比例重新調整表格寬度。如果父元素寬度改變，爲了使表格寬度能夠自動調整則需要實現函式：setGridWidth
				  height:  Public.setGrid().h,
				  altRows: true, //設定隔行顯示
				  colModel:[
				      {name:'FITEMID', label:'ID',width:200,hidden:true},
					  {name:'FNAME', label:'名稱',width:200},
					  {name:'FITEMNO', label:'編號', width:200},
					  {name:'FRIGHT',lable:'許可權',hidden:true}
				  ],
				  multiselect : true,// 多選
				  cmTemplate: {sortable: false, title: false},
				  page: 1, 
				  pager: "#page",  
				  rowNum: 100,  
				  rowList: [100, 200, 500],  
				  //scroll: 1, 
				  gridview: true,
				  //loadonce: true,
				  viewrecords: true,
				  shrinkToFit: false,
				  forceFit: false,
				  localReader: {
					root: "data.rows", 
					records: "data.records", 
					total: "data.total",  
					repeatitems : false,
					id: 'FITEMID'
				  },
				  jsonReader: {
					root: "data.rows", 
					records: "data.records", 
					total: "data.total", 
					repeatitems : false,
					id: 'FITEMID'
				  },
				  loadComplete:function(){
				  },
				  onSelectRow:function(rowid,status){
					  var rowData = $("#grid").jqGrid('getRowData', rowid);
					  rowData.FRIGHT = status ? '1' : '0';
					  $("#grid").jqGrid('setRowData', rowid, rowData);
					  if(changeList[rowid]){
						  delete changeList[rowid];
					  }else{
						  changeList[rowid] = {FITEMID:rowid, FRIGHT:status ? "1" : "0"};
					  }
					},
					gridComplete : function() {
						var _data = $grid.getRowData();
						for ( var i = 0, len = _data.length; i < len; i++) {
							if (_data[i].FRIGHT === "1") {
								$grid.jqGrid('setSelection' , _data[i].FITEMID ,false);
							}
						}
						for(var item in changeList){
							$grid.jqGrid('setSelection' , changeList[item].FITEMID ,false);
							var rowData = $("#grid").jqGrid('getRowData', changeList[item].FITEMID);
							if(rowData){
								rowData.FRIGHT = changeList[item].FRIGHT;
								$("#grid").jqGrid('setRowData', changeList[item].FITEMID, rowData);
							}
						}
					},
					onSelectAll:function(aRowids,status){
						var currentList = {};
						var _data = $grid.getRowData();
						for ( var i = 0, len = _data.length; i < len; i++) {
							currentList[_data[i].FITEMID] = {FITEMID:_data[i].FITEMID, FRIGHT:_data[i].FRIGHT};
						}
						var val = status ? '1' : '0';
						for ( var i = 0, len = _data.length; i < len; i++) {
							var id = _data[i].FITEMID;
							var rowData = $("#grid").jqGrid('getRowData', id);
							rowData.FRIGHT = val;
							$("#grid").jqGrid('setRowData', id, rowData);
							if(currentList[id].FRIGHT !=  val){
								if(changeList[id]){
									delete changeList[id];
								}else{
									changeList[id] = {FITEMID:id, FRIGHT:val};
								}
							}
						}
					}
				});
			}
		};
	});
</script>
</body>
</html>
