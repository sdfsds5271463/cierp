var $_curTr;
$(function() {
	var a = function(a) {
			var b = Public.urlParam(),
				c = "../report/fundBalance_detail?action=detail",
				d = "../report/fundBalance_exporter?action=exporter";
			$_fromDate = $("#filter-fromDate"), $_toDate = $("#filter-toDate"), $_accountNoInput = $("#customerAuto");
			var e = {
				SALE: {
					tabid: "sales-sales",
					text: "銷貨單",
					right: "SA_QUERY",
					url: "../scm/invsa?action=editSale&id="
				},
				PUR: {
					tabid: "purchase-purchase",
					text: "購貨單",
					right: "PU_QUERY",
					url: "../scm/invpu?action=editPur&id="
				},
				TRANSFER: {
					tabid: "storage-transfers",
					text: "調撥單",
					right: "TF_QUERY",
					url: "../scm/invtf?action=editTf&id="
				},
				OO: {
					tabid: "storage-otherOutbound",
					text: "其它出庫 ",
					right: "OO_QUERY",
					url: "../scm/invOi?action=editOi&type=in&id="
				},
				OI: {
					tabid: "storage-otherWarehouse",
					text: "其它入庫 ",
					right: "IO_QUERY",
					url: "../scm/invOi?action=editOi&type=out&id="
				},
				CADJ: {
					tabid: "storage-adjustment",
					text: "成本調整",
					right: "CADJ_QUERY",
					url: "../storage/adjustment.jsp?id="
				},
				PAYMENT: {
					tabid: "money-payment",
					text: "付款單",
					right: "PAYMENT_QUERY",
					url: "../scm/payment?action=editPay&id="
				},
				RECEIPT: {
					tabid: "money-receipt",
					text: "收款單",
					right: "RECEIPT_QUERY",
					url: "../scm/receipt?action=editReceipt&id="
				},
				VERIFICA: {
					tabid: "money-verifica",
					text: "覈銷單 ",
					right: "VERIFICA_QUERY",
					url: "../money/verification.jsp?id="
				}
			},
				f = {
					beginDate: b.beginDate || defParams.beginDate,
					endDate: b.endDate || defParams.endDate,
					accountNo: b.accountNo || ""
				},
				g = function() {
					$_fromDate.datepicker(), $_toDate.datepicker()
				},
				h = function() {
					Business.moreFilterEvent(), $("#conditions-trigger").trigger("click")
				},
				i = function() {
					var a = "";
					for (key in f) f[key] && (a += "&" + key + "=" + encodeURIComponent(f[key]));
					window.location = c + a
				},
				j = function() {
					$("#filter-submit").on("click", function(a) {
						a.preventDefault();
						var b = $_fromDate.val(),
							c = $_toDate.val();
						return b && c && new Date(b).getTime() > new Date(c).getTime() ? void parent.Public.tips({
							type: 1,
							content: "開始日期不能大於結束日期"
						}) : (f = {
							beginDate: b,
							endDate: c,
							accountNo: $_accountNoInput.val() || ""
						}, void i())
					}), $(document).on("click", "#ui-datepicker-div,.ui-datepicker-header", function(a) {
						a.stopPropagation()
					}), $("#filter-reset").on("click", function(a) {
						a.preventDefault(), $_fromDate.val(""), $_toDate.val(""), $_accountNoInput.val("")
					}), $("#refresh").on("click", function(a) {
						a.preventDefault(), i()
					}), $("#btn-print").click(function(a) {
						a.preventDefault(), Business.verifyRight("RECEIPTDETAIL_PRINT") && window.print()
					}), $("#btn-export").click(function(a) {
						if (a.preventDefault(), Business.verifyRight("RECEIPTDETAIL_EXPORT")) {
							var b = {};
							for (var c in f) f[c] && (b[c] = f[c]);
							Business.getFile(d, b)
						}
					}), $(".grid-wrap").on("click", ".link", function() {
						var a = $(this).data("id"),
							b = $(this).data("type").toLocaleUpperCase(),
							c = e[b];
						c && Business.verifyRight(c.right) && (parent.tab.addTabItem({
							tabid: c.tabid,
							text: c.text,
							url: c.url + a
						}), $(this).addClass("tr-hover"), $_curTr = $(this))
					}), Business.gridEvent()
				};
			return a.init = function() {
				$_fromDate.val(f.beginDate || ""), $_toDate.val(f.endDate || ""), $_accountNoInput.val(f.accountNo || ""), f.beginDate && f.endDate && $("#selected-period").text(f.beginDate + "至" + f.endDate), Business.filterCustomer(), $("#customerAuto").val(""), g(), h(), j()
			}, a
		}(a || {});
	a.init(), Public.initCustomGrid($("table.list"))
});