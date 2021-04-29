<?php $this->load->view('header');?>

<script type="text/javascript">
var DOMAIN = document.domain;
var WDURL = "";
var SCHEME= "<?php echo sys_skin()?>";
try{
	document.domain = '<?php echo base_url()?>';
}catch(e){
}
</script>

</head>

<body>
<div class="wrapper">
  <div class="mod-toolbar-top cf">
    <div class="fl"><h3 class="f14">詳細許可權設定<span class="fwn">（請勾選為 <b id="userName"></b> 分配的許可權）</span></h3></div>
    <div class="fr"><a class="ui-btn ui-btn-sp mrb" id="save">確定</a><a class="ui-btn" href="<?php echo site_url('settings/authority')?>">返回</a></div>
  </div>
  <div class="grid-wrap">
    <table id="grid">
    </table>
    <div id="page"></div>
  </div>
</div>
<script>
  var urlParam = Public.urlParam(), userName = urlParam.userName, curGroup;
  var height = Public.setGrid().h;
  var relation = {
			"購貨單":[{name:'商品',rights:['查詢']},{name:'倉庫',rights:['查詢']},{name:'供應商',rights:['查詢']}],
			"銷貨單":[{name:'商品',rights:['查詢']},{name:'倉庫',rights:['查詢']},{name:'客戶',rights:['查詢']}],
			"調撥單":[{name:'商品',rights:['查詢']},{name:'倉庫',rights:['查詢']}]
	},
	$grid = $('#grid'),
	RelationalMapping = {};//Rowid與名字的對映
  $('#userName').text(userName);
  $("#grid").jqGrid({
	  url:'../right/queryalluserright?userName=' + userName,
	  datatype: "json",
	  //caption: "科目餘額表",
	  autowidth: true,//如果為ture時，則當表格在首次被建立時會根據父元素比例重新調整表格寬度。如果父元素寬度改變，爲了使表格寬度能夠自動調整則需要實現函式：setGridWidth
	  //width: width,
	  height: height,
	  altRows: true, //設定隔行顯示
	  //rownumbers: true,//如果為ture則會在表格左邊新增一列，顯示行順序號，從1開始遞增。此列名為'rn'
	  //gridview: true,
	  colNames:['<input type="checkbox" id="all" class="vm">', '功能列表', '操作', '<label for="all">授權</label>'],
	  colModel:[
	  	  {name:'fobjectid', width:40, align:"center", formatter:groupFmatter},
		  {name:'fobject', width:200, formatter:moduleFmatter},
		  {name:'faction', width:150, align:"center"},
		  {name:'fright', width:100, align:"center", formatter:rightFmatter}
	  ],
	  cmTemplate: {sortable: false, title: false},
	  //idPrefix: 'ys',
	  //loadui: 'block',
	  //multiselect: true,
	  //multiboxonly: true,
	  page: 1, 
	  sortname: 'number',    
	  sortorder: "desc", 
	  pager: "#page",  
	  rowNum: 2000,  
	  rowList:[300,500,1000],     
	  scroll: 1, //建立一個動態滾動的表格，當爲true時，翻頁欄被禁用，使用垂直滾動條載入數據，且在首次訪問伺服器端時將載入所有數據到客戶端。當此參數為數字時，表格只控制可見的幾行，所有數據都在這幾行中載入
	  loadonce: true,
	  viewrecords: true,
	  shrinkToFit: false,
	  forceFit: false,
	  jsonReader: {
		root: "data.items", 
		records: "data.totalsize",  
		repeatitems : false,
		id: -1
	  },
	  afterInsertRow: function(rowid, rowdata, rowelem) {
		
	  },
	  loadComplete: function(data) {
	  	$('.group').each(function(index, element) {
			 var groupId = $(this).attr('id');
			 var $_ckbox = $('.ckbox[data-for=' + groupId + ']');
			 if($_ckbox.length === $_ckbox.filter(':checked').length) {
				this.checked = true;
			 };
        }); 
	  	initRelation();
	  },
	  loadError: function(xhr,st,err) {
		  
	  }
  });
  
  function groupFmatter(val, opt, row){
	if(curGroup !== val){
		return '<input class="group" type="checkbox" id="'  + val + '">';
	} else {
		return '';
	};
  };
  function moduleFmatter(val, opt, row){
	fillMap(val, opt ,row);//快取對映關係
	if(curGroup !== row.fobjectid){
		curGroup = row.fobjectid;
		return val;
	} else {
		return '';
	};
  };
  
  function rightFmatter(val, opt, row){
	var html_str = '<input type="checkbox" class="ckbox" data-for="' + row.fobjectid + '" data-id="' + row.frightid + '"';
	if(row.faction === '查詢') {
		html_str = html_str + 'data-view="true"';
	};
	if(val > 0){
		return html_str + ' checked="checked">';
	} else {
		return html_str + '>';
	};
  };
  
  $('#all').click(function(e){
	  e.stopPropagation();
	  if(this.checked) {
		$('.ckbox').each(function(){
			this.checked = true;
		});	
		$('.group').each(function(){
			this.checked = true;
		});	
	  } else {
		 $('.ckbox').removeAttr('checked');
		 $('.group').removeAttr('checked');
	  }
  });
  $('#save').click(function(e){
	  var items = [];
	  $('.ckbox').each(function(i){
		  if(this.checked) {
			 items.push($(this).data('id'));
	      }
	  });
	  //Public.ajaxPost('../right/addRights2OutUser?userName=' + userName + '&rightid={rightids:['+ items.join(',') + ']}', {}, function(data){
	  Public.ajaxPost('../right/addRights2OutUser?userName=' + userName + '&rightid='+ items.join(','), {}, function(data){
		  if(data.status === 200) {
			  parent.Public.tips({content : '儲存成功！'});
		  } else {
			  parent.Public.tips({type: 1, content : data.msg});
		  }
	  });
  });
  $('.grid-wrap').on('click', '.group', function(){
	 var groupId = $(this).attr('id');
	 if(this.checked) {
		$('.ckbox[data-for=' + groupId + ']').each(function(){
			this.checked = true;
		});	
	 } else {
		$('.ckbox[data-for=' + groupId + ']').removeAttr('checked');
	 };
	 $(this).closest('tr').find('input').filter('[data-view=true]').trigger('checkChange');
  });
  $('.grid-wrap').on('click', '.ckbox', function(){
	 var groupId = $(this).data('for');
	 var $_group = $('.ckbox[data-for=' + groupId + ']'), $_view = $_group.filter('[data-view=true]'), $_others = $_group.not('[data-view=true]');
	 if(!$(this).data('view')) {
		if(this.checked && $_view.length > 0) {
	 		$_view[0].checked = true;
		};
	 } else {
	 	if($_others.length > 0 && $_others.filter(':checked').length > 0) {
			this.checked = true;
		};
	 };
	 $_view.trigger('checkChange');
	 if($_group.length === $_group.filter(':checked').length) {
		$('#' + groupId)[0].checked = true;
	 } else {
		$('#' + groupId).removeAttr('checked');
	 };
  });
/**
 * 關聯許可權處理
 */
 function fillMap(val, opt ,row){
		RelationalMapping[val+"-"+row.faction] = opt.rowId;
}
 function initRelation(){  
	 $grid.find('input').filter('[data-view=true]').each(function(){
		setRelativeRight($(this));
	});
 };
 function setRelativeRight(view){
	 var _modelName = view.closest('tr').find('td:eq(1)').html();
	 if(relation[_modelName]){
		 view.on('checkChange',function(){
			 var _arr = relation[_modelName];
			 var _isChecked = this.checked;
			 for(var i = 0,len = _arr.length; i < len; i++){
				 var _name = _arr[i].name;
				 var _rights = _arr[i].rights;
				 for(var j=0,l = _rights.length; j<l; j++){
					 var _proName = _arr[i].name+"-"+_rights[j];
					 var _rid = RelationalMapping[_proName];
					 if(!_arr[i].ckbox){
						 _arr[i].ckbox = {};
					 }
					 if(!_arr[i].ckbox[_proName]){
					 	_arr[i].ckbox[_proName] = $('#'+_rid).find('.ckbox')[0];//快取目前對像
					 }
					 if(_isChecked){
						 //如果主許可權獲得，則做以下處理
						 _arr[i].ckbox[_proName].checked = true;
					 }
					 else{
						 //如果主許可權取消，則做以下處理
					 }
				 }
			 }
			 this.checked = _isChecked;
		 });
	 }
}
</script>
</body>
</html>