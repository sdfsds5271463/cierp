var queryConditions = {
	matchCon: ""
},
	SYSTEM = parent.SYSTEM,
	//VERSION = parent.SYSTEM.siType,
	VERSION = 1,
	billRequiredCheck = 0,
	//billRequiredCheck = system.billRequiredCheck,
	THISPAGE = {
		init: function(a) {
			this.mod_PageConfig = Public.mod_PageConfig.init("receiptList"), this.initDom(), this.loadGrid(), this.addEvent()
		},
		initDom: function() {
			this.$_matchCon = $("#matchCon"), this.$_beginDate = $("#beginDate").val(SYSTEM.beginDate), this.$_endDate = $("#endDate").val(SYSTEM.endDate), this.$_matchCon.placeholder(), this.$_beginDate.datepicker(), this.$_endDate.datepicker()
		},
		loadGrid: function() {
			function a(a, b, c) {
				var d = '<div class="operating" data-id="' + c.id + '"><span class="ui-icon ui-icon-pencil" title="修改"></span><span class="ui-icon ui-icon-trash" title="刪除"></span></div>';
				return d
			}
			var b = $(window).height() - $(".grid-wrap").offset().top - 65,
				c = this,
				d = [{
					name: "operating",
					label: "操作",
					width: 60,
					fixed: !0,
					formatter: a,
					align: "center"
				}, {
					name: "billDate",
					label: "單據日期",
					index: "billDate",
					width: 100,
					align: "center"
				}, {
					name: "billNo",
					label: "單據編號",
					index: "billNo",
					width: 120,
					align: "center"
				}, {
					name: "contactName",
					label: "銷貨單位",
					index: "contactName",
					width: 200
				}, {
					name: "amount",
					label: "收款金額",
					index: "amount",
					width: 100,
					align: "right",
					formatter: "currency"
				}, {
					name: "checkName",
					label: "審覈人",
					index: "checkName",
					width: 80,
					hidden: billRequiredCheck ? !1 : !0,
					fixed: !0,
					align: "center",
					title: !0,
					classes: "ui-ellipsis"
				}, {
					name: "userName",
					label: "制單人",
					index: "userName",
					width: 80,
					fixed: !0,
					align: "center",
					title: !0,
					classes: "ui-ellipsis"
				}];
			switch (VERSION) {
			case 1:
				break;
			case 2:
				d = d.concat([{
					name: "bDeAmount",
					label: "本次覈銷金額",
					index: "hxAmount",
					width: 100,
					align: "right",
					formatter: "currency"
				}, {
					name: "adjustRate",
					label: "整單折扣",
					index: "adjustRate",
					width: 100,
					align: "right",
					formatter: "currency"
				}, {
					name: "deAmount",
					label: "本次預收款",
					index: "deAmount",
					width: 100,
					align: "right",
					formatter: "currency"
				}])
			}
			d.push({
				name: "description",
				label: "備註",
				index: "description",
				width: 200,
				classes: "ui-ellipsis"
			}), queryConditions.beginDate = this.$_beginDate.val(), queryConditions.endDate = this.$_endDate.val(), c.markRow = [], this.mod_PageConfig.gridReg("grid", d), d = this.mod_PageConfig.conf.grids.grid.colModel, $("#grid").jqGrid({
				url: "../scm/receipt?action=list",
				postData: queryConditions,
				datatype: "json",
				autowidth: !0,
				height: b,
				altRows: !0,
				rownumbers: !0,
				gridview: !0,
				colModel: d,
				cmTemplate: {
					sortable: !1,
					title: !1
				},
				multiselect: !0,
				page: 1,
				sortname: "number",
				sortorder: "desc",
				pager: "#page",
				rowNum: 2e3,
				rowList: [300, 500, 1e3],
				scroll: 1,
				loadonce: !0,
				viewrecords: !0,
				shrinkToFit: !1,
				forceFit: !0,
				jsonReader: {
					root: "data.rows",
					records: "data.records",
					repeatitems: !1,
					id: "id"
				},
				loadComplete: function(a) {
					var b = c.markRow.length;
					if (b > 0) for (var d = 0; b > d; d++) $("#" + c.markRow[d]).addClass("red")
				},
				loadError: function(a, b, c) {},
				ondblClickRow: function(a, b, c, d) {
					$("#" + a).find(".ui-icon-pencil").trigger("click")
				},
				resizeStop: function(a, b) {
					THISPAGE.mod_PageConfig.setGridWidthByIndex(a, b - 1, "grid")
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
			this.markRow = [], $("#grid").jqGrid("setGridParam", {
				url: "../scm/receipt?action=list",
				datatype: "json",
				postData: a
			}).trigger("reloadGrid")
		},
		addEvent: function() {
			var a = this;
			if ($(".grid-wrap").on("click", ".ui-icon-pencil", function(a) {
				a.preventDefault();
				var b = $(this).parent().data("id");
				parent.tab.addTabItem({
					tabid: "money-receipt",
					text: "收款單",
					url: "../scm/receipt?action=editReceipt&id=" + b
				});
				$("#grid").jqGrid("getDataIDs");
				parent.receiptListIds = $("#grid").jqGrid("getDataIDs")
			}), $(".grid-wrap").on("click", ".ui-icon-trash", function(a) {
				if (a.preventDefault(), Business.verifyRight("RECEIPT_DELETE")) {
					var b = $(this).parent().data("id");
					$.dialog.confirm("您確定要刪除該收款記錄嗎？", function() {
						Public.ajaxGet("../scm/receipt/delete?action=delete", {
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
				queryConditions.matchCon = "請輸入單據號或客戶或備註" === a.$_matchCon.val() ? "" : a.$_matchCon.val(), queryConditions.beginDate = a.$_beginDate.val(), queryConditions.endDate = a.$_endDate.val(), THISPAGE.reloadData(queryConditions)
			}), $("#refresh").click(function() {
				THISPAGE.reloadData(queryConditions)
			}), $("#add").click(function(a) {
				a.preventDefault(), Business.verifyRight("RECEIPT_ADD") && parent.tab.addTabItem({
					tabid: "money-receipt",
					text: "收款單",
					url: "../scm/receipt?action=initReceipt"
				})
			}), billRequiredCheck) {
				$("#audit").css("display", "inline-block"), $("#reAudit").css("display", "inline-block");
				$(".wrapper").on("click", "#audit", function(a) {
					if (a.preventDefault(), Business.verifyRight("RECEIPT_CHECK")) {
						var b = $("#grid").jqGrid("getGridParam", "selarrrow"),
							c = b.join();
						return c ? void Public.ajaxPost("../scm/receipt/batchCheckReceipt?action=batchCheckReceipt", {
							id: c
						}, function(a) {
							200 === a.status ? parent.Public.tips({
								content: a.msg
							}) : parent.Public.tips({
								type: 1,
								content: a.msg
							}), $("#search").trigger("click")
						}) : void parent.Public.tips({
							type: 2,
							content: "請先選擇需要審覈的項！"
						})
					}
				}), $(".wrapper").on("click", "#reAudit", function(a) {
					if (a.preventDefault(), Business.verifyRight("RECEIPT_UNCHECK")) {
						var b = $("#grid").jqGrid("getGridParam", "selarrrow"),
							c = b.join();
						return c ? void Public.ajaxPost("../scm/receipt/rsbatchCheckReceipt?action=rsbatchCheckReceipt", {
							id: c
						}, function(a) {
							200 === a.status ? parent.Public.tips({
								content: a.msg
							}) : parent.Public.tips({
								type: 1,
								content: a.msg
							}), $("#search").trigger("click")
						}) : void parent.Public.tips({
							type: 2,
							content: "請先選擇需要反審覈的項！"
						})
					}
				})
			}
			$(".wrapper").on("click", "#print", function(a) {
				a.preventDefault(), Business.verifyRight("RECEIPT_PRINT") && Public.print({
					title: "收款單列印",
					$grid: $("#grid"),
					pdf: "../scm/receipt/toPdf?action=toPdf",
					billType: 10601,
					filterConditions: queryConditions
				})
			}), $("#export").click(function(a) {
				if (!Business.verifyRight("RECEIPT_EXPORT")) return void a.preventDefault();
				var b = $("#grid").jqGrid("getGridParam", "selarrrow"),
					c = b.join(),
					d = c ? "&id=" + c : "";
				for (var e in queryConditions) queryConditions[e] && (d += "&" + e + "=" + queryConditions[e]);
				var f = "../scm/receipt/exportReceipt?action=exportReceipt" + d;
				$(this).attr("href", f)
			}), $(window).resize(function() {
				Public.resizeGrid()
			})
		}
	};
$(function() {
	THISPAGE.init()
});

 