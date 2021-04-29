function initFilter() {
	var a = Public.urlParam();
	filterConditions = {
		matchCon: a.matchCon || "",
		customer: a.customer || "",
		supplier: a.supplier || ""
	}, filterConditions.matchCon ? $("#matchCon").val(filterConditions.matchCon || "請輸入客戶、供應商或編號查詢") : ($("#matchCon").addClass("ui-input-ph"), $("#matchCon").placeholder()), filterConditions.customer && $("#customer").attr("checked", !0), filterConditions.supplier && $("#supplier").attr("checked", !0), $("#search").on("click", function(a) {
		a.preventDefault();
		var b = "請輸入客戶、供應商或編號查詢" === $("#matchCon").val() ? "" : $.trim($("#matchCon").val());
		filterConditions = {
			matchCon: b,
			customer: $("#customer").is(":checked") ? 1 : "",
			supplier: $("#supplier").is(":checked") ? 1 : ""
		}, reloadReport()
	})
}
function initField() {
	var a = filterConditions.customer ? filterConditions.customer.split(",") : "",
		b = filterConditions.goods ? filterConditions.goods.split(",") : "",
		c = "";
	a && b ? c = "「您已選擇了<b>" + a.length + "</b>個客戶，<b>" + b.length + "</b>個商品進行查詢」" : a ? c = "「您已選擇了<b>" + a.length + "</b>個客戶進行查詢」" : b && (c = "「您已選擇了<b>" + b.length + "</b>個商品進行查詢」"), $("#cur-search-tip").html(c)
}
function initEvent() {
	$("#btn-print").click(function(a) {
		a.preventDefault(), Business.verifyRight("ContactDebtReport_PRINT") && window.print()
	}), $("#btn-export").click(function(a) {
		if (a.preventDefault(), Business.verifyRight("ContactDebtReport_EXPORT")) {
			var b = {};
			for (var c in filterConditions) filterConditions[c] && (b[c] = filterConditions[c]);
			Business.getFile("report/contactDebt_exporter?action=exporter", b)
		}
	}), Business.gridEvent()
}
function reloadReport() {
	var a = "";
	for (key in filterConditions) filterConditions[key] && (a += "&" + key + "=" + encodeURIComponent(filterConditions[key]));
	window.location = "../report/contactDebt_detail?action=detail" + a
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