define(["jquery", "print"], function(a, b, c) {
	function d() {
		Business.filterSupplier(), k("#filter-fromDate").val(m.beginDate || ""), k("#filter-toDate").val(m.endDate || ""), m.beginDate && m.endDate && k("div.grid-subtitle").text("日期: " + m.beginDate + " 至 " + m.endDate), k("#filter-fromDate, #filter-toDate").datepicker(), Public.dateCheck(), k("#filter-submit").on("click", function(a) {
			a.preventDefault();
			var b = k("#filter-fromDate").val(),
				c = k("#filter-toDate").val();
			return b && c && new Date(b).getTime() > new Date(c).getTime() ? void parent.Public.tips({
				type: 1,
				content: "開始日期不能大於結束日期"
			}) : (m = {
				beginDate: b,
				endDate: c,
				accountNo: k("#supplierAuto").val() || ""
			}, k("div.grid-subtitle").text("日期: " + b + " 至 " + c), void j())
		})
	}
	function e() {
		k("#btn-print").click(function(a) {
			a.preventDefault(), Business.verifyRight("PAYMENTDETAIL_PRINT") && k("div.ui-print").printTable()
		}), k("#btn-export").click(function(a) {
			if (a.preventDefault(), Business.verifyRight("PAYMENTDETAIL_EXPORT")) {
				var b = {};
				for (var c in m) m[c] && (b[c] = m[c]);
				Business.getFile(n, b)
			}
		}), k("#config").click(function(a) {
			p.config()
		})
	}
	function f() {
		var a = !1,
			b = !1,
			c = !1;
		l.isAdmin !== !1 || l.rights.AMOUNT_COSTAMOUNT || (a = !0), l.isAdmin !== !1 || l.rights.AMOUNT_OUTAMOUNT || (b = !0), l.isAdmin !== !1 || l.rights.AMOUNT_INAMOUNT || (c = !0);
		var d = l.serviceType,
			e = "";
		(12 == d || 13 == d) && (e = "支付應付款"), 12 != d && 13 != d && (e = "增加預付款");
		var f = [{
			name: "buName",
			label: "供應商",
			width: 150,
			align: "center"
		}, {
			name: "date",
			label: "單據日期",
			width: 100,
			align: "center"
		}, {
			name: "billNo",
			label: "單據編號",
			width: 110,
			align: "center"
		}, {
			name: "transType",
			label: "業務型別",
			width: 110,
			align: "center"
		}, {
			name: "income",
			label: "增加應付款",
			align: "right",
			width: 120,
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "expenditure",
			label: e,
			width: 120,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "balance",
			label: "應付款餘額",
			width: 120,
			align: "right",
			formatter: "currency",
			formatoptions: {
				thousandsSeparator: ",",
				decimalSeparator: ".",
				decimalPlaces: Number(l.amountPlaces)
			}
		}, {
			name: "billId",
			label: "",
			width: 0,
			align: "center",
			hidden: !0
		}, {
			name: "billTypeNo",
			label: "",
			width: 0,
			align: "center",
			hidden: !0
		}],
			h = "local",
			i = "#";
		m.autoSearch && (h = "json", i = o), p.gridReg("grid", f), f = p.conf.grids.grid.colModel, k("#grid").jqGrid({
			url: i,
			postData: m,
			datatype: h,
			autowidth: !0,
			gridview: !0,
			colModel: f,
			cmTemplate: {
				sortable: !1,
				title: !1
			},
			page: 1,
			sortname: "date",
			sortorder: "desc",
			rowNum: 3e3,
			loadonce: !0,
			viewrecords: !0,
			shrinkToFit: !1,
			forceFit: !0,
			footerrow: !0,
			userDataOnFooter: !0,
			cellLayout: 0,
			jsonReader: {
				root: "data.list",
				userdata: "data.total",
				repeatitems: !1,
				id: "0"
			},
			onCellSelect: function(a) {
				var b = k("#grid").getRowData(a),
					c = b.billId,
					d = b.billTypeNo.toUpperCase();
				switch (d) {
				case "PUR":
					if (!Business.verifyRight("PU_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "purchase-purchase",
						text: "購貨單",
						url: "../scm/invPu?action=editPur&id=" + c
					});
					break;
				case "SALE":
					if (!Business.verifyRight("SA_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "sales-sales",
						text: "銷售單",
						url: "../scm/invSa?action=editSale&id=" + c
					});
					break;
				case "TRANSFER":
					if (!Business.verifyRight("TF_QUERY")) return;

					parent.tab.addTabItem({
						tabid: "storage-transfers",
						text: "調撥單",
						url: "../scm/invTf?action=editTf&id=" + c
					});
					break;
				case "OI":
					if (!Business.verifyRight("IO_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "storage-otherWarehouse",
						text: "其他入庫",
						url: "../scm/invOi?action=editOi&type=in&id=" + c
					});
					break;
				case "OO":
					if (!Business.verifyRight("OO_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "storage-otherOutbound",
						text: "其他出庫",
						url: "../scm/invOi?action=editOi&type=out&id=" + c
					});
					break;
				case "CADJ":
					if (!Business.verifyRight("CADJ_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "storage-adjustment",
						text: "成本調整單",
						url: "../scm/invOi?action=editOi&type=cbtz&id=" + c
					});
					break;
				case "PAYMENT":
					if (!Business.verifyRight("PAYMENT_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "money-payment",
						text: "付款單",
						url: "../scm/payment?action=editPay&id=" + c
					});
					break;
				case "VERIFICA":
					if (!Business.verifyRight("VERIFICA_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "money-verifica",
						text: "覈銷單",
						url: "/money/verification.jsp?id=" + c
					});
					break;
				case "RECEIPT":
					if (!Business.verifyRight("RECEIPT_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "money-receipt",
						text: "收款單",
						url: "../scm/receipt?action=editReceipt&id=" + c
					});
					break;
				case "QTSR":
					if (!Business.verifyRight("QTSR_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "money-otherIncome",
						text: "其它收入單",
						url: "../scm/ori?action=editInc&id=" + c
					});
					break;
				case "QTZC":
					if (!Business.verifyRight("QTZC_QUERY")) return;
					parent.tab.addTabItem({
						tabid: "money-otherExpense",
						text: "其它支出單",
						url: "../scm/ori?action=editExp&id=" + c
					})
				}
			},
			loadComplete: function(a) {
				var b;
				if (a && a.data) {
					var c = a.data.list.length;
					b = c ? 31 * c : 1
				}
				g(b)
			},
			gridComplete: function() {
				k("#grid").footerData("set", {
					transType: "合計:"
				})
			},
			resizeStop: function(a, b) {
				p.setGridWidthByIndex(a, b + 1, "grid")
			}
		}), m.autoSearch ? (k(".no-query").remove(), k(".ui-print").show()) : k(".ui-print").hide()
	}
	function g(a) {
		a && (g.h = a);
		var b = h(),
			c = g.h,
			d = i(),
			e = k("#grid");
		c > d && (c = d), b < e.width() && (c += 17), k("#grid-wrap").height(function() {
			return document.body.clientHeight - this.offsetTop - 36 - 5
		}), e.jqGrid("setGridHeight", c), e.jqGrid("setGridWidth", b, !1)
	}
	function h() {
		return k(window).width() - k("#grid-wrap").offset().left - 36 - 20
	}
	function i() {
		return k(window).height() - k("#grid").offset().top - 36 - 16
	}
	function j() {
		k(".no-query").remove(), k(".ui-print").show(), k("#grid").clearGridData(!0), k("#grid").jqGrid("setGridParam", {
			datatype: "json",
			postData: m,
			url: o
		}).trigger("reloadGrid")
	}
	var k = a("jquery"),
		l = parent.SYSTEM,
		m = k.extend({
			beginDate: "",
			endDate: "",
			accountNo: ""
		}, Public.urlParam()),
		n = "../report/fundBalance_exporterSupplier?action=exporterSupplier&type=10",
		o = "../report/fundBalance_detailSupplier?action=detailSupplier&type=10";
	a("print");
	var p = Public.mod_PageConfig.init("accountPayDetailNew");
	d(), e(), f();
	var q;
	k(window).on("resize", function(a) {
		q || (q = setTimeout(function() {
			g(), q = null
		}, 50))
	})
});