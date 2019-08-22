! function(e, t) {
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function(e) {
        if (!e.document) throw new Error("jQuery requires a window with a document");
        return t(e)
    } : t(e)
}("undefined" != typeof window ? window : this, function(e, t) {
    var n = [],
        r = n.slice,
        i = n.concat,
        o = n.push,
        a = n.indexOf,
        s = {},
        l = s.toString,
        u = s.hasOwnProperty,
        c = {},
        d = "1.11.3",
        f = function(e, t) {
            return new f.fn.init(e, t)
        },
        p = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
        h = /^-ms-/,
        m = /-([\da-z])/gi,
        g = function(e, t) {
            return t.toUpperCase()
        };

    function v(e) {
        var t = "length" in e && e.length,
            n = f.type(e);
        return "function" !== n && !f.isWindow(e) && (!(1 !== e.nodeType || !t) || ("array" === n || 0 === t || "number" == typeof t && t > 0 && t - 1 in e))
    }
    f.fn = f.prototype = {
        jquery: d,
        constructor: f,
        selector: "",
        length: 0,
        toArray: function() {
            return r.call(this)
        },
        get: function(e) {
            return null != e ? 0 > e ? this[e + this.length] : this[e] : r.call(this)
        },
        pushStack: function(e) {
            var t = f.merge(this.constructor(), e);
            return t.prevObject = this, t.context = this.context, t
        },
        each: function(e, t) {
            return f.each(this, e, t)
        },
        map: function(e) {
            return this.pushStack(f.map(this, function(t, n) {
                return e.call(t, n, t)
            }))
        },
        slice: function() {
            return this.pushStack(r.apply(this, arguments))
        },
        first: function() {
            return this.eq(0)
        },
        last: function() {
            return this.eq(-1)
        },
        eq: function(e) {
            var t = this.length,
                n = +e + (0 > e ? t : 0);
            return this.pushStack(n >= 0 && t > n ? [this[n]] : [])
        },
        end: function() {
            return this.prevObject || this.constructor(null)
        },
        push: o,
        sort: n.sort,
        splice: n.splice
    }, f.extend = f.fn.extend = function() {
        var e, t, n, r, i, o, a = arguments[0] || {},
            s = 1,
            l = arguments.length,
            u = !1;
        for ("boolean" == typeof a && (u = a, a = arguments[s] || {}, s++), "object" == typeof a || f.isFunction(a) || (a = {}), s === l && (a = this, s--); l > s; s++)
            if (null != (i = arguments[s]))
                for (r in i) e = a[r], a !== (n = i[r]) && (u && n && (f.isPlainObject(n) || (t = f.isArray(n))) ? (t ? (t = !1, o = e && f.isArray(e) ? e : []) : o = e && f.isPlainObject(e) ? e : {}, a[r] = f.extend(u, o, n)) : void 0 !== n && (a[r] = n));
        return a
    }, f.extend({
        expando: "jQuery" + (d + Math.random()).replace(/\D/g, ""),
        isReady: !0,
        error: function(e) {
            throw new Error(e)
        },
        noop: function() {},
        isFunction: function(e) {
            return "function" === f.type(e)
        },
        isArray: Array.isArray || function(e) {
            return "array" === f.type(e)
        },
        isWindow: function(e) {
            return null != e && e == e.window
        },
        isNumeric: function(e) {
            return !f.isArray(e) && e - parseFloat(e) + 1 >= 0
        },
        isEmptyObject: function(e) {
            var t;
            for (t in e) return !1;
            return !0
        },
        isPlainObject: function(e) {
            var t;
            if (!e || "object" !== f.type(e) || e.nodeType || f.isWindow(e)) return !1;
            try {
                if (e.constructor && !u.call(e, "constructor") && !u.call(e.constructor.prototype, "isPrototypeOf")) return !1
            } catch (e) {
                return !1
            }
            if (c.ownLast)
                for (t in e) return u.call(e, t);
            for (t in e);
            return void 0 === t || u.call(e, t)
        },
        type: function(e) {
            return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? s[l.call(e)] || "object" : typeof e
        },
        globalEval: function(t) {
            t && f.trim(t) && (e.execScript || function(t) {
                e.eval.call(e, t)
            })(t)
        },
        camelCase: function(e) {
            return e.replace(h, "ms-").replace(m, g)
        },
        nodeName: function(e, t) {
            return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
        },
        each: function(e, t, n) {
            var r = 0,
                i = e.length,
                o = v(e);
            if (n) {
                if (o)
                    for (; i > r && !1 !== t.apply(e[r], n); r++);
                else
                    for (r in e)
                        if (!1 === t.apply(e[r], n)) break
            } else if (o)
                for (; i > r && !1 !== t.call(e[r], r, e[r]); r++);
            else
                for (r in e)
                    if (!1 === t.call(e[r], r, e[r])) break;
            return e
        },
        trim: function(e) {
            return null == e ? "" : (e + "").replace(p, "")
        },
        makeArray: function(e, t) {
            var n = t || [];
            return null != e && (v(Object(e)) ? f.merge(n, "string" == typeof e ? [e] : e) : o.call(n, e)), n
        },
        inArray: function(e, t, n) {
            var r;
            if (t) {
                if (a) return a.call(t, e, n);
                for (r = t.length, n = n ? 0 > n ? Math.max(0, r + n) : n : 0; r > n; n++)
                    if (n in t && t[n] === e) return n
            }
            return -1
        },
        merge: function(e, t) {
            for (var n = +t.length, r = 0, i = e.length; n > r;) e[i++] = t[r++];
            if (n != n)
                for (; void 0 !== t[r];) e[i++] = t[r++];
            return e.length = i, e
        },
        grep: function(e, t, n) {
            for (var r = [], i = 0, o = e.length, a = !n; o > i; i++) !t(e[i], i) !== a && r.push(e[i]);
            return r
        },
        map: function(e, t, n) {
            var r, o = 0,
                a = e.length,
                s = [];
            if (v(e))
                for (; a > o; o++) null != (r = t(e[o], o, n)) && s.push(r);
            else
                for (o in e) null != (r = t(e[o], o, n)) && s.push(r);
            return i.apply([], s)
        },
        guid: 1,
        proxy: function(e, t) {
            var n, i, o;
            return "string" == typeof t && (o = e[t], t = e, e = o), f.isFunction(e) ? (n = r.call(arguments, 2), (i = function() {
                return e.apply(t || this, n.concat(r.call(arguments)))
            }).guid = e.guid = e.guid || f.guid++, i) : void 0
        },
        now: function() {
            return +new Date
        },
        support: c
    }), f.each("Boolean Number String Function Array Date RegExp Object Error".split(" "), function(e, t) {
        s["[object " + t + "]"] = t.toLowerCase()
    });
    var y = function(e) {
        var t, n, r, i, o, a, s, l, u, c, d, f, p, h, m, g, v, y, b, x = "sizzle" + 1 * new Date,
            w = e.document,
            T = 0,
            C = 0,
            N = ae(),
            E = ae(),
            k = ae(),
            S = function(e, t) {
                return e === t && (d = !0), 0
            },
            A = 1 << 31,
            D = {}.hasOwnProperty,
            j = [],
            L = j.pop,
            H = j.push,
            q = j.push,
            _ = j.slice,
            M = function(e, t) {
                for (var n = 0, r = e.length; r > n; n++)
                    if (e[n] === t) return n;
                return -1
            },
            F = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            O = "[\\x20\\t\\r\\n\\f]",
            B = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
            P = B.replace("w", "w#"),
            R = "\\[" + O + "*(" + B + ")(?:" + O + "*([*^$|!~]?=)" + O + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + P + "))|)" + O + "*\\]",
            W = ":(" + B + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + R + ")*)|.*)\\)|)",
            $ = new RegExp(O + "+", "g"),
            z = new RegExp("^" + O + "+|((?:^|[^\\\\])(?:\\\\.)*)" + O + "+$", "g"),
            I = new RegExp("^" + O + "*," + O + "*"),
            X = new RegExp("^" + O + "*([>+~]|" + O + ")" + O + "*"),
            U = new RegExp("=" + O + "*([^\\]'\"]*?)" + O + "*\\]", "g"),
            V = new RegExp(W),
            J = new RegExp("^" + P + "$"),
            Y = {
                ID: new RegExp("^#(" + B + ")"),
                CLASS: new RegExp("^\\.(" + B + ")"),
                TAG: new RegExp("^(" + B.replace("w", "w*") + ")"),
                ATTR: new RegExp("^" + R),
                PSEUDO: new RegExp("^" + W),
                CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + O + "*(even|odd|(([+-]|)(\\d*)n|)" + O + "*(?:([+-]|)" + O + "*(\\d+)|))" + O + "*\\)|)", "i"),
                bool: new RegExp("^(?:" + F + ")$", "i"),
                needsContext: new RegExp("^" + O + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + O + "*((?:-\\d)?\\d*)" + O + "*\\)|)(?=[^-]|$)", "i")
            },
            G = /^(?:input|select|textarea|button)$/i,
            Q = /^h\d$/i,
            K = /^[^{]+\{\s*\[native \w/,
            Z = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
            ee = /[+~]/,
            te = /'|\\/g,
            ne = new RegExp("\\\\([\\da-f]{1,6}" + O + "?|(" + O + ")|.)", "ig"),
            re = function(e, t, n) {
                var r = "0x" + t - 65536;
                return r != r || n ? t : 0 > r ? String.fromCharCode(r + 65536) : String.fromCharCode(r >> 10 | 55296, 1023 & r | 56320)
            },
            ie = function() {
                f()
            };
        try {
            q.apply(j = _.call(w.childNodes), w.childNodes), j[w.childNodes.length].nodeType
        } catch (e) {
            q = {
                apply: j.length ? function(e, t) {
                    H.apply(e, _.call(t))
                } : function(e, t) {
                    for (var n = e.length, r = 0; e[n++] = t[r++];);
                    e.length = n - 1
                }
            }
        }

        function oe(e, t, r, i) {
            var o, s, u, c, d, h, v, y, T, C;
            if ((t ? t.ownerDocument || t : w) !== p && f(t), r = r || [], c = (t = t || p).nodeType, "string" != typeof e || !e || 1 !== c && 9 !== c && 11 !== c) return r;
            if (!i && m) {
                if (11 !== c && (o = Z.exec(e)))
                    if (u = o[1]) {
                        if (9 === c) {
                            if (!(s = t.getElementById(u)) || !s.parentNode) return r;
                            if (s.id === u) return r.push(s), r
                        } else if (t.ownerDocument && (s = t.ownerDocument.getElementById(u)) && b(t, s) && s.id === u) return r.push(s), r
                    } else {
                        if (o[2]) return q.apply(r, t.getElementsByTagName(e)), r;
                        if ((u = o[3]) && n.getElementsByClassName) return q.apply(r, t.getElementsByClassName(u)), r
                    } if (n.qsa && (!g || !g.test(e))) {
                    if (y = v = x, T = t, C = 1 !== c && e, 1 === c && "object" !== t.nodeName.toLowerCase()) {
                        for (h = a(e), (v = t.getAttribute("id")) ? y = v.replace(te, "\\$&") : t.setAttribute("id", y), y = "[id='" + y + "'] ", d = h.length; d--;) h[d] = y + ge(h[d]);
                        T = ee.test(e) && he(t.parentNode) || t, C = h.join(",")
                    }
                    if (C) try {
                        return q.apply(r, T.querySelectorAll(C)), r
                    } catch (e) {} finally {
                        v || t.removeAttribute("id")
                    }
                }
            }
            return l(e.replace(z, "$1"), t, r, i)
        }

        function ae() {
            var e = [];
            return function t(n, i) {
                return e.push(n + " ") > r.cacheLength && delete t[e.shift()], t[n + " "] = i
            }
        }

        function se(e) {
            return e[x] = !0, e
        }

        function le(e) {
            var t = p.createElement("div");
            try {
                return !!e(t)
            } catch (e) {
                return !1
            } finally {
                t.parentNode && t.parentNode.removeChild(t), t = null
            }
        }

        function ue(e, t) {
            for (var n = e.split("|"), i = e.length; i--;) r.attrHandle[n[i]] = t
        }

        function ce(e, t) {
            var n = t && e,
                r = n && 1 === e.nodeType && 1 === t.nodeType && (~t.sourceIndex || A) - (~e.sourceIndex || A);
            if (r) return r;
            if (n)
                for (; n = n.nextSibling;)
                    if (n === t) return -1;
            return e ? 1 : -1
        }

        function de(e) {
            return function(t) {
                return "input" === t.nodeName.toLowerCase() && t.type === e
            }
        }

        function fe(e) {
            return function(t) {
                var n = t.nodeName.toLowerCase();
                return ("input" === n || "button" === n) && t.type === e
            }
        }

        function pe(e) {
            return se(function(t) {
                return t = +t, se(function(n, r) {
                    for (var i, o = e([], n.length, t), a = o.length; a--;) n[i = o[a]] && (n[i] = !(r[i] = n[i]))
                })
            })
        }

        function he(e) {
            return e && void 0 !== e.getElementsByTagName && e
        }
        for (t in n = oe.support = {}, o = oe.isXML = function(e) {
                var t = e && (e.ownerDocument || e).documentElement;
                return !!t && "HTML" !== t.nodeName
            }, f = oe.setDocument = function(e) {
                var t, i, a = e ? e.ownerDocument || e : w;
                return a !== p && 9 === a.nodeType && a.documentElement ? (p = a, h = a.documentElement, (i = a.defaultView) && i !== i.top && (i.addEventListener ? i.addEventListener("unload", ie, !1) : i.attachEvent && i.attachEvent("onunload", ie)), m = !o(a), n.attributes = le(function(e) {
                    return e.className = "i", !e.getAttribute("className")
                }), n.getElementsByTagName = le(function(e) {
                    return e.appendChild(a.createComment("")), !e.getElementsByTagName("*").length
                }), n.getElementsByClassName = K.test(a.getElementsByClassName), n.getById = le(function(e) {
                    return h.appendChild(e).id = x, !a.getElementsByName || !a.getElementsByName(x).length
                }), n.getById ? (r.find.ID = function(e, t) {
                    if (void 0 !== t.getElementById && m) {
                        var n = t.getElementById(e);
                        return n && n.parentNode ? [n] : []
                    }
                }, r.filter.ID = function(e) {
                    var t = e.replace(ne, re);
                    return function(e) {
                        return e.getAttribute("id") === t
                    }
                }) : (delete r.find.ID, r.filter.ID = function(e) {
                    var t = e.replace(ne, re);
                    return function(e) {
                        var n = void 0 !== e.getAttributeNode && e.getAttributeNode("id");
                        return n && n.value === t
                    }
                }), r.find.TAG = n.getElementsByTagName ? function(e, t) {
                    return void 0 !== t.getElementsByTagName ? t.getElementsByTagName(e) : n.qsa ? t.querySelectorAll(e) : void 0
                } : function(e, t) {
                    var n, r = [],
                        i = 0,
                        o = t.getElementsByTagName(e);
                    if ("*" === e) {
                        for (; n = o[i++];) 1 === n.nodeType && r.push(n);
                        return r
                    }
                    return o
                }, r.find.CLASS = n.getElementsByClassName && function(e, t) {
                    return m ? t.getElementsByClassName(e) : void 0
                }, v = [], g = [], (n.qsa = K.test(a.querySelectorAll)) && (le(function(e) {
                    h.appendChild(e).innerHTML = "<a id='" + x + "'></a><select id='" + x + "-\f]' msallowcapture=''><option selected=''></option></select>", e.querySelectorAll("[msallowcapture^='']").length && g.push("[*^$]=" + O + "*(?:''|\"\")"), e.querySelectorAll("[selected]").length || g.push("\\[" + O + "*(?:value|" + F + ")"), e.querySelectorAll("[id~=" + x + "-]").length || g.push("~="), e.querySelectorAll(":checked").length || g.push(":checked"), e.querySelectorAll("a#" + x + "+*").length || g.push(".#.+[+~]")
                }), le(function(e) {
                    var t = a.createElement("input");
                    t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && g.push("name" + O + "*[*^$|!~]?="), e.querySelectorAll(":enabled").length || g.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), g.push(",.*:")
                })), (n.matchesSelector = K.test(y = h.matches || h.webkitMatchesSelector || h.mozMatchesSelector || h.oMatchesSelector || h.msMatchesSelector)) && le(function(e) {
                    n.disconnectedMatch = y.call(e, "div"), y.call(e, "[s!='']:x"), v.push("!=", W)
                }), g = g.length && new RegExp(g.join("|")), v = v.length && new RegExp(v.join("|")), t = K.test(h.compareDocumentPosition), b = t || K.test(h.contains) ? function(e, t) {
                    var n = 9 === e.nodeType ? e.documentElement : e,
                        r = t && t.parentNode;
                    return e === r || !(!r || 1 !== r.nodeType || !(n.contains ? n.contains(r) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(r)))
                } : function(e, t) {
                    if (t)
                        for (; t = t.parentNode;)
                            if (t === e) return !0;
                    return !1
                }, S = t ? function(e, t) {
                    if (e === t) return d = !0, 0;
                    var r = !e.compareDocumentPosition - !t.compareDocumentPosition;
                    return r || (1 & (r = (e.ownerDocument || e) === (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !n.sortDetached && t.compareDocumentPosition(e) === r ? e === a || e.ownerDocument === w && b(w, e) ? -1 : t === a || t.ownerDocument === w && b(w, t) ? 1 : c ? M(c, e) - M(c, t) : 0 : 4 & r ? -1 : 1)
                } : function(e, t) {
                    if (e === t) return d = !0, 0;
                    var n, r = 0,
                        i = e.parentNode,
                        o = t.parentNode,
                        s = [e],
                        l = [t];
                    if (!i || !o) return e === a ? -1 : t === a ? 1 : i ? -1 : o ? 1 : c ? M(c, e) - M(c, t) : 0;
                    if (i === o) return ce(e, t);
                    for (n = e; n = n.parentNode;) s.unshift(n);
                    for (n = t; n = n.parentNode;) l.unshift(n);
                    for (; s[r] === l[r];) r++;
                    return r ? ce(s[r], l[r]) : s[r] === w ? -1 : l[r] === w ? 1 : 0
                }, a) : p
            }, oe.matches = function(e, t) {
                return oe(e, null, null, t)
            }, oe.matchesSelector = function(e, t) {
                if ((e.ownerDocument || e) !== p && f(e), t = t.replace(U, "='$1']"), !(!n.matchesSelector || !m || v && v.test(t) || g && g.test(t))) try {
                    var r = y.call(e, t);
                    if (r || n.disconnectedMatch || e.document && 11 !== e.document.nodeType) return r
                } catch (e) {}
                return oe(t, p, null, [e]).length > 0
            }, oe.contains = function(e, t) {
                return (e.ownerDocument || e) !== p && f(e), b(e, t)
            }, oe.attr = function(e, t) {
                (e.ownerDocument || e) !== p && f(e);
                var i = r.attrHandle[t.toLowerCase()],
                    o = i && D.call(r.attrHandle, t.toLowerCase()) ? i(e, t, !m) : void 0;
                return void 0 !== o ? o : n.attributes || !m ? e.getAttribute(t) : (o = e.getAttributeNode(t)) && o.specified ? o.value : null
            }, oe.error = function(e) {
                throw new Error("Syntax error, unrecognized expression: " + e)
            }, oe.uniqueSort = function(e) {
                var t, r = [],
                    i = 0,
                    o = 0;
                if (d = !n.detectDuplicates, c = !n.sortStable && e.slice(0), e.sort(S), d) {
                    for (; t = e[o++];) t === e[o] && (i = r.push(o));
                    for (; i--;) e.splice(r[i], 1)
                }
                return c = null, e
            }, i = oe.getText = function(e) {
                var t, n = "",
                    r = 0,
                    o = e.nodeType;
                if (o) {
                    if (1 === o || 9 === o || 11 === o) {
                        if ("string" == typeof e.textContent) return e.textContent;
                        for (e = e.firstChild; e; e = e.nextSibling) n += i(e)
                    } else if (3 === o || 4 === o) return e.nodeValue
                } else
                    for (; t = e[r++];) n += i(t);
                return n
            }, (r = oe.selectors = {
                cacheLength: 50,
                createPseudo: se,
                match: Y,
                attrHandle: {},
                find: {},
                relative: {
                    ">": {
                        dir: "parentNode",
                        first: !0
                    },
                    " ": {
                        dir: "parentNode"
                    },
                    "+": {
                        dir: "previousSibling",
                        first: !0
                    },
                    "~": {
                        dir: "previousSibling"
                    }
                },
                preFilter: {
                    ATTR: function(e) {
                        return e[1] = e[1].replace(ne, re), e[3] = (e[3] || e[4] || e[5] || "").replace(ne, re), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                    },
                    CHILD: function(e) {
                        return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || oe.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && oe.error(e[0]), e
                    },
                    PSEUDO: function(e) {
                        var t, n = !e[6] && e[2];
                        return Y.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && V.test(n) && (t = a(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                    }
                },
                filter: {
                    TAG: function(e) {
                        var t = e.replace(ne, re).toLowerCase();
                        return "*" === e ? function() {
                            return !0
                        } : function(e) {
                            return e.nodeName && e.nodeName.toLowerCase() === t
                        }
                    },
                    CLASS: function(e) {
                        var t = N[e + " "];
                        return t || (t = new RegExp("(^|" + O + ")" + e + "(" + O + "|$)")) && N(e, function(e) {
                            return t.test("string" == typeof e.className && e.className || void 0 !== e.getAttribute && e.getAttribute("class") || "")
                        })
                    },
                    ATTR: function(e, t, n) {
                        return function(r) {
                            var i = oe.attr(r, e);
                            return null == i ? "!=" === t : !t || (i += "", "=" === t ? i === n : "!=" === t ? i !== n : "^=" === t ? n && 0 === i.indexOf(n) : "*=" === t ? n && i.indexOf(n) > -1 : "$=" === t ? n && i.slice(-n.length) === n : "~=" === t ? (" " + i.replace($, " ") + " ").indexOf(n) > -1 : "|=" === t && (i === n || i.slice(0, n.length + 1) === n + "-"))
                        }
                    },
                    CHILD: function(e, t, n, r, i) {
                        var o = "nth" !== e.slice(0, 3),
                            a = "last" !== e.slice(-4),
                            s = "of-type" === t;
                        return 1 === r && 0 === i ? function(e) {
                            return !!e.parentNode
                        } : function(t, n, l) {
                            var u, c, d, f, p, h, m = o !== a ? "nextSibling" : "previousSibling",
                                g = t.parentNode,
                                v = s && t.nodeName.toLowerCase(),
                                y = !l && !s;
                            if (g) {
                                if (o) {
                                    for (; m;) {
                                        for (d = t; d = d[m];)
                                            if (s ? d.nodeName.toLowerCase() === v : 1 === d.nodeType) return !1;
                                        h = m = "only" === e && !h && "nextSibling"
                                    }
                                    return !0
                                }
                                if (h = [a ? g.firstChild : g.lastChild], a && y) {
                                    for (p = (u = (c = g[x] || (g[x] = {}))[e] || [])[0] === T && u[1], f = u[0] === T && u[2], d = p && g.childNodes[p]; d = ++p && d && d[m] || (f = p = 0) || h.pop();)
                                        if (1 === d.nodeType && ++f && d === t) {
                                            c[e] = [T, p, f];
                                            break
                                        }
                                } else if (y && (u = (t[x] || (t[x] = {}))[e]) && u[0] === T) f = u[1];
                                else
                                    for (;
                                        (d = ++p && d && d[m] || (f = p = 0) || h.pop()) && ((s ? d.nodeName.toLowerCase() !== v : 1 !== d.nodeType) || !++f || (y && ((d[x] || (d[x] = {}))[e] = [T, f]), d !== t)););
                                return (f -= i) === r || f % r == 0 && f / r >= 0
                            }
                        }
                    },
                    PSEUDO: function(e, t) {
                        var n, i = r.pseudos[e] || r.setFilters[e.toLowerCase()] || oe.error("unsupported pseudo: " + e);
                        return i[x] ? i(t) : i.length > 1 ? (n = [e, e, "", t], r.setFilters.hasOwnProperty(e.toLowerCase()) ? se(function(e, n) {
                            for (var r, o = i(e, t), a = o.length; a--;) e[r = M(e, o[a])] = !(n[r] = o[a])
                        }) : function(e) {
                            return i(e, 0, n)
                        }) : i
                    }
                },
                pseudos: {
                    not: se(function(e) {
                        var t = [],
                            n = [],
                            r = s(e.replace(z, "$1"));
                        return r[x] ? se(function(e, t, n, i) {
                            for (var o, a = r(e, null, i, []), s = e.length; s--;)(o = a[s]) && (e[s] = !(t[s] = o))
                        }) : function(e, i, o) {
                            return t[0] = e, r(t, null, o, n), t[0] = null, !n.pop()
                        }
                    }),
                    has: se(function(e) {
                        return function(t) {
                            return oe(e, t).length > 0
                        }
                    }),
                    contains: se(function(e) {
                        return e = e.replace(ne, re),
                            function(t) {
                                return (t.textContent || t.innerText || i(t)).indexOf(e) > -1
                            }
                    }),
                    lang: se(function(e) {
                        return J.test(e || "") || oe.error("unsupported lang: " + e), e = e.replace(ne, re).toLowerCase(),
                            function(t) {
                                var n;
                                do {
                                    if (n = m ? t.lang : t.getAttribute("xml:lang") || t.getAttribute("lang")) return (n = n.toLowerCase()) === e || 0 === n.indexOf(e + "-")
                                } while ((t = t.parentNode) && 1 === t.nodeType);
                                return !1
                            }
                    }),
                    target: function(t) {
                        var n = e.location && e.location.hash;
                        return n && n.slice(1) === t.id
                    },
                    root: function(e) {
                        return e === h
                    },
                    focus: function(e) {
                        return e === p.activeElement && (!p.hasFocus || p.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                    },
                    enabled: function(e) {
                        return !1 === e.disabled
                    },
                    disabled: function(e) {
                        return !0 === e.disabled
                    },
                    checked: function(e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && !!e.checked || "option" === t && !!e.selected
                    },
                    selected: function(e) {
                        return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
                    },
                    empty: function(e) {
                        for (e = e.firstChild; e; e = e.nextSibling)
                            if (e.nodeType < 6) return !1;
                        return !0
                    },
                    parent: function(e) {
                        return !r.pseudos.empty(e)
                    },
                    header: function(e) {
                        return Q.test(e.nodeName)
                    },
                    input: function(e) {
                        return G.test(e.nodeName)
                    },
                    button: function(e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && "button" === e.type || "button" === t
                    },
                    text: function(e) {
                        var t;
                        return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
                    },
                    first: pe(function() {
                        return [0]
                    }),
                    last: pe(function(e, t) {
                        return [t - 1]
                    }),
                    eq: pe(function(e, t, n) {
                        return [0 > n ? n + t : n]
                    }),
                    even: pe(function(e, t) {
                        for (var n = 0; t > n; n += 2) e.push(n);
                        return e
                    }),
                    odd: pe(function(e, t) {
                        for (var n = 1; t > n; n += 2) e.push(n);
                        return e
                    }),
                    lt: pe(function(e, t, n) {
                        for (var r = 0 > n ? n + t : n; --r >= 0;) e.push(r);
                        return e
                    }),
                    gt: pe(function(e, t, n) {
                        for (var r = 0 > n ? n + t : n; ++r < t;) e.push(r);
                        return e
                    })
                }
            }).pseudos.nth = r.pseudos.eq, {
                radio: !0,
                checkbox: !0,
                file: !0,
                password: !0,
                image: !0
            }) r.pseudos[t] = de(t);
        for (t in {
                submit: !0,
                reset: !0
            }) r.pseudos[t] = fe(t);

        function me() {}

        function ge(e) {
            for (var t = 0, n = e.length, r = ""; n > t; t++) r += e[t].value;
            return r
        }

        function ve(e, t, n) {
            var r = t.dir,
                i = n && "parentNode" === r,
                o = C++;
            return t.first ? function(t, n, o) {
                for (; t = t[r];)
                    if (1 === t.nodeType || i) return e(t, n, o)
            } : function(t, n, a) {
                var s, l, u = [T, o];
                if (a) {
                    for (; t = t[r];)
                        if ((1 === t.nodeType || i) && e(t, n, a)) return !0
                } else
                    for (; t = t[r];)
                        if (1 === t.nodeType || i) {
                            if ((s = (l = t[x] || (t[x] = {}))[r]) && s[0] === T && s[1] === o) return u[2] = s[2];
                            if (l[r] = u, u[2] = e(t, n, a)) return !0
                        }
            }
        }

        function ye(e) {
            return e.length > 1 ? function(t, n, r) {
                for (var i = e.length; i--;)
                    if (!e[i](t, n, r)) return !1;
                return !0
            } : e[0]
        }

        function be(e, t, n, r, i) {
            for (var o, a = [], s = 0, l = e.length, u = null != t; l > s; s++)(o = e[s]) && (!n || n(o, r, i)) && (a.push(o), u && t.push(s));
            return a
        }

        function xe(e, t, n, r, i, o) {
            return r && !r[x] && (r = xe(r)), i && !i[x] && (i = xe(i, o)), se(function(o, a, s, l) {
                var u, c, d, f = [],
                    p = [],
                    h = a.length,
                    m = o || function(e, t, n) {
                        for (var r = 0, i = t.length; i > r; r++) oe(e, t[r], n);
                        return n
                    }(t || "*", s.nodeType ? [s] : s, []),
                    g = !e || !o && t ? m : be(m, f, e, s, l),
                    v = n ? i || (o ? e : h || r) ? [] : a : g;
                if (n && n(g, v, s, l), r)
                    for (u = be(v, p), r(u, [], s, l), c = u.length; c--;)(d = u[c]) && (v[p[c]] = !(g[p[c]] = d));
                if (o) {
                    if (i || e) {
                        if (i) {
                            for (u = [], c = v.length; c--;)(d = v[c]) && u.push(g[c] = d);
                            i(null, v = [], u, l)
                        }
                        for (c = v.length; c--;)(d = v[c]) && (u = i ? M(o, d) : f[c]) > -1 && (o[u] = !(a[u] = d))
                    }
                } else v = be(v === a ? v.splice(h, v.length) : v), i ? i(null, a, v, l) : q.apply(a, v)
            })
        }

        function we(e) {
            for (var t, n, i, o = e.length, a = r.relative[e[0].type], s = a || r.relative[" "], l = a ? 1 : 0, c = ve(function(e) {
                    return e === t
                }, s, !0), d = ve(function(e) {
                    return M(t, e) > -1
                }, s, !0), f = [function(e, n, r) {
                    var i = !a && (r || n !== u) || ((t = n).nodeType ? c(e, n, r) : d(e, n, r));
                    return t = null, i
                }]; o > l; l++)
                if (n = r.relative[e[l].type]) f = [ve(ye(f), n)];
                else {
                    if ((n = r.filter[e[l].type].apply(null, e[l].matches))[x]) {
                        for (i = ++l; o > i && !r.relative[e[i].type]; i++);
                        return xe(l > 1 && ye(f), l > 1 && ge(e.slice(0, l - 1).concat({
                            value: " " === e[l - 2].type ? "*" : ""
                        })).replace(z, "$1"), n, i > l && we(e.slice(l, i)), o > i && we(e = e.slice(i)), o > i && ge(e))
                    }
                    f.push(n)
                } return ye(f)
        }
        return me.prototype = r.filters = r.pseudos, r.setFilters = new me, a = oe.tokenize = function(e, t) {
            var n, i, o, a, s, l, u, c = E[e + " "];
            if (c) return t ? 0 : c.slice(0);
            for (s = e, l = [], u = r.preFilter; s;) {
                for (a in (!n || (i = I.exec(s))) && (i && (s = s.slice(i[0].length) || s), l.push(o = [])), n = !1, (i = X.exec(s)) && (n = i.shift(), o.push({
                        value: n,
                        type: i[0].replace(z, " ")
                    }), s = s.slice(n.length)), r.filter) !(i = Y[a].exec(s)) || u[a] && !(i = u[a](i)) || (n = i.shift(), o.push({
                    value: n,
                    type: a,
                    matches: i
                }), s = s.slice(n.length));
                if (!n) break
            }
            return t ? s.length : s ? oe.error(e) : E(e, l).slice(0)
        }, s = oe.compile = function(e, t) {
            var n, i, o, s, l, c, d = [],
                f = [],
                h = k[e + " "];
            if (!h) {
                for (t || (t = a(e)), n = t.length; n--;)(h = we(t[n]))[x] ? d.push(h) : f.push(h);
                (h = k(e, (i = f, s = (o = d).length > 0, l = i.length > 0, c = function(e, t, n, a, c) {
                    var d, f, h, m = 0,
                        g = "0",
                        v = e && [],
                        y = [],
                        b = u,
                        x = e || l && r.find.TAG("*", c),
                        w = T += null == b ? 1 : Math.random() || .1,
                        C = x.length;
                    for (c && (u = t !== p && t); g !== C && null != (d = x[g]); g++) {
                        if (l && d) {
                            for (f = 0; h = i[f++];)
                                if (h(d, t, n)) {
                                    a.push(d);
                                    break
                                } c && (T = w)
                        }
                        s && ((d = !h && d) && m--, e && v.push(d))
                    }
                    if (m += g, s && g !== m) {
                        for (f = 0; h = o[f++];) h(v, y, t, n);
                        if (e) {
                            if (m > 0)
                                for (; g--;) v[g] || y[g] || (y[g] = L.call(a));
                            y = be(y)
                        }
                        q.apply(a, y), c && !e && y.length > 0 && m + o.length > 1 && oe.uniqueSort(a)
                    }
                    return c && (T = w, u = b), v
                }, s ? se(c) : c))).selector = e
            }
            return h
        }, l = oe.select = function(e, t, i, o) {
            var l, u, c, d, f, p = "function" == typeof e && e,
                h = !o && a(e = p.selector || e);
            if (i = i || [], 1 === h.length) {
                if ((u = h[0] = h[0].slice(0)).length > 2 && "ID" === (c = u[0]).type && n.getById && 9 === t.nodeType && m && r.relative[u[1].type]) {
                    if (!(t = (r.find.ID(c.matches[0].replace(ne, re), t) || [])[0])) return i;
                    p && (t = t.parentNode), e = e.slice(u.shift().value.length)
                }
                for (l = Y.needsContext.test(e) ? 0 : u.length; l-- && (c = u[l], !r.relative[d = c.type]);)
                    if ((f = r.find[d]) && (o = f(c.matches[0].replace(ne, re), ee.test(u[0].type) && he(t.parentNode) || t))) {
                        if (u.splice(l, 1), !(e = o.length && ge(u))) return q.apply(i, o), i;
                        break
                    }
            }
            return (p || s(e, h))(o, t, !m, i, ee.test(e) && he(t.parentNode) || t), i
        }, n.sortStable = x.split("").sort(S).join("") === x, n.detectDuplicates = !!d, f(), n.sortDetached = le(function(e) {
            return 1 & e.compareDocumentPosition(p.createElement("div"))
        }), le(function(e) {
            return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
        }) || ue("type|href|height|width", function(e, t, n) {
            return n ? void 0 : e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
        }), n.attributes && le(function(e) {
            return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
        }) || ue("value", function(e, t, n) {
            return n || "input" !== e.nodeName.toLowerCase() ? void 0 : e.defaultValue
        }), le(function(e) {
            return null == e.getAttribute("disabled")
        }) || ue(F, function(e, t, n) {
            var r;
            return n ? void 0 : !0 === e[t] ? t.toLowerCase() : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
        }), oe
    }(e);
    f.find = y, f.expr = y.selectors, f.expr[":"] = f.expr.pseudos, f.unique = y.uniqueSort, f.text = y.getText, f.isXMLDoc = y.isXML, f.contains = y.contains;
    var b = f.expr.match.needsContext,
        x = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
        w = /^.[^:#\[\.,]*$/;

    function T(e, t, n) {
        if (f.isFunction(t)) return f.grep(e, function(e, r) {
            return !!t.call(e, r, e) !== n
        });
        if (t.nodeType) return f.grep(e, function(e) {
            return e === t !== n
        });
        if ("string" == typeof t) {
            if (w.test(t)) return f.filter(t, e, n);
            t = f.filter(t, e)
        }
        return f.grep(e, function(e) {
            return f.inArray(e, t) >= 0 !== n
        })
    }
    f.filter = function(e, t, n) {
        var r = t[0];
        return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === r.nodeType ? f.find.matchesSelector(r, e) ? [r] : [] : f.find.matches(e, f.grep(t, function(e) {
            return 1 === e.nodeType
        }))
    }, f.fn.extend({
        find: function(e) {
            var t, n = [],
                r = this,
                i = r.length;
            if ("string" != typeof e) return this.pushStack(f(e).filter(function() {
                for (t = 0; i > t; t++)
                    if (f.contains(r[t], this)) return !0
            }));
            for (t = 0; i > t; t++) f.find(e, r[t], n);
            return (n = this.pushStack(i > 1 ? f.unique(n) : n)).selector = this.selector ? this.selector + " " + e : e, n
        },
        filter: function(e) {
            return this.pushStack(T(this, e || [], !1))
        },
        not: function(e) {
            return this.pushStack(T(this, e || [], !0))
        },
        is: function(e) {
            return !!T(this, "string" == typeof e && b.test(e) ? f(e) : e || [], !1).length
        }
    });
    var C, N = e.document,
        E = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/;
    (f.fn.init = function(e, t) {
        var n, r;
        if (!e) return this;
        if ("string" == typeof e) {
            if (!(n = "<" === e.charAt(0) && ">" === e.charAt(e.length - 1) && e.length >= 3 ? [null, e, null] : E.exec(e)) || !n[1] && t) return !t || t.jquery ? (t || C).find(e) : this.constructor(t).find(e);
            if (n[1]) {
                if (t = t instanceof f ? t[0] : t, f.merge(this, f.parseHTML(n[1], t && t.nodeType ? t.ownerDocument || t : N, !0)), x.test(n[1]) && f.isPlainObject(t))
                    for (n in t) f.isFunction(this[n]) ? this[n](t[n]) : this.attr(n, t[n]);
                return this
            }
            if ((r = N.getElementById(n[2])) && r.parentNode) {
                if (r.id !== n[2]) return C.find(e);
                this.length = 1, this[0] = r
            }
            return this.context = N, this.selector = e, this
        }
        return e.nodeType ? (this.context = this[0] = e, this.length = 1, this) : f.isFunction(e) ? void 0 !== C.ready ? C.ready(e) : e(f) : (void 0 !== e.selector && (this.selector = e.selector, this.context = e.context), f.makeArray(e, this))
    }).prototype = f.fn, C = f(N);
    var k = /^(?:parents|prev(?:Until|All))/,
        S = {
            children: !0,
            contents: !0,
            next: !0,
            prev: !0
        };

    function A(e, t) {
        do {
            e = e[t]
        } while (e && 1 !== e.nodeType);
        return e
    }
    f.extend({
        dir: function(e, t, n) {
            for (var r = [], i = e[t]; i && 9 !== i.nodeType && (void 0 === n || 1 !== i.nodeType || !f(i).is(n));) 1 === i.nodeType && r.push(i), i = i[t];
            return r
        },
        sibling: function(e, t) {
            for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
            return n
        }
    }), f.fn.extend({
        has: function(e) {
            var t, n = f(e, this),
                r = n.length;
            return this.filter(function() {
                for (t = 0; r > t; t++)
                    if (f.contains(this, n[t])) return !0
            })
        },
        closest: function(e, t) {
            for (var n, r = 0, i = this.length, o = [], a = b.test(e) || "string" != typeof e ? f(e, t || this.context) : 0; i > r; r++)
                for (n = this[r]; n && n !== t; n = n.parentNode)
                    if (n.nodeType < 11 && (a ? a.index(n) > -1 : 1 === n.nodeType && f.find.matchesSelector(n, e))) {
                        o.push(n);
                        break
                    } return this.pushStack(o.length > 1 ? f.unique(o) : o)
        },
        index: function(e) {
            return e ? "string" == typeof e ? f.inArray(this[0], f(e)) : f.inArray(e.jquery ? e[0] : e, this) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        },
        add: function(e, t) {
            return this.pushStack(f.unique(f.merge(this.get(), f(e, t))))
        },
        addBack: function(e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), f.each({
        parent: function(e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null
        },
        parents: function(e) {
            return f.dir(e, "parentNode")
        },
        parentsUntil: function(e, t, n) {
            return f.dir(e, "parentNode", n)
        },
        next: function(e) {
            return A(e, "nextSibling")
        },
        prev: function(e) {
            return A(e, "previousSibling")
        },
        nextAll: function(e) {
            return f.dir(e, "nextSibling")
        },
        prevAll: function(e) {
            return f.dir(e, "previousSibling")
        },
        nextUntil: function(e, t, n) {
            return f.dir(e, "nextSibling", n)
        },
        prevUntil: function(e, t, n) {
            return f.dir(e, "previousSibling", n)
        },
        siblings: function(e) {
            return f.sibling((e.parentNode || {}).firstChild, e)
        },
        children: function(e) {
            return f.sibling(e.firstChild)
        },
        contents: function(e) {
            return f.nodeName(e, "iframe") ? e.contentDocument || e.contentWindow.document : f.merge([], e.childNodes)
        }
    }, function(e, t) {
        f.fn[e] = function(n, r) {
            var i = f.map(this, t, n);
            return "Until" !== e.slice(-5) && (r = n), r && "string" == typeof r && (i = f.filter(r, i)), this.length > 1 && (S[e] || (i = f.unique(i)), k.test(e) && (i = i.reverse())), this.pushStack(i)
        }
    });
    var D, j = /\S+/g,
        L = {};

    function H() {
        N.addEventListener ? (N.removeEventListener("DOMContentLoaded", q, !1), e.removeEventListener("load", q, !1)) : (N.detachEvent("onreadystatechange", q), e.detachEvent("onload", q))
    }

    function q() {
        (N.addEventListener || "load" === event.type || "complete" === N.readyState) && (H(), f.ready())
    }
    f.Callbacks = function(e) {
        var t, n;
        e = "string" == typeof e ? L[e] || (n = L[t = e] = {}, f.each(t.match(j) || [], function(e, t) {
            n[t] = !0
        }), n) : f.extend({}, e);
        var r, i, o, a, s, l, u = [],
            c = !e.once && [],
            d = function(t) {
                for (i = e.memory && t, o = !0, s = l || 0, l = 0, a = u.length, r = !0; u && a > s; s++)
                    if (!1 === u[s].apply(t[0], t[1]) && e.stopOnFalse) {
                        i = !1;
                        break
                    } r = !1, u && (c ? c.length && d(c.shift()) : i ? u = [] : p.disable())
            },
            p = {
                add: function() {
                    if (u) {
                        var t = u.length;
                        ! function t(n) {
                            f.each(n, function(n, r) {
                                var i = f.type(r);
                                "function" === i ? e.unique && p.has(r) || u.push(r) : r && r.length && "string" !== i && t(r)
                            })
                        }(arguments), r ? a = u.length : i && (l = t, d(i))
                    }
                    return this
                },
                remove: function() {
                    return u && f.each(arguments, function(e, t) {
                        for (var n;
                            (n = f.inArray(t, u, n)) > -1;) u.splice(n, 1), r && (a >= n && a--, s >= n && s--)
                    }), this
                },
                has: function(e) {
                    return e ? f.inArray(e, u) > -1 : !(!u || !u.length)
                },
                empty: function() {
                    return u = [], a = 0, this
                },
                disable: function() {
                    return u = c = i = void 0, this
                },
                disabled: function() {
                    return !u
                },
                lock: function() {
                    return c = void 0, i || p.disable(), this
                },
                locked: function() {
                    return !c
                },
                fireWith: function(e, t) {
                    return !u || o && !c || (t = [e, (t = t || []).slice ? t.slice() : t], r ? c.push(t) : d(t)), this
                },
                fire: function() {
                    return p.fireWith(this, arguments), this
                },
                fired: function() {
                    return !!o
                }
            };
        return p
    }, f.extend({
        Deferred: function(e) {
            var t = [
                    ["resolve", "done", f.Callbacks("once memory"), "resolved"],
                    ["reject", "fail", f.Callbacks("once memory"), "rejected"],
                    ["notify", "progress", f.Callbacks("memory")]
                ],
                n = "pending",
                r = {
                    state: function() {
                        return n
                    },
                    always: function() {
                        return i.done(arguments).fail(arguments), this
                    },
                    then: function() {
                        var e = arguments;
                        return f.Deferred(function(n) {
                            f.each(t, function(t, o) {
                                var a = f.isFunction(e[t]) && e[t];
                                i[o[1]](function() {
                                    var e = a && a.apply(this, arguments);
                                    e && f.isFunction(e.promise) ? e.promise().done(n.resolve).fail(n.reject).progress(n.notify) : n[o[0] + "With"](this === r ? n.promise() : this, a ? [e] : arguments)
                                })
                            }), e = null
                        }).promise()
                    },
                    promise: function(e) {
                        return null != e ? f.extend(e, r) : r
                    }
                },
                i = {};
            return r.pipe = r.then, f.each(t, function(e, o) {
                var a = o[2],
                    s = o[3];
                r[o[1]] = a.add, s && a.add(function() {
                    n = s
                }, t[1 ^ e][2].disable, t[2][2].lock), i[o[0]] = function() {
                    return i[o[0] + "With"](this === i ? r : this, arguments), this
                }, i[o[0] + "With"] = a.fireWith
            }), r.promise(i), e && e.call(i, i), i
        },
        when: function(e) {
            var t, n, i, o = 0,
                a = r.call(arguments),
                s = a.length,
                l = 1 !== s || e && f.isFunction(e.promise) ? s : 0,
                u = 1 === l ? e : f.Deferred(),
                c = function(e, n, i) {
                    return function(o) {
                        n[e] = this, i[e] = arguments.length > 1 ? r.call(arguments) : o, i === t ? u.notifyWith(n, i) : --l || u.resolveWith(n, i)
                    }
                };
            if (s > 1)
                for (t = new Array(s), n = new Array(s), i = new Array(s); s > o; o++) a[o] && f.isFunction(a[o].promise) ? a[o].promise().done(c(o, i, a)).fail(u.reject).progress(c(o, n, t)) : --l;
            return l || u.resolveWith(i, a), u.promise()
        }
    }), f.fn.ready = function(e) {
        return f.ready.promise().done(e), this
    }, f.extend({
        isReady: !1,
        readyWait: 1,
        holdReady: function(e) {
            e ? f.readyWait++ : f.ready(!0)
        },
        ready: function(e) {
            if (!0 === e ? !--f.readyWait : !f.isReady) {
                if (!N.body) return setTimeout(f.ready);
                f.isReady = !0, !0 !== e && --f.readyWait > 0 || (D.resolveWith(N, [f]), f.fn.triggerHandler && (f(N).triggerHandler("ready"), f(N).off("ready")))
            }
        }
    }), f.ready.promise = function(t) {
        if (!D)
            if (D = f.Deferred(), "complete" === N.readyState) setTimeout(f.ready);
            else if (N.addEventListener) N.addEventListener("DOMContentLoaded", q, !1), e.addEventListener("load", q, !1);
        else {
            N.attachEvent("onreadystatechange", q), e.attachEvent("onload", q);
            var n = !1;
            try {
                n = null == e.frameElement && N.documentElement
            } catch (e) {}
            n && n.doScroll && function e() {
                if (!f.isReady) {
                    try {
                        n.doScroll("left")
                    } catch (t) {
                        return setTimeout(e, 50)
                    }
                    H(), f.ready()
                }
            }()
        }
        return D.promise(t)
    };
    var _, M = "undefined";
    for (_ in f(c)) break;
    c.ownLast = "0" !== _, c.inlineBlockNeedsLayout = !1, f(function() {
            var e, t, n, r;
            }),
        function() {
            var e = N.createElement("div");
            if (null == c.deleteExpando) {
                c.deleteExpando = !0;
                try {
                    delete e.test
                } catch (e) {
                    c.deleteExpando = !1
                }
            }
            e = null
        }(), f.acceptData = function(e) {
            var t = f.noData[(e.nodeName + " ").toLowerCase()],
                n = +e.nodeType || 1;
            return (1 === n || 9 === n) && (!t || !0 !== t && e.getAttribute("classid") === t)
        };
    var F = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
        O = /([A-Z])/g;

    function B(e, t, n) {
        if (void 0 === n && 1 === e.nodeType) {
            var r = "data-" + t.replace(O, "-$1").toLowerCase();
            if ("string" == typeof(n = e.getAttribute(r))) {
                try {
                    n = "true" === n || "false" !== n && ("null" === n ? null : +n + "" === n ? +n : F.test(n) ? f.parseJSON(n) : n)
                } catch (e) {}
                f.data(e, t, n)
            } else n = void 0
        }
        return n
    }

    function P(e) {
        var t;
        for (t in e)
            if (("data" !== t || !f.isEmptyObject(e[t])) && "toJSON" !== t) return !1;
        return !0
    }

    function R(e, t, r, i) {
        if (f.acceptData(e)) {
            var o, a, s = f.expando,
                l = e.nodeType,
                u = l ? f.cache : e,
                c = l ? e[s] : e[s] && s;
            if (c && u[c] && (i || u[c].data) || void 0 !== r || "string" != typeof t) return c || (c = l ? e[s] = n.pop() || f.guid++ : s), u[c] || (u[c] = l ? {} : {
                toJSON: f.noop
            }), ("object" == typeof t || "function" == typeof t) && (i ? u[c] = f.extend(u[c], t) : u[c].data = f.extend(u[c].data, t)), a = u[c], i || (a.data || (a.data = {}), a = a.data), void 0 !== r && (a[f.camelCase(t)] = r), "string" == typeof t ? null == (o = a[t]) && (o = a[f.camelCase(t)]) : o = a, o
        }
    }

    function W(e, t, n) {
        if (f.acceptData(e)) {
            var r, i, o = e.nodeType,
                a = o ? f.cache : e,
                s = o ? e[f.expando] : f.expando;
            if (a[s]) {
                if (t && (r = n ? a[s] : a[s].data)) {
                    f.isArray(t) ? t = t.concat(f.map(t, f.camelCase)) : t in r ? t = [t] : t = (t = f.camelCase(t)) in r ? [t] : t.split(" "), i = t.length;
                    for (; i--;) delete r[t[i]];
                    if (n ? !P(r) : !f.isEmptyObject(r)) return
                }(n || (delete a[s].data, P(a[s]))) && (o ? f.cleanData([e], !0) : c.deleteExpando || a != a.window ? delete a[s] : a[s] = null)
            }
        }
    }
    f.extend({
        cache: {},
        noData: {
            "applet ": !0,
            "embed ": !0,
            "object ": "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
        },
        hasData: function(e) {
            return !!(e = e.nodeType ? f.cache[e[f.expando]] : e[f.expando]) && !P(e)
        },
        data: function(e, t, n) {
            return R(e, t, n)
        },
        removeData: function(e, t) {
            return W(e, t)
        },
        _data: function(e, t, n) {
            return R(e, t, n, !0)
        },
        _removeData: function(e, t) {
            return W(e, t, !0)
        }
    }), f.fn.extend({
        data: function(e, t) {
            var n, r, i, o = this[0],
                a = o && o.attributes;
            if (void 0 === e) {
                if (this.length && (i = f.data(o), 1 === o.nodeType && !f._data(o, "parsedAttrs"))) {
                    for (n = a.length; n--;) a[n] && (0 === (r = a[n].name).indexOf("data-") && B(o, r = f.camelCase(r.slice(5)), i[r]));
                    f._data(o, "parsedAttrs", !0)
                }
                return i
            }
            return "object" == typeof e ? this.each(function() {
                f.data(this, e)
            }) : arguments.length > 1 ? this.each(function() {
                f.data(this, e, t)
            }) : o ? B(o, e, f.data(o, e)) : void 0
        },
        removeData: function(e) {
            return this.each(function() {
                f.removeData(this, e)
            })
        }
    }), f.extend({
        queue: function(e, t, n) {
            var r;
            return e ? (t = (t || "fx") + "queue", r = f._data(e, t), n && (!r || f.isArray(n) ? r = f._data(e, t, f.makeArray(n)) : r.push(n)), r || []) : void 0
        },
        dequeue: function(e, t) {
            t = t || "fx";
            var n = f.queue(e, t),
                r = n.length,
                i = n.shift(),
                o = f._queueHooks(e, t);
            "inprogress" === i && (i = n.shift(), r--), i && ("fx" === t && n.unshift("inprogress"), delete o.stop, i.call(e, function() {
                f.dequeue(e, t)
            }, o)), !r && o && o.empty.fire()
        },
        _queueHooks: function(e, t) {
            var n = t + "queueHooks";
            return f._data(e, n) || f._data(e, n, {
                empty: f.Callbacks("once memory").add(function() {
                    f._removeData(e, t + "queue"), f._removeData(e, n)
                })
            })
        }
    }), f.fn.extend({
        queue: function(e, t) {
            var n = 2;
            return "string" != typeof e && (t = e, e = "fx", n--), arguments.length < n ? f.queue(this[0], e) : void 0 === t ? this : this.each(function() {
                var n = f.queue(this, e, t);
                f._queueHooks(this, e), "fx" === e && "inprogress" !== n[0] && f.dequeue(this, e)
            })
        },
        dequeue: function(e) {
            return this.each(function() {
                f.dequeue(this, e)
            })
        },
        clearQueue: function(e) {
            return this.queue(e || "fx", [])
        },
        promise: function(e, t) {
            var n, r = 1,
                i = f.Deferred(),
                o = this,
                a = this.length,
                s = function() {
                    --r || i.resolveWith(o, [o])
                };
            for ("string" != typeof e && (t = e, e = void 0), e = e || "fx"; a--;)(n = f._data(o[a], e + "queueHooks")) && n.empty && (r++, n.empty.add(s));
            return s(), i.promise(t)
        }
    });
    var $ = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
        z = ["Top", "Right", "Bottom", "Left"],
        I = function(e, t) {
            return e = t || e, "none" === f.css(e, "display") || !f.contains(e.ownerDocument, e)
        },
        X = f.access = function(e, t, n, r, i, o, a) {
            var s = 0,
                l = e.length,
                u = null == n;
            if ("object" === f.type(n))
                for (s in i = !0, n) f.access(e, t, s, n[s], !0, o, a);
            else if (void 0 !== r && (i = !0, f.isFunction(r) || (a = !0), u && (a ? (t.call(e, r), t = null) : (u = t, t = function(e, t, n) {
                    return u.call(f(e), n)
                })), t))
                for (; l > s; s++) t(e[s], n, a ? r : r.call(e[s], s, t(e[s], n)));
            return i ? e : u ? t.call(e) : l ? t(e[0], n) : o
        },
        U = /^(?:checkbox|radio)$/i;
    ! function() {
        var e = N.createElement("input"),
            t = N.createElement("div"),
            n = N.createDocumentFragment();
        if (t.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", c.leadingWhitespace = 3 === t.firstChild.nodeType, c.tbody = !t.getElementsByTagName("tbody").length, c.htmlSerialize = !!t.getElementsByTagName("link").length, c.html5Clone = "<:nav></:nav>" !== N.createElement("nav").cloneNode(!0).outerHTML, e.type = "checkbox", e.checked = !0, n.appendChild(e), c.appendChecked = e.checked, t.innerHTML = "<textarea>x</textarea>", c.noCloneChecked = !!t.cloneNode(!0).lastChild.defaultValue, n.appendChild(t), t.innerHTML = "<input type='radio' checked='checked' name='t'/>", c.checkClone = t.cloneNode(!0).cloneNode(!0).lastChild.checked, c.noCloneEvent = !0, t.attachEvent && (t.attachEvent("onclick", function() {
                c.noCloneEvent = !1
            }), t.cloneNode(!0).click()), null == c.deleteExpando) {
            c.deleteExpando = !0;
            try {
                delete t.test
            } catch (e) {
                c.deleteExpando = !1
            }
        }
    }(),
    function() {
        var t, n, r = N.createElement("div");
        for (t in {
                submit: !0,
                change: !0,
                focusin: !0
            }) n = "on" + t, (c[t + "Bubbles"] = n in e) || (r.setAttribute(n, "t"), c[t + "Bubbles"] = !1 === r.attributes[n].expando);
        r = null
    }();
    var V = /^(?:input|select|textarea)$/i,
        J = /^key/,
        Y = /^(?:mouse|pointer|contextmenu)|click/,
        G = /^(?:focusinfocus|focusoutblur)$/,
        Q = /^([^.]*)(?:\.(.+)|)$/;

    function K() {
        return !0
    }

    function Z() {
        return !1
    }

    function ee() {
        try {
            return N.activeElement
        } catch (e) {}
    }

    function te(e) {
        var t = ne.split("|"),
            n = e.createDocumentFragment();
        if (n.createElement)
            for (; t.length;) n.createElement(t.pop());
        return n
    }
    f.event = {
        global: {},
        add: function(e, t, n, r, i) {
            var o, a, s, l, u, c, d, p, h, m, g, v = f._data(e);
            if (v) {
                for (n.handler && (n = (l = n).handler, i = l.selector), n.guid || (n.guid = f.guid++), (a = v.events) || (a = v.events = {}), (c = v.handle) || ((c = v.handle = function(e) {
                        return typeof f === M || e && f.event.triggered === e.type ? void 0 : f.event.dispatch.apply(c.elem, arguments)
                    }).elem = e), s = (t = (t || "").match(j) || [""]).length; s--;) h = g = (o = Q.exec(t[s]) || [])[1], m = (o[2] || "").split(".").sort(), h && (u = f.event.special[h] || {}, h = (i ? u.delegateType : u.bindType) || h, u = f.event.special[h] || {}, d = f.extend({
                    type: h,
                    origType: g,
                    data: r,
                    handler: n,
                    guid: n.guid,
                    selector: i,
                    needsContext: i && f.expr.match.needsContext.test(i),
                    namespace: m.join(".")
                }, l), (p = a[h]) || ((p = a[h] = []).delegateCount = 0, u.setup && !1 !== u.setup.call(e, r, m, c) || (e.addEventListener ? e.addEventListener(h, c, !1) : e.attachEvent && e.attachEvent("on" + h, c))), u.add && (u.add.call(e, d), d.handler.guid || (d.handler.guid = n.guid)), i ? p.splice(p.delegateCount++, 0, d) : p.push(d), f.event.global[h] = !0);
                e = null
            }
        },
        remove: function(e, t, n, r, i) {
            var o, a, s, l, u, c, d, p, h, m, g, v = f.hasData(e) && f._data(e);
            if (v && (c = v.events)) {
                for (u = (t = (t || "").match(j) || [""]).length; u--;)
                    if (h = g = (s = Q.exec(t[u]) || [])[1], m = (s[2] || "").split(".").sort(), h) {
                        for (d = f.event.special[h] || {}, p = c[h = (r ? d.delegateType : d.bindType) || h] || [], s = s[2] && new RegExp("(^|\\.)" + m.join("\\.(?:.*\\.|)") + "(\\.|$)"), l = o = p.length; o--;) a = p[o], !i && g !== a.origType || n && n.guid !== a.guid || s && !s.test(a.namespace) || r && r !== a.selector && ("**" !== r || !a.selector) || (p.splice(o, 1), a.selector && p.delegateCount--, d.remove && d.remove.call(e, a));
                        l && !p.length && (d.teardown && !1 !== d.teardown.call(e, m, v.handle) || f.removeEvent(e, h, v.handle), delete c[h])
                    } else
                        for (h in c) f.event.remove(e, h + t[u], n, r, !0);
                f.isEmptyObject(c) && (delete v.handle, f._removeData(e, "events"))
            }
        },
        trigger: function(t, n, r, i) {
            var o, a, s, l, c, d, p, h = [r || N],
                m = u.call(t, "type") ? t.type : t,
                g = u.call(t, "namespace") ? t.namespace.split(".") : [];
            if (s = d = r = r || N, 3 !== r.nodeType && 8 !== r.nodeType && !G.test(m + f.event.triggered) && (m.indexOf(".") >= 0 && (m = (g = m.split(".")).shift(), g.sort()), a = m.indexOf(":") < 0 && "on" + m, (t = t[f.expando] ? t : new f.Event(m, "object" == typeof t && t)).isTrigger = i ? 2 : 3, t.namespace = g.join("."), t.namespace_re = t.namespace ? new RegExp("(^|\\.)" + g.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, t.result = void 0, t.target || (t.target = r), n = null == n ? [t] : f.makeArray(n, [t]), c = f.event.special[m] || {}, i || !c.trigger || !1 !== c.trigger.apply(r, n))) {
                if (!i && !c.noBubble && !f.isWindow(r)) {
                    for (l = c.delegateType || m, G.test(l + m) || (s = s.parentNode); s; s = s.parentNode) h.push(s), d = s;
                    d === (r.ownerDocument || N) && h.push(d.defaultView || d.parentWindow || e)
                }
                for (p = 0;
                    (s = h[p++]) && !t.isPropagationStopped();) t.type = p > 1 ? l : c.bindType || m, (o = (f._data(s, "events") || {})[t.type] && f._data(s, "handle")) && o.apply(s, n), (o = a && s[a]) && o.apply && f.acceptData(s) && (t.result = o.apply(s, n), !1 === t.result && t.preventDefault());
                if (t.type = m, !i && !t.isDefaultPrevented() && (!c._default || !1 === c._default.apply(h.pop(), n)) && f.acceptData(r) && a && r[m] && !f.isWindow(r)) {
                    (d = r[a]) && (r[a] = null), f.event.triggered = m;
                    try {
                        r[m]()
                    } catch (e) {}
                    f.event.triggered = void 0, d && (r[a] = d)
                }
                return t.result
            }
        },
        dispatch: function(e) {
            e = f.event.fix(e);
            var t, n, i, o, a, s = [],
                l = r.call(arguments),
                u = (f._data(this, "events") || {})[e.type] || [],
                c = f.event.special[e.type] || {};
            if (l[0] = e, e.delegateTarget = this, !c.preDispatch || !1 !== c.preDispatch.call(this, e)) {
                for (s = f.event.handlers.call(this, e, u), t = 0;
                    (o = s[t++]) && !e.isPropagationStopped();)
                    for (e.currentTarget = o.elem, a = 0;
                        (i = o.handlers[a++]) && !e.isImmediatePropagationStopped();)(!e.namespace_re || e.namespace_re.test(i.namespace)) && (e.handleObj = i, e.data = i.data, void 0 !== (n = ((f.event.special[i.origType] || {}).handle || i.handler).apply(o.elem, l)) && !1 === (e.result = n) && (e.preventDefault(), e.stopPropagation()));
                return c.postDispatch && c.postDispatch.call(this, e), e.result
            }
        },
        handlers: function(e, t) {
            var n, r, i, o, a = [],
                s = t.delegateCount,
                l = e.target;
            if (s && l.nodeType && (!e.button || "click" !== e.type))
                for (; l != this; l = l.parentNode || this)
                    if (1 === l.nodeType && (!0 !== l.disabled || "click" !== e.type)) {
                        for (i = [], o = 0; s > o; o++) void 0 === i[n = (r = t[o]).selector + " "] && (i[n] = r.needsContext ? f(n, this).index(l) >= 0 : f.find(n, this, null, [l]).length), i[n] && i.push(r);
                        i.length && a.push({
                            elem: l,
                            handlers: i
                        })
                    } return s < t.length && a.push({
                elem: this,
                handlers: t.slice(s)
            }), a
        },
        fix: function(e) {
            if (e[f.expando]) return e;
            var t, n, r, i = e.type,
                o = e,
                a = this.fixHooks[i];
            for (a || (this.fixHooks[i] = a = Y.test(i) ? this.mouseHooks : J.test(i) ? this.keyHooks : {}), r = a.props ? this.props.concat(a.props) : this.props, e = new f.Event(o), t = r.length; t--;) e[n = r[t]] = o[n];
            return e.target || (e.target = o.srcElement || N), 3 === e.target.nodeType && (e.target = e.target.parentNode), e.metaKey = !!e.metaKey, a.filter ? a.filter(e, o) : e
        },
        props: "altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
        fixHooks: {},
        keyHooks: {
            props: "char charCode key keyCode".split(" "),
            filter: function(e, t) {
                return null == e.which && (e.which = null != t.charCode ? t.charCode : t.keyCode), e
            }
        },
        mouseHooks: {
            props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
            filter: function(e, t) {
                var n, r, i, o = t.button,
                    a = t.fromElement;
                return null == e.pageX && null != t.clientX && (i = (r = e.target.ownerDocument || N).documentElement, n = r.body, e.pageX = t.clientX + (i && i.scrollLeft || n && n.scrollLeft || 0) - (i && i.clientLeft || n && n.clientLeft || 0), e.pageY = t.clientY + (i && i.scrollTop || n && n.scrollTop || 0) - (i && i.clientTop || n && n.clientTop || 0)), !e.relatedTarget && a && (e.relatedTarget = a === e.target ? t.toElement : a), e.which || void 0 === o || (e.which = 1 & o ? 1 : 2 & o ? 3 : 4 & o ? 2 : 0), e
            }
        },
        special: {
            load: {
                noBubble: !0
            },
            focus: {
                trigger: function() {
                    if (this !== ee() && this.focus) try {
                        return this.focus(), !1
                    } catch (e) {}
                },
                delegateType: "focusin"
            },
            blur: {
                trigger: function() {
                    return this === ee() && this.blur ? (this.blur(), !1) : void 0
                },
                delegateType: "focusout"
            },
            click: {
                trigger: function() {
                    return f.nodeName(this, "input") && "checkbox" === this.type && this.click ? (this.click(), !1) : void 0
                },
                _default: function(e) {
                    return f.nodeName(e.target, "a")
                }
            },
            beforeunload: {
                postDispatch: function(e) {
                    void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
                }
            }
        },
        simulate: function(e, t, n, r) {
            var i = f.extend(new f.Event, n, {
                type: e,
                isSimulated: !0,
                originalEvent: {}
            });
            r ? f.event.trigger(i, null, t) : f.event.dispatch.call(t, i), i.isDefaultPrevented() && n.preventDefault()
        }
    }, f.removeEvent = N.removeEventListener ? function(e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n, !1)
    } : function(e, t, n) {
        var r = "on" + t;
        e.detachEvent && (typeof e[r] === M && (e[r] = null), e.detachEvent(r, n))
    }, f.Event = function(e, t) {
        return this instanceof f.Event ? (e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && !1 === e.returnValue ? K : Z) : this.type = e, t && f.extend(this, t), this.timeStamp = e && e.timeStamp || f.now(), void(this[f.expando] = !0)) : new f.Event(e, t)
    }, f.Event.prototype = {
        isDefaultPrevented: Z,
        isPropagationStopped: Z,
        isImmediatePropagationStopped: Z,
        preventDefault: function() {
            var e = this.originalEvent;
            this.isDefaultPrevented = K, e && (e.preventDefault ? e.preventDefault() : e.returnValue = !1)
        },
        stopPropagation: function() {
            var e = this.originalEvent;
            this.isPropagationStopped = K, e && (e.stopPropagation && e.stopPropagation(), e.cancelBubble = !0)
        },
        stopImmediatePropagation: function() {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = K, e && e.stopImmediatePropagation && e.stopImmediatePropagation(), this.stopPropagation()
        }
    }, f.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function(e, t) {
        f.event.special[e] = {
            delegateType: t,
            bindType: t,
            handle: function(e) {
                var n, r = e.relatedTarget,
                    i = e.handleObj;
                return (!r || r !== this && !f.contains(this, r)) && (e.type = i.origType, n = i.handler.apply(this, arguments), e.type = t), n
            }
        }
    }), c.submitBubbles || (f.event.special.submit = {
        setup: function() {
            return !f.nodeName(this, "form") && void f.event.add(this, "click._submit keypress._submit", function(e) {
                var t = e.target,
                    n = f.nodeName(t, "input") || f.nodeName(t, "button") ? t.form : void 0;
                n && !f._data(n, "submitBubbles") && (f.event.add(n, "submit._submit", function(e) {
                    e._submit_bubble = !0
                }), f._data(n, "submitBubbles", !0))
            })
        },
        postDispatch: function(e) {
            e._submit_bubble && (delete e._submit_bubble, this.parentNode && !e.isTrigger && f.event.simulate("submit", this.parentNode, e, !0))
        },
        teardown: function() {
            return !f.nodeName(this, "form") && void f.event.remove(this, "._submit")
        }
    }), c.changeBubbles || (f.event.special.change = {
        setup: function() {
            return V.test(this.nodeName) ? (("checkbox" === this.type || "radio" === this.type) && (f.event.add(this, "propertychange._change", function(e) {
                "checked" === e.originalEvent.propertyName && (this._just_changed = !0)
            }), f.event.add(this, "click._change", function(e) {
                this._just_changed && !e.isTrigger && (this._just_changed = !1), f.event.simulate("change", this, e, !0)
            })), !1) : void f.event.add(this, "beforeactivate._change", function(e) {
                var t = e.target;
                V.test(t.nodeName) && !f._data(t, "changeBubbles") && (f.event.add(t, "change._change", function(e) {
                    !this.parentNode || e.isSimulated || e.isTrigger || f.event.simulate("change", this.parentNode, e, !0)
                }), f._data(t, "changeBubbles", !0))
            })
        },
        handle: function(e) {
            var t = e.target;
            return this !== t || e.isSimulated || e.isTrigger || "radio" !== t.type && "checkbox" !== t.type ? e.handleObj.handler.apply(this, arguments) : void 0
        },
        teardown: function() {
            return f.event.remove(this, "._change"), !V.test(this.nodeName)
        }
    }), c.focusinBubbles || f.each({
        focus: "focusin",
        blur: "focusout"
    }, function(e, t) {
        var n = function(e) {
            f.event.simulate(t, e.target, f.event.fix(e), !0)
        };
        f.event.special[t] = {
            setup: function() {
                var r = this.ownerDocument || this,
                    i = f._data(r, t);
                i || r.addEventListener(e, n, !0), f._data(r, t, (i || 0) + 1)
            },
            teardown: function() {
                var r = this.ownerDocument || this,
                    i = f._data(r, t) - 1;
                i ? f._data(r, t, i) : (r.removeEventListener(e, n, !0), f._removeData(r, t))
            }
        }
    }), f.fn.extend({
        on: function(e, t, n, r, i) {
            var o, a;
            if ("object" == typeof e) {
                for (o in "string" != typeof t && (n = n || t, t = void 0), e) this.on(o, t, n, e[o], i);
                return this
            }
            if (null == n && null == r ? (r = t, n = t = void 0) : null == r && ("string" == typeof t ? (r = n, n = void 0) : (r = n, n = t, t = void 0)), !1 === r) r = Z;
            else if (!r) return this;
            return 1 === i && (a = r, (r = function(e) {
                return f().off(e), a.apply(this, arguments)
            }).guid = a.guid || (a.guid = f.guid++)), this.each(function() {
                f.event.add(this, e, r, n, t)
            })
        },
        one: function(e, t, n, r) {
            return this.on(e, t, n, r, 1)
        },
        off: function(e, t, n) {
            var r, i;
            if (e && e.preventDefault && e.handleObj) return r = e.handleObj, f(e.delegateTarget).off(r.namespace ? r.origType + "." + r.namespace : r.origType, r.selector, r.handler), this;
            if ("object" == typeof e) {
                for (i in e) this.off(i, t, e[i]);
                return this
            }
            return (!1 === t || "function" == typeof t) && (n = t, t = void 0), !1 === n && (n = Z), this.each(function() {
                f.event.remove(this, e, n, t)
            })
        },
        trigger: function(e, t) {
            return this.each(function() {
                f.event.trigger(e, t, this)
            })
        },
        triggerHandler: function(e, t) {
            var n = this[0];
            return n ? f.event.trigger(e, t, n, !0) : void 0
        }
    });
    var ne = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",
        re = / jQuery\d+="(?:null|\d+)"/g,
        ie = new RegExp("<(?:" + ne + ")[\\s/>]", "i"),
        oe = /^\s+/,
        ae = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
        se = /<([\w:]+)/,
        le = /<tbody/i,
        ue = /<|&#?\w+;/,
        ce = /<(?:script|style|link)/i,
        de = /checked\s*(?:[^=]|=\s*.checked.)/i,
        fe = /^$|\/(?:java|ecma)script/i,
        pe = /^true\/(.*)/,
        he = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,
        me = {
            option: [1, "<select multiple='multiple'>", "</select>"],
            legend: [1, "<fieldset>", "</fieldset>"],
            area: [1, "<map>", "</map>"],
            param: [1, "<object>", "</object>"],
            thead: [1, "<table>", "</table>"],
            tr: [2, "<table><tbody>", "</tbody></table>"],
            col: [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"],
            td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
            _default: c.htmlSerialize ? [0, "", ""] : [1, "X<div>", "</div>"]
        },
        ge = te(N).appendChild(N.createElement("div"));

    function ve(e, t) {
        var n, r, i = 0,
            o = typeof e.getElementsByTagName !== M ? e.getElementsByTagName(t || "*") : typeof e.querySelectorAll !== M ? e.querySelectorAll(t || "*") : void 0;
        if (!o)
            for (o = [], n = e.childNodes || e; null != (r = n[i]); i++) !t || f.nodeName(r, t) ? o.push(r) : f.merge(o, ve(r, t));
        return void 0 === t || t && f.nodeName(e, t) ? f.merge([e], o) : o
    }

    function ye(e) {
        U.test(e.type) && (e.defaultChecked = e.checked)
    }

    function be(e, t) {
        return f.nodeName(e, "table") && f.nodeName(11 !== t.nodeType ? t : t.firstChild, "tr") ? e.getElementsByTagName("tbody")[0] || e.appendChild(e.ownerDocument.createElement("tbody")) : e
    }

    function xe(e) {
        return e.type = (null !== f.find.attr(e, "type")) + "/" + e.type, e
    }

    function we(e) {
        var t = pe.exec(e.type);
        return t ? e.type = t[1] : e.removeAttribute("type"), e
    }

    function Te(e, t) {
        for (var n, r = 0; null != (n = e[r]); r++) f._data(n, "globalEval", !t || f._data(t[r], "globalEval"))
    }

    function Ce(e, t) {
        if (1 === t.nodeType && f.hasData(e)) {
            var n, r, i, o = f._data(e),
                a = f._data(t, o),
                s = o.events;
            if (s)
                for (n in delete a.handle, a.events = {}, s)
                    for (r = 0, i = s[n].length; i > r; r++) f.event.add(t, n, s[n][r]);
            a.data && (a.data = f.extend({}, a.data))
        }
    }

    function Ne(e, t) {
        var n, r, i;
        if (1 === t.nodeType) {
            if (n = t.nodeName.toLowerCase(), !c.noCloneEvent && t[f.expando]) {
                for (r in (i = f._data(t)).events) f.removeEvent(t, r, i.handle);
                t.removeAttribute(f.expando)
            }
            "script" === n && t.text !== e.text ? (xe(t).text = e.text, we(t)) : "object" === n ? (t.parentNode && (t.outerHTML = e.outerHTML), c.html5Clone && e.innerHTML && !f.trim(t.innerHTML) && (t.innerHTML = e.innerHTML)) : "input" === n && U.test(e.type) ? (t.defaultChecked = t.checked = e.checked, t.value !== e.value && (t.value = e.value)) : "option" === n ? t.defaultSelected = t.selected = e.defaultSelected : ("input" === n || "textarea" === n) && (t.defaultValue = e.defaultValue)
        }
    }
    me.optgroup = me.option, me.tbody = me.tfoot = me.colgroup = me.caption = me.thead, me.th = me.td, f.extend({
        clone: function(e, t, n) {
            var r, i, o, a, s, l = f.contains(e.ownerDocument, e);
            if (c.html5Clone || f.isXMLDoc(e) || !ie.test("<" + e.nodeName + ">") ? o = e.cloneNode(!0) : (ge.innerHTML = e.outerHTML, ge.removeChild(o = ge.firstChild)), !(c.noCloneEvent && c.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || f.isXMLDoc(e)))
                for (r = ve(o), s = ve(e), a = 0; null != (i = s[a]); ++a) r[a] && Ne(i, r[a]);
            if (t)
                if (n)
                    for (s = s || ve(e), r = r || ve(o), a = 0; null != (i = s[a]); a++) Ce(i, r[a]);
                else Ce(e, o);
            return (r = ve(o, "script")).length > 0 && Te(r, !l && ve(e, "script")), r = s = i = null, o
        },
        buildFragment: function(e, t, n, r) {
            for (var i, o, a, s, l, u, d, p = e.length, h = te(t), m = [], g = 0; p > g; g++)
                if ((o = e[g]) || 0 === o)
                    if ("object" === f.type(o)) f.merge(m, o.nodeType ? [o] : o);
                    else if (ue.test(o)) {
                for (s = s || h.appendChild(t.createElement("div")), l = (se.exec(o) || ["", ""])[1].toLowerCase(), d = me[l] || me._default, s.innerHTML = d[1] + o.replace(ae, "<$1></$2>") + d[2], i = d[0]; i--;) s = s.lastChild;
                if (!c.leadingWhitespace && oe.test(o) && m.push(t.createTextNode(oe.exec(o)[0])), !c.tbody)
                    for (i = (o = "table" !== l || le.test(o) ? "<table>" !== d[1] || le.test(o) ? 0 : s : s.firstChild) && o.childNodes.length; i--;) f.nodeName(u = o.childNodes[i], "tbody") && !u.childNodes.length && o.removeChild(u);
                for (f.merge(m, s.childNodes), s.textContent = ""; s.firstChild;) s.removeChild(s.firstChild);
                s = h.lastChild
            } else m.push(t.createTextNode(o));
            for (s && h.removeChild(s), c.appendChecked || f.grep(ve(m, "input"), ye), g = 0; o = m[g++];)
                if ((!r || -1 === f.inArray(o, r)) && (a = f.contains(o.ownerDocument, o), s = ve(h.appendChild(o), "script"), a && Te(s), n))
                    for (i = 0; o = s[i++];) fe.test(o.type || "") && n.push(o);
            return s = null, h
        },
        cleanData: function(e, t) {
            for (var r, i, o, a, s = 0, l = f.expando, u = f.cache, d = c.deleteExpando, p = f.event.special; null != (r = e[s]); s++)
                if ((t || f.acceptData(r)) && (a = (o = r[l]) && u[o])) {
                    if (a.events)
                        for (i in a.events) p[i] ? f.event.remove(r, i) : f.removeEvent(r, i, a.handle);
                    u[o] && (delete u[o], d ? delete r[l] : typeof r.removeAttribute !== M ? r.removeAttribute(l) : r[l] = null, n.push(o))
                }
        }
    }), f.fn.extend({
        text: function(e) {
            return X(this, function(e) {
                return void 0 === e ? f.text(this) : this.empty().append((this[0] && this[0].ownerDocument || N).createTextNode(e))
            }, null, e, arguments.length)
        },
        append: function() {
            return this.domManip(arguments, function(e) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || be(this, e).appendChild(e)
            })
        },
        prepend: function() {
            return this.domManip(arguments, function(e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = be(this, e);
                    t.insertBefore(e, t.firstChild)
                }
            })
        },
        before: function() {
            return this.domManip(arguments, function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            })
        },
        after: function() {
            return this.domManip(arguments, function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            })
        },
        remove: function(e, t) {
            for (var n, r = e ? f.filter(e, this) : this, i = 0; null != (n = r[i]); i++) t || 1 !== n.nodeType || f.cleanData(ve(n)), n.parentNode && (t && f.contains(n.ownerDocument, n) && Te(ve(n, "script")), n.parentNode.removeChild(n));
            return this
        },
        empty: function() {
            for (var e, t = 0; null != (e = this[t]); t++) {
                for (1 === e.nodeType && f.cleanData(ve(e, !1)); e.firstChild;) e.removeChild(e.firstChild);
                e.options && f.nodeName(e, "select") && (e.options.length = 0)
            }
            return this
        },
        clone: function(e, t) {
            return e = null != e && e, t = null == t ? e : t, this.map(function() {
                return f.clone(this, e, t)
            })
        },
        html: function(e) {
            return X(this, function(e) {
                var t = this[0] || {},
                    n = 0,
                    r = this.length;
                if (void 0 === e) return 1 === t.nodeType ? t.innerHTML.replace(re, "") : void 0;
                if (!("string" != typeof e || ce.test(e) || !c.htmlSerialize && ie.test(e) || !c.leadingWhitespace && oe.test(e) || me[(se.exec(e) || ["", ""])[1].toLowerCase()])) {
                    e = e.replace(ae, "<$1></$2>");
                    try {
                        for (; r > n; n++) 1 === (t = this[n] || {}).nodeType && (f.cleanData(ve(t, !1)), t.innerHTML = e);
                        t = 0
                    } catch (e) {}
                }
                t && this.empty().append(e)
            }, null, e, arguments.length)
        },
        replaceWith: function() {
            var e = arguments[0];
            return this.domManip(arguments, function(t) {
                e = this.parentNode, f.cleanData(ve(this)), e && e.replaceChild(t, this)
            }), e && (e.length || e.nodeType) ? this : this.remove()
        },
        detach: function(e) {
            return this.remove(e, !0)
        },
        domManip: function(e, t) {
            e = i.apply([], e);
            var n, r, o, a, s, l, u = 0,
                d = this.length,
                p = this,
                h = d - 1,
                m = e[0],
                g = f.isFunction(m);
            if (g || d > 1 && "string" == typeof m && !c.checkClone && de.test(m)) return this.each(function(n) {
                var r = p.eq(n);
                g && (e[0] = m.call(this, n, r.html())), r.domManip(e, t)
            });
            if (d && (n = (l = f.buildFragment(e, this[0].ownerDocument, !1, this)).firstChild, 1 === l.childNodes.length && (l = n), n)) {
                for (o = (a = f.map(ve(l, "script"), xe)).length; d > u; u++) r = l, u !== h && (r = f.clone(r, !0, !0), o && f.merge(a, ve(r, "script"))), t.call(this[u], r, u);
                if (o)
                    for (s = a[a.length - 1].ownerDocument, f.map(a, we), u = 0; o > u; u++) r = a[u], fe.test(r.type || "") && !f._data(r, "globalEval") && f.contains(s, r) && (r.src ? f._evalUrl && f._evalUrl(r.src) : f.globalEval((r.text || r.textContent || r.innerHTML || "").replace(he, "")));
                l = n = null
            }
            return this
        }
    }), f.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function(e, t) {
        f.fn[e] = function(e) {
            for (var n, r = 0, i = [], a = f(e), s = a.length - 1; s >= r; r++) n = r === s ? this : this.clone(!0), f(a[r])[t](n), o.apply(i, n.get());
            return this.pushStack(i)
        }
    });
    var Ee, ke, Se = {};

    function Ae(t, n) {
        var r, i = f(n.createElement(t)).appendTo(n.body),
            o = e.getDefaultComputedStyle && (r = e.getDefaultComputedStyle(i[0])) ? r.display : f.css(i[0], "display");
        return i.detach(), o
    }

    function De(e) {
        var t = N,
            n = Se[e];
        return n || ("none" !== (n = Ae(e, t)) && n || ((t = ((Ee = (Ee || f("<iframe frameborder='0' width='0' height='0'/>")).appendTo(t.documentElement))[0].contentWindow || Ee[0].contentDocument).document).write(), t.close(), n = Ae(e, t), Ee.detach()), Se[e] = n), n
    }
    c.shrinkWrapBlocks = function() {
        return null != ke ? ke : (ke = !1, (t = N.getElementsByTagName("body")[0]) && t.style ? (e = N.createElement("div"), (n = N.createElement("div")).style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", t.appendChild(n).appendChild(e), typeof e.style.zoom !== M && (e.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:1px;width:1px;zoom:1", e.appendChild(N.createElement("div")).style.width = "5px", ke = 3 !== e.offsetWidth), t.removeChild(n), ke) : void 0);
        var e, t, n
    };
    var je, Le, He = /^margin/,
        qe = new RegExp("^(" + $ + ")(?!px)[a-z%]+$", "i"),
        _e = /^(top|right|bottom|left)$/;

    function Me(e, t) {
        return {
            get: function() {
                var n = e();
                if (null != n) return n ? void delete this.get : (this.get = t).apply(this, arguments)
            }
        }
    }
    e.getComputedStyle ? (je = function(t) {
            return t.ownerDocument.defaultView.opener ? t.ownerDocument.defaultView.getComputedStyle(t, null) : e.getComputedStyle(t, null)
        }, Le = function(e, t, n) {
            var r, i, o, a, s = e.style;
            return a = (n = n || je(e)) ? n.getPropertyValue(t) || n[t] : void 0, n && ("" !== a || f.contains(e.ownerDocument, e) || (a = f.style(e, t)), qe.test(a) && He.test(t) && (r = s.width, i = s.minWidth, o = s.maxWidth, s.minWidth = s.maxWidth = s.width = a, a = n.width, s.width = r, s.minWidth = i, s.maxWidth = o)), void 0 === a ? a : a + ""
        }) : N.documentElement.currentStyle && (je = function(e) {
            return e.currentStyle
        }, Le = function(e, t, n) {
            var r, i, o, a, s = e.style;
            return null == (a = (n = n || je(e)) ? n[t] : void 0) && s && s[t] && (a = s[t]), qe.test(a) && !_e.test(t) && (r = s.left, (o = (i = e.runtimeStyle) && i.left) && (i.left = e.currentStyle.left), s.left = "fontSize" === t ? "1em" : a, a = s.pixelLeft + "px", s.left = r, o && (i.left = o)), void 0 === a ? a : a + "" || "auto"
        }),
        function() {
            var t, n, r, i, o, a, s;
            if ((t = N.createElement("div")).innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", n = (r = t.getElementsByTagName("a")[0]) && r.style) {
                function l() {
                    var t, n, r, l;
                    (n = N.getElementsByTagName("body")[0]) && n.style && (t = N.createElement("div"), (r = N.createElement("div")).style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", n.appendChild(r).appendChild(t), t.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;display:block;margin-top:1%;top:1%;border:1px;padding:1px;width:4px;position:absolute", i = o = !1, s = !0, e.getComputedStyle && (i = "1%" !== (e.getComputedStyle(t, null) || {}).top, o = "4px" === (e.getComputedStyle(t, null) || {
                        width: "4px"
                    }).width, (l = t.appendChild(N.createElement("div"))).style.cssText = t.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0", l.style.marginRight = l.style.width = "0", t.style.width = "1px", s = !parseFloat((e.getComputedStyle(l, null) || {}).marginRight), t.removeChild(l)), t.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", (l = t.getElementsByTagName("td"))[0].style.cssText = "margin:0;border:0;padding:0;display:none", (a = 0 === l[0].offsetHeight) && (l[0].style.display = "", l[1].style.display = "none", a = 0 === l[0].offsetHeight), n.removeChild(r))
                }
                n.cssText = "float:left;opacity:.5", c.opacity = "0.5" === n.opacity, c.cssFloat = !!n.cssFloat, t.style.backgroundClip = "content-box", t.cloneNode(!0).style.backgroundClip = "", c.clearCloneStyle = "content-box" === t.style.backgroundClip, c.boxSizing = "" === n.boxSizing || "" === n.MozBoxSizing || "" === n.WebkitBoxSizing, f.extend(c, {
                    reliableHiddenOffsets: function() {
                        return null == a && l(), a
                    },
                    boxSizingReliable: function() {
                        return null == o && l(), o
                    },
                    pixelPosition: function() {
                        return null == i && l(), i
                    },
                    reliableMarginRight: function() {
                        return null == s && l(), s
                    }
                })
            }
        }(), f.swap = function(e, t, n, r) {
            var i, o, a = {};
            for (o in t) a[o] = e.style[o], e.style[o] = t[o];
            for (o in i = n.apply(e, r || []), t) e.style[o] = a[o];
            return i
        };
    var Fe = /alpha\([^)]*\)/i,
        Oe = /opacity\s*=\s*([^)]*)/,
        Be = /^(none|table(?!-c[ea]).+)/,
        Pe = new RegExp("^(" + $ + ")(.*)$", "i"),
        Re = new RegExp("^([+-])=(" + $ + ")", "i"),
        We = {
            position: "absolute",
            visibility: "hidden",
            display: "block"
        },
        $e = {
            letterSpacing: "0",
            fontWeight: "400"
        },
        ze = ["Webkit", "O", "Moz", "ms"];

    function Ie(e, t) {
        if (t in e) return t;
        for (var n = t.charAt(0).toUpperCase() + t.slice(1), r = t, i = ze.length; i--;)
            if ((t = ze[i] + n) in e) return t;
        return r
    }

    function Xe(e, t) {
        for (var n, r, i, o = [], a = 0, s = e.length; s > a; a++)(r = e[a]).style && (o[a] = f._data(r, "olddisplay"), n = r.style.display, t ? (o[a] || "none" !== n || (r.style.display = ""), "" === r.style.display && I(r) && (o[a] = f._data(r, "olddisplay", De(r.nodeName)))) : (i = I(r), (n && "none" !== n || !i) && f._data(r, "olddisplay", i ? n : f.css(r, "display"))));
        for (a = 0; s > a; a++)(r = e[a]).style && (t && "none" !== r.style.display && "" !== r.style.display || (r.style.display = t ? o[a] || "" : "none"));
        return e
    }

    function Ue(e, t, n) {
        var r = Pe.exec(t);
        return r ? Math.max(0, r[1] - (n || 0)) + (r[2] || "px") : t
    }

    function Ve(e, t, n, r, i) {
        for (var o = n === (r ? "border" : "content") ? 4 : "width" === t ? 1 : 0, a = 0; 4 > o; o += 2) "margin" === n && (a += f.css(e, n + z[o], !0, i)), r ? ("content" === n && (a -= f.css(e, "padding" + z[o], !0, i)), "margin" !== n && (a -= f.css(e, "border" + z[o] + "Width", !0, i))) : (a += f.css(e, "padding" + z[o], !0, i), "padding" !== n && (a += f.css(e, "border" + z[o] + "Width", !0, i)));
        return a
    }

    function Je(e, t, n) {
        var r = !0,
            i = "width" === t ? e.offsetWidth : e.offsetHeight,
            o = je(e),
            a = c.boxSizing && "border-box" === f.css(e, "boxSizing", !1, o);
        if (0 >= i || null == i) {
            if ((0 > (i = Le(e, t, o)) || null == i) && (i = e.style[t]), qe.test(i)) return i;
            r = a && (c.boxSizingReliable() || i === e.style[t]), i = parseFloat(i) || 0
        }
        return i + Ve(e, t, n || (a ? "border" : "content"), r, o) + "px"
    }

    function Ye(e, t, n, r, i) {
        return new Ye.prototype.init(e, t, n, r, i)
    }
    f.extend({
        cssHooks: {
            opacity: {
                get: function(e, t) {
                    if (t) {
                        var n = Le(e, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {
            float: c.cssFloat ? "cssFloat" : "styleFloat"
        },
        style: function(e, t, n, r) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var i, o, a, s = f.camelCase(t),
                    l = e.style;
                if (t = f.cssProps[s] || (f.cssProps[s] = Ie(l, s)), a = f.cssHooks[t] || f.cssHooks[s], void 0 === n) return a && "get" in a && void 0 !== (i = a.get(e, !1, r)) ? i : l[t];
                if ("string" === (o = typeof n) && (i = Re.exec(n)) && (n = (i[1] + 1) * i[2] + parseFloat(f.css(e, t)), o = "number"), null != n && n == n && ("number" !== o || f.cssNumber[s] || (n += "px"), c.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (l[t] = "inherit"), !(a && "set" in a && void 0 === (n = a.set(e, n, r))))) try {
                    l[t] = n
                } catch (e) {}
            }
        },
        css: function(e, t, n, r) {
            var i, o, a, s = f.camelCase(t);
            return t = f.cssProps[s] || (f.cssProps[s] = Ie(e.style, s)), (a = f.cssHooks[t] || f.cssHooks[s]) && "get" in a && (o = a.get(e, !0, n)), void 0 === o && (o = Le(e, t, r)), "normal" === o && t in $e && (o = $e[t]), "" === n || n ? (i = parseFloat(o), !0 === n || f.isNumeric(i) ? i || 0 : o) : o
        }
    }), f.each(["height", "width"], function(e, t) {
        f.cssHooks[t] = {
            get: function(e, n, r) {
                return n ? Be.test(f.css(e, "display")) && 0 === e.offsetWidth ? f.swap(e, We, function() {
                    return Je(e, t, r)
                }) : Je(e, t, r) : void 0
            },
            set: function(e, n, r) {
                var i = r && je(e);
                return Ue(0, n, r ? Ve(e, t, r, c.boxSizing && "border-box" === f.css(e, "boxSizing", !1, i), i) : 0)
            }
        }
    }), c.opacity || (f.cssHooks.opacity = {
        get: function(e, t) {
            return Oe.test((t && e.currentStyle ? e.currentStyle.filter : e.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "" : t ? "1" : ""
        },
        set: function(e, t) {
            var n = e.style,
                r = e.currentStyle,
                i = f.isNumeric(t) ? "alpha(opacity=" + 100 * t + ")" : "",
                o = r && r.filter || n.filter || "";
            n.zoom = 1, (t >= 1 || "" === t) && "" === f.trim(o.replace(Fe, "")) && n.removeAttribute && (n.removeAttribute("filter"), "" === t || r && !r.filter) || (n.filter = Fe.test(o) ? o.replace(Fe, i) : o + " " + i)
        }
    }), f.cssHooks.marginRight = Me(c.reliableMarginRight, function(e, t) {
        return t ? f.swap(e, {
            display: "inline-block"
        }, Le, [e, "marginRight"]) : void 0
    }), f.each({
        margin: "",
        padding: "",
        border: "Width"
    }, function(e, t) {
        f.cssHooks[e + t] = {
            expand: function(n) {
                for (var r = 0, i = {}, o = "string" == typeof n ? n.split(" ") : [n]; 4 > r; r++) i[e + z[r] + t] = o[r] || o[r - 2] || o[0];
                return i
            }
        }, He.test(e) || (f.cssHooks[e + t].set = Ue)
    }), f.fn.extend({
        css: function(e, t) {
            return X(this, function(e, t, n) {
                var r, i, o = {},
                    a = 0;
                if (f.isArray(t)) {
                    for (r = je(e), i = t.length; i > a; a++) o[t[a]] = f.css(e, t[a], !1, r);
                    return o
                }
                return void 0 !== n ? f.style(e, t, n) : f.css(e, t)
            }, e, t, arguments.length > 1)
        },
        show: function() {
            return Xe(this, !0)
        },
        hide: function() {
            return Xe(this)
        },
        toggle: function(e) {
            return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function() {
                I(this) ? f(this).show() : f(this).hide()
            })
        }
    }), f.Tween = Ye, Ye.prototype = {
        constructor: Ye,
        init: function(e, t, n, r, i, o) {
            this.elem = e, this.prop = n, this.easing = i || "swing", this.options = t, this.start = this.now = this.cur(), this.end = r, this.unit = o || (f.cssNumber[n] ? "" : "px")
        },
        cur: function() {
            var e = Ye.propHooks[this.prop];
            return e && e.get ? e.get(this) : Ye.propHooks._default.get(this)
        },
        run: function(e) {
            var t, n = Ye.propHooks[this.prop];
            return this.options.duration ? this.pos = t = f.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : Ye.propHooks._default.set(this), this
        }
    }, Ye.prototype.init.prototype = Ye.prototype, Ye.propHooks = {
        _default: {
            get: function(e) {
                var t;
                return null == e.elem[e.prop] || e.elem.style && null != e.elem.style[e.prop] ? (t = f.css(e.elem, e.prop, "")) && "auto" !== t ? t : 0 : e.elem[e.prop]
            },
            set: function(e) {
                f.fx.step[e.prop] ? f.fx.step[e.prop](e) : e.elem.style && (null != e.elem.style[f.cssProps[e.prop]] || f.cssHooks[e.prop]) ? f.style(e.elem, e.prop, e.now + e.unit) : e.elem[e.prop] = e.now
            }
        }
    }, Ye.propHooks.scrollTop = Ye.propHooks.scrollLeft = {
        set: function(e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, f.easing = {
        linear: function(e) {
            return e
        },
        swing: function(e) {
            return .5 - Math.cos(e * Math.PI) / 2
        }
    }, f.fx = Ye.prototype.init, f.fx.step = {};
    var Ge, Qe, Ke, Ze, et, tt, nt, rt = /^(?:toggle|show|hide)$/,
        it = new RegExp("^(?:([+-])=|)(" + $ + ")([a-z%]*)$", "i"),
        ot = /queueHooks$/,
        at = [function(e, t, n) {
            var r, i, o, a, s, l, u, d = this,
                p = {},
                h = e.style,
                m = e.nodeType && I(e),
                g = f._data(e, "fxshow");
            for (r in n.queue || (null == (s = f._queueHooks(e, "fx")).unqueued && (s.unqueued = 0, l = s.empty.fire, s.empty.fire = function() {
                    s.unqueued || l()
                }), s.unqueued++, d.always(function() {
                    d.always(function() {
                        s.unqueued--, f.queue(e, "fx").length || s.empty.fire()
                    })
                })), 1 === e.nodeType && ("height" in t || "width" in t) && (n.overflow = [h.overflow, h.overflowX, h.overflowY], u = f.css(e, "display"), "inline" === ("none" === u ? f._data(e, "olddisplay") || De(e.nodeName) : u) && "none" === f.css(e, "float") && (c.inlineBlockNeedsLayout && "inline" !== De(e.nodeName) ? h.zoom = 1 : h.display = "inline-block")), n.overflow && (h.overflow = "hidden", c.shrinkWrapBlocks() || d.always(function() {
                    h.overflow = n.overflow[0], h.overflowX = n.overflow[1], h.overflowY = n.overflow[2]
                })), t)
                if (i = t[r], rt.exec(i)) {
                    if (delete t[r], o = o || "toggle" === i, i === (m ? "hide" : "show")) {
                        if ("show" !== i || !g || void 0 === g[r]) continue;
                        m = !0
                    }
                    p[r] = g && g[r] || f.style(e, r)
                } else u = void 0;
            if (f.isEmptyObject(p)) "inline" === ("none" === u ? De(e.nodeName) : u) && (h.display = u);
            else
                for (r in g ? "hidden" in g && (m = g.hidden) : g = f._data(e, "fxshow", {}), o && (g.hidden = !m), m ? f(e).show() : d.done(function() {
                        f(e).hide()
                    }), d.done(function() {
                        var t;
                        for (t in f._removeData(e, "fxshow"), p) f.style(e, t, p[t])
                    }), p) a = ct(m ? g[r] : 0, r, d), r in g || (g[r] = a.start, m && (a.end = a.start, a.start = "width" === r || "height" === r ? 1 : 0))
        }],
        st = {
            "*": [function(e, t) {
                var n = this.createTween(e, t),
                    r = n.cur(),
                    i = it.exec(t),
                    o = i && i[3] || (f.cssNumber[e] ? "" : "px"),
                    a = (f.cssNumber[e] || "px" !== o && +r) && it.exec(f.css(n.elem, e)),
                    s = 1,
                    l = 20;
                if (a && a[3] !== o) {
                    o = o || a[3], i = i || [], a = +r || 1;
                    do {
                        a /= s = s || ".5", f.style(n.elem, e, a + o)
                    } while (s !== (s = n.cur() / r) && 1 !== s && --l)
                }
                return i && (a = n.start = +a || +r || 0, n.unit = o, n.end = i[1] ? a + (i[1] + 1) * i[2] : +i[2]), n
            }]
        };

    function lt() {
        return setTimeout(function() {
            Ge = void 0
        }), Ge = f.now()
    }

    function ut(e, t) {
        var n, r = {
                height: e
            },
            i = 0;
        for (t = t ? 1 : 0; 4 > i; i += 2 - t) r["margin" + (n = z[i])] = r["padding" + n] = e;
        return t && (r.opacity = r.width = e), r
    }

    function ct(e, t, n) {
        for (var r, i = (st[t] || []).concat(st["*"]), o = 0, a = i.length; a > o; o++)
            if (r = i[o].call(n, t, e)) return r
    }

    function dt(e, t, n) {
        var r, i, o = 0,
            a = at.length,
            s = f.Deferred().always(function() {
                delete l.elem
            }),
            l = function() {
                if (i) return !1;
                for (var t = Ge || lt(), n = Math.max(0, u.startTime + u.duration - t), r = 1 - (n / u.duration || 0), o = 0, a = u.tweens.length; a > o; o++) u.tweens[o].run(r);
                return s.notifyWith(e, [u, r, n]), 1 > r && a ? n : (s.resolveWith(e, [u]), !1)
            },
            u = s.promise({
                elem: e,
                props: f.extend({}, t),
                opts: f.extend(!0, {
                    specialEasing: {}
                }, n),
                originalProperties: t,
                originalOptions: n,
                startTime: Ge || lt(),
                duration: n.duration,
                tweens: [],
                createTween: function(t, n) {
                    var r = f.Tween(e, u.opts, t, n, u.opts.specialEasing[t] || u.opts.easing);
                    return u.tweens.push(r), r
                },
                stop: function(t) {
                    var n = 0,
                        r = t ? u.tweens.length : 0;
                    if (i) return this;
                    for (i = !0; r > n; n++) u.tweens[n].run(1);
                    return t ? s.resolveWith(e, [u, t]) : s.rejectWith(e, [u, t]), this
                }
            }),
            c = u.props;
        for (function(e, t) {
                var n, r, i, o, a;
                for (n in e)
                    if (i = t[r = f.camelCase(n)], o = e[n], f.isArray(o) && (i = o[1], o = e[n] = o[0]), n !== r && (e[r] = o, delete e[n]), (a = f.cssHooks[r]) && "expand" in a)
                        for (n in o = a.expand(o), delete e[r], o) n in e || (e[n] = o[n], t[n] = i);
                    else t[r] = i
            }(c, u.opts.specialEasing); a > o; o++)
            if (r = at[o].call(u, e, c, u.opts)) return r;
        return f.map(c, ct, u), f.isFunction(u.opts.start) && u.opts.start.call(e, u), f.fx.timer(f.extend(l, {
            elem: e,
            anim: u,
            queue: u.opts.queue
        })), u.progress(u.opts.progress).done(u.opts.done, u.opts.complete).fail(u.opts.fail).always(u.opts.always)
    }
    f.Animation = f.extend(dt, {
        tweener: function(e, t) {
            f.isFunction(e) ? (t = e, e = ["*"]) : e = e.split(" ");
            for (var n, r = 0, i = e.length; i > r; r++) n = e[r], st[n] = st[n] || [], st[n].unshift(t)
        },
        prefilter: function(e, t) {
            t ? at.unshift(e) : at.push(e)
        }
    }), f.speed = function(e, t, n) {
        var r = e && "object" == typeof e ? f.extend({}, e) : {
            complete: n || !n && t || f.isFunction(e) && e,
            duration: e,
            easing: n && t || t && !f.isFunction(t) && t
        };
        return r.duration = f.fx.off ? 0 : "number" == typeof r.duration ? r.duration : r.duration in f.fx.speeds ? f.fx.speeds[r.duration] : f.fx.speeds._default, (null == r.queue || !0 === r.queue) && (r.queue = "fx"), r.old = r.complete, r.complete = function() {
            f.isFunction(r.old) && r.old.call(this), r.queue && f.dequeue(this, r.queue)
        }, r
    }, f.fn.extend({
        fadeTo: function(e, t, n, r) {
            return this.filter(I).css("opacity", 0).show().end().animate({
                opacity: t
            }, e, n, r)
        },
        animate: function(e, t, n, r) {
            var i = f.isEmptyObject(e),
                o = f.speed(t, n, r),
                a = function() {
                    var t = dt(this, f.extend({}, e), o);
                    (i || f._data(this, "finish")) && t.stop(!0)
                };
            return a.finish = a, i || !1 === o.queue ? this.each(a) : this.queue(o.queue, a)
        },
        stop: function(e, t, n) {
            var r = function(e) {
                var t = e.stop;
                delete e.stop, t(n)
            };
            return "string" != typeof e && (n = t, t = e, e = void 0), t && !1 !== e && this.queue(e || "fx", []), this.each(function() {
                var t = !0,
                    i = null != e && e + "queueHooks",
                    o = f.timers,
                    a = f._data(this);
                if (i) a[i] && a[i].stop && r(a[i]);
                else
                    for (i in a) a[i] && a[i].stop && ot.test(i) && r(a[i]);
                for (i = o.length; i--;) o[i].elem !== this || null != e && o[i].queue !== e || (o[i].anim.stop(n), t = !1, o.splice(i, 1));
                (t || !n) && f.dequeue(this, e)
            })
        },
        finish: function(e) {
            return !1 !== e && (e = e || "fx"), this.each(function() {
                var t, n = f._data(this),
                    r = n[e + "queue"],
                    i = n[e + "queueHooks"],
                    o = f.timers,
                    a = r ? r.length : 0;
                for (n.finish = !0, f.queue(this, e, []), i && i.stop && i.stop.call(this, !0), t = o.length; t--;) o[t].elem === this && o[t].queue === e && (o[t].anim.stop(!0), o.splice(t, 1));
                for (t = 0; a > t; t++) r[t] && r[t].finish && r[t].finish.call(this);
                delete n.finish
            })
        }
    }), f.each(["toggle", "show", "hide"], function(e, t) {
        var n = f.fn[t];
        f.fn[t] = function(e, r, i) {
            return null == e || "boolean" == typeof e ? n.apply(this, arguments) : this.animate(ut(t, !0), e, r, i)
        }
    }), f.each({
        slideDown: ut("show"),
        slideUp: ut("hide"),
        slideToggle: ut("toggle"),
        fadeIn: {
            opacity: "show"
        },
        fadeOut: {
            opacity: "hide"
        },
        fadeToggle: {
            opacity: "toggle"
        }
    }, function(e, t) {
        f.fn[e] = function(e, n, r) {
            return this.animate(t, e, n, r)
        }
    }), f.timers = [], f.fx.tick = function() {
        var e, t = f.timers,
            n = 0;
        for (Ge = f.now(); n < t.length; n++)(e = t[n])() || t[n] !== e || t.splice(n--, 1);
        t.length || f.fx.stop(), Ge = void 0
    }, f.fx.timer = function(e) {
        f.timers.push(e), e() ? f.fx.start() : f.timers.pop()
    }, f.fx.interval = 13, f.fx.start = function() {
        Qe || (Qe = setInterval(f.fx.tick, f.fx.interval))
    }, f.fx.stop = function() {
        clearInterval(Qe), Qe = null
    }, f.fx.speeds = {
        slow: 600,
        fast: 200,
        _default: 400
    }, f.fn.delay = function(e, t) {
        return e = f.fx && f.fx.speeds[e] || e, t = t || "fx", this.queue(t, function(t, n) {
            var r = setTimeout(t, e);
            n.stop = function() {
                clearTimeout(r)
            }
        })
    }, (Ze = N.createElement("div")).setAttribute("className", "t"), Ze.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", tt = Ze.getElementsByTagName("a")[0], nt = (et = N.createElement("select")).appendChild(N.createElement("option")), Ke = Ze.getElementsByTagName("input")[0], tt.style.cssText = "top:1px", c.getSetAttribute = "t" !== Ze.className, c.style = /top/.test(tt.getAttribute("style")), c.hrefNormalized = "/a" === tt.getAttribute("href"), c.checkOn = !!Ke.value, c.optSelected = nt.selected, c.enctype = !!N.createElement("form").enctype, et.disabled = !0, c.optDisabled = !nt.disabled, (Ke = N.createElement("input")).setAttribute("value", ""), c.input = "" === Ke.getAttribute("value"), Ke.value = "t", Ke.setAttribute("type", "radio"), c.radioValue = "t" === Ke.value;
    var ft = /\r/g;
    f.fn.extend({
        val: function(e) {
            var t, n, r, i = this[0];
            return arguments.length ? (r = f.isFunction(e), this.each(function(n) {
                var i;
                1 === this.nodeType && (null == (i = r ? e.call(this, n, f(this).val()) : e) ? i = "" : "number" == typeof i ? i += "" : f.isArray(i) && (i = f.map(i, function(e) {
                    return null == e ? "" : e + ""
                })), (t = f.valHooks[this.type] || f.valHooks[this.nodeName.toLowerCase()]) && "set" in t && void 0 !== t.set(this, i, "value") || (this.value = i))
            })) : i ? (t = f.valHooks[i.type] || f.valHooks[i.nodeName.toLowerCase()]) && "get" in t && void 0 !== (n = t.get(i, "value")) ? n : "string" == typeof(n = i.value) ? n.replace(ft, "") : null == n ? "" : n : void 0
        }
    }), f.extend({
        valHooks: {
            option: {
                get: function(e) {
                    var t = f.find.attr(e, "value");
                    return null != t ? t : f.trim(f.text(e))
                }
            },
            select: {
                get: function(e) {
                    for (var t, n, r = e.options, i = e.selectedIndex, o = "select-one" === e.type || 0 > i, a = o ? null : [], s = o ? i + 1 : r.length, l = 0 > i ? s : o ? i : 0; s > l; l++)
                        if (!(!(n = r[l]).selected && l !== i || (c.optDisabled ? n.disabled : null !== n.getAttribute("disabled")) || n.parentNode.disabled && f.nodeName(n.parentNode, "optgroup"))) {
                            if (t = f(n).val(), o) return t;
                            a.push(t)
                        } return a
                },
                set: function(e, t) {
                    for (var n, r, i = e.options, o = f.makeArray(t), a = i.length; a--;)
                        if (r = i[a], f.inArray(f.valHooks.option.get(r), o) >= 0) try {
                            r.selected = n = !0
                        } catch (e) {
                            r.scrollHeight
                        } else r.selected = !1;
                    return n || (e.selectedIndex = -1), i
                }
            }
        }
    }), f.each(["radio", "checkbox"], function() {
        f.valHooks[this] = {
            set: function(e, t) {
                return f.isArray(t) ? e.checked = f.inArray(f(e).val(), t) >= 0 : void 0
            }
        }, c.checkOn || (f.valHooks[this].get = function(e) {
            return null === e.getAttribute("value") ? "on" : e.value
        })
    });
    var pt, ht, mt = f.expr.attrHandle,
        gt = /^(?:checked|selected)$/i,
        vt = c.getSetAttribute,
        yt = c.input;
    f.fn.extend({
        attr: function(e, t) {
            return X(this, f.attr, e, t, arguments.length > 1)
        },
        removeAttr: function(e) {
            return this.each(function() {
                f.removeAttr(this, e)
            })
        }
    }), f.extend({
        attr: function(e, t, n) {
            var r, i, o = e.nodeType;
            if (e && 3 !== o && 8 !== o && 2 !== o) return typeof e.getAttribute === M ? f.prop(e, t, n) : (1 === o && f.isXMLDoc(e) || (t = t.toLowerCase(), r = f.attrHooks[t] || (f.expr.match.bool.test(t) ? ht : pt)), void 0 === n ? r && "get" in r && null !== (i = r.get(e, t)) ? i : null == (i = f.find.attr(e, t)) ? void 0 : i : null !== n ? r && "set" in r && void 0 !== (i = r.set(e, n, t)) ? i : (e.setAttribute(t, n + ""), n) : void f.removeAttr(e, t))
        },
        removeAttr: function(e, t) {
            var n, r, i = 0,
                o = t && t.match(j);
            if (o && 1 === e.nodeType)
                for (; n = o[i++];) r = f.propFix[n] || n, f.expr.match.bool.test(n) ? yt && vt || !gt.test(n) ? e[r] = !1 : e[f.camelCase("default-" + n)] = e[r] = !1 : f.attr(e, n, ""), e.removeAttribute(vt ? n : r)
        },
        attrHooks: {
            type: {
                set: function(e, t) {
                    if (!c.radioValue && "radio" === t && f.nodeName(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        }
    }), ht = {
        set: function(e, t, n) {
            return !1 === t ? f.removeAttr(e, n) : yt && vt || !gt.test(n) ? e.setAttribute(!vt && f.propFix[n] || n, n) : e[f.camelCase("default-" + n)] = e[n] = !0, n
        }
    }, f.each(f.expr.match.bool.source.match(/\w+/g), function(e, t) {
        var n = mt[t] || f.find.attr;
        mt[t] = yt && vt || !gt.test(t) ? function(e, t, r) {
            var i, o;
            return r || (o = mt[t], mt[t] = i, i = null != n(e, t, r) ? t.toLowerCase() : null, mt[t] = o), i
        } : function(e, t, n) {
            return n ? void 0 : e[f.camelCase("default-" + t)] ? t.toLowerCase() : null
        }
    }), yt && vt || (f.attrHooks.value = {
        set: function(e, t, n) {
            return f.nodeName(e, "input") ? void(e.defaultValue = t) : pt && pt.set(e, t, n)
        }
    }), vt || (pt = {
        set: function(e, t, n) {
            var r = e.getAttributeNode(n);
            return r || e.setAttributeNode(r = e.ownerDocument.createAttribute(n)), r.value = t += "", "value" === n || t === e.getAttribute(n) ? t : void 0
        }
    }, mt.id = mt.name = mt.coords = function(e, t, n) {
        var r;
        return n ? void 0 : (r = e.getAttributeNode(t)) && "" !== r.value ? r.value : null
    }, f.valHooks.button = {
        get: function(e, t) {
            var n = e.getAttributeNode(t);
            return n && n.specified ? n.value : void 0
        },
        set: pt.set
    }, f.attrHooks.contenteditable = {
        set: function(e, t, n) {
            pt.set(e, "" !== t && t, n)
        }
    }, f.each(["width", "height"], function(e, t) {
        f.attrHooks[t] = {
            set: function(e, n) {
                return "" === n ? (e.setAttribute(t, "auto"), n) : void 0
            }
        }
    })), c.style || (f.attrHooks.style = {
        get: function(e) {
            return e.style.cssText || void 0
        },
        set: function(e, t) {
            return e.style.cssText = t + ""
        }
    });
    var bt = /^(?:input|select|textarea|button|object)$/i,
        xt = /^(?:a|area)$/i;
    f.fn.extend({
        prop: function(e, t) {
            return X(this, f.prop, e, t, arguments.length > 1)
        },
        removeProp: function(e) {
            return e = f.propFix[e] || e, this.each(function() {
                try {
                    this[e] = void 0, delete this[e]
                } catch (e) {}
            })
        }
    }), f.extend({
        propFix: {
            for: "htmlFor",
            class: "className"
        },
        prop: function(e, t, n) {
            var r, i, o = e.nodeType;
            if (e && 3 !== o && 8 !== o && 2 !== o) return (1 !== o || !f.isXMLDoc(e)) && (t = f.propFix[t] || t, i = f.propHooks[t]), void 0 !== n ? i && "set" in i && void 0 !== (r = i.set(e, n, t)) ? r : e[t] = n : i && "get" in i && null !== (r = i.get(e, t)) ? r : e[t]
        },
        propHooks: {
            tabIndex: {
                get: function(e) {
                    var t = f.find.attr(e, "tabindex");
                    return t ? parseInt(t, 10) : bt.test(e.nodeName) || xt.test(e.nodeName) && e.href ? 0 : -1
                }
            }
        }
    }), c.hrefNormalized || f.each(["href", "src"], function(e, t) {
        f.propHooks[t] = {
            get: function(e) {
                return e.getAttribute(t, 4)
            }
        }
    }), c.optSelected || (f.propHooks.selected = {
        get: function(e) {
            var t = e.parentNode;
            return t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex), null
        }
    }), f.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() {
        f.propFix[this.toLowerCase()] = this
    }), c.enctype || (f.propFix.enctype = "encoding");
    var wt = /[\t\r\n\f]/g;
    f.fn.extend({
        addClass: function(e) {
            var t, n, r, i, o, a, s = 0,
                l = this.length,
                u = "string" == typeof e && e;
            if (f.isFunction(e)) return this.each(function(t) {
                f(this).addClass(e.call(this, t, this.className))
            });
            if (u)
                for (t = (e || "").match(j) || []; l > s; s++)
                    if (r = 1 === (n = this[s]).nodeType && (n.className ? (" " + n.className + " ").replace(wt, " ") : " ")) {
                        for (o = 0; i = t[o++];) r.indexOf(" " + i + " ") < 0 && (r += i + " ");
                        a = f.trim(r), n.className !== a && (n.className = a)
                    } return this
        },
        removeClass: function(e) {
            var t, n, r, i, o, a, s = 0,
                l = this.length,
                u = 0 === arguments.length || "string" == typeof e && e;
            if (f.isFunction(e)) return this.each(function(t) {
                f(this).removeClass(e.call(this, t, this.className))
            });
            if (u)
                for (t = (e || "").match(j) || []; l > s; s++)
                    if (r = 1 === (n = this[s]).nodeType && (n.className ? (" " + n.className + " ").replace(wt, " ") : "")) {
                        for (o = 0; i = t[o++];)
                            for (; r.indexOf(" " + i + " ") >= 0;) r = r.replace(" " + i + " ", " ");
                        a = e ? f.trim(r) : "", n.className !== a && (n.className = a)
                    } return this
        },
        toggleClass: function(e, t) {
            var n = typeof e;
            return "boolean" == typeof t && "string" === n ? t ? this.addClass(e) : this.removeClass(e) : this.each(f.isFunction(e) ? function(n) {
                f(this).toggleClass(e.call(this, n, this.className, t), t)
            } : function() {
                if ("string" === n)
                    for (var t, r = 0, i = f(this), o = e.match(j) || []; t = o[r++];) i.hasClass(t) ? i.removeClass(t) : i.addClass(t);
                else(n === M || "boolean" === n) && (this.className && f._data(this, "__className__", this.className), this.className = this.className || !1 === e ? "" : f._data(this, "__className__") || "")
            })
        },
        hasClass: function(e) {
            for (var t = " " + e + " ", n = 0, r = this.length; r > n; n++)
                if (1 === this[n].nodeType && (" " + this[n].className + " ").replace(wt, " ").indexOf(t) >= 0) return !0;
            return !1
        }
    }), f.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function(e, t) {
        f.fn[t] = function(e, n) {
            return arguments.length > 0 ? this.on(t, null, e, n) : this.trigger(t)
        }
    }), f.fn.extend({
        hover: function(e, t) {
            return this.mouseenter(e).mouseleave(t || e)
        },
        bind: function(e, t, n) {
            return this.on(e, null, t, n)
        },
        unbind: function(e, t) {
            return this.off(e, null, t)
        },
        delegate: function(e, t, n, r) {
            return this.on(t, e, n, r)
        },
        undelegate: function(e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        }
    });
    var Tt = f.now(),
        Ct = /\?/,
        Nt = /(,)|(\[|{)|(}|])|"(?:[^"\\\r\n]|\\["\\\/bfnrt]|\\u[\da-fA-F]{4})*"\s*:?|true|false|null|-?(?!0\d)\d+(?:\.\d+|)(?:[eE][+-]?\d+|)/g;
    f.parseJSON = function(t) {
        if (e.JSON && e.JSON.parse) return e.JSON.parse(t + "");
        var n, r = null,
            i = f.trim(t + "");
        return i && !f.trim(i.replace(Nt, function(e, t, i, o) {
            return n && t && (r = 0), 0 === r ? e : (n = i || t, r += !o - !i, "")
        })) ? Function("return " + i)() : f.error("Invalid JSON: " + t)
    }, f.parseXML = function(t) {
        var n, r;
        if (!t || "string" != typeof t) return null;
        try {
            e.DOMParser ? (r = new DOMParser, n = r.parseFromString(t, "text/xml")) : ((n = new ActiveXObject("Microsoft.XMLDOM")).async = "false", n.loadXML(t))
        } catch (e) {
            n = void 0
        }
        return n && n.documentElement && !n.getElementsByTagName("parsererror").length || f.error("Invalid XML: " + t), n
    };
    var Et, kt, St = /#.*$/,
        At = /([?&])_=[^&]*/,
        Dt = /^(.*?):[ \t]*([^\r\n]*)\r?$/gm,
        jt = /^(?:GET|HEAD)$/,
        Lt = /^\/\//,
        Ht = /^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/,
        qt = {},
        _t = {},
        Mt = "*/".concat("*");
    try {
        kt = location.href
    } catch (e) {
        (kt = N.createElement("a")).href = "", kt = kt.href
    }

    function Ft(e) {
        return function(t, n) {
            "string" != typeof t && (n = t, t = "*");
            var r, i = 0,
                o = t.toLowerCase().match(j) || [];
            if (f.isFunction(n))
                for (; r = o[i++];) "+" === r.charAt(0) ? (r = r.slice(1) || "*", (e[r] = e[r] || []).unshift(n)) : (e[r] = e[r] || []).push(n)
        }
    }

    function Ot(e, t, n, r) {
        var i = {},
            o = e === _t;

        function a(s) {
            var l;
            return i[s] = !0, f.each(e[s] || [], function(e, s) {
                var u = s(t, n, r);
                return "string" != typeof u || o || i[u] ? o ? !(l = u) : void 0 : (t.dataTypes.unshift(u), a(u), !1)
            }), l
        }
        return a(t.dataTypes[0]) || !i["*"] && a("*")
    }

    function Bt(e, t) {
        var n, r, i = f.ajaxSettings.flatOptions || {};
        for (r in t) void 0 !== t[r] && ((i[r] ? e : n || (n = {}))[r] = t[r]);
        return n && f.extend(!0, e, n), e
    }
    Et = Ht.exec(kt.toLowerCase()) || [], f.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: kt,
            type: "GET",
            isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(Et[1]),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": Mt,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {
                xml: /xml/,
                html: /html/,
                json: /json/
            },
            responseFields: {
                xml: "responseXML",
                text: "responseText",
                json: "responseJSON"
            },
            converters: {
                "* text": String,
                "text html": !0,
                "text json": f.parseJSON,
                "text xml": f.parseXML
            },
            flatOptions: {
                url: !0,
                context: !0
            }
        },
        ajaxSetup: function(e, t) {
            return t ? Bt(Bt(e, f.ajaxSettings), t) : Bt(f.ajaxSettings, e)
        },
        ajaxPrefilter: Ft(qt),
        ajaxTransport: Ft(_t),
        ajax: function(e, t) {
            "object" == typeof e && (t = e, e = void 0), t = t || {};
            var n, r, i, o, a, s, l, u, c = f.ajaxSetup({}, t),
                d = c.context || c,
                p = c.context && (d.nodeType || d.jquery) ? f(d) : f.event,
                h = f.Deferred(),
                m = f.Callbacks("once memory"),
                g = c.statusCode || {},
                v = {},
                y = {},
                b = 0,
                x = "canceled",
                w = {
                    readyState: 0,
                    getResponseHeader: function(e) {
                        var t;
                        if (2 === b) {
                            if (!u)
                                for (u = {}; t = Dt.exec(o);) u[t[1].toLowerCase()] = t[2];
                            t = u[e.toLowerCase()]
                        }
                        return null == t ? null : t
                    },
                    getAllResponseHeaders: function() {
                        return 2 === b ? o : null
                    },
                    setRequestHeader: function(e, t) {
                        var n = e.toLowerCase();
                        return b || (e = y[n] = y[n] || e, v[e] = t), this
                    },
                    overrideMimeType: function(e) {
                        return b || (c.mimeType = e), this
                    },
                    statusCode: function(e) {
                        var t;
                        if (e)
                            if (2 > b)
                                for (t in e) g[t] = [g[t], e[t]];
                            else w.always(e[w.status]);
                        return this
                    },
                    abort: function(e) {
                        var t = e || x;
                        return l && l.abort(t), T(0, t), this
                    }
                };
            if (h.promise(w).complete = m.add, w.success = w.done, w.error = w.fail, c.url = ((e || c.url || kt) + "").replace(St, "").replace(Lt, Et[1] + "//"), c.type = t.method || t.type || c.method || c.type, c.dataTypes = f.trim(c.dataType || "*").toLowerCase().match(j) || [""], null == c.crossDomain && (n = Ht.exec(c.url.toLowerCase()), c.crossDomain = !(!n || n[1] === Et[1] && n[2] === Et[2] && (n[3] || ("http:" === n[1] ? "80" : "443")) === (Et[3] || ("http:" === Et[1] ? "80" : "443")))), c.data && c.processData && "string" != typeof c.data && (c.data = f.param(c.data, c.traditional)), Ot(qt, c, t, w), 2 === b) return w;
            for (r in (s = f.event && c.global) && 0 == f.active++ && f.event.trigger("ajaxStart"), c.type = c.type.toUpperCase(), c.hasContent = !jt.test(c.type), i = c.url, c.hasContent || (c.data && (i = c.url += (Ct.test(i) ? "&" : "?") + c.data, delete c.data), !1 === c.cache && (c.url = At.test(i) ? i.replace(At, "$1_=" + Tt++) : i + (Ct.test(i) ? "&" : "?") + "_=" + Tt++)), c.ifModified && (f.lastModified[i] && w.setRequestHeader("If-Modified-Since", f.lastModified[i]), f.etag[i] && w.setRequestHeader("If-None-Match", f.etag[i])), (c.data && c.hasContent && !1 !== c.contentType || t.contentType) && w.setRequestHeader("Content-Type", c.contentType), w.setRequestHeader("Accept", c.dataTypes[0] && c.accepts[c.dataTypes[0]] ? c.accepts[c.dataTypes[0]] + ("*" !== c.dataTypes[0] ? ", " + Mt + "; q=0.01" : "") : c.accepts["*"]), c.headers) w.setRequestHeader(r, c.headers[r]);
            if (c.beforeSend && (!1 === c.beforeSend.call(d, w, c) || 2 === b)) return w.abort();
            for (r in x = "abort", {
                    success: 1,
                    error: 1,
                    complete: 1
                }) w[r](c[r]);
            if (l = Ot(_t, c, t, w)) {
                w.readyState = 1, s && p.trigger("ajaxSend", [w, c]), c.async && c.timeout > 0 && (a = setTimeout(function() {
                    w.abort("timeout")
                }, c.timeout));
                try {
                    b = 1, l.send(v, T)
                } catch (e) {
                    if (!(2 > b)) throw e;
                    T(-1, e)
                }
            } else T(-1, "No Transport");

            function T(e, t, n, r) {
                var u, v, y, x, T, C = t;
                2 !== b && (b = 2, a && clearTimeout(a), l = void 0, o = r || "", w.readyState = e > 0 ? 4 : 0, u = e >= 200 && 300 > e || 304 === e, n && (x = function(e, t, n) {
                    for (var r, i, o, a, s = e.contents, l = e.dataTypes;
                        "*" === l[0];) l.shift(), void 0 === i && (i = e.mimeType || t.getResponseHeader("Content-Type"));
                    if (i)
                        for (a in s)
                            if (s[a] && s[a].test(i)) {
                                l.unshift(a);
                                break
                            } if (l[0] in n) o = l[0];
                    else {
                        for (a in n) {
                            if (!l[0] || e.converters[a + " " + l[0]]) {
                                o = a;
                                break
                            }
                            r || (r = a)
                        }
                        o = o || r
                    }
                    return o ? (o !== l[0] && l.unshift(o), n[o]) : void 0
                }(c, w, n)), x = function(e, t, n, r) {
                    var i, o, a, s, l, u = {},
                        c = e.dataTypes.slice();
                    if (c[1])
                        for (a in e.converters) u[a.toLowerCase()] = e.converters[a];
                    for (o = c.shift(); o;)
                        if (e.responseFields[o] && (n[e.responseFields[o]] = t), !l && r && e.dataFilter && (t = e.dataFilter(t, e.dataType)), l = o, o = c.shift())
                            if ("*" === o) o = l;
                            else if ("*" !== l && l !== o) {
                        if (!(a = u[l + " " + o] || u["* " + o]))
                            for (i in u)
                                if ((s = i.split(" "))[1] === o && (a = u[l + " " + s[0]] || u["* " + s[0]])) {
                                    !0 === a ? a = u[i] : !0 !== u[i] && (o = s[0], c.unshift(s[1]));
                                    break
                                } if (!0 !== a)
                            if (a && e.throws) t = a(t);
                            else try {
                                t = a(t)
                            } catch (e) {
                                return {
                                    state: "parsererror",
                                    error: a ? e : "No conversion from " + l + " to " + o
                                }
                            }
                    }
                    return {
                        state: "success",
                        data: t
                    }
                }(c, x, w, u), u ? (c.ifModified && ((T = w.getResponseHeader("Last-Modified")) && (f.lastModified[i] = T), (T = w.getResponseHeader("etag")) && (f.etag[i] = T)), 204 === e || "HEAD" === c.type ? C = "nocontent" : 304 === e ? C = "notmodified" : (C = x.state, v = x.data, u = !(y = x.error))) : (y = C, (e || !C) && (C = "error", 0 > e && (e = 0))), w.status = e, w.statusText = (t || C) + "", u ? h.resolveWith(d, [v, C, w]) : h.rejectWith(d, [w, C, y]), w.statusCode(g), g = void 0, s && p.trigger(u ? "ajaxSuccess" : "ajaxError", [w, c, u ? v : y]), m.fireWith(d, [w, C]), s && (p.trigger("ajaxComplete", [w, c]), --f.active || f.event.trigger("ajaxStop")))
            }
            return w
        },
        getJSON: function(e, t, n) {
            return f.get(e, t, n, "json")
        },
        getScript: function(e, t) {
            return f.get(e, void 0, t, "script")
        }
    }), f.each(["get", "post"], function(e, t) {
        f[t] = function(e, n, r, i) {
            return f.isFunction(n) && (i = i || r, r = n, n = void 0), f.ajax({
                url: e,
                type: t,
                dataType: i,
                data: n,
                success: r
            })
        }
    }), f._evalUrl = function(e) {
        return f.ajax({
            url: e,
            type: "GET",
            dataType: "script",
            async: !1,
            global: !1,
            throws: !0
        })
    }, f.fn.extend({
        wrapAll: function(e) {
            if (f.isFunction(e)) return this.each(function(t) {
                f(this).wrapAll(e.call(this, t))
            });
            if (this[0]) {
                var t = f(e, this[0].ownerDocument).eq(0).clone(!0);
                this[0].parentNode && t.insertBefore(this[0]), t.map(function() {
                    for (var e = this; e.firstChild && 1 === e.firstChild.nodeType;) e = e.firstChild;
                    return e
                }).append(this)
            }
            return this
        },
        wrapInner: function(e) {
            return this.each(f.isFunction(e) ? function(t) {
                f(this).wrapInner(e.call(this, t))
            } : function() {
                var t = f(this),
                    n = t.contents();
                n.length ? n.wrapAll(e) : t.append(e)
            })
        },
        wrap: function(e) {
            var t = f.isFunction(e);
            return this.each(function(n) {
                f(this).wrapAll(t ? e.call(this, n) : e)
            })
        },
        unwrap: function() {
            return this.parent().each(function() {
                f.nodeName(this, "body") || f(this).replaceWith(this.childNodes)
            }).end()
        }
    }), f.expr.filters.hidden = function(e) {
        return e.offsetWidth <= 0 && e.offsetHeight <= 0 || !c.reliableHiddenOffsets() && "none" === (e.style && e.style.display || f.css(e, "display"))
    }, f.expr.filters.visible = function(e) {
        return !f.expr.filters.hidden(e)
    };
    var Pt = /%20/g,
        Rt = /\[\]$/,
        Wt = /\r?\n/g,
        $t = /^(?:submit|button|image|reset|file)$/i,
        zt = /^(?:input|select|textarea|keygen)/i;

    function It(e, t, n, r) {
        var i;
        if (f.isArray(t)) f.each(t, function(t, i) {
            n || Rt.test(e) ? r(e, i) : It(e + "[" + ("object" == typeof i ? t : "") + "]", i, n, r)
        });
        else if (n || "object" !== f.type(t)) r(e, t);
        else
            for (i in t) It(e + "[" + i + "]", t[i], n, r)
    }
    f.param = function(e, t) {
        var n, r = [],
            i = function(e, t) {
                t = f.isFunction(t) ? t() : null == t ? "" : t, r[r.length] = encodeURIComponent(e) + "=" + encodeURIComponent(t)
            };
        if (void 0 === t && (t = f.ajaxSettings && f.ajaxSettings.traditional), f.isArray(e) || e.jquery && !f.isPlainObject(e)) f.each(e, function() {
            i(this.name, this.value)
        });
        else
            for (n in e) It(n, e[n], t, i);
        return r.join("&").replace(Pt, "+")
    }, f.fn.extend({
        serialize: function() {
            return f.param(this.serializeArray())
        },
        serializeArray: function() {
            return this.map(function() {
                var e = f.prop(this, "elements");
                return e ? f.makeArray(e) : this
            }).filter(function() {
                var e = this.type;
                return this.name && !f(this).is(":disabled") && zt.test(this.nodeName) && !$t.test(e) && (this.checked || !U.test(e))
            }).map(function(e, t) {
                var n = f(this).val();
                return null == n ? null : f.isArray(n) ? f.map(n, function(e) {
                    return {
                        name: t.name,
                        value: e.replace(Wt, "\r\n")
                    }
                }) : {
                    name: t.name,
                    value: n.replace(Wt, "\r\n")
                }
            }).get()
        }
    }), f.ajaxSettings.xhr = void 0 !== e.ActiveXObject ? function() {
        return !this.isLocal && /^(get|post|head|put|delete|options)$/i.test(this.type) && Jt() || function() {
            try {
                return new e.ActiveXObject("Microsoft.XMLHTTP")
            } catch (e) {}
        }()
    } : Jt;
    var Xt = 0,
        Ut = {},
        Vt = f.ajaxSettings.xhr();

    function Jt() {
        try {
            return new e.XMLHttpRequest
        } catch (e) {}
    }
    e.attachEvent && e.attachEvent("onunload", function() {
        for (var e in Ut) Ut[e](void 0, !0)
    }), c.cors = !!Vt && "withCredentials" in Vt, (Vt = c.ajax = !!Vt) && f.ajaxTransport(function(e) {
        var t;

    }), f.ajaxSetup({
        accepts: {
            script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
        },
        contents: {
            script: /(?:java|ecma)script/
        },
        converters: {
            "text script": function(e) {
                return f.globalEval(e), e
            }
        }
    }), f.ajaxPrefilter("script", function(e) {
        void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET", e.global = !1)
    }), f.ajaxTransport("script", function(e) {
        if (e.crossDomain) {
            var t, n = N.head || f("head")[0] || N.documentElement;
            return {
                send: function(r, i) {
                    (t = N.createElement("script")).async = !0, e.scriptCharset && (t.charset = e.scriptCharset), t.src = e.url, t.onload = t.onreadystatechange = function(e, n) {
                        (n || !t.readyState || /loaded|complete/.test(t.readyState)) && (t.onload = t.onreadystatechange = null, t.parentNode && t.parentNode.removeChild(t), t = null, n || i(200, "success"))
                    }, n.insertBefore(t, n.firstChild)
                },
                abort: function() {
                    t && t.onload(void 0, !0)
                }
            }
        }
    });
    var Yt = [],
        Gt = /(=)\?(?=&|$)|\?\?/;
    f.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function() {
            var e = Yt.pop() || f.expando + "_" + Tt++;
            return this[e] = !0, e
        }
    }), f.ajaxPrefilter("json jsonp", function(t, n, r) {
        var i, o, a, s = !1 !== t.jsonp && (Gt.test(t.url) ? "url" : "string" == typeof t.data && !(t.contentType || "").indexOf("application/x-www-form-urlencoded") && Gt.test(t.data) && "data");
        return s || "jsonp" === t.dataTypes[0] ? (i = t.jsonpCallback = f.isFunction(t.jsonpCallback) ? t.jsonpCallback() : t.jsonpCallback, s ? t[s] = t[s].replace(Gt, "$1" + i) : !1 !== t.jsonp && (t.url += (Ct.test(t.url) ? "&" : "?") + t.jsonp + "=" + i), t.converters["script json"] = function() {
            return a || f.error(i + " was not called"), a[0]
        }, t.dataTypes[0] = "json", o = e[i], e[i] = function() {
            a = arguments
        }, r.always(function() {
            e[i] = o, t[i] && (t.jsonpCallback = n.jsonpCallback, Yt.push(i)), a && f.isFunction(o) && o(a[0]), a = o = void 0
        }), "script") : void 0
    }), f.parseHTML = function(e, t, n) {
        if (!e || "string" != typeof e) return null;
        "boolean" == typeof t && (n = t, t = !1), t = t || N;
        var r = x.exec(e),
            i = !n && [];
        return r ? [t.createElement(r[1])] : (r = f.buildFragment([e], t, i), i && i.length && f(i).remove(), f.merge([], r.childNodes))
    };
    var Qt = f.fn.load;
    f.fn.load = function(e, t, n) {
        if ("string" != typeof e && Qt) return Qt.apply(this, arguments);
        var r, i, o, a = this,
            s = e.indexOf(" ");
        return s >= 0 && (r = f.trim(e.slice(s, e.length)), e = e.slice(0, s)), f.isFunction(t) ? (n = t, t = void 0) : t && "object" == typeof t && (o = "POST"), a.length > 0 && f.ajax({
            url: e,
            type: o,
            dataType: "html",
            data: t
        }).done(function(e) {
            i = arguments, a.html(r ? f("<div>").append(f.parseHTML(e)).find(r) : e)
        }).complete(n && function(e, t) {
            a.each(n, i || [e.responseText, t, e])
        }), this
    }, f.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(e, t) {
        f.fn[t] = function(e) {
            return this.on(t, e)
        }
    }), f.expr.filters.animated = function(e) {
        return f.grep(f.timers, function(t) {
            return e === t.elem
        }).length
    };
    var Kt = e.document.documentElement;

    function Zt(e) {
        return f.isWindow(e) ? e : 9 === e.nodeType && (e.defaultView || e.parentWindow)
    }
    f.offset = {
        setOffset: function(e, t, n) {
            var r, i, o, a, s, l, u = f.css(e, "position"),
                c = f(e),
                d = {};
            "static" === u && (e.style.position = "relative"), s = c.offset(), o = f.css(e, "top"), l = f.css(e, "left"), ("absolute" === u || "fixed" === u) && f.inArray("auto", [o, l]) > -1 ? (a = (r = c.position()).top, i = r.left) : (a = parseFloat(o) || 0, i = parseFloat(l) || 0), f.isFunction(t) && (t = t.call(e, n, s)), null != t.top && (d.top = t.top - s.top + a), null != t.left && (d.left = t.left - s.left + i), "using" in t ? t.using.call(e, d) : c.css(d)
        }
    }, f.fn.extend({
        offset: function(e) {
            if (arguments.length) return void 0 === e ? this : this.each(function(t) {
                f.offset.setOffset(this, e, t)
            });
            var t, n, r = {
                    top: 0,
                    left: 0
                },
                i = this[0],
                o = i && i.ownerDocument;
            return o ? (t = o.documentElement, f.contains(t, i) ? (typeof i.getBoundingClientRect !== M && (r = i.getBoundingClientRect()), n = Zt(o), {
                top: r.top + (n.pageYOffset || t.scrollTop) - (t.clientTop || 0),
                left: r.left + (n.pageXOffset || t.scrollLeft) - (t.clientLeft || 0)
            }) : r) : void 0
        },
        position: function() {
            if (this[0]) {
                var e, t, n = {
                        top: 0,
                        left: 0
                    },
                    r = this[0];
                return "fixed" === f.css(r, "position") ? t = r.getBoundingClientRect() : (e = this.offsetParent(), t = this.offset(), f.nodeName(e[0], "html") || (n = e.offset()), n.top += f.css(e[0], "borderTopWidth", !0), n.left += f.css(e[0], "borderLeftWidth", !0)), {
                    top: t.top - n.top - f.css(r, "marginTop", !0),
                    left: t.left - n.left - f.css(r, "marginLeft", !0)
                }
            }
        },
        offsetParent: function() {
            return this.map(function() {
                for (var e = this.offsetParent || Kt; e && !f.nodeName(e, "html") && "static" === f.css(e, "position");) e = e.offsetParent;
                return e || Kt
            })
        }
    }), f.each({
        scrollLeft: "pageXOffset",
        scrollTop: "pageYOffset"
    }, function(e, t) {
        var n = /Y/.test(t);
        f.fn[e] = function(r) {
            return X(this, function(e, r, i) {
                var o = Zt(e);
                return void 0 === i ? o ? t in o ? o[t] : o.document.documentElement[r] : e[r] : void(o ? o.scrollTo(n ? f(o).scrollLeft() : i, n ? i : f(o).scrollTop()) : e[r] = i)
            }, e, r, arguments.length, null)
        }
    }), f.each(["top", "left"], function(e, t) {
        f.cssHooks[t] = Me(c.pixelPosition, function(e, n) {
            return n ? (n = Le(e, t), qe.test(n) ? f(e).position()[t] + "px" : n) : void 0
        })
    }), f.each({
        Height: "height",
        Width: "width"
    }, function(e, t) {
        f.each({
            padding: "inner" + e,
            content: t,
            "": "outer" + e
        }, function(n, r) {
            f.fn[r] = function(r, i) {
                var o = arguments.length && (n || "boolean" != typeof r),
                    a = n || (!0 === r || !0 === i ? "margin" : "border");
                return X(this, function(t, n, r) {
                    var i;
                    return f.isWindow(t) ? t.document.documentElement["client" + e] : 9 === t.nodeType ? (i = t.documentElement, Math.max(t.body["scroll" + e], i["scroll" + e], t.body["offset" + e], i["offset" + e], i["client" + e])) : void 0 === r ? f.css(t, n, a) : f.style(t, n, r, a)
                }, t, o ? r : void 0, o, null)
            }
        })
    }), f.fn.size = function() {
        return this.length
    }, f.fn.andSelf = f.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function() {
        return f
    });
    var en = e.jQuery,
        tn = e.$;
    return f.noConflict = function(t) {
        return e.$ === f && (e.$ = tn), t && e.jQuery === f && (e.jQuery = en), f
    }, typeof t === M && (e.jQuery = e.$ = f), f
});
var sharewindow, bLazy;

function androidAppShowDialog() {
    if ("undefined" != typeof Storage)
        if (null == localStorage.getItem("androidAppDontAskAnymoreV2")) $("#installAndroidApp").show();
        else {
            var e = Date.parse(localStorage.getItem("androidAppDontAskAnymoreDate"));
            new Date - e > 2592e6 && $("#installAndroidApp").show()
        }
}

function androidAppInstall() {
    ga("send", "event", "AndroidApp", "Install"), androidAppDontAskAnymore(), document.location.href = "https://play.google.com/store/apps/details?id=com.adriamedia.espreso"
}

function androidAppCancel() {
    ga("send", "event", "AndroidApp", "Cancel"), androidAppDontAskAnymore()
}

function androidAppLocalStorageReset() {
    localStorage.removeItem("androidAppDontAskAnymoreV2"), localStorage.removeItem("androidAppDontAskAnymoreDate")
}

function androidAppDontAskAnymore() {
    if ($("#installAndroidApp").hide(), "undefined" != typeof Storage) {
        localStorage.setItem("androidAppDontAskAnymoreV2", !0);
        var e = new Date;
        localStorage.setItem("androidAppDontAskAnymoreDate", e)
    }
}

$(function() {
    $(".hMenu").click(function() {
        return $("html").toggleClass("locked"), !1
    }), $(".mClose").click(function() {
        return $("html").removeClass("locked"), !1
    }), $("#sideMenuBlock").bind("touchend", function() {
        setTimeout(function() {
            $("html").removeClass("locked")
        }, 10), setTimeout(function() {
            $("#sideMenu ul").scrollTop(0)
        }, 400)
    }), androidCheckVersion() && androidAppShowDialog(), setTimeout(function() {
        $(".ticker").scrollForever()
    }, 1e3), bLazy = new Blazy({
        offset: 300
    }), window.onresize = function(e) {
        bLazy.revalidate()
    }, $(".articleNav").each(function() {
        var e = $(this);
        id = $(this).attr("data-id"), cid = $(this).attr("data-cid"), $.ajax({
            method: "GET",
            dataType: "json",
            url: "/ajax/get-next-article",
            data: {
                id: id,
                cid: cid
            }
        }).done(function(t) {
            if ("ok" == t.message) {
                var a = e.find(".articleNavLinkPrev"),
                    i = e.find(".articleNavLinkNext");
                t.prev_href ? a.attr("href", t.prev_href) : a.hide(), t.next_href ? i.attr("href", t.next_href) : i.hide()
            } else e.hide()
        }).fail(function(t) {
            e.hide()
        })
    }), $(".shareWrap").each(function() {
        var e = $(this),
            t = encodeURIComponent(e.data("url")),
            a = encodeURIComponent(e.data("image")),
            i = encodeURIComponent(e.data("title")),
            o = (encodeURIComponent(e.data("summary")), encodeURIComponent(e.data("fb-app-id")));
        encodeURIComponent(e.data("fb-page-id"));
        $(e).find("li").each(function() {
            var e = "",
                n = $(this);
            n.hasClass("tw") ? e = "http://twitter.com/share?url=" + t + "&via=espresors&text=" + i : n.hasClass("gp") ? e = "https://plus.google.com/share?url=" + t : n.hasClass("ins") ? e = "http://instagram.com/connoisseurs.me" : n.hasClass("pi") ? e = "http://www.pinterest.com/pin/create/button/?url=" + t + "&media=" + a + "&description=" + i : n.hasClass("fb") && (e = "https://www.facebook.com/dialog/share?app_id=" + o + "&display=popup&href=" + t), n.find("a").click(function() {
                if ("" != e) return null != sharewindow && sharewindow.close(), sharewindow = window.open(e, "Podeli", "width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0"), window.focus && sharewindow.focus(), !1
            })
        })
    }), $(".top-content-boxes").each(function(e, t) {
        var a = "slide" + e;
        this.id = a, $(this).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: !1,
            mobileFirst: !0,
            asNavFor: ".topContentNav",
            responsive: [{
                breakpoint: 600,
                settings: "unslick"
            }]
        }), $(this).on("afterChange", function(e, t, a, i) {
            bLazy.revalidate()
        }), $(window).resize(function() {
            $(window).width() <= 600 && $(".top-content-boxes").slick("resize")
        })
    }), $(".topContentNav").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        swipe: !1,
        arrows: !1,
        variableWidth: !0,
        asNavFor: ".top-content-boxes",
        centerMode: !0,
        focusOnSelect: !0
    }), $("#menu li.on").addClass("subActive"), $(".subTrigger").on("click", function() {
        $(this).parent().toggleClass("subActive")
    })
});
var $mediaSlider, $mediaThumb, lastScrollTop = 0,
    delta = 10,
    navbarHeight = $("#menuWrap").outerHeight();

function hasScrolled() {
    var e = $(this).scrollTop();
    Math.abs(lastScrollTop - e) <= delta || (e > lastScrollTop && e > navbarHeight ? $("#menuWrap").removeClass("nav-down").addClass("nav-up") : e + $(window).height() < $(document).height() && $("#menuWrap").removeClass("nav-up").addClass("nav-down"), lastScrollTop = e)
}

function slideToSlide(e) {
    try {
        $mediaSlider.slick("slickGoTo", e - 1, !0), $mediaThumb.slick("slickGoTo", e - 1, !0)
    } catch (e) {
        return void setTimeout(slideToSlide, 100)
    }
}

function setMediaDescription(e) {
    $("#mediaDescription").html(nl2br(e.attr("alt"))), $("#mediaPhotographer").html(e.attr("data-photographer"))
}

function androidCheckVersion() {
    var e = navigator.userAgent.toLowerCase().match(/android\s([0-9\.]*)/),
        t = !!e && e[1];
    return !1 !== t && (t = (t = t.split("."))[0] > 4 || 4 == t[0] && null != t[1] && t[1] >= 1), t
}

function searchHeaderBtn() {
    $("#searchSend").submit()
}

function searchHeader() {
    return $("#searchString_header").val().length > 2 || (alert("Termin za pretragu mora imati minimalno tri karaktera."), !1)
}

function searchForm() {
    return $("#searchText").val().length > 2 || (alert("Termin za pretragu mora imati minimalno tri karaktera."), !1)
}

function sideBoxTabs() {
    $(".sideBox.tabs").each(function() {
        container = $(this), container.find(".tab-control .tab-button").first().addClass("active").addClass("unveiled"), container.find(".tab").first().addClass("active"), container.find(".tab-control .tab-button").click(function(e) {
            e.preventDefault();
            var t = $(this).attr("data-tab");
            container.find(".tab-control .tab-button").removeClass("active"), container.find(".tab").removeClass("active"), $(this).addClass("active"), $("#" + t).addClass("active"), $(this).hasClass("unveiled") || ($(this).addClass("unveiled"), bLazy.revalidate())
        })
    })
}
$(window).on("scroll", function(e) {
    didScroll = !0
}), setInterval(function() {

}, 250), $(function() {
    "undefined" != typeof first_match_id && setMatch(first_match_id), $mediaSlider = $(".mediaSlider ul"), $mediaThumb = $(".mediaThumb ul"), setMediaDescription($(".mediaSlider .mslide:first img")), $mediaSlider.show(), $mediaSlider.slick({
        lazyLoad: "ondemand",
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: !0,
        nextArrow: ".navR",
        prevArrow: ".navL",
        asNavFor: ".mediaThumb ul",
        fade: !0,
        responsive: [{
            breakpoint: 600,
            settings: {
                fade: !1
            }
        }]
    }), $mediaSlider.on("afterChange", function(e, t, a) {
        el = $(t.$slides[a]).find("img"), setMediaDescription(el);
        var i = window.location.pathname,
            o = /\/media\/(\d+)\/(\d+)/;
        if (i.match(o) && (i = i.replace(o, "/media/$1")), 1 != ++a && (i += "/" + a), window.location.pathname != i && window.history && window.history.replaceState) {
            var n = $(document).prop("title"),
                l = $('meta[name="Description"]').attr("content");
            o = /\| Slika (\d+) \|/, n = n.replace(o, " Slika " + a + " |"), l = l.replace(o, "| Slika " + a + " |"), window.history.replaceState({}, n, i), $(document).prop("title", n), $('meta[name="Description"]').attr("content", l), ga("send", "pageview", i), pp_gemius_hit(pp_gemius_identifier)
        }
    }), $mediaThumb.slick({
        lazyLoad: "progressive",
        arrows: !1,
        slidesToShow: 10,
        centerMode: !1,
        focusOnSelect: !0,
        swipeToSlide: !1,
        asNavFor: ".mediaSlider ul",
        responsive: [{
            breakpoint: 800,
            settings: {
                slidesToShow: 6
            }
        }]
    });
    var e = 1 * $(".mediaView").attr("data-mslide");
    0 != e && slideToSlide(e), $mediaSlider.on("beforeChange", function(e, t, a, i) {
        var o = i;
        $(".slider-nav-thumbnails .slick-slide").removeClass("slick-active"), $(".slider-nav-thumbnails .slick-slide").eq(o).addClass("slick-active")
    })
}), sideBoxTabs();
var get_tpl_i = 0;

function get_tpl(e) {
    data = {
        id: get_tpl_i,
        type: $(e).attr("data-type"),
        class: $(e).attr("data-class"),
        wrap_class: $(e).attr("data-wrap-class"),
        title: $(e).attr("data-title"),
        content: $(e).attr("data-content"),
        content_id: $(e).attr("data-content-id"),
        content_limit: $(e).attr("data-content-limit")
    }, $(e).attr("id", "get-tpl-" + get_tpl_i);
    var t = "GET";
    void 0 !== $(e).attr("data-method") && (t = $(e).attr("data-method"));
    var a = !1;
    void 0 !== $(e).attr("data-callback") && (a = $(e).attr("data-callback")), $.ajax({
        method: t,
        dataType: "json",
        url: "/ajax/get-tpl",
        data: data
    }).done(function(e) {
        if ("ok" == e.message) {
            for (i in e.templates) $("#get-tpl-" + i).replaceWithPush(e.templates[i]);
            a && window[a](), bLazy.revalidate()
        }
    }).fail(function(e) {}), get_tpl_i++
}

function removeElement(e) {
    $(e).fadeOut("fast").remove()
}

function nl2br(e, t) {
    return (e + "").replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, "$1" + (t || void 0 === t ? "<br />" : "<br>") + "$2")
}

function toTop() {
    $("html, body").animate({
        scrollTop: 0
    }, 2e3)
}
$(function() {
    $(".get-tpl").each(function() {
        get_tpl(this)
    })
}), $.fn.replaceWithPush = function(e) {
    var t = $(e);
    return this.replaceWith(t), t
};
var $window = $(window);

function equalHeight(e) {
    tallest = 0, e.each(function() {
        thisHeight = $(this).height(), thisHeight > tallest && (tallest = thisHeight)
    }), e.height(tallest)
}

function trim(e) {
    return e.replace(/^\s+|\s+$/g, "")
}

function isEmail(e) {
    return /^[-_.a-z0-9]+@(([-_a-z0-9]+\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|rs|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i.test(e)
}

function loadAntibot(e) {
    $.ajax({
        type: "POST",
        url: "/resources/templates/common/ajax_antibot.php",
        data: {
            holder: e
        },
        success: function(t) {
            null != t && "" != t && $("#" + e).html(t)
        }
    })
}

function poll_init(e) {
    poll = $("#poll_" + e), poll.find(".poll_saving").hide(), "1" == poll.attr("data-voted") ? (poll.find(".poll_answers").remove(), poll.find(".poll_button_show_votes").remove()) : poll.find(".poll_results").hide(), poll.find(".poll_msg_thanks").hide(), poll.show()
}

function poll_check_votes(e) {
    poll = $("#poll_" + e), answers_no = poll.attr("data-answers-no"), poll.find(".poll_answers input:checkbox").attr("disabled", !1), i = 0, poll.find(".poll_answers input:checkbox:checked").each(function() {
        i++
    }), poll.find(".answers_no_left").html(answers_no - i), answers_no == i ? (poll.find(".poll_button_vote").attr("disabled", !1), poll.find(".poll_answers input:checkbox:not(:checked)").each(function() {
        $(this).attr("disabled", "disabled")
    })) : poll.find(".poll_button_vote").attr("disabled", "disabled")
}

function poll_vote(e) {
    poll = $("#poll_" + e);
    var t = new Array;
    i = 0, poll.find(".poll_answers input:checkbox:checked").each(function() {
        t[i] = $(this).val(), i++
    }), poll.find(".poll_saving").show(), $.ajax({
        type: "POST",
        url: "/ajax/poll/save",
        data: {
            poll_id: poll.attr("data-id"),
            poll_type: poll.attr("data-type"),
            answers: t
        },
        dataType: "json",
        success: function(t) {
            poll.find(".poll_saving").hide(), "ok" == t.message && (poll.replaceWith(t.html), poll_init(e), poll.find(".poll_msg_thanks").show())
        },
        error: function() {
            poll.find(".poll_saving").hide()
        }
    })
}

function poll_show_results(e) {
    poll = $("#poll_" + e), poll.find(".poll_answers").hide(), poll.find(".poll_results").show()
}

function poll_show_answers(e) {
    poll = $("#poll_" + e), poll.find(".poll_answers").show(), poll.find(".poll_results").hide()
}

function getImagesFromLive() {
    $("img").each(function() {
        "/data/images/" == $(this).attr("src").substring(13, 0) && $(this).attr("src", "http://zena.blic.rs" + $(this).attr("src"))
    })
}
$window.bind("resize", function() {
    $window.width() < 800 || $window.scrollTop() < 88 ? $("html").removeClass("stick") : $("html").addClass("stick")
}), jQuery.cookie = function(e, t, a) {
    if (void 0 === t) {
        var i = null;
        if (document.cookie && "" != document.cookie)
            for (var o = document.cookie.split(";"), n = 0; n < o.length; n++) {
                var l = jQuery.trim(o[n]);
                if (l.substring(0, e.length + 1) == e + "=") {
                    i = decodeURIComponent(l.substring(e.length + 1));
                    break
                }
            }
        return i
    }
    a = a || {}, null === t && (t = "", a.expires = -1);
    var r, s = "";
    a.expires && ("number" == typeof a.expires || a.expires.toUTCString) && ("number" == typeof a.expires ? (r = new Date).setTime(r.getTime() + 24 * a.expires * 60 * 60 * 1e3) : r = a.expires, s = "; expires=" + r.toUTCString());
    var d = a.path ? "; path=" + a.path : "",
        c = a.domain ? "; domain=" + a.domain : "",
        p = a.secure ? "; secure" : "";
    document.cookie = [e, "=", encodeURIComponent(t), s, d, c, p].join("")
}, jQuery.expr[":"].regex = function(e, t, a) {
    var i = a[3].split(","),
        o = /^(data|css):/,
        n = {
            method: i[0].match(o) ? i[0].split(":")[0] : "attr",
            property: i.shift().replace(o, "")
        };
    return new RegExp(i.join("").replace(/^\s+|\s+$/g, ""), "ig").test(jQuery(e)[n.method](n.property))
}, jQuery.fn.tabify = function(e) {
    return this.each(function() {
        var e = jQuery(this),
            t = this.id;
        e.find("a:regex(href,^#.)").each(function(a, i) {
            var o = jQuery(this);
            jQuery.cookie(t) ? jQuery(i).attr("href") == $.cookie(t) ? o.addClass("current") : jQuery(o.attr("href")).hide() : a ? jQuery(o.attr("href")).hide() : o.addClass("current"), o.click(function() {
                return id = jQuery(this).attr("href"), $.cookie(t, id), jQuery(e.find("a.current").removeClass("current").attr("href")).hide(), jQuery(o.addClass("current").attr("href")).show(), !1
            })
        })
    })
};
! function(t, n) {
    "function" == typeof define && define.amd ? define(["jquery"], function(e) {
        return n(t, e)
    }) : "object" == typeof exports ? n(t, require("jquery")) : n(t, t.jQuery || t.Zepto)
}(this, function(t, n) {
    "use strict";
    var e, a, i, o = "remodal",
        s = t.REMODAL_GLOBALS && t.REMODAL_GLOBALS.NAMESPACE || o,
        r = n.map(["animationstart", "webkitAnimationStart", "MSAnimationStart", "oAnimationStart"], function(t) {
            return t + "." + s
        }).join(" "),
        d = n.map(["animationend", "webkitAnimationEnd", "MSAnimationEnd", "oAnimationEnd"], function(t) {
            return t + "." + s
        }).join(" "),
        c = n.extend({
            hashTracking: !0,
            closeOnConfirm: !0,
            closeOnCancel: !0,
            closeOnEscape: !0,
            closeOnOutsideClick: !0,
            modifier: "",
            appendTo: null
        }, t.REMODAL_GLOBALS && t.REMODAL_GLOBALS.DEFAULTS),
        l = {
            CLOSING: "closing",
            CLOSED: "closed",
            OPENING: "opening",
            OPENED: "opened"
        },
        p = {
            CONFIRMATION: "confirmation",
            CANCELLATION: "cancellation"
        },
        m = void 0 !== (e = document.createElement("div").style).animationName || void 0 !== e.WebkitAnimationName || void 0 !== e.MozAnimationName || void 0 !== e.msAnimationName || void 0 !== e.OAnimationName,
        u = /iPad|iPhone|iPod/.test(navigator.platform);

    function f(t) {
        if (m && "none" === t.css("animation-name") && "none" === t.css("-webkit-animation-name") && "none" === t.css("-moz-animation-name") && "none" === t.css("-o-animation-name") && "none" === t.css("-ms-animation-name")) return 0;
        var n, e, a, i, o = t.css("animation-duration") || t.css("-webkit-animation-duration") || t.css("-moz-animation-duration") || t.css("-o-animation-duration") || t.css("-ms-animation-duration") || "0s",
            s = t.css("animation-delay") || t.css("-webkit-animation-delay") || t.css("-moz-animation-delay") || t.css("-o-animation-delay") || t.css("-ms-animation-delay") || "0s",
            r = t.css("animation-iteration-count") || t.css("-webkit-animation-iteration-count") || t.css("-moz-animation-iteration-count") || t.css("-o-animation-iteration-count") || t.css("-ms-animation-iteration-count") || "1";
        for (o = o.split(", "), s = s.split(", "), r = r.split(", "), i = 0, e = o.length, n = Number.NEGATIVE_INFINITY; i < e; i++)(a = parseFloat(o[i]) * parseInt(r[i], 10) + parseFloat(s[i])) > n && (n = a);
        return n
    }

    function g() {
        if (n(document).height() <= n(window).height()) return 0;
        var t, e, a = document.createElement("div"),
            i = document.createElement("div");
        return a.style.visibility = "hidden", a.style.width = "100px", document.body.appendChild(a), t = a.offsetWidth, a.style.overflow = "scroll", i.style.width = "100%", a.appendChild(i), e = i.offsetWidth, a.parentNode.removeChild(a), t - e
    }

    function h() {
        if (!u) {
            var t, e, a = n("html"),
                i = $("is-locked");
            a.hasClass(i) && (e = n(document.body), t = parseInt(e.css("padding-right"), 10) - g(), e.css("padding-right", t + "px"), a.removeClass(i))
        }
    }

    function v(t, n, e, a) {
        var i = $("is", n),
            o = [$("is", l.CLOSING), $("is", l.OPENING), $("is", l.CLOSED), $("is", l.OPENED)].join(" ");
        t.$bg.removeClass(o).addClass(i), t.$overlay.removeClass(o).addClass(i), t.$wrapper.removeClass(o).addClass(i), t.$modal.removeClass(o).addClass(i), t.state = n, !e && t.$modal.trigger({
            type: n,
            reason: a
        }, [{
            reason: a
        }])
    }

    function C(t, e, a) {
        var i = 0,
            o = function(t) {
                t.target === this && i++
            },
            s = function(t) {
                t.target === this && 0 == --i && (n.each(["$bg", "$overlay", "$wrapper", "$modal"], function(t, n) {
                    a[n].off(r + " " + d)
                }), e())
            };
        n.each(["$bg", "$overlay", "$wrapper", "$modal"], function(t, n) {
            a[n].on(r, o).on(d, s)
        }), t(), 0 === f(a.$bg) && 0 === f(a.$overlay) && 0 === f(a.$wrapper) && 0 === f(a.$modal) && (n.each(["$bg", "$overlay", "$wrapper", "$modal"], function(t, n) {
            a[n].off(r + " " + d)
        }), e())
    }

    function O(t) {
        t.state !== l.CLOSED && (n.each(["$bg", "$overlay", "$wrapper", "$modal"], function(n, e) {
            t[e].off(r + " " + d)
        }), t.$bg.removeClass(t.settings.modifier), t.$overlay.removeClass(t.settings.modifier).hide(), t.$wrapper.hide(), h(), v(t, l.CLOSED, !0))
    }

    function $() {
        for (var t = s, n = 0; n < arguments.length; ++n) t += "-" + arguments[n];
        return t
    }

    function E() {
        var t, e, i = location.hash.replace("#", "");
        if (i) {
            try {
                e = n("[data-" + o + '-id="' + i + '"]')
            } catch (t) {}
            e && e.length && (t = n[o].lookup[e.data(o)]) && t.settings.hashTracking && t.open()
        } else a && a.state === l.OPENED && a.settings.hashTracking && a.close()
    }

    function y(t, e) {
        var a = n(document.body),
            i = this;
        i.settings = n.extend({}, c, e), i.index = n[o].lookup.push(i) - 1, i.state = l.CLOSED, i.$overlay = n("." + $("overlay")), null !== i.settings.appendTo && i.settings.appendTo.length && (a = n(i.settings.appendTo)), i.$overlay.length || (i.$overlay = n("<div>").addClass($("overlay") + " " + $("is", l.CLOSED)).hide(), a.append(i.$overlay)), i.$bg = n("." + $("bg")).addClass($("is", l.CLOSED)), i.$modal = t.addClass(s + " " + $("is-initialized") + " " + i.settings.modifier + " " + $("is", l.CLOSED)).attr("tabindex", "-1"), i.$wrapper = n("<div>").addClass($("wrapper") + " " + i.settings.modifier + " " + $("is", l.CLOSED)).hide().append(i.$modal), a.append(i.$wrapper), i.$wrapper.on("click." + s, "[data-" + o + '-action="close"]', function(t) {
            t.preventDefault(), i.close()
        }), i.$wrapper.on("click." + s, "[data-" + o + '-action="cancel"]', function(t) {
            t.preventDefault(), i.$modal.trigger(p.CANCELLATION), i.settings.closeOnCancel && i.close(p.CANCELLATION)
        }), i.$wrapper.on("click." + s, "[data-" + o + '-action="confirm"]', function(t) {
            t.preventDefault(), i.$modal.trigger(p.CONFIRMATION), i.settings.closeOnConfirm && i.close(p.CONFIRMATION)
        }), i.$wrapper.on("click." + s, function(t) {
            n(t.target).hasClass($("wrapper")) && i.settings.closeOnOutsideClick && i.close()
        })
    }
    y.prototype.open = function() {
        var t, e = this;
        e.state !== l.OPENING && e.state !== l.CLOSING && ((t = e.$modal.attr("data-" + o + "-id")) && e.settings.hashTracking && (i = n(window).scrollTop(), location.hash = t), a && a !== e && O(a), a = e, function() {
            if (!u) {
                var t, e, a = n("html"),
                    i = $("is-locked");
                a.hasClass(i) || (e = n(document.body), t = parseInt(e.css("padding-right"), 10) + g(), e.css("padding-right", t + "px"), a.addClass(i))
            }
        }(), e.$bg.addClass(e.settings.modifier), e.$overlay.addClass(e.settings.modifier).show(), e.$wrapper.show().scrollTop(0), e.$modal.focus(), C(function() {
            v(e, l.OPENING)
        }, function() {
            v(e, l.OPENED)
        }, e))
    }, y.prototype.close = function(t) {
        var e = this;
        e.state !== l.OPENING && e.state !== l.CLOSING && e.state !== l.CLOSED && (e.settings.hashTracking && e.$modal.attr("data-" + o + "-id") === location.hash.substr(1) && (location.hash = "", n(window).scrollTop(i)), C(function() {
            v(e, l.CLOSING, !1, t)
        }, function() {
            e.$bg.removeClass(e.settings.modifier), e.$overlay.removeClass(e.settings.modifier).hide(), e.$wrapper.hide(), h(), v(e, l.CLOSED, !1, t)
        }, e))
    }, y.prototype.getState = function() {
        return this.state
    }, y.prototype.destroy = function() {
        var t = n[o].lookup;
        O(this), this.$wrapper.remove(), delete t[this.index], 0 === n.grep(t, function(t) {
            return !!t
        }).length && (this.$overlay.remove(), this.$bg.removeClass($("is", l.CLOSING) + " " + $("is", l.OPENING) + " " + $("is", l.CLOSED) + " " + $("is", l.OPENED)))
    }, n[o] = {
        lookup: []
    }, n.fn[o] = function(t) {
        var e, a;
        return this.each(function(i, s) {
            null == (a = n(s)).data(o) ? (e = new y(a, t), a.data(o, e.index), e.settings.hashTracking && a.attr("data-" + o + "-id") === location.hash.substr(1) && e.open()) : e = n[o].lookup[a.data(o)]
        }), e
    }, n(document).ready(function() {
        n(document).on("click", "[data-" + o + "-target]", function(t) {
            t.preventDefault();
            var e = t.currentTarget.getAttribute("data-" + o + "-target"),
                a = n("[data-" + o + '-id="' + e + '"]');
            n[o].lookup[a.data(o)].open()
        }), n(document).find("." + s).each(function(t, e) {
            var a = n(e),
                i = a.data(o + "-options");
            i ? ("string" == typeof i || i instanceof String) && (i = function(t) {
                var n, e, a, i, o = {};
                for (i = 0, e = (n = (t = t.replace(/\s*:\s*/g, ":").replace(/\s*,\s*/g, ",")).split(",")).length; i < e; i++) n[i] = n[i].split(":"), ("string" == typeof(a = n[i][1]) || a instanceof String) && (a = "true" === a || "false" !== a && a), ("string" == typeof a || a instanceof String) && (a = isNaN(a) ? a : +a), o[n[i][0]] = a;
                return o
            }(i)) : i = {}, a[o](i)
        }), n(document).on("keydown." + s, function(t) {
            a && a.settings.closeOnEscape && a.state === l.OPENED && 27 === t.keyCode && a.close()
        }), n(window).on("hashchange." + s, E)
    })
});
var _slice = Array.prototype.slice,
    _slicedToArray = function() {
        return function(t, e) {
            if (Array.isArray(t)) return t;
            if (Symbol.iterator in Object(t)) return function(t, e) {
                var i = [],
                    n = !0,
                    r = !1,
                    s = void 0;
                try {
                    for (var a, o = t[Symbol.iterator](); !(n = (a = o.next()).done) && (i.push(a.value), !e || i.length !== e); n = !0);
                } catch (t) {
                    r = !0, s = t
                } finally {
                    try {
                        !n && o.return && o.return()
                    } finally {
                        if (r) throw s
                    }
                }
                return i
            }(t, e);
            throw new TypeError("Invalid attempt to destructure non-iterable instance")
        }
    }(),
    _extends = Object.assign || function(t) {
        for (var e = 1; e < arguments.length; e++) {
            var i = arguments[e];
            for (var n in i) Object.prototype.hasOwnProperty.call(i, n) && (t[n] = i[n])
        }
        return t
    };

function _toConsumableArray(t) {
    if (Array.isArray(t)) {
        for (var e = 0, i = Array(t.length); e < t.length; e++) i[e] = t[e];
        return i
    }
    return Array.from(t)
}! function(t, e) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = e(require("jquery")) : "function" == typeof define && define.amd ? define(["jquery"], e) : t.parsley = e(t.jQuery)
}(this, function(t) {
    "use strict";
    var e, i = 1,
        n = {},
        r = {
            attr: function(t, e, i) {
                var n, r, s, a = new RegExp("^" + e, "i");
                if (void 0 === i) i = {};
                else
                    for (n in i) i.hasOwnProperty(n) && delete i[n];
                if (!t) return i;
                for (n = (s = t.attributes).length; n--;)(r = s[n]) && r.specified && a.test(r.name) && (i[this.camelize(r.name.slice(e.length))] = this.deserializeValue(r.value));
                return i
            },
            checkAttr: function(t, e, i) {
                return t.hasAttribute(e + i)
            },
            setAttr: function(t, e, i, n) {
                t.setAttribute(this.dasherize(e + i), String(n))
            },
            getType: function(t) {
                return t.getAttribute("type") || "text"
            },
            generateID: function() {
                return "" + i++
            },
            deserializeValue: function(t) {
                var e;
                try {
                    return t ? "true" == t || "false" != t && ("null" == t ? null : isNaN(e = Number(t)) ? /^[\[\{]/.test(t) ? JSON.parse(t) : t : e) : t
                } catch (e) {
                    return t
                }
            },
            camelize: function(t) {
                return t.replace(/-+(.)?/g, function(t, e) {
                    return e ? e.toUpperCase() : ""
                })
            },
            dasherize: function(t) {
                return t.replace(/::/g, "/").replace(/([A-Z]+)([A-Z][a-z])/g, "$1_$2").replace(/([a-z\d])([A-Z])/g, "$1_$2").replace(/_/g, "-").toLowerCase()
            },
            warn: function() {
                var t;
                window.console && "function" == typeof window.console.warn && (t = window.console).warn.apply(t, arguments)
            },
            warnOnce: function(t) {
                n[t] || (n[t] = !0, this.warn.apply(this, arguments))
            },
            _resetWarnings: function() {
                n = {}
            },
            trimString: function(t) {
                return t.replace(/^\s+|\s+$/g, "")
            },
            parse: {
                date: function(t) {
                    var e = t.match(/^(\d{4,})-(\d\d)-(\d\d)$/);
                    if (!e) return null;
                    var i = e.map(function(t) {
                            return parseInt(t, 10)
                        }),
                        n = _slicedToArray(i, 4),
                        r = (n[0], n[1]),
                        s = n[2],
                        a = n[3],
                        o = new Date(r, s - 1, a);
                    return o.getFullYear() !== r || o.getMonth() + 1 !== s || o.getDate() !== a ? null : o
                },
                string: function(t) {
                    return t
                },
                integer: function(t) {
                    return isNaN(t) ? null : parseInt(t, 10)
                },
                number: function(t) {
                    if (isNaN(t)) throw null;
                    return parseFloat(t)
                },
                boolean: function(t) {
                    return !/^\s*false\s*$/i.test(t)
                },
                object: function(t) {
                    return r.deserializeValue(t)
                },
                regexp: function(t) {
                    var e = "";
                    return /^\/.*\/(?:[gimy]*)$/.test(t) ? (e = t.replace(/.*\/([gimy]*)$/, "$1"), t = t.replace(new RegExp("^/(.*?)/" + e + "$"), "$1")) : t = "^" + t + "$", new RegExp(t, e)
                }
            },
            parseRequirement: function(t, e) {
                var i = this.parse[t || "string"];
                if (!i) throw 'Unknown requirement specification: "' + t + '"';
                var n = i(e);
                if (null === n) throw "Requirement is not a " + t + ': "' + e + '"';
                return n
            },
            namespaceEvents: function(e, i) {
                return (e = this.trimString(e || "").split(/\s+/))[0] ? t.map(e, function(t) {
                    return t + "." + i
                }).join(" ") : ""
            },
            difference: function(e, i) {
                var n = [];
                return t.each(e, function(t, e) {
                    -1 == i.indexOf(e) && n.push(e)
                }), n
            },
            all: function(e) {
                return t.when.apply(t, _toConsumableArray(e).concat([42, 42]))
            },
            objectCreate: Object.create || (e = function() {}, function(t) {
                if (arguments.length > 1) throw Error("Second argument not supported");
                if ("object" != typeof t) throw TypeError("Argument must be an object");
                e.prototype = t;
                var i = new e;
                return e.prototype = null, i
            }),
            _SubmitSelector: 'input[type="submit"], button:submit'
        },
        s = {
            namespace: "data-parsley-",
            inputs: "input, textarea, select",
            excluded: "input[type=button], input[type=submit], input[type=reset], input[type=hidden]",
            priorityEnabled: !0,
            multiple: null,
            group: null,
            uiEnabled: !0,
            validationThreshold: 3,
            focus: "first",
            trigger: !1,
            triggerAfterFailure: "input",
            errorClass: "parsley-error",
            successClass: "parsley-success",
            classHandler: function(t) {},
            errorsContainer: function(t) {},
            errorsWrapper: '<ul class="parsley-errors-list"></ul>',
            errorTemplate: "<li></li>"
        },
        a = function() {
            this.__id__ = r.generateID()
        };
    a.prototype = {
        asyncSupport: !0,
        _pipeAccordingToValidationResult: function() {
            var e = this,
                i = function() {
                    var i = t.Deferred();
                    return !0 !== e.validationResult && i.reject(), i.resolve().promise()
                };
            return [i, i]
        },
        actualizeOptions: function() {
            return r.attr(this.element, this.options.namespace, this.domOptions), this.parent && this.parent.actualizeOptions && this.parent.actualizeOptions(), this
        },
        _resetOptions: function(t) {
            for (var e in this.domOptions = r.objectCreate(this.parent.options), this.options = r.objectCreate(this.domOptions), t) t.hasOwnProperty(e) && (this.options[e] = t[e]);
            this.actualizeOptions()
        },
        _listeners: null,
        on: function(t, e) {
            return this._listeners = this._listeners || {}, (this._listeners[t] = this._listeners[t] || []).push(e), this
        },
        subscribe: function(e, i) {
            t.listenTo(this, e.toLowerCase(), i)
        },
        off: function(t, e) {
            var i = this._listeners && this._listeners[t];
            if (i)
                if (e)
                    for (var n = i.length; n--;) i[n] === e && i.splice(n, 1);
                else delete this._listeners[t];
            return this
        },
        unsubscribe: function(e, i) {
            t.unsubscribeTo(this, e.toLowerCase())
        },
        trigger: function(t, e, i) {
            e = e || this;
            var n, r = this._listeners && this._listeners[t];
            if (r)
                for (var s = r.length; s--;)
                    if (!1 === (n = r[s].call(e, e, i))) return n;
            return !this.parent || this.parent.trigger(t, e, i)
        },
        asyncIsValid: function(t, e) {
            return r.warnOnce("asyncIsValid is deprecated; please use whenValid instead"), this.whenValid({
                group: t,
                force: e
            })
        },
        _findRelated: function() {
            return this.options.multiple ? t(this.parent.element.querySelectorAll("[" + this.options.namespace + 'multiple="' + this.options.multiple + '"]')) : this.$element
        }
    };
    var o = function(e) {
        t.extend(!0, this, e)
    };
    o.prototype = {
        validate: function(t, e) {
            if (this.fn) return arguments.length > 3 && (e = [].slice.call(arguments, 1, -1)), this.fn(t, e);
            if (Array.isArray(t)) {
                if (!this.validateMultiple) throw "Validator `" + this.name + "` does not handle multiple values";
                return this.validateMultiple.apply(this, arguments)
            }
            var i = arguments[arguments.length - 1];
            if (this.validateDate && i._isDateInput()) return arguments[0] = r.parse.date(arguments[0]), null !== arguments[0] && this.validateDate.apply(this, arguments);
            if (this.validateNumber) return !isNaN(t) && (arguments[0] = parseFloat(arguments[0]), this.validateNumber.apply(this, arguments));
            if (this.validateString) return this.validateString.apply(this, arguments);
            throw "Validator `" + this.name + "` only handles multiple values"
        },
        parseRequirements: function(e, i) {
            if ("string" != typeof e) return Array.isArray(e) ? e : [e];
            var n = this.requirementType;
            if (Array.isArray(n)) {
                for (var s = function(t, e) {
                        var i = t.match(/^\s*\[(.*)\]\s*$/);
                        if (!i) throw 'Requirement is not an array: "' + t + '"';
                        var n = i[1].split(",").map(r.trimString);
                        if (n.length !== e) throw "Requirement has " + n.length + " values when " + e + " are needed";
                        return n
                    }(e, n.length), a = 0; a < s.length; a++) s[a] = r.parseRequirement(n[a], s[a]);
                return s
            }
            return t.isPlainObject(n) ? function(t, e, i) {
                var n = null,
                    s = {};
                for (var a in t)
                    if (a) {
                        var o = i(a);
                        "string" == typeof o && (o = r.parseRequirement(t[a], o)), s[a] = o
                    } else n = r.parseRequirement(t[a], e);
                return [n, s]
            }(n, e, i) : [r.parseRequirement(n, e)]
        },
        requirementType: "string",
        priority: 2
    };
    var l = function(t, e) {
            this.__class__ = "ValidatorRegistry", this.locale = "en", this.init(t || {}, e || {})
        },
        u = {
            email: /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i,
            number: /^-?(\d*\.)?\d+(e[-+]?\d+)?$/i,
            integer: /^-?\d+$/,
            digits: /^\d+$/,
            alphanum: /^\w+$/i,
            date: {
                test: function(t) {
                    return null !== r.parse.date(t)
                }
            },
            url: new RegExp("^(?:(?:https?|ftp)://)?(?:\\S+(?::\\S*)?@)?(?:(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[1-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]-*)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,})))(?::\\d{2,5})?(?:/\\S*)?$", "i")
        };
    u.range = u.number;
    var d = function(t) {
            var e = ("" + t).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            return e ? Math.max(0, (e[1] ? e[1].length : 0) - (e[2] ? +e[2] : 0)) : 0
        },
        h = function(t, e) {
            return function(i) {
                for (var n = arguments.length, s = Array(n > 1 ? n - 1 : 0), a = 1; a < n; a++) s[a - 1] = arguments[a];
                return s.pop(), e.apply(void 0, [i].concat(_toConsumableArray((o = t, s.map(r.parse[o])))));
                var o
            }
        },
        p = function(t) {
            return {
                validateDate: h("date", t),
                validateNumber: h("number", t),
                requirementType: t.length <= 2 ? "string" : ["string", "string"],
                priority: 30
            }
        };
    l.prototype = {
        init: function(t, e) {
            for (var i in this.catalog = e, this.validators = _extends({}, this.validators), t) this.addValidator(i, t[i].fn, t[i].priority);
            window.Parsley.trigger("parsley:validator:init")
        },
        setLocale: function(t) {
            if (void 0 === this.catalog[t]) throw new Error(t + " is not available in the catalog");
            return this.locale = t, this
        },
        addCatalog: function(t, e, i) {
            return "object" == typeof e && (this.catalog[t] = e), !0 === i ? this.setLocale(t) : this
        },
        addMessage: function(t, e, i) {
            return void 0 === this.catalog[t] && (this.catalog[t] = {}), this.catalog[t][e] = i, this
        },
        addMessages: function(t, e) {
            for (var i in e) this.addMessage(t, i, e[i]);
            return this
        },
        addValidator: function(t, e, i) {
            if (this.validators[t]) r.warn('Validator "' + t + '" is already defined.');
            else if (s.hasOwnProperty(t)) return void r.warn('"' + t + '" is a restricted keyword and is not a valid validator name.');
            return this._setValidator.apply(this, arguments)
        },
        hasValidator: function(t) {
            return !!this.validators[t]
        },
        updateValidator: function(t, e, i) {
            return this.validators[t] ? this._setValidator.apply(this, arguments) : (r.warn('Validator "' + t + '" is not already defined.'), this.addValidator.apply(this, arguments))
        },
        removeValidator: function(t) {
            return this.validators[t] || r.warn('Validator "' + t + '" is not defined.'), delete this.validators[t], this
        },
        _setValidator: function(t, e, i) {
            for (var n in "object" != typeof e && (e = {
                    fn: e,
                    priority: i
                }), e.validate || (e = new o(e)), this.validators[t] = e, e.messages || {}) this.addMessage(n, t, e.messages[n]);
            return this
        },
        getErrorMessage: function(t) {
            var e;
            "type" === t.name ? e = (this.catalog[this.locale][t.name] || {})[t.requirements] : e = this.formatMessage(this.catalog[this.locale][t.name], t.requirements);
            return e || this.catalog[this.locale].defaultMessage || this.catalog.en.defaultMessage
        },
        formatMessage: function(t, e) {
            if ("object" == typeof e) {
                for (var i in e) t = this.formatMessage(t, e[i]);
                return t
            }
            return "string" == typeof t ? t.replace(/%s/i, e) : ""
        },
        validators: {
            notblank: {
                validateString: function(t) {
                    return /\S/.test(t)
                },
                priority: 2
            },
            required: {
                validateMultiple: function(t) {
                    return t.length > 0
                },
                validateString: function(t) {
                    return /\S/.test(t)
                },
                priority: 512
            },
            type: {
                validateString: function(t, e) {
                    var i = arguments.length <= 2 || void 0 === arguments[2] ? {} : arguments[2],
                        n = i.step,
                        r = void 0 === n ? "any" : n,
                        s = i.base,
                        a = void 0 === s ? 0 : s,
                        o = u[e];
                    if (!o) throw new Error("validator type `" + e + "` is not supported");
                    if (!o.test(t)) return !1;
                    if ("number" === e && !/^any$/i.test(r || "")) {
                        var l = Number(t),
                            h = Math.max(d(r), d(a));
                        if (d(l) > h) return !1;
                        var p = function(t) {
                            return Math.round(t * Math.pow(10, h))
                        };
                        if ((p(l) - p(a)) % p(r) != 0) return !1
                    }
                    return !0
                },
                requirementType: {
                    "": "string",
                    step: "string",
                    base: "number"
                },
                priority: 256
            },
            pattern: {
                validateString: function(t, e) {
                    return e.test(t)
                },
                requirementType: "regexp",
                priority: 64
            },
            minlength: {
                validateString: function(t, e) {
                    return t.length >= e
                },
                requirementType: "integer",
                priority: 30
            },
            maxlength: {
                validateString: function(t, e) {
                    return t.length <= e
                },
                requirementType: "integer",
                priority: 30
            },
            length: {
                validateString: function(t, e, i) {
                    return t.length >= e && t.length <= i
                },
                requirementType: ["integer", "integer"],
                priority: 30
            },
            mincheck: {
                validateMultiple: function(t, e) {
                    return t.length >= e
                },
                requirementType: "integer",
                priority: 30
            },
            maxcheck: {
                validateMultiple: function(t, e) {
                    return t.length <= e
                },
                requirementType: "integer",
                priority: 30
            },
            check: {
                validateMultiple: function(t, e, i) {
                    return t.length >= e && t.length <= i
                },
                requirementType: ["integer", "integer"],
                priority: 30
            },
            min: p(function(t, e) {
                return t >= e
            }),
            max: p(function(t, e) {
                return t <= e
            }),
            range: p(function(t, e, i) {
                return t >= e && t <= i
            }),
            equalto: {
                validateString: function(e, i) {
                    var n = t(i);
                    return n.length ? e === n.val() : e === i
                },
                priority: 256
            }
        }
    };
    var c = {};
    c.Form = {
        _actualizeTriggers: function() {
            var t = this;
            this.$element.on("submit.Parsley", function(e) {
                t.onSubmitValidate(e)
            }), this.$element.on("click.Parsley", r._SubmitSelector, function(e) {
                t.onSubmitButton(e)
            }), !1 !== this.options.uiEnabled && this.element.setAttribute("novalidate", "")
        },
        focus: function() {
            if (this._focusedField = null, !0 === this.validationResult || "none" === this.options.focus) return null;
            for (var t = 0; t < this.fields.length; t++) {
                var e = this.fields[t];
                if (!0 !== e.validationResult && e.validationResult.length > 0 && void 0 === e.options.noFocus && (this._focusedField = e.$element, "first" === this.options.focus)) break
            }
            return null === this._focusedField ? null : this._focusedField.focus()
        },
        _destroyUI: function() {
            this.$element.off(".Parsley")
        }
    }, c.Field = {
        _reflowUI: function() {
            if (this._buildUI(), this._ui) {
                var t = function t(e, i, n) {
                    for (var r = [], s = [], a = 0; a < e.length; a++) {
                        for (var o = !1, l = 0; l < i.length; l++)
                            if (e[a].assert.name === i[l].assert.name) {
                                o = !0;
                                break
                            } o ? s.push(e[a]) : r.push(e[a])
                    }
                    return {
                        kept: s,
                        added: r,
                        removed: n ? [] : t(i, e, !0).added
                    }
                }(this.validationResult, this._ui.lastValidationResult);
                this._ui.lastValidationResult = this.validationResult, this._manageStatusClass(), this._manageErrorsMessages(t), this._actualizeTriggers(), !t.kept.length && !t.added.length || this._failedOnce || (this._failedOnce = !0, this._actualizeTriggers())
            }
        },
        getErrorsMessages: function() {
            if (!0 === this.validationResult) return [];
            for (var t = [], e = 0; e < this.validationResult.length; e++) t.push(this.validationResult[e].errorMessage || this._getErrorMessage(this.validationResult[e].assert));
            return t
        },
        addError: function(t) {
            var e = arguments.length <= 1 || void 0 === arguments[1] ? {} : arguments[1],
                i = e.message,
                n = e.assert,
                r = e.updateClass,
                s = void 0 === r || r;
            this._buildUI(), this._addError(t, {
                message: i,
                assert: n
            }), s && this._errorClass()
        },
        updateError: function(t) {
            var e = arguments.length <= 1 || void 0 === arguments[1] ? {} : arguments[1],
                i = e.message,
                n = e.assert,
                r = e.updateClass,
                s = void 0 === r || r;
            this._buildUI(), this._updateError(t, {
                message: i,
                assert: n
            }), s && this._errorClass()
        },
        removeError: function(t) {
            var e = (arguments.length <= 1 || void 0 === arguments[1] ? {} : arguments[1]).updateClass,
                i = void 0 === e || e;
            this._buildUI(), this._removeError(t), i && this._manageStatusClass()
        },
        _manageStatusClass: function() {
            this.hasConstraints() && this.needsValidation() && !0 === this.validationResult ? this._successClass() : this.validationResult.length > 0 ? this._errorClass() : this._resetClass()
        },
        _manageErrorsMessages: function(e) {
            if (void 0 === this.options.errorsMessagesDisabled) {
                if (void 0 !== this.options.errorMessage) return e.added.length || e.kept.length ? (this._insertErrorWrapper(), 0 === this._ui.$errorsWrapper.find(".parsley-custom-error-message").length && this._ui.$errorsWrapper.append(t(this.options.errorTemplate).addClass("parsley-custom-error-message")), this._ui.$errorsWrapper.addClass("filled").find(".parsley-custom-error-message").html(this.options.errorMessage)) : this._ui.$errorsWrapper.removeClass("filled").find(".parsley-custom-error-message").remove();
                for (var i = 0; i < e.removed.length; i++) this._removeError(e.removed[i].assert.name);
                for (i = 0; i < e.added.length; i++) this._addError(e.added[i].assert.name, {
                    message: e.added[i].errorMessage,
                    assert: e.added[i].assert
                });
                for (i = 0; i < e.kept.length; i++) this._updateError(e.kept[i].assert.name, {
                    message: e.kept[i].errorMessage,
                    assert: e.kept[i].assert
                })
            }
        },
        _addError: function(e, i) {
            var n = i.message,
                r = i.assert;
            this._insertErrorWrapper(), this._ui.$errorsWrapper.addClass("filled").append(t(this.options.errorTemplate).addClass("parsley-" + e).html(n || this._getErrorMessage(r)))
        },
        _updateError: function(t, e) {
            var i = e.message,
                n = e.assert;
            this._ui.$errorsWrapper.addClass("filled").find(".parsley-" + t).html(i || this._getErrorMessage(n))
        },
        _removeError: function(t) {
            this._ui.$errorsWrapper.removeClass("filled").find(".parsley-" + t).remove()
        },
        _getErrorMessage: function(t) {
            var e = t.name + "Message";
            return void 0 !== this.options[e] ? window.Parsley.formatMessage(this.options[e], t.requirements) : window.Parsley.getErrorMessage(t)
        },
        _buildUI: function() {
            if (!this._ui && !1 !== this.options.uiEnabled) {
                var e = {};
                this.element.setAttribute(this.options.namespace + "id", this.__id__), e.$errorClassHandler = this._manageClassHandler(), e.errorsWrapperId = "parsley-id-" + (this.options.multiple ? "multiple-" + this.options.multiple : this.__id__), e.$errorsWrapper = t(this.options.errorsWrapper).attr("id", e.errorsWrapperId), e.lastValidationResult = [], e.validationInformationVisible = !1, this._ui = e
            }
        },
        _manageClassHandler: function() {
            if ("string" == typeof this.options.classHandler && t(this.options.classHandler).length) return t(this.options.classHandler);
            var e = this.options.classHandler;
            if ("string" == typeof this.options.classHandler && "function" == typeof window[this.options.classHandler] && (e = window[this.options.classHandler]), "function" == typeof e) {
                var i = e.call(this, this);
                if (void 0 !== i && i.length) return i
            } else {
                if ("object" == typeof e && e instanceof jQuery && e.length) return e;
                e && r.warn("The class handler `" + e + "` does not exist in DOM nor as a global JS function")
            }
            return this._inputHolder()
        },
        _inputHolder: function() {
            return this.options.multiple && "SELECT" !== this.element.nodeName ? this.$element.parent() : this.$element
        },
        _insertErrorWrapper: function() {
            var e = this.options.errorsContainer;
            if (0 !== this._ui.$errorsWrapper.parent().length) return this._ui.$errorsWrapper.parent();
            if ("string" == typeof e) {
                if (t(e).length) return t(e).append(this._ui.$errorsWrapper);
                "function" == typeof window[e] ? e = window[e] : r.warn("The errors container `" + e + "` does not exist in DOM nor as a global JS function")
            }
            return "function" == typeof e && (e = e.call(this, this)), "object" == typeof e && e.length ? e.append(this._ui.$errorsWrapper) : this._inputHolder().after(this._ui.$errorsWrapper)
        },
        _actualizeTriggers: function() {
            var t, e = this,
                i = this._findRelated();
            i.off(".Parsley"), this._failedOnce ? i.on(r.namespaceEvents(this.options.triggerAfterFailure, "Parsley"), function() {
                e._validateIfNeeded()
            }) : (t = r.namespaceEvents(this.options.trigger, "Parsley")) && i.on(t, function(t) {
                e._validateIfNeeded(t)
            })
        },
        _validateIfNeeded: function(t) {
            var e = this;
            t && /key|input/.test(t.type) && (!this._ui || !this._ui.validationInformationVisible) && this.getValue().length <= this.options.validationThreshold || (this.options.debounce ? (window.clearTimeout(this._debounced), this._debounced = window.setTimeout(function() {
                return e.validate()
            }, this.options.debounce)) : this.validate())
        },
        _resetUI: function() {
            this._failedOnce = !1, this._actualizeTriggers(), void 0 !== this._ui && (this._ui.$errorsWrapper.removeClass("filled").children().remove(), this._resetClass(), this._ui.lastValidationResult = [], this._ui.validationInformationVisible = !1)
        },
        _destroyUI: function() {
            this._resetUI(), void 0 !== this._ui && this._ui.$errorsWrapper.remove(), delete this._ui
        },
        _successClass: function() {
            this._ui.validationInformationVisible = !0, this._ui.$errorClassHandler.removeClass(this.options.errorClass).addClass(this.options.successClass)
        },
        _errorClass: function() {
            this._ui.validationInformationVisible = !0, this._ui.$errorClassHandler.removeClass(this.options.successClass).addClass(this.options.errorClass)
        },
        _resetClass: function() {
            this._ui.$errorClassHandler.removeClass(this.options.successClass).removeClass(this.options.errorClass)
        }
    };
    var f = function(e, i, n) {
            this.__class__ = "Form", this.element = e, this.$element = t(e), this.domOptions = i, this.options = n, this.parent = window.Parsley, this.fields = [], this.validationResult = null
        },
        m = {
            pending: null,
            resolved: !0,
            rejected: !1
        };
    f.prototype = {
        onSubmitValidate: function(t) {
            var e = this;
            if (!0 !== t.parsley) {
                var i = this._submitSource || this.$element.find(r._SubmitSelector)[0];
                if (this._submitSource = null, this.$element.find(".parsley-synthetic-submit-button").prop("disabled", !0), !i || null === i.getAttribute("formnovalidate")) {
                    window.Parsley._remoteCache = {};
                    var n = this.whenValidate({
                        event: t
                    });
                    "resolved" === n.state() && !1 !== this._trigger("submit") || (t.stopImmediatePropagation(), t.preventDefault(), "pending" === n.state() && n.done(function() {
                        e._submit(i)
                    }))
                }
            }
        },
        onSubmitButton: function(t) {
            this._submitSource = t.currentTarget
        },
        _submit: function(e) {
            if (!1 !== this._trigger("submit")) {
                if (e) {
                    var i = this.$element.find(".parsley-synthetic-submit-button").prop("disabled", !1);
                    0 === i.length && (i = t('<input class="parsley-synthetic-submit-button" type="hidden">').appendTo(this.$element)), i.attr({
                        name: e.getAttribute("name"),
                        value: e.getAttribute("value")
                    })
                }
                this.$element.trigger(_extends(t.Event("submit"), {
                    parsley: !0
                }))
            }
        },
        validate: function(e) {
            if (arguments.length >= 1 && !t.isPlainObject(e)) {
                r.warnOnce("Calling validate on a parsley form without passing arguments as an object is deprecated.");
                var i = _slice.call(arguments);
                e = {
                    group: i[0],
                    force: i[1],
                    event: i[2]
                }
            }
            return m[this.whenValidate(e).state()]
        },
        whenValidate: function() {
            var e, i = this,
                n = arguments.length <= 0 || void 0 === arguments[0] ? {} : arguments[0],
                s = n.group,
                a = n.force,
                o = n.event;
            this.submitEvent = o, o && (this.submitEvent = _extends({}, o, {
                preventDefault: function() {
                    r.warnOnce("Using `this.submitEvent.preventDefault()` is deprecated; instead, call `this.validationResult = false`"), i.validationResult = !1
                }
            })), this.validationResult = !0, this._trigger("validate"), this._refreshFields();
            var l = this._withoutReactualizingFormOptions(function() {
                return t.map(i.fields, function(t) {
                    return t.whenValidate({
                        force: a,
                        group: s
                    })
                })
            });
            return (e = r.all(l).done(function() {
                i._trigger("success")
            }).fail(function() {
                i.validationResult = !1, i.focus(), i._trigger("error")
            }).always(function() {
                i._trigger("validated")
            })).pipe.apply(e, _toConsumableArray(this._pipeAccordingToValidationResult()))
        },
        isValid: function(e) {
            if (arguments.length >= 1 && !t.isPlainObject(e)) {
                r.warnOnce("Calling isValid on a parsley form without passing arguments as an object is deprecated.");
                var i = _slice.call(arguments);
                e = {
                    group: i[0],
                    force: i[1]
                }
            }
            return m[this.whenValid(e).state()]
        },
        whenValid: function() {
            var e = this,
                i = arguments.length <= 0 || void 0 === arguments[0] ? {} : arguments[0],
                n = i.group,
                s = i.force;
            this._refreshFields();
            var a = this._withoutReactualizingFormOptions(function() {
                return t.map(e.fields, function(t) {
                    return t.whenValid({
                        group: n,
                        force: s
                    })
                })
            });
            return r.all(a)
        },
        refresh: function() {
            return this._refreshFields(), this
        },
        reset: function() {
            for (var t = 0; t < this.fields.length; t++) this.fields[t].reset();
            this._trigger("reset")
        },
        destroy: function() {
            this._destroyUI();
            for (var t = 0; t < this.fields.length; t++) this.fields[t].destroy();
            this.$element.removeData("Parsley"), this._trigger("destroy")
        },
        _refreshFields: function() {
            return this.actualizeOptions()._bindFields()
        },
        _bindFields: function() {
            var e = this,
                i = this.fields;
            return this.fields = [], this.fieldsMappedById = {}, this._withoutReactualizingFormOptions(function() {
                e.$element.find(e.options.inputs).not(e.options.excluded).each(function(t, i) {
                    var n = new window.Parsley.Factory(i, {}, e);
                    if (("Field" === n.__class__ || "FieldMultiple" === n.__class__) && !0 !== n.options.excluded) {
                        var r = n.__class__ + "-" + n.__id__;
                        void 0 === e.fieldsMappedById[r] && (e.fieldsMappedById[r] = n, e.fields.push(n))
                    }
                }), t.each(r.difference(i, e.fields), function(t, e) {
                    e.reset()
                })
            }), this
        },
        _withoutReactualizingFormOptions: function(t) {
            var e = this.actualizeOptions;
            this.actualizeOptions = function() {
                return this
            };
            var i = t();
            return this.actualizeOptions = e, i
        },
        _trigger: function(t) {
            return this.trigger("form:" + t)
        }
    };
    var g = function(t, e, i, n, r) {
        var s = window.Parsley._validatorRegistry.validators[e],
            a = new o(s);
        n = n || t.options[e + "Priority"] || a.priority, _extends(this, {
            validator: a,
            name: e,
            requirements: i,
            priority: n,
            isDomConstraint: r = !0 === r
        }), this._parseRequirements(t.options)
    };
    g.prototype = {
        validate: function(t, e) {
            var i;
            return (i = this.validator).validate.apply(i, [t].concat(_toConsumableArray(this.requirementList), [e]))
        },
        _parseRequirements: function(t) {
            var e = this;
            this.requirementList = this.validator.parseRequirements(this.requirements, function(i) {
                return t[e.name + (n = i, n[0].toUpperCase() + n.slice(1))];
                var n
            })
        }
    };
    var v = function(e, i, n, r) {
            this.__class__ = "Field", this.element = e, this.$element = t(e), void 0 !== r && (this.parent = r), this.options = n, this.domOptions = i, this.constraints = [], this.constraintsByName = {}, this.validationResult = !0, this._bindConstraints()
        },
        y = {
            pending: null,
            resolved: !0,
            rejected: !1
        };
    v.prototype = {
        validate: function(e) {
            arguments.length >= 1 && !t.isPlainObject(e) && (r.warnOnce("Calling validate on a parsley field without passing arguments as an object is deprecated."), e = {
                options: e
            });
            var i = this.whenValidate(e);
            if (!i) return !0;
            switch (i.state()) {
                case "pending":
                    return null;
                case "resolved":
                    return !0;
                case "rejected":
                    return this.validationResult
            }
        },
        whenValidate: function() {
            var t, e = this,
                i = arguments.length <= 0 || void 0 === arguments[0] ? {} : arguments[0],
                n = i.force,
                r = i.group;
            if (this.refresh(), !r || this._isInGroup(r)) return this.value = this.getValue(), this._trigger("validate"), (t = this.whenValid({
                force: n,
                value: this.value,
                _refreshed: !0
            }).always(function() {
                e._reflowUI()
            }).done(function() {
                e._trigger("success")
            }).fail(function() {
                e._trigger("error")
            }).always(function() {
                e._trigger("validated")
            })).pipe.apply(t, _toConsumableArray(this._pipeAccordingToValidationResult()))
        },
        hasConstraints: function() {
            return 0 !== this.constraints.length
        },
        needsValidation: function(t) {
            return void 0 === t && (t = this.getValue()), !(!t.length && !this._isRequired() && void 0 === this.options.validateIfEmpty)
        },
        _isInGroup: function(e) {
            return Array.isArray(this.options.group) ? -1 !== t.inArray(e, this.options.group) : this.options.group === e
        },
        isValid: function(e) {
            if (arguments.length >= 1 && !t.isPlainObject(e)) {
                r.warnOnce("Calling isValid on a parsley field without passing arguments as an object is deprecated.");
                var i = _slice.call(arguments);
                e = {
                    force: i[0],
                    value: i[1]
                }
            }
            var n = this.whenValid(e);
            return !n || y[n.state()]
        },
        whenValid: function() {
            var e = this,
                i = arguments.length <= 0 || void 0 === arguments[0] ? {} : arguments[0],
                n = i.force,
                s = void 0 !== n && n,
                a = i.value,
                o = i.group;
            if (i._refreshed || this.refresh(), !o || this._isInGroup(o)) {
                if (this.validationResult = !0, !this.hasConstraints()) return t.when();
                if (null == a && (a = this.getValue()), !this.needsValidation(a) && !0 !== s) return t.when();
                var l = this._getGroupedConstraints(),
                    u = [];
                return t.each(l, function(i, n) {
                    var s = r.all(t.map(n, function(t) {
                        return e._validateConstraint(a, t)
                    }));
                    if (u.push(s), "rejected" === s.state()) return !1
                }), r.all(u)
            }
        },
        _validateConstraint: function(e, i) {
            var n = this,
                s = i.validate(e, this);
            return !1 === s && (s = t.Deferred().reject()), r.all([s]).fail(function(t) {
                n.validationResult instanceof Array || (n.validationResult = []), n.validationResult.push({
                    assert: i,
                    errorMessage: "string" == typeof t && t
                })
            })
        },
        getValue: function() {
            var t;
            return null == (t = "function" == typeof this.options.value ? this.options.value(this) : void 0 !== this.options.value ? this.options.value : this.$element.val()) ? "" : this._handleWhitespace(t)
        },
        reset: function() {
            return this._resetUI(), this._trigger("reset")
        },
        destroy: function() {
            this._destroyUI(), this.$element.removeData("Parsley"), this.$element.removeData("FieldMultiple"), this._trigger("destroy")
        },
        refresh: function() {
            return this._refreshConstraints(), this
        },
        _refreshConstraints: function() {
            return this.actualizeOptions()._bindConstraints()
        },
        refreshConstraints: function() {
            return r.warnOnce("Parsley's refreshConstraints is deprecated. Please use refresh"), this.refresh()
        },
        addConstraint: function(t, e, i, n) {
            if (window.Parsley._validatorRegistry.validators[t]) {
                var r = new g(this, t, e, i, n);
                "undefined" !== this.constraintsByName[r.name] && this.removeConstraint(r.name), this.constraints.push(r), this.constraintsByName[r.name] = r
            }
            return this
        },
        removeConstraint: function(t) {
            for (var e = 0; e < this.constraints.length; e++)
                if (t === this.constraints[e].name) {
                    this.constraints.splice(e, 1);
                    break
                } return delete this.constraintsByName[t], this
        },
        updateConstraint: function(t, e, i) {
            return this.removeConstraint(t).addConstraint(t, e, i)
        },
        _bindConstraints: function() {
            for (var t = [], e = {}, i = 0; i < this.constraints.length; i++) !1 === this.constraints[i].isDomConstraint && (t.push(this.constraints[i]), e[this.constraints[i].name] = this.constraints[i]);
            for (var n in this.constraints = t, this.constraintsByName = e, this.options) this.addConstraint(n, this.options[n], void 0, !0);
            return this._bindHtml5Constraints()
        },
        _bindHtml5Constraints: function() {
            null !== this.element.getAttribute("required") && this.addConstraint("required", !0, void 0, !0), null !== this.element.getAttribute("pattern") && this.addConstraint("pattern", this.element.getAttribute("pattern"), void 0, !0);
            var t = this.element.getAttribute("min"),
                e = this.element.getAttribute("max");
            null !== t && null !== e ? this.addConstraint("range", [t, e], void 0, !0) : null !== t ? this.addConstraint("min", t, void 0, !0) : null !== e && this.addConstraint("max", e, void 0, !0), null !== this.element.getAttribute("minlength") && null !== this.element.getAttribute("maxlength") ? this.addConstraint("length", [this.element.getAttribute("minlength"), this.element.getAttribute("maxlength")], void 0, !0) : null !== this.element.getAttribute("minlength") ? this.addConstraint("minlength", this.element.getAttribute("minlength"), void 0, !0) : null !== this.element.getAttribute("maxlength") && this.addConstraint("maxlength", this.element.getAttribute("maxlength"), void 0, !0);
            var i = r.getType(this.element);
            return "number" === i ? this.addConstraint("type", ["number", {
                step: this.element.getAttribute("step") || "1",
                base: t || this.element.getAttribute("value")
            }], void 0, !0) : /^(email|url|range|date)$/i.test(i) ? this.addConstraint("type", i, void 0, !0) : this
        },
        _isRequired: function() {
            return void 0 !== this.constraintsByName.required && !1 !== this.constraintsByName.required.requirements
        },
        _trigger: function(t) {
            return this.trigger("field:" + t)
        },
        _handleWhitespace: function(t) {
            return !0 === this.options.trimValue && r.warnOnce('data-parsley-trim-value="true" is deprecated, please use data-parsley-whitespace="trim"'), "squish" === this.options.whitespace && (t = t.replace(/\s{2,}/g, " ")), "trim" !== this.options.whitespace && "squish" !== this.options.whitespace && !0 !== this.options.trimValue || (t = r.trimString(t)), t
        },
        _isDateInput: function() {
            var t = this.constraintsByName.type;
            return t && "date" === t.requirements
        },
        _getGroupedConstraints: function() {
            if (!1 === this.options.priorityEnabled) return [this.constraints];
            for (var t = [], e = {}, i = 0; i < this.constraints.length; i++) {
                var n = this.constraints[i].priority;
                e[n] || t.push(e[n] = []), e[n].push(this.constraints[i])
            }
            return t.sort(function(t, e) {
                return e[0].priority - t[0].priority
            }), t
        }
    };
    var _ = v,
        w = function() {
            this.__class__ = "FieldMultiple"
        };
    w.prototype = {
        addElement: function(t) {
            return this.$elements.push(t), this
        },
        _refreshConstraints: function() {
            var e;
            if (this.constraints = [], "SELECT" === this.element.nodeName) return this.actualizeOptions()._bindConstraints(), this;
            for (var i = 0; i < this.$elements.length; i++)
                if (t("html").has(this.$elements[i]).length) {
                    e = this.$elements[i].data("FieldMultiple")._refreshConstraints().constraints;
                    for (var n = 0; n < e.length; n++) this.addConstraint(e[n].name, e[n].requirements, e[n].priority, e[n].isDomConstraint)
                } else this.$elements.splice(i, 1);
            return this
        },
        getValue: function() {
            if ("function" == typeof this.options.value) return this.options.value(this);
            if (void 0 !== this.options.value) return this.options.value;
            if ("INPUT" === this.element.nodeName) {
                var e = r.getType(this.element);
                if ("radio" === e) return this._findRelated().filter(":checked").val() || "";
                if ("checkbox" === e) {
                    var i = [];
                    return this._findRelated().filter(":checked").each(function() {
                        i.push(t(this).val())
                    }), i
                }
            }
            return "SELECT" === this.element.nodeName && null === this.$element.val() ? [] : this.$element.val()
        },
        _init: function() {
            return this.$elements = [this.$element], this
        }
    };
    var b = function(e, i, n) {
        this.element = e, this.$element = t(e);
        var r = this.$element.data("Parsley");
        if (r) return void 0 !== n && r.parent === window.Parsley && (r.parent = n, r._resetOptions(r.options)), "object" == typeof i && _extends(r.options, i), r;
        if (!this.$element.length) throw new Error("You must bind Parsley on an existing element.");
        if (void 0 !== n && "Form" !== n.__class__) throw new Error("Parent instance must be a Form instance");
        return this.parent = n || window.Parsley, this.init(i)
    };
    b.prototype = {
        init: function(t) {
            return this.__class__ = "Parsley", this.__version__ = "2.8.0", this.__id__ = r.generateID(), this._resetOptions(t), "FORM" === this.element.nodeName || r.checkAttr(this.element, this.options.namespace, "validate") && !this.$element.is(this.options.inputs) ? this.bind("parsleyForm") : this.isMultiple() ? this.handleMultiple() : this.bind("parsleyField")
        },
        isMultiple: function() {
            var t = r.getType(this.element);
            return "radio" === t || "checkbox" === t || "SELECT" === this.element.nodeName && null !== this.element.getAttribute("multiple")
        },
        handleMultiple: function() {
            var e, i, n = this;
            if (this.options.multiple = this.options.multiple || (e = this.element.getAttribute("name")) || this.element.getAttribute("id"), "SELECT" === this.element.nodeName && null !== this.element.getAttribute("multiple")) return this.options.multiple = this.options.multiple || this.__id__, this.bind("parsleyFieldMultiple");
            if (!this.options.multiple) return r.warn("To be bound by Parsley, a radio, a checkbox and a multiple select input must have either a name or a multiple option.", this.$element), this;
            this.options.multiple = this.options.multiple.replace(/(:|\.|\[|\]|\{|\}|\$)/g, ""), e && t('input[name="' + e + '"]').each(function(t, e) {
                var i = r.getType(e);
                "radio" !== i && "checkbox" !== i || e.setAttribute(n.options.namespace + "multiple", n.options.multiple)
            });
            for (var s = this._findRelated(), a = 0; a < s.length; a++)
                if (void 0 !== (i = t(s.get(a)).data("Parsley"))) {
                    this.$element.data("FieldMultiple") || i.addElement(this.$element);
                    break
                } return this.bind("parsleyField", !0), i || this.bind("parsleyFieldMultiple")
        },
        bind: function(e, i) {
            var n;
            switch (e) {
                case "parsleyForm":
                    n = t.extend(new f(this.element, this.domOptions, this.options), new a, window.ParsleyExtend)._bindFields();
                    break;
                case "parsleyField":
                    n = t.extend(new _(this.element, this.domOptions, this.options, this.parent), new a, window.ParsleyExtend);
                    break;
                case "parsleyFieldMultiple":
                    n = t.extend(new _(this.element, this.domOptions, this.options, this.parent), new w, new a, window.ParsleyExtend)._init();
                    break;
                default:
                    throw new Error(e + "is not a supported Parsley type")
            }
            return this.options.multiple && r.setAttr(this.element, this.options.namespace, "multiple", this.options.multiple), void 0 !== i ? (this.$element.data("FieldMultiple", n), n) : (this.$element.data("Parsley", n), n._actualizeTriggers(), n._trigger("init"), n)
        }
    };
    var F = t.fn.jquery.split(".");
    if (parseInt(F[0]) <= 1 && parseInt(F[1]) < 8) throw "The loaded version of jQuery is too old. Please upgrade to 1.8.x or better.";
    F.forEach || r.warn("Parsley requires ES5 to run properly. Please include https://github.com/es-shims/es5-shim");
    var C = _extends(new a, {
        element: document,
        $element: t(document),
        actualizeOptions: null,
        _resetOptions: null,
        Factory: b,
        version: "2.8.0"
    });
    _extends(_.prototype, c.Field, a.prototype), _extends(f.prototype, c.Form, a.prototype), _extends(b.prototype, a.prototype), t.fn.parsley = t.fn.psly = function(e) {
        if (this.length > 1) {
            var i = [];
            return this.each(function() {
                i.push(t(this).parsley(e))
            }), i
        }
        if (0 != this.length) return new b(this[0], e)
    }, void 0 === window.ParsleyExtend && (window.ParsleyExtend = {}), C.options = _extends(r.objectCreate(s), window.ParsleyConfig), window.ParsleyConfig = C.options, window.Parsley = window.psly = C, C.Utils = r, window.ParsleyUtils = {}, t.each(r, function(t, e) {
        "function" == typeof e && (window.ParsleyUtils[t] = function() {
            return r.warnOnce("Accessing `window.ParsleyUtils` is deprecated. Use `window.Parsley.Utils` instead."), r[t].apply(r, arguments)
        })
    });
    var E = window.Parsley._validatorRegistry = new l(window.ParsleyConfig.validators, window.ParsleyConfig.i18n);
    window.ParsleyValidator = {}, t.each("setLocale addCatalog addMessage addMessages getErrorMessage formatMessage addValidator updateValidator removeValidator hasValidator".split(" "), function(t, e) {
        window.Parsley[e] = function() {
            return E[e].apply(E, arguments)
        }, window.ParsleyValidator[e] = function() {
            var t;
            return r.warnOnce("Accessing the method '" + e + "' through Validator is deprecated. Simply call 'window.Parsley." + e + "(...)'"), (t = window.Parsley)[e].apply(t, arguments)
        }
    }), window.Parsley.UI = c, window.ParsleyUI = {
        removeError: function(t, e, i) {
            var n = !0 !== i;
            return r.warnOnce("Accessing UI is deprecated. Call 'removeError' on the instance directly. Please comment in issue 1073 as to your need to call this method."), t.removeError(e, {
                updateClass: n
            })
        },
        getErrorsMessages: function(t) {
            return r.warnOnce("Accessing UI is deprecated. Call 'getErrorsMessages' on the instance directly."), t.getErrorsMessages()
        }
    }, t.each("addError updateError".split(" "), function(t, e) {
        window.ParsleyUI[e] = function(t, i, n, s, a) {
            var o = !0 !== a;
            return r.warnOnce("Accessing UI is deprecated. Call '" + e + "' on the instance directly. Please comment in issue 1073 as to your need to call this method."), t[e](i, {
                message: n,
                assert: s,
                updateClass: o
            })
        }
    }), !1 !== window.ParsleyConfig.autoBind && t(function() {
        t("[data-parsley-validate]").length && t("[data-parsley-validate]").parsley()
    });
    var A = t({}),
        x = function() {
            r.warnOnce("Parsley's pubsub module is deprecated; use the 'on' and 'off' methods on parsley instances or window.Parsley")
        };

    function $(t, e) {
        return t.parsleyAdaptedCallback || (t.parsleyAdaptedCallback = function() {
            var i = Array.prototype.slice.call(arguments, 0);
            i.unshift(this), t.apply(e || A, i)
        }), t.parsleyAdaptedCallback
    }
    var P = "parsley:";

    function V(t) {
        return 0 === t.lastIndexOf(P, 0) ? t.substr(P.length) : t
    }
    return t.listen = function(t, e) {
        var i;
        if (x(), "object" == typeof arguments[1] && "function" == typeof arguments[2] && (i = arguments[1], e = arguments[2]), "function" != typeof e) throw new Error("Wrong parameters");
        window.Parsley.on(V(t), $(e, i))
    }, t.listenTo = function(t, e, i) {
        if (x(), !(t instanceof _ || t instanceof f)) throw new Error("Must give Parsley instance");
        if ("string" != typeof e || "function" != typeof i) throw new Error("Wrong parameters");
        t.on(V(e), $(i))
    }, t.unsubscribe = function(t, e) {
        if (x(), "string" != typeof t || "function" != typeof e) throw new Error("Wrong arguments");
        window.Parsley.off(V(t), e.parsleyAdaptedCallback)
    }, t.unsubscribeTo = function(t, e) {
        if (x(), !(t instanceof _ || t instanceof f)) throw new Error("Must give Parsley instance");
        t.off(V(e))
    }, t.unsubscribeAll = function(e) {
        x(), window.Parsley.off(V(e)), t("form,input,textarea,select").each(function() {
            var i = t(this).data("Parsley");
            i && i.off(V(e))
        })
    }, t.emit = function(t, e) {
        var i;
        x();
        var n = e instanceof _ || e instanceof f,
            r = Array.prototype.slice.call(arguments, n ? 2 : 1);
        r.unshift(V(t)), n || (e = window.Parsley), (i = e).trigger.apply(i, _toConsumableArray(r))
    }, t.extend(!0, C, {
        asyncValidators: {
            default: {
                fn: function(t) {
                    return t.status >= 200 && t.status < 300
                },
                url: !1
            },
            reverse: {
                fn: function(t) {
                    return t.status < 200 || t.status >= 300
                },
                url: !1
            }
        },
        addAsyncValidator: function(t, e, i, n) {
            return C.asyncValidators[t] = {
                fn: e,
                url: i || !1,
                options: n || {}
            }, this
        }
    }), C.addValidator("remote", {
        requirementType: {
            "": "string",
            validator: "string",
            reverse: "boolean",
            options: "object"
        },
        validateString: function(e, i, n, r) {
            var s, a, o = {},
                l = n.validator || (!0 === n.reverse ? "reverse" : "default");
            if (void 0 === C.asyncValidators[l]) throw new Error("Calling an undefined async validator: `" + l + "`");
            (i = C.asyncValidators[l].url || i).indexOf("{value}") > -1 ? i = i.replace("{value}", encodeURIComponent(e)) : o[r.element.getAttribute("name") || r.element.getAttribute("id")] = e;
            var u = t.extend(!0, n.options || {}, C.asyncValidators[l].options);
            s = t.extend(!0, {}, {
                url: i,
                data: o,
                type: "GET"
            }, u), r.trigger("field:ajaxoptions", r, s), a = t.param(s), void 0 === C._remoteCache && (C._remoteCache = {});
            var d = C._remoteCache[a] = C._remoteCache[a] || t.ajax(s),
                h = function() {
                    var e = C.asyncValidators[l].fn.call(r, d, i, n);
                    return e || (e = t.Deferred().reject()), t.when(e)
                };
            return d.then(h, h)
        },
        priority: -1
    }), C.on("form:submit", function() {
        C._remoteCache = {}
    }), a.prototype.addAsyncValidator = function() {
        return r.warnOnce("Accessing the method `addAsyncValidator` through an instance is deprecated. Simply call `Parsley.addAsyncValidator(...)`"), C.addAsyncValidator.apply(C, arguments)
    }, C.addMessages("en", {
        defaultMessage: "This value seems to be invalid.",
        type: {
            email: "This value should be a valid email.",
            url: "This value should be a valid url.",
            number: "This value should be a valid number.",
            integer: "This value should be a valid integer.",
            digits: "This value should be digits.",
            alphanum: "This value should be alphanumeric."
        },
        notblank: "This value should not be blank.",
        required: "This value is required.",
        pattern: "This value seems to be invalid.",
        min: "This value should be greater than or equal to %s.",
        max: "This value should be lower than or equal to %s.",
        range: "This value should be between %s and %s.",
        minlength: "This value is too short. It should have %s characters or more.",
        maxlength: "This value is too long. It should have %s characters or fewer.",
        length: "This value length is invalid. It should be between %s and %s characters long.",
        mincheck: "You must select at least %s choices.",
        maxcheck: "You must select %s choices or fewer.",
        check: "You must select between %s and %s choices.",
        equalto: "This value should be the same."
    }), C.setLocale("en"), (new function() {
        var e = this,
            i = window || global;
        _extends(this, {
            isNativeEvent: function(t) {
                return t.originalEvent && !1 !== t.originalEvent.isTrusted
            },
            fakeInputEvent: function(i) {
                e.isNativeEvent(i) && t(i.target).trigger("input")
            },
            misbehaves: function(i) {
                e.isNativeEvent(i) && (e.behavesOk(i), t(document).on("change.inputevent", i.data.selector, e.fakeInputEvent), e.fakeInputEvent(i))
            },
            behavesOk: function(i) {
                e.isNativeEvent(i) && t(document).off("input.inputevent", i.data.selector, e.behavesOk).off("change.inputevent", i.data.selector, e.misbehaves)
            },
            install: function() {
                if (!i.inputEventPatched) {
                    i.inputEventPatched = "0.0.3";
                    for (var n = ["select", 'input[type="checkbox"]', 'input[type="radio"]', 'input[type="file"]'], r = 0; r < n.length; r++) {
                        var s = n[r];
                        t(document).on("input.inputevent", s, {
                            selector: s
                        }, e.behavesOk).on("change.inputevent", s, {
                            selector: s
                        }, e.misbehaves)
                    }
                }
            },
            uninstall: function() {
                delete i.inputEventPatched, t(document).off(".inputevent")
            }
        })
    }).install(), C
});
Parsley.addMessages("sr", {
    defaultMessage: "Uneta vrednost nije validna.",
    type: {
        email: "Email adresa nije validna.",
        url: "Url adresa nije validna.",
        number: "Unesite numeričku vrednost.",
        integer: "Unesite ceo broj bez decimala.",
        digits: "Unesite samo brojeve.",
        alphanum: "Unesite samo alfanumeričke znake (slova i brojeve)."
    },
    notblank: "Ovo polje ne sme biti prazno.",
    required: "Ovo polje je obavezno.",
    pattern: "Uneta vrednost nije validna.",
    min: "Vrednost mora biti veća ili jednaka %s.",
    max: "Vrednost mora biti manja ili jednaka %s.",
    range: "Vrednost mora biti između %s i %s.",
    minlength: "Unos je prekratak. Mora imati najmanje %s znakova.",
    maxlength: "Unos je predug. Može imati najviše %s znakova.",
    length: "Dužina unosa je pogrešna. Broj znakova mora biti između %s i %s.",
    mincheck: "Morate izabrati minimalno %s opcija.",
    maxcheck: "Možete izabrati najviše %s opcija.",
    check: "Broj izabranih opcija mora biti između %s i %s.",
    equalto: "Lozinke nisu iste.",
    remote: "Uneta vrednost se već nalazi u bazi. Upišite drugu vrednost."
}), Parsley.setLocale("sr");

function checkIfUserIsLoggedIn() {
    $.ajax({
        url: "/profil/check_if_user_is_logged_in",
        type: "POST",
        datatype: "json",
        success: function(e) {
            if (!0 === (e = JSON.parse(e)).half_registered) $("[data-remodal-id=register-modal-social]").remodal().open();
            else if (void 0 !== e.reset_password_code && !1 !== e.reset_password_code) {
                !1 === e.user_old && ($(".user-old").remove(), $(".user-old-text").text("Unesite novu lozinku")), $("[data-remodal-id=forget-password-form]").remodal().open()
            }!1 === e.half_registered && !1 !== e.username ? ($(".user-profile-link").addClass("logged"), $("#if-user-is-logged-in").show(), $("#if-user-not-logged-in").hide()) : ($(".user-profile-link").removeClass("logged"), $("#if-user-is-logged-in").hide(), $("#if-user-not-logged-in").show())
        },
        error: function(e, r, o) {
            $("#error-message").text(e.responseText)
        }
    })
}

function checkUserPreviousScrollPosition() {
    var e = getCookie("scroll_to_element");
    if ("" !== e && null !== e && "undefined" !== e) {
        var r = $("div[data-id='" + e + "']");
        r.length ? $(window).load(function() {
            $("html, body").animate({
                scrollTop: r.offset().top
            }, 1), r.find(".com_reply").click(), r.find("#com_text").focus(), $.cookie("scroll_to_element", null, {
                path: "/"
            })
        }) : $.cookie("scroll_to_element", null, {
            path: "/"
        })
    }
}

function checkStrength(e) {
    var r = 0;
    return e.length < 6 ? ($(".result").attr("class", "result").addClass("short"), "Lozinka je previše kratka") : (e.length > 7 && (r += 1), e.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/) && (r += 1), e.match(/([a-zA-Z])/) && e.match(/([0-9])/) && (r += 1), e.match(/([!,%,&,@,#,$,^,*,?,_,~])/) && (r += 1), e.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/) && (r += 1), r < 2 ? ($(".result").attr("class", "result").addClass("weak"), "Vaša lozinka ima slabu sigurnost.") : 2 == r ? ($(".result").attr("class", "result").addClass("good"), "Vaša lozinka ima dobru sigurnost.") : ($(".result").attr("class", "result").addClass("strong"), "Vaša lozinka ima jaku sigurnost."))
}

function addendLoader() {
    $(".remodal").prepend(loader)
}

function removeLoader() {
    $(".loader-wrapper").remove()
}

function setCookie(e, r, o) {
    var a = new Date;
    a.setTime(a.getTime() + 24 * o * 60 * 60 * 1e3);
    var s = "expires=" + a.toUTCString();
    document.cookie = e + "=" + r + ";" + s + ";path=/"
}

function checkCookie() {
    var e = getCookie("username");
    "" != e ? alert("Welcome again " + e) : "" != (e = prompt("Please enter your name:", "")) && null != e && setCookie("username", e, 365)
}

function getCookie(e) {
    for (var r = e + "=", o = decodeURIComponent(document.cookie).split(";"), a = 0; a < o.length; a++) {
        for (var s = o[a];
            " " == s.charAt(0);) s = s.substring(1);
        if (0 == s.indexOf(r)) return s.substring(r.length, s.length)
    }
    return ""
}

function openLoginModal() {
    $("[data-remodal-id=login-modal]").find(".remodalHeader h2").html("Prijavi se"), $("[data-remodal-id=login-modal]").remodal().open()
}

function logOut() {
    $.ajax({
        url: "/profil/logout",
        type: "POST",
        data: {},
        datatype: "json",
        success: function(e) {},
        error: function(e, r, o) {}
    })
}

function resetAllValidationFields() {
    $("#user_profile_form").parsley()
}

function userProfile() {
    if ("" !== getCookie("login_cookie").replace("+", " ")) window.location.href = "/profil";
    else if (window.Parsley) {
        $("[data-remodal-id=login-modal]").find(".remodalHeader h2").html("Prijavi se"), $("[data-remodal-id=login-modal]").remodal({
            hashTracking: !1,
            closeOnOutsideClick: !1,
            closeOnConfirm: !1
        }).open()
    }
}

function openRegisterModal() {
    $("[data-remodal-id=register-modal]").remodal({
        hashTracking: !1,
        closeOnOutsideClick: !1,
        closeOnConfirm: !1
    }).open()
}

function showErrorMessage(e) {
    $(".error-message").text(e).css("display", "inline-block")
}

function hideErrorMessage() {
    $(".error-message").text(text).css("display", "none")
}
loader = '<div class="loader-wrapper">\n    <div class="loader"></div>\n</div>', window.Parsley.addValidator("maxFileSize", {
    validateString: function(e, r, o) {
        if (!window.FormData) return alert("You are making all developpers in the world cringe. Upgrade your browser!"), !0;
        var a = o.$element[0].files;
        return 1 != a.length || a[0].size <= 1024 * r
    },
    requirementType: "integer",
    messages: {
        sr: "fajl ne sme da bude veći od %s Kb"
    }
}), $(document).ajaxStop(function() {
    checkUserPreviousScrollPosition()
}), $(function() {
    ($(".username-validation").bind("keyup blur", function() {
        var e = $(this);
        e.val(e.val().replace(/[^\.a-zA-Z0-9_-]/g, ""))
    }), checkIfUserIsLoggedIn(), resetAllValidationFields(), $(".facebook_login a").unbind("click").click(function(e) {
        return e.preventDefault(), $("#facebook_login_form").attr("action", $(this).attr("data-action")), $("#facebook_login_form").submit(), !1
    }), $("#login-button").click(function() {
        if (!0 === $("#login_form").parsley().validate()) {
            var e = $("#login_email").val(),
                r = $("#login_password").val();
            addendLoader(), $.ajax({
                url: "/profil/login",
                type: "POST",
                data: {
                    email: e,
                    password: r
                },
                datatype: "json",
                success: function(e) {
                    $(".loader-wrapper").remove(), $(".error-message").text("").hide(), location.reload(!0)
                },
                error: function(e, r, o) {
                    $(".loader-wrapper").remove(), showErrorMessage(e.responseText)
                }
            })
        }
    }), $("#login_form").keypress(function(e) {
        13 == e.which && $("#login-button").click()
    }), $("#register-button").click(function() {
        if (!0 === $("#register_form").parsley().validate()) {
            var e = $("#register_email").val(),
                r = $("#register_username").val(),
                o = $("#register_password").val(),
                a = $("#register_confirm_password").val(),
                s = $("#register_newsletter_digest").is(":checked") ? 1 : 0,
                t = $("#register_newsletter_digest").is(":checked") ? 1 : 0,
                i = $("#register_terms_and_conditions").is(":checked") ? 1 : 0;
            addendLoader(), $.ajax({
                url: "/profil/register",
                type: "POST",
                data: {
                    email: e,
                    username: r,
                    password: o,
                    confirm_password: a,
                    newsletter: s,
                    digest: t,
                    terms_and_conditions: i
                },
                datatype: "json",
                success: function(e) {
                    removeLoader(), $("[data-remodal-id=activation-mail-info]").remodal().open()
                },
                error: function(e, r, o) {
                    removeLoader(), showErrorMessage(e.responseText)
                }
            })
        }
    }), $("#register_form").keypress(function(e) {
        13 == e.which && $("#register-button").click()
    }), $("#register-button-social").unbind("click").click(function() {
        if (!0 === $("#register_form_social").parsley().validate()) {
            var e = $("#register_username_social").val(),
                r = $("#register_newsletter_digest_social").is(":checked") ? 1 : 0,
                o = $("#register_newsletter_digest_social").is(":checked") ? 1 : 0,
                a = $("#register_terms_and_conditions_social").is(":checked") ? 1 : 0;
            addendLoader(), $.ajax({
                url: "/profil/register-facebook",
                type: "POST",
                data: {
                    username: e,
                    newsletter: r,
                    digest: o,
                    terms_and_conditions: a
                },
                datatype: "json",
                success: function(e) {
                    removeLoader(), $("[data-remodal-id=register-info-modal]").remodal().open(), checkIfUserIsLoggedIn()
                },
                error: function(e, r, o) {
                    removeLoader(), showErrorMessage(e.responseText)
                }
            })
        }
    }), $("#register_form_social").keypress(function(e) {
        13 == e.which && $("#register-button-social").click()
    }), $("#register-cancel-button-social").click(function() {
        $.ajax({
            url: "/profil/logout",
            type: "POST",
            datatype: "json",
            success: function(e) {
                location.reload(!0)
            },
            error: function(e, r, o) {}
        })
    }), $("#forget-password-email-button").click(function() {
        if (!0 === $("#forget_password_form_email").parsley().validate()) {
            var e = $("#forget_password_email").val();
            addendLoader(), $.ajax({
                url: "/profil/lozinka/reset_password_email",
                type: "POST",
                data: {
                    email: e
                },
                datatype: "json",
                success: function(e) {
                    removeLoader(), $("[data-remodal-id=forget-password-info]").remodal().open()
                },
                error: function(e, r, o) {
                    removeLoader(), showErrorMessage(e.responseText)
                }
            })
        }
    }), $("#forget_password_form_email").keypress(function(e) {
        13 == e.which && $("#forget-password-email-button").click()
    }), $("#forget-password-form-button").click(function() {
        var e = $("#forget-password-form");
        if (!0 === e.parsley().validate()) {
            var r = new FormData(e[0]);
            addendLoader(), $.ajax({
                url: "/profil/lozinka/password_reset",
                type: "POST",
                data: r,
                cache: !1,
                processData: !1,
                contentType: !1,
                success: function(e) {
                    removeLoader(), $("[data-remodal-id=forget-password-info-modal]").remodal().open()
                },
                error: function(e, r, o) {
                    removeLoader(), showErrorMessage(e.responseText)
                }
            })
        }
    }), $("#forget-password-form").keypress(function(e) {
        13 == e.which && $("#forget-password-form-button").click()
    }), $("#resend-activation-email-form-button").click(function() {
        if (!0 === $("#resend_activation_email_form").parsley().validate()) {
            var e = $("#resend_activation_email_form_email").val();
            addendLoader(), $.ajax({
                url: "/profil/resend_activation_email",
                type: "POST",
                data: {
                    email: e
                },
                datatype: "json",
                success: function(e) {
                    removeLoader(), $("[data-remodal-id=activation-mail-info]").remodal().open()
                },
                error: function(e, r, o) {
                    removeLoader(), showErrorMessage(e.responseText)
                }
            })
        }
    }), $("#resend_activation_email_form").keypress(function(e) {
        13 == e.which && $("#resend-activation-email-form-button").click()
    }), $("#register_password").keyup(function() {
        $(".resultText").html(checkStrength($("#register_password").val())), $(".resultBar").show()
    }), $("#forget_password_form_password").keyup(function() {
        $(".resultText").html(checkStrength($("#forget_password_form_password").val())), $(".resultBar").show()
    }), $("#user_profile_password").keyup(function() {
        $(".resultText").html(checkStrength($("#user_profile_password").val())), $(".resultBar").show()
    }), $.cookie("thank_you_for_registering_modal")) && ($("[data-remodal-id=register-info-modal]").remodal().open(), $.cookie("thank_you_for_registering_modal", null, {
        path: "/"
    }));
    $(document).on("opening", ".remodal", function(e) {
        $("#login_form").parsley().reset(), $("#register_email").parsley().reset(), $("#register_username").parsley().reset(), $("#register_username_social").parsley().reset(), $("#register_password").parsley().reset(), $("#register_confirm_password").parsley().reset(), $("#forget_password_email").parsley().reset(), $("#forget_password_form_password").parsley().reset(), $("#forget_password_form_password_confirm_password").parsley().reset(), $("#resend_activation_email_form_email").parsley().reset(), $(".resultText").empty(), $(".resultBar").hide(), $(".error-message").text("").hide(), $(this).find("input:not(:checkbox)").each(function(e) {
            "register_username_social" !== $(this).attr("id") && "hidden" !== $(this).attr("type") && "radio" !== $(this).attr("type") && $(this).val("")
        })
    }), $(document).on("closing", ".thank-you", function(e) {
        checkIfUserIsLoggedIn()
    })
}), $("a.user-profile-link").click(function(e) {
    e.preventDefault()
});

function uploadAvatar() {
    $("#user_profile_avatar").click()
}

function getUrlVars() {
    for (var e, r = [], s = window.location.href.slice(window.location.href.indexOf("?") + 1).split("&"), o = 0; o < s.length; o++) e = s[o].split("="), r.push(e[0]), r[e[0]] = e[1];
    return r
}
finishLoding = !0, $(document).ready(function() {
    toastr.options = {
        positionClass: "toast-top-center"
    };
    $("#user_profile_avatar").on("change", function() {
        ! function(e) {
            if ($("#UAvatarWrap").addClass("uploading"), e.files && e.files[0]) {
                var r = $("#user_profile_form"),
                    s = new FormData(r[0]);
                s.append("api_key", getLoginCookie("api_key")), $.ajax({
                    url: login_server + "avatar-upload",
                    type: "POST",
                    data: s,
                    dataType: "json",
                    cache: !1,
                    processData: !1,
                    contentType: !1,
                    success: function(e) {
                        toastr.success(e.message), $("#avatar-image").attr("src", e.avatar + "?v=" + Math.floor(1e5 * Math.random())), $(".user-profile-link").html('<img src="' + e.avatar + "?v=" + Math.floor(1e5 * Math.random()) + '">'), $("#UAvatarWrap").removeClass("uploading")
                    },
                    error: function(e, r, s) {
                        toastr.error(e.responseJSON.errors.avatar[0]), $("#UAvatarWrap").removeClass("uploading")
                    }
                })
            }
        }(this)
    }), $("#save-user_profile-button").click(function(e) {
        if (!0 === $("#user_profile_form").parsley().validate()) {
            var r = $(this);
            r.prop("disabled", !0);
            var s = {
                first_name: $("#user_profile_first_name").val(),
                last_name: $("#user_profile_last_name").val(),
                newsletter: $("#user_profile_newsletter").is(":checked") ? 1 : 0,
                digest: $("#user_profile_digest").is(":checked") ? 1 : 0,
                comment_approve: $("#user_profile_comment_approve").is(":checked") ? 1 : 0,
                comment_reply: $("#user_profile_comment_reply").is(":checked") ? 1 : 0
            };
            s.api_key = getLoginCookie("api_key"), addendLoader(), $.ajax({
                url: login_server + "update",
                type: "POST",
                data: s,
                dataType: "json",
                success: function(e) {
                    toastr.success(e.message), r.prop("disabled", !1), $(".error-message").hide()
                },
                error: function(e, s, o) {
                    toastr.error(e.responseJSON.message), console.log("Error:"), console.log(s), console.log(o), console.log(e.responseText), r.prop("disabled", !1)
                }
            })
        }
    }), $("#save-subscriptions-button").click(function(e) {
        var r = $(this);
        if (r.prop("disabled", !0), !0 === $("#unsubscribe_form").parsley().validate()) {
            var s = {
                newsletter: $("#user_profile_newsletter").is(":checked") ? 1 : 0,
                digest: $("#user_profile_digest").is(":checked") ? 1 : 0,
                comment_approve: $("#user_profile_comment_approve").is(":checked") ? 1 : 0,
                comment_reply: $("#user_profile_comment_reply").is(":checked") ? 1 : 0,
                unsubscribe_code: getUrlVars().unsubscribe_code
            };
            $.ajax({
                url: login_server + "unsubscribe_email_list_update",
                type: "POST",
                data: s,
                dataType: "json",
                success: function(e) {
                    r.prop("disabled", !1), toastr.success(e.message), $(".error-message").hide()
                },
                error: function(e, s, o) {
                    r.prop("disabled", !1), toastr.error(e.responseJSON.message), console.log("Error:"), console.log(s), console.log(o), console.log(e.responseText)
                }
            })
        }
    }), $("#user_profile_password").keyup(function() {
        $(".resultText").html(checkStrength($("#user_profile_password").val())), $(".resultBar").show()
    }), $("#user-profile-password-form-button").click(function() {
        if (!0 === $("#user-profile-password-form").parsley().validate()) {
            var e = $(this);
            e.prop("disabled", !0);
            var r = $("#user_profile_password").val(),
                s = $("#user_profile_confirm_password").val();
            $.ajax({
                url: login_server + "update-password",
                type: "POST",
                data: {
                    password: r,
                    password_confirmation: s,
                    api_key: getLoginCookie("api_key")
                },
                dataType: "json",
                success: function(r) {
                    e.prop("disabled", !1), toastr.success(r.message)
                },
                error: function(r, s, o) {
                    e.prop("disabled", !1), toastr.error(r.responseJSON.message), console.log("Error:"), console.log(s), console.log(o), console.log(r.responseText)
                }
            })
        }
    }), $("[data-tab]").on("click", function(e) {
        $(this).addClass("selected").parent().siblings("li").children("[data-tab]").removeClass("selected"), $("[data-content]").hide(), $("[data-content=" + $(this).data("tab") + "]").show(), e.preventDefault()
    })
});
("function" == typeof define && define.amd ? define : function(e, t) {
    "undefined" != typeof module && module.exports ? module.exports = t(require("jquery")) : window.toastr = t(window.jQuery)
})(["jquery"], function(e) {
    return function() {
        function t(t, n) {
            return t || (t = i()), (r = e("#" + t.containerId)).length ? r : (n && (s = t, (r = e("<div/>").attr("id", s.containerId).addClass(s.positionClass)).appendTo(e(s.target)), r = r), r);
            var s
        }

        function n(t, n, s) {
            var o = !(!s || !s.force) && s.force;
            return !(!t || !o && 0 !== e(":focus", t).length || (t[n.hideMethod]({
                duration: n.hideDuration,
                easing: n.hideEasing,
                complete: function() {
                    a(t)
                }
            }), 0))
        }

        function s(e) {
            l && l(e)
        }

        function o(n) {
            function o(e) {
                return null == e && (e = ""), e.replace(/&/g, "&amp;").replace(/"/g, "&quot;").replace(/'/g, "&#39;").replace(/</g, "&lt;").replace(/>/g, "&gt;")
            }

            function l(t) {
                var n = t && !1 !== m.closeMethod ? m.closeMethod : m.hideMethod,
                    o = t && !1 !== m.closeDuration ? m.closeDuration : m.hideDuration,
                    i = t && !1 !== m.closeEasing ? m.closeEasing : m.hideEasing;
                if (!e(":focus", v).length || t) return clearTimeout(b.intervalId), v[n]({
                    duration: o,
                    easing: i,
                    complete: function() {
                        a(v), clearTimeout(h), m.onHidden && "hidden" !== D.state && m.onHidden(), D.state = "hidden", D.endTime = new Date, s(D)
                    }
                })
            }

            function u() {
                (m.timeOut > 0 || m.extendedTimeOut > 0) && (h = setTimeout(l, m.extendedTimeOut), b.maxHideTime = parseFloat(m.extendedTimeOut), b.hideEta = (new Date).getTime() + b.maxHideTime)
            }

            function p() {
                clearTimeout(h), b.hideEta = 0, v.stop(!0, !0)[m.showMethod]({
                    duration: m.showDuration,
                    easing: m.showEasing
                })
            }

            function g() {
                var e = (b.hideEta - (new Date).getTime()) / b.maxHideTime * 100;
                T.width(e + "%")
            }
            var m = i(),
                f = n.iconClass || m.iconClass;
            if (void 0 !== n.optionsOverride && (m = e.extend(m, n.optionsOverride), f = n.optionsOverride.iconClass || f), ! function(e, t) {
                    if (e.preventDuplicates) {
                        if (t.message === c) return !0;
                        c = t.message
                    }
                    return !1
                }(m, n)) {
                d++, r = t(m, !0);
                var h = null,
                    v = e("<div/>"),
                    C = e("<div/>"),
                    w = e("<div/>"),
                    T = e("<div/>"),
                    O = e(m.closeHtml),
                    b = {
                        intervalId: null,
                        hideEta: null,
                        maxHideTime: null
                    },
                    D = {
                        toastId: d,
                        state: "visible",
                        startTime: new Date,
                        options: m,
                        map: n
                    };
                return n.iconClass && v.addClass(m.toastClass).addClass(f),
                    function() {
                        if (n.title) {
                            var e = n.title;
                            m.escapeHtml && (e = o(n.title)), C.append(e).addClass(m.titleClass), v.append(C)
                        }
                    }(),
                    function() {
                        if (n.message) {
                            var e = n.message;
                            m.escapeHtml && (e = o(n.message)), w.append(e).addClass(m.messageClass), v.append(w)
                        }
                    }(), m.closeButton && (O.addClass(m.closeClass).attr("role", "button"), v.prepend(O)), m.progressBar && (T.addClass(m.progressClass), v.prepend(T)), m.rtl && v.addClass("rtl"), m.newestOnTop ? r.prepend(v) : r.append(v),
                    function() {
                        var e = "";
                        switch (n.iconClass) {
                            case "toast-success":
                            case "toast-info":
                                e = "polite";
                                break;
                            default:
                                e = "assertive"
                        }
                        v.attr("aria-live", e)
                    }(), v.hide(), v[m.showMethod]({
                        duration: m.showDuration,
                        easing: m.showEasing,
                        complete: m.onShown
                    }), m.timeOut > 0 && (h = setTimeout(l, m.timeOut), b.maxHideTime = parseFloat(m.timeOut), b.hideEta = (new Date).getTime() + b.maxHideTime, m.progressBar && (b.intervalId = setInterval(g, 10))), m.closeOnHover && v.hover(p, u), !m.onclick && m.tapToDismiss && v.click(l), m.closeButton && O && O.click(function(e) {
                        e.stopPropagation ? e.stopPropagation() : void 0 !== e.cancelBubble && !0 !== e.cancelBubble && (e.cancelBubble = !0), m.onCloseClick && m.onCloseClick(e), l(!0)
                    }), m.onclick && v.click(function(e) {
                        m.onclick(e), l()
                    }), s(D), m.debug && console && console.log(D), v
            }
        }

        function i() {
            return e.extend({}, {
                tapToDismiss: !0,
                toastClass: "toast",
                containerId: "toast-container",
                debug: !1,
                showMethod: "fadeIn",
                showDuration: 300,
                showEasing: "swing",
                onShown: void 0,
                hideMethod: "fadeOut",
                hideDuration: 1e3,
                hideEasing: "swing",
                onHidden: void 0,
                closeMethod: !1,
                closeDuration: !1,
                closeEasing: !1,
                closeOnHover: !0,
                extendedTimeOut: 1e3,
                iconClasses: {
                    error: "toast-error",
                    info: "toast-info",
                    success: "toast-success",
                    warning: "toast-warning"
                },
                iconClass: "toast-info",
                positionClass: "toast-top-right",
                timeOut: 5e3,
                titleClass: "toast-title",
                messageClass: "toast-message",
                escapeHtml: !1,
                target: "body",
                closeHtml: '<button type="button">&times;</button>',
                closeClass: "toast-close-button",
                newestOnTop: !0,
                preventDuplicates: !1,
                progressBar: !1,
                progressClass: "toast-progress",
                rtl: !1
            }, p.options)
        }

        function a(e) {
            r || (r = t()), e.is(":visible") || (e.remove(), e = null, 0 === r.children().length && (r.remove(), c = void 0))
        }
        var r, l, c, d = 0,
            u = {
                error: "error",
                info: "info",
                success: "success",
                warning: "warning"
            },
            p = {
                clear: function(s, o) {
                    var a = i();
                    r || t(a), n(s, a, o) || function(t) {
                        for (var s = r.children(), o = s.length - 1; o >= 0; o--) n(e(s[o]), t)
                    }(a)
                },
                remove: function(n) {
                    var s = i();
                    return r || t(s), n && 0 === e(":focus", n).length ? void a(n) : void(r.children().length && r.remove())
                },
                error: function(e, t, n) {
                    return o({
                        type: u.error,
                        iconClass: i().iconClasses.error,
                        message: e,
                        optionsOverride: n,
                        title: t
                    })
                },
                getContainer: t,
                info: function(e, t, n) {
                    return o({
                        type: u.info,
                        iconClass: i().iconClasses.info,
                        message: e,
                        optionsOverride: n,
                        title: t
                    })
                },
                options: {},
                subscribe: function(e) {
                    l = e
                },
                success: function(e, t, n) {
                    return o({
                        type: u.success,
                        iconClass: i().iconClasses.success,
                        message: e,
                        optionsOverride: n,
                        title: t
                    })
                },
                version: "2.1.3",
                warning: function(e, t, n) {
                    return o({
                        type: u.warning,
                        iconClass: i().iconClasses.warning,
                        message: e,
                        optionsOverride: n,
                        title: t
                    })
                }
            };
        return p
    }()
});

function removeHash() {
    var t, o, e = window.location;
    "replaceState" in history ? history.replaceState("", document.title, e.pathname + e.search) : (t = document.body.scrollTop, o = document.body.scrollLeft, e.hash = "", document.body.scrollTop = t, document.body.scrollLeft = o)
}
"#_=_" != location.hash && "#_=_" != location.href.slice(-1) || removeHash(), $(function() {
    $("#com_sort a").unbind("click").click(function() {
        return $("#com_sort a").removeClass("active"), $("#com_sort a").removeClass("asc"), $("#com_sort a").removeClass("desc"), $(this).addClass("active"), sort = $(this).attr("data-sort"), order = $(this).attr("data-order"), current_sort = $("#com_sort").attr("data-sort"), current_order = $("#com_sort").attr("data-order"), sort == current_sort && "" != order && ("asc" == current_order ? order = "desc" : order = "asc"), $("#com_sort").attr("data-sort", sort), $("#com_sort").attr("data-order", order), $(this).addClass(order), com_list(1, sort, order), !1
    })
});
var com_loading = !1;

function com_load_more() {
    page_max = $("#com_list").attr("data-page-max"), page = $("#com_list").attr("data-page"), sort = $("#com_sort").attr("data-sort"), order = $("#com_sort").attr("data-order"), page == page_max ? com_loading = !0 : (page++, $("#com_list").attr("data-page", page), com_list(page, sort, order, page_max))
}

function com_list(t, o, e, a) {
    return com_loading = !0, $("#com_more_loading").show(), 1 == t && (com_loading = !1), aid = $("#com_list").attr("data-id"), table = $("#com_list").attr("data-table"), commentId = $("#com_list").attr("data-comment-id"), $("#com_list").attr("data-page", t), $("#com_sort").attr("data-sort", o), $("#com_order").attr("data-order", e), $.ajax({
        type: "GET",
        url: "/ajax/comments/list",
        data: {
            aid: aid,
            table: table,
            page: t,
            sort: o,
            order: e,
            commentId: commentId
        },
        success: function(o) {
            $("#com_more_loading").hide(), 1 == t ? $("#com_list").html(o) : $("#com_list").append(o), com_form_init(), null != a && t != a && (com_loading = !1)
        },
        error: function(t, o) {
            $("#com_loading").hide(), console.log(o)
        }
    }), !1
}
$(function() {
    $("#com_more").length && $(window).scroll(function() {
        !com_loading && $(window).scrollTop() > $("#com_more").offset().top - $(window).height() - 300 && com_load_more()
    })
});
var antibot_id = 0,
    antibot_timeout = {};

function com_form_init() {
    $(".com_login a").unbind("click").click(function(t) {
        if ("old" == users_login) return t.preventDefault(), $("#com_login_form").attr("action", $(this).attr("data-action")), $("#com_login_form").submit(), !1;
        if (t.preventDefault(), "/profil/logout" != $(this).attr("data-action")) {
            var o = $(this).closest(".com_comment").attr("data-id");
            setCookie("scroll_to_element", o, 1), "openRegisterModal" == $(this).attr("data-action") ? openRegisterModal() : "openLoginModal" == $(this).attr("data-action") && openLoginModal()
        } else $("#com_login_form").attr("action", $(this).attr("data-action")), $("#com_login_form").submit();
        return !1
    }), $(".com_antibot").antibot(), $(".com_send").length && $(".com_send").unbind("click").click(function(t) {
        t.preventDefault();
        var o = $(this).closest(".com_form");
        return o.find(".com_send").attr("disabled", !0), o.find(".com_loading").show(), o.find(".com_message").hide().html(""), o.find(".com_error_message").hide().html(""), $.ajax({
            type: "POST",
            url: "/ajax/comments/save",
            dataType: "json",
            data: o.serialize(),
            success: function(t) {
                if (o.find(".com_send").attr("disabled", !1), o.find(".com_loading").hide(), "ok" == t.status)
                    if (o.find(".rid").length) {
                        var e = o.closest(".com_comment");
                        e.find(".com_message").html(t.message).show(), setTimeout(function() {
                            e.find(".com_message").hide().html("")
                        }, 5e3), com_close_reply(e), $("html, body").animate({
                            scrollTop: e.offset().top - 100
                        }, 200)
                    } else o.find("input[type=text], textarea").val(""), o.find(".com_text_charcount span").html("0/" + a), o.find(".com_message").html(t.message).show(), setTimeout(function() {
                        o.find(".com_message").hide().html("")
                    }, 5e3), com_reset_antibot(o);
                else o.find(".com_error_message").hide().html(t.error.join("<br/>")).slideDown(), com_reset_antibot(o)
            },
            error: function(t, e) {
                o.find(".com_send").attr("disabled", !1), o.find(".com_loading").hide(), com_reset_antibot(o), console.log(e)
            }
        }), !1
    }), $(".com_reply").unbind("click").click(function(t) {
        t.preventDefault();
        var o = $(this).closest(".com_comment");
        if ($(this).hasClass("active")) com_close_reply(o);
        else {
            if ($(this).addClass("active"), "0" == o.attr("data-rid")) var e = o.attr("data-id"),
                i = o.attr("data-id");
            else e = o.attr("data-rid"), i = o.attr("data-id");
            var r = $("<div />", {
                html: $("#com_form_container").html()
            });
            r.find(".com_antibot").replaceWith('<div class="com_antibot"></div>'), r.find(".com_form").append('<input type="hidden" class="rid" name="rid" value="' + e + '">'), r.find(".com_form").append('<input type="hidden" class="rrid" name="rrid" value="' + i + '">'), r.find(".com_loading").hide(), r.find(".com_message").hide().html(""), r.find(".com_error_message").hide().html(""), r.find(".com_text_charcount span").html("0/" + a), o.find(".com_reply_container").hide().html(r.html()).slideDown(200), o.find(".com_cancel").show().click(function(t) {
                t.preventDefault(), com_close_reply(o)
            }), com_form_init()
        }
    }), $(".com_vote").unbind("click").click(function(t) {
        var o = $(this).closest(".com_comment"),
            e = o.attr("data-id"),
            a = $("#com_list").attr("data-table"),
            i = $(this).hasClass("com_vote_p") ? "+" : "-";
        return o.find(".com_message").removeClass("error").html(""), o.find(".com_vote").attr("disabled", !0), dataPush(a + "_votes", 1 * e), $.ajax({
            type: "POST",
            url: "/ajax/comments/vote",
            dataType: "json",
            data: {
                cid: e,
                table: a,
                type: i
            },
            success: function(t) {
                "ok" == t.status ? (o.find(".com_message").html(t.message).fadeIn(200), o.find(".com_vote.com_vote_p span").html(t.vote_p), o.find(".com_vote.com_vote_n span").html(t.vote_n)) : o.find(".com_message").addClass("error").html(t.error.join(" ")).show(), setTimeout(function() {
                    o.find(".com_message").fadeOut(200, function() {
                        $(this).hide().html("")
                    })
                }, 5e3)
            },
            error: function(t, o) {
                console.log(o)
            }
        }), !1
    });
    var t = dataGet($("#com_list").attr("data-table") + "_votes");
    null != t && $(".com_comment").each(function() {
        id = 1 * $(this).attr("data-id"), -1 !== $.inArray(id, t) && $(this).find(".com_vote").attr("disabled", !0)
    });
    var o = $("[data-remodal-id=comment-report]").remodal();
    $(".com_report").unbind("click").click(function(t) {
        var e = $(this).closest(".com_comment");
        (e.find(".com_message").hide().removeClass("error").html(""), comment_report_reqire_login) ? "" !== getCookie("login_cookie").replace("+", " ") ? o.open() : openModal("login"): (o.open(), $("#comment_report_antibot").antibot());
        $("#comment_report_id").val(e.attr("data-id")), $("#comment_report_table").val($("#com_list").attr("data-table"))
    }), $("#comment_report_button").unbind("click").click(function() {
        var t = $("#komentar_" + $("#comment_report_id").val());
        $.ajax({
            type: "POST",
            url: "/ajax/comments/report",
            dataType: "json",
            data: $("#comment_report_form").serialize(),
            success: function(e) {
                "ok" == e.status ? (t.find(".com_message").html(e.message).show(), t.find(".com_report").attr("disabled", !0), dataPush($("#comment_report_table").val() + "_reports", 1 * $("#comment_report_id").val()), o.close()) : ($("[data-remodal-id=comment-report]").find(".error-message").html(e.error.join(" ")).show(), $("#comment_report_antibot").antibot()), setTimeout(function() {
                    t.find(".com_message").html("").hide()
                }, 5e3)
            },
            error: function(t, o) {
                console.log(o)
            }
        })
    });
    var e = dataGet($("#com_list").attr("data-table") + "_reports");
    null != e && $(".com_comment").each(function() {
        id = 1 * $(this).attr("data-id"), -1 !== $.inArray(id, e) && $(this).find(".com_report").attr("disabled", !0)
    });
    var a = $("#com_form_container").attr("data-maxchar");
    $(".com_text").keyup(function() {
        var t = $(this).val().length,
            o = $(this).closest(".com_form").find(".com_text_charcount span");
        t > a && ($(this).val($(this).val().substr(0, a)), t = a), o.html(t + "/" + a)
    })
}

function com_preview_init() {
    com_form_init(), get_tpl($("#com_form_tpl"))
}

function com_close_reply(t) {
    var o = t.find(".com_antibot").attr("data-id");
    void 0 !== o && !1 !== o && (clearTimeout(antibot_timeout[o]), delete antibot_timeout[o]), t.find(".com_reply_container").slideUp(200, function() {
        $(this).html("")
    }), t.find(".com_reply").removeClass("active")
}

function com_reset_antibot(t) {
    $(".com_antibot").each(function() {
        $(this).antibot()
    })
}

function dataSet(t, o) {
    "undefined" != typeof Storage && localStorage.setObj(t, o)
}

function dataPush(t, o) {
    "undefined" != typeof Storage && (localStorage[t] ? i = localStorage.getObj(t) : i = new Array, i.push(o), localStorage.setObj(t, i))
}

function dataGet(t) {
    return "undefined" != typeof Storage && localStorage.getObj(t)
}! function(t) {
    t.fn.antibot = function(o) {
        return o = t.extend({}, {
            callback: !1,
            reset: !1
        }, o), this.each(function() {
            var o = this,
                e = t(o).attr("data-id");
            void 0 !== e && !1 !== e ? clearTimeout(antibot_timeout[e]) : (e = antibot_id, t(o).attr("data-id", e), antibot_id++), t.ajax({
                type: "POST",
                url: "/ajax/antibot",
                dataType: "json",
                data: {
                    id: t("#com_list").attr("data-id")
                },
                success: function(a) {
                    "ok" == a.status ? (t(o).html(a.html), antibot_timeout[e] = setTimeout(function() {
                        t(o).antibot()
                    }, 59e4)) : t(o).html(a.error.join(" "))
                },
                error: function(t, o) {
                    console.log(o)
                }
            })
        })
    }
}(jQuery), "undefined" != typeof Storage && (Storage.prototype.setObj = function(t, o) {
    return this.setItem(t, JSON.stringify(o))
}, Storage.prototype.getObj = function(t) {
    return JSON.parse(this.getItem(t))
});
! function(i) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], i) : "undefined" != typeof exports ? module.exports = i(require("jquery")) : i(jQuery)
}(function(i) {
    "use strict";
    var e = window.Slick || {};
    (e = function() {
        var e = 0;
        return function(t, o) {
            var s, n = this;
            n.defaults = {
                accessibility: !0,
                adaptiveHeight: !1,
                appendArrows: i(t),
                appendDots: i(t),
                arrows: !0,
                asNavFor: null,
                prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>',
                nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>',
                autoplay: !1,
                autoplaySpeed: 3e3,
                centerMode: !1,
                centerPadding: "50px",
                cssEase: "ease",
                customPaging: function(i, e) {
                    return '<button type="button" data-role="none" role="button" aria-required="false" tabindex="0">' + (e + 1) + "</button>"
                },
                dots: !1,
                dotsClass: "slick-dots",
                draggable: !0,
                easing: "linear",
                edgeFriction: .35,
                fade: !1,
                focusOnSelect: !1,
                infinite: !0,
                initialSlide: 0,
                lazyLoad: "ondemand",
                mobileFirst: !1,
                pauseOnHover: !0,
                pauseOnDotsHover: !1,
                respondTo: "window",
                responsive: null,
                rows: 1,
                rtl: !1,
                slide: "",
                slidesPerRow: 1,
                slidesToShow: 1,
                slidesToScroll: 1,
                speed: 500,
                swipe: !0,
                swipeToSlide: !1,
                touchMove: !0,
                touchThreshold: 5,
                useCSS: !0,
                useTransform: !0,
                variableWidth: !1,
                vertical: !1,
                verticalSwiping: !1,
                waitForAnimate: !0,
                zIndex: 1e3
            }, n.initials = {
                animating: !1,
                dragging: !1,
                autoPlayTimer: null,
                currentDirection: 0,
                currentLeft: null,
                currentSlide: 0,
                direction: 1,
                $dots: null,
                listWidth: null,
                listHeight: null,
                loadIndex: 0,
                $nextArrow: null,
                $prevArrow: null,
                slideCount: null,
                slideWidth: null,
                $slideTrack: null,
                $slides: null,
                sliding: !1,
                slideOffset: 0,
                swipeLeft: null,
                $list: null,
                touchObject: {},
                transformsEnabled: !1,
                unslicked: !1
            }, i.extend(n, n.initials), n.activeBreakpoint = null, n.animType = null, n.animProp = null, n.breakpoints = [], n.breakpointSettings = [], n.cssTransitions = !1, n.hidden = "hidden", n.paused = !1, n.positionProp = null, n.respondTo = null, n.rowCount = 1, n.shouldClick = !0, n.$slider = i(t), n.$slidesCache = null, n.transformType = null, n.transitionType = null, n.visibilityChange = "visibilitychange", n.windowWidth = 0, n.windowTimer = null, s = i(t).data("slick") || {}, n.options = i.extend({}, n.defaults, s, o), n.currentSlide = n.options.initialSlide, n.originalSettings = n.options, void 0 !== document.mozHidden ? (n.hidden = "mozHidden", n.visibilityChange = "mozvisibilitychange") : void 0 !== document.webkitHidden && (n.hidden = "webkitHidden", n.visibilityChange = "webkitvisibilitychange"), n.autoPlay = i.proxy(n.autoPlay, n), n.autoPlayClear = i.proxy(n.autoPlayClear, n), n.changeSlide = i.proxy(n.changeSlide, n), n.clickHandler = i.proxy(n.clickHandler, n), n.selectHandler = i.proxy(n.selectHandler, n), n.setPosition = i.proxy(n.setPosition, n), n.swipeHandler = i.proxy(n.swipeHandler, n), n.dragHandler = i.proxy(n.dragHandler, n), n.keyHandler = i.proxy(n.keyHandler, n), n.autoPlayIterator = i.proxy(n.autoPlayIterator, n), n.instanceUid = e++, n.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/, n.registerBreakpoints(), n.init(!0), n.checkResponsive(!0)
        }
    }()).prototype.addSlide = e.prototype.slickAdd = function(e, t, o) {
        var s = this;
        if ("boolean" == typeof t) o = t, t = null;
        else if (0 > t || t >= s.slideCount) return !1;
        s.unload(), "number" == typeof t ? 0 === t && 0 === s.$slides.length ? i(e).appendTo(s.$slideTrack) : o ? i(e).insertBefore(s.$slides.eq(t)) : i(e).insertAfter(s.$slides.eq(t)) : !0 === o ? i(e).prependTo(s.$slideTrack) : i(e).appendTo(s.$slideTrack), s.$slides = s.$slideTrack.children(this.options.slide), s.$slideTrack.children(this.options.slide).detach(), s.$slideTrack.append(s.$slides), s.$slides.each(function(e, t) {
            i(t).attr("data-slick-index", e)
        }), s.$slidesCache = s.$slides, s.reinit()
    }, e.prototype.animateHeight = function() {
        var i = this;
        if (1 === i.options.slidesToShow && !0 === i.options.adaptiveHeight && !1 === i.options.vertical) {
            var e = i.$slides.eq(i.currentSlide).outerHeight(!0);
            i.$list.animate({
                height: e
            }, i.options.speed)
        }
    }, e.prototype.animateSlide = function(e, t) {
        var o = {},
            s = this;
        s.animateHeight(), !0 === s.options.rtl && !1 === s.options.vertical && (e = -e), !1 === s.transformsEnabled ? !1 === s.options.vertical ? s.$slideTrack.animate({
            left: e
        }, s.options.speed, s.options.easing, t) : s.$slideTrack.animate({
            top: e
        }, s.options.speed, s.options.easing, t) : !1 === s.cssTransitions ? (!0 === s.options.rtl && (s.currentLeft = -s.currentLeft), i({
            animStart: s.currentLeft
        }).animate({
            animStart: e
        }, {
            duration: s.options.speed,
            easing: s.options.easing,
            step: function(i) {
                i = Math.ceil(i), !1 === s.options.vertical ? (o[s.animType] = "translate(" + i + "px, 0px)", s.$slideTrack.css(o)) : (o[s.animType] = "translate(0px," + i + "px)", s.$slideTrack.css(o))
            },
            complete: function() {
                t && t.call()
            }
        })) : (s.applyTransition(), e = Math.ceil(e), !1 === s.options.vertical ? o[s.animType] = "translate3d(" + e + "px, 0px, 0px)" : o[s.animType] = "translate3d(0px," + e + "px, 0px)", s.$slideTrack.css(o), t && setTimeout(function() {
            s.disableTransition(), t.call()
        }, s.options.speed))
    }, e.prototype.asNavFor = function(e) {
        var t = this.options.asNavFor;
        t && null !== t && (t = i(t).not(this.$slider)), null !== t && "object" == typeof t && t.each(function() {
            var t = i(this).slick("getSlick");
            t.unslicked || t.slideHandler(e, !0)
        })
    }, e.prototype.applyTransition = function(i) {
        var e = this,
            t = {};
        !1 === e.options.fade ? t[e.transitionType] = e.transformType + " " + e.options.speed + "ms " + e.options.cssEase : t[e.transitionType] = "opacity " + e.options.speed + "ms " + e.options.cssEase, !1 === e.options.fade ? e.$slideTrack.css(t) : e.$slides.eq(i).css(t)
    }, e.prototype.autoPlay = function() {
        var i = this;
        i.autoPlayTimer && clearInterval(i.autoPlayTimer), i.slideCount > i.options.slidesToShow && !0 !== i.paused && (i.autoPlayTimer = setInterval(i.autoPlayIterator, i.options.autoplaySpeed))
    }, e.prototype.autoPlayClear = function() {
        this.autoPlayTimer && clearInterval(this.autoPlayTimer)
    }, e.prototype.autoPlayIterator = function() {
        var i = this;
        !1 === i.options.infinite ? 1 === i.direction ? (i.currentSlide + 1 === i.slideCount - 1 && (i.direction = 0), i.slideHandler(i.currentSlide + i.options.slidesToScroll)) : (i.currentSlide - 1 == 0 && (i.direction = 1), i.slideHandler(i.currentSlide - i.options.slidesToScroll)) : i.slideHandler(i.currentSlide + i.options.slidesToScroll)
    }, e.prototype.buildArrows = function() {
        var e = this;
        !0 === e.options.arrows && (e.$prevArrow = i(e.options.prevArrow).addClass("slick-arrow"), e.$nextArrow = i(e.options.nextArrow).addClass("slick-arrow"), e.slideCount > e.options.slidesToShow ? (e.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.prependTo(e.options.appendArrows), e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.appendTo(e.options.appendArrows), !0 !== e.options.infinite && e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : e.$prevArrow.add(e.$nextArrow).addClass("slick-hidden").attr({
            "aria-disabled": "true",
            tabindex: "-1"
        }))
    }, e.prototype.buildDots = function() {
        var e, t, o = this;
        if (!0 === o.options.dots && o.slideCount > o.options.slidesToShow) {
            for (t = '<ul class="' + o.options.dotsClass + '">', e = 0; e <= o.getDotCount(); e += 1) t += "<li>" + o.options.customPaging.call(this, o, e) + "</li>";
            t += "</ul>", o.$dots = i(t).appendTo(o.options.appendDots), o.$dots.find("li").first().addClass("slick-active").attr("aria-hidden", "false")
        }
    }, e.prototype.buildOut = function() {
        var e = this;
        e.$slides = e.$slider.children(e.options.slide + ":not(.slick-cloned)").addClass("slick-slide"), e.slideCount = e.$slides.length, e.$slides.each(function(e, t) {
            i(t).attr("data-slick-index", e).data("originalStyling", i(t).attr("style") || "")
        }), e.$slider.addClass("slick-slider"), e.$slideTrack = 0 === e.slideCount ? i('<div class="slick-track"/>').appendTo(e.$slider) : e.$slides.wrapAll('<div class="slick-track"/>').parent(), e.$list = e.$slideTrack.wrap('<div aria-live="polite" class="slick-list"/>').parent(), e.$slideTrack.css("opacity", 0), (!0 === e.options.centerMode || !0 === e.options.swipeToSlide) && (e.options.slidesToScroll = 1), i("img[data-lazy]", e.$slider).not("[src]").addClass("slick-loading"), e.setupInfinite(), e.buildArrows(), e.buildDots(), e.updateDots(), e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0), !0 === e.options.draggable && e.$list.addClass("draggable")
    }, e.prototype.buildRows = function() {
        var i, e, t, o, s, n, l, r = this;
        if (o = document.createDocumentFragment(), n = r.$slider.children(), r.options.rows > 1) {
            for (l = r.options.slidesPerRow * r.options.rows, s = Math.ceil(n.length / l), i = 0; s > i; i++) {
                var a = document.createElement("div");
                for (e = 0; e < r.options.rows; e++) {
                    var d = document.createElement("div");
                    for (t = 0; t < r.options.slidesPerRow; t++) {
                        var c = i * l + (e * r.options.slidesPerRow + t);
                        n.get(c) && d.appendChild(n.get(c))
                    }
                    a.appendChild(d)
                }
                o.appendChild(a)
            }
            r.$slider.html(o), r.$slider.children().children().children().css({
                width: 100 / r.options.slidesPerRow + "%",
                display: "inline-block"
            })
        }
    }, e.prototype.checkResponsive = function(e, t) {
        var o, s, n, l = this,
            r = !1,
            a = l.$slider.width(),
            d = window.innerWidth || i(window).width();
        if ("window" === l.respondTo ? n = d : "slider" === l.respondTo ? n = a : "min" === l.respondTo && (n = Math.min(d, a)), l.options.responsive && l.options.responsive.length && null !== l.options.responsive) {
            for (o in s = null, l.breakpoints) l.breakpoints.hasOwnProperty(o) && (!1 === l.originalSettings.mobileFirst ? n < l.breakpoints[o] && (s = l.breakpoints[o]) : n > l.breakpoints[o] && (s = l.breakpoints[o]));
            null !== s ? null !== l.activeBreakpoint ? (s !== l.activeBreakpoint || t) && (l.activeBreakpoint = s, "unslick" === l.breakpointSettings[s] ? l.unslick(s) : (l.options = i.extend({}, l.originalSettings, l.breakpointSettings[s]), !0 === e && (l.currentSlide = l.options.initialSlide), l.refresh(e)), r = s) : (l.activeBreakpoint = s, "unslick" === l.breakpointSettings[s] ? l.unslick(s) : (l.options = i.extend({}, l.originalSettings, l.breakpointSettings[s]), !0 === e && (l.currentSlide = l.options.initialSlide), l.refresh(e)), r = s) : null !== l.activeBreakpoint && (l.activeBreakpoint = null, l.options = l.originalSettings, !0 === e && (l.currentSlide = l.options.initialSlide), l.refresh(e), r = s), e || !1 === r || l.$slider.trigger("breakpoint", [l, r])
        }
    }, e.prototype.changeSlide = function(e, t) {
        var o, s, n = this,
            l = i(e.target);
        switch (l.is("a") && e.preventDefault(), l.is("li") || (l = l.closest("li")), o = n.slideCount % n.options.slidesToScroll != 0 ? 0 : (n.slideCount - n.currentSlide) % n.options.slidesToScroll, e.data.message) {
            case "previous":
                s = 0 === o ? n.options.slidesToScroll : n.options.slidesToShow - o, n.slideCount > n.options.slidesToShow && n.slideHandler(n.currentSlide - s, !1, t);
                break;
            case "next":
                s = 0 === o ? n.options.slidesToScroll : o, n.slideCount > n.options.slidesToShow && n.slideHandler(n.currentSlide + s, !1, t);
                break;
            case "index":
                var r = 0 === e.data.index ? 0 : e.data.index || l.index() * n.options.slidesToScroll;
                n.slideHandler(n.checkNavigable(r), !1, t), l.children().trigger("focus");
                break;
            default:
                return
        }
    }, e.prototype.checkNavigable = function(i) {
        var e, t;
        if (t = 0, i > (e = this.getNavigableIndexes())[e.length - 1]) i = e[e.length - 1];
        else
            for (var o in e) {
                if (i < e[o]) {
                    i = t;
                    break
                }
                t = e[o]
            }
        return i
    }, e.prototype.cleanUpEvents = function() {
        var e = this;
        e.options.dots && null !== e.$dots && (i("li", e.$dots).off("click.slick", e.changeSlide), !0 === e.options.pauseOnDotsHover && !0 === e.options.autoplay && i("li", e.$dots).off("mouseenter.slick", i.proxy(e.setPaused, e, !0)).off("mouseleave.slick", i.proxy(e.setPaused, e, !1))), !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && (e.$prevArrow && e.$prevArrow.off("click.slick", e.changeSlide), e.$nextArrow && e.$nextArrow.off("click.slick", e.changeSlide)), e.$list.off("touchstart.slick mousedown.slick", e.swipeHandler), e.$list.off("touchmove.slick mousemove.slick", e.swipeHandler), e.$list.off("touchend.slick mouseup.slick", e.swipeHandler), e.$list.off("touchcancel.slick mouseleave.slick", e.swipeHandler), e.$list.off("click.slick", e.clickHandler), i(document).off(e.visibilityChange, e.visibility), e.$list.off("mouseenter.slick", i.proxy(e.setPaused, e, !0)), e.$list.off("mouseleave.slick", i.proxy(e.setPaused, e, !1)), !0 === e.options.accessibility && e.$list.off("keydown.slick", e.keyHandler), !0 === e.options.focusOnSelect && i(e.$slideTrack).children().off("click.slick", e.selectHandler), i(window).off("orientationchange.slick.slick-" + e.instanceUid, e.orientationChange), i(window).off("resize.slick.slick-" + e.instanceUid, e.resize), i("[draggable!=true]", e.$slideTrack).off("dragstart", e.preventDefault), i(window).off("load.slick.slick-" + e.instanceUid, e.setPosition), i(document).off("ready.slick.slick-" + e.instanceUid, e.setPosition)
    }, e.prototype.cleanUpRows = function() {
        var i;
        this.options.rows > 1 && ((i = this.$slides.children().children()).removeAttr("style"), this.$slider.html(i))
    }, e.prototype.clickHandler = function(i) {
        !1 === this.shouldClick && (i.stopImmediatePropagation(), i.stopPropagation(), i.preventDefault())
    }, e.prototype.destroy = function(e) {
        var t = this;
        t.autoPlayClear(), t.touchObject = {}, t.cleanUpEvents(), i(".slick-cloned", t.$slider).detach(), t.$dots && t.$dots.remove(), t.$prevArrow && t.$prevArrow.length && (t.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.prevArrow) && t.$prevArrow.remove()), t.$nextArrow && t.$nextArrow.length && (t.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.nextArrow) && t.$nextArrow.remove()), t.$slides && (t.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function() {
            i(this).attr("style", i(this).data("originalStyling"))
        }), t.$slideTrack.children(this.options.slide).detach(), t.$slideTrack.detach(), t.$list.detach(), t.$slider.append(t.$slides)), t.cleanUpRows(), t.$slider.removeClass("slick-slider"), t.$slider.removeClass("slick-initialized"), t.unslicked = !0, e || t.$slider.trigger("destroy", [t])
    }, e.prototype.disableTransition = function(i) {
        var e = {};
        e[this.transitionType] = "", !1 === this.options.fade ? this.$slideTrack.css(e) : this.$slides.eq(i).css(e)
    }, e.prototype.fadeSlide = function(i, e) {
        var t = this;
        !1 === t.cssTransitions ? (t.$slides.eq(i).css({
            zIndex: t.options.zIndex
        }), t.$slides.eq(i).animate({
            opacity: 1
        }, t.options.speed, t.options.easing, e)) : (t.applyTransition(i), t.$slides.eq(i).css({
            opacity: 1,
            zIndex: t.options.zIndex
        }), e && setTimeout(function() {
            t.disableTransition(i), e.call()
        }, t.options.speed))
    }, e.prototype.fadeSlideOut = function(i) {
        var e = this;
        !1 === e.cssTransitions ? e.$slides.eq(i).animate({
            opacity: 0,
            zIndex: e.options.zIndex - 2
        }, e.options.speed, e.options.easing) : (e.applyTransition(i), e.$slides.eq(i).css({
            opacity: 0,
            zIndex: e.options.zIndex - 2
        }))
    }, e.prototype.filterSlides = e.prototype.slickFilter = function(i) {
        var e = this;
        null !== i && (e.$slidesCache = e.$slides, e.unload(), e.$slideTrack.children(this.options.slide).detach(), e.$slidesCache.filter(i).appendTo(e.$slideTrack), e.reinit())
    }, e.prototype.getCurrent = e.prototype.slickCurrentSlide = function() {
        return this.currentSlide
    }, e.prototype.getDotCount = function() {
        var i = this,
            e = 0,
            t = 0,
            o = 0;
        if (!0 === i.options.infinite)
            for (; e < i.slideCount;) ++o, e = t + i.options.slidesToScroll, t += i.options.slidesToScroll <= i.options.slidesToShow ? i.options.slidesToScroll : i.options.slidesToShow;
        else if (!0 === i.options.centerMode) o = i.slideCount;
        else
            for (; e < i.slideCount;) ++o, e = t + i.options.slidesToScroll, t += i.options.slidesToScroll <= i.options.slidesToShow ? i.options.slidesToScroll : i.options.slidesToShow;
        return o - 1
    }, e.prototype.getLeft = function(i) {
        var e, t, o, s = this,
            n = 0;
        return s.slideOffset = 0, t = s.$slides.first().outerHeight(!0), !0 === s.options.infinite ? (s.slideCount > s.options.slidesToShow && (s.slideOffset = s.slideWidth * s.options.slidesToShow * -1, n = t * s.options.slidesToShow * -1), s.slideCount % s.options.slidesToScroll != 0 && i + s.options.slidesToScroll > s.slideCount && s.slideCount > s.options.slidesToShow && (i > s.slideCount ? (s.slideOffset = (s.options.slidesToShow - (i - s.slideCount)) * s.slideWidth * -1, n = (s.options.slidesToShow - (i - s.slideCount)) * t * -1) : (s.slideOffset = s.slideCount % s.options.slidesToScroll * s.slideWidth * -1, n = s.slideCount % s.options.slidesToScroll * t * -1))) : i + s.options.slidesToShow > s.slideCount && (s.slideOffset = (i + s.options.slidesToShow - s.slideCount) * s.slideWidth, n = (i + s.options.slidesToShow - s.slideCount) * t), s.slideCount <= s.options.slidesToShow && (s.slideOffset = 0, n = 0), !0 === s.options.centerMode && !0 === s.options.infinite ? s.slideOffset += s.slideWidth * Math.floor(s.options.slidesToShow / 2) - s.slideWidth : !0 === s.options.centerMode && (s.slideOffset = 0, s.slideOffset += s.slideWidth * Math.floor(s.options.slidesToShow / 2)), e = !1 === s.options.vertical ? i * s.slideWidth * -1 + s.slideOffset : i * t * -1 + n, !0 === s.options.variableWidth && (o = s.slideCount <= s.options.slidesToShow || !1 === s.options.infinite ? s.$slideTrack.children(".slick-slide").eq(i) : s.$slideTrack.children(".slick-slide").eq(i + s.options.slidesToShow), e = !0 === s.options.rtl ? o[0] ? -1 * (s.$slideTrack.width() - o[0].offsetLeft - o.width()) : 0 : o[0] ? -1 * o[0].offsetLeft : 0, !0 === s.options.centerMode && (o = s.slideCount <= s.options.slidesToShow || !1 === s.options.infinite ? s.$slideTrack.children(".slick-slide").eq(i) : s.$slideTrack.children(".slick-slide").eq(i + s.options.slidesToShow + 1), e = !0 === s.options.rtl ? o[0] ? -1 * (s.$slideTrack.width() - o[0].offsetLeft - o.width()) : 0 : o[0] ? -1 * o[0].offsetLeft : 0, e += (s.$list.width() - o.outerWidth()) / 2)), e
    }, e.prototype.getOption = e.prototype.slickGetOption = function(i) {
        return this.options[i]
    }, e.prototype.getNavigableIndexes = function() {
        var i, e = this,
            t = 0,
            o = 0,
            s = [];
        for (!1 === e.options.infinite ? i = e.slideCount : (t = -1 * e.options.slidesToScroll, o = -1 * e.options.slidesToScroll, i = 2 * e.slideCount); i > t;) s.push(t), t = o + e.options.slidesToScroll, o += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow;
        return s
    }, e.prototype.getSlick = function() {
        return this
    }, e.prototype.getSlideCount = function() {
        var e, t, o = this;
        return t = !0 === o.options.centerMode ? o.slideWidth * Math.floor(o.options.slidesToShow / 2) : 0, !0 === o.options.swipeToSlide ? (o.$slideTrack.find(".slick-slide").each(function(s, n) {
            return n.offsetLeft - t + i(n).outerWidth() / 2 > -1 * o.swipeLeft ? (e = n, !1) : void 0
        }), Math.abs(i(e).attr("data-slick-index") - o.currentSlide) || 1) : o.options.slidesToScroll
    }, e.prototype.goTo = e.prototype.slickGoTo = function(i, e) {
        this.changeSlide({
            data: {
                message: "index",
                index: parseInt(i)
            }
        }, e)
    }, e.prototype.init = function(e) {
        var t = this;
        i(t.$slider).hasClass("slick-initialized") || (i(t.$slider).addClass("slick-initialized"), t.buildRows(), t.buildOut(), t.setProps(), t.startLoad(), t.loadSlider(), t.initializeEvents(), t.updateArrows(), t.updateDots()), e && t.$slider.trigger("init", [t]), !0 === t.options.accessibility && t.initADA()
    }, e.prototype.initArrowEvents = function() {
        var i = this;
        !0 === i.options.arrows && i.slideCount > i.options.slidesToShow && (i.$prevArrow.on("click.slick", {
            message: "previous"
        }, i.changeSlide), i.$nextArrow.on("click.slick", {
            message: "next"
        }, i.changeSlide))
    }, e.prototype.initDotEvents = function() {
        var e = this;
        !0 === e.options.dots && e.slideCount > e.options.slidesToShow && i("li", e.$dots).on("click.slick", {
            message: "index"
        }, e.changeSlide), !0 === e.options.dots && !0 === e.options.pauseOnDotsHover && !0 === e.options.autoplay && i("li", e.$dots).on("mouseenter.slick", i.proxy(e.setPaused, e, !0)).on("mouseleave.slick", i.proxy(e.setPaused, e, !1))
    }, e.prototype.initializeEvents = function() {
        var e = this;
        e.initArrowEvents(), e.initDotEvents(), e.$list.on("touchstart.slick mousedown.slick", {
            action: "start"
        }, e.swipeHandler), e.$list.on("touchmove.slick mousemove.slick", {
            action: "move"
        }, e.swipeHandler), e.$list.on("touchend.slick mouseup.slick", {
            action: "end"
        }, e.swipeHandler), e.$list.on("touchcancel.slick mouseleave.slick", {
            action: "end"
        }, e.swipeHandler), e.$list.on("click.slick", e.clickHandler), i(document).on(e.visibilityChange, i.proxy(e.visibility, e)), e.$list.on("mouseenter.slick", i.proxy(e.setPaused, e, !0)), e.$list.on("mouseleave.slick", i.proxy(e.setPaused, e, !1)), !0 === e.options.accessibility && e.$list.on("keydown.slick", e.keyHandler), !0 === e.options.focusOnSelect && i(e.$slideTrack).children().on("click.slick", e.selectHandler), i(window).on("orientationchange.slick.slick-" + e.instanceUid, i.proxy(e.orientationChange, e)), i(window).on("resize.slick.slick-" + e.instanceUid, i.proxy(e.resize, e)), i("[draggable!=true]", e.$slideTrack).on("dragstart", e.preventDefault), i(window).on("load.slick.slick-" + e.instanceUid, e.setPosition), i(document).on("ready.slick.slick-" + e.instanceUid, e.setPosition)
    }, e.prototype.initUI = function() {
        var i = this;
        !0 === i.options.arrows && i.slideCount > i.options.slidesToShow && (i.$prevArrow.show(), i.$nextArrow.show()), !0 === i.options.dots && i.slideCount > i.options.slidesToShow && i.$dots.show(), !0 === i.options.autoplay && i.autoPlay()
    }, e.prototype.keyHandler = function(i) {
        i.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === i.keyCode && !0 === this.options.accessibility ? this.changeSlide({
            data: {
                message: "previous"
            }
        }) : 39 === i.keyCode && !0 === this.options.accessibility && this.changeSlide({
            data: {
                message: "next"
            }
        }))
    }, e.prototype.lazyLoad = function() {
        function e(e) {
            i("img[data-lazy]", e).each(function() {
                var e = i(this),
                    t = i(this).attr("data-lazy"),
                    o = document.createElement("img");
                o.onload = function() {
                    e.animate({
                        opacity: 0
                    }, 100, function() {
                        e.attr("src", t).animate({
                            opacity: 1
                        }, 200, function() {
                            e.removeAttr("data-lazy").removeClass("slick-loading")
                        })
                    })
                }, o.src = t
            })
        }
        var t, o, s = this;
        !0 === s.options.centerMode ? !0 === s.options.infinite ? o = (t = s.currentSlide + (s.options.slidesToShow / 2 + 1)) + s.options.slidesToShow + 2 : (t = Math.max(0, s.currentSlide - (s.options.slidesToShow / 2 + 1)), o = s.options.slidesToShow / 2 + 1 + 2 + s.currentSlide) : (o = (t = s.options.infinite ? s.options.slidesToShow + s.currentSlide : s.currentSlide) + s.options.slidesToShow, !0 === s.options.fade && (t > 0 && t--, o <= s.slideCount && o++)), e(s.$slider.find(".slick-slide").slice(t, o)), s.slideCount <= s.options.slidesToShow ? e(s.$slider.find(".slick-slide")) : s.currentSlide >= s.slideCount - s.options.slidesToShow ? e(s.$slider.find(".slick-cloned").slice(0, s.options.slidesToShow)) : 0 === s.currentSlide && e(s.$slider.find(".slick-cloned").slice(-1 * s.options.slidesToShow))
    }, e.prototype.loadSlider = function() {
        var i = this;
        i.setPosition(), i.$slideTrack.css({
            opacity: 1
        }), i.$slider.removeClass("slick-loading"), i.initUI(), "progressive" === i.options.lazyLoad && i.progressiveLazyLoad()
    }, e.prototype.next = e.prototype.slickNext = function() {
        this.changeSlide({
            data: {
                message: "next"
            }
        })
    }, e.prototype.orientationChange = function() {
        this.checkResponsive(), this.setPosition()
    }, e.prototype.pause = e.prototype.slickPause = function() {
        this.autoPlayClear(), this.paused = !0
    }, e.prototype.play = e.prototype.slickPlay = function() {
        this.paused = !1, this.autoPlay()
    }, e.prototype.postSlide = function(i) {
        var e = this;
        e.$slider.trigger("afterChange", [e, i]), e.animating = !1, e.setPosition(), e.swipeLeft = null, !0 === e.options.autoplay && !1 === e.paused && e.autoPlay(), !0 === e.options.accessibility && e.initADA()
    }, e.prototype.prev = e.prototype.slickPrev = function() {
        this.changeSlide({
            data: {
                message: "previous"
            }
        })
    }, e.prototype.preventDefault = function(i) {
        i.preventDefault()
    }, e.prototype.progressiveLazyLoad = function() {
        var e, t = this;
        i("img[data-lazy]", t.$slider).length > 0 && ((e = i("img[data-lazy]", t.$slider).first()).attr("src", null), e.attr("src", e.attr("data-lazy")).removeClass("slick-loading").load(function() {
            e.removeAttr("data-lazy"), t.progressiveLazyLoad(), !0 === t.options.adaptiveHeight && t.setPosition()
        }).error(function() {
            e.removeAttr("data-lazy"), t.progressiveLazyLoad()
        }))
    }, e.prototype.refresh = function(e) {
        var t, o, s = this;
        o = s.slideCount - s.options.slidesToShow, s.options.infinite || (s.slideCount <= s.options.slidesToShow ? s.currentSlide = 0 : s.currentSlide > o && (s.currentSlide = o)), t = s.currentSlide, s.destroy(!0), i.extend(s, s.initials, {
            currentSlide: t
        }), s.init(), e || s.changeSlide({
            data: {
                message: "index",
                index: t
            }
        }, !1)
    }, e.prototype.registerBreakpoints = function() {
        var e, t, o, s = this,
            n = s.options.responsive || null;
        if ("array" === i.type(n) && n.length) {
            for (e in s.respondTo = s.options.respondTo || "window", n)
                if (o = s.breakpoints.length - 1, t = n[e].breakpoint, n.hasOwnProperty(e)) {
                    for (; o >= 0;) s.breakpoints[o] && s.breakpoints[o] === t && s.breakpoints.splice(o, 1), o--;
                    s.breakpoints.push(t), s.breakpointSettings[t] = n[e].settings
                } s.breakpoints.sort(function(i, e) {
                return s.options.mobileFirst ? i - e : e - i
            })
        }
    }, e.prototype.reinit = function() {
        var e = this;
        e.$slides = e.$slideTrack.children(e.options.slide).addClass("slick-slide"), e.slideCount = e.$slides.length, e.currentSlide >= e.slideCount && 0 !== e.currentSlide && (e.currentSlide = e.currentSlide - e.options.slidesToScroll), e.slideCount <= e.options.slidesToShow && (e.currentSlide = 0), e.registerBreakpoints(), e.setProps(), e.setupInfinite(), e.buildArrows(), e.updateArrows(), e.initArrowEvents(), e.buildDots(), e.updateDots(), e.initDotEvents(), e.checkResponsive(!1, !0), !0 === e.options.focusOnSelect && i(e.$slideTrack).children().on("click.slick", e.selectHandler), e.setSlideClasses(0), e.setPosition(), e.$slider.trigger("reInit", [e]), !0 === e.options.autoplay && e.focusHandler()
    }, e.prototype.resize = function() {
        var e = this;
        i(window).width() !== e.windowWidth && (clearTimeout(e.windowDelay), e.windowDelay = window.setTimeout(function() {
            e.windowWidth = i(window).width(), e.checkResponsive(), e.unslicked || e.setPosition()
        }, 50))
    }, e.prototype.removeSlide = e.prototype.slickRemove = function(i, e, t) {
        var o = this;
        return "boolean" == typeof i ? i = !0 === (e = i) ? 0 : o.slideCount - 1 : i = !0 === e ? --i : i, !(o.slideCount < 1 || 0 > i || i > o.slideCount - 1) && (o.unload(), !0 === t ? o.$slideTrack.children().remove() : o.$slideTrack.children(this.options.slide).eq(i).remove(), o.$slides = o.$slideTrack.children(this.options.slide), o.$slideTrack.children(this.options.slide).detach(), o.$slideTrack.append(o.$slides), o.$slidesCache = o.$slides, void o.reinit())
    }, e.prototype.setCSS = function(i) {
        var e, t, o = this,
            s = {};
        !0 === o.options.rtl && (i = -i), e = "left" == o.positionProp ? Math.ceil(i) + "px" : "0px", t = "top" == o.positionProp ? Math.ceil(i) + "px" : "0px", s[o.positionProp] = i, !1 === o.transformsEnabled ? o.$slideTrack.css(s) : (s = {}, !1 === o.cssTransitions ? (s[o.animType] = "translate(" + e + ", " + t + ")", o.$slideTrack.css(s)) : (s[o.animType] = "translate3d(" + e + ", " + t + ", 0px)", o.$slideTrack.css(s)))
    }, e.prototype.setDimensions = function() {
        var i = this;
        !1 === i.options.vertical ? !0 === i.options.centerMode && i.$list.css({
            padding: "0px " + i.options.centerPadding
        }) : (i.$list.height(i.$slides.first().outerHeight(!0) * i.options.slidesToShow), !0 === i.options.centerMode && i.$list.css({
            padding: i.options.centerPadding + " 0px"
        })), i.listWidth = i.$list.width(), i.listHeight = i.$list.height(), !1 === i.options.vertical && !1 === i.options.variableWidth ? (i.slideWidth = Math.ceil(i.listWidth / i.options.slidesToShow), i.$slideTrack.width(Math.ceil(i.slideWidth * i.$slideTrack.children(".slick-slide").length))) : !0 === i.options.variableWidth ? i.$slideTrack.width(5e3 * i.slideCount) : (i.slideWidth = Math.ceil(i.listWidth), i.$slideTrack.height(Math.ceil(i.$slides.first().outerHeight(!0) * i.$slideTrack.children(".slick-slide").length)));
        var e = i.$slides.first().outerWidth(!0) - i.$slides.first().width();
        !1 === i.options.variableWidth && i.$slideTrack.children(".slick-slide").width(i.slideWidth - e)
    }, e.prototype.setFade = function() {
        var e, t = this;
        t.$slides.each(function(o, s) {
            e = t.slideWidth * o * -1, !0 === t.options.rtl ? i(s).css({
                position: "relative",
                right: e,
                top: 0,
                zIndex: t.options.zIndex - 2,
                opacity: 0
            }) : i(s).css({
                position: "relative",
                left: e,
                top: 0,
                zIndex: t.options.zIndex - 2,
                opacity: 0
            })
        }), t.$slides.eq(t.currentSlide).css({
            zIndex: t.options.zIndex - 1,
            opacity: 1
        })
    }, e.prototype.setHeight = function() {
        var i = this;
        if (1 === i.options.slidesToShow && !0 === i.options.adaptiveHeight && !1 === i.options.vertical) {
            var e = i.$slides.eq(i.currentSlide).outerHeight(!0);
            i.$list.css("height", e)
        }
    }, e.prototype.setOption = e.prototype.slickSetOption = function(e, t, o) {
        var s, n, l = this;
        if ("responsive" === e && "array" === i.type(t))
            for (n in t)
                if ("array" !== i.type(l.options.responsive)) l.options.responsive = [t[n]];
                else {
                    for (s = l.options.responsive.length - 1; s >= 0;) l.options.responsive[s].breakpoint === t[n].breakpoint && l.options.responsive.splice(s, 1), s--;
                    l.options.responsive.push(t[n])
                }
        else l.options[e] = t;
        !0 === o && (l.unload(), l.reinit())
    }, e.prototype.setPosition = function() {
        var i = this;
        i.setDimensions(), i.setHeight(), !1 === i.options.fade ? i.setCSS(i.getLeft(i.currentSlide)) : i.setFade(), i.$slider.trigger("setPosition", [i])
    }, e.prototype.setProps = function() {
        var i = this,
            e = document.body.style;
        i.positionProp = !0 === i.options.vertical ? "top" : "left", "top" === i.positionProp ? i.$slider.addClass("slick-vertical") : i.$slider.removeClass("slick-vertical"), (void 0 !== e.WebkitTransition || void 0 !== e.MozTransition || void 0 !== e.msTransition) && !0 === i.options.useCSS && (i.cssTransitions = !0), i.options.fade && ("number" == typeof i.options.zIndex ? i.options.zIndex < 3 && (i.options.zIndex = 3) : i.options.zIndex = i.defaults.zIndex), void 0 !== e.OTransform && (i.animType = "OTransform", i.transformType = "-o-transform", i.transitionType = "OTransition", void 0 === e.perspectiveProperty && void 0 === e.webkitPerspective && (i.animType = !1)), void 0 !== e.MozTransform && (i.animType = "MozTransform", i.transformType = "-moz-transform", i.transitionType = "MozTransition", void 0 === e.perspectiveProperty && void 0 === e.MozPerspective && (i.animType = !1)), void 0 !== e.webkitTransform && (i.animType = "webkitTransform", i.transformType = "-webkit-transform", i.transitionType = "webkitTransition", void 0 === e.perspectiveProperty && void 0 === e.webkitPerspective && (i.animType = !1)), void 0 !== e.msTransform && (i.animType = "msTransform", i.transformType = "-ms-transform", i.transitionType = "msTransition", void 0 === e.msTransform && (i.animType = !1)), void 0 !== e.transform && !1 !== i.animType && (i.animType = "transform", i.transformType = "transform", i.transitionType = "transition"), i.transformsEnabled = i.options.useTransform && null !== i.animType && !1 !== i.animType
    }, e.prototype.setSlideClasses = function(i) {
        var e, t, o, s, n = this;
        t = n.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true"), n.$slides.eq(i).addClass("slick-current"), !0 === n.options.centerMode ? (e = Math.floor(n.options.slidesToShow / 2), !0 === n.options.infinite && (i >= e && i <= n.slideCount - 1 - e ? n.$slides.slice(i - e, i + e + 1).addClass("slick-active").attr("aria-hidden", "false") : (o = n.options.slidesToShow + i, t.slice(o - e + 1, o + e + 2).addClass("slick-active").attr("aria-hidden", "false")), 0 === i ? t.eq(t.length - 1 - n.options.slidesToShow).addClass("slick-center") : i === n.slideCount - 1 && t.eq(n.options.slidesToShow).addClass("slick-center")), n.$slides.eq(i).addClass("slick-center")) : i >= 0 && i <= n.slideCount - n.options.slidesToShow ? n.$slides.slice(i, i + n.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : t.length <= n.options.slidesToShow ? t.addClass("slick-active").attr("aria-hidden", "false") : (s = n.slideCount % n.options.slidesToShow, o = !0 === n.options.infinite ? n.options.slidesToShow + i : i, n.options.slidesToShow == n.options.slidesToScroll && n.slideCount - i < n.options.slidesToShow ? t.slice(o - (n.options.slidesToShow - s), o + s).addClass("slick-active").attr("aria-hidden", "false") : t.slice(o, o + n.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false")), "ondemand" === n.options.lazyLoad && n.lazyLoad()
    }, e.prototype.setupInfinite = function() {
        var e, t, o, s = this;
        if (!0 === s.options.fade && (s.options.centerMode = !1), !0 === s.options.infinite && !1 === s.options.fade && (t = null, s.slideCount > s.options.slidesToShow)) {
            for (o = !0 === s.options.centerMode ? s.options.slidesToShow + 1 : s.options.slidesToShow, e = s.slideCount; e > s.slideCount - o; e -= 1) t = e - 1, i(s.$slides[t]).clone(!0).attr("id", "").attr("data-slick-index", t - s.slideCount).prependTo(s.$slideTrack).addClass("slick-cloned");
            for (e = 0; o > e; e += 1) t = e, i(s.$slides[t]).clone(!0).attr("id", "").attr("data-slick-index", t + s.slideCount).appendTo(s.$slideTrack).addClass("slick-cloned");
            s.$slideTrack.find(".slick-cloned").find("[id]").each(function() {
                i(this).attr("id", "")
            })
        }
    }, e.prototype.setPaused = function(i) {
        var e = this;
        !0 === e.options.autoplay && !0 === e.options.pauseOnHover && (e.paused = i, i ? e.autoPlayClear() : e.autoPlay())
    }, e.prototype.selectHandler = function(e) {
        var t = this,
            o = i(e.target).is(".slick-slide") ? i(e.target) : i(e.target).parents(".slick-slide"),
            s = parseInt(o.attr("data-slick-index"));
        return s || (s = 0), t.slideCount <= t.options.slidesToShow ? (t.setSlideClasses(s), void t.asNavFor(s)) : void t.slideHandler(s)
    }, e.prototype.slideHandler = function(i, e, t) {
        var o, s, n, l, r = null,
            a = this;
        return e = e || !1, !0 === a.animating && !0 === a.options.waitForAnimate || !0 === a.options.fade && a.currentSlide === i || a.slideCount <= a.options.slidesToShow ? void 0 : (!1 === e && a.asNavFor(i), o = i, r = a.getLeft(o), l = a.getLeft(a.currentSlide), a.currentLeft = null === a.swipeLeft ? l : a.swipeLeft, !1 === a.options.infinite && !1 === a.options.centerMode && (0 > i || i > a.getDotCount() * a.options.slidesToScroll) ? void(!1 === a.options.fade && (o = a.currentSlide, !0 !== t ? a.animateSlide(l, function() {
            a.postSlide(o)
        }) : a.postSlide(o))) : !1 === a.options.infinite && !0 === a.options.centerMode && (0 > i || i > a.slideCount - a.options.slidesToScroll) ? void(!1 === a.options.fade && (o = a.currentSlide, !0 !== t ? a.animateSlide(l, function() {
            a.postSlide(o)
        }) : a.postSlide(o))) : (!0 === a.options.autoplay && clearInterval(a.autoPlayTimer), s = 0 > o ? a.slideCount % a.options.slidesToScroll != 0 ? a.slideCount - a.slideCount % a.options.slidesToScroll : a.slideCount + o : o >= a.slideCount ? a.slideCount % a.options.slidesToScroll != 0 ? 0 : o - a.slideCount : o, a.animating = !0, a.$slider.trigger("beforeChange", [a, a.currentSlide, s]), n = a.currentSlide, a.currentSlide = s, a.setSlideClasses(a.currentSlide), a.updateDots(), a.updateArrows(), !0 === a.options.fade ? (!0 !== t ? (a.fadeSlideOut(n), a.fadeSlide(s, function() {
            a.postSlide(s)
        })) : a.postSlide(s), void a.animateHeight()) : void(!0 !== t ? a.animateSlide(r, function() {
            a.postSlide(s)
        }) : a.postSlide(s))))
    }, e.prototype.startLoad = function() {
        var i = this;
        !0 === i.options.arrows && i.slideCount > i.options.slidesToShow && (i.$prevArrow.hide(), i.$nextArrow.hide()), !0 === i.options.dots && i.slideCount > i.options.slidesToShow && i.$dots.hide(), i.$slider.addClass("slick-loading")
    }, e.prototype.swipeDirection = function() {
        var i, e, t, o, s = this;
        return i = s.touchObject.startX - s.touchObject.curX, e = s.touchObject.startY - s.touchObject.curY, t = Math.atan2(e, i), 0 > (o = Math.round(180 * t / Math.PI)) && (o = 360 - Math.abs(o)), 45 >= o && o >= 0 ? !1 === s.options.rtl ? "left" : "right" : 360 >= o && o >= 315 ? !1 === s.options.rtl ? "left" : "right" : o >= 135 && 225 >= o ? !1 === s.options.rtl ? "right" : "left" : !0 === s.options.verticalSwiping ? o >= 35 && 135 >= o ? "left" : "right" : "vertical"
    }, e.prototype.swipeEnd = function(i) {
        var e, t = this;
        if (t.dragging = !1, t.shouldClick = !(t.touchObject.swipeLength > 10), void 0 === t.touchObject.curX) return !1;
        if (!0 === t.touchObject.edgeHit && t.$slider.trigger("edge", [t, t.swipeDirection()]), t.touchObject.swipeLength >= t.touchObject.minSwipe) switch (t.swipeDirection()) {
            case "left":
                e = t.options.swipeToSlide ? t.checkNavigable(t.currentSlide + t.getSlideCount()) : t.currentSlide + t.getSlideCount(), t.slideHandler(e), t.currentDirection = 0, t.touchObject = {}, t.$slider.trigger("swipe", [t, "left"]);
                break;
            case "right":
                e = t.options.swipeToSlide ? t.checkNavigable(t.currentSlide - t.getSlideCount()) : t.currentSlide - t.getSlideCount(), t.slideHandler(e), t.currentDirection = 1, t.touchObject = {}, t.$slider.trigger("swipe", [t, "right"])
        } else t.touchObject.startX !== t.touchObject.curX && (t.slideHandler(t.currentSlide), t.touchObject = {})
    }, e.prototype.swipeHandler = function(i) {
        var e = this;
        if (!(!1 === e.options.swipe || "ontouchend" in document && !1 === e.options.swipe || !1 === e.options.draggable && -1 !== i.type.indexOf("mouse"))) switch (e.touchObject.fingerCount = i.originalEvent && void 0 !== i.originalEvent.touches ? i.originalEvent.touches.length : 1, e.touchObject.minSwipe = e.listWidth / e.options.touchThreshold, !0 === e.options.verticalSwiping && (e.touchObject.minSwipe = e.listHeight / e.options.touchThreshold), i.data.action) {
            case "start":
                e.swipeStart(i);
                break;
            case "move":
                e.swipeMove(i);
                break;
            case "end":
                e.swipeEnd(i)
        }
    }, e.prototype.swipeMove = function(i) {
        var e, t, o, s, n, l = this;
        return n = void 0 !== i.originalEvent ? i.originalEvent.touches : null, !(!l.dragging || n && 1 !== n.length) && (e = l.getLeft(l.currentSlide), l.touchObject.curX = void 0 !== n ? n[0].pageX : i.clientX, l.touchObject.curY = void 0 !== n ? n[0].pageY : i.clientY, l.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(l.touchObject.curX - l.touchObject.startX, 2))), !0 === l.options.verticalSwiping && (l.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(l.touchObject.curY - l.touchObject.startY, 2)))), "vertical" !== (t = l.swipeDirection()) ? (void 0 !== i.originalEvent && l.touchObject.swipeLength > 4 && i.preventDefault(), s = (!1 === l.options.rtl ? 1 : -1) * (l.touchObject.curX > l.touchObject.startX ? 1 : -1), !0 === l.options.verticalSwiping && (s = l.touchObject.curY > l.touchObject.startY ? 1 : -1), o = l.touchObject.swipeLength, l.touchObject.edgeHit = !1, !1 === l.options.infinite && (0 === l.currentSlide && "right" === t || l.currentSlide >= l.getDotCount() && "left" === t) && (o = l.touchObject.swipeLength * l.options.edgeFriction, l.touchObject.edgeHit = !0), !1 === l.options.vertical ? l.swipeLeft = e + o * s : l.swipeLeft = e + o * (l.$list.height() / l.listWidth) * s, !0 === l.options.verticalSwiping && (l.swipeLeft = e + o * s), !0 !== l.options.fade && !1 !== l.options.touchMove && (!0 === l.animating ? (l.swipeLeft = null, !1) : void l.setCSS(l.swipeLeft))) : void 0)
    }, e.prototype.swipeStart = function(i) {
        var e, t = this;
        return 1 !== t.touchObject.fingerCount || t.slideCount <= t.options.slidesToShow ? (t.touchObject = {}, !1) : (void 0 !== i.originalEvent && void 0 !== i.originalEvent.touches && (e = i.originalEvent.touches[0]), t.touchObject.startX = t.touchObject.curX = void 0 !== e ? e.pageX : i.clientX, t.touchObject.startY = t.touchObject.curY = void 0 !== e ? e.pageY : i.clientY, void(t.dragging = !0))
    }, e.prototype.unfilterSlides = e.prototype.slickUnfilter = function() {
        var i = this;
        null !== i.$slidesCache && (i.unload(), i.$slideTrack.children(this.options.slide).detach(), i.$slidesCache.appendTo(i.$slideTrack), i.reinit())
    }, e.prototype.unload = function() {
        var e = this;
        i(".slick-cloned", e.$slider).remove(), e.$dots && e.$dots.remove(), e.$prevArrow && e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.remove(), e.$nextArrow && e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.remove(), e.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "")
    }, e.prototype.unslick = function(i) {
        this.$slider.trigger("unslick", [this, i]), this.destroy()
    }, e.prototype.updateArrows = function() {
        var i = this;
        Math.floor(i.options.slidesToShow / 2), !0 === i.options.arrows && i.slideCount > i.options.slidesToShow && !i.options.infinite && (i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), i.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === i.currentSlide ? (i.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), i.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : i.currentSlide >= i.slideCount - i.options.slidesToShow && !1 === i.options.centerMode ? (i.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : i.currentSlide >= i.slideCount - 1 && !0 === i.options.centerMode && (i.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")))
    }, e.prototype.updateDots = function() {
        var i = this;
        null !== i.$dots && (i.$dots.find("li").removeClass("slick-active").attr("aria-hidden", "true"), i.$dots.find("li").eq(Math.floor(i.currentSlide / i.options.slidesToScroll)).addClass("slick-active").attr("aria-hidden", "false"))
    }, e.prototype.visibility = function() {
        var i = this;
        document[i.hidden] ? (i.paused = !0, i.autoPlayClear()) : !0 === i.options.autoplay && (i.paused = !1, i.autoPlay())
    }, e.prototype.initADA = function() {
        var e = this;
        e.$slides.add(e.$slideTrack.find(".slick-cloned")).attr({
            "aria-hidden": "true",
            tabindex: "-1"
        }).find("a, input, button, select").attr({
            tabindex: "-1"
        }), e.$slideTrack.attr("role", "listbox"), e.$slides.not(e.$slideTrack.find(".slick-cloned")).each(function(t) {
            i(this).attr({
                role: "option",
                "aria-describedby": "slick-slide" + e.instanceUid + t
            })
        }), null !== e.$dots && e.$dots.attr("role", "tablist").find("li").each(function(t) {
            i(this).attr({
                role: "presentation",
                "aria-selected": "false",
                "aria-controls": "navigation" + e.instanceUid + t,
                id: "slick-slide" + e.instanceUid + t
            })
        }).first().attr("aria-selected", "true").end().find("button").attr("role", "button").end().closest("div").attr("role", "toolbar"), e.activateADA()
    }, e.prototype.activateADA = function() {
        this.$slideTrack.find(".slick-active").attr({
            "aria-hidden": "false"
        }).find("a, input, button, select").attr({
            tabindex: "0"
        })
    }, e.prototype.focusHandler = function() {
        var e = this;
        e.$slider.on("focus.slick blur.slick", "*", function(t) {
            t.stopImmediatePropagation();
            var o = i(this);
            setTimeout(function() {
                e.isPlay && (o.is(":focus") ? (e.autoPlayClear(), e.paused = !0) : (e.paused = !1, e.autoPlay()))
            }, 0)
        })
    }, i.fn.slick = function() {
        var i, t, o = this,
            s = arguments[0],
            n = Array.prototype.slice.call(arguments, 1),
            l = o.length;
        for (i = 0; l > i; i++)
            if ("object" == typeof s || void 0 === s ? o[i].slick = new e(o[i], s) : t = o[i].slick[s].apply(o[i].slick, n), void 0 !== t) return t;
        return o
    }
});
! function(t, e) {
    "function" == typeof define && define.amd ? define(e) : "object" == typeof exports ? module.exports = e() : t.Blazy = e()
}(this, function() {
    function t(t) {
        var o = t._util;
        o.elements = function(t) {
            for (var e = [], o = (t = t.root.querySelectorAll(t.selector)).length; o--; e.unshift(t[o]));
            return e
        }(t.options), o.count = o.elements.length, o.destroyed && (o.destroyed = !1, t.options.container && f(t.options.container, function(t) {
            l(t, "scroll", o.validateT)
        }), l(window, "resize", o.saveViewportOffsetT), l(window, "resize", o.validateT), l(window, "scroll", o.validateT)), e(t)
    }

    function e(t) {
        for (var e = t._util, n = 0; n < e.count; n++) {
            var s, i = e.elements[n],
                a = i;
            s = t.options;
            var c = a.getBoundingClientRect();
            s.container && h && (a = a.closest(s.containerClass)) ? s = !!o(a = a.getBoundingClientRect(), v) && o(c, {
                top: a.top - s.offset,
                right: a.right + s.offset,
                bottom: a.bottom + s.offset,
                left: a.left - s.offset
            }) : s = o(c, v), (s || r(i, t.options.successClass)) && (t.load(i), e.elements.splice(n, 1), e.count--, n--)
        }
        0 === e.count && t.destroy()
    }

    function o(t, e) {
        return t.right >= e.left && t.bottom >= e.top && t.left <= e.right && t.top <= e.bottom
    }

    function n(t, e, o) {
        if (!r(t, o.successClass) && (e || o.loadInvisible || 0 < t.offsetWidth && 0 < t.offsetHeight))
            if (e = t.getAttribute(d) || t.getAttribute(o.src)) {
                var n = (e = e.split(o.separator))[m && 1 < e.length ? 1 : 0],
                    c = t.getAttribute(o.srcset),
                    p = "img" === t.nodeName.toLowerCase(),
                    v = (e = t.parentNode) && "picture" === e.nodeName.toLowerCase();
                if (p || void 0 === t.src) {
                    var h = new Image,
                        g = function() {
                            o.error && o.error(t, "invalid"), a(t, o.errorClass), u(h, "error", g), u(h, "load", w)
                        },
                        w = function() {
                            p ? v || i(t, n, c) : t.style.backgroundImage = 'url("' + n + '")', s(t, o), u(h, "load", w), u(h, "error", g)
                        };
                    v && (h = t, f(e.getElementsByTagName("source"), function(t) {
                        var e = o.srcset,
                            n = t.getAttribute(e);
                        n && (t.setAttribute("srcset", n), t.removeAttribute(e))
                    })) 
                } else t.src = n, s(t, o)
            } else "video" === t.nodeName.toLowerCase() ? (f(t.getElementsByTagName("source"), function(t) {
                var e = o.src,
                    n = t.getAttribute(e);
                n && (t.setAttribute("src", n), t.removeAttribute(e))
            }), t.load(), s(t, o)) : (o.error && o.error(t, "missing"), a(t, o.errorClass))
    }

    function s(t, e) {
        a(t, e.successClass), e.success && e.success(t), t.removeAttribute(e.src), t.removeAttribute(e.srcset), f(e.breakpoints, function(e) {
            t.removeAttribute(e.src)
        })
    }

    function r(t, e) {
        return -1 !== (" " + t.className + " ").indexOf(" " + e + " ")
    }

    function a(t, e) {
        r(t, e) || (t.className += " " + e)
    }

    function c(t) {
        v.bottom = (window.innerHeight || document.documentElement.clientHeight) + t, v.right = (window.innerWidth || document.documentElement.clientWidth) + t
    }

    function l(t, e, o) {
        t.attachEvent ? t.attachEvent && t.attachEvent("on" + e, o) : t.addEventListener(e, o, {
            capture: !1,
            passive: !0
        })
    }

    function u(t, e, o) {
        t.detachEvent ? t.detachEvent && t.detachEvent("on" + e, o) : t.removeEventListener(e, o, {
            capture: !1,
            passive: !0
        })
    }

    function f(t, e) {
        if (t && e)
            for (var o = t.length, n = 0; n < o && !1 !== e(t[n], n); n++);
    }

    function p(t, e, o) {
        var n = 0;
        return function() {
            var s = +new Date;
            s - n < e || (n = s, t.apply(o, arguments))
        }
    }
    var d, v, m, h;
    return function(o) {
        if (!document.querySelectorAll) {
            var s = document.createStyleSheet();
            document.querySelectorAll = function(t, e, o, n, i) {
                for (i = document.all, e = [], o = (t = t.replace(/\[for\b/gi, "[htmlFor").split(",")).length; o--;) {
                    for (s.addRule(t[o], "k:v"), n = i.length; n--;) i[n].currentStyle.k && e.push(i[n]);
                    s.removeRule(0)
                }
                return e
            }
        }
        var i = this,
            r = i._util = {};
        r.elements = [], r.destroyed = !0, i.options = o || {}, i.options.error = i.options.error || !1, i.options.offset = i.options.offset || 100, i.options.root = i.options.root || document, i.options.success = i.options.success || !1, i.options.selector = i.options.selector || ".b-lazy", i.options.separator = i.options.separator || "|", i.options.containerClass = i.options.container, i.options.container = !!i.options.containerClass && document.querySelectorAll(i.options.containerClass), i.options.errorClass = i.options.errorClass || "b-error", i.options.breakpoints = i.options.breakpoints || !1, i.options.loadInvisible = i.options.loadInvisible || !1, i.options.successClass = i.options.successClass || "b-loaded", i.options.validateDelay = i.options.validateDelay || 25, i.options.saveViewportOffsetDelay = i.options.saveViewportOffsetDelay || 50, i.options.srcset = i.options.srcset || "data-srcset", i.options.src = d = i.options.src || "data-src", h = Element.prototype.closest, m = 1 < window.devicePixelRatio, (v = {}).top = 0 - i.options.offset, v.left = 0 - i.options.offset, i.revalidate = function() {
            t(i)
        }, i.load = function(t, e) {
            var o = this.options;
            void 0 === t.length ? n(t, e, o) : f(t, function(t) {
                n(t, e, o)
            })
        }, i.destroy = function() {
            var t = this._util;
            this.options.container && f(this.options.container, function(e) {
                u(e, "scroll", t.validateT)
            }), u(window, "scroll", t.validateT), u(window, "resize", t.validateT), u(window, "resize", t.saveViewportOffsetT), t.count = 0, t.elements.length = 0, t.destroyed = !0
        }, r.validateT = p(function() {
            e(i)
        }, i.options.validateDelay, i), r.saveViewportOffsetT = p(function() {
            c(i.options.offset)
        }, i.options.saveViewportOffsetDelay, i), c(i.options.offset), f(i.options.breakpoints, function(t) {
            if (t.width >= window.screen.width) return d = t.src, !1
        }), setTimeout(function() {
            t(i)
        })
    }
});
! function(n) {
    n.fn.scrollForever = function(e) {
        var t = n.extend({}, {
                placeholder: 0,
                dir: "left",
                container: "ul",
                inner: "li",
                speed: 1e3,
                delayTime: 0,
                continuous: !0,
                num: 1
            }, e),
            o = t.placeholder,
            i = t.dir,
            r = t.speed,
            l = (t.Time, t.num),
            c = t.delayTime;
        return this.each(function() {
            var e, s, a, u, f, d, p = n(this),
                h = p.find(t.container),
                T = h.find(t.inner),
                m = T.length,
                g = !0;

            function v() {
                f = T.outerWidth(), d = T.outerHeight(), t.continuous ? "left" == i ? (e = f * m, h.css("width", 2 * e), g && (T.clone().appendTo(h), g = !1)) : "top" == i && (e = d * m, h.css("height", 2 * e), g && (T.clone().appendTo(h), g = !1)) : "left" == i ? (o = 0 != o ? o : f * l, e = f * (m + 1), h.css("width", e)) : "top" == i && (o = 0 != o ? o : d * l, e = d * (m + 1), h.css("height", e))
            }

            function L() {
                t.continuous ? "left" == i ? (s = p.scrollLeft()) >= e ? p.scrollLeft(0) : p.scrollLeft(s + 1) : "top" == i && ((s = p.scrollTop()) >= e ? p.scrollTop(0) : p.scrollTop(s + 1)) : "left" == i ? h.animate({
                    marginLeft: "-" + o
                }, r, function() {
                    h.css({
                        marginLeft: 0
                    }).find(t.inner + ":lt(" + l + ")").appendTo(h)
                }) : "top" == i && h.animate({
                    marginTop: "-" + o
                }, r, function() {
                    h.css({
                        marginTop: 0
                    }).find(t.inner + ":lt(" + l + ")").appendTo(h)
                })
            }
            n(window).on("resize", function() {
                clearTimeout(u), u = setTimeout(v, 250)
            }), v();
            var w = 1 == t.continuous ? 20 : 2e3;
            c = 0 == c ? w : c, a = setInterval(L, c), p.hover(function() {
                clearInterval(a)
            }, function() {
                a = setInterval(L, c)
            })
        })
    }
}(jQuery);