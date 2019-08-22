function isMacintosh() {
    return navigator.platform.indexOf("Mac") > -1
}

function isLinux() {
    return navigator.platform.indexOf("Linux") > -1
}

function urlRedirect(n) {
    window.location.href = n
}

function getIEVersion() { 
    var n = window.navigator.userAgent,
        t = n.indexOf("MSIE");
    return t > 0 ? parseInt(n.substring(t + 5, n.indexOf(".", t))) : navigator.userAgent.match(/Trident\/7\./) ? 11 : 0
}

function getMSEdge() {
    var n = window.navigator.userAgent,
        t = n.indexOf("Edge/");
    return t > 0 ? !0 : !1
}

function getMOZFirefox() {
    var n = window.navigator.userAgent,
        t = n.indexOf("Firefox/");
    return t > 0 ? !0 : !1
}

function clientOverrides() {
    var n, t, i;
    isMacintosh() && jQuery("body").addClass("t-macos");
    isLinux() && jQuery("body").addClass("t-linux");
    n = getIEVersion();
    n > 0 && jQuery("body").addClass("t-browser-ie t-browser-ie-" + n);
    t = getMSEdge();
    t && jQuery("body").addClass("t-browser-msedge");
    i = getMOZFirefox();
    i && jQuery("body").addClass("t-browser-firefox");
    isMobile.any() && jQuery("body").addClass("t-browser-mobile");
    isMobile.iOS() && jQuery("body").addClass("t-browser-mobile-ios");
    isMobile.Android() && (jQuery("body").addClass("t-browser-mobile-android"), isMobile.AndroidFirefox() ? jQuery("body").addClass("t-browser-mobile-android-firefox") : isMobile.AndroidWebkit() && jQuery("body").addClass("t-browser-mobile-android-webkit"))
}

function windowAdjustOnBrowserResize() {
    var i = 1e3,
        t = null,
        r = null,
        n = !1,
        u = function() {
            n = !1;
            jQuery(window).trigger("resizeend", r);
            jQuery("body").width() != win_w && (win_w = jQuery("body").width());
            contentShowMore()
        };
    typeof win_w == "undefined" && (win_w = jQuery("body").width());
    jQuery(window).resize(function(r) {
        r = r || r;
        clearTimeout(t);
        n || (jQuery(window).trigger("resizestart", r), n = !0);
        t = setTimeout(u, i)
    })
}

function windowScrollSetPosCls(n, t) {
    var i = jQuery("body");
    t ? i.addClass("t-scroll-pos-" + n) : i.removeClass("t-scroll-pos-" + n)
}

function windowScrollProcess() {
    var e = jQuery("body"),
        l = jQuery(".js-site-header"),
        a = l[0].getBoundingClientRect(),
        i, o, s, t, h, r, u, f;
    if (a.top < 0 ? windowScrollSetPosCls(1, !0) : windowScrollSetPosCls(1, !1), i = jQuery('main article[rel="detalhe-artigo"] h1[rel="headline"]').eq(0), o = jQuery(".js-sticky-article-id").eq(0), i.length && o.length && (s = i[0].getBoundingClientRect(), s.bottom - 44 < 0 ? windowScrollSetPosCls(3, !0) : windowScrollSetPosCls(3, !1)), t = jQuery('main article[rel="detalhe-artigo"]').eq(0), h = jQuery(".js-sticky-article-related").eq(0), t.length && h.length) {
        var v = t[0].getBoundingClientRect(),
            n = 250,
            c = t.find(".t-af1-c1-sb").eq(0);
        c.length && (n = n + c.outerHeight());
        r = t.find(".t-af-comments-1").eq(0);
        r.length && (n = n + r.outerHeight());
        u = t.find(".t-af-sidebar-1").eq(0);
        u.length && (n = n + u.outerHeight());
        v.bottom - n < 0 ? windowScrollSetPosCls(4, !0) : windowScrollSetPosCls(4, !1)
    }
    f = "interaction-adjust-footer-pub";
    jQuery(".js-footer .t-pubbox-bb-1").outerHeight() > 10 ? e.addClass(f) : e.removeClass(f)
}

function windowScrollInit() {
    var n = jQuery(".js-site-header");
    windowScrollProcess();
    jQuery(window).scroll(function() {
        windowScrollProcess()
    });
    n.headroom({
        offset: 250,
        tolerance: 5
    })
}

function appOverlayCloseActions() {
    var n = jQuery("body");
    n.append('<em class="t-overlay-shadow js-overlay-shadow"><\/em>')
}

function appOverlayCloseBoxes() {
    var n = jQuery("body");
    n.removeClass("interaction-overlay-body-overflow interaction-overlay-box-mainsidebar-open interaction-overlay-box-useracc-open")
}

function appOverlayMainSidebarActions() {
    var i = jQuery("body"),
        r = ".js-mainsidebar-toggle";
    i.off("click touchstart", r).on("click touchstart", r, function() {
        appOverlayCloseBoxes();
        appOverlayMainSidebarOpen()
    });
    var u = jQuery(".js-mainmenu"),
        n = u.find(".js-submenu"),
        f = n.length,
        t = 0;
    n.each(function() {
        if (jQuery(this).attr("jsdata-submenu-idx", t).append('<span class="t-submenu-btn js-submenu-btn"><\/span>'), t++, t === f) i.off("click", ".js-mainmenu ul li .js-submenu-btn").on("click", ".js-mainmenu ul li .js-submenu-btn", function() {
            var t = jQuery(this).parent("li"),
                i = t.attr("jsdata-submenu-idx"),
                r = t.find("ul");
            t.is(".open") ? n.removeClass("open").find("ul").slideUp(200) : (n.not('[jsdata-submenu-idx="' + i + '"]').removeClass("open").find("ul").slideUp(200), t.addClass("open"), r.slideDown())
        })
    })
}

function appOverlayMainSidebarOpen() {
    var n = jQuery("body"),
        t = jQuery(".js-overlay-mainsidebar-content");
    t.scrollTop(0);
    jQuery(".js-mainmenu .js-submenu").removeClass("open").find("ul").hide();
    n.addClass("interaction-overlay-body-overflow interaction-overlay-box-mainsidebar-open")
}

function appOverlayUserAccountActions() {
    var t = jQuery("body"),
        n = ".js-useraccount-toggle";
    t.off("click touchstart", n).on("click touchstart", n, function() {
        appOverlayCloseBoxes();
        appOverlayUserAccountOpen()
    })
}

function appOverlayUserAccountOpen() {
    var n = jQuery("body"),
        t = jQuery(".js-overlay-useracc-content");
    t.scrollTop(0);
    n.addClass("interaction-overlay-body-overflow interaction-overlay-box-useracc-open")
}

function appOverlaysDismissInit() {
    jQuery("body").off("click", ".js-overlays-dismiss-1").on("click", ".js-overlays-dismiss-1", function() {
        appOverlayCloseBoxes()
    })
}

function appContentDismissInit() {
    jQuery("body").off("click", ".js-content-dismiss-1").on("click", ".js-content-dismiss-1", function() {
        var n = jQuery(this).closest(".js-content-dismiss-root"),
            t;
        t = n.is(".js-content-dismiss-target") ? n : n.find(".js-content-dismiss-target");
        n.is(".t-cticker-live") ? SaveCookie("TickerDireto", 1, !0) : n.is(".t-cticker-jed") ? SaveCookie("JogosAoVivo", 1, !0) : n.is(".t-cticker-now") && SaveCookie("UltimaHora", 1, !0);
        t.slideUp(600, "easeInOutQuint")
    })
}

function appTickersInit() {
    jQuery(".js-list-ticker-1").each(function() {
        var n = jQuery(this),
            t = n.find("ul"),
            i = n.outerWidth(),
            r = t.outerWidth();
        r > i && jQuery(this).jConveyorTicker({
            anim_duration: 180,
            reverse_elm: !1
        })
    });
    jQuery(".js-list-ticker-2").each(function() {
        var n = jQuery(this),
            t = n.find("ul"),
            i = n.outerWidth(),
            r = t.outerWidth();
        r > i && jQuery(this).jConveyorTicker({
            anim_duration: 100,
            reverse_elm: !1
        })
    })
}

function slidersInit() {
    var n, t;
    jQuery(".js-article-slider-1").each(function() {
        jQuery(this).hasClass("owl-loaded") && jQuery(this).owlCarousel("destroy");
        jQuery(this).find(".item").length > 1 ? jQuery(this).owlCarousel({
            items: 1,
            loop: !1,
            margin: 0,
            dots: !1,
            nav: !0,
            navSpeed: 600,
            autoHeight: !0,
            lazyLoad: !0,
            animateOut: "fadeOut",
            navText: ["<span>Anterior<\/span>", "<span>Seguinte<\/span>"],
            onInitialized: function(n) {
                jQuery(n.target).find(".owl-stage-outer").removeClass("t-slider-working");
                setTimeout(function() {
                    jQuery(n.target).trigger("refresh.owl.carousel")
                }, 100)
            }
        }) : jQuery(this).show()
    });
    n = ".js-pubbox-peps-slider";
    jQuery(n).each(function() {
        jQuery(this).hasClass("owl-loaded") && jQuery(this).owlCarousel("destroy");
        jQuery(this).find(".item").length > 1 ? jQuery(this).owlCarousel({
            loop: !1,
            margin: 10,
            dots: !1,
            nav: !0,
            navSpeed: 600,
            lazyLoad: !0,
            items: 1,
            onInitialized: function(n) {
                jQuery(n.target).find(".owl-stage-outer").removeClass("t-slider-working");
                setTimeout(function() {
                    jQuery(n.target).trigger("refresh.owl.carousel")
                }, 100)
            }
        }) : jQuery(this).show()
    });
    t = ".js-sticky-article-slider";
    jQuery(t).each(function() {
        jQuery(this).hasClass("owl-loaded") && jQuery(this).owlCarousel("destroy");
        jQuery(this).find(".item").length > 1 ? jQuery(this).owlCarousel({
            loop: !1,
            margin: 14,
            dots: !1,
            nav: !1,
            navSpeed: 600,
            autoWidth: !0,
            items: 1,
            onInitialized: function(n) {
                jQuery(n.target).find(".owl-stage-outer").removeClass("t-slider-working");
                setTimeout(function() {
                    jQuery(n.target).trigger("refresh.owl.carousel")
                }, 100)
            }
        }) : jQuery(this).show()
    })
}

function contentShowMore() {
    var n = jQuery("body");
    if (jQuery(".js-content-sm-1").each(function() {
            var t = jQuery(this),
                u = t.find(".js-content-sm-full"),
                i = t.css("min-height"),
                r;
            i = i.split("px")[0];
            r = u.outerHeight();
            n.is(".interaction-sm-btns-set") || t.append('<span aria-label="Ver mais" class="t-btn-6 t-sm-btn js-sm-btn"><\/span>');
            !n.is(".js-content-sm-triggered") && r > i ? t.addClass("t-content-sm-ready js-content-sm-ready") : t.removeClass("t-content-sm-ready js-content-sm-ready")
        }), jQuery(".js-sm-btn").length && !n.is(".interaction-sm-btns-set")) {
        n.off("click", ".js-sm-btn").on("click", ".js-sm-btn", function() {
            var n = jQuery(this).closest(".js-content-sm-root");
            n.is(".js-content-sm-ready") && n.addClass("t-content-sm-triggered js-content-sm-triggered")
        });
        n.addClass("interaction-sm-btns-set")
    }
}

function contentCollapse() {
    var n = jQuery("body");
    n.off("click", ".js-contentcollapse-toggle").on("click", ".js-contentcollapse-toggle", function() {
        var n = jQuery(this).closest(".js-contentcollapse-root");
        n.slideUp(500)
    })
}

function articleReadMore() {
    jQuery(".js-a-content-rm").each(function() {
        var n = jQuery(this),
            t = n.closest('[rel="detalhe-artigo"]'),
            i = n.find(".js-a-content-rm-full").eq(0),
            r = i.outerHeight(),
            u = n.find(".js-a-content-top-elm-ref").eq(0),
            f = u.outerHeight(),
            e = n.find(".js-a-content-body-elm-targ").eq(0),
            o = e.outerHeight(),
            s = f + o;
        t.is('[data-truncated="true"]') ? (n.css("max-height", s), n.addClass("t-a-content-rm t-a-content-rm-ready js-a-content-rm-ready")) : r > 800 ? n.addClass("t-a-content-rm t-a-content-rm-ready js-a-content-rm-ready") : jQuery(".js-a-pub-rm-1").removeClass("t-a-pub-rm")
    })
}

function appDropDowns() {
    var i = jQuery("body"),
        n = "focusin",
        t = "focusout";
    isMobile.any() && (n = "touchstart", t = "touchend");
    i.off(n + " " + t, ".js-dd-1").on(n, ".js-dd-1", function() {
        jQuery(this).addClass("open")
    }).on(t, ".js-dd-1", function() {
        setTimeout(function() {
            jQuery(".js-dd-1").removeClass("open")
        }, 500)
    })
}

function tabSys1() {
    jQuery("body").off("click", ".js-tabs-sys-1 .js-tabs-sys-1-index li").on("click", ".js-tabs-sys-1 .js-tabs-sys-1-index li", function() {
        var t = "current",
            n, i;
        jQuery(this).hasClass(t) || (n = jQuery(this).closest(".js-tabs-sys-1"), jQuery(this).siblings("li").removeClass(t), jQuery(this).addClass(t), n.find(".js-tabs-sys-1-content > div").hide(), i = n.children(".js-tabs-sys-1-index").find("li").index(n.children(".js-tabs-sys-1-index").find("." + t + ":eq(0)")), n.find(".js-tabs-sys-1-content > div").eq(i).fadeIn())
    })
}

function jsEncodeURI(n) {
    return encodeURIComponent(n).replace(/!/g, "%21").replace(/'/g, "%27").replace(/\(/g, "%28").replace(/\)/g, "%29").replace(/\*/g, "%2A")
}

function appGetWinURL1() {
    var n = window.location.href.split("#media-");
    return n.length > 1 ? n[1] : !1
}

function appChangeWinURL1(n) {
    var t = window.location.href.split("#media-");
    window.history.replaceState && (n > 0 ? window.history.replaceState("", "", t[0] + "#media-" + n) : window.history.replaceState("", "", t[0]))
}

function appArticleLightbox1Slider(n) {
    window.lightbox_gallery_1 = jQuery(n).lightSlider({
        item: 1,
        mode: "fade",
        loop: !0,
        pager: !1,
        adaptiveHeight: !0,
        slideMargin: 0,
        slideMove: 1,
        speed: 600,
        easing: "cubic-bezier(0.25, 0, 0.25, 1)",
        onSliderLoad: function() {
            var n = appGetWinURL1();
            n && jQuery('body.t-body-article main.t-main article[rel="detalhe-artigo"] figure[rel="img-artigo"] img[data-lb-pos*="' + n + '"]').click()
        },
        onAfterSlide: function(n) {
            var i = n.getCurrentSlideCount(),
                t;
            appChangeWinURL1(i);
            t = n.find(".lslide.active figure figcaption").html();
            jQuery(".js-lb-sb-captions").html(t)
        }
    })
}

function appArticleLightbox1Init() {
    var n = jQuery(".js-lb-wrap-1"),
        t = jQuery('body.t-body-article main.t-main article[rel="detalhe-artigo"] figure[rel="img-artigo"]'),
        i = jQuery('body.t-body-article main.t-main article[rel="detalhe-artigo"] h1[rel="headline"]').eq(0).text();
    if (n.length) {
        t.each(function(r) {
            var o = jQuery(this),
                u = o.find('img[itemprop="image"]'),
                e, f, s;
            if (u.length) {
                u.attr("data-lb-pos", "media-" + (r + 1));
                e = u.data("src");
                u.is("[data-hires-src]") && (e = u.data("hires-src"));
                f = o.find("figcaption").html();
                typeof f == "undefined" && (f = "");
                s = jQuery('<li><figure itemscope itemtype="http://schema.org/ImageObject" itemprop="image"><img itemprop="image" src="' + e + '" alt="" /><figcaption>' + f + "<\/figcaption><\/figure><\/li>");
                n.find(".js-lb-content-items").append(s);
                r + 1 === t.length && (jQuery("body").addClass("interaction-article-lightbox-ready interaction-article-lightbox-closed"), appArticleLightbox1Slider(".js-lb-content-items"), jQuery(".js-lb-sb-pretitle em").text(t.length), jQuery(".js-lb-sb-title span").text(i));
                u.on("click", function() {
                    typeof lightbox_gallery_1 != "undefined" ? (lightbox_gallery_1.goToSlide(r + 1), appChangeWinURL1(r + 1)) : lightbox_gallery_1.goToSlide(1);
                    n.scrollTop(0);
                    jQuery("body").removeClass("interaction-article-lightbox-closed").addClass("interaction-overlay-body-overflow interaction-article-lightbox-open")
                })
            }
        });
        jQuery("body").off("click", ".js-lb-close").on("click", ".js-lb-close", function() {
            jQuery("body").removeClass("interaction-article-lightbox-open");
            setTimeout(function() {
                jQuery("body").removeClass("interaction-overlay-body-overflow").addClass("interaction-article-lightbox-closed");
                appChangeWinURL1(0)
            }, 700)
        });
        jQuery("body").off("click", ".js-lb-sb-share-fb").on("click", ".js-lb-sb-share-fb", function() {
            var n = jsEncodeURI(window.location.href),
                t = "http://www.facebook.com/sharer/sharer.php?u=" + n;
            return window.open(t, "dn-share-facebook", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,left=660,top=190,width=600,height=600"), !1
        });
        jQuery("body").off("click", ".js-lb-sb-share-tw").on("click", ".js-lb-sb-share-tw", function() {
            var n = jsEncodeURI(document.title),
                t = jsEncodeURI(window.location.href),
                i = "https://twitter.com/intent/tweet?url=" + t + "&amp;text=" + n;
            return window.open(i, "dn-share-twitter", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,left=660,top=190,width=600,height=600"), !1
        });
        jQuery("body").off("click", ".js-lb-sb-share-comment").on("click", ".js-lb-sb-share-comment", function() {
            return jQuery(".js-lb-close").click(), jQuery("html, body").stop().animate({
                scrollTop: jQuery(".t-af-comments-1").offset().top - 100
            }, 3e3), !1
        })
    }
}! function(n, t) {
    "use strict";
    "object" == typeof module && "object" == typeof module.exports ? module.exports = n.document ? t(n, !0) : function(n) {
        if (!n.document) throw new Error("jQuery requires a window with a document");
        return t(n)
    } : t(n)
}("undefined" != typeof window ? window : this, function(n, t) {
    "use strict";

    function hr(n, t, i) {
        var r, u = (t = t || f).createElement("script");
        if (u.text = n, i)
            for (r in df) i[r] && (u[r] = i[r]);
        t.head.appendChild(u).parentNode.removeChild(u)
    }

    function it(n) {
        return null == n ? n + "" : "object" == typeof n || "function" == typeof n ? bt[or.call(n)] || "object" : typeof n
    }

    function hi(n) {
        var t = !!n && "length" in n && n.length,
            i = it(n);
        return !u(n) && !tt(n) && ("array" === i || 0 === t || "number" == typeof t && t > 0 && t - 1 in n)
    }

    function v(n, t) {
        return n.nodeName && n.nodeName.toLowerCase() === t.toLowerCase()
    }

    function li(n, t, r) {
        return u(t) ? i.grep(n, function(n, i) {
            return !!t.call(n, i, n) !== r
        }) : t.nodeType ? i.grep(n, function(n) {
            return n === t !== r
        }) : "string" != typeof t ? i.grep(n, function(n) {
            return wt.call(t, n) > -1 !== r
        }) : i.filter(t, n, r)
    }

    function wr(n, t) {
        while ((n = n[t]) && 1 !== n.nodeType);
        return n
    }

    function ne(n) {
        var t = {};
        return i.each(n.match(l) || [], function(n, i) {
            t[i] = !0
        }), t
    }

    function ut(n) {
        return n
    }

    function dt(n) {
        throw n;
    }

    function br(n, t, i, r) {
        var f;
        try {
            n && u(f = n.promise) ? f.call(n).done(t).fail(i) : n && u(f = n.then) ? f.call(n, t, i) : t.apply(void 0, [n].slice(r))
        } catch (n) {
            i.apply(void 0, [n])
        }
    }

    function ni() {
        f.removeEventListener("DOMContentLoaded", ni);
        n.removeEventListener("load", ni);
        i.ready()
    }

    function re(n, t) {
        return t.toUpperCase()
    }

    function y(n) {
        return n.replace(te, "ms-").replace(ie, re)
    }

    function at() {
        this.expando = i.expando + at.uid++
    }

    function ee(n) {
        return "true" === n || "false" !== n && ("null" === n ? null : n === +n + "" ? +n : ue.test(n) ? JSON.parse(n) : n)
    }

    function dr(n, t, i) {
        var r;
        if (void 0 === i && 1 === n.nodeType)
            if (r = "data-" + t.replace(fe, "-$&").toLowerCase(), "string" == typeof(i = n.getAttribute(r))) {
                try {
                    i = ee(i)
                } catch (n) {}
                o.set(n, t, i)
            } else i = void 0;
        return i
    }

    function tu(n, t, r, u) {
        var s, h, c = 20,
            l = u ? function() {
                return u.cur()
            } : function() {
                return i.css(n, t, "")
            },
            o = l(),
            e = r && r[3] || (i.cssNumber[t] ? "" : "px"),
            f = (i.cssNumber[t] || "px" !== e && +o) && vt.exec(i.css(n, t));
        if (f && f[3] !== e) {
            for (o /= 2, e = e || f[3], f = +o || 1; c--;) i.style(n, t, f + e), (1 - h) * (1 - (h = l() / o || .5)) <= 0 && (c = 0), f /= h;
            f *= 2;
            i.style(n, t, f + e);
            r = r || []
        }
        return r && (f = +f || +o || 0, s = r[1] ? f + (r[1] + 1) * r[2] : +r[2], u && (u.unit = e, u.start = f, u.end = s)), s
    }

    function oe(n) {
        var r, f = n.ownerDocument,
            u = n.nodeName,
            t = ai[u];
        return t || (r = f.body.appendChild(f.createElement(u)), t = i.css(r, "display"), r.parentNode.removeChild(r), "none" === t && (t = "block"), ai[u] = t, t)
    }

    function ft(n, t) {
        for (var e, u, f = [], i = 0, o = n.length; i < o; i++)(u = n[i]).style && (e = u.style.display, t ? ("none" === e && (f[i] = r.get(u, "display") || null, f[i] || (u.style.display = "")), "" === u.style.display && ti(u) && (f[i] = oe(u))) : "none" !== e && (f[i] = "none", r.set(u, "display", e)));
        for (i = 0; i < o; i++) null != f[i] && (n[i].style.display = f[i]);
        return n
    }

    function s(n, t) {
        var r;
        return r = "undefined" != typeof n.getElementsByTagName ? n.getElementsByTagName(t || "*") : "undefined" != typeof n.querySelectorAll ? n.querySelectorAll(t || "*") : [], void 0 === t || t && v(n, t) ? i.merge([n], r) : r
    }

    function vi(n, t) {
        for (var i = 0, u = n.length; i < u; i++) r.set(n[i], "globalEval", !t || r.get(t[i], "globalEval"))
    }

    function eu(n, t, r, u, f) {
        for (var e, o, p, a, w, v, h = t.createDocumentFragment(), y = [], l = 0, b = n.length; l < b; l++)
            if ((e = n[l]) || 0 === e)
                if ("object" === it(e)) i.merge(y, e.nodeType ? [e] : e);
                else if (fu.test(e)) {
            for (o = o || h.appendChild(t.createElement("div")), p = (ru.exec(e) || ["", ""])[1].toLowerCase(), a = c[p] || c._default, o.innerHTML = a[1] + i.htmlPrefilter(e) + a[2], v = a[0]; v--;) o = o.lastChild;
            i.merge(y, o.childNodes);
            (o = h.firstChild).textContent = ""
        } else y.push(t.createTextNode(e));
        for (h.textContent = "", l = 0; e = y[l++];)
            if (u && i.inArray(e, u) > -1) f && f.push(e);
            else if (w = i.contains(e.ownerDocument, e), o = s(h.appendChild(e), "script"), w && vi(o), r)
            for (v = 0; e = o[v++];) uu.test(e.type || "") && r.push(e);
        return h
    }

    function ri() {
        return !0
    }

    function et() {
        return !1
    }

    function su() {
        try {
            return f.activeElement
        } catch (n) {}
    }

    function yi(n, t, r, u, f, e) {
        var o, s;
        if ("object" == typeof t) {
            "string" != typeof r && (u = u || r, r = void 0);
            for (s in t) yi(n, s, r, u, t[s], e);
            return n
        }
        if (null == u && null == f ? (f = r, u = r = void 0) : null == f && ("string" == typeof r ? (f = u, u = void 0) : (f = u, u = r, r = void 0)), !1 === f) f = et;
        else if (!f) return n;
        return 1 === e && (o = f, (f = function(n) {
            return i().off(n), o.apply(this, arguments)
        }).guid = o.guid || (o.guid = i.guid++)), n.each(function() {
            i.event.add(this, t, f, u, r)
        })
    }

    function hu(n, t) {
        return v(n, "table") && v(11 !== t.nodeType ? t : t.firstChild, "tr") ? i(n).children("tbody")[0] || n : n
    }

    function ye(n) {
        return n.type = (null !== n.getAttribute("type")) + "/" + n.type, n
    }

    function pe(n) {
        return "true/" === (n.type || "").slice(0, 5) ? n.type = n.type.slice(5) : n.removeAttribute("type"), n
    }

    function cu(n, t) {
        var u, c, f, s, h, l, a, e;
        if (1 === t.nodeType) {
            if (r.hasData(n) && (s = r.access(n), h = r.set(t, s), e = s.events)) {
                delete h.handle;
                h.events = {};
                for (f in e)
                    for (u = 0, c = e[f].length; u < c; u++) i.event.add(t, f, e[f][u])
            }
            o.hasData(n) && (l = o.access(n), a = i.extend({}, l), o.set(t, a))
        }
    }

    function we(n, t) {
        var i = t.nodeName.toLowerCase();
        "input" === i && iu.test(n.type) ? t.checked = n.checked : "input" !== i && "textarea" !== i || (t.defaultValue = n.defaultValue)
    }

    function ot(n, t, f, o) {
        t = er.apply([], t);
        var l, w, a, v, h, b, c = 0,
            y = n.length,
            d = y - 1,
            p = t[0],
            k = u(p);
        if (k || y > 1 && "string" == typeof p && !e.checkClone && ae.test(p)) return n.each(function(i) {
            var r = n.eq(i);
            k && (t[0] = p.call(this, i, r.html()));
            ot(r, t, f, o)
        });
        if (y && (l = eu(t, n[0].ownerDocument, !1, n, o), w = l.firstChild, 1 === l.childNodes.length && (l = w), w || o)) {
            for (v = (a = i.map(s(l, "script"), ye)).length; c < y; c++) h = l, c !== d && (h = i.clone(h, !0, !0), v && i.merge(a, s(h, "script"))), f.call(n[c], h, c);
            if (v)
                for (b = a[a.length - 1].ownerDocument, i.map(a, pe), c = 0; c < v; c++) h = a[c], uu.test(h.type || "") && !r.access(h, "globalEval") && i.contains(b, h) && (h.src && "module" !== (h.type || "").toLowerCase() ? i._evalUrl && i._evalUrl(h.src) : hr(h.textContent.replace(ve, ""), b, h))
        }
        return n
    }

    function lu(n, t, r) {
        for (var u, e = t ? i.filter(t, n) : n, f = 0; null != (u = e[f]); f++) r || 1 !== u.nodeType || i.cleanData(s(u)), u.parentNode && (r && i.contains(u.ownerDocument, u) && vi(s(u, "script")), u.parentNode.removeChild(u));
        return n
    }

    function yt(n, t, r) {
        var o, s, h, f, u = n.style;
        return (r = r || ui(n)) && ("" !== (f = r.getPropertyValue(t) || r[t]) || i.contains(n.ownerDocument, n) || (f = i.style(n, t)), !e.pixelBoxStyles() && pi.test(f) && be.test(t) && (o = u.width, s = u.minWidth, h = u.maxWidth, u.minWidth = u.maxWidth = u.width = f, f = r.width, u.width = o, u.minWidth = s, u.maxWidth = h)), void 0 !== f ? f + "" : f
    }

    function au(n, t) {
        return {
            get: function() {
                if (!n()) return (this.get = t).apply(this, arguments);
                delete this.get
            }
        }
    }

    function ge(n) {
        if (n in wu) return n;
        for (var i = n[0].toUpperCase() + n.slice(1), t = pu.length; t--;)
            if ((n = pu[t] + i) in wu) return n
    }

    function bu(n) {
        var t = i.cssProps[n];
        return t || (t = i.cssProps[n] = ge(n) || n), t
    }

    function ku(n, t, i) {
        var r = vt.exec(t);
        return r ? Math.max(0, r[2] - (i || 0)) + (r[3] || "px") : t
    }

    function wi(n, t, r, u, f, e) {
        var o = "width" === t ? 1 : 0,
            h = 0,
            s = 0;
        if (r === (u ? "border" : "content")) return 0;
        for (; o < 4; o += 2) "margin" === r && (s += i.css(n, r + w[o], !0, f)), u ? ("content" === r && (s -= i.css(n, "padding" + w[o], !0, f)), "margin" !== r && (s -= i.css(n, "border" + w[o] + "Width", !0, f))) : (s += i.css(n, "padding" + w[o], !0, f), "padding" !== r ? s += i.css(n, "border" + w[o] + "Width", !0, f) : h += i.css(n, "border" + w[o] + "Width", !0, f));
        return !u && e >= 0 && (s += Math.max(0, Math.ceil(n["offset" + t[0].toUpperCase() + t.slice(1)] - e - s - h - .5))), s
    }

    function du(n, t, r) {
        var f = ui(n),
            u = yt(n, t, f),
            s = "border-box" === i.css(n, "boxSizing", !1, f),
            o = s;
        if (pi.test(u)) {
            if (!r) return u;
            u = "auto"
        }
        return o = o && (e.boxSizingReliable() || u === n.style[t]), ("auto" === u || !parseFloat(u) && "inline" === i.css(n, "display", !1, f)) && (u = n["offset" + t[0].toUpperCase() + t.slice(1)], o = !0), (u = parseFloat(u) || 0) + wi(n, t, r || (s ? "border" : "content"), o, f, u) + "px"
    }

    function h(n, t, i, r, u) {
        return new h.prototype.init(n, t, i, r, u)
    }

    function bi() {
        fi && (!1 === f.hidden && n.requestAnimationFrame ? n.requestAnimationFrame(bi) : n.setTimeout(bi, i.fx.interval), i.fx.tick())
    }

    function tf() {
        return n.setTimeout(function() {
            st = void 0
        }), st = Date.now()
    }

    function ei(n, t) {
        var u, r = 0,
            i = {
                height: n
            };
        for (t = t ? 1 : 0; r < 4; r += 2 - t) i["margin" + (u = w[r])] = i["padding" + u] = n;
        return t && (i.opacity = i.width = n), i
    }

    function rf(n, t, i) {
        for (var u, f = (a.tweeners[t] || []).concat(a.tweeners["*"]), r = 0, e = f.length; r < e; r++)
            if (u = f[r].call(i, t, n)) return u
    }

    function no(n, t, u) {
        var f, y, w, c, b, h, o, l, k = "width" in t || "height" in t,
            v = this,
            p = {},
            s = n.style,
            a = n.nodeType && ti(n),
            e = r.get(n, "fxshow");
        u.queue || (null == (c = i._queueHooks(n, "fx")).unqueued && (c.unqueued = 0, b = c.empty.fire, c.empty.fire = function() {
            c.unqueued || b()
        }), c.unqueued++, v.always(function() {
            v.always(function() {
                c.unqueued--;
                i.queue(n, "fx").length || c.empty.fire()
            })
        }));
        for (f in t)
            if (y = t[f], gu.test(y)) {
                if (delete t[f], w = w || "toggle" === y, y === (a ? "hide" : "show")) {
                    if ("show" !== y || !e || void 0 === e[f]) continue;
                    a = !0
                }
                p[f] = e && e[f] || i.style(n, f)
            } if ((h = !i.isEmptyObject(t)) || !i.isEmptyObject(p)) {
            k && 1 === n.nodeType && (u.overflow = [s.overflow, s.overflowX, s.overflowY], null == (o = e && e.display) && (o = r.get(n, "display")), "none" === (l = i.css(n, "display")) && (o ? l = o : (ft([n], !0), o = n.style.display || o, l = i.css(n, "display"), ft([n]))), ("inline" === l || "inline-block" === l && null != o) && "none" === i.css(n, "float") && (h || (v.done(function() {
                s.display = o
            }), null == o && (l = s.display, o = "none" === l ? "" : l)), s.display = "inline-block"));
            u.overflow && (s.overflow = "hidden", v.always(function() {
                s.overflow = u.overflow[0];
                s.overflowX = u.overflow[1];
                s.overflowY = u.overflow[2]
            }));
            h = !1;
            for (f in p) h || (e ? "hidden" in e && (a = e.hidden) : e = r.access(n, "fxshow", {
                display: o
            }), w && (e.hidden = !a), a && ft([n], !0), v.done(function() {
                a || ft([n]);
                r.remove(n, "fxshow");
                for (f in p) i.style(n, f, p[f])
            })), h = rf(a ? e[f] : 0, f, v), f in e || (e[f] = h.start, a && (h.end = h.start, h.start = 0))
        }
    }

    function to(n, t) {
        var r, f, e, u, o;
        for (r in n)
            if (f = y(r), e = t[f], u = n[r], Array.isArray(u) && (e = u[1], u = n[r] = u[0]), r !== f && (n[f] = u, delete n[r]), (o = i.cssHooks[f]) && "expand" in o) {
                u = o.expand(u);
                delete n[f];
                for (r in u) r in n || (n[r] = u[r], t[r] = e)
            } else t[f] = e
    }

    function a(n, t, r) {
        var o, s, h = 0,
            v = a.prefilters.length,
            e = i.Deferred().always(function() {
                delete l.elem
            }),
            l = function() {
                if (s) return !1;
                for (var o = st || tf(), t = Math.max(0, f.startTime + f.duration - o), i = 1 - (t / f.duration || 0), r = 0, u = f.tweens.length; r < u; r++) f.tweens[r].run(i);
                return e.notifyWith(n, [f, i, t]), i < 1 && u ? t : (u || e.notifyWith(n, [f, 1, 0]), e.resolveWith(n, [f]), !1)
            },
            f = e.promise({
                elem: n,
                props: i.extend({}, t),
                opts: i.extend(!0, {
                    specialEasing: {},
                    easing: i.easing._default
                }, r),
                originalProperties: t,
                originalOptions: r,
                startTime: st || tf(),
                duration: r.duration,
                tweens: [],
                createTween: function(t, r) {
                    var u = i.Tween(n, f.opts, t, r, f.opts.specialEasing[t] || f.opts.easing);
                    return f.tweens.push(u), u
                },
                stop: function(t) {
                    var i = 0,
                        r = t ? f.tweens.length : 0;
                    if (s) return this;
                    for (s = !0; i < r; i++) f.tweens[i].run(1);
                    return t ? (e.notifyWith(n, [f, 1, 0]), e.resolveWith(n, [f, t])) : e.rejectWith(n, [f, t]), this
                }
            }),
            c = f.props;
        for (to(c, f.opts.specialEasing); h < v; h++)
            if (o = a.prefilters[h].call(f, n, c, f.opts)) return u(o.stop) && (i._queueHooks(f.elem, f.opts.queue).stop = o.stop.bind(o)), o;
        return i.map(c, rf, f), u(f.opts.start) && f.opts.start.call(n, f), f.progress(f.opts.progress).done(f.opts.done, f.opts.complete).fail(f.opts.fail).always(f.opts.always), i.fx.timer(i.extend(l, {
            elem: n,
            anim: f,
            queue: f.opts.queue
        })), f
    }

    function g(n) {
        return (n.match(l) || []).join(" ")
    }

    function nt(n) {
        return n.getAttribute && n.getAttribute("class") || ""
    }

    function ki(n) {
        return Array.isArray(n) ? n : "string" == typeof n ? n.match(l) || [] : []
    }

    function tr(n, t, r, u) {
        var f;
        if (Array.isArray(t)) i.each(t, function(t, i) {
            r || io.test(n) ? u(n, i) : tr(n + "[" + ("object" == typeof i && null != i ? t : "") + "]", i, r, u)
        });
        else if (r || "object" !== it(t)) u(n, t);
        else
            for (f in t) tr(n + "[" + f + "]", t[f], r, u)
    }

    function af(n) {
        return function(t, i) {
            "string" != typeof t && (i = t, t = "*");
            var r, f = 0,
                e = t.toLowerCase().match(l) || [];
            if (u(i))
                while (r = e[f++]) "+" === r[0] ? (r = r.slice(1) || "*", (n[r] = n[r] || []).unshift(i)) : (n[r] = n[r] || []).push(i)
        }
    }

    function vf(n, t, r, u) {
        function e(s) {
            var h;
            return f[s] = !0, i.each(n[s] || [], function(n, i) {
                var s = i(t, r, u);
                return "string" != typeof s || o || f[s] ? o ? !(h = s) : void 0 : (t.dataTypes.unshift(s), e(s), !1)
            }), h
        }
        var f = {},
            o = n === ir;
        return e(t.dataTypes[0]) || !f["*"] && e("*")
    }

    function ur(n, t) {
        var r, u, f = i.ajaxSettings.flatOptions || {};
        for (r in t) void 0 !== t[r] && ((f[r] ? n : u || (u = {}))[r] = t[r]);
        return u && i.extend(!0, n, u), n
    }

    function lo(n, t, i) {
        for (var e, u, f, o, s = n.contents, r = n.dataTypes;
            "*" === r[0];) r.shift(), void 0 === e && (e = n.mimeType || t.getResponseHeader("Content-Type"));
        if (e)
            for (u in s)
                if (s[u] && s[u].test(e)) {
                    r.unshift(u);
                    break
                } if (r[0] in i) f = r[0];
        else {
            for (u in i) {
                if (!r[0] || n.converters[u + " " + r[0]]) {
                    f = u;
                    break
                }
                o || (o = u)
            }
            f = f || o
        }
        if (f) return f !== r[0] && r.unshift(f), i[f]
    }

    function ao(n, t, i, r) {
        var h, u, f, s, e, o = {},
            c = n.dataTypes.slice();
        if (c[1])
            for (f in n.converters) o[f.toLowerCase()] = n.converters[f];
        for (u = c.shift(); u;)
            if (n.responseFields[u] && (i[n.responseFields[u]] = t), !e && r && n.dataFilter && (t = n.dataFilter(t, n.dataType)), e = u, u = c.shift())
                if ("*" === u) u = e;
                else if ("*" !== e && e !== u) {
            if (!(f = o[e + " " + u] || o["* " + u]))
                for (h in o)
                    if ((s = h.split(" "))[1] === u && (f = o[e + " " + s[0]] || o["* " + s[0]])) {
                        !0 === f ? f = o[h] : !0 !== o[h] && (u = s[0], c.unshift(s[1]));
                        break
                    } if (!0 !== f)
                if (f && n.throws) t = f(t);
                else try {
                    t = f(t)
                } catch (n) {
                    return {
                        state: "parsererror",
                        error: f ? n : "No conversion from " + e + " to " + u
                    }
                }
        }
        return {
            state: "success",
            data: t
        }
    }
    var k = [],
        f = n.document,
        bf = Object.getPrototypeOf,
        d = k.slice,
        er = k.concat,
        si = k.push,
        wt = k.indexOf,
        bt = {},
        or = bt.toString,
        kt = bt.hasOwnProperty,
        sr = kt.toString,
        kf = sr.call(Object),
        e = {},
        u = function(n) {
            return "function" == typeof n && "number" != typeof n.nodeType
        },
        tt = function(n) {
            return null != n && n === n.window
        },
        df = {
            type: !0,
            src: !0,
            noModule: !0
        },
        i = function(n, t) {
            return new i.fn.init(n, t)
        },
        gf = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
        b, ci, ar, vr, yr, pr, l, kr, gt, lt, ai, fu, st, fi, gu, nf, uf, ht, ff, ef, of , di, gi, yf, ct, fr, oi, pf, wf;
    i.fn = i.prototype = {
        jquery: "3.3.1",
        constructor: i,
        length: 0,
        toArray: function() {
            return d.call(this)
        },
        get: function(n) {
            return null == n ? d.call(this) : n < 0 ? this[n + this.length] : this[n]
        },
        pushStack: function(n) {
            var t = i.merge(this.constructor(), n);
            return t.prevObject = this, t
        },
        each: function(n) {
            return i.each(this, n)
        },
        map: function(n) {
            return this.pushStack(i.map(this, function(t, i) {
                return n.call(t, i, t)
            }))
        },
        slice: function() {
            return this.pushStack(d.apply(this, arguments))
        },
        first: function() {
            return this.eq(0)
        },
        last: function() {
            return this.eq(-1)
        },
        eq: function(n) {
            var i = this.length,
                t = +n + (n < 0 ? i : 0);
            return this.pushStack(t >= 0 && t < i ? [this[t]] : [])
        },
        end: function() {
            return this.prevObject || this.constructor()
        },
        push: si,
        sort: k.sort,
        splice: k.splice
    };
    i.extend = i.fn.extend = function() {
        var o, e, t, r, s, h, n = arguments[0] || {},
            f = 1,
            l = arguments.length,
            c = !1;
        for ("boolean" == typeof n && (c = n, n = arguments[f] || {}, f++), "object" == typeof n || u(n) || (n = {}), f === l && (n = this, f--); f < l; f++)
            if (null != (o = arguments[f]))
                for (e in o) t = n[e], n !== (r = o[e]) && (c && r && (i.isPlainObject(r) || (s = Array.isArray(r))) ? (s ? (s = !1, h = t && Array.isArray(t) ? t : []) : h = t && i.isPlainObject(t) ? t : {}, n[e] = i.extend(c, h, r)) : void 0 !== r && (n[e] = r));
        return n
    };
    i.extend({
        expando: "jQuery" + ("3.3.1" + Math.random()).replace(/\D/g, ""),
        isReady: !0,
        error: function(n) {
            throw new Error(n);
        },
        noop: function() {},
        isPlainObject: function(n) {
            var t, i;
            return !(!n || "[object Object]" !== or.call(n)) && (!(t = bf(n)) || "function" == typeof(i = kt.call(t, "constructor") && t.constructor) && sr.call(i) === kf)
        },
        isEmptyObject: function(n) {
            var t;
            for (t in n) return !1;
            return !0
        },
        globalEval: function(n) {
            hr(n)
        },
        each: function(n, t) {
            var r, i = 0;
            if (hi(n)) {
                for (r = n.length; i < r; i++)
                    if (!1 === t.call(n[i], i, n[i])) break
            } else
                for (i in n)
                    if (!1 === t.call(n[i], i, n[i])) break;
            return n
        },
        trim: function(n) {
            return null == n ? "" : (n + "").replace(gf, "")
        },
        makeArray: function(n, t) {
            var r = t || [];
            return null != n && (hi(Object(n)) ? i.merge(r, "string" == typeof n ? [n] : n) : si.call(r, n)), r
        },
        inArray: function(n, t, i) {
            return null == t ? -1 : wt.call(t, n, i)
        },
        merge: function(n, t) {
            for (var u = +t.length, i = 0, r = n.length; i < u; i++) n[r++] = t[i];
            return n.length = r, n
        },
        grep: function(n, t, i) {
            for (var f, u = [], r = 0, e = n.length, o = !i; r < e; r++)(f = !t(n[r], r)) !== o && u.push(n[r]);
            return u
        },
        map: function(n, t, i) {
            var e, u, r = 0,
                f = [];
            if (hi(n))
                for (e = n.length; r < e; r++) null != (u = t(n[r], r, i)) && f.push(u);
            else
                for (r in n) null != (u = t(n[r], r, i)) && f.push(u);
            return er.apply([], f)
        },
        guid: 1,
        support: e
    });
    "function" == typeof Symbol && (i.fn[Symbol.iterator] = k[Symbol.iterator]);
    i.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function(n, t) {
        bt["[object " + t + "]"] = t.toLowerCase()
    });
    b = function(n) {
        function u(n, t, r, u) {
            var s, p, l, a, w, d, g, y = t && t.ownerDocument,
                v = t ? t.nodeType : 9;
            if (r = r || [], "string" != typeof n || !n || 1 !== v && 9 !== v && 11 !== v) return r;
            if (!u && ((t ? t.ownerDocument || t : c) !== i && b(t), t = t || i, h)) {
                if (11 !== v && (w = cr.exec(n)))
                    if (s = w[1]) {
                        if (9 === v) {
                            if (!(l = t.getElementById(s))) return r;
                            if (l.id === s) return r.push(l), r
                        } else if (y && (l = y.getElementById(s)) && et(t, l) && l.id === s) return r.push(l), r
                    } else {
                        if (w[2]) return k.apply(r, t.getElementsByTagName(n)), r;
                        if ((s = w[3]) && e.getElementsByClassName && t.getElementsByClassName) return k.apply(r, t.getElementsByClassName(s)), r
                    } if (e.qsa && !lt[n + " "] && (!o || !o.test(n))) {
                    if (1 !== v) y = t, g = n;
                    else if ("object" !== t.nodeName.toLowerCase()) {
                        for ((a = t.getAttribute("id")) ? a = a.replace(vi, yi) : t.setAttribute("id", a = f), p = (d = ft(n)).length; p--;) d[p] = "#" + a + " " + yt(d[p]);
                        g = d.join(",");
                        y = ni.test(n) && ri(t.parentNode) || t
                    }
                    if (g) try {
                        return k.apply(r, y.querySelectorAll(g)), r
                    } catch (n) {} finally {
                        a === f && t.removeAttribute("id")
                    }
                }
            }
            return si(n.replace(at, "$1"), t, r, u)
        }

        function ti() {
            function n(r, u) {
                return i.push(r + " ") > t.cacheLength && delete n[i.shift()], n[r + " "] = u
            }
            var i = [];
            return n
        }

        function l(n) {
            return n[f] = !0, n
        }

        function a(n) {
            var t = i.createElement("fieldset");
            try {
                return !!n(t)
            } catch (n) {
                return !1
            } finally {
                t.parentNode && t.parentNode.removeChild(t);
                t = null
            }
        }

        function ii(n, i) {
            for (var r = n.split("|"), u = r.length; u--;) t.attrHandle[r[u]] = i
        }

        function wi(n, t) {
            var i = t && n,
                r = i && 1 === n.nodeType && 1 === t.nodeType && n.sourceIndex - t.sourceIndex;
            if (r) return r;
            if (i)
                while (i = i.nextSibling)
                    if (i === t) return -1;
            return n ? 1 : -1
        }

        function ar(n) {
            return function(t) {
                return "input" === t.nodeName.toLowerCase() && t.type === n
            }
        }

        function vr(n) {
            return function(t) {
                var i = t.nodeName.toLowerCase();
                return ("input" === i || "button" === i) && t.type === n
            }
        }

        function bi(n) {
            return function(t) {
                return "form" in t ? t.parentNode && !1 === t.disabled ? "label" in t ? "label" in t.parentNode ? t.parentNode.disabled === n : t.disabled === n : t.isDisabled === n || t.isDisabled !== !n && lr(t) === n : t.disabled === n : "label" in t && t.disabled === n
            }
        }

        function it(n) {
            return l(function(t) {
                return t = +t, l(function(i, r) {
                    for (var u, f = n([], i.length, t), e = f.length; e--;) i[u = f[e]] && (i[u] = !(r[u] = i[u]))
                })
            })
        }

        function ri(n) {
            return n && "undefined" != typeof n.getElementsByTagName && n
        }

        function ki() {}

        function yt(n) {
            for (var t = 0, r = n.length, i = ""; t < r; t++) i += n[t].value;
            return i
        }

        function pt(n, t, i) {
            var r = t.dir,
                u = t.next,
                e = u || r,
                o = i && "parentNode" === e,
                s = di++;
            return t.first ? function(t, i, u) {
                while (t = t[r])
                    if (1 === t.nodeType || o) return n(t, i, u);
                return !1
            } : function(t, i, h) {
                var c, l, a, y = [v, s];
                if (h) {
                    while (t = t[r])
                        if ((1 === t.nodeType || o) && n(t, i, h)) return !0
                } else
                    while (t = t[r])
                        if (1 === t.nodeType || o)
                            if (a = t[f] || (t[f] = {}), l = a[t.uniqueID] || (a[t.uniqueID] = {}), u && u === t.nodeName.toLowerCase()) t = t[r] || t;
                            else {
                                if ((c = l[e]) && c[0] === v && c[1] === s) return y[2] = c[2];
                                if (l[e] = y, y[2] = n(t, i, h)) return !0
                            } return !1
            }
        }

        function ui(n) {
            return n.length > 1 ? function(t, i, r) {
                for (var u = n.length; u--;)
                    if (!n[u](t, i, r)) return !1;
                return !0
            } : n[0]
        }

        function yr(n, t, i) {
            for (var r = 0, f = t.length; r < f; r++) u(n, t[r], i);
            return i
        }

        function wt(n, t, i, r, u) {
            for (var e, o = [], f = 0, s = n.length, h = null != t; f < s; f++)(e = n[f]) && (i && !i(e, r, u) || (o.push(e), h && t.push(f)));
            return o
        }

        function fi(n, t, i, r, u, e) {
            return r && !r[f] && (r = fi(r)), u && !u[f] && (u = fi(u, e)), l(function(f, e, o, s) {
                var l, c, a, p = [],
                    y = [],
                    w = e.length,
                    b = f || yr(t || "*", o.nodeType ? [o] : o, []),
                    v = !n || !f && t ? b : wt(b, p, n, o, s),
                    h = i ? u || (f ? n : w || r) ? [] : e : v;
                if (i && i(v, h, o, s), r)
                    for (l = wt(h, y), r(l, [], o, s), c = l.length; c--;)(a = l[c]) && (h[y[c]] = !(v[y[c]] = a));
                if (f) {
                    if (u || n) {
                        if (u) {
                            for (l = [], c = h.length; c--;)(a = h[c]) && l.push(v[c] = a);
                            u(null, h = [], l, s)
                        }
                        for (c = h.length; c--;)(a = h[c]) && (l = u ? nt(f, a) : p[c]) > -1 && (f[l] = !(e[l] = a))
                    }
                } else h = wt(h === e ? h.splice(w, h.length) : h), u ? u(null, e, h, s) : k.apply(e, h)
            })
        }

        function ei(n) {
            for (var o, u, r, s = n.length, h = t.relative[n[0].type], c = h || t.relative[" "], i = h ? 1 : 0, l = pt(function(n) {
                    return n === o
                }, c, !0), a = pt(function(n) {
                    return nt(o, n) > -1
                }, c, !0), e = [function(n, t, i) {
                    var r = !h && (i || t !== ht) || ((o = t).nodeType ? l(n, t, i) : a(n, t, i));
                    return o = null, r
                }]; i < s; i++)
                if (u = t.relative[n[i].type]) e = [pt(ui(e), u)];
                else {
                    if ((u = t.filter[n[i].type].apply(null, n[i].matches))[f]) {
                        for (r = ++i; r < s; r++)
                            if (t.relative[n[r].type]) break;
                        return fi(i > 1 && ui(e), i > 1 && yt(n.slice(0, i - 1).concat({
                            value: " " === n[i - 2].type ? "*" : ""
                        })).replace(at, "$1"), u, i < r && ei(n.slice(i, r)), r < s && ei(n = n.slice(r)), r < s && yt(n))
                    }
                    e.push(u)
                } return ui(e)
        }

        function pr(n, r) {
            var f = r.length > 0,
                e = n.length > 0,
                o = function(o, s, c, l, a) {
                    var y, nt, d, g = 0,
                        p = "0",
                        tt = o && [],
                        w = [],
                        it = ht,
                        rt = o || e && t.find.TAG("*", a),
                        ut = v += null == it ? 1 : Math.random() || .1,
                        ft = rt.length;
                    for (a && (ht = s === i || s || a); p !== ft && null != (y = rt[p]); p++) {
                        if (e && y) {
                            for (nt = 0, s || y.ownerDocument === i || (b(y), c = !h); d = n[nt++];)
                                if (d(y, s || i, c)) {
                                    l.push(y);
                                    break
                                } a && (v = ut)
                        }
                        f && ((y = !d && y) && g--, o && tt.push(y))
                    }
                    if (g += p, f && p !== g) {
                        for (nt = 0; d = r[nt++];) d(tt, w, s, c);
                        if (o) {
                            if (g > 0)
                                while (p--) tt[p] || w[p] || (w[p] = nr.call(l));
                            w = wt(w)
                        }
                        k.apply(l, w);
                        a && !o && w.length > 0 && g + r.length > 1 && u.uniqueSort(l)
                    }
                    return a && (v = ut, ht = it), tt
                };
            return f ? l(o) : o
        }
        var rt, e, t, st, oi, ft, bt, si, ht, w, ut, b, i, s, h, o, d, ct, et, f = "sizzle" + 1 * new Date,
            c = n.document,
            v = 0,
            di = 0,
            hi = ti(),
            ci = ti(),
            lt = ti(),
            kt = function(n, t) {
                return n === t && (ut = !0), 0
            },
            gi = {}.hasOwnProperty,
            g = [],
            nr = g.pop,
            tr = g.push,
            k = g.push,
            li = g.slice,
            nt = function(n, t) {
                for (var i = 0, r = n.length; i < r; i++)
                    if (n[i] === t) return i;
                return -1
            },
            dt = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            r = "[\\x20\\t\\r\\n\\f]",
            tt = "(?:\\\\.|[\\w-]|[^\0-\\xa0])+",
            ai = "\\[" + r + "*(" + tt + ")(?:" + r + "*([*^$|!~]?=)" + r + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + tt + "))|)" + r + "*\\]",
            gt = ":(" + tt + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + ai + ")*)|.*)\\)|)",
            ir = new RegExp(r + "+", "g"),
            at = new RegExp("^" + r + "+|((?:^|[^\\\\])(?:\\\\.)*)" + r + "+$", "g"),
            rr = new RegExp("^" + r + "*," + r + "*"),
            ur = new RegExp("^" + r + "*([>+~]|" + r + ")" + r + "*"),
            fr = new RegExp("=" + r + "*([^\\]'\"]*?)" + r + "*\\]", "g"),
            er = new RegExp(gt),
            or = new RegExp("^" + tt + "$"),
            vt = {
                ID: new RegExp("^#(" + tt + ")"),
                CLASS: new RegExp("^\\.(" + tt + ")"),
                TAG: new RegExp("^(" + tt + "|[*])"),
                ATTR: new RegExp("^" + ai),
                PSEUDO: new RegExp("^" + gt),
                CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + r + "*(even|odd|(([+-]|)(\\d*)n|)" + r + "*(?:([+-]|)" + r + "*(\\d+)|))" + r + "*\\)|)", "i"),
                bool: new RegExp("^(?:" + dt + ")$", "i"),
                needsContext: new RegExp("^" + r + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + r + "*((?:-\\d)?\\d*)" + r + "*\\)|)(?=[^-]|$)", "i")
            },
            sr = /^(?:input|select|textarea|button)$/i,
            hr = /^h\d$/i,
            ot = /^[^{]+\{\s*\[native \w/,
            cr = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
            ni = /[+~]/,
            y = new RegExp("\\\\([\\da-f]{1,6}" + r + "?|(" + r + ")|.)", "ig"),
            p = function(n, t, i) {
                var r = "0x" + t - 65536;
                return r !== r || i ? t : r < 0 ? String.fromCharCode(r + 65536) : String.fromCharCode(r >> 10 | 55296, 1023 & r | 56320)
            },
            vi = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
            yi = function(n, t) {
                return t ? "\0" === n ? "�" : n.slice(0, -1) + "\\" + n.charCodeAt(n.length - 1).toString(16) + " " : "\\" + n
            },
            pi = function() {
                b()
            },
            lr = pt(function(n) {
                return !0 === n.disabled && ("form" in n || "label" in n)
            }, {
                dir: "parentNode",
                next: "legend"
            });
        try {
            k.apply(g = li.call(c.childNodes), c.childNodes);
            g[c.childNodes.length].nodeType
        } catch (n) {
            k = {
                apply: g.length ? function(n, t) {
                    tr.apply(n, li.call(t))
                } : function(n, t) {
                    for (var i = n.length, r = 0; n[i++] = t[r++];);
                    n.length = i - 1
                }
            }
        }
        e = u.support = {};
        oi = u.isXML = function(n) {
            var t = n && (n.ownerDocument || n).documentElement;
            return !!t && "HTML" !== t.nodeName
        };
        b = u.setDocument = function(n) {
            var v, u, l = n ? n.ownerDocument || n : c;
            return l !== i && 9 === l.nodeType && l.documentElement ? (i = l, s = i.documentElement, h = !oi(i), c !== i && (u = i.defaultView) && u.top !== u && (u.addEventListener ? u.addEventListener("unload", pi, !1) : u.attachEvent && u.attachEvent("onunload", pi)), e.attributes = a(function(n) {
                return n.className = "i", !n.getAttribute("className")
            }), e.getElementsByTagName = a(function(n) {
                return n.appendChild(i.createComment("")), !n.getElementsByTagName("*").length
            }), e.getElementsByClassName = ot.test(i.getElementsByClassName), e.getById = a(function(n) {
                return s.appendChild(n).id = f, !i.getElementsByName || !i.getElementsByName(f).length
            }), e.getById ? (t.filter.ID = function(n) {
                var t = n.replace(y, p);
                return function(n) {
                    return n.getAttribute("id") === t
                }
            }, t.find.ID = function(n, t) {
                if ("undefined" != typeof t.getElementById && h) {
                    var i = t.getElementById(n);
                    return i ? [i] : []
                }
            }) : (t.filter.ID = function(n) {
                var t = n.replace(y, p);
                return function(n) {
                    var i = "undefined" != typeof n.getAttributeNode && n.getAttributeNode("id");
                    return i && i.value === t
                }
            }, t.find.ID = function(n, t) {
                if ("undefined" != typeof t.getElementById && h) {
                    var r, u, f, i = t.getElementById(n);
                    if (i) {
                        if ((r = i.getAttributeNode("id")) && r.value === n) return [i];
                        for (f = t.getElementsByName(n), u = 0; i = f[u++];)
                            if ((r = i.getAttributeNode("id")) && r.value === n) return [i]
                    }
                    return []
                }
            }), t.find.TAG = e.getElementsByTagName ? function(n, t) {
                return "undefined" != typeof t.getElementsByTagName ? t.getElementsByTagName(n) : e.qsa ? t.querySelectorAll(n) : void 0
            } : function(n, t) {
                var i, r = [],
                    f = 0,
                    u = t.getElementsByTagName(n);
                if ("*" === n) {
                    while (i = u[f++]) 1 === i.nodeType && r.push(i);
                    return r
                }
                return u
            }, t.find.CLASS = e.getElementsByClassName && function(n, t) {
                if ("undefined" != typeof t.getElementsByClassName && h) return t.getElementsByClassName(n)
            }, d = [], o = [], (e.qsa = ot.test(i.querySelectorAll)) && (a(function(n) {
                s.appendChild(n).innerHTML = "<a id='" + f + "'><\/a><select id='" + f + "-\r\\' msallowcapture=''><option selected=''><\/option><\/select>";
                n.querySelectorAll("[msallowcapture^='']").length && o.push("[*^$]=" + r + "*(?:''|\"\")");
                n.querySelectorAll("[selected]").length || o.push("\\[" + r + "*(?:value|" + dt + ")");
                n.querySelectorAll("[id~=" + f + "-]").length || o.push("~=");
                n.querySelectorAll(":checked").length || o.push(":checked");
                n.querySelectorAll("a#" + f + "+*").length || o.push(".#.+[+~]")
            }), a(function(n) {
                n.innerHTML = "<a href='' disabled='disabled'><\/a><select disabled='disabled'><option/><\/select>";
                var t = i.createElement("input");
                t.setAttribute("type", "hidden");
                n.appendChild(t).setAttribute("name", "D");
                n.querySelectorAll("[name=d]").length && o.push("name" + r + "*[*^$|!~]?=");
                2 !== n.querySelectorAll(":enabled").length && o.push(":enabled", ":disabled");
                s.appendChild(n).disabled = !0;
                2 !== n.querySelectorAll(":disabled").length && o.push(":enabled", ":disabled");
                n.querySelectorAll("*,:x");
                o.push(",.*:")
            })), (e.matchesSelector = ot.test(ct = s.matches || s.webkitMatchesSelector || s.mozMatchesSelector || s.oMatchesSelector || s.msMatchesSelector)) && a(function(n) {
                e.disconnectedMatch = ct.call(n, "*");
                ct.call(n, "[s!='']:x");
                d.push("!=", gt)
            }), o = o.length && new RegExp(o.join("|")), d = d.length && new RegExp(d.join("|")), v = ot.test(s.compareDocumentPosition), et = v || ot.test(s.contains) ? function(n, t) {
                var r = 9 === n.nodeType ? n.documentElement : n,
                    i = t && t.parentNode;
                return n === i || !(!i || 1 !== i.nodeType || !(r.contains ? r.contains(i) : n.compareDocumentPosition && 16 & n.compareDocumentPosition(i)))
            } : function(n, t) {
                if (t)
                    while (t = t.parentNode)
                        if (t === n) return !0;
                return !1
            }, kt = v ? function(n, t) {
                if (n === t) return ut = !0, 0;
                var r = !n.compareDocumentPosition - !t.compareDocumentPosition;
                return r || (1 & (r = (n.ownerDocument || n) === (t.ownerDocument || t) ? n.compareDocumentPosition(t) : 1) || !e.sortDetached && t.compareDocumentPosition(n) === r ? n === i || n.ownerDocument === c && et(c, n) ? -1 : t === i || t.ownerDocument === c && et(c, t) ? 1 : w ? nt(w, n) - nt(w, t) : 0 : 4 & r ? -1 : 1)
            } : function(n, t) {
                if (n === t) return ut = !0, 0;
                var r, u = 0,
                    o = n.parentNode,
                    s = t.parentNode,
                    f = [n],
                    e = [t];
                if (!o || !s) return n === i ? -1 : t === i ? 1 : o ? -1 : s ? 1 : w ? nt(w, n) - nt(w, t) : 0;
                if (o === s) return wi(n, t);
                for (r = n; r = r.parentNode;) f.unshift(r);
                for (r = t; r = r.parentNode;) e.unshift(r);
                while (f[u] === e[u]) u++;
                return u ? wi(f[u], e[u]) : f[u] === c ? -1 : e[u] === c ? 1 : 0
            }, i) : i
        };
        u.matches = function(n, t) {
            return u(n, null, null, t)
        };
        u.matchesSelector = function(n, t) {
            if ((n.ownerDocument || n) !== i && b(n), t = t.replace(fr, "='$1']"), e.matchesSelector && h && !lt[t + " "] && (!d || !d.test(t)) && (!o || !o.test(t))) try {
                var r = ct.call(n, t);
                if (r || e.disconnectedMatch || n.document && 11 !== n.document.nodeType) return r
            } catch (n) {}
            return u(t, i, null, [n]).length > 0
        };
        u.contains = function(n, t) {
            return (n.ownerDocument || n) !== i && b(n), et(n, t)
        };
        u.attr = function(n, r) {
            (n.ownerDocument || n) !== i && b(n);
            var f = t.attrHandle[r.toLowerCase()],
                u = f && gi.call(t.attrHandle, r.toLowerCase()) ? f(n, r, !h) : void 0;
            return void 0 !== u ? u : e.attributes || !h ? n.getAttribute(r) : (u = n.getAttributeNode(r)) && u.specified ? u.value : null
        };
        u.escape = function(n) {
            return (n + "").replace(vi, yi)
        };
        u.error = function(n) {
            throw new Error("Syntax error, unrecognized expression: " + n);
        };
        u.uniqueSort = function(n) {
            var r, u = [],
                t = 0,
                i = 0;
            if (ut = !e.detectDuplicates, w = !e.sortStable && n.slice(0), n.sort(kt), ut) {
                while (r = n[i++]) r === n[i] && (t = u.push(i));
                while (t--) n.splice(u[t], 1)
            }
            return w = null, n
        };
        st = u.getText = function(n) {
            var r, i = "",
                u = 0,
                t = n.nodeType;
            if (t) {
                if (1 === t || 9 === t || 11 === t) {
                    if ("string" == typeof n.textContent) return n.textContent;
                    for (n = n.firstChild; n; n = n.nextSibling) i += st(n)
                } else if (3 === t || 4 === t) return n.nodeValue
            } else
                while (r = n[u++]) i += st(r);
            return i
        };
        (t = u.selectors = {
            cacheLength: 50,
            createPseudo: l,
            match: vt,
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
                ATTR: function(n) {
                    return n[1] = n[1].replace(y, p), n[3] = (n[3] || n[4] || n[5] || "").replace(y, p), "~=" === n[2] && (n[3] = " " + n[3] + " "), n.slice(0, 4)
                },
                CHILD: function(n) {
                    return n[1] = n[1].toLowerCase(), "nth" === n[1].slice(0, 3) ? (n[3] || u.error(n[0]), n[4] = +(n[4] ? n[5] + (n[6] || 1) : 2 * ("even" === n[3] || "odd" === n[3])), n[5] = +(n[7] + n[8] || "odd" === n[3])) : n[3] && u.error(n[0]), n
                },
                PSEUDO: function(n) {
                    var i, t = !n[6] && n[2];
                    return vt.CHILD.test(n[0]) ? null : (n[3] ? n[2] = n[4] || n[5] || "" : t && er.test(t) && (i = ft(t, !0)) && (i = t.indexOf(")", t.length - i) - t.length) && (n[0] = n[0].slice(0, i), n[2] = t.slice(0, i)), n.slice(0, 3))
                }
            },
            filter: {
                TAG: function(n) {
                    var t = n.replace(y, p).toLowerCase();
                    return "*" === n ? function() {
                        return !0
                    } : function(n) {
                        return n.nodeName && n.nodeName.toLowerCase() === t
                    }
                },
                CLASS: function(n) {
                    var t = hi[n + " "];
                    return t || (t = new RegExp("(^|" + r + ")" + n + "(" + r + "|$)")) && hi(n, function(n) {
                        return t.test("string" == typeof n.className && n.className || "undefined" != typeof n.getAttribute && n.getAttribute("class") || "")
                    })
                },
                ATTR: function(n, t, i) {
                    return function(r) {
                        var f = u.attr(r, n);
                        return null == f ? "!=" === t : !t || (f += "", "=" === t ? f === i : "!=" === t ? f !== i : "^=" === t ? i && 0 === f.indexOf(i) : "*=" === t ? i && f.indexOf(i) > -1 : "$=" === t ? i && f.slice(-i.length) === i : "~=" === t ? (" " + f.replace(ir, " ") + " ").indexOf(i) > -1 : "|=" === t && (f === i || f.slice(0, i.length + 1) === i + "-"))
                    }
                },
                CHILD: function(n, t, i, r, u) {
                    var s = "nth" !== n.slice(0, 3),
                        o = "last" !== n.slice(-4),
                        e = "of-type" === t;
                    return 1 === r && 0 === u ? function(n) {
                        return !!n.parentNode
                    } : function(t, i, h) {
                        var p, d, y, c, a, w, b = s !== o ? "nextSibling" : "previousSibling",
                            k = t.parentNode,
                            nt = e && t.nodeName.toLowerCase(),
                            g = !h && !e,
                            l = !1;
                        if (k) {
                            if (s) {
                                while (b) {
                                    for (c = t; c = c[b];)
                                        if (e ? c.nodeName.toLowerCase() === nt : 1 === c.nodeType) return !1;
                                    w = b = "only" === n && !w && "nextSibling"
                                }
                                return !0
                            }
                            if (w = [o ? k.firstChild : k.lastChild], o && g) {
                                for (l = (a = (p = (d = (y = (c = k)[f] || (c[f] = {}))[c.uniqueID] || (y[c.uniqueID] = {}))[n] || [])[0] === v && p[1]) && p[2], c = a && k.childNodes[a]; c = ++a && c && c[b] || (l = a = 0) || w.pop();)
                                    if (1 === c.nodeType && ++l && c === t) {
                                        d[n] = [v, a, l];
                                        break
                                    }
                            } else if (g && (l = a = (p = (d = (y = (c = t)[f] || (c[f] = {}))[c.uniqueID] || (y[c.uniqueID] = {}))[n] || [])[0] === v && p[1]), !1 === l)
                                while (c = ++a && c && c[b] || (l = a = 0) || w.pop())
                                    if ((e ? c.nodeName.toLowerCase() === nt : 1 === c.nodeType) && ++l && (g && ((d = (y = c[f] || (c[f] = {}))[c.uniqueID] || (y[c.uniqueID] = {}))[n] = [v, l]), c === t)) break;
                            return (l -= u) === r || l % r == 0 && l / r >= 0
                        }
                    }
                },
                PSEUDO: function(n, i) {
                    var e, r = t.pseudos[n] || t.setFilters[n.toLowerCase()] || u.error("unsupported pseudo: " + n);
                    return r[f] ? r(i) : r.length > 1 ? (e = [n, n, "", i], t.setFilters.hasOwnProperty(n.toLowerCase()) ? l(function(n, t) {
                        for (var e, u = r(n, i), f = u.length; f--;) n[e = nt(n, u[f])] = !(t[e] = u[f])
                    }) : function(n) {
                        return r(n, 0, e)
                    }) : r
                }
            },
            pseudos: {
                not: l(function(n) {
                    var t = [],
                        r = [],
                        i = bt(n.replace(at, "$1"));
                    return i[f] ? l(function(n, t, r, u) {
                        for (var e, o = i(n, null, u, []), f = n.length; f--;)(e = o[f]) && (n[f] = !(t[f] = e))
                    }) : function(n, u, f) {
                        return t[0] = n, i(t, null, f, r), t[0] = null, !r.pop()
                    }
                }),
                has: l(function(n) {
                    return function(t) {
                        return u(n, t).length > 0
                    }
                }),
                contains: l(function(n) {
                    return n = n.replace(y, p),
                        function(t) {
                            return (t.textContent || t.innerText || st(t)).indexOf(n) > -1
                        }
                }),
                lang: l(function(n) {
                    return or.test(n || "") || u.error("unsupported lang: " + n), n = n.replace(y, p).toLowerCase(),
                        function(t) {
                            var i;
                            do
                                if (i = h ? t.lang : t.getAttribute("xml:lang") || t.getAttribute("lang")) return (i = i.toLowerCase()) === n || 0 === i.indexOf(n + "-"); while ((t = t.parentNode) && 1 === t.nodeType);
                            return !1
                        }
                }),
                target: function(t) {
                    var i = n.location && n.location.hash;
                    return i && i.slice(1) === t.id
                },
                root: function(n) {
                    return n === s
                },
                focus: function(n) {
                    return n === i.activeElement && (!i.hasFocus || i.hasFocus()) && !!(n.type || n.href || ~n.tabIndex)
                },
                enabled: bi(!1),
                disabled: bi(!0),
                checked: function(n) {
                    var t = n.nodeName.toLowerCase();
                    return "input" === t && !!n.checked || "option" === t && !!n.selected
                },
                selected: function(n) {
                    return n.parentNode && n.parentNode.selectedIndex, !0 === n.selected
                },
                empty: function(n) {
                    for (n = n.firstChild; n; n = n.nextSibling)
                        if (n.nodeType < 6) return !1;
                    return !0
                },
                parent: function(n) {
                    return !t.pseudos.empty(n)
                },
                header: function(n) {
                    return hr.test(n.nodeName)
                },
                input: function(n) {
                    return sr.test(n.nodeName)
                },
                button: function(n) {
                    var t = n.nodeName.toLowerCase();
                    return "input" === t && "button" === n.type || "button" === t
                },
                text: function(n) {
                    var t;
                    return "input" === n.nodeName.toLowerCase() && "text" === n.type && (null == (t = n.getAttribute("type")) || "text" === t.toLowerCase())
                },
                first: it(function() {
                    return [0]
                }),
                last: it(function(n, t) {
                    return [t - 1]
                }),
                eq: it(function(n, t, i) {
                    return [i < 0 ? i + t : i]
                }),
                even: it(function(n, t) {
                    for (var i = 0; i < t; i += 2) n.push(i);
                    return n
                }),
                odd: it(function(n, t) {
                    for (var i = 1; i < t; i += 2) n.push(i);
                    return n
                }),
                lt: it(function(n, t, i) {
                    for (var r = i < 0 ? i + t : i; --r >= 0;) n.push(r);
                    return n
                }),
                gt: it(function(n, t, i) {
                    for (var r = i < 0 ? i + t : i; ++r < t;) n.push(r);
                    return n
                })
            }
        }).pseudos.nth = t.pseudos.eq;
        for (rt in {
                radio: !0,
                checkbox: !0,
                file: !0,
                password: !0,
                image: !0
            }) t.pseudos[rt] = ar(rt);
        for (rt in {
                submit: !0,
                reset: !0
            }) t.pseudos[rt] = vr(rt);
        return ki.prototype = t.filters = t.pseudos, t.setFilters = new ki, ft = u.tokenize = function(n, i) {
            var e, f, s, o, r, h, c, l = ci[n + " "];
            if (l) return i ? 0 : l.slice(0);
            for (r = n, h = [], c = t.preFilter; r;) {
                (!e || (f = rr.exec(r))) && (f && (r = r.slice(f[0].length) || r), h.push(s = []));
                e = !1;
                (f = ur.exec(r)) && (e = f.shift(), s.push({
                    value: e,
                    type: f[0].replace(at, " ")
                }), r = r.slice(e.length));
                for (o in t.filter)(f = vt[o].exec(r)) && (!c[o] || (f = c[o](f))) && (e = f.shift(), s.push({
                    value: e,
                    type: o,
                    matches: f
                }), r = r.slice(e.length));
                if (!e) break
            }
            return i ? r.length : r ? u.error(n) : ci(n, h).slice(0)
        }, bt = u.compile = function(n, t) {
            var r, u = [],
                e = [],
                i = lt[n + " "];
            if (!i) {
                for (t || (t = ft(n)), r = t.length; r--;)(i = ei(t[r]))[f] ? u.push(i) : e.push(i);
                (i = lt(n, pr(e, u))).selector = n
            }
            return i
        }, si = u.select = function(n, i, r, u) {
            var o, f, e, l, a, c = "function" == typeof n && n,
                s = !u && ft(n = c.selector || n);
            if (r = r || [], 1 === s.length) {
                if ((f = s[0] = s[0].slice(0)).length > 2 && "ID" === (e = f[0]).type && 9 === i.nodeType && h && t.relative[f[1].type]) {
                    if (!(i = (t.find.ID(e.matches[0].replace(y, p), i) || [])[0])) return r;
                    c && (i = i.parentNode);
                    n = n.slice(f.shift().value.length)
                }
                for (o = vt.needsContext.test(n) ? 0 : f.length; o--;) {
                    if (e = f[o], t.relative[l = e.type]) break;
                    if ((a = t.find[l]) && (u = a(e.matches[0].replace(y, p), ni.test(f[0].type) && ri(i.parentNode) || i))) {
                        if (f.splice(o, 1), !(n = u.length && yt(f))) return k.apply(r, u), r;
                        break
                    }
                }
            }
            return (c || bt(n, s))(u, i, !h, r, !i || ni.test(n) && ri(i.parentNode) || i), r
        }, e.sortStable = f.split("").sort(kt).join("") === f, e.detectDuplicates = !!ut, b(), e.sortDetached = a(function(n) {
            return 1 & n.compareDocumentPosition(i.createElement("fieldset"))
        }), a(function(n) {
            return n.innerHTML = "<a href='#'><\/a>", "#" === n.firstChild.getAttribute("href")
        }) || ii("type|href|height|width", function(n, t, i) {
            if (!i) return n.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
        }), e.attributes && a(function(n) {
            return n.innerHTML = "<input/>", n.firstChild.setAttribute("value", ""), "" === n.firstChild.getAttribute("value")
        }) || ii("value", function(n, t, i) {
            if (!i && "input" === n.nodeName.toLowerCase()) return n.defaultValue
        }), a(function(n) {
            return null == n.getAttribute("disabled")
        }) || ii(dt, function(n, t, i) {
            var r;
            if (!i) return !0 === n[t] ? t.toLowerCase() : (r = n.getAttributeNode(t)) && r.specified ? r.value : null
        }), u
    }(n);
    i.find = b;
    i.expr = b.selectors;
    i.expr[":"] = i.expr.pseudos;
    i.uniqueSort = i.unique = b.uniqueSort;
    i.text = b.getText;
    i.isXMLDoc = b.isXML;
    i.contains = b.contains;
    i.escapeSelector = b.escape;
    var rt = function(n, t, r) {
            for (var u = [], f = void 0 !== r;
                (n = n[t]) && 9 !== n.nodeType;)
                if (1 === n.nodeType) {
                    if (f && i(n).is(r)) break;
                    u.push(n)
                } return u
        },
        cr = function(n, t) {
            for (var i = []; n; n = n.nextSibling) 1 === n.nodeType && n !== t && i.push(n);
            return i
        },
        lr = i.expr.match.needsContext;
    ci = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;
    i.filter = function(n, t, r) {
        var u = t[0];
        return r && (n = ":not(" + n + ")"), 1 === t.length && 1 === u.nodeType ? i.find.matchesSelector(u, n) ? [u] : [] : i.find.matches(n, i.grep(t, function(n) {
            return 1 === n.nodeType
        }))
    };
    i.fn.extend({
        find: function(n) {
            var t, r, u = this.length,
                f = this;
            if ("string" != typeof n) return this.pushStack(i(n).filter(function() {
                for (t = 0; t < u; t++)
                    if (i.contains(f[t], this)) return !0
            }));
            for (r = this.pushStack([]), t = 0; t < u; t++) i.find(n, f[t], r);
            return u > 1 ? i.uniqueSort(r) : r
        },
        filter: function(n) {
            return this.pushStack(li(this, n || [], !1))
        },
        not: function(n) {
            return this.pushStack(li(this, n || [], !0))
        },
        is: function(n) {
            return !!li(this, "string" == typeof n && lr.test(n) ? i(n) : n || [], !1).length
        }
    });
    vr = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    (i.fn.init = function(n, t, r) {
        var e, o;
        if (!n) return this;
        if (r = r || ar, "string" == typeof n) {
            if (!(e = "<" === n[0] && ">" === n[n.length - 1] && n.length >= 3 ? [null, n, null] : vr.exec(n)) || !e[1] && t) return !t || t.jquery ? (t || r).find(n) : this.constructor(t).find(n);
            if (e[1]) {
                if (t = t instanceof i ? t[0] : t, i.merge(this, i.parseHTML(e[1], t && t.nodeType ? t.ownerDocument || t : f, !0)), ci.test(e[1]) && i.isPlainObject(t))
                    for (e in t) u(this[e]) ? this[e](t[e]) : this.attr(e, t[e]);
                return this
            }
            return (o = f.getElementById(e[2])) && (this[0] = o, this.length = 1), this
        }
        return n.nodeType ? (this[0] = n, this.length = 1, this) : u(n) ? void 0 !== r.ready ? r.ready(n) : n(i) : i.makeArray(n, this)
    }).prototype = i.fn;
    ar = i(f);
    yr = /^(?:parents|prev(?:Until|All))/;
    pr = {
        children: !0,
        contents: !0,
        next: !0,
        prev: !0
    };
    i.fn.extend({
        has: function(n) {
            var t = i(n, this),
                r = t.length;
            return this.filter(function() {
                for (var n = 0; n < r; n++)
                    if (i.contains(this, t[n])) return !0
            })
        },
        closest: function(n, t) {
            var r, f = 0,
                o = this.length,
                u = [],
                e = "string" != typeof n && i(n);
            if (!lr.test(n))
                for (; f < o; f++)
                    for (r = this[f]; r && r !== t; r = r.parentNode)
                        if (r.nodeType < 11 && (e ? e.index(r) > -1 : 1 === r.nodeType && i.find.matchesSelector(r, n))) {
                            u.push(r);
                            break
                        } return this.pushStack(u.length > 1 ? i.uniqueSort(u) : u)
        },
        index: function(n) {
            return n ? "string" == typeof n ? wt.call(i(n), this[0]) : wt.call(this, n.jquery ? n[0] : n) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        },
        add: function(n, t) {
            return this.pushStack(i.uniqueSort(i.merge(this.get(), i(n, t))))
        },
        addBack: function(n) {
            return this.add(null == n ? this.prevObject : this.prevObject.filter(n))
        }
    });
    i.each({
        parent: function(n) {
            var t = n.parentNode;
            return t && 11 !== t.nodeType ? t : null
        },
        parents: function(n) {
            return rt(n, "parentNode")
        },
        parentsUntil: function(n, t, i) {
            return rt(n, "parentNode", i)
        },
        next: function(n) {
            return wr(n, "nextSibling")
        },
        prev: function(n) {
            return wr(n, "previousSibling")
        },
        nextAll: function(n) {
            return rt(n, "nextSibling")
        },
        prevAll: function(n) {
            return rt(n, "previousSibling")
        },
        nextUntil: function(n, t, i) {
            return rt(n, "nextSibling", i)
        },
        prevUntil: function(n, t, i) {
            return rt(n, "previousSibling", i)
        },
        siblings: function(n) {
            return cr((n.parentNode || {}).firstChild, n)
        },
        children: function(n) {
            return cr(n.firstChild)
        },
        contents: function(n) {
            return v(n, "iframe") ? n.contentDocument : (v(n, "template") && (n = n.content || n), i.merge([], n.childNodes))
        }
    }, function(n, t) {
        i.fn[n] = function(r, u) {
            var f = i.map(this, t, r);
            return "Until" !== n.slice(-5) && (u = r), u && "string" == typeof u && (f = i.filter(u, f)), this.length > 1 && (pr[n] || i.uniqueSort(f), yr.test(n) && f.reverse()), this.pushStack(f)
        }
    });
    l = /[^\x20\t\r\n\f]+/g;
    i.Callbacks = function(n) {
        n = "string" == typeof n ? ne(n) : i.extend({}, n);
        var f, r, c, e, t = [],
            s = [],
            o = -1,
            l = function() {
                for (e = e || n.once, c = f = !0; s.length; o = -1)
                    for (r = s.shift(); ++o < t.length;) !1 === t[o].apply(r[0], r[1]) && n.stopOnFalse && (o = t.length, r = !1);
                n.memory || (r = !1);
                f = !1;
                e && (t = r ? [] : "")
            },
            h = {
                add: function() {
                    return t && (r && !f && (o = t.length - 1, s.push(r)), function f(r) {
                        i.each(r, function(i, r) {
                            u(r) ? n.unique && h.has(r) || t.push(r) : r && r.length && "string" !== it(r) && f(r)
                        })
                    }(arguments), r && !f && l()), this
                },
                remove: function() {
                    return i.each(arguments, function(n, r) {
                        for (var u;
                            (u = i.inArray(r, t, u)) > -1;) t.splice(u, 1), u <= o && o--
                    }), this
                },
                has: function(n) {
                    return n ? i.inArray(n, t) > -1 : t.length > 0
                },
                empty: function() {
                    return t && (t = []), this
                },
                disable: function() {
                    return e = s = [], t = r = "", this
                },
                disabled: function() {
                    return !t
                },
                lock: function() {
                    return e = s = [], r || f || (t = r = ""), this
                },
                locked: function() {
                    return !!e
                },
                fireWith: function(n, t) {
                    return e || (t = [n, (t = t || []).slice ? t.slice() : t], s.push(t), f || l()), this
                },
                fire: function() {
                    return h.fireWith(this, arguments), this
                },
                fired: function() {
                    return !!c
                }
            };
        return h
    };
    i.extend({
        Deferred: function(t) {
            var f = [
                    ["notify", "progress", i.Callbacks("memory"), i.Callbacks("memory"), 2],
                    ["resolve", "done", i.Callbacks("once memory"), i.Callbacks("once memory"), 0, "resolved"],
                    ["reject", "fail", i.Callbacks("once memory"), i.Callbacks("once memory"), 1, "rejected"]
                ],
                o = "pending",
                e = {
                    state: function() {
                        return o
                    },
                    always: function() {
                        return r.done(arguments).fail(arguments), this
                    },
                    "catch": function(n) {
                        return e.then(null, n)
                    },
                    pipe: function() {
                        var n = arguments;
                        return i.Deferred(function(t) {
                            i.each(f, function(i, f) {
                                var e = u(n[f[4]]) && n[f[4]];
                                r[f[1]](function() {
                                    var n = e && e.apply(this, arguments);
                                    n && u(n.promise) ? n.promise().progress(t.notify).done(t.resolve).fail(t.reject) : t[f[0] + "With"](this, e ? [n] : arguments)
                                })
                            });
                            n = null
                        }).promise()
                    },
                    then: function(t, r, e) {
                        function s(t, r, f, e) {
                            return function() {
                                var h = this,
                                    c = arguments,
                                    a = function() {
                                        var n, i;
                                        if (!(t < o)) {
                                            if ((n = f.apply(h, c)) === r.promise()) throw new TypeError("Thenable self-resolution");
                                            i = n && ("object" == typeof n || "function" == typeof n) && n.then;
                                            u(i) ? e ? i.call(n, s(o, r, ut, e), s(o, r, dt, e)) : (o++, i.call(n, s(o, r, ut, e), s(o, r, dt, e), s(o, r, ut, r.notifyWith))) : (f !== ut && (h = void 0, c = [n]), (e || r.resolveWith)(h, c))
                                        }
                                    },
                                    l = e ? a : function() {
                                        try {
                                            a()
                                        } catch (n) {
                                            i.Deferred.exceptionHook && i.Deferred.exceptionHook(n, l.stackTrace);
                                            t + 1 >= o && (f !== dt && (h = void 0, c = [n]), r.rejectWith(h, c))
                                        }
                                    };
                                t ? l() : (i.Deferred.getStackHook && (l.stackTrace = i.Deferred.getStackHook()), n.setTimeout(l))
                            }
                        }
                        var o = 0;
                        return i.Deferred(function(n) {
                            f[0][3].add(s(0, n, u(e) ? e : ut, n.notifyWith));
                            f[1][3].add(s(0, n, u(t) ? t : ut));
                            f[2][3].add(s(0, n, u(r) ? r : dt))
                        }).promise()
                    },
                    promise: function(n) {
                        return null != n ? i.extend(n, e) : e
                    }
                },
                r = {};
            return i.each(f, function(n, t) {
                var i = t[2],
                    u = t[5];
                e[t[1]] = i.add;
                u && i.add(function() {
                    o = u
                }, f[3 - n][2].disable, f[3 - n][3].disable, f[0][2].lock, f[0][3].lock);
                i.add(t[3].fire);
                r[t[0]] = function() {
                    return r[t[0] + "With"](this === r ? void 0 : this, arguments), this
                };
                r[t[0] + "With"] = i.fireWith
            }), e.promise(r), t && t.call(r, r), r
        },
        when: function(n) {
            var e = arguments.length,
                t = e,
                o = Array(t),
                f = d.call(arguments),
                r = i.Deferred(),
                s = function(n) {
                    return function(t) {
                        o[n] = this;
                        f[n] = arguments.length > 1 ? d.call(arguments) : t;
                        --e || r.resolveWith(o, f)
                    }
                };
            if (e <= 1 && (br(n, r.done(s(t)).resolve, r.reject, !e), "pending" === r.state() || u(f[t] && f[t].then))) return r.then();
            while (t--) br(f[t], s(t), r.reject);
            return r.promise()
        }
    });

    gt = i.Deferred();
    i.fn.ready = function(n) {
        return gt.then(n)["catch"](function(n) {
            i.readyException(n)
        }), this
    };
    i.extend({
        isReady: !1,
        readyWait: 1,
        ready: function(n) {
            (!0 === n ? --i.readyWait : i.isReady) || (i.isReady = !0, !0 !== n && --i.readyWait > 0 || gt.resolveWith(f, [i]))
        }
    });
    i.ready.then = gt.then;
    "complete" === f.readyState || "loading" !== f.readyState && !f.documentElement.doScroll ? n.setTimeout(i.ready) : (f.addEventListener("DOMContentLoaded", ni), n.addEventListener("load", ni));
    var p = function(n, t, r, f, e, o, s) {
            var h = 0,
                l = n.length,
                c = null == r;
            if ("object" === it(r)) {
                e = !0;
                for (h in r) p(n, t, h, r[h], !0, o, s)
            } else if (void 0 !== f && (e = !0, u(f) || (s = !0), c && (s ? (t.call(n, f), t = null) : (c = t, t = function(n, t, r) {
                    return c.call(i(n), r)
                })), t))
                for (; h < l; h++) t(n[h], r, s ? f : f.call(n[h], h, t(n[h], r)));
            return e ? n : c ? t.call(n) : l ? t(n[0], r) : o
        },
        te = /^-ms-/,
        ie = /-([a-z])/g;
    lt = function(n) {
        return 1 === n.nodeType || 9 === n.nodeType || !+n.nodeType
    };
    at.uid = 1;
    at.prototype = {
        cache: function(n) {
            var t = n[this.expando];
            return t || (t = {}, lt(n) && (n.nodeType ? n[this.expando] = t : Object.defineProperty(n, this.expando, {
                value: t,
                configurable: !0
            }))), t
        },
        set: function(n, t, i) {
            var r, u = this.cache(n);
            if ("string" == typeof t) u[y(t)] = i;
            else
                for (r in t) u[y(r)] = t[r];
            return u
        },
        get: function(n, t) {
            return void 0 === t ? this.cache(n) : n[this.expando] && n[this.expando][y(t)]
        },
        access: function(n, t, i) {
            return void 0 === t || t && "string" == typeof t && void 0 === i ? this.get(n, t) : (this.set(n, t, i), void 0 !== i ? i : t)
        },
        remove: function(n, t) {
            var u, r = n[this.expando];
            if (void 0 !== r) {
                if (void 0 !== t)
                    for (u = (t = Array.isArray(t) ? t.map(y) : (t = y(t)) in r ? [t] : t.match(l) || []).length; u--;) delete r[t[u]];
                (void 0 === t || i.isEmptyObject(r)) && (n.nodeType ? n[this.expando] = void 0 : delete n[this.expando])
            }
        },
        hasData: function(n) {
            var t = n[this.expando];
            return void 0 !== t && !i.isEmptyObject(t)
        }
    };
    var r = new at,
        o = new at,
        ue = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
        fe = /[A-Z]/g;
    i.extend({
        hasData: function(n) {
            return o.hasData(n) || r.hasData(n)
        },
        data: function(n, t, i) {
            return o.access(n, t, i)
        },
        removeData: function(n, t) {
            o.remove(n, t)
        },
        _data: function(n, t, i) {
            return r.access(n, t, i)
        },
        _removeData: function(n, t) {
            r.remove(n, t)
        }
    });
    i.fn.extend({
        data: function(n, t) {
            var f, u, e, i = this[0],
                s = i && i.attributes;
            if (void 0 === n) {
                if (this.length && (e = o.get(i), 1 === i.nodeType && !r.get(i, "hasDataAttrs"))) {
                    for (f = s.length; f--;) s[f] && 0 === (u = s[f].name).indexOf("data-") && (u = y(u.slice(5)), dr(i, u, e[u]));
                    r.set(i, "hasDataAttrs", !0)
                }
                return e
            }
            return "object" == typeof n ? this.each(function() {
                o.set(this, n)
            }) : p(this, function(t) {
                var r;
                if (i && void 0 === t) {
                    if (void 0 !== (r = o.get(i, n)) || void 0 !== (r = dr(i, n))) return r
                } else this.each(function() {
                    o.set(this, n, t)
                })
            }, null, t, arguments.length > 1, null, !0)
        },
        removeData: function(n) {
            return this.each(function() {
                o.remove(this, n)
            })
        }
    });
    i.extend({
        queue: function(n, t, u) {
            var f;
            if (n) return t = (t || "fx") + "queue", f = r.get(n, t), u && (!f || Array.isArray(u) ? f = r.access(n, t, i.makeArray(u)) : f.push(u)), f || []
        },
        dequeue: function(n, t) {
            t = t || "fx";
            var r = i.queue(n, t),
                e = r.length,
                u = r.shift(),
                f = i._queueHooks(n, t),
                o = function() {
                    i.dequeue(n, t)
                };
            "inprogress" === u && (u = r.shift(), e--);
            u && ("fx" === t && r.unshift("inprogress"), delete f.stop, u.call(n, o, f));
            !e && f && f.empty.fire()
        },
        _queueHooks: function(n, t) {
            var u = t + "queueHooks";
            return r.get(n, u) || r.access(n, u, {
                empty: i.Callbacks("once memory").add(function() {
                    r.remove(n, [t + "queue", u])
                })
            })
        }
    });
    i.fn.extend({
        queue: function(n, t) {
            var r = 2;
            return "string" != typeof n && (t = n, n = "fx", r--), arguments.length < r ? i.queue(this[0], n) : void 0 === t ? this : this.each(function() {
                var r = i.queue(this, n, t);
                i._queueHooks(this, n);
                "fx" === n && "inprogress" !== r[0] && i.dequeue(this, n)
            })
        },
        dequeue: function(n) {
            return this.each(function() {
                i.dequeue(this, n)
            })
        },
        clearQueue: function(n) {
            return this.queue(n || "fx", [])
        },
        promise: function(n, t) {
            var u, e = 1,
                o = i.Deferred(),
                f = this,
                s = this.length,
                h = function() {
                    --e || o.resolveWith(f, [f])
                };
            for ("string" != typeof n && (t = n, n = void 0), n = n || "fx"; s--;)(u = r.get(f[s], n + "queueHooks")) && u.empty && (e++, u.empty.add(h));
            return h(), o.promise(t)
        }
    });
    var gr = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
        vt = new RegExp("^(?:([+-])=|)(" + gr + ")([a-z%]*)$", "i"),
        w = ["Top", "Right", "Bottom", "Left"],
        ti = function(n, t) {
            return "none" === (n = t || n).style.display || "" === n.style.display && i.contains(n.ownerDocument, n) && "none" === i.css(n, "display")
        },
        nu = function(n, t, i, r) {
            var f, u, e = {};
            for (u in t) e[u] = n.style[u], n.style[u] = t[u];
            f = i.apply(n, r || []);
            for (u in t) n.style[u] = e[u];
            return f
        };
    ai = {};
    i.fn.extend({
        show: function() {
            return ft(this, !0)
        },
        hide: function() {
            return ft(this)
        },
        toggle: function(n) {
            return "boolean" == typeof n ? n ? this.show() : this.hide() : this.each(function() {
                ti(this) ? i(this).show() : i(this).hide()
            })
        }
    });
    var iu = /^(?:checkbox|radio)$/i,
        ru = /<([a-z][^\/\0>\x20\t\r\n\f]+)/i,
        uu = /^$|^module$|\/(?:java|ecma)script/i,
        c = {
            option: [1, "<select multiple='multiple'>", "<\/select>"],
            thead: [1, "<table>", "<\/table>"],
            col: [2, "<table><colgroup>", "<\/colgroup><\/table>"],
            tr: [2, "<table><tbody>", "<\/tbody><\/table>"],
            td: [3, "<table><tbody><tr>", "<\/tr><\/tbody><\/table>"],
            _default: [0, "", ""]
        };
    c.optgroup = c.option;
    c.tbody = c.tfoot = c.colgroup = c.caption = c.thead;
    c.th = c.td;
    fu = /<|&#?\w+;/;
    ! function() {
        var n = f.createDocumentFragment().appendChild(f.createElement("div")),
            t = f.createElement("input");
        t.setAttribute("type", "radio");
        t.setAttribute("checked", "checked");
        t.setAttribute("name", "t");
        n.appendChild(t);
        e.checkClone = n.cloneNode(!0).cloneNode(!0).lastChild.checked;
        n.innerHTML = "<textarea>x<\/textarea>";
        e.noCloneChecked = !!n.cloneNode(!0).lastChild.defaultValue
    }();
    var ii = f.documentElement,
        se = /^key/,
        he = /^(?:mouse|pointer|contextmenu|drag|drop)|click/,
        ou = /^([^.]*)(?:\.(.+)|)/;
    i.event = {
        global: {},
        add: function(n, t, u, f, e) {
            var p, v, k, y, w, h, s, c, o, b, d, a = r.get(n);
            if (a)
                for (u.handler && (u = (p = u).handler, e = p.selector), e && i.find.matchesSelector(ii, e), u.guid || (u.guid = i.guid++), (y = a.events) || (y = a.events = {}), (v = a.handle) || (v = a.handle = function(t) {
                        if ("undefined" != typeof i && i.event.triggered !== t.type) return i.event.dispatch.apply(n, arguments)
                    }), w = (t = (t || "").match(l) || [""]).length; w--;) o = d = (k = ou.exec(t[w]) || [])[1], b = (k[2] || "").split(".").sort(), o && (s = i.event.special[o] || {}, o = (e ? s.delegateType : s.bindType) || o, s = i.event.special[o] || {}, h = i.extend({
                    type: o,
                    origType: d,
                    data: f,
                    handler: u,
                    guid: u.guid,
                    selector: e,
                    needsContext: e && i.expr.match.needsContext.test(e),
                    namespace: b.join(".")
                }, p), (c = y[o]) || ((c = y[o] = []).delegateCount = 0, s.setup && !1 !== s.setup.call(n, f, b, v) || n.addEventListener && n.addEventListener(o, v)), s.add && (s.add.call(n, h), h.handler.guid || (h.handler.guid = u.guid)), e ? c.splice(c.delegateCount++, 0, h) : c.push(h), i.event.global[o] = !0)
        },
        remove: function(n, t, u, f, e) {
            var y, k, h, v, p, s, c, a, o, b, d, w = r.hasData(n) && r.get(n);
            if (w && (v = w.events)) {
                for (p = (t = (t || "").match(l) || [""]).length; p--;)
                    if (h = ou.exec(t[p]) || [], o = d = h[1], b = (h[2] || "").split(".").sort(), o) {
                        for (c = i.event.special[o] || {}, a = v[o = (f ? c.delegateType : c.bindType) || o] || [], h = h[2] && new RegExp("(^|\\.)" + b.join("\\.(?:.*\\.|)") + "(\\.|$)"), k = y = a.length; y--;) s = a[y], !e && d !== s.origType || u && u.guid !== s.guid || h && !h.test(s.namespace) || f && f !== s.selector && ("**" !== f || !s.selector) || (a.splice(y, 1), s.selector && a.delegateCount--, c.remove && c.remove.call(n, s));
                        k && !a.length && (c.teardown && !1 !== c.teardown.call(n, b, w.handle) || i.removeEvent(n, o, w.handle), delete v[o])
                    } else
                        for (o in v) i.event.remove(n, o + t[p], u, f, !0);
                i.isEmptyObject(v) && r.remove(n, "handle events")
            }
        },
        dispatch: function(n) {
            var t = i.event.fix(n),
                u, h, c, e, f, l, s = new Array(arguments.length),
                a = (r.get(this, "events") || {})[t.type] || [],
                o = i.event.special[t.type] || {};
            for (s[0] = t, u = 1; u < arguments.length; u++) s[u] = arguments[u];
            if (t.delegateTarget = this, !o.preDispatch || !1 !== o.preDispatch.call(this, t)) {
                for (l = i.event.handlers.call(this, t, a), u = 0;
                    (e = l[u++]) && !t.isPropagationStopped();)
                    for (t.currentTarget = e.elem, h = 0;
                        (f = e.handlers[h++]) && !t.isImmediatePropagationStopped();) t.rnamespace && !t.rnamespace.test(f.namespace) || (t.handleObj = f, t.data = f.data, void 0 !== (c = ((i.event.special[f.origType] || {}).handle || f.handler).apply(e.elem, s)) && !1 === (t.result = c) && (t.preventDefault(), t.stopPropagation()));
                return o.postDispatch && o.postDispatch.call(this, t), t.result
            }
        },
        handlers: function(n, t) {
            var f, h, u, e, o, c = [],
                s = t.delegateCount,
                r = n.target;
            if (s && r.nodeType && !("click" === n.type && n.button >= 1))
                for (; r !== this; r = r.parentNode || this)
                    if (1 === r.nodeType && ("click" !== n.type || !0 !== r.disabled)) {
                        for (e = [], o = {}, f = 0; f < s; f++) void 0 === o[u = (h = t[f]).selector + " "] && (o[u] = h.needsContext ? i(u, this).index(r) > -1 : i.find(u, this, null, [r]).length), o[u] && e.push(h);
                        e.length && c.push({
                            elem: r,
                            handlers: e
                        })
                    } return r = this, s < t.length && c.push({
                elem: r,
                handlers: t.slice(s)
            }), c
        },
        addProp: function(n, t) {
            Object.defineProperty(i.Event.prototype, n, {
                enumerable: !0,
                configurable: !0,
                get: u(t) ? function() {
                    if (this.originalEvent) return t(this.originalEvent)
                } : function() {
                    if (this.originalEvent) return this.originalEvent[n]
                },
                set: function(t) {
                    Object.defineProperty(this, n, {
                        enumerable: !0,
                        configurable: !0,
                        writable: !0,
                        value: t
                    })
                }
            })
        },
        fix: function(n) {
            return n[i.expando] ? n : new i.Event(n)
        },
        special: {
            load: {
                noBubble: !0
            },
            focus: {
                trigger: function() {
                    if (this !== su() && this.focus) return this.focus(), !1
                },
                delegateType: "focusin"
            },
            blur: {
                trigger: function() {
                    if (this === su() && this.blur) return this.blur(), !1
                },
                delegateType: "focusout"
            },
            click: {
                trigger: function() {
                    if ("checkbox" === this.type && this.click && v(this, "input")) return this.click(), !1
                },
                _default: function(n) {
                    return v(n.target, "a")
                }
            },
            beforeunload: {
                postDispatch: function(n) {
                    void 0 !== n.result && n.originalEvent && (n.originalEvent.returnValue = n.result)
                }
            }
        }
    };
    i.removeEvent = function(n, t, i) {
        n.removeEventListener && n.removeEventListener(t, i)
    };
    i.Event = function(n, t) {
        if (!(this instanceof i.Event)) return new i.Event(n, t);
        n && n.type ? (this.originalEvent = n, this.type = n.type, this.isDefaultPrevented = n.defaultPrevented || void 0 === n.defaultPrevented && !1 === n.returnValue ? ri : et, this.target = n.target && 3 === n.target.nodeType ? n.target.parentNode : n.target, this.currentTarget = n.currentTarget, this.relatedTarget = n.relatedTarget) : this.type = n;
        t && i.extend(this, t);
        this.timeStamp = n && n.timeStamp || Date.now();
        this[i.expando] = !0
    };
    i.Event.prototype = {
        constructor: i.Event,
        isDefaultPrevented: et,
        isPropagationStopped: et,
        isImmediatePropagationStopped: et,
        isSimulated: !1,
        preventDefault: function() {
            var n = this.originalEvent;
            this.isDefaultPrevented = ri;
            n && !this.isSimulated && n.preventDefault()
        },
        stopPropagation: function() {
            var n = this.originalEvent;
            this.isPropagationStopped = ri;
            n && !this.isSimulated && n.stopPropagation()
        },
        stopImmediatePropagation: function() {
            var n = this.originalEvent;
            this.isImmediatePropagationStopped = ri;
            n && !this.isSimulated && n.stopImmediatePropagation();
            this.stopPropagation()
        }
    };
    i.each({
        altKey: !0,
        bubbles: !0,
        cancelable: !0,
        changedTouches: !0,
        ctrlKey: !0,
        detail: !0,
        eventPhase: !0,
        metaKey: !0,
        pageX: !0,
        pageY: !0,
        shiftKey: !0,
        view: !0,
        char: !0,
        charCode: !0,
        key: !0,
        keyCode: !0,
        button: !0,
        buttons: !0,
        clientX: !0,
        clientY: !0,
        offsetX: !0,
        offsetY: !0,
        pointerId: !0,
        pointerType: !0,
        screenX: !0,
        screenY: !0,
        targetTouches: !0,
        toElement: !0,
        touches: !0,
        which: function(n) {
            var t = n.button;
            return null == n.which && se.test(n.type) ? null != n.charCode ? n.charCode : n.keyCode : !n.which && void 0 !== t && he.test(n.type) ? 1 & t ? 1 : 2 & t ? 3 : 4 & t ? 2 : 0 : n.which
        }
    }, i.event.addProp);
    i.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function(n, t) {
        i.event.special[n] = {
            delegateType: t,
            bindType: t,
            handle: function(n) {
                var u, f = this,
                    r = n.relatedTarget,
                    e = n.handleObj;
                return r && (r === f || i.contains(f, r)) || (n.type = e.origType, u = e.handler.apply(this, arguments), n.type = t), u
            }
        }
    });
    i.fn.extend({
        on: function(n, t, i, r) {
            return yi(this, n, t, i, r)
        },
        one: function(n, t, i, r) {
            return yi(this, n, t, i, r, 1)
        },
        off: function(n, t, r) {
            var u, f;
            if (n && n.preventDefault && n.handleObj) return u = n.handleObj, i(n.delegateTarget).off(u.namespace ? u.origType + "." + u.namespace : u.origType, u.selector, u.handler), this;
            if ("object" == typeof n) {
                for (f in n) this.off(f, t, n[f]);
                return this
            }
            return !1 !== t && "function" != typeof t || (r = t, t = void 0), !1 === r && (r = et), this.each(function() {
                i.event.remove(this, n, r, t)
            })
        }
    });
    var ce = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([a-z][^\/\0>\x20\t\r\n\f]*)[^>]*)\/>/gi,
        le = /<script|<style|<link/i,
        ae = /checked\s*(?:[^=]|=\s*.checked.)/i,
        ve = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;
    i.extend({
        htmlPrefilter: function(n) {
            return n.replace(ce, "<$1><\/$2>")
        },
        clone: function(n, t, r) {
            var u, c, o, f, h = n.cloneNode(!0),
                l = i.contains(n.ownerDocument, n);
            if (!(e.noCloneChecked || 1 !== n.nodeType && 11 !== n.nodeType || i.isXMLDoc(n)))
                for (f = s(h), u = 0, c = (o = s(n)).length; u < c; u++) we(o[u], f[u]);
            if (t)
                if (r)
                    for (o = o || s(n), f = f || s(h), u = 0, c = o.length; u < c; u++) cu(o[u], f[u]);
                else cu(n, h);
            return (f = s(h, "script")).length > 0 && vi(f, !l && s(n, "script")), h
        },
        cleanData: function(n) {
            for (var u, t, f, s = i.event.special, e = 0; void 0 !== (t = n[e]); e++)
                if (lt(t)) {
                    if (u = t[r.expando]) {
                        if (u.events)
                            for (f in u.events) s[f] ? i.event.remove(t, f) : i.removeEvent(t, f, u.handle);
                        t[r.expando] = void 0
                    }
                    t[o.expando] && (t[o.expando] = void 0)
                }
        }
    });
    i.fn.extend({
        detach: function(n) {
            return lu(this, n, !0)
        },
        remove: function(n) {
            return lu(this, n)
        },
        text: function(n) {
            return p(this, function(n) {
                return void 0 === n ? i.text(this) : this.empty().each(function() {
                    1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = n)
                })
            }, null, n, arguments.length)
        },
        append: function() {
            return ot(this, arguments, function(n) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || hu(this, n).appendChild(n)
            })
        },
        prepend: function() {
            return ot(this, arguments, function(n) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = hu(this, n);
                    t.insertBefore(n, t.firstChild)
                }
            })
        },
        before: function() {
            return ot(this, arguments, function(n) {
                this.parentNode && this.parentNode.insertBefore(n, this)
            })
        },
        after: function() {
            return ot(this, arguments, function(n) {
                this.parentNode && this.parentNode.insertBefore(n, this.nextSibling)
            })
        },
        empty: function() {
            for (var n, t = 0; null != (n = this[t]); t++) 1 === n.nodeType && (i.cleanData(s(n, !1)), n.textContent = "");
            return this
        },
        clone: function(n, t) {
            return n = null != n && n, t = null == t ? n : t, this.map(function() {
                return i.clone(this, n, t)
            })
        },
        html: function(n) {
            return p(this, function(n) {
                var t = this[0] || {},
                    r = 0,
                    u = this.length;
                if (void 0 === n && 1 === t.nodeType) return t.innerHTML;
                if ("string" == typeof n && !le.test(n) && !c[(ru.exec(n) || ["", ""])[1].toLowerCase()]) {
                    n = i.htmlPrefilter(n);
                    try {
                        for (; r < u; r++) 1 === (t = this[r] || {}).nodeType && (i.cleanData(s(t, !1)), t.innerHTML = n);
                        t = 0
                    } catch (n) {}
                }
                t && this.empty().append(n)
            }, null, n, arguments.length)
        },
        replaceWith: function() {
            var n = [];
            return ot(this, arguments, function(t) {
                var r = this.parentNode;
                i.inArray(this, n) < 0 && (i.cleanData(s(this)), r && r.replaceChild(t, this))
            }, n)
        }
    });
    i.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function(n, t) {
        i.fn[n] = function(n) {
            for (var u, f = [], e = i(n), o = e.length - 1, r = 0; r <= o; r++) u = r === o ? this : this.clone(!0), i(e[r])[t](u), si.apply(f, u.get());
            return this.pushStack(f)
        }
    });
    var pi = new RegExp("^(" + gr + ")(?!px)[a-z%]+$", "i"),
        ui = function(t) {
            var i = t.ownerDocument.defaultView;
            return i && i.opener || (i = n), i.getComputedStyle(t)
        },
        be = new RegExp(w.join("|"), "i");
    ! function() {
        function r() {
            if (t) {
                o.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0";
                t.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%";
                ii.appendChild(o).appendChild(t);
                var i = n.getComputedStyle(t);
                s = "1%" !== i.top;
                a = 12 === u(i.marginLeft);
                t.style.right = "60%";
                l = 36 === u(i.right);
                h = 36 === u(i.width);
                t.style.position = "absolute";
                c = 36 === t.offsetWidth || "absolute";
                ii.removeChild(o);
                t = null
            }
        }

        function u(n) {
            return Math.round(parseFloat(n))
        }
        var s, h, c, l, a, o = f.createElement("div"),
            t = f.createElement("div");
        t.style && (t.style.backgroundClip = "content-box", t.cloneNode(!0).style.backgroundClip = "", e.clearCloneStyle = "content-box" === t.style.backgroundClip, i.extend(e, {
            boxSizingReliable: function() {
                return r(), h
            },
            pixelBoxStyles: function() {
                return r(), l
            },
            pixelPosition: function() {
                return r(), s
            },
            reliableMarginLeft: function() {
                return r(), a
            },
            scrollboxSize: function() {
                return r(), c
            }
        }))
    }();
    var ke = /^(none|table(?!-c[ea]).+)/,
        vu = /^--/,
        de = {
            position: "absolute",
            visibility: "hidden",
            display: "block"
        },
        yu = {
            letterSpacing: "0",
            fontWeight: "400"
        },
        pu = ["Webkit", "Moz", "ms"],
        wu = f.createElement("div").style;
    i.extend({
        cssHooks: {
            opacity: {
                get: function(n, t) {
                    if (t) {
                        var i = yt(n, "opacity");
                        return "" === i ? "1" : i
                    }
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
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
        cssProps: {},
        style: function(n, t, r, u) {
            if (n && 3 !== n.nodeType && 8 !== n.nodeType && n.style) {
                var f, h, o, c = y(t),
                    l = vu.test(t),
                    s = n.style;
                if (l || (t = bu(c)), o = i.cssHooks[t] || i.cssHooks[c], void 0 === r) return o && "get" in o && void 0 !== (f = o.get(n, !1, u)) ? f : s[t];
                "string" == (h = typeof r) && (f = vt.exec(r)) && f[1] && (r = tu(n, t, f), h = "number");
                null != r && r === r && ("number" === h && (r += f && f[3] || (i.cssNumber[c] ? "" : "px")), e.clearCloneStyle || "" !== r || 0 !== t.indexOf("background") || (s[t] = "inherit"), o && "set" in o && void 0 === (r = o.set(n, r, u)) || (l ? s.setProperty(t, r) : s[t] = r))
            }
        },
        css: function(n, t, r, u) {
            var f, e, o, s = y(t);
            return vu.test(t) || (t = bu(s)), (o = i.cssHooks[t] || i.cssHooks[s]) && "get" in o && (f = o.get(n, !0, r)), void 0 === f && (f = yt(n, t, u)), "normal" === f && t in yu && (f = yu[t]), "" === r || r ? (e = parseFloat(f), !0 === r || isFinite(e) ? e || 0 : f) : f
        }
    });
    i.each(["height", "width"], function(n, t) {
        i.cssHooks[t] = {
            get: function(n, r, u) {
                if (r) return !ke.test(i.css(n, "display")) || n.getClientRects().length && n.getBoundingClientRect().width ? du(n, t, u) : nu(n, de, function() {
                    return du(n, t, u)
                })
            },
            set: function(n, r, u) {
                var s, f = ui(n),
                    h = "border-box" === i.css(n, "boxSizing", !1, f),
                    o = u && wi(n, t, u, h, f);
                return h && e.scrollboxSize() === f.position && (o -= Math.ceil(n["offset" + t[0].toUpperCase() + t.slice(1)] - parseFloat(f[t]) - wi(n, t, "border", !1, f) - .5)), o && (s = vt.exec(r)) && "px" !== (s[3] || "px") && (n.style[t] = r, r = i.css(n, t)), ku(n, r, o)
            }
        }
    });
    i.cssHooks.marginLeft = au(e.reliableMarginLeft, function(n, t) {
        if (t) return (parseFloat(yt(n, "marginLeft")) || n.getBoundingClientRect().left - nu(n, {
            marginLeft: 0
        }, function() {
            return n.getBoundingClientRect().left
        })) + "px"
    });
    i.each({
        margin: "",
        padding: "",
        border: "Width"
    }, function(n, t) {
        i.cssHooks[n + t] = {
            expand: function(i) {
                for (var r = 0, f = {}, u = "string" == typeof i ? i.split(" ") : [i]; r < 4; r++) f[n + w[r] + t] = u[r] || u[r - 2] || u[0];
                return f
            }
        };
        "margin" !== n && (i.cssHooks[n + t].set = ku)
    });
    i.fn.extend({
        css: function(n, t) {
            return p(this, function(n, t, r) {
                var f, e, o = {},
                    u = 0;
                if (Array.isArray(t)) {
                    for (f = ui(n), e = t.length; u < e; u++) o[t[u]] = i.css(n, t[u], !1, f);
                    return o
                }
                return void 0 !== r ? i.style(n, t, r) : i.css(n, t)
            }, n, t, arguments.length > 1)
        }
    });
    i.Tween = h;
    h.prototype = {
        constructor: h,
        init: function(n, t, r, u, f, e) {
            this.elem = n;
            this.prop = r;
            this.easing = f || i.easing._default;
            this.options = t;
            this.start = this.now = this.cur();
            this.end = u;
            this.unit = e || (i.cssNumber[r] ? "" : "px")
        },
        cur: function() {
            var n = h.propHooks[this.prop];
            return n && n.get ? n.get(this) : h.propHooks._default.get(this)
        },
        run: function(n) {
            var t, r = h.propHooks[this.prop];
            return this.pos = this.options.duration ? t = i.easing[this.easing](n, this.options.duration * n, 0, 1, this.options.duration) : t = n, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), r && r.set ? r.set(this) : h.propHooks._default.set(this), this
        }
    };
    h.prototype.init.prototype = h.prototype;
    h.propHooks = {
        _default: {
            get: function(n) {
                var t;
                return 1 !== n.elem.nodeType || null != n.elem[n.prop] && null == n.elem.style[n.prop] ? n.elem[n.prop] : (t = i.css(n.elem, n.prop, "")) && "auto" !== t ? t : 0
            },
            set: function(n) {
                i.fx.step[n.prop] ? i.fx.step[n.prop](n) : 1 !== n.elem.nodeType || null == n.elem.style[i.cssProps[n.prop]] && !i.cssHooks[n.prop] ? n.elem[n.prop] = n.now : i.style(n.elem, n.prop, n.now + n.unit)
            }
        }
    };
    h.propHooks.scrollTop = h.propHooks.scrollLeft = {
        set: function(n) {
            n.elem.nodeType && n.elem.parentNode && (n.elem[n.prop] = n.now)
        }
    };
    i.easing = {
        linear: function(n) {
            return n
        },
        swing: function(n) {
            return .5 - Math.cos(n * Math.PI) / 2
        },
        _default: "swing"
    };
    i.fx = h.prototype.init;
    i.fx.step = {};
    gu = /^(?:toggle|show|hide)$/;
    nf = /queueHooks$/;
    i.Animation = i.extend(a, {
        tweeners: {
            "*": [function(n, t) {
                var i = this.createTween(n, t);
                return tu(i.elem, n, vt.exec(t), i), i
            }]
        },
        tweener: function(n, t) {
            u(n) ? (t = n, n = ["*"]) : n = n.match(l);
            for (var i, r = 0, f = n.length; r < f; r++) i = n[r], a.tweeners[i] = a.tweeners[i] || [], a.tweeners[i].unshift(t)
        },
        prefilters: [no],
        prefilter: function(n, t) {
            t ? a.prefilters.unshift(n) : a.prefilters.push(n)
        }
    });
    i.speed = function(n, t, r) {
        var f = n && "object" == typeof n ? i.extend({}, n) : {
            complete: r || !r && t || u(n) && n,
            duration: n,
            easing: r && t || t && !u(t) && t
        };
        return i.fx.off ? f.duration = 0 : "number" != typeof f.duration && (f.duration = f.duration in i.fx.speeds ? i.fx.speeds[f.duration] : i.fx.speeds._default), null != f.queue && !0 !== f.queue || (f.queue = "fx"), f.old = f.complete, f.complete = function() {
            u(f.old) && f.old.call(this);
            f.queue && i.dequeue(this, f.queue)
        }, f
    };
    i.fn.extend({
        fadeTo: function(n, t, i, r) {
            return this.filter(ti).css("opacity", 0).show().end().animate({
                opacity: t
            }, n, i, r)
        },
        animate: function(n, t, u, f) {
            var s = i.isEmptyObject(n),
                o = i.speed(t, u, f),
                e = function() {
                    var t = a(this, i.extend({}, n), o);
                    (s || r.get(this, "finish")) && t.stop(!0)
                };
            return e.finish = e, s || !1 === o.queue ? this.each(e) : this.queue(o.queue, e)
        },
        stop: function(n, t, u) {
            var f = function(n) {
                var t = n.stop;
                delete n.stop;
                t(u)
            };
            return "string" != typeof n && (u = t, t = n, n = void 0), t && !1 !== n && this.queue(n || "fx", []), this.each(function() {
                var s = !0,
                    t = null != n && n + "queueHooks",
                    o = i.timers,
                    e = r.get(this);
                if (t) e[t] && e[t].stop && f(e[t]);
                else
                    for (t in e) e[t] && e[t].stop && nf.test(t) && f(e[t]);
                for (t = o.length; t--;) o[t].elem !== this || null != n && o[t].queue !== n || (o[t].anim.stop(u), s = !1, o.splice(t, 1));
                !s && u || i.dequeue(this, n)
            })
        },
        finish: function(n) {
            return !1 !== n && (n = n || "fx"), this.each(function() {
                var t, e = r.get(this),
                    u = e[n + "queue"],
                    o = e[n + "queueHooks"],
                    f = i.timers,
                    s = u ? u.length : 0;
                for (e.finish = !0, i.queue(this, n, []), o && o.stop && o.stop.call(this, !0), t = f.length; t--;) f[t].elem === this && f[t].queue === n && (f[t].anim.stop(!0), f.splice(t, 1));
                for (t = 0; t < s; t++) u[t] && u[t].finish && u[t].finish.call(this);
                delete e.finish
            })
        }
    });
    i.each(["toggle", "show", "hide"], function(n, t) {
        var r = i.fn[t];
        i.fn[t] = function(n, i, u) {
            return null == n || "boolean" == typeof n ? r.apply(this, arguments) : this.animate(ei(t, !0), n, i, u)
        }
    });
    i.each({
        slideDown: ei("show"),
        slideUp: ei("hide"),
        slideToggle: ei("toggle"),
        fadeIn: {
            opacity: "show"
        },
        fadeOut: {
            opacity: "hide"
        },
        fadeToggle: {
            opacity: "toggle"
        }
    }, function(n, t) {
        i.fn[n] = function(n, i, r) {
            return this.animate(t, n, i, r)
        }
    });
    i.timers = [];
    i.fx.tick = function() {
        var r, n = 0,
            t = i.timers;
        for (st = Date.now(); n < t.length; n++)(r = t[n])() || t[n] !== r || t.splice(n--, 1);
        t.length || i.fx.stop();
        st = void 0
    };
    i.fx.timer = function(n) {
        i.timers.push(n);
        i.fx.start()
    };
    i.fx.interval = 13;
    i.fx.start = function() {
        fi || (fi = !0, bi())
    };
    i.fx.stop = function() {
        fi = null
    };
    i.fx.speeds = {
        slow: 600,
        fast: 200,
        _default: 400
    };
    i.fn.delay = function(t, r) {
            return t = i.fx ? i.fx.speeds[t] || t : t, r = r || "fx", this.queue(r, function(i, r) {
                var u = n.setTimeout(i, t);
                r.stop = function() {
                    n.clearTimeout(u)
                }
            })
        },
        function() {
            var n = f.createElement("input"),
                t = f.createElement("select").appendChild(f.createElement("option"));
            n.type = "checkbox";
            e.checkOn = "" !== n.value;
            e.optSelected = t.selected;
            (n = f.createElement("input")).value = "t";
            n.type = "radio";
            e.radioValue = "t" === n.value
        }();
    ht = i.expr.attrHandle;
    i.fn.extend({
        attr: function(n, t) {
            return p(this, i.attr, n, t, arguments.length > 1)
        },
        removeAttr: function(n) {
            return this.each(function() {
                i.removeAttr(this, n)
            })
        }
    });
    i.extend({
        attr: function(n, t, r) {
            var f, u, e = n.nodeType;
            if (3 !== e && 8 !== e && 2 !== e) return "undefined" == typeof n.getAttribute ? i.prop(n, t, r) : (1 === e && i.isXMLDoc(n) || (u = i.attrHooks[t.toLowerCase()] || (i.expr.match.bool.test(t) ? uf : void 0)), void 0 !== r ? null === r ? void i.removeAttr(n, t) : u && "set" in u && void 0 !== (f = u.set(n, r, t)) ? f : (n.setAttribute(t, r + ""), r) : u && "get" in u && null !== (f = u.get(n, t)) ? f : null == (f = i.find.attr(n, t)) ? void 0 : f)
        },
        attrHooks: {
            type: {
                set: function(n, t) {
                    if (!e.radioValue && "radio" === t && v(n, "input")) {
                        var i = n.value;
                        return n.setAttribute("type", t), i && (n.value = i), t
                    }
                }
            }
        },
        removeAttr: function(n, t) {
            var i, u = 0,
                r = t && t.match(l);
            if (r && 1 === n.nodeType)
                while (i = r[u++]) n.removeAttribute(i)
        }
    });
    uf = {
        set: function(n, t, r) {
            return !1 === t ? i.removeAttr(n, r) : n.setAttribute(r, r), r
        }
    };
    i.each(i.expr.match.bool.source.match(/\w+/g), function(n, t) {
        var r = ht[t] || i.find.attr;
        ht[t] = function(n, t, i) {
            var f, e, u = t.toLowerCase();
            return i || (e = ht[u], ht[u] = f, f = null != r(n, t, i) ? u : null, ht[u] = e), f
        }
    });
    ff = /^(?:input|select|textarea|button)$/i;
    ef = /^(?:a|area)$/i;
    i.fn.extend({
        prop: function(n, t) {
            return p(this, i.prop, n, t, arguments.length > 1)
        },
        removeProp: function(n) {
            return this.each(function() {
                delete this[i.propFix[n] || n]
            })
        }
    });
    i.extend({
        prop: function(n, t, r) {
            var f, u, e = n.nodeType;
            if (3 !== e && 8 !== e && 2 !== e) return 1 === e && i.isXMLDoc(n) || (t = i.propFix[t] || t, u = i.propHooks[t]), void 0 !== r ? u && "set" in u && void 0 !== (f = u.set(n, r, t)) ? f : n[t] = r : u && "get" in u && null !== (f = u.get(n, t)) ? f : n[t]
        },
        propHooks: {
            tabIndex: {
                get: function(n) {
                    var t = i.find.attr(n, "tabindex");
                    return t ? parseInt(t, 10) : ff.test(n.nodeName) || ef.test(n.nodeName) && n.href ? 0 : -1
                }
            }
        },
        propFix: {
            "for": "htmlFor",
            "class": "className"
        }
    });
    e.optSelected || (i.propHooks.selected = {
        get: function(n) {
            var t = n.parentNode;
            return t && t.parentNode && t.parentNode.selectedIndex, null
        },
        set: function(n) {
            var t = n.parentNode;
            t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex)
        }
    });
    i.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() {
        i.propFix[this.toLowerCase()] = this
    });
    i.fn.extend({
        addClass: function(n) {
            var o, t, r, f, e, s, h, c = 0;
            if (u(n)) return this.each(function(t) {
                i(this).addClass(n.call(this, t, nt(this)))
            });
            if ((o = ki(n)).length)
                while (t = this[c++])
                    if (f = nt(t), r = 1 === t.nodeType && " " + g(f) + " ") {
                        for (s = 0; e = o[s++];) r.indexOf(" " + e + " ") < 0 && (r += e + " ");
                        f !== (h = g(r)) && t.setAttribute("class", h)
                    } return this
        },
        removeClass: function(n) {
            var o, r, t, f, e, s, h, c = 0;
            if (u(n)) return this.each(function(t) {
                i(this).removeClass(n.call(this, t, nt(this)))
            });
            if (!arguments.length) return this.attr("class", "");
            if ((o = ki(n)).length)
                while (r = this[c++])
                    if (f = nt(r), t = 1 === r.nodeType && " " + g(f) + " ") {
                        for (s = 0; e = o[s++];)
                            while (t.indexOf(" " + e + " ") > -1) t = t.replace(" " + e + " ", " ");
                        f !== (h = g(t)) && r.setAttribute("class", h)
                    } return this
        },
        toggleClass: function(n, t) {
            var f = typeof n,
                e = "string" === f || Array.isArray(n);
            return "boolean" == typeof t && e ? t ? this.addClass(n) : this.removeClass(n) : u(n) ? this.each(function(r) {
                i(this).toggleClass(n.call(this, r, nt(this), t), t)
            }) : this.each(function() {
                var t, o, u, s;
                if (e)
                    for (o = 0, u = i(this), s = ki(n); t = s[o++];) u.hasClass(t) ? u.removeClass(t) : u.addClass(t);
                else void 0 !== n && "boolean" !== f || ((t = nt(this)) && r.set(this, "__className__", t), this.setAttribute && this.setAttribute("class", t || !1 === n ? "" : r.get(this, "__className__") || ""))
            })
        },
        hasClass: function(n) {
            for (var t, r = 0, i = " " + n + " "; t = this[r++];)
                if (1 === t.nodeType && (" " + g(nt(t)) + " ").indexOf(i) > -1) return !0;
            return !1
        }
    }); of = /\r/g;
    i.fn.extend({
        val: function(n) {
            var t, r, e, f = this[0];
            return arguments.length ? (e = u(n), this.each(function(r) {
                var u;
                1 === this.nodeType && (null == (u = e ? n.call(this, r, i(this).val()) : n) ? u = "" : "number" == typeof u ? u += "" : Array.isArray(u) && (u = i.map(u, function(n) {
                    return null == n ? "" : n + ""
                })), (t = i.valHooks[this.type] || i.valHooks[this.nodeName.toLowerCase()]) && "set" in t && void 0 !== t.set(this, u, "value") || (this.value = u))
            })) : f ? (t = i.valHooks[f.type] || i.valHooks[f.nodeName.toLowerCase()]) && "get" in t && void 0 !== (r = t.get(f, "value")) ? r : "string" == typeof(r = f.value) ? r.replace( of , "") : null == r ? "" : r : void 0
        }
    });
    i.extend({
        valHooks: {
            option: {
                get: function(n) {
                    var t = i.find.attr(n, "value");
                    return null != t ? t : g(i.text(n))
                }
            },
            select: {
                get: function(n) {
                    for (var e, t, o = n.options, u = n.selectedIndex, f = "select-one" === n.type, s = f ? null : [], h = f ? u + 1 : o.length, r = u < 0 ? h : f ? u : 0; r < h; r++)
                        if (((t = o[r]).selected || r === u) && !t.disabled && (!t.parentNode.disabled || !v(t.parentNode, "optgroup"))) {
                            if (e = i(t).val(), f) return e;
                            s.push(e)
                        } return s
                },
                set: function(n, t) {
                    for (var r, u, f = n.options, e = i.makeArray(t), o = f.length; o--;)((u = f[o]).selected = i.inArray(i.valHooks.option.get(u), e) > -1) && (r = !0);
                    return r || (n.selectedIndex = -1), e
                }
            }
        }
    });
    i.each(["radio", "checkbox"], function() {
        i.valHooks[this] = {
            set: function(n, t) {
                if (Array.isArray(t)) return n.checked = i.inArray(i(n).val(), t) > -1
            }
        };
        e.checkOn || (i.valHooks[this].get = function(n) {
            return null === n.getAttribute("value") ? "on" : n.value
        })
    });
    e.focusin = "onfocusin" in n;
    di = /^(?:focusinfocus|focusoutblur)$/;
    gi = function(n) {
        n.stopPropagation()
    };
    i.extend(i.event, {
        trigger: function(t, e, o, s) {
            var k, c, l, d, v, y, a, p, w = [o || f],
                h = kt.call(t, "type") ? t.type : t,
                b = kt.call(t, "namespace") ? t.namespace.split(".") : [];
            if (c = p = l = o = o || f, 3 !== o.nodeType && 8 !== o.nodeType && !di.test(h + i.event.triggered) && (h.indexOf(".") > -1 && (h = (b = h.split(".")).shift(), b.sort()), v = h.indexOf(":") < 0 && "on" + h, t = t[i.expando] ? t : new i.Event(h, "object" == typeof t && t), t.isTrigger = s ? 2 : 3, t.namespace = b.join("."), t.rnamespace = t.namespace ? new RegExp("(^|\\.)" + b.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, t.result = void 0, t.target || (t.target = o), e = null == e ? [t] : i.makeArray(e, [t]), a = i.event.special[h] || {}, s || !a.trigger || !1 !== a.trigger.apply(o, e))) {
                if (!s && !a.noBubble && !tt(o)) {
                    for (d = a.delegateType || h, di.test(d + h) || (c = c.parentNode); c; c = c.parentNode) w.push(c), l = c;
                    l === (o.ownerDocument || f) && w.push(l.defaultView || l.parentWindow || n)
                }
                for (k = 0;
                    (c = w[k++]) && !t.isPropagationStopped();) p = c, t.type = k > 1 ? d : a.bindType || h, (y = (r.get(c, "events") || {})[t.type] && r.get(c, "handle")) && y.apply(c, e), (y = v && c[v]) && y.apply && lt(c) && (t.result = y.apply(c, e), !1 === t.result && t.preventDefault());
                return t.type = h, s || t.isDefaultPrevented() || a._default && !1 !== a._default.apply(w.pop(), e) || !lt(o) || v && u(o[h]) && !tt(o) && ((l = o[v]) && (o[v] = null), i.event.triggered = h, t.isPropagationStopped() && p.addEventListener(h, gi), o[h](), t.isPropagationStopped() && p.removeEventListener(h, gi), i.event.triggered = void 0, l && (o[v] = l)), t.result
            }
        },
        simulate: function(n, t, r) {
            var u = i.extend(new i.Event, r, {
                type: n,
                isSimulated: !0
            });
            i.event.trigger(u, null, t)
        }
    });
    i.fn.extend({
        trigger: function(n, t) {
            return this.each(function() {
                i.event.trigger(n, t, this)
            })
        },
        triggerHandler: function(n, t) {
            var r = this[0];
            if (r) return i.event.trigger(n, t, r, !0)
        }
    });
    e.focusin || i.each({
        focus: "focusin",
        blur: "focusout"
    }, function(n, t) {
        var u = function(n) {
            i.event.simulate(t, n.target, i.event.fix(n))
        };
        i.event.special[t] = {
            setup: function() {
                var i = this.ownerDocument || this,
                    f = r.access(i, t);
                f || i.addEventListener(n, u, !0);
                r.access(i, t, (f || 0) + 1)
            },
            teardown: function() {
                var i = this.ownerDocument || this,
                    f = r.access(i, t) - 1;
                f ? r.access(i, t, f) : (i.removeEventListener(n, u, !0), r.remove(i, t))
            }
        }
    });
    var pt = n.location,
        sf = Date.now(),
        nr = /\?/;
    i.parseXML = function(t) {
        var r;
        if (!t || "string" != typeof t) return null;
        try {
            r = (new n.DOMParser).parseFromString(t, "text/xml")
        } catch (n) {
            r = void 0
        }
        return r && !r.getElementsByTagName("parsererror").length || i.error("Invalid XML: " + t), r
    };
    var io = /\[\]$/,
        hf = /\r?\n/g,
        ro = /^(?:submit|button|image|reset|file)$/i,
        uo = /^(?:input|select|textarea|keygen)/i;
    i.param = function(n, t) {
        var r, f = [],
            e = function(n, t) {
                var i = u(t) ? t() : t;
                f[f.length] = encodeURIComponent(n) + "=" + encodeURIComponent(null == i ? "" : i)
            };
        if (Array.isArray(n) || n.jquery && !i.isPlainObject(n)) i.each(n, function() {
            e(this.name, this.value)
        });
        else
            for (r in n) tr(r, n[r], t, e);
        return f.join("&")
    };
    i.fn.extend({
        serialize: function() {
            return i.param(this.serializeArray())
        },
        serializeArray: function() {
            return this.map(function() {
                var n = i.prop(this, "elements");
                return n ? i.makeArray(n) : this
            }).filter(function() {
                var n = this.type;
                return this.name && !i(this).is(":disabled") && uo.test(this.nodeName) && !ro.test(n) && (this.checked || !iu.test(n))
            }).map(function(n, t) {
                var r = i(this).val();
                return null == r ? null : Array.isArray(r) ? i.map(r, function(n) {
                    return {
                        name: t.name,
                        value: n.replace(hf, "\r\n")
                    }
                }) : {
                    name: t.name,
                    value: r.replace(hf, "\r\n")
                }
            }).get()
        }
    });
    var fo = /%20/g,
        eo = /#.*$/,
        oo = /([?&])_=[^&]*/,
        so = /^(.*?):[ \t]*([^\r\n]*)$/gm,
        ho = /^(?:GET|HEAD)$/,
        co = /^\/\//,
        cf = {},
        ir = {},
        lf = "*/".concat("*"),
        rr = f.createElement("a");
    return rr.href = pt.href, i.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: pt.href,
            type: "GET",
            isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(pt.protocol),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": lf,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {
                xml: /\bxml\b/,
                html: /\bhtml/,
                json: /\bjson\b/
            },
            responseFields: {
                xml: "responseXML",
                text: "responseText",
                json: "responseJSON"
            },
            converters: {
                "* text": String,
                "text html": !0,
                "text json": JSON.parse,
                "text xml": i.parseXML
            },
            flatOptions: {
                url: !0,
                context: !0
            }
        },
        ajaxSetup: function(n, t) {
            return t ? ur(ur(n, i.ajaxSettings), t) : ur(i.ajaxSettings, n)
        },
        ajaxPrefilter: af(cf),
        ajaxTransport: af(ir),
        ajax: function(t, r) {
            function b(t, r, f, c) {
                var v, rt, b, p, g, l = r;
                s || (s = !0, d && n.clearTimeout(d), a = void 0, k = c || "", e.readyState = t > 0 ? 4 : 0, v = t >= 200 && t < 300 || 304 === t, f && (p = lo(u, e, f)), p = ao(u, p, e, v), v ? (u.ifModified && ((g = e.getResponseHeader("Last-Modified")) && (i.lastModified[o] = g), (g = e.getResponseHeader("etag")) && (i.etag[o] = g)), 204 === t || "HEAD" === u.type ? l = "nocontent" : 304 === t ? l = "notmodified" : (l = p.state, rt = p.data, v = !(b = p.error))) : (b = l, !t && l || (l = "error", t < 0 && (t = 0))), e.status = t, e.statusText = (r || l) + "", v ? tt.resolveWith(h, [rt, l, e]) : tt.rejectWith(h, [e, l, b]), e.statusCode(w), w = void 0, y && nt.trigger(v ? "ajaxSuccess" : "ajaxError", [e, u, v ? rt : b]), it.fireWith(h, [e, l]), y && (nt.trigger("ajaxComplete", [e, u]), --i.active || i.event.trigger("ajaxStop")))
            }
            "object" == typeof t && (r = t, t = void 0);
            r = r || {};
            var a, o, k, v, d, c, s, y, g, p, u = i.ajaxSetup({}, r),
                h = u.context || u,
                nt = u.context && (h.nodeType || h.jquery) ? i(h) : i.event,
                tt = i.Deferred(),
                it = i.Callbacks("once memory"),
                w = u.statusCode || {},
                rt = {},
                ut = {},
                ft = "canceled",
                e = {
                    readyState: 0,
                    getResponseHeader: function(n) {
                        var t;
                        if (s) {
                            if (!v)
                                for (v = {}; t = so.exec(k);) v[t[1].toLowerCase()] = t[2];
                            t = v[n.toLowerCase()]
                        }
                        return null == t ? null : t
                    },
                    getAllResponseHeaders: function() {
                        return s ? k : null
                    },
                    setRequestHeader: function(n, t) {
                        return null == s && (n = ut[n.toLowerCase()] = ut[n.toLowerCase()] || n, rt[n] = t), this
                    },
                    overrideMimeType: function(n) {
                        return null == s && (u.mimeType = n), this
                    },
                    statusCode: function(n) {
                        var t;
                        if (n)
                            if (s) e.always(n[e.status]);
                            else
                                for (t in n) w[t] = [w[t], n[t]];
                        return this
                    },
                    abort: function(n) {
                        var t = n || ft;
                        return a && a.abort(t), b(0, t), this
                    }
                };
            if (tt.promise(e), u.url = ((t || u.url || pt.href) + "").replace(co, pt.protocol + "//"), u.type = r.method || r.type || u.method || u.type, u.dataTypes = (u.dataType || "*").toLowerCase().match(l) || [""], null == u.crossDomain) {
                c = f.createElement("a");
                try {
                    c.href = u.url;
                    c.href = c.href;
                    u.crossDomain = rr.protocol + "//" + rr.host != c.protocol + "//" + c.host
                } catch (n) {
                    u.crossDomain = !0
                }
            }
            if (u.data && u.processData && "string" != typeof u.data && (u.data = i.param(u.data, u.traditional)), vf(cf, u, r, e), s) return e;
            (y = i.event && u.global) && 0 == i.active++ && i.event.trigger("ajaxStart");
            u.type = u.type.toUpperCase();
            u.hasContent = !ho.test(u.type);
            o = u.url.replace(eo, "");
            u.hasContent ? u.data && u.processData && 0 === (u.contentType || "").indexOf("application/x-www-form-urlencoded") && (u.data = u.data.replace(fo, "+")) : (p = u.url.slice(o.length), u.data && (u.processData || "string" == typeof u.data) && (o += (nr.test(o) ? "&" : "?") + u.data, delete u.data), !1 === u.cache && (o = o.replace(oo, "$1"), p = (nr.test(o) ? "&" : "?") + "_=" + sf++ + p), u.url = o + p);
            u.ifModified && (i.lastModified[o] && e.setRequestHeader("If-Modified-Since", i.lastModified[o]), i.etag[o] && e.setRequestHeader("If-None-Match", i.etag[o]));
            (u.data && u.hasContent && !1 !== u.contentType || r.contentType) && e.setRequestHeader("Content-Type", u.contentType);
            e.setRequestHeader("Accept", u.dataTypes[0] && u.accepts[u.dataTypes[0]] ? u.accepts[u.dataTypes[0]] + ("*" !== u.dataTypes[0] ? ", " + lf + "; q=0.01" : "") : u.accepts["*"]);
            for (g in u.headers) e.setRequestHeader(g, u.headers[g]);
            if (u.beforeSend && (!1 === u.beforeSend.call(h, e, u) || s)) return e.abort();
            if (ft = "abort", it.add(u.complete), e.done(u.success), e.fail(u.error), a = vf(ir, u, r, e)) {
                if (e.readyState = 1, y && nt.trigger("ajaxSend", [e, u]), s) return e;
                u.async && u.timeout > 0 && (d = n.setTimeout(function() {
                    e.abort("timeout")
                }, u.timeout));
                try {
                    s = !1;
                    a.send(rt, b)
                } catch (n) {
                    if (s) throw n;
                    b(-1, n)
                }
            } else b(-1, "No Transport");
            return e
        },
        getJSON: function(n, t, r) {
            return i.get(n, t, r, "json")
        },
        getScript: function(n, t) {
            return i.get(n, void 0, t, "script")
        }
    }), i.each(["get", "post"], function(n, t) {
        i[t] = function(n, r, f, e) {
            return u(r) && (e = e || f, f = r, r = void 0), i.ajax(i.extend({
                url: n,
                type: t,
                dataType: e,
                data: r,
                success: f
            }, i.isPlainObject(n) && n))
        }
    }), i._evalUrl = function(n) {
        return i.ajax({
            url: n,
            type: "GET",
            dataType: "script",
            cache: !0,
            async: !1,
            global: !1,
            throws: !0
        })
    }, i.fn.extend({
        wrapAll: function(n) {
            var t;
            return this[0] && (u(n) && (n = n.call(this[0])), t = i(n, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && t.insertBefore(this[0]), t.map(function() {
                for (var n = this; n.firstElementChild;) n = n.firstElementChild;
                return n
            }).append(this)), this
        },
        wrapInner: function(n) {
            return u(n) ? this.each(function(t) {
                i(this).wrapInner(n.call(this, t))
            }) : this.each(function() {
                var t = i(this),
                    r = t.contents();
                r.length ? r.wrapAll(n) : t.append(n)
            })
        },
        wrap: function(n) {
            var t = u(n);
            return this.each(function(r) {
                i(this).wrapAll(t ? n.call(this, r) : n)
            })
        },
        unwrap: function(n) {
            return this.parent(n).not("body").each(function() {
                i(this).replaceWith(this.childNodes)
            }), this
        }
    }), i.expr.pseudos.hidden = function(n) {
        return !i.expr.pseudos.visible(n)
    }, i.expr.pseudos.visible = function(n) {
        return !!(n.offsetWidth || n.offsetHeight || n.getClientRects().length)
    }, i.ajaxSettings.xhr = function() {
        try {
            return new n.XMLHttpRequest
        } catch (n) {}
    }, yf = {
        0: 200,
        1223: 204
    }, ct = i.ajaxSettings.xhr(), e.cors = !!ct && "withCredentials" in ct, e.ajax = ct = !!ct, i.ajaxTransport(function(t) {
        var i, r;
        if (e.cors || ct && !t.crossDomain) return {
            send: function(u, f) {
                var o, e = t.xhr();
                if (e.open(t.type, t.url, t.async, t.username, t.password), t.xhrFields)
                    for (o in t.xhrFields) e[o] = t.xhrFields[o];
                t.mimeType && e.overrideMimeType && e.overrideMimeType(t.mimeType);
                t.crossDomain || u["X-Requested-With"] || (u["X-Requested-With"] = "XMLHttpRequest");
                for (o in u) e.setRequestHeader(o, u[o]);
                i = function(n) {
                    return function() {
                        i && (i = r = e.onload = e.onerror = e.onabort = e.ontimeout = e.onreadystatechange = null, "abort" === n ? e.abort() : "error" === n ? "number" != typeof e.status ? f(0, "error") : f(e.status, e.statusText) : f(yf[e.status] || e.status, e.statusText, "text" !== (e.responseType || "text") || "string" != typeof e.responseText ? {
                            binary: e.response
                        } : {
                            text: e.responseText
                        }, e.getAllResponseHeaders()))
                    }
                };
                e.onload = i();
                r = e.onerror = e.ontimeout = i("error");
                void 0 !== e.onabort ? e.onabort = r : e.onreadystatechange = function() {
                    4 === e.readyState && n.setTimeout(function() {
                        i && r()
                    })
                };
                i = i("abort");
                try {
                    
                } catch (n) {
                    if (i) throw n;
                }
            },
            abort: function() {
                i && i()
            }
        }
    }), i.ajaxPrefilter(function(n) {
        n.crossDomain && (n.contents.script = !1)
    }), i.ajaxSetup({
        accepts: {
            script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
        },
        contents: {
            script: /\b(?:java|ecma)script\b/
        },
        converters: {
            "text script": function(n) {
                return i.globalEval(n), n
            }
        }
    }), i.ajaxPrefilter("script", function(n) {
        void 0 === n.cache && (n.cache = !1);
        n.crossDomain && (n.type = "GET")
    }), i.ajaxTransport("script", function(n) {
        if (n.crossDomain) {
            var r, t;
            return {
                send: function(u, e) {
                    r = i("<script>").prop({
                        charset: n.scriptCharset,
                        src: n.url
                    }).on("load error", t = function(n) {
                        r.remove();
                        t = null;
                        n && e("error" === n.type ? 404 : 200, n.type)
                    });
                    f.head.appendChild(r[0])
                },
                abort: function() {
                    t && t()
                }
            }
        }
    }), fr = [], oi = /(=)\?(?=&|$)|\?\?/, i.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function() {
            var n = fr.pop() || i.expando + "_" + sf++;
            return this[n] = !0, n
        }
    }), i.ajaxPrefilter("json jsonp", function(t, r, f) {
        var e, o, s, h = !1 !== t.jsonp && (oi.test(t.url) ? "url" : "string" == typeof t.data && 0 === (t.contentType || "").indexOf("application/x-www-form-urlencoded") && oi.test(t.data) && "data");
        if (h || "jsonp" === t.dataTypes[0]) return e = t.jsonpCallback = u(t.jsonpCallback) ? t.jsonpCallback() : t.jsonpCallback, h ? t[h] = t[h].replace(oi, "$1" + e) : !1 !== t.jsonp && (t.url += (nr.test(t.url) ? "&" : "?") + t.jsonp + "=" + e), t.converters["script json"] = function() {
            return s || i.error(e + " was not called"), s[0]
        }, t.dataTypes[0] = "json", o = n[e], n[e] = function() {
            s = arguments
        }, f.always(function() {
            void 0 === o ? i(n).removeProp(e) : n[e] = o;
            t[e] && (t.jsonpCallback = r.jsonpCallback, fr.push(e));
            s && u(o) && o(s[0]);
            s = o = void 0
        }), "script"
    }), e.createHTMLDocument = function() {
        var n = f.implementation.createHTMLDocument("").body;
        return n.innerHTML = "<form><\/form><form><\/form>", 2 === n.childNodes.length
    }(), i.parseHTML = function(n, t, r) {
        if ("string" != typeof n) return [];
        "boolean" == typeof t && (r = t, t = !1);
        var s, u, o;
        return t || (e.createHTMLDocument ? ((s = (t = f.implementation.createHTMLDocument("")).createElement("base")).href = f.location.href, t.head.appendChild(s)) : t = f), u = ci.exec(n), o = !r && [], u ? [t.createElement(u[1])] : (u = eu([n], t, o), o && o.length && i(o).remove(), i.merge([], u.childNodes))
    }, i.fn.load = function(n, t, r) {
        var f, s, h, e = this,
            o = n.indexOf(" ");
        return o > -1 && (f = g(n.slice(o)), n = n.slice(0, o)), u(t) ? (r = t, t = void 0) : t && "object" == typeof t && (s = "POST"), e.length > 0 && i.ajax({
            url: n,
            type: s || "GET",
            dataType: "html",
            data: t
        }).done(function(n) {
            h = arguments;
            e.html(f ? i("<div>").append(i.parseHTML(n)).find(f) : n)
        }).always(r && function(n, t) {
            e.each(function() {
                r.apply(this, h || [n.responseText, t, n])
            })
        }), this
    }, i.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(n, t) {
        i.fn[t] = function(n) {
            return this.on(t, n)
        }
    }), i.expr.pseudos.animated = function(n) {
        return i.grep(i.timers, function(t) {
            return n === t.elem
        }).length
    }, i.offset = {
        setOffset: function(n, t, r) {
            var v, o, s, h, f, c, y, l = i.css(n, "position"),
                a = i(n),
                e = {};
            "static" === l && (n.style.position = "relative");
            f = a.offset();
            s = i.css(n, "top");
            c = i.css(n, "left");
            (y = ("absolute" === l || "fixed" === l) && (s + c).indexOf("auto") > -1) ? (h = (v = a.position()).top, o = v.left) : (h = parseFloat(s) || 0, o = parseFloat(c) || 0);
            u(t) && (t = t.call(n, r, i.extend({}, f)));
            null != t.top && (e.top = t.top - f.top + h);
            null != t.left && (e.left = t.left - f.left + o);
            "using" in t ? t.using.call(n, e) : a.css(e)
        }
    }, i.fn.extend({
        offset: function(n) {
            if (arguments.length) return void 0 === n ? this : this.each(function(t) {
                i.offset.setOffset(this, n, t)
            });
            var r, u, t = this[0];
            if (t) return t.getClientRects().length ? (r = t.getBoundingClientRect(), u = t.ownerDocument.defaultView, {
                top: r.top + u.pageYOffset,
                left: r.left + u.pageXOffset
            }) : {
                top: 0,
                left: 0
            }
        },
        position: function() {
            if (this[0]) {
                var n, r, u, t = this[0],
                    f = {
                        top: 0,
                        left: 0
                    };
                if ("fixed" === i.css(t, "position")) r = t.getBoundingClientRect();
                else {
                    for (r = this.offset(), u = t.ownerDocument, n = t.offsetParent || u.documentElement; n && (n === u.body || n === u.documentElement) && "static" === i.css(n, "position");) n = n.parentNode;
                    n && n !== t && 1 === n.nodeType && ((f = i(n).offset()).top += i.css(n, "borderTopWidth", !0), f.left += i.css(n, "borderLeftWidth", !0))
                }
                return {
                    top: r.top - f.top - i.css(t, "marginTop", !0),
                    left: r.left - f.left - i.css(t, "marginLeft", !0)
                }
            }
        },
        offsetParent: function() {
            return this.map(function() {
                for (var n = this.offsetParent; n && "static" === i.css(n, "position");) n = n.offsetParent;
                return n || ii
            })
        }
    }), i.each({
        scrollLeft: "pageXOffset",
        scrollTop: "pageYOffset"
    }, function(n, t) {
        var r = "pageYOffset" === t;
        i.fn[n] = function(i) {
            return p(this, function(n, i, u) {
                var f;
                if (tt(n) ? f = n : 9 === n.nodeType && (f = n.defaultView), void 0 === u) return f ? f[t] : n[i];
                f ? f.scrollTo(r ? f.pageXOffset : u, r ? u : f.pageYOffset) : n[i] = u
            }, n, i, arguments.length)
        }
    }), i.each(["top", "left"], function(n, t) {
        i.cssHooks[t] = au(e.pixelPosition, function(n, r) {
            if (r) return r = yt(n, t), pi.test(r) ? i(n).position()[t] + "px" : r
        })
    }), i.each({
        Height: "height",
        Width: "width"
    }, function(n, t) {
        i.each({
            padding: "inner" + n,
            content: t,
            "": "outer" + n
        }, function(r, u) {
            i.fn[u] = function(f, e) {
                var o = arguments.length && (r || "boolean" != typeof f),
                    s = r || (!0 === f || !0 === e ? "margin" : "border");
                return p(this, function(t, r, f) {
                    var e;
                    return tt(t) ? 0 === u.indexOf("outer") ? t["inner" + n] : t.document.documentElement["client" + n] : 9 === t.nodeType ? (e = t.documentElement, Math.max(t.body["scroll" + n], e["scroll" + n], t.body["offset" + n], e["offset" + n], e["client" + n])) : void 0 === f ? i.css(t, r, s) : i.style(t, r, f, s)
                }, t, o ? f : void 0, o)
            }
        })
    }), i.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), function(n, t) {
        i.fn[t] = function(n, i) {
            return arguments.length > 0 ? this.on(t, null, n, i) : this.trigger(t)
        }
    }), i.fn.extend({
        hover: function(n, t) {
            return this.mouseenter(n).mouseleave(t || n)
        }
    }), i.fn.extend({
        bind: function(n, t, i) {
            return this.on(n, null, t, i)
        },
        unbind: function(n, t) {
            return this.off(n, null, t)
        },
        delegate: function(n, t, i, r) {
            return this.on(t, n, i, r)
        },
        undelegate: function(n, t, i) {
            return 1 === arguments.length ? this.off(n, "**") : this.off(t, n || "**", i)
        }
    }), i.proxy = function(n, t) {
        var f, e, r;
        if ("string" == typeof t && (f = n[t], t = n, n = f), u(n)) return e = d.call(arguments, 2), r = function() {
            return n.apply(t || this, e.concat(d.call(arguments)))
        }, r.guid = n.guid = n.guid || i.guid++, r
    }, i.holdReady = function(n) {
        n ? i.readyWait++ : i.ready(!0)
    }, i.isArray = Array.isArray, i.parseJSON = JSON.parse, i.nodeName = v, i.isFunction = u, i.isWindow = tt, i.camelCase = y, i.type = it, i.now = Date.now, i.isNumeric = function(n) {
        var t = i.type(n);
        return ("number" === t || "string" === t) && !isNaN(n - parseFloat(n))
    }, "function" == typeof define && define.amd && define("jquery", [], function() {
        return i
    }), pf = n.jQuery, wf = n.$, i.noConflict = function(t) {
        return n.$ === i && (n.$ = wf), t && n.jQuery === i && (n.jQuery = pf), i
    }, t || (n.jQuery = n.$ = i), i
});
! function(n) {
    "function" == typeof define && define.amd ? define(["jquery"], n) : "object" == typeof exports ? module.exports = n : n(jQuery)
}(function(n) {
    function u(r) {
        var u = r || window.event,
            w = c.call(arguments, 1),
            l = 0,
            s = 0,
            e = 0,
            a = 0,
            b = 0,
            k = 0,
            v, y, p;
        if (r = n.event.fix(u), r.type = "mousewheel", "detail" in u && (e = -1 * u.detail), "wheelDelta" in u && (e = u.wheelDelta), "wheelDeltaY" in u && (e = u.wheelDeltaY), "wheelDeltaX" in u && (s = -1 * u.wheelDeltaX), "axis" in u && u.axis === u.HORIZONTAL_AXIS && (s = -1 * e, e = 0), l = 0 === e ? s : e, "deltaY" in u && (e = -1 * u.deltaY, l = e), "deltaX" in u && (s = u.deltaX, 0 === e && (l = -1 * s)), 0 !== e || 0 !== s) return 1 === u.deltaMode ? (v = n.data(this, "mousewheel-line-height"), l *= v, e *= v, s *= v) : 2 === u.deltaMode && (y = n.data(this, "mousewheel-page-height"), l *= y, e *= y, s *= y), (a = Math.max(Math.abs(e), Math.abs(s)), (!t || t > a) && (t = a, o(u, a) && (t /= 40)), o(u, a) && (l /= 40, s /= 40, e /= 40), l = Math[l >= 1 ? "floor" : "ceil"](l / t), s = Math[s >= 1 ? "floor" : "ceil"](s / t), e = Math[e >= 1 ? "floor" : "ceil"](e / t), i.settings.normalizeOffset && this.getBoundingClientRect) && (p = this.getBoundingClientRect(), b = r.clientX - p.left, k = r.clientY - p.top), r.deltaX = s, r.deltaY = e, r.deltaFactor = t, r.offsetX = b, r.offsetY = k, r.deltaMode = 0, w.unshift(r, l, s, e), f && clearTimeout(f), f = setTimeout(h, 200), (n.event.dispatch || n.event.handle).apply(this, w)
    }

    function h() {
        t = null
    }

    function o(n, t) {
        return i.settings.adjustOldDeltas && "mousewheel" === n.type && t % 120 == 0
    }
    var f, t, s = ["wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll"],
        r = "onwheel" in document || document.documentMode >= 9 ? ["wheel"] : ["mousewheel", "DomMouseScroll", "MozMousePixelScroll"],
        c = Array.prototype.slice,
        e, i;
    if (n.event.fixHooks)
        for (e = s.length; e;) n.event.fixHooks[s[--e]] = n.event.mouseHooks;
    i = n.event.special.mousewheel = {
        version: "3.1.12",
        setup: function() {
            if (this.addEventListener)
                for (var t = r.length; t;) this.addEventListener(r[--t], u, !1);
            else this.onmousewheel = u;
            n.data(this, "mousewheel-line-height", i.getLineHeight(this));
            n.data(this, "mousewheel-page-height", i.getPageHeight(this))
        },
        teardown: function() {
            if (this.removeEventListener)
                for (var t = r.length; t;) this.removeEventListener(r[--t], u, !1);
            else this.onmousewheel = null;
            n.removeData(this, "mousewheel-line-height");
            n.removeData(this, "mousewheel-page-height")
        },
        getLineHeight: function(t) {
            var r = n(t),
                i = r["offsetParent" in n.fn ? "offsetParent" : "parent"]();
            return i.length || (i = n("body")), parseInt(i.css("fontSize"), 10) || parseInt(r.css("fontSize"), 10) || 16
        },
        getPageHeight: function(t) {
            return n(t).height()
        },
        settings: {
            adjustOldDeltas: !0,
            normalizeOffset: !0
        }
    };
    n.fn.extend({
        mousewheel: function(n) {
            return n ? this.bind("mousewheel", n) : this.trigger("mousewheel")
        },
        unmousewheel: function(n) {
            return this.unbind("mousewheel", n)
        }
    })
}),
function(n) {
    n.easing.jswing = n.easing.swing;
    n.extend(n.easing, {
        def: "easeOutQuad",
        swing: function(t, i, r, u, f) {
            return n.easing[n.easing.def](t, i, r, u, f)
        },
        easeInQuad: function(n, t, i, r, u) {
            return r * (t /= u) * t + i
        },
        easeOutQuad: function(n, t, i, r, u) {
            return -r * (t /= u) * (t - 2) + i
        },
        easeInOutQuad: function(n, t, i, r, u) {
            return 1 > (t /= u / 2) ? r / 2 * t * t + i : -r / 2 * (--t * (t - 2) - 1) + i
        },
        easeInCubic: function(n, t, i, r, u) {
            return r * (t /= u) * t * t + i
        },
        easeOutCubic: function(n, t, i, r, u) {
            return r * ((t = t / u - 1) * t * t + 1) + i
        },
        easeInOutCubic: function(n, t, i, r, u) {
            return 1 > (t /= u / 2) ? r / 2 * t * t * t + i : r / 2 * ((t -= 2) * t * t + 2) + i
        },
        easeInQuart: function(n, t, i, r, u) {
            return r * (t /= u) * t * t * t + i
        },
        easeOutQuart: function(n, t, i, r, u) {
            return -r * ((t = t / u - 1) * t * t * t - 1) + i
        },
        easeInOutQuart: function(n, t, i, r, u) {
            return 1 > (t /= u / 2) ? r / 2 * t * t * t * t + i : -r / 2 * ((t -= 2) * t * t * t - 2) + i
        },
        easeInQuint: function(n, t, i, r, u) {
            return r * (t /= u) * t * t * t * t + i
        },
        easeOutQuint: function(n, t, i, r, u) {
            return r * ((t = t / u - 1) * t * t * t * t + 1) + i
        },
        easeInOutQuint: function(n, t, i, r, u) {
            return 1 > (t /= u / 2) ? r / 2 * t * t * t * t * t + i : r / 2 * ((t -= 2) * t * t * t * t + 2) + i
        },
        easeInSine: function(n, t, i, r, u) {
            return -r * Math.cos(t / u * (Math.PI / 2)) + r + i
        },
        easeOutSine: function(n, t, i, r, u) {
            return r * Math.sin(t / u * (Math.PI / 2)) + i
        },
        easeInOutSine: function(n, t, i, r, u) {
            return -r / 2 * (Math.cos(Math.PI * t / u) - 1) + i
        },
        easeInExpo: function(n, t, i, r, u) {
            return 0 == t ? i : r * Math.pow(2, 10 * (t / u - 1)) + i
        },
        easeOutExpo: function(n, t, i, r, u) {
            return t == u ? i + r : r * (-Math.pow(2, -10 * t / u) + 1) + i
        },
        easeInOutExpo: function(n, t, i, r, u) {
            return 0 == t ? i : t == u ? i + r : 1 > (t /= u / 2) ? r / 2 * Math.pow(2, 10 * (t - 1)) + i : r / 2 * (-Math.pow(2, -10 * --t) + 2) + i
        },
        easeInCirc: function(n, t, i, r, u) {
            return -r * (Math.sqrt(1 - (t /= u) * t) - 1) + i
        },
        easeOutCirc: function(n, t, i, r, u) {
            return r * Math.sqrt(1 - (t = t / u - 1) * t) + i
        },
        easeInOutCirc: function(n, t, i, r, u) {
            return 1 > (t /= u / 2) ? -r / 2 * (Math.sqrt(1 - t * t) - 1) + i : r / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + i
        },
        easeInElastic: function(n, t, i, r, u) {
            n = 1.70158;
            var f = 0,
                e = r;
            return 0 == t ? i : 1 == (t /= u) ? i + r : (f || (f = .3 * u), e < Math.abs(r) ? (e = r, n = f / 4) : n = f / (2 * Math.PI) * Math.asin(r / e), -(e * Math.pow(2, 10 * --t) * Math.sin(2 * (t * u - n) * Math.PI / f)) + i)
        },
        easeOutElastic: function(n, t, i, r, u) {
            n = 1.70158;
            var f = 0,
                e = r;
            return 0 == t ? i : 1 == (t /= u) ? i + r : (f || (f = .3 * u), e < Math.abs(r) ? (e = r, n = f / 4) : n = f / (2 * Math.PI) * Math.asin(r / e), e * Math.pow(2, -10 * t) * Math.sin(2 * (t * u - n) * Math.PI / f) + r + i)
        },
        easeInOutElastic: function(n, t, i, r, u) {
            n = 1.70158;
            var f = 0,
                e = r;
            return 0 == t ? i : 2 == (t /= u / 2) ? i + r : (f || (f = .3 * u * 1.5), e < Math.abs(r) ? (e = r, n = f / 4) : n = f / (2 * Math.PI) * Math.asin(r / e), 1 > t ? -.5 * e * Math.pow(2, 10 * --t) * Math.sin(2 * (t * u - n) * Math.PI / f) + i : e * Math.pow(2, -10 * --t) * Math.sin(2 * (t * u - n) * Math.PI / f) * .5 + r + i)
        },
        easeInBack: function(n, t, i, r, u, f) {
            return void 0 == f && (f = 1.70158), r * (t /= u) * t * ((f + 1) * t - f) + i
        },
        easeOutBack: function(n, t, i, r, u, f) {
            return void 0 == f && (f = 1.70158), r * ((t = t / u - 1) * t * ((f + 1) * t + f) + 1) + i
        },
        easeInOutBack: function(n, t, i, r, u, f) {
            return void 0 == f && (f = 1.70158), 1 > (t /= u / 2) ? r / 2 * t * t * (((f *= 1.525) + 1) * t - f) + i : r / 2 * ((t -= 2) * t * (((f *= 1.525) + 1) * t + f) + 2) + i
        },
        easeInBounce: function(t, i, r, u, f) {
            return u - n.easing.easeOutBounce(t, f - i, 0, u, f) + r
        },
        easeOutBounce: function(n, t, i, r, u) {
            return (t /= u) < 1 / 2.75 ? 7.5625 * r * t * t + i : t < 2 / 2.75 ? r * (7.5625 * (t -= 1.5 / 2.75) * t + .75) + i : t < 2.5 / 2.75 ? r * (7.5625 * (t -= 2.25 / 2.75) * t + .9375) + i : r * (7.5625 * (t -= 2.625 / 2.75) * t + .984375) + i
        },
        easeInOutBounce: function(t, i, r, u, f) {
            return i < f / 2 ? .5 * n.easing.easeInBounce(t, 2 * i, 0, u, f) + r : .5 * n.easing.easeOutBounce(t, 2 * i - f, 0, u, f) + .5 * u + r
        }
    })
}(jQuery),
function(n, t) {
    var i, r, u, f;
    n.tapHandling = !1;
    n.tappy = !0;
    i = function(i) {
        return i.each(function() {
            function c(n) {
                t(n.target).trigger("tap", [n, t(n.target).attr("href")])
            }

            function o(n) {
                var i = n.originalEvent || n,
                    t = i.touches || i.targetTouches;
                return t ? [t[0].pageX, t[0].pageY] : null
            }

            function l(n) {
                if (n.touches && n.touches.length > 1 || n.targetTouches && n.targetTouches.length > 1) return !1;
                var t = o(n);
                f = t[0];
                u = t[1]
            }

            function a(n) {
                if (!i) {
                    var t = o(n);
                    t && (Math.abs(u - t[1]) > e || Math.abs(f - t[0]) > e) && (i = !0)
                }
            }

            function s(t) {
                if (clearTimeout(r), r = setTimeout(function() {
                        n.tapHandling = !1;
                        i = !1
                    }, 1e3), (!t.which || !(t.which > 1)) && !t.shiftKey && !t.altKey && !t.metaKey && !t.ctrlKey) {
                    if (t.preventDefault(), i || n.tapHandling && n.tapHandling !== t.type) {
                        i = !1;
                        return
                    }
                    n.tapHandling = t.type;
                    c(t)
                }
            }
            var h = t(this),
                r, u, f, i, e = 10;
            h.bind("touchstart.tappy MSPointerDown.tappy", l).bind("touchmove.tappy MSPointerMove.tappy", a).bind("touchend.tappy MSPointerUp.tappy", s).bind("click.tappy", s)
        })
    };
    r = function(n) {
        return n.unbind(".tappy")
    };
    t.event && t.event.special ? t.event.special.tap = {
        add: function() {
            i(t(this))
        },
        remove: function() {
            r(t(this))
        }
    } : (u = t.fn.bind, f = t.fn.unbind, t.fn.bind = function(n) {
        return /(^| )tap( |$)/.test(n) && i(this), u.apply(this, arguments)
    }, t.fn.unbind = function(n) {
        return /(^| )tap( |$)/.test(n) && r(this), f.apply(this, arguments)
    })
}(this, jQuery);
! function(n, t, i, r) {
    function s(n, t) {
        return n[t] === r ? u[t] : n[t]
    }

    function b() {
        var n = t.pageYOffset;
        return n === r ? e.scrollTop : n
    }

    function h(n, t) {
        var i = u["on" + n];
        i && (rt(i) ? i.call(t[0]) : (i.addClass && t.addClass(i.addClass), i.removeClass && t.removeClass(i.removeClass)));
        t.trigger("lazy" + n, [t]);
        f()
    }

    function k(t) {
        h(t.type, n(this).off(tt, k))
    }

    function d(i) {
        var g, ut;
        if (o.length) {
            i = i || u.forceLoad;
            y = 1 / 0;
            for (var ft = b(), st = t.innerHeight || e.clientHeight, ht = t.innerWidth || e.clientWidth, f = 0, l = o.length; l > f; f++) {
                var v, s = o[f],
                    r = s[0],
                    p = s[c],
                    nt = !1,
                    it = i || w(r, a) < 0;
                if (n.contains(e, r)) {
                    if (i || !p.visibleOnly || r.offsetWidth || r.offsetHeight) {
                        if (!it) {
                            var d = r.getBoundingClientRect(),
                                et = p.edgeX,
                                ot = p.edgeY;
                            v = d.top + ft - ot - st;
                            it = ft >= v && d.bottom > -ot && d.left <= ht + et && d.right > -et
                        }
                        it ? (s.on(tt, k), h("show", s), g = p.srcAttr, ut = rt(g) ? g(s) : r.getAttribute(g), ut && (r.src = ut), nt = !0) : y > v && (y = v)
                    }
                } else nt = !0;
                nt && (w(r, a, 0), o.splice(f--, 1), l--)
            }
            l || h("complete", n(e))
        }
    }

    function g() {
        l > 1 ? (l = 1, d(), setTimeout(g, u.throttle)) : l = 0
    }

    function f(n) {
        o.length && (n && "scroll" === n.type && n.currentTarget === t && y >= b() || (l || setTimeout(g, 0), l = 2))
    }

    function nt() {
        v.lazyLoadXT()
    }

    function ft() {
        d(!0)
    }
    var c = "lazyLoadXT",
        a = "lazied",
        tt = "load error",
        p = "lazy-hidden",
        e = i.documentElement || i.body,
        et = t.onscroll === r || !!t.operamini || !e.getBoundingClientRect,
        u = {
            autoInit: !0,
            selector: "img[data-src]",
            blankImage: "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7",
            throttle: 99,
            forceLoad: et,
            loadEvent: "pageshow",
            updateEvent: "load orientationchange resize scroll touchmove focus",
            forceEvent: "lazyloadall",
            oninit: {
                removeClass: "lazy"
            },
            onshow: {
                addClass: p
            },
            onload: {
                removeClass: p,
                addClass: "lazy-loaded"
            },
            onerror: {
                removeClass: p
            },
            checkDuplicates: !0
        },
        it = {
            srcAttr: "data-src",
            edgeX: 0,
            edgeY: 0,
            visibleOnly: !0
        },
        v = n(t),
        rt = n.isFunction,
        ut = n.extend,
        w = n.data || function(t, i) {
            return n(t).data(i)
        },
        o = [],
        y = 0,
        l = 0;
    n[c] = ut(u, it, n[c]);
    n.fn[c] = function(i) {
        i = i || {};
        var r, e = s(i, "blankImage"),
            v = s(i, "checkDuplicates"),
            y = s(i, "scrollContainer"),
            p = s(i, "show"),
            l = {};
        n(y).on("scroll", f);
        for (r in it) l[r] = s(i, r);
        return this.each(function(r, s) {
            if (s === t) n(u.selector).lazyLoadXT(i);
            else {
                var b = v && w(s, a),
                    y = n(s).data(a, p ? -1 : 1);
                if (b) return void f();
                e && "IMG" === s.tagName && !s.src && (s.src = e);
                y[c] = ut({}, l);
                h("init", y);
                o.push(y);
                f()
            }
        })
    };
    n(i).ready(function() {
        h("start", v);
        v.on(u.updateEvent, f).on(u.forceEvent, ft);
        n(i).on(u.updateEvent, f);
        u.autoInit && (v.on(u.loadEvent, nt), nt())
    })
}(window.jQuery || window.Zepto || window.$, window, document),
function(n) {
    typeof define == "function" && define.amd ? define(["jquery"], n) : n(jQuery)
}(function(n) {
    n.fn.addBack = n.fn.addBack || n.fn.andSelf;
    n.fn.extend({
        actual: function(t, i) {
            var s, u, h, c;
            if (!this[t]) throw '$.actual => The jQuery method "' + t + '" you called does not exist';
            var f = n.extend({
                    absolute: !1,
                    clone: !1,
                    includeMargin: !1,
                    display: "block"
                }, i),
                r = this.eq(0),
                e, o;
            return f.clone === !0 ? (e = function() {
                r = r.clone().attr("style", "position: absolute !important; top: -1000 !important; ").appendTo("body")
            }, o = function() {
                r.remove()
            }) : (s = [], u = "", e = function() {
                h = r.parents().addBack().filter(":hidden");
                u += "visibility: hidden !important; display: " + f.display + " !important; ";
                f.absolute === !0 && (u += "position: absolute !important; ");
                h.each(function() {
                    var i = n(this),
                        t = i.attr("style");
                    s.push(t);
                    i.attr("style", t ? t + ";" + u : u)
                })
            }, o = function() {
                h.each(function(t) {
                    var i = n(this),
                        r = s[t];
                    r === undefined ? i.removeAttr("style") : i.attr("style", r)
                })
            }), e(), c = /(outer)/.test(t) ? r[t](f.includeMargin) : r[t](), o(), c
        }
    })
});
! function(n, t, i, r) {
    function u(t, i) {
        this.settings = null;
        this.options = n.extend({}, u.Defaults, i);
        this.$element = n(t);
        this._handlers = {};
        this._plugins = {};
        this._supress = {};
        this._current = null;
        this._speed = null;
        this._coordinates = [];
        this._breakpoint = null;
        this._width = null;
        this._items = [];
        this._clones = [];
        this._mergers = [];
        this._widths = [];
        this._invalidated = {};
        this._pipe = [];
        this._drag = {
            time: null,
            target: null,
            pointer: null,
            stage: {
                start: null,
                current: null
            },
            direction: null
        };
        this._states = {
            current: {},
            tags: {
                initializing: ["busy"],
                animating: ["busy"],
                dragging: ["interacting"]
            }
        };
        n.each(["onResize", "onThrottledResize"], n.proxy(function(t, i) {
            this._handlers[i] = n.proxy(this[i], this)
        }, this));
        n.each(u.Plugins, n.proxy(function(n, t) {
            this._plugins[n.charAt(0).toLowerCase() + n.slice(1)] = new t(this)
        }, this));
        n.each(u.Workers, n.proxy(function(t, i) {
            this._pipe.push({
                filter: i.filter,
                run: n.proxy(i.run, this)
            })
        }, this));
        this.setup();
        this.initialize()
    }
    u.Defaults = {
        items: 3,
        loop: !1,
        center: !1,
        rewind: !1,
        checkVisibility: !0,
        mouseDrag: !0,
        touchDrag: !0,
        pullDrag: !0,
        freeDrag: !1,
        margin: 0,
        stagePadding: 0,
        merge: !1,
        mergeFit: !0,
        autoWidth: !1,
        startPosition: 0,
        rtl: !1,
        smartSpeed: 250,
        fluidSpeed: !1,
        dragEndSpeed: !1,
        responsive: {},
        responsiveRefreshRate: 200,
        responsiveBaseElement: t,
        fallbackEasing: "swing",
        slideTransition: "",
        info: !1,
        nestedItemSelector: !1,
        itemElement: "div",
        stageElement: "div",
        refreshClass: "owl-refresh",
        loadedClass: "owl-loaded",
        loadingClass: "owl-loading",
        rtlClass: "owl-rtl",
        responsiveClass: "owl-responsive",
        dragClass: "owl-drag",
        itemClass: "owl-item",
        stageClass: "owl-stage",
        stageOuterClass: "owl-stage-outer",
        grabClass: "owl-grab"
    };
    u.Width = {
        Default: "default",
        Inner: "inner",
        Outer: "outer"
    };
    u.Type = {
        Event: "event",
        State: "state"
    };
    u.Plugins = {};
    u.Workers = [{
        filter: ["width", "settings"],
        run: function() {
            this._width = this.$element.width()
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(n) {
            n.current = this._items && this._items[this.relative(this._current)]
        }
    }, {
        filter: ["items", "settings"],
        run: function() {
            this.$stage.children(".cloned").remove()
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(n) {
            var t = this.settings.margin || "",
                u = !this.settings.autoWidth,
                i = this.settings.rtl,
                r = {
                    width: "auto",
                    "margin-left": i ? t : "",
                    "margin-right": i ? "" : t
                };
            u || this.$stage.children().css(r);
            n.css = r
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(n) {
            var r = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,
                t = null,
                i = this._items.length,
                f = !this.settings.autoWidth,
                u = [];
            for (n.items = {
                    merge: !1,
                    width: r
                }; i--;) t = this._mergers[i], t = this.settings.mergeFit && Math.min(t, this.settings.items) || t, n.items.merge = t > 1 || n.items.merge, u[i] = f ? r * t : this._items[i].width();
            this._widths = u
        }
    }, {
        filter: ["items", "settings"],
        run: function() {
            var t = [],
                i = this._items,
                r = this.settings,
                e = Math.max(2 * r.items, 4),
                s = 2 * Math.ceil(i.length / 2),
                u = r.loop && i.length ? r.rewind ? e : Math.max(e, s) : 0,
                o = "",
                f = "";
            for (u /= 2; u > 0;) t.push(this.normalize(t.length / 2, !0)), o += i[t[t.length - 1]][0].outerHTML, t.push(this.normalize(i.length - 1 - (t.length - 1) / 2, !0)), f = i[t[t.length - 1]][0].outerHTML + f, u -= 1;
            this._clones = t;
            n(o).addClass("cloned").appendTo(this.$stage);
            n(f).addClass("cloned").prependTo(this.$stage)
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function() {
            for (var u = this.settings.rtl ? 1 : -1, f = this._clones.length + this._items.length, n = -1, i = 0, r = 0, t = []; ++n < f;) i = t[n - 1] || 0, r = this._widths[this.relative(n)] + this.settings.margin, t.push(i + r * u);
            this._coordinates = t
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function() {
            var n = this.settings.stagePadding,
                t = this._coordinates,
                i = {
                    width: Math.ceil(Math.abs(t[t.length - 1])) + 2 * n,
                    "padding-left": n || "",
                    "padding-right": n || ""
                };
            this.$stage.css(i)
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(n) {
            var t = this._coordinates.length,
                i = !this.settings.autoWidth,
                r = this.$stage.children();
            if (i && n.items.merge)
                for (; t--;) n.css.width = this._widths[this.relative(t)], r.eq(t).css(n.css);
            else i && (n.css.width = n.items.width, r.css(n.css))
        }
    }, {
        filter: ["items"],
        run: function() {
            this._coordinates.length < 1 && this.$stage.removeAttr("style")
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(n) {
            n.current = n.current ? this.$stage.children().index(n.current) : 0;
            n.current = Math.max(this.minimum(), Math.min(this.maximum(), n.current));
            this.reset(n.current)
        }
    }, {
        filter: ["position"],
        run: function() {
            this.animate(this.coordinates(this._current))
        }
    }, {
        filter: ["width", "position", "items", "settings"],
        run: function() {
            for (var t, i, f = this.settings.rtl ? 1 : -1, e = 2 * this.settings.stagePadding, r = this.coordinates(this.current()) + e, o = r + this.width() * f, s = [], n = 0, u = this._coordinates.length; n < u; n++) t = this._coordinates[n - 1] || 0, i = Math.abs(this._coordinates[n]) + e * f, (this.op(t, "<=", r) && this.op(t, ">", o) || this.op(i, "<", r) && this.op(i, ">", o)) && s.push(n);
            this.$stage.children(".active").removeClass("active");
            this.$stage.children(":eq(" + s.join("), :eq(") + ")").addClass("active");
            this.$stage.children(".center").removeClass("center");
            this.settings.center && this.$stage.children().eq(this.current()).addClass("center")
        }
    }];
    u.prototype.initializeStage = function() {
        this.$stage = this.$element.find("." + this.settings.stageClass);
        this.$stage.length || (this.$element.addClass(this.options.loadingClass), this.$stage = n("<" + this.settings.stageElement + ">", {
            "class": this.settings.stageClass
        }).wrap(n("<div/>", {
            "class": this.settings.stageOuterClass
        })), this.$element.append(this.$stage.parent()))
    };
    u.prototype.initializeItems = function() {
        var t = this.$element.find(".owl-item");
        if (t.length) return this._items = t.get().map(function(t) {
            return n(t)
        }), this._mergers = this._items.map(function() {
            return 1
        }), void this.refresh();
        this.replace(this.$element.children().not(this.$stage.parent()));
        this.isVisible() ? this.refresh() : this.invalidate("width");
        this.$element.removeClass(this.options.loadingClass).addClass(this.options.loadedClass)
    };
    u.prototype.initialize = function() {
        if (this.enter("initializing"), this.trigger("initialize"), this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl), this.settings.autoWidth && !this.is("pre-loading")) {
            var n, t, i;
            n = this.$element.find("img");
            t = this.settings.nestedItemSelector ? "." + this.settings.nestedItemSelector : r;
            i = this.$element.children(t).width();
            n.length && i <= 0 && this.preloadAutoWidthImages(n)
        }
        this.initializeStage();
        this.initializeItems();
        this.registerEventHandlers();
        this.leave("initializing");
        this.trigger("initialized")
    };
    u.prototype.isVisible = function() {
        return !this.settings.checkVisibility || this.$element.is(":visible")
    };
    u.prototype.setup = function() {
        var u = this.viewport(),
            r = this.options.responsive,
            i = -1,
            t = null;
        r ? (n.each(r, function(n) {
            n <= u && n > i && (i = Number(n))
        }), t = n.extend({}, this.options, r[i]), "function" == typeof t.stagePadding && (t.stagePadding = t.stagePadding()), delete t.responsive, t.responsiveClass && this.$element.attr("class", this.$element.attr("class").replace(new RegExp("(" + this.options.responsiveClass + "-)\\S+\\s", "g"), "$1" + i))) : t = n.extend({}, this.options);
        this.trigger("change", {
            property: {
                name: "settings",
                value: t
            }
        });
        this._breakpoint = i;
        this.settings = t;
        this.invalidate("settings");
        this.trigger("changed", {
            property: {
                name: "settings",
                value: this.settings
            }
        })
    };
    u.prototype.optionsLogic = function() {
        this.settings.autoWidth && (this.settings.stagePadding = !1, this.settings.merge = !1)
    };
    u.prototype.prepare = function(t) {
        var i = this.trigger("prepare", {
            content: t
        });
        return i.data || (i.data = n("<" + this.settings.itemElement + "/>").addClass(this.options.itemClass).append(t)), this.trigger("prepared", {
            content: i.data
        }), i.data
    };
    u.prototype.update = function() {
        for (var t = 0, i = this._pipe.length, r = n.proxy(function(n) {
                return this[n]
            }, this._invalidated), u = {}; t < i;)(this._invalidated.all || n.grep(this._pipe[t].filter, r).length > 0) && this._pipe[t].run(u), t++;
        this._invalidated = {};
        this.is("valid") || this.enter("valid")
    };
    u.prototype.width = function(n) {
        switch (n = n || u.Width.Default) {
            case u.Width.Inner:
            case u.Width.Outer:
                return this._width;
            default:
                return this._width - 2 * this.settings.stagePadding + this.settings.margin
        }
    };
    u.prototype.refresh = function() {
        this.enter("refreshing");
        this.trigger("refresh");
        this.setup();
        this.optionsLogic();
        this.$element.addClass(this.options.refreshClass);
        this.update();
        this.$element.removeClass(this.options.refreshClass);
        this.leave("refreshing");
        this.trigger("refreshed")
    };
    u.prototype.onThrottledResize = function() {
        t.clearTimeout(this.resizeTimer);
        this.resizeTimer = t.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate)
    };
    u.prototype.onResize = function() {
        return !!this._items.length && this._width !== this.$element.width() && !!this.isVisible() && (this.enter("resizing"), this.trigger("resize").isDefaultPrevented() ? (this.leave("resizing"), !1) : (this.invalidate("width"), this.refresh(), this.leave("resizing"), void this.trigger("resized")))
    };
    u.prototype.registerEventHandlers = function() {
        n.support.transition && this.$stage.on(n.support.transition.end + ".owl.core", n.proxy(this.onTransitionEnd, this));
        !1 !== this.settings.responsive && this.on(t, "resize", this._handlers.onThrottledResize);
        this.settings.mouseDrag && (this.$element.addClass(this.options.dragClass), this.$stage.on("mousedown.owl.core", n.proxy(this.onDragStart, this)), this.$stage.on("dragstart.owl.core selectstart.owl.core", function() {
            return !1
        }));
        this.settings.touchDrag && (this.$stage.on("touchstart.owl.core", n.proxy(this.onDragStart, this)), this.$stage.on("touchcancel.owl.core", n.proxy(this.onDragEnd, this)))
    };
    u.prototype.onDragStart = function(t) {
        var r = null;
        3 !== t.which && (n.support.transform ? (r = this.$stage.css("transform").replace(/.*\(|\)| /g, "").split(","), r = {
            x: r[16 === r.length ? 12 : 4],
            y: r[16 === r.length ? 13 : 5]
        }) : (r = this.$stage.position(), r = {
            x: this.settings.rtl ? r.left + this.$stage.width() - this.width() + this.settings.margin : r.left,
            y: r.top
        }), this.is("animating") && (n.support.transform ? this.animate(r.x) : this.$stage.stop(), this.invalidate("position")), this.$element.toggleClass(this.options.grabClass, "mousedown" === t.type), this.speed(0), this._drag.time = (new Date).getTime(), this._drag.target = n(t.target), this._drag.stage.start = r, this._drag.stage.current = r, this._drag.pointer = this.pointer(t), n(i).on("mouseup.owl.core touchend.owl.core", n.proxy(this.onDragEnd, this)), n(i).one("mousemove.owl.core touchmove.owl.core", n.proxy(function(t) {
            var r = this.difference(this._drag.pointer, this.pointer(t));
            n(i).on("mousemove.owl.core touchmove.owl.core", n.proxy(this.onDragMove, this));
            Math.abs(r.x) < Math.abs(r.y) && this.is("valid") || (t.preventDefault(), this.enter("dragging"), this.trigger("drag"))
        }, this)))
    };
    u.prototype.onDragMove = function(n) {
        var t = null,
            i = null,
            u = null,
            f = this.difference(this._drag.pointer, this.pointer(n)),
            r = this.difference(this._drag.stage.start, f);
        this.is("dragging") && (n.preventDefault(), this.settings.loop ? (t = this.coordinates(this.minimum()), i = this.coordinates(this.maximum() + 1) - t, r.x = ((r.x - t) % i + i) % i + t) : (t = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum()), i = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum()), u = this.settings.pullDrag ? f.x / -5 : 0, r.x = Math.max(Math.min(r.x, t + u), i + u)), this._drag.stage.current = r, this.animate(r.x))
    };
    u.prototype.onDragEnd = function(t) {
        var r = this.difference(this._drag.pointer, this.pointer(t)),
            f = this._drag.stage.current,
            u = r.x > 0 ^ this.settings.rtl ? "left" : "right";
        n(i).off(".owl.core");
        this.$element.removeClass(this.options.grabClass);
        (0 !== r.x && this.is("dragging") || !this.is("valid")) && (this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed), this.current(this.closest(f.x, 0 !== r.x ? u : this._drag.direction)), this.invalidate("position"), this.update(), this._drag.direction = u, (Math.abs(r.x) > 3 || (new Date).getTime() - this._drag.time > 300) && this._drag.target.one("click.owl.core", function() {
            return !1
        }));
        this.is("dragging") && (this.leave("dragging"), this.trigger("dragged"))
    };
    u.prototype.closest = function(t, i) {
        var u = -1,
            e = 30,
            o = this.width(),
            f = this.coordinates();
        return this.settings.freeDrag || n.each(f, n.proxy(function(n, s) {
            return "left" === i && t > s - e && t < s + e ? u = n : "right" === i && t > s - o - e && t < s - o + e ? u = n + 1 : this.op(t, "<", s) && this.op(t, ">", f[n + 1] !== r ? f[n + 1] : s - o) && (u = "left" === i ? n + 1 : n), -1 === u
        }, this)), this.settings.loop || (this.op(t, ">", f[this.minimum()]) ? u = t = this.minimum() : this.op(t, "<", f[this.maximum()]) && (u = t = this.maximum())), u
    };
    u.prototype.animate = function(t) {
        var i = this.speed() > 0;
        this.is("animating") && this.onTransitionEnd();
        i && (this.enter("animating"), this.trigger("translate"));
        n.support.transform3d && n.support.transition ? this.$stage.css({
            transform: "translate3d(" + t + "px,0px,0px)",
            transition: this.speed() / 1e3 + "s" + (this.settings.slideTransition ? " " + this.settings.slideTransition : "")
        }) : i ? this.$stage.animate({
            left: t + "px"
        }, this.speed(), this.settings.fallbackEasing, n.proxy(this.onTransitionEnd, this)) : this.$stage.css({
            left: t + "px"
        })
    };
    u.prototype.is = function(n) {
        return this._states.current[n] && this._states.current[n] > 0
    };
    u.prototype.current = function(n) {
        if (n === r) return this._current;
        if (0 === this._items.length) return r;
        if (n = this.normalize(n), this._current !== n) {
            var t = this.trigger("change", {
                property: {
                    name: "position",
                    value: n
                }
            });
            t.data !== r && (n = this.normalize(t.data));
            this._current = n;
            this.invalidate("position");
            this.trigger("changed", {
                property: {
                    name: "position",
                    value: this._current
                }
            })
        }
        return this._current
    };
    u.prototype.invalidate = function(t) {
        return "string" === n.type(t) && (this._invalidated[t] = !0, this.is("valid") && this.leave("valid")), n.map(this._invalidated, function(n, t) {
            return t
        })
    };
    u.prototype.reset = function(n) {
        (n = this.normalize(n)) !== r && (this._speed = 0, this._current = n, this.suppress(["translate", "translated"]), this.animate(this.coordinates(n)), this.release(["translate", "translated"]))
    };
    u.prototype.normalize = function(n, t) {
        var i = this._items.length,
            u = t ? 0 : this._clones.length;
        return !this.isNumeric(n) || i < 1 ? n = r : (n < 0 || n >= i + u) && (n = ((n - u / 2) % i + i) % i + u / 2), n
    };
    u.prototype.relative = function(n) {
        return n -= this._clones.length / 2, this.normalize(n, !0)
    };
    u.prototype.maximum = function(n) {
        var t, u, f, i = this.settings,
            r = this._coordinates.length;
        if (i.loop) r = this._clones.length / 2 + this._items.length - 1;
        else if (i.autoWidth || i.merge) {
            if (t = this._items.length)
                for (u = this._items[--t].width(), f = this.$element.width(); t-- && !((u += this._items[t].width() + this.settings.margin) > f););
            r = t + 1
        } else r = i.center ? this._items.length - 1 : this._items.length - i.items;
        return n && (r -= this._clones.length / 2), Math.max(r, 0)
    };
    u.prototype.minimum = function(n) {
        return n ? 0 : this._clones.length / 2
    };
    u.prototype.items = function(n) {
        return n === r ? this._items.slice() : (n = this.normalize(n, !0), this._items[n])
    };
    u.prototype.mergers = function(n) {
        return n === r ? this._mergers.slice() : (n = this.normalize(n, !0), this._mergers[n])
    };
    u.prototype.clones = function(t) {
        var i = this._clones.length / 2,
            f = i + this._items.length,
            u = function(n) {
                return n % 2 == 0 ? f + n / 2 : i - (n + 1) / 2
            };
        return t === r ? n.map(this._clones, function(n, t) {
            return u(t)
        }) : n.map(this._clones, function(n, i) {
            return n === t ? u(i) : null
        })
    };
    u.prototype.speed = function(n) {
        return n !== r && (this._speed = n), this._speed
    };
    u.prototype.coordinates = function(t) {
        var i, f = 1,
            u = t - 1;
        return t === r ? n.map(this._coordinates, n.proxy(function(n, t) {
            return this.coordinates(t)
        }, this)) : (this.settings.center ? (this.settings.rtl && (f = -1, u = t + 1), i = this._coordinates[t], i += (this.width() - i + (this._coordinates[u] || 0)) / 2 * f) : i = this._coordinates[u] || 0, i = Math.ceil(i))
    };
    u.prototype.duration = function(n, t, i) {
        return 0 === i ? 0 : Math.min(Math.max(Math.abs(t - n), 1), 6) * Math.abs(i || this.settings.smartSpeed)
    };
    u.prototype.to = function(n, t) {
        var u = this.current(),
            f = null,
            i = n - this.relative(u),
            s = (i > 0) - (i < 0),
            e = this._items.length,
            o = this.minimum(),
            r = this.maximum();
        this.settings.loop ? (!this.settings.rewind && Math.abs(i) > e / 2 && (i += -1 * s * e), n = u + i, (f = ((n - o) % e + e) % e + o) !== n && f - i <= r && f - i > 0 && (u = f - i, n = f, this.reset(u))) : this.settings.rewind ? (r += 1, n = (n % r + r) % r) : n = Math.max(o, Math.min(r, n));
        this.speed(this.duration(u, n, t));
        this.current(n);
        this.isVisible() && this.update()
    };
    u.prototype.next = function(n) {
        n = n || !1;
        this.to(this.relative(this.current()) + 1, n)
    };
    u.prototype.prev = function(n) {
        n = n || !1;
        this.to(this.relative(this.current()) - 1, n)
    };
    u.prototype.onTransitionEnd = function(n) {
        if (n !== r && (n.stopPropagation(), (n.target || n.srcElement || n.originalTarget) !== this.$stage.get(0))) return !1;
        this.leave("animating");
        this.trigger("translated")
    };
    u.prototype.viewport = function() {
        var r;
        return this.options.responsiveBaseElement !== t ? r = n(this.options.responsiveBaseElement).width() : t.innerWidth ? r = t.innerWidth : i.documentElement && i.documentElement.clientWidth ? r = i.documentElement.clientWidth : console.warn("Can not detect viewport width."), r
    };
    u.prototype.replace = function(t) {
        this.$stage.empty();
        this._items = [];
        t && (t = t instanceof jQuery ? t : n(t));
        this.settings.nestedItemSelector && (t = t.find("." + this.settings.nestedItemSelector));
        t.filter(function() {
            return 1 === this.nodeType
        }).each(n.proxy(function(n, t) {
            t = this.prepare(t);
            this.$stage.append(t);
            this._items.push(t);
            this._mergers.push(1 * t.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)
        }, this));
        this.reset(this.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0);
        this.invalidate("items")
    };
    u.prototype.add = function(t, i) {
        var u = this.relative(this._current);
        i = i === r ? this._items.length : this.normalize(i, !0);
        t = t instanceof jQuery ? t : n(t);
        this.trigger("add", {
            content: t,
            position: i
        });
        t = this.prepare(t);
        0 === this._items.length || i === this._items.length ? (0 === this._items.length && this.$stage.append(t), 0 !== this._items.length && this._items[i - 1].after(t), this._items.push(t), this._mergers.push(1 * t.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)) : (this._items[i].before(t), this._items.splice(i, 0, t), this._mergers.splice(i, 0, 1 * t.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1));
        this._items[u] && this.reset(this._items[u].index());
        this.invalidate("items");
        this.trigger("added", {
            content: t,
            position: i
        })
    };
    u.prototype.remove = function(n) {
        (n = this.normalize(n, !0)) !== r && (this.trigger("remove", {
            content: this._items[n],
            position: n
        }), this._items[n].remove(), this._items.splice(n, 1), this._mergers.splice(n, 1), this.invalidate("items"), this.trigger("removed", {
            content: null,
            position: n
        }))
    };
    u.prototype.preloadAutoWidthImages = function(t) {
        t.each(n.proxy(function(t, i) {
            this.enter("pre-loading");
            i = n(i);
            n(new Image).one("load", n.proxy(function(n) {
                i.attr("src", n.target.src);
                i.css("opacity", 1);
                this.leave("pre-loading");
                !this.is("pre-loading") && !this.is("initializing") && this.refresh()
            }, this)).attr("src", i.attr("src") || i.attr("data-src") || i.attr("data-src-retina"))
        }, this))
    };
    u.prototype.destroy = function() {
        this.$element.off(".owl.core");
        this.$stage.off(".owl.core");
        n(i).off(".owl.core");
        !1 !== this.settings.responsive && (t.clearTimeout(this.resizeTimer), this.off(t, "resize", this._handlers.onThrottledResize));
        for (var r in this._plugins) this._plugins[r].destroy();
        this.$stage.children(".cloned").remove();
        this.$stage.unwrap();
        this.$stage.children().contents().unwrap();
        this.$stage.children().unwrap();
        this.$stage.remove();
        this.$element.removeClass(this.options.refreshClass).removeClass(this.options.loadingClass).removeClass(this.options.loadedClass).removeClass(this.options.rtlClass).removeClass(this.options.dragClass).removeClass(this.options.grabClass).attr("class", this.$element.attr("class").replace(new RegExp(this.options.responsiveClass + "-\\S+\\s", "g"), "")).removeData("owl.carousel")
    };
    u.prototype.op = function(n, t, i) {
        var r = this.settings.rtl;
        switch (t) {
            case "<":
                return r ? n > i : n < i;
            case ">":
                return r ? n < i : n > i;
            case ">=":
                return r ? n <= i : n >= i;
            case "<=":
                return r ? n >= i : n <= i
        }
    };
    u.prototype.on = function(n, t, i, r) {
        n.addEventListener ? n.addEventListener(t, i, r) : n.attachEvent && n.attachEvent("on" + t, i)
    };
    u.prototype.off = function(n, t, i, r) {
        n.removeEventListener ? n.removeEventListener(t, i, r) : n.detachEvent && n.detachEvent("on" + t, i)
    };
    u.prototype.trigger = function(t, i, r) {
        var o = {
                item: {
                    count: this._items.length,
                    index: this.current()
                }
            },
            e = n.camelCase(n.grep(["on", t, r], function(n) {
                return n
            }).join("-").toLowerCase()),
            f = n.Event([t, "owl", r || "carousel"].join(".").toLowerCase(), n.extend({
                relatedTarget: this
            }, o, i));
        return this._supress[t] || (n.each(this._plugins, function(n, t) {
            t.onTrigger && t.onTrigger(f)
        }), this.register({
            type: u.Type.Event,
            name: t
        }), this.$element.trigger(f), this.settings && "function" == typeof this.settings[e] && this.settings[e].call(this, f)), f
    };
    u.prototype.enter = function(t) {
        n.each([t].concat(this._states.tags[t] || []), n.proxy(function(n, t) {
            this._states.current[t] === r && (this._states.current[t] = 0);
            this._states.current[t]++
        }, this))
    };
    u.prototype.leave = function(t) {
        n.each([t].concat(this._states.tags[t] || []), n.proxy(function(n, t) {
            this._states.current[t]--
        }, this))
    };
    u.prototype.register = function(t) {
        if (t.type === u.Type.Event) {
            if (n.event.special[t.name] || (n.event.special[t.name] = {}), !n.event.special[t.name].owl) {
                var i = n.event.special[t.name]._default;
                n.event.special[t.name]._default = function(n) {
                    return !i || !i.apply || n.namespace && -1 !== n.namespace.indexOf("owl") ? n.namespace && n.namespace.indexOf("owl") > -1 : i.apply(this, arguments)
                };
                n.event.special[t.name].owl = !0
            }
        } else t.type === u.Type.State && (this._states.tags[t.name] = this._states.tags[t.name] ? this._states.tags[t.name].concat(t.tags) : t.tags, this._states.tags[t.name] = n.grep(this._states.tags[t.name], n.proxy(function(i, r) {
            return n.inArray(i, this._states.tags[t.name]) === r
        }, this)))
    };
    u.prototype.suppress = function(t) {
        n.each(t, n.proxy(function(n, t) {
            this._supress[t] = !0
        }, this))
    };
    u.prototype.release = function(t) {
        n.each(t, n.proxy(function(n, t) {
            delete this._supress[t]
        }, this))
    };
    u.prototype.pointer = function(n) {
        var i = {
            x: null,
            y: null
        };
        return n = n.originalEvent || n || t.event, n = n.touches && n.touches.length ? n.touches[0] : n.changedTouches && n.changedTouches.length ? n.changedTouches[0] : n, n.pageX ? (i.x = n.pageX, i.y = n.pageY) : (i.x = n.clientX, i.y = n.clientY), i
    };
    u.prototype.isNumeric = function(n) {
        return !isNaN(parseFloat(n))
    };
    u.prototype.difference = function(n, t) {
        return {
            x: n.x - t.x,
            y: n.y - t.y
        }
    };
    n.fn.owlCarousel = function(t) {
        var i = Array.prototype.slice.call(arguments, 1);
        return this.each(function() {
            var f = n(this),
                r = f.data("owl.carousel");
            r || (r = new u(this, "object" == typeof t && t), f.data("owl.carousel", r), n.each(["next", "prev", "to", "destroy", "refresh", "replace", "add", "remove"], function(t, i) {
                r.register({
                    type: u.Type.Event,
                    name: i
                });
                r.$element.on(i + ".owl.carousel.core", n.proxy(function(n) {
                    n.namespace && n.relatedTarget !== this && (this.suppress([i]), r[i].apply(this, [].slice.call(arguments, 1)), this.release([i]))
                }, r))
            }));
            "string" == typeof t && "_" !== t.charAt(0) && r[t].apply(r, i)
        })
    };
    n.fn.owlCarousel.Constructor = u
}(window.Zepto || window.jQuery, window, document),
function(n, t) {
    var i = function(t) {
        this._core = t;
        this._interval = null;
        this._visible = null;
        this._handlers = {
            "initialized.owl.carousel": n.proxy(function(n) {
                n.namespace && this._core.settings.autoRefresh && this.watch()
            }, this)
        };
        this._core.options = n.extend({}, i.Defaults, this._core.options);
        this._core.$element.on(this._handlers)
    };
    i.Defaults = {
        autoRefresh: !0,
        autoRefreshInterval: 500
    };
    i.prototype.watch = function() {
        this._interval || (this._visible = this._core.isVisible(), this._interval = t.setInterval(n.proxy(this.refresh, this), this._core.settings.autoRefreshInterval))
    };
    i.prototype.refresh = function() {
        this._core.isVisible() !== this._visible && (this._visible = !this._visible, this._core.$element.toggleClass("owl-hidden", !this._visible), this._visible && this._core.invalidate("width") && this._core.refresh())
    };
    i.prototype.destroy = function() {
        var n, i;
        t.clearInterval(this._interval);
        for (n in this._handlers) this._core.$element.off(n, this._handlers[n]);
        for (i in Object.getOwnPropertyNames(this)) "function" != typeof this[i] && (this[i] = null)
    };
    n.fn.owlCarousel.Constructor.Plugins.AutoRefresh = i
}(window.Zepto || window.jQuery, window, document),
function(n, t, i, r) {
    var u = function(t) {
        this._core = t;
        this._loaded = [];
        this._handlers = {
            "initialized.owl.carousel change.owl.carousel resized.owl.carousel": n.proxy(function(t) {
                if (t.namespace && this._core.settings && this._core.settings.lazyLoad && (t.property && "position" == t.property.name || "initialized" == t.type)) {
                    var i = this._core.settings,
                        u = i.center && Math.ceil(i.items / 2) || i.items,
                        e = i.center && -1 * u || 0,
                        f = (t.property && t.property.value !== r ? t.property.value : this._core.current()) + e,
                        o = this._core.clones().length,
                        s = n.proxy(function(n, t) {
                            this.load(t)
                        }, this);
                    for (i.lazyLoadEager > 0 && (u += i.lazyLoadEager, i.loop && (f -= i.lazyLoadEager, u++)); e++ < u;) this.load(o / 2 + this._core.relative(f)), o && n.each(this._core.clones(this._core.relative(f)), s), f++
                }
            }, this)
        };
        this._core.options = n.extend({}, u.Defaults, this._core.options);
        this._core.$element.on(this._handlers)
    };
    u.Defaults = {
        lazyLoad: !1,
        lazyLoadEager: 0
    };
    u.prototype.load = function(i) {
        var r = this._core.$stage.children().eq(i),
            u = r && r.find(".owl-lazy");
        !u || n.inArray(r.get(0), this._loaded) > -1 || (u.each(n.proxy(function(i, r) {
            var e, u = n(r),
                f = t.devicePixelRatio > 1 && u.attr("data-src-retina") || u.attr("data-src") || u.attr("data-srcset");
            this._core.trigger("load", {
                element: u,
                url: f
            }, "lazy");
            u.is("img") ? u.one("load.owl.lazy", n.proxy(function() {
                u.css("opacity", 1);
                this._core.trigger("loaded", {
                    element: u,
                    url: f
                }, "lazy")
            }, this)).attr("src", f) : u.is("source") ? u.one("load.owl.lazy", n.proxy(function() {
                this._core.trigger("loaded", {
                    element: u,
                    url: f
                }, "lazy")
            }, this)).attr("srcset", f) : (e = new Image, e.onload = n.proxy(function() {
                u.css({
                    "background-image": 'url("' + f + '")',
                    opacity: "1"
                });
                this._core.trigger("loaded", {
                    element: u,
                    url: f
                }, "lazy")
            }, this), e.src = f)
        }, this)), this._loaded.push(r.get(0)))
    };
    u.prototype.destroy = function() {
        var n, t;
        for (n in this.handlers) this._core.$element.off(n, this.handlers[n]);
        for (t in Object.getOwnPropertyNames(this)) "function" != typeof this[t] && (this[t] = null)
    };
    n.fn.owlCarousel.Constructor.Plugins.Lazy = u
}(window.Zepto || window.jQuery, window, document),
function(n, t) {
    var i = function(r) {
        this._core = r;
        this._previousHeight = null;
        this._handlers = {
            "initialized.owl.carousel refreshed.owl.carousel": n.proxy(function(n) {
                n.namespace && this._core.settings.autoHeight && this.update()
            }, this),
            "changed.owl.carousel": n.proxy(function(n) {
                n.namespace && this._core.settings.autoHeight && "position" === n.property.name && this.update()
            }, this),
            "loaded.owl.lazy": n.proxy(function(n) {
                n.namespace && this._core.settings.autoHeight && n.element.closest("." + this._core.settings.itemClass).index() === this._core.current() && this.update()
            }, this)
        };
        this._core.options = n.extend({}, i.Defaults, this._core.options);
        this._core.$element.on(this._handlers);
        this._intervalId = null;
        var u = this;
        n(t).on("load", function() {
            u._core.settings.autoHeight && u.update()
        });
        n(t).resize(function() {
            u._core.settings.autoHeight && (null != u._intervalId && clearTimeout(u._intervalId), u._intervalId = setTimeout(function() {
                u.update()
            }, 250))
        })
    };
    i.Defaults = {
        autoHeight: !1,
        autoHeightClass: "owl-height"
    };
    i.prototype.update = function() {
        var i = this._core._current,
            u = i + this._core.settings.items,
            f = this._core.settings.lazyLoad,
            e = this._core.$stage.children().toArray().slice(i, u),
            r = [],
            t = 0;
        n.each(e, function(t, i) {
            r.push(n(i).height())
        });
        t = Math.max.apply(null, r);
        t <= 1 && f && this._previousHeight && (t = this._previousHeight);
        this._previousHeight = t;
        this._core.$stage.parent().height(t).addClass(this._core.settings.autoHeightClass)
    };
    i.prototype.destroy = function() {
        var n, t;
        for (n in this._handlers) this._core.$element.off(n, this._handlers[n]);
        for (t in Object.getOwnPropertyNames(this)) "function" != typeof this[t] && (this[t] = null)
    };
    n.fn.owlCarousel.Constructor.Plugins.AutoHeight = i
}(window.Zepto || window.jQuery, window, document),
function(n, t, i) {
    var r = function(t) {
        this._core = t;
        this._videos = {};
        this._playing = null;
        this._handlers = {
            "initialized.owl.carousel": n.proxy(function(n) {
                n.namespace && this._core.register({
                    type: "state",
                    name: "playing",
                    tags: ["interacting"]
                })
            }, this),
            "resize.owl.carousel": n.proxy(function(n) {
                n.namespace && this._core.settings.video && this.isInFullScreen() && n.preventDefault()
            }, this),
            "refreshed.owl.carousel": n.proxy(function(n) {
                n.namespace && this._core.is("resizing") && this._core.$stage.find(".cloned .owl-video-frame").remove()
            }, this),
            "changed.owl.carousel": n.proxy(function(n) {
                n.namespace && "position" === n.property.name && this._playing && this.stop()
            }, this),
            "prepared.owl.carousel": n.proxy(function(t) {
                if (t.namespace) {
                    var i = n(t.content).find(".owl-video");
                    i.length && (i.css("display", "none"), this.fetch(i, n(t.content)))
                }
            }, this)
        };
        this._core.options = n.extend({}, r.Defaults, this._core.options);
        this._core.$element.on(this._handlers);
        this._core.$element.on("click.owl.video", ".owl-video-play-icon", n.proxy(function(n) {
            this.play(n)
        }, this))
    };
    r.Defaults = {
        video: !1,
        videoHeight: !1,
        videoWidth: !1
    };
    r.prototype.fetch = function(n, t) {
        var u = function() {
                return n.attr("data-vimeo-id") ? "vimeo" : n.attr("data-vzaar-id") ? "vzaar" : "youtube"
            }(),
            i = n.attr("data-vimeo-id") || n.attr("data-youtube-id") || n.attr("data-vzaar-id"),
            f = n.attr("data-width") || this._core.settings.videoWidth,
            e = n.attr("data-height") || this._core.settings.videoHeight,
            r = n.attr("href");
        if (!r) throw new Error("Missing video URL.");
        if (i = r.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com|be\-nocookie\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/), i[3].indexOf("youtu") > -1) u = "youtube";
        else if (i[3].indexOf("vimeo") > -1) u = "vimeo";
        else {
            if (!(i[3].indexOf("vzaar") > -1)) throw new Error("Video URL not supported.");
            u = "vzaar"
        }
        i = i[6];
        this._videos[r] = {
            type: u,
            id: i,
            width: f,
            height: e
        };
        t.attr("data-video", r);
        this.thumbnail(n, this._videos[r])
    };
    r.prototype.thumbnail = function(t, i) {
        var e, o, r, c = i.width && i.height ? "width:" + i.width + "px;height:" + i.height + "px;" : "",
            f = t.find("img"),
            s = "src",
            h = "",
            l = this._core.settings,
            u = function(i) {
                o = '<div class="owl-video-play-icon"><\/div>';
                e = l.lazyLoad ? n("<div/>", {
                    "class": "owl-video-tn " + h,
                    srcType: i
                }) : n("<div/>", {
                    "class": "owl-video-tn",
                    style: "opacity:1;background-image:url(" + i + ")"
                });
                t.after(e);
                t.after(o)
            };
        if (t.wrap(n("<div/>", {
                "class": "owl-video-wrapper",
                style: c
            })), this._core.settings.lazyLoad && (s = "data-src", h = "owl-lazy"), f.length) return u(f.attr(s)), f.remove(), !1;
        "youtube" === i.type ? (r = "//img.youtube.com/vi/" + i.id + "/hqdefault.jpg", u(r)) : "vimeo" === i.type ? n.ajax({
            type: "GET",
            url: "//vimeo.com/api/v2/video/" + i.id + ".json",
            jsonp: "callback",
            dataType: "jsonp",
            success: function(n) {
                r = n[0].thumbnail_large;
                u(r)
            }
        }) : "vzaar" === i.type && n.ajax({
            type: "GET",
            url: "//vzaar.com/api/videos/" + i.id + ".json",
            jsonp: "callback",
            dataType: "jsonp",
            success: function(n) {
                r = n.framegrab_url;
                u(r)
            }
        })
    };
    r.prototype.stop = function() {
        this._core.trigger("stop", null, "video");
        this._playing.find(".owl-video-frame").remove();
        this._playing.removeClass("owl-video-playing");
        this._playing = null;
        this._core.leave("playing");
        this._core.trigger("stopped", null, "video")
    };
    r.prototype.play = function(t) {
        var r, f = n(t.target),
            u = f.closest("." + this._core.settings.itemClass),
            i = this._videos[u.attr("data-video")],
            e = i.width || "100%",
            o = i.height || this._core.$stage.height();
        this._playing || (this._core.enter("playing"), this._core.trigger("play", null, "video"), u = this._core.items(this._core.relative(u.index())), this._core.reset(u.index()), r = n('<iframe frameborder="0" allowfullscreen mozallowfullscreen webkitAllowFullScreen ><\/iframe>'), r.attr("height", o), r.attr("width", e), "youtube" === i.type ? r.attr("src", "//www.youtube.com/embed/" + i.id + "?autoplay=1&rel=0&v=" + i.id) : "vimeo" === i.type ? r.attr("src", "//player.vimeo.com/video/" + i.id + "?autoplay=1") : "vzaar" === i.type && r.attr("src", "//view.vzaar.com/" + i.id + "/player?autoplay=true"), n(r).wrap('<div class="owl-video-frame" />').insertAfter(u.find(".owl-video")), this._playing = u.addClass("owl-video-playing"))
    };
    r.prototype.isInFullScreen = function() {
        var t = i.fullscreenElement || i.mozFullScreenElement || i.webkitFullscreenElement;
        return t && n(t).parent().hasClass("owl-video-frame")
    };
    r.prototype.destroy = function() {
        var n, t;
        this._core.$element.off("click.owl.video");
        for (n in this._handlers) this._core.$element.off(n, this._handlers[n]);
        for (t in Object.getOwnPropertyNames(this)) "function" != typeof this[t] && (this[t] = null)
    };
    n.fn.owlCarousel.Constructor.Plugins.Video = r
}(window.Zepto || window.jQuery, window, document),
function(n, t, i, r) {
    var u = function(t) {
        this.core = t;
        this.core.options = n.extend({}, u.Defaults, this.core.options);
        this.swapping = !0;
        this.previous = r;
        this.next = r;
        this.handlers = {
            "change.owl.carousel": n.proxy(function(n) {
                n.namespace && "position" == n.property.name && (this.previous = this.core.current(), this.next = n.property.value)
            }, this),
            "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": n.proxy(function(n) {
                n.namespace && (this.swapping = "translated" == n.type)
            }, this),
            "translate.owl.carousel": n.proxy(function(n) {
                n.namespace && this.swapping && (this.core.options.animateOut || this.core.options.animateIn) && this.swap()
            }, this)
        };
        this.core.$element.on(this.handlers)
    };
    u.Defaults = {
        animateOut: !1,
        animateIn: !1
    };
    u.prototype.swap = function() {
        if (1 === this.core.settings.items && n.support.animation && n.support.transition) {
            this.core.speed(0);
            var t, i = n.proxy(this.clear, this),
                f = this.core.$stage.children().eq(this.previous),
                e = this.core.$stage.children().eq(this.next),
                r = this.core.settings.animateIn,
                u = this.core.settings.animateOut;
            this.core.current() !== this.previous && (u && (t = this.core.coordinates(this.previous) - this.core.coordinates(this.next), f.one(n.support.animation.end, i).css({
                left: t + "px"
            }).addClass("animated owl-animated-out").addClass(u)), r && e.one(n.support.animation.end, i).addClass("animated owl-animated-in").addClass(r))
        }
    };
    u.prototype.clear = function(t) {
        n(t.target).css({
            left: ""
        }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut);
        this.core.onTransitionEnd()
    };
    u.prototype.destroy = function() {
        var n, t;
        for (n in this.handlers) this.core.$element.off(n, this.handlers[n]);
        for (t in Object.getOwnPropertyNames(this)) "function" != typeof this[t] && (this[t] = null)
    };
    n.fn.owlCarousel.Constructor.Plugins.Animate = u
}(window.Zepto || window.jQuery, window, document),
function(n, t, i) {
    var r = function(t) {
        this._core = t;
        this._call = null;
        this._time = 0;
        this._timeout = 0;
        this._paused = !0;
        this._handlers = {
            "changed.owl.carousel": n.proxy(function(n) {
                n.namespace && "settings" === n.property.name ? this._core.settings.autoplay ? this.play() : this.stop() : n.namespace && "position" === n.property.name && this._paused && (this._time = 0)
            }, this),
            "initialized.owl.carousel": n.proxy(function(n) {
                n.namespace && this._core.settings.autoplay && this.play()
            }, this),
            "play.owl.autoplay": n.proxy(function(n, t, i) {
                n.namespace && this.play(t, i)
            }, this),
            "stop.owl.autoplay": n.proxy(function(n) {
                n.namespace && this.stop()
            }, this),
            "mouseover.owl.autoplay": n.proxy(function() {
                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause()
            }, this),
            "mouseleave.owl.autoplay": n.proxy(function() {
                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.play()
            }, this),
            "touchstart.owl.core": n.proxy(function() {
                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause()
            }, this),
            "touchend.owl.core": n.proxy(function() {
                this._core.settings.autoplayHoverPause && this.play()
            }, this)
        };
        this._core.$element.on(this._handlers);
        this._core.options = n.extend({}, r.Defaults, this._core.options)
    };
    r.Defaults = {
        autoplay: !1,
        autoplayTimeout: 5e3,
        autoplayHoverPause: !1,
        autoplaySpeed: !1
    };
    r.prototype._next = function(r) {
        this._call = t.setTimeout(n.proxy(this._next, this, r), this._timeout * (Math.round(this.read() / this._timeout) + 1) - this.read());
        this._core.is("interacting") || i.hidden || this._core.next(r || this._core.settings.autoplaySpeed)
    };
    r.prototype.read = function() {
        return (new Date).getTime() - this._time
    };
    r.prototype.play = function(i, r) {
        var u;
        this._core.is("rotating") || this._core.enter("rotating");
        i = i || this._core.settings.autoplayTimeout;
        u = Math.min(this._time % (this._timeout || i), i);
        this._paused ? (this._time = this.read(), this._paused = !1) : t.clearTimeout(this._call);
        this._time += this.read() % i - u;
        this._timeout = i;
        this._call = t.setTimeout(n.proxy(this._next, this, r), i - u)
    };
    r.prototype.stop = function() {
        this._core.is("rotating") && (this._time = 0, this._paused = !0, t.clearTimeout(this._call), this._core.leave("rotating"))
    };
    r.prototype.pause = function() {
        this._core.is("rotating") && !this._paused && (this._time = this.read(), this._paused = !0, t.clearTimeout(this._call))
    };
    r.prototype.destroy = function() {
        var n, t;
        this.stop();
        for (n in this._handlers) this._core.$element.off(n, this._handlers[n]);
        for (t in Object.getOwnPropertyNames(this)) "function" != typeof this[t] && (this[t] = null)
    };
    n.fn.owlCarousel.Constructor.Plugins.autoplay = r
}(window.Zepto || window.jQuery, window, document),
function(n) {
    "use strict";
    var t = function(i) {
        this._core = i;
        this._initialized = !1;
        this._pages = [];
        this._controls = {};
        this._templates = [];
        this.$element = this._core.$element;
        this._overrides = {
            next: this._core.next,
            prev: this._core.prev,
            to: this._core.to
        };
        this._handlers = {
            "prepared.owl.carousel": n.proxy(function(t) {
                t.namespace && this._core.settings.dotsData && this._templates.push('<div class="' + this._core.settings.dotClass + '">' + n(t.content).find("[data-dot]").addBack("[data-dot]").attr("data-dot") + "<\/div>")
            }, this),
            "added.owl.carousel": n.proxy(function(n) {
                n.namespace && this._core.settings.dotsData && this._templates.splice(n.position, 0, this._templates.pop())
            }, this),
            "remove.owl.carousel": n.proxy(function(n) {
                n.namespace && this._core.settings.dotsData && this._templates.splice(n.position, 1)
            }, this),
            "changed.owl.carousel": n.proxy(function(n) {
                n.namespace && "position" == n.property.name && this.draw()
            }, this),
            "initialized.owl.carousel": n.proxy(function(n) {
                n.namespace && !this._initialized && (this._core.trigger("initialize", null, "navigation"), this.initialize(), this.update(), this.draw(), this._initialized = !0, this._core.trigger("initialized", null, "navigation"))
            }, this),
            "refreshed.owl.carousel": n.proxy(function(n) {
                n.namespace && this._initialized && (this._core.trigger("refresh", null, "navigation"), this.update(), this.draw(), this._core.trigger("refreshed", null, "navigation"))
            }, this)
        };
        this._core.options = n.extend({}, t.Defaults, this._core.options);
        this.$element.on(this._handlers)
    };
    t.Defaults = {
        nav: !1,
        navText: ['<span aria-label="Previous">&#x2039;<\/span>', '<span aria-label="Next">&#x203a;<\/span>'],
        navSpeed: !1,
        navElement: 'button type="button" role="presentation"',
        navContainer: !1,
        navContainerClass: "owl-nav",
        navClass: ["owl-prev", "owl-next"],
        slideBy: 1,
        dotClass: "owl-dot",
        dotsClass: "owl-dots",
        dots: !0,
        dotsEach: !1,
        dotsData: !1,
        dotsSpeed: !1,
        dotsContainer: !1
    };
    t.prototype.initialize = function() {
        var i, t = this._core.settings;
        this._controls.$relative = (t.navContainer ? n(t.navContainer) : n("<div>").addClass(t.navContainerClass).appendTo(this.$element)).addClass("disabled");
        this._controls.$previous = n("<" + t.navElement + ">").addClass(t.navClass[0]).html(t.navText[0]).prependTo(this._controls.$relative).on("click", n.proxy(function() {
            this.prev(t.navSpeed)
        }, this));
        this._controls.$next = n("<" + t.navElement + ">").addClass(t.navClass[1]).html(t.navText[1]).appendTo(this._controls.$relative).on("click", n.proxy(function() {
            this.next(t.navSpeed)
        }, this));
        t.dotsData || (this._templates = [n('<button role="button">').addClass(t.dotClass).append(n("<span>")).prop("outerHTML")]);
        this._controls.$absolute = (t.dotsContainer ? n(t.dotsContainer) : n("<div>").addClass(t.dotsClass).appendTo(this.$element)).addClass("disabled");
        this._controls.$absolute.on("click", "button", n.proxy(function(i) {
            var r = n(i.target).parent().is(this._controls.$absolute) ? n(i.target).index() : n(i.target).parent().index();
            i.preventDefault();
            this.to(r, t.dotsSpeed)
        }, this));
        for (i in this._overrides) this._core[i] = n.proxy(this[i], this)
    };
    t.prototype.destroy = function() {
        var t, n, i, r, u = this._core.settings;
        for (t in this._handlers) this.$element.off(t, this._handlers[t]);
        for (n in this._controls) "$relative" === n && u.navContainer ? this._controls[n].html("") : this._controls[n].remove();
        for (r in this.overides) this._core[r] = this._overrides[r];
        for (i in Object.getOwnPropertyNames(this)) "function" != typeof this[i] && (this[i] = null)
    };
    t.prototype.update = function() {
        var t, i, f, r = this._core.clones().length / 2,
            o = r + this._core.items().length,
            u = this._core.maximum(!0),
            n = this._core.settings,
            e = n.center || n.autoWidth || n.dotsData ? 1 : n.dotsEach || n.items;
        if ("page" !== n.slideBy && (n.slideBy = Math.min(n.slideBy, n.items)), n.dots || "page" == n.slideBy)
            for (this._pages = [], t = r, i = 0, f = 0; t < o; t++) {
                if (i >= e || 0 === i) {
                    if (this._pages.push({
                            start: Math.min(u, t - r),
                            end: t - r + e - 1
                        }), Math.min(u, t - r) === u) break;
                    i = 0;
                    ++f
                }
                i += this._core.mergers(this._core.relative(t))
            }
    };
    t.prototype.draw = function() {
        var i, t = this._core.settings,
            r = this._core.items().length <= t.items,
            u = this._core.relative(this._core.current()),
            f = t.loop || t.rewind;
        this._controls.$relative.toggleClass("disabled", !t.nav || r);
        t.nav && (this._controls.$previous.toggleClass("disabled", !f && u <= this._core.minimum(!0)), this._controls.$next.toggleClass("disabled", !f && u >= this._core.maximum(!0)));
        this._controls.$absolute.toggleClass("disabled", !t.dots || r);
        t.dots && (i = this._pages.length - this._controls.$absolute.children().length, t.dotsData && 0 !== i ? this._controls.$absolute.html(this._templates.join("")) : i > 0 ? this._controls.$absolute.append(new Array(i + 1).join(this._templates[0])) : i < 0 && this._controls.$absolute.children().slice(i).remove(), this._controls.$absolute.find(".active").removeClass("active"), this._controls.$absolute.children().eq(n.inArray(this.current(), this._pages)).addClass("active"))
    };
    t.prototype.onTrigger = function(t) {
        var i = this._core.settings;
        t.page = {
            index: n.inArray(this.current(), this._pages),
            count: this._pages.length,
            size: i && (i.center || i.autoWidth || i.dotsData ? 1 : i.dotsEach || i.items)
        }
    };
    t.prototype.current = function() {
        var t = this._core.relative(this._core.current());
        return n.grep(this._pages, n.proxy(function(n) {
            return n.start <= t && n.end >= t
        }, this)).pop()
    };
    t.prototype.getPosition = function(t) {
        var i, r, u = this._core.settings;
        return "page" == u.slideBy ? (i = n.inArray(this.current(), this._pages), r = this._pages.length, t ? ++i : --i, i = this._pages[(i % r + r) % r].start) : (i = this._core.relative(this._core.current()), r = this._core.items().length, t ? i += u.slideBy : i -= u.slideBy), i
    };
    t.prototype.next = function(t) {
        n.proxy(this._overrides.to, this._core)(this.getPosition(!0), t)
    };
    t.prototype.prev = function(t) {
        n.proxy(this._overrides.to, this._core)(this.getPosition(!1), t)
    };
    t.prototype.to = function(t, i, r) {
        var u;
        !r && this._pages.length ? (u = this._pages.length, n.proxy(this._overrides.to, this._core)(this._pages[(t % u + u) % u].start, i)) : n.proxy(this._overrides.to, this._core)(t, i)
    };
    n.fn.owlCarousel.Constructor.Plugins.Navigation = t
}(window.Zepto || window.jQuery, window, document),
function(n, t, i, r) {
    "use strict";
    var u = function(i) {
        this._core = i;
        this._hashes = {};
        this.$element = this._core.$element;
        this._handlers = {
            "initialized.owl.carousel": n.proxy(function(i) {
                i.namespace && "URLHash" === this._core.settings.startPosition && n(t).trigger("hashchange.owl.navigation")
            }, this),
            "prepared.owl.carousel": n.proxy(function(t) {
                if (t.namespace) {
                    var i = n(t.content).find("[data-hash]").addBack("[data-hash]").attr("data-hash");
                    if (!i) return;
                    this._hashes[i] = t.content
                }
            }, this),
            "changed.owl.carousel": n.proxy(function(i) {
                if (i.namespace && "position" === i.property.name) {
                    var u = this._core.items(this._core.relative(this._core.current())),
                        r = n.map(this._hashes, function(n, t) {
                            return n === u ? t : null
                        }).join();
                    if (!r || t.location.hash.slice(1) === r) return;
                    t.location.hash = r
                }
            }, this)
        };
        this._core.options = n.extend({}, u.Defaults, this._core.options);
        this.$element.on(this._handlers);
        n(t).on("hashchange.owl.navigation", n.proxy(function() {
            var i = t.location.hash.substring(1),
                u = this._core.$stage.children(),
                n = this._hashes[i] && u.index(this._hashes[i]);
            n !== r && n !== this._core.current() && this._core.to(this._core.relative(n), !1, !0)
        }, this))
    };
    u.Defaults = {
        URLhashListener: !1
    };
    u.prototype.destroy = function() {
        var i, r;
        n(t).off("hashchange.owl.navigation");
        for (i in this._handlers) this._core.$element.off(i, this._handlers[i]);
        for (r in Object.getOwnPropertyNames(this)) "function" != typeof this[r] && (this[r] = null)
    };
    n.fn.owlCarousel.Constructor.Plugins.Hash = u
}(window.Zepto || window.jQuery, window, document),
function(n, t, i, r) {
    function u(t, i) {
        var u = !1,
            f = t.charAt(0).toUpperCase() + t.slice(1);
        return n.each((t + " " + h.join(f + " ") + f).split(" "), function(n, t) {
            if (s[t] !== r) return u = !i || t, !1
        }), u
    }

    function e(n) {
        return u(n, !0)
    }
    var s = n("<support>").get(0).style,
        h = "Webkit Moz O ms".split(" "),
        o = {
            transition: {
                end: {
                    WebkitTransition: "webkitTransitionEnd",
                    MozTransition: "transitionend",
                    OTransition: "oTransitionEnd",
                    transition: "transitionend"
                }
            },
            animation: {
                end: {
                    WebkitAnimation: "webkitAnimationEnd",
                    MozAnimation: "animationend",
                    OAnimation: "oAnimationEnd",
                    animation: "animationend"
                }
            }
        },
        f = {
            csstransforms: function() {
                return !!u("transform")
            },
            csstransforms3d: function() {
                return !!u("perspective")
            },
            csstransitions: function() {
                return !!u("transition")
            },
            cssanimations: function() {
                return !!u("animation")
            }
        };
    f.csstransitions() && (n.support.transition = new String(e("transition")), n.support.transition.end = o.transition.end[n.support.transition]);
    f.cssanimations() && (n.support.animation = new String(e("animation")), n.support.animation.end = o.animation.end[n.support.animation]);
    f.csstransforms() && (n.support.transform = new String(e("transform")), n.support.transform3d = f.csstransforms3d())
}(window.Zepto || window.jQuery, window, document);
! function(n, t) {
    "use strict";
    "function" == typeof define && define.amd ? define([], t) : "object" == typeof exports ? module.exports = t() : n.Headroom = t()
}(this, function() {
    "use strict";

    function i(n) {
        this.callback = n;
        this.ticking = !1
    }

    function u(n) {
        return n && "undefined" != typeof window && (n === window || n.nodeType)
    }

    function r(n) {
        var t, f, i, e;
        if (arguments.length <= 0) throw new Error("Missing arguments in extend function");
        for (i = n || {}, f = 1; f < arguments.length; f++) {
            e = arguments[f] || {};
            for (t in e) i[t] = "object" != typeof i[t] || u(i[t]) ? i[t] || e[t] : r(i[t], e[t])
        }
        return i
    }

    function f(n) {
        return n === Object(n) ? n : {
            down: n,
            up: n
        }
    }

    function n(t, i) {
        i = r(i, n.options);
        this.lastKnownScrollY = 0;
        this.elem = t;
        this.tolerance = f(i.tolerance);
        this.classes = i.classes;
        this.offset = i.offset;
        this.scroller = i.scroller;
        this.initialised = !1;
        this.onPin = i.onPin;
        this.onUnpin = i.onUnpin;
        this.onTop = i.onTop;
        this.onNotTop = i.onNotTop;
        this.onBottom = i.onBottom;
        this.onNotBottom = i.onNotBottom
    }
    var t = {
        bind: !! function() {}.bind,
        classList: "classList" in document.documentElement,
        rAF: !!(window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame)
    };
    return window.requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame, i.prototype = {
        constructor: i,
        update: function() {
            this.callback && this.callback();
            this.ticking = !1
        },
        requestTick: function() {
            this.ticking || (requestAnimationFrame(this.rafCallback || (this.rafCallback = this.update.bind(this))), this.ticking = !0)
        },
        handleEvent: function() {
            this.requestTick()
        }
    }, n.prototype = {
        constructor: n,
        init: function() {
            if (n.cutsTheMustard) return this.debouncer = new i(this.update.bind(this)), this.elem.classList.add(this.classes.initial), setTimeout(this.attachEvent.bind(this), 100), this
        },
        destroy: function() {
            var n = this.classes,
                t;
            this.initialised = !1;
            for (t in n) n.hasOwnProperty(t) && this.elem.classList.remove(n[t]);
            this.scroller.removeEventListener("scroll", this.debouncer, !1)
        },
        attachEvent: function() {
            this.initialised || (this.lastKnownScrollY = this.getScrollY(), this.initialised = !0, this.scroller.addEventListener("scroll", this.debouncer, !1), this.debouncer.handleEvent())
        },
        unpin: function() {
            var n = this.elem.classList,
                t = this.classes;
            !n.contains(t.pinned) && n.contains(t.unpinned) || (n.add(t.unpinned), n.remove(t.pinned), this.onUnpin && this.onUnpin.call(this))
        },
        pin: function() {
            var n = this.elem.classList,
                t = this.classes;
            n.contains(t.unpinned) && (n.remove(t.unpinned), n.add(t.pinned), this.onPin && this.onPin.call(this))
        },
        top: function() {
            var n = this.elem.classList,
                t = this.classes;
            n.contains(t.top) || (n.add(t.top), n.remove(t.notTop), this.onTop && this.onTop.call(this))
        },
        notTop: function() {
            var n = this.elem.classList,
                t = this.classes;
            n.contains(t.notTop) || (n.add(t.notTop), n.remove(t.top), this.onNotTop && this.onNotTop.call(this))
        },
        bottom: function() {
            var n = this.elem.classList,
                t = this.classes;
            n.contains(t.bottom) || (n.add(t.bottom), n.remove(t.notBottom), this.onBottom && this.onBottom.call(this))
        },
        notBottom: function() {
            var n = this.elem.classList,
                t = this.classes;
            n.contains(t.notBottom) || (n.add(t.notBottom), n.remove(t.bottom), this.onNotBottom && this.onNotBottom.call(this))
        },
        getScrollY: function() {
            return void 0 !== this.scroller.pageYOffset ? this.scroller.pageYOffset : void 0 !== this.scroller.scrollTop ? this.scroller.scrollTop : (document.documentElement || document.body.parentNode || document.body).scrollTop
        },
        getViewportHeight: function() {
            return window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight
        },
        getElementPhysicalHeight: function(n) {
            return Math.max(n.offsetHeight, n.clientHeight)
        },
        getScrollerPhysicalHeight: function() {
            return this.scroller === window || this.scroller === document.body ? this.getViewportHeight() : this.getElementPhysicalHeight(this.scroller)
        },
        getDocumentHeight: function() {
            var n = document.body,
                t = document.documentElement;
            return Math.max(n.scrollHeight, t.scrollHeight, n.offsetHeight, t.offsetHeight, n.clientHeight, t.clientHeight)
        },
        getElementHeight: function(n) {
            return Math.max(n.scrollHeight, n.offsetHeight, n.clientHeight)
        },
        getScrollerHeight: function() {
            return this.scroller === window || this.scroller === document.body ? this.getDocumentHeight() : this.getElementHeight(this.scroller)
        },
        isOutOfBounds: function(n) {
            var t = n < 0,
                i = n + this.getScrollerPhysicalHeight() > this.getScrollerHeight();
            return t || i
        },
        toleranceExceeded: function(n, t) {
            return Math.abs(n - this.lastKnownScrollY) >= this.tolerance[t]
        },
        shouldUnpin: function(n, t) {
            var i = n > this.lastKnownScrollY,
                r = n >= this.offset;
            return i && r && t
        },
        shouldPin: function(n, t) {
            var i = n < this.lastKnownScrollY,
                r = n <= this.offset;
            return i && t || r
        },
        update: function() {
            var n = this.getScrollY(),
                i = n > this.lastKnownScrollY ? "down" : "up",
                t = this.toleranceExceeded(n, i);
            this.isOutOfBounds(n) || (n <= this.offset ? this.top() : this.notTop(), n + this.getViewportHeight() >= this.getScrollerHeight() ? this.bottom() : this.notBottom(), this.shouldUnpin(n, t) ? this.unpin() : this.shouldPin(n, t) && this.pin(), this.lastKnownScrollY = n)
        }
    }, n.options = {
        tolerance: {
            up: 0,
            down: 0
        },
        offset: 0,
        scroller: window,
        classes: {
            pinned: "headroom--pinned",
            unpinned: "headroom--unpinned",
            top: "headroom--top",
            notTop: "headroom--not-top",
            bottom: "headroom--bottom",
            notBottom: "headroom--not-bottom",
            initial: "headroom"
        }
    }, n.cutsTheMustard = "undefined" != typeof t && t.rAF && t.bind && t.classList, n
});
! function(n) {
    n && (n.fn.headroom = function(t) {
        return this.each(function() {
            var r = n(this),
                i = r.data("headroom"),
                u = "object" == typeof t && t;
            u = n.extend(!0, {}, Headroom.options, u);
            i || (i = new Headroom(this, u), i.init(), r.data("headroom", i));
            "string" == typeof t && (i[t](), "destroy" === t && r.removeData("headroom"))
        })
    }, n("[data-headroom]").each(function() {
        var t = n(this);
        t.headroom(t.data())
    }))
}(window.Zepto || window.jQuery);
! function(n) {
    n.fn.jConveyorTicker = function(t) {
        if (void 0 === this || 0 === this.length) return console.log("jquery.jConveyorTicker() INITIALIZATION ERROR: You need to select one or more elements. See documentation form more information."), !1;
        var i = {
                anim_duration: 200,
                reverse_elm: !1
            },
            r = i.anim_duration,
            u = i.reverse_elm;
        t && (void 0 !== t.anim_duration && (r = t.anim_duration), void 0 !== t.reverse_elm && (u = t.reverse_elm), n.extend(i, t));
        this.each(function() {
            var f = n(this),
                t = f.children("ul"),
                o, e, i;
            (f.addClass("jctkr-wrapper"), t.width() >= t.parent().width() - 20) && (o = t.clone().children("li"), t.append(o), e = 0, t.children().each(function() {
                e += n(this).outerWidth()
            }), t.width(e), i = function(n) {
                var u, o = t.width(),
                    f = t.position().left,
                    s = "-",
                    e = "normal",
                    h;
                if (void 0 !== n && "reverse" === n) {
                    if (u = o / 2, f > 0) return t.css("left", "-" + u + "px"), void i("reverse");
                    s = "+";
                    e = "reverse"
                } else if (u = o / -2, f < u) return h = -1 * (u - f), t.css("left", h + "px"), void i(e);
                t.animate({
                    left: s + "=10px"
                }, r, "linear", function() {
                    i(e)
                })
            }, f.hover(function() {
                t.stop()
            }, function() {
                t.stop();
                i("normal")
            }), u && f.prev(".jctkr-label").hover(function() {
                t.stop();
                i("reverse")
            }, function() {
                t.stop();
                i("normal")
            }).click(function() {
                return !1
            }), i("normal"));
            f.addClass("jctkr-initialized")
        })
    }
}(jQuery, window, document);
! function(n) {
    "function" == typeof define && define.amd ? define(["jquery"], n) : "object" == typeof exports ? module.exports = n : n(jQuery)
}(function(n) {
    n.event.special.mresize = {
        add: function() {
            var t = n(this);
            t.data("mresize") || ("static" === t.css("position") && t.css("position", "relative"), t.append("<div class='resize' style='position:absolute; width:auto; height:auto; top:0; right:0; bottom:0; left:0; margin:0; padding:0; overflow:hidden; visibility:hidden; z-index:-1'><iframe style='width:100%; height:0; border:0; visibility:visible; margin:0' /><iframe style='width:0; height:100%; border:0; visibility:visible; margin:0' /><\/div>").data("mresize", {
                w: t.width(),
                h: t.height(),
                t: null,
                throttle: 100
            }).find(".resize iframe").each(function() {
                n(this.contentWindow || this).on("resize", function() {
                    var n = t.data("mresize");
                    (n.w !== t.width() || n.h !== t.height()) && (n.t && clearTimeout(n.t), n.t = setTimeout(function() {
                        t.triggerHandler("mresize");
                        n.w = t.width();
                        n.h = t.height()
                    }, n.throttle))
                })
            }))
        },
        remove: function() {
            n(this).removeData("mresize").find(".resize").remove()
        }
    }
});
! function(n) {
    "use strict";
    var t = {
        item: 3,
        autoWidth: !1,
        slideMove: 1,
        slideMargin: 10,
        addClass: "",
        mode: "slide",
        useCSS: !0,
        cssEasing: "ease",
        easing: "linear",
        speed: 400,
        auto: !1,
        pauseOnHover: !1,
        loop: !1,
        slideEndAnimation: !0,
        pause: 2e3,
        keyPress: !1,
        controls: !0,
        prevHtml: "",
        nextHtml: "",
        rtl: !1,
        adaptiveHeight: !1,
        vertical: !1,
        verticalHeight: 500,
        vThumbWidth: 100,
        thumbItem: 10,
        pager: !0,
        gallery: !1,
        galleryMargin: 5,
        thumbMargin: 5,
        currentPagerPosition: "middle",
        enableTouch: !0,
        enableDrag: !0,
        freeMove: !0,
        swipeThreshold: 40,
        responsive: [],
        onBeforeStart: function() {},
        onSliderLoad: function() {},
        onBeforeSlide: function() {},
        onAfterSlide: function() {},
        onBeforeNextSlide: function() {},
        onBeforePrevSlide: function() {}
    };
    n.fn.lightSlider = function(i) {
        if (0 === this.length) return this;
        if (this.length > 1) return this.each(function() {
            n(this).lightSlider(i)
        }), this;
        var l = {},
            r = n.extend(!0, {}, t, i),
            p = {},
            u = this;
        l.$el = this;
        "fade" === r.mode && (r.vertical = !1);
        var o = u.children(),
            g = n(window).width(),
            ut = null,
            b = null,
            w = 0,
            c = 0,
            nt = !1,
            s = 0,
            f = "",
            e = 0,
            tt = r.vertical === !0 ? "height" : "width",
            it = r.vertical === !0 ? "margin-bottom" : "margin-right",
            a = 0,
            d = 0,
            y = 0,
            k = 0,
            v = null,
            rt = "ontouchstart" in document.documentElement,
            h = {};
        return h.chbreakpoint = function() {
            var f, i, t, u;
            if (g = n(window).width(), r.responsive.length) {
                if (r.autoWidth === !1 && (f = r.item), g < r.responsive[0].breakpoint)
                    for (i = 0; i < r.responsive.length; i++) g < r.responsive[i].breakpoint && (ut = r.responsive[i].breakpoint, b = r.responsive[i]);
                if ("undefined" != typeof b && null !== b)
                    for (t in b.settings) b.settings.hasOwnProperty(t) && (("undefined" == typeof p[t] || null === p[t]) && (p[t] = r[t]), r[t] = b.settings[t]);
                if (!n.isEmptyObject(p) && g > r.responsive[0].breakpoint)
                    for (u in p) p.hasOwnProperty(u) && (r[u] = p[u]);
                r.autoWidth === !1 && a > 0 && y > 0 && f !== r.item && (e = Math.round(a / ((y + r.slideMargin) * r.slideMove)))
            }
        }, h.calSW = function() {
            r.autoWidth === !1 && (y = (s - (r.item * r.slideMargin - r.slideMargin)) / r.item)
        }, h.calWidth = function(n) {
            var i = n === !0 ? f.find(".lslide").length : o.length,
                t;
            if (r.autoWidth === !1) c = i * (y + r.slideMargin);
            else
                for (c = 0, t = 0; i > t; t++) c += parseInt(o.eq(t).width()) + r.slideMargin;
            return c
        }, l = {
            doCss: function() {
                var n = function() {
                    for (var t = ["transition", "MozTransition", "WebkitTransition", "OTransition", "msTransition", "KhtmlTransition"], i = document.documentElement, n = 0; n < t.length; n++)
                        if (t[n] in i.style) return !0
                };
                return r.useCSS && n() ? !0 : !1
            },
            keyPress: function() {
                r.keyPress && n(document).on("keyup.lightslider", function(t) {
                    n(":focus").is("input, textarea") || (t.preventDefault ? t.preventDefault() : t.returnValue = !1, 37 === t.keyCode ? u.goToPrevSlide() : 39 === t.keyCode && u.goToNextSlide())
                })
            },
            controls: function() {
                r.controls && (u.after('<div class="lSAction"><a class="lSPrev">' + r.prevHtml + '<\/a><a class="lSNext">' + r.nextHtml + "<\/a><\/div>"), r.autoWidth ? h.calWidth(!1) < s && f.find(".lSAction").hide() : w <= r.item && f.find(".lSAction").hide(), f.find(".lSAction a").on("click", function(t) {
                    return t.preventDefault ? t.preventDefault() : t.returnValue = !1, "lSPrev" === n(this).attr("class") ? u.goToPrevSlide() : u.goToNextSlide(), !1
                }))
            },
            initialStyle: function() {
                var n = this;
                "fade" === r.mode && (r.autoWidth = !1, r.slideEndAnimation = !1);
                r.auto && (r.slideEndAnimation = !1);
                r.autoWidth && (r.slideMove = 1, r.item = 1);
                r.loop && (r.slideMove = 1, r.freeMove = !1);
                r.onBeforeStart.call(this, u);
                h.chbreakpoint();
                u.addClass("lightSlider").wrap('<div class="lSSlideOuter ' + r.addClass + '"><div class="lSSlideWrapper"><\/div><\/div>');
                f = u.parent(".lSSlideWrapper");
                r.rtl === !0 && f.parent().addClass("lSrtl");
                r.vertical ? (f.parent().addClass("vertical"), s = r.verticalHeight, f.css("height", s + "px")) : s = u.outerWidth();
                o.addClass("lslide");
                r.loop === !0 && "slide" === r.mode && (h.calSW(), h.clone = function() {
                    var t, i, f, c, l;
                    if (h.calWidth(!0) > s) {
                        for (var v = 0, y = 0, a = 0; a < o.length && (v += parseInt(u.find(".lslide").eq(a).width()) + r.slideMargin, y++, !(v >= s + r.slideMargin)); a++);
                        if (t = r.autoWidth === !0 ? y : r.item, t < u.find(".clone.left").length)
                            for (i = 0; i < u.find(".clone.left").length - t; i++) o.eq(i).remove();
                        if (t < u.find(".clone.right").length)
                            for (f = o.length - 1; f > o.length - 1 - u.find(".clone.right").length; f--) e--, o.eq(f).remove();
                        for (c = u.find(".clone.right").length; t > c; c++) u.find(".lslide").eq(c).clone().removeClass("lslide").addClass("clone right").appendTo(u), e++;
                        for (l = u.find(".lslide").length - u.find(".clone.left").length; l > u.find(".lslide").length - t; l--) u.find(".lslide").eq(l - 1).clone().removeClass("lslide").addClass("clone left").prependTo(u);
                        o = u.children()
                    } else o.hasClass("clone") && (u.find(".clone").remove(), n.move(u, 0))
                }, h.clone());
                h.sSW = function() {
                    w = o.length;
                    r.rtl === !0 && r.vertical === !1 && (it = "margin-left");
                    r.autoWidth === !1 && o.css(tt, y + "px");
                    o.css(it, r.slideMargin + "px");
                    c = h.calWidth(!1);
                    u.css(tt, c + "px");
                    r.loop === !0 && "slide" === r.mode && nt === !1 && (e = u.find(".clone.left").length)
                };
                h.calL = function() {
                    o = u.children();
                    w = o.length
                };
                this.doCss() && f.addClass("usingCss");
                h.calL();
                "slide" === r.mode ? (h.calSW(), h.sSW(), r.loop === !0 && (a = n.slideValue(), this.move(u, a)), r.vertical === !1 && this.setHeight(u, !1)) : (this.setHeight(u, !0), u.addClass("lSFade"), this.doCss() || (o.fadeOut(0), o.eq(e).fadeIn(0)));
                r.loop === !0 && "slide" === r.mode ? o.eq(e).addClass("active") : o.first().addClass("active")
            },
            pager: function() {
                var i = this,
                    n, t;
                (h.createPager = function() {
                    var p, a, t, o;
                    k = (s - (r.thumbItem * r.thumbMargin - r.thumbMargin)) / r.thumbItem;
                    for (var v = f.find(".lslide"), w = f.find(".lslide").length, n = 0, h = "", l = 0, n = 0; w > n; n++)
                        if ("slide" === r.mode && (r.autoWidth ? l += (parseInt(v.eq(n).width()) + r.slideMargin) * r.slideMove : l = n * (y + r.slideMargin) * r.slideMove), p = v.eq(n * r.slideMove).attr("data-thumb"), h += r.gallery === !0 ? '<li style="width:100%;' + tt + ":" + k + "px;" + it + ":" + r.thumbMargin + 'px"><a href="#"><img src="' + p + '" /><\/a><\/li>' : '<li><a href="#">' + (n + 1) + "<\/a><\/li>", "slide" === r.mode && l >= c - s - r.slideMargin) {
                            n += 1;
                            a = 2;
                            r.autoWidth && (h += '<li><a href="#">' + (n + 1) + "<\/a><\/li>", a = 1);
                            a > n ? (h = null, f.parent().addClass("noPager")) : f.parent().removeClass("noPager");
                            break
                        } t = f.parent();
                    t.find(".lSPager").html(h);
                    r.gallery === !0 && (r.vertical === !0 && t.find(".lSPager").css("width", r.vThumbWidth + "px"), d = n * (r.thumbMargin + k) + .5, t.find(".lSPager").css({
                        property: d + "px",
                        "transition-duration": r.speed + "ms"
                    }), r.vertical === !0 && f.parent().css("padding-right", r.vThumbWidth + r.galleryMargin + "px"), t.find(".lSPager").css(tt, d + "px"));
                    o = t.find(".lSPager").find("li");
                    o.first().addClass("active");
                    o.on("click", function() {
                        return r.loop === !0 && "slide" === r.mode ? e += o.index(this) - t.find(".lSPager").find("li.active").index() : e = o.index(this), u.mode(!1), r.gallery === !0 && i.slideThumb(), !1
                    })
                }, r.pager) && (n = "lSpg", r.gallery && (n = "lSGallery"), f.after('<ul class="lSPager ' + n + '"><\/ul>'), t = r.vertical ? "margin-left" : "margin-top", f.parent().find(".lSPager").css(t, r.galleryMargin + "px"), h.createPager());
                setTimeout(function() {
                    h.init()
                }, 0)
            },
            setHeight: function(n, t) {
                var i = null,
                    f = this,
                    u;
                i = r.loop ? n.children(".lslide ").first() : n.children().first();
                u = function() {
                    var r = i.outerHeight(),
                        u = 0,
                        f = r;
                    t && (r = 0, u = 100 * f / s);
                    n.css({
                        height: r + "px",
                        "padding-bottom": u + "%"
                    })
                };
                u();
                i.find("img").length ? i.find("img")[0].complete ? (u(), v || f.auto()) : i.find("img").on("load", function() {
                    setTimeout(function() {
                        u();
                        v || f.auto()
                    }, 100)
                }) : v || f.auto()
            },
            active: function(n, t) {
                var i, o, s;
                this.doCss() && "fade" === r.mode && f.addClass("on");
                i = 0;
                e * r.slideMove < w ? (n.removeClass("active"), this.doCss() || "fade" !== r.mode || t !== !1 || n.fadeOut(r.speed), i = t === !0 ? e : e * r.slideMove, t === !0 && (o = n.length, s = o - 1, i + 1 >= o && (i = s)), r.loop === !0 && "slide" === r.mode && (i = t === !0 ? e - u.find(".clone.left").length : e * r.slideMove, t === !0 && (o = n.length, s = o - 1, i + 1 === o ? i = s : i + 1 > o && (i = 0))), this.doCss() || "fade" !== r.mode || t !== !1 || n.eq(i).fadeIn(r.speed), n.eq(i).addClass("active")) : (n.removeClass("active"), n.eq(n.length - 1).addClass("active"), this.doCss() || "fade" !== r.mode || t !== !1 || (n.fadeOut(r.speed), n.eq(i).fadeIn(r.speed)))
            },
            move: function(n, t) {
                r.rtl === !0 && (t = -t);
                this.doCss() ? n.css(r.vertical === !0 ? {
                    transform: "translate3d(0px, " + -t + "px, 0px)",
                    "-webkit-transform": "translate3d(0px, " + -t + "px, 0px)"
                } : {
                    transform: "translate3d(" + -t + "px, 0px, 0px)",
                    "-webkit-transform": "translate3d(" + -t + "px, 0px, 0px)"
                }) : r.vertical === !0 ? n.css("position", "relative").animate({
                    top: -t + "px"
                }, r.speed, r.easing) : n.css("position", "relative").animate({
                    left: -t + "px"
                }, r.speed, r.easing);
                var i = f.parent().find(".lSPager").find("li");
                this.active(i, !0)
            },
            fade: function() {
                this.active(o, !1);
                var n = f.parent().find(".lSPager").find("li");
                this.active(n, !0)
            },
            slide: function() {
                var n = this;
                h.calSlide = function() {
                    c > s && (a = n.slideValue(), n.active(o, !1), a > c - s - r.slideMargin ? a = c - s - r.slideMargin : 0 > a && (a = 0), n.move(u, a), r.loop === !0 && "slide" === r.mode && (e >= w - u.find(".clone.left").length / r.slideMove && n.resetSlide(u.find(".clone.left").length), 0 === e && n.resetSlide(f.find(".lslide").length)))
                };
                h.calSlide()
            },
            resetSlide: function(n) {
                var t = this;
                f.find(".lSAction a").addClass("disabled");
                setTimeout(function() {
                    e = n;
                    f.css("transition-duration", "0ms");
                    a = t.slideValue();
                    t.active(o, !1);
                    l.move(u, a);
                    setTimeout(function() {
                        f.css("transition-duration", r.speed + "ms");
                        f.find(".lSAction a").removeClass("disabled")
                    }, 50)
                }, r.speed + 100)
            },
            slideValue: function() {
                var n = 0,
                    t;
                if (r.autoWidth === !1) n = e * (y + r.slideMargin) * r.slideMove;
                else
                    for (n = 0, t = 0; e > t; t++) n += parseInt(o.eq(t).width()) + r.slideMargin;
                return n
            },
            slideThumb: function() {
                var i, n, o, t;
                switch (r.currentPagerPosition) {
                    case "left":
                        i = 0;
                        break;
                    case "middle":
                        i = s / 2 - k / 2;
                        break;
                    case "right":
                        i = s - k
                }
                n = e - u.find(".clone.left").length;
                o = f.parent().find(".lSPager");
                "slide" === r.mode && r.loop === !0 && (n >= o.children().length ? n = 0 : 0 > n && (n = o.children().length));
                t = n * (k + r.thumbMargin) - i;
                t + s > d && (t = d - s - r.thumbMargin);
                0 > t && (t = 0);
                this.move(o, t)
            },
            auto: function() {
                r.auto && (clearInterval(v), v = setInterval(function() {
                    u.goToNextSlide()
                }, r.pause))
            },
            pauseOnHover: function() {
                var t = this;
                r.auto && r.pauseOnHover && (f.on("mouseenter", function() {
                    n(this).addClass("ls-hover");
                    u.pause();
                    r.auto = !0
                }), f.on("mouseleave", function() {
                    n(this).removeClass("ls-hover");
                    f.find(".lightSlider").hasClass("lsGrabbing") || t.auto()
                }))
            },
            touchMove: function(n, t) {
                var o, i, e;
                (f.css("transition-duration", "0ms"), "slide" === r.mode) && (o = n - t, i = a - o, i >= c - s - r.slideMargin ? r.freeMove === !1 ? i = c - s - r.slideMargin : (e = c - s - r.slideMargin, i = e + (i - e) / 5) : 0 > i && (r.freeMove === !1 ? i = 0 : i /= 5), this.move(u, i))
            },
            touchEnd: function(n) {
                var i, t, h;
                (f.css("transition-duration", r.speed + "ms"), "slide" === r.mode) ? (i = !1, t = !0, a -= n, a > c - s - r.slideMargin ? (a = c - s - r.slideMargin, r.autoWidth === !1 && (i = !0)) : 0 > a && (a = 0), h = function(n) {
                    var u = 0,
                        f, t, h;
                    if (i || n && (u = 1), r.autoWidth)
                        for (f = 0, t = 0; t < o.length && (f += parseInt(o.eq(t).width()) + r.slideMargin, e = t + u, !(f >= a)); t++);
                    else h = a / ((y + r.slideMargin) * r.slideMove), e = parseInt(h) + u, a >= c - s - r.slideMargin && h % 1 != 0 && e++
                }, n >= r.swipeThreshold ? (h(!1), t = !1) : n <= -r.swipeThreshold && (h(!0), t = !1), u.mode(t), this.slideThumb()) : n >= r.swipeThreshold ? u.goToPrevSlide() : n <= -r.swipeThreshold && u.goToNextSlide()
            },
            enableDrag: function() {
                var e = this;
                if (!rt) {
                    var u = 0,
                        t = 0,
                        i = !1;
                    f.find(".lightSlider").addClass("lsGrab");
                    f.on("mousedown", function(t) {
                        return s > c && 0 !== c ? !1 : void("lSPrev" !== n(t.target).attr("class") && "lSNext" !== n(t.target).attr("class") && (u = r.vertical === !0 ? t.pageY : t.pageX, i = !0, t.preventDefault ? t.preventDefault() : t.returnValue = !1, f.scrollLeft += 1, f.scrollLeft -= 1, f.find(".lightSlider").removeClass("lsGrab").addClass("lsGrabbing"), clearInterval(v)))
                    });
                    n(window).on("mousemove", function(n) {
                        i && (t = r.vertical === !0 ? n.pageY : n.pageX, e.touchMove(t, u))
                    });
                    n(window).on("mouseup", function(o) {
                        if (i) {
                            f.find(".lightSlider").removeClass("lsGrabbing").addClass("lsGrab");
                            i = !1;
                            t = r.vertical === !0 ? o.pageY : o.pageX;
                            var s = t - u;
                            Math.abs(s) >= r.swipeThreshold && n(window).on("click.ls", function(t) {
                                t.preventDefault ? t.preventDefault() : t.returnValue = !1;
                                t.stopImmediatePropagation();
                                t.stopPropagation();
                                n(window).off("click.ls")
                            });
                            e.touchEnd(s)
                        }
                    })
                }
            },
            enableTouch: function() {
                var i = this,
                    n, t;
                rt && (n = {}, t = {}, f.on("touchstart", function(i) {
                    t = i.originalEvent.targetTouches[0];
                    n.pageX = i.originalEvent.targetTouches[0].pageX;
                    n.pageY = i.originalEvent.targetTouches[0].pageY;
                    clearInterval(v)
                }), f.on("touchmove", function(u) {
                    var o, f, e;
                    if (s > c && 0 !== c) return !1;
                    o = u.originalEvent;
                    t = o.targetTouches[0];
                    f = Math.abs(t.pageX - n.pageX);
                    e = Math.abs(t.pageY - n.pageY);
                    r.vertical === !0 ? (3 * e > f && u.preventDefault(), i.touchMove(t.pageY, n.pageY)) : (3 * f > e && u.preventDefault(), i.touchMove(t.pageX, n.pageX))
                }), f.on("touchend", function() {
                    if (s > c && 0 !== c) return !1;
                    var u;
                    u = r.vertical === !0 ? t.pageY - n.pageY : t.pageX - n.pageX;
                    i.touchEnd(u)
                }))
            },
            build: function() {
                var t = this;
                t.initialStyle();
                this.doCss() && (r.enableTouch === !0 && t.enableTouch(), r.enableDrag === !0 && t.enableDrag());
                n(window).on("focus", function() {
                    t.auto()
                });
                n(window).on("blur", function() {
                    clearInterval(v)
                });
                t.pager();
                t.pauseOnHover();
                t.controls();
                t.keyPress()
            }
        }, l.build(), h.init = function() {
            h.chbreakpoint();
            r.vertical === !0 ? (s = r.item > 1 ? r.verticalHeight : o.outerHeight(), f.css("height", s + "px")) : s = f.outerWidth();
            r.loop === !0 && "slide" === r.mode && h.clone();
            h.calL();
            "slide" === r.mode && u.removeClass("lSSlide");
            "slide" === r.mode && (h.calSW(), h.sSW());
            setTimeout(function() {
                "slide" === r.mode && u.addClass("lSSlide")
            }, 1e3);
            r.pager && h.createPager();
            r.adaptiveHeight === !0 && r.vertical === !1 && u.css("height", o.eq(e).outerHeight(!0));
            r.adaptiveHeight === !1 && ("slide" === r.mode ? r.vertical === !1 ? l.setHeight(u, !1) : l.auto() : l.setHeight(u, !0));
            r.gallery === !0 && l.slideThumb();
            "slide" === r.mode && l.slide();
            r.autoWidth === !1 ? o.length <= r.item ? f.find(".lSAction").hide() : f.find(".lSAction").show() : h.calWidth(!1) < s && 0 !== c ? f.find(".lSAction").hide() : f.find(".lSAction").show()
        }, u.goToPrevSlide = function() {
            if (e > 0) r.onBeforePrevSlide.call(this, u, e), e--, u.mode(!1), r.gallery === !0 && l.slideThumb();
            else if (r.loop === !0) {
                if (r.onBeforePrevSlide.call(this, u, e), "fade" === r.mode) {
                    var n = w - 1;
                    e = parseInt(n / r.slideMove)
                }
                u.mode(!1);
                r.gallery === !0 && l.slideThumb()
            } else r.slideEndAnimation === !0 && (u.addClass("leftEnd"), setTimeout(function() {
                u.removeClass("leftEnd")
            }, 400))
        }, u.goToNextSlide = function() {
            var n = !0,
                t;
            "slide" === r.mode && (t = l.slideValue(), n = t < c - s - r.slideMargin);
            e * r.slideMove < w - r.slideMove && n ? (r.onBeforeNextSlide.call(this, u, e), e++, u.mode(!1), r.gallery === !0 && l.slideThumb()) : r.loop === !0 ? (r.onBeforeNextSlide.call(this, u, e), e = 0, u.mode(!1), r.gallery === !0 && l.slideThumb()) : r.slideEndAnimation === !0 && (u.addClass("rightEnd"), setTimeout(function() {
                u.removeClass("rightEnd")
            }, 400))
        }, u.mode = function(n) {
            r.adaptiveHeight === !0 && r.vertical === !1 && u.css("height", o.eq(e).outerHeight(!0));
            nt === !1 && ("slide" === r.mode ? l.doCss() && (u.addClass("lSSlide"), "" !== r.speed && f.css("transition-duration", r.speed + "ms"), "" !== r.cssEasing && f.css("transition-timing-function", r.cssEasing)) : l.doCss() && ("" !== r.speed && u.css("transition-duration", r.speed + "ms"), "" !== r.cssEasing && u.css("transition-timing-function", r.cssEasing)));
            n || r.onBeforeSlide.call(this, u, e);
            "slide" === r.mode ? l.slide() : l.fade();
            f.hasClass("ls-hover") || l.auto();
            setTimeout(function() {
                n || r.onAfterSlide.call(this, u, e)
            }, r.speed);
            nt = !0
        }, u.play = function() {
            u.goToNextSlide();
            r.auto = !0;
            l.auto()
        }, u.pause = function() {
            r.auto = !1;
            clearInterval(v)
        }, u.refresh = function() {
            h.init()
        }, u.getCurrentSlideCount = function() {
            var i = e,
                t, n;
            return r.loop && (t = f.find(".lslide").length, n = u.find(".clone.left").length, i = n - 1 >= e ? t + (e - n) : e >= t + n ? e - t - n : e - n), i + 1
        }, u.getTotalSlideCount = function() {
            return f.find(".lslide").length
        }, u.goToSlide = function(n) {
            e = r.loop ? n + u.find(".clone.left").length - 1 : n;
            u.mode(!1);
            r.gallery === !0 && l.slideThumb()
        }, u.destroy = function() {
            u.lightSlider && (u.goToPrevSlide = function() {}, u.goToNextSlide = function() {}, u.mode = function() {}, u.play = function() {}, u.pause = function() {}, u.refresh = function() {}, u.getCurrentSlideCount = function() {}, u.getTotalSlideCount = function() {}, u.goToSlide = function() {}, u.lightSlider = null, h = {
                init: function() {}
            }, u.parent().parent().find(".lSAction, .lSPager").remove(), u.removeClass("lightSlider lSFade lSSlide lsGrab lsGrabbing leftEnd right").removeAttr("style").unwrap().unwrap(), u.children().removeAttr("style"), o.removeClass("lslide active"), u.find(".clone").remove(), o = null, v = null, nt = !1, e = 0)
        }, setTimeout(function() {
            r.onSliderLoad.call(this, u)
        }, 10), n(window).on("resize orientationchange", function(n) {
            setTimeout(function() {
                n.preventDefault ? n.preventDefault() : n.returnValue = !1;
                h.init()
            }, 200)
        }), this
    }
}(jQuery);
! function(n, t) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : n.moment = t()
}(this, function() {
    "use strict";

    function t() {
        return ke.apply(null, arguments)
    }

    function ns(n) {
        ke = n
    }

    function tt(n) {
        return n instanceof Array || "[object Array]" === Object.prototype.toString.call(n)
    }

    function hi(n) {
        return null != n && "[object Object]" === Object.prototype.toString.call(n)
    }

    function ts(n) {
        if (Object.getOwnPropertyNames) return 0 === Object.getOwnPropertyNames(n).length;
        var t;
        for (t in n)
            if (n.hasOwnProperty(t)) return !1;
        return !0
    }

    function p(n) {
        return void 0 === n
    }

    function dt(n) {
        return "number" == typeof n || "[object Number]" === Object.prototype.toString.call(n)
    }

    function gi(n) {
        return n instanceof Date || "[object Date]" === Object.prototype.toString.call(n)
    }

    function of (n, t) {
        for (var r = [], i = 0; i < n.length; ++i) r.push(t(n[i], i));
        return r
    }

    function l(n, t) {
        return Object.prototype.hasOwnProperty.call(n, t)
    }

    function vt(n, t) {
        for (var i in t) l(t, i) && (n[i] = t[i]);
        return l(t, "toString") && (n.toString = t.toString), l(t, "valueOf") && (n.valueOf = t.valueOf), n
    }

    function ft(n, t, i, r) {
        return re(n, t, i, r, !0).utc()
    }

    function is() {
        return {
            empty: !1,
            unusedTokens: [],
            unusedInput: [],
            overflow: -2,
            charsLeftOver: 0,
            nullInput: !1,
            invalidMonth: null,
            invalidFormat: !1,
            userInvalidated: !1,
            iso: !1,
            parsedDateParts: [],
            meridiem: null,
            rfc2822: !1,
            weekdayMismatch: !1
        }
    }

    function u(n) {
        return null == n._pf && (n._pf = is()), n._pf
    }

    function kr(n) {
        if (null == n._isValid) {
            var t = u(n),
                r = de.call(t.parsedDateParts, function(n) {
                    return null != n
                }),
                i = !isNaN(n._d.getTime()) && t.overflow < 0 && !t.empty && !t.invalidMonth && !t.invalidWeekday && !t.weekdayMismatch && !t.nullInput && !t.invalidFormat && !t.userInvalidated && (!t.meridiem || t.meridiem && r);
            if (n._strict && (i = i && 0 === t.charsLeftOver && 0 === t.unusedTokens.length && void 0 === t.bigHour), null != Object.isFrozen && Object.isFrozen(n)) return i;
            n._isValid = i
        }
        return n._isValid
    }

    function nr(n) {
        var t = ft(NaN);
        return null != n ? vt(u(t), n) : u(t).userInvalidated = !0, t
    }

    function dr(n, t) {
        var i, r, f;
        if (p(t._isAMomentObject) || (n._isAMomentObject = t._isAMomentObject), p(t._i) || (n._i = t._i), p(t._f) || (n._f = t._f), p(t._l) || (n._l = t._l), p(t._strict) || (n._strict = t._strict), p(t._tzm) || (n._tzm = t._tzm), p(t._isUTC) || (n._isUTC = t._isUTC), p(t._offset) || (n._offset = t._offset), p(t._pf) || (n._pf = u(t)), p(t._locale) || (n._locale = t._locale), pu.length > 0)
            for (i = 0; i < pu.length; i++) r = pu[i], f = t[r], p(f) || (n[r] = f);
        return n
    }

    function ci(n) {
        dr(this, n);
        this._d = new Date(null != n._d ? n._d.getTime() : NaN);
        this.isValid() || (this._d = new Date(NaN));
        wu === !1 && (wu = !0, t.updateOffset(this), wu = !1)
    }

    function yt(n) {
        return n instanceof ci || null != n && null != n._isAMomentObject
    }

    function d(n) {
        return n < 0 ? Math.ceil(n) || 0 : Math.floor(n)
    }

    function f(n) {
        var t = +n,
            i = 0;
        return 0 !== t && isFinite(t) && (i = d(t)), i
    }

    function sf(n, t, i) {
        for (var e = Math.min(n.length, t.length), o = Math.abs(n.length - t.length), u = 0, r = 0; r < e; r++)(i && n[r] !== t[r] || !i && f(n[r]) !== f(t[r])) && u++;
        return u + o
    }

    function hf(n) {
        t.suppressDeprecationWarnings === !1 && "undefined" != typeof console && console.warn && console.warn("Deprecation warning: " + n)
    }

    function g(n, i) {
        var r = !0;
        return vt(function() {
            var u, e, f, o;
            if (null != t.deprecationHandler && t.deprecationHandler(null, n), r) {
                for (e = [], f = 0; f < arguments.length; f++) {
                    if (u = "", "object" == typeof arguments[f]) {
                        u += "\n[" + f + "] ";
                        for (o in arguments[0]) u += o + ": " + arguments[0][o] + ", ";
                        u = u.slice(0, -2)
                    } else u = arguments[f];
                    e.push(u)
                }
                hf(n + "\nArguments: " + Array.prototype.slice.call(e).join("") + "\n" + (new Error).stack);
                r = !1
            }
            return i.apply(this, arguments)
        }, i)
    }

    function cf(n, i) {
        null != t.deprecationHandler && t.deprecationHandler(n, i);
        ge[n] || (hf(i), ge[n] = !0)
    }

    function et(n) {
        return n instanceof Function || "[object Function]" === Object.prototype.toString.call(n)
    }

    function rs(n) {
        var t, i;
        for (i in n) t = n[i], et(t) ? this[i] = t : this["_" + i] = t;
        this._config = n;
        this._dayOfMonthOrdinalParseLenient = new RegExp((this._dayOfMonthOrdinalParse.source || this._ordinalParse.source) + "|" + /\d{1,2}/.source)
    }

    function lf(n, t) {
        var i, r = vt({}, n);
        for (i in t) l(t, i) && (hi(n[i]) && hi(t[i]) ? (r[i] = {}, vt(r[i], n[i]), vt(r[i], t[i])) : null != t[i] ? r[i] = t[i] : delete r[i]);
        for (i in n) l(n, i) && !l(t, i) && hi(n[i]) && (r[i] = vt({}, r[i]));
        return r
    }

    function gr(n) {
        null != n && this.set(n)
    }

    function us(n, t, i) {
        var r = this._calendar[n] || this._calendar.sameElse;
        return et(r) ? r.call(t, i) : r
    }

    function fs(n) {
        var t = this._longDateFormat[n],
            i = this._longDateFormat[n.toUpperCase()];
        return t || !i ? t : (this._longDateFormat[n] = i.replace(/MMMM|MM|DD|dddd/g, function(n) {
            return n.slice(1)
        }), this._longDateFormat[n])
    }

    function es() {
        return this._invalidDate
    }

    function os(n) {
        return this._ordinal.replace("%d", n)
    }

    function ss(n, t, i, r) {
        var u = this._relativeTime[i];
        return et(u) ? u(n, t, i, r) : u.replace(/%d/i, n)
    }

    function hs(n, t) {
        var i = this._relativeTime[n > 0 ? "future" : "past"];
        return et(i) ? i(t) : i.replace(/%s/i, t)
    }

    function w(n, t) {
        var i = n.toLowerCase();
        pi[i] = pi[i + "s"] = pi[t] = n
    }

    function nt(n) {
        if ("string" == typeof n) return pi[n] || pi[n.toLowerCase()]
    }

    function nu(n) {
        var i, t, r = {};
        for (t in n) l(n, t) && (i = nt(t), i && (r[i] = n[t]));
        return r
    }

    function b(n, t) {
        to[n] = t
    }

    function cs(n) {
        var t = [],
            i;
        for (i in n) t.push({
            unit: i,
            priority: to[i]
        });
        return t.sort(function(n, t) {
            return n.priority - t.priority
        }), t
    }

    function ht(n, t, i) {
        var r = "" + Math.abs(n),
            u = t - r.length,
            f = n >= 0;
        return (f ? i ? "+" : "" : "-") + Math.pow(10, Math.max(0, u)).toString().substr(1) + r
    }

    function r(n, t, i, r) {
        var u = r;
        "string" == typeof r && (u = function() {
            return this[r]()
        });
        n && (si[n] = u);
        t && (si[t[0]] = function() {
            return ht(u.apply(this, arguments), t[1], t[2])
        });
        i && (si[i] = function() {
            return this.localeData().ordinal(u.apply(this, arguments), n)
        })
    }

    function ls(n) {
        return n.match(/\[[\s\S]/) ? n.replace(/^\[|\]$/g, "") : n.replace(/\\/g, "")
    }

    function as(n) {
        for (var t = n.match(io), i = 0, r = t.length; i < r; i++) t[i] = si[t[i]] ? si[t[i]] : ls(t[i]);
        return function(i) {
            for (var f = "", u = 0; u < r; u++) f += et(t[u]) ? t[u].call(i, n) : t[u];
            return f
        }
    }

    function tr(n, t) {
        return n.isValid() ? (t = af(t, n.localeData()), bu[t] = bu[t] || as(t), bu[t](n)) : n.localeData().invalidDate()
    }

    function af(n, t) {
        function r(n) {
            return t.longDateFormat(n) || n
        }
        var i = 5;
        for (lr.lastIndex = 0; i >= 0 && lr.test(n);) n = n.replace(lr, r), lr.lastIndex = 0, i -= 1;
        return n
    }

    function i(n, t, i) {
        gu[n] = et(t) ? t : function(n) {
            return n && i ? i : t
        }
    }

    function vs(n, t) {
        return l(gu, n) ? gu[n](t._strict, t._locale) : new RegExp(ys(n))
    }

    function ys(n) {
        return gt(n.replace("\\", "").replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g, function(n, t, i, r, u) {
            return t || i || r || u
        }))
    }

    function gt(n) {
        return n.replace(/[-\/\\^$*+?.()|[\]{}]/g, "\\$&")
    }

    function s(n, t) {
        var i, r = t;
        for ("string" == typeof n && (n = [n]), dt(t) && (r = function(n, i) {
                i[t] = f(n)
            }), i = 0; i < n.length; i++) nf[n[i]] = r
    }

    function li(n, t) {
        s(n, function(n, i, r, u) {
            r._w = r._w || {};
            t(n, r._w, r, u)
        })
    }

    function ps(n, t, i) {
        null != t && l(nf, n) && nf[n](t, i._a, i, n)
    }

    function ai(n) {
        return ir(n) ? 366 : 365
    }

    function ir(n) {
        return n % 4 == 0 && n % 100 != 0 || n % 400 == 0
    }

    function ws() {
        return ir(this.year())
    }

    function ui(n, i) {
        return function(r) {
            return null != r ? (vf(this, n, r), t.updateOffset(this, i), this) : rr(this, n)
        }
    }

    function rr(n, t) {
        return n.isValid() ? n._d["get" + (n._isUTC ? "UTC" : "") + t]() : NaN
    }

    function vf(n, t, i) {
        n.isValid() && !isNaN(i) && ("FullYear" === t && ir(n.year()) && 1 === n.month() && 29 === n.date() ? n._d["set" + (n._isUTC ? "UTC" : "") + t](i, n.month(), ur(i, n.month())) : n._d["set" + (n._isUTC ? "UTC" : "") + t](i))
    }

    function bs(n) {
        return n = nt(n), et(this[n]) ? this[n]() : this
    }

    function ks(n, t) {
        if ("object" == typeof n) {
            n = nu(n);
            for (var r = cs(n), i = 0; i < r.length; i++) this[r[i].unit](n[r[i].unit])
        } else if (n = nt(n), et(this[n])) return this[n](t);
        return this
    }

    function ds(n, t) {
        return (n % t + t) % t
    }

    function ur(n, t) {
        if (isNaN(n) || isNaN(t)) return NaN;
        var i = ds(t, 12);
        return n += (t - i) / 12, 1 === i ? ir(n) ? 29 : 28 : 31 - i % 7 % 2
    }

    function gs(n, t) {
        return n ? tt(this._months) ? this._months[n.month()] : this._months[(this._months.isFormat || oo).test(t) ? "format" : "standalone"][n.month()] : tt(this._months) ? this._months : this._months.standalone
    }

    function nh(n, t) {
        return n ? tt(this._monthsShort) ? this._monthsShort[n.month()] : this._monthsShort[oo.test(t) ? "format" : "standalone"][n.month()] : tt(this._monthsShort) ? this._monthsShort : this._monthsShort.standalone
    }

    function th(n, t, i) {
        var u, r, e, f = n.toLocaleLowerCase();
        if (!this._monthsParse)
            for (this._monthsParse = [], this._longMonthsParse = [], this._shortMonthsParse = [], u = 0; u < 12; ++u) e = ft([2e3, u]), this._shortMonthsParse[u] = this.monthsShort(e, "").toLocaleLowerCase(), this._longMonthsParse[u] = this.months(e, "").toLocaleLowerCase();
        return i ? "MMM" === t ? (r = a.call(this._shortMonthsParse, f), r !== -1 ? r : null) : (r = a.call(this._longMonthsParse, f), r !== -1 ? r : null) : "MMM" === t ? (r = a.call(this._shortMonthsParse, f), r !== -1 ? r : (r = a.call(this._longMonthsParse, f), r !== -1 ? r : null)) : (r = a.call(this._longMonthsParse, f), r !== -1 ? r : (r = a.call(this._shortMonthsParse, f), r !== -1 ? r : null))
    }

    function ih(n, t, i) {
        var r, u, f;
        if (this._monthsParseExact) return th.call(this, n, t, i);
        for (this._monthsParse || (this._monthsParse = [], this._longMonthsParse = [], this._shortMonthsParse = []), r = 0; r < 12; r++)
            if ((u = ft([2e3, r]), i && !this._longMonthsParse[r] && (this._longMonthsParse[r] = new RegExp("^" + this.months(u, "").replace(".", "") + "$", "i"), this._shortMonthsParse[r] = new RegExp("^" + this.monthsShort(u, "").replace(".", "") + "$", "i")), i || this._monthsParse[r] || (f = "^" + this.months(u, "") + "|^" + this.monthsShort(u, ""), this._monthsParse[r] = new RegExp(f.replace(".", ""), "i")), i && "MMMM" === t && this._longMonthsParse[r].test(n)) || i && "MMM" === t && this._shortMonthsParse[r].test(n) || !i && this._monthsParse[r].test(n)) return r
    }

    function yf(n, t) {
        var i;
        if (!n.isValid()) return n;
        if ("string" == typeof t)
            if (/^\d+$/.test(t)) t = f(t);
            else if (t = n.localeData().monthsParse(t), !dt(t)) return n;
        return i = Math.min(n.date(), ur(n.year(), t)), n._d["set" + (n._isUTC ? "UTC" : "") + "Month"](t, i), n
    }

    function pf(n) {
        return null != n ? (yf(this, n), t.updateOffset(this, !0), this) : rr(this, "Month")
    }

    function rh() {
        return ur(this.year(), this.month())
    }

    function uh(n) {
        return this._monthsParseExact ? (l(this, "_monthsRegex") || wf.call(this), n ? this._monthsShortStrictRegex : this._monthsShortRegex) : (l(this, "_monthsShortRegex") || (this._monthsShortRegex = gy), this._monthsShortStrictRegex && n ? this._monthsShortStrictRegex : this._monthsShortRegex)
    }

    function fh(n) {
        return this._monthsParseExact ? (l(this, "_monthsRegex") || wf.call(this), n ? this._monthsStrictRegex : this._monthsRegex) : (l(this, "_monthsRegex") || (this._monthsRegex = np), this._monthsStrictRegex && n ? this._monthsStrictRegex : this._monthsRegex)
    }

    function wf() {
        function f(n, t) {
            return t.length - n.length
        }
        for (var i, r = [], u = [], t = [], n = 0; n < 12; n++) i = ft([2e3, n]), r.push(this.monthsShort(i, "")), u.push(this.months(i, "")), t.push(this.months(i, "")), t.push(this.monthsShort(i, ""));
        for (r.sort(f), u.sort(f), t.sort(f), n = 0; n < 12; n++) r[n] = gt(r[n]), u[n] = gt(u[n]);
        for (n = 0; n < 24; n++) t[n] = gt(t[n]);
        this._monthsRegex = new RegExp("^(" + t.join("|") + ")", "i");
        this._monthsShortRegex = this._monthsRegex;
        this._monthsStrictRegex = new RegExp("^(" + u.join("|") + ")", "i");
        this._monthsShortStrictRegex = new RegExp("^(" + r.join("|") + ")", "i")
    }

    function eh(n, t, i, r, u, f, e) {
        var o = new Date(n, t, i, r, u, f, e);
        return n < 100 && n >= 0 && isFinite(o.getFullYear()) && o.setFullYear(n), o
    }

    function vi(n) {
        var t = new Date(Date.UTC.apply(null, arguments));
        return n < 100 && n >= 0 && isFinite(t.getUTCFullYear()) && t.setUTCFullYear(n), t
    }

    function fr(n, t, i) {
        var r = 7 + t - i,
            u = (7 + vi(n, 0, r).getUTCDay() - t) % 7;
        return -u + r - 1
    }

    function bf(n, t, i, r, u) {
        var f, o, s = (7 + i - r) % 7,
            h = fr(n, r, u),
            e = 1 + 7 * (t - 1) + s + h;
        return e <= 0 ? (f = n - 1, o = ai(f) + e) : e > ai(n) ? (f = n + 1, o = e - ai(n)) : (f = n, o = e), {
            year: f,
            dayOfYear: o
        }
    }

    function yi(n, t, i) {
        var f, r, e = fr(n.year(), t, i),
            u = Math.floor((n.dayOfYear() - e - 1) / 7) + 1;
        return u < 1 ? (r = n.year() - 1, f = u + ni(r, t, i)) : u > ni(n.year(), t, i) ? (f = u - ni(n.year(), t, i), r = n.year() + 1) : (r = n.year(), f = u), {
            week: f,
            year: r
        }
    }

    function ni(n, t, i) {
        var r = fr(n, t, i),
            u = fr(n + 1, t, i);
        return (ai(n) - r + u) / 7
    }

    function oh(n) {
        return yi(n, this._week.dow, this._week.doy).week
    }

    function sh() {
        return this._week.dow
    }

    function hh() {
        return this._week.doy
    }

    function ch(n) {
        var t = this.localeData().week(this);
        return null == n ? t : this.add(7 * (n - t), "d")
    }

    function lh(n) {
        var t = yi(this, 1, 4).week;
        return null == n ? t : this.add(7 * (n - t), "d")
    }

    function ah(n, t) {
        return "string" != typeof n ? n : isNaN(n) ? (n = t.weekdaysParse(n), "number" == typeof n ? n : null) : parseInt(n, 10)
    }

    function vh(n, t) {
        return "string" == typeof n ? t.weekdaysParse(n) % 7 || 7 : isNaN(n) ? null : n
    }

    function yh(n, t) {
        return n ? tt(this._weekdays) ? this._weekdays[n.day()] : this._weekdays[this._weekdays.isFormat.test(t) ? "format" : "standalone"][n.day()] : tt(this._weekdays) ? this._weekdays : this._weekdays.standalone
    }

    function ph(n) {
        return n ? this._weekdaysShort[n.day()] : this._weekdaysShort
    }

    function wh(n) {
        return n ? this._weekdaysMin[n.day()] : this._weekdaysMin
    }

    function bh(n, t, i) {
        var f, r, e, u = n.toLocaleLowerCase();
        if (!this._weekdaysParse)
            for (this._weekdaysParse = [], this._shortWeekdaysParse = [], this._minWeekdaysParse = [], f = 0; f < 7; ++f) e = ft([2e3, 1]).day(f), this._minWeekdaysParse[f] = this.weekdaysMin(e, "").toLocaleLowerCase(), this._shortWeekdaysParse[f] = this.weekdaysShort(e, "").toLocaleLowerCase(), this._weekdaysParse[f] = this.weekdays(e, "").toLocaleLowerCase();
        return i ? "dddd" === t ? (r = a.call(this._weekdaysParse, u), r !== -1 ? r : null) : "ddd" === t ? (r = a.call(this._shortWeekdaysParse, u), r !== -1 ? r : null) : (r = a.call(this._minWeekdaysParse, u), r !== -1 ? r : null) : "dddd" === t ? (r = a.call(this._weekdaysParse, u), r !== -1 ? r : (r = a.call(this._shortWeekdaysParse, u), r !== -1 ? r : (r = a.call(this._minWeekdaysParse, u), r !== -1 ? r : null))) : "ddd" === t ? (r = a.call(this._shortWeekdaysParse, u), r !== -1 ? r : (r = a.call(this._weekdaysParse, u), r !== -1 ? r : (r = a.call(this._minWeekdaysParse, u), r !== -1 ? r : null))) : (r = a.call(this._minWeekdaysParse, u), r !== -1 ? r : (r = a.call(this._weekdaysParse, u), r !== -1 ? r : (r = a.call(this._shortWeekdaysParse, u), r !== -1 ? r : null)))
    }

    function kh(n, t, i) {
        var r, u, f;
        if (this._weekdaysParseExact) return bh.call(this, n, t, i);
        for (this._weekdaysParse || (this._weekdaysParse = [], this._minWeekdaysParse = [], this._shortWeekdaysParse = [], this._fullWeekdaysParse = []), r = 0; r < 7; r++)
            if ((u = ft([2e3, 1]).day(r), i && !this._fullWeekdaysParse[r] && (this._fullWeekdaysParse[r] = new RegExp("^" + this.weekdays(u, "").replace(".", "\\.?") + "$", "i"), this._shortWeekdaysParse[r] = new RegExp("^" + this.weekdaysShort(u, "").replace(".", "\\.?") + "$", "i"), this._minWeekdaysParse[r] = new RegExp("^" + this.weekdaysMin(u, "").replace(".", "\\.?") + "$", "i")), this._weekdaysParse[r] || (f = "^" + this.weekdays(u, "") + "|^" + this.weekdaysShort(u, "") + "|^" + this.weekdaysMin(u, ""), this._weekdaysParse[r] = new RegExp(f.replace(".", ""), "i")), i && "dddd" === t && this._fullWeekdaysParse[r].test(n)) || i && "ddd" === t && this._shortWeekdaysParse[r].test(n) || i && "dd" === t && this._minWeekdaysParse[r].test(n) || !i && this._weekdaysParse[r].test(n)) return r
    }

    function dh(n) {
        if (!this.isValid()) return null != n ? this : NaN;
        var t = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
        return null != n ? (n = ah(n, this.localeData()), this.add(n - t, "d")) : t
    }

    function gh(n) {
        if (!this.isValid()) return null != n ? this : NaN;
        var t = (this.day() + 7 - this.localeData()._week.dow) % 7;
        return null == n ? t : this.add(n - t, "d")
    }

    function nc(n) {
        if (!this.isValid()) return null != n ? this : NaN;
        if (null != n) {
            var t = vh(n, this.localeData());
            return this.day(this.day() % 7 ? t : t - 7)
        }
        return this.day() || 7
    }

    function tc(n) {
        return this._weekdaysParseExact ? (l(this, "_weekdaysRegex") || tu.call(this), n ? this._weekdaysStrictRegex : this._weekdaysRegex) : (l(this, "_weekdaysRegex") || (this._weekdaysRegex = rp), this._weekdaysStrictRegex && n ? this._weekdaysStrictRegex : this._weekdaysRegex)
    }

    function ic(n) {
        return this._weekdaysParseExact ? (l(this, "_weekdaysRegex") || tu.call(this), n ? this._weekdaysShortStrictRegex : this._weekdaysShortRegex) : (l(this, "_weekdaysShortRegex") || (this._weekdaysShortRegex = up), this._weekdaysShortStrictRegex && n ? this._weekdaysShortStrictRegex : this._weekdaysShortRegex)
    }

    function rc(n) {
        return this._weekdaysParseExact ? (l(this, "_weekdaysRegex") || tu.call(this), n ? this._weekdaysMinStrictRegex : this._weekdaysMinRegex) : (l(this, "_weekdaysMinRegex") || (this._weekdaysMinRegex = fp), this._weekdaysMinStrictRegex && n ? this._weekdaysMinStrictRegex : this._weekdaysMinRegex)
    }

    function tu() {
        function u(n, t) {
            return t.length - n.length
        }
        for (var f, e, o, s, h = [], i = [], r = [], t = [], n = 0; n < 7; n++) f = ft([2e3, 1]).day(n), e = this.weekdaysMin(f, ""), o = this.weekdaysShort(f, ""), s = this.weekdays(f, ""), h.push(e), i.push(o), r.push(s), t.push(e), t.push(o), t.push(s);
        for (h.sort(u), i.sort(u), r.sort(u), t.sort(u), n = 0; n < 7; n++) i[n] = gt(i[n]), r[n] = gt(r[n]), t[n] = gt(t[n]);
        this._weekdaysRegex = new RegExp("^(" + t.join("|") + ")", "i");
        this._weekdaysShortRegex = this._weekdaysRegex;
        this._weekdaysMinRegex = this._weekdaysRegex;
        this._weekdaysStrictRegex = new RegExp("^(" + r.join("|") + ")", "i");
        this._weekdaysShortStrictRegex = new RegExp("^(" + i.join("|") + ")", "i");
        this._weekdaysMinStrictRegex = new RegExp("^(" + h.join("|") + ")", "i")
    }

    function iu() {
        return this.hours() % 12 || 12
    }

    function uc() {
        return this.hours() || 24
    }

    function kf(n, t) {
        r(n, 0, 0, function() {
            return this.localeData().meridiem(this.hours(), this.minutes(), t)
        })
    }

    function df(n, t) {
        return t._meridiemParse
    }

    function fc(n) {
        return "p" === (n + "").toLowerCase().charAt(0)
    }

    function ec(n, t, i) {
        return n > 11 ? i ? "pm" : "PM" : i ? "am" : "AM"
    }

    function gf(n) {
        return n ? n.toLowerCase().replace("_", "-") : n
    }

    function oc(n) {
        for (var i, t, f, r, u = 0; u < n.length;) {
            for (r = gf(n[u]).split("-"), i = r.length, t = gf(n[u + 1]), t = t ? t.split("-") : null; i > 0;) {
                if (f = er(r.slice(0, i).join("-"))) return f;
                if (t && t.length >= i && sf(r, t, !0) >= i - 1) break;
                i--
            }
            u++
        }
        return bi
    }

    function er(n) {
        var t = null,
            i;
        if (!y[n] && "undefined" != typeof module && module && module.exports) try {
            t = bi._abbr;
            i = require;
            i("./locale/" + n);
            fi(t)
        } catch (n) {}
        return y[n]
    }

    function fi(n, t) {
        var i;
        return n && (i = p(t) ? pt(n) : ru(n, t), i ? bi = i : "undefined" != typeof console && console.warn && console.warn("Locale " + n + " not found. Did you forget to load it?")), bi._abbr
    }

    function ru(n, t) {
        if (null !== t) {
            var r, i = lo;
            if (t.abbr = n, null != y[n]) cf("defineLocaleOverride", "use moment.updateLocale(localeName, config) to change an existing locale. moment.defineLocale(localeName, config) should only be used for creating a new locale See http://momentjs.com/guides/#/warnings/define-locale/ for more info."), i = y[n]._config;
            else if (null != t.parentLocale)
                if (null != y[t.parentLocale]) i = y[t.parentLocale]._config;
                else {
                    if (r = er(t.parentLocale), null == r) return ki[t.parentLocale] || (ki[t.parentLocale] = []), ki[t.parentLocale].push({
                        name: n,
                        config: t
                    }), null;
                    i = r._config
                } return y[n] = new gr(lf(i, t)), ki[n] && ki[n].forEach(function(n) {
                ru(n.name, n.config)
            }), fi(n), y[n]
        }
        return delete y[n], null
    }

    function sc(n, t) {
        if (null != t) {
            var i, r, u = lo;
            r = er(n);
            null != r && (u = r._config);
            t = lf(u, t);
            i = new gr(t);
            i.parentLocale = y[n];
            y[n] = i;
            fi(n)
        } else null != y[n] && (null != y[n].parentLocale ? y[n] = y[n].parentLocale : null != y[n] && delete y[n]);
        return y[n]
    }

    function pt(n) {
        var t;
        if (n && n._locale && n._locale._abbr && (n = n._locale._abbr), !n) return bi;
        if (!tt(n)) {
            if (t = er(n)) return t;
            n = [n]
        }
        return oc(n)
    }

    function hc() {
        return no(y)
    }

    function uu(n) {
        var i, t = n._a;
        return t && u(n).overflow === -2 && (i = t[ct] < 0 || t[ct] > 11 ? ct : t[ot] < 1 || t[ot] > ur(t[rt], t[ct]) ? ot : t[v] < 0 || t[v] > 24 || 24 === t[v] && (0 !== t[ut] || 0 !== t[lt] || 0 !== t[ri]) ? v : t[ut] < 0 || t[ut] > 59 ? ut : t[lt] < 0 || t[lt] > 59 ? lt : t[ri] < 0 || t[ri] > 999 ? ri : -1, u(n)._overflowDayOfYear && (i < rt || i > ot) && (i = ot), u(n)._overflowWeeks && i === -1 && (i = by), u(n)._overflowWeekday && i === -1 && (i = ky), u(n).overflow = i), n
    }

    function ei(n, t, i) {
        return null != n ? n : null != t ? t : i
    }

    function cc(n) {
        var i = new Date(t.now());
        return n._useUTC ? [i.getUTCFullYear(), i.getUTCMonth(), i.getUTCDate()] : [i.getFullYear(), i.getMonth(), i.getDate()]
    }

    function fu(n) {
        var t, i, r, o, f, e = [];
        if (!n._d) {
            for (r = cc(n), n._w && null == n._a[ot] && null == n._a[ct] && lc(n), null != n._dayOfYear && (f = ei(n._a[rt], r[rt]), (n._dayOfYear > ai(f) || 0 === n._dayOfYear) && (u(n)._overflowDayOfYear = !0), i = vi(f, 0, n._dayOfYear), n._a[ct] = i.getUTCMonth(), n._a[ot] = i.getUTCDate()), t = 0; t < 3 && null == n._a[t]; ++t) n._a[t] = e[t] = r[t];
            for (; t < 7; t++) n._a[t] = e[t] = null == n._a[t] ? 2 === t ? 1 : 0 : n._a[t];
            24 === n._a[v] && 0 === n._a[ut] && 0 === n._a[lt] && 0 === n._a[ri] && (n._nextDay = !0, n._a[v] = 0);
            n._d = (n._useUTC ? vi : eh).apply(null, e);
            o = n._useUTC ? n._d.getUTCDay() : n._d.getDay();
            null != n._tzm && n._d.setUTCMinutes(n._d.getUTCMinutes() - n._tzm);
            n._nextDay && (n._a[v] = 24);
            n._w && "undefined" != typeof n._w.d && n._w.d !== o && (u(n).weekdayMismatch = !0)
        }
    }

    function lc(n) {
        var t, o, f, i, r, e, h, s, l;
        (t = n._w, null != t.GG || null != t.W || null != t.E) ? (r = 1, e = 4, o = ei(t.GG, n._a[rt], yi(c(), 1, 4).year), f = ei(t.W, 1), i = ei(t.E, 1), (i < 1 || i > 7) && (s = !0)) : (r = n._locale._week.dow, e = n._locale._week.doy, l = yi(c(), r, e), o = ei(t.gg, n._a[rt], l.year), f = ei(t.w, l.week), null != t.d ? (i = t.d, (i < 0 || i > 6) && (s = !0)) : null != t.e ? (i = t.e + r, (t.e < 0 || t.e > 6) && (s = !0)) : i = r);
        f < 1 || f > ni(o, r, e) ? u(n)._overflowWeeks = !0 : null != s ? u(n)._overflowWeekday = !0 : (h = bf(o, f, i, r, e), n._a[rt] = h.year, n._dayOfYear = h.dayOfYear)
    }

    function ne(n) {
        var t, r, o, e, f, s, h = n._i,
            i = op.exec(h) || sp.exec(h);
        if (i) {
            for (u(n).iso = !0, t = 0, r = br.length; t < r; t++)
                if (br[t][1].exec(i[1])) {
                    e = br[t][0];
                    o = br[t][2] !== !1;
                    break
                } if (null == e) return void(n._isValid = !1);
            if (i[3]) {
                for (t = 0, r = rf.length; t < r; t++)
                    if (rf[t][1].exec(i[3])) {
                        f = (i[2] || " ") + rf[t][0];
                        break
                    } if (null == f) return void(n._isValid = !1)
            }
            if (!o && null != f) return void(n._isValid = !1);
            if (i[4]) {
                if (!hp.exec(i[4])) return void(n._isValid = !1);
                s = "Z"
            }
            n._f = e + (f || "") + (s || "");
            eu(n)
        } else n._isValid = !1
    }

    function ac(n, t, i, r, u, f) {
        var e = [vc(n), so.indexOf(t), parseInt(i, 10), parseInt(r, 10), parseInt(u, 10)];
        return f && e.push(parseInt(f, 10)), e
    }

    function vc(n) {
        var t = parseInt(n, 10);
        return t <= 49 ? 2e3 + t : t <= 999 ? 1900 + t : t
    }

    function yc(n) {
        return n.replace(/\([^)]*\)|[\n\t]/g, " ").replace(/(\s\s+)/g, " ").replace(/^\s\s*/, "").replace(/\s\s*$/, "")
    }

    function pc(n, t, i) {
        if (n) {
            var r = co.indexOf(n),
                f = new Date(t[0], t[1], t[2]).getDay();
            if (r !== f) return u(i).weekdayMismatch = !0, i._isValid = !1, !1
        }
        return !0
    }

    function wc(n, t, i) {
        if (n) return ap[n];
        if (t) return 0;
        var r = parseInt(i, 10),
            u = r % 100,
            f = (r - u) / 100;
        return 60 * f + u
    }

    function te(n) {
        var t = lp.exec(yc(n._i)),
            i;
        if (t) {
            if (i = ac(t[4], t[3], t[2], t[5], t[6], t[7]), !pc(t[1], i, n)) return;
            n._a = i;
            n._tzm = wc(t[8], t[9], t[10]);
            n._d = vi.apply(null, n._a);
            n._d.setUTCMinutes(n._d.getUTCMinutes() - n._tzm);
            u(n).rfc2822 = !0
        } else n._isValid = !1
    }

    function bc(n) {
        var i = cp.exec(n._i);
        return null !== i ? void(n._d = new Date(+i[1])) : (ne(n), void(n._isValid === !1 && (delete n._isValid, te(n), n._isValid === !1 && (delete n._isValid, t.createFromInputFallback(n)))))
    }

    function eu(n) {
        if (n._f === t.ISO_8601) return void ne(n);
        if (n._f === t.RFC_2822) return void te(n);
        n._a = [];
        u(n).empty = !0;
        for (var i, f, s, r = "" + n._i, c = r.length, h = 0, o = af(n._f, n._locale).match(io) || [], e = 0; e < o.length; e++) f = o[e], i = (r.match(vs(f, n)) || [])[0], i && (s = r.substr(0, r.indexOf(i)), s.length > 0 && u(n).unusedInput.push(s), r = r.slice(r.indexOf(i) + i.length), h += i.length), si[f] ? (i ? u(n).empty = !1 : u(n).unusedTokens.push(f), ps(f, i, n)) : n._strict && !i && u(n).unusedTokens.push(f);
        u(n).charsLeftOver = c - h;
        r.length > 0 && u(n).unusedInput.push(r);
        n._a[v] <= 12 && u(n).bigHour === !0 && n._a[v] > 0 && (u(n).bigHour = void 0);
        u(n).parsedDateParts = n._a.slice(0);
        u(n).meridiem = n._meridiem;
        n._a[v] = kc(n._locale, n._a[v], n._meridiem);
        fu(n);
        uu(n)
    }

    function kc(n, t, i) {
        var r;
        return null == i ? t : null != n.meridiemHour ? n.meridiemHour(t, i) : null != n.isPM ? (r = n.isPM(i), r && t < 12 && (t += 12), r || 12 !== t || (t = 0), t) : t
    }

    function dc(n) {
        var t, e, f, r, i;
        if (0 === n._f.length) return u(n).invalidFormat = !0, void(n._d = new Date(NaN));
        for (r = 0; r < n._f.length; r++) i = 0, t = dr({}, n), null != n._useUTC && (t._useUTC = n._useUTC), t._f = n._f[r], eu(t), kr(t) && (i += u(t).charsLeftOver, i += 10 * u(t).unusedTokens.length, u(t).score = i, (null == f || i < f) && (f = i, e = t));
        vt(n, e || t)
    }

    function gc(n) {
        if (!n._d) {
            var t = nu(n._i);
            n._a = of ([t.year, t.month, t.day || t.date, t.hour, t.minute, t.second, t.millisecond], function(n) {
                return n && parseInt(n, 10)
            });
            fu(n)
        }
    }

    function nl(n) {
        var t = new ci(uu(ie(n)));
        return t._nextDay && (t.add(1, "d"), t._nextDay = void 0), t
    }

    function ie(n) {
        var t = n._i,
            i = n._f;
        return n._locale = n._locale || pt(n._l), null === t || void 0 === i && "" === t ? nr({
            nullInput: !0
        }) : ("string" == typeof t && (n._i = t = n._locale.preparse(t)), yt(t) ? new ci(uu(t)) : (gi(t) ? n._d = t : tt(i) ? dc(n) : i ? eu(n) : tl(n), kr(n) || (n._d = null), n))
    }

    function tl(n) {
        var i = n._i;
        p(i) ? n._d = new Date(t.now()) : gi(i) ? n._d = new Date(i.valueOf()) : "string" == typeof i ? bc(n) : tt(i) ? (n._a = of (i.slice(0), function(n) {
            return parseInt(n, 10)
        }), fu(n)) : hi(i) ? gc(n) : dt(i) ? n._d = new Date(i) : t.createFromInputFallback(n)
    }

    function re(n, t, i, r, u) {
        var f = {};
        return i !== !0 && i !== !1 || (r = i, i = void 0), (hi(n) && ts(n) || tt(n) && 0 === n.length) && (n = void 0), f._isAMomentObject = !0, f._useUTC = f._isUTC = u, f._l = i, f._i = n, f._f = t, f._strict = r, nl(f)
    }

    function c(n, t, i, r) {
        return re(n, t, i, r, !1)
    }

    function ue(n, t) {
        var r, i;
        if (1 === t.length && tt(t[0]) && (t = t[0]), !t.length) return c();
        for (r = t[0], i = 1; i < t.length; ++i) t[i].isValid() && !t[i][n](r) || (r = t[i]);
        return r
    }

    function il() {
        var n = [].slice.call(arguments, 0);
        return ue("isBefore", n)
    }

    function rl() {
        var n = [].slice.call(arguments, 0);
        return ue("isAfter", n)
    }

    function ul(n) {
        var i, r, t;
        for (i in n)
            if (a.call(di, i) === -1 || null != n[i] && isNaN(n[i])) return !1;
        for (r = !1, t = 0; t < di.length; ++t)
            if (n[di[t]]) {
                if (r) return !1;
                parseFloat(n[di[t]]) !== f(n[di[t]]) && (r = !0)
            } return !0
    }

    function fl() {
        return this._isValid
    }

    function el() {
        return it(NaN)
    }

    function or(n) {
        var t = nu(n),
            i = t.year || 0,
            r = t.quarter || 0,
            u = t.month || 0,
            f = t.week || 0,
            e = t.day || 0,
            o = t.hour || 0,
            s = t.minute || 0,
            h = t.second || 0,
            c = t.millisecond || 0;
        this._isValid = ul(t);
        this._milliseconds = +c + 1e3 * h + 6e4 * s + 36e5 * o;
        this._days = +e + 7 * f;
        this._months = +u + 3 * r + 12 * i;
        this._data = {};
        this._locale = pt();
        this._bubble()
    }

    function ou(n) {
        return n instanceof or
    }

    function su(n) {
        return n < 0 ? Math.round(-1 * n) * -1 : Math.round(n)
    }

    function fe(n, t) {
        r(n, 0, 0, function() {
            var n = this.utcOffset(),
                i = "+";
            return n < 0 && (n = -n, i = "-"), i + ht(~~(n / 60), 2) + t + ht(~~n % 60, 2)
        })
    }

    function hu(n, t) {
        var i = (t || "").match(n);
        if (null === i) return null;
        var e = i[i.length - 1] || [],
            r = (e + "").match(ao) || ["-", 0, 0],
            u = +(60 * r[1]) + f(r[2]);
        return 0 === u ? 0 : "+" === r[0] ? u : -u
    }

    function cu(n, i) {
        var r, u;
        return i._isUTC ? (r = i.clone(), u = (yt(n) || gi(n) ? n.valueOf() : c(n).valueOf()) - r.valueOf(), r._d.setTime(r._d.valueOf() + u), t.updateOffset(r, !1), r) : c(n).local()
    }

    function lu(n) {
        return 15 * -Math.round(n._d.getTimezoneOffset() / 15)
    }

    function ol(n, i, r) {
        var u, f = this._offset || 0;
        if (!this.isValid()) return null != n ? this : NaN;
        if (null != n) {
            if ("string" == typeof n) {
                if (n = hu(wr, n), null === n) return this
            } else Math.abs(n) < 16 && !r && (n = 60 * n);
            return !this._isUTC && i && (u = lu(this)), this._offset = n, this._isUTC = !0, null != u && this.add(u, "m"), f !== n && (!i || this._changeInProgress ? he(this, it(n - f, "m"), 1, !1) : this._changeInProgress || (this._changeInProgress = !0, t.updateOffset(this, !0), this._changeInProgress = null)), this
        }
        return this._isUTC ? f : lu(this)
    }

    function sl(n, t) {
        return null != n ? ("string" != typeof n && (n = -n), this.utcOffset(n, t), this) : -this.utcOffset()
    }

    function hl(n) {
        return this.utcOffset(0, n)
    }

    function cl(n) {
        return this._isUTC && (this.utcOffset(0, n), this._isUTC = !1, n && this.subtract(lu(this), "m")), this
    }

    function ll() {
        if (null != this._tzm) this.utcOffset(this._tzm, !1, !0);
        else if ("string" == typeof this._i) {
            var n = hu(wy, this._i);
            null != n ? this.utcOffset(n) : this.utcOffset(0, !0)
        }
        return this
    }

    function al(n) {
        return !!this.isValid() && (n = n ? c(n).utcOffset() : 0, (this.utcOffset() - n) % 60 == 0)
    }

    function vl() {
        return this.utcOffset() > this.clone().month(0).utcOffset() || this.utcOffset() > this.clone().month(5).utcOffset()
    }

    function yl() {
        var n, t;
        return p(this._isDSTShifted) ? (n = {}, (dr(n, this), n = ie(n), n._a) ? (t = n._isUTC ? ft(n._a) : c(n._a), this._isDSTShifted = this.isValid() && sf(n._a, t.toArray()) > 0) : this._isDSTShifted = !1, this._isDSTShifted) : this._isDSTShifted
    }

    function pl() {
        return !!this.isValid() && !this._isUTC
    }

    function wl() {
        return !!this.isValid() && this._isUTC
    }

    function ee() {
        return !!this.isValid() && this._isUTC && 0 === this._offset
    }

    function it(n, t) {
        var u, e, o, i = n,
            r = null;
        return ou(n) ? i = {
            ms: n._milliseconds,
            d: n._days,
            M: n._months
        } : dt(n) ? (i = {}, t ? i[t] = n : i.milliseconds = n) : (r = vo.exec(n)) ? (u = "-" === r[1] ? -1 : 1, i = {
            y: 0,
            d: f(r[ot]) * u,
            h: f(r[v]) * u,
            m: f(r[ut]) * u,
            s: f(r[lt]) * u,
            ms: f(su(1e3 * r[ri])) * u
        }) : (r = yo.exec(n)) ? (u = "-" === r[1] ? -1 : ("+" === r[1], 1), i = {
            y: ti(r[2], u),
            M: ti(r[3], u),
            w: ti(r[4], u),
            d: ti(r[5], u),
            h: ti(r[6], u),
            m: ti(r[7], u),
            s: ti(r[8], u)
        }) : null == i ? i = {} : "object" == typeof i && ("from" in i || "to" in i) && (o = bl(c(i.from), c(i.to)), i = {}, i.ms = o.milliseconds, i.M = o.months), e = new or(i), ou(n) && l(n, "_locale") && (e._locale = n._locale), e
    }

    function ti(n, t) {
        var i = n && parseFloat(n.replace(",", "."));
        return (isNaN(i) ? 0 : i) * t
    }

    function oe(n, t) {
        var i = {
            milliseconds: 0,
            months: 0
        };
        return i.months = t.month() - n.month() + 12 * (t.year() - n.year()), n.clone().add(i.months, "M").isAfter(t) && --i.months, i.milliseconds = +t - +n.clone().add(i.months, "M"), i
    }

    function bl(n, t) {
        var i;
        return n.isValid() && t.isValid() ? (t = cu(t, n), n.isBefore(t) ? i = oe(n, t) : (i = oe(t, n), i.milliseconds = -i.milliseconds, i.months = -i.months), i) : {
            milliseconds: 0,
            months: 0
        }
    }

    function se(n, t) {
        return function(i, r) {
            var u, f;
            return null === r || isNaN(+r) || (cf(t, "moment()." + t + "(period, number) is deprecated. Please use moment()." + t + "(number, period). See http://momentjs.com/guides/#/warnings/add-inverted-param/ for more info."), f = i, i = r, r = f), i = "string" == typeof i ? +i : i, u = it(i, r), he(this, u, n), this
        }
    }

    function he(n, i, r, u) {
        var o = i._milliseconds,
            f = su(i._days),
            e = su(i._months);
        n.isValid() && (u = null == u || u, e && yf(n, rr(n, "Month") + e * r), f && vf(n, "Date", rr(n, "Date") + f * r), o && n._d.setTime(n._d.valueOf() + o * r), u && t.updateOffset(n, f || e))
    }

    function kl(n, t) {
        var i = n.diff(t, "days", !0);
        return i < -6 ? "sameElse" : i < -1 ? "lastWeek" : i < 0 ? "lastDay" : i < 1 ? "sameDay" : i < 2 ? "nextDay" : i < 7 ? "nextWeek" : "sameElse"
    }

    function dl(n, i) {
        var u = n || c(),
            f = cu(u, this).startOf("day"),
            r = t.calendarFormat(this, f) || "sameElse",
            e = i && (et(i[r]) ? i[r].call(this, u) : i[r]);
        return this.format(e || this.localeData().calendar(r, this, c(u)))
    }

    function gl() {
        return new ci(this)
    }

    function na(n, t) {
        var i = yt(n) ? n : c(n);
        return !(!this.isValid() || !i.isValid()) && (t = nt(p(t) ? "millisecond" : t), "millisecond" === t ? this.valueOf() > i.valueOf() : i.valueOf() < this.clone().startOf(t).valueOf())
    }

    function ta(n, t) {
        var i = yt(n) ? n : c(n);
        return !(!this.isValid() || !i.isValid()) && (t = nt(p(t) ? "millisecond" : t), "millisecond" === t ? this.valueOf() < i.valueOf() : this.clone().endOf(t).valueOf() < i.valueOf())
    }

    function ia(n, t, i, r) {
        return r = r || "()", ("(" === r[0] ? this.isAfter(n, i) : !this.isBefore(n, i)) && (")" === r[1] ? this.isBefore(t, i) : !this.isAfter(t, i))
    }

    function ra(n, t) {
        var i, r = yt(n) ? n : c(n);
        return !(!this.isValid() || !r.isValid()) && (t = nt(t || "millisecond"), "millisecond" === t ? this.valueOf() === r.valueOf() : (i = r.valueOf(), this.clone().startOf(t).valueOf() <= i && i <= this.clone().endOf(t).valueOf()))
    }

    function ua(n, t) {
        return this.isSame(n, t) || this.isAfter(n, t)
    }

    function fa(n, t) {
        return this.isSame(n, t) || this.isBefore(n, t)
    }

    function ea(n, t, i) {
        var r, f, u;
        if (!this.isValid()) return NaN;
        if (r = cu(n, this), !r.isValid()) return NaN;
        switch (f = 6e4 * (r.utcOffset() - this.utcOffset()), t = nt(t)) {
            case "year":
                u = au(this, r) / 12;
                break;
            case "month":
                u = au(this, r);
                break;
            case "quarter":
                u = au(this, r) / 3;
                break;
            case "second":
                u = (this - r) / 1e3;
                break;
            case "minute":
                u = (this - r) / 6e4;
                break;
            case "hour":
                u = (this - r) / 36e5;
                break;
            case "day":
                u = (this - r - f) / 864e5;
                break;
            case "week":
                u = (this - r - f) / 6048e5;
                break;
            default:
                u = this - r
        }
        return i ? u : d(u)
    }

    function au(n, t) {
        var r, f, u = 12 * (t.year() - n.year()) + (t.month() - n.month()),
            i = n.clone().add(u, "months");
        return t - i < 0 ? (r = n.clone().add(u - 1, "months"), f = (t - i) / (i - r)) : (r = n.clone().add(u + 1, "months"), f = (t - i) / (r - i)), -(u + f) || 0
    }

    function oa() {
        return this.clone().locale("en").format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ")
    }

    function sa(n) {
        if (!this.isValid()) return null;
        var i = n !== !0,
            t = i ? this.clone().utc() : this;
        return t.year() < 0 || t.year() > 9999 ? tr(t, i ? "YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]" : "YYYYYY-MM-DD[T]HH:mm:ss.SSSZ") : et(Date.prototype.toISOString) ? i ? this.toDate().toISOString() : new Date(this.valueOf() + 6e4 * this.utcOffset()).toISOString().replace("Z", tr(t, "Z")) : tr(t, i ? "YYYY-MM-DD[T]HH:mm:ss.SSS[Z]" : "YYYY-MM-DD[T]HH:mm:ss.SSSZ")
    }

    function ha() {
        var n, t;
        if (!this.isValid()) return "moment.invalid(/* " + this._i + " */)";
        n = "moment";
        t = "";
        this.isLocal() || (n = 0 === this.utcOffset() ? "moment.utc" : "moment.parseZone", t = "Z");
        var i = "[" + n + '("]',
            r = 0 <= this.year() && this.year() <= 9999 ? "YYYY" : "YYYYYY",
            u = t + '[")]';
        return this.format(i + r + "-MM-DD[T]HH:mm:ss.SSS" + u)
    }

    function ca(n) {
        n || (n = this.isUtc() ? t.defaultFormatUtc : t.defaultFormat);
        var i = tr(this, n);
        return this.localeData().postformat(i)
    }

    function la(n, t) {
        return this.isValid() && (yt(n) && n.isValid() || c(n).isValid()) ? it({
            to: this,
            from: n
        }).locale(this.locale()).humanize(!t) : this.localeData().invalidDate()
    }

    function aa(n) {
        return this.from(c(), n)
    }

    function va(n, t) {
        return this.isValid() && (yt(n) && n.isValid() || c(n).isValid()) ? it({
            from: this,
            to: n
        }).locale(this.locale()).humanize(!t) : this.localeData().invalidDate()
    }

    function ya(n) {
        return this.to(c(), n)
    }

    function ce(n) {
        var t;
        return void 0 === n ? this._locale._abbr : (t = pt(n), null != t && (this._locale = t), this)
    }

    function le() {
        return this._locale
    }

    function pa(n) {
        switch (n = nt(n)) {
            case "year":
                this.month(0);
            case "quarter":
            case "month":
                this.date(1);
            case "week":
            case "isoWeek":
            case "day":
            case "date":
                this.hours(0);
            case "hour":
                this.minutes(0);
            case "minute":
                this.seconds(0);
            case "second":
                this.milliseconds(0)
        }
        return "week" === n && this.weekday(0), "isoWeek" === n && this.isoWeekday(1), "quarter" === n && this.month(3 * Math.floor(this.month() / 3)), this
    }

    function wa(n) {
        return n = nt(n), void 0 === n || "millisecond" === n ? this : ("date" === n && (n = "day"), this.startOf(n).add(1, "isoWeek" === n ? "week" : n).subtract(1, "ms"))
    }

    function ba() {
        return this._d.valueOf() - 6e4 * (this._offset || 0)
    }

    function ka() {
        return Math.floor(this.valueOf() / 1e3)
    }

    function da() {
        return new Date(this.valueOf())
    }

    function ga() {
        var n = this;
        return [n.year(), n.month(), n.date(), n.hour(), n.minute(), n.second(), n.millisecond()]
    }

    function nv() {
        var n = this;
        return {
            years: n.year(),
            months: n.month(),
            date: n.date(),
            hours: n.hours(),
            minutes: n.minutes(),
            seconds: n.seconds(),
            milliseconds: n.milliseconds()
        }
    }

    function tv() {
        return this.isValid() ? this.toISOString() : null
    }

    function iv() {
        return kr(this)
    }

    function rv() {
        return vt({}, u(this))
    }

    function uv() {
        return u(this).overflow
    }

    function fv() {
        return {
            input: this._i,
            format: this._f,
            locale: this._locale,
            isUTC: this._isUTC,
            strict: this._strict
        }
    }

    function sr(n, t) {
        r(0, [n, n.length], 0, t)
    }

    function ev(n) {
        return ae.call(this, n, this.week(), this.weekday(), this.localeData()._week.dow, this.localeData()._week.doy)
    }

    function ov(n) {
        return ae.call(this, n, this.isoWeek(), this.isoWeekday(), 1, 4)
    }

    function sv() {
        return ni(this.year(), 1, 4)
    }

    function hv() {
        var n = this.localeData()._week;
        return ni(this.year(), n.dow, n.doy)
    }

    function ae(n, t, i, r, u) {
        var f;
        return null == n ? yi(this, r, u).year : (f = ni(n, r, u), t > f && (t = f), cv.call(this, n, t, i, r, u))
    }

    function cv(n, t, i, r, u) {
        var e = bf(n, t, i, r, u),
            f = vi(e.year, 0, e.dayOfYear);
        return this.year(f.getUTCFullYear()), this.month(f.getUTCMonth()), this.date(f.getUTCDate()), this
    }

    function lv(n) {
        return null == n ? Math.ceil((this.month() + 1) / 3) : this.month(3 * (n - 1) + this.month() % 3)
    }

    function av(n) {
        var t = Math.round((this.clone().startOf("day") - this.clone().startOf("year")) / 864e5) + 1;
        return null == n ? t : this.add(n - t, "d")
    }

    function vv(n, t) {
        t[ri] = f(1e3 * ("0." + n))
    }

    function yv() {
        return this._isUTC ? "UTC" : ""
    }

    function pv() {
        return this._isUTC ? "Coordinated Universal Time" : ""
    }

    function wv(n) {
        return c(1e3 * n)
    }

    function bv() {
        return c.apply(null, arguments).parseZone()
    }

    function ve(n) {
        return n
    }

    function hr(n, t, i, r) {
        var u = pt(),
            f = ft().set(r, t);
        return u[i](f, n)
    }

    function ye(n, t, i) {
        if (dt(n) && (t = n, n = void 0), n = n || "", null != t) return hr(n, t, i, "month");
        for (var u = [], r = 0; r < 12; r++) u[r] = hr(n, r, i, "month");
        return u
    }

    function vu(n, t, i, r) {
        var o, f, u, e;
        if ("boolean" == typeof n ? (dt(t) && (i = t, t = void 0), t = t || "") : (t = n, i = t, n = !1, dt(t) && (i = t, t = void 0), t = t || ""), o = pt(), f = n ? o._week.dow : 0, null != i) return hr(t, (i + f) % 7, r, "day");
        for (e = [], u = 0; u < 7; u++) e[u] = hr(t, (u + f) % 7, r, "day");
        return e
    }

    function kv(n, t) {
        return ye(n, t, "months")
    }

    function dv(n, t) {
        return ye(n, t, "monthsShort")
    }

    function gv(n, t, i) {
        return vu(n, t, i, "weekdays")
    }

    function ny(n, t, i) {
        return vu(n, t, i, "weekdaysShort")
    }

    function ty(n, t, i) {
        return vu(n, t, i, "weekdaysMin")
    }

    function iy() {
        var n = this._data;
        return this._milliseconds = at(this._milliseconds), this._days = at(this._days), this._months = at(this._months), n.milliseconds = at(n.milliseconds), n.seconds = at(n.seconds), n.minutes = at(n.minutes), n.hours = at(n.hours), n.months = at(n.months), n.years = at(n.years), this
    }

    function pe(n, t, i, r) {
        var u = it(t, i);
        return n._milliseconds += r * u._milliseconds, n._days += r * u._days, n._months += r * u._months, n._bubble()
    }

    function ry(n, t) {
        return pe(this, n, t, 1)
    }

    function uy(n, t) {
        return pe(this, n, t, -1)
    }

    function we(n) {
        return n < 0 ? Math.floor(n) : Math.ceil(n)
    }

    function fy() {
        var u, f, e, s, o, r = this._milliseconds,
            n = this._days,
            t = this._months,
            i = this._data;
        return r >= 0 && n >= 0 && t >= 0 || r <= 0 && n <= 0 && t <= 0 || (r += 864e5 * we(yu(t) + n), n = 0, t = 0), i.milliseconds = r % 1e3, u = d(r / 1e3), i.seconds = u % 60, f = d(u / 60), i.minutes = f % 60, e = d(f / 60), i.hours = e % 24, n += d(e / 24), o = d(be(n)), t += o, n -= we(yu(o)), s = d(t / 12), t %= 12, i.days = n, i.months = t, i.years = s, this
    }

    function be(n) {
        return 4800 * n / 146097
    }

    function yu(n) {
        return 146097 * n / 4800
    }

    function ey(n) {
        if (!this.isValid()) return NaN;
        var t, r, i = this._milliseconds;
        if (n = nt(n), "month" === n || "year" === n) return t = this._days + i / 864e5, r = this._months + be(t), "month" === n ? r : r / 12;
        switch (t = this._days + Math.round(yu(this._months)), n) {
            case "week":
                return t / 7 + i / 6048e5;
            case "day":
                return t + i / 864e5;
            case "hour":
                return 24 * t + i / 36e5;
            case "minute":
                return 1440 * t + i / 6e4;
            case "second":
                return 86400 * t + i / 1e3;
            case "millisecond":
                return Math.floor(864e5 * t) + i;
            default:
                throw new Error("Unknown unit " + n);
        }
    }

    function oy() {
        return this.isValid() ? this._milliseconds + 864e5 * this._days + this._months % 12 * 2592e6 + 31536e6 * f(this._months / 12) : NaN
    }

    function wt(n) {
        return function() {
            return this.as(n)
        }
    }

    function sy() {
        return it(this)
    }

    function hy(n) {
        return n = nt(n), this.isValid() ? this[n + "s"]() : NaN
    }

    function ii(n) {
        return function() {
            return this.isValid() ? this._data[n] : NaN
        }
    }

    function cy() {
        return d(this.days() / 7)
    }

    function ly(n, t, i, r, u) {
        return u.relativeTime(t || 1, !!i, n, r)
    }

    function ay(n, t, i) {
        var r = it(n).abs(),
            u = kt(r.as("s")),
            e = kt(r.as("m")),
            o = kt(r.as("h")),
            s = kt(r.as("d")),
            h = kt(r.as("M")),
            c = kt(r.as("y")),
            f = u <= st.ss && ["s", u] || u < st.s && ["ss", u] || e <= 1 && ["m"] || e < st.m && ["mm", e] || o <= 1 && ["h"] || o < st.h && ["hh", o] || s <= 1 && ["d"] || s < st.d && ["dd", s] || h <= 1 && ["M"] || h < st.M && ["MM", h] || c <= 1 && ["y"] || ["yy", c];
        return f[2] = t, f[3] = +n > 0, f[4] = i, ly.apply(null, f)
    }

    function vy(n) {
        return void 0 === n ? kt : "function" == typeof n && (kt = n, !0)
    }

    function yy(n, t) {
        return void 0 !== st[n] && (void 0 === t ? st[n] : (st[n] = t, "s" === n && (st.ss = t - 1), !0))
    }

    function py(n) {
        if (!this.isValid()) return this.localeData().invalidDate();
        var t = this.localeData(),
            i = ay(this, !n, t);
        return n && (i = t.pastFuture(+this, i)), t.postformat(i)
    }

    function oi(n) {
        return (n > 0) - (n < 0) || +n
    }

    function cr() {
        if (!this.isValid()) return this.localeData().invalidDate();
        var t, s, h, i = ef(this._milliseconds) / 1e3,
            y = ef(this._days),
            r = ef(this._months);
        t = d(i / 60);
        s = d(t / 60);
        i %= 60;
        t %= 60;
        h = d(r / 12);
        r %= 12;
        var c = h,
            l = r,
            a = y,
            u = s,
            f = t,
            e = i ? i.toFixed(3).replace(/\.?0+$/, "") : "",
            n = this.asSeconds();
        if (!n) return "P0D";
        var p = n < 0 ? "-" : "",
            v = oi(this._months) !== oi(n) ? "-" : "",
            w = oi(this._days) !== oi(n) ? "-" : "",
            o = oi(this._milliseconds) !== oi(n) ? "-" : "";
        return p + "P" + (c ? v + c + "Y" : "") + (l ? v + l + "M" : "") + (a ? w + a + "D" : "") + (u || f || e ? "T" : "") + (u ? o + u + "H" : "") + (f ? o + f + "M" : "") + (e ? o + e + "S" : "")
    }
    var ke, de, no, a, tf, ho, ao, vo, yo, po, wo, uf, ff, bo, ko, bt, go, n, o;
    de = Array.prototype.some ? Array.prototype.some : function(n) {
        for (var i = Object(this), r = i.length >>> 0, t = 0; t < r; t++)
            if (t in i && n.call(this, i[t], t, i)) return !0;
        return !1
    };
    var pu = t.momentProperties = [],
        wu = !1,
        ge = {};
    t.suppressDeprecationWarnings = !1;
    t.deprecationHandler = null;
    no = Object.keys ? Object.keys : function(n) {
        var t, i = [];
        for (t in n) l(n, t) && i.push(t);
        return i
    };
    var pi = {},
        to = {},
        io = /(\[[^\[]*\])|(\\)?([Hh]mm(ss)?|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Qo?|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|kk?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g,
        lr = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,
        bu = {},
        si = {},
        ro = /\d/,
        k = /\d\d/,
        uo = /\d{3}/,
        ku = /\d{4}/,
        ar = /[+-]?\d{6}/,
        h = /\d\d?/,
        fo = /\d\d\d\d?/,
        eo = /\d\d\d\d\d\d?/,
        vr = /\d{1,3}/,
        du = /\d{1,4}/,
        yr = /[+-]?\d{1,6}/,
        pr = /[+-]?\d+/,
        wy = /Z|[+-]\d\d:?\d\d/gi,
        wr = /Z|[+-]\d\d(?::?\d\d)?/gi,
        wi = /[0-9]{0,256}['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFF07\uFF10-\uFFEF]{1,256}|[\u0600-\u06FF\/]{1,256}(\s*?[\u0600-\u06FF]{1,256}){1,2}/i,
        gu = {},
        nf = {},
        rt = 0,
        ct = 1,
        ot = 2,
        v = 3,
        ut = 4,
        lt = 5,
        ri = 6,
        by = 7,
        ky = 8;
    r("Y", 0, 0, function() {
        var n = this.year();
        return n <= 9999 ? "" + n : "+" + n
    });
    r(0, ["YY", 2], 0, function() {
        return this.year() % 100
    });
    r(0, ["YYYY", 4], 0, "year");
    r(0, ["YYYYY", 5], 0, "year");
    r(0, ["YYYYYY", 6, !0], 0, "year");
    w("year", "y");
    b("year", 1);
    i("Y", pr);
    i("YY", h, k);
    i("YYYY", du, ku);
    i("YYYYY", yr, ar);
    i("YYYYYY", yr, ar);
    s(["YYYYY", "YYYYYY"], rt);
    s("YYYY", function(n, i) {
        i[rt] = 2 === n.length ? t.parseTwoDigitYear(n) : f(n)
    });
    s("YY", function(n, i) {
        i[rt] = t.parseTwoDigitYear(n)
    });
    s("Y", function(n, t) {
        t[rt] = parseInt(n, 10)
    });
    t.parseTwoDigitYear = function(n) {
        return f(n) + (f(n) > 68 ? 1900 : 2e3)
    };
    tf = ui("FullYear", !0);
    a = Array.prototype.indexOf ? Array.prototype.indexOf : function(n) {
        for (var t = 0; t < this.length; ++t)
            if (this[t] === n) return t;
        return -1
    };
    r("M", ["MM", 2], "Mo", function() {
        return this.month() + 1
    });
    r("MMM", 0, 0, function(n) {
        return this.localeData().monthsShort(this, n)
    });
    r("MMMM", 0, 0, function(n) {
        return this.localeData().months(this, n)
    });
    w("month", "M");
    b("month", 8);
    i("M", h);
    i("MM", h, k);
    i("MMM", function(n, t) {
        return t.monthsShortRegex(n)
    });
    i("MMMM", function(n, t) {
        return t.monthsRegex(n)
    });
    s(["M", "MM"], function(n, t) {
        t[ct] = f(n) - 1
    });
    s(["MMM", "MMMM"], function(n, t, i, r) {
        var f = i._locale.monthsParse(n, r, i._strict);
        null != f ? t[ct] = f : u(i).invalidMonth = n
    });
    var oo = /D[oD]?(\[[^\[\]]*\]|\s)+MMMM?/,
        dy = "January_February_March_April_May_June_July_August_September_October_November_December".split("_"),
        so = "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"),
        gy = wi,
        np = wi;
    r("w", ["ww", 2], "wo", "week");
    r("W", ["WW", 2], "Wo", "isoWeek");
    w("week", "w");
    w("isoWeek", "W");
    b("week", 5);
    b("isoWeek", 5);
    i("w", h);
    i("ww", h, k);
    i("W", h);
    i("WW", h, k);
    li(["w", "ww", "W", "WW"], function(n, t, i, r) {
        t[r.substr(0, 1)] = f(n)
    });
    ho = {
        dow: 0,
        doy: 6
    };
    r("d", 0, "do", "day");
    r("dd", 0, 0, function(n) {
        return this.localeData().weekdaysMin(this, n)
    });
    r("ddd", 0, 0, function(n) {
        return this.localeData().weekdaysShort(this, n)
    });
    r("dddd", 0, 0, function(n) {
        return this.localeData().weekdays(this, n)
    });
    r("e", 0, 0, "weekday");
    r("E", 0, 0, "isoWeekday");
    w("day", "d");
    w("weekday", "e");
    w("isoWeekday", "E");
    b("day", 11);
    b("weekday", 11);
    b("isoWeekday", 11);
    i("d", h);
    i("e", h);
    i("E", h);
    i("dd", function(n, t) {
        return t.weekdaysMinRegex(n)
    });
    i("ddd", function(n, t) {
        return t.weekdaysShortRegex(n)
    });
    i("dddd", function(n, t) {
        return t.weekdaysRegex(n)
    });
    li(["dd", "ddd", "dddd"], function(n, t, i, r) {
        var f = i._locale.weekdaysParse(n, r, i._strict);
        null != f ? t.d = f : u(i).invalidWeekday = n
    });
    li(["d", "e", "E"], function(n, t, i, r) {
        t[r] = f(n)
    });
    var tp = "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),
        co = "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"),
        ip = "Su_Mo_Tu_We_Th_Fr_Sa".split("_"),
        rp = wi,
        up = wi,
        fp = wi;
    r("H", ["HH", 2], 0, "hour");
    r("h", ["hh", 2], 0, iu);
    r("k", ["kk", 2], 0, uc);
    r("hmm", 0, 0, function() {
        return "" + iu.apply(this) + ht(this.minutes(), 2)
    });
    r("hmmss", 0, 0, function() {
        return "" + iu.apply(this) + ht(this.minutes(), 2) + ht(this.seconds(), 2)
    });
    r("Hmm", 0, 0, function() {
        return "" + this.hours() + ht(this.minutes(), 2)
    });
    r("Hmmss", 0, 0, function() {
        return "" + this.hours() + ht(this.minutes(), 2) + ht(this.seconds(), 2)
    });
    kf("a", !0);
    kf("A", !1);
    w("hour", "h");
    b("hour", 13);
    i("a", df);
    i("A", df);
    i("H", h);
    i("h", h);
    i("k", h);
    i("HH", h, k);
    i("hh", h, k);
    i("kk", h, k);
    i("hmm", fo);
    i("hmmss", eo);
    i("Hmm", fo);
    i("Hmmss", eo);
    s(["H", "HH"], v);
    s(["k", "kk"], function(n, t) {
        var i = f(n);
        t[v] = 24 === i ? 0 : i
    });
    s(["a", "A"], function(n, t, i) {
        i._isPm = i._locale.isPM(n);
        i._meridiem = n
    });
    s(["h", "hh"], function(n, t, i) {
        t[v] = f(n);
        u(i).bigHour = !0
    });
    s("hmm", function(n, t, i) {
        var r = n.length - 2;
        t[v] = f(n.substr(0, r));
        t[ut] = f(n.substr(r));
        u(i).bigHour = !0
    });
    s("hmmss", function(n, t, i) {
        var r = n.length - 4,
            e = n.length - 2;
        t[v] = f(n.substr(0, r));
        t[ut] = f(n.substr(r, 2));
        t[lt] = f(n.substr(e));
        u(i).bigHour = !0
    });
    s("Hmm", function(n, t) {
        var i = n.length - 2;
        t[v] = f(n.substr(0, i));
        t[ut] = f(n.substr(i))
    });
    s("Hmmss", function(n, t) {
        var i = n.length - 4,
            r = n.length - 2;
        t[v] = f(n.substr(0, i));
        t[ut] = f(n.substr(i, 2));
        t[lt] = f(n.substr(r))
    });
    var bi, ep = ui("Hours", !0),
        lo = {
            calendar: {
                sameDay: "[Today at] LT",
                nextDay: "[Tomorrow at] LT",
                nextWeek: "dddd [at] LT",
                lastDay: "[Yesterday at] LT",
                lastWeek: "[Last] dddd [at] LT",
                sameElse: "L"
            },
            longDateFormat: {
                LTS: "h:mm:ss A",
                LT: "h:mm A",
                L: "MM/DD/YYYY",
                LL: "MMMM D, YYYY",
                LLL: "MMMM D, YYYY h:mm A",
                LLLL: "dddd, MMMM D, YYYY h:mm A"
            },
            invalidDate: "Invalid date",
            ordinal: "%d",
            dayOfMonthOrdinalParse: /\d{1,2}/,
            relativeTime: {
                future: "in %s",
                past: "%s ago",
                s: "a few seconds",
                ss: "%d seconds",
                m: "a minute",
                mm: "%d minutes",
                h: "an hour",
                hh: "%d hours",
                d: "a day",
                dd: "%d days",
                M: "a month",
                MM: "%d months",
                y: "a year",
                yy: "%d years"
            },
            months: dy,
            monthsShort: so,
            week: ho,
            weekdays: tp,
            weekdaysMin: ip,
            weekdaysShort: co,
            meridiemParse: /[ap]\.?m?\.?/i
        },
        y = {},
        ki = {},
        op = /^\s*((?:[+-]\d{6}|\d{4})-(?:\d\d-\d\d|W\d\d-\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?::\d\d(?::\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,
        sp = /^\s*((?:[+-]\d{6}|\d{4})(?:\d\d\d\d|W\d\d\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?:\d\d(?:\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,
        hp = /Z|[+-]\d\d(?::?\d\d)?/,
        br = [
            ["YYYYYY-MM-DD", /[+-]\d{6}-\d\d-\d\d/],
            ["YYYY-MM-DD", /\d{4}-\d\d-\d\d/],
            ["GGGG-[W]WW-E", /\d{4}-W\d\d-\d/],
            ["GGGG-[W]WW", /\d{4}-W\d\d/, !1],
            ["YYYY-DDD", /\d{4}-\d{3}/],
            ["YYYY-MM", /\d{4}-\d\d/, !1],
            ["YYYYYYMMDD", /[+-]\d{10}/],
            ["YYYYMMDD", /\d{8}/],
            ["GGGG[W]WWE", /\d{4}W\d{3}/],
            ["GGGG[W]WW", /\d{4}W\d{2}/, !1],
            ["YYYYDDD", /\d{7}/]
        ],
        rf = [
            ["HH:mm:ss.SSSS", /\d\d:\d\d:\d\d\.\d+/],
            ["HH:mm:ss,SSSS", /\d\d:\d\d:\d\d,\d+/],
            ["HH:mm:ss", /\d\d:\d\d:\d\d/],
            ["HH:mm", /\d\d:\d\d/],
            ["HHmmss.SSSS", /\d\d\d\d\d\d\.\d+/],
            ["HHmmss,SSSS", /\d\d\d\d\d\d,\d+/],
            ["HHmmss", /\d\d\d\d\d\d/],
            ["HHmm", /\d\d\d\d/],
            ["HH", /\d\d/]
        ],
        cp = /^\/?Date\((\-?\d+)/i,
        lp = /^(?:(Mon|Tue|Wed|Thu|Fri|Sat|Sun),?\s)?(\d{1,2})\s(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s(\d{2,4})\s(\d\d):(\d\d)(?::(\d\d))?\s(?:(UT|GMT|[ECMP][SD]T)|([Zz])|([+-]\d{4}))$/,
        ap = {
            UT: 0,
            GMT: 0,
            EDT: -240,
            EST: -300,
            CDT: -300,
            CST: -360,
            MDT: -360,
            MST: -420,
            PDT: -420,
            PST: -480
        };
    t.createFromInputFallback = g("value provided is not in a recognized RFC2822 or ISO format. moment construction falls back to js Date(), which is not reliable across all browsers and versions. Non RFC2822/ISO date formats are discouraged and will be removed in an upcoming major release. Please refer to http://momentjs.com/guides/#/warnings/js-date/ for more info.", function(n) {
        n._d = new Date(n._i + (n._useUTC ? " UTC" : ""))
    });
    t.ISO_8601 = function() {};
    t.RFC_2822 = function() {};
    var vp = g("moment().min is deprecated, use moment.max instead. http://momentjs.com/guides/#/warnings/min-max/", function() {
            var n = c.apply(null, arguments);
            return this.isValid() && n.isValid() ? n < this ? this : n : nr()
        }),
        yp = g("moment().max is deprecated, use moment.min instead. http://momentjs.com/guides/#/warnings/min-max/", function() {
            var n = c.apply(null, arguments);
            return this.isValid() && n.isValid() ? n > this ? this : n : nr()
        }),
        pp = function() {
            return Date.now ? Date.now() : +new Date
        },
        di = ["year", "quarter", "month", "week", "day", "hour", "minute", "second", "millisecond"];
    for (fe("Z", ":"), fe("ZZ", ""), i("Z", wr), i("ZZ", wr), s(["Z", "ZZ"], function(n, t, i) {
            i._useUTC = !0;
            i._tzm = hu(wr, n)
        }), ao = /([\+\-]|\d\d)/gi, t.updateOffset = function() {}, vo = /^(\-|\+)?(?:(\d*)[. ])?(\d+)\:(\d+)(?:\:(\d+)(\.\d*)?)?$/, yo = /^(-|\+)?P(?:([-+]?[0-9,.]*)Y)?(?:([-+]?[0-9,.]*)M)?(?:([-+]?[0-9,.]*)W)?(?:([-+]?[0-9,.]*)D)?(?:T(?:([-+]?[0-9,.]*)H)?(?:([-+]?[0-9,.]*)M)?(?:([-+]?[0-9,.]*)S)?)?$/, it.fn = or.prototype, it.invalid = el, po = se(1, "add"), wo = se(-1, "subtract"), t.defaultFormat = "YYYY-MM-DDTHH:mm:ssZ", t.defaultFormatUtc = "YYYY-MM-DDTHH:mm:ss[Z]", uf = g("moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.", function(n) {
            return void 0 === n ? this.localeData() : this.locale(n)
        }), r(0, ["gg", 2], 0, function() {
            return this.weekYear() % 100
        }), r(0, ["GG", 2], 0, function() {
            return this.isoWeekYear() % 100
        }), sr("gggg", "weekYear"), sr("ggggg", "weekYear"), sr("GGGG", "isoWeekYear"), sr("GGGGG", "isoWeekYear"), w("weekYear", "gg"), w("isoWeekYear", "GG"), b("weekYear", 1), b("isoWeekYear", 1), i("G", pr), i("g", pr), i("GG", h, k), i("gg", h, k), i("GGGG", du, ku), i("gggg", du, ku), i("GGGGG", yr, ar), i("ggggg", yr, ar), li(["gggg", "ggggg", "GGGG", "GGGGG"], function(n, t, i, r) {
            t[r.substr(0, 2)] = f(n)
        }), li(["gg", "GG"], function(n, i, r, u) {
            i[u] = t.parseTwoDigitYear(n)
        }), r("Q", 0, "Qo", "quarter"), w("quarter", "Q"), b("quarter", 7), i("Q", ro), s("Q", function(n, t) {
            t[ct] = 3 * (f(n) - 1)
        }), r("D", ["DD", 2], "Do", "date"), w("date", "D"), b("date", 9), i("D", h), i("DD", h, k), i("Do", function(n, t) {
            return n ? t._dayOfMonthOrdinalParse || t._ordinalParse : t._dayOfMonthOrdinalParseLenient
        }), s(["D", "DD"], ot), s("Do", function(n, t) {
            t[ot] = f(n.match(h)[0])
        }), ff = ui("Date", !0), r("DDD", ["DDDD", 3], "DDDo", "dayOfYear"), w("dayOfYear", "DDD"), b("dayOfYear", 4), i("DDD", vr), i("DDDD", uo), s(["DDD", "DDDD"], function(n, t, i) {
            i._dayOfYear = f(n)
        }), r("m", ["mm", 2], 0, "minute"), w("minute", "m"), b("minute", 14), i("m", h), i("mm", h, k), s(["m", "mm"], ut), bo = ui("Minutes", !1), r("s", ["ss", 2], 0, "second"), w("second", "s"), b("second", 15), i("s", h), i("ss", h, k), s(["s", "ss"], lt), ko = ui("Seconds", !1), r("S", 0, 0, function() {
            return ~~(this.millisecond() / 100)
        }), r(0, ["SS", 2], 0, function() {
            return ~~(this.millisecond() / 10)
        }), r(0, ["SSS", 3], 0, "millisecond"), r(0, ["SSSS", 4], 0, function() {
            return 10 * this.millisecond()
        }), r(0, ["SSSSS", 5], 0, function() {
            return 100 * this.millisecond()
        }), r(0, ["SSSSSS", 6], 0, function() {
            return 1e3 * this.millisecond()
        }), r(0, ["SSSSSSS", 7], 0, function() {
            return 1e4 * this.millisecond()
        }), r(0, ["SSSSSSSS", 8], 0, function() {
            return 1e5 * this.millisecond()
        }), r(0, ["SSSSSSSSS", 9], 0, function() {
            return 1e6 * this.millisecond()
        }), w("millisecond", "ms"), b("millisecond", 16), i("S", vr, ro), i("SS", vr, k), i("SSS", vr, uo), bt = "SSSS"; bt.length <= 9; bt += "S") i(bt, /\d+/);
    for (bt = "S"; bt.length <= 9; bt += "S") s(bt, vv);
    go = ui("Milliseconds", !1);
    r("z", 0, 0, "zoneAbbr");
    r("zz", 0, 0, "zoneName");
    n = ci.prototype;
    n.add = po;
    n.calendar = dl;
    n.clone = gl;
    n.diff = ea;
    n.endOf = wa;
    n.format = ca;
    n.from = la;
    n.fromNow = aa;
    n.to = va;
    n.toNow = ya;
    n.get = bs;
    n.invalidAt = uv;
    n.isAfter = na;
    n.isBefore = ta;
    n.isBetween = ia;
    n.isSame = ra;
    n.isSameOrAfter = ua;
    n.isSameOrBefore = fa;
    n.isValid = iv;
    n.lang = uf;
    n.locale = ce;
    n.localeData = le;
    n.max = yp;
    n.min = vp;
    n.parsingFlags = rv;
    n.set = ks;
    n.startOf = pa;
    n.subtract = wo;
    n.toArray = ga;
    n.toObject = nv;
    n.toDate = da;
    n.toISOString = sa;
    n.inspect = ha;
    n.toJSON = tv;
    n.toString = oa;
    n.unix = ka;
    n.valueOf = ba;
    n.creationData = fv;
    n.year = tf;
    n.isLeapYear = ws;
    n.weekYear = ev;
    n.isoWeekYear = ov;
    n.quarter = n.quarters = lv;
    n.month = pf;
    n.daysInMonth = rh;
    n.week = n.weeks = ch;
    n.isoWeek = n.isoWeeks = lh;
    n.weeksInYear = hv;
    n.isoWeeksInYear = sv;
    n.date = ff;
    n.day = n.days = dh;
    n.weekday = gh;
    n.isoWeekday = nc;
    n.dayOfYear = av;
    n.hour = n.hours = ep;
    n.minute = n.minutes = bo;
    n.second = n.seconds = ko;
    n.millisecond = n.milliseconds = go;
    n.utcOffset = ol;
    n.utc = hl;
    n.local = cl;
    n.parseZone = ll;
    n.hasAlignedHourOffset = al;
    n.isDST = vl;
    n.isLocal = pl;
    n.isUtcOffset = wl;
    n.isUtc = ee;
    n.isUTC = ee;
    n.zoneAbbr = yv;
    n.zoneName = pv;
    n.dates = g("dates accessor is deprecated. Use date instead.", ff);
    n.months = g("months accessor is deprecated. Use month instead", pf);
    n.years = g("years accessor is deprecated. Use year instead", tf);
    n.zone = g("moment().zone is deprecated, use moment().utcOffset instead. http://momentjs.com/guides/#/warnings/zone/", sl);
    n.isDSTShifted = g("isDSTShifted is deprecated. See http://momentjs.com/guides/#/warnings/dst-shifted/ for more information", yl);
    o = gr.prototype;
    o.calendar = us;
    o.longDateFormat = fs;
    o.invalidDate = es;
    o.ordinal = os;
    o.preparse = ve;
    o.postformat = ve;
    o.relativeTime = ss;
    o.pastFuture = hs;
    o.set = rs;
    o.months = gs;
    o.monthsShort = nh;
    o.monthsParse = ih;
    o.monthsRegex = fh;
    o.monthsShortRegex = uh;
    o.week = oh;
    o.firstDayOfYear = hh;
    o.firstDayOfWeek = sh;
    o.weekdays = yh;
    o.weekdaysMin = wh;
    o.weekdaysShort = ph;
    o.weekdaysParse = kh;
    o.weekdaysRegex = tc;
    o.weekdaysShortRegex = ic;
    o.weekdaysMinRegex = rc;
    o.isPM = fc;
    o.meridiem = ec;
    fi("en", {
        dayOfMonthOrdinalParse: /\d{1,2}(th|st|nd|rd)/,
        ordinal: function(n) {
            var t = n % 10,
                i = 1 === f(n % 100 / 10) ? "th" : 1 === t ? "st" : 2 === t ? "nd" : 3 === t ? "rd" : "th";
            return n + i
        }
    });
    t.lang = g("moment.lang is deprecated. Use moment.locale instead.", fi);
    t.langData = g("moment.langData is deprecated. Use moment.localeData instead.", pt);
    var at = Math.abs,
        wp = wt("ms"),
        bp = wt("s"),
        kp = wt("m"),
        dp = wt("h"),
        gp = wt("d"),
        nw = wt("w"),
        tw = wt("M"),
        iw = wt("y"),
        rw = ii("milliseconds"),
        uw = ii("seconds"),
        fw = ii("minutes"),
        ew = ii("hours"),
        ow = ii("days"),
        sw = ii("months"),
        hw = ii("years"),
        kt = Math.round,
        st = {
            ss: 44,
            s: 45,
            m: 45,
            h: 22,
            d: 26,
            M: 11
        },
        ef = Math.abs,
        e = or.prototype;
    return e.isValid = fl, e.abs = iy, e.add = ry, e.subtract = uy, e.as = ey, e.asMilliseconds = wp, e.asSeconds = bp, e.asMinutes = kp, e.asHours = dp, e.asDays = gp, e.asWeeks = nw, e.asMonths = tw, e.asYears = iw, e.valueOf = oy, e._bubble = fy, e.clone = sy, e.get = hy, e.milliseconds = rw, e.seconds = uw, e.minutes = fw, e.hours = ew, e.days = ow, e.weeks = cy, e.months = sw, e.years = hw, e.humanize = py, e.toISOString = cr, e.toString = cr, e.toJSON = cr, e.locale = ce, e.localeData = le, e.toIsoString = g("toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)", cr), e.lang = uf, r("X", 0, 0, "unix"), r("x", 0, 0, "valueOf"), i("x", pr), i("X", /[+-]?\d+(\.\d{1,3})?/), s("X", function(n, t, i) {
        i._d = new Date(1e3 * parseFloat(n, 10))
    }), s("x", function(n, t, i) {
        i._d = new Date(f(n))
    }), t.version = "2.22.2", ns(c), t.fn = n, t.min = il, t.max = rl, t.now = pp, t.utc = ft, t.unix = wv, t.months = kv, t.isDate = gi, t.locale = fi, t.invalid = nr, t.duration = it, t.isMoment = yt, t.weekdays = gv, t.parseZone = bv, t.localeData = pt, t.isDuration = ou, t.monthsShort = dv, t.weekdaysMin = ty, t.defineLocale = ru, t.updateLocale = sc, t.locales = hc, t.weekdaysShort = ny, t.normalizeUnits = nt, t.relativeTimeRounding = vy, t.relativeTimeThreshold = yy, t.calendarFormat = kl, t.prototype = n, t.HTML5_FMT = {
        DATETIME_LOCAL: "YYYY-MM-DDTHH:mm",
        DATETIME_LOCAL_SECONDS: "YYYY-MM-DDTHH:mm:ss",
        DATETIME_LOCAL_MS: "YYYY-MM-DDTHH:mm:ss.SSS",
        DATE: "YYYY-MM-DD",
        TIME: "HH:mm",
        TIME_SECONDS: "HH:mm:ss",
        TIME_MS: "HH:mm:ss.SSS",
        WEEK: "YYYY-[W]WW",
        MONTH: "YYYY-MM"
    }, t
});
! function(n, t) {
    "object" == typeof exports && "undefined" != typeof module && "function" == typeof require ? t(require("../moment")) : "function" == typeof define && define.amd ? define(["../moment"], t) : t(n.moment)
}(this, function(n) {
    "use strict";
    return n.defineLocale("pt", {
        months: "janeiro_fevereiro_março_abril_maio_junho_julho_agosto_setembro_outubro_novembro_dezembro".split("_"),
        monthsShort: "jan_fev_mar_abr_mai_jun_jul_ago_set_out_nov_dez".split("_"),
        weekdays: "Domingo_Segunda-feira_Terça-feira_Quarta-feira_Quinta-feira_Sexta-feira_Sábado".split("_"),
        weekdaysShort: "Dom_Seg_Ter_Qua_Qui_Sex_Sáb".split("_"),
        weekdaysMin: "Do_2ª_3ª_4ª_5ª_6ª_Sá".split("_"),
        weekdaysParseExact: !0,
        longDateFormat: {
            LT: "HH:mm",
            LTS: "HH:mm:ss",
            L: "DD/MM/YYYY",
            LL: "D [de] MMMM [de] YYYY",
            LLL: "D [de] MMMM [de] YYYY HH:mm",
            LLLL: "dddd, D [de] MMMM [de] YYYY HH:mm"
        },
        calendar: {
            sameDay: "[Hoje às] LT",
            nextDay: "[Amanhã às] LT",
            nextWeek: "dddd [às] LT",
            lastDay: "[Ontem às] LT",
            lastWeek: function() {
                return 0 === this.day() || 6 === this.day() ? "[Último] dddd [às] LT" : "[Última] dddd [às] LT"
            },
            sameElse: "L"
        },
        relativeTime: {
            future: "em %s",
            past: "há %s",
            s: "segundos",
            ss: "%d segundos",
            m: "um minuto",
            mm: "%d minutos",
            h: "uma hora",
            hh: "%d horas",
            d: "um dia",
            dd: "%d dias",
            M: "um mês",
            MM: "%d meses",
            y: "um ano",
            yy: "%d anos"
        },
        dayOfMonthOrdinalParse: /\d{1,2}º/,
        ordinal: "%dº",
        week: {
            dow: 1,
            doy: 4
        }
    })
});
var win_w, isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i)
    },
    AndroidFirefox: function() {
        var n = navigator.userAgent.toLowerCase().indexOf("android") > -1,
            t = navigator.userAgent.toLowerCase().indexOf("firefox") > -1;
        return n && t ? !0 : !1
    },
    AndroidWebkit: function() {
        var n = navigator.userAgent.toLowerCase().indexOf("android") > -1,
            t = navigator.userAgent.toLowerCase().indexOf("applewebkit") > -1;
        return n && t ? !0 : !1
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i)
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i)
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i)
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i)
    },
    any: function() {
        return isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows()
    }
};
(function() {
    jQuery(function() {
        clientOverrides();
        windowAdjustOnBrowserResize();
        windowScrollInit();
        setTimeout(function() {
            windowScrollProcess()
        }, 1e3);
        appOverlayCloseActions();
        appOverlayMainSidebarActions();
        appOverlayUserAccountActions();
        appOverlaysDismissInit();
        appContentDismissInit();
        appTickersInit();
        slidersInit();
        contentShowMore();
        contentCollapse();
        articleReadMore();
        jQuery(".js-article-readmore-resize-watch").on("mresize", function() {
            var t = jQuery(this),
                n = t.closest(".js-a-content-rm").eq(0);
            n.length && n.is(".js-a-content-rm-ready") && articleReadMore()
        });
        jQuery("body").off("click", ".js-a-content-rm-btn").on("click", ".js-a-content-rm-btn", function() {
            var t = jQuery(this).closest('[rel="detalhe-artigo"]'),
                n = jQuery(this).closest(".js-a-content-rm"),
                i = n.find(".js-a-content-rm-full").eq(0),
                r = i.outerHeight();
            n.is(".js-a-content-rm-ready") && (t.is('[data-truncated="true"]') || n.css({
                "max-height": r
            }), setTimeout(function() {
                n.removeAttr("style").removeClass("t-a-content-rm t-a-content-rm-ready js-a-content-rm-ready").addClass("t-a-content-rm-triggered");
                jQuery(".js-a-pub-rm-1").removeClass("t-a-pub-rm")
            }, 1e3), articleReplaceDetailHtml && articleReplaceDetailHtml())
        });
        appDropDowns();
        tabSys1();
        appArticleLightbox1Init();
        jQuery(document).keyup(function(n) {
            n.keyCode == 27 && jQuery(".js-lb-close").click();
            jQuery(".js-lb-wrap-1").eq(0).is(":visible") && (n.keyCode == 37 && jQuery(".js-lb-wrap-1 .lSAction .lSPrev").click(), n.keyCode == 39 && jQuery(".js-lb-wrap-1 .lSAction .lSNext").click())
        });
        jQuery("body").on("click", ".js-edd-toggle-1 .js-edd-toggle-1-btn", function() {
            var t = jQuery("body"),
                i = "interaction-t-edd-search-open",
                n = jQuery(this).closest(".js-edd-toggle-1").find(".js-edd-toggle-1-target").eq(0);
            n.is(":visible") ? (t.removeClass(i), n.slideUp()) : (t.addClass(i), n.slideDown())
        })
    })
})(jQuery);
! function(n, t, i, r) {
    var e = t.document,
        k = n(e),
        h = n(t),
        d = Array.prototype,
        et = !0,
        yt = 3e4,
        tt = !1,
        y = navigator.userAgent.toLowerCase(),
        ot = t.location.hash.replace(/#\//, ""),
        g = "file:" == t.location.protocol ? "http:" : t.location.protocol,
        f = Math,
        c = function() {},
        pt = function() {
            return !1
        },
        wt = !(t.screen.width > 1279 && 1 == t.devicePixelRatio || t.screen.width > 1e3 && t.innerWidth < .9 * t.screen.width),
        o = function() {
            var n = 3,
                t = e.createElement("div"),
                i = t.getElementsByTagName("i");
            do t.innerHTML = "<!--[if gt IE " + ++n + "]><i><\/i><![endif]-->"; while (i[0]);
            return n > 4 ? n : e.documentMode || r
        }(),
        s = function() {
            return {
                html: e.documentElement,
                body: e.body,
                head: e.getElementsByTagName("head")[0],
                title: e.title
            }
        },
        nt = t.parent !== t.self,
        bt = "data ready thumbnail loadstart loadfinish image play pause progress fullscreen_enter fullscreen_exit idle_enter idle_exit rescale lightbox_open lightbox_close lightbox_image",
        st = function() {
            var t = [];
            return n.each(bt.split(" "), function(n, i) {
                t.push(i);
                /_/.test(i) && t.push(i.replace(/_/g, ""))
            }), t
        }(),
        ht = function(t) {
            var i;
            return "object" != typeof t ? t : (n.each(t, function(r, u) {
                /^[a-z]+_/.test(r) && (i = "", n.each(r.split("_"), function(n, t) {
                    i += n > 0 ? t.substr(0, 1).toUpperCase() + t.substr(1) : t
                }), t[i] = u, delete t[r])
            }), t)
        },
        it = function(t) {
            return n.inArray(t, st) > -1 ? i[t.toUpperCase()] : t
        },
        v = {
            youtube: {
                reg: /https?:\/\/(?:[a-zA_Z]{2,3}.)?(?:youtube\.com\/watch\?)((?:[\w\d\-\_\=]+&amp;(?:amp;)?)*v(?:&lt;[A-Z]+&gt;)?=([0-9a-zA-Z\-\_]+))/i,
                embed: function() {
                    return g + "//www.youtube.com/embed/" + this.id
                },
                get_thumb: function() {
                    return g + "//img.youtube.com/vi/" + this.id + "/default.jpg"
                },
                get_image: function() {
                    return g + "//img.youtube.com/vi/" + this.id + "/hqdefault.jpg"
                }
            },
            vimeo: {
                reg: /https?:\/\/(?:www\.)?(vimeo\.com)\/(?:hd#)?([0-9]+)/i,
                embed: function() {
                    return g + "//player.vimeo.com/video/" + this.id
                },
                getUrl: function() {
                    return g + "//vimeo.com/api/v2/video/" + this.id + ".json?callback=?"
                },
                get_thumb: function(n) {
                    return n[0].thumbnail_medium
                },
                get_image: function(n) {
                    return n[0].thumbnail_large
                }
            },
            dailymotion: {
                reg: /https?:\/\/(?:www\.)?(dailymotion\.com)\/video\/([^_]+)/,
                embed: function() {
                    return g + "//www.dailymotion.com/embed/video/" + this.id
                },
                getUrl: function() {
                    return "https://api.dailymotion.com/video/" + this.id + "?fields=thumbnail_240_url,thumbnail_720_url&callback=?"
                },
                get_thumb: function(n) {
                    return n.thumbnail_240_url
                },
                get_image: function(n) {
                    return n.thumbnail_720_url
                }
            },
            _inst: []
        },
        ct = function(i, r) {
            for (var f, u = 0; u < v._inst.length; u++)
                if (v._inst[u].id === r && v._inst[u].type == i) return v._inst[u];
            this.type = i;
            this.id = r;
            this.readys = [];
            v._inst.push(this);
            f = this;
            n.extend(this, v[i]);
            _videoThumbs = function(t) {
                f.data = t;
                n.each(f.readys, function(n, t) {
                    t(f.data)
                });
                f.readys = []
            };
            this.hasOwnProperty("getUrl") ? n.getJSON(this.getUrl(), _videoThumbs) : t.setTimeout(_videoThumbs, 400);
            this.getMedia = function(n, t, i) {
                i = i || c;
                var r = this,
                    u = function(i) {
                        t(r["get_" + n](i))
                    };
                try {
                    r.data ? u(r.data) : r.readys.push(u)
                } catch (n) {
                    i()
                }
            }
        },
        lt = function(n) {
            var t, i;
            for (i in v)
                if (t = n && v[i].reg && n.match(v[i].reg), t && t.length) return {
                    id: t[2],
                    provider: i
                };
            return !1
        },
        l = {
            support: function() {
                var n = s().html;
                return !nt && (n.requestFullscreen || n.msRequestFullscreen || n.mozRequestFullScreen || n.webkitRequestFullScreen)
            }(),
            callback: c,
            enter: function(n, t, i) {
                this.instance = n;
                this.callback = t || c;
                i = i || s().html;
                i.requestFullscreen ? i.requestFullscreen() : i.msRequestFullscreen ? i.msRequestFullscreen() : i.mozRequestFullScreen ? i.mozRequestFullScreen() : i.webkitRequestFullScreen && i.webkitRequestFullScreen()
            },
            exit: function(n) {
                this.callback = n || c;
                e.exitFullscreen ? e.exitFullscreen() : e.msExitFullscreen ? e.msExitFullscreen() : e.mozCancelFullScreen ? e.mozCancelFullScreen() : e.webkitCancelFullScreen && e.webkitCancelFullScreen()
            },
            instance: null,
            listen: function() {
                if (this.support) {
                    var n = function() {
                        if (l.instance) {
                            var n = l.instance._fullscreen;
                            e.fullscreen || e.mozFullScreen || e.webkitIsFullScreen || e.msFullscreenElement && null !== e.msFullscreenElement ? n._enter(l.callback) : n._exit(l.callback)
                        }
                    };
                    e.addEventListener("fullscreenchange", n, !1);
                    e.addEventListener("MSFullscreenChange", n, !1);
                    e.addEventListener("mozfullscreenchange", n, !1);
                    e.addEventListener("webkitfullscreenchange", n, !1)
                }
            }
        },
        rt = [],
        w = [],
        at = !1,
        a = !1,
        vt = [],
        b = [],
        ut = function(t) {
            b.push(t);
            n.each(vt, function(n, i) {
                i._options.theme != t.name && (i._initialized || i._options.theme) || (i.theme = t, i._init.call(i))
            })
        },
        u = function() {
            return {
                clearTimer: function(t) {
                    n.each(i.get(), function() {
                        this.clearTimer(t)
                    })
                },
                addTimer: function(t) {
                    n.each(i.get(), function() {
                        this.addTimer(t)
                    })
                },
                array: function(n) {
                    return d.slice.call(n, 0)
                },
                create: function(n, t) {
                    t = t || "div";
                    var i = e.createElement(t);
                    return i.className = n, i
                },
                removeFromArray: function(t, i) {
                    return n.each(t, function(n, r) {
                        if (r == i) return t.splice(n, 1), !1
                    }), t
                },
                getScriptPath: function(t) {
                    t = t || n("script:last").attr("src");
                    var i = t.split("/");
                    return 1 == i.length ? "" : (i.pop(), i.join("/") + "/")
                },
                animate: function() {
                    var s, f, v, y, h, r, l, p = function(n) {
                            var i, r = "transition WebkitTransition MozTransition OTransition".split(" ");
                            if (t.opera) return !1;
                            for (i = 0; r[i]; i++)
                                if ("undefined" != typeof n[r[i]]) return r[i];
                            return !1
                        }((e.body || e.documentElement).style),
                        w = {
                            MozTransition: "transitionend",
                            OTransition: "oTransitionEnd",
                            WebkitTransition: "webkitTransitionEnd",
                            transition: "transitionend"
                        } [p],
                        a = {
                            _default: [.25, .1, .25, 1],
                            galleria: [.645, .045, .355, 1],
                            galleriaIn: [.55, .085, .68, .53],
                            galleriaOut: [.25, .46, .45, .94],
                            ease: [.25, 0, .25, 1],
                            linear: [.25, .25, .75, .75],
                            "ease-in": [.42, 0, 1, 1],
                            "ease-out": [0, 0, .58, 1],
                            "ease-in-out": [.42, 0, .58, 1]
                        },
                        o = function(t, i, r) {
                            var u = {};
                            r = r || "transition";
                            n.each("webkit moz ms o".split(" "), function() {
                                u["-" + this + "-" + r] = i
                            });
                            t.css(u)
                        },
                        b = function(n) {
                            o(n, "none", "transition");
                            i.WEBKIT && i.TOUCH && (o(n, "translate3d(0,0,0)", "transform"), n.data("revert") && (n.css(n.data("revert")), n.data("revert", null)))
                        };
                    return function(e, k, d) {
                        return d = n.extend({
                            duration: 400,
                            complete: c,
                            stop: !1
                        }, d), e = n(e), d.duration ? p ? (d.stop && (e.off(w), b(e)), s = !1, n.each(k, function(n, t) {
                            l = e.css(n);
                            u.parseValue(l) != u.parseValue(t) && (s = !0);
                            e.css(n, l)
                        }), s ? (f = [], v = d.easing in a ? a[d.easing] : a._default, y = " " + d.duration + "ms cubic-bezier(" + v.join(",") + ")", void t.setTimeout(function(t, e, s, c) {
                            return function() {
                                t.one(e, function(n) {
                                    return function() {
                                        b(n);
                                        d.complete.call(n[0])
                                    }
                                }(t));
                                i.WEBKIT && i.TOUCH && (h = {}, r = [0, 0, 0], n.each(["left", "top"], function(n, i) {
                                    i in s && (r[n] = u.parseValue(s[i]) - u.parseValue(t.css(i)) + "px", h[i] = s[i], delete s[i])
                                }), (r[0] || r[1]) && (t.data("revert", h), f.push("-webkit-transform" + c), o(t, "translate3d(" + r.join(",") + ")", "transform")));
                                n.each(s, function(n) {
                                    f.push(n + c)
                                });
                                o(t, f.join(","));
                                t.css(s)
                            }
                        }(e, w, k, y), 2)) : void t.setTimeout(function() {
                            d.complete.call(e[0])
                        }, d.duration)) : void e.animate(k, d) : (e.css(k), void d.complete.call(e[0]))
                    }
                }(),
                removeAlpha: function(n) {
                    if (n instanceof jQuery && (n = n[0]), o < 9 && n) {
                        var t = n.style,
                            i = n.currentStyle,
                            r = i && i.filter || t.filter || "";
                        /alpha/.test(r) && (t.filter = r.replace(/alpha\([^)]*\)/i, ""))
                    }
                },
                forceStyles: function(t, i) {
                    t = n(t);
                    t.attr("style") && t.data("styles", t.attr("style")).removeAttr("style");
                    t.css(i)
                },
                revertStyles: function() {
                    n.each(u.array(arguments), function(t, i) {
                        i = n(i);
                        i.removeAttr("style");
                        i.attr("style", "");
                        i.data("styles") && i.attr("style", i.data("styles")).data("styles", null)
                    })
                },
                moveOut: function(n) {
                    u.forceStyles(n, {
                        position: "absolute",
                        left: -1e4
                    })
                },
                moveIn: function() {
                    u.revertStyles.apply(u, u.array(arguments))
                },
                hide: function(t, i, r) {
                    var f, e, s;
                    r = r || c;
                    f = n(t);
                    t = f[0];
                    f.data("opacity") || f.data("opacity", f.css("opacity"));
                    e = {
                        opacity: 0
                    };
                    i ? (s = o < 9 && t ? function() {
                        u.removeAlpha(t);
                        t.style.visibility = "hidden";
                        r.call(t)
                    } : r, u.animate(t, e, {
                        duration: i,
                        complete: s,
                        stop: !0
                    })) : o < 9 && t ? (u.removeAlpha(t), t.style.visibility = "hidden") : f.css(e)
                },
                show: function(t, i, r) {
                    var f, s, e, h;
                    r = r || c;
                    f = n(t);
                    t = f[0];
                    s = parseFloat(f.data("opacity")) || 1;
                    e = {
                        opacity: s
                    };
                    i ? (o < 9 && (f.css("opacity", 0), t.style.visibility = "visible"), h = o < 9 && t ? function() {
                        1 == e.opacity && u.removeAlpha(t);
                        r.call(t)
                    } : r, u.animate(t, e, {
                        duration: i,
                        complete: h,
                        stop: !0
                    })) : o < 9 && 1 == e.opacity && t ? (u.removeAlpha(t), t.style.visibility = "visible") : f.css(e)
                },
                wait: function(r) {
                    i._waiters = i._waiters || [];
                    r = n.extend({
                        until: pt,
                        success: c,
                        error: function() {
                            i.raise("Could not complete wait function.")
                        },
                        timeout: 3e3
                    }, r);
                    var o, f, e, s = u.timestamp(),
                        h = function() {
                            return f = u.timestamp(), o = f - s, u.removeFromArray(i._waiters, e), r.until(o) ? (r.success(), !1) : "number" == typeof r.timeout && f >= s + r.timeout ? (r.error(), !1) : void i._waiters.push(e = t.setTimeout(h, 10))
                        };
                    i._waiters.push(e = t.setTimeout(h, 10))
                },
                toggleQuality: function(n, t) {
                    (7 === o || 8 === o) && n && "IMG" == n.nodeName.toUpperCase() && ("undefined" == typeof t && (t = "nearest-neighbor" === n.style.msInterpolationMode), n.style.msInterpolationMode = t ? "bicubic" : "nearest-neighbor")
                },
                insertStyleTag: function(t, i) {
                    var r, u;
                    i && n("#" + i).length || (r = e.createElement("style"), (i && (r.id = i), s().head.appendChild(r), r.styleSheet) ? r.styleSheet.cssText = t : (u = e.createTextNode(t), r.appendChild(u)))
                },
                loadScript: function(t, i) {
                    var u = !1,
                        r = n("<script>").attr({
                            src: t,
                            async: !0
                        }).get(0);
                    r.onload = r.onreadystatechange = function() {
                        u || this.readyState && "loaded" !== this.readyState && "complete" !== this.readyState || (u = !0, r.onload = r.onreadystatechange = null, "function" == typeof i && i.call(this, this))
                    };
                    s().head.appendChild(r)
                },
                parseValue: function(n) {
                    if ("number" == typeof n) return n;
                    if ("string" == typeof n) {
                        var t = n.match(/\-?\d|\./g);
                        return t && t.constructor === Array ? 1 * t.join("") : 0
                    }
                    return 0
                },
                timestamp: function() {
                    return (new Date).getTime()
                },
                loadCSS: function(t, f, h) {
                    var l, y, a, v;
                    if (n("link[rel=stylesheet]").each(function() {
                            if (new RegExp(t).test(this.href)) return l = this, !1
                        }), "function" == typeof f && (h = f, f = r), h = h || c, l) return h.call(l, l), l;
                    if (y = e.styleSheets.length, n("#" + f).length) n("#" + f).attr("href", t), y--;
                    else if (l = n("<link>").attr({
                            rel: "stylesheet",
                            href: t,
                            id: f
                        }).get(0), a = n('link[rel="stylesheet"], style'), a.length ? a.get(0).parentNode.insertBefore(l, a[0]) : s().head.appendChild(l), o && y >= 31) return void i.raise("You have reached the browser stylesheet limit (31)", !0);
                    return "function" == typeof h && (v = n("<s>").attr("id", "galleria-loader").hide().appendTo(s().body), u.wait({
                        until: function() {
                            return v.height() > 0
                        },
                        success: function() {
                            v.remove();
                            h.call(l, l)
                        },
                        error: function() {
                            v.remove();
                            i.raise("Theme CSS could not load after 20 sec. " + (i.QUIRK ? "Your browser is in Quirks Mode, please add a correct doctype." : "Please download the latest theme at http://galleria.io/customer/."), !0)
                        },
                        timeout: 5e3
                    })), l
                }
            }
        }(),
        ft = function(t) {
            return u.insertStyleTag(".galleria-videoicon{width:60px;height:60px;position:absolute;top:50%;left:50%;z-index:1;margin:-30px 0 0 -30px;cursor:pointer;background:#000;background:rgba(0,0,0,.8);border-radius:3px;-webkit-transition:all 150ms}.galleria-videoicon i{width:0px;height:0px;border-style:solid;border-width:10px 0 10px 16px;display:block;border-color:transparent transparent transparent #ffffff;margin:20px 0 0 22px}.galleria-image:hover .galleria-videoicon{background:#000}", "galleria-videoicon"), n(u.create("galleria-videoicon")).html("<i><\/i>").appendTo(t).click(function() {
                n(this).siblings("img").mouseup()
            })
        },
        p = function() {
            var t = function(t, i, r, f) {
                var s = this.getOptions("easing"),
                    h = this.getStageWidth(),
                    e = {
                        left: h * (t.rewind ? -1 : 1)
                    },
                    o = {
                        left: 0
                    };
                r ? (e.opacity = 0, o.opacity = 1) : e.opacity = 1;
                n(t.next).css(e);
                u.animate(t.next, o, {
                    duration: t.speed,
                    complete: function(n) {
                        return function() {
                            i();
                            n.css({
                                left: 0
                            })
                        }
                    }(n(t.next).add(t.prev)),
                    queue: !1,
                    easing: s
                });
                f && (t.rewind = !t.rewind);
                t.prev && (e = {
                    left: 0
                }, o = {
                    left: h * (t.rewind ? 1 : -1)
                }, r && (e.opacity = 1, o.opacity = 0), n(t.prev).css(e), u.animate(t.prev, o, {
                    duration: t.speed,
                    queue: !1,
                    easing: s,
                    complete: function() {
                        n(this).css("opacity", 0)
                    }
                }))
            };
            return {
                active: !1,
                init: function(n, t, i) {
                    p.effects.hasOwnProperty(n) && p.effects[n].call(this, t, i)
                },
                effects: {
                    fade: function(t, i) {
                        n(t.next).css({
                            opacity: 0,
                            left: 0
                        });
                        u.animate(t.next, {
                            opacity: 1
                        }, {
                            duration: t.speed,
                            complete: i
                        });
                        t.prev && (n(t.prev).css("opacity", 1).show(), u.animate(t.prev, {
                            opacity: 0
                        }, {
                            duration: t.speed
                        }))
                    },
                    flash: function(t, i) {
                        n(t.next).css({
                            opacity: 0,
                            left: 0
                        });
                        t.prev ? u.animate(t.prev, {
                            opacity: 0
                        }, {
                            duration: t.speed / 2,
                            complete: function() {
                                u.animate(t.next, {
                                    opacity: 1
                                }, {
                                    duration: t.speed,
                                    complete: i
                                })
                            }
                        }) : u.animate(t.next, {
                            opacity: 1
                        }, {
                            duration: t.speed,
                            complete: i
                        })
                    },
                    pulse: function(t, i) {
                        t.prev && n(t.prev).hide();
                        n(t.next).css({
                            opacity: 0,
                            left: 0
                        }).show();
                        u.animate(t.next, {
                            opacity: 1
                        }, {
                            duration: t.speed,
                            complete: i
                        })
                    },
                    slide: function() {
                        t.apply(this, u.array(arguments))
                    },
                    fadeslide: function() {
                        t.apply(this, u.array(arguments).concat([!0]))
                    },
                    doorslide: function() {
                        t.apply(this, u.array(arguments).concat([!1, !0]))
                    }
                }
            }
        }();
    l.listen();
    n.event.special["click:fast"] = {
        propagate: !0,
        add: function(i) {
            var u = function(n) {
                    if (n.touches && n.touches.length) {
                        var t = n.touches[0];
                        return {
                            x: t.pageX,
                            y: t.pageY
                        }
                    }
                },
                r = {
                    touched: !1,
                    touchdown: !1,
                    coords: {
                        x: 0,
                        y: 0
                    },
                    evObj: {}
                };
            n(this).data({
                clickstate: r,
                timer: 0
            }).on("touchstart.fast", function(i) {
                t.clearTimeout(n(this).data("timer"));
                n(this).data("clickstate", {
                    touched: !0,
                    touchdown: !0,
                    coords: u(i.originalEvent),
                    evObj: i
                })
            }).on("touchmove.fast", function(t) {
                var r = u(t.originalEvent),
                    i = n(this).data("clickstate"),
                    f = Math.max(Math.abs(i.coords.x - r.x), Math.abs(i.coords.y - r.y));
                f > 6 && n(this).data("clickstate", n.extend(i, {
                    touchdown: !1
                }))
            }).on("touchend.fast", function(u) {
                var f = n(this),
                    e = f.data("clickstate");
                e.touchdown && i.handler.call(this, u);
                f.data("timer", t.setTimeout(function() {
                    f.data("clickstate", r)
                }, 400))
            }).on("click.fast", function(t) {
                var u = n(this).data("clickstate");
                return !u.touched && (n(this).data("clickstate", r), void i.handler.call(this, t))
            })
        },
        remove: function() {
            n(this).off("touchstart.fast touchmove.fast touchend.fast click.fast")
        }
    };
    h.on("orientationchange", function() {
        n(this).resize()
    });
    i = function() {
        var c = this,
            it, rt;
        this._options = {};
        this._playing = !1;
        this._playtime = 5e3;
        this._active = null;
        this._queue = {
            length: 0
        };
        this._data = [];
        this._dom = {};
        this._thumbnails = [];
        this._layers = [];
        this._initialized = !1;
        this._firstrun = !1;
        this._stageWidth = 0;
        this._stageHeight = 0;
        this._target = r;
        this._binds = [];
        this._id = parseInt(1e4 * f.random(), 10);
        it = "container stage images image-nav image-nav-left image-nav-right info info-text info-title info-description thumbnails thumbnails-list thumbnails-container thumb-nav-left thumb-nav-right loader counter tooltip";
        rt = "current total";
        n.each(it.split(" "), function(n, t) {
            c._dom[t] = u.create("galleria-" + t)
        });
        n.each(rt.split(" "), function(n, t) {
            c._dom[t] = u.create("galleria-" + t, "span")
        });
        var g = this._keyboard = {
                keys: {
                    UP: 38,
                    DOWN: 40,
                    LEFT: 37,
                    RIGHT: 39,
                    RETURN: 13,
                    ESCAPE: 27,
                    BACKSPACE: 8,
                    SPACE: 32
                },
                map: {},
                bound: !1,
                press: function(n) {
                    var t = n.keyCode || n.which;
                    t in g.map && "function" == typeof g.map[t] && g.map[t].call(c, n)
                },
                attach: function(n) {
                    var t, i;
                    for (t in n) n.hasOwnProperty(t) && (i = t.toUpperCase(), i in g.keys ? g.map[g.keys[i]] = n[t] : g.map[i] = n[t]);
                    g.bound || (g.bound = !0, k.on("keydown", g.press))
                },
                detach: function() {
                    g.bound = !1;
                    g.map = {};
                    k.off("keydown", g.press)
                }
            },
            tt = this._controls = {
                0: r,
                1: r,
                active: 0,
                swap: function() {
                    tt.active = tt.active ? 0 : 1
                },
                getActive: function() {
                    return c._options.swipe ? tt.slides[c._active] : tt[tt.active]
                },
                getNext: function() {
                    return c._options.swipe ? tt.slides[c.getNext(c._active)] : tt[1 - tt.active]
                },
                slides: [],
                frames: [],
                layers: []
            },
            v = this._carousel = {
                next: c.$("thumb-nav-right"),
                prev: c.$("thumb-nav-left"),
                width: 0,
                current: 0,
                max: 0,
                hooks: [],
                update: function() {
                    var t = 0,
                        i = 0,
                        r = [0];
                    n.each(c._thumbnails, function(u, e) {
                        if (e.ready) {
                            t += e.outerWidth || n(e.container).outerWidth(!0);
                            var o = n(e.container).width();
                            t += o - f.floor(o);
                            r[u + 1] = t;
                            i = f.max(i, e.outerHeight || n(e.container).outerHeight(!0))
                        }
                    });
                    c.$("thumbnails").css({
                        width: t,
                        height: i
                    });
                    v.max = t;
                    v.hooks = r;
                    v.width = c.$("thumbnails-list").width();
                    v.setClasses();
                    c.$("thumbnails-container").toggleClass("galleria-carousel", t > v.width);
                    v.width = c.$("thumbnails-list").width()
                },
                bindControls: function() {
                    var n;
                    v.next.on("click:fast", function(t) {
                        if (t.preventDefault(), "auto" === c._options.carouselSteps) {
                            for (n = v.current; n < v.hooks.length; n++)
                                if (v.hooks[n] - v.hooks[v.current] > v.width) {
                                    v.set(n - 2);
                                    break
                                }
                        } else v.set(v.current + c._options.carouselSteps)
                    });
                    v.prev.on("click:fast", function(t) {
                        if (t.preventDefault(), "auto" === c._options.carouselSteps)
                            for (n = v.current; n >= 0; n--) {
                                if (v.hooks[v.current] - v.hooks[n] > v.width) {
                                    v.set(n + 2);
                                    break
                                }
                                if (0 === n) {
                                    v.set(0);
                                    break
                                }
                            } else v.set(v.current - c._options.carouselSteps)
                    })
                },
                set: function(n) {
                    for (n = f.max(n, 0); v.hooks[n - 1] + v.width >= v.max && n >= 0;) n--;
                    v.current = n;
                    v.animate()
                },
                getLast: function(n) {
                    return (n || v.current) - 1
                },
                follow: function(n) {
                    if (0 === n || n === v.hooks.length - 2) return void v.set(n);
                    for (var t = v.current; v.hooks[t] - v.hooks[v.current] < v.width && t <= v.hooks.length;) t++;
                    n - 1 < v.current ? v.set(n - 1) : n + 2 > t && v.set(n - t + v.current + 2)
                },
                setClasses: function() {
                    v.prev.toggleClass("disabled", !v.current);
                    v.next.toggleClass("disabled", v.hooks[v.current] + v.width >= v.max)
                },
                animate: function() {
                    v.setClasses();
                    var t = v.hooks[v.current] * -1;
                    isNaN(t) || (c.$("thumbnails").css("left", function() {
                        return n(this).css("left")
                    }), u.animate(c.get("thumbnails"), {
                        left: t
                    }, {
                        duration: c._options.carouselSpeed,
                        easing: c._options.easing,
                        queue: !1
                    }))
                }
            },
            d = this._tooltip = {
                initialized: !1,
                open: !1,
                timer: "tooltip" + c._id,
                swapTimer: "swap" + c._id,
                init: function() {
                    d.initialized = !0;
                    u.insertStyleTag(".galleria-tooltip{padding:3px 8px;max-width:50%;background:#ffe;color:#000;z-index:3;position:absolute;font-size:11px;line-height:1.3;opacity:0;box-shadow:0 0 2px rgba(0,0,0,.4);-moz-box-shadow:0 0 2px rgba(0,0,0,.4);-webkit-box-shadow:0 0 2px rgba(0,0,0,.4);}", "galleria-tooltip");
                    c.$("tooltip").css({
                        opacity: .8,
                        visibility: "visible",
                        display: "none"
                    })
                },
                move: function(n) {
                    var s = c.getMousePosition(n).x,
                        e = c.getMousePosition(n).y,
                        r = c.$("tooltip"),
                        i = s,
                        t = e,
                        u = r.outerHeight(!0) + 1,
                        h = r.outerWidth(!0),
                        o = u + 15,
                        l = c.$("container").width() - h - 2,
                        a = c.$("container").height() - u - 2;
                    isNaN(i) || isNaN(t) || (i += 10, t -= u + 8, i = f.max(0, f.min(l, i)), t = f.max(0, f.min(a, t)), e < o && (t = o), r.css({
                        left: i,
                        top: t
                    }))
                },
                bind: function(t, r) {
                    if (!i.TOUCH) {
                        d.initialized || d.init();
                        var u = function() {
                                c.$("container").off("mousemove", d.move);
                                c.clearTimer(d.timer);
                                c.$("tooltip").stop().animate({
                                    opacity: 0
                                }, 200, function() {
                                    c.$("tooltip").hide();
                                    c.addTimer(d.swapTimer, function() {
                                        d.open = !1
                                    }, 1e3)
                                })
                            },
                            f = function(t, i) {
                                d.define(t, i);
                                n(t).hover(function() {
                                    c.clearTimer(d.swapTimer);
                                    c.$("container").off("mousemove", d.move).on("mousemove", d.move).trigger("mousemove");
                                    d.show(t);
                                    c.addTimer(d.timer, function() {
                                        c.$("tooltip").stop().show().animate({
                                            opacity: 1
                                        });
                                        d.open = !0
                                    }, d.open ? 0 : 500)
                                }, u).click(u)
                            };
                        "string" == typeof r ? f(t in c._dom ? c.get(t) : t, r) : n.each(t, function(n, t) {
                            f(c.get(n), t)
                        })
                    }
                },
                show: function(i) {
                    i = n(i in c._dom ? c.get(i) : i);
                    var r = i.data("tt"),
                        u = function(n) {
                            t.setTimeout(function(n) {
                                return function() {
                                    d.move(n)
                                }
                            }(n), 10);
                            i.off("mouseup", u)
                        };
                    r = "function" == typeof r ? r() : r;
                    r && (c.$("tooltip").html(r.replace(/\s/, "&#160;")), i.on("mouseup", u))
                },
                define: function(t, i) {
                    if ("function" != typeof i) {
                        var r = i;
                        i = function() {
                            return r
                        }
                    }
                    t = n(t in c._dom ? c.get(t) : t).data("tt", i);
                    d.show(t)
                }
            },
            w = this._fullscreen = {
                scrolled: 0,
                crop: r,
                active: !1,
                prev: n(),
                beforeEnter: function(n) {
                    n()
                },
                beforeExit: function(n) {
                    n()
                },
                keymap: c._keyboard.map,
                parseCallback: function(t, i) {
                    return p.active ? function() {
                        "function" == typeof t && t.call(c);
                        var r = c._controls.getActive(),
                            u = c._controls.getNext();
                        c._scaleImage(u);
                        c._scaleImage(r);
                        i && c._options.trueFullscreen && n(r.container).add(u.container).trigger("transitionend")
                    } : t
                },
                enter: function(n) {
                    w.beforeEnter(function() {
                        n = w.parseCallback(n, !0);
                        c._options.trueFullscreen && l.support ? (w.active = !0, u.forceStyles(c.get("container"), {
                            width: "100%",
                            height: "100%"
                        }), c.rescale(), i.MAC ? i.SAFARI && /version\/[1-5]/.test(y) ? (c.$("stage").css("opacity", 0), t.setTimeout(function() {
                            w.scale();
                            c.$("stage").css("opacity", 1)
                        }, 4)) : (c.$("container").css("opacity", 0).addClass("fullscreen"), t.setTimeout(function() {
                            w.scale();
                            c.$("container").css("opacity", 1)
                        }, 50)) : c.$("container").addClass("fullscreen"), h.resize(w.scale), l.enter(c, n, c.get("container"))) : (w.scrolled = h.scrollTop(), i.TOUCH || t.scrollTo(0, 0), w._enter(n))
                    })
                },
                _enter: function(f) {
                    w.active = !0;
                    nt && (w.iframe = function() {
                        var f, o = e.referrer,
                            r = e.createElement("a"),
                            u = t.location;
                        return r.href = o, r.protocol != u.protocol || r.hostname != u.hostname || r.port != u.port ? (i.raise("Parent fullscreen not available. Iframe protocol, domains and ports must match."), !1) : (w.pd = t.parent.document, n(w.pd).find("iframe").each(function() {
                            var n = this.contentDocument || this.contentWindow.document;
                            if (n === e) return f = this, !1
                        }), f)
                    }());
                    u.hide(c.getActiveImage());
                    nt && w.iframe && (w.iframe.scrolled = n(t.parent).scrollTop(), t.parent.scrollTo(0, 0));
                    var o = c.getData(),
                        v = c._options,
                        p = !c._options.trueFullscreen || !l.support,
                        a = {
                            height: "100%",
                            overflow: "hidden",
                            margin: 0,
                            padding: 0
                        };
                    if (p && (c.$("container").addClass("fullscreen"), w.prev = c.$("container").prev(), w.prev.length || (w.parent = c.$("container").parent()), c.$("container").appendTo("body"), u.forceStyles(c.get("container"), {
                            position: i.TOUCH ? "absolute" : "fixed",
                            top: 0,
                            left: 0,
                            width: "100%",
                            height: "100%",
                            zIndex: 1e4
                        }), u.forceStyles(s().html, a), u.forceStyles(s().body, a)), nt && w.iframe && (u.forceStyles(w.pd.documentElement, a), u.forceStyles(w.pd.body, a), u.forceStyles(w.iframe, n.extend(a, {
                            width: "100%",
                            height: "100%",
                            top: 0,
                            left: 0,
                            position: "fixed",
                            zIndex: 1e4,
                            border: "none"
                        }))), w.keymap = n.extend({}, c._keyboard.map), c.attachKeyboard({
                            escape: c.exitFullscreen,
                            right: c.next,
                            left: c.prev
                        }), w.crop = v.imageCrop, v.fullscreenCrop != r && (v.imageCrop = v.fullscreenCrop), o && o.big && o.image !== o.big) {
                        var k = new i.Picture,
                            d = k.isCached(o.big),
                            y = c.getIndex(),
                            g = c._thumbnails[y];
                        c.trigger({
                            type: i.LOADSTART,
                            cached: d,
                            rewind: !1,
                            index: y,
                            imageTarget: c.getActiveImage(),
                            thumbTarget: g,
                            galleriaData: o
                        });
                        k.load(o.big, function(t) {
                            c._scaleImage(t, {
                                complete: function(t) {
                                    c.trigger({
                                        type: i.LOADFINISH,
                                        cached: d,
                                        index: y,
                                        rewind: !1,
                                        imageTarget: t.image,
                                        thumbTarget: g
                                    });
                                    var r = c._controls.getActive().image;
                                    r && n(r).width(t.image.width).height(t.image.height).attr("style", n(t.image).attr("style")).attr("src", t.image.src)
                                }
                            })
                        });
                        var tt = c.getNext(y),
                            it = new i.Picture,
                            b = c.getData(tt);
                        it.preload(c.isFullscreen() && b.big ? b.big : b.image)
                    }
                    c.rescale(function() {
                        c.addTimer(!1, function() {
                            p && u.show(c.getActiveImage());
                            "function" == typeof f && f.call(c);
                            c.rescale()
                        }, 100);
                        c.trigger(i.FULLSCREEN_ENTER)
                    });
                    p ? h.resize(w.scale) : u.show(c.getActiveImage())
                },
                scale: function() {
                    c.rescale()
                },
                exit: function(n) {
                    w.beforeExit(function() {
                        n = w.parseCallback(n);
                        c._options.trueFullscreen && l.support ? l.exit(n) : w._exit(n)
                    })
                },
                _exit: function(n) {
                    var e, o, r, a, f;
                    w.active = !1;
                    e = !c._options.trueFullscreen || !l.support;
                    o = c.$("container").removeClass("fullscreen");
                    (w.parent ? w.parent.prepend(o) : o.insertAfter(w.prev), e) && (u.hide(c.getActiveImage()), u.revertStyles(c.get("container"), s().html, s().body), i.TOUCH || t.scrollTo(0, w.scrolled), r = c._controls.frames[c._controls.active], r && r.image && (r.image.src = r.image.src));
                    nt && w.iframe && (u.revertStyles(w.pd.documentElement, w.pd.body, w.iframe), w.iframe.scrolled && t.parent.scrollTo(0, w.iframe.scrolled));
                    c.detachKeyboard();
                    c.attachKeyboard(w.keymap);
                    c._options.imageCrop = w.crop;
                    a = c.getData().big;
                    f = c._controls.getActive().image;
                    !c.getData().iframe && f && a && a == f.src && t.setTimeout(function(n) {
                        return function() {
                            f.src = n
                        }
                    }(c.getData().image), 1);
                    c.rescale(function() {
                        c.addTimer(!1, function() {
                            e && u.show(c.getActiveImage());
                            "function" == typeof n && n.call(c);
                            h.trigger("resize")
                        }, 50);
                        c.trigger(i.FULLSCREEN_EXIT)
                    });
                    h.off("resize", w.scale)
                }
            },
            b = this._idle = {
                trunk: [],
                bound: !1,
                active: !1,
                add: function(t, r, u, f) {
                    if (t && !i.TOUCH) {
                        b.bound || b.addEvent();
                        t = n(t);
                        "boolean" == typeof u && (f = u, u = {});
                        u = u || {};
                        var e, o = {};
                        for (e in r) r.hasOwnProperty(e) && (o[e] = t.css(e));
                        t.data("idle", {
                            from: n.extend(o, u),
                            to: r,
                            complete: !0,
                            busy: !1
                        });
                        f ? t.css(r) : b.addTimer();
                        b.trunk.push(t)
                    }
                },
                remove: function(t) {
                    t = n(t);
                    n.each(b.trunk, function(n, i) {
                        i && i.length && !i.not(t).length && (t.css(t.data("idle").from), b.trunk.splice(n, 1))
                    });
                    b.trunk.length || (b.removeEvent(), c.clearTimer(b.timer))
                },
                addEvent: function() {
                    b.bound = !0;
                    c.$("container").on("mousemove click", b.showAll);
                    "hover" == c._options.idleMode && c.$("container").on("mouseleave", b.hide)
                },
                removeEvent: function() {
                    b.bound = !1;
                    c.$("container").on("mousemove click", b.showAll);
                    "hover" == c._options.idleMode && c.$("container").off("mouseleave", b.hide)
                },
                addTimer: function() {
                    "hover" != c._options.idleMode && c.addTimer("idle", function() {
                        b.hide()
                    }, c._options.idleTime)
                },
                hide: function() {
                    if (c._options.idleMode && c.getIndex() !== !1) {
                        c.trigger(i.IDLE_ENTER);
                        var t = b.trunk.length;
                        n.each(b.trunk, function(n, i) {
                            var r = i.data("idle");
                            r && (i.data("idle").complete = !1, u.animate(i, r.to, {
                                duration: c._options.idleSpeed,
                                complete: function() {
                                    n == t - 1 && (b.active = !1)
                                }
                            }))
                        })
                    }
                },
                showAll: function() {
                    c.clearTimer("idle");
                    n.each(b.trunk, function(n, t) {
                        b.show(t)
                    })
                },
                show: function(t) {
                    var r = t.data("idle");
                    b.active && (r.busy || r.complete) || (r.busy = !0, c.trigger(i.IDLE_EXIT), c.clearTimer("idle"), u.animate(t, r.from, {
                        duration: c._options.idleSpeed / 2,
                        complete: function() {
                            b.active = !0;
                            n(t).data("idle").busy = !1;
                            n(t).data("idle").complete = !0
                        }
                    }));
                    b.addTimer()
                }
            },
            a = this._lightbox = {
                width: 0,
                height: 0,
                initialized: !1,
                active: null,
                image: null,
                elems: {},
                keymap: !1,
                init: function() {
                    if (!a.initialized) {
                        a.initialized = !0;
                        var r = {},
                            e = c._options,
                            h = "",
                            t = "position:absolute;",
                            f = "lightbox-",
                            l = {
                                overlay: "position:fixed;display:none;opacity:" + e.overlayOpacity + ";filter:alpha(opacity=" + 100 * e.overlayOpacity + ");top:0;left:0;width:100%;height:100%;background:" + e.overlayBackground + ";z-index:99990",
                                box: "position:fixed;display:none;width:400px;height:400px;top:50%;left:50%;margin-top:-200px;margin-left:-200px;z-index:99991",
                                shadow: t + "background:#000;width:100%;height:100%;",
                                content: t + "background-color:#fff;top:10px;left:10px;right:10px;bottom:10px;overflow:hidden",
                                info: t + "bottom:10px;left:10px;right:10px;color:#444;font:11px/13px arial,sans-serif;height:13px",
                                close: t + "top:10px;right:10px;height:20px;width:20px;background:#fff;text-align:center;cursor:pointer;color:#444;font:16px/22px arial,sans-serif;z-index:99999",
                                image: t + "top:10px;left:10px;right:10px;bottom:30px;overflow:hidden;display:block;",
                                prevholder: t + "width:50%;top:0;bottom:40px;cursor:pointer;",
                                nextholder: t + "width:50%;top:0;bottom:40px;right:-1px;cursor:pointer;",
                                prev: t + "top:50%;margin-top:-20px;height:40px;width:30px;background:#fff;left:20px;display:none;text-align:center;color:#000;font:bold 16px/36px arial,sans-serif",
                                next: t + "top:50%;margin-top:-20px;height:40px;width:30px;background:#fff;right:20px;left:auto;display:none;font:bold 16px/36px arial,sans-serif;text-align:center;color:#000",
                                title: "float:left",
                                counter: "float:right;margin-left:8px;"
                            },
                            p = function(t) {
                                return t.hover(function() {
                                    n(this).css("color", "#bbb")
                                }, function() {
                                    n(this).css("color", "#444")
                                })
                            },
                            y = {},
                            v = "";
                        v = o > 7 ? o < 9 ? "background:#000;filter:alpha(opacity=0);" : "background:rgba(0,0,0,0);" : "z-index:99999";
                        l.nextholder += v;
                        l.prevholder += v;
                        n.each(l, function(n, t) {
                            h += ".galleria-" + f + n + "{" + t + "}"
                        });
                        h += ".galleria-" + f + "box.iframe .galleria-" + f + "prevholder,.galleria-" + f + "box.iframe .galleria-" + f + "nextholder{width:100px;height:100px;top:50%;margin-top:-70px}";
                        u.insertStyleTag(h, "galleria-lightbox");
                        n.each("overlay box content shadow title info close prevholder prev nextholder next counter image".split(" "), function(n, t) {
                            c.addElement("lightbox-" + t);
                            r[t] = a.elems[t] = c.get("lightbox-" + t)
                        });
                        a.image = new i.Picture;
                        n.each({
                            box: "shadow content close prevholder nextholder",
                            info: "title counter",
                            content: "info image",
                            prevholder: "prev",
                            nextholder: "next"
                        }, function(t, i) {
                            var r = [];
                            n.each(i.split(" "), function(n, t) {
                                r.push(f + t)
                            });
                            y[f + t] = r
                        });
                        c.append(y);
                        n(r.image).append(a.image.container);
                        n(s().body).append(r.overlay, r.box);
                        p(n(r.close).on("click:fast", a.hide).html("&#215;"));
                        n.each(["Prev", "Next"], function(t, u) {
                            var f = n(r[u.toLowerCase()]).html(/v/.test(u) ? "&#8249;&#160;" : "&#160;&#8250;"),
                                e = n(r[u.toLowerCase() + "holder"]);
                            return e.on("click:fast", function() {
                                a["show" + u]()
                            }), o < 8 || i.TOUCH ? void f.show() : void e.hover(function() {
                                f.show()
                            }, function() {
                                f.stop().fadeOut(200)
                            })
                        });
                        n(r.overlay).on("click:fast", a.hide);
                        i.IPAD && (c._options.lightboxTransitionSpeed = 0)
                    }
                },
                rescale: function(t) {
                    var l = f.min(h.width() - 40, a.width),
                        v = f.min(h.height() - 60, a.height),
                        r = f.min(l / a.width, v / a.height),
                        e = f.round(a.width * r) + 40,
                        o = f.round(a.height * r) + 60,
                        s = {
                            width: e,
                            height: o,
                            "margin-top": f.ceil(o / 2) * -1,
                            "margin-left": f.ceil(e / 2) * -1
                        };
                    t ? n(a.elems.box).css(s) : n(a.elems.box).animate(s, {
                        duration: c._options.lightboxTransitionSpeed,
                        easing: c._options.easing,
                        complete: function() {
                            var t = a.image,
                                r = c._options.lightboxFadeSpeed;
                            c.trigger({
                                type: i.LIGHTBOX_IMAGE,
                                imageTarget: t.image
                            });
                            n(t.container).show();
                            n(t.image).animate({
                                opacity: 1
                            }, r);
                            u.show(a.elems.info, r)
                        }
                    })
                },
                hide: function() {
                    a.image.image = null;
                    h.off("resize", a.rescale);
                    n(a.elems.box).hide().find("iframe").remove();
                    u.hide(a.elems.info);
                    c.detachKeyboard();
                    c.attachKeyboard(a.keymap);
                    a.keymap = !1;
                    u.hide(a.elems.overlay, 200, function() {
                        n(this).hide().css("opacity", c._options.overlayOpacity);
                        c.trigger(i.LIGHTBOX_CLOSE)
                    })
                },
                showNext: function() {
                    a.show(c.getNext(a.active))
                },
                showPrev: function() {
                    a.show(c.getPrev(a.active))
                },
                show: function(r) {
                    a.active = r = "number" == typeof r ? r : c.getIndex() || 0;
                    a.initialized || a.init();
                    c.trigger(i.LIGHTBOX_OPEN);
                    a.keymap || (a.keymap = n.extend({}, c._keyboard.map), c.attachKeyboard({
                        escape: a.hide,
                        right: a.showNext,
                        left: a.showPrev
                    }));
                    h.off("resize", a.rescale);
                    var s, y, l, e = c.getData(r),
                        p = c.getDataLength(),
                        v = c.getNext(r);
                    u.hide(a.elems.info);
                    try {
                        for (l = c._options.preload; l > 0; l--) y = new i.Picture, s = c.getData(v), y.preload(s.big ? s.big : s.image), v = c.getNext(v)
                    } catch (n) {}
                    a.image.isIframe = e.iframe && !e.image;
                    n(a.elems.box).toggleClass("iframe", a.image.isIframe);
                    n(a.image.container).find(".galleria-videoicon").remove();
                    a.image.load(e.big || e.image || e.iframe, function(i) {
                        var u, s, l, v;
                        i.isIframe ? (u = n(t).width(), s = n(t).height(), i.video && c._options.maxVideoSize && (l = f.min(c._options.maxVideoSize / u, c._options.maxVideoSize / s), l < 1 && (u *= l, s *= l)), a.width = u, a.height = s) : (a.width = i.original.width, a.height = i.original.height);
                        (n(i.image).css({
                            width: i.isIframe ? "100%" : "100.1%",
                            height: i.isIframe ? "100%" : "100.1%",
                            top: 0,
                            bottom: 0,
                            zIndex: 99998,
                            opacity: 0,
                            visibility: "visible"
                        }).parent().height("100%"), a.elems.title.innerHTML = e.title || "", a.elems.counter.innerHTML = r + 1 + " / " + p, h.resize(a.rescale), a.rescale(), e.image && e.iframe) && ((n(a.elems.box).addClass("iframe"), e.video) && (v = ft(i.container).hide(), t.setTimeout(function() {
                            v.fadeIn(200)
                        }, 200)), n(i.image).css("cursor", "pointer").mouseup(function(t, i) {
                            return function(r) {
                                n(a.image.container).find(".galleria-videoicon").remove();
                                r.preventDefault();
                                i.isIframe = !0;
                                i.load(t.iframe + (t.video ? "&autoplay=1" : ""), {
                                    width: "100%",
                                    height: o < 8 ? n(a.image.container).height() : "100%"
                                })
                            }
                        }(e, i)))
                    });
                    n(a.elems.overlay).show().css("visibility", "visible");
                    n(a.elems.box).show()
                }
            },
            ut = this._timer = {
                trunk: {},
                add: function(n, i, r, u) {
                    if (n = n || (new Date).getTime(), u = u || !1, this.clear(n), u) {
                        var f = i;
                        i = function() {
                            f();
                            ut.add(n, i, r)
                        }
                    }
                    this.trunk[n] = t.setTimeout(i, r)
                },
                clear: function(n) {
                    var i, r = function(n) {
                        t.clearTimeout(this.trunk[n]);
                        delete this.trunk[n]
                    };
                    if (n && n in this.trunk) r.call(this, n);
                    else if ("undefined" == typeof n)
                        for (i in this.trunk) this.trunk.hasOwnProperty(i) && r.call(this, i)
                }
            };
        return this
    };
    i.prototype = {
        constructor: i,
        init: function(t, u) {
            if (u = ht(u), this._original = {
                    target: t,
                    options: u,
                    data: null
                }, this._target = this._dom.target = t.nodeName ? t : n(t).get(0), this._original.html = this._target.innerHTML, w.push(this), !this._target) return void i.raise("Target not found", !0);
            if (this._options = {
                    autoplay: !1,
                    carousel: !0,
                    carouselFollow: !0,
                    carouselSpeed: 400,
                    carouselSteps: "auto",
                    clicknext: !1,
                    dailymotion: {
                        foreground: "%23EEEEEE",
                        highlight: "%235BCEC5",
                        background: "%23222222",
                        logo: 0,
                        hideInfos: 1
                    },
                    dataConfig: function() {
                        return {}
                    },
                    dataSelector: "img",
                    dataSort: !1,
                    dataSource: this._target,
                    debug: r,
                    dummy: r,
                    easing: "galleria",
                    extend: function() {},
                    fullscreenCrop: r,
                    fullscreenDoubleTap: !0,
                    fullscreenTransition: r,
                    height: 0,
                    idleMode: !0,
                    idleTime: 3e3,
                    idleSpeed: 200,
                    imageCrop: !1,
                    imageMargin: 0,
                    imagePan: !1,
                    imagePanSmoothness: 12,
                    imagePosition: "50%",
                    imageTimeout: r,
                    initialTransition: r,
                    keepSource: !1,
                    layerFollow: !0,
                    lightbox: !1,
                    lightboxFadeSpeed: 200,
                    lightboxTransitionSpeed: 200,
                    linkSourceImages: !0,
                    maxScaleRatio: r,
                    maxVideoSize: r,
                    minScaleRatio: r,
                    overlayOpacity: .85,
                    overlayBackground: "#0b0b0b",
                    pauseOnInteraction: !0,
                    popupLinks: !1,
                    preload: 2,
                    queue: !0,
                    responsive: !0,
                    show: 0,
                    showInfo: !0,
                    showCounter: !0,
                    showImagenav: !0,
                    swipe: "auto",
                    theme: null,
                    thumbCrop: !0,
                    thumbEventType: "click:fast",
                    thumbMargin: 0,
                    thumbQuality: "auto",
                    thumbDisplayOrder: !0,
                    thumbPosition: "50%",
                    thumbnails: !0,
                    touchTransition: r,
                    transition: "fade",
                    transitionInitial: r,
                    transitionSpeed: 400,
                    trueFullscreen: !0,
                    useCanvas: !1,
                    variation: "",
                    videoPoster: !0,
                    vimeo: {
                        title: 0,
                        byline: 0,
                        portrait: 0,
                        color: "aaaaaa"
                    },
                    wait: 5e3,
                    width: "auto",
                    youtube: {
                        modestbranding: 1,
                        autohide: 1,
                        color: "white",
                        hd: 1,
                        rel: 0,
                        showinfo: 0
                    }
                }, this._options.initialTransition = this._options.initialTransition || this._options.transitionInitial, u && (u.debug === !1 && (et = !1), "number" == typeof u.imageTimeout && (yt = u.imageTimeout), "string" == typeof u.dummy && (tt = u.dummy), "string" == typeof u.theme && (this._options.theme = u.theme)), n(this._target).children().hide(), i.QUIRK && i.raise("Your page is in Quirks mode, Galleria may not render correctly. Please validate your HTML and add a correct doctype."), b.length)
                if (this._options.theme) {
                    for (var f = 0; f < b.length; f++)
                        if (this._options.theme === b[f].name) {
                            this.theme = b[f];
                            break
                        }
                } else this.theme = b[0];
            return "object" == typeof this.theme ? this._init() : vt.push(this), this
        },
        _init: function() {
            var s = this,
                c = this._options,
                v, l;
            return this._initialized ? (i.raise("Init failed: Gallery instance already initialized."), this) : (this._initialized = !0, !this.theme) ? (i.raise("Init failed: No theme found.", !0), this) : ((n.extend(!0, c, this.theme.defaults, this._original.options, i.configure.options), c.swipe = function(n) {
                return "enforced" == n || n !== !1 && "disabled" != n && !!i.TOUCH
            }(c.swipe), c.swipe && (c.clicknext = !1, c.imagePan = !1), function(n) {
                return "getContext" in n ? void(a = a || {
                    elem: n,
                    context: n.getContext("2d"),
                    cache: {},
                    length: 0
                }) : void(n = null)
            }(e.createElement("canvas")), this.bind(i.DATA, function() {
                var e, n, r;
                t.screen && t.screen.width && Array.prototype.forEach && this._data.forEach(function(n) {
                    var i = "devicePixelRatio" in t ? t.devicePixelRatio : 1,
                        r = f.max(t.screen.width, t.screen.height);
                    r * i < 1024 && (n.big = n.image)
                });
                this._original.data = this._data;
                this.get("total").innerHTML = this.getDataLength();
                e = this.$("container");
                s._options.height < 2 && (s._userRatio = s._ratio = s._options.height);
                n = {
                    width: 0,
                    height: 0
                };
                r = function() {
                    return s.$("stage").height()
                };
                u.wait({
                    until: function() {
                        return n = s._getWH(), e.width(n.width).height(n.height), r() && n.width && n.height > 50
                    },
                    success: function() {
                        s._width = n.width;
                        s._height = n.height;
                        s._ratio = s._ratio || n.height / n.width;
                        i.WEBKIT ? t.setTimeout(function() {
                            s._run()
                        }, 1) : s._run()
                    },
                    error: function() {
                        r() ? i.raise("Could not extract sufficient width/height of the gallery container. Traced measures: width:" + n.width + "px, height: " + n.height + "px.", !0) : i.raise("Could not extract a stage height from the CSS. Traced height: " + r() + "px.", !0)
                    },
                    timeout: "number" == typeof this._options.wait && this._options.wait
                })
            }), this.append({
                "info-text": ["info-title", "info-description"],
                info: ["info-text"],
                "image-nav": ["image-nav-right", "image-nav-left"],
                stage: ["images", "loader", "counter", "image-nav"],
                "thumbnails-list": ["thumbnails"],
                "thumbnails-container": ["thumb-nav-left", "thumbnails-list", "thumb-nav-right"],
                container: ["stage", "thumbnails-container", "info", "tooltip"]
            }), u.hide(this.$("counter").append(this.get("current"), e.createTextNode(" / "), this.get("total"))), this.setCounter("&#8211;"), u.hide(s.get("tooltip")), this.$("container").addClass([i.TOUCH ? "touch" : "notouch", this._options.variation, "galleria-theme-" + this.theme.name].join(" ")), this._options.swipe || n.each(new Array(2), function(t) {
                var r = new i.Picture,
                    f;
                n(r.container).css({
                    position: "absolute",
                    top: 0,
                    left: 0
                }).prepend(s._layers[t] = n(u.create("galleria-layer")).css({
                    position: "absolute",
                    top: 0,
                    left: 0,
                    right: 0,
                    bottom: 0,
                    zIndex: 2
                })[0]);
                s.$("images").append(r.container);
                s._controls[t] = r;
                f = new i.Picture;
                f.isIframe = !0;
                n(f.container).attr("class", "galleria-frame").css({
                    position: "absolute",
                    top: 0,
                    left: 0,
                    zIndex: 4,
                    background: "#000",
                    display: "none"
                }).appendTo(r.container);
                s._controls.frames[t] = f
            }), this.$("images").css({
                position: "relative",
                top: 0,
                left: 0,
                width: "100%",
                height: "100%"
            }), c.swipe && (this.$("images").css({
                position: "absolute",
                top: 0,
                left: 0,
                width: 0,
                height: "100%"
            }), this.finger = new i.Finger(this.get("stage"), {
                onchange: function(n) {
                    s.pause().show(n)
                },
                oncomplete: function(t) {
                    var i = f.max(0, f.min(parseInt(t, 10), s.getDataLength() - 1)),
                        r = s.getData(i);
                    n(s._thumbnails[i].container).addClass("active").siblings(".active").removeClass("active");
                    r && (s.$("images").find(".galleria-frame").css("opacity", 0).hide().find("iframe").remove(), s._options.carousel && s._options.carouselFollow && s._carousel.follow(i))
                }
            }), this.bind(i.RESCALE, function() {
                this.finger.setup()
            }), this.$("stage").on("click", function() {
                var i = s.getData();
                if (i) {
                    if (i.iframe) {
                        s.isPlaying() && s.pause();
                        var u = s._controls.frames[s._active],
                            f = s._stageWidth,
                            e = s._stageHeight;
                        return n(u.container).find("iframe").length ? void 0 : (n(u.container).css({
                            width: f,
                            height: e,
                            opacity: 0
                        }).show().animate({
                            opacity: 1
                        }, 200), void t.setTimeout(function() {
                            u.load(i.iframe + (i.video ? "&autoplay=1" : ""), {
                                width: f,
                                height: e
                            }, function(n) {
                                s.$("container").addClass("videoplay");
                                n.scale({
                                    width: s._stageWidth,
                                    height: s._stageHeight,
                                    iframelimit: i.video ? s._options.maxVideoSize : r
                                })
                            })
                        }, 100))
                    }
                    i.link && (s._options.popupLinks ? t.open(i.link, "_blank") : t.location.href = i.link)
                }
            }), this.bind(i.IMAGE, function(t) {
                var i;
                s.setCounter(t.index);
                s.setInfo(t.index);
                var r = this.getNext(),
                    u = this.getPrev(),
                    f = [u, r];
                f.push(this.getNext(r), this.getPrev(u), s._controls.slides.length - 1);
                i = [];
                n.each(f, function(t, r) {
                    n.inArray(r, i) == -1 && i.push(r)
                });
                n.each(i, function(t, i) {
                    var r = s.getData(i),
                        u = s._controls.slides[i],
                        f = s.isFullscreen() && r.big ? r.big : r.image || r.iframe;
                    r.iframe && !r.image && (u.isIframe = !0);
                    u.ready || s._controls.slides[i].load(f, function(t) {
                        t.isIframe || n(t.image).css("visibility", "hidden");
                        s._scaleImage(t, {
                            complete: function(t) {
                                t.isIframe || n(t.image).css({
                                    opacity: 0,
                                    visibility: "visible"
                                }).animate({
                                    opacity: 1
                                }, 200)
                            }
                        })
                    })
                })
            })), this.$("thumbnails, thumbnails-list").css({
                overflow: "hidden",
                position: "relative"
            }), this.$("image-nav-right, image-nav-left").on("click:fast", function() {
                c.pauseOnInteraction && s.pause();
                var n = /right/.test(this.className) ? "next" : "prev";
                s[n]()
            }).on("click", function(n) {
                n.preventDefault();
                (c.clicknext || c.swipe) && n.stopPropagation()
            }), n.each(["info", "counter", "image-nav"], function(n, t) {
                c["show" + t.substr(0, 1).toUpperCase() + t.substr(1).replace(/-/, "")] === !1 && u.moveOut(s.get(t.toLowerCase()))
            }), this.load(), c.keepSource || o || (this._target.innerHTML = ""), this.get("errors") && this.appendChild("target", "errors"), this.appendChild("target", "container"), c.carousel) && (v = 0, l = c.show, this.bind(i.THUMBNAIL, function() {
                this.updateCarousel();
                ++v == this.getDataLength() && "number" == typeof l && l > 0 && this._carousel.follow(l)
            })), c.responsive && h.on("resize", function() {
                s.isFullscreen() || s.resize()
            }), c.fullscreenDoubleTap && this.$("stage").on("touchstart", function() {
                var n, t, i, f, e, r, o = function(n) {
                    return n.originalEvent.touches ? n.originalEvent.touches[0] : n
                };
                return s.$("stage").on("touchmove", function() {
                        n = 0
                    }),
                    function(h) {
                        if (!/(-left|-right)/.test(h.target.className)) {
                            if (r = u.timestamp(), t = o(h).pageX, i = o(h).pageY, h.originalEvent.touches.length < 2 && r - n < 300 && t - f < 20 && i - e < 20) return s.toggleFullscreen(), void h.preventDefault();
                            n = r;
                            f = t;
                            e = i
                        }
                    }
            }()), n.each(i.on.binds, function(t, i) {
                n.inArray(i.hash, s._binds) == -1 && s.bind(i.type, i.callback)
            }), this)
        },
        addTimer: function() {
            return this._timer.add.apply(this._timer, u.array(arguments)), this
        },
        clearTimer: function() {
            return this._timer.clear.apply(this._timer, u.array(arguments)), this
        },
        _getWH: function() {
            var r, e = this.$("container"),
                o = this.$("target"),
                t = this,
                i = {};
            return n.each(["width", "height"], function(n, s) {
                t._options[s] && "number" == typeof t._options[s] ? i[s] = t._options[s] : (r = [u.parseValue(e.css(s)), u.parseValue(o.css(s)), e[s](), o[s]()], t["_" + s] || r.splice(r.length, u.parseValue(e.css("min-" + s)), u.parseValue(o.css("min-" + s))), i[s] = f.max.apply(f, r))
            }), t._userRatio && (i.height = i.width * t._userRatio), i
        },
        _createThumbnails: function(r) {
            this.get("total").innerHTML = this.getDataLength();
            var y, f, l, a, c = this,
                s = this._options,
                h = r ? this._data.length - r.length : 0,
                g = h,
                p = [],
                w = 0,
                nt = o < 8 ? "http://upload.wikimedia.org/wikipedia/commons/c/c0/Blank.gif" : "data:image/gif;base64,R0lGODlhAQABAPABAP///wAAACH5BAEKAAAALAAAAAABAAEAAAICRAEAOw%3D%3D",
                tt = function() {
                    var n = c.$("thumbnails").find(".active");
                    return !!n.length && n.find("img").attr("src")
                }(),
                v = "string" == typeof s.thumbnails ? s.thumbnails.toLowerCase() : null,
                b = function(n) {
                    return e.defaultView && e.defaultView.getComputedStyle ? e.defaultView.getComputedStyle(f.container, null)[n] : a.css(n)
                },
                it = function(t, r, u) {
                    return function() {
                        n(u).append(t);
                        c.trigger({
                            type: i.THUMBNAIL,
                            thumbTarget: t,
                            index: r,
                            galleriaData: c.getData(r)
                        })
                    }
                },
                rt = function(t) {
                    s.pauseOnInteraction && c.pause();
                    var i = n(t.currentTarget).data("index");
                    c.getIndex() !== i && c.show(i);
                    t.preventDefault()
                },
                k = function(t, r) {
                    n(t.container).css("visibility", "visible");
                    c.trigger({
                        type: i.THUMBNAIL,
                        thumbTarget: t.image,
                        index: t.data.order,
                        galleriaData: c.getData(t.data.order)
                    });
                    "function" == typeof r && r.call(c, t)
                },
                d = function(t, i) {
                    t.scale({
                        width: t.data.width,
                        height: t.data.height,
                        crop: s.thumbCrop,
                        margin: s.thumbMargin,
                        canvas: s.useCanvas,
                        position: s.thumbPosition,
                        complete: function(t) {
                            var f, r, e = ["left", "top"];
                            c.getData(t.index);
                            n.each(["Width", "Height"], function(i, u) {
                                f = u.toLowerCase();
                                s.thumbCrop === !0 && s.thumbCrop !== f || (r = {}, r[f] = t[f], n(t.container).css(r), r = {}, r[e[i]] = 0, n(t.image).css(r));
                                t["outer" + u] = n(t.container)["outer" + u](!0)
                            });
                            u.toggleQuality(t.image, s.thumbQuality === !0 || "auto" === s.thumbQuality && t.original.width < 3 * t.width);
                            s.thumbDisplayOrder && !t.lazy ? n.each(p, function(n, t) {
                                if (n === w && t.ready && !t.displayed) return w++, t.displayed = !0, void k(t, i)
                            }) : k(t, i)
                        }
                    })
                };
            for (r || (this._thumbnails = [], this.$("thumbnails").empty()); this._data[h]; h++) l = this._data[h], y = l.thumb || l.image, s.thumbnails !== !0 && "lazy" != v || !l.thumb && !l.image ? l.iframe && null !== v || "empty" === v || "numbers" === v ? (f = {
                container: u.create("galleria-image"),
                image: u.create("img", "span"),
                ready: !0,
                data: {
                    order: h
                }
            }, "numbers" === v && n(f.image).text(h + 1), l.iframe && n(f.image).addClass("iframe"), this.$("thumbnails").append(f.container), t.setTimeout(it(f.image, h, f.container), 50 + 20 * h)) : f = {
                container: null,
                image: null
            } : (f = new i.Picture(h), f.index = h, f.displayed = !1, f.lazy = !1, f.video = !1, this.$("thumbnails").append(f.container), a = n(f.container), a.css("visibility", "hidden"), f.data = {
                width: u.parseValue(b("width")),
                height: u.parseValue(b("height")),
                order: h,
                src: y
            }, s.thumbCrop !== !0 ? a.css({
                width: "auto",
                height: "auto"
            }) : a.css({
                width: f.data.width,
                height: f.data.height
            }), "lazy" == v ? (a.addClass("lazy"), f.lazy = !0, f.load(nt, {
                height: f.data.height,
                width: f.data.width
            })) : f.load(y, d), "all" === s.preload && f.preload(l.image)), n(f.container).add(s.keepSource && s.linkSourceImages ? l.original : null).data("index", h).on(s.thumbEventType, rt).data("thumbload", d), tt === y && n(f.container).addClass("active"), this._thumbnails.push(f);
            return p = this._thumbnails.slice(g), this
        },
        lazyLoad: function(t, i) {
            var u = t.constructor == Array ? t : [t],
                r = this,
                f = 0;
            return n.each(u, function(t, e) {
                if (!(e > r._thumbnails.length - 1)) {
                    var o = r._thumbnails[e],
                        c = o.data,
                        h = function() {
                            ++f == u.length && "function" == typeof i && i.call(r)
                        },
                        s = n(o.container).data("thumbload");
                    s && (o.video ? s.call(r, o, h) : o.load(c.src, function(n) {
                        s.call(r, n, h)
                    }))
                }
            }), this
        },
        lazyLoadChunks: function(n, i) {
            var e = this.getDataLength(),
                r = 0,
                o = 0,
                s = [],
                u = [],
                h = this,
                f;
            for (i = i || 0; r < e; r++) u.push(r), ++o != n && r != e - 1 || (s.push(u), o = 0, u = []);
            return f = function(n) {
                var r = s.shift();
                r && t.setTimeout(function() {
                    h.lazyLoad(r, function() {
                        f(!0)
                    })
                }, i && n ? i : 0)
            }, f(!1), this
        },
        _run: function() {
            var f = this;
            f._createThumbnails();
            u.wait({
                timeout: 1e4,
                until: function() {
                    return i.OPERA && f.$("stage").css("display", "inline-block"), f._stageWidth = f.$("stage").width(), f._stageHeight = f.$("stage").height(), f._stageWidth && f._stageHeight > 50
                },
                success: function() {
                    if (rt.push(f), f._options.swipe) {
                        var e = f.$("images").width(f.getDataLength() * f._stageWidth);
                        n.each(new Array(f.getDataLength()), function(t) {
                            var r = new i.Picture,
                                s = f.getData(t),
                                o;
                            n(r.container).css({
                                position: "absolute",
                                top: 0,
                                left: f._stageWidth * t
                            }).prepend(f._layers[t] = n(u.create("galleria-layer")).css({
                                position: "absolute",
                                top: 0,
                                left: 0,
                                right: 0,
                                bottom: 0,
                                zIndex: 2
                            })[0]).appendTo(e);
                            s.video && ft(r.container);
                            f._controls.slides.push(r);
                            o = new i.Picture;
                            o.isIframe = !0;
                            n(o.container).attr("class", "galleria-frame").css({
                                position: "absolute",
                                top: 0,
                                left: 0,
                                zIndex: 4,
                                background: "#000",
                                display: "none"
                            }).appendTo(r.container);
                            f._controls.frames.push(o)
                        });
                        f.finger.setup()
                    }
                    return u.show(f.get("counter")), f._options.carousel && f._carousel.bindControls(), f._options.autoplay && (f.pause(), "number" == typeof f._options.autoplay && (f._playtime = f._options.autoplay), f._playing = !0), f._firstrun ? (f._options.autoplay && f.trigger(i.PLAY), void("number" == typeof f._options.show && f.show(f._options.show))) : (f._firstrun = !0, i.History && i.History.change(function(n) {
                        isNaN(n) ? t.history.go(-1) : f.show(n, r, !0)
                    }), f.trigger(i.READY), f.theme.init.call(f, f._options), n.each(i.ready.callbacks, function(n, t) {
                        "function" == typeof t && t.call(f, f._options)
                    }), f._options.extend.call(f, f._options), /^[0-9]{1,4}$/.test(ot) && i.History ? f.show(ot, r, !0) : f._data[f._options.show] && f.show(f._options.show), void(f._options.autoplay && f.trigger(i.PLAY)))
                },
                error: function() {
                    i.raise("Stage width or height is too small to show the gallery. Traced measures: width:" + f._stageWidth + "px, height: " + f._stageHeight + "px.", !0)
                }
            })
        },
        load: function(t, r, u) {
            var o = this,
                e = this._options;
            return this._data = [], this._thumbnails = [], this.$("thumbnails").empty(), "function" == typeof r && (u = r, r = null), t = t || e.dataSource, r = r || e.dataSelector, u = u || e.dataConfig, n.isPlainObject(t) && (t = [t]), n.isArray(t) ? this.validate(t) ? this._data = t : i.raise("Load failed: JSON Array not valid.") : (r += ",.video,.iframe", n(t).find(r).each(function(t, i) {
                i = n(i);
                var r = {},
                    e = i.parent(),
                    f = e.attr("href"),
                    s = e.attr("rel");
                f && ("IMG" == i[0].nodeName || i.hasClass("video")) && lt(f) ? r.video = f : f && i.hasClass("iframe") ? r.iframe = f : r.image = r.big = f;
                s && (r.big = s);
                n.each("big title description link layer image".split(" "), function(n, t) {
                    i.data(t) && (r[t] = i.data(t).toString())
                });
                r.big || (r.big = r.image);
                o._data.push(n.extend({
                    title: i.attr("title") || "",
                    thumb: i.attr("src"),
                    image: i.attr("src"),
                    big: i.attr("src"),
                    description: i.attr("alt") || "",
                    link: i.attr("longdesc"),
                    original: i.get(0)
                }, r, u(i)))
            })), "function" == typeof e.dataSort ? d.sort.call(this._data, e.dataSort) : "random" == e.dataSort && this._data.sort(function() {
                return f.round(f.random()) - .5
            }), this.getDataLength() && this._parseData(function() {
                this.trigger(i.DATA)
            }), this
        },
        _parseData: function(t) {
            var i, u = this,
                f = !1,
                e = function() {
                    var i = !0;
                    n.each(u._data, function(n, t) {
                        if (t.loading) return i = !1, !1
                    });
                    i && !f && (f = !0, t.call(u))
                };
            return n.each(this._data, function(t, f) {
                if (i = u._data[t], "thumb" in f == !1 && (i.thumb = f.image), f.big || (i.big = f.image), "video" in f) {
                    var o = lt(f.video);
                    o && (i.iframe = new ct(o.provider, o.id).embed() + function() {
                        if ("object" == typeof u._options[o.provider]) {
                            var t = [];
                            return n.each(u._options[o.provider], function(n, i) {
                                t.push(n + "=" + i)
                            }), "youtube" == o.provider && (t = ["wmode=opaque"].concat(t)), "?" + t.join("&")
                        }
                        return ""
                    }(), i.thumb && i.image || n.each(["thumb", "image"], function(n, t) {
                        if ("image" == t && !u._options.videoPoster) return void(i.image = r);
                        var f = new ct(o.provider, o.id);
                        i[t] || (i.loading = !0, f.getMedia(t, function(n, t) {
                            return function(i) {
                                n[t] = i;
                                "image" != t || n.big || (n.big = n.image);
                                delete n.loading;
                                e()
                            }
                        }(i, t)))
                    }))
                }
            }), e(), this
        },
        destroy: function() {
            return this.$("target").data("galleria", null), this.$("container").off("galleria"), this.get("target").innerHTML = this._original.html, this.clearTimer(), u.removeFromArray(w, this), u.removeFromArray(rt, this), void 0 !== i._waiters && i._waiters.length && n.each(i._waiters, function(n, i) {
                i && t.clearTimeout(i)
            }), this
        },
        splice: function() {
            var n = this,
                i = u.array(arguments);
            return t.setTimeout(function() {
                d.splice.apply(n._data, i);
                n._parseData(function() {
                    n._createThumbnails()
                })
            }, 2), n
        },
        push: function() {
            var i = this,
                n = u.array(arguments);
            return 1 == n.length && n[0].constructor == Array && (n = n[0]), t.setTimeout(function() {
                d.push.apply(i._data, n);
                i._parseData(function() {
                    i._createThumbnails(n)
                })
            }, 2), i
        },
        _getActive: function() {
            return this._controls.getActive()
        },
        validate: function() {
            return !0
        },
        bind: function(n, t) {
            return n = it(n), this.$("container").on(n, this.proxy(t)), this
        },
        unbind: function(n) {
            return n = it(n), this.$("container").off(n), this
        },
        trigger: function(t) {
            return t = "object" == typeof t ? n.extend(t, {
                scope: this
            }) : {
                type: it(t),
                scope: this
            }, this.$("container").trigger(t), this
        },
        addIdleState: function() {
            return this._idle.add.apply(this._idle, u.array(arguments)), this
        },
        removeIdleState: function() {
            return this._idle.remove.apply(this._idle, u.array(arguments)), this
        },
        enterIdleMode: function() {
            return this._idle.hide(), this
        },
        exitIdleMode: function() {
            return this._idle.showAll(), this
        },
        enterFullscreen: function() {
            return this._fullscreen.enter.apply(this, u.array(arguments)), this
        },
        exitFullscreen: function() {
            return this._fullscreen.exit.apply(this, u.array(arguments)), this
        },
        toggleFullscreen: function() {
            return this._fullscreen[this.isFullscreen() ? "exit" : "enter"].apply(this, u.array(arguments)), this
        },
        bindTooltip: function() {
            return this._tooltip.bind.apply(this._tooltip, u.array(arguments)), this
        },
        defineTooltip: function() {
            return this._tooltip.define.apply(this._tooltip, u.array(arguments)), this
        },
        refreshTooltip: function() {
            return this._tooltip.show.apply(this._tooltip, u.array(arguments)), this
        },
        openLightbox: function() {
            return this._lightbox.show.apply(this._lightbox, u.array(arguments)), this
        },
        closeLightbox: function() {
            return this._lightbox.hide.apply(this._lightbox, u.array(arguments)), this
        },
        hasVariation: function(t) {
            return n.inArray(t, this._options.variation.split(/\s+/)) > -1
        },
        getActiveImage: function() {
            var n = this._getActive();
            return n ? n.image : r
        },
        getActiveThumb: function() {
            return this._thumbnails[this._active].image || r
        },
        getMousePosition: function(n) {
            return {
                x: n.pageX - this.$("container").offset().left,
                y: n.pageY - this.$("container").offset().top
            }
        },
        addPan: function(t) {
            if (this._options.imageCrop !== !1) {
                t = n(t || this.getActiveImage());
                var i = this,
                    v = t.width() / 2,
                    y = t.height() / 2,
                    h = parseInt(t.css("left"), 10),
                    c = parseInt(t.css("top"), 10),
                    e = h || 0,
                    s = c || 0,
                    l = 0,
                    a = 0,
                    p = !1,
                    d = u.timestamp(),
                    w = 0,
                    r = 0,
                    b = function(n, i, u) {
                        if (n > 0 && (r = f.round(f.max(n * -1, f.min(0, i))), w !== r))
                            if (w = r, 8 === o) t.parent()["scroll" + u](r * -1);
                            else {
                                var e = {};
                                e[u.toLowerCase()] = r;
                                t.css(e)
                            }
                    },
                    k = function(n) {
                        u.timestamp() - d < 50 || (p = !0, v = i.getMousePosition(n).x, y = i.getMousePosition(n).y)
                    },
                    g = function() {
                        p && (l = t.width() - i._stageWidth, a = t.height() - i._stageHeight, h = v / i._stageWidth * l * -1, c = y / i._stageHeight * a * -1, e += (h - e) / i._options.imagePanSmoothness, s += (c - s) / i._options.imagePanSmoothness, b(a, s, "Top"), b(l, e, "Left"))
                    };
                return 8 === o && (t.parent().scrollTop(s * -1).scrollLeft(e * -1), t.css({
                    top: 0,
                    left: 0
                })), this.$("stage").off("mousemove", k).on("mousemove", k), this.addTimer("pan" + i._id, g, 50, !0), this
            }
        },
        proxy: function(n, t) {
            return "function" != typeof n ? c : (t = t || this, function() {
                return n.apply(t, u.array(arguments))
            })
        },
        getThemeName: function() {
            return this.theme.name
        },
        removePan: function() {
            return this.$("stage").off("mousemove"), this.clearTimer("pan" + this._id), this
        },
        addElement: function() {
            var t = this._dom;
            return n.each(u.array(arguments), function(n, i) {
                t[i] = u.create("galleria-" + i)
            }), this
        },
        attachKeyboard: function() {
            return this._keyboard.attach.apply(this._keyboard, u.array(arguments)), this
        },
        detachKeyboard: function() {
            return this._keyboard.detach.apply(this._keyboard, u.array(arguments)), this
        },
        appendChild: function(n, t) {
            return this.$(n).append(this.get(t) || t), this
        },
        prependChild: function(n, t) {
            return this.$(n).prepend(this.get(t) || t), this
        },
        remove: function() {
            return this.$(u.array(arguments).join(",")).remove(), this
        },
        append: function(n) {
            var t, i;
            for (t in n)
                if (n.hasOwnProperty(t))
                    if (n[t].constructor === Array)
                        for (i = 0; n[t][i]; i++) this.appendChild(t, n[t][i]);
                    else this.appendChild(t, n[t]);
            return this
        },
        _scaleImage: function(t, i) {
            if (t = t || this._controls.getActive()) {
                var r, e = function(t) {
                    n(t.container).children(":first").css({
                        top: f.max(0, u.parseValue(t.image.style.top)),
                        left: f.max(0, u.parseValue(t.image.style.left)),
                        width: u.parseValue(t.image.width),
                        height: u.parseValue(t.image.height)
                    })
                };
                return i = n.extend({
                    width: this._stageWidth,
                    height: this._stageHeight,
                    crop: this._options.imageCrop,
                    max: this._options.maxScaleRatio,
                    min: this._options.minScaleRatio,
                    margin: this._options.imageMargin,
                    position: this._options.imagePosition,
                    iframelimit: this._options.maxVideoSize
                }, i), this._options.layerFollow && this._options.imageCrop !== !0 ? "function" == typeof i.complete ? (r = i.complete, i.complete = function() {
                    r.call(t, t);
                    e(t)
                }) : i.complete = e : n(t.container).children(":first").css({
                    top: 0,
                    left: 0
                }), t.scale(i), this
            }
        },
        updateCarousel: function() {
            return this._carousel.update(), this
        },
        resize: function(t, i) {
            "function" == typeof t && (i = t, t = r);
            t = n.extend({
                width: 0,
                height: 0
            }, t);
            var f = this,
                u = this.$("container");
            return n.each(t, function(n, i) {
                i || (u[n]("auto"), t[n] = f._getWH()[n])
            }), n.each(t, function(n, t) {
                u[n](t)
            }), this.rescale(i)
        },
        rescale: function(t, u, f) {
            var e = this,
                o;
            return "function" == typeof t && (f = t, t = r), o = function() {
                e._stageWidth = t || e.$("stage").width();
                e._stageHeight = u || e.$("stage").height();
                e._options.swipe ? (n.each(e._controls.slides, function(t, i) {
                    e._scaleImage(i);
                    n(i.container).css("left", e._stageWidth * t)
                }), e.$("images").css("width", e._stageWidth * e.getDataLength())) : e._scaleImage();
                e._options.carousel && e.updateCarousel();
                var r = e._controls.frames[e._controls.active];
                r && e._controls.frames[e._controls.active].scale({
                    width: e._stageWidth,
                    height: e._stageHeight,
                    iframelimit: e._options.maxVideoSize
                });
                e.trigger(i.RESCALE);
                "function" == typeof f && f.call(e)
            }, o.call(e), this
        },
        refreshImage: function() {
            return this._scaleImage(), this._options.imagePan && this.addPan(), this
        },
        _preload: function() {
            if (this._options.preload) {
                var u, t, n, r = this.getNext();
                try {
                    for (t = this._options.preload; t > 0; t--) u = new i.Picture, n = this.getData(r), u.preload(this.isFullscreen() && n.big ? n.big : n.image), r = this.getNext(r)
                } catch (u) {}
            }
        },
        show: function(r, u, e) {
            var v = this._options.swipe,
                o, s, l;
            if (v || !(this._queue.length > 3 || r === !1 || !this._options.queue && this._queue.stalled)) {
                if (r = f.max(0, f.min(parseInt(r, 10), this.getDataLength() - 1)), u = "undefined" != typeof u ? !!u : r < this.getIndex(), e = e || !1, !e && i.History) return void i.History.set(r.toString());
                if (this.finger && r !== this._active && (this.finger.to = -(r * this.finger.width), this.finger.index = r), this._active = r, v) {
                    if (o = this.getData(r), s = this, !o) return;
                    var a = this.isFullscreen() && o.big ? o.big : o.image || o.iframe,
                        h = this._controls.slides[r],
                        y = h.isCached(a),
                        p = this._thumbnails[r],
                        c = {
                            cached: y,
                            index: r,
                            rewind: u,
                            imageTarget: h.image,
                            thumbTarget: p.image,
                            galleriaData: o
                        };
                    this.trigger(n.extend(c, {
                        type: i.LOADSTART
                    }));
                    s.$("container").removeClass("videoplay");
                    l = function() {
                        s._layers[r].innerHTML = s.getData().layer || "";
                        s.trigger(n.extend(c, {
                            type: i.LOADFINISH
                        }));
                        s._playCheck()
                    };
                    s._preload();
                    t.setTimeout(function() {
                        h.ready && n(h.image).attr("src") == a ? (s.trigger(n.extend(c, {
                            type: i.IMAGE
                        })), l()) : (o.iframe && !o.image && (h.isIframe = !0), h.load(a, function(t) {
                            c.imageTarget = t.image;
                            s._scaleImage(t, l).trigger(n.extend(c, {
                                type: i.IMAGE
                            }));
                            l()
                        }))
                    }, 100)
                } else d.push.call(this._queue, {
                    index: r,
                    rewind: u
                }), this._queue.stalled || this._show();
                return this
            }
        },
        _show: function() {
            var f = this,
                o = this._queue[0],
                e = this.getData(o.index),
                c;
            if (e) {
                var l = this.isFullscreen() && e.big ? e.big : e.image || e.iframe,
                    h = this._controls.getActive(),
                    s = this._controls.getNext(),
                    a = s.isCached(l),
                    v = this._thumbnails[o.index],
                    y = function() {
                        n(s.image).trigger("mouseup")
                    };
                f.$("container").toggleClass("iframe", !!e.isIframe).removeClass("videoplay");
                c = function(e, o, s, h, c) {
                    return function() {
                        var l;
                        p.active = !1;
                        u.toggleQuality(o.image, f._options.imageQuality);
                        f._layers[f._controls.active].innerHTML = "";
                        n(s.container).css({
                            zIndex: 0,
                            opacity: 0
                        }).show();
                        n(s.container).find("iframe, .galleria-videoicon").remove();
                        n(f._controls.frames[f._controls.active].container).hide();
                        n(o.container).css({
                            zIndex: 1,
                            left: 0,
                            top: 0
                        }).show();
                        f._controls.swap();
                        f._options.imagePan && f.addPan(o.image);
                        (e.iframe && e.image || e.link || f._options.lightbox || f._options.clicknext) && n(o.image).css({
                            cursor: "pointer"
                        }).on("mouseup", function(u) {
                            if (!("number" == typeof u.which && u.which > 1)) {
                                if (e.iframe) {
                                    f.isPlaying() && f.pause();
                                    var o = f._controls.frames[f._controls.active],
                                        s = f._stageWidth,
                                        h = f._stageHeight;
                                    return n(o.container).css({
                                        width: s,
                                        height: h,
                                        opacity: 0
                                    }).show().animate({
                                        opacity: 1
                                    }, 200), void t.setTimeout(function() {
                                        o.load(e.iframe + (e.video ? "&autoplay=1" : ""), {
                                            width: s,
                                            height: h
                                        }, function(n) {
                                            f.$("container").addClass("videoplay");
                                            n.scale({
                                                width: f._stageWidth,
                                                height: f._stageHeight,
                                                iframelimit: e.video ? f._options.maxVideoSize : r
                                            })
                                        })
                                    }, 100)
                                }
                                return f._options.clicknext && !i.TOUCH ? (f._options.pauseOnInteraction && f.pause(), void f.next()) : e.link ? void(f._options.popupLinks ? l = t.open(e.link, "_blank") : t.location.href = e.link) : void(f._options.lightbox && f.openLightbox())
                            }
                        });
                        f._playCheck();
                        f.trigger({
                            type: i.IMAGE,
                            index: h.index,
                            imageTarget: o.image,
                            thumbTarget: c.image,
                            galleriaData: e
                        });
                        d.shift.call(f._queue);
                        f._queue.stalled = !1;
                        f._queue.length && f._show()
                    }
                }(e, s, h, o, v);
                this._options.carousel && this._options.carouselFollow && this._carousel.follow(o.index);
                f._preload();
                u.show(s.container);
                s.isIframe = e.iframe && !e.image;
                n(f._thumbnails[o.index].container).addClass("active").siblings(".active").removeClass("active");
                f.trigger({
                    type: i.LOADSTART,
                    cached: a,
                    index: o.index,
                    rewind: o.rewind,
                    imageTarget: s.image,
                    thumbTarget: v.image,
                    galleriaData: e
                });
                f._queue.stalled = !0;
                s.load(l, function(t) {
                    var s = n(f._layers[1 - f._controls.active]).html(e.layer || "").hide();
                    f._scaleImage(t, {
                        complete: function(t) {
                            var l, v;
                            "image" in h && u.toggleQuality(h.image, !1);
                            u.toggleQuality(t.image, !1);
                            f.removePan();
                            f.setInfo(o.index);
                            f.setCounter(o.index);
                            e.layer && (s.show(), (e.iframe && e.image || e.link || f._options.lightbox || f._options.clicknext) && s.css("cursor", "pointer").off("mouseup").mouseup(y));
                            e.video && e.image && ft(t.container);
                            l = f._options.transition;
                            (n.each({
                                initial: null === h.image,
                                touch: i.TOUCH,
                                fullscreen: f.isFullscreen()
                            }, function(n, t) {
                                if (t && f._options[n + "Transition"] !== r) return l = f._options[n + "Transition"], !1
                            }), l in p.effects == !1) ? c(): (v = {
                                prev: h.container,
                                next: t.container,
                                rewind: o.rewind,
                                speed: f._options.transitionSpeed || 400
                            }, p.active = !0, p.init.call(f, l, v, c));
                            f.trigger({
                                type: i.LOADFINISH,
                                cached: a,
                                index: o.index,
                                rewind: o.rewind,
                                imageTarget: t.image,
                                thumbTarget: f._thumbnails[o.index].image,
                                galleriaData: f.getData(o.index)
                            })
                        }
                    })
                })
            }
        },
        getNext: function(n) {
            return n = "number" == typeof n ? n : this.getIndex(), n === this.getDataLength() - 1 ? 0 : n + 1
        },
        getPrev: function(n) {
            return n = "number" == typeof n ? n : this.getIndex(), 0 === n ? this.getDataLength() - 1 : n - 1
        },
        next: function() {
            return this.getDataLength() > 1 && this.show(this.getNext(), !1), this
        },
        prev: function() {
            return this.getDataLength() > 1 && this.show(this.getPrev(), !0), this
        },
        get: function(n) {
            return n in this._dom ? this._dom[n] : null
        },
        getData: function(n) {
            return n in this._data ? this._data[n] : this._data[this._active]
        },
        getDataLength: function() {
            return this._data.length
        },
        getIndex: function() {
            return "number" == typeof this._active && this._active
        },
        getStageHeight: function() {
            return this._stageHeight
        },
        getStageWidth: function() {
            return this._stageWidth
        },
        getOptions: function(n) {
            return "undefined" == typeof n ? this._options : this._options[n]
        },
        setOptions: function(t, i) {
            return "object" == typeof t ? n.extend(this._options, t) : this._options[t] = i, this
        },
        play: function(n) {
            return this._playing = !0, this._playtime = n || this._playtime, this._playCheck(), this.trigger(i.PLAY), this
        },
        pause: function() {
            return this._playing = !1, this.trigger(i.PAUSE), this
        },
        playToggle: function(n) {
            return this._playing ? this.pause() : this.play(n)
        },
        isPlaying: function() {
            return this._playing
        },
        isFullscreen: function() {
            return this._fullscreen.active
        },
        _playCheck: function() {
            var n = this,
                t = 0,
                o = 20,
                s = u.timestamp(),
                r = "play" + this._id,
                e;
            this._playing && (this.clearTimer(r), e = function() {
                return t = u.timestamp() - s, t >= n._playtime && n._playing ? (n.clearTimer(r), void n.next()) : void(n._playing && (n.trigger({
                    type: i.PROGRESS,
                    percent: f.ceil(t / n._playtime * 100),
                    seconds: f.floor(t / 1e3),
                    milliseconds: t
                }), n.addTimer(r, e, o)))
            }, n.addTimer(r, e, o))
        },
        setPlaytime: function(n) {
            return this._playtime = n, this
        },
        setIndex: function(n) {
            return this._active = n, this
        },
        setCounter: function(n) {
            if ("number" == typeof n ? n++ : "undefined" == typeof n && (n = this.getIndex() + 1), this.get("current").innerHTML = n, o) {
                var t = this.$("counter"),
                    i = t.css("opacity");
                1 === parseInt(i, 10) ? u.removeAlpha(t[0]) : this.$("counter").css("opacity", i)
            }
            return this
        },
        setInfo: function(t) {
            var r = this,
                i = this.getData(t);
            return n.each(["title", "description"], function(n, t) {
                var u = r.$("info-" + t);
                i[t] ? u[i[t].length ? "show" : "hide"]().html(i[t]) : u.empty().hide()
            }), this
        },
        hasInfo: function(n) {
            for (var i = "title description".split(" "), t = 0; i[t]; t++)
                if (this.getData(n)[i[t]]) return !0;
            return !1
        },
        jQuery: function(t) {
            var r = this,
                u = [],
                i;
            return n.each(t.split(","), function(t, i) {
                i = n.trim(i);
                r.get(i) && u.push(i)
            }), i = n(r.get(u.shift())), n.each(u, function(n, t) {
                i = i.add(r.get(t))
            }), i
        },
        $: function() {
            return this.jQuery.apply(this, u.array(arguments))
        }
    };
    n.each(st, function(n, t) {
        var r = /_/.test(t) ? t.replace(/_/g, "") : t;
        i[t.toUpperCase()] = "galleria." + r
    });
    n.extend(i, {
        IE9: 9 === o,
        IE8: 8 === o,
        IE7: 7 === o,
        IE6: 6 === o,
        IE: o,
        WEBKIT: /webkit/.test(y),
        CHROME: /chrome/.test(y),
        SAFARI: /safari/.test(y) && !/chrome/.test(y),
        QUIRK: o && e.compatMode && "BackCompat" === e.compatMode,
        MAC: /mac/.test(navigator.platform.toLowerCase()),
        OPERA: !!t.opera,
        IPHONE: /iphone/.test(y),
        IPAD: /ipad/.test(y),
        ANDROID: /android/.test(y),
        TOUCH: "ontouchstart" in e && wt
    });
    i.addTheme = function(r) {
        r.name || i.raise("No theme name specified");
        (!r.version || parseInt(10 * i.version) > parseInt(10 * r.version)) && i.raise("This version of Galleria requires " + r.name + " theme version " + parseInt(10 * i.version) / 10 + " or later", !0);
        r.defaults = "object" != typeof r.defaults ? {} : ht(r.defaults);
        var e, o, f = !1;
        return "string" == typeof r.css ? (n("link").each(function(n, t) {
            if (e = new RegExp(r.css), e.test(t.href)) return f = !0, ut(r), !1
        }), f || n(function() {
            var h = 0,
                s = function() {
                    n("script").each(function(n, i) {
                        e = new RegExp("galleria\\." + r.name.toLowerCase() + "\\.");
                        o = new RegExp("galleria\\.io\\/theme\\/" + r.name.toLowerCase() + "\\/(\\d*\\.*)?(\\d*\\.*)?(\\d*\\/)?js");
                        (e.test(i.src) || o.test(i.src)) && (f = i.src.replace(/[^\/]*$/, "") + r.css, t.setTimeout(function() {
                            u.loadCSS(f, "galleria-theme-" + r.name, function() {
                                ut(r)
                            })
                        }, 1))
                    });
                    f || (h++ > 5 ? i.raise("No theme CSS loaded") : t.setTimeout(s, 500))
                };
            s()
        })) : ut(r), r
    };
    i.loadTheme = function(r) {
        if (!n("script").filter(function() {
                return n(this).attr("src") == r
            }).length) {
            var e, f = !1;
            return n(t).on("load", function() {
                f || (e = t.setTimeout(function() {
                    f || i.raise("Galleria had problems loading theme at " + r + ". Please check theme path or load manually.", !0)
                }, 2e4))
            }), u.loadScript(r, function() {
                f = !0;
                t.clearTimeout(e)
            }), i
        }
    };
    i.get = function(n) {
        return w[n] ? w[n] : "number" != typeof n ? w : void i.raise("Gallery index " + n + " not found")
    };
    i.configure = function(t, r) {
        var u = {};
        return "string" == typeof t && r ? (u[t] = r, t = u) : n.extend(u, t), i.configure.options = u, n.each(i.get(), function(n, t) {
            t.setOptions(u)
        }), i
    };
    i.configure.options = {};
    i.on = function(t, r) {
        if (t) {
            r = r || c;
            var f = t + r.toString().replace(/\s/g, "") + u.timestamp();
            return n.each(i.get(), function(n, i) {
                i._binds.push(f);
                i.bind(t, r)
            }), i.on.binds.push({
                type: t,
                callback: r,
                hash: f
            }), i
        }
    };
    i.on.binds = [];
    i.run = function(t, r) {
        return n.isFunction(r) && (r = {
            extend: r
        }), n(t || "#galleria").galleria(r), i
    };
    i.addTransition = function(n, t) {
        return p.effects[n] = t, i
    };
    i.utils = u;
    i.log = function() {
        var i = u.array(arguments);
        if (!("console" in t && "log" in t.console)) return t.alert(i.join("<br>"));
        try {
            return t.console.log.apply(t.console, i)
        } catch (r) {
            n.each(i, function() {
                t.console.log(this)
            })
        }
    };
    i.ready = function(t) {
        return "function" != typeof t ? i : (n.each(rt, function(n, i) {
            t.call(i, i._options)
        }), i.ready.callbacks.push(t), i)
    };
    i.ready.callbacks = [];
    i.raise = function(t, i) {
        var r = i ? "Fatal error" : "Error",
            u = {
                color: "#fff",
                position: "absolute",
                top: 0,
                left: 0,
                zIndex: 1e5
            },
            f = function(t) {
                var f = '<div style="padding:4px;margin:0 0 2px;background:#' + (i ? "811" : "222") + ';">' + (i ? "<strong>" + r + ": <\/strong>" : "") + t + "<\/div>";
                n.each(w, function() {
                    var n = this.$("errors"),
                        t = this.$("target");
                    n.length || (t.css("position", "relative"), n = this.addElement("errors").appendChild("target", "errors").$("errors").css(u));
                    n.append(f)
                });
                w.length || n("<div>").css(n.extend(u, {
                    position: "fixed"
                })).append(f).appendTo(s().body)
            };
        if (et) {
            if (f(t), i) throw new Error(r + ": " + t);
        } else if (i) {
            if (at) return;
            at = !0;
            i = !1;
            f("Gallery could not load.")
        }
    };
    i.version = 1.57;
    i.getLoadedThemes = function() {
        return n.map(b, function(n) {
            return n.name
        })
    };
    i.requires = function(n, t) {
        return t = t || "You need to upgrade Galleria to version " + n + " to use one or more components.", i.version < n && i.raise(t, !0), i
    };
    i.Picture = function(t) {
        this.id = t || null;
        this.image = null;
        this.container = u.create("galleria-image");
        n(this.container).css({
            overflow: "hidden",
            position: "relative"
        });
        this.original = {
            width: 0,
            height: 0
        };
        this.ready = !1;
        this.isIframe = !1
    };
    i.Picture.prototype = {
        cache: {},
        show: function() {
            u.show(this.image)
        },
        hide: function() {
            u.moveOut(this.image)
        },
        clear: function() {
            this.image = null
        },
        isCached: function(n) {
            return !!this.cache[n]
        },
        preload: function(t) {
            n(new Image).on("load", function(n, t) {
                return function() {
                    t[n] = n
                }
            }(t, this.cache)).attr("src", t)
        },
        load: function(r, f, e) {
            var o, h;
            if ("function" == typeof f && (e = f, f = null), this.isIframe) return o = "if" + (new Date).getTime(), h = this.image = n("<iframe>", {
                src: r,
                frameborder: 0,
                id: o,
                allowfullscreen: !0,
                css: {
                    visibility: "hidden"
                }
            })[0], f && n(h).css(f), n(this.container).find("iframe,img").remove(), this.container.appendChild(this.image), n("#" + o).on("load", function(i, r) {
                return function() {
                    t.setTimeout(function() {
                        n(i.image).css("visibility", "visible");
                        "function" == typeof r && r.call(i, i)
                    }, 10)
                }
            }(this, e)), this.container;
            this.image = new Image;
            i.IE8 && n(this.image).css("filter", "inherit");
            i.IE || i.CHROME || i.SAFARI || n(this.image).css("image-rendering", "optimizequality");
            var c = !1,
                l = !1,
                a = n(this.container),
                s = n(this.image),
                y = function() {
                    c ? tt ? n(this).attr("src", tt) : i.raise("Image not found: " + r) : (c = !0, t.setTimeout(function(n, t) {
                        return function() {
                            n.attr("src", t + (t.indexOf("?") > -1 ? "&" : "?") + u.timestamp())
                        }
                    }(n(this), r), 50))
                },
                v = function(r, e, o) {
                    return function() {
                        var s = function() {
                            n(this).off("load");
                            r.original = f || {
                                height: this.height,
                                width: this.width
                            };
                            i.HAS3D && (this.style.MozTransform = this.style.webkitTransform = "translate3d(0,0,0)");
                            a.append(this);
                            r.cache[o] = o;
                            "function" == typeof e && t.setTimeout(function() {
                                e.call(r, r)
                            }, 1)
                        };
                        this.width && this.height ? s.call(this) : ! function(t) {
                            u.wait({
                                until: function() {
                                    return t.width && t.height
                                },
                                success: function() {
                                    s.call(t)
                                },
                                error: function() {
                                    l ? i.raise("Could not extract width/height from image: " + t.src + ". Traced measures: width:" + t.width + "px, height: " + t.height + "px.") : (n(new Image).on("load", v).attr("src", t.src), l = !0)
                                },
                                timeout: 100
                            })
                        }(this)
                    }
                }(this, e, r);
            return a.find("iframe,img").remove(), s.css("display", "block"), u.hide(this.image), n.each("minWidth minHeight maxWidth maxHeight".split(" "), function(n, t) {
                s.css(t, /min/.test(t) ? "0" : "none")
            }), s.on("load", v).on("error", y).attr("src", r), this.container
        },
        scale: function(t) {
            var e = this,
                w, b, o, s, y, h, l, p, v;
            if (t = n.extend({
                    width: 0,
                    height: 0,
                    min: r,
                    max: r,
                    margin: 0,
                    complete: c,
                    position: "center",
                    crop: !1,
                    canvas: !1,
                    iframelimit: r
                }, t), this.isIframe) {
                o = t.width;
                s = t.height;
                t.iframelimit && (y = f.min(t.iframelimit / o, t.iframelimit / s), y < 1 ? (w = o * y, b = s * y, n(this.image).css({
                    top: s / 2 - b / 2,
                    left: o / 2 - w / 2,
                    position: "absolute"
                })) : n(this.image).css({
                    top: 0,
                    left: 0
                }));
                n(this.image).width(w || o).height(b || s).removeAttr("width").removeAttr("height");
                n(this.container).width(o).height(s);
                t.complete.call(e, e);
                try {
                    this.image.contentWindow && n(this.image.contentWindow).trigger("resize")
                } catch (n) {}
                return this.container
            }
            return this.image ? (v = n(e.container), u.wait({
                until: function() {
                    return h = t.width || v.width() || u.parseValue(v.css("width")), l = t.height || v.height() || u.parseValue(v.css("height")), h && l
                },
                success: function() {
                    var o = (h - 2 * t.margin) / e.original.width,
                        s = (l - 2 * t.margin) / e.original.height,
                        c = f.min(o, s),
                        v = f.max(o, s),
                        d = {
                            "true": v,
                            width: o,
                            height: s,
                            "false": c,
                            landscape: e.original.width > e.original.height ? v : c,
                            portrait: e.original.width < e.original.height ? v : c
                        },
                        r = d[t.crop.toString()],
                        y = "";
                    t.max && (r = f.min(t.max, r));
                    t.min && (r = f.max(t.min, r));
                    n.each(["width", "height"], function(t, i) {
                        n(e.image)[i](e[i] = e.image[i] = f.round(e.original[i] * r))
                    });
                    n(e.container).width(h).height(l);
                    t.canvas && a && (a.elem.width = e.width, a.elem.height = e.height, y = e.image.src + ":" + e.width + "x" + e.height, e.image.src = a.cache[y] || function(n) {
                        a.context.drawImage(e.image, 0, 0, e.original.width * r, e.original.height * r);
                        try {
                            return p = a.elem.toDataURL(), a.length += p.length, a.cache[n] = p, p
                        } catch (n) {
                            return e.image.src
                        }
                    }(y));
                    var i = {},
                        w = {},
                        b = function(t, i, r) {
                            var o = 0,
                                s, h;
                            return /\%/.test(t) ? (s = parseInt(t, 10) / 100, h = e.image[i] || n(e.image)[i](), o = f.ceil(h * -1 * s + r * s)) : o = u.parseValue(t), o
                        },
                        k = {
                            top: {
                                top: 0
                            },
                            left: {
                                left: 0
                            },
                            right: {
                                left: "100%"
                            },
                            bottom: {
                                top: "100%"
                            }
                        };
                    n.each(t.position.toLowerCase().split(" "), function(n, t) {
                        "center" === t && (t = "50%");
                        i[n ? "top" : "left"] = t
                    });
                    n.each(i, function(t, i) {
                        k.hasOwnProperty(i) && n.extend(w, k[i])
                    });
                    i = i.top ? n.extend(i, w) : w;
                    i = n.extend({
                        top: "50%",
                        left: "50%"
                    }, i);
                    n(e.image).css({
                        position: "absolute",
                        top: b(i.top, "height", l),
                        left: b(i.left, "width", h)
                    });
                    e.show();
                    e.ready = !0;
                    t.complete.call(e, e)
                },
                error: function() {
                    i.raise("Could not scale image: " + e.image.src)
                },
                timeout: 1e3
            }), this) : this.container
        }
    };
    n.extend(n.easing, {
        galleria: function(n, t, i, r, u) {
            return (t /= u / 2) < 1 ? r / 2 * t * t * t + i : r / 2 * ((t -= 2) * t * t + 2) + i
        },
        galleriaIn: function(n, t, i, r, u) {
            return r * (t /= u) * t + i
        },
        galleriaOut: function(n, t, i, r, u) {
            return -r * (t /= u) * (t - 2) + i
        }
    });
    i.Finger = function() {
        var u = (f.abs, i.HAS3D = function() {
                var u, f, i = e.createElement("p"),
                    r = ["webkit", "O", "ms", "Moz", ""],
                    t = 0,
                    o = "transform";
                for (s().html.insertBefore(i, null); r[t]; t++) f = r[t] ? r[t] + "Transform" : o, void 0 !== i.style[f] && (i.style[f] = "translate3d(1px,1px,1px)", u = n(i).css(r[t] ? "-" + r[t].toLowerCase() + "-" + o : o));
                return s().html.removeChild(i), void 0 !== u && u.length > 0 && "none" !== u
            }()),
            o = function() {
                var n = "RequestAnimationFrame";
                return t.requestAnimationFrame || t["webkit" + n] || t["moz" + n] || t["o" + n] || t["ms" + n] || function(n) {
                    t.setTimeout(n, 1e3 / 60)
                }
            }(),
            r = function(i, r) {
                if (this.config = {
                        start: 0,
                        duration: 500,
                        onchange: function() {},
                        oncomplete: function() {},
                        easing: function(n, t, i, r, u) {
                            return -r * ((t = t / u - 1) * t * t * t - 1) + i
                        }
                    }, this.easeout = function(n, t, i, r, u) {
                        return r * ((t = t / u - 1) * t * t * t * t + 1) + i
                    }, i.children.length) {
                    var f = this;
                    n.extend(this.config, r);
                    this.elem = i;
                    this.child = i.children[0];
                    this.to = this.pos = 0;
                    this.touching = !1;
                    this.start = {};
                    this.index = this.config.start;
                    this.anim = 0;
                    this.easing = this.config.easing;
                    u || (this.child.style.position = "absolute", this.elem.style.position = "relative");
                    n.each(["ontouchstart", "ontouchmove", "ontouchend", "setup"], function(n, t) {
                        f[t] = function(n) {
                            return function() {
                                n.apply(f, arguments)
                            }
                        }(f[t])
                    });
                    this.setX = function() {
                        var n = f.child.style;
                        return u ? void(n.MozTransform = n.webkitTransform = n.transform = "translate3d(" + f.pos + "px,0,0)") : void(n.left = f.pos + "px")
                    };
                    n(i).on("touchstart", this.ontouchstart);
                    n(t).on("resize", this.setup);
                    n(t).on("orientationchange", this.setup);
                    this.setup(),
                        function n() {
                            o(n);
                            f.loop.call(f)
                        }()
                }
            };
        return r.prototype = {
            constructor: r,
            setup: function() {
                this.width = n(this.elem).width();
                this.length = f.ceil(n(this.child).width() / this.width);
                0 !== this.index && (this.index = f.max(0, f.min(this.index, this.length - 1)), this.pos = this.to = -this.width * this.index)
            },
            setPosition: function(n) {
                this.pos = n;
                this.to = n
            },
            ontouchstart: function(n) {
                var t = n.originalEvent.touches;
                this.start = {
                    pageX: t[0].pageX,
                    pageY: t[0].pageY,
                    time: +new Date
                };
                this.isScrolling = null;
                this.touching = !0;
                this.deltaX = 0;
                k.on("touchmove", this.ontouchmove);
                k.on("touchend", this.ontouchend)
            },
            ontouchmove: function(n) {
                var t = n.originalEvent.touches;
                t && t.length > 1 || n.scale && 1 !== n.scale || (this.deltaX = t[0].pageX - this.start.pageX, null === this.isScrolling && (this.isScrolling = !!(this.isScrolling || f.abs(this.deltaX) < f.abs(t[0].pageY - this.start.pageY))), this.isScrolling || (n.preventDefault(), this.deltaX /= !this.index && this.deltaX > 0 || this.index == this.length - 1 && this.deltaX < 0 ? f.abs(this.deltaX) / this.width + 1.8 : 1, this.to = this.deltaX - this.index * this.width), n.stopPropagation())
            },
            ontouchend: function() {
                this.touching = !1;
                var n = +new Date - this.start.time < 250 && f.abs(this.deltaX) > 40 || f.abs(this.deltaX) > this.width / 2,
                    t = !this.index && this.deltaX > 0 || this.index == this.length - 1 && this.deltaX < 0;
                this.isScrolling || this.show(this.index + (n && !t ? this.deltaX < 0 ? 1 : -1 : 0));
                k.off("touchmove", this.ontouchmove);
                k.off("touchend", this.ontouchend)
            },
            show: function(n) {
                n != this.index ? this.config.onchange.call(this, n) : this.to = -(n * this.width)
            },
            moveTo: function(n) {
                n != this.index && (this.pos = this.to = -(n * this.width), this.index = n)
            },
            loop: function() {
                var n = this.to - this.pos,
                    r = 1,
                    t, i;
                if (this.width && n && (r = f.max(.5, f.min(1.5, f.abs(n / this.width)))), this.touching || f.abs(n) <= 1) this.pos = this.to, n = 0, this.anim && !this.touching && this.config.oncomplete(this.index), this.anim = 0, this.easing = this.config.easing;
                else {
                    if (this.anim || (this.anim = {
                            start: this.pos,
                            time: +new Date,
                            distance: n,
                            factor: r,
                            destination: this.to
                        }), t = +new Date - this.anim.time, i = this.config.duration * this.anim.factor, t > i || this.anim.destination != this.to) return this.anim = 0, void(this.easing = this.easeout);
                    this.pos = this.easing(null, t, this.anim.start, this.anim.distance, i)
                }
                this.setX()
            }
        }, r
    }();
    n.fn.galleria = function(t) {
        var r = this.selector;
        return n(this).length ? this.each(function() {
            n.data(this, "galleria") && (n.data(this, "galleria").destroy(), n(this).find("*").hide());
            n.data(this, "galleria", (new i).init(this, t))
        }) : (n(function() {
            n(r).length ? n(r).galleria(t) : i.utils.wait({
                until: function() {
                    return n(r).length
                },
                success: function() {
                    n(r).galleria(t)
                },
                error: function() {
                    i.raise('Init failed: Galleria could not find the element "' + r + '".')
                },
                timeout: 5e3
            })
        }), this)
    };
    "object" == typeof module && module && "object" == typeof module.exports ? module.exports = i : (t.Galleria = i, "function" == typeof define && define.amd && define("galleria", ["jquery"], function() {
        return i
    }))
}(jQuery, this)