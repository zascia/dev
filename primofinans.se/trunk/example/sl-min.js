/*! jQuery UI - v1.11.3 - 2015-03-06
 * http://jqueryui.com
 * Includes: core.js, widget.js, mouse.js, position.js, accordion.js, slider.js
 * Copyright 2015 jQuery Foundation and other contributors; Licensed MIT */

(function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : e(jQuery)
})(function (e) {
    function t(t, s) {
        var n, a, o, r = t.nodeName.toLowerCase();
        return "area" === r ? (n = t.parentNode, a = n.name, t.href && a && "map" === n.nodeName.toLowerCase() ? (o = e("img[usemap='#" + a + "']")[0], !!o && i(o)) : !1) : (/^(input|select|textarea|button|object)$/.test(r) ? !t.disabled : "a" === r ? t.href || s : s) && i(t)
    }

    function i(t) {
        return e.expr.filters.visible(t) && !e(t).parents().addBack().filter(function () {
                return "hidden" === e.css(this, "visibility")
            }).length
    }

    e.ui = e.ui || {}, e.extend(e.ui, {
        version: "1.11.3",
        keyCode: {
            BACKSPACE: 8,
            COMMA: 188,
            DELETE: 46,
            DOWN: 40,
            END: 35,
            ENTER: 13,
            ESCAPE: 27,
            HOME: 36,
            LEFT: 37,
            PAGE_DOWN: 34,
            PAGE_UP: 33,
            PERIOD: 190,
            RIGHT: 39,
            SPACE: 32,
            TAB: 9,
            UP: 38
        }
    }), e.fn.extend({
        scrollParent: function (t) {
            var i = this.css("position"), s = "absolute" === i, n = t ? /(auto|scroll|hidden)/ : /(auto|scroll)/, a = this.parents().filter(function () {
                var t = e(this);
                return s && "static" === t.css("position") ? !1 : n.test(t.css("overflow") + t.css("overflow-y") + t.css("overflow-x"))
            }).eq(0);
            return "fixed" !== i && a.length ? a : e(this[0].ownerDocument || document)
        }, uniqueId: function () {
            var e = 0;
            return function () {
                return this.each(function () {
                    this.id || (this.id = "ui-id-" + ++e)
                })
            }
        }(), removeUniqueId: function () {
            return this.each(function () {
                /^ui-id-\d+$/.test(this.id) && e(this).removeAttr("id")
            })
        }
    }), e.extend(e.expr[":"], {
        data: e.expr.createPseudo ? e.expr.createPseudo(function (t) {
                return function (i) {
                    return !!e.data(i, t)
                }
            }) : function (t, i, s) {
                return !!e.data(t, s[3])
            }, focusable: function (i) {
            return t(i, !isNaN(e.attr(i, "tabindex")))
        }, tabbable: function (i) {
            var s = e.attr(i, "tabindex"), n = isNaN(s);
            return (n || s >= 0) && t(i, !n)
        }
    }), e("<a>").outerWidth(1).jquery || e.each(["Width", "Height"], function (t, i) {
        function s(t, i, s, a) {
            return e.each(n, function () {
                i -= parseFloat(e.css(t, "padding" + this)) || 0, s && (i -= parseFloat(e.css(t, "border" + this + "Width")) || 0), a && (i -= parseFloat(e.css(t, "margin" + this)) || 0)
            }), i
        }

        var n = "Width" === i ? ["Left", "Right"] : ["Top", "Bottom"], a = i.toLowerCase(), o = {
            innerWidth: e.fn.innerWidth,
            innerHeight: e.fn.innerHeight,
            outerWidth: e.fn.outerWidth,
            outerHeight: e.fn.outerHeight
        };
        e.fn["inner" + i] = function (t) {
            return void 0 === t ? o["inner" + i].call(this) : this.each(function () {
                    e(this).css(a, s(this, t) + "px")
                })
        }, e.fn["outer" + i] = function (t, n) {
            return "number" != typeof t ? o["outer" + i].call(this, t) : this.each(function () {
                    e(this).css(a, s(this, t, !0, n) + "px")
                })
        }
    }), e.fn.addBack || (e.fn.addBack = function (e) {
        return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
    }), e("<a>").data("a-b", "a").removeData("a-b").data("a-b") && (e.fn.removeData = function (t) {
        return function (i) {
            return arguments.length ? t.call(this, e.camelCase(i)) : t.call(this)
        }
    }(e.fn.removeData)), e.ui.ie = !!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase()), e.fn.extend({
        focus: function (t) {
            return function (i, s) {
                return "number" == typeof i ? this.each(function () {
                        var t = this;
                        setTimeout(function () {
                            e(t).focus(), s && s.call(t)
                        }, i)
                    }) : t.apply(this, arguments)
            }
        }(e.fn.focus), disableSelection: function () {
            var e = "onselectstart" in document.createElement("div") ? "selectstart" : "mousedown";
            return function () {
                return this.bind(e + ".ui-disableSelection", function (e) {
                    e.preventDefault()
                })
            }
        }(), enableSelection: function () {
            return this.unbind(".ui-disableSelection")
        }, zIndex: function (t) {
            if (void 0 !== t)return this.css("zIndex", t);
            if (this.length)for (var i, s, n = e(this[0]); n.length && n[0] !== document;) {
                if (i = n.css("position"), ("absolute" === i || "relative" === i || "fixed" === i) && (s = parseInt(n.css("zIndex"), 10), !isNaN(s) && 0 !== s))return s;
                n = n.parent()
            }
            return 0
        }
    }), e.ui.plugin = {
        add: function (t, i, s) {
            var n, a = e.ui[t].prototype;
            for (n in s)a.plugins[n] = a.plugins[n] || [], a.plugins[n].push([i, s[n]])
        }, call: function (e, t, i, s) {
            var n, a = e.plugins[t];
            if (a && (s || e.element[0].parentNode && 11 !== e.element[0].parentNode.nodeType))for (n = 0; a.length > n; n++)e.options[a[n][0]] && a[n][1].apply(e.element, i)
        }
    };
    var s = 0, n = Array.prototype.slice;
    e.cleanData = function (t) {
        return function (i) {
            var s, n, a;
            for (a = 0; null != (n = i[a]); a++)try {
                s = e._data(n, "events"), s && s.remove && e(n).triggerHandler("remove")
            } catch (o) {
            }
            t(i)
        }
    }(e.cleanData), e.widget = function (t, i, s) {
        var n, a, o, r, h = {}, l = t.split(".")[0];
        return t = t.split(".")[1], n = l + "-" + t, s || (s = i, i = e.Widget), e.expr[":"][n.toLowerCase()] = function (t) {
            return !!e.data(t, n)
        }, e[l] = e[l] || {}, a = e[l][t], o = e[l][t] = function (e, t) {
            return this._createWidget ? (arguments.length && this._createWidget(e, t), void 0) : new o(e, t)
        }, e.extend(o, a, {
            version: s.version,
            _proto: e.extend({}, s),
            _childConstructors: []
        }), r = new i, r.options = e.widget.extend({}, r.options), e.each(s, function (t, s) {
            return e.isFunction(s) ? (h[t] = function () {
                    var e = function () {
                        return i.prototype[t].apply(this, arguments)
                    }, n = function (e) {
                        return i.prototype[t].apply(this, e)
                    };
                    return function () {
                        var t, i = this._super, a = this._superApply;
                        return this._super = e, this._superApply = n, t = s.apply(this, arguments), this._super = i, this._superApply = a, t
                    }
                }(), void 0) : (h[t] = s, void 0)
        }), o.prototype = e.widget.extend(r, {widgetEventPrefix: a ? r.widgetEventPrefix || t : t}, h, {
            constructor: o,
            namespace: l,
            widgetName: t,
            widgetFullName: n
        }), a ? (e.each(a._childConstructors, function (t, i) {
                var s = i.prototype;
                e.widget(s.namespace + "." + s.widgetName, o, i._proto)
            }), delete a._childConstructors) : i._childConstructors.push(o), e.widget.bridge(t, o), o
    }, e.widget.extend = function (t) {
        for (var i, s, a = n.call(arguments, 1), o = 0, r = a.length; r > o; o++)for (i in a[o])s = a[o][i], a[o].hasOwnProperty(i) && void 0 !== s && (t[i] = e.isPlainObject(s) ? e.isPlainObject(t[i]) ? e.widget.extend({}, t[i], s) : e.widget.extend({}, s) : s);
        return t
    }, e.widget.bridge = function (t, i) {
        var s = i.prototype.widgetFullName || t;
        e.fn[t] = function (a) {
            var o = "string" == typeof a, r = n.call(arguments, 1), h = this;
            return o ? this.each(function () {
                    var i, n = e.data(this, s);
                    return "instance" === a ? (h = n, !1) : n ? e.isFunction(n[a]) && "_" !== a.charAt(0) ? (i = n[a].apply(n, r), i !== n && void 0 !== i ? (h = i && i.jquery ? h.pushStack(i.get()) : i, !1) : void 0) : e.error("no such method '" + a + "' for " + t + " widget instance") : e.error("cannot call methods on " + t + " prior to initialization; " + "attempted to call method '" + a + "'")
                }) : (r.length && (a = e.widget.extend.apply(null, [a].concat(r))), this.each(function () {
                    var t = e.data(this, s);
                    t ? (t.option(a || {}), t._init && t._init()) : e.data(this, s, new i(a, this))
                })), h
        }
    }, e.Widget = function () {
    }, e.Widget._childConstructors = [], e.Widget.prototype = {
        widgetName: "widget",
        widgetEventPrefix: "",
        defaultElement: "<div>",
        options: {disabled: !1, create: null},
        _createWidget: function (t, i) {
            i = e(i || this.defaultElement || this)[0], this.element = e(i), this.uuid = s++, this.eventNamespace = "." + this.widgetName + this.uuid, this.bindings = e(), this.hoverable = e(), this.focusable = e(), i !== this && (e.data(i, this.widgetFullName, this), this._on(!0, this.element, {
                remove: function (e) {
                    e.target === i && this.destroy()
                }
            }), this.document = e(i.style ? i.ownerDocument : i.document || i), this.window = e(this.document[0].defaultView || this.document[0].parentWindow)), this.options = e.widget.extend({}, this.options, this._getCreateOptions(), t), this._create(), this._trigger("create", null, this._getCreateEventData()), this._init()
        },
        _getCreateOptions: e.noop,
        _getCreateEventData: e.noop,
        _create: e.noop,
        _init: e.noop,
        destroy: function () {
            this._destroy(), this.element.unbind(this.eventNamespace).removeData(this.widgetFullName).removeData(e.camelCase(this.widgetFullName)), this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName + "-disabled " + "ui-state-disabled"), this.bindings.unbind(this.eventNamespace), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus")
        },
        _destroy: e.noop,
        widget: function () {
            return this.element
        },
        option: function (t, i) {
            var s, n, a, o = t;
            if (0 === arguments.length)return e.widget.extend({}, this.options);
            if ("string" == typeof t)if (o = {}, s = t.split("."), t = s.shift(), s.length) {
                for (n = o[t] = e.widget.extend({}, this.options[t]), a = 0; s.length - 1 > a; a++)n[s[a]] = n[s[a]] || {}, n = n[s[a]];
                if (t = s.pop(), 1 === arguments.length)return void 0 === n[t] ? null : n[t];
                n[t] = i
            } else {
                if (1 === arguments.length)return void 0 === this.options[t] ? null : this.options[t];
                o[t] = i
            }
            return this._setOptions(o), this
        },
        _setOptions: function (e) {
            var t;
            for (t in e)this._setOption(t, e[t]);
            return this
        },
        _setOption: function (e, t) {
            return this.options[e] = t, "disabled" === e && (this.widget().toggleClass(this.widgetFullName + "-disabled", !!t), t && (this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus"))), this
        },
        enable: function () {
            return this._setOptions({disabled: !1})
        },
        disable: function () {
            return this._setOptions({disabled: !0})
        },
        _on: function (t, i, s) {
            var n, a = this;
            "boolean" != typeof t && (s = i, i = t, t = !1), s ? (i = n = e(i), this.bindings = this.bindings.add(i)) : (s = i, i = this.element, n = this.widget()), e.each(s, function (s, o) {
                function r() {
                    return t || a.options.disabled !== !0 && !e(this).hasClass("ui-state-disabled") ? ("string" == typeof o ? a[o] : o).apply(a, arguments) : void 0
                }

                "string" != typeof o && (r.guid = o.guid = o.guid || r.guid || e.guid++);
                var h = s.match(/^([\w:-]*)\s*(.*)$/), l = h[1] + a.eventNamespace, u = h[2];
                u ? n.delegate(u, l, r) : i.bind(l, r)
            })
        },
        _off: function (t, i) {
            i = (i || "").split(" ").join(this.eventNamespace + " ") + this.eventNamespace, t.unbind(i).undelegate(i), this.bindings = e(this.bindings.not(t).get()), this.focusable = e(this.focusable.not(t).get()), this.hoverable = e(this.hoverable.not(t).get())
        },
        _delay: function (e, t) {
            function i() {
                return ("string" == typeof e ? s[e] : e).apply(s, arguments)
            }

            var s = this;
            return setTimeout(i, t || 0)
        },
        _hoverable: function (t) {
            this.hoverable = this.hoverable.add(t), this._on(t, {
                mouseenter: function (t) {
                    e(t.currentTarget).addClass("ui-state-hover")
                }, mouseleave: function (t) {
                    e(t.currentTarget).removeClass("ui-state-hover")
                }
            })
        },
        _focusable: function (t) {
            this.focusable = this.focusable.add(t), this._on(t, {
                focusin: function (t) {
                    e(t.currentTarget).addClass("ui-state-focus")
                }, focusout: function (t) {
                    e(t.currentTarget).removeClass("ui-state-focus")
                }
            })
        },
        _trigger: function (t, i, s) {
            var n, a, o = this.options[t];
            if (s = s || {}, i = e.Event(i), i.type = (t === this.widgetEventPrefix ? t : this.widgetEventPrefix + t).toLowerCase(), i.target = this.element[0], a = i.originalEvent)for (n in a)n in i || (i[n] = a[n]);
            return this.element.trigger(i, s), !(e.isFunction(o) && o.apply(this.element[0], [i].concat(s)) === !1 || i.isDefaultPrevented())
        }
    }, e.each({show: "fadeIn", hide: "fadeOut"}, function (t, i) {
        e.Widget.prototype["_" + t] = function (s, n, a) {
            "string" == typeof n && (n = {effect: n});
            var o, r = n ? n === !0 || "number" == typeof n ? i : n.effect || i : t;
            n = n || {}, "number" == typeof n && (n = {duration: n}), o = !e.isEmptyObject(n), n.complete = a, n.delay && s.delay(n.delay), o && e.effects && e.effects.effect[r] ? s[t](n) : r !== t && s[r] ? s[r](n.duration, n.easing, a) : s.queue(function (i) {
                        e(this)[t](), a && a.call(s[0]), i()
                    })
        }
    }), e.widget;
    var a = !1;
    e(document).mouseup(function () {
        a = !1
    }), e.widget("ui.mouse", {
        version: "1.11.3",
        options: {cancel: "input,textarea,button,select,option", distance: 1, delay: 0},
        _mouseInit: function () {
            var t = this;
            this.element.bind("mousedown." + this.widgetName, function (e) {
                return t._mouseDown(e)
            }).bind("click." + this.widgetName, function (i) {
                return !0 === e.data(i.target, t.widgetName + ".preventClickEvent") ? (e.removeData(i.target, t.widgetName + ".preventClickEvent"), i.stopImmediatePropagation(), !1) : void 0
            }), this.started = !1
        },
        _mouseDestroy: function () {
            this.element.unbind("." + this.widgetName), this._mouseMoveDelegate && this.document.unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate)
        },
        _mouseDown: function (t) {
            if (!a) {
                this._mouseMoved = !1, this._mouseStarted && this._mouseUp(t), this._mouseDownEvent = t;
                var i = this, s = 1 === t.which, n = "string" == typeof this.options.cancel && t.target.nodeName ? e(t.target).closest(this.options.cancel).length : !1;
                return s && !n && this._mouseCapture(t) ? (this.mouseDelayMet = !this.options.delay, this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function () {
                        i.mouseDelayMet = !0
                    }, this.options.delay)), this._mouseDistanceMet(t) && this._mouseDelayMet(t) && (this._mouseStarted = this._mouseStart(t) !== !1, !this._mouseStarted) ? (t.preventDefault(), !0) : (!0 === e.data(t.target, this.widgetName + ".preventClickEvent") && e.removeData(t.target, this.widgetName + ".preventClickEvent"), this._mouseMoveDelegate = function (e) {
                            return i._mouseMove(e)
                        }, this._mouseUpDelegate = function (e) {
                            return i._mouseUp(e)
                        }, this.document.bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate), t.preventDefault(), a = !0, !0)) : !0
            }
        },
        _mouseMove: function (t) {
            if (this._mouseMoved) {
                if (e.ui.ie && (!document.documentMode || 9 > document.documentMode) && !t.button)return this._mouseUp(t);
                if (!t.which)return this._mouseUp(t)
            }
            return (t.which || t.button) && (this._mouseMoved = !0), this._mouseStarted ? (this._mouseDrag(t), t.preventDefault()) : (this._mouseDistanceMet(t) && this._mouseDelayMet(t) && (this._mouseStarted = this._mouseStart(this._mouseDownEvent, t) !== !1, this._mouseStarted ? this._mouseDrag(t) : this._mouseUp(t)), !this._mouseStarted)
        },
        _mouseUp: function (t) {
            return this.document.unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate), this._mouseStarted && (this._mouseStarted = !1, t.target === this._mouseDownEvent.target && e.data(t.target, this.widgetName + ".preventClickEvent", !0), this._mouseStop(t)), a = !1, !1
        },
        _mouseDistanceMet: function (e) {
            return Math.max(Math.abs(this._mouseDownEvent.pageX - e.pageX), Math.abs(this._mouseDownEvent.pageY - e.pageY)) >= this.options.distance
        },
        _mouseDelayMet: function () {
            return this.mouseDelayMet
        },
        _mouseStart: function () {
        },
        _mouseDrag: function () {
        },
        _mouseStop: function () {
        },
        _mouseCapture: function () {
            return !0
        }
    }), function () {
        function t(e, t, i) {
            return [parseFloat(e[0]) * (p.test(e[0]) ? t / 100 : 1), parseFloat(e[1]) * (p.test(e[1]) ? i / 100 : 1)]
        }

        function i(t, i) {
            return parseInt(e.css(t, i), 10) || 0
        }

        function s(t) {
            var i = t[0];
            return 9 === i.nodeType ? {
                    width: t.width(),
                    height: t.height(),
                    offset: {top: 0, left: 0}
                } : e.isWindow(i) ? {
                        width: t.width(),
                        height: t.height(),
                        offset: {top: t.scrollTop(), left: t.scrollLeft()}
                    } : i.preventDefault ? {
                            width: 0,
                            height: 0,
                            offset: {top: i.pageY, left: i.pageX}
                        } : {width: t.outerWidth(), height: t.outerHeight(), offset: t.offset()}
        }

        e.ui = e.ui || {};
        var n, a, o = Math.max, r = Math.abs, h = Math.round, l = /left|center|right/, u = /top|center|bottom/, d = /[\+\-]\d+(\.[\d]+)?%?/, c = /^\w+/, p = /%$/, f = e.fn.position;
        e.position = {
            scrollbarWidth: function () {
                if (void 0 !== n)return n;
                var t, i, s = e("<div style='display:block;position:absolute;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>"), a = s.children()[0];
                return e("body").append(s), t = a.offsetWidth, s.css("overflow", "scroll"), i = a.offsetWidth, t === i && (i = s[0].clientWidth), s.remove(), n = t - i
            }, getScrollInfo: function (t) {
                var i = t.isWindow || t.isDocument ? "" : t.element.css("overflow-x"), s = t.isWindow || t.isDocument ? "" : t.element.css("overflow-y"), n = "scroll" === i || "auto" === i && t.width < t.element[0].scrollWidth, a = "scroll" === s || "auto" === s && t.height < t.element[0].scrollHeight;
                return {width: a ? e.position.scrollbarWidth() : 0, height: n ? e.position.scrollbarWidth() : 0}
            }, getWithinInfo: function (t) {
                var i = e(t || window), s = e.isWindow(i[0]), n = !!i[0] && 9 === i[0].nodeType;
                return {
                    element: i,
                    isWindow: s,
                    isDocument: n,
                    offset: i.offset() || {left: 0, top: 0},
                    scrollLeft: i.scrollLeft(),
                    scrollTop: i.scrollTop(),
                    width: s || n ? i.width() : i.outerWidth(),
                    height: s || n ? i.height() : i.outerHeight()
                }
            }
        }, e.fn.position = function (n) {
            if (!n || !n.of)return f.apply(this, arguments);
            n = e.extend({}, n);
            var p, m, g, v, y, b, _ = e(n.of), x = e.position.getWithinInfo(n.within), w = e.position.getScrollInfo(x), k = (n.collision || "flip").split(" "), T = {};
            return b = s(_), _[0].preventDefault && (n.at = "left top"), m = b.width, g = b.height, v = b.offset, y = e.extend({}, v), e.each(["my", "at"], function () {
                var e, t, i = (n[this] || "").split(" ");
                1 === i.length && (i = l.test(i[0]) ? i.concat(["center"]) : u.test(i[0]) ? ["center"].concat(i) : ["center", "center"]), i[0] = l.test(i[0]) ? i[0] : "center", i[1] = u.test(i[1]) ? i[1] : "center", e = d.exec(i[0]), t = d.exec(i[1]), T[this] = [e ? e[0] : 0, t ? t[0] : 0], n[this] = [c.exec(i[0])[0], c.exec(i[1])[0]]
            }), 1 === k.length && (k[1] = k[0]), "right" === n.at[0] ? y.left += m : "center" === n.at[0] && (y.left += m / 2), "bottom" === n.at[1] ? y.top += g : "center" === n.at[1] && (y.top += g / 2), p = t(T.at, m, g), y.left += p[0], y.top += p[1], this.each(function () {
                var s, l, u = e(this), d = u.outerWidth(), c = u.outerHeight(), f = i(this, "marginLeft"), b = i(this, "marginTop"), D = d + f + i(this, "marginRight") + w.width, S = c + b + i(this, "marginBottom") + w.height, N = e.extend({}, y), M = t(T.my, u.outerWidth(), u.outerHeight());
                "right" === n.my[0] ? N.left -= d : "center" === n.my[0] && (N.left -= d / 2), "bottom" === n.my[1] ? N.top -= c : "center" === n.my[1] && (N.top -= c / 2), N.left += M[0], N.top += M[1], a || (N.left = h(N.left), N.top = h(N.top)), s = {
                    marginLeft: f,
                    marginTop: b
                }, e.each(["left", "top"], function (t, i) {
                    e.ui.position[k[t]] && e.ui.position[k[t]][i](N, {
                        targetWidth: m,
                        targetHeight: g,
                        elemWidth: d,
                        elemHeight: c,
                        collisionPosition: s,
                        collisionWidth: D,
                        collisionHeight: S,
                        offset: [p[0] + M[0], p[1] + M[1]],
                        my: n.my,
                        at: n.at,
                        within: x,
                        elem: u
                    })
                }), n.using && (l = function (e) {
                    var t = v.left - N.left, i = t + m - d, s = v.top - N.top, a = s + g - c, h = {
                        target: {
                            element: _,
                            left: v.left,
                            top: v.top,
                            width: m,
                            height: g
                        },
                        element: {element: u, left: N.left, top: N.top, width: d, height: c},
                        horizontal: 0 > i ? "left" : t > 0 ? "right" : "center",
                        vertical: 0 > a ? "top" : s > 0 ? "bottom" : "middle"
                    };
                    d > m && m > r(t + i) && (h.horizontal = "center"), c > g && g > r(s + a) && (h.vertical = "middle"), h.important = o(r(t), r(i)) > o(r(s), r(a)) ? "horizontal" : "vertical", n.using.call(this, e, h)
                }), u.offset(e.extend(N, {using: l}))
            })
        }, e.ui.position = {
            fit: {
                left: function (e, t) {
                    var i, s = t.within, n = s.isWindow ? s.scrollLeft : s.offset.left, a = s.width, r = e.left - t.collisionPosition.marginLeft, h = n - r, l = r + t.collisionWidth - a - n;
                    t.collisionWidth > a ? h > 0 && 0 >= l ? (i = e.left + h + t.collisionWidth - a - n, e.left += h - i) : e.left = l > 0 && 0 >= h ? n : h > l ? n + a - t.collisionWidth : n : h > 0 ? e.left += h : l > 0 ? e.left -= l : e.left = o(e.left - r, e.left)
                }, top: function (e, t) {
                    var i, s = t.within, n = s.isWindow ? s.scrollTop : s.offset.top, a = t.within.height, r = e.top - t.collisionPosition.marginTop, h = n - r, l = r + t.collisionHeight - a - n;
                    t.collisionHeight > a ? h > 0 && 0 >= l ? (i = e.top + h + t.collisionHeight - a - n, e.top += h - i) : e.top = l > 0 && 0 >= h ? n : h > l ? n + a - t.collisionHeight : n : h > 0 ? e.top += h : l > 0 ? e.top -= l : e.top = o(e.top - r, e.top)
                }
            }, flip: {
                left: function (e, t) {
                    var i, s, n = t.within, a = n.offset.left + n.scrollLeft, o = n.width, h = n.isWindow ? n.scrollLeft : n.offset.left, l = e.left - t.collisionPosition.marginLeft, u = l - h, d = l + t.collisionWidth - o - h, c = "left" === t.my[0] ? -t.elemWidth : "right" === t.my[0] ? t.elemWidth : 0, p = "left" === t.at[0] ? t.targetWidth : "right" === t.at[0] ? -t.targetWidth : 0, f = -2 * t.offset[0];
                    0 > u ? (i = e.left + c + p + f + t.collisionWidth - o - a, (0 > i || r(u) > i) && (e.left += c + p + f)) : d > 0 && (s = e.left - t.collisionPosition.marginLeft + c + p + f - h, (s > 0 || d > r(s)) && (e.left += c + p + f))
                }, top: function (e, t) {
                    var i, s, n = t.within, a = n.offset.top + n.scrollTop, o = n.height, h = n.isWindow ? n.scrollTop : n.offset.top, l = e.top - t.collisionPosition.marginTop, u = l - h, d = l + t.collisionHeight - o - h, c = "top" === t.my[1], p = c ? -t.elemHeight : "bottom" === t.my[1] ? t.elemHeight : 0, f = "top" === t.at[1] ? t.targetHeight : "bottom" === t.at[1] ? -t.targetHeight : 0, m = -2 * t.offset[1];
                    0 > u ? (s = e.top + p + f + m + t.collisionHeight - o - a, (0 > s || r(u) > s) && (e.top += p + f + m)) : d > 0 && (i = e.top - t.collisionPosition.marginTop + p + f + m - h, (i > 0 || d > r(i)) && (e.top += p + f + m))
                }
            }, flipfit: {
                left: function () {
                    e.ui.position.flip.left.apply(this, arguments), e.ui.position.fit.left.apply(this, arguments)
                }, top: function () {
                    e.ui.position.flip.top.apply(this, arguments), e.ui.position.fit.top.apply(this, arguments)
                }
            }
        }, function () {
            var t, i, s, n, o, r = document.getElementsByTagName("body")[0], h = document.createElement("div");
            t = document.createElement(r ? "div" : "body"), s = {
                visibility: "hidden",
                width: 0,
                height: 0,
                border: 0,
                margin: 0,
                background: "none"
            }, r && e.extend(s, {position: "absolute", left: "-1000px", top: "-1000px"});
            for (o in s)t.style[o] = s[o];
            t.appendChild(h), i = r || document.documentElement, i.insertBefore(t, i.firstChild), h.style.cssText = "position: absolute; left: 10.7432222px;", n = e(h).offset().left, a = n > 10 && 11 > n, t.innerHTML = "", i.removeChild(t)
        }()
    }(), e.ui.position, e.widget("ui.accordion", {
        version: "1.11.3",
        options: {
            active: 0,
            animate: {},
            collapsible: !1,
            event: "click",
            header: "> li > :first-child,> :not(li):even",
            heightStyle: "auto",
            icons: {activeHeader: "ui-icon-triangle-1-s", header: "ui-icon-triangle-1-e"},
            activate: null,
            beforeActivate: null
        },
        hideProps: {
            borderTopWidth: "hide",
            borderBottomWidth: "hide",
            paddingTop: "hide",
            paddingBottom: "hide",
            height: "hide"
        },
        showProps: {
            borderTopWidth: "show",
            borderBottomWidth: "show",
            paddingTop: "show",
            paddingBottom: "show",
            height: "show"
        },
        _create: function () {
            var t = this.options;
            this.prevShow = this.prevHide = e(), this.element.addClass("ui-accordion ui-widget ui-helper-reset").attr("role", "tablist"), t.collapsible || t.active !== !1 && null != t.active || (t.active = 0), this._processPanels(), 0 > t.active && (t.active += this.headers.length), this._refresh()
        },
        _getCreateEventData: function () {
            return {header: this.active, panel: this.active.length ? this.active.next() : e()}
        },
        _createIcons: function () {
            var t = this.options.icons;
            t && (e("<span>").addClass("ui-accordion-header-icon ui-icon " + t.header).prependTo(this.headers), this.active.children(".ui-accordion-header-icon").removeClass(t.header).addClass(t.activeHeader), this.headers.addClass("ui-accordion-icons"))
        },
        _destroyIcons: function () {
            this.headers.removeClass("ui-accordion-icons").children(".ui-accordion-header-icon").remove()
        },
        _destroy: function () {
            var e;
            this.element.removeClass("ui-accordion ui-widget ui-helper-reset").removeAttr("role"), this.headers.removeClass("ui-accordion-header ui-accordion-header-active ui-state-default ui-corner-all ui-state-active ui-state-disabled ui-corner-top").removeAttr("role").removeAttr("aria-expanded").removeAttr("aria-selected").removeAttr("aria-controls").removeAttr("tabIndex").removeUniqueId(), this._destroyIcons(), e = this.headers.next().removeClass("ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content ui-accordion-content-active ui-state-disabled").css("display", "").removeAttr("role").removeAttr("aria-hidden").removeAttr("aria-labelledby").removeUniqueId(), "content" !== this.options.heightStyle && e.css("height", "")
        },
        _setOption: function (e, t) {
            return "active" === e ? (this._activate(t), void 0) : ("event" === e && (this.options.event && this._off(this.headers, this.options.event), this._setupEvents(t)), this._super(e, t), "collapsible" !== e || t || this.options.active !== !1 || this._activate(0), "icons" === e && (this._destroyIcons(), t && this._createIcons()), "disabled" === e && (this.element.toggleClass("ui-state-disabled", !!t).attr("aria-disabled", t), this.headers.add(this.headers.next()).toggleClass("ui-state-disabled", !!t)), void 0)
        },
        _keydown: function (t) {
            if (!t.altKey && !t.ctrlKey) {
                var i = e.ui.keyCode, s = this.headers.length, n = this.headers.index(t.target), a = !1;
                switch (t.keyCode) {
                    case i.RIGHT:
                    case i.DOWN:
                        a = this.headers[(n + 1) % s];
                        break;
                    case i.LEFT:
                    case i.UP:
                        a = this.headers[(n - 1 + s) % s];
                        break;
                    case i.SPACE:
                    case i.ENTER:
                        this._eventHandler(t);
                        break;
                    case i.HOME:
                        a = this.headers[0];
                        break;
                    case i.END:
                        a = this.headers[s - 1]
                }
                a && (e(t.target).attr("tabIndex", -1), e(a).attr("tabIndex", 0), a.focus(), t.preventDefault())
            }
        },
        _panelKeyDown: function (t) {
            t.keyCode === e.ui.keyCode.UP && t.ctrlKey && e(t.currentTarget).prev().focus()
        },
        refresh: function () {
            var t = this.options;
            this._processPanels(), t.active === !1 && t.collapsible === !0 || !this.headers.length ? (t.active = !1, this.active = e()) : t.active === !1 ? this._activate(0) : this.active.length && !e.contains(this.element[0], this.active[0]) ? this.headers.length === this.headers.find(".ui-state-disabled").length ? (t.active = !1, this.active = e()) : this._activate(Math.max(0, t.active - 1)) : t.active = this.headers.index(this.active), this._destroyIcons(), this._refresh()
        },
        _processPanels: function () {
            var e = this.headers, t = this.panels;
            this.headers = this.element.find(this.options.header).addClass("ui-accordion-header ui-state-default ui-corner-all"), this.panels = this.headers.next().addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom").filter(":not(.ui-accordion-content-active)").hide(), t && (this._off(e.not(this.headers)), this._off(t.not(this.panels)))
        },
        _refresh: function () {
            var t, i = this.options, s = i.heightStyle, n = this.element.parent();
            this.active = this._findActive(i.active).addClass("ui-accordion-header-active ui-state-active ui-corner-top").removeClass("ui-corner-all"), this.active.next().addClass("ui-accordion-content-active").show(), this.headers.attr("role", "tab").each(function () {
                var t = e(this), i = t.uniqueId().attr("id"), s = t.next(), n = s.uniqueId().attr("id");
                t.attr("aria-controls", n), s.attr("aria-labelledby", i)
            }).next().attr("role", "tabpanel"), this.headers.not(this.active).attr({
                "aria-selected": "false",
                "aria-expanded": "false",
                tabIndex: -1
            }).next().attr({"aria-hidden": "true"}).hide(), this.active.length ? this.active.attr({
                    "aria-selected": "true",
                    "aria-expanded": "true",
                    tabIndex: 0
                }).next().attr({"aria-hidden": "false"}) : this.headers.eq(0).attr("tabIndex", 0), this._createIcons(), this._setupEvents(i.event), "fill" === s ? (t = n.height(), this.element.siblings(":visible").each(function () {
                    var i = e(this), s = i.css("position");
                    "absolute" !== s && "fixed" !== s && (t -= i.outerHeight(!0))
                }), this.headers.each(function () {
                    t -= e(this).outerHeight(!0)
                }), this.headers.next().each(function () {
                    e(this).height(Math.max(0, t - e(this).innerHeight() + e(this).height()))
                }).css("overflow", "auto")) : "auto" === s && (t = 0, this.headers.next().each(function () {
                    t = Math.max(t, e(this).css("height", "").height())
                }).height(t))
        },
        _activate: function (t) {
            var i = this._findActive(t)[0];
            i !== this.active[0] && (i = i || this.active[0], this._eventHandler({
                target: i,
                currentTarget: i,
                preventDefault: e.noop
            }))
        },
        _findActive: function (t) {
            return "number" == typeof t ? this.headers.eq(t) : e()
        },
        _setupEvents: function (t) {
            var i = {keydown: "_keydown"};
            t && e.each(t.split(" "), function (e, t) {
                i[t] = "_eventHandler"
            }), this._off(this.headers.add(this.headers.next())), this._on(this.headers, i), this._on(this.headers.next(), {keydown: "_panelKeyDown"}), this._hoverable(this.headers), this._focusable(this.headers)
        },
        _eventHandler: function (t) {
            var i = this.options, s = this.active, n = e(t.currentTarget), a = n[0] === s[0], o = a && i.collapsible, r = o ? e() : n.next(), h = s.next(), l = {
                oldHeader: s,
                oldPanel: h,
                newHeader: o ? e() : n,
                newPanel: r
            };
            t.preventDefault(), a && !i.collapsible || this._trigger("beforeActivate", t, l) === !1 || (i.active = o ? !1 : this.headers.index(n), this.active = a ? e() : n, this._toggle(l), s.removeClass("ui-accordion-header-active ui-state-active"), i.icons && s.children(".ui-accordion-header-icon").removeClass(i.icons.activeHeader).addClass(i.icons.header), a || (n.removeClass("ui-corner-all").addClass("ui-accordion-header-active ui-state-active ui-corner-top"), i.icons && n.children(".ui-accordion-header-icon").removeClass(i.icons.header).addClass(i.icons.activeHeader), n.next().addClass("ui-accordion-content-active")))
        },
        _toggle: function (t) {
            var i = t.newPanel, s = this.prevShow.length ? this.prevShow : t.oldPanel;
            this.prevShow.add(this.prevHide).stop(!0, !0), this.prevShow = i, this.prevHide = s, this.options.animate ? this._animate(i, s, t) : (s.hide(), i.show(), this._toggleComplete(t)), s.attr({"aria-hidden": "true"}), s.prev().attr({
                "aria-selected": "false",
                "aria-expanded": "false"
            }), i.length && s.length ? s.prev().attr({
                    tabIndex: -1,
                    "aria-expanded": "false"
                }) : i.length && this.headers.filter(function () {
                    return 0 === parseInt(e(this).attr("tabIndex"), 10)
                }).attr("tabIndex", -1), i.attr("aria-hidden", "false").prev().attr({
                "aria-selected": "true",
                "aria-expanded": "true",
                tabIndex: 0
            })
        },
        _animate: function (e, t, i) {
            var s, n, a, o = this, r = 0, h = e.length && (!t.length || e.index() < t.index()), l = this.options.animate || {}, u = h && l.down || l, d = function () {
                o._toggleComplete(i)
            };
            return "number" == typeof u && (a = u), "string" == typeof u && (n = u), n = n || u.easing || l.easing, a = a || u.duration || l.duration, t.length ? e.length ? (s = e.show().outerHeight(), t.animate(this.hideProps, {
                        duration: a,
                        easing: n,
                        step: function (e, t) {
                            t.now = Math.round(e)
                        }
                    }), e.hide().animate(this.showProps, {
                        duration: a, easing: n, complete: d, step: function (e, i) {
                            i.now = Math.round(e), "height" !== i.prop ? r += i.now : "content" !== o.options.heightStyle && (i.now = Math.round(s - t.outerHeight() - r), r = 0)
                        }
                    }), void 0) : t.animate(this.hideProps, a, n, d) : e.animate(this.showProps, a, n, d)
        },
        _toggleComplete: function (e) {
            var t = e.oldPanel;
            t.removeClass("ui-accordion-content-active").prev().removeClass("ui-corner-top").addClass("ui-corner-all"), t.length && (t.parent()[0].className = t.parent()[0].className), this._trigger("activate", null, e)
        }
    }), e.widget("ui.slider", e.ui.mouse, {
        version: "1.11.3",
        widgetEventPrefix: "slide",
        options: {
            animate: !1,
            distance: 0,
            max: 100,
            min: 0,
            orientation: "horizontal",
            range: !1,
            step: 1,
            value: 0,
            values: null,
            change: null,
            slide: null,
            start: null,
            stop: null
        },
        numPages: 5,
        _create: function () {
            this._keySliding = !1, this._mouseSliding = !1, this._animateOff = !0, this._handleIndex = null, this._detectOrientation(), this._mouseInit(), this._calculateNewMax(), this.element.addClass("ui-slider ui-slider-" + this.orientation + " ui-widget" + " ui-widget-content" + " ui-corner-all"), this._refresh(), this._setOption("disabled", this.options.disabled), this._animateOff = !1
        },
        _refresh: function () {
            this._createRange(), this._createHandles(), this._setupEvents(), this._refreshValue()
        },
        _createHandles: function () {
            var t, i, s = this.options, n = this.element.find(".ui-slider-handle").addClass("ui-state-default ui-corner-all"), a = "<span class='ui-slider-handle ui-state-default ui-corner-all' tabindex='0'></span>", o = [];
            for (i = s.values && s.values.length || 1, n.length > i && (n.slice(i).remove(), n = n.slice(0, i)), t = n.length; i > t; t++)o.push(a);
            this.handles = n.add(e(o.join("")).appendTo(this.element)), this.handle = this.handles.eq(0), this.handles.each(function (t) {
                e(this).data("ui-slider-handle-index", t)
            })
        },
        _createRange: function () {
            var t = this.options, i = "";
            t.range ? (t.range === !0 && (t.values ? t.values.length && 2 !== t.values.length ? t.values = [t.values[0], t.values[0]] : e.isArray(t.values) && (t.values = t.values.slice(0)) : t.values = [this._valueMin(), this._valueMin()]), this.range && this.range.length ? this.range.removeClass("ui-slider-range-min ui-slider-range-max").css({
                        left: "",
                        bottom: ""
                    }) : (this.range = e("<div></div>").appendTo(this.element), i = "ui-slider-range ui-widget-header ui-corner-all"), this.range.addClass(i + ("min" === t.range || "max" === t.range ? " ui-slider-range-" + t.range : ""))) : (this.range && this.range.remove(), this.range = null)
        },
        _setupEvents: function () {
            this._off(this.handles), this._on(this.handles, this._handleEvents), this._hoverable(this.handles), this._focusable(this.handles)
        },
        _destroy: function () {
            this.handles.remove(), this.range && this.range.remove(), this.element.removeClass("ui-slider ui-slider-horizontal ui-slider-vertical ui-widget ui-widget-content ui-corner-all"), this._mouseDestroy()
        },
        _mouseCapture: function (t) {
            var i, s, n, a, o, r, h, l, u = this, d = this.options;
            return d.disabled ? !1 : (this.elementSize = {
                    width: this.element.outerWidth(),
                    height: this.element.outerHeight()
                }, this.elementOffset = this.element.offset(), i = {
                    x: t.pageX,
                    y: t.pageY
                }, s = this._normValueFromMouse(i), n = this._valueMax() - this._valueMin() + 1, this.handles.each(function (t) {
                    var i = Math.abs(s - u.values(t));
                    (n > i || n === i && (t === u._lastChangedValue || u.values(t) === d.min)) && (n = i, a = e(this), o = t)
                }), r = this._start(t, o), r === !1 ? !1 : (this._mouseSliding = !0, this._handleIndex = o, a.addClass("ui-state-active").focus(), h = a.offset(), l = !e(t.target).parents().addBack().is(".ui-slider-handle"), this._clickOffset = l ? {
                            left: 0,
                            top: 0
                        } : {
                            left: t.pageX - h.left - a.width() / 2,
                            top: t.pageY - h.top - a.height() / 2 - (parseInt(a.css("borderTopWidth"), 10) || 0) - (parseInt(a.css("borderBottomWidth"), 10) || 0) + (parseInt(a.css("marginTop"), 10) || 0)
                        }, this.handles.hasClass("ui-state-hover") || this._slide(t, o, s), this._animateOff = !0, !0))
        },
        _mouseStart: function () {
            return !0
        },
        _mouseDrag: function (e) {
            var t = {x: e.pageX, y: e.pageY}, i = this._normValueFromMouse(t);
            return this._slide(e, this._handleIndex, i), !1
        },
        _mouseStop: function (e) {
            return this.handles.removeClass("ui-state-active"), this._mouseSliding = !1, this._stop(e, this._handleIndex), this._change(e, this._handleIndex), this._handleIndex = null, this._clickOffset = null, this._animateOff = !1, !1
        },
        _detectOrientation: function () {
            this.orientation = "vertical" === this.options.orientation ? "vertical" : "horizontal"
        },
        _normValueFromMouse: function (e) {
            var t, i, s, n, a;
            return "horizontal" === this.orientation ? (t = this.elementSize.width, i = e.x - this.elementOffset.left - (this._clickOffset ? this._clickOffset.left : 0)) : (t = this.elementSize.height, i = e.y - this.elementOffset.top - (this._clickOffset ? this._clickOffset.top : 0)), s = i / t, s > 1 && (s = 1), 0 > s && (s = 0), "vertical" === this.orientation && (s = 1 - s), n = this._valueMax() - this._valueMin(), a = this._valueMin() + s * n, this._trimAlignValue(a)
        },
        _start: function (e, t) {
            var i = {handle: this.handles[t], value: this.value()};
            return this.options.values && this.options.values.length && (i.value = this.values(t), i.values = this.values()), this._trigger("start", e, i)
        },
        _slide: function (e, t, i) {
            var s, n, a;
            this.options.values && this.options.values.length ? (s = this.values(t ? 0 : 1), 2 === this.options.values.length && this.options.range === !0 && (0 === t && i > s || 1 === t && s > i) && (i = s), i !== this.values(t) && (n = this.values(), n[t] = i, a = this._trigger("slide", e, {
                    handle: this.handles[t],
                    value: i,
                    values: n
                }), s = this.values(t ? 0 : 1), a !== !1 && this.values(t, i))) : i !== this.value() && (a = this._trigger("slide", e, {
                    handle: this.handles[t],
                    value: i
                }), a !== !1 && this.value(i))
        },
        _stop: function (e, t) {
            var i = {handle: this.handles[t], value: this.value()};
            this.options.values && this.options.values.length && (i.value = this.values(t), i.values = this.values()), this._trigger("stop", e, i)
        },
        _change: function (e, t) {
            if (!this._keySliding && !this._mouseSliding) {
                var i = {handle: this.handles[t], value: this.value()};
                this.options.values && this.options.values.length && (i.value = this.values(t), i.values = this.values()), this._lastChangedValue = t, this._trigger("change", e, i)
            }
        },
        value: function (e) {
            return arguments.length ? (this.options.value = this._trimAlignValue(e), this._refreshValue(), this._change(null, 0), void 0) : this._value()
        },
        values: function (t, i) {
            var s, n, a;
            if (arguments.length > 1)return this.options.values[t] = this._trimAlignValue(i), this._refreshValue(), this._change(null, t), void 0;
            if (!arguments.length)return this._values();
            if (!e.isArray(arguments[0]))return this.options.values && this.options.values.length ? this._values(t) : this.value();
            for (s = this.options.values, n = arguments[0], a = 0; s.length > a; a += 1)s[a] = this._trimAlignValue(n[a]), this._change(null, a);
            this._refreshValue()
        },
        _setOption: function (t, i) {
            var s, n = 0;
            switch ("range" === t && this.options.range === !0 && ("min" === i ? (this.options.value = this._values(0), this.options.values = null) : "max" === i && (this.options.value = this._values(this.options.values.length - 1), this.options.values = null)), e.isArray(this.options.values) && (n = this.options.values.length), "disabled" === t && this.element.toggleClass("ui-state-disabled", !!i), this._super(t, i), t) {
                case"orientation":
                    this._detectOrientation(), this.element.removeClass("ui-slider-horizontal ui-slider-vertical").addClass("ui-slider-" + this.orientation), this._refreshValue(), this.handles.css("horizontal" === i ? "bottom" : "left", "");
                    break;
                case"value":
                    this._animateOff = !0, this._refreshValue(), this._change(null, 0), this._animateOff = !1;
                    break;
                case"values":
                    for (this._animateOff = !0, this._refreshValue(), s = 0; n > s; s += 1)this._change(null, s);
                    this._animateOff = !1;
                    break;
                case"step":
                case"min":
                case"max":
                    this._animateOff = !0, this._calculateNewMax(), this._refreshValue(), this._animateOff = !1;
                    break;
                case"range":
                    this._animateOff = !0, this._refresh(), this._animateOff = !1
            }
        },
        _value: function () {
            var e = this.options.value;
            return e = this._trimAlignValue(e)
        },
        _values: function (e) {
            var t, i, s;
            if (arguments.length)return t = this.options.values[e], t = this._trimAlignValue(t);
            if (this.options.values && this.options.values.length) {
                for (i = this.options.values.slice(), s = 0; i.length > s; s += 1)i[s] = this._trimAlignValue(i[s]);
                return i
            }
            return []
        },
        _trimAlignValue: function (e) {
            if (this._valueMin() >= e)return this._valueMin();
            if (e >= this._valueMax())return this._valueMax();
            var t = this.options.step > 0 ? this.options.step : 1, i = (e - this._valueMin()) % t, s = e - i;
            return 2 * Math.abs(i) >= t && (s += i > 0 ? t : -t), parseFloat(s.toFixed(5))
        },
        _calculateNewMax: function () {
            var e = this.options.max, t = this._valueMin(), i = this.options.step, s = Math.floor((e - t) / i) * i;
            e = s + t, this.max = parseFloat(e.toFixed(this._precision()))
        },
        _precision: function () {
            var e = this._precisionOf(this.options.step);
            return null !== this.options.min && (e = Math.max(e, this._precisionOf(this.options.min))), e
        },
        _precisionOf: function (e) {
            var t = "" + e, i = t.indexOf(".");
            return -1 === i ? 0 : t.length - i - 1
        },
        _valueMin: function () {
            return this.options.min
        },
        _valueMax: function () {
            return this.max
        },
        _refreshValue: function () {
            var t, i, s, n, a, o = this.options.range, r = this.options, h = this, l = this._animateOff ? !1 : r.animate, u = {};
            this.options.values && this.options.values.length ? this.handles.each(function (s) {
                    i = 100 * ((h.values(s) - h._valueMin()) / (h._valueMax() - h._valueMin())), u["horizontal" === h.orientation ? "left" : "bottom"] = i + "%", e(this).stop(1, 1)[l ? "animate" : "css"](u, r.animate), h.options.range === !0 && ("horizontal" === h.orientation ? (0 === s && h.range.stop(1, 1)[l ? "animate" : "css"]({left: i + "%"}, r.animate), 1 === s && h.range[l ? "animate" : "css"]({width: i - t + "%"}, {
                            queue: !1,
                            duration: r.animate
                        })) : (0 === s && h.range.stop(1, 1)[l ? "animate" : "css"]({bottom: i + "%"}, r.animate), 1 === s && h.range[l ? "animate" : "css"]({height: i - t + "%"}, {
                            queue: !1,
                            duration: r.animate
                        }))), t = i
                }) : (s = this.value(), n = this._valueMin(), a = this._valueMax(), i = a !== n ? 100 * ((s - n) / (a - n)) : 0, u["horizontal" === this.orientation ? "left" : "bottom"] = i + "%", this.handle.stop(1, 1)[l ? "animate" : "css"](u, r.animate), "min" === o && "horizontal" === this.orientation && this.range.stop(1, 1)[l ? "animate" : "css"]({width: i + "%"}, r.animate), "max" === o && "horizontal" === this.orientation && this.range[l ? "animate" : "css"]({width: 100 - i + "%"}, {
                    queue: !1,
                    duration: r.animate
                }), "min" === o && "vertical" === this.orientation && this.range.stop(1, 1)[l ? "animate" : "css"]({height: i + "%"}, r.animate), "max" === o && "vertical" === this.orientation && this.range[l ? "animate" : "css"]({height: 100 - i + "%"}, {
                    queue: !1,
                    duration: r.animate
                }))
        },
        _handleEvents: {
            keydown: function (t) {
                var i, s, n, a, o = e(t.target).data("ui-slider-handle-index");
                switch (t.keyCode) {
                    case e.ui.keyCode.HOME:
                    case e.ui.keyCode.END:
                    case e.ui.keyCode.PAGE_UP:
                    case e.ui.keyCode.PAGE_DOWN:
                    case e.ui.keyCode.UP:
                    case e.ui.keyCode.RIGHT:
                    case e.ui.keyCode.DOWN:
                    case e.ui.keyCode.LEFT:
                        if (t.preventDefault(), !this._keySliding && (this._keySliding = !0, e(t.target).addClass("ui-state-active"), i = this._start(t, o), i === !1))return
                }
                switch (a = this.options.step, s = n = this.options.values && this.options.values.length ? this.values(o) : this.value(), t.keyCode) {
                    case e.ui.keyCode.HOME:
                        n = this._valueMin();
                        break;
                    case e.ui.keyCode.END:
                        n = this._valueMax();
                        break;
                    case e.ui.keyCode.PAGE_UP:
                        n = this._trimAlignValue(s + (this._valueMax() - this._valueMin()) / this.numPages);
                        break;
                    case e.ui.keyCode.PAGE_DOWN:
                        n = this._trimAlignValue(s - (this._valueMax() - this._valueMin()) / this.numPages);
                        break;
                    case e.ui.keyCode.UP:
                    case e.ui.keyCode.RIGHT:
                        if (s === this._valueMax())return;
                        n = this._trimAlignValue(s + a);
                        break;
                    case e.ui.keyCode.DOWN:
                    case e.ui.keyCode.LEFT:
                        if (s === this._valueMin())return;
                        n = this._trimAlignValue(s - a)
                }
                this._slide(t, o, n)
            }, keyup: function (t) {
                var i = e(t.target).data("ui-slider-handle-index");
                this._keySliding && (this._keySliding = !1, this._stop(t, i), this._change(t, i), e(t.target).removeClass("ui-state-active"))
            }
        }
    })
});


/*!
 * jQuery UI Touch Punch 0.2.3
 *
 * Copyright 2011–2014, Dave Furfero
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Depends:
 *  jquery.ui.widget.js
 *  jquery.ui.mouse.js
 */
!function (a) {
    function f(a, b) {
        if (!(a.originalEvent.touches.length > 1)) {
            a.preventDefault();
            var c = a.originalEvent.changedTouches[0], d = document.createEvent("MouseEvents");
            d.initMouseEvent(b, !0, !0, window, 1, c.screenX, c.screenY, c.clientX, c.clientY, !1, !1, !1, !1, 0, null), a.target.dispatchEvent(d)
        }
    }

    if (a.support.touch = "ontouchend" in document, a.support.touch) {
        var e, b = a.ui.mouse.prototype, c = b._mouseInit, d = b._mouseDestroy;
        b._touchStart = function (a) {
            var b = this;
            !e && b._mouseCapture(a.originalEvent.changedTouches[0]) && (e = !0, b._touchMoved = !1, f(a, "mouseover"), f(a, "mousemove"), f(a, "mousedown"))
        }, b._touchMove = function (a) {
            e && (this._touchMoved = !0, f(a, "mousemove"))
        }, b._touchEnd = function (a) {
            e && (f(a, "mouseup"), f(a, "mouseout"), this._touchMoved || f(a, "click"), e = !1)
        }, b._mouseInit = function () {
            var b = this;
            b.element.bind({
                touchstart: a.proxy(b, "_touchStart"),
                touchmove: a.proxy(b, "_touchMove"),
                touchend: a.proxy(b, "_touchEnd")
            }), c.call(b)
        }, b._mouseDestroy = function () {
            var b = this;
            b.element.unbind({
                touchstart: a.proxy(b, "_touchStart"),
                touchmove: a.proxy(b, "_touchMove"),
                touchend: a.proxy(b, "_touchEnd")
            }), d.call(b)
        }
    }
}(jQuery);

!function (e, n, t, o) {
    "use strict";
    function a() {
        return "Microsoft Internet Explorer" == navigator.appName || navigator.userAgent.match(/MSIE\s+\d+\.\d+/) || navigator.userAgent.match(/Trident\/\d+\.\d+/)
    }

    function r(n, t) {
        var o = e("body"), r = o.outerWidth(!0);
        o.addClass(n.lockClass);
        var l = o.outerWidth(!0) - r;
        if (a() && (u = o.css("margin-top"), o.css("margin-top", 0)), 0 != l) {
            var s = e("html, body");
            s.each(function () {
                var n = e(this);
                d[n.prop("tagName").toLowerCase()] = parseInt(n.css("margin-right"))
            }), e("html").css("margin-right", d.html + l), t.css("left", 0 - l)
        }
    }

    function l(n) {
        a() && e("body").css("margin-top", u);
        var t = e("body"), o = t.outerWidth(!0);
        t.removeClass(n.lockClass);
        var r = t.outerWidth(!0) - o;
        0 != r && e("html, body").each(function () {
            var n = e(this);
            n.css("margin-right", d[n.prop("tagName").toLowerCase()])
        })
    }

    function s(o, a) {
        var s = a;
        return o.length ? o.each(function () {
                e(this).data(i + ".options", s)
            }) : e.extend(c, s), e(n).bind("keydown", function (t) {
            if (!t.ctrlKey || 65 != t.keyCode)return !0;
            var o = new e.Event("onSelectAll");
            return o.parentEvent = t, e(n).trigger(o), !0
        }), o.bind("keydown", function (n) {
            var t = e(":focusable", e(this));
            t.filter(":last").is(":focus") && 9 == (n.which || n.keyCode) && (n.preventDefault(), t.filter(":first").focus())
        }), {
            open: function (a) {
                var l = o.get(0), s = e.extend({}, c, e(l).data(i + ".options"), a);
                e("." + s.overlayClass).length && e.modal().close();
                var d = e("<div/>").addClass(s.overlayClass).prependTo("body");
                if (d.data(i + ".options", s), r(s, d), l) {
                    var u = null;
                    s.cloning ? u = e(l).clone(!0).appendTo(d).show() : (d.data(i + ".el", l), e(l).data(i + ".parent", e(l).parent()), u = e(l).appendTo(d).show())
                }
                s.closeOnEsc && e(t).bind("keyup." + i, function (n) {
                    27 === n.keyCode && e.modal().close()
                }), s.closeOnOverlayClick && (d.children().on("click." + i, function (e) {
                    e.stopPropagation()
                }), e("." + s.overlayClass).on("click." + i, function (n) {
                    e.modal().close()
                })), e(t).bind("touchmove." + i, function (n) {
                    e(n).parents("." + s.overlayClass) || n.preventDefault()
                }), l && e(n).bind("onSelectAll", function (e) {
                    e.parentEvent.preventDefault();
                    var o = null, a = null, r = u.get(0);
                    t.body.createTextRange ? (o = t.body.createTextRange(), o.moveToElementText(r), o.select()) : n.getSelection && (a = n.getSelection(), o = t.createRange(), o.selectNodeContents(r), a.removeAllRanges(), a.addRange(o))
                }), s.onOpen && s.onOpen(d, s)
            }, close: function (a) {
                var r = o.get(0), s = e.extend({}, c, e(r).data(i + ".options"), a), d = e("." + s.overlayClass);
                e.isFunction(s.onBeforeClose) && s.onBeforeClose(d, s) === !1 || (s.cloning || (r || (r = d.data(i + ".el")), e(r).hide().appendTo(e(r).data(i + ".parent"))), d.remove(), l(s), s.closeOnEsc && e(t).unbind("keyup." + i), e(n).unbind("onSelectAll"), s.onClose && s.onClose(d, s))
            }
        }
    }

    e.extend(e.expr[":"], {
        focusable: function (n) {
            function t(n) {
                return e.expr.filters.visible(n) && !e(n).parents().addBack().filter(function () {
                        return "hidden" === e.css(this, "visibility")
                    }).length
            }

            var o, a, r, l = n.nodeName.toLowerCase(), s = !isNaN(e.attr(n, "tabindex"));
            if ("area" === l)return o = n.parentNode, a = o.name, n.href && a && "map" === o.nodeName.toLowerCase() ? (r = e("img[usemap=#" + a + "]")[0], !!r && t(r)) : !1;
            var i = s;
            return /input|select|textarea|button|object/.test(l) ? i = !n.disabled : "a" === l && (i = n.href || s), i && t(n)
        }
    });
    var i = "the-modal", c = {
        lockClass: "themodal-lock",
        overlayClass: "themodal-overlay",
        closeOnEsc: !0,
        closeOnOverlayClick: !0,
        onBeforeClose: null,
        onClose: null,
        onOpen: null,
        cloning: !0
    }, d = {}, u = 0;
    e.modal = function (n) {
        return s(e(), n)
    }, e.fn.modal = function (e) {
        return s(this, e)
    }
}(jQuery, window, document);

var AxoScript9473 = new function () {
    var e, t = "sv", n = "SE", a = !1, o = 0, r = {
        NO: {
            "#loan-amount-slider": {
                settings: {
                    value: 15e4,
                    min: 1e4,
                    max: 5e5,
                    step: 5e3,
                    animate: !0,
                    range: "min"
                }, id: "#loan-amount", value: "#loan-amount-value", slide: "updatePayment", stop: "updatePayment"
            }
        },
        SE: {
            "#loan-amount-slider": {
                settings: {value: 2e5, min: 5e3, max: 6e5, step: 5e3, animate: !0, range: "min"},
                id: "#loan-amount",
                value: "#loan-amount-value",
                slide: "updatePayment",
                stop: "updatePayment"
            },
            "#credit-loan-amount-slider": {
                settings: {value: 0, min: 0, max: 6e5, step: 5e3, animate: !0, range: "min"},
                id: "#credit-loan-amount",
                value: "#credit-loan-amount-value",
                slide: "calculateSavings",
                stop: "calculateSavings"
            }
        }
    }, s = {
        "loan-amount": {
            selector: "#loan-amount select",
            range: [5e5, 0],
            exclude: [5e3],
            step: 5e3,
            suffix: " kr",
            selected: 15e4
        },
        "annual-terms": {
            selector: "#form-annual-terms select",
            range: [1, 20],
            suffix: {nb: " år", sv: " år", en: {0: " year", 1: " years"}},
            selected: (function(){
                if ( document.querySelectorAll('.first-step-form').length > 0 ) return 18;
                var data = localStorage.getItem('SEAXOcalcValuesList'),
                    calcValues;
                if (data) {
                    calcValues = JSON.parse(data);
                }
                return calcValues['loanTenureValue'];
            })()
        },
        "employment-type": {
            selector: "#form-employment-type select",
            "first-empty": !0,
            options: {
                nb: {
                    1: "Fast ansatt (privat)",
                    2: "Fast ansatt (offentlig)",
                    3: "Midlertidig ansatt/vikar",
                    4: "Selvst. næringsdrivende",
                    5: "Pensjonist",
                    6: "Student",
                    7: "Uføretrygdet",
                    8: "Arbeidsavklaring/attføring",
                    9: "Arbeidsledig",
                    10: "Langtidssykemeldt"
                },
                sv: {
                    1: "Fast anställd",
                    4: "Egen rörelse",
                    3: "Vikariat",
                    9: "Arbetslös",
                    5: "Pensionär",
                    6: "Studerande",
                    8: "Förtidspensionär"
                },
                en: {
                    1: "Permanent position",
                    4: "Self-employed",
                    3: "Temporary position/contract",
                    9: "Unemployed",
                    5: "Retired",
                    6: "Student"
                }
            }
        },
        "co-employment-type": {
            selector: "#form-co-employment-type select",
            "first-empty": !0,
            options: {
                nb: {
                    1: "Fast ansatt (privat)",
                    2: "Fast ansatt (offentlig)",
                    3: "Midlertidig ansatt/vikar",
                    4: "Selvst. næringsdrivende",
                    5: "Pensjonist",
                    6: "Student",
                    7: "Uføretrygdet",
                    8: "Arbeidsavklaring/attføring",
                    9: "Arbeidsledig",
                    10: "Langtidssykemeldt"
                },
                sv: {
                    1: "Fast anställd",
                    4: "Egen rörelse",
                    3: "Vikariat",
                    9: "Arbetslös",
                    5: "Pensionär",
                    6: "Studerande",
                    8: "Förtidspensionär"
                },
                en: {
                    1: "Permanent position",
                    4: "Self-employed",
                    3: "Temporary position/contract",
                    9: "Unemployed",
                    5: "Retired",
                    6: "Student"
                }
            }
        },
        "employed-since": {
            selector: "#form-employed-since select:not(#employed-since-month),#employed-since-year,#form-co-employed-since select:not(#co-employed-since-month),#co-employed-since-year",
            range: [new Date().getFullYear(), 1960],
            "first-empty": !0
        },
        "employed-since-month": {
            selector: "#employed-since-month,#co-employed-since-month",
            "first-empty": !0,
            options: {
                sv: {
                    1: "Januari",
                    2: "Februari",
                    3: "Mars",
                    4: "April",
                    5: "Maj",
                    6: "Juni",
                    7: "Juli",
                    8: "Augusti",
                    9: "September",
                    10: "Oktober",
                    11: "November",
                    12: "December"
                },
                en: {
                    1: "January",
                    2: "February",
                    3: "March",
                    4: "April",
                    5: "May",
                    6: "June",
                    7: "July",
                    8: "August",
                    9: "September",
                    10: "October",
                    11: "November",
                    12: "December"
                }
            }
        },
        "employed-last": {
            selector: "#form-employed-last select:not(#employed-last-month),#employed-last-year,#form-co-employment-last select:not(#co-employed-since-month),#co-employment-last-year",
            range: [2017, new Date().getFullYear()],
            "first-empty": !0
        },
        "employed-last-month": {
            selector: "#employed-last-month,#co-employment-last-month",
            "first-empty": !0,
            options: {
                sv: {
                    1: "Januari",
                    2: "Februari",
                    3: "Mars",
                    4: "April",
                    5: "Maj",
                    6: "Juni",
                    7: "Juli",
                    8: "Augusti",
                    9: "September",
                    10: "Oktober",
                    11: "November",
                    12: "December"
                },
                en: {
                    1: "January",
                    2: "February",
                    3: "March",
                    4: "April",
                    5: "May",
                    6: "June",
                    7: "July",
                    8: "August",
                    9: "September",
                    10: "October",
                    11: "November",
                    12: "December"
                }
            }
        },
        "address-since": {
            selector: "#form-address-since select:not(#form-address-since-month,#co-address-since-month),#address-since-year,#co-address-since-year",
            range: [new Date().getFullYear(), 1950],
            "first-empty": !0
        },
        "address-since-month": {
            selector: "#form-address-since-month,#co-address-since-month",
            "first-empty": !0,
            options: {
                sv: {
                    1: "Januari",
                    2: "Februari",
                    3: "Mars",
                    4: "April",
                    5: "Maj",
                    6: "Juni",
                    7: "Juli",
                    8: "Augusti",
                    9: "September",
                    10: "Oktober",
                    11: "November",
                    12: "December"
                },
                en: {
                    1: "January",
                    2: "February",
                    3: "March",
                    4: "April",
                    5: "May",
                    6: "June",
                    7: "July",
                    8: "August",
                    9: "September",
                    10: "October",
                    11: "November",
                    12: "December"
                }
            }
        },
        education: {
            selector: "#form-education select",
            "first-empty": !0,
            options: {
                nb: {
                    1: "Grunnskole",
                    2: "Videregående",
                    3: "Høysk./universitet 1-3 år",
                    4: "Høysk./universitet 4+år"
                }
            }
        },
        "co-applicant-education": {
            selector: "#form-co-education select",
            "first-empty": !0,
            options: {
                nb: {
                    1: "Grunnskole",
                    2: "Videregående",
                    3: "Høysk./universitet 1-3 år",
                    4: "Høysk./universitet 4+år"
                }
            }
        },
        "years-in-norway": {selector: "#form-years-in-norway select", range: [1, 20], suffix: " år", "first-empty": !1},
        "co-applicant-years-in-norway": {
            selector: "#form-co-years-in-norway select",
            range: [1, 20],
            suffix: " år",
            "first-empty": !1
        },
        civilstatus: {
            selector: "#form-civilstatus select",
            "first-empty": !0,
            options: {
                nb: {1: "Gift/partner", 2: "Skilt", 3: "Ugift", 4: "Enke/enkemann", 5: "Samboer", 6: "Separert"},
                sv: {1: "Gift", 2: "Sambo", 3: "Ensamstående", 4: "Skild", 5: "Änka/änkling"},
                en: {1: "Married", 2: "Unmarried partner", 3: "Single", 4: "Divorced", 5: "Widow/Widower"}
            }
        },
        "co-civilstatus": {
            selector: "#form-co-civilstatus select",
            "first-empty": !0,
            options: {
                nb: {1: "Gift/partner", 2: "Skilt", 3: "Ugift", 4: "Enke/enkemann", 5: "Samboer", 6: "Separert"},
                sv: {1: "Gift", 2: "Sambo", 3: "Ensamstående", 4: "Skild", 5: "Änka/änkling"},
                en: {1: "Married", 2: "Unmarried partner", 3: "Single", 4: "Divorced", 5: "Widow/Widower"}
            }
        },
        "living-conditions": {
            selector: "#form-living-conditions select",
            "first-empty": !0,
            options: {
                nb: {
                    1: "Selveier",
                    2: "Enebolig",
                    3: "Aksje/andel/borettslag",
                    4: "Leier",
                    5: "Bor hos foreldre"
                },
                sv: {2: "Villa/radhus", 6: "Hyresrätt", 3: "Bostadsrätt", 4: "Inneboende"},
                en: {2: "House/semi-detached house", 6: "Rental", 3: "Co-operative apartment", 4: "Live-in"}
            }
        },
        "co-living-conditions": {
            selector: "#form-co-living-conditions select",
            "first-empty": !0,
            options: {
                nb: {
                    1: "Selveier",
                    2: "Enebolig",
                    3: "Aksje/andel/borettslag",
                    4: "Leier",
                    5: "Bor hos foreldre"
                },
                sv: {2: "Villa/radhus", 6: "Hyresrätt", 3: "Bostadsrätt", 4: "Inneboende"},
                en: {2: "House/semi-detached house", 6: "Rental", 3: "Co-operative apartment", 4: "Live-in"}
            }
        },
        "number-of-children": {
            selector: "#form-number-of-children select",
            range: [0, 9],
            suffix: {nb: " barn", sv: " barn", en: {0: " child", 1: " children"}},
            "first-empty": !0
        },
        loan_purpose: {
            selector: "#form-loan-purpose select",
            "first-empty": !0,
            options: {
                nb: {
                    1: "Selveier",
                    2: "Enebolig",
                    3: "Aksje/andel/borettslag",
                    4: "Leier",
                    5: "Bor hos foreldre"
                },
                sv: {1: "Köpa bil/fordon/båt", 2: "Renovering", 3: "Semester", 4: "Sjukvård", 5: "Övrig konsumtion"},
                en: {1: "Buy vehicle", 2: "Renovate/buy furniture", 3: "Consumption", 4: "Travel", 5: "Other"}
            }
        }
    }, l = {
        "consumer-credit": {startupFee: 495, monthlyFee: 35, nomInterest: .053},
        refinancing: {
            startupFee: 495,
            monthlyFee: 35,
            nomInterest: .053,
            cardsCount: 4,
            cardsMinPay: .03,
            cardsInterest: .17,
            cardsFee: 25
        }
    }, c = "refinancing", d = {
        loanAmount: null,
        creditLoanAmount: null,
        totalLoanAmount: null,
        maxLoanAmount: 5e5,
        annualTerms: null,
        monthlyTerms: null,
        payment: null,
        nomInterest: null,
        effInterest: null,
        irr: null,
        startupFee: null,
        monthlyFee: null,
        nomInterest: null,
        debt: 0,
        monthlySaving: 0,
        totalDebt: 0,
        sumDebt: 0,
        creditLoanInterest: 0
    }, u = {}, p = {
        "consolidate-debt": {value: 0, selectors: []},
        "co-applicant": {value: 0, selectors: []},
        "live-together": {value: 0, selectors: []},
        civilstatus: {value: 0, selectors: ["#form-spouse-income", "#form-number-of-children"]},
        "living-conditions": {
            value: 0,
            selectors: ["#form-rent", "#form-address-since", "#form-rent-income", "#form-refinancing"]
        },
        "co-living-conditions": {value: 0, selectors: ["#form-co-rent", "#form-co-address-since"]},
        "employment-type": {
            value: 0,
            selectors: ["#form-employed-since", "#form-employed-last", "#form-employer", "#form-monthly-income", "#form-work-number"]
        },
        "co-employment-type": {
            value: 0,
            selectors: ["#form-co-employed-since", "#form-co-employed-last", "#form-co-employer", "#form-co-monthly-income", "#form-co-work-number"]
        }
    }, m = !1, f = !1, h = {
        nin: {
            NO: function (e) {
                var t = (e = e.replace(" ", "")).split(""), n = (11 - (3 * t[0] + 7 * t[1] + 6 * t[2] + 1 * t[3] + 8 * t[4] + 9 * t[5] + 4 * t[6] + 5 * t[7] + 2 * t[8]) % 11) % 11, i = (11 - (5 * t[0] + 4 * t[1] + 3 * t[2] + 2 * t[3] + 7 * t[4] + 6 * t[5] + 5 * t[6] + 4 * t[7] + 3 * t[8] + 2 * n) % 11) % 11;
                return 11 == n && (n = 0), n == t[9] && i == t[10]
            }, SE: function (e) {
                var t = String(e.replace(/( |-)/g, ""));
                if (isNotFpn = !1, 0 == t.length)return !1;
                if (11 == t.length)return isNotFpn = !0, !1;
                if (12 == t.length && (t = String(t.substr(2))), isNotFpn)return !1;
                if (10 != t.length || isNaN(t)) {
                    if (11 == t.length)return !1
                } else {
                    switch (imonth = t.substr(2, 2), iday = t.substr(4, 2), imonth) {
                        case"01":
                        case"03":
                        case"05":
                        case"07":
                        case"08":
                        case"10":
                        case"12":
                            (iday < 1 || iday > 31) && (isNotFpn = !0);
                            break;
                        case"04":
                        case"06":
                        case"09":
                        case"11":
                            (iday < 1 || iday > 30) && (isNotFpn = !0);
                            break;
                        case"02":
                            (iday < 1 || iday > 29) && (isNotFpn = !0);
                            break;
                        default:
                            isNotFpn = !0
                    }
                    if (!isNotFpn) {
                        for (i = 0, iValue = 0, iSum = 0; i < t.length - 1 && !isNotFpn;)tChar = t.substr(i, 1), isNaN(tChar) ? isNotFpn = !0 : (iValue = tChar * ((i + 1) % 2 + 1), iValue > 9 && (iValue -= 9), iSum += iValue), i++;
                        if (!isNotFpn && i == t.length - 1 && (10 - iSum % 10) % 10 == t.substr(t.length - 1, 1))return !0
                    }
                }
            }
        }, account: function (e) {
            var t = e.split("");
            return (11 - (5 * t[0] + 4 * t[1] + 3 * t[2] + 2 * t[3] + 7 * t[4] + 6 * t[5] + 5 * t[6] + 4 * t[7] + 3 * t[8] + 2 * t[9]) % 11) % 11 == t[10]
        }, email: function (e) {
            var t = e.lastIndexOf("@");
            if (t < 1)return !1;
            if (t == e.length - 1)return !1;
            if (t > 64)return !1;
            if (e.length - t > 255)return !1;
            var n = e.lastIndexOf(".");
            return n > t + 1 && n < e.length - 1 || "[" == e.charAt(t + 1) && "]" == e.charAt(e.length - 1)
        }
    }, v = {
        email: /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/i,
        mobile: {NO: /^(\+47|47){0,1}([4|9]{1})([0-9]{7})$/, SE: /^[0]{1}[7]{1}[0|2|3|6|9]{1}[0-9]{7}\s*$/},
        phone: {NO: /^(\+47|47){0,1}([1-9]{1})([0-9]{7})$/, SE: /^[0]{1}[\d]{8,10}$/},
        currency: /^[0-9\ ]{1,9} kr$/,
        account_number: /^[0-9]{11}|[0-9]{4}[0-9]{2}[0-9]{5}$/,
        currency_integer: /^[0-9]{1,7}/,
        text: /^[^0-9]+$/,
        number: /^\d{5}$|^\d{8}$/
    };
    this.getValidationRegex = function () {
        return v
    };
    var g = {
        frameClass: "dept-frame creditor-frame border-col",
        frameSelectorClass: ".dept-frame.creditor-frame",
        frameMainClass: "creditor-frame",
        frameAfterClass: "add-creditor-frame",
        creditorClass: "col form-row-normal form-row-input-text",
        creditorLabel: "Lånegiver/kortutsteder:",
        creditorInput: {classCSS: "input-text validate", type: "text", name: "lender"},
        balanceClass: "col form-row-normal form-row-input-text other-debt-balance",
        balanceLabel: "Saldo (kr):",
        balanceInput: {classCSS: "input-text currency validate-currency validate", type: "tel", name: "balance"},
        frameCounter: 0
    };
    this.addEvents = function () {
        $("#consolidate-debt-1,#consolidate-debt-").change(function () {
            $(this).is(":checked") && (p["consolidate-debt"].value = parseInt($(this).val())), a = !!p["consolidate-debt"].value, c = p["consolidate-debt"].value ? "refinancing" : "consumer-credit", AxoScript9473.setLoanData(), AxoScript9473.calculateLoan(), AxoScript9473.updateLoanFields(), AxoScript9473.getLoanAmount(), AxoScript9473.recalculateLoanUpdateFields(), $("#form-refinancing").trigger("conditionChange"), $("#form-loan-purpose").trigger("conditionChange")
        }), $("#co-applicant-1,#co-applicant-").change(function () {
            $(this).is(":checked") && (p["co-applicant"].value = parseInt($(this).val())), $(".form-main").trigger("conditionChange"), $("#personal-details-co-applicant, .collapse2").trigger("conditionChange"), $("#form-spouse-income").trigger("conditionChange")
        }), $("#live-together-1,#live-together-").change(function () {
            $(this).is(":checked") && (p["live-together"].value = parseInt($(this).val())), $(".form-main").trigger("conditionChange"), $("#form-co-civilstatus").trigger("conditionChange"), $("#form-co-living-conditions, #form-co-rent, #form-co-address-since").trigger("conditionChange")
        }), $("#norwegian-1,#norwegian-").change(function () {
            p.norwegian.value = parseInt($(this).val()), $("#form-years-in-norway").trigger("conditionChange"), $("#form-contry-origin").trigger("conditionChange")
        }), $("#co-applicant-norwegian-1,#co-applicant-norwegian-").change(function () {
            p["co-applicant-norwegian"].value = parseInt($(this).val()), $("#form-co-years-in-norway").trigger("conditionChange")
        }), $("#form-totale-unsecured-debt input").change(function () {
            d.totalDebt = parseInt($(this).val()), $("#form-total-unsecured-debt-refinance").trigger("conditionChange"), $(".creditor-frame").trigger("conditionChange")
        }), $("#form-interest-low,#form-interest-medium,#form-interest-high").change(function () {
            d.creditLoanInterest = parseInt($(this).val()), $("#form-interest-rate").trigger("conditionChange")
        }), $("#loan-amount").bind("valueChange", function () {
            AxoScript9473.getLoanAmount(), AxoScript9473.recalculateLoanUpdateFields()
        }), $("#form-annual-terms select").bind("valueChange", function () {
            AxoScript9473.getAnnualTerms(), AxoScript9473.recalculateLoanUpdateFields()
        }), $(".form-main").bind("conditionChange", function () {
            p["co-applicant"].value ? $(this).addClass("with-co-applicant") : $(this).removeClass("with-co-applicant")
        }), $("#personal-details-co-applicant, .collapse2").bind("conditionChange", function () {
            p["co-applicant"].value ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-contry-origin").bind("conditionChange", function () {
            p.norwegian.value ? $(this).slideUp(0) : $(this).slideDown(0)
        }), $("#form-years-in-norway").bind("conditionChange", function () {
            p.norwegian.value ? $(this).slideUp(0) : $(this).slideDown(0)
        }), $("#form-co-years-in-norway").bind("conditionChange", function () {
            p["co-applicant-norwegian"].value ? $(this).slideUp(0) : $(this).slideDown(0)
        }), $("#consolidate-loan-footnote").bind("conditionChange", function () {
            d.totalLoanAmount ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#consolidate-loan-footnote-savings").bind("conditionChange", function () {
            d.creditLoanAmount ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-total-unsecured-debt-refinance").bind("conditionChange", function () {
            var e = d.sumDebt, t = AxoScript9473.getCurrencyFormat(d.totalDebt) + " kr", n = AxoScript9473.getCurrencyFormat(e) + " kr";
            $(".total-unsecured-debt").text(t), $(".total-unsecured-debt-refinance-sum").text(n), d.sumDebt && d.totalDebt ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $(".creditor-frame").bind("conditionChange", function () {
            d.totalDebt ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-interest-rate").bind("conditionChange", function () {
            AxoScript9473.calculateSavings()
        }), $("#form-number-of-children").bind("conditionChange", function () {
            $.inArray(p.civilstatus.value, [1, 2, 3, 4, 5]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-spouse-income").bind("conditionChange", function () {
            !p["co-applicant"].value && $.inArray(p.civilstatus.value, [1, 5]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-rent").bind("conditionChange", function () {
            $.inArray(p["living-conditions"].value, [3, 4, 6]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-address-since").bind("conditionChange", function () {
            $.inArray(p["living-conditions"].value, [2, 3, 4, 6]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-rent-income").bind("conditionChange", function () {
            $.inArray(p["living-conditions"].value, [1, 2, 3]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-monthly-income").bind("conditionChange", function () {
            p["employment-type"].value > 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-employer, #form-work-number").bind("conditionChange", function () {
            $.inArray(p["employment-type"].value, [1, 2, 3, 4]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-employed-since").bind("conditionChange", function () {
            $.inArray(p["employment-type"].value, [1, 2, 4]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-employed-last").bind("conditionChange", function () {
            $.inArray(p["employment-type"].value, [3]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-co-monthly-income").bind("conditionChange", function () {
            p["co-employment-type"].value > 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-co-employer, #form-co-work-number").bind("conditionChange", function () {
            $.inArray(p["co-employment-type"].value, [1, 2, 3, 4]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-co-employed-since").bind("conditionChange", function () {
            $.inArray(p["co-employment-type"].value, [1, 2, 4]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-co-employed-last").bind("conditionChange", function () {
            $.inArray(p["co-employment-type"].value, [3]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-co-living-conditions").bind("conditionChange", function () {
            0 == p["live-together"].value ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-co-rent").bind("conditionChange", function () {
            0 == p["live-together"].value && $.inArray(p["co-living-conditions"].value, [3, 4, 6]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-co-address-since").bind("conditionChange", function () {
            0 == p["live-together"].value && $.inArray(p["co-living-conditions"].value, [2, 3, 4, 6]) >= 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-alimony-per-month").bind("conditionChange", function () {
            p["number-of-children"].value > 0 ? $(this).slideDown(0) : $(this).slideUp(0)
        }), $("#form-loan-purpose").bind("conditionChange", function () {
            p["consolidate-debt"].value ? $("#form-loan-purpose").slideUp(0) : $("#form-loan-purpose").slideDown(0)
        }), $("#form-refinancing").bind("conditionChange", function () {
            p["consolidate-debt"].value ? $("#form-refinancing").slideDown(0) : $("#form-refinancing").slideUp(0)
        }), $(window).load(function () {
            AxoScript9473.validate()
        }), e.find("input, select").change(function () {
            AxoScript9473.validate(), f || AxoScript9473.storeValue($(this))
        }), e.find("input, select").focus(function () {
            $(this).is(":not([type=checkbox])") && AxoScript9473.addWarning($(this)), m || (m = !0)
        }), e.find("input, select").blur(function () {
            if (AxoScript9473.removeWarning($(this)), AxoScript9473.validate(), $(this).hasClass("not-valid") && $(window).width() <= 760) {
                for (var e = $("input,select").filter(":visible"), t = (e.index(this), !1), n = !1, i = !1, a = 0; a < e.length; a++)$(e[a]).is(this) && (t = !0), $(e[a]).is($(event.relatedTarget)) && (n = !0, i = 1 != t);
                if (1 == n && 1 == t) {
                    if (1 == i) {
                        o = $(this).offset().top - $(event.relatedTarget).offset().top;
                        $(window).height() / 2 > o + 30 && $("html, body").animate({scrollTop: $(event.relatedTarget).offset().top - 30}, 400)
                    }
                    if (0 == i) {
                        var o = $(event.relatedTarget).offset().top - $(this).offset().top;
                        $(window).height() / 2 > o && $("html, body").animate({scrollTop: $(event.relatedTarget).offset().top - o - 30}, 400)
                    }
                }
            }
        }), e.find(".add-creditor").not(function () {
            return !!$(this).data("InputEventSet")
        }).click(function (e) {
            e.preventDefault(), AxoScript9473.addOtherDebt()
        }).data("InputEventSet", "true")
    }, this.getAB = function (e) {
        return $.get("/inc/ALL/" + e, function (e) {
            $("body").append(e)
        }), !1
    }, this.addInputEvents = function () {
        e.find("input.currency").not(function () {
            return !!$(this).data("InputEventSet")
        }).focus(function () {
            var e = AxoScript9473.getValueFieldName($(this).attr("name")), t = $(this).parent().find("input[name='" + e + "']");
            void 0 === t.val() && (t = $("<input />").addClass("value-field").attr("type", "hidden").attr("name", e).attr("value", ""), $(this).parent().append(t)), $(this).val(t.val())
        }), e.find("input.currency").not(function () {
            return !!$(this).data("InputEventSet")
        }).blur(function () {
            var e = AxoScript9473.getValueFieldName($(this).attr("name")), t = $(this).parent().find("input[name='" + e + "']"), n = parseInt(AxoScript9473.stripCharsCurrency($(this).val()));
            n >= 0 ? (t.val(n), formatedVal = AxoScript9473.getCurrencyFormat(n), $(this).val(formatedVal + " kr"), u[$(this).attr("name")] = n) : (t.val(""), u[$(this).attr("name")] = ""), AxoScript9473.validate()
        }), $(this).find("input, select").not(function () {
            return !!$(this).data("InputEventSet")
        }).focus(function () {
            $(this).addClass("in-focus"), $(this).parent().addClass("in-focus-parent"), $(this).parents("section").addClass("in-focus in-focus-active"), $(this).parents("section").siblings().removeClass("in-focus")
        }).blur(function () {
            $(this).removeClass("in-focus empty"), $(this).parent().removeClass("in-focus-parent parent-empty"), $(this).parents("section").removeClass("in-focus-active")
        }).data("InputEventSet", "true")
    }, this.addDropdowns = function () {
        $.each(s, function (e, n) {
            if (void 0 !== n.options && void 0 !== n.options[t] && (void 0 !== n["first-empty"] && n["first-empty"] && AxoScript9473.addDropdownOption("", "", n.selector), $.each(n.options[t], function (e, t) {
                    AxoScript9473.addDropdownOption(e, t, n.selector)
                }), $(n.selector).data("Options", n.options[t]), $(n.selector).change(function () {
                    var e = $(this).data("Options"), t = AxoScript9473.getValueFieldName($(this).attr("name")), n = $(this).parent().find("input[name='" + t + "']"), i = e[$(this).val()];
                    void 0 === n.val() ? (n = $("<input />").addClass("value-field").attr("type", "hidden").attr("name", t).attr("value", i), $(this).parent().append(n)) : n.val(i)
                }), void 0 !== $(n.selector).data("selected") && String($(n.selector).data("selected")) && (n.selected = $(n.selector).data("selected")), void 0 !== n.selected && String(n.selected) && $(n.selector).val(n.selected)), void 0 !== n.range) {
                var a = [];
                void 0 !== n["first-empty"] && n["first-empty"] && a.push("");
                var o = 1;
                for (void 0 !== n.step && n.step && (o = n.step), i = Math.max(n.range[0], n.range[1]); i >= Math.min(n.range[0], n.range[1]); i -= o)(void 0 === n.exclude || $.inArray(i, n.exclude)) && a.push(i);
                n.range[0] < n.range[1] && a.sort(function (e, t) {
                    return e - t
                }), $.each(a, function (e, i) {
                    text = i, void 0 !== n.suffix && "" !== i && ("object" == typeof n.suffix ? "object" == typeof n.suffix[t] ? text = "1" == text ? text + n.suffix[t][0] : text + n.suffix[t][1] : text += n.suffix[t] : text += n.suffix), AxoScript9473.addDropdownOption(i, text, n.selector)
                }), void 0 !== $(n.selector).data("selected") && String($(n.selector).data("selected")) && (n.selected = $(n.selector).data("selected")), void 0 !== n.selected && String(n.selected) && $(n.selector).val(n.selected)
            }
            $(n.selector).change(function () {
                void 0 !== p[e] && (p[e].value = parseInt($(this).val()), void 0 !== p[e].selectors && $.each(p[e].selectors, function (e, t) {
                    $(t).trigger("conditionChange")
                })), $(this).trigger("valueChange")
            })
        })
    }, this.addDropdownOption = function (t, n, i) {
        var a = $("<option/>");
        a.val(t), a.text(n), e.find(i).append(a)
    }, this.setPopCookie = function (e, t, n) {
        var i = new Date;
        i.setDate(i.getDate() + n);
        var a = escape(t) + (null == n ? "" : "; expires=" + i.toUTCString());
        document.cookie = e + "=" + a
    }, this.getPopCookie = function (e) {
        var t, n, i, a = document.cookie.split(";");
        for (t = 0; t < a.length; t++)if (n = a[t].substr(0, a[t].indexOf("=")), i = a[t].substr(a[t].indexOf("=") + 1), (n = n.replace(/^\s+|\s+$/g, "")) == e)return unescape(i)
    };
    var y = 0, b = 0, x = 0, C = 0;
    $(".intercom-launcher-frame").bind("click", function () {
        y = 1
    }), $("#nextstepbutton").bind("click", function () {
        AxoScript9473.setPopCookie("overlay_up", "1", 1)
    }), this.popUpOverlay = function (e, t) {
        popCookie = AxoScript9473.getPopCookie("overlay_up"), window.onload = function () {
            popCookie
        }, C = e, 1 == t && C ? window.addEventListener("mouseout", function (e) {
                b = setTimeout(function () {
                    (x = e.clientY) <= 0 && 0 == y && 1 != popCookie && (AxoScript9473.getAB(1), y = 1, AxoScript9473.setPopCookie("overlay_up", "1", 1))
                }, C)
            }, !1) : 0 != t && void 0 != t || window.addEventListener("mouseout", function (e) {
                b = setTimeout(function () {
                    (x = e.clientY) <= 0 && 0 == y && 1 != popCookie && (AxoScript9473.getAB(1), y = 1, AxoScript9473.setPopCookie("overlay_up", "1", 1))
                }, 2e3)
            }, !1), window.addEventListener("mouseover", function (e) {
            clearTimeout(b)
        }), $(".form-body, .form-body *, .ui-slider-handle").bind("click", function () {
            var e = 0;
            $(document).ready(function () {
                function t() {
                    (e += 1) > 29 && 0 == y && 1 != popCookie && (AxoScript9473.getAB(1), y = 1, AxoScript9473.setPopCookie("overlay_up", "1", 1))
                }

                setInterval(t, 1e3);
                $(this).mousemove(function (t) {
                    e = 0
                }), $(this).keypress(function (t) {
                    e = 0
                }), $("input").focus(function (t) {
                    e = 0
                })
            })
        })
    }, this.popUpMobile = function () {
        if ($(window).width() < 760) {
            popCookie = AxoScript9473.getPopCookie("overlay_up");
            var e = 0;
            $(document).ready(function () {
                function t() {
                    (e += 1) > 14 && 0 == y && 1 != popCookie && (AxoScript9473.getAB(1), y = 1, AxoScript9473.setPopCookie("overlay_up", "1", 1))
                }

                setInterval(t, 1e3);
                document.addEventListener("touchmove", function (t) {
                    e = 0
                }), $(this).keypress(function (t) {
                    e = 0
                }), $("input").focus(function (t) {
                    e = 0
                })
            })
        }
    }, this.addDefaults = function () {
        e.find("#consolidate-debt-1").is(":not(:checked)") && e.find("#consolidate-debt-").is(":not(:checked)") && (p["consolidate-debt"].value ? e.find("#consolidate-debt-1").prop("checked", !0) : e.find("#consolidate-debt-").prop("checked", !0))
    }, this.addSliders = function () {
        void 0 !== r[n] && $.each(r[n], function (t, n) {
            var i = $(t), a = e.find(n.value).val() ? e.find(n.value).val() : n.settings.value;
            i.slider({
                value: a,
                min: n.settings.min,
                max: n.settings.max,
                step: n.settings.step,
                animate: n.settings.animate,
                range: n.settings.range,
                slide: function (e, t) {
                    AxoScript9473.setSliderValue(n.value, n.id, t.value, n.type), window.AxoScript9473[n.slide]()
                },
                stop: function (e, t) {
                    AxoScript9473.setSliderValue(n.value, n.id, t.value, n.type), window.AxoScript9473[n.stop]()
                }
            }), AxoScript9473.setSliderValue(n.value, n.id, i.slider("value"), n.type), "#credit-loan-amount-slider" == t && $(i).first().children().first().addClass("blue"), $(n.id).focus(function () {
                $(this).attr("type", "tel").val($(n.value).val())
            }), $(n.id).blur(function () {
                $(n.id).attr("type", "text");
                var e = AxoScript9473.getCleanValue(this);
                e ? e < i.slider("option", "min") || e > i.slider("option", "max") ? e < n.settings.min ? (e = n.settings.min, i.slider("value", n.settings.min)) : e > n.settings.max ? (e = n.settings.max, i.slider("value", n.settings.max)) : e = i.slider("value") : (i.slider("option", "step", 1), i.slider("value", e), i.slider("option", "step", n.settings.step)) : 0 != e ? e = i.slider("value") : (e = 1, i.slider("option", "step", 1), i.slider("value", e), i.slider("option", "step", n.settings.step), AxoScript9473.setSliderValue(n.value, n.id, e, n.type), e = 0), AxoScript9473.setSliderValue(n.value, n.id, e, n.type), window.AxoScript9473[n.stop]()
            })
        })
    }, this.stripChars = function (e) {
        return e.replace(/(\.| |\D|,-)/g, "")
    }, this.stripCharsCurrency = function (e) {
        return -1 !== e.indexOf(",") && (e = e.substring(0, e.indexOf(","))), e = e.replace(/(\.| |\D|,-)/g, "")
    }, this.stripFpn = function (e) {
        return 12 == (e = e.replace("-", "")).length && (e = e.substring(2)), e
    }, this.getCurrencyFormat = function (e) {
        var t = String(e), n = "";
        for (i = 0; i < t.length; i++)n += (t.length - i && (t.length - i) % 3 ? "" : " ") + t.charAt(i);
        return n
    }, this.getValueFieldName = function (e) {
        return "value_" + e.replace("-", "_")
    }, this.getCleanValue = function (e) {
        return 0 == $(e).val() ? 0 : parseInt($(e).val().replace(/\./g, "").replace(/ /g, ""))
    }, this.setSliderValue = function (e, t, n, i) {
        switch ($(e).val(n), formatedVal = AxoScript9473.getCurrencyFormat(n), i) {
            case"years":
                $(t).val(formatedVal + " år");
                break;
            default:
                $(t).val(formatedVal + " kr")
        }
    }, this.addOtherDebt = function (t) {
        var n = $("<div/>").addClass(g.frameClass), i = $("<label/>").addClass("label"), a = $("<div/>").addClass(g.creditorClass).append(i), o = $("<div/>").addClass("value text"), r = $("<input/>").addClass(g.creditorInput.classCSS).attr("type", g.creditorInput.type).attr("name", g.creditorInput.name + "[" + g.frameCounter + "]");
        r.focus(function () {
            AxoScript9473.addWarning($(this))
        }), r.blur(function () {
            AxoScript9473.removeWarning($(this))
        }), o.append($('<span class="warning-message-wrapper"><span class="warning-message">Navn på lånegiver/kortutsteder hvor restsaldo skal refinansieres, eks. Cresco.</span><span class="warning-message-arrow"></span></span>')), o.append(r), i.append($("<span/>").addClass("desc").html(g.creditorLabel)), i.append(o);
        var s = $("<label/>").addClass("label"), l = $("<div/>").addClass(g.balanceClass).append(s), c = $("<div/>").addClass("value text"), u = $("<input/>").addClass(g.balanceInput.classCSS).attr("type", g.balanceInput.type).attr("name", g.balanceInput.name + "[" + g.frameCounter + "]");
        u.focus(function () {
            AxoScript9473.addWarning($(this))
        }), u.blur(function () {
            AxoScript9473.removeWarning($(this)), $(this).val() ? r.addClass("required") : r.removeClass("required")
        }), r.focus(function () {
            AxoScript9473.addWarning($(this))
        }), r.blur(function () {
            AxoScript9473.removeWarning($(this)), $(this).val() ? u.addClass("required") : u.removeClass("required")
        }), u.change(function () {
            var e = parseInt($(this).val().replace(/\./g, "").replace(/ /g, ""));
            e || (e = 0), n.data("other-debt-value", e), AxoScript9473.calculateRefinanceSum(e), $("#form-total-unsecured-debt-refinance").trigger("conditionChange")
        }), c.append($('<span class="warning-message-wrapper"><span class="warning-message">Beløp som skal refinansieres</span><span class="warning-message-arrow"></span></span>')), c.append(u), s.append($("<span/>").addClass("desc").html(g.balanceLabel)), s.append(c), void 0 !== t && t || n.append($("<div/>").addClass("col")), n.append(a), n.append(l), n.bind("conditionChange", function () {
            d.totalDebt ? $(this).slideDown(0) : $(this).slideUp(0)
        });
        var p = $("<a/>").addClass("remove-creditor ingen-link").text("Fjern gjeldspost");
        p.click(function () {
            AxoScript9473.removeOtherDebt(n)
        }), s.append(p), void 0 !== t && t ? n.addClass("first") : n.addClass("border-col"), n.hide(), e.find("." + g.frameAfterClass).before(n), e.find("input.currency").not(function () {
            return !!$(this).data("InputEventSet")
        }).focus(function () {
            var e = AxoScript9473.getValueFieldName($(this).attr("name")), t = $(this).parent().find("input[name='" + e + "']");
            void 0 === t.val() && (t = $("<input />").addClass("value-field").attr("type", "hidden").attr("name", e).attr("value", ""), $(this).parent().append(t)), $(this).val(t.val())
        }), g.frameCounter++, n.slideDown(0), void 0 !== t && t || n.find("input").eq(0).focus(), this.addInputEvents()
    }, this.removeOtherDebt = function (e) {
        e.slideUp(function () {
            e.remove(), AxoScript9473.calculateRefinanceSum(0), $("#form-total-unsecured-debt-refinance").trigger("conditionChange")
        })
    }, this.recalculateLoanUpdateFields = function () {
        AxoScript9473.calculateLoan(), AxoScript9473.updateLoanFields()
    }, this.updatePayment = function () {
        AxoScript9473.getLoanAmount(), AxoScript9473.recalculateLoanUpdateFields()
    }, this.updatePaymentFields = function () {
        $("#monthly-amount").text(AxoScript9473.getCurrencyFormat(d.payment)), $("#annual-terms").text(d.annualTerms), $("#consolidate-loan-footnote,#consolidate-loan-footnote-savings").trigger("conditionChange"), $("#loan-amount-value").trigger("change")
    }, this.updateRefinancingFields = function () {
        $("#monthly-saving").text(AxoScript9473.getCurrencyFormat(d.monthlySaving)), $("#total-loan-amount").text(AxoScript9473.getCurrencyFormat(d.totalLoanAmount)), $("#loan-amount-saving").text(AxoScript9473.getCurrencyFormat(d.loanAmount)), $("#debt").text(AxoScript9473.getCurrencyFormat(d.debt)), $("#payment").text(AxoScript9473.getCurrencyFormat(d.payment)), $("#annual-terms-info").text(AxoScript9473.getCurrencyFormat(d.annualTerms));
        var e = 100 * d.nomInterest;
        $("#nom-interest").text(AxoScript9473.getCurrencyFormat(e))
    }, this.getLoanAmount = function () {
        $("#loan-amount").val() && (d.loanAmount = parseInt($("#loan-amount-value").val()))
    }, this.getAnnualTerms = function () {
        $("#form-annual-terms select").val() && (d.annualTerms = parseInt($("#form-annual-terms select").val()))
    }, this.calculateLoan = function () {
        AxoScript9473.calculatePayment(), AxoScript9473.calculateRefinancing()
    }, this.updateLoanFields = function () {
        AxoScript9473.updatePaymentFields(), AxoScript9473.updateRefinancingFields()
    }, this.setLoanData = function () {
        var e = l[c];
        d.startupFee = e.startupFee, d.monthlyFee = e.monthlyFee, d.nomInterest = e.nomInterest, void 0 !== e.cardsCount ? d.cardsCount = e.cardsCount : d.cardsCount = 0, void 0 !== e.cardsMinPay ? d.cardsMinPay = e.cardsMinPay : d.cardsMinPay = 0, void 0 !== e.cardsFee ? d.cardsFee = e.cardsFee : d.cardsFee = 0
    }, this.calculatePayment = function () {
        var e = d.totalLoanAmount = d.loanAmount;
        "SE" == n && (e = d.totalLoanAmount = d.loanAmount), d.monthlyTerms = 12 * d.annualTerms;
        var t = d.nomInterest / 12;
        Math.pow(1 + t, d.monthlyTerms);
        d.payment = 0 == Math.round(e * t / (1 - Math.pow(1 + t, -d.monthlyTerms))) ? Math.round(e * t / (1 - Math.pow(1 + t, -d.monthlyTerms))) : Math.round(e * t / (1 - Math.pow(1 + t, -d.monthlyTerms))) + d.monthlyFee
    }, this.calculateRefinanceSum = function (e) {
        void 0 !== e && (e = 0);
        var t = parseInt(e);
        $(g.frameSelectorClass).each(function () {
            void 0 !== $(this).data("other-debt-value") && (t += $(this).data("other-debt-value"))
        }), d.sumDebt = t
    }, this.calculateEffInterest = function () {
        var e = d.totalLoanAmount;
        d.irr = AxoScript9473.calculateIRR(d.annualTerms, d.payment + d.monthlyFee, d.startupFee, e, 2 * d.nomInterest, 4), effInterest = Math.pow(d.irr / 12 + 1, 12) - 1
    }, this.calculateRefinancing = function () {
        d.totalLoanAmount;
        AxoScript9473.calculateEffInterest();
        var e = d.creditLoanAmount * l.refinancing.cardsInterest / (1 - Math.pow(1 + l.refinancing.cardsInterest, -d.annualTerms)) + l.refinancing.monthlyFee, t = d.creditLoanAmount * l.refinancing.nomInterest / (1 - Math.pow(1 + l.refinancing.nomInterest, -d.annualTerms)) + l.refinancing.monthlyFee;
        d.monthlySaving = Math.round(Math.max(e - t, 0)), d.monthlySaving < 0 && (d.monthlySaving = 0)
    }, this.calculateIRR = function (e, t, n, a, o, r) {
        var s = e * t + n, l = o;
        for (i = 0; i < r; i++) {
            var c = 1 / (1 + l / 12), d = n + t * (Math.pow(c, e + 1) - c) / (c - 1);
            l = l * Math.log(a / s) / Math.log(d / s)
        }
        return l
    }, this.addError = function (e) {
        e.parent("div,label").addClass("error")
    }, this.removeError = function (e) {
        e.parent("div,label").removeClass("error")
    }, this.addWarning = function (e) {
        e.parent("div,label").addClass("warning"), this.removeError(e)
    }, this.removeWarning = function (e) {
        e.parent("div,label").removeClass("warning")
    }, this.setFormStarted = function () {
        m = !0
    }, this.storeValue = function (t) {
        if (m && !t.hasClass("not-valid")) {
            var n = {}, i = t.attr("name"), a = t.val();
            a && (n[i] = a, n["loan-amount"] = $("#loan-amount-value").val(), n["credit-loan-amount"] = $("#credit-loan-amount-value").val(), n.source = $("#form_element-2").val(), n.origin = $("#origin").val(), jQuery.post("/incomplete/value", n, function (t) {
                if (1 == t.refresh) {
                    var n = {};
                    n.tenure = $("select[name='tenure']").val(), e.find("input.valid, select.valid").filter(":visible").each(function () {
                        var e = $(this);
                        n[e.attr("name")] = e.val()
                    }), e.find("input[type=radio]").filter(":visible").filter(":checked").each(function () {
                        var e = $(this);
                        n[e.attr("name")] = e.val()
                    }), jQuery.post("/incomplete/value", n, function (e) {
                    })
                }
            }))
        }
    }, this.storePopupValue = function () {
        var e = {};
        e.source = $("#form_element-2").val(), e.mobile_number = $("#popup-number").val(), e.email = $("#popup-email").val(), jQuery.post("/incomplete/value", e, function (e) {
        })
    }, this.validateHiddenFields = function () {
    }, this.validate = function () {
        AxoScript9473.validateHiddenFields(), e.find("input.validate").each(function () {
            var e = $(this);
            if (e.val() && e.is(":not([type=checkbox])")) {
                var t = !0;
                e.is("input.validate-email") && (e.val(e.val().toLowerCase()), t = v.email.test(e.val())), e.is("input.validate-phone") && (e.val(e.val().replace(/ /g, "")), e.val(e.val().replace(/-/g, "")), t = v.phone[n].test(e.val())), e.is("input.validate-mobile") && (e.val(e.val().replace(/ /g, "")), e.val(e.val().replace(/-/g, "")), t = v.mobile[n].test(e.val())), !e.is("input.validate-currency") || v.currency_integer.test(e.val()) || v.currency.test(e.val()) || (t = !1), e.is("input.validate-clearing-number") && (e.val(AxoScript9473.stripChars(e.val())), t = v.clearing.test(e.val())), e.is("input.validate-account-number") && (e.val(AxoScript9473.stripChars(e.val())), t = v.account_number.test(e.val())), e.is("input.validate-birth-number") && (e.val(AxoScript9473.stripChars(e.val())), t = h.nin[n](AxoScript9473.stripChars(e.val()))), e.is("input.validate-text") && (t = v.text.test(e.val())), e.is("input.validate-number") && (t = v.number.test(e.val())), e.is(":checkbox") && (t = e.is(":checked")), t ? (e.removeClass("not-valid"), e.parent().removeClass("error"), e.addClass("valid"), e.parent().addClass("parent-valid")) : (e.addClass("not-valid"), e.parent().addClass("error"), e.removeClass("valid"), e.parent().removeClass("parent-valid"))
            } else e.removeClass("not-valid"), e.parent().removeClass("error"), e.removeClass("valid"), e.parent().removeClass("parent-valid")
        }), e.find("select.required:visible").not(function () {
            return $(this).parent().removeClass("error"), !$(this).val()
        }).addClass("valid").parent().addClass("parent-valid"), e.find("select.required:visible").not(function () {
            return !!$(this).val()
        }).removeClass("valid").parent().removeClass("parent-valid"), e.find("input[type=checkbox]").each(function () {
            $(this).parent().removeClass("error")
        })
    }, this.formSubmit = function () {
        e.find("input, select").keydown(function (e) {
            if (13 == e.keyCode) {
                var t = $("input,select").filter(":visible"), n = t.index(this);
                $(t[n + 1]).focus()
            }
            return 13 != e.keyCode
        }), this.expand = function (e) {
            e ? ($("#div-nextstepbutton").hide(), $(".collapse1").slideDown(700)) : ($("#div-nextstepbutton").hide(), $(".collapse1").show(0))
        }, e.submit(function (t) {
            AxoScript9473.validate();
            var n = [];
            if (n = $.merge(n, $(e).find(".col:not(:hidden) input.not-valid")), n = $.merge(n, $(e).find("input.required:checkbox").not(":checked")), n = $.merge(n, $(e).find("input.required:visible:not(:checkbox)").not(".valid")), (n = $.merge(n, $(e).find(".col:not(:hidden) select.required:visible").not(function () {
                    return !!$(this).val()
                }))).length) {
                var i = 9999;
                return $.each(n, function () {
                    $(this).offset().top < i && (i = $(this).offset().top), AxoScript9473.addError($(this))
                }), $(window).width() < 760 ? $("html, body").animate({scrollTop: i - 80}, 400) : $("html, body").animate({scrollTop: i - 150}, 400), !1
            }
            if (0 == o && $(".collapse1").length)return t.preventDefault(), o++, AxoScript9473.expand(!0), !0;
            $("#submitbutton").attr("disabled", "disabled"), setTimeout(function () {
                $("#submitbutton").removeAttr("disabled")
            }, 5e3), $(this).find("input.strip-non-numeric").each(function () {
                $(this).val(AxoScript9473.stripChars($(this).val()))
            }), $(this).find("input, select").not(":visible").not("[type='hidden']").prop("disabled", !0), $("#creditor-wrapper").find("input").each(function () {
                if ("" == $(this).val()) {
                    var e = $(this).prop("name").substring($(this).prop("name").length - 3);
                    $("input[name='lender" + e + "']").prop("disabled", !0), $("input[name='balance" + e + "']").prop("disabled", !0), $("input[name='value_balance" + e + "']").prop("disabled", !0)
                }
            }), $("input[name='social_number']").val(AxoScript9473.stripFpn($("input[name='social_number']").val())), $("input[name='co_social_number']").val(AxoScript9473.stripFpn($("input[name='co_social_number']").val()))
        })
    }, this.setLanguage = function (e) {
        t = e
    }, this.setCountry = function (e) {
        n = e
    }, this.triggerConditionChanges = function () {
        var t = e.find("div.col-set > div"), n = e.find("label");
        t.each(function () {
            $(this).trigger("conditionChange")
        }), n.each(function () {
            $(this).trigger("conditionChange")
        }), $(window).resize(function () {
            e.find("div.col-set").find("div:first").trigger("conditionChange")
        }), $("#consolidate-debt-1,#consolidate-debt-").trigger("change"), $("#co-applicant-1,#co-applicant-").trigger("change"), $("#live-together-1,#live-together-").trigger("change")
    }, this.setLoadingUFS = function (e) {
        f = e
    }, this.expandAll = function () {
        return o++, AxoScript9473.expand(!0), !0
    }, this.calculateSavings = function () {
        var e, t, n = parseInt($("#credit-loan-amount").val()), i = 3 * n + 250, a = 0;
        switch (d.creditLoanInterest) {
            case 2:
                t = .16;
                break;
            case 1:
                t = .12;
                break;
            default:
                t = .079
        }
        var o, r, s, l, c, u, p, m, f, h, v, g, y = t / 12;
        n <= 49999 ? (e = 6, o = 79.2453598652384, r = 1.52690720787511, s = 81.7944458372244, l = 1.49528583619753, c = 78.3634909071655, u = 1.39854295588512, p = 1.55246579863121, m = 0, f = .341614127979564, h = 173.559911682757, v = 112.970069082305, g = 96.9289778621888) : n <= 99999 ? (e = 8, o = 82.4487812988896, r = 1.57483636995205, s = 84.0348535729425, l = 1.56068678376424, c = 86.6014432500973, u = 1.53463327188172, p = 1.48205946411662, m = .000595739340496984, f = .11391550850553, h = 144.496042047555, v = 114.29042607758, g = 4e-7) : n <= 149999 ? (e = 10, o = 85.3544886549982, r = 1.62588602054154, s = 84.8553645222529, l = 1.61439389054325, c = 86.517044739803, u = 1.58101114530264, p = 1.46819044293564, m = .0130386356155918, f = .00649627272079261, h = 188.402250920233, v = 68.487900742208, g = 0) : n <= 224999 ? (e = 12, o = 93.1916016708001, r = 1.71805926898794, s = 93.4121263586605, l = 1.72605820088287, c = 90.6892860081513, u = 1.65274598068976, p = 1.482773609121, m = .00370214227165084, f = 5e-7, h = 222.811572642394, v = 45.0027026414537, g = 0) : (e = 12, o = 94.8229152064281, r = 1.77702488925962, s = 93.2549321788427, l = 1.77964197048846, c = 99.5402205388138, u = 1.75239615564156, p = 1.49098276680788, m = 0, f = 6e-7, h = 260.616071149818, v = 28.3485507333505, g = 0);
        var b = 12 * e;
        Math.pow(1 + t / 12, 12);
        switch (d.creditLoanInterest) {
            case 2:
                c, u;
                break;
            case 1:
                s, l;
                break;
            default:
                o, r
        }
        var x, i = (n + 950) * y / (1 - Math.pow(1 + y, -12 * e)) + 30, C = (Math.pow(1 + .079 / 12, -12 * e), Math.log(n / 1e5), Math.LN10, Math.round(.03 * n - i)), a = (p + m * n / 1e5 + f * (Math.log(n / 1e5) / Math.LN10)) * n, S = i * b - n;
        switch (d.creditLoanInterest) {
            case 2:
                x = "høy";
                break;
            case 1:
                x = "middels";
                break;
            default:
                x = "lav"
        }
        $("#interest-level").html(x), $("#monthly-savings").html(AxoScript9473.getCurrencyFormat(Math.round(C)) + " kr"), $("#total-cost-card").html(AxoScript9473.getCurrencyFormat(Math.round(a)) + " kr"), $("#total-cost-loan").html(AxoScript9473.getCurrencyFormat(Math.round(S)) + " kr")
    }, this.init = function (t) {
        window.jQuery && window.$ && window.jQuery === window.$ ? jQuery.isReady ? (e = jQuery(t), this.addSliders(), this.addDropdowns(), this.addDefaults(), this.addEvents(), this.addInputEvents(), this.getLoanAmount(), this.getAnnualTerms(), this.setLoanData(), this.calculatePayment(), this.calculateRefinancing(), this.updateLoanFields(), this.addOtherDebt(!0), this.formSubmit(), this.triggerConditionChanges(), "undefined" != typeof initiateUFS && ufs()) : console.error("DOM is not loaded.") : console.error("jQuery missing.")
    }
};
$(document).ready(function () {
    function e(e) {
        e.preventDefault(), $("#responsive-menu").toggleClass("open-menu")
    }

    $(".owl-carousel").owlCarousel({
        loop: !0,
        margin: 40,
        nav: !0,
        items: 5,
        autoWidth: !0,
        center: !0,
        autoplay: !0,
        autoplayTimeout: 2e3,
        autoplayHoverPause: !0
    }), $("#close-footer-form").click(function (e) {
        e.preventDefault(), $("#footer-contact-form").slideUp(0)
    }), $("nav .open-contact-form, #footer-menu .open-contact-form").click(function (e) {
        e.preventDefault(), $("#footer-contact-form").slideDown(0), $("html, body").animate({scrollTop: $("#footer-contact-form").offset().top}, 250)
    }), $("nav#responsive-menu .dropdown > a, nav#responsive-menu .dropdown > .dropdown-button").click(function (e) {
        e.preventDefault();
        var t = $(this).parent(), n = t.children(".dropdown-button");
        t.toggleClass("open"), n.text("+" === n.text() ? "—" : "+")
    }), $(document).on("click", "#mobile-main-menu .toggle-menu", e), $("#toTopBtn, #ingressToForm").click(function () {
        $("html, body").animate({scrollTop: $("#axo-form-small").offset().top}, 750)
    }), $(".quicklink­button­one > a").click(function (e) {
        e.preventDefault(), "/låna-pengar" === window.location.href ? $("html, body").animate({scrollTop: $("#axo-form-small").offset().top}, 750) : (window.location.href = "/låna-pengar", $("html, body").animate({scrollTop: $("#axo-form-small").offset().top}, 750))
    }), $(".quicklink­button­two > a").click(function (e) {
        e.preventDefault(), "/lösa-lån" === window.location.href ? $("html, body").animate({scrollTop: $("#axo-form-small").offset().top}, 750) : (window.location.href = "/lösa-lån", $("html, body").animate({scrollTop: $("#axo-form-small").offset().top}, 750))
    })
}), jQuery(function (e) {
    if (e(".close-call-me-x .closewindow").click(function () {
            e("#call-me-panel").fadeOut(300), e("#call-me-panel-thanks").fadeOut(300), e("#lightbox").fadeOut(300)
        }), e(".open-call-me").click(function (t) {
            t.preventDefault(), e("#lightbox").fadeIn(300), e("#call-me-panel").fadeIn(300)
        }), e("#call-me-send").click(function (t) {
            t.preventDefault();
            var n = e("#maybe").find("input.required"), i = e("#call_me_num"), a = e("#whichhelp");
            i.val(), i.val(i.val().replace(/ /g, "")), i.val(i.val().replace(/-/g, ""));
            var o = !0, r = e("#whichhelp option:selected").text(), s = e("#whichhelp option:selected").val(), l = e("#call_me_num").val();
            if (n.each(function () {
                    e(this).val() || (e(this).parent().addClass("error"), o = !1)
                }), AxoScript9473.getValidationRegex().phone.SE.test(l) ? i.parent().removeClass("error") : (i.parent().addClass("error"), o = !1), "" == r ? (e("#whichhelp").parent().addClass("error"), o = !1) : e("#whichhelp").parent().removeClass("error"), o) {
                i.parent().removeClass("error"), a.parent().removeClass("error");
                e.post("/ajaxo/sendtlf", {valg: s, number: l}, function () {
                    e("#call-me-panel-thanks .action-before-words p").html("Tack!</br>Du valde: " + r + "</br>Telefonnummer: " + l + "</br></br>Vi ringer så fort vi kan"), e("#call-me-panel").fadeOut(300), e("#call-me-panel-thanks").fadeIn(300), e("#call_me_num").val(""), e("#whichhelp").val(0)
                })
            } else e("#call_me_num").addClass("not-valid")
        }), e("body").on("click", "#open-terms-modal", function (t) {
            t.preventDefault(), e("#terms-modalbox").modal().open()
        }), e(".terms-modal .close").on("click", function (t) {
            t.preventDefault(), e.modal().close()
        }), e("#footer-contact-form").length) {
        var t = e("#footer-contact-form"), n = t.find("input.validate-email"), i = t.find("input"), a = t.find("input.required");
        t.hide(), e("#contact-sent").hide(), e(".contact-icon").click(function (n) {
            n.preventDefault(), e("#footer-contact-form").fadeIn(300), e(window).width() >= 1 && e("html, body").animate({scrollTop: t.offset().top}, 400)
        }), i.each(function () {
            e(this).focus(function () {
                e(this).parent().removeClass("error")
            })
        }), e("#contact-submit").click(function (i) {
            var o = !0;
            i.preventDefault(), a.each(function () {
                e(this).val() || (e(this).parent().addClass("error"), o = !1)
            }), AxoScript9473.getValidationRegex().email.test(n.val()) || (n.parent().addClass("error"), o = !1), o && (e.post("/ajaxo/contactfooter", {
                contactname: e("#contactname").val(),
                contactemail: e("#contactemail").val(),
                contacttext: e("#contacttext").val()
            }, function () {
                e("#contact-sent").fadeIn(300), e(window).width() >= 1 && e("html, body").animate({scrollTop: parseInt(e("#contact-sent").offset().top)}, 400)
            }), t.fadeOut(300))
        }), e(".contact-close-link").click(function (t) {
            t.preventDefault(), e("#contact-sent").fadeOut(300), e(window).width() >= 1 && e("html, body").animate({scrollTop: e("#footer").offset().top}, 400)
        })
    }
});