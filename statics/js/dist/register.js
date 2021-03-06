!
function(a) {
	function b() {
		a.ajax({
			url: "../right/isMaxShareUser",
			dataType: "json",
			type: "POST",
			success: function(a) {
				if (200 == a.status) {
					var b = a.data;
					if (b.shareTotal >= b.totalUserNum) return Public.tips({
						type: 2,
						content: "共享使用者已經達到上限值：" + b.totalUserNum
					}), !1
				}
			}
		})
	}
	function c() {
		var b = a.trim(a("#userName").val()),
			c = a('<span class="loading"><i class="ui-incon ui-icon-loading"></i>檢查使用者名稱...</span>').insertAfter(a("#userName"));
		a("#registerForm").data("onPost", !0), a.ajax({
			url: "../right/queryUserByName?userName=" + b,
			dataType: "json",
			type: "POST",
			success: function(b) {
				c.remove(), a("#registerForm").data("onPost", !1), 200 == b.status ? (a("#userName").data("valid", !1), h(a("#userName"), !1, "該使用者名稱已被佔用")) : (a("#userName").data("valid", !0), h(a("#userName"), !0))
			}
		})
	}
	function d() {
		var b = {
			userName: a.trim(a("#realName").val()),
			userNumber: a.trim(a("#userName").val()),
			userMobile: a.trim(a("#userMobile").val()),
			password: a.trim(a("#password").val())
		};
		a("#registerForm").data("onPost", !0), a.ajax({
			url: "../right/addUser",
			data: b,
			type: "POST",
			dataType: "json",
			success: function(c) {
				a("#registerForm").data("onPost", !1), 200 == c.status ? window.location.href = "authority_setting?userName=" + b.userNumber + "&right=0" : Public.tips({
					type: 1,
					content: c.msg
				})
			},
			error: function() {
				a("#registerForm").data("onPost", !1), Public.tips({
					type: 1,
					content: "建立使用者失敗！請重試"
				})
			}
		})
	}
	function e(a) {
		var b, c = 0,
			d = a.length;
		return /\d/.test(a) && c++, /[a-z]/.test(a) && c++, /[A-Z]/.test(a) && c++, /[^a-zA-Z0-9]/.test(a) && c++, 6 > d ? b = 0 : d >= 6 && (b = c), b
	}
	function f(a) {
		for (var b = a.find("input:visible"), c = !0, d = 0, e = b.length; e > d; d++) {
			var f = b.eq(d);
			"undefined" != typeof f.data("valid") ? f.data("valid") || (c = !1, f.addClass("input-error")) : g(f) || (c = !1)
		}
		return c
	}
	function g(b) {
		var c = b.attr("id"),
			d = j[c];
		if (d && d.required) {
			var e = a.trim(b.val());
			for (var f in d) {
				var g, i = !0;
				if ("min" == f) {
					var m = d[f];
					m > e.length && (i = !1)
				} else if ("max" == f) {
					var m = d[f];
					m < e.length && (i = !1)
				} else if ("length" == f) {
					var m = d[f];
					m != e.length && (i = !1)
				} else if ("equalTo" == f) {
					var n = a.trim(a(d[f]).val());
					e != n && (i = !1)
				} else if (l[f]) l[f].test(e) || (i = !1);
				else if ("required" == f) e || (i = !1);
				else if (a.isFunction(d[f])) {
					var o = d[f];
					i = o()
				} else if ("ajaxValid" == f) var p = d[f];
				if (!i) return g = k[c][f], h(b, i, g), b.data("valid", !1), !1
			}
			return p ? a.ajax({
				type: "POST",
				dataType: "json",
				url: p.url,
				success: function(a) {
					return (i = p.success(a)) ? (h(b, i), b.data("valid", !0), !0) : (g = k[c][f], h(b, i, g), b.data("valid", !1), void 0)
				}
			}) : (h(b, i), b.data("valid", !0)), !0
		}
	}
	function h(b, c, d) {
		var e = b.parent().find(".valid-msg");
		0 == e.length && (e = a('<span class="valid-msg"><i /><span /></span>').insertAfter(b)), d = c ? "" : d, c ? (e.addClass("valid-success").removeClass("valid-error"), b.removeClass("input-error")) : (e.addClass("valid-error").removeClass("valid-success"), b.addClass("input-error")), e.show().find(">span").text(d)
	}
	function i(a) {
		a.parent().find("span.valid-msg").hide(), a.removeClass("input-error")
	}
	a(document).ready(function() {
		b()
	});
	var j = {
		userName: {
			required: !0,
			min: 4,
			max: 20,
			userName: !0
		},
		password: {
			required: !0,
			min: 6,
			max: 20,
			notAllNum: !0,
			password: !0
		},
		pswConfirm: {
			required: !0,
			equalTo: "#password"
		},
		realName: {
			required: !0,
			realName: !0
		},
		userMobile: {
			required: !0,
			mobile: !0
		}
	},
		k = {
			userName: {
				required: "請輸入使用者名稱",
				min: "使用者名稱長度應該為4-20位",
				max: "使用者名稱長度應該為4-20位",
				userName: "使用者名稱應該由英文字母或數字組成"
			},
			password: {
				required: "請輸入密碼",
				min: "密碼長度應該為6-20位",
				max: "密碼長度應該為6-20位",
				notAllNum: "密碼不能全為數字",
				password: "密碼應該由英文字母（區分大小寫）或數字或特殊符號組成"
			},
			pswConfirm: {
				required: "請再次輸入密碼",
				equalTo: "兩次輸入的密碼不一致"
			},
			realName: {
				required: "請輸入真實姓名",
				realName: "請輸入真實姓名"
			},
			userMobile: {
				required: "請輸入常用手機",
				mobile: "請輸入正確的手機號碼"
			}
		},
		l = {
			userName: /^[a-zA-Z0-9]{4,20}$/,
			password: /^.*[A-Za-z0-9_-]+.*$/,
			mobile: /^(13|15|18)[0-9]{9}$/,
			notAllNum: /[^0-9]+/,
			realName: /^[A-Za-z\u4e00-\u9fa5]+$/
		};
	a("#registerForm input").on("focus", function() {
		a(this).parent().find(".msg").addClass("msg-focus"), i(a(this)), "password" == a(this).attr("id") && a("#pswStrength").show()
	}).on("blur", function() {
		"undefined" == typeof a(this).data("valid") ? (g(a(this)), "userName" == a(this).attr("id") && a(this).data("valid") && (a(this).removeData("valid"), i(a(this)), c())) : (a(this).data("valid") === !1 && a(this).addClass("input-error"), a(this).parent().find(".valid-msg").show()), a(this).parent().find(".msg").removeClass("msg-focus"), "password" == a(this).attr("id") && a("#pswStrength").hide()
	}).on("change", function() {
		a(this).removeData("valid")
	}), a("#registerBtn").on("click", function(b) {
		b.preventDefault(), f(a("#registerForm")) && !a("#registerForm").data("onPost") && d()
	}), a("#password").on("keyup", function() {
		var b = a.trim(a(this).val()),
			c = e(b);
		a("#pswStrength b").removeClass("on"), a.each(a("#pswStrength b"), function(b, d) {
			b > c - 1 || a(d).addClass("on")
		});
		var d = "密碼強度";
		1 == c ? d += "：弱" : 2 == c ? d += "：中" : 3 == c && (d += "：強"), a("#pswStrength p").text(d)
	})
}(jQuery);