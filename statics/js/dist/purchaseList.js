var queryConditions = {
	matchCon: ""
},
	SYSTEM = system = parent.SYSTEM,
	hiddenAmount = !1,
	billRequiredCheck = system.billRequiredCheck,
	//billRequiredCheck = 0,
	urlParam = Public.urlParam();
queryConditions.transType = "150502" === urlParam.transType ? "150502" : "150501";
var THISPAGE = {
	init: function() {
		SYSTEM.isAdmin !== !1 || SYSTEM.rights.AMOUNT_INAMOUNT || (hiddenAmount = !0), this.initDom(), this.loadGrid(), this.addEvent()
	},
	initDom: function() {
		this.$_matchCon = $("#matchCon"), this.$_beginDate = $("#beginDate").val(system.beginDate), this.$_endDate = $("#endDate").val(system.endDate), this.$_matchCon.placeholder(), this.$_beginDate.datepicker(), this.$_endDate.datepicker()
	},
	loadGrid: function() {
		function a(a, b, c) {
			var d = '<div class="operating" data-id="' + c.id + '"><a class="ui-icon ui-icon-pencil" title="修改"></a><a class="ui-icon ui-icon-trash" title="刪除"></a></div>';
			return d
		}
		var b = Public.setGrid();
		queryConditions.beginDate = this.$_beginDate.val(), queryConditions.endDate = this.$_endDate.val();
		var c = "150501" == queryConditions.transType ? "付" : "退";
		$("#grid").jqGrid({
			url: "../scm/invPu?action=list",
			postData: queryConditions,
			datatype: "json",
			autowidth: !0,
			height: b.h,
			altRows: !0,
			gridview: !0,
			multiselect: !0,
			colNames: ["操作", "單據日期", "單據編號", "供應商", "購貨金額", "優惠後金額", "已" + c + "款", c + "款狀態", "數量", "制單人", "審覈人", "備註", "訂單來源"],
			colModel: [{
				name: "operating",
				width: 60,
				fixed: !0,
				formatter: a,
				align: "center",
				sortable: !1
			}, {
				name: "billDate",
				index: "billDate",
				width: 100,
				align: "center"
			}, {
				name: "billNo",
				index: "billNo",
				width: 120,
				align: "center"
			}, {
				name: "contactName",
				index: "contactName",
				width: 200
			}, {
				name: "totalAmount",
				index: "totalAmount",
				hidden: hiddenAmount,
				width: 100,
				align: "right",
				formatter: "currency"
			}, {
				name: "amount",
				index: "amount",
				hidden: hiddenAmount,
				width: 100,
				align: "right",
				formatter: "currency"
			}, {
				name: "rpAmount",
				index: "rpAmount",
				hidden: hiddenAmount,
				width: 100,
				align: "right",
				formatter: "currency"
			}, {
				name: "hxStateCode",
				index: "hxStateCode",
				width: 80,
				fixed: !0,
				align: "center",
				title: !0,
				classes: "ui-ellipsis",
				formatter: function(a) {
					switch (a) {
					case 0:
						return "未" + c + "款";
					case 1:
						return "部分" + c + "款";
					case 2:
						return "全部" + c + "款";
					default:
						return "&#160"
					}
				}
			}, {
				name: "totalQty",
				index: "totalQty",
				hidden: hiddenAmount,
				width: 100,
				align: "right",
				formatter: "currency"
			}, {
				name: "userName",
				index: "userName",
				width: 80,
				fixed: !0,
				align: "center",
				title: !0,
				classes: "ui-ellipsis"
			}, {
				name: "checkName",
				index: "checkName",
				width: 80,
				hidden: billRequiredCheck ? !1 : !0,
				fixed: !0,
				align: "center",
				title: !0,
				classes: "ui-ellipsis"
			}, {
				name: "description",
				index: "description",
				width: 200,
				classes: "ui-ellipsis",
				sortable: !1
			}, {
				name: "disEditable",
				label: "不可編輯",
				index: "disEditable",
				hidden: !0
			}],
			cmTemplate: {
				sortable: !0,
				title: !1
			},
			page: 1,
			pager: "#page",
			rowNum: 100,
			rowList: [100, 200, 500],
			viewrecords: !0,
			shrinkToFit: !1,
			forceFit: !1,
			jsonReader: {
				root: "data.rows",
				records: "data.records",
				total: "data.total",
				repeatitems: !1,
				id: "id"
			},
			loadComplete: function(a) {
				if (billRequiredCheck) for (var b = a.data.rows, c = 0; c < b.length; c++) {
					var d = b[c];
					d.checked || $("#" + d.id).addClass("gray")
				}
				"150502" == queryConditions.transType && $("#grid").find(".jqgrow").addClass("red")
			},
			loadError: function() {},
			ondblClickRow: function(a) {
				$("#" + a).find(".ui-icon-pencil").trigger("click")
			}
		})
	},
	reloadData: function(a) {
		$("#grid").jqGrid("setGridParam", {
			url: "../scm/invPu?action=list",
			datatype: "json",
			postData: a
		}).trigger("reloadGrid")
	},
	addEvent: function() {
		var a = this;
		if ($(".grid-wrap").on("click", ".ui-icon-pencil", function(a) {
			a.preventDefault();
			var b = $(this).parent().data("id"),
				c = $("#grid").jqGrid("getRowData", b),
				d = 1 == c.disEditable ? "&disEditable=true" : "",
				e = ($("#grid").jqGrid("getDataIDs"), "購貨單"),
				f = "purchase-purchase";
			"150502" == queryConditions.transType ? (e = "購貨退貨單", f = "purchase-purchaseBack", parent.cacheList.purchaseBackId = $("#grid").jqGrid("getDataIDs")) : parent.cacheList.purchaseId = $("#grid").jqGrid("getDataIDs"), parent.tab.addTabItem({
				tabid: f,
				text: e,
				url: "../scm/invPu?action=editPur&id=" + b + "&flag=list" + d + "&transType=" + queryConditions.transType
			})
		}), $(".grid-wrap").on("click", ".ui-icon-trash", function(a) {
			if (a.preventDefault(), Business.verifyRight("PU_DELETE")) {
				var b = $(this).parent().data("id");
				$.dialog.confirm("您確定要刪除該購貨記錄嗎？", function() {
					Public.ajaxGet("../scm/invPu/delete?action=delete", {
						id: b
					}, function(a) {
						200 === a.status ? ($("#grid").jqGrid("delRowData", b), parent.Public.tips({
							content: "刪除成功！"
						})) : parent.Public.tips({
							type: 1,
							content: a.msg
						})
					})
				})
			}
		}),
		$(".wrapper").on("click", "#btn-batchDel", function(a) {
			if (!Business.verifyRight("PU_DELETE")) return void a.preventDefault();
			var b = $("#grid").jqGrid("getGridParam", "selarrrow"),
				c = b.join();
			if (!c) return void parent.Public.tips({
				type: 2,
				content: "請先選擇需要刪除的項！"
			});
			var d = "購貨單";
			"150502" == queryConditions.transType && (d = "購貨退貨單"), $.dialog.confirm("您確定要刪除選中的" + d + "嗎？", function() {
				Public.ajaxPost("../scm/invPu/delete?action=delete", {
					id: c
				}, function(a) {
					if (200 === a.status && a.msg && a.msg.length) {
						var b = "<p>操作成功！</p>";
						for (var c in a.msg)"function" != typeof a.msg[c] && (c = a.msg[c], b += '<p class="' + (1 == c.isSuccess ? "" : "red") + '">' + d + "［" + c.id + "］刪除" + (1 == c.isSuccess ? "成功！" : "失敗：" + c.msg) + "</p>");
						parent.Public.tips({
							content: b
						})
					} else parent.Public.tips({
						type: 1,
						content: a.msg
					});
					$("#search").trigger("click")
				})
			})
		}), 
			$(".wrapper").on("click", "#print", function(a) {
			a.preventDefault(), Business.verifyRight("PU_PRINT") && Public.print({
				title: "購貨單列表",
				$grid: $("#grid"),
				pdf: "../scm/invPu/toPdf?action=toPdf",
				billType: 10101,
				filterConditions: queryConditions
			})
		}), $(".wrapper").on("click", "#export", function(a) {
			if (!Business.verifyRight("PU_EXPORT")) return void a.preventDefault();
			var b = $("#grid").jqGrid("getGridParam", "selarrrow"),
				c = b.join(),
				d = c ? "&id=" + c : "";
			for (var e in queryConditions) queryConditions[e] && (d += "&" + e + "=" + queryConditions[e]);
			var f = "../scm/invPu/exportInvPu?action=exportInvPu" + d;
			$(this).attr("href", f)
		}), billRequiredCheck) {
			{
				$("#audit").css("display", "inline-block"), $("#reAudit").css("display", "inline-block")
			}
			$(".wrapper").on("click", "#audit", function(a) {
				a.preventDefault();
				var b = $("#grid").jqGrid("getGridParam", "selarrrow"),
					c = b.join();
				return c ? void Public.ajaxPost("../scm/invPu/batchCheckInvPu?action=batchCheckInvPu", {
					id: c
				}, function(a) {
					if (200 === a.status) {
						for (var c = 0, d = b.length; d > c; c++) $("#grid").setCell(b[c], "checkName", system.realName), $("#" + b[c]).removeClass("gray");
						parent.Public.tips({
							content: "審覈成功！"
						})
					} else parent.Public.tips({
						type: 1,
						content: a.msg
					})
				}) : void parent.Public.tips({
					type: 2,
					content: "請先選擇需要審覈的項！"
				})
			}), $(".wrapper").on("click", "#reAudit", function(a) {
				a.preventDefault();
				var b = $("#grid").jqGrid("getGridParam", "selarrrow"),
					c = b.join();
				return c ? void Public.ajaxPost("../scm/invPu/rsBatchCheckInvPu?action=rsBatchCheckInvPu", {
					id: c
				}, function(a) {
					if (200 === a.status) {
						for (var c = 0, d = b.length; d > c; c++) $("#grid").setCell(b[c], "checkName", "&#160;"), $("#" + b[c]).addClass("gray");
						parent.Public.tips({
							content: "反審覈成功！"
						})
					} else parent.Public.tips({
						type: 1,
						content: a.msg
					})
				}) : void parent.Public.tips({
					type: 2,
					content: "請先選擇需要反審覈的項！"
				})
			})
		}
		$("#search").click(function() {
			queryConditions.matchCon = "請輸入單據號或供應商或序列號或備註" === a.$_matchCon.val() ? "" : a.$_matchCon.val(), queryConditions.beginDate = a.$_beginDate.val(), queryConditions.endDate = a.$_endDate.val(), THISPAGE.reloadData(queryConditions)
		}), $("#add").click(function(a) {
			if (a.preventDefault(), Business.verifyRight("PU_ADD")) {
				var b = "購貨單",
					c = "purchase-purchase";
				if ("150502" == queryConditions.transType) var b = "購貨退貨單",
					c = "purchase-purchaseBack";
				parent.tab.addTabItem({
					tabid: c,
					text: b,
					url: "../scm/invPu?action=initPur&transType=" + queryConditions.transType
				})
			}
		}), $(window).resize(function() {
			Public.resizeGrid()
		})
	}
};
THISPAGE.init();