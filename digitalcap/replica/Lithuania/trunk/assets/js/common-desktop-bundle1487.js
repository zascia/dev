function clearScriptTags(e) {
    return "undefined" == typeof e || null == e ? "" : (re = /<script[^>]*>(.*?)<\/script>/gi, e.replace(re, ""))
}

function obj(e, t, n, r, i) {
    return "undefined" != typeof i && "" != i || (i = t + n + Math.random()), "undefined" != typeof r && "" != r || (r = "transparent"), clid = "", 1 == $.browser.msie && (clid = ' classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" '), o = '<object width="' + t + '" height="' + n + '" pluginspage="http://www.macromedia.com/go/getflashplayer" data="' + e + '" type="application/x-shockwave-flash" id="' + i + '" ' + clid + " >", o += '<param value="' + e + '" name="movie">', o += '<param value="' + r + '" name="wmode">', o += '<param value="always" name="allowScriptAccess">', o += "</object>", o
}! function(e, t) {
    function n(e) {
        return H.isWindow(e) ? e : 9 === e.nodeType && (e.defaultView || e.parentWindow)
    }

    function r(e) {
        if (!bt[e]) {
            var t = M.body,
                n = H("<" + e + ">").appendTo(t),
                r = n.css("display");
            n.remove(), "none" !== r && "" !== r || (mt || (mt = M.createElement("iframe"), mt.frameBorder = mt.width = mt.height = 0), t.appendChild(mt), gt && mt.createElement || (gt = (mt.contentWindow || mt.contentDocument).document, gt.write(("CSS1Compat" === M.compatMode ? "<!doctype html>" : "") + "<html><body>"), gt.close()), n = gt.createElement(e), gt.body.appendChild(n), r = H.css(n, "display"), t.removeChild(mt)), bt[e] = r
        }
        return bt[e]
    }

    function i(e, t) {
        var n = {};
        return H.each(Tt.concat.apply([], Tt.slice(0, t)), function() {
            n[this] = e
        }), n
    }

    function o() {
        vt = t
    }

    function a() {
        return setTimeout(o, 0), vt = H.now()
    }

    function s() {
        try {
            return new e.ActiveXObject("Microsoft.XMLHTTP")
        } catch (t) {}
    }

    function l() {
        try {
            return new e.XMLHttpRequest
        } catch (t) {}
    }

    function u(e, n) {
        e.dataFilter && (n = e.dataFilter(n, e.dataType));
        var r, i, o, a, s, l, u, c, f = e.dataTypes,
            d = {},
            p = f.length,
            h = f[0];
        for (r = 1; r < p; r++) {
            if (1 === r)
                for (i in e.converters) "string" == typeof i && (d[i.toLowerCase()] = e.converters[i]);
            if (a = h, h = f[r], "*" === h) h = a;
            else if ("*" !== a && a !== h) {
                if (s = a + " " + h, l = d[s] || d["* " + h], !l) {
                    c = t;
                    for (u in d)
                        if (o = u.split(" "), (o[0] === a || "*" === o[0]) && (c = d[o[1] + " " + h])) {
                            u = d[u], u === !0 ? l = c : c === !0 && (l = u);
                            break
                        }
                }!l && !c && H.error("No conversion from " + s.replace(" ", " to ")), l !== !0 && (n = l ? l(n) : c(u(n)))
            }
        }
        return n
    }

    function c(e, n, r) {
        var i, o, a, s, l = e.contents,
            u = e.dataTypes,
            c = e.responseFields;
        for (o in c) o in r && (n[c[o]] = r[o]);
        for (;
            "*" === u[0];) u.shift(), i === t && (i = e.mimeType || n.getResponseHeader("content-type"));
        if (i)
            for (o in l)
                if (l[o] && l[o].test(i)) {
                    u.unshift(o);
                    break
                } if (u[0] in r) a = u[0];
        else {
            for (o in r) {
                if (!u[0] || e.converters[o + " " + u[0]]) {
                    a = o;
                    break
                }
                s || (s = o)
            }
            a = a || s
        }
        if (a) return a !== u[0] && u.unshift(a), r[a]
    }

    function f(e, t, n, r) {
        if (H.isArray(t)) H.each(t, function(t, i) {
            n || ze.test(e) ? r(e, i) : f(e + "[" + ("object" == typeof i || H.isArray(i) ? t : "") + "]", i, n, r)
        });
        else if (n || null == t || "object" != typeof t) r(e, t);
        else
            for (var i in t) f(e + "[" + i + "]", t[i], n, r)
    }

    function d(e, n) {
        var r, i, o = H.ajaxSettings.flatOptions || {};
        for (r in n) n[r] !== t && ((o[r] ? e : i || (i = {}))[r] = n[r]);
        i && H.extend(!0, e, i)
    }

    function p(e, n, r, i, o, a) {
        o = o || n.dataTypes[0], a = a || {}, a[o] = !0;
        for (var s, l = e[o], u = 0, c = l ? l.length : 0, f = e === at; u < c && (f || !s); u++) s = l[u](n, r, i), "string" == typeof s && (!f || a[s] ? s = t : (n.dataTypes.unshift(s), s = p(e, n, r, i, s, a)));
        return (f || !s) && !a["*"] && (s = p(e, n, r, i, "*", a)), s
    }

    function h(e) {
        return function(t, n) {
            if ("string" != typeof t && (n = t, t = "*"), H.isFunction(n))
                for (var r, i, o, a = t.toLowerCase().split(nt), s = 0, l = a.length; s < l; s++) r = a[s], o = /^\+/.test(r), o && (r = r.substr(1) || "*"), i = e[r] = e[r] || [], i[o ? "unshift" : "push"](n)
        }
    }

    function m(e, t, n) {
        var r = "width" === t ? e.offsetWidth : e.offsetHeight,
            i = "width" === t ? We : Ie,
            o = 0,
            a = i.length;
        if (r > 0) {
            if ("border" !== n)
                for (; o < a; o++) n || (r -= parseFloat(H.css(e, "padding" + i[o])) || 0), "margin" === n ? r += parseFloat(H.css(e, n + i[o])) || 0 : r -= parseFloat(H.css(e, "border" + i[o] + "Width")) || 0;
            return r + "px"
        }
        if (r = Le(e, t, t), (r < 0 || null == r) && (r = e.style[t] || 0), r = parseFloat(r) || 0, n)
            for (; o < a; o++) r += parseFloat(H.css(e, "padding" + i[o])) || 0, "padding" !== n && (r += parseFloat(H.css(e, "border" + i[o] + "Width")) || 0), "margin" === n && (r += parseFloat(H.css(e, n + i[o])) || 0);
        return r + "px"
    }

    function g(e, t) {
        t.src ? H.ajax({
            url: t.src,
            async: !1,
            dataType: "script"
        }) : H.globalEval((t.text || t.textContent || t.innerHTML || "").replace(Se, "/*$0*/")), t.parentNode && t.parentNode.removeChild(t)
    }

    function y(e) {
        var t = M.createElement("div");
        return je.appendChild(t), t.innerHTML = e.outerHTML, t.firstChild
    }

    function v(e) {
        var t = (e.nodeName || "").toLowerCase();
        "input" === t ? b(e) : "script" !== t && "undefined" != typeof e.getElementsByTagName && H.grep(e.getElementsByTagName("input"), b)
    }

    function b(e) {
        "checkbox" !== e.type && "radio" !== e.type || (e.defaultChecked = e.checked)
    }

    function x(e) {
        return "undefined" != typeof e.getElementsByTagName ? e.getElementsByTagName("*") : "undefined" != typeof e.querySelectorAll ? e.querySelectorAll("*") : []
    }

    function w(e, t) {
        var n;
        1 === t.nodeType && (t.clearAttributes && t.clearAttributes(), t.mergeAttributes && t.mergeAttributes(e), n = t.nodeName.toLowerCase(), "object" === n ? t.outerHTML = e.outerHTML : "input" !== n || "checkbox" !== e.type && "radio" !== e.type ? "option" === n ? t.selected = e.defaultSelected : "input" !== n && "textarea" !== n || (t.defaultValue = e.defaultValue) : (e.checked && (t.defaultChecked = t.checked = e.checked), t.value !== e.value && (t.value = e.value)), t.removeAttribute(H.expando))
    }

    function T(e, t) {
        if (1 === t.nodeType && H.hasData(e)) {
            var n, r, i, o = H._data(e),
                a = H._data(t, o),
                s = o.events;
            if (s) {
                delete a.handle, a.events = {};
                for (n in s)
                    for (r = 0, i = s[n].length; r < i; r++) H.event.add(t, n + (s[n][r].namespace ? "." : "") + s[n][r].namespace, s[n][r], s[n][r].data)
            }
            a.data && (a.data = H.extend({}, a.data))
        }
    }

    function N(e, t) {
        return H.nodeName(e, "table") ? e.getElementsByTagName("tbody")[0] || e.appendChild(e.ownerDocument.createElement("tbody")) : e
    }

    function C(e) {
        var t = me.split("|"),
            n = e.createDocumentFragment();
        if (n.createElement)
            for (; t.length;) n.createElement(t.pop());
        return n
    }

    function E(e, t, n) {
        if (t = t || 0, H.isFunction(t)) return H.grep(e, function(e, r) {
            var i = !!t.call(e, r, e);
            return i === n
        });
        if (t.nodeType) return H.grep(e, function(e, r) {
            return e === t === n
        });
        if ("string" == typeof t) {
            var r = H.grep(e, function(e) {
                return 1 === e.nodeType
            });
            if (fe.test(t)) return H.filter(t, r, !n);
            t = H.filter(t, r)
        }
        return H.grep(e, function(e, r) {
            return H.inArray(e, t) >= 0 === n
        })
    }

    function k(e) {
        return !e || !e.parentNode || 11 === e.parentNode.nodeType
    }

    function S() {
        return !0
    }

    function A() {
        return !1
    }

    function j(e, t, n) {
        var r = t + "defer",
            i = t + "queue",
            o = t + "mark",
            a = H._data(e, r);
        a && ("queue" === n || !H._data(e, i)) && ("mark" === n || !H._data(e, o)) && setTimeout(function() {
            !H._data(e, i) && !H._data(e, o) && (H.removeData(e, r, !0), a.fire())
        }, 0)
    }

    function L(e) {
        for (var t in e)
            if (("data" !== t || !H.isEmptyObject(e[t])) && "toJSON" !== t) return !1;
        return !0
    }

    function D(e, n, r) {
        if (r === t && 1 === e.nodeType) {
            var i = "data-" + n.replace(W, "-$1").toLowerCase();
            if (r = e.getAttribute(i), "string" == typeof r) {
                try {
                    r = "true" === r || "false" !== r && ("null" === r ? null : H.isNumeric(r) ? parseFloat(r) : q.test(r) ? H.parseJSON(r) : r)
                } catch (o) {}
                H.data(e, n, r)
            } else r = t
        }
        return r
    }

    function F(e) {
        var t, n, r = B[e] = {};
        for (e = e.split(/\s+/), t = 0, n = e.length; t < n; t++) r[e[t]] = !0;
        return r
    }
    var M = e.document,
        _ = e.navigator,
        O = e.location,
        H = function() {
            function n() {
                if (!s.isReady) {
                    try {
                        M.documentElement.doScroll("left")
                    } catch (e) {
                        return void setTimeout(n, 1)
                    }
                    s.ready()
                }
            }
            var r, i, o, a, s = function(e, t) {
                    return new s.fn.init(e, t, r)
                },
                l = e.jQuery,
                u = e.$,
                c = /^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,
                f = /\S/,
                d = /^\s+/,
                p = /\s+$/,
                h = /^<(\w+)\s*\/?>(?:<\/\1>)?$/,
                m = /^[\],:{}\s]*$/,
                g = /\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,
                y = /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
                v = /(?:^|:|,)(?:\s*\[)+/g,
                b = /(webkit)[ \/]([\w.]+)/,
                x = /(opera)(?:.*version)?[ \/]([\w.]+)/,
                w = /(msie) ([\w.]+)/,
                T = /(mozilla)(?:.*? rv:([\w.]+))?/,
                N = /-([a-z]|[0-9])/gi,
                C = /^-ms-/,
                E = function(e, t) {
                    return (t + "").toUpperCase()
                },
                k = _.userAgent,
                S = Object.prototype.toString,
                A = Object.prototype.hasOwnProperty,
                j = Array.prototype.push,
                L = Array.prototype.slice,
                D = String.prototype.trim,
                F = Array.prototype.indexOf,
                O = {};
            return s.fn = s.prototype = {
                constructor: s,
                init: function(e, n, r) {
                    var i, o, a, l;
                    if (!e) return this;
                    if (e.nodeType) return this.context = this[0] = e, this.length = 1, this;
                    if ("body" === e && !n && M.body) return this.context = M, this[0] = M.body, this.selector = e, this.length = 1, this;
                    if ("string" == typeof e) {
                        if (i = "<" !== e.charAt(0) || ">" !== e.charAt(e.length - 1) || e.length < 3 ? c.exec(e) : [null, e, null], i && (i[1] || !n)) {
                            if (i[1]) return n = n instanceof s ? n[0] : n, l = n ? n.ownerDocument || n : M, a = h.exec(e), a ? s.isPlainObject(n) ? (e = [M.createElement(a[1])], s.fn.attr.call(e, n, !0)) : e = [l.createElement(a[1])] : (a = s.buildFragment([i[1]], [l]), e = (a.cacheable ? s.clone(a.fragment) : a.fragment).childNodes), s.merge(this, e);
                            if (o = M.getElementById(i[2]), o && o.parentNode) {
                                if (o.id !== i[2]) return r.find(e);
                                this.length = 1, this[0] = o
                            }
                            return this.context = M, this.selector = e, this
                        }
                        return !n || n.jquery ? (n || r).find(e) : this.constructor(n).find(e)
                    }
                    return s.isFunction(e) ? r.ready(e) : (e.selector !== t && (this.selector = e.selector, this.context = e.context), s.makeArray(e, this))
                },
                selector: "",
                jquery: "1.7.1",
                length: 0,
                size: function() {
                    return this.length
                },
                toArray: function() {
                    return L.call(this, 0)
                },
                get: function(e) {
                    return null == e ? this.toArray() : e < 0 ? this[this.length + e] : this[e]
                },
                pushStack: function(e, t, n) {
                    var r = this.constructor();
                    return s.isArray(e) ? j.apply(r, e) : s.merge(r, e), r.prevObject = this, r.context = this.context, "find" === t ? r.selector = this.selector + (this.selector ? " " : "") + n : t && (r.selector = this.selector + "." + t + "(" + n + ")"), r
                },
                each: function(e, t) {
                    return s.each(this, e, t)
                },
                ready: function(e) {
                    return s.bindReady(), o.add(e), this
                },
                eq: function(e) {
                    return e = +e, e === -1 ? this.slice(e) : this.slice(e, e + 1)
                },
                first: function() {
                    return this.eq(0)
                },
                last: function() {
                    return this.eq(-1)
                },
                slice: function() {
                    return this.pushStack(L.apply(this, arguments), "slice", L.call(arguments).join(","))
                },
                map: function(e) {
                    return this.pushStack(s.map(this, function(t, n) {
                        return e.call(t, n, t)
                    }))
                },
                end: function() {
                    return this.prevObject || this.constructor(null)
                },
                push: j,
                sort: [].sort,
                splice: [].splice
            }, s.fn.init.prototype = s.fn, s.extend = s.fn.extend = function() {
                var e, n, r, i, o, a, l = arguments[0] || {},
                    u = 1,
                    c = arguments.length,
                    f = !1;
                for ("boolean" == typeof l && (f = l, l = arguments[1] || {}, u = 2), "object" != typeof l && !s.isFunction(l) && (l = {}), c === u && (l = this, --u); u < c; u++)
                    if (null != (e = arguments[u]))
                        for (n in e) r = l[n], i = e[n], l !== i && (f && i && (s.isPlainObject(i) || (o = s.isArray(i))) ? (o ? (o = !1, a = r && s.isArray(r) ? r : []) : a = r && s.isPlainObject(r) ? r : {}, l[n] = s.extend(f, a, i)) : i !== t && (l[n] = i));
                return l
            }, s.extend({
                noConflict: function(t) {
                    return e.$ === s && (e.$ = u), t && e.jQuery === s && (e.jQuery = l), s
                },
                isReady: !1,
                readyWait: 1,
                holdReady: function(e) {
                    e ? s.readyWait++ : s.ready(!0)
                },
                ready: function(e) {
                    if (e === !0 && !--s.readyWait || e !== !0 && !s.isReady) {
                        if (!M.body) return setTimeout(s.ready, 1);
                        if (s.isReady = !0, e !== !0 && --s.readyWait > 0) return;
                        o.fireWith(M, [s]), s.fn.trigger && s(M).trigger("ready").off("ready")
                    }
                },
                bindReady: function() {
                    if (!o) {
                        if (o = s.Callbacks("once memory"), "complete" === M.readyState) return setTimeout(s.ready, 1);
                        if (M.addEventListener) M.addEventListener("DOMContentLoaded", a, !1), e.addEventListener("load", s.ready, !1);
                        else if (M.attachEvent) {
                            M.attachEvent("onreadystatechange", a), e.attachEvent("onload", s.ready);
                            var t = !1;
                            try {
                                t = null == e.frameElement
                            } catch (r) {}
                            M.documentElement.doScroll && t && n()
                        }
                    }
                },
                isFunction: function(e) {
                    return "function" === s.type(e)
                },
                isArray: Array.isArray || function(e) {
                    return "array" === s.type(e)
                },
                isWindow: function(e) {
                    return e && "object" == typeof e && "setInterval" in e
                },
                isNumeric: function(e) {
                    return !isNaN(parseFloat(e)) && isFinite(e)
                },
                type: function(e) {
                    return null == e ? String(e) : O[S.call(e)] || "object"
                },
                isPlainObject: function(e) {
                    if (!e || "object" !== s.type(e) || e.nodeType || s.isWindow(e)) return !1;
                    try {
                        if (e.constructor && !A.call(e, "constructor") && !A.call(e.constructor.prototype, "isPrototypeOf")) return !1
                    } catch (n) {
                        return !1
                    }
                    var r;
                    for (r in e);
                    return r === t || A.call(e, r)
                },
                isEmptyObject: function(e) {
                    for (var t in e) return !1;
                    return !0
                },
                error: function(e) {
                    throw new Error(e)
                },
                parseJSON: function(t) {
                    return "string" == typeof t && t ? (t = s.trim(t), e.JSON && e.JSON.parse ? e.JSON.parse(t) : m.test(t.replace(g, "@").replace(y, "]").replace(v, "")) ? new Function("return " + t)() : void s.error("Invalid JSON: " + t)) : null
                },
                parseXML: function(n) {
                    var r, i;
                    try {
                        e.DOMParser ? (i = new DOMParser, r = i.parseFromString(n, "text/xml")) : (r = new ActiveXObject("Microsoft.XMLDOM"), r.async = "false", r.loadXML(n))
                    } catch (o) {
                        r = t
                    }
                    return (!r || !r.documentElement || r.getElementsByTagName("parsererror").length) && s.error("Invalid XML: " + n), r
                },
                noop: function() {},
                globalEval: function(t) {
                    t && f.test(t) && (e.execScript || function(t) {
                        e.eval.call(e, t)
                    })(t)
                },
                camelCase: function(e) {
                    return e.replace(C, "ms-").replace(N, E)
                },
                nodeName: function(e, t) {
                    return e.nodeName && e.nodeName.toUpperCase() === t.toUpperCase()
                },
                each: function(e, n, r) {
                    var i, o = 0,
                        a = e.length,
                        l = a === t || s.isFunction(e);
                    if (r)
                        if (l) {
                            for (i in e)
                                if (n.apply(e[i], r) === !1) break
                        } else
                            for (; o < a && n.apply(e[o++], r) !== !1;);
                    else if (l) {
                        for (i in e)
                            if (n.call(e[i], i, e[i]) === !1) break
                    } else
                        for (; o < a && n.call(e[o], o, e[o++]) !== !1;);
                    return e
                },
                trim: D ? function(e) {
                    return null == e ? "" : D.call(e)
                } : function(e) {
                    return null == e ? "" : (e + "").replace(d, "").replace(p, "")
                },
                makeArray: function(e, t) {
                    var n = t || [];
                    if (null != e) {
                        var r = s.type(e);
                        null == e.length || "string" === r || "function" === r || "regexp" === r || s.isWindow(e) ? j.call(n, e) : s.merge(n, e)
                    }
                    return n
                },
                inArray: function(e, t, n) {
                    var r;
                    if (t) {
                        if (F) return F.call(t, e, n);
                        for (r = t.length, n = n ? n < 0 ? Math.max(0, r + n) : n : 0; n < r; n++)
                            if (n in t && t[n] === e) return n
                    }
                    return -1
                },
                merge: function(e, n) {
                    var r = e.length,
                        i = 0;
                    if ("number" == typeof n.length)
                        for (var o = n.length; i < o; i++) e[r++] = n[i];
                    else
                        for (; n[i] !== t;) e[r++] = n[i++];
                    return e.length = r, e
                },
                grep: function(e, t, n) {
                    var r, i = [];
                    n = !!n;
                    for (var o = 0, a = e.length; o < a; o++) r = !!t(e[o], o), n !== r && i.push(e[o]);
                    return i
                },
                map: function(e, n, r) {
                    var i, o, a = [],
                        l = 0,
                        u = e.length,
                        c = e instanceof s || u !== t && "number" == typeof u && (u > 0 && e[0] && e[u - 1] || 0 === u || s.isArray(e));
                    if (c)
                        for (; l < u; l++) i = n(e[l], l, r), null != i && (a[a.length] = i);
                    else
                        for (o in e) i = n(e[o], o, r), null != i && (a[a.length] = i);
                    return a.concat.apply([], a)
                },
                guid: 1,
                proxy: function(e, n) {
                    if ("string" == typeof n) {
                        var r = e[n];
                        n = e, e = r
                    }
                    if (!s.isFunction(e)) return t;
                    var i = L.call(arguments, 2),
                        o = function() {
                            return e.apply(n, i.concat(L.call(arguments)))
                        };
                    return o.guid = e.guid = e.guid || o.guid || s.guid++, o
                },
                access: function(e, n, r, i, o, a) {
                    var l = e.length;
                    if ("object" == typeof n) {
                        for (var u in n) s.access(e, u, n[u], i, o, r);
                        return e
                    }
                    if (r !== t) {
                        i = !a && i && s.isFunction(r);
                        for (var c = 0; c < l; c++) o(e[c], n, i ? r.call(e[c], c, o(e[c], n)) : r, a);
                        return e
                    }
                    return l ? o(e[0], n) : t
                },
                now: function() {
                    return (new Date).getTime()
                },
                uaMatch: function(e) {
                    e = e.toLowerCase();
                    var t = b.exec(e) || x.exec(e) || w.exec(e) || e.indexOf("compatible") < 0 && T.exec(e) || [];
                    return {
                        browser: t[1] || "",
                        version: t[2] || "0"
                    }
                },
                sub: function() {
                    function e(t, n) {
                        return new e.fn.init(t, n)
                    }
                    s.extend(!0, e, this), e.superclass = this, e.fn = e.prototype = this(), e.fn.constructor = e, e.sub = this.sub, e.fn.init = function(n, r) {
                        return r && r instanceof s && !(r instanceof e) && (r = e(r)), s.fn.init.call(this, n, r, t)
                    }, e.fn.init.prototype = e.fn;
                    var t = e(M);
                    return e
                },
                browser: {}
            }), s.each("Boolean Number String Function Array Date RegExp Object".split(" "), function(e, t) {
                O["[object " + t + "]"] = t.toLowerCase()
            }), i = s.uaMatch(k), i.browser && (s.browser[i.browser] = !0, s.browser.version = i.version), s.browser.webkit && (s.browser.safari = !0), f.test(" ") && (d = /^[\s\xA0]+/, p = /[\s\xA0]+$/), r = s(M), M.addEventListener ? a = function() {
                M.removeEventListener("DOMContentLoaded", a, !1), s.ready()
            } : M.attachEvent && (a = function() {
                "complete" === M.readyState && (M.detachEvent("onreadystatechange", a), s.ready())
            }), s
        }(),
        B = {};
    H.Callbacks = function(e) {
        e = e ? B[e] || F(e) : {};
        var n, r, i, o, a, s = [],
            l = [],
            u = function(t) {
                var n, r, i, o;
                for (n = 0, r = t.length; n < r; n++) i = t[n], o = H.type(i), "array" === o ? u(i) : "function" === o && (!e.unique || !f.has(i)) && s.push(i)
            },
            c = function(t, u) {
                for (u = u || [], n = !e.memory || [t, u], r = !0, a = i || 0, i = 0, o = s.length; s && a < o; a++)
                    if (s[a].apply(t, u) === !1 && e.stopOnFalse) {
                        n = !0;
                        break
                    } r = !1, s && (e.once ? n === !0 ? f.disable() : s = [] : l && l.length && (n = l.shift(), f.fireWith(n[0], n[1])))
            },
            f = {
                add: function() {
                    if (s) {
                        var e = s.length;
                        u(arguments), r ? o = s.length : n && n !== !0 && (i = e, c(n[0], n[1]))
                    }
                    return this
                },
                remove: function() {
                    if (s)
                        for (var t = arguments, n = 0, i = t.length; n < i; n++)
                            for (var l = 0; l < s.length && (t[n] !== s[l] || (r && l <= o && (o--, l <= a && a--), s.splice(l--, 1), !e.unique)); l++);
                    return this
                },
                has: function(e) {
                    if (s)
                        for (var t = 0, n = s.length; t < n; t++)
                            if (e === s[t]) return !0;
                    return !1
                },
                empty: function() {
                    return s = [], this
                },
                disable: function() {
                    return s = l = n = t, this
                },
                disabled: function() {
                    return !s
                },
                lock: function() {
                    return l = t, (!n || n === !0) && f.disable(), this
                },
                locked: function() {
                    return !l
                },
                fireWith: function(t, i) {
                    return l && (r ? e.once || l.push([t, i]) : (!e.once || !n) && c(t, i)), this
                },
                fire: function() {
                    return f.fireWith(this, arguments), this
                },
                fired: function() {
                    return !!n
                }
            };
        return f
    };
    var P = [].slice;
    H.extend({
        Deferred: function(e) {
            var t, n = H.Callbacks("once memory"),
                r = H.Callbacks("once memory"),
                i = H.Callbacks("memory"),
                o = "pending",
                a = {
                    resolve: n,
                    reject: r,
                    notify: i
                },
                s = {
                    done: n.add,
                    fail: r.add,
                    progress: i.add,
                    state: function() {
                        return o
                    },
                    isResolved: n.fired,
                    isRejected: r.fired,
                    then: function(e, t, n) {
                        return l.done(e).fail(t).progress(n), this
                    },
                    always: function() {
                        return l.done.apply(l, arguments).fail.apply(l, arguments), this
                    },
                    pipe: function(e, t, n) {
                        return H.Deferred(function(r) {
                            H.each({
                                done: [e, "resolve"],
                                fail: [t, "reject"],
                                progress: [n, "notify"]
                            }, function(e, t) {
                                var n, i = t[0],
                                    o = t[1];
                                H.isFunction(i) ? l[e](function() {
                                    n = i.apply(this, arguments), n && H.isFunction(n.promise) ? n.promise().then(r.resolve, r.reject, r.notify) : r[o + "With"](this === l ? r : this, [n])
                                }) : l[e](r[o])
                            })
                        }).promise()
                    },
                    promise: function(e) {
                        if (null == e) e = s;
                        else
                            for (var t in s) e[t] = s[t];
                        return e
                    }
                },
                l = s.promise({});
            for (t in a) l[t] = a[t].fire, l[t + "With"] = a[t].fireWith;
            return l.done(function() {
                o = "resolved"
            }, r.disable, i.lock).fail(function() {
                o = "rejected"
            }, n.disable, i.lock), e && e.call(l, l), l
        },
        when: function(e) {
            function t(e) {
                return function(t) {
                    a[e] = arguments.length > 1 ? P.call(arguments, 0) : t, l.notifyWith(u, a)
                }
            }

            function n(e) {
                return function(t) {
                    r[e] = arguments.length > 1 ? P.call(arguments, 0) : t, --s || l.resolveWith(l, r)
                }
            }
            var r = P.call(arguments, 0),
                i = 0,
                o = r.length,
                a = Array(o),
                s = o,
                l = o <= 1 && e && H.isFunction(e.promise) ? e : H.Deferred(),
                u = l.promise();
            if (o > 1) {
                for (; i < o; i++) r[i] && r[i].promise && H.isFunction(r[i].promise) ? r[i].promise().then(n(i), l.reject, t(i)) : --s;
                s || l.resolveWith(l, r)
            } else l !== e && l.resolveWith(l, o ? [e] : []);
            return u
        }
    }), H.support = function() {
        var t, n, r, i, o, a, s, l, u, c, f, d, p = M.createElement("div");
        M.documentElement;
        if (p.setAttribute("className", "t"), p.innerHTML = "   <link/><table></table><a href='/a' style='top:1px;float:left;opacity:.55;'>a</a><input type='checkbox'/>", n = p.getElementsByTagName("*"), r = p.getElementsByTagName("a")[0], !n || !n.length || !r) return {};
        i = M.createElement("select"), o = i.appendChild(M.createElement("option")), a = p.getElementsByTagName("input")[0], t = {
            leadingWhitespace: 3 === p.firstChild.nodeType,
            tbody: !p.getElementsByTagName("tbody").length,
            htmlSerialize: !!p.getElementsByTagName("link").length,
            style: /top/.test(r.getAttribute("style")),
            hrefNormalized: "/a" === r.getAttribute("href"),
            opacity: /^0.55/.test(r.style.opacity),
            cssFloat: !!r.style.cssFloat,
            checkOn: "on" === a.value,
            optSelected: o.selected,
            getSetAttribute: "t" !== p.className,
            enctype: !!M.createElement("form").enctype,
            html5Clone: "<:nav></:nav>" !== M.createElement("nav").cloneNode(!0).outerHTML,
            submitBubbles: !0,
            changeBubbles: !0,
            focusinBubbles: !1,
            deleteExpando: !0,
            noCloneEvent: !0,
            inlineBlockNeedsLayout: !1,
            shrinkWrapBlocks: !1,
            reliableMarginRight: !0
        }, a.checked = !0, t.noCloneChecked = a.cloneNode(!0).checked, i.disabled = !0, t.optDisabled = !o.disabled;
        try {
            delete p.test
        } catch (h) {
            t.deleteExpando = !1
        }
        if (!p.addEventListener && p.attachEvent && p.fireEvent && (p.attachEvent("onclick", function() {
                t.noCloneEvent = !1
            }), p.cloneNode(!0).fireEvent("onclick")), a = M.createElement("input"), a.value = "t", a.setAttribute("type", "radio"), t.radioValue = "t" === a.value, a.setAttribute("checked", "checked"), p.appendChild(a), l = M.createDocumentFragment(), l.appendChild(p.lastChild), t.checkClone = l.cloneNode(!0).cloneNode(!0).lastChild.checked, t.appendChecked = a.checked, l.removeChild(a), l.appendChild(p), p.innerHTML = "", e.getComputedStyle && (s = M.createElement("div"), s.style.width = "0", s.style.marginRight = "0", p.style.width = "2px", p.appendChild(s), t.reliableMarginRight = 0 === (parseInt((e.getComputedStyle(s, null) || {
                marginRight: 0
            }).marginRight, 10) || 0)), p.attachEvent)
            for (f in {
                    submit: 1,
                    change: 1,
                    focusin: 1
                }) c = "on" + f, d = c in p, d || (p.setAttribute(c, "return;"), d = "function" == typeof p[c]), t[f + "Bubbles"] = d;
        
    }();
    var q = /^(?:\{.*\}|\[.*\])$/,
        W = /([A-Z])/g;
    H.extend({
        cache: {},
        uuid: 0,
        expando: "jQuery" + (H.fn.jquery + Math.random()).replace(/\D/g, ""),
        noData: {
            embed: !0,
            object: "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",
            applet: !0
        },
        hasData: function(e) {
            return e = e.nodeType ? H.cache[e[H.expando]] : e[H.expando], !!e && !L(e)
        },
        data: function(e, n, r, i) {
            if (H.acceptData(e)) {
                var o, a, s, l = H.expando,
                    u = "string" == typeof n,
                    c = e.nodeType,
                    f = c ? H.cache : e,
                    d = c ? e[l] : e[l] && l,
                    p = "events" === n;
                if ((!d || !f[d] || !p && !i && !f[d].data) && u && r === t) return;
                return d || (c ? e[l] = d = ++H.uuid : d = l), f[d] || (f[d] = {}, c || (f[d].toJSON = H.noop)), "object" != typeof n && "function" != typeof n || (i ? f[d] = H.extend(f[d], n) : f[d].data = H.extend(f[d].data, n)), o = a = f[d], i || (a.data || (a.data = {}), a = a.data), r !== t && (a[H.camelCase(n)] = r), p && !a[n] ? o.events : (u ? (s = a[n], null == s && (s = a[H.camelCase(n)])) : s = a, s)
            }
        },
        removeData: function(e, t, n) {
            if (H.acceptData(e)) {
                var r, i, o, a = H.expando,
                    s = e.nodeType,
                    l = s ? H.cache : e,
                    u = s ? e[a] : a;
                if (!l[u]) return;
                if (t && (r = n ? l[u] : l[u].data)) {
                    H.isArray(t) || (t in r ? t = [t] : (t = H.camelCase(t), t = t in r ? [t] : t.split(" ")));
                    for (i = 0, o = t.length; i < o; i++) delete r[t[i]];
                    if (!(n ? L : H.isEmptyObject)(r)) return
                }
                if (!n && (delete l[u].data, !L(l[u]))) return;
                H.support.deleteExpando || !l.setInterval ? delete l[u] : l[u] = null, s && (H.support.deleteExpando ? delete e[a] : e.removeAttribute ? e.removeAttribute(a) : e[a] = null)
            }
        },
        _data: function(e, t, n) {
            return H.data(e, t, n, !0)
        },
        acceptData: function(e) {
            if (e.nodeName) {
                var t = H.noData[e.nodeName.toLowerCase()];
                if (t) return t !== !0 && e.getAttribute("classid") === t
            }
            return !0
        }
    }), H.fn.extend({
        data: function(e, n) {
            var r, i, o, a = null;
            if ("undefined" == typeof e) {
                if (this.length && (a = H.data(this[0]), 1 === this[0].nodeType && !H._data(this[0], "parsedAttrs"))) {
                    i = this[0].attributes;
                    for (var s = 0, l = i.length; s < l; s++) o = i[s].name, 0 === o.indexOf("data-") && (o = H.camelCase(o.substring(5)), D(this[0], o, a[o]));
                    H._data(this[0], "parsedAttrs", !0)
                }
                return a
            }
            return "object" == typeof e ? this.each(function() {
                H.data(this, e)
            }) : (r = e.split("."), r[1] = r[1] ? "." + r[1] : "", n === t ? (a = this.triggerHandler("getData" + r[1] + "!", [r[0]]), a === t && this.length && (a = H.data(this[0], e), a = D(this[0], e, a)), a === t && r[1] ? this.data(r[0]) : a) : this.each(function() {
                var t = H(this),
                    i = [r[0], n];
                t.triggerHandler("setData" + r[1] + "!", i), H.data(this, e, n), t.triggerHandler("changeData" + r[1] + "!", i)
            }))
        },
        removeData: function(e) {
            return this.each(function() {
                H.removeData(this, e)
            })
        }
    }), H.extend({
        _mark: function(e, t) {
            e && (t = (t || "fx") + "mark", H._data(e, t, (H._data(e, t) || 0) + 1))
        },
        _unmark: function(e, t, n) {
            if (e !== !0 && (n = t, t = e, e = !1), t) {
                n = n || "fx";
                var r = n + "mark",
                    i = e ? 0 : (H._data(t, r) || 1) - 1;
                i ? H._data(t, r, i) : (H.removeData(t, r, !0), j(t, n, "mark"))
            }
        },
        queue: function(e, t, n) {
            var r;
            if (e) return t = (t || "fx") + "queue", r = H._data(e, t), n && (!r || H.isArray(n) ? r = H._data(e, t, H.makeArray(n)) : r.push(n)), r || []
        },
        dequeue: function(e, t) {
            t = t || "fx";
            var n = H.queue(e, t),
                r = n.shift(),
                i = {};
            "inprogress" === r && (r = n.shift()), r && ("fx" === t && n.unshift("inprogress"), H._data(e, t + ".run", i), r.call(e, function() {
                H.dequeue(e, t)
            }, i)), n.length || (H.removeData(e, t + "queue " + t + ".run", !0), j(e, t, "queue"))
        }
    }), H.fn.extend({
        queue: function(e, n) {
            return "string" != typeof e && (n = e, e = "fx"), n === t ? H.queue(this[0], e) : this.each(function() {
                var t = H.queue(this, e, n);
                "fx" === e && "inprogress" !== t[0] && H.dequeue(this, e)
            })
        },
        dequeue: function(e) {
            return this.each(function() {
                H.dequeue(this, e)
            })
        },
        delay: function(e, t) {
            return e = H.fx ? H.fx.speeds[e] || e : e, t = t || "fx", this.queue(t, function(t, n) {
                var r = setTimeout(t, e);
                n.stop = function() {
                    clearTimeout(r)
                }
            })
        },
        clearQueue: function(e) {
            return this.queue(e || "fx", [])
        },
        promise: function(e, n) {
            function r() {
                --l || o.resolveWith(a, [a])
            }
            "string" != typeof e && (n = e, e = t), e = e || "fx";
            for (var i, o = H.Deferred(), a = this, s = a.length, l = 1, u = e + "defer", c = e + "queue", f = e + "mark"; s--;)(i = H.data(a[s], u, t, !0) || (H.data(a[s], c, t, !0) || H.data(a[s], f, t, !0)) && H.data(a[s], u, H.Callbacks("once memory"), !0)) && (l++, i.add(r));
            return r(), o.promise()
        }
    });
}
   