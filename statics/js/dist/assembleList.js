var queryConditions = {
	matchCon: ""
},
	system = parent.SYSTEM,
	qtyPlaces = Number(parent.SYSTEM.qtyPlaces),
	pricePlaces = Number(parent.SYSTEM.pricePlaces),
	amountPlaces = Number(parent.SYSTEM.amountPlaces),
	hiddenAmount = !1;
system.isAdmin !== !1 || system.rights.AMOUNT_COSTAMOUNT || (hiddenAmount = !0);
var THISPAGE = {
	init: function(a) {
		this.mod_PageConfig = Public.mod_PageConfig.init("assembleList"), this.initDom(), this.loadGrid(), this.addEvent()
	},
	initDom: function() {
		this.$_matchCon = $("#matchCon"), this.$_beginDate = $("#beginDate").val(system.beginDate), this.$_endDate = $("#endDate").val(system.endDate), this.$_matchCon.placeholder(), this.$_beginDate.datepicker(), this.$_endDate.datepicker()
	},
	loadGrid: function() {
		function a(a, b, c) {
			var d = '<div class="operating" data-id="' + c.id + '"><span class="ui-icon ui-icon-pencil" title="修改"></span><span class="ui-icon ui-icon-trash" title="刪除"></span></div>';
			return d
		}
		function b(a, b, c) {
			var d;
			if (d = "unitCosts" === b.colModel.name && a ? $.map(a, function(a) {
				return Number(a).toFixed(pricePlaces)
			}) : "costs" === b.colModel.name && a ? $.map(a, function(a) {
				return Number(a).toFixed(amountPlaces)
			}) : a) var e = d.join('<p class="line" />');
			return e || "&#160;"
		}
		var c = Public.setGrid();
		queryConditions.beginDate = this.$_beginDate.val(), queryConditions.endDate = this.$_endDate.val();
		var d = [{
			name: "operating",
			label: "操作",
			width: 60,
			fixed: !0,
			formatter: a,
			align: "center",
			title: !1
		}, {
			name: "billDate",
			label: "單據日期",
			width: 80,
			align: "center",
			title: !1
		}, {
			name: "billNo",
			label: "單據編號",
			width: 120,
			align: "center",
			title: !1
		}, {
			name: "good",
			label: "組合件",
			width: 200,
			title: !0,
			classes: "ui-ellipsis"
		}, {
			name: "qty",
			label: "組合件數量",
			width: 80,
			title: !1
		}, {
			name: "mainUnit",
			label: "單位",
			width: 35,
			title: !1,
			align: "center"
		}, {
			name: "unitCost",
			label: "組合件單位成本",
			width: 100,
			title: !1,
			align: "right",
			formatter: "currency",
			formatoptions: {
				showZero: !0,
				decimalPlaces: pricePlaces
			},
			hidden: hiddenAmount
		}, {
			name: "cost",
			label: "組合件成本",
			width: 80,
			title: !1,
			align: "right",
			hidden: hiddenAmount
		}, {
			name: "goods",
			label: "子件",
			index: "userName",
			formatter: b,
			classes: "ui-ellipsis",
			width: 200,
			fixed: !0,
			title: !0
		}, {
			name: "qtys",
			label: "子件數量",
			width: 80,
			formatter: b,
			classes: "ui-ellipsis"
		}, {
			name: "mainUnits",
			label: "單位",
			width: 35,
			formatter: b,
			classes: "ui-ellipsis",
			align: "center"
		}, {
			name: "unitCosts",
			label: "子件單位成本",
			width: 100,
			formatter: b,
			classes: "ui-ellipsis",
			align: "right",
			hidden: hiddenAmount
		}, {
			name: "costs",
			label: "子件成本",
			width: 80,
			formatter: b,
			classes: "ui-ellipsis",
			align: "right",
			hidden: hiddenAmount
		}, {
			name: "description",
			label: "備註",
			width: 200
		}];
		this.mod_PageConfig.gridReg("grid", d), d = this.mod_PageConfig.conf.grids.grid.colModel, $("#grid").jqGrid({
			url: "../scm/invOi/listZz?action=listZz&type=zz",
			postData: queryConditions,
			datatype: "json",
			autowidth: !0,
			height: c.h,
			altRows: !0,
			gridview: !0,
			multiselect: !0,
			colModel: d,
			cmTemplate: {
				sortable: !1,
				title: !1
			},
			page: 1,
			sortname: "number",
			sortorder: "desc",
			pager: "#page",
			rowNum: 100,
			rowList: [100, 200, 500],
			viewrecords: !0,
			shrinkToFit: !1,
			forceFit: !0,
			jsonReader: {
				root: "data.rows",
				records: "data.records",
				repeatitems: !1,
				id: "id"
			},
			loadError: function(a, b, c) {},
			ondblClickRow: function(a, b, c, d) {
				$("#" + a).find(".ui-icon-pencil").trigger("click")
			},
			resizeStop: function(a, b) {
				THISPAGE.mod_PageConfig.setGridWidthByIndex(a, b, "grid")
			}
		}).navGrid("#page", {
			edit: !1,
			add: !1,
			del: !1,
			search: !1,
			refresh: !1
		}).navButtonAdd("#page", {
			caption: "",
			buttonicon: "ui-icon-config",
			onClickButton: function() {
				THISPAGE.mod_PageConfig.config()
			},
			position: "last"
		})
	},
	reloadData: function(a) {
		$("#grid").jqGrid("setGridParam", {
			url: "../scm/invOi/listZz?action=listZz&type=zz",
			datatype: "json",
			postData: a
		}).trigger("reloadGrid")
	},
	addEvent: function() {
		var a = this;
		$(".grid-wrap").on("click", ".ui-icon-pencil", function(a) {
			a.preventDefault();
			var b = $(this).parent().data("id");
			parent.tab.addTabItem({
				tabid: "storage-assemble",
				text: "組裝單",
				url: "/storage/assemble.jsp?id=" + b
			});
			$("#grid").jqGrid("getDataIDs");
			parent.salesListIds = $("#grid").jqGrid("getDataIDs")
		}), $(".grid-wrap").on("click", ".ui-icon-trash", function(a) {
			if (a.preventDefault(), Business.verifyRight("ZZD_DELETE")) {
				var b = $(this).parent().data("id");
				$.dialog.confirm("您確定要刪除該組裝記錄嗎？", function() {
					Public.ajaxGet("../scm/invOi/deleteZz?action=deleteZz", {
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
		}), $("#search").click(function() {
			queryConditions.matchCon = "請輸入單據號或備註" === a.$_matchCon.val() ? "" : a.$_matchCon.val(), queryConditions.beginDate = a.$_beginDate.val(), queryConditions.endDate = a.$_endDate.val(), THISPAGE.reloadData(queryConditions)
		}), $(".wrapper").on("click", "#print", function(a) {
			a.preventDefault(), Business.verifyRight("ZZD_PRINT") && Public.print({
				title: "組裝單列表",
				$grid: $("#grid"),
				pdf: "../scm/invOi/toZzdPdf?action=toZzdPdf",
				billType: 10419,
				filterConditions: queryConditions
			})
		}), $("#moreCon").click(function() {
			queryConditions.matchCon = a.$_matchCon.val(), queryConditions.beginDate = a.$_beginDate.val(), queryConditions.endDate = a.$_endDate.val(), $.dialog({
				id: "moreCon",
				width: 480,
				height: 330,
				min: !1,
				max: !1,
				title: "高級搜索",
				button: [{
					name: "確定",
					focus: !0,
					callback: function() {
						queryConditions = this.content.handle(queryConditions), THISPAGE.reloadData(queryConditions), "" !== queryConditions.matchCon ? a.$_matchCon.val(queryConditions.matchCon) : a.$_matchCon.val("請輸入單據號或備註"), a.$_beginDate.val(queryConditions.beginDate), a.$_endDate.val(queryConditions.endDate)
					}
				}, {
					name: "取消"
				}],
				resize: !1,
				content: "url:/storage/assemble-search.jsp?type=transfers",
				data: queryConditions
			})
		}), $("#add").click(function(a) {
			a.preventDefault(), Business.verifyRight("ZZD_ADD") && parent.tab.addTabItem({
				tabid: "storage-assemble",
				text: "組裝單",
				url: "../scm/invOi.do?action=initOi&type=zz"
			})
		}), $(window).resize(function() {
			Public.resizeGrid()
		}), $(".wrapper").on("click", "#export", function(a) {
			if (!Business.verifyRight("ZZD_EXPORT")) return void a.preventDefault();
			var b = $("#grid").jqGrid("getGridParam", "selarrrow"),
				c = b.join(),
				d = c ? "&id=" + c : "";
			for (var e in queryConditions) queryConditions[e] && (d += "&" + e + "=" + queryConditions[e]);
			var f = "../scm/invOi/exportInvZzd?action=exportInvZzd" + d;
			$(this).attr("href", f)
		})
	}
};
$(function() {
	THISPAGE.init()
});