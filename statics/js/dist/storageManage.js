function initField() {
	rowData.id && ($("#number").val(rowData.locationNo), $("#name").val(rowData.name))
}
function initEvent() {
	var a = $("#number");
	Public.limitInput(a, /^[a-zA-Z0-9\-_]*$/), Public.bindEnterSkip($("#manage-wrap"), postData, oper, rowData.id), initValidator(), a.focus().select()
}
function initPopBtns() {
	var a = "add" == oper ? ["儲存", "關閉"] : ["確定", "取消"];
	api.button({
		id: "confirm",
		name: a[0],
		focus: !0,
		callback: function() {
			return postData(oper, rowData.id), !1
		}
	}, {
		id: "cancel",
		name: a[1]
	})
}
function initValidator() {
	$.validator.addMethod("number", function(a) {
		return /^[a-zA-Z0-9\-_]*$/.test(a)
	}), $("#manage-form").validate({
		rules: {
			number: {
				required: !0,
				number: !0
			},
			name: {
				required: !0
			}
		},
		messages: {
			number: {
				required: "倉庫編號不能為空",
				number: "倉庫編號只能由數字、字母、-或_等字元組成"
			},
			name: {
				required: "倉庫名稱不能為空"
			}
		},
		errorClass: "valid-error"
	})
}
function postData(a, b) {
	if (!$("#manage-form").validate().form()) return void $("#manage-form").find("input.valid-error").eq(0).focus();
	var c = $.trim($("#number").val()),
		d = $.trim($("#name").val()),
		e = "add" == a ? "新增倉庫" : "修改倉庫";
	params = rowData.id ? {
		locationId: b,
		locationNo: c,
		name: d,
		isDelete: rowData["delete"]
	} : {
		locationNo: c,
		name: d,
		isDelete: !1
	}, Public.ajaxPost("../basedata/invlocation/" + ("add" == a ? "add" : "update"), params, function(b) {
		200 == b.status ? (parent.parent.Public.tips({
			content: e + "成功！"
		}), callback && "function" == typeof callback && callback(b.data, a, window)) : parent.parent.Public.tips({
			type: 1,
			content: e + "失敗！" + b.msg
		})
	})
}
function resetForm(a) {
	$("#manage-form").validate().resetForm(), $("#name").val(""), $("#number").val(Public.getSuggestNum(a.locationNo)).focus().select()
}
var api = frameElement.api,
	oper = api.data.oper,
	rowData = api.data.rowData || {},
	callback = api.data.callback;
initPopBtns(), initField(), initEvent();