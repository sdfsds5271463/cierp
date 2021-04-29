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

<body style="background:#FFF; ">
<div class="wrapper">
  <div class="mod-search-adv">
    <ul>
      <li>
        <label>搜索條件:</label>
        <input type="text" id="matchCon" class="ui-input ui-input-ph con" value="請輸入單據號或客戶名或備註">
      </li>
      <li>
        <label>日期:</label>
        <input type="text" id="beginDate" class="ui-input ui-datepicker-input">
        <i>至</i>
        <input type="text" id="endDate" class="ui-input ui-datepicker-input">
      </li>
      <li>
        <label>調出倉庫:</label>
        <span id="storageA"></span>
        <i>調入倉庫:</i>
        <span id="storageB"></span></li>
    </ul>
  </div>
</div>
<script src="<?php echo base_url()?>statics/js/dist/advSearch.js?2"></script>
</body>
</html>