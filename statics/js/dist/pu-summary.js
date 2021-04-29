function initFilter() {
	Business.filterSupplier(), Business.filterGoods(), Business.filterStorage(), $("#filter-fromDate, #filter-toDate").datepicker();
	var a = Public.urlParam();
	filterConditions = {
		beginDate: a.beginDate || defParams.beginDate,
		endDate: a.endDate || defParams.endDate,
		customerNo: a.customerNo || "",
		goodsNo: a.goodsNo || "",
		storageNo: a.storageNo || "",
		showSku: a.showSku || "0"
	}, $("#filter-fromDate").val(filterConditions.beginDate || ""), $("#filter-toDate").val(filterConditions.endDate || ""), $("#filter-customer input").val(filterConditions.customerNo || ""), $("#filter-goods input").val(filterConditions.goodsNo || ""), $("#filter-storage input").val(filterConditions.storageNo || ""), filterConditions.beginDate && filterConditions.endDate && $("#selected-period").text(filterConditions.beginDate + "至" + filterConditions.endDate), Public.dateCheck(), "1" === a.showSku && $('#chk-wrap input[name="showSku"]').attr("checked", !0), parent.SYSTEM.enableAssistingProp || $("#chk-wrap").hide(), $(document).on("click", "#ui-datepicker-div,.ui-datepicker-header", function(a) {
		a.stopPropagation()
	}), chkboxes = $("#chk-wrap").cssCheckbox(), Business.moreFilterEvent(), $("#conditions-trigger").trigger("click"), $("#filter-submit").on("click", function(a) {
		a.preventDefault();
		var b = $("#filter-fromDate").val(),
			c = $("#filter-toDate").val();
		if (b && c && new Date(b).getTime() > new Date(c).getTime()) return void parent.Public.tips({
			type: 1,
			content: "開始日期不能大於結束日期"
		});
		filterConditions = {
			beginDate: b,
			endDate: c,
			customerNo: $("#filter-customer input").val() || "",
			goodsNo: $("#filter-goods input").val() || "",
			storageNo: $("#filter-storage input").val() || ""
		}, chkVals = chkboxes.chkVal();
		for (var d = 0, e = chkVals.length; e > d; d++) filterConditions[chkVals[d]] = 1;
		reloadReport()
	}), $("#filter-reset").on("click", function(a) {
		a.preventDefault(), $("#filter-fromDate").val(""), $("#filter-toDate").val(""), $("#filter-customer input").val("").removeData("ids"), $("#filter-goods input").val("").removeData("ids"), $("#filter-storage input").val("").removeData("ids")
	})
}
function initField() {
	var a = filterConditions.customer ? filterConditions.customer.split(",") : "",
		b = filterConditions.goods ? filterConditions.goods.split(",") : "",
		c = "";
	a && b ? c = "「您已選擇了<b>" + a.length + "</b>個客戶，<b>" + b.length + "</b>個商品進行查詢」" : a ? c = "「您已選擇了<b>" + a.length + "</b>個客戶進行查詢」" : b && (c = "「您已選擇了<b>" + b.length + "</b>個商品進行查詢」"), $("#cur-search-tip").html(c)
}
function initEvent() {
	$("#refresh").on("click", function(a) {
		a.preventDefault(), reloadReport()
	}), $("#btn-print").click(function(a) {
		a.preventDefault(), Business.verifyRight("PUREPORTINV_PRINT") && window.print()
	}), $("#btn-export").click(function(a) {
		if (a.preventDefault(), Business.verifyRight("PUREPORTINV_EXPORT")) {
			var b = {};
			for (var c in filterConditions) filterConditions[c] && (b[c] = filterConditions[c]);
			Business.getFile("../report/puDetail_invExporter?action=invExporter", b)
		}
	}), $(".grid-wrap").on("click", ".link", function(a) {
		if (a.preventDefault(), Business.verifyRight("PUREOORTDETAIL_QUERY")) {
			var b = $(this).data("invno"),
				c = $(this).data("locationno"),
				d = Public.urlParam();
			parent.tab.addTabItem({
				tabid: "report-puDetail",
				text: "採購明細表",
				url: "../report/puDetail_detail?action=detail&beginDate=" + filterConditions.beginDate + "&endDate=" + filterConditions.endDate + "&customerNo=" + filterConditions.customerNo + "&goodsNo=" + b + "&storageNo=" + c + "&showSku=" + d.showSku
			}), $(this).addClass("tr-hover"), $_curTr = $(this)
		}
	}), Business.gridEvent()
}
function reloadReport() {
	var a = "";
	for (key in filterConditions) filterConditions[key] && (a += "&" + key + "=" + encodeURIComponent(filterConditions[key]));
	window.location = "../report/puDetail_inv?action=inv" + a
}
var filterConditions = {},
	profitChk, $_curTr;
initFilter(), initEvent(), function() {
	if (Public.isIE6) {
		var a = $("#report-search"),
			b = $(window);
		a.width(b.width()), b.resize(function() {
			a.width(b.width())
		})
	}
}(), $(function() {
	Public.initCustomGrid($("table.list"))
});