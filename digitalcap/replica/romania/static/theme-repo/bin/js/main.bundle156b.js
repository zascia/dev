! function(i) {
    var n = {};

    function a(e) {
        if (n[e]) return n[e].exports;
        var t = n[e] = {
            i: e,
            l: !1,
            exports: {}
        };
        return i[e].call(t.exports, t, t.exports, a), t.l = !0, t.exports
    }
    a.m = i, a.c = n, a.d = function(e, t, i) {
        a.o(e, t) || Object.defineProperty(e, t, {
            enumerable: !0,
            get: i
        })
    }, a.r = function(e) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(e, "__esModule", {
            value: !0
        })
    }, a.t = function(t, e) {
        if (1 & e && (t = a(t)), 8 & e) return t;
        if (4 & e && "object" == typeof t && t && t.__esModule) return t;
        var i = Object.create(null);
        if (a.r(i), Object.defineProperty(i, "default", {
                enumerable: !0,
                value: t
            }), 2 & e && "string" != typeof t)
            for (var n in t) a.d(i, n, function(e) {
                return t[e]
            }.bind(null, n));
        return i
    }, a.n = function(e) {
        var t = e && e.__esModule ? function() {
            return e.default
        } : function() {
            return e
        };
        return a.d(t, "a", t), t
    }, a.o = function(e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }, a.p = "", a(a.s = 0)
}
    ([function(e, t, i) {
    "use strict";
    window.appCfgDist = {
        baseUrl: "",
        assetsBaseUrl: "images/",
        cookiesPath: "/",
        jwPlayerCfg: {},
        xhrCfg: {
            userXhr: {
                relUrl: "_xhr.php",
                method: "GET",
                params: {
                    logout: function() {
                        try {
                            if (new URLSearchParams(window.location.search).has("logout")) return !0
                        } catch (e) {
                            return !1
                        }
                    }()
                }
            },
            pollXhr: {
                relUrl: "_ajax_poll.php",
                method: "POST",
                params: {
                    answer: null
                }
            }
        },
        firebaseCfg: {
            apiKey: "AIzaSyCHYQqZcHj6xr8pOsszoeJW6VkzwMJX9WI",
            authDomain: "digi24-1537439259482.firebaseapp.com",
            databaseURL: "https://digi24-1537439259482.firebaseio.com",
            projectId: "digi24-1537439259482",
            storageBucket: "digi24-1537439259482.appspot.com",
            messagingSenderId: "949331725214"
        }
    }, window.appCfg && (window.appCfgDist = Object.assign({}, window.appCfgDist, window.appCfg));
    var n = new(i(1))({
        config: window.appCfgDist.firebaseCfg,
        element: ".user",
        container: ".auth",
        content: ".auth-content",
        placeholder: ".auth-placeholder",
        dialog: {
            modal: "#modal",
            title: "#modal-title",
            link: "#modal-link",
            close: "#modal-close"
        }
    });
    n.initAuth(), new(i(2))({
        cookieName: "prv_level",
        cookiePath: window.appCfgDist.cookiesPath,
        container: "#gdpr",
        modal: "#gdpr-modal",
        button: ".gdpr-modal-trigger",
        trigger: ".gdpr-trigger",
        input: ".gdpr-input",
        marker: "#gdpr-marker"
    }).initGdpr();
    var a = i(4),
        r = new a({
            element: ".header",
            trigger: ".nav-trigger",
            clickable: ".nav-menu, .search",
            close: ".nav-close",
            scrollable: !0
        });
    r.toggleActive(), r.removeActive();
    var s = new a({
        element: ".search",
        trigger: ".search-trigger",
        clickable: ".search",
        close: ".form-search-close",
        scrollable: !0
    });
    s.toggleActive(), s.removeActive();
    new a({
        element: "#modal",
        trigger: "#modal",
        clickable: "#modal-box",
        close: "#modal-close",
        scrollable: !0
    }).removeActive();
    new a({
        element: ".dropdown",
        trigger: ".dropdown",
        clickable: ".dropdown",
        close: ".dropdown"
    }).removeActive();
    new a({
        element: ".schedule-list",
        trigger: ".schedule-nav .dropdown-list-item-link"
    }).addActive();
    new(i(5))({
        trigger: ".nav-menu-list-item",
        submenu: ".nav-submenu"
    }).toggleMenu();
    new(i(6))({
        trigger: ".search-trigger",
        element: ".form-search-input"
    }).initFocus();
    new(i(7))({
        element: ".header",
        cls: "header-sticky",
        offset: "main",
        breakpoint: 0
    }).stickyNavigation();
    var o = i(8);
    new o({
        container: ".dropdown-wrapper .dropdown"
    }).initDropdown();
    new o({
        container: ".dropdown-wrapper-alt .dropdown",
        breakpoint: 767
    }).initDropdown();
    var l = i(9);
    new l({
        element: ".form-element select"
    }).initChoices();
    new l({
        element: ".submit-select select",
        submit: !0
    }).initChoices(), (new(i(11))).initSlider();
    var c = i(12);
    new c({
        element: ".swiper-stream .swiper-container",
        options: {
            slidesPerView: 4,
            navigation: {
                nextEl: ".swiper-stream .swiper-button-next",
                prevEl: ".swiper-stream .swiper-button-prev"
            },
            breakpoints: {
                1220: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 2
                },
                480: {
                    slidesPerView: 1
                }
            }
        }
    })
    var u = i(16);
    new u({
        form: "#signup",
        captcha: "#g-recaptcha-signup",
        callback: n.signUp
    }).initValidator(), new u({
        form: "#signin",
        captcha: "#g-recaptcha-signin",
        callback: n.signIn
    }).initValidator(), new u({
        form: "#forgot",
        captcha: "#g-recaptcha-forgot",
        callback: n.forgotPassword
    }).initValidator(), new u({
        form: "#reset",
        callback: n.handleActionCode
    }).initValidator(), new u({
        form: "#verify",
        callback: n.handleActionCode
    }).initValidator(), new u({
        form: "#recover",
        callback: n.handleActionCode
    }).initValidator(), new u({
        form: "#password",
        callback: n.updatePassword
    }).initValidator(), new u({
        form: "#email",
        callback: n.updateEmail
    }).initValidator();
    var h = i(17);
    new h({
        cfg: "#form-contact-cfg",
        dest: "#contact-response",
        form: {
            formId: "#contact",
            formField: ".form-element",
            captcha: "#g-recaptcha-contact"
        }
    }).initAjax();
    new h({
        cfg: "#form-newsletter-cfg",
        dest: "#newsletter-response",
        form: {
            formId: "#newsletter",
            formField: ".form-element",
            captcha: "#g-recaptcha-newsletter"
        }
    }).initAjax();
    new h({
        cfg: "#form-digivox-cfg",
        dest: "#digivox-response",
        form: {
            formId: "#digivox",
            formField: ".form-element",
            captcha: "#g-recaptcha-digivox"
        }
    }).initAjax();
    new h({
        cfg: "#form-signup-county-cfg",
        dest: "#signup-county",
        element: "#signup-country"
    }).initAjax();
    new h({
        cfg: "#form-signup-city-cfg",
        dest: "#signup-city",
        element: "#signup-county"
    }).initAjax();
    new h({
        cfg: "#hipo-cfg",
        dest: "#hipo",
        preload: !0,
        element: '[data-action="hipo"]'
    }).initAjax();
    new h({
        cfg: "#agenda-cfg",
        dest: "#agenda",
        preload: !0,
        element: '[data-action-select="agenda"]'
    }).initAjax();
    var p = i(18);
    new p({
        element: ".social-icon",
        baseUrl: window.appCfgDist.baseUrl
    }).initShare(), new p({
        element: ".social-link",
        baseUrl: window.appCfgDist.baseUrl
    }).setShareLinks();
    new p({
        element: ".copy-link"
    }).copyLink();
    var f = i(19);
    new f({
        element: ".video-player",
        container: "video-player-live",
        options: window.appCfgDist.jwPlayerCfg
    }).initPlayer(), new f({
        element: ".schedule-list-item",
        container: "video-player-shows",
        options: window.appCfgDist.jwPlayerCfg,
        multiple: !0
    }).initPlayer();
    new(i(20))({
        element: ".schedule-list-item",
        container: ".schedule-list",
        trigger: ".schedule-nav .dropdown-list-item-link",
        delay: 6e4
    }).initSchedule();
    new(i(21))({
        element: ".location-input",
        cfg: "#contact-cfg",
        map: "#map"
    }).initContact();
    new(i(22))({
        element: ".weather-map-pin",
        cfg: "#weather-cfg",
        target: ".widget-weather"
    }).initWeather();
    new(i(23))({
        element: "#dropzone",
        cfg: "#dropzone-cfg",
        url: "#file-url",
        id: "#file-id"
    }).initDropzone(), (new(i(26))).nativeAds()
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            t = e.config,
            r = void 0 === t ? null : t,
            i = e.element,
            n = void 0 === i ? null : i,
            a = e.container,
            s = void 0 === a ? null : a,
            o = e.content,
            m = void 0 === o ? null : o,
            l = e.placeholder,
            g = void 0 === l ? null : l,
            c = e.dialog,
            d = void 0 === c ? {} : c,
            u = e.dialog,
            y = ((u = void 0 === u ? {} : u).modal, u.title, u.link, u.close, document.querySelector(n)),
            b = document.querySelector(s),
            w = document.querySelectorAll(s),
            h = document.querySelector(d.modal),
            p = document.querySelector(d.title),
            f = document.querySelector(d.link),
            v = document.querySelector(d.close);

        function E() {
            if (document.documentElement.classList.add("loading"), Math.max(document.body.scrollHeight, document.documentElement.scrollHeight, document.body.offsetHeight, document.documentElement.offsetHeight, document.body.clientHeight, document.documentElement.clientHeight) > document.documentElement.clientHeight) {
                var e = window.pageYOffset;
                document.documentElement.classList.add("noscroll"), document.documentElement.style.top = -e + "px"
            }
        }

        function x(e) {
            var t = 1 < arguments.length && void 0 !== arguments[1] && arguments[1],
                i = 2 < arguments.length && void 0 !== arguments[2] && arguments[2];
            h && (p.textContent = e, f.title = "", v.title = "", t && (f.title = t), i && (v.title = i), document.documentElement.classList.remove("loading"), h.classList.add("active"))
        }

        function S(e) {
            switch (e) {
                case "auth/invalid-email":
                    x("Adresa de email nu este validă", !1, "OK");
                    break;
                case "auth/wrong-password":
                    x("Parola nu este validă", !1, "OK");
                    break;
                case "auth/weak-password":
                    x("Parola nu este sigură", !1, "OK");
                    break;
                default:
                    x("Am înregistrat o eroare, te rugăm să reîncerci mai târziu", !1, "OK")
            }
        }
        this.signIn = function() {
            E(), firebase.auth().currentUser && firebase.auth().signOut();
            var e = document.querySelector('[type="email"]').value,
                t = document.querySelector('[type="password"]').value;
            firebase.auth().signInWithEmailAndPassword(e, t).then(function(e) {
                firebase.auth().currentUser && firebase.auth().currentUser.emailVerified ? document.forms[0].submit() : x("Pentru activarea contului vă rugăm să urmați instrucțiunile trimise pe adresa de email", "OK")
            }).catch(function(e) {
                S(e.code)
            })
        }, this.signUp = function() {
            E();
            var e = document.querySelector('[type="email"]').value,
                t = document.querySelector('[type="password"]').value,
                i = document.querySelector('[type="text"]').value;
            firebase.auth().createUserWithEmailAndPassword(e, t).then(function() {
                firebase.auth().currentUser.updateProfile({
                    displayName: i
                }).then(function() {
                    firebase.auth().currentUser.sendEmailVerification().then(function() {
                        document.forms[0].reset(), x("Pentru activarea contului vă rugăm să urmați instrucțiunile trimise pe adresa de email", "OK")
                    }).catch(function(e) {
                        S(e.code)
                    })
                }).catch(function(e) {
                    S(e.code)
                })
            }).catch(function(e) {
                S(e.code)
            })
        }, this.forgotPassword = function() {
            E();
            var e = document.querySelector('[type="email"]').value;
            firebase.auth().sendPasswordResetEmail(e).then(function() {
                document.forms[0].reset(), x("Pentru resetarea parolei vă rugăm să urmați instrucțiunile trimise pe adresa de email", "OK")
            }).catch(function(e) {
                S(e.code)
            })
        }, this.handleActionCode = function() {
            "undefined" == typeof URLSearchParams && (location.href = "/");
            var e = new URLSearchParams(window.location.search);
            if (e.has("mode") && e.has("oobCode")) {
                var t = e.get("mode"),
                    i = e.get("oobCode");
                switch (t) {
                    case "resetPassword":
                        E(), firebase.auth().verifyPasswordResetCode(i).then(function(e) {
                            var t = document.querySelector('[type="password"]').value;
                            firebase.auth().confirmPasswordReset(i, t).then(function() {
                                document.forms[0].submit()
                            }).catch(function(e) {
                                S(e.code)
                            })
                        }).catch(function(e) {
                            S(e.code)
                        });
                        break;
                    case "verifyEmail":
                        E(), firebase.auth().applyActionCode(i).then(function() {
                            document.forms[0].submit()
                        }).catch(function(e) {
                            S(e.code)
                        });
                        break;
                    case "recoverEmail":
                        E();
                        var n = null;
                        firebase.auth().checkActionCode(i).then(function(e) {
                            return n = e.data.email, firebase.auth().applyActionCode(i)
                        }).then(function() {
                            firebase.auth().sendPasswordResetEmail(n).then(function() {
                                document.forms[0].submit()
                            }).catch(function(e) {
                                S(e.code)
                            })
                        }).catch(function(e) {
                            S(e.code)
                        });
                        break;
                    default:
                        location.href = "/"
                }
            } else location.href = "/"
        }, this.updatePassword = function() {
            if (!firebase.auth().currentUser) return !(location.href = "/");
            E();
            var e = document.querySelector('[type="password"]').value;
            firebase.auth().currentUser.updatePassword(e).then(function() {
                document.forms[1].reset(), x("Setările au fost salvate cu succes", !1, "OK")
            }).catch(function(e) {
                S(e.code)
            })
        }, this.updateEmail = function() {
            if (!firebase.auth().currentUser) return !(location.href = "/");
            E();
            var e = document.querySelector('[type="email"]').value;
            firebase.auth().currentUser.updateEmail(e).then(function() {
                document.forms[1].reset(), x("Setările au fost salvate cu succes", !1, "OK")
            }).catch(function(e) {
                S(e.code)
            })
        }, this.initAuth = function() {
            if (!r) return !1;
            if ("undefined" == typeof firebase) {
                if (document.getElementById("account") && (location.href = "/"), null != y && y.remove(), null != b) {
                    var e = !0,
                        t = !1,
                        i = void 0;
                    try {
                        for (var n, a = w[Symbol.iterator](); !(e = (n = a.next()).done); e = !0) n.value.classList.remove("loading")
                    } catch (e) {
                        t = !0, i = e
                    } finally {
                        try {
                            e || null == a.return || a.return()
                        } finally {
                            if (t) throw i
                        }
                    }
                }
                return !1
            }
            firebase.initializeApp(r), firebase.auth().onAuthStateChanged(function(e) {
                if (e && e.emailVerified) {
                    if (null != y && (y.classList.add("active"), y.classList.remove("loading")), null != b) {
                        var t = !0,
                            i = !1,
                            n = void 0;
                        try {
                            for (var a, r = w[Symbol.iterator](); !(t = (a = r.next()).done); t = !0) a.value.classList.remove("loading")
                        } catch (e) {
                            i = !0, n = e
                        } finally {
                            try {
                                t || null == r.return || r.return()
                            } finally {
                                if (i) throw n
                            }
                        }
                    }
                    var s = document.querySelector("#auth-name"),
                        o = document.querySelector("#auth-email");
                    s && o && (s.dataset.dt = "Nume: ", s.dataset.dd = e.displayName, o.dataset.dt = "Email: ", o.dataset.dd = e.email)
                } else if (document.getElementById("account") && (location.href = "/"), null != y && y.classList.remove("loading"), null != b) {
                    var l = !0,
                        c = !1,
                        d = void 0;
                    try {
                        for (var u, h = w[Symbol.iterator](); !(l = (u = h.next()).done); l = !0) {
                            var p = u.value,
                                f = p.querySelector(m),
                                v = p.querySelector(g);
                            null != f && (f.innerHTML = "", null != v && v.classList.remove("hide")), p.classList.remove("loading")
                        }
                    } catch (e) {
                        c = !0, d = e
                    } finally {
                        try {
                            l || null == h.return || h.return()
                        } finally {
                            if (c) throw d
                        }
                    }
                }
            }), document.addEventListener("click", function(e) {
                firebase.auth().currentUser && e.target.matches(".logout") && firebase.auth().signOut()
            })
        }
    }
}, function(e, t, i) {
    (function(b) {
        e.exports = function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
                t = e.cookieName,
                l = void 0 === t ? "gdpr_cookie" : t,
                i = e.cookiePath,
                c = void 0 === i ? window.appCfgDist.cookiesPath : i,
                n = e.container,
                a = void 0 === n ? "#gdpr" : n,
                r = e.modal,
                d = void 0 === r ? "#gdpr-modal" : r,
                s = e.button,
                o = void 0 === s ? ".gdpr-modal-trigger" : s,
                u = e.trigger,
                h = void 0 === u ? ".gdpr-trigger" : u,
                p = e.input,
                f = void 0 === p ? ".gdpr-input" : p,
                v = e.marker,
                m = void 0 === v ? "#gdpr-marker" : v,
                g = document.querySelector(a),
                y = document.querySelector(d),
                q = document.querySelectorAll(f),
                Y = document.querySelector(m);
            this.initGdpr = function() {
                if (null == g) return !1;
                document.addEventListener("DOMContentLoaded", function() {
                    var e = b.get(l);
                    null != e && 0 != e || g.classList.add("active")
                }), document.addEventListener("click", function(e) {
                    if (!e.target.matches(h)) return !1;
                    e.preventDefault();
                    var t = 15;
                    if (null != e.target.closest(d)) {
                        var i = !0,
                            n = !1,
                            a = void 0;
                        try {
                            for (var r, s = q[Symbol.iterator](); !(i = (r = s.next()).done); i = !0) {
                                var o = r.value;
                                1 == o.checked && (t -= parseInt(o.value))
                            }
                        } catch (e) {
                            n = !0, a = e
                        } finally {
                            try {
                                i || null == s.return || s.return()
                            } finally {
                                if (n) throw a
                            }
                        }
                    }
                    b.set(l, t, {
                        expires: 365,
                        path: c
                    }), window.adtlgcen = window.adtlgcen || {}, adtlgcen.taskQueue = adtlgcen.taskQueue || [], t < 9 ? adtlgcen.taskQueue.push("optOut") : adtlgcen.taskQueue.push("optIn"), location.reload(!0)
                }), document.addEventListener("click", function(e) {
                    if (!e.target.matches(o)) return !1;
                    if (e.preventDefault(), y.classList.contains("active")) {
                        if (y.classList.remove("active"), document.documentElement.classList.contains("noscroll")) {
                            var t = getComputedStyle(document.documentElement);
                            n = parseInt(t.top), document.documentElement.classList.remove("noscroll"), window.scrollTo(0, -n)
                        }
                    } else {
                        var i = b.get(l);
                        if (void 0 !== i && 1 < i && function(e) {
                                switch (e = parseInt(e)) {
                                    case 15:
                                        var t = !0,
                                            i = !1,
                                            n = void 0;
                                        try {
                                            for (var a, r = q[Symbol.iterator](); !(t = (a = r.next()).done); t = !0) {
                                                var s = a.value;
                                                s.hasAttribute("disabled") || (s.checked = !1)
                                            }
                                        } catch (e) {
                                            i = !0, n = e
                                        } finally {
                                            try {
                                                t || null == r.return || r.return()
                                            } finally {
                                                if (i) throw n
                                            }
                                        }
                                        break;
                                    case 13:
                                        var o = !0,
                                            l = !1,
                                            c = void 0;
                                        try {
                                            for (var d, u = q[Symbol.iterator](); !(o = (d = u.next()).done); o = !0) {
                                                var h = d.value;
                                                4 != h.value && 8 != h.value || (h.checked = !1)
                                            }
                                        } catch (e) {
                                            l = !0, c = e
                                        } finally {
                                            try {
                                                o || null == u.return || u.return()
                                            } finally {
                                                if (l) throw c
                                            }
                                        }
                                        break;
                                    case 11:
                                        var p = !0,
                                            f = !1,
                                            v = void 0;
                                        try {
                                            for (var m, g = q[Symbol.iterator](); !(p = (m = g.next()).done); p = !0) {
                                                var y = m.value;
                                                2 != y.value && 8 != y.value || (y.checked = !1)
                                            }
                                        } catch (e) {
                                            f = !0, v = e
                                        } finally {
                                            try {
                                                p || null == g.return || g.return()
                                            } finally {
                                                if (f) throw v
                                            }
                                        }
                                        break;
                                    case 9:
                                        var b = !0,
                                            w = !1,
                                            E = void 0;
                                        try {
                                            for (var x, S = q[Symbol.iterator](); !(b = (x = S.next()).done); b = !0) {
                                                var C = x.value;
                                                8 == C.value && (C.checked = !1)
                                            }
                                        } catch (e) {
                                            w = !0, E = e
                                        } finally {
                                            try {
                                                b || null == S.return || S.return()
                                            } finally {
                                                if (w) throw E
                                            }
                                        }
                                        break;
                                    case 7:
                                        var k = !0,
                                            T = !1,
                                            _ = void 0;
                                        try {
                                            for (var L, I = q[Symbol.iterator](); !(k = (L = I.next()).done); k = !0) {
                                                var M = L.value;
                                                2 != M.value && 4 != M.value || (M.checked = !1)
                                            }
                                        } catch (e) {
                                            T = !0, _ = e
                                        } finally {
                                            try {
                                                k || null == I.return || I.return()
                                            } finally {
                                                if (T) throw _
                                            }
                                        }
                                        break;
                                    case 5:
                                        var O = !0,
                                            D = !1,
                                            P = void 0;
                                        try {
                                            for (var A, F = q[Symbol.iterator](); !(O = (A = F.next()).done); O = !0) {
                                                var z = A.value;
                                                4 == z.value && (z.checked = !1)
                                            }
                                        } catch (e) {
                                            D = !0, P = e
                                        } finally {
                                            try {
                                                O || null == F.return || F.return()
                                            } finally {
                                                if (D) throw P
                                            }
                                        }
                                        break;
                                    case 3:
                                        var N = !0,
                                            j = !1,
                                            R = void 0;
                                        try {
                                            for (var H, B = q[Symbol.iterator](); !(N = (H = B.next()).done); N = !0) {
                                                var $ = H.value;
                                                2 == $.value && ($.checked = !1)
                                            }
                                        } catch (e) {
                                            j = !0, R = e
                                        } finally {
                                            try {
                                                N || null == B.return || B.return()
                                            } finally {
                                                if (j) throw R
                                            }
                                        }
                                }
                                Y.checked = !1
                            }(i), Math.max(document.body.scrollHeight, document.documentElement.scrollHeight, document.body.offsetHeight, document.documentElement.offsetHeight, document.body.clientHeight, document.documentElement.clientHeight) > document.documentElement.clientHeight) {
                            var n = window.pageYOffset;
                            document.documentElement.classList.add("noscroll"), document.documentElement.style.top = -n + "px"
                        }
                        y.classList.add("active")
                    }
                }), document.addEventListener("change", function(e) {
                    if (!e.target.matches(f)) return !1;
                    var t = 0,
                        i = !0,
                        n = !1,
                        a = void 0;
                    try {
                        for (var r, s = q[Symbol.iterator](); !(i = (r = s.next()).done); i = !0) 1 == r.value.checked && t++
                    } catch (e) {
                        n = !0, a = e
                    } finally {
                        try {
                            i || null == s.return || s.return()
                        } finally {
                            if (n) throw a
                        }
                    }
                    t == q.length ? Y.checked = !0 : Y.checked = !1
                }), document.addEventListener("change", function(e) {
                    if (!e.target.matches(m)) return !1;
                    if (1 == Y.checked) {
                        var t = !0,
                            i = !1,
                            n = void 0;
                        try {
                            for (var a, r = q[Symbol.iterator](); !(t = (a = r.next()).done); t = !0) {
                                var s = a.value;
                                s.hasAttribute("disabled") || (s.checked = !0)
                            }
                        } catch (e) {
                            i = !0, n = e
                        } finally {
                            try {
                                t || null == r.return || r.return()
                            } finally {
                                if (i) throw n
                            }
                        }
                    } else {
                        var o = !0,
                            l = !1,
                            c = void 0;
                        try {
                            for (var d, u = q[Symbol.iterator](); !(o = (d = u.next()).done); o = !0) {
                                var h = d.value;
                                h.hasAttribute("disabled") || (h.checked = !1)
                            }
                        } catch (e) {
                            l = !0, c = e
                        } finally {
                            try {
                                o || null == u.return || u.return()
                            } finally {
                                if (l) throw c
                            }
                        }
                    }
                })
            }
        }
    }).call(this, i(3))
}, function(n, a, r) {
    var s, o;
    ! function(e) {
        if (void 0 === (o = "function" == typeof(s = e) ? s.call(a, r, a, n) : s) || (n.exports = o), !0, n.exports = e(), !!0) {
            var t = window.Cookies,
                i = window.Cookies = e();
            i.noConflict = function() {
                return window.Cookies = t, i
            }
        }
    }(function() {
        function v() {
            for (var e = 0, t = {}; e < arguments.length; e++) {
                var i = arguments[e];
                for (var n in i) t[n] = i[n]
            }
            return t
        }
        return function e(p) {
            function f(e, t, i) {
                var n;
                if ("undefined" != typeof document) {
                    if (1 < arguments.length) {
                        if ("number" == typeof(i = v({
                                path: "/"
                            }, f.defaults, i)).expires) {
                            var a = new Date;
                            a.setMilliseconds(a.getMilliseconds() + 864e5 * i.expires), i.expires = a
                        }
                        i.expires = i.expires ? i.expires.toUTCString() : "";
                        try {
                            n = JSON.stringify(t), /^[\{\[]/.test(n) && (t = n)
                        } catch (e) {}
                        t = p.write ? p.write(t, e) : encodeURIComponent(String(t)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent), e = (e = (e = encodeURIComponent(String(e))).replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent)).replace(/[\(\)]/g, escape);
                        var r = "";
                        for (var s in i) i[s] && (r += "; " + s, !0 !== i[s] && (r += "=" + i[s]));
                        return document.cookie = e + "=" + t + r
                    }
                    e || (n = {});
                    for (var o = document.cookie ? document.cookie.split("; ") : [], l = /(%[0-9A-Z]{2})+/g, c = 0; c < o.length; c++) {
                        var d = o[c].split("="),
                            u = d.slice(1).join("=");
                        this.json || '"' !== u.charAt(0) || (u = u.slice(1, -1));
                        try {
                            var h = d[0].replace(l, decodeURIComponent);
                            if (u = p.read ? p.read(u, h) : p(u, h) || u.replace(l, decodeURIComponent), this.json) try {
                                u = JSON.parse(u)
                            } catch (e) {}
                            if (e === h) {
                                n = u;
                                break
                            }
                            e || (n[h] = u)
                        } catch (e) {}
                    }
                    return n
                }
            }
            return (f.set = f).get = function(e) {
                return f.call(f, e)
            }, f.getJSON = function() {
                return f.apply({
                    json: !0
                }, [].slice.call(arguments))
            }, f.defaults = {}, f.remove = function(e, t) {
                f(e, "", v(t, {
                    expires: -1
                }))
            }, f.withConverter = e, f
        }(function() {})
    })
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            r = e.element,
            s = e.trigger,
            t = e.clickable,
            i = e.close,
            n = e.scrollable,
            a = void 0 !== n && n,
            o = document.querySelector(r),
            l = document.querySelector(s);

        function c() {
            var e = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight, document.body.offsetHeight, document.documentElement.offsetHeight, document.body.clientHeight, document.documentElement.clientHeight);
            if (!0 === a && o.classList.contains("active") && e > document.documentElement.clientHeight) {
                var t = window.pageYOffset;
                document.documentElement.classList.add("noscroll"), document.documentElement.style.top = -t + "px"
            } else if (!0 === a && document.documentElement.classList.contains("noscroll")) {
                var i = getComputedStyle(document.documentElement);
                t = parseInt(i.top), document.documentElement.classList.remove("noscroll"), window.scrollTo(0, -t)
            }
        }
        document.querySelector(t), document.querySelector(i), this.toggleActive = function() {
            if (null == o) return !1;
            document.addEventListener("click", function(e) {
                if (!e.target.matches(s) && !e.target.closest(s)) return !1;
                o.classList.toggle("active"), l.classList.toggle("active"), c()
            })
        }, this.removeActive = function() {
            if (null == o) return !1;
            document.addEventListener("mousedown", function(e) {
                e.target.closest(t) || e.target.closest(s) || !o.classList.contains("active") || o.classList.contains("loading") || (e.stopPropagation(), o.classList.remove("active"), l.classList.remove("active"), c())
            }), document.addEventListener("click", function(e) {
                e.target.matches(i) && o.classList.contains("active") && l.classList.contains("active") && (o.classList.remove("active"), l.classList.remove("active"), c())
            }), document.addEventListener("keydown", function(e) {
                27 === e.keyCode && o.classList.contains("active") && l.classList.contains("active") && (o.classList.remove("active"), l.classList.remove("active"), c())
            })
        }, this.addActive = function() {
            if (null == o || null == l) return !1;
            document.addEventListener("click", function(i) {
                if (!i.target.matches(s) && !i.target.closest(s)) return !1;
                var n = 0,
                    e = document.querySelectorAll(s),
                    t = document.querySelectorAll(r);
                if ([].forEach.call(e, function(e, t) {
                        e.classList.contains("active") && e.classList.remove("active"), i.target == e && (n = t)
                    }), [].forEach.call(t, function(e, t) {
                        e.classList.contains("active") && e.classList.remove("active")
                    }), null != e[n] && null != t[n]) {
                    e[n].classList.add("active"), t[n].classList.add("active");
                    var a = new CustomEvent("swiperScrollbarTrigger");
                    document.dispatchEvent(a)
                }
            })
        }
    }
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            i = e.trigger,
            n = e.submenu,
            a = document.querySelectorAll(i);
        this.toggleMenu = function() {
            document.addEventListener("click", function(e) {
                if (e.target.matches(i)) {
                    var t = e.target;
                    if (!t.querySelector(n)) return !1;
                    t.classList.contains("active") ? (t.classList.remove("active"), t.querySelector(n).classList.remove("active"), t.parentElement.classList.remove("opened")) : ([].forEach.call(a, function(e, t) {
                        e.classList.contains("active") && (e.classList.remove("active"), e.querySelector(n).classList.remove("active"))
                    }), t.classList.add("active"), t.parentElement.classList.add("opened"), t.querySelector(n).classList.add("active"))
                }
            })
        }
    }
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            t = e.trigger,
            i = e.element;
        this.initFocus = function() {
            document.addEventListener("click", function(e) {
                if (!e.target.matches(t)) return !1;
                e.target.classList.contains("active") ? document.querySelector(i).focus() : document.querySelector(i).blur()
            })
        }
    }
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            t = e.element,
            i = e.cls,
            n = e.offset,
            a = e.breakpoint,
            r = document.querySelector(t),
            s = document.querySelector(n),
            o = null != r ? r.offsetHeight : "";

        function l() {
            window.innerWidth > a && window.pageYOffset > o && !r.classList.contains(i) ? (r.classList.add(i), s.style.marginTop = o + "px") : window.pageYOffset <= o && !document.documentElement.classList.contains("noscroll") && (r.classList.remove(i), s.style.marginTop = "")
        }
        this.stickyNavigation = function() {
            if (null == r) return !1;
            document.addEventListener("DOMContentLoaded", function() {
                r.classList.contains(i) || (o = r.offsetHeight), l()
            }), window.onresize = function() {
                r.classList.contains(i) || (o = r.offsetHeight), l()
            }, window.onscroll = l
        }
    }
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            d = e.container,
            t = e.breakpoint,
            n = void 0 === t ? null : t,
            i = document.querySelector(d),
            a = document.querySelectorAll(d),
            r = [];

        function s() {
            [].forEach.call(a, function(e, t) {
                if (null != n) return window.innerWidth <= n && !e.classList.contains("wrap") ? e.classList.add("wrap") : window.innerWidth > n && e.classList.contains("wrap") && e.classList.remove("wrap"), !1;
                var i = e.parentElement.clientWidth;
                r[t] > i && !e.classList.contains("wrap") ? e.classList.add("wrap") : r[t] <= i && e.classList.contains("wrap") && e.classList.remove("wrap")
            })
        }

        function o() {
            [].forEach.call(a, function(e, t) {
                var i = null != e.querySelector("button") ? e.querySelector("button").offsetWidth : 0,
                    n = e.querySelector("ul").offsetWidth,
                    a = parseInt(i) + parseInt(n);
                r.push(a)
            }), s()
        }
        this.initDropdown = function() {
            if (null == i) return !1;
            var e;
            document.addEventListener("click", function(e) {
                if (e.target.matches(d + " button") && ((t = e.target.closest(d)).classList.contains("active") ? t.classList.remove("active") : t.classList.add("active")), e.target.matches(d + " li") || e.target.matches(d + " a")) {
                    var t, i = (t = e.target.closest(d)).querySelector("button"),
                        n = t.querySelectorAll("a");
                    t.hasAttribute("data-dropdown-type") && "autocomplete" == t.getAttribute("data-dropdown-type") && (e.preventDefault(), i.textContent = e.target.textContent), t.classList.remove("active");
                    var a = !0,
                        r = !1,
                        s = void 0;
                    try {
                        for (var o, l = n[Symbol.iterator](); !(a = (o = l.next()).done); a = !0) {
                            var c = o.value;
                            c.classList.contains("active") && c.classList.remove("active")
                        }
                    } catch (e) {
                        r = !0, s = e
                    } finally {
                        try {
                            a || null == l.return || l.return()
                        } finally {
                            if (r) throw s
                        }
                    }
                    e.target.closest("a").classList.add("active")
                }
            }), document.addEventListener("DOMContentLoaded", o), window.addEventListener("resize", function() {
                e || (e = setTimeout(function() {
                    e = null, s()
                }, 66))
            }, !1)
        }
    }
}, function(e, t, i) {
    var p = i(10);
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            t = e.element,
            i = e.options,
            c = void 0 === i ? null : i,
            n = e.submit,
            d = void 0 !== n && n,
            u = document.querySelector(t),
            h = document.querySelectorAll(t);
        this.initChoices = function() {
            if (null == u) return !1;
            var e = {
                loadingText: "Se încarcă...",
                noResultsText: "Nu există rezultate",
                noChoicesText: "No există opțiuni",
                itemSelectText: "Selectează",
                searchPlaceholderValue: "Caută",
                addItemText: function(e) {
                    return 'Apasă Enter pentru a adăuga <b>"'.concat(e, '"</b>')
                },
                maxItemText: function(e) {
                    return "Pot fi adăugate maximum ".concat(e, " opțiuni")
                },
                classNames: {
                    containerOuter: "choices",
                    containerInner: "choices-inner",
                    input: "choices-input",
                    inputCloned: "choices-input-cloned",
                    list: "choices-list",
                    listItems: "choices-list-multiple",
                    listSingle: "choices-list-single",
                    listDropdown: "choices-list-dropdown",
                    item: "choices-item",
                    itemSelectable: "choices-item-selectable",
                    itemDisabled: "choices-item-disabled",
                    itemChoice: "choices-item-choice",
                    placeholder: "choices-placeholder",
                    group: "choices-group",
                    groupHeading: "choices-heading",
                    button: "choices-button",
                    activeState: "is-active",
                    focusState: "is-focused",
                    openState: "is-open",
                    disabledState: "is-disabled",
                    highlightedState: "is-highlighted",
                    hiddenState: "is-hidden",
                    flippedState: "is-flipped",
                    loadingState: "is-loading",
                    noResults: "has-no-results",
                    noChoices: "has-no-choices"
                }
            };
            if (c = null != c ? Object.assign({}, c, e) : e, 1 < h.length) {
                var a = [],
                    t = !0,
                    i = !1,
                    n = void 0;
                try {
                    for (var r, s = h[Symbol.iterator](); !(t = (r = s.next()).done); t = !0) {
                        var o = r.value;
                        o.selectedIndex = 0;
                        var l = new p(o, c);
                        a.push(l)
                    }
                } catch (e) {
                    i = !0, n = e
                } finally {
                    try {
                        t || null == s.return || s.return()
                    } finally {
                        if (i) throw n
                    }
                }
            } else 0 == d && (u.selectedIndex = 0), new p(u, c);
            u.addEventListener("change", function() {
                var e = u.closest("form");
                null != e && 1 == d && e.submit(), null == e && 1 == d && (location.href = window.appCfgDist.baseUrl + u.value)
            }, !1), document.addEventListener("ajaxCallXhrTrigger", function(e) {
                if (1 < h.length && 0 < a.length)
                    for (var t = 0, i = 0; i < a.length; i++)
                        if (a[i].passedElement.element.matches(e.detail.dest)) {
                            if (a[i].setChoices(e.detail.json, "value", "label", !0), a[i].passedElement.element.closest(".form-element").classList.remove("hide"), t = i, ++t < a.length)
                                for (var n = t; n < a.length; n++) a[n].clearStore(), a[n].passedElement.element.closest(".form-element").classList.add("hide");
                            break
                        }
            })
        }
    }
}, function(Fi, Gi, Hi) {
    "undefined" != typeof self && self, Fi.exports = function(i) {
        function n(e) {
            if (a[e]) return a[e].exports;
            var t = a[e] = {
                i: e,
                l: !1,
                exports: {}
            };
            return i[e].call(t.exports, t, t.exports, n), t.l = !0, t.exports
        }
        var a = {};
        return n.m = i, n.c = a, n.d = function(e, t, i) {
            n.o(e, t) || Object.defineProperty(e, t, {
                configurable: !1,
                enumerable: !0,
                get: i
            })
        }, n.n = function(e) {
            var t = e && e.__esModule ? function() {
                return e.default
            } : function() {
                return e
            };
            return n.d(t, "a", t), t
        }, n.o = function(e, t) {
            return Object.prototype.hasOwnProperty.call(e, t)
        }, n.p = "/public/assets/scripts/", n(n.s = 37)
    }([function(e, t, i) {
        var n = i(26)("wks"),
            a = i(13),
            r = i(3).Symbol,
            s = "function" == typeof r;
        (e.exports = function(e) {
            return n[e] || (n[e] = s && r[e] || (s ? r : a)("Symbol." + e))
        }).store = n
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var n, a = t.getRandomNumber = function(e, t) {
                return Math.floor(Math.random() * (t - e) + e)
            },
            r = t.generateChars = function(e) {
                for (var t = "", i = 0; i < e; i++) t += a(0, 36).toString(36);
                return t
            },
            s = (t.generateId = function(e, t) {
                var i = e.id || e.name && e.name + "-" + r(2) || r(4);
                return i = i.replace(/(:|\.|\[|\]|,)/g, ""), i = t + "-" + i
            }, t.getType = function(e) {
                return Object.prototype.toString.call(e).slice(8, -1)
            }),
            o = t.isType = function(e, t) {
                var i = s(t);
                return null != t && i === e
            },
            l = (t.isElement = function(e) {
                return e instanceof Element
            }, t.extend = function i() {
                for (var n = {}, e = arguments.length, t = 0; t < e; t++) {
                    var a = arguments[t];
                    o("Object", a) && function(e) {
                        for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (o("Object", e[t]) ? n[t] = i(!0, n[t], e[t]) : n[t] = e[t])
                    }(a)
                }
                return n
            }, t.wrap = function(e, t) {
                return t = t || document.createElement("div"), e.nextSibling ? e.parentNode.insertBefore(t, e.nextSibling) : e.parentNode.appendChild(t), t.appendChild(e)
            }, t.findAncestor = function(e, t) {
                for (;
                    (e = e.parentElement) && !e.classList.contains(t););
                return e
            }, t.findAncestorByAttrName = function(e, t) {
                for (var i = e; i;) {
                    if (i.hasAttribute(t)) return i;
                    i = i.parentElement
                }
                return null
            }, t.getAdjacentEl = function(e, t) {
                var i = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 1;
                if (e && t) {
                    var n = e.parentNode.parentNode,
                        a = Array.from(n.querySelectorAll(t));
                    return a[a.indexOf(e) + (0 < i ? 1 : -1)]
                }
            }, t.isScrolledIntoView = function(e, t) {
                var i = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 1;
                if (e) return 0 < i ? t.scrollTop + t.offsetHeight >= e.offsetTop + e.offsetHeight : e.offsetTop >= t.scrollTop
            }, t.stripHTML = function(e) {
                return e.replace(/&/g, "&amp;").replace(/>/g, "&rt;").replace(/</g, "&lt;").replace(/"/g, "&quot;")
            }),
            c = t.strToEl = (n = document.createElement("div"), function(e) {
                var t = e.trim(),
                    i = void 0;
                for (n.innerHTML = t, i = n.children[0]; n.firstChild;) n.removeChild(n.firstChild);
                return i
            });
        t.calcWidthOfInput = function(e, t) {
            var i = e.value || e.placeholder,
                n = e.offsetWidth;
            if (i) {
                var a = c("<span>" + l(i) + "</span>");
                if (a.style.position = "absolute", a.style.padding = "0", a.style.top = "-9999px", a.style.left = "-9999px", a.style.width = "auto", a.style.whiteSpace = "pre", document.body.contains(e) && window.getComputedStyle) {
                    var r = window.getComputedStyle(e);
                    r && (a.style.fontSize = r.fontSize, a.style.fontFamily = r.fontFamily, a.style.fontWeight = r.fontWeight, a.style.fontStyle = r.fontStyle, a.style.letterSpacing = r.letterSpacing, a.style.textTransform = r.textTransform, a.style.padding = r.padding)
                }
                document.body.appendChild(a), requestAnimationFrame(function() {
                    i && a.offsetWidth !== e.offsetWidth && (n = a.offsetWidth + 4), document.body.removeChild(a), t.call(void 0, n + "px")
                })
            } else t.call(void 0, n + "px")
        }, t.sortByAlpha = function(e, t) {
            var i = (e.label || e.value).toLowerCase(),
                n = (t.label || t.value).toLowerCase();
            return i < n ? -1 : n < i ? 1 : 0
        }, t.sortByScore = function(e, t) {
            return e.score - t.score
        }, t.dispatchEvent = function(e, t) {
            var i = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : null,
                n = new CustomEvent(t, {
                    detail: i,
                    bubbles: !0,
                    cancelable: !0
                });
            return e.dispatchEvent(n)
        }, t.regexFilter = function(e, t) {
            return !(!e || !t) && new RegExp(t.source, "i").test(e)
        }, t.getWindowHeight = function() {
            var e = document.body,
                t = document.documentElement;
            return Math.max(e.scrollHeight, e.offsetHeight, t.clientHeight, t.scrollHeight, t.offsetHeight)
        }, t.reduceToValues = function(e) {
            var i = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "value";
            return e.reduce(function(e, t) {
                return e.push(t[i]), e
            }, [])
        }, t.fetchFromObject = function e(t, i) {
            var n = i.indexOf(".");
            return -1 < n ? e(t[i.substring(0, n)], i.substr(n + 1)) : t[i]
        }, t.isIE11 = function() {
            return !(!navigator.userAgent.match(/Trident/) || !navigator.userAgent.match(/rv[ :]11/))
        }, t.existsInArray = function(e, t) {
            var i = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "value";
            return e.some(function(e) {
                return o("String", t) ? e[i] === t.trim() : e[i] === t
            })
        }, t.cloneObject = function(e) {
            return JSON.parse(JSON.stringify(e))
        }, t.doKeysMatch = function(e, t) {
            var i = Object.keys(e).sort(),
                n = Object.keys(t).sort();
            return JSON.stringify(i) === JSON.stringify(n)
        }
    }, function(e, t) {
        var i = e.exports = {
            version: "2.5.7"
        };
        "number" == typeof __e && (__e = i)
    }, function(e, t) {
        var i = e.exports = "undefined" != typeof window && window.Math == Math ? window : "undefined" != typeof self && self.Math == Math ? self : Function("return this")();
        "number" == typeof __g && (__g = i)
    }, function(e, t, i) {
        var n = i(7),
            a = i(12);
        e.exports = i(10) ? function(e, t, i) {
            return n.f(e, t, a(1, i))
        } : function(e, t, i) {
            return e[t] = i, e
        }
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        }), t.SCROLLING_SPEED = t.KEY_CODES = t.ACTION_TYPES = t.EVENTS = t.DEFAULT_CONFIG = t.DEFAULT_CLASSNAMES = void 0;
        var n = i(1),
            a = t.DEFAULT_CLASSNAMES = {
                containerOuter: "choices",
                containerInner: "choices__inner",
                input: "choices__input",
                inputCloned: "choices__input--cloned",
                list: "choices__list",
                listItems: "choices__list--multiple",
                listSingle: "choices__list--single",
                listDropdown: "choices__list--dropdown",
                item: "choices__item",
                itemSelectable: "choices__item--selectable",
                itemDisabled: "choices__item--disabled",
                itemChoice: "choices__item--choice",
                placeholder: "choices__placeholder",
                group: "choices__group",
                groupHeading: "choices__heading",
                button: "choices__button",
                activeState: "is-active",
                focusState: "is-focused",
                openState: "is-open",
                disabledState: "is-disabled",
                highlightedState: "is-highlighted",
                hiddenState: "is-hidden",
                flippedState: "is-flipped",
                loadingState: "is-loading",
                noResults: "has-no-results",
                noChoices: "has-no-choices"
            };
        t.DEFAULT_CONFIG = {
            items: [],
            choices: [],
            silent: !1,
            renderChoiceLimit: -1,
            maxItemCount: -1,
            addItems: !0,
            removeItems: !0,
            removeItemButton: !1,
            editItems: !1,
            duplicateItemsAllowed: !0,
            delimiter: ",",
            paste: !0,
            searchEnabled: !0,
            searchChoices: !0,
            searchFloor: 1,
            searchResultLimit: 4,
            searchFields: ["label", "value"],
            position: "auto",
            resetScrollPosition: !0,
            regexFilter: null,
            shouldSort: !0,
            shouldSortItems: !1,
            sortFn: n.sortByAlpha,
            placeholder: !0,
            placeholderValue: null,
            searchPlaceholderValue: null,
            prependValue: null,
            appendValue: null,
            renderSelectedChoices: "auto",
            loadingText: "Loading...",
            noResultsText: "No results found",
            noChoicesText: "No choices to choose from",
            itemSelectText: "Press to select",
            uniqueItemText: "Only unique values can be added",
            addItemText: function(e) {
                return 'Press Enter to add <b>"' + (0, n.stripHTML)(e) + '"</b>'
            },
            maxItemText: function(e) {
                return "Only " + e + " values can be added"
            },
            itemComparer: function(e, t) {
                return e === t
            },
            fuseOptions: {
                includeScore: !0
            },
            callbackOnInit: null,
            callbackOnCreateTemplates: null,
            classNames: a
        }, t.EVENTS = {
            showDropdown: "showDropdown",
            hideDropdown: "hideDropdown",
            change: "change",
            choice: "choice",
            search: "search",
            addItem: "addItem",
            removeItem: "removeItem",
            highlightItem: "highlightItem",
            highlightChoice: "highlightChoice"
        }, t.ACTION_TYPES = {
            ADD_CHOICE: "ADD_CHOICE",
            FILTER_CHOICES: "FILTER_CHOICES",
            ACTIVATE_CHOICES: "ACTIVATE_CHOICES",
            CLEAR_CHOICES: "CLEAR_CHOICES",
            ADD_GROUP: "ADD_GROUP",
            ADD_ITEM: "ADD_ITEM",
            REMOVE_ITEM: "REMOVE_ITEM",
            HIGHLIGHT_ITEM: "HIGHLIGHT_ITEM",
            CLEAR_ALL: "CLEAR_ALL"
        }, t.KEY_CODES = {
            BACK_KEY: 46,
            DELETE_KEY: 8,
            ENTER_KEY: 13,
            A_KEY: 65,
            ESC_KEY: 27,
            UP_KEY: 38,
            DOWN_KEY: 40,
            PAGE_UP_KEY: 33,
            PAGE_DOWN_KEY: 34
        }, t.SCROLLING_SPEED = 4
    }, function(e, t, i) {
        var v = i(3),
            m = i(2),
            g = i(4),
            y = i(24),
            b = i(14),
            w = function(e, t, i) {
                var n, a, r, s, o = e & w.F,
                    l = e & w.G,
                    c = e & w.S,
                    d = e & w.P,
                    u = e & w.B,
                    h = l ? v : c ? v[t] || (v[t] = {}) : (v[t] || {}).prototype,
                    p = l ? m : m[t] || (m[t] = {}),
                    f = p.prototype || (p.prototype = {});
                for (n in l && (i = t), i) a = !o && h && void 0 !== h[n], r = (a ? h : i)[n], s = u && a ? b(r, v) : d && "function" == typeof r ? b(Function.call, r) : r, h && y(h, n, r, e & w.U), p[n] != r && g(p, n, s), d && f[n] != r && (f[n] = r)
            };
        v.core = m, w.F = 1, w.G = 2, w.S = 4, w.P = 8, w.B = 16, w.W = 32, w.U = 64, w.R = 128, e.exports = w
    }, function(e, t, i) {
        var n = i(8),
            a = i(44),
            r = i(45),
            s = Object.defineProperty;
        t.f = i(10) ? Object.defineProperty : function(e, t, i) {
            if (n(e), t = r(t, !0), n(i), a) try {
                return s(e, t, i)
            } catch (e) {}
            if ("get" in i || "set" in i) throw TypeError("Accessors not supported!");
            return "value" in i && (e[t] = i.value), e
        }
    }, function(e, t, i) {
        var n = i(9);
        e.exports = function(e) {
            if (!n(e)) throw TypeError(e + " is not an object!");
            return e
        }
    }, function(e, t) {
        e.exports = function(e) {
            return "object" == typeof e ? null !== e : "function" == typeof e
        }
    }, function(e, t, i) {
        e.exports = !i(22)(function() {
            return 7 != Object.defineProperty({}, "a", {
                get: function() {
                    return 7
                }
            }).a
        })
    }, function(e, t) {
        var i = {}.hasOwnProperty;
        e.exports = function(e, t) {
            return i.call(e, t)
        }
    }, function(e, t) {
        e.exports = function(e, t) {
            return {
                enumerable: !(1 & e),
                configurable: !(2 & e),
                writable: !(4 & e),
                value: t
            }
        }
    }, function(e, t) {
        var i = 0,
            n = Math.random();
        e.exports = function(e) {
            return "Symbol(".concat(void 0 === e ? "" : e, ")_", (++i + n).toString(36))
        }
    }, function(e, t, i) {
        var r = i(46);
        e.exports = function(n, a, e) {
            if (r(n), void 0 === a) return n;
            switch (e) {
                case 1:
                    return function(e) {
                        return n.call(a, e)
                    };
                case 2:
                    return function(e, t) {
                        return n.call(a, e, t)
                    };
                case 3:
                    return function(e, t, i) {
                        return n.call(a, e, t, i)
                    }
            }
            return function() {
                return n.apply(a, arguments)
            }
        }
    }, function(e, t) {
        var i = {}.toString;
        e.exports = function(e) {
            return i.call(e).slice(8, -1)
        }
    }, function(e, t, i) {
        var n = i(17);
        e.exports = function(e) {
            return Object(n(e))
        }
    }, function(e, t) {
        e.exports = function(e) {
            if (null == e) throw TypeError("Can't call method on  " + e);
            return e
        }
    }, function(e, t, i) {
        var n = i(19),
            a = Math.min;
        e.exports = function(e) {
            return 0 < e ? a(n(e), 9007199254740991) : 0
        }
    }, function(e, t) {
        var i = Math.ceil,
            n = Math.floor;
        e.exports = function(e) {
            return isNaN(e = +e) ? 0 : (0 < e ? n : i)(e)
        }
    }, function(e, t) {
        e.exports = {}
    }, function(e, t, i) {
        var n = i(26)("keys"),
            a = i(13);
        e.exports = function(e) {
            return n[e] || (n[e] = a(e))
        }
    }, function(e, t) {
        e.exports = function(e) {
            try {
                return !!e()
            } catch (e) {
                return !0
            }
        }
    }, function(e, t, i) {
        var n = i(9),
            a = i(3).document,
            r = n(a) && n(a.createElement);
        e.exports = function(e) {
            return r ? a.createElement(e) : {}
        }
    }, function(e, t, i) {
        var r = i(3),
            s = i(4),
            o = i(11),
            l = i(13)("src"),
            n = Function.toString,
            c = ("" + n).split("toString");
        i(2).inspectSource = function(e) {
            return n.call(e)
        }, (e.exports = function(e, t, i, n) {
            var a = "function" == typeof i;
            a && (o(i, "name") || s(i, "name", t)), e[t] !== i && (a && (o(i, l) || s(i, l, e[t] ? "" + e[t] : c.join(String(t)))), e === r ? e[t] = i : n ? e[t] ? e[t] = i : s(e, t, i) : (delete e[t], s(e, t, i)))
        })(Function.prototype, "toString", function() {
            return "function" == typeof this && this[l] || n.call(this)
        })
    }, function(e, t, i) {
        var n = i(15);
        e.exports = Object("z").propertyIsEnumerable(0) ? Object : function(e) {
            return "String" == n(e) ? e.split("") : Object(e)
        }
    }, function(e, t, i) {
        var n = i(2),
            a = i(3),
            r = a["__core-js_shared__"] || (a["__core-js_shared__"] = {});
        (e.exports = function(e, t) {
            return r[e] || (r[e] = void 0 !== t ? t : {})
        })("versions", []).push({
            version: n.version,
            mode: i(27) ? "pure" : "global",
            copyright: "© 2018 Denis Pushkarev (zloirock.ru)"
        })
    }, function(e, t) {
        e.exports = !1
    }, function(e, t, i) {
        var n = i(0)("unscopables"),
            a = Array.prototype;
        null == a[n] && i(4)(a, n, {}), e.exports = function(e) {
            a[n][e] = !0
        }
    }, function(e, t, i) {
        var n = i(25),
            a = i(17);
        e.exports = function(e) {
            return n(a(e))
        }
    }, function(e, t, i) {
        var l = i(29),
            c = i(18),
            d = i(60);
        e.exports = function(o) {
            return function(e, t, i) {
                var n, a = l(e),
                    r = c(a.length),
                    s = d(i, r);
                if (o && t != t) {
                    for (; s < r;)
                        if ((n = a[s++]) != n) return !0
                } else
                    for (; s < r; s++)
                        if ((o || s in a) && a[s] === t) return o || s || 0;
                return !o && -1
            }
        }
    }, function(e, t) {
        e.exports = "constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf".split(",")
    }, function(e, t, i) {
        var n = i(7).f,
            a = i(11),
            r = i(0)("toStringTag");
        e.exports = function(e, t, i) {
            e && !a(e = i ? e : e.prototype, r) && n(e, r, {
                configurable: !0,
                value: t
            })
        }
    }, function(e, t, i) {
        "use strict";

        function p(e, t, i) {
            function n() {
                u === d && (u = d.slice())
            }

            function a() {
                return c
            }

            function r(t) {
                if ("function" != typeof t) throw new Error("Expected listener to be a function.");
                var i = !0;
                return n(), u.push(t),
                    function() {
                        if (i) {
                            i = !1, n();
                            var e = u.indexOf(t);
                            u.splice(e, 1)
                        }
                    }
            }

            function s(e) {
                if (!A(e)) throw new Error("Actions must be plain objects. Use custom middleware for async actions.");
                if (void 0 === e.type) throw new Error('Actions may not have an undefined "type" property. Have you misspelled a constant?');
                if (h) throw new Error("Reducers may not dispatch actions.");
                try {
                    h = !0, c = l(c, e)
                } finally {
                    h = !1
                }
                for (var t = d = u, i = 0; i < t.length; i++)(0, t[i])();
                return e
            }
            var o;
            if ("function" == typeof t && void 0 === i && (i = t, t = void 0), void 0 !== i) {
                if ("function" != typeof i) throw new Error("Expected the enhancer to be a function.");
                return i(p)(e, t)
            }
            if ("function" != typeof e) throw new Error("Expected the reducer to be a function.");
            var l = e,
                c = t,
                d = [],
                u = d,
                h = !1;
            return s({
                type: z.INIT
            }), (o = {
                dispatch: s,
                subscribe: r,
                getState: a,
                replaceReducer: function(e) {
                    if ("function" != typeof e) throw new Error("Expected the nextReducer to be a function.");
                    l = e, s({
                        type: z.INIT
                    })
                }
            })[F.a] = function() {
                var e, i = r;
                return (e = {
                    subscribe: function(e) {
                        function t() {
                            e.next && e.next(a())
                        }
                        if ("object" != typeof e) throw new TypeError("Expected the observer to be an object.");
                        return t(), {
                            unsubscribe: i(t)
                        }
                    }
                })[F.a] = function() {
                    return this
                }, e
            }, o
        }

        function n(e) {
            for (var t = Object.keys(e), p = {}, i = 0; i < t.length; i++) {
                var n = t[i];
                "function" == typeof e[n] && (p[n] = e[n])
            }
            var a, f = Object.keys(p),
                v = void 0;
            try {
                a = p, Object.keys(a).forEach(function(e) {
                    var t = a[e];
                    if (void 0 === t(void 0, {
                            type: z.INIT
                        })) throw new Error('Reducer "' + e + "\" returned undefined during initialization. If the state passed to the reducer is undefined, you must explicitly return the initial state. The initial state may not be undefined. If you don't want to set a value for this reducer, you can use null instead of undefined.");
                    if (void 0 === t(void 0, {
                            type: "@@redux/PROBE_UNKNOWN_ACTION_" + Math.random().toString(36).substring(7).split("").join(".")
                        })) throw new Error('Reducer "' + e + "\" returned undefined when probed with a random type. Don't try to handle " + z.INIT + ' or other actions in "redux/*" namespace. They are considered private. Instead, you must return the current state for any unknown actions, unless it is undefined, in which case you must return the initial state, regardless of the action type. The initial state may not be undefined, but can be null.')
                })
            } catch (e) {
                v = e
            }
            return function() {
                var e, t, i, n = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
                    a = arguments[1];
                if (v) throw v;
                for (var r = !1, s = {}, o = 0; o < f.length; o++) {
                    var l = f[o],
                        c = p[l],
                        d = n[l],
                        u = c(d, a);
                    if (void 0 === u) {
                        var h = (e = l, i = void 0, "Given action " + ((i = (t = a) && t.type) && '"' + i.toString() + '"' || "an action") + ', reducer "' + e + '" returned undefined. To ignore an action, you must explicitly return the previous state. If you want this reducer to hold no value, you can return null instead of undefined.');
                        throw new Error(h)
                    }
                    s[l] = u, r = r || u !== d
                }
                return r ? s : n
            }
        }

        function o(e, t) {
            return function() {
                return t(e.apply(void 0, arguments))
            }
        }

        function a(e, t) {
            if ("function" == typeof e) return o(e, t);
            if ("object" != typeof e || null === e) throw new Error("bindActionCreators expected an object or a function, instead received " + (null === e ? "null" : typeof e) + '. Did you write "import ActionCreators from" instead of "import * as ActionCreators from"?');
            for (var i = Object.keys(e), n = {}, a = 0; a < i.length; a++) {
                var r = i[a],
                    s = e[r];
                "function" == typeof s && (n[r] = o(s, t))
            }
            return n
        }

        function c() {
            for (var e = arguments.length, t = Array(e), i = 0; i < e; i++) t[i] = arguments[i];
            return 0 === t.length ? function(e) {
                return e
            } : 1 === t.length ? t[0] : t.reduce(function(e, t) {
                return function() {
                    return e(t.apply(void 0, arguments))
                }
            })
        }

        function r() {
            for (var e = arguments.length, l = Array(e), t = 0; t < e; t++) l[t] = arguments[t];
            return function(o) {
                return function(e, t, i) {
                    var n = o(e, t, i),
                        a = n.dispatch,
                        r = [],
                        s = {
                            getState: n.getState,
                            dispatch: function(e) {
                                return a(e)
                            }
                        };
                    return r = l.map(function(e) {
                        return e(s)
                    }), a = c.apply(void 0, r)(n.dispatch), N({}, n, {
                        dispatch: a
                    })
                }
            }
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var s = i(74),
            l = "object" == typeof self && self && self.Object === Object && self,
            d = s.a || l || Function("return this")(),
            u = d,
            h = u.Symbol,
            f = h,
            v = Object.prototype,
            m = v.hasOwnProperty,
            g = v.toString,
            y = f ? f.toStringTag : void 0,
            b = function(e) {
                var t = m.call(e, y),
                    i = e[y];
                try {
                    var n = !(e[y] = void 0)
                } catch (e) {}
                var a = g.call(e);
                return n && (t ? e[y] = i : delete e[y]), a
            },
            w = Object.prototype,
            E = w.toString,
            x = function(e) {
                return E.call(e)
            },
            S = f ? f.toStringTag : void 0,
            C = function(e) {
                return null == e ? void 0 === e ? "[object Undefined]" : "[object Null]" : S && S in Object(e) ? b(e) : x(e)
            },
            k = function(t, i) {
                return function(e) {
                    return t(i(e))
                }
            },
            T = k(Object.getPrototypeOf, Object),
            _ = T,
            L = function(e) {
                return null != e && "object" == typeof e
            },
            I = Function.prototype,
            M = Object.prototype,
            O = I.toString,
            D = M.hasOwnProperty,
            P = O.call(Object),
            A = function(e) {
                if (!L(e) || "[object Object]" != C(e)) return !1;
                var t = _(e);
                if (null === t) return !0;
                var i = D.call(t, "constructor") && t.constructor;
                return "function" == typeof i && i instanceof i && O.call(i) == P
            },
            F = i(75),
            z = {
                INIT: "@@redux/INIT"
            },
            N = Object.assign || function(e) {
                for (var t = 1; t < arguments.length; t++) {
                    var i = arguments[t];
                    for (var n in i) Object.prototype.hasOwnProperty.call(i, n) && (e[n] = i[n])
                }
                return e
            };
        i.d(t, "createStore", function() {
            return p
        }), i.d(t, "combineReducers", function() {
            return n
        }), i.d(t, "bindActionCreators", function() {
            return a
        }), i.d(t, "applyMiddleware", function() {
            return r
        }), i.d(t, "compose", function() {
            return c
        })
    }, function(ir, jr) {
        var kr;
        kr = function() {
            return this
        }();
        try {
            kr = kr || Function("return this")() || eval("this")
        } catch (ir) {
            "object" == typeof window && (kr = window)
        }
        ir.exports = kr
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var a = function() {
                function n(e, t) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                    }
                }
                return function(e, t, i) {
                    return t && n(e.prototype, t), i && n(e, i), e
                }
            }(),
            r = i(1),
            n = function() {
                function n(e) {
                    var t = e.element,
                        i = e.classNames;
                    if (function(e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                        }(this, n), Object.assign(this, {
                            element: t,
                            classNames: i
                        }), !(0, r.isElement)(t)) throw new TypeError("Invalid element passed");
                    this.isDisabled = !1
                }
                return a(n, [{
                    key: "conceal",
                    value: function() {
                        this.element.classList.add(this.classNames.input), this.element.classList.add(this.classNames.hiddenState), this.element.tabIndex = "-1";
                        var e = this.element.getAttribute("style");
                        e && this.element.setAttribute("data-choice-orig-style", e), this.element.setAttribute("aria-hidden", "true"), this.element.setAttribute("data-choice", "active")
                    }
                }, {
                    key: "reveal",
                    value: function() {
                        this.element.classList.remove(this.classNames.input), this.element.classList.remove(this.classNames.hiddenState), this.element.removeAttribute("tabindex");
                        var e = this.element.getAttribute("data-choice-orig-style");
                        e ? (this.element.removeAttribute("data-choice-orig-style"), this.element.setAttribute("style", e)) : this.element.removeAttribute("style"), this.element.removeAttribute("aria-hidden"), this.element.removeAttribute("data-choice"), this.element.value = this.element.value
                    }
                }, {
                    key: "enable",
                    value: function() {
                        this.element.removeAttribute("disabled"), this.element.disabled = !1, this.isDisabled = !1
                    }
                }, {
                    key: "disable",
                    value: function() {
                        this.element.setAttribute("disabled", ""), this.element.disabled = !0, this.isDisabled = !0
                    }
                }, {
                    key: "triggerEvent",
                    value: function(e, t) {
                        (0, r.dispatchEvent)(this.element, e, t)
                    }
                }, {
                    key: "value",
                    get: function() {
                        return this.element.value
                    }
                }]), n
            }();
        t.default = n
    }, function(e, t, i) {
        "use strict";

        function l(e, t, i) {
            return t in e ? Object.defineProperty(e, t, {
                value: i,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : e[t] = i, e
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        }), t.TEMPLATES = void 0;
        var n, a = i(89),
            c = (n = a) && n.__esModule ? n : {
                default: n
            },
            d = i(1),
            r = t.TEMPLATES = {
                containerOuter: function(e, t, i, n, a, r) {
                    var s = n ? 'tabindex="0"' : "",
                        o = i ? 'role="listbox"' : "",
                        l = "";
                    return i && a && (o = 'role="combobox"', l = 'aria-autocomplete="list"'), (0, d.strToEl)('\n      <div\n        class="' + e.containerOuter + '"\n        data-type="' + r + '"\n        ' + o + "\n        " + s + "\n        " + l + '\n        aria-haspopup="true"\n        aria-expanded="false"\n        dir="' + t + '"\n        >\n      </div>\n    ')
                },
                containerInner: function(e) {
                    return (0, d.strToEl)('\n      <div class="' + e.containerInner + '"></div>\n    ')
                },
                itemList: function(e, t) {
                    var i, n = (0, c.default)(e.list, (l(i = {}, e.listSingle, t), l(i, e.listItems, !t), i));
                    return (0, d.strToEl)('\n      <div class="' + n + '"></div>\n    ')
                },
                placeholder: function(e, t) {
                    return (0, d.strToEl)('\n      <div class="' + e.placeholder + '">\n        ' + t + "\n      </div>\n    ")
                },
                item: function(e, t, i) {
                    var n, a, r = t.active ? 'aria-selected="true"' : "",
                        s = t.disabled ? 'aria-disabled="true"' : "",
                        o = (0, c.default)(e.item, (l(n = {}, e.highlightedState, t.highlighted), l(n, e.itemSelectable, !t.highlighted), l(n, e.placeholder, t.placeholder), n));
                    return i ? (o = (0, c.default)(e.item, (l(a = {}, e.highlightedState, t.highlighted), l(a, e.itemSelectable, !t.disabled), l(a, e.placeholder, t.placeholder), a)), (0, d.strToEl)('\n        <div\n          class="' + o + '"\n          data-item\n          data-id="' + t.id + '"\n          data-value="' + t.value + '"\n          data-deletable\n          ' + r + "\n          " + s + "\n          >\n          " + t.label + '\x3c!--\n       --\x3e<button\n            type="button"\n            class="' + e.button + '"\n            data-button\n            aria-label="Remove item: \'' + t.value + "'\"\n            >\n            Remove item\n          </button>\n        </div>\n      ")) : (0, d.strToEl)('\n      <div\n        class="' + o + '"\n        data-item\n        data-id="' + t.id + '"\n        data-value="' + t.value + '"\n        ' + r + "\n        " + s + "\n        >\n        " + t.label + "\n      </div>\n    ")
                },
                choiceList: function(e, t) {
                    var i = t ? "" : 'aria-multiselectable="true"';
                    return (0, d.strToEl)('\n      <div\n        class="' + e.list + '"\n        dir="ltr"\n        role="listbox"\n        ' + i + "\n        >\n      </div>\n    ")
                },
                choiceGroup: function(e, t) {
                    var i = t.disabled ? 'aria-disabled="true"' : "",
                        n = (0, c.default)(e.group, l({}, e.itemDisabled, t.disabled));
                    return (0, d.strToEl)('\n      <div\n        class="' + n + '"\n        data-group\n        data-id="' + t.id + '"\n        data-value="' + t.value + '"\n        role="group"\n        ' + i + '\n        >\n        <div class="' + e.groupHeading + '">' + t.value + "</div>\n      </div>\n    ")
                },
                choice: function(e, t, i) {
                    var n, a = 0 < t.groupId ? 'role="treeitem"' : 'role="option"',
                        r = (0, c.default)(e.item, e.itemChoice, (l(n = {}, e.itemDisabled, t.disabled), l(n, e.itemSelectable, !t.disabled), l(n, e.placeholder, t.placeholder), n));
                    return (0, d.strToEl)('\n      <div\n        class="' + r + '"\n        data-select-text="' + i + '"\n        data-choice\n        data-id="' + t.id + '"\n        data-value="' + t.value + '"\n        ' + (t.disabled ? 'data-choice-disabled aria-disabled="true"' : "data-choice-selectable") + '\n        id="' + t.elementId + '"\n        ' + a + "\n        >\n        " + t.label + "\n      </div>\n    ")
                },
                input: function(e) {
                    var t = (0, c.default)(e.input, e.inputCloned);
                    return (0, d.strToEl)('\n      <input\n        type="text"\n        class="' + t + '"\n        autocomplete="off"\n        autocapitalize="off"\n        spellcheck="false"\n        role="textbox"\n        aria-autocomplete="list"\n        >\n    ')
                },
                dropdown: function(e) {
                    var t = (0, c.default)(e.list, e.listDropdown);
                    return (0, d.strToEl)('\n      <div\n        class="' + t + '"\n        aria-expanded="false"\n        >\n      </div>\n    ')
                },
                notice: function(e, t) {
                    var i, n = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "",
                        a = (0, c.default)(e.item, e.itemChoice, (l(i = {}, e.noResults, "no-results" === n), l(i, e.noChoices, "no-choices" === n), i));
                    return (0, d.strToEl)('\n      <div class="' + a + '">\n        ' + t + "\n      </div>\n    ")
                },
                option: function(e) {
                    return (0, d.strToEl)('\n      <option value="' + e.value + '" ' + (e.active ? "selected" : "") + " " + (e.disabled ? "disabled" : "") + ">" + e.label + "</option>\n    ")
                }
            };
        t.default = r
    }, function(e, t, i) {
        e.exports = i(38)
    }, function(e, t, i) {
        "use strict";

        function n(e) {
            return e && e.__esModule ? e : {
                default: e
            }
        }

        function x(e, t, i) {
            return t in e ? Object.defineProperty(e, t, {
                value: i,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : e[t] = i, e
        }

        function g(e) {
            if (Array.isArray(e)) {
                for (var t = 0, i = Array(e.length); t < e.length; t++) i[t] = e[t];
                return i
            }
            return Array.from(e)
        }
        var r = function() {
                function n(e, t) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                    }
                }
                return function(e, t, i) {
                    return t && n(e.prototype, t), i && n(e, i), e
                }
            }(),
            a = i(39),
            c = n(a),
            s = i(40),
            o = n(s);
        i(41);
        var l = i(73),
            d = n(l),
            u = i(82),
            S = i(5),
            h = i(36),
            w = i(90),
            C = i(91),
            p = i(92),
            f = i(93),
            k = i(1),
            v = function() {
                function a() {
                    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "[data-choice]",
                        t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : {};
                    if (function(e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                        }(this, a), (0, k.isType)("String", e)) {
                        var i = Array.from(document.querySelectorAll(e));
                        if (1 < i.length) return this._generateInstances(i, t)
                    }
                    this.config = o.default.all([S.DEFAULT_CONFIG, a.userDefaults, t]), (0, k.doKeysMatch)(this.config, S.DEFAULT_CONFIG) || console.warn("Unknown config option(s) passed"), ["auto", "always"].includes(this.config.renderSelectedChoices) || (this.config.renderSelectedChoices = "auto");
                    var n = (0, k.isType)("String", e) ? document.querySelector(e) : e;
                    return n ? (this._isTextElement = "text" === n.type, this._isSelectOneElement = "select-one" === n.type, this._isSelectMultipleElement = "select-multiple" === n.type, this._isSelectElement = this._isSelectOneElement || this._isSelectMultipleElement, this._isTextElement ? this.passedElement = new u.WrappedInput({
                        element: n,
                        classNames: this.config.classNames,
                        delimiter: this.config.delimiter
                    }) : this._isSelectElement && (this.passedElement = new u.WrappedSelect({
                        element: n,
                        classNames: this.config.classNames
                    })), n ? (!0 === this.config.shouldSortItems && this._isSelectOneElement && !this.config.silent && console.warn("shouldSortElements: Type of passed element is 'select-one', falling back to false."), this.initialised = !1, this._store = new d.default(this.render), this._initialState = {}, this._currentState = {}, this._prevState = {}, this._currentValue = "", this._canSearch = this.config.searchEnabled, this._isScrollingOnIe = !1, this._highlightPosition = 0, this._wasTap = !0, this._placeholderValue = this._generatePlaceholderValue(), this._baseId = (0, k.generateId)(this.passedElement.element, "choices-"), this._direction = this.passedElement.element.getAttribute("dir") || "ltr", this._idNames = {
                        itemChoice: "item-choice"
                    }, this._presetChoices = this.config.choices, this._presetItems = this.config.items, this.passedElement.value && (this._presetItems = this._presetItems.concat(this.passedElement.value.split(this.config.delimiter))), this._render = this._render.bind(this), this._onFocus = this._onFocus.bind(this), this._onBlur = this._onBlur.bind(this), this._onKeyUp = this._onKeyUp.bind(this), this._onKeyDown = this._onKeyDown.bind(this), this._onClick = this._onClick.bind(this), this._onTouchMove = this._onTouchMove.bind(this), this._onTouchEnd = this._onTouchEnd.bind(this), this._onMouseDown = this._onMouseDown.bind(this), this._onMouseOver = this._onMouseOver.bind(this), this._onFormReset = this._onFormReset.bind(this), this._onAKey = this._onAKey.bind(this), this._onEnterKey = this._onEnterKey.bind(this), this._onEscapeKey = this._onEscapeKey.bind(this), this._onDirectionKey = this._onDirectionKey.bind(this), this._onDeleteKey = this._onDeleteKey.bind(this), "active" === this.passedElement.element.getAttribute("data-choice") && console.warn("Trying to initialise Choices on element already initialised"), void this.init()) : console.error("Passed element was of an invalid type")) : console.error("Could not find passed element or passed element was of an invalid type")
                }
                return r(a, [{
                    key: "init",
                    value: function() {
                        if (!this.initialised) {
                            this._createTemplates(), this._createElements(), this._createStructure(), this._initialState = (0, k.cloneObject)(this._store.state), this._store.subscribe(this._render), this._render(), this._addEventListeners(), (!this.config.addItems || this.passedElement.element.hasAttribute("disabled")) && this.disable(), this.initialised = !0;
                            var e = this.config.callbackOnInit;
                            e && (0, k.isType)("Function", e) && e.call(this)
                        }
                    }
                }, {
                    key: "destroy",
                    value: function() {
                        this.initialised && (this._removeEventListeners(), this.passedElement.reveal(), this.containerOuter.unwrap(this.passedElement.element), this._isSelectElement && (this.passedElement.options = this._presetChoices), this.clearStore(), this.config.templates = null, this.initialised = !1)
                    }
                }, {
                    key: "enable",
                    value: function() {
                        return this.passedElement.isDisabled && this.passedElement.enable(), this.containerOuter.isDisabled && (this._addEventListeners(), this.input.enable(), this.containerOuter.enable()), this
                    }
                }, {
                    key: "disable",
                    value: function() {
                        return this.passedElement.isDisabled || this.passedElement.disable(), this.containerOuter.isDisabled || (this._removeEventListeners(), this.input.disable(), this.containerOuter.disable()), this
                    }
                }, {
                    key: "highlightItem",
                    value: function(e) {
                        var t = !(1 < arguments.length && void 0 !== arguments[1]) || arguments[1];
                        if (!e) return this;
                        var i = e.id,
                            n = e.groupId,
                            a = void 0 === n ? -1 : n,
                            r = e.value,
                            s = void 0 === r ? "" : r,
                            o = e.label,
                            l = void 0 === o ? "" : o,
                            c = 0 <= a ? this._store.getGroupById(a) : null;
                        return this._store.dispatch((0, C.highlightItem)(i, !0)), t && this.passedElement.triggerEvent(S.EVENTS.highlightItem, {
                            id: i,
                            value: s,
                            label: l,
                            groupValue: c && c.value ? c.value : null
                        }), this
                    }
                }, {
                    key: "unhighlightItem",
                    value: function(e) {
                        if (!e) return this;
                        var t = e.id,
                            i = e.groupId,
                            n = void 0 === i ? -1 : i,
                            a = e.value,
                            r = void 0 === a ? "" : a,
                            s = e.label,
                            o = void 0 === s ? "" : s,
                            l = 0 <= n ? this._store.getGroupById(n) : null;
                        return this._store.dispatch((0, C.highlightItem)(t, !1)), this.passedElement.triggerEvent(S.EVENTS.highlightItem, {
                            id: t,
                            value: r,
                            label: o,
                            groupValue: l && l.value ? l.value : null
                        }), this
                    }
                }, {
                    key: "highlightAll",
                    value: function() {
                        var t = this;
                        return this._store.items.forEach(function(e) {
                            return t.highlightItem(e)
                        }), this
                    }
                }, {
                    key: "unhighlightAll",
                    value: function() {
                        var t = this;
                        return this._store.items.forEach(function(e) {
                            return t.unhighlightItem(e)
                        }), this
                    }
                }, {
                    key: "removeActiveItemsByValue",
                    value: function(t) {
                        var i = this;
                        return this._store.activeItems.filter(function(e) {
                            return e.value === t
                        }).forEach(function(e) {
                            return i._removeItem(e)
                        }), this
                    }
                }, {
                    key: "removeActiveItems",
                    value: function(t) {
                        var i = this;
                        return this._store.activeItems.filter(function(e) {
                            return e.id !== t
                        }).forEach(function(e) {
                            return i._removeItem(e)
                        }), this
                    }
                }, {
                    key: "removeHighlightedItems",
                    value: function() {
                        var t = this,
                            i = 0 < arguments.length && void 0 !== arguments[0] && arguments[0];
                        return this._store.highlightedActiveItems.forEach(function(e) {
                            t._removeItem(e), i && t._triggerChange(e.value)
                        }), this
                    }
                }, {
                    key: "showDropdown",
                    value: function(e) {
                        var t = this;
                        return this.dropdown.isActive || requestAnimationFrame(function() {
                            t.dropdown.show(), t.containerOuter.open(t.dropdown.distanceFromTopWindow()), !e && t._canSearch && t.input.focus(), t.passedElement.triggerEvent(S.EVENTS.showDropdown, {})
                        }), this
                    }
                }, {
                    key: "hideDropdown",
                    value: function(e) {
                        var t = this;
                        return this.dropdown.isActive && requestAnimationFrame(function() {
                            t.dropdown.hide(), t.containerOuter.close(), !e && t._canSearch && (t.input.removeActiveDescendant(), t.input.blur()), t.passedElement.triggerEvent(S.EVENTS.hideDropdown, {})
                        }), this
                    }
                }, {
                    key: "toggleDropdown",
                    value: function() {
                        return this.dropdown.isActive ? this.hideDropdown() : this.showDropdown(), this
                    }
                }, {
                    key: "getValue",
                    value: function() {
                        var n = 0 < arguments.length && void 0 !== arguments[0] && arguments[0],
                            e = this._store.activeItems.reduce(function(e, t) {
                                var i = n ? t.value : t;
                                return e.push(i), e
                            }, []);
                        return this._isSelectOneElement ? e[0] : e
                    }
                }, {
                    key: "setValue",
                    value: function(e) {
                        var t = this;
                        return this.initialised && [].concat(g(e)).forEach(function(e) {
                            return t._setChoiceOrItem(e)
                        }), this
                    }
                }, {
                    key: "setChoiceByValue",
                    value: function(e) {
                        var t = this;
                        return !this.initialised || this._isTextElement || ((0, k.isType)("Array", e) ? e : [e]).forEach(function(e) {
                            return t._findAndSelectChoiceByValue(e)
                        }), this
                    }
                }, {
                    key: "setChoices",
                    value: function() {
                        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : [],
                            t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "",
                            i = this,
                            n = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "",
                            a = 3 < arguments.length && void 0 !== arguments[3] && arguments[3];
                        return this._isSelectElement && e.length && t && (a && this._clearChoices(), this.containerOuter.removeLoadingState(), e.forEach(function(e) {
                            e.choices ? i._addGroup({
                                group: e,
                                id: e.id || null,
                                valueKey: t,
                                labelKey: n
                            }) : i._addChoice({
                                value: e[t],
                                label: e[n],
                                isSelected: e.selected,
                                isDisabled: e.disabled,
                                customProperties: e.customProperties,
                                placeholder: e.placeholder
                            })
                        })), this
                    }
                }, {
                    key: "clearStore",
                    value: function() {
                        return this._store.dispatch((0, f.clearAll)()), this
                    }
                }, {
                    key: "clearInput",
                    value: function() {
                        var e = !this._isSelectOneElement;
                        return this.input.clear(e), !this._isTextElement && this._canSearch && (this._isSearching = !1, this._store.dispatch((0, w.activateChoices)(!0))), this
                    }
                }, {
                    key: "ajax",
                    value: function(e) {
                        var t = this;
                        return this.initialised && this._isSelectElement && e && (requestAnimationFrame(function() {
                            return t._handleLoadingState(!0)
                        }), e(this._ajaxCallback())), this
                    }
                }, {
                    key: "_render",
                    value: function() {
                        this._currentState = this._store.state;
                        var e = this._currentState.choices !== this._prevState.choices || this._currentState.groups !== this._prevState.groups || this._currentState.items !== this._prevState.items,
                            t = this._isSelectElement,
                            i = this._currentState.items !== this._prevState.items;
                        e && (t && this._renderChoices(), i && this._renderItems(), this._prevState = this._currentState)
                    }
                }, {
                    key: "_renderChoices",
                    value: function() {
                        var e = this,
                            t = this._store,
                            i = t.activeGroups,
                            n = t.activeChoices,
                            a = document.createDocumentFragment();
                        if (this.choiceList.clear(), this.config.resetScrollPosition && requestAnimationFrame(function() {
                                return e.choiceList.scrollToTop()
                            }), 1 <= i.length && !this._isSearching) {
                            var r = n.filter(function(e) {
                                return !0 === e.placeholder && -1 === e.groupId
                            });
                            1 <= r.length && (a = this._createChoicesFragment(r, a)), a = this._createGroupsFragment(i, n, a)
                        } else 1 <= n.length && (a = this._createChoicesFragment(n, a));
                        if (a.childNodes && 0 < a.childNodes.length) {
                            var s = this._store.activeItems,
                                o = this._canAddItem(s, this.input.value);
                            o.response ? (this.choiceList.append(a), this._highlightChoice()) : this.choiceList.append(this._getTemplate("notice", o.notice))
                        } else {
                            var l = void 0,
                                c = void 0;
                            l = this._isSearching ? (c = (0, k.isType)("Function", this.config.noResultsText) ? this.config.noResultsText() : this.config.noResultsText, this._getTemplate("notice", c, "no-results")) : (c = (0, k.isType)("Function", this.config.noChoicesText) ? this.config.noChoicesText() : this.config.noChoicesText, this._getTemplate("notice", c, "no-choices")), this.choiceList.append(l)
                        }
                    }
                }, {
                    key: "_renderItems",
                    value: function() {
                        var e = this._store.activeItems || [];
                        this.itemList.clear();
                        var t = this._createItemsFragment(e);
                        t.childNodes && this.itemList.append(t)
                    }
                }, {
                    key: "_createGroupsFragment",
                    value: function(e, a, t) {
                        var r = this,
                            s = t || document.createDocumentFragment();
                        return this.config.shouldSort && e.sort(this.config.sortFn), e.forEach(function(e) {
                            var t, i = (t = e, a.filter(function(e) {
                                return r._isSelectOneElement ? e.groupId === t.id : e.groupId === t.id && ("always" === r.config.renderSelectedChoices || !e.selected)
                            }));
                            if (1 <= i.length) {
                                var n = r._getTemplate("choiceGroup", e);
                                s.appendChild(n), r._createChoicesFragment(i, s, !0)
                            }
                        }), s
                    }
                }, {
                    key: "_createChoicesFragment",
                    value: function(e, t) {
                        var i = this,
                            n = 2 < arguments.length && void 0 !== arguments[2] && arguments[2],
                            a = t || document.createDocumentFragment(),
                            r = this.config,
                            s = r.renderSelectedChoices,
                            o = r.searchResultLimit,
                            l = r.renderChoiceLimit,
                            c = this._isSearching ? k.sortByScore : this.config.sortFn,
                            d = e;
                        "auto" !== s || this._isSelectOneElement || (d = e.filter(function(e) {
                            return !e.selected
                        }));
                        var u = d.reduce(function(e, t) {
                                return t.placeholder ? e.placeholderChoices.push(t) : e.normalChoices.push(t), e
                            }, {
                                placeholderChoices: [],
                                normalChoices: []
                            }),
                            h = u.placeholderChoices,
                            p = u.normalChoices;
                        (this.config.shouldSort || this._isSearching) && p.sort(c);
                        var f = d.length,
                            v = [].concat(g(h), g(p));
                        this._isSearching ? f = o : 0 < l && !n && (f = l);
                        for (var m = 0; m < f; m += 1) v[m] && function(e) {
                            if ("auto" !== s || i._isSelectOneElement || !e.selected) {
                                var t = i._getTemplate("choice", e, i.config.itemSelectText);
                                a.appendChild(t)
                            }
                        }(v[m]);
                        return a
                    }
                }, {
                    key: "_createItemsFragment",
                    value: function(e) {
                        var n = this,
                            t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : null,
                            i = this.config,
                            a = i.shouldSortItems,
                            r = i.sortFn,
                            s = i.removeItemButton,
                            o = t || document.createDocumentFragment();
                        return a && !this._isSelectOneElement && e.sort(r), this._isTextElement ? this.passedElement.value = e : this.passedElement.options = e, e.forEach(function(e) {
                            return t = e, i = n._getTemplate("item", t, s), void o.appendChild(i);
                            var t, i
                        }), o
                    }
                }, {
                    key: "_triggerChange",
                    value: function(e) {
                        null != e && this.passedElement.triggerEvent(S.EVENTS.change, {
                            value: e
                        })
                    }
                }, {
                    key: "_selectPlaceholderChoice",
                    value: function() {
                        var e = this._store.placeholderChoice;
                        e && (this._addItem({
                            value: e.value,
                            label: e.label,
                            choiceId: e.id,
                            groupId: e.groupId,
                            placeholder: e.placeholder
                        }), this._triggerChange(e.value))
                    }
                }, {
                    key: "_handleButtonAction",
                    value: function(e, t) {
                        if (e && t && this.config.removeItems && this.config.removeItemButton) {
                            var i = t.parentNode.getAttribute("data-id"),
                                n = e.find(function(e) {
                                    return e.id === parseInt(i, 10)
                                });
                            this._removeItem(n), this._triggerChange(n.value), this._isSelectOneElement && this._selectPlaceholderChoice()
                        }
                    }
                }, {
                    key: "_handleItemAction",
                    value: function(e, t) {
                        var i = this,
                            n = 2 < arguments.length && void 0 !== arguments[2] && arguments[2];
                        if (e && t && this.config.removeItems && !this._isSelectOneElement) {
                            var a = t.getAttribute("data-id");
                            e.forEach(function(e) {
                                e.id !== parseInt(a, 10) || e.highlighted ? !n && e.highlighted && i.unhighlightItem(e) : i.highlightItem(e)
                            }), this.input.focus()
                        }
                    }
                }, {
                    key: "_handleChoiceAction",
                    value: function(e, t) {
                        if (e && t) {
                            var i = t.getAttribute("data-id"),
                                n = this._store.getChoiceById(i),
                                a = e[0] && e[0].keyCode ? e[0].keyCode : null,
                                r = this.dropdown.isActive;
                            n.keyCode = a, this.passedElement.triggerEvent(S.EVENTS.choice, {
                                choice: n
                            }), !n || n.selected || n.disabled || this._canAddItem(e, n.value).response && (this._addItem({
                                value: n.value,
                                label: n.label,
                                choiceId: n.id,
                                groupId: n.groupId,
                                customProperties: n.customProperties,
                                placeholder: n.placeholder,
                                keyCode: n.keyCode
                            }), this._triggerChange(n.value)), this.clearInput(), r && this._isSelectOneElement && (this.hideDropdown(!0), this.containerOuter.focus())
                        }
                    }
                }, {
                    key: "_handleBackspace",
                    value: function(e) {
                        if (this.config.removeItems && e) {
                            var t = e[e.length - 1],
                                i = e.some(function(e) {
                                    return e.highlighted
                                });
                            this.config.editItems && !i && t ? (this.input.value = t.value, this.input.setWidth(), this._removeItem(t), this._triggerChange(t.value)) : (i || this.highlightItem(t, !1), this.removeHighlightedItems(!0))
                        }
                    }
                }, {
                    key: "_handleLoadingState",
                    value: function() {
                        var e = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0],
                            t = this.itemList.getChild("." + this.config.classNames.placeholder);
                        e ? (this.disable(), this.containerOuter.addLoadingState(), this._isSelectOneElement ? t ? t.innerHTML = this.config.loadingText : (t = this._getTemplate("placeholder", this.config.loadingText), this.itemList.append(t)) : this.input.placeholder = this.config.loadingText) : (this.enable(), this.containerOuter.removeLoadingState(), this._isSelectOneElement ? t.innerHTML = this._placeholderValue || "" : this.input.placeholder = this._placeholderValue || "")
                    }
                }, {
                    key: "_handleSearch",
                    value: function(e) {
                        if (e && this.input.isFocussed) {
                            var t = this._store.choices,
                                i = this.config,
                                n = i.searchFloor,
                                a = i.searchChoices,
                                r = t.some(function(e) {
                                    return !e.active
                                });
                            if (e && e.length >= n) {
                                var s = a ? this._searchChoices(e) : 0;
                                this.passedElement.triggerEvent(S.EVENTS.search, {
                                    value: e,
                                    resultCount: s
                                })
                            } else r && (this._isSearching = !1, this._store.dispatch((0, w.activateChoices)(!0)))
                        }
                    }
                }, {
                    key: "_canAddItem",
                    value: function(e, t) {
                        var i = !0,
                            n = (0, k.isType)("Function", this.config.addItemText) ? this.config.addItemText(t) : this.config.addItemText;
                        if (!this._isSelectOneElement) {
                            var a = (0, k.existsInArray)(e, t);
                            0 < this.config.maxItemCount && this.config.maxItemCount <= e.length && (i = !1, n = (0, k.isType)("Function", this.config.maxItemText) ? this.config.maxItemText(this.config.maxItemCount) : this.config.maxItemText), this.config.regexFilter && this._isTextElement && this.config.addItems && i && (i = (0, k.regexFilter)(t, this.config.regexFilter)), !this.config.duplicateItemsAllowed && a && i && (i = !1, n = (0, k.isType)("Function", this.config.uniqueItemText) ? this.config.uniqueItemText(t) : this.config.uniqueItemText)
                        }
                        return {
                            response: i,
                            notice: n
                        }
                    }
                }, {
                    key: "_ajaxCallback",
                    value: function() {
                        var a = this;
                        return function(e, t, i) {
                            if (e && t) {
                                var n = (0, k.isType)("Object", e) ? [e] : e;
                                n && (0, k.isType)("Array", n) && n.length ? (a._handleLoadingState(!1), n.forEach(function(e) {
                                    e.choices ? a._addGroup({
                                        group: e,
                                        id: e.id || null,
                                        valueKey: t,
                                        labelKey: i
                                    }) : a._addChoice({
                                        value: (0, k.fetchFromObject)(e, t),
                                        label: (0, k.fetchFromObject)(e, i),
                                        isSelected: e.selected,
                                        isDisabled: e.disabled,
                                        customProperties: e.customProperties,
                                        placeholder: e.placeholder
                                    })
                                }), a._isSelectOneElement && a._selectPlaceholderChoice()) : a._handleLoadingState(!1)
                            }
                        }
                    }
                }, {
                    key: "_searchChoices",
                    value: function(e) {
                        var t = (0, k.isType)("String", e) ? e.trim() : e,
                            i = (0, k.isType)("String", this._currentValue) ? this._currentValue.trim() : this._currentValue;
                        if (t.length < 1 && t === i + " ") return 0;
                        var n = this._store.searchableChoices,
                            a = t,
                            r = [].concat(g(this.config.searchFields)),
                            s = Object.assign(this.config.fuseOptions, {
                                keys: r
                            }),
                            o = new c.default(n, s),
                            l = o.search(a);
                        return this._currentValue = t, this._highlightPosition = 0, this._isSearching = !0, this._store.dispatch((0, w.filterChoices)(l)), l.length
                    }
                }, {
                    key: "_addEventListeners",
                    value: function() {
                        document.addEventListener("keyup", this._onKeyUp), document.addEventListener("keydown", this._onKeyDown), document.addEventListener("click", this._onClick), document.addEventListener("touchmove", this._onTouchMove), document.addEventListener("touchend", this._onTouchEnd), document.addEventListener("mousedown", this._onMouseDown), document.addEventListener("mouseover", this._onMouseOver), this._isSelectOneElement && (this.containerOuter.element.addEventListener("focus", this._onFocus), this.containerOuter.element.addEventListener("blur", this._onBlur)), this.input.element.addEventListener("focus", this._onFocus), this.input.element.addEventListener("blur", this._onBlur), this.input.element.form && this.input.element.form.addEventListener("reset", this._onFormReset), this.input.addEventListeners()
                    }
                }, {
                    key: "_removeEventListeners",
                    value: function() {
                        document.removeEventListener("keyup", this._onKeyUp), document.removeEventListener("keydown", this._onKeyDown), document.removeEventListener("click", this._onClick), document.removeEventListener("touchmove", this._onTouchMove), document.removeEventListener("touchend", this._onTouchEnd), document.removeEventListener("mousedown", this._onMouseDown), document.removeEventListener("mouseover", this._onMouseOver), this._isSelectOneElement && (this.containerOuter.element.removeEventListener("focus", this._onFocus), this.containerOuter.element.removeEventListener("blur", this._onBlur)), this.input.element.removeEventListener("focus", this._onFocus), this.input.element.removeEventListener("blur", this._onBlur), this.input.element.form && this.input.element.form.removeEventListener("reset", this._onFormReset), this.input.removeEventListeners()
                    }
                }, {
                    key: "_onKeyDown",
                    value: function(e) {
                        var t, i = e.target,
                            n = e.keyCode,
                            a = e.ctrlKey,
                            r = e.metaKey;
                        if (i === this.input.element || this.containerOuter.element.contains(i)) {
                            var s = this._store.activeItems,
                                o = this.input.isFocussed,
                                l = this.dropdown.isActive,
                                c = this.itemList.hasChildren,
                                d = String.fromCharCode(n),
                                u = S.KEY_CODES.BACK_KEY,
                                h = S.KEY_CODES.DELETE_KEY,
                                p = S.KEY_CODES.ENTER_KEY,
                                f = S.KEY_CODES.A_KEY,
                                v = S.KEY_CODES.ESC_KEY,
                                m = S.KEY_CODES.UP_KEY,
                                g = S.KEY_CODES.DOWN_KEY,
                                y = S.KEY_CODES.PAGE_UP_KEY,
                                b = S.KEY_CODES.PAGE_DOWN_KEY,
                                w = a || r;
                            !this._isTextElement && /[a-zA-Z0-9-_ ]/.test(d) && this.showDropdown();
                            var E = (x(t = {}, f, this._onAKey), x(t, p, this._onEnterKey), x(t, v, this._onEscapeKey), x(t, m, this._onDirectionKey), x(t, y, this._onDirectionKey), x(t, g, this._onDirectionKey), x(t, b, this._onDirectionKey), x(t, h, this._onDeleteKey), x(t, u, this._onDeleteKey), t);
                            E[n] && E[n]({
                                target: i,
                                keyCode: n,
                                metaKey: r,
                                activeItems: s,
                                hasFocusedInput: o,
                                hasActiveDropdown: l,
                                hasItems: c,
                                hasCtrlDownKeyPressed: w
                            })
                        }
                    }
                }, {
                    key: "_onKeyUp",
                    value: function(e) {
                        var t = e.target,
                            i = e.keyCode;
                        if (t === this.input.element) {
                            var n = this.input.value,
                                a = this._store.activeItems,
                                r = this._canAddItem(a, n);
                            if (this._isTextElement)
                                if (n) {
                                    if (r.notice) {
                                        var s = this._getTemplate("notice", r.notice);
                                        this.dropdown.element.innerHTML = s.outerHTML
                                    }!0 === r.response ? this.showDropdown(!0) : r.notice || this.hideDropdown(!0)
                                } else this.hideDropdown(!0);
                            else {
                                var o = S.KEY_CODES.BACK_KEY,
                                    l = S.KEY_CODES.DELETE_KEY;
                                i !== o && i !== l || t.value ? this._canSearch && r.response && this._handleSearch(this.input.value) : !this._isTextElement && this._isSearching && (this._isSearching = !1, this._store.dispatch((0, w.activateChoices)(!0)))
                            }
                            this._canSearch = this.config.searchEnabled
                        }
                    }
                }, {
                    key: "_onAKey",
                    value: function(e) {
                        var t = e.hasItems;
                        e.hasCtrlDownKeyPressed && t && (this._canSearch = !1, this.config.removeItems && !this.input.value && this.input.element === document.activeElement && this.highlightAll())
                    }
                }, {
                    key: "_onEnterKey",
                    value: function(e) {
                        var t = e.target,
                            i = e.activeItems,
                            n = e.hasActiveDropdown,
                            a = S.KEY_CODES.ENTER_KEY;
                        if (this._isTextElement && t.value) {
                            var r = this.input.value;
                            this._canAddItem(i, r).response && (this.hideDropdown(!0), this._addItem({
                                value: r
                            }), this._triggerChange(r), this.clearInput())
                        }
                        if (t.hasAttribute("data-button") && (this._handleButtonAction(i, t), event.preventDefault()), n) {
                            var s = this.dropdown.getChild("." + this.config.classNames.highlightedState);
                            s && (i[0] && (i[0].keyCode = a), this._handleChoiceAction(i, s)), event.preventDefault()
                        } else this._isSelectOneElement && (this.showDropdown(), event.preventDefault())
                    }
                }, {
                    key: "_onEscapeKey",
                    value: function(e) {
                        e.hasActiveDropdown && (this.hideDropdown(!0), this.containerOuter.focus())
                    }
                }, {
                    key: "_onDirectionKey",
                    value: function(e) {
                        var t = e.hasActiveDropdown,
                            i = e.keyCode,
                            n = e.metaKey,
                            a = S.KEY_CODES.DOWN_KEY,
                            r = S.KEY_CODES.PAGE_UP_KEY,
                            s = S.KEY_CODES.PAGE_DOWN_KEY;
                        if (t || this._isSelectOneElement) {
                            this.showDropdown(), this._canSearch = !1;
                            var o = i === a || i === s ? 1 : -1,
                                l = n || i === s || i === r,
                                c = void 0;
                            if (l) c = 0 < o ? Array.from(this.dropdown.element.querySelectorAll("[data-choice-selectable]")).pop() : this.dropdown.element.querySelector("[data-choice-selectable]");
                            else {
                                var d = this.dropdown.element.querySelector("." + this.config.classNames.highlightedState);
                                c = d ? (0, k.getAdjacentEl)(d, "[data-choice-selectable]", o) : this.dropdown.element.querySelector("[data-choice-selectable]")
                            }
                            c && ((0, k.isScrolledIntoView)(c, this.choiceList.element, o) || this.choiceList.scrollToChoice(c, o), this._highlightChoice(c)), event.preventDefault()
                        }
                    }
                }, {
                    key: "_onDeleteKey",
                    value: function(e) {
                        var t = e.target,
                            i = e.hasFocusedInput,
                            n = e.activeItems;
                        !i || t.value || this._isSelectOneElement || (this._handleBackspace(n), event.preventDefault())
                    }
                }, {
                    key: "_onTouchMove",
                    value: function() {
                        !0 === this._wasTap && (this._wasTap = !1)
                    }
                }, {
                    key: "_onTouchEnd",
                    value: function(e) {
                        var t = e.target || e.touches[0].target;
                        !0 === this._wasTap && this.containerOuter.element.contains(t) && ((t === this.containerOuter.element || t === this.containerInner.element) && !this._isSelectOneElement && (this._isTextElement ? this.input.focus() : this.showDropdown()), e.stopPropagation()), this._wasTap = !0
                    }
                }, {
                    key: "_onMouseDown",
                    value: function(e) {
                        var t = e.target,
                            i = e.shiftKey;
                        if (t === this.choiceList && (0, k.isIE11)() && (this._isScrollingOnIe = !0), this.containerOuter.element.contains(t) && t !== this.input.element) {
                            var n = this._store.activeItems,
                                a = i,
                                r = (0, k.findAncestorByAttrName)(t, "data-button"),
                                s = (0, k.findAncestorByAttrName)(t, "data-item"),
                                o = (0, k.findAncestorByAttrName)(t, "data-choice");
                            r ? this._handleButtonAction(n, r) : s ? this._handleItemAction(n, s, a) : o && this._handleChoiceAction(n, o), e.preventDefault()
                        }
                    }
                }, {
                    key: "_onMouseOver",
                    value: function(e) {
                        var t = e.target;
                        (t === this.dropdown || this.dropdown.element.contains(t)) && t.hasAttribute("data-choice") && this._highlightChoice(t)
                    }
                }, {
                    key: "_onClick",
                    value: function(e) {
                        var t = e.target;
                        this.containerOuter.element.contains(t) ? this.dropdown.isActive || this.containerOuter.isDisabled ? this._isSelectOneElement && t !== this.input.element && !this.dropdown.element.contains(t) && this.hideDropdown() : this._isTextElement ? document.activeElement !== this.input.element && this.input.focus() : (this.showDropdown(), this.containerOuter.focus()) : (this._store.highlightedActiveItems && this.unhighlightAll(), this.containerOuter.removeFocusState(), this.hideDropdown(!0))
                    }
                }, {
                    key: "_onFocus",
                    value: function(e) {
                        var t = this,
                            i = e.target;
                        this.containerOuter.element.contains(i) && {
                            text: function() {
                                i === t.input.element && t.containerOuter.addFocusState()
                            },
                            "select-one": function() {
                                t.containerOuter.addFocusState(), i === t.input.element && t.showDropdown(!0)
                            },
                            "select-multiple": function() {
                                i === t.input.element && (t.showDropdown(!0), t.containerOuter.addFocusState())
                            }
                        } [this.passedElement.element.type]()
                    }
                }, {
                    key: "_onBlur",
                    value: function(e) {
                        var t = this,
                            i = e.target;
                        if (this.containerOuter.element.contains(i) && !this._isScrollingOnIe) {
                            var n = this._store.activeItems,
                                a = n.some(function(e) {
                                    return e.highlighted
                                });
                            ({
                                text: function() {
                                    i === t.input.element && (t.containerOuter.removeFocusState(), a && t.unhighlightAll(), t.hideDropdown(!0))
                                },
                                "select-one": function() {
                                    t.containerOuter.removeFocusState(), (i === t.input.element || i === t.containerOuter.element && !t._canSearch) && t.hideDropdown(!0)
                                },
                                "select-multiple": function() {
                                    i === t.input.element && (t.containerOuter.removeFocusState(), t.hideDropdown(!0), a && t.unhighlightAll())
                                }
                            })[this.passedElement.element.type]()
                        } else this._isScrollingOnIe = !1, this.input.element.focus()
                    }
                }, {
                    key: "_onFormReset",
                    value: function() {
                        this._store.dispatch((0, f.resetTo)(this._initialState))
                    }
                }, {
                    key: "_highlightChoice",
                    value: function() {
                        var t = this,
                            e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : null,
                            i = Array.from(this.dropdown.element.querySelectorAll("[data-choice-selectable]"));
                        if (i.length) {
                            var n = e;
                            Array.from(this.dropdown.element.querySelectorAll("." + this.config.classNames.highlightedState)).forEach(function(e) {
                                e.classList.remove(t.config.classNames.highlightedState), e.setAttribute("aria-selected", "false")
                            }), n ? this._highlightPosition = i.indexOf(n) : (n = i.length > this._highlightPosition ? i[this._highlightPosition] : i[i.length - 1]) || (n = i[0]), n.classList.add(this.config.classNames.highlightedState), n.setAttribute("aria-selected", "true"), this.passedElement.triggerEvent(S.EVENTS.highlightChoice, {
                                el: n
                            }), this.dropdown.isActive && (this.input.setActiveDescendant(n.id), this.containerOuter.setActiveDescendant(n.id))
                        }
                    }
                }, {
                    key: "_addItem",
                    value: function(e) {
                        var t = e.value,
                            i = e.label,
                            n = void 0 === i ? null : i,
                            a = e.choiceId,
                            r = void 0 === a ? -1 : a,
                            s = e.groupId,
                            o = void 0 === s ? -1 : s,
                            l = e.customProperties,
                            c = void 0 === l ? null : l,
                            d = e.placeholder,
                            u = void 0 !== d && d,
                            h = e.keyCode,
                            p = void 0 === h ? null : h,
                            f = (0, k.isType)("String", t) ? t.trim() : t,
                            v = p,
                            m = c,
                            g = this._store.items,
                            y = n || f,
                            b = parseInt(r, 10) || -1,
                            w = 0 <= o ? this._store.getGroupById(o) : null,
                            E = g ? g.length + 1 : 1;
                        return this.config.prependValue && (f = this.config.prependValue + f.toString()), this.config.appendValue && (f += this.config.appendValue.toString()), this._store.dispatch((0, C.addItem)({
                            value: f,
                            label: y,
                            id: E,
                            choiceId: b,
                            groupId: o,
                            customProperties: c,
                            placeholder: u,
                            keyCode: v
                        })), this._isSelectOneElement && this.removeActiveItems(E), w && w.value ? this.passedElement.triggerEvent(S.EVENTS.addItem, {
                            id: E,
                            value: f,
                            label: y,
                            customProperties: m,
                            groupValue: w.value,
                            keyCode: v
                        }) : this.passedElement.triggerEvent(S.EVENTS.addItem, {
                            id: E,
                            value: f,
                            label: y,
                            customProperties: m,
                            keyCode: v
                        }), this
                    }
                }, {
                    key: "_removeItem",
                    value: function(e) {
                        if (!e || !(0, k.isType)("Object", e)) return this;
                        var t = e.id,
                            i = e.value,
                            n = e.label,
                            a = e.choiceId,
                            r = e.groupId,
                            s = 0 <= r ? this._store.getGroupById(r) : null;
                        return this._store.dispatch((0, C.removeItem)(t, a)), s && s.value ? this.passedElement.triggerEvent(S.EVENTS.removeItem, {
                            id: t,
                            value: i,
                            label: n,
                            groupValue: s.value
                        }) : this.passedElement.triggerEvent(S.EVENTS.removeItem, {
                            id: t,
                            value: i,
                            label: n
                        }), this
                    }
                }, {
                    key: "_addChoice",
                    value: function(e) {
                        var t = e.value,
                            i = e.label,
                            n = void 0 === i ? null : i,
                            a = e.isSelected,
                            r = void 0 !== a && a,
                            s = e.isDisabled,
                            o = void 0 !== s && s,
                            l = e.groupId,
                            c = void 0 === l ? -1 : l,
                            d = e.customProperties,
                            u = void 0 === d ? null : d,
                            h = e.placeholder,
                            p = void 0 !== h && h,
                            f = e.keyCode,
                            v = void 0 === f ? null : f;
                        if (null != t) {
                            var m = this._store.choices,
                                g = n || t,
                                y = m ? m.length + 1 : 1,
                                b = this._baseId + "-" + this._idNames.itemChoice + "-" + y;
                            this._store.dispatch((0, w.addChoice)({
                                value: t,
                                label: g,
                                id: y,
                                groupId: c,
                                disabled: o,
                                elementId: b,
                                customProperties: u,
                                placeholder: p,
                                keyCode: v
                            })), r && this._addItem({
                                value: t,
                                label: g,
                                choiceId: y,
                                customProperties: u,
                                placeholder: p,
                                keyCode: v
                            })
                        }
                    }
                }, {
                    key: "_clearChoices",
                    value: function() {
                        this._store.dispatch((0, w.clearChoices)())
                    }
                }, {
                    key: "_addGroup",
                    value: function(e) {
                        var i = this,
                            t = e.group,
                            n = e.id,
                            a = e.valueKey,
                            r = void 0 === a ? "value" : a,
                            s = e.labelKey,
                            o = void 0 === s ? "label" : s,
                            l = (0, k.isType)("Object", t) ? t.choices : Array.from(t.getElementsByTagName("OPTION")),
                            c = n || Math.floor((new Date).valueOf() * Math.random()),
                            d = !!t.disabled && t.disabled;
                        l ? (this._store.dispatch((0, p.addGroup)(t.label, c, !0, d)), l.forEach(function(e) {
                            var t = e.disabled || e.parentNode && e.parentNode.disabled;
                            i._addChoice({
                                value: e[r],
                                label: (0, k.isType)("Object", e) ? e[o] : e.innerHTML,
                                isSelected: e.selected,
                                isDisabled: t,
                                groupId: c,
                                customProperties: e.customProperties,
                                placeholder: e.placeholder
                            })
                        })) : this._store.dispatch((0, p.addGroup)(t.label, t.id, !1, t.disabled))
                    }
                }, {
                    key: "_getTemplate",
                    value: function(e) {
                        var t;
                        if (!e) return null;
                        for (var i = this.config, n = i.templates, a = i.classNames, r = arguments.length, s = Array(1 < r ? r - 1 : 0), o = 1; o < r; o++) s[o - 1] = arguments[o];
                        return (t = n[e]).call.apply(t, [this, a].concat(s))
                    }
                }, {
                    key: "_createTemplates",
                    value: function() {
                        var e = this.config.callbackOnCreateTemplates,
                            t = {};
                        e && (0, k.isType)("Function", e) && (t = e.call(this, k.strToEl)), this.config.templates = (0, k.extend)(h.TEMPLATES, t)
                    }
                }, {
                    key: "_createElements",
                    value: function() {
                        this.containerOuter = new u.Container({
                            element: this._getTemplate("containerOuter", this._direction, this._isSelectElement, this._isSelectOneElement, this.config.searchEnabled, this.passedElement.element.type),
                            classNames: this.config.classNames,
                            type: this.passedElement.element.type,
                            position: this.config.position
                        }), this.containerInner = new u.Container({
                            element: this._getTemplate("containerInner"),
                            classNames: this.config.classNames,
                            type: this.passedElement.element.type,
                            position: this.config.position
                        }), this.input = new u.Input({
                            element: this._getTemplate("input"),
                            classNames: this.config.classNames,
                            type: this.passedElement.element.type
                        }), this.choiceList = new u.List({
                            element: this._getTemplate("choiceList", this._isSelectOneElement)
                        }), this.itemList = new u.List({
                            element: this._getTemplate("itemList", this._isSelectOneElement)
                        }), this.dropdown = new u.Dropdown({
                            element: this._getTemplate("dropdown"),
                            classNames: this.config.classNames,
                            type: this.passedElement.element.type
                        })
                    }
                }, {
                    key: "_createStructure",
                    value: function() {
                        this.passedElement.conceal(), this.containerInner.wrap(this.passedElement.element), this.containerOuter.wrap(this.containerInner.element), this._isSelectOneElement ? this.input.placeholder = this.config.searchPlaceholderValue || "" : this._placeholderValue && (this.input.placeholder = this._placeholderValue, this.input.setWidth(!0)), this.containerOuter.element.appendChild(this.containerInner.element), this.containerOuter.element.appendChild(this.dropdown.element), this.containerInner.element.appendChild(this.itemList.element), this._isTextElement || this.dropdown.element.appendChild(this.choiceList.element), this._isSelectOneElement ? this.config.searchEnabled && this.dropdown.element.insertBefore(this.input.element, this.dropdown.element.firstChild) : this.containerInner.element.appendChild(this.input.element), this._isSelectElement ? this._addPredefinedChoices() : this._isTextElement && this._addPredefinedItems()
                    }
                }, {
                    key: "_addPredefinedChoices",
                    value: function() {
                        var c = this,
                            e = this.passedElement.optionGroups;
                        if (this._highlightPosition = 0, this._isSearching = !1, e && e.length) {
                            var t = this.passedElement.placeholderOption;
                            t && "SELECT" === t.parentNode.tagName && this._addChoice({
                                value: t.value,
                                label: t.innerHTML,
                                isSelected: t.selected,
                                isDisabled: t.disabled,
                                placeholder: !0
                            }), e.forEach(function(e) {
                                return c._addGroup({
                                    group: e,
                                    id: e.id || null
                                })
                            })
                        } else {
                            var i = this.passedElement.options,
                                n = this.config.sortFn,
                                a = this._presetChoices;
                            i.forEach(function(e) {
                                a.push({
                                    value: e.value,
                                    label: e.innerHTML,
                                    selected: e.selected,
                                    disabled: e.disabled || e.parentNode.disabled,
                                    placeholder: e.hasAttribute("placeholder")
                                })
                            }), this.config.shouldSort && a.sort(n);
                            var d = a.some(function(e) {
                                return e.selected
                            });
                            a.forEach(function(e, t) {
                                return function(e, t) {
                                    var i = e.value,
                                        n = e.label,
                                        a = e.customProperties,
                                        r = e.placeholder;
                                    if (c._isSelectElement)
                                        if (e.choices) c._addGroup({
                                            group: e,
                                            id: e.id || null
                                        });
                                        else {
                                            var s = c._isSelectOneElement && !d && 0 === t,
                                                o = !!s || e.selected,
                                                l = !s && e.disabled;
                                            c._addChoice({
                                                value: i,
                                                label: n,
                                                isSelected: o,
                                                isDisabled: l,
                                                customProperties: a,
                                                placeholder: r
                                            })
                                        }
                                    else c._addChoice({
                                        value: i,
                                        label: n,
                                        isSelected: e.selected,
                                        isDisabled: e.disabled,
                                        customProperties: a,
                                        placeholder: r
                                    })
                                }(e, t)
                            })
                        }
                    }
                }, {
                    key: "_addPredefinedItems",
                    value: function() {
                        var n = this;
                        this._presetItems.forEach(function(e) {
                            return t = e, void("Object" === (i = (0, k.getType)(t)) && t.value ? n._addItem({
                                value: t.value,
                                label: t.label,
                                choiceId: t.id,
                                customProperties: t.customProperties,
                                placeholder: t.placeholder
                            }) : "String" === i && n._addItem({
                                value: t
                            }));
                            var t, i
                        })
                    }
                }, {
                    key: "_setChoiceOrItem",
                    value: function(e) {
                        var t = this,
                            i = (0, k.getType)(e).toLowerCase();
                        ({
                            object: function() {
                                e.value && (t._isTextElement ? t._addItem({
                                    value: e.value,
                                    label: e.label,
                                    choiceId: e.id,
                                    customProperties: e.customProperties,
                                    placeholder: e.placeholder
                                }) : t._addChoice({
                                    value: e.value,
                                    label: e.label,
                                    isSelected: !0,
                                    isDisabled: !1,
                                    customProperties: e.customProperties,
                                    placeholder: e.placeholder
                                }))
                            },
                            string: function() {
                                t._isTextElement ? t._addItem({
                                    value: e
                                }) : t._addChoice({
                                    value: e,
                                    label: e,
                                    isSelected: !0,
                                    isDisabled: !1
                                })
                            }
                        })[i]()
                    }
                }, {
                    key: "_findAndSelectChoiceByValue",
                    value: function(t) {
                        var i = this,
                            e = this._store.choices,
                            n = e.find(function(e) {
                                return i.config.itemComparer(e.value, t)
                            });
                        n && !n.selected && this._addItem({
                            value: n.value,
                            label: n.label,
                            id: n.id,
                            groupId: n.groupId,
                            customProperties: n.customProperties,
                            placeholder: n.placeholder,
                            keyCode: n.keyCode
                        })
                    }
                }, {
                    key: "_generateInstances",
                    value: function(e, i) {
                        return e.reduce(function(e, t) {
                            return e.push(new a(t, i)), e
                        }, [this])
                    }
                }, {
                    key: "_generatePlaceholderValue",
                    value: function() {
                        return !this._isSelectOneElement && !!this.config.placeholder && (this.config.placeholderValue || this.passedElement.element.getAttribute("placeholder"))
                    }
                }]), a
            }();
        v.userDefaults = {}, e.exports = v
    }, function(e, t, i) {
        e.exports = function(i) {
            function n(e) {
                if (a[e]) return a[e].exports;
                var t = a[e] = {
                    i: e,
                    l: !1,
                    exports: {}
                };
                return i[e].call(t.exports, t, t.exports, n), t.l = !0, t.exports
            }
            var a = {};
            return n.m = i, n.c = a, n.i = function(e) {
                return e
            }, n.d = function(e, t, i) {
                n.o(e, t) || Object.defineProperty(e, t, {
                    configurable: !1,
                    enumerable: !0,
                    get: i
                })
            }, n.n = function(e) {
                var t = e && e.__esModule ? function() {
                    return e.default
                } : function() {
                    return e
                };
                return n.d(t, "a", t), t
            }, n.o = function(e, t) {
                return Object.prototype.hasOwnProperty.call(e, t)
            }, n.p = "", n(n.s = 8)
        }([function(e, t, i) {
            "use strict";
            e.exports = function(e) {
                return "[object Array]" === Object.prototype.toString.call(e)
            }
        }, function(e, t, i) {
            "use strict";
            var n = function() {
                    function n(e, t) {
                        for (var i = 0; i < t.length; i++) {
                            var n = t[i];
                            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                        }
                    }
                    return function(e, t, i) {
                        return t && n(e.prototype, t), i && n(e, i), e
                    }
                }(),
                d = i(5),
                u = i(7),
                b = i(4),
                a = function() {
                    function y(e, t) {
                        var i = t.location,
                            n = void 0 === i ? 0 : i,
                            a = t.distance,
                            r = void 0 === a ? 100 : a,
                            s = t.threshold,
                            o = void 0 === s ? .6 : s,
                            l = t.maxPatternLength,
                            c = void 0 === l ? 32 : l,
                            d = t.isCaseSensitive,
                            u = void 0 !== d && d,
                            h = t.tokenSeparator,
                            p = void 0 === h ? / +/g : h,
                            f = t.findAllMatches,
                            v = void 0 !== f && f,
                            m = t.minMatchCharLength,
                            g = void 0 === m ? 1 : m;
                        (function(e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                        })(this, y), this.options = {
                            location: n,
                            distance: r,
                            threshold: o,
                            maxPatternLength: c,
                            isCaseSensitive: u,
                            tokenSeparator: p,
                            findAllMatches: v,
                            minMatchCharLength: g
                        }, this.pattern = this.options.isCaseSensitive ? e : e.toLowerCase(), this.pattern.length <= c && (this.patternAlphabet = b(this.pattern))
                    }
                    return n(y, [{
                        key: "search",
                        value: function(e) {
                            if (this.options.isCaseSensitive || (e = e.toLowerCase()), this.pattern === e) return {
                                isMatch: !0,
                                score: 0,
                                matchedIndices: [
                                    [0, e.length - 1]
                                ]
                            };
                            var t = this.options,
                                i = t.maxPatternLength,
                                n = t.tokenSeparator;
                            if (this.pattern.length > i) return d(e, this.pattern, n);
                            var a = this.options,
                                r = a.location,
                                s = a.distance,
                                o = a.threshold,
                                l = a.findAllMatches,
                                c = a.minMatchCharLength;
                            return u(e, this.pattern, this.patternAlphabet, {
                                location: r,
                                distance: s,
                                threshold: o,
                                findAllMatches: l,
                                minMatchCharLength: c
                            })
                        }
                    }]), y
                }();
            e.exports = a
        }, function(e, t, i) {
            "use strict";
            var d = i(0);
            e.exports = function(e, t) {
                return function e(t, i, n) {
                    if (i) {
                        var a = i.indexOf("."),
                            r = i,
                            s = null; - 1 !== a && (r = i.slice(0, a), s = i.slice(a + 1));
                        var o = t[r];
                        if (null != o)
                            if (s || "string" != typeof o && "number" != typeof o)
                                if (d(o))
                                    for (var l = 0, c = o.length; l < c; l += 1) e(o[l], s, n);
                                else s && e(o, s, n);
                        else n.push(o.toString())
                    } else n.push(t);
                    return n
                }(e, t, [])
            }
        }, function(e, t, i) {
            "use strict";
            e.exports = function() {
                for (var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : [], t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 1, i = [], n = -1, a = -1, r = 0, s = e.length; r < s; r += 1) {
                    var o = e[r];
                    o && -1 === n ? n = r : o || -1 === n || (t <= (a = r - 1) - n + 1 && i.push([n, a]), n = -1)
                }
                return e[r - 1] && t <= r - n && i.push([n, r - 1]), i
            }
        }, function(e, t, i) {
            "use strict";
            e.exports = function(e) {
                for (var t = {}, i = e.length, n = 0; n < i; n += 1) t[e.charAt(n)] = 0;
                for (var a = 0; a < i; a += 1) t[e.charAt(a)] |= 1 << i - a - 1;
                return t
            }
        }, function(e, t, i) {
            "use strict";
            var d = /[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g;
            e.exports = function(e, t) {
                var i = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : / +/g,
                    n = new RegExp(t.replace(d, "\\$&").replace(i, "|")),
                    a = e.match(n),
                    r = !!a,
                    s = [];
                if (r)
                    for (var o = 0, l = a.length; o < l; o += 1) {
                        var c = a[o];
                        s.push([e.indexOf(c), c.length - 1])
                    }
                return {
                    score: r ? .5 : 1,
                    isMatch: r,
                    matchedIndices: s
                }
            }
        }, function(e, t, i) {
            "use strict";
            e.exports = function(e, t) {
                var i = t.errors,
                    n = void 0 === i ? 0 : i,
                    a = t.currentLocation,
                    r = void 0 === a ? 0 : a,
                    s = t.expectedLocation,
                    o = void 0 === s ? 0 : s,
                    l = t.distance,
                    c = void 0 === l ? 100 : l,
                    d = n / e.length,
                    u = Math.abs(o - r);
                return c ? d + u / c : u ? 1 : d
            }
        }, function(e, t, i) {
            "use strict";
            var z = i(6),
                N = i(3);
            e.exports = function(e, t, i, n) {
                for (var a = n.location, r = void 0 === a ? 0 : a, s = n.distance, o = void 0 === s ? 100 : s, l = n.threshold, c = void 0 === l ? .6 : l, d = n.findAllMatches, u = void 0 !== d && d, h = n.minMatchCharLength, p = void 0 === h ? 1 : h, f = r, v = e.length, m = c, g = e.indexOf(t, f), y = t.length, b = [], w = 0; w < v; w += 1) b[w] = 0;
                if (-1 !== g) {
                    var E = z(t, {
                        errors: 0,
                        currentLocation: g,
                        expectedLocation: f,
                        distance: o
                    });
                    if (m = Math.min(E, m), -1 !== (g = e.lastIndexOf(t, f + y))) {
                        var x = z(t, {
                            errors: 0,
                            currentLocation: g,
                            expectedLocation: f,
                            distance: o
                        });
                        m = Math.min(x, m)
                    }
                }
                g = -1;
                for (var S = [], C = 1, k = y + v, T = 1 << y - 1, _ = 0; _ < y; _ += 1) {
                    for (var L = 0, I = k; L < I;) z(t, {
                        errors: _,
                        currentLocation: f + I,
                        expectedLocation: f,
                        distance: o
                    }) <= m ? L = I : k = I, I = Math.floor((k - L) / 2 + L);
                    k = I;
                    var M = Math.max(1, f - I + 1),
                        O = u ? v : Math.min(f + I, v) + y,
                        D = Array(O + 2);
                    D[O + 1] = (1 << _) - 1;
                    for (var P = O; M <= P; P -= 1) {
                        var A = P - 1,
                            F = i[e.charAt(A)];
                        if (F && (b[A] = 1), D[P] = (D[P + 1] << 1 | 1) & F, 0 !== _ && (D[P] |= (S[P + 1] | S[P]) << 1 | 1 | S[P + 1]), D[P] & T && (C = z(t, {
                                errors: _,
                                currentLocation: A,
                                expectedLocation: f,
                                distance: o
                            })) <= m) {
                            if (m = C, (g = A) <= f) break;
                            M = Math.max(1, 2 * f - g)
                        }
                    }
                    if (z(t, {
                            errors: _ + 1,
                            currentLocation: f,
                            expectedLocation: f,
                            distance: o
                        }) > m) break;
                    S = D
                }
                return {
                    isMatch: 0 <= g,
                    score: 0 === C ? .001 : C,
                    matchedIndices: N(b, p)
                }
            }
        }, function(e, t, i) {
            "use strict";
            var n = function() {
                    function n(e, t) {
                        for (var i = 0; i < t.length; i++) {
                            var n = t[i];
                            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                        }
                    }
                    return function(e, t, i) {
                        return t && n(e.prototype, t), i && n(e, i), e
                    }
                }(),
                r = i(1),
                R = i(2),
                z = i(0),
                a = function() {
                    function j(e, t) {
                        var i = t.location,
                            n = void 0 === i ? 0 : i,
                            a = t.distance,
                            r = void 0 === a ? 100 : a,
                            s = t.threshold,
                            o = void 0 === s ? .6 : s,
                            l = t.maxPatternLength,
                            c = void 0 === l ? 32 : l,
                            d = t.caseSensitive,
                            u = void 0 !== d && d,
                            h = t.tokenSeparator,
                            p = void 0 === h ? / +/g : h,
                            f = t.findAllMatches,
                            v = void 0 !== f && f,
                            m = t.minMatchCharLength,
                            g = void 0 === m ? 1 : m,
                            y = t.id,
                            b = void 0 === y ? null : y,
                            w = t.keys,
                            E = void 0 === w ? [] : w,
                            x = t.shouldSort,
                            S = void 0 === x || x,
                            C = t.getFn,
                            k = void 0 === C ? R : C,
                            T = t.sortFn,
                            _ = void 0 === T ? function(e, t) {
                                return e.score - t.score
                            } : T,
                            L = t.tokenize,
                            I = void 0 !== L && L,
                            M = t.matchAllTokens,
                            O = void 0 !== M && M,
                            D = t.includeMatches,
                            P = void 0 !== D && D,
                            A = t.includeScore,
                            F = void 0 !== A && A,
                            z = t.verbose,
                            N = void 0 !== z && z;
                        (function(e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                        })(this, j), this.options = {
                            location: n,
                            distance: r,
                            threshold: o,
                            maxPatternLength: c,
                            isCaseSensitive: u,
                            tokenSeparator: p,
                            findAllMatches: v,
                            minMatchCharLength: g,
                            id: b,
                            keys: E,
                            includeMatches: P,
                            includeScore: F,
                            shouldSort: S,
                            getFn: k,
                            sortFn: _,
                            verbose: N,
                            tokenize: I,
                            matchAllTokens: O
                        }, this.setCollection(e)
                    }
                    return n(j, [{
                        key: "setCollection",
                        value: function(e) {
                            return this.list = e
                        }
                    }, {
                        key: "search",
                        value: function(e) {
                            this._log('---------\nSearch pattern: "' + e + '"');
                            var t = this._prepareSearchers(e),
                                i = t.tokenSearchers,
                                n = t.fullSearcher,
                                a = this._search(i, n),
                                r = a.weights,
                                s = a.results;
                            return this._computeScore(r, s), this.options.shouldSort && this._sort(s), this._format(s)
                        }
                    }, {
                        key: "_prepareSearchers",
                        value: function() {
                            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "",
                                t = [];
                            if (this.options.tokenize)
                                for (var i = e.split(this.options.tokenSeparator), n = 0, a = i.length; n < a; n += 1) t.push(new r(i[n], this.options));
                            return {
                                tokenSearchers: t,
                                fullSearcher: new r(e, this.options)
                            }
                        }
                    }, {
                        key: "_search",
                        value: function() {
                            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : [],
                                t = arguments[1],
                                i = this.list,
                                n = {},
                                a = [];
                            if ("string" == typeof i[0]) {
                                for (var r = 0, s = i.length; r < s; r += 1) this._analyze({
                                    key: "",
                                    value: i[r],
                                    record: r,
                                    index: r
                                }, {
                                    resultMap: n,
                                    results: a,
                                    tokenSearchers: e,
                                    fullSearcher: t
                                });
                                return {
                                    weights: null,
                                    results: a
                                }
                            }
                            for (var o = {}, l = 0, c = i.length; l < c; l += 1)
                                for (var d = i[l], u = 0, h = this.options.keys.length; u < h; u += 1) {
                                    var p = this.options.keys[u];
                                    if ("string" != typeof p) {
                                        if (o[p.name] = {
                                                weight: 1 - p.weight || 1
                                            }, p.weight <= 0 || 1 < p.weight) throw new Error("Key weight has to be > 0 and <= 1");
                                        p = p.name
                                    } else o[p] = {
                                        weight: 1
                                    };
                                    this._analyze({
                                        key: p,
                                        value: this.options.getFn(d, p),
                                        record: d,
                                        index: l
                                    }, {
                                        resultMap: n,
                                        results: a,
                                        tokenSearchers: e,
                                        fullSearcher: t
                                    })
                                }
                            return {
                                weights: o,
                                results: a
                            }
                        }
                    }, {
                        key: "_analyze",
                        value: function(e, t) {
                            var i = e.key,
                                n = e.arrayIndex,
                                a = void 0 === n ? -1 : n,
                                r = e.value,
                                s = e.record,
                                o = e.index,
                                l = t.tokenSearchers,
                                c = void 0 === l ? [] : l,
                                d = t.fullSearcher,
                                u = void 0 === d ? [] : d,
                                h = t.resultMap,
                                p = void 0 === h ? {} : h,
                                f = t.results,
                                v = void 0 === f ? [] : f;
                            if (null != r) {
                                var m = !1,
                                    g = -1,
                                    y = 0;
                                if ("string" == typeof r) {
                                    this._log("\nKey: " + ("" === i ? "-" : i));
                                    var b = u.search(r);
                                    if (this._log('Full text: "' + r + '", score: ' + b.score), this.options.tokenize) {
                                        for (var w = r.split(this.options.tokenSeparator), E = [], x = 0; x < c.length; x += 1) {
                                            var S = c[x];
                                            this._log('\nPattern: "' + S.pattern + '"');
                                            for (var C = !1, k = 0; k < w.length; k += 1) {
                                                var T = w[k],
                                                    _ = S.search(T),
                                                    L = {};
                                                _.isMatch ? (L[T] = _.score, C = m = !0, E.push(_.score)) : (L[T] = 1, this.options.matchAllTokens || E.push(1)), this._log('Token: "' + T + '", score: ' + L[T])
                                            }
                                            C && (y += 1)
                                        }
                                        g = E[0];
                                        for (var I = E.length, M = 1; M < I; M += 1) g += E[M];
                                        g /= I, this._log("Token score average:", g)
                                    }
                                    var O = b.score; - 1 < g && (O = (O + g) / 2), this._log("Score average:", O);
                                    var D = !this.options.tokenize || !this.options.matchAllTokens || y >= c.length;
                                    if (this._log("\nCheck Matches: " + D), (m || b.isMatch) && D) {
                                        var P = p[o];
                                        P ? P.output.push({
                                            key: i,
                                            arrayIndex: a,
                                            value: r,
                                            score: O,
                                            matchedIndices: b.matchedIndices
                                        }) : (p[o] = {
                                            item: s,
                                            output: [{
                                                key: i,
                                                arrayIndex: a,
                                                value: r,
                                                score: O,
                                                matchedIndices: b.matchedIndices
                                            }]
                                        }, v.push(p[o]))
                                    }
                                } else if (z(r))
                                    for (var A = 0, F = r.length; A < F; A += 1) this._analyze({
                                        key: i,
                                        arrayIndex: A,
                                        value: r[A],
                                        record: s,
                                        index: o
                                    }, {
                                        resultMap: p,
                                        results: v,
                                        tokenSearchers: c,
                                        fullSearcher: u
                                    })
                            }
                        }
                    }, {
                        key: "_computeScore",
                        value: function(e, t) {
                            this._log("\n\nComputing score:\n");
                            for (var i = 0, n = t.length; i < n; i += 1) {
                                for (var a = t[i].output, r = a.length, s = 0, o = 1, l = 0; l < r; l += 1) {
                                    var c = e ? e[a[l].key].weight : 1,
                                        d = 1 === c ? a[l].score : a[l].score || .001,
                                        u = d * c;
                                    1 !== c ? o = Math.min(o, u) : (a[l].nScore = u, s += u)
                                }
                                t[i].score = 1 === o ? s / r : o, this._log(t[i])
                            }
                        }
                    }, {
                        key: "_sort",
                        value: function(e) {
                            this._log("\n\nSorting...."), e.sort(this.options.sortFn)
                        }
                    }, {
                        key: "_format",
                        value: function(e) {
                            var t = [];
                            this._log("\n\nOutput:\n\n", JSON.stringify(e));
                            var i = [];
                            this.options.includeMatches && i.push(function(e, t) {
                                var i = e.output;
                                t.matches = [];
                                for (var n = 0, a = i.length; n < a; n += 1) {
                                    var r = i[n];
                                    if (0 !== r.matchedIndices.length) {
                                        var s = {
                                            indices: r.matchedIndices,
                                            value: r.value
                                        };
                                        r.key && (s.key = r.key), r.hasOwnProperty("arrayIndex") && -1 < r.arrayIndex && (s.arrayIndex = r.arrayIndex), t.matches.push(s)
                                    }
                                }
                            }), this.options.includeScore && i.push(function(e, t) {
                                t.score = e.score
                            });
                            for (var n = 0, a = e.length; n < a; n += 1) {
                                var r = e[n];
                                if (this.options.id && (r.item = this.options.getFn(r.item, this.options.id)[0]), i.length) {
                                    for (var s = {
                                            item: r.item
                                        }, o = 0, l = i.length; o < l; o += 1) i[o](r, s);
                                    t.push(s)
                                } else t.push(r.item)
                            }
                            return t
                        }
                    }, {
                        key: "_log",
                        value: function() {
                            var e;
                            this.options.verbose && (e = console).log.apply(e, arguments)
                        }
                    }]), j
                }();
            e.exports = a
        }])
    }, function(e, t, i) {
        "use strict";

        function n(e) {
            var t = Object.prototype.toString.call(e);
            return "[object RegExp]" === t || "[object Date]" === t || e.$$typeof === r
        }

        function l(e, t) {
            return !1 !== t.clone && t.isMergeableObject(e) ? d((i = e, Array.isArray(i) ? [] : {}), e, t) : e;
            var i
        }

        function c(e, t, i) {
            return e.concat(t).map(function(e) {
                return l(e, i)
            })
        }

        function d(e, t, i) {
            (i = i || {}).arrayMerge = i.arrayMerge || c, i.isMergeableObject = i.isMergeableObject || u;
            var n, a, r, s, o = Array.isArray(t);
            return o === Array.isArray(e) ? o ? i.arrayMerge(e, t, i) : (n = e, a = t, s = {}, (r = i).isMergeableObject(n) && Object.keys(n).forEach(function(e) {
                s[e] = l(n[e], r)
            }), Object.keys(a).forEach(function(e) {
                r.isMergeableObject(a[e]) && n[e] ? s[e] = d(n[e], a[e], r) : s[e] = l(a[e], r)
            }), s) : l(t, i)
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var u = function(e) {
                return !!(t = e) && "object" == typeof t && !n(e);
                var t
            },
            a = "function" == typeof Symbol && Symbol.for,
            r = a ? Symbol.for("react.element") : 60103;
        d.all = function(e, i) {
            if (!Array.isArray(e)) throw new Error("first argument should be an array");
            return e.reduce(function(e, t) {
                return d(e, t, i)
            }, {})
        };
        var s = d;
        t.default = s
    }, function(e, t, i) {
        "use strict";
        i(42), i(51), i(70), i(72)
    }, function(e, t, i) {
        i(43), e.exports = i(2).Array.find
    }, function(e, t, i) {
        "use strict";
        var n = i(6),
            a = i(47)(5),
            r = !0;
        "find" in [] && Array(1).find(function() {
            r = !1
        }), n(n.P + n.F * r, "Array", {
            find: function(e) {
                return a(this, e, 1 < arguments.length ? arguments[1] : void 0)
            }
        }), i(28)("find")
    }, function(e, t, i) {
        e.exports = !i(10) && !i(22)(function() {
            return 7 != Object.defineProperty(i(23)("div"), "a", {
                get: function() {
                    return 7
                }
            }).a
        })
    }, function(e, t, i) {
        var a = i(9);
        e.exports = function(e, t) {
            if (!a(e)) return e;
            var i, n;
            if (t && "function" == typeof(i = e.toString) && !a(n = i.call(e))) return n;
            if ("function" == typeof(i = e.valueOf) && !a(n = i.call(e))) return n;
            if (!t && "function" == typeof(i = e.toString) && !a(n = i.call(e))) return n;
            throw TypeError("Can't convert object to primitive value")
        }
    }, function(e, t) {
        e.exports = function(e) {
            if ("function" != typeof e) throw TypeError(e + " is not a function!");
            return e
        }
    }, function(e, t, i) {
        var b = i(14),
            w = i(25),
            E = i(16),
            x = i(18),
            n = i(48);
        e.exports = function(u, e) {
            var h = 1 == u,
                p = 2 == u,
                f = 3 == u,
                v = 4 == u,
                m = 6 == u,
                g = 5 == u || m,
                y = e || n;
            return function(e, t, i) {
                for (var n, a, r = E(e), s = w(r), o = b(t, i, 3), l = x(s.length), c = 0, d = h ? y(e, l) : p ? y(e, 0) : void 0; c < l; c++)
                    if ((g || c in s) && (n = s[c], a = o(n, c, r), u))
                        if (h) d[c] = a;
                        else if (a) switch (u) {
                    case 3:
                        return !0;
                    case 5:
                        return n;
                    case 6:
                        return c;
                    case 2:
                        d.push(n)
                } else if (v) return !1;
                return m ? -1 : f || v ? v : d
            }
        }
    }, function(e, t, i) {
        var n = i(49);
        e.exports = function(e, t) {
            return new(n(e))(t)
        }
    }, function(e, t, i) {
        var n = i(9),
            a = i(50),
            r = i(0)("species");
        e.exports = function(e) {
            var t;
            return a(e) && ("function" != typeof(t = e.constructor) || t !== Array && !a(t.prototype) || (t = void 0), n(t) && null === (t = t[r]) && (t = void 0)), void 0 === t ? Array : t
        }
    }, function(e, t, i) {
        var n = i(15);
        e.exports = Array.isArray || function(e) {
            return "Array" == n(e)
        }
    }, function(e, t, i) {
        i(52), i(63), e.exports = i(2).Array.from
    }, function(e, t, i) {
        "use strict";
        var n = i(53)(!0);
        i(54)(String, "String", function(e) {
            this._t = String(e), this._i = 0
        }, function() {
            var e, t = this._t,
                i = this._i;
            return i >= t.length ? {
                value: void 0,
                done: !0
            } : (e = n(t, i), this._i += e.length, {
                value: e,
                done: !1
            })
        })
    }, function(e, t, i) {
        var l = i(19),
            c = i(17);
        e.exports = function(o) {
            return function(e, t) {
                var i, n, a = String(c(e)),
                    r = l(t),
                    s = a.length;
                return r < 0 || s <= r ? o ? "" : void 0 : (i = a.charCodeAt(r)) < 55296 || 56319 < i || r + 1 === s || (n = a.charCodeAt(r + 1)) < 56320 || 57343 < n ? o ? a.charAt(r) : i : o ? a.slice(r, r + 2) : n - 56320 + (i - 55296 << 10) + 65536
            }
        }
    }, function(e, t, i) {
        "use strict";
        var b = i(27),
            w = i(6),
            E = i(24),
            x = i(4),
            S = i(20),
            C = i(55),
            k = i(32),
            T = i(62),
            _ = i(0)("iterator"),
            L = !([].keys && "next" in [].keys()),
            I = function() {
                return this
            };
        e.exports = function(e, t, i, n, a, r, s) {
            C(i, t, n);
            var o, l, c, d = function(e) {
                    if (!L && e in f) return f[e];
                    switch (e) {
                        case "keys":
                        case "values":
                            return function() {
                                return new i(this, e)
                            }
                    }
                    return function() {
                        return new i(this, e)
                    }
                },
                u = t + " Iterator",
                h = "values" == a,
                p = !1,
                f = e.prototype,
                v = f[_] || f["@@iterator"] || a && f[a],
                m = v || d(a),
                g = a ? h ? d("entries") : m : void 0,
                y = "Array" == t && f.entries || v;
            if (y && (c = T(y.call(new e))) !== Object.prototype && c.next && (k(c, u, !0), b || "function" == typeof c[_] || x(c, _, I)), h && v && "values" !== v.name && (p = !0, m = function() {
                    return v.call(this)
                }), b && !s || !L && !p && f[_] || x(f, _, m), S[t] = m, S[u] = I, a)
                if (o = {
                        values: h ? m : d("values"),
                        keys: r ? m : d("keys"),
                        entries: g
                    }, s)
                    for (l in o) l in f || E(f, l, o[l]);
                else w(w.P + w.F * (L || p), t, o);
            return o
        }
    }, function(e, t, i) {
        "use strict";
        var n = i(56),
            a = i(12),
            r = i(32),
            s = {};
        i(4)(s, i(0)("iterator"), function() {
            return this
        }), e.exports = function(e, t, i) {
            e.prototype = n(s, {
                next: a(1, i)
            }), r(e, t + " Iterator")
        }
    }, function(e, t, n) {
        var a = n(8),
            r = n(57),
            s = n(31),
            o = n(21)("IE_PROTO"),
            l = function() {},
            c = function() {
                var e, t = n(23)("iframe"),
                    i = s.length;
                for (t.style.display = "none", n(61).appendChild(t), t.src = "javascript:", (e = t.contentWindow.document).open(), e.write("<script>document.F=Object<\/script>"), e.close(), c = e.F; i--;) delete c.prototype[s[i]];
                return c()
            };
        e.exports = Object.create || function(e, t) {
            var i;
            return null !== e ? (l.prototype = a(e), i = new l, l.prototype = null, i[o] = e) : i = c(), void 0 === t ? i : r(i, t)
        }
    }, function(e, t, i) {
        var s = i(7),
            o = i(8),
            l = i(58);
        e.exports = i(10) ? Object.defineProperties : function(e, t) {
            o(e);
            for (var i, n = l(t), a = n.length, r = 0; r < a;) s.f(e, i = n[r++], t[i]);
            return e
        }
    }, function(e, t, i) {
        var n = i(59),
            a = i(31);
        e.exports = Object.keys || function(e) {
            return n(e, a)
        }
    }, function(e, t, i) {
        var n = i(3).document;
        e.exports = n && n.documentElement
    }, function(e, t, i) {
        var n = i(11),
            a = i(16),
            r = i(21)("IE_PROTO"),
            s = Object.prototype;
        e.exports = Object.getPrototypeOf || function(e) {
            return e = a(e), n(e, r) ? e[r] : "function" == typeof e.constructor && e instanceof e.constructor ? e.constructor.prototype : e instanceof Object ? s : null
        }
    }, function(e, t, i) {
        "use strict";
        var h = i(14),
            n = i(6),
            p = i(16),
            f = i(64),
            v = i(65),
            m = i(18),
            g = i(66),
            y = i(67);
        n(n.S + n.F * !i(69)(function(e) {
            Array.from(e)
        }), "Array", {
            from: function(e) {
                var t, i, n, a, r = p(e),
                    s = "function" == typeof this ? this : Array,
                    o = arguments.length,
                    l = 1 < o ? arguments[1] : void 0,
                    c = void 0 !== l,
                    d = 0,
                    u = y(r);
                if (c && (l = h(l, 2 < o ? arguments[2] : void 0, 2)), null == u || s == Array && v(u))
                    for (t = m(r.length), i = new s(t); d < t; d++) g(i, d, c ? l(r[d], d) : r[d]);
                else
                    for (a = u.call(r), i = new s; !(n = a.next()).done; d++) g(i, d, c ? f(a, l, [n.value, d], !0) : n.value);
                return i.length = d, i
            }
, function(e, t) {
        try {
            var i = new window.CustomEvent("test");
            if (i.preventDefault(), !0 !== i.defaultPrevented) throw new Error("Could not prevent default")
        } catch (e) {
            var n = function(e, t) {
                var i, n;
                return t = t || {
                    bubbles: !1,
                    cancelable: !1,
                    detail: void 0
                }, (i = document.createEvent("CustomEvent")).initCustomEvent(e, t.bubbles, t.cancelable, t.detail), n = i.preventDefault, i.preventDefault = function() {
                    n.call(this);
                    try {
                        Object.defineProperty(this, "defaultPrevented", {
                            get: function() {
                                return !0
                            }
                        })
                    } catch (e) {
                        this.defaultPrevented = !0
                    }
                }, i
            };
            n.prototype = window.Event.prototype, window.CustomEvent = n
        }
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var n, a = function() {
                function n(e, t) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                    }
                }
                return function(e, t, i) {
                    return t && n(e.prototype, t), i && n(e, i), e
                }
            }(),
            r = i(33),
            s = i(78),
            o = (n = s) && n.__esModule ? n : {
                default: n
            },
            l = function() {
                function e() {
                    (function(e, t) {
                        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                    })(this, e), this._store = (0, r.createStore)(o.default, window.devToolsExtension ? window.devToolsExtension() : void 0)
                }
                return a(e, [{
                    key: "subscribe",
                    value: function(e) {
                        this._store.subscribe(e)
                    }
                }, {
                    key: "dispatch",
                    value: function(e) {
                        this._store.dispatch(e)
                    }
                }, {
                    key: "getChoiceById",
                    value: function(t) {
                        return !!t && this.activeChoices.find(function(e) {
                            return e.id === parseInt(t, 10)
                        })
                    }
                }, {
                    key: "getGroupById",
                    value: function(t) {
                        return this.groups.find(function(e) {
                            return e.id === parseInt(t, 10)
                        })
                    }
                }, {
                    key: "state",
                    get: function() {
                        return this._store.getState()
                    }
                }, {
                    key: "items",
                    get: function() {
                        return this.state.items
                    }
                }, {
                    key: "activeItems",
                    get: function() {
                        return this.items.filter(function(e) {
                            return !0 === e.active
                        })
                    }
                }, {
                    key: "highlightedActiveItems",
                    get: function() {
                        return this.items.filter(function(e) {
                            return e.active && e.highlighted
                        })
                    }
                }, {
                    key: "choices",
                    get: function() {
                        return this.state.choices
                    }
                }, {
                    key: "activeChoices",
                    get: function() {
                        return this.choices.filter(function(e) {
                            return !0 === e.active
                        })
                    }
                }, {
                    key: "selectableChoices",
                    get: function() {
                        return this.choices.filter(function(e) {
                            return !0 !== e.disabled
                        })
                    }
                }, {
                    key: "searchableChoices",
                    get: function() {
                        return this.selectableChoices.filter(function(e) {
                            return !0 !== e.placeholder
                        })
                    }
                }, {
                    key: "placeholderChoice",
                    get: function() {
                        return [].concat(function(e) {
                            if (Array.isArray(e)) {
                                for (var t = 0, i = Array(e.length); t < e.length; t++) i[t] = e[t];
                                return i
                            }
                            return Array.from(e)
                        }(this.choices)).reverse().find(function(e) {
                            return !0 === e.placeholder
                        })
                    }
                }, {
                    key: "groups",
                    get: function() {
                        return this.state.groups
                    }
                }, {
                    key: "activeGroups",
                    get: function() {
                        var e = this.groups,
                            n = this.choices;
                        return e.filter(function(e) {
                            var t = !0 === e.active && !1 === e.disabled,
                                i = n.some(function(e) {
                                    return !0 === e.active && !1 === e.disabled
                                });
                            return t && i
                        }, [])
                    }
                }]), e
            }();
        t.default = l
    }, function(e, i, t) {
        "use strict";
        (function(e) {
            var t = "object" == typeof e && e && e.Object === Object && e;
            i.a = t
        }).call(i, t(34))
    }, function(e, r, s) {
        "use strict";
        (function(e, t) {
            var i, n = s(77);
            i = "undefined" != typeof self ? self : "undefined" != typeof window ? window : void 0 !== e ? e : t;
            var a = Object(n.a)(i);
            r.a = a
        }).call(r, s(34), s(76)(e))
    }, function(e, t) {
        e.exports = function(e) {
            if (!e.webpackPolyfill) {
                var t = Object.create(e);
                t.children || (t.children = []), Object.defineProperty(t, "loaded", {
                    enumerable: !0,
                    get: function() {
                        return t.l
                    }
                }), Object.defineProperty(t, "id", {
                    enumerable: !0,
                    get: function() {
                        return t.i
                    }
                }), Object.defineProperty(t, "exports", {
                    enumerable: !0
                }), t.webpackPolyfill = 1
            }
            return t
        }
    }, function(e, t, i) {
        "use strict";
        t.a = function(e) {
            var t, i = e.Symbol;
            return "function" == typeof i ? i.observable ? t = i.observable : (t = i("observable"), i.observable = t) : t = "@@observable", t
        }
    }, function(e, t, i) {
        "use strict";

        function n(e) {
            return e && e.__esModule ? e : {
                default: e
            }
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var a = i(33),
            r = i(79),
            s = n(r),
            o = i(80),
            l = n(o),
            c = i(81),
            d = n(c),
            u = i(1),
            h = (0, a.combineReducers)({
                items: s.default,
                groups: l.default,
                choices: d.default
            });
        t.default = function(e, t) {
            var i = e;
            if ("CLEAR_ALL" === t.type) i = void 0;
            else if ("RESET_TO" === t.type) return (0, u.cloneObject)(t.state);
            return h(i, t)
        }
    }, function(e, t, i) {
        "use strict";

        function n(e) {
            if (Array.isArray(e)) {
                for (var t = 0, i = Array(e.length); t < e.length; t++) i[t] = e[t];
                return i
            }
            return Array.from(e)
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        }), t.default = function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : a,
                i = arguments[1];
            switch (i.type) {
                case "ADD_ITEM":
                    return [].concat(n(e), [{
                        id: i.id,
                        choiceId: i.choiceId,
                        groupId: i.groupId,
                        value: i.value,
                        label: i.label,
                        active: !0,
                        highlighted: !1,
                        customProperties: i.customProperties,
                        placeholder: i.placeholder || !1,
                        keyCode: null
                    }]).map(function(e) {
                        var t = e;
                        return t.highlighted = !1, t
                    });
                case "REMOVE_ITEM":
                    return e.map(function(e) {
                        var t = e;
                        return t.id === i.id && (t.active = !1), t
                    });
                case "HIGHLIGHT_ITEM":
                    return e.map(function(e) {
                        var t = e;
                        return t.id === i.id && (t.highlighted = i.highlighted), t
                    });
                default:
                    return e
            }
        };
        var a = t.defaultState = []
    }, function(e, t, i) {
        "use strict";

        function n(e) {
            if (Array.isArray(e)) {
                for (var t = 0, i = Array(e.length); t < e.length; t++) i[t] = e[t];
                return i
            }
            return Array.from(e)
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        }), t.default = function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : a,
                t = arguments[1];
            switch (t.type) {
                case "ADD_GROUP":
                    return [].concat(n(e), [{
                        id: t.id,
                        value: t.value,
                        active: t.active,
                        disabled: t.disabled
                    }]);
                case "CLEAR_CHOICES":
                    return [];
                default:
                    return e
            }
        };
        var a = t.defaultState = []
    }, function(e, t, i) {
        "use strict";

        function n(e) {
            if (Array.isArray(e)) {
                for (var t = 0, i = Array(e.length); t < e.length; t++) i[t] = e[t];
                return i
            }
            return Array.from(e)
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        }), t.default = function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : a,
                i = arguments[1];
            switch (i.type) {
                case "ADD_CHOICE":
                    return [].concat(n(e), [{
                        id: i.id,
                        elementId: i.elementId,
                        groupId: i.groupId,
                        value: i.value,
                        label: i.label || i.value,
                        disabled: i.disabled || !1,
                        selected: !1,
                        active: !0,
                        score: 9999,
                        customProperties: i.customProperties,
                        placeholder: i.placeholder || !1,
                        keyCode: null
                    }]);
                case "ADD_ITEM":
                    return i.activateOptions ? e.map(function(e) {
                        var t = e;
                        return t.active = i.active, t
                    }) : -1 < i.choiceId ? e.map(function(e) {
                        var t = e;
                        return t.id === parseInt(i.choiceId, 10) && (t.selected = !0), t
                    }) : e;
                case "REMOVE_ITEM":
                    return -1 < i.choiceId ? e.map(function(e) {
                        var t = e;
                        return t.id === parseInt(i.choiceId, 10) && (t.selected = !1), t
                    }) : e;
                case "FILTER_CHOICES":
                    return e.map(function(e) {
                        var n = e;
                        return n.active = i.results.some(function(e) {
                            var t = e.item,
                                i = e.score;
                            return t.id === n.id && (n.score = i, !0)
                        }), n
                    });
                case "ACTIVATE_CHOICES":
                    return e.map(function(e) {
                        var t = e;
                        return t.active = i.active, t
                    });
                case "CLEAR_CHOICES":
                    return a;
                default:
                    return e
            }
        };
        var a = t.defaultState = []
    }, function(e, t, i) {
        "use strict";

        function n(e) {
            return e && e.__esModule ? e : {
                default: e
            }
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        }), t.WrappedSelect = t.WrappedInput = t.List = t.Input = t.Container = t.Dropdown = void 0;
        var a = i(83),
            r = n(a),
            s = i(84),
            o = n(s),
            l = i(85),
            c = n(l),
            d = i(86),
            u = n(d),
            h = i(87),
            p = n(h),
            f = i(88),
            v = n(f);
        t.Dropdown = r.default, t.Container = o.default, t.Input = c.default, t.List = u.default, t.WrappedInput = p.default, t.WrappedSelect = v.default
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var n = function() {
                function n(e, t) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                    }
                }
                return function(e, t, i) {
                    return t && n(e.prototype, t), i && n(e, i), e
                }
            }(),
            a = function() {
                function a(e) {
                    var t = e.element,
                        i = e.type,
                        n = e.classNames;
                    (function(e, t) {
                        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                    })(this, a), Object.assign(this, {
                        element: t,
                        type: i,
                        classNames: n
                    }), this.isActive = !1
                }
                return n(a, [{
                    key: "distanceFromTopWindow",
                    value: function() {
                        return this.dimensions = this.element.getBoundingClientRect(), this.position = Math.ceil(this.dimensions.top + window.pageYOffset + this.element.offsetHeight), this.position
                    }
                }, {
                    key: "getChild",
                    value: function(e) {
                        return this.element.querySelector(e)
                    }
                }, {
                    key: "show",
                    value: function() {
                        return this.element.classList.add(this.classNames.activeState), this.element.setAttribute("aria-expanded", "true"), this.isActive = !0, this
                    }
                }, {
                    key: "hide",
                    value: function() {
                        return this.element.classList.remove(this.classNames.activeState), this.element.setAttribute("aria-expanded", "false"), this.isActive = !1, this
                    }
                }]), a
            }();
        t.default = a
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var n = function() {
                function n(e, t) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                    }
                }
                return function(e, t, i) {
                    return t && n(e.prototype, t), i && n(e, i), e
                }
            }(),
            a = i(1),
            r = function() {
                function r(e) {
                    var t = e.element,
                        i = e.type,
                        n = e.classNames,
                        a = e.position;
                    (function(e, t) {
                        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                    })(this, r), Object.assign(this, {
                        element: t,
                        classNames: n,
                        type: i,
                        position: a
                    }), this.isOpen = !1, this.isFlipped = !1, this.isFocussed = !1, this.isDisabled = !1, this.isLoading = !1, this._onFocus = this._onFocus.bind(this), this._onBlur = this._onBlur.bind(this)
                }
                return n(r, [{
                    key: "addEventListeners",
                    value: function() {
                        this.element.addEventListener("focus", this._onFocus), this.element.addEventListener("blur", this._onBlur)
                    }
                }, {
                    key: "removeEventListeners",
                    value: function() {
                        this.element.removeEventListener("focus", this._onFocus), this.element.removeEventListener("blur", this._onBlur)
                    }
                }, {
                    key: "shouldFlip",
                    value: function(e) {
                        var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : (0, a.getWindowHeight)();
                        if (void 0 === e) return !1;
                        var i = !1;
                        return "auto" === this.position ? i = t <= e : "top" === this.position && (i = !0), i
                    }
                }, {
                    key: "setActiveDescendant",
                    value: function(e) {
                        this.element.setAttribute("aria-activedescendant", e)
                    }
                }, {
                    key: "removeActiveDescendant",
                    value: function() {
                        this.element.removeAttribute("aria-activedescendant")
                    }
                }, {
                    key: "open",
                    value: function(e) {
                        this.element.classList.add(this.classNames.openState), this.element.setAttribute("aria-expanded", "true"), this.isOpen = !0, this.shouldFlip(e) && (this.element.classList.add(this.classNames.flippedState), this.isFlipped = !0)
                    }
                }, {
                    key: "close",
                    value: function() {
                        this.element.classList.remove(this.classNames.openState), this.element.setAttribute("aria-expanded", "false"), this.removeActiveDescendant(), this.isOpen = !1, this.isFlipped && (this.element.classList.remove(this.classNames.flippedState), this.isFlipped = !1)
                    }
                }, {
                    key: "focus",
                    value: function() {
                        this.isFocussed || this.element.focus()
                    }
                }, {
                    key: "addFocusState",
                    value: function() {
                        this.element.classList.add(this.classNames.focusState)
                    }
                }, {
                    key: "removeFocusState",
                    value: function() {
                        this.element.classList.remove(this.classNames.focusState)
                    }
                }, {
                    key: "enable",
                    value: function() {
                        this.element.classList.remove(this.classNames.disabledState), this.element.removeAttribute("aria-disabled"), "select-one" === this.type && this.element.setAttribute("tabindex", "0"), this.isDisabled = !1
                    }
                }, {
                    key: "disable",
                    value: function() {
                        this.element.classList.add(this.classNames.disabledState), this.element.setAttribute("aria-disabled", "true"), "select-one" === this.type && this.element.setAttribute("tabindex", "-1"), this.isDisabled = !0
                    }
                }, {
                    key: "wrap",
                    value: function(e) {
                        (0, a.wrap)(e, this.element)
                    }
                }, {
                    key: "unwrap",
                    value: function(e) {
                        this.element.parentNode.insertBefore(e, this.element), this.element.parentNode.removeChild(this.element)
                    }
                }, {
                    key: "addLoadingState",
                    value: function() {
                        this.element.classList.add(this.classNames.loadingState), this.element.setAttribute("aria-busy", "true"), this.isLoading = !0
                    }
                }, {
                    key: "removeLoadingState",
                    value: function() {
                        this.element.classList.remove(this.classNames.loadingState), this.element.removeAttribute("aria-busy"), this.isLoading = !1
                    }
                }, {
                    key: "_onFocus",
                    value: function() {
                        this.isFocussed = !0
                    }
                }, {
                    key: "_onBlur",
                    value: function() {
                        this.isFocussed = !1
                    }
                }]), r
            }();
        t.default = r
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var n = function() {
                function n(e, t) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                    }
                }
                return function(e, t, i) {
                    return t && n(e.prototype, t), i && n(e, i), e
                }
            }(),
            a = i(1),
            r = function() {
                function r(e) {
                    var t = e.element,
                        i = e.type,
                        n = e.classNames,
                        a = e.placeholderValue;
                    (function(e, t) {
                        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                    })(this, r), Object.assign(this, {
                        element: t,
                        type: i,
                        classNames: n,
                        placeholderValue: a
                    }), this.element = t, this.classNames = n, this.isFocussed = this.element === document.activeElement, this.isDisabled = !1, this._onPaste = this._onPaste.bind(this), this._onInput = this._onInput.bind(this), this._onFocus = this._onFocus.bind(this), this._onBlur = this._onBlur.bind(this)
                }
                return n(r, [{
                    key: "addEventListeners",
                    value: function() {
                        this.element.addEventListener("input", this._onInput), this.element.addEventListener("paste", this._onPaste), this.element.addEventListener("focus", this._onFocus), this.element.addEventListener("blur", this._onBlur), this.element.form && this.element.form.addEventListener("reset", this._onFormReset)
                    }
                }, {
                    key: "removeEventListeners",
                    value: function() {
                        this.element.removeEventListener("input", this._onInput), this.element.removeEventListener("paste", this._onPaste), this.element.removeEventListener("focus", this._onFocus), this.element.removeEventListener("blur", this._onBlur), this.element.form && this.element.form.removeEventListener("reset", this._onFormReset)
                    }
                }, {
                    key: "enable",
                    value: function() {
                        this.element.removeAttribute("disabled"), this.isDisabled = !1
                    }
                }, {
                    key: "disable",
                    value: function() {
                        this.element.setAttribute("disabled", ""), this.isDisabled = !0
                    }
                }, {
                    key: "focus",
                    value: function() {
                        this.isFocussed || this.element.focus()
                    }
                }, {
                    key: "blur",
                    value: function() {
                        this.isFocussed && this.element.blur()
                    }
                }, {
                    key: "clear",
                    value: function() {
                        var e = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0];
                        return this.element.value && (this.element.value = ""), e && this.setWidth(), this
                    }
                }, {
                    key: "setWidth",
                    value: function(e) {
                        var t = this,
                            i = function(e) {
                                t.element.style.width = e
                            };
                        if (this._placeholderValue) {
                            var n = this.element.value.length >= this._placeholderValue.length / 1.25;
                            (this.element.value && n || e) && this.calcWidth(i)
                        } else this.calcWidth(i)
                    }
                }, {
                    key: "calcWidth",
                    value: function(e) {
                        return (0, a.calcWidthOfInput)(this.element, e)
                    }
                }, {
                    key: "setActiveDescendant",
                    value: function(e) {
                        this.element.setAttribute("aria-activedescendant", e)
                    }
                }, {
                    key: "removeActiveDescendant",
                    value: function() {
                        this.element.removeAttribute("aria-activedescendant")
                    }
                }, {
                    key: "_onInput",
                    value: function() {
                        "select-one" !== this.type && this.setWidth()
                    }
                }, {
                    key: "_onPaste",
                    value: function(e) {
                        e.target === this.element && this.preventPaste && e.preventDefault()
                    }
                }, {
                    key: "_onFocus",
                    value: function() {
                        this.isFocussed = !0
                    }
                }, {
                    key: "_onBlur",
                    value: function() {
                        this.isFocussed = !1
                    }
                }, {
                    key: "placeholder",
                    set: function(e) {
                        this.element.placeholder = e
                    }
                }, {
                    key: "value",
                    set: function(e) {
                        this.element.value = "" + e
                    },
                    get: function() {
                        return (0, a.stripHTML)(this.element.value)
                    }
                }]), r
            }();
        t.default = r
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var n = function() {
                function n(e, t) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                    }
                }
                return function(e, t, i) {
                    return t && n(e.prototype, t), i && n(e, i), e
                }
            }(),
            o = i(5),
            a = function() {
                function i(e) {
                    var t = e.element;
                    (function(e, t) {
                        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                    })(this, i), Object.assign(this, {
                        element: t
                    }), this.scrollPos = this.element.scrollTop, this.height = this.element.offsetHeight, this.hasChildren = !!this.element.children
                }
                return n(i, [{
                    key: "clear",
                    value: function() {
                        this.element.innerHTML = ""
                    }
                }, {
                    key: "append",
                    value: function(e) {
                        this.element.appendChild(e)
                    }
                }, {
                    key: "getChild",
                    value: function(e) {
                        return this.element.querySelector(e)
                    }
                }, {
                    key: "scrollToTop",
                    value: function() {
                        this.element.scrollTop = 0
                    }
                }, {
                    key: "scrollToChoice",
                    value: function(e, t) {
                        var i = this;
                        if (e) {
                            var n = this.element.offsetHeight,
                                a = e.offsetHeight,
                                r = e.offsetTop + a,
                                s = this.element.scrollTop + n,
                                o = 0 < t ? this.element.scrollTop + r - s : e.offsetTop;
                            requestAnimationFrame(function(e) {
                                i._animateScroll(e, o, t)
                            })
                        }
                    }
                }, {
                    key: "_scrollDown",
                    value: function(e, t, i) {
                        var n = (i - e) / t,
                            a = 1 < n ? n : 1;
                        this.element.scrollTop = e + a
                    }
                }, {
                    key: "_scrollUp",
                    value: function(e, t, i) {
                        var n = (e - i) / t,
                            a = 1 < n ? n : 1;
                        this.element.scrollTop = e - a
                    }
                }, {
                    key: "_animateScroll",
                    value: function(e, t, i) {
                        var n = this,
                            a = o.SCROLLING_SPEED,
                            r = this.element.scrollTop,
                            s = !1;
                        0 < i ? (this._scrollDown(r, a, t), r < t && (s = !0)) : (this._scrollUp(r, a, t), t < r && (s = !0)), s && requestAnimationFrame(function() {
                            n._animateScroll(e, t, i)
                        })
                    }
                }]), i
            }();
        t.default = a
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var n, a = function() {
                function n(e, t) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                    }
                }
                return function(e, t, i) {
                    return t && n(e.prototype, t), i && n(e, i), e
                }
            }(),
            r = i(35),
            s = (n = r) && n.__esModule ? n : {
                default: n
            },
            o = i(1),
            l = function(e) {
                function r(e) {
                    var t = e.element,
                        i = e.classNames,
                        n = e.delimiter;
                    ! function(e, t) {
                        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                    }(this, r);
                    var a = function(e, t) {
                        if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                        return !t || "object" != typeof t && "function" != typeof t ? e : t
                    }(this, (r.__proto__ || Object.getPrototypeOf(r)).call(this, {
                        element: t,
                        classNames: i
                    }));
                    return a.delimiter = n, a
                }
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
                    e.prototype = Object.create(t && t.prototype, {
                        constructor: {
                            value: e,
                            enumerable: !1,
                            writable: !0,
                            configurable: !0
                        }
                    }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
                }(r, e), a(r, [{
                    key: "value",
                    set: function(e) {
                        var t = (0, o.reduceToValues)(e),
                            i = t.join(this.delimiter);
                        this.element.setAttribute("value", i), this.element.value = i
                    },
                    get: function() {
                        return function e(t, i, n) {
                            null === t && (t = Function.prototype);
                            var a = Object.getOwnPropertyDescriptor(t, i);
                            if (void 0 === a) {
                                var r = Object.getPrototypeOf(t);
                                return null === r ? void 0 : e(r, i, n)
                            }
                            if ("value" in a) return a.value;
                            var s = a.get;
                            return void 0 !== s ? s.call(n) : void 0
                        }(r.prototype.__proto__ || Object.getPrototypeOf(r.prototype), "value", this)
                    }
                }]), r
            }(s.default);
        t.default = l
    }, function(e, t, i) {
        "use strict";

        function n(e) {
            return e && e.__esModule ? e : {
                default: e
            }
        }
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var a = function() {
                function n(e, t) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                    }
                }
                return function(e, t, i) {
                    return t && n(e.prototype, t), i && n(e, i), e
                }
            }(),
            r = i(35),
            s = n(r),
            o = i(36),
            l = n(o),
            c = function(e) {
                function n(e) {
                    var t = e.element,
                        i = e.classNames;
                    return function(e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                        }(this, n),
                        function(e, t) {
                            if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                            return !t || "object" != typeof t && "function" != typeof t ? e : t
                        }(this, (n.__proto__ || Object.getPrototypeOf(n)).call(this, {
                            element: t,
                            classNames: i
                        }))
                }
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
                    e.prototype = Object.create(t && t.prototype, {
                        constructor: {
                            value: e,
                            enumerable: !1,
                            writable: !0,
                            configurable: !0
                        }
                    }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
                }(n, e), a(n, [{
                    key: "appendDocFragment",
                    value: function(e) {
                        this.element.innerHTML = "", this.element.appendChild(e)
                    }
                }, {
                    key: "placeholderOption",
                    get: function() {
                        return this.element.querySelector("option[placeholder]")
                    }
                }, {
                    key: "optionGroups",
                    get: function() {
                        return Array.from(this.element.getElementsByTagName("OPTGROUP"))
                    }
                }, {
                    key: "options",
                    get: function() {
                        return Array.from(this.element.options)
                    },
                    set: function(e) {
                        var n = document.createDocumentFragment();
                        e.forEach(function(e) {
                            return t = e, i = l.default.option(t), void n.appendChild(i);
                            var t, i
                        }), this.appendDocFragment(n)
                    }
                }]), n
            }(s.default);
        t.default = c
    }, function(e, t, i) {
        var n;
        ! function() {
            "use strict";

            function r() {
                for (var e = [], t = 0; t < arguments.length; t++) {
                    var i = arguments[t];
                    if (i) {
                        var n = typeof i;
                        if ("string" === n || "number" === n) e.push(i);
                        else if (Array.isArray(i)) e.push(r.apply(null, i));
                        else if ("object" === n)
                            for (var a in i) s.call(i, a) && i[a] && e.push(a)
                    }
                }
                return e.join(" ")
            }
            var s = {}.hasOwnProperty;
            void 0 !== e && e.exports ? e.exports = r : void 0 !== (n = function() {
                return r
            }.apply(t, [])) && (e.exports = n)
        }()
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        }), t.clearChoices = t.activateChoices = t.filterChoices = t.addChoice = void 0;
        var d = i(5);
        t.addChoice = function(e) {
            var t = e.value,
                i = e.label,
                n = e.id,
                a = e.groupId,
                r = e.disabled,
                s = e.elementId,
                o = e.customProperties,
                l = e.placeholder,
                c = e.keyCode;
            return {
                type: d.ACTION_TYPES.ADD_CHOICE,
                value: t,
                label: i,
                id: n,
                groupId: a,
                disabled: r,
                elementId: s,
                customProperties: o,
                placeholder: l,
                keyCode: c
            }
        }, t.filterChoices = function(e) {
            return {
                type: d.ACTION_TYPES.FILTER_CHOICES,
                results: e
            }
        }, t.activateChoices = function() {
            var e = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0];
            return {
                type: d.ACTION_TYPES.ACTIVATE_CHOICES,
                active: e
            }
        }, t.clearChoices = function() {
            return {
                type: d.ACTION_TYPES.CLEAR_CHOICES
            }
        }
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        }), t.highlightItem = t.removeItem = t.addItem = void 0;
        var c = i(5);
        t.addItem = function(e) {
            var t = e.value,
                i = e.label,
                n = e.id,
                a = e.choiceId,
                r = e.groupId,
                s = e.customProperties,
                o = e.placeholder,
                l = e.keyCode;
            return {
                type: c.ACTION_TYPES.ADD_ITEM,
                value: t,
                label: i,
                id: n,
                choiceId: a,
                groupId: r,
                customProperties: s,
                placeholder: o,
                keyCode: l
            }
        }, t.removeItem = function(e, t) {
            return {
                type: c.ACTION_TYPES.REMOVE_ITEM,
                id: e,
                choiceId: t
            }
        }, t.highlightItem = function(e, t) {
            return {
                type: c.ACTION_TYPES.HIGHLIGHT_ITEM,
                id: e,
                highlighted: t
            }
        }
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        }), t.addGroup = void 0;
        var a = i(5);
        t.addGroup = function(e, t, i, n) {
            return {
                type: a.ACTION_TYPES.ADD_GROUP,
                value: e,
                id: t,
                active: i,
                disabled: n
            }
        }
    }, function(e, t, i) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        }), t.clearAll = function() {
            return {
                type: "CLEAR_ALL"
            }
        }, t.resetTo = function(e) {
            return {
                type: "RESET_TO",
                state: e
            }
        }
    }])
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            t = e.container,
            i = void 0 === t ? ".slider" : t,
            n = e.element,
            a = void 0 === n ? ".slide" : n,
            r = e.step,
            s = void 0 === r ? ".slider-step span" : r,
            o = e.btnNext,
            l = void 0 === o ? ".slider-btn-next" : o,
            c = e.btnPrev,
            d = void 0 === c ? ".slider-btn-prev" : c,
            u = e.delay,
            h = void 0 === u ? 5e3 : u,
            p = e.speed,
            f = void 0 === p ? 500 : p,
            v = null,
            m = null,
            g = 0,
            y = 0,
            b = null,
            w = !1,
            E = [],
            x = document.querySelector(i),
            S = document.querySelectorAll(a),
            C = document.querySelector(s),
            k = null,
            T = document.querySelector(l),
            _ = document.querySelector(d),
            L = {
                touchStartX: 0,
                touchEndX: 0,
                minSwipePixels: 30,
                detectionZone: null,
                swiperCallback: function() {},
                init: function(e, t) {
                    L.swiperCallback = t, e.addEventListener("touchstart", function(e) {
                        L.touchStartX = e.changedTouches[0].screenX
                    }, !1), e.addEventListener("touchend", function(e) {
                        L.touchEndX = e.changedTouches[0].screenX, L.handleSwipeGesture()
                    }, !1)
                },
                handleSwipeGesture: function() {
                    var e = null,
                        t = null;
                    L.touchEndX <= L.touchStartX && (t = L.touchStartX - L.touchEndX, e = "left"), L.touchEndX >= L.touchStartX && (t = L.touchEndX - L.touchStartX, e = "right"), t > L.minSwipePixels && null !== e && L.swipe(e, t)
                },
                swipe: function(e, t) {
                    var i = {};
                    i.direction = e, i.movedPixels = t, L.swiperCallback(i)
                }
            };

        function I() {
            if (null != b && clearTimeout(b), (y = S.length) < 1) return x.remove(), !1;
            if (y < 2) return C.parentNode.removeChild(C), T.remove(), _.remove(), x.classList.add("active"), !1;
            E = function() {
                var e = [],
                    t = !0,
                    i = !1,
                    n = void 0;
                try {
                    for (var a, r = S[Symbol.iterator](); !(t = (a = r.next()).done); t = !0) {
                        var s = a.value;
                        s.style.animationDuration = f / 1e3 + "s";
                        var o = s.style.backgroundImage.replace(/^url\(["']?/, "").replace(/["']?\)$/, "");
                        e.push(o)
                    }
                } catch (e) {
                    i = !0, n = e
                } finally {
                    try {
                        t || null == r.return || r.return()
                    } finally {
                        if (i) throw n
                    }
                }
                return e
            }();
            for (var t = 0, e = 0; e < y; e++) {
                var i = new Image;
                i.src = E[e], i.onload = function() {
                    if (0 < t) {
                        var e = C.cloneNode(!0);
                        C.parentElement.appendChild(e)
                    }++t == y && (k = document.querySelectorAll(s), C.classList.add("active"), S[0].classList.add("active"), x.classList.add("active"), b = setTimeout(M, h))
                }
            }
        }

        function M() {
            v = S[g], g == y - 1 ? (m = S[0], g = 0) : (m = S[g + 1], g++), [].forEach.call(k, function(e) {
                e.classList.remove("active")
            }), m.classList.add("pending"), v.classList.add("animate"), k[g].classList.add("active"), w = !0, setTimeout(function() {
                v.classList.remove("active", "pending", "animate"), m.classList.add("active"), m.classList.remove("pending"), w = !1, b = setTimeout(M, h)
            }, f)
        }

        function O() {
            v = S[g], 0 == g ? (m = S[y - 1], g = y - 1) : (m = S[g - 1], g--), [].forEach.call(k, function(e) {
                e.classList.remove("active")
            }), m.classList.add("pending"), v.classList.add("animate"), k[g].classList.add("active"), w = !0, setTimeout(function() {
                v.classList.remove("active", "pending", "animate"), m.classList.add("active"), m.classList.remove("pending"), w = !1, b = setTimeout(O, h)
            }, f)
        }
        this.initSlider = function() {
            if (null == x) return !1;
            I(), document.addEventListener("click", function(e) {
                if (!e.target.matches(s) || w) return !1;
                var t = Array.from(k).indexOf(e.target);
                if (g == t) return !1;
                clearTimeout(b), v = S[g], m = S[g = t], [].forEach.call(k, function(e) {
                    e.classList.remove("active")
                }), m.classList.add("pending"), v.classList.add("animate"), k[g].classList.add("active"), w = !0, setTimeout(function() {
                    v.classList.remove("active", "pending", "animate"), m.classList.add("active"), m.classList.remove("pending"), w = !1, b = setTimeout(M, h)
                }, f)
            }), document.addEventListener("click", function(e) {
                if (!e.target.matches(l) || w) return !1;
                clearTimeout(b), M()
            }), document.addEventListener("click", function(e) {
                if (!e.target.matches(d) || w) return !1;
                clearTimeout(b), O()
            }), L.init(x, function(e) {
                "left" != e.direction || w || (clearTimeout(b), M()), "right" != e.direction || w || (clearTimeout(b), O())
            })
        }
    }
}, function(e, t, i) {
    e.exports = function() {
        "use strict";
        var v = "undefined" == typeof document ? {
                body: {},
                addEventListener: function() {},
                removeEventListener: function() {},
                activeElement: {
                    blur: function() {},
                    nodeName: ""
                },
                querySelector: function() {
                    return null
                },
                querySelectorAll: function() {
                    return []
                },
                getElementById: function() {
                    return null
                },
                createEvent: function() {
                    return {
                        initEvent: function() {}
                    }
                },
                createElement: function() {
                    return {
                        children: [],
                        childNodes: [],
                        style: {},
                        setAttribute: function() {},
                        getElementsByTagName: function() {
                            return []
                        }
                    }
                },
                location: {
                    hash: ""
                }
            } : document,
            B = "undefined" == typeof window ? {
                document: v,
                navigator: {
                    userAgent: ""
                },
                location: {},
                history: {},
                CustomEvent: function() {
                    return this
                },
                addEventListener: function() {},
                removeEventListener: function() {},
                getComputedStyle: function() {
                    return {
                        getPropertyValue: function() {
                            return ""
                        }
                    }
                },
                Image: function() {},
                Date: function() {},
                screen: {},
                setTimeout: function() {},
                clearTimeout: function() {}
            } : window,
            l = function(e) {
                for (var t = 0; t < e.length; t += 1) this[t] = e[t];
                return this.length = e.length, this
            };

        function O(e, t) {
            var i = [],
                n = 0;
            if (e && !t && e instanceof l) return e;
            if (e)
                if ("string" == typeof e) {
                    var a, r, s = e.trim();
                    if (0 <= s.indexOf("<") && 0 <= s.indexOf(">")) {
                        var o = "div";
                        for (0 === s.indexOf("<li") && (o = "ul"), 0 === s.indexOf("<tr") && (o = "tbody"), 0 !== s.indexOf("<td") && 0 !== s.indexOf("<th") || (o = "tr"), 0 === s.indexOf("<tbody") && (o = "table"), 0 === s.indexOf("<option") && (o = "select"), (r = v.createElement(o)).innerHTML = s, n = 0; n < r.childNodes.length; n += 1) i.push(r.childNodes[n])
                    } else
                        for (a = t || "#" !== e[0] || e.match(/[ .<>:~]/) ? (t || v).querySelectorAll(e.trim()) : [v.getElementById(e.trim().split("#")[1])], n = 0; n < a.length; n += 1) a[n] && i.push(a[n])
                } else if (e.nodeType || e === B || e === v) i.push(e);
            else if (0 < e.length && e[0].nodeType)
                for (n = 0; n < e.length; n += 1) i.push(e[n]);
            return new l(i)
        }

        function r(e) {
            for (var t = [], i = 0; i < e.length; i += 1) - 1 === t.indexOf(e[i]) && t.push(e[i]);
            return t
        }
        O.fn = l.prototype, O.Class = l, O.Dom7 = l;
        var t = {
            addClass: function(e) {
                if (void 0 === e) return this;
                for (var t = e.split(" "), i = 0; i < t.length; i += 1)
                    for (var n = 0; n < this.length; n += 1) void 0 !== this[n] && void 0 !== this[n].classList && this[n].classList.add(t[i]);
                return this
            },
            removeClass: function(e) {
                for (var t = e.split(" "), i = 0; i < t.length; i += 1)
                    for (var n = 0; n < this.length; n += 1) void 0 !== this[n] && void 0 !== this[n].classList && this[n].classList.remove(t[i]);
                return this
            },
            hasClass: function(e) {
                return !!this[0] && this[0].classList.contains(e)
            },
            toggleClass: function(e) {
                for (var t = e.split(" "), i = 0; i < t.length; i += 1)
                    for (var n = 0; n < this.length; n += 1) void 0 !== this[n] && void 0 !== this[n].classList && this[n].classList.toggle(t[i]);
                return this
            },
            attr: function(e, t) {
                var i = arguments;
                if (1 === arguments.length && "string" == typeof e) return this[0] ? this[0].getAttribute(e) : void 0;
                for (var n = 0; n < this.length; n += 1)
                    if (2 === i.length) this[n].setAttribute(e, t);
                    else
                        for (var a in e) this[n][a] = e[a], this[n].setAttribute(a, e[a]);
                return this
            },
            removeAttr: function(e) {
                for (var t = 0; t < this.length; t += 1) this[t].removeAttribute(e);
                return this
            },
            data: function(e, t) {
                var i;
                if (void 0 !== t) {
                    for (var n = 0; n < this.length; n += 1)(i = this[n]).dom7ElementDataStorage || (i.dom7ElementDataStorage = {}), i.dom7ElementDataStorage[e] = t;
                    return this
                }
                if (i = this[0]) {
                    if (i.dom7ElementDataStorage && e in i.dom7ElementDataStorage) return i.dom7ElementDataStorage[e];
                    var a = i.getAttribute("data-" + e);
                    return a || void 0
                }
            },
            transform: function(e) {
                for (var t = 0; t < this.length; t += 1) {
                    var i = this[t].style;
                    i.webkitTransform = e, i.transform = e
                }
                return this
            },
            transition: function(e) {
                "string" != typeof e && (e += "ms");
                for (var t = 0; t < this.length; t += 1) {
                    var i = this[t].style;
                    i.webkitTransitionDuration = e, i.transitionDuration = e
                }
                return this
            },
            on: function() {
                for (var e, t = [], i = arguments.length; i--;) t[i] = arguments[i];
                var n = t[0],
                    r = t[1],
                    s = t[2],
                    a = t[3];

                function o(e) {
                    var t = e.target;
                    if (t) {
                        var i = e.target.dom7EventData || [];
                        if (i.indexOf(e) < 0 && i.unshift(e), O(t).is(r)) s.apply(t, i);
                        else
                            for (var n = O(t).parents(), a = 0; a < n.length; a += 1) O(n[a]).is(r) && s.apply(n[a], i)
                    }
                }

                function l(e) {
                    var t = e && e.target && e.target.dom7EventData || [];
                    t.indexOf(e) < 0 && t.unshift(e), s.apply(this, t)
                }
                "function" == typeof t[1] && (n = (e = t)[0], s = e[1], a = e[2], r = void 0), a || (a = !1);
                for (var c, d = n.split(" "), u = 0; u < this.length; u += 1) {
                    var h = this[u];
                    if (r)
                        for (c = 0; c < d.length; c += 1) {
                            var p = d[c];
                            h.dom7LiveListeners || (h.dom7LiveListeners = {}), h.dom7LiveListeners[p] || (h.dom7LiveListeners[p] = []), h.dom7LiveListeners[p].push({
                                listener: s,
                                proxyListener: o
                            }), h.addEventListener(p, o, a)
                        } else
                            for (c = 0; c < d.length; c += 1) {
                                var f = d[c];
                                h.dom7Listeners || (h.dom7Listeners = {}), h.dom7Listeners[f] || (h.dom7Listeners[f] = []), h.dom7Listeners[f].push({
                                    listener: s,
                                    proxyListener: l
                                }), h.addEventListener(f, l, a)
                            }
                }
                return this
            },
            off: function() {
                for (var e, t = [], i = arguments.length; i--;) t[i] = arguments[i];
                var n = t[0],
                    a = t[1],
                    r = t[2],
                    s = t[3];
                "function" == typeof t[1] && (n = (e = t)[0], r = e[1], s = e[2], a = void 0), s || (s = !1);
                for (var o = n.split(" "), l = 0; l < o.length; l += 1)
                    for (var c = o[l], d = 0; d < this.length; d += 1) {
                        var u = this[d],
                            h = void 0;
                        if (!a && u.dom7Listeners ? h = u.dom7Listeners[c] : a && u.dom7LiveListeners && (h = u.dom7LiveListeners[c]), h && h.length)
                            for (var p = h.length - 1; 0 <= p; p -= 1) {
                                var f = h[p];
                                r && f.listener === r ? (u.removeEventListener(c, f.proxyListener, s), h.splice(p, 1)) : r || (u.removeEventListener(c, f.proxyListener, s), h.splice(p, 1))
                            }
                    }
                return this
            },
            trigger: function() {
                for (var e = [], t = arguments.length; t--;) e[t] = arguments[t];
                for (var i = e[0].split(" "), n = e[1], a = 0; a < i.length; a += 1)
                    for (var r = i[a], s = 0; s < this.length; s += 1) {
                        var o = this[s],
                            l = void 0;
                        try {
                            l = new B.CustomEvent(r, {
                                detail: n,
                                bubbles: !0,
                                cancelable: !0
                            })
                        } catch (e) {
                            (l = v.createEvent("Event")).initEvent(r, !0, !0), l.detail = n
                        }
                        o.dom7EventData = e.filter(function(e, t) {
                            return 0 < t
                        }), o.dispatchEvent(l), o.dom7EventData = [], delete o.dom7EventData
                    }
                return this
            },
            transitionEnd: function(t) {
                var i, n = ["webkitTransitionEnd", "transitionend"],
                    a = this;

                function r(e) {
                    if (e.target === this)
                        for (t.call(this, e), i = 0; i < n.length; i += 1) a.off(n[i], r)
                }
                if (t)
                    for (i = 0; i < n.length; i += 1) a.on(n[i], r);
                return this
            },
            outerWidth: function(e) {
                if (0 < this.length) {
                    if (e) {
                        var t = this.styles();
                        return this[0].offsetWidth + parseFloat(t.getPropertyValue("margin-right")) + parseFloat(t.getPropertyValue("margin-left"))
                    }
                    return this[0].offsetWidth
                }
                return null
            },
            outerHeight: function(e) {
                if (0 < this.length) {
                    if (e) {
                        var t = this.styles();
                        return this[0].offsetHeight + parseFloat(t.getPropertyValue("margin-top")) + parseFloat(t.getPropertyValue("margin-bottom"))
                    }
                    return this[0].offsetHeight
                }
                return null
            },
            offset: function() {
                if (0 < this.length) {
                    var e = this[0],
                        t = e.getBoundingClientRect(),
                        i = v.body,
                        n = e.clientTop || i.clientTop || 0,
                        a = e.clientLeft || i.clientLeft || 0,
                        r = e === B ? B.scrollY : e.scrollTop,
                        s = e === B ? B.scrollX : e.scrollLeft;
                    return {
                        top: t.top + r - n,
                        left: t.left + s - a
                    }
                }
                return null
            },
            css: function(e, t) {
                var i;
                if (1 === arguments.length) {
                    if ("string" != typeof e) {
                        for (i = 0; i < this.length; i += 1)
                            for (var n in e) this[i].style[n] = e[n];
                        return this
                    }
                    if (this[0]) return B.getComputedStyle(this[0], null).getPropertyValue(e)
                }
                if (2 !== arguments.length || "string" != typeof e) return this;
                for (i = 0; i < this.length; i += 1) this[i].style[e] = t;
                return this
            },
            each: function(e) {
                if (!e) return this;
                for (var t = 0; t < this.length; t += 1)
                    if (!1 === e.call(this[t], t, this[t])) return this;
                return this
            },
            html: function(e) {
                if (void 0 === e) return this[0] ? this[0].innerHTML : void 0;
                for (var t = 0; t < this.length; t += 1) this[t].innerHTML = e;
                return this
            },
            text: function(e) {
                if (void 0 === e) return this[0] ? this[0].textContent.trim() : null;
                for (var t = 0; t < this.length; t += 1) this[t].textContent = e;
                return this
            },
            is: function(e) {
                var t, i, n = this[0];
                if (!n || void 0 === e) return !1;
                if ("string" == typeof e) {
                    if (n.matches) return n.matches(e);
                    if (n.webkitMatchesSelector) return n.webkitMatchesSelector(e);
                    if (n.msMatchesSelector) return n.msMatchesSelector(e);
                    for (t = O(e), i = 0; i < t.length; i += 1)
                        if (t[i] === n) return !0;
                    return !1
                }
                if (e === v) return n === v;
                if (e === B) return n === B;
                if (e.nodeType || e instanceof l) {
                    for (t = e.nodeType ? [e] : e, i = 0; i < t.length; i += 1)
                        if (t[i] === n) return !0;
                    return !1
                }
                return !1
            },
            index: function() {
                var e, t = this[0];
                if (t) {
                    for (e = 0; null !== (t = t.previousSibling);) 1 === t.nodeType && (e += 1);
                    return e
                }
            },
            eq: function(e) {
                if (void 0 === e) return this;
                var t, i = this.length;
                return new l(i - 1 < e ? [] : e < 0 ? (t = i + e) < 0 ? [] : [this[t]] : [this[e]])
            },
            append: function() {
                for (var e, t = [], i = arguments.length; i--;) t[i] = arguments[i];
                for (var n = 0; n < t.length; n += 1) {
                    e = t[n];
                    for (var a = 0; a < this.length; a += 1)
                        if ("string" == typeof e) {
                            var r = v.createElement("div");
                            for (r.innerHTML = e; r.firstChild;) this[a].appendChild(r.firstChild)
                        } else if (e instanceof l)
                        for (var s = 0; s < e.length; s += 1) this[a].appendChild(e[s]);
                    else this[a].appendChild(e)
                }
                return this
            },
            prepend: function(e) {
                var t, i;
                for (t = 0; t < this.length; t += 1)
                    if ("string" == typeof e) {
                        var n = v.createElement("div");
                        for (n.innerHTML = e, i = n.childNodes.length - 1; 0 <= i; i -= 1) this[t].insertBefore(n.childNodes[i], this[t].childNodes[0])
                    } else if (e instanceof l)
                    for (i = 0; i < e.length; i += 1) this[t].insertBefore(e[i], this[t].childNodes[0]);
                else this[t].insertBefore(e, this[t].childNodes[0]);
                return this
            },
            next: function(e) {
                return 0 < this.length ? e ? this[0].nextElementSibling && O(this[0].nextElementSibling).is(e) ? new l([this[0].nextElementSibling]) : new l([]) : this[0].nextElementSibling ? new l([this[0].nextElementSibling]) : new l([]) : new l([])
            },
            nextAll: function(e) {
                var t = [],
                    i = this[0];
                if (!i) return new l([]);
                for (; i.nextElementSibling;) {
                    var n = i.nextElementSibling;
                    e ? O(n).is(e) && t.push(n) : t.push(n), i = n
                }
                return new l(t)
            },
            prev: function(e) {
                if (0 < this.length) {
                    var t = this[0];
                    return e ? t.previousElementSibling && O(t.previousElementSibling).is(e) ? new l([t.previousElementSibling]) : new l([]) : t.previousElementSibling ? new l([t.previousElementSibling]) : new l([])
                }
                return new l([])
            },
            prevAll: function(e) {
                var t = [],
                    i = this[0];
                if (!i) return new l([]);
                for (; i.previousElementSibling;) {
                    var n = i.previousElementSibling;
                    e ? O(n).is(e) && t.push(n) : t.push(n), i = n
                }
                return new l(t)
            },
            parent: function(e) {
                for (var t = [], i = 0; i < this.length; i += 1) null !== this[i].parentNode && (e ? O(this[i].parentNode).is(e) && t.push(this[i].parentNode) : t.push(this[i].parentNode));
                return O(r(t))
            },
            parents: function(e) {
                for (var t = [], i = 0; i < this.length; i += 1)
                    for (var n = this[i].parentNode; n;) e ? O(n).is(e) && t.push(n) : t.push(n), n = n.parentNode;
                return O(r(t))
            },
            closest: function(e) {
                var t = this;
                return void 0 === e ? new l([]) : (t.is(e) || (t = t.parents(e).eq(0)), t)
            },
            find: function(e) {
                for (var t = [], i = 0; i < this.length; i += 1)
                    for (var n = this[i].querySelectorAll(e), a = 0; a < n.length; a += 1) t.push(n[a]);
                return new l(t)
            },
            children: function(e) {
                for (var t = [], i = 0; i < this.length; i += 1)
                    for (var n = this[i].childNodes, a = 0; a < n.length; a += 1) e ? 1 === n[a].nodeType && O(n[a]).is(e) && t.push(n[a]) : 1 === n[a].nodeType && t.push(n[a]);
                return new l(r(t))
            },
            remove: function() {
                for (var e = 0; e < this.length; e += 1) this[e].parentNode && this[e].parentNode.removeChild(this[e]);
                return this
            },
            add: function() {
                for (var e, t, i = [], n = arguments.length; n--;) i[n] = arguments[n];
                for (e = 0; e < i.length; e += 1) {
                    var a = O(i[e]);
                    for (t = 0; t < a.length; t += 1) this[this.length] = a[t], this.length += 1
                }
                return this
            },
            styles: function() {
                return this[0] ? B.getComputedStyle(this[0], null) : {}
            }
        };
        Object.keys(t).forEach(function(e) {
            O.fn[e] = t[e]
        });
        var e, i, n, $ = {
                deleteProps: function(e) {
                    var t = e;
                    Object.keys(t).forEach(function(e) {
                        try {
                            t[e] = null
                        } catch (e) {}
                        try {
                            delete t[e]
                        } catch (e) {}
                    })
                },
                nextTick: function(e, t) {
                    return void 0 === t && (t = 0), setTimeout(e, t)
                },
                now: function() {
                    return Date.now()
                },
                getTranslate: function(e, t) {
                    var i, n, a;
                    void 0 === t && (t = "x");
                    var r = B.getComputedStyle(e, null);
                    return B.WebKitCSSMatrix ? (6 < (n = r.transform || r.webkitTransform).split(",").length && (n = n.split(", ").map(function(e) {
                        return e.replace(",", ".")
                    }).join(", ")), a = new B.WebKitCSSMatrix("none" === n ? "" : n)) : (a = r.MozTransform || r.OTransform || r.MsTransform || r.msTransform || r.transform || r.getPropertyValue("transform").replace("translate(", "matrix(1, 0, 0, 1,"), i = a.toString().split(",")), "x" === t && (n = B.WebKitCSSMatrix ? a.m41 : 16 === i.length ? parseFloat(i[12]) : parseFloat(i[4])), "y" === t && (n = B.WebKitCSSMatrix ? a.m42 : 16 === i.length ? parseFloat(i[13]) : parseFloat(i[5])), n || 0
                },
                parseUrlQuery: function(e) {
                    var t, i, n, a, r = {},
                        s = e || B.location.href;
                    if ("string" == typeof s && s.length)
                        for (s = -1 < s.indexOf("?") ? s.replace(/\S*\?/, "") : "", i = s.split("&").filter(function(e) {
                                return "" !== e
                            }), a = i.length, t = 0; t < a; t += 1) n = i[t].replace(/#\S+/g, "").split("="), r[decodeURIComponent(n[0])] = void 0 === n[1] ? void 0 : decodeURIComponent(n[1]) || "";
                    return r
                },
                isObject: function(e) {
                    return "object" == typeof e && null !== e && e.constructor && e.constructor === Object
                },
                extend: function() {
                    for (var e = [], t = arguments.length; t--;) e[t] = arguments[t];
                    for (var i = Object(e[0]), n = 1; n < e.length; n += 1) {
                        var a = e[n];
                        if (null != a)
                            for (var r = Object.keys(Object(a)), s = 0, o = r.length; s < o; s += 1) {
                                var l = r[s],
                                    c = Object.getOwnPropertyDescriptor(a, l);
                                void 0 !== c && c.enumerable && ($.isObject(i[l]) && $.isObject(a[l]) ? $.extend(i[l], a[l]) : !$.isObject(i[l]) && $.isObject(a[l]) ? (i[l] = {}, $.extend(i[l], a[l])) : i[l] = a[l])
                            }
                    }
                    return i
                }
            },
            q = (n = v.createElement("div"), {
                touch: B.Modernizr && !0 === B.Modernizr.touch || !!("ontouchstart" in B || B.DocumentTouch && v instanceof B.DocumentTouch),
                pointerEvents: !!(B.navigator.pointerEnabled || B.PointerEvent || "maxTouchPoints" in B.navigator),
                prefixedPointerEvents: !!B.navigator.msPointerEnabled,
                transition: (i = n.style, "transition" in i || "webkitTransition" in i || "MozTransition" in i),
                transforms3d: B.Modernizr && !0 === B.Modernizr.csstransforms3d || (e = n.style, "webkitPerspective" in e || "MozPerspective" in e || "OPerspective" in e || "MsPerspective" in e || "perspective" in e),
                flexbox: function() {
                    for (var e = n.style, t = "alignItems webkitAlignItems webkitBoxAlign msFlexAlign mozBoxAlign webkitFlexDirection msFlexDirection mozBoxDirection mozBoxOrient webkitBoxDirection webkitBoxOrient".split(" "), i = 0; i < t.length; i += 1)
                        if (t[i] in e) return !0;
                    return !1
                }(),
                observer: "MutationObserver" in B || "WebkitMutationObserver" in B,
                passiveListener: function() {
                    var e = !1;
                    try {
                        var t = Object.defineProperty({}, "passive", {
                            get: function() {
                                e = !0
                            }
                        });
                        B.addEventListener("testPassiveListener", null, t)
                    } catch (e) {}
                    return e
                }(),
                gestures: "ongesturestart" in B
            }),
            a = function(e) {
                void 0 === e && (e = {});
                var t = this;
                t.params = e, t.eventsListeners = {}, t.params && t.params.on && Object.keys(t.params.on).forEach(function(e) {
                    t.on(e, t.params.on[e])
                })
            },
            s = {
                components: {
                    configurable: !0
                }
            };
        a.prototype.on = function(e, t, i) {
            var n = this;
            if ("function" != typeof t) return n;
            var a = i ? "unshift" : "push";
            return e.split(" ").forEach(function(e) {
                n.eventsListeners[e] || (n.eventsListeners[e] = []), n.eventsListeners[e][a](t)
            }), n
        }, a.prototype.once = function(n, a, e) {
            var r = this;
            return "function" != typeof a ? r : r.on(n, function e() {
                for (var t = [], i = arguments.length; i--;) t[i] = arguments[i];
                a.apply(r, t), r.off(n, e)
            }, e)
        }, a.prototype.off = function(e, n) {
            var a = this;
            return a.eventsListeners && e.split(" ").forEach(function(i) {
                void 0 === n ? a.eventsListeners[i] = [] : a.eventsListeners[i] && a.eventsListeners[i].length && a.eventsListeners[i].forEach(function(e, t) {
                    e === n && a.eventsListeners[i].splice(t, 1)
                })
            }), a
        }, a.prototype.emit = function() {
            for (var e = [], t = arguments.length; t--;) e[t] = arguments[t];
            var i, n, a, r = this;
            if (!r.eventsListeners) return r;
            a = "string" == typeof e[0] || Array.isArray(e[0]) ? (i = e[0], n = e.slice(1, e.length), r) : (i = e[0].events, n = e[0].data, e[0].context || r);
            var s = Array.isArray(i) ? i : i.split(" ");
            return s.forEach(function(e) {
                if (r.eventsListeners && r.eventsListeners[e]) {
                    var t = [];
                    r.eventsListeners[e].forEach(function(e) {
                        t.push(e)
                    }), t.forEach(function(e) {
                        e.apply(a, n)
                    })
                }
            }), r
        }, a.prototype.useModulesParams = function(i) {
            var n = this;
            n.modules && Object.keys(n.modules).forEach(function(e) {
                var t = n.modules[e];
                t.params && $.extend(i, t.params)
            })
        }, a.prototype.useModules = function(n) {
            void 0 === n && (n = {});
            var a = this;
            a.modules && Object.keys(a.modules).forEach(function(e) {
                var i = a.modules[e],
                    t = n[e] || {};
                i.instance && Object.keys(i.instance).forEach(function(e) {
                    var t = i.instance[e];
                    a[e] = "function" == typeof t ? t.bind(a) : t
                }), i.on && a.on && Object.keys(i.on).forEach(function(e) {
                    a.on(e, i.on[e])
                }), i.create && i.create.bind(a)(t)
            })
        }, s.components.set = function(e) {
            this.use && this.use(e)
        }, a.installModule = function(t) {
            for (var e = [], i = arguments.length - 1; 0 < i--;) e[i] = arguments[i + 1];
            var n = this;
            n.prototype.modules || (n.prototype.modules = {});
            var a = t.name || Object.keys(n.prototype.modules).length + "_" + $.now();
            return (n.prototype.modules[a] = t).proto && Object.keys(t.proto).forEach(function(e) {
                n.prototype[e] = t.proto[e]
            }), t.static && Object.keys(t.static).forEach(function(e) {
                n[e] = t.static[e]
            }), t.install && t.install.apply(n, e), n
        }, a.use = function(e) {
            for (var t = [], i = arguments.length - 1; 0 < i--;) t[i] = arguments[i + 1];
            var n = this;
            return Array.isArray(e) ? (e.forEach(function(e) {
                return n.installModule(e)
            }), n) : n.installModule.apply(n, [e].concat(t))
        }, Object.defineProperties(a, s);
        var o = {
                updateSize: function() {
                    var e, t, i = this,
                        n = i.$el;
                    e = void 0 !== i.params.width ? i.params.width : n[0].clientWidth, t = void 0 !== i.params.height ? i.params.height : n[0].clientHeight, 0 === e && i.isHorizontal() || 0 === t && i.isVertical() || (e = e - parseInt(n.css("padding-left"), 10) - parseInt(n.css("padding-right"), 10), t = t - parseInt(n.css("padding-top"), 10) - parseInt(n.css("padding-bottom"), 10), $.extend(i, {
                        width: e,
                        height: t,
                        size: i.isHorizontal() ? e : t
                    }))
                },
                updateSlides: function() {
                    var e = this,
                        t = e.params,
                        i = e.$wrapperEl,
                        n = e.size,
                        a = e.rtlTranslate,
                        r = e.wrongRTL,
                        s = e.virtual && t.virtual.enabled,
                        o = s ? e.virtual.slides.length : e.slides.length,
                        l = i.children("." + e.params.slideClass),
                        c = s ? e.virtual.slides.length : l.length,
                        d = [],
                        u = [],
                        h = [],
                        p = t.slidesOffsetBefore;
                    "function" == typeof p && (p = t.slidesOffsetBefore.call(e));
                    var f = t.slidesOffsetAfter;
                    "function" == typeof f && (f = t.slidesOffsetAfter.call(e));
                    var v, m, g = e.snapGrid.length,
                        y = e.snapGrid.length,
                        b = t.spaceBetween,
                        w = -p,
                        E = 0,
                        x = 0;
                    if (void 0 !== n) {
                        "string" == typeof b && 0 <= b.indexOf("%") && (b = parseFloat(b.replace("%", "")) / 100 * n), e.virtualSize = -b, a ? l.css({
                            marginLeft: "",
                            marginTop: ""
                        }) : l.css({
                            marginRight: "",
                            marginBottom: ""
                        }), 1 < t.slidesPerColumn && (v = Math.floor(c / t.slidesPerColumn) === c / e.params.slidesPerColumn ? c : Math.ceil(c / t.slidesPerColumn) * t.slidesPerColumn, "auto" !== t.slidesPerView && "row" === t.slidesPerColumnFill && (v = Math.max(v, t.slidesPerView * t.slidesPerColumn)));
                        for (var S, C = t.slidesPerColumn, k = v / C, T = k - (t.slidesPerColumn * k - c), _ = 0; _ < c; _ += 1) {
                            m = 0;
                            var L = l.eq(_);
                            if (1 < t.slidesPerColumn) {
                                var I = void 0,
                                    M = void 0,
                                    O = void 0;
                                "column" === t.slidesPerColumnFill ? (M = Math.floor(_ / C), O = _ - M * C, (T < M || M === T && O === C - 1) && C <= (O += 1) && (O = 0, M += 1), I = M + O * v / C, L.css({
                                    "-webkit-box-ordinal-group": I,
                                    "-moz-box-ordinal-group": I,
                                    "-ms-flex-order": I,
                                    "-webkit-order": I,
                                    order: I
                                })) : (O = Math.floor(_ / k), M = _ - O * k), L.css("margin-" + (e.isHorizontal() ? "top" : "left"), 0 !== O && t.spaceBetween && t.spaceBetween + "px").attr("data-swiper-column", M).attr("data-swiper-row", O)
                            }
                            if ("none" !== L.css("display")) {
                                if ("auto" === t.slidesPerView) {
                                    var D = B.getComputedStyle(L[0], null),
                                        P = L[0].style.transform,
                                        A = L[0].style.webkitTransform;
                                    P && (L[0].style.transform = "none"), A && (L[0].style.webkitTransform = "none"), m = t.roundLengths ? e.isHorizontal() ? L.outerWidth(!0) : L.outerHeight(!0) : e.isHorizontal() ? parseFloat(D.getPropertyValue("width")) + parseFloat(D.getPropertyValue("margin-left")) + parseFloat(D.getPropertyValue("margin-right")) : parseFloat(D.getPropertyValue("height")) + parseFloat(D.getPropertyValue("margin-top")) + parseFloat(D.getPropertyValue("margin-bottom")), P && (L[0].style.transform = P), A && (L[0].style.webkitTransform = A), t.roundLengths && (m = Math.floor(m))
                                } else m = (n - (t.slidesPerView - 1) * b) / t.slidesPerView, t.roundLengths && (m = Math.floor(m)), l[_] && (e.isHorizontal() ? l[_].style.width = m + "px" : l[_].style.height = m + "px");
                                l[_] && (l[_].swiperSlideSize = m), h.push(m), t.centeredSlides ? (w = w + m / 2 + E / 2 + b, 0 === E && 0 !== _ && (w = w - n / 2 - b), 0 === _ && (w = w - n / 2 - b), Math.abs(w) < .001 && (w = 0), t.roundLengths && (w = Math.floor(w)), x % t.slidesPerGroup == 0 && d.push(w), u.push(w)) : (t.roundLengths && (w = Math.floor(w)), x % t.slidesPerGroup == 0 && d.push(w), u.push(w), w = w + m + b), e.virtualSize += m + b, E = m, x += 1
                            }
                        }
                        if (e.virtualSize = Math.max(e.virtualSize, n) + f, a && r && ("slide" === t.effect || "coverflow" === t.effect) && i.css({
                                width: e.virtualSize + t.spaceBetween + "px"
                            }), q.flexbox && !t.setWrapperSize || (e.isHorizontal() ? i.css({
                                width: e.virtualSize + t.spaceBetween + "px"
                            }) : i.css({
                                height: e.virtualSize + t.spaceBetween + "px"
                            })), 1 < t.slidesPerColumn && (e.virtualSize = (m + t.spaceBetween) * v, e.virtualSize = Math.ceil(e.virtualSize / t.slidesPerColumn) - t.spaceBetween, e.isHorizontal() ? i.css({
                                width: e.virtualSize + t.spaceBetween + "px"
                            }) : i.css({
                                height: e.virtualSize + t.spaceBetween + "px"
                            }), t.centeredSlides)) {
                            S = [];
                            for (var F = 0; F < d.length; F += 1) {
                                var z = d[F];
                                t.roundLengths && (z = Math.floor(z)), d[F] < e.virtualSize + d[0] && S.push(z)
                            }
                            d = S
                        }
                        if (!t.centeredSlides) {
                            S = [];
                            for (var N = 0; N < d.length; N += 1) {
                                var j = d[N];
                                t.roundLengths && (j = Math.floor(j)), d[N] <= e.virtualSize - n && S.push(j)
                            }
                            d = S, 1 < Math.floor(e.virtualSize - n) - Math.floor(d[d.length - 1]) && d.push(e.virtualSize - n)
                        }
                        if (0 === d.length && (d = [0]), 0 !== t.spaceBetween && (e.isHorizontal() ? a ? l.css({
                                marginLeft: b + "px"
                            }) : l.css({
                                marginRight: b + "px"
                            }) : l.css({
                                marginBottom: b + "px"
                            })), t.centerInsufficientSlides) {
                            var R = 0;
                            if (h.forEach(function(e) {
                                    R += e + (t.spaceBetween ? t.spaceBetween : 0)
                                }), (R -= t.spaceBetween) < n) {
                                var H = (n - R) / 2;
                                d.forEach(function(e, t) {
                                    d[t] = e - H
                                }), u.forEach(function(e, t) {
                                    u[t] = e + H
                                })
                            }
                        }
                        $.extend(e, {
                            slides: l,
                            snapGrid: d,
                            slidesGrid: u,
                            slidesSizesGrid: h
                        }), c !== o && e.emit("slidesLengthChange"), d.length !== g && (e.params.watchOverflow && e.checkOverflow(), e.emit("snapGridLengthChange")), u.length !== y && e.emit("slidesGridLengthChange"), (t.watchSlidesProgress || t.watchSlidesVisibility) && e.updateSlidesOffset()
                    }
                },
                updateAutoHeight: function(e) {
                    var t, i = this,
                        n = [],
                        a = 0;
                    if ("number" == typeof e ? i.setTransition(e) : !0 === e && i.setTransition(i.params.speed), "auto" !== i.params.slidesPerView && 1 < i.params.slidesPerView)
                        for (t = 0; t < Math.ceil(i.params.slidesPerView); t += 1) {
                            var r = i.activeIndex + t;
                            if (r > i.slides.length) break;
                            n.push(i.slides.eq(r)[0])
                        } else n.push(i.slides.eq(i.activeIndex)[0]);
                    for (t = 0; t < n.length; t += 1)
                        if (void 0 !== n[t]) {
                            var s = n[t].offsetHeight;
                            a = a < s ? s : a
                        } a && i.$wrapperEl.css("height", a + "px")
                },
                updateSlidesOffset: function() {
                    for (var e = this.slides, t = 0; t < e.length; t += 1) e[t].swiperSlideOffset = this.isHorizontal() ? e[t].offsetLeft : e[t].offsetTop
                },
                updateSlidesProgress: function(e) {
                    void 0 === e && (e = this && this.translate || 0);
                    var t = this,
                        i = t.params,
                        n = t.slides,
                        a = t.rtlTranslate;
                    if (0 !== n.length) {
                        void 0 === n[0].swiperSlideOffset && t.updateSlidesOffset();
                        var r = -e;
                        a && (r = e), n.removeClass(i.slideVisibleClass), t.visibleSlidesIndexes = [], t.visibleSlides = [];
                        for (var s = 0; s < n.length; s += 1) {
                            var o = n[s],
                                l = (r + (i.centeredSlides ? t.minTranslate() : 0) - o.swiperSlideOffset) / (o.swiperSlideSize + i.spaceBetween);
                            if (i.watchSlidesVisibility) {
                                var c = -(r - o.swiperSlideOffset),
                                    d = c + t.slidesSizesGrid[s],
                                    u = 0 <= c && c < t.size || 0 < d && d <= t.size || c <= 0 && d >= t.size;
                                u && (t.visibleSlides.push(o), t.visibleSlidesIndexes.push(s), n.eq(s).addClass(i.slideVisibleClass))
                            }
                            o.progress = a ? -l : l
                        }
                        t.visibleSlides = O(t.visibleSlides)
                    }
                },
                updateProgress: function(e) {
                    void 0 === e && (e = this && this.translate || 0);
                    var t = this,
                        i = t.params,
                        n = t.maxTranslate() - t.minTranslate(),
                        a = t.progress,
                        r = t.isBeginning,
                        s = t.isEnd,
                        o = r,
                        l = s;
                    s = 0 === n ? r = !(a = 0) : (a = (e - t.minTranslate()) / n, r = a <= 0, 1 <= a), $.extend(t, {
                        progress: a,
                        isBeginning: r,
                        isEnd: s
                    }), (i.watchSlidesProgress || i.watchSlidesVisibility) && t.updateSlidesProgress(e), r && !o && t.emit("reachBeginning toEdge"), s && !l && t.emit("reachEnd toEdge"), (o && !r || l && !s) && t.emit("fromEdge"), t.emit("progress", a)
                },
                updateSlidesClasses: function() {
                    var e, t = this,
                        i = t.slides,
                        n = t.params,
                        a = t.$wrapperEl,
                        r = t.activeIndex,
                        s = t.realIndex,
                        o = t.virtual && n.virtual.enabled;
                    i.removeClass(n.slideActiveClass + " " + n.slideNextClass + " " + n.slidePrevClass + " " + n.slideDuplicateActiveClass + " " + n.slideDuplicateNextClass + " " + n.slideDuplicatePrevClass), (e = o ? t.$wrapperEl.find("." + n.slideClass + '[data-swiper-slide-index="' + r + '"]') : i.eq(r)).addClass(n.slideActiveClass), n.loop && (e.hasClass(n.slideDuplicateClass) ? a.children("." + n.slideClass + ":not(." + n.slideDuplicateClass + ')[data-swiper-slide-index="' + s + '"]').addClass(n.slideDuplicateActiveClass) : a.children("." + n.slideClass + "." + n.slideDuplicateClass + '[data-swiper-slide-index="' + s + '"]').addClass(n.slideDuplicateActiveClass));
                    var l = e.nextAll("." + n.slideClass).eq(0).addClass(n.slideNextClass);
                    n.loop && 0 === l.length && (l = i.eq(0)).addClass(n.slideNextClass);
                    var c = e.prevAll("." + n.slideClass).eq(0).addClass(n.slidePrevClass);
                    n.loop && 0 === c.length && (c = i.eq(-1)).addClass(n.slidePrevClass), n.loop && (l.hasClass(n.slideDuplicateClass) ? a.children("." + n.slideClass + ":not(." + n.slideDuplicateClass + ')[data-swiper-slide-index="' + l.attr("data-swiper-slide-index") + '"]').addClass(n.slideDuplicateNextClass) : a.children("." + n.slideClass + "." + n.slideDuplicateClass + '[data-swiper-slide-index="' + l.attr("data-swiper-slide-index") + '"]').addClass(n.slideDuplicateNextClass), c.hasClass(n.slideDuplicateClass) ? a.children("." + n.slideClass + ":not(." + n.slideDuplicateClass + ')[data-swiper-slide-index="' + c.attr("data-swiper-slide-index") + '"]').addClass(n.slideDuplicatePrevClass) : a.children("." + n.slideClass + "." + n.slideDuplicateClass + '[data-swiper-slide-index="' + c.attr("data-swiper-slide-index") + '"]').addClass(n.slideDuplicatePrevClass))
                },
                updateActiveIndex: function(e) {
                    var t, i = this,
                        n = i.rtlTranslate ? i.translate : -i.translate,
                        a = i.slidesGrid,
                        r = i.snapGrid,
                        s = i.params,
                        o = i.activeIndex,
                        l = i.realIndex,
                        c = i.snapIndex,
                        d = e;
                    if (void 0 === d) {
                        for (var u = 0; u < a.length; u += 1) void 0 !== a[u + 1] ? n >= a[u] && n < a[u + 1] - (a[u + 1] - a[u]) / 2 ? d = u : n >= a[u] && n < a[u + 1] && (d = u + 1) : n >= a[u] && (d = u);
                        s.normalizeSlideIndex && (d < 0 || void 0 === d) && (d = 0)
                    }
                    if ((t = 0 <= r.indexOf(n) ? r.indexOf(n) : Math.floor(d / s.slidesPerGroup)) >= r.length && (t = r.length - 1), d !== o) {
                        var h = parseInt(i.slides.eq(d).attr("data-swiper-slide-index") || d, 10);
                        $.extend(i, {
                            snapIndex: t,
                            realIndex: h,
                            previousIndex: o,
                            activeIndex: d
                        }), i.emit("activeIndexChange"), i.emit("snapIndexChange"), l !== h && i.emit("realIndexChange"), i.emit("slideChange")
                    } else t !== c && (i.snapIndex = t, i.emit("snapIndexChange"))
                },
                updateClickedSlide: function(e) {
                    var t = this,
                        i = t.params,
                        n = O(e.target).closest("." + i.slideClass)[0],
                        a = !1;
                    if (n)
                        for (var r = 0; r < t.slides.length; r += 1) t.slides[r] === n && (a = !0);
                    if (!n || !a) return t.clickedSlide = void 0, void(t.clickedIndex = void 0);
                    t.clickedSlide = n, t.virtual && t.params.virtual.enabled ? t.clickedIndex = parseInt(O(n).attr("data-swiper-slide-index"), 10) : t.clickedIndex = O(n).index(), i.slideToClickedSlide && void 0 !== t.clickedIndex && t.clickedIndex !== t.activeIndex && t.slideToClickedSlide()
                }
            },
            c = {
                getTranslate: function(e) {
                    void 0 === e && (e = this.isHorizontal() ? "x" : "y");
                    var t = this.params,
                        i = this.rtlTranslate,
                        n = this.translate,
                        a = this.$wrapperEl;
                    if (t.virtualTranslate) return i ? -n : n;
                    var r = $.getTranslate(a[0], e);
                    return i && (r = -r), r || 0
                },
                setTranslate: function(e, t) {
                    var i = this,
                        n = i.rtlTranslate,
                        a = i.params,
                        r = i.$wrapperEl,
                        s = i.progress,
                        o = 0,
                        l = 0;
                    i.isHorizontal() ? o = n ? -e : e : l = e, a.roundLengths && (o = Math.floor(o), l = Math.floor(l)), a.virtualTranslate || (q.transforms3d ? r.transform("translate3d(" + o + "px, " + l + "px, 0px)") : r.transform("translate(" + o + "px, " + l + "px)")), i.previousTranslate = i.translate, i.translate = i.isHorizontal() ? o : l;
                    var c = i.maxTranslate() - i.minTranslate();
                    (0 === c ? 0 : (e - i.minTranslate()) / c) !== s && i.updateProgress(e), i.emit("setTranslate", i.translate, t)
                },
                minTranslate: function() {
                    return -this.snapGrid[0]
                },
                maxTranslate: function() {
                    return -this.snapGrid[this.snapGrid.length - 1]
                }
            },
            d = {
                setTransition: function(e, t) {
                    this.$wrapperEl.transition(e), this.emit("setTransition", e, t)
                },
                transitionStart: function(e, t) {
                    void 0 === e && (e = !0);
                    var i = this,
                        n = i.activeIndex,
                        a = i.params,
                        r = i.previousIndex;
                    a.autoHeight && i.updateAutoHeight();
                    var s = t;
                    if (s || (s = r < n ? "next" : n < r ? "prev" : "reset"), i.emit("transitionStart"), e && n !== r) {
                        if ("reset" === s) return void i.emit("slideResetTransitionStart");
                        i.emit("slideChangeTransitionStart"), "next" === s ? i.emit("slideNextTransitionStart") : i.emit("slidePrevTransitionStart")
                    }
                },
                transitionEnd: function(e, t) {
                    void 0 === e && (e = !0);
                    var i = this,
                        n = i.activeIndex,
                        a = i.previousIndex;
                    i.animating = !1, i.setTransition(0);
                    var r = t;
                    if (r || (r = a < n ? "next" : n < a ? "prev" : "reset"), i.emit("transitionEnd"), e && n !== a) {
                        if ("reset" === r) return void i.emit("slideResetTransitionEnd");
                        i.emit("slideChangeTransitionEnd"), "next" === r ? i.emit("slideNextTransitionEnd") : i.emit("slidePrevTransitionEnd")
                    }
                }
            },
            u = {
                slideTo: function(e, t, i, n) {
                    void 0 === e && (e = 0), void 0 === t && (t = this.params.speed), void 0 === i && (i = !0);
                    var a = this,
                        r = e;
                    r < 0 && (r = 0);
                    var s = a.params,
                        o = a.snapGrid,
                        l = a.slidesGrid,
                        c = a.previousIndex,
                        d = a.activeIndex,
                        u = a.rtlTranslate;
                    if (a.animating && s.preventInteractionOnTransition) return !1;
                    var h = Math.floor(r / s.slidesPerGroup);
                    h >= o.length && (h = o.length - 1), (d || s.initialSlide || 0) === (c || 0) && i && a.emit("beforeSlideChangeStart");
                    var p, f = -o[h];
                    if (a.updateProgress(f), s.normalizeSlideIndex)
                        for (var v = 0; v < l.length; v += 1) - Math.floor(100 * f) >= Math.floor(100 * l[v]) && (r = v);
                    if (a.initialized && r !== d) {
                        if (!a.allowSlideNext && f < a.translate && f < a.minTranslate()) return !1;
                        if (!a.allowSlidePrev && f > a.translate && f > a.maxTranslate() && (d || 0) !== r) return !1
                    }
                    return p = d < r ? "next" : r < d ? "prev" : "reset", u && -f === a.translate || !u && f === a.translate ? (a.updateActiveIndex(r), s.autoHeight && a.updateAutoHeight(), a.updateSlidesClasses(), "slide" !== s.effect && a.setTranslate(f), "reset" !== p && (a.transitionStart(i, p), a.transitionEnd(i, p)), !1) : (0 !== t && q.transition ? (a.setTransition(t), a.setTranslate(f), a.updateActiveIndex(r), a.updateSlidesClasses(), a.emit("beforeTransitionStart", t, n), a.transitionStart(i, p), a.animating || (a.animating = !0, a.onSlideToWrapperTransitionEnd || (a.onSlideToWrapperTransitionEnd = function(e) {
                        a && !a.destroyed && e.target === this && (a.$wrapperEl[0].removeEventListener("transitionend", a.onSlideToWrapperTransitionEnd), a.$wrapperEl[0].removeEventListener("webkitTransitionEnd", a.onSlideToWrapperTransitionEnd), a.onSlideToWrapperTransitionEnd = null, delete a.onSlideToWrapperTransitionEnd, a.transitionEnd(i, p))
                    }), a.$wrapperEl[0].addEventListener("transitionend", a.onSlideToWrapperTransitionEnd), a.$wrapperEl[0].addEventListener("webkitTransitionEnd", a.onSlideToWrapperTransitionEnd))) : (a.setTransition(0), a.setTranslate(f), a.updateActiveIndex(r), a.updateSlidesClasses(), a.emit("beforeTransitionStart", t, n), a.transitionStart(i, p), a.transitionEnd(i, p)), !0)
                },
                slideToLoop: function(e, t, i, n) {
                    void 0 === e && (e = 0), void 0 === t && (t = this.params.speed), void 0 === i && (i = !0);
                    var a = e;
                    return this.params.loop && (a += this.loopedSlides), this.slideTo(a, t, i, n)
                },
                slideNext: function(e, t, i) {
                    void 0 === e && (e = this.params.speed), void 0 === t && (t = !0);
                    var n = this,
                        a = n.params,
                        r = n.animating;
                    return a.loop ? !r && (n.loopFix(), n._clientLeft = n.$wrapperEl[0].clientLeft, n.slideTo(n.activeIndex + a.slidesPerGroup, e, t, i)) : n.slideTo(n.activeIndex + a.slidesPerGroup, e, t, i)
                },
                slidePrev: function(e, t, i) {
                    void 0 === e && (e = this.params.speed), void 0 === t && (t = !0);
                    var n = this,
                        a = n.params,
                        r = n.animating,
                        s = n.snapGrid,
                        o = n.slidesGrid,
                        l = n.rtlTranslate;
                    if (a.loop) {
                        if (r) return !1;
                        n.loopFix(), n._clientLeft = n.$wrapperEl[0].clientLeft
                    }

                    function c(e) {
                        return e < 0 ? -Math.floor(Math.abs(e)) : Math.floor(e)
                    }
                    var d, u = c(l ? n.translate : -n.translate),
                        h = s.map(function(e) {
                            return c(e)
                        }),
                        p = (o.map(function(e) {
                            return c(e)
                        }), s[h.indexOf(u)], s[h.indexOf(u) - 1]);
                    return void 0 !== p && (d = o.indexOf(p)) < 0 && (d = n.activeIndex - 1), n.slideTo(d, e, t, i)
                },
                slideReset: function(e, t, i) {
                    return void 0 === e && (e = this.params.speed), void 0 === t && (t = !0), this.slideTo(this.activeIndex, e, t, i)
                },
                slideToClosest: function(e, t, i) {
                    void 0 === e && (e = this.params.speed), void 0 === t && (t = !0);
                    var n = this,
                        a = n.activeIndex,
                        r = Math.floor(a / n.params.slidesPerGroup);
                    if (r < n.snapGrid.length - 1) {
                        var s = n.rtlTranslate ? n.translate : -n.translate,
                            o = n.snapGrid[r],
                            l = n.snapGrid[r + 1];
                        (l - o) / 2 < s - o && (a = n.params.slidesPerGroup)
                    }
                    return n.slideTo(a, e, t, i)
                },
                slideToClickedSlide: function() {
                    var e, t = this,
                        i = t.params,
                        n = t.$wrapperEl,
                        a = "auto" === i.slidesPerView ? t.slidesPerViewDynamic() : i.slidesPerView,
                        r = t.clickedIndex;
                    if (i.loop) {
                        if (t.animating) return;
                        e = parseInt(O(t.clickedSlide).attr("data-swiper-slide-index"), 10), i.centeredSlides ? r < t.loopedSlides - a / 2 || r > t.slides.length - t.loopedSlides + a / 2 ? (t.loopFix(), r = n.children("." + i.slideClass + '[data-swiper-slide-index="' + e + '"]:not(.' + i.slideDuplicateClass + ")").eq(0).index(), $.nextTick(function() {
                            t.slideTo(r)
                        })) : t.slideTo(r) : r > t.slides.length - a ? (t.loopFix(), r = n.children("." + i.slideClass + '[data-swiper-slide-index="' + e + '"]:not(.' + i.slideDuplicateClass + ")").eq(0).index(), $.nextTick(function() {
                            t.slideTo(r)
                        })) : t.slideTo(r)
                    } else t.slideTo(r)
                }
            },
            h = {
                loopCreate: function() {
                    var n = this,
                        e = n.params,
                        t = n.$wrapperEl;
                    t.children("." + e.slideClass + "." + e.slideDuplicateClass).remove();
                    var a = t.children("." + e.slideClass);
                    if (e.loopFillGroupWithBlank) {
                        var i = e.slidesPerGroup - a.length % e.slidesPerGroup;
                        if (i !== e.slidesPerGroup) {
                            for (var r = 0; r < i; r += 1) {
                                var s = O(v.createElement("div")).addClass(e.slideClass + " " + e.slideBlankClass);
                                t.append(s)
                            }
                            a = t.children("." + e.slideClass)
                        }
                    }
                    "auto" !== e.slidesPerView || e.loopedSlides || (e.loopedSlides = a.length), n.loopedSlides = parseInt(e.loopedSlides || e.slidesPerView, 10), n.loopedSlides += e.loopAdditionalSlides, n.loopedSlides > a.length && (n.loopedSlides = a.length);
                    var o = [],
                        l = [];
                    a.each(function(e, t) {
                        var i = O(t);
                        e < n.loopedSlides && l.push(t), e < a.length && e >= a.length - n.loopedSlides && o.push(t), i.attr("data-swiper-slide-index", e)
                    });
                    for (var c = 0; c < l.length; c += 1) t.append(O(l[c].cloneNode(!0)).addClass(e.slideDuplicateClass));
                    for (var d = o.length - 1; 0 <= d; d -= 1) t.prepend(O(o[d].cloneNode(!0)).addClass(e.slideDuplicateClass))
                },
                loopFix: function() {
                    var e, t = this,
                        i = t.params,
                        n = t.activeIndex,
                        a = t.slides,
                        r = t.loopedSlides,
                        s = t.allowSlidePrev,
                        o = t.allowSlideNext,
                        l = t.snapGrid,
                        c = t.rtlTranslate;
                    t.allowSlidePrev = !0, t.allowSlideNext = !0;
                    var d = -l[n] - t.getTranslate();
                    if (n < r) {
                        e = a.length - 3 * r + n, e += r;
                        var u = t.slideTo(e, 0, !1, !0);
                        u && 0 !== d && t.setTranslate((c ? -t.translate : t.translate) - d)
                    } else if ("auto" === i.slidesPerView && 2 * r <= n || n >= a.length - r) {
                        e = -a.length + n + r, e += r;
                        var h = t.slideTo(e, 0, !1, !0);
                        h && 0 !== d && t.setTranslate((c ? -t.translate : t.translate) - d)
                    }
                    t.allowSlidePrev = s, t.allowSlideNext = o
                },
                loopDestroy: function() {
                    var e = this.$wrapperEl,
                        t = this.params,
                        i = this.slides;
                    e.children("." + t.slideClass + "." + t.slideDuplicateClass).remove(), i.removeAttr("data-swiper-slide-index")
                }
            },
            p = {
                setGrabCursor: function(e) {
                    if (!(q.touch || !this.params.simulateTouch || this.params.watchOverflow && this.isLocked)) {
                        var t = this.el;
                        t.style.cursor = "move", t.style.cursor = e ? "-webkit-grabbing" : "-webkit-grab", t.style.cursor = e ? "-moz-grabbin" : "-moz-grab", t.style.cursor = e ? "grabbing" : "grab"
                    }
                },
                unsetGrabCursor: function() {
                    q.touch || this.params.watchOverflow && this.isLocked || (this.el.style.cursor = "")
                }
            },
            f = {
                appendSlide: function(e) {
                    var t = this,
                        i = t.$wrapperEl,
                        n = t.params;
                    if (n.loop && t.loopDestroy(), "object" == typeof e && "length" in e)
                        for (var a = 0; a < e.length; a += 1) e[a] && i.append(e[a]);
                    else i.append(e);
                    n.loop && t.loopCreate(), n.observer && q.observer || t.update()
                },
                prependSlide: function(e) {
                    var t = this,
                        i = t.params,
                        n = t.$wrapperEl,
                        a = t.activeIndex;
                    i.loop && t.loopDestroy();
                    var r = a + 1;
                    if ("object" == typeof e && "length" in e) {
                        for (var s = 0; s < e.length; s += 1) e[s] && n.prepend(e[s]);
                        r = a + e.length
                    } else n.prepend(e);
                    i.loop && t.loopCreate(), i.observer && q.observer || t.update(), t.slideTo(r, 0, !1)
                },
                addSlide: function(e, t) {
                    var i = this,
                        n = i.$wrapperEl,
                        a = i.params,
                        r = i.activeIndex;
                    a.loop && (r -= i.loopedSlides, i.loopDestroy(), i.slides = n.children("." + a.slideClass));
                    var s = i.slides.length;
                    if (e <= 0) i.prependSlide(t);
                    else if (s <= e) i.appendSlide(t);
                    else {
                        for (var o = e < r ? r + 1 : r, l = [], c = s - 1; e <= c; c -= 1) {
                            var d = i.slides.eq(c);
                            d.remove(), l.unshift(d)
                        }
                        if ("object" == typeof t && "length" in t) {
                            for (var u = 0; u < t.length; u += 1) t[u] && n.append(t[u]);
                            o = e < r ? r + t.length : r
                        } else n.append(t);
                        for (var h = 0; h < l.length; h += 1) n.append(l[h]);
                        a.loop && i.loopCreate(), a.observer && q.observer || i.update(), a.loop ? i.slideTo(o + i.loopedSlides, 0, !1) : i.slideTo(o, 0, !1)
                    }
                },
                removeSlide: function(e) {
                    var t = this,
                        i = t.params,
                        n = t.$wrapperEl,
                        a = t.activeIndex;
                    i.loop && (a -= t.loopedSlides, t.loopDestroy(), t.slides = n.children("." + i.slideClass));
                    var r, s = a;
                    if ("object" == typeof e && "length" in e) {
                        for (var o = 0; o < e.length; o += 1) r = e[o], t.slides[r] && t.slides.eq(r).remove(), r < s && (s -= 1);
                        s = Math.max(s, 0)
                    } else r = e, t.slides[r] && t.slides.eq(r).remove(), r < s && (s -= 1), s = Math.max(s, 0);
                    i.loop && t.loopCreate(), i.observer && q.observer || t.update(), i.loop ? t.slideTo(s + t.loopedSlides, 0, !1) : t.slideTo(s, 0, !1)
                },
                removeAllSlides: function() {
                    for (var e = [], t = 0; t < this.slides.length; t += 1) e.push(t);
                    this.removeSlide(e)
                }
            },
            m = function() {
                var e = B.navigator.userAgent,
                    t = {
                        ios: !1,
                        android: !1,
                        androidChrome: !1,
                        desktop: !1,
                        windows: !1,
                        iphone: !1,
                        ipod: !1,
                        ipad: !1,
                        cordova: B.cordova || B.phonegap,
                        phonegap: B.cordova || B.phonegap
                    },
                    i = e.match(/(Windows Phone);?[\s\/]+([\d.]+)?/),
                    n = e.match(/(Android);?[\s\/]+([\d.]+)?/),
                    a = e.match(/(iPad).*OS\s([\d_]+)/),
                    r = e.match(/(iPod)(.*OS\s([\d_]+))?/),
                    s = !a && e.match(/(iPhone\sOS|iOS)\s([\d_]+)/);
                if (i && (t.os = "windows", t.osVersion = i[2], t.windows = !0), n && !i && (t.os = "android", t.osVersion = n[2], t.android = !0, t.androidChrome = 0 <= e.toLowerCase().indexOf("chrome")), (a || s || r) && (t.os = "ios", t.ios = !0), s && !r && (t.osVersion = s[2].replace(/_/g, "."), t.iphone = !0), a && (t.osVersion = a[2].replace(/_/g, "."), t.ipad = !0), r && (t.osVersion = r[3] ? r[3].replace(/_/g, ".") : null, t.iphone = !0), t.ios && t.osVersion && 0 <= e.indexOf("Version/") && "10" === t.osVersion.split(".")[0] && (t.osVersion = e.toLowerCase().split("version/")[1].split(" ")[0]), t.desktop = !(t.os || t.android || t.webView), t.webView = (s || a || r) && e.match(/.*AppleWebKit(?!.*Safari)/i), t.os && "ios" === t.os) {
                    var o = t.osVersion.split("."),
                        l = v.querySelector('meta[name="viewport"]');
                    t.minimalUi = !t.webView && (r || s) && (1 * o[0] == 7 ? 1 <= 1 * o[1] : 7 < 1 * o[0]) && l && 0 <= l.getAttribute("content").indexOf("minimal-ui")
                }
                return t.pixelRatio = B.devicePixelRatio || 1, t
            }();

        function g(e) {
            var t = this,
                i = t.touchEventsData,
                n = t.params,
                a = t.touches;
            if (!t.animating || !n.preventInteractionOnTransition) {
                var r = e;
                if (r.originalEvent && (r = r.originalEvent), i.isTouchEvent = "touchstart" === r.type, (i.isTouchEvent || !("which" in r) || 3 !== r.which) && !(!i.isTouchEvent && "button" in r && 0 < r.button || i.isTouched && i.isMoved))
                    if (n.noSwiping && O(r.target).closest(n.noSwipingSelector ? n.noSwipingSelector : "." + n.noSwipingClass)[0]) t.allowClick = !0;
                    else if (!n.swipeHandler || O(r).closest(n.swipeHandler)[0]) {
                    a.currentX = "touchstart" === r.type ? r.targetTouches[0].pageX : r.pageX, a.currentY = "touchstart" === r.type ? r.targetTouches[0].pageY : r.pageY;
                    var s = a.currentX,
                        o = a.currentY,
                        l = n.edgeSwipeDetection || n.iOSEdgeSwipeDetection,
                        c = n.edgeSwipeThreshold || n.iOSEdgeSwipeThreshold;
                    if (!l || !(s <= c || s >= B.screen.width - c)) {
                        if ($.extend(i, {
                                isTouched: !0,
                                isMoved: !1,
                                allowTouchCallbacks: !0,
                                isScrolling: void 0,
                                startMoving: void 0
                            }), a.startX = s, a.startY = o, i.touchStartTime = $.now(), t.allowClick = !0, t.updateSize(), t.swipeDirection = void 0, 0 < n.threshold && (i.allowThresholdMove = !1), "touchstart" !== r.type) {
                            var d = !0;
                            O(r.target).is(i.formElements) && (d = !1), v.activeElement && O(v.activeElement).is(i.formElements) && v.activeElement !== r.target && v.activeElement.blur();
                            var u = d && t.allowTouchMove && n.touchStartPreventDefault;
                            (n.touchStartForcePreventDefault || u) && r.preventDefault()
                        }
                        t.emit("touchStart", r)
                    }
                }
            }
        }

        function y(e) {
            var t = this,
                i = t.touchEventsData,
                n = t.params,
                a = t.touches,
                r = t.rtlTranslate,
                s = e;
            if (s.originalEvent && (s = s.originalEvent), i.isTouched) {
                if (!i.isTouchEvent || "mousemove" !== s.type) {
                    var o = "touchmove" === s.type ? s.targetTouches[0].pageX : s.pageX,
                        l = "touchmove" === s.type ? s.targetTouches[0].pageY : s.pageY;
                    if (s.preventedByNestedSwiper) return a.startX = o, void(a.startY = l);
                    if (!t.allowTouchMove) return t.allowClick = !1, void(i.isTouched && ($.extend(a, {
                        startX: o,
                        startY: l,
                        currentX: o,
                        currentY: l
                    }), i.touchStartTime = $.now()));
                    if (i.isTouchEvent && n.touchReleaseOnEdges && !n.loop)
                        if (t.isVertical()) {
                            if (l < a.startY && t.translate <= t.maxTranslate() || l > a.startY && t.translate >= t.minTranslate()) return i.isTouched = !1, void(i.isMoved = !1)
                        } else if (o < a.startX && t.translate <= t.maxTranslate() || o > a.startX && t.translate >= t.minTranslate()) return;
                    if (i.isTouchEvent && v.activeElement && s.target === v.activeElement && O(s.target).is(i.formElements)) return i.isMoved = !0, void(t.allowClick = !1);
                    if (i.allowTouchCallbacks && t.emit("touchMove", s), !(s.targetTouches && 1 < s.targetTouches.length)) {
                        a.currentX = o, a.currentY = l;
                        var c, d = a.currentX - a.startX,
                            u = a.currentY - a.startY;
                        if (!(t.params.threshold && Math.sqrt(Math.pow(d, 2) + Math.pow(u, 2)) < t.params.threshold))
                            if (void 0 === i.isScrolling && (t.isHorizontal() && a.currentY === a.startY || t.isVertical() && a.currentX === a.startX ? i.isScrolling = !1 : 25 <= d * d + u * u && (c = 180 * Math.atan2(Math.abs(u), Math.abs(d)) / Math.PI, i.isScrolling = t.isHorizontal() ? c > n.touchAngle : 90 - c > n.touchAngle)), i.isScrolling && t.emit("touchMoveOpposite", s), void 0 === i.startMoving && (a.currentX === a.startX && a.currentY === a.startY || (i.startMoving = !0)), i.isScrolling) i.isTouched = !1;
                            else if (i.startMoving) {
                            t.allowClick = !1, s.preventDefault(), n.touchMoveStopPropagation && !n.nested && s.stopPropagation(), i.isMoved || (n.loop && t.loopFix(), i.startTranslate = t.getTranslate(), t.setTransition(0), t.animating && t.$wrapperEl.trigger("webkitTransitionEnd transitionend"), i.allowMomentumBounce = !1, !n.grabCursor || !0 !== t.allowSlideNext && !0 !== t.allowSlidePrev || t.setGrabCursor(!0), t.emit("sliderFirstMove", s)), t.emit("sliderMove", s), i.isMoved = !0;
                            var h = t.isHorizontal() ? d : u;
                            a.diff = h, h *= n.touchRatio, r && (h = -h), t.swipeDirection = 0 < h ? "prev" : "next", i.currentTranslate = h + i.startTranslate;
                            var p = !0,
                                f = n.resistanceRatio;
                            if (n.touchReleaseOnEdges && (f = 0), 0 < h && i.currentTranslate > t.minTranslate() ? (p = !1, n.resistance && (i.currentTranslate = t.minTranslate() - 1 + Math.pow(-t.minTranslate() + i.startTranslate + h, f))) : h < 0 && i.currentTranslate < t.maxTranslate() && (p = !1, n.resistance && (i.currentTranslate = t.maxTranslate() + 1 - Math.pow(t.maxTranslate() - i.startTranslate - h, f))), p && (s.preventedByNestedSwiper = !0), !t.allowSlideNext && "next" === t.swipeDirection && i.currentTranslate < i.startTranslate && (i.currentTranslate = i.startTranslate), !t.allowSlidePrev && "prev" === t.swipeDirection && i.currentTranslate > i.startTranslate && (i.currentTranslate = i.startTranslate), 0 < n.threshold) {
                                if (!(Math.abs(h) > n.threshold || i.allowThresholdMove)) return void(i.currentTranslate = i.startTranslate);
                                if (!i.allowThresholdMove) return i.allowThresholdMove = !0, a.startX = a.currentX, a.startY = a.currentY, i.currentTranslate = i.startTranslate, void(a.diff = t.isHorizontal() ? a.currentX - a.startX : a.currentY - a.startY)
                            }
                            n.followFinger && ((n.freeMode || n.watchSlidesProgress || n.watchSlidesVisibility) && (t.updateActiveIndex(), t.updateSlidesClasses()), n.freeMode && (0 === i.velocities.length && i.velocities.push({
                                position: a[t.isHorizontal() ? "startX" : "startY"],
                                time: i.touchStartTime
                            }), i.velocities.push({
                                position: a[t.isHorizontal() ? "currentX" : "currentY"],
                                time: $.now()
                            })), t.updateProgress(i.currentTranslate), t.setTranslate(i.currentTranslate))
                        }
                    }
                }
            } else i.startMoving && i.isScrolling && t.emit("touchMoveOpposite", s)
        }

        function b(e) {
            var t = this,
                i = t.touchEventsData,
                n = t.params,
                a = t.touches,
                r = t.rtlTranslate,
                s = t.$wrapperEl,
                o = t.slidesGrid,
                l = t.snapGrid,
                c = e;
            if (c.originalEvent && (c = c.originalEvent), i.allowTouchCallbacks && t.emit("touchEnd", c), i.allowTouchCallbacks = !1, !i.isTouched) return i.isMoved && n.grabCursor && t.setGrabCursor(!1), i.isMoved = !1, void(i.startMoving = !1);
            n.grabCursor && i.isMoved && i.isTouched && (!0 === t.allowSlideNext || !0 === t.allowSlidePrev) && t.setGrabCursor(!1);
            var d, u = $.now(),
                h = u - i.touchStartTime;
            if (t.allowClick && (t.updateClickedSlide(c), t.emit("tap", c), h < 300 && 300 < u - i.lastClickTime && (i.clickTimeout && clearTimeout(i.clickTimeout), i.clickTimeout = $.nextTick(function() {
                    t && !t.destroyed && t.emit("click", c)
                }, 300)), h < 300 && u - i.lastClickTime < 300 && (i.clickTimeout && clearTimeout(i.clickTimeout), t.emit("doubleTap", c))), i.lastClickTime = $.now(), $.nextTick(function() {
                    t.destroyed || (t.allowClick = !0)
                }), !i.isTouched || !i.isMoved || !t.swipeDirection || 0 === a.diff || i.currentTranslate === i.startTranslate) return i.isTouched = !1, i.isMoved = !1, void(i.startMoving = !1);
            if (i.isTouched = !1, i.isMoved = !1, i.startMoving = !1, d = n.followFinger ? r ? t.translate : -t.translate : -i.currentTranslate, n.freeMode) {
                if (d < -t.minTranslate()) return void t.slideTo(t.activeIndex);
                if (d > -t.maxTranslate()) return void(t.slides.length < l.length ? t.slideTo(l.length - 1) : t.slideTo(t.slides.length - 1));
                if (n.freeModeMomentum) {
                    if (1 < i.velocities.length) {
                        var p = i.velocities.pop(),
                            f = i.velocities.pop(),
                            v = p.position - f.position,
                            m = p.time - f.time;
                        t.velocity = v / m, t.velocity /= 2, Math.abs(t.velocity) < n.freeModeMinimumVelocity && (t.velocity = 0), (150 < m || 300 < $.now() - p.time) && (t.velocity = 0)
                    } else t.velocity = 0;
                    t.velocity *= n.freeModeMomentumVelocityRatio, i.velocities.length = 0;
                    var g = 1e3 * n.freeModeMomentumRatio,
                        y = t.velocity * g,
                        b = t.translate + y;
                    r && (b = -b);
                    var w, E, x = !1,
                        S = 20 * Math.abs(t.velocity) * n.freeModeMomentumBounceRatio;
                    if (b < t.maxTranslate()) n.freeModeMomentumBounce ? (b + t.maxTranslate() < -S && (b = t.maxTranslate() - S), w = t.maxTranslate(), x = !0, i.allowMomentumBounce = !0) : b = t.maxTranslate(), n.loop && n.centeredSlides && (E = !0);
                    else if (b > t.minTranslate()) n.freeModeMomentumBounce ? (b - t.minTranslate() > S && (b = t.minTranslate() + S), w = t.minTranslate(), x = !0, i.allowMomentumBounce = !0) : b = t.minTranslate(), n.loop && n.centeredSlides && (E = !0);
                    else if (n.freeModeSticky) {
                        for (var C, k = 0; k < l.length; k += 1)
                            if (l[k] > -b) {
                                C = k;
                                break
                            } b = -(b = Math.abs(l[C] - b) < Math.abs(l[C - 1] - b) || "next" === t.swipeDirection ? l[C] : l[C - 1])
                    }
                    if (E && t.once("transitionEnd", function() {
                            t.loopFix()
                        }), 0 !== t.velocity) g = r ? Math.abs((-b - t.translate) / t.velocity) : Math.abs((b - t.translate) / t.velocity);
                    else if (n.freeModeSticky) return void t.slideToClosest();
                    n.freeModeMomentumBounce && x ? (t.updateProgress(w), t.setTransition(g), t.setTranslate(b), t.transitionStart(!0, t.swipeDirection), t.animating = !0, s.transitionEnd(function() {
                        t && !t.destroyed && i.allowMomentumBounce && (t.emit("momentumBounce"), t.setTransition(n.speed), t.setTranslate(w), s.transitionEnd(function() {
                            t && !t.destroyed && t.transitionEnd()
                        }))
                    })) : t.velocity ? (t.updateProgress(b), t.setTransition(g), t.setTranslate(b), t.transitionStart(!0, t.swipeDirection), t.animating || (t.animating = !0, s.transitionEnd(function() {
                        t && !t.destroyed && t.transitionEnd()
                    }))) : t.updateProgress(b), t.updateActiveIndex(), t.updateSlidesClasses()
                } else if (n.freeModeSticky) return void t.slideToClosest();
                (!n.freeModeMomentum || h >= n.longSwipesMs) && (t.updateProgress(), t.updateActiveIndex(), t.updateSlidesClasses())
            } else {
                for (var T = 0, _ = t.slidesSizesGrid[0], L = 0; L < o.length; L += n.slidesPerGroup) void 0 !== o[L + n.slidesPerGroup] ? d >= o[L] && d < o[L + n.slidesPerGroup] && (_ = o[(T = L) + n.slidesPerGroup] - o[L]) : d >= o[L] && (T = L, _ = o[o.length - 1] - o[o.length - 2]);
                var I = (d - o[T]) / _;
                if (h > n.longSwipesMs) {
                    if (!n.longSwipes) return void t.slideTo(t.activeIndex);
                    "next" === t.swipeDirection && (I >= n.longSwipesRatio ? t.slideTo(T + n.slidesPerGroup) : t.slideTo(T)), "prev" === t.swipeDirection && (I > 1 - n.longSwipesRatio ? t.slideTo(T + n.slidesPerGroup) : t.slideTo(T))
                } else {
                    if (!n.shortSwipes) return void t.slideTo(t.activeIndex);
                    "next" === t.swipeDirection && t.slideTo(T + n.slidesPerGroup), "prev" === t.swipeDirection && t.slideTo(T)
                }
            }
        }

        function w() {
            var e = this,
                t = e.params,
                i = e.el;
            if (!i || 0 !== i.offsetWidth) {
                t.breakpoints && e.setBreakpoint();
                var n = e.allowSlideNext,
                    a = e.allowSlidePrev,
                    r = e.snapGrid;
                if (e.allowSlideNext = !0, e.allowSlidePrev = !0, e.updateSize(), e.updateSlides(), t.freeMode) {
                    var s = Math.min(Math.max(e.translate, e.maxTranslate()), e.minTranslate());
                    e.setTranslate(s), e.updateActiveIndex(), e.updateSlidesClasses(), t.autoHeight && e.updateAutoHeight()
                } else e.updateSlidesClasses(), ("auto" === t.slidesPerView || 1 < t.slidesPerView) && e.isEnd && !e.params.centeredSlides ? e.slideTo(e.slides.length - 1, 0, !1, !0) : e.slideTo(e.activeIndex, 0, !1, !0);
                e.allowSlidePrev = a, e.allowSlideNext = n, e.params.watchOverflow && r !== e.snapGrid && e.checkOverflow()
            }
        }

        function E(e) {
            this.allowClick || (this.params.preventClicks && e.preventDefault(), this.params.preventClicksPropagation && this.animating && (e.stopPropagation(), e.stopImmediatePropagation()))
        }
        var x, S = {
                attachEvents: function() {
                    var e = this,
                        t = e.params,
                        i = e.touchEvents,
                        n = e.el,
                        a = e.wrapperEl;
                    e.onTouchStart = g.bind(e), e.onTouchMove = y.bind(e), e.onTouchEnd = b.bind(e), e.onClick = E.bind(e);
                    var r = "container" === t.touchEventsTarget ? n : a,
                        s = !!t.nested;
                    if (q.touch || !q.pointerEvents && !q.prefixedPointerEvents) {
                        if (q.touch) {
                            var o = !("touchstart" !== i.start || !q.passiveListener || !t.passiveListeners) && {
                                passive: !0,
                                capture: !1
                            };
                            r.addEventListener(i.start, e.onTouchStart, o), r.addEventListener(i.move, e.onTouchMove, q.passiveListener ? {
                                passive: !1,
                                capture: s
                            } : s), r.addEventListener(i.end, e.onTouchEnd, o)
                        }(t.simulateTouch && !m.ios && !m.android || t.simulateTouch && !q.touch && m.ios) && (r.addEventListener("mousedown", e.onTouchStart, !1), v.addEventListener("mousemove", e.onTouchMove, s), v.addEventListener("mouseup", e.onTouchEnd, !1))
                    } else r.addEventListener(i.start, e.onTouchStart, !1), v.addEventListener(i.move, e.onTouchMove, s), v.addEventListener(i.end, e.onTouchEnd, !1);
                    (t.preventClicks || t.preventClicksPropagation) && r.addEventListener("click", e.onClick, !0), e.on(m.ios || m.android ? "resize orientationchange observerUpdate" : "resize observerUpdate", w, !0)
                },
                detachEvents: function() {
                    var e = this,
                        t = e.params,
                        i = e.touchEvents,
                        n = e.el,
                        a = e.wrapperEl,
                        r = "container" === t.touchEventsTarget ? n : a,
                        s = !!t.nested;
                    if (q.touch || !q.pointerEvents && !q.prefixedPointerEvents) {
                        if (q.touch) {
                            var o = !("onTouchStart" !== i.start || !q.passiveListener || !t.passiveListeners) && {
                                passive: !0,
                                capture: !1
                            };
                            r.removeEventListener(i.start, e.onTouchStart, o), r.removeEventListener(i.move, e.onTouchMove, s), r.removeEventListener(i.end, e.onTouchEnd, o)
                        }(t.simulateTouch && !m.ios && !m.android || t.simulateTouch && !q.touch && m.ios) && (r.removeEventListener("mousedown", e.onTouchStart, !1), v.removeEventListener("mousemove", e.onTouchMove, s), v.removeEventListener("mouseup", e.onTouchEnd, !1))
                    } else r.removeEventListener(i.start, e.onTouchStart, !1), v.removeEventListener(i.move, e.onTouchMove, s), v.removeEventListener(i.end, e.onTouchEnd, !1);
                    (t.preventClicks || t.preventClicksPropagation) && r.removeEventListener("click", e.onClick, !0), e.off(m.ios || m.android ? "resize orientationchange observerUpdate" : "resize observerUpdate", w)
                }
            },
            C = {
                setBreakpoint: function() {
                    var e = this,
                        t = e.activeIndex,
                        i = e.initialized,
                        n = e.loopedSlides;
                    void 0 === n && (n = 0);
                    var a = e.params,
                        r = a.breakpoints;
                    if (r && (!r || 0 !== Object.keys(r).length)) {
                        var s = e.getBreakpoint(r);
                        if (s && e.currentBreakpoint !== s) {
                            var o = s in r ? r[s] : void 0;
                            o && ["slidesPerView", "spaceBetween", "slidesPerGroup"].forEach(function(e) {
                                var t = o[e];
                                void 0 !== t && (o[e] = "slidesPerView" !== e || "AUTO" !== t && "auto" !== t ? "slidesPerView" === e ? parseFloat(t) : parseInt(t, 10) : "auto")
                            });
                            var l = o || e.originalParams,
                                c = a.loop && l.slidesPerView !== a.slidesPerView;
                            $.extend(e.params, l), $.extend(e, {
                                allowTouchMove: e.params.allowTouchMove,
                                allowSlideNext: e.params.allowSlideNext,
                                allowSlidePrev: e.params.allowSlidePrev
                            }), e.currentBreakpoint = s, c && i && (e.loopDestroy(), e.loopCreate(), e.updateSlides(), e.slideTo(t - n + e.loopedSlides, 0, !1)), e.emit("breakpoint", l)
                        }
                    }
                },
                getBreakpoint: function(e) {
                    if (e) {
                        var t = !1,
                            i = [];
                        Object.keys(e).forEach(function(e) {
                            i.push(e)
                        }), i.sort(function(e, t) {
                            return parseInt(e, 10) - parseInt(t, 10)
                        });
                        for (var n = 0; n < i.length; n += 1) {
                            var a = i[n];
                            this.params.breakpointsInverse ? a <= B.innerWidth && (t = a) : a >= B.innerWidth && !t && (t = a)
                        }
                        return t || "max"
                    }
                }
            },
            D = {
                isIE: !!B.navigator.userAgent.match(/Trident/g) || !!B.navigator.userAgent.match(/MSIE/g),
                isEdge: !!B.navigator.userAgent.match(/Edge/g),
                isSafari: (x = B.navigator.userAgent.toLowerCase(), 0 <= x.indexOf("safari") && x.indexOf("chrome") < 0 && x.indexOf("android") < 0),
                isUiWebView: /(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(B.navigator.userAgent)
            },
            k = {
                init: !0,
                direction: "horizontal",
                touchEventsTarget: "container",
                initialSlide: 0,
                speed: 300,
                preventInteractionOnTransition: !1,
                edgeSwipeDetection: !1,
                edgeSwipeThreshold: 20,
                freeMode: !1,
                freeModeMomentum: !0,
                freeModeMomentumRatio: 1,
                freeModeMomentumBounce: !0,
                freeModeMomentumBounceRatio: 1,
                freeModeMomentumVelocityRatio: 1,
                freeModeSticky: !1,
                freeModeMinimumVelocity: .02,
                autoHeight: !1,
                setWrapperSize: !1,
                virtualTranslate: !1,
                effect: "slide",
                breakpoints: void 0,
                breakpointsInverse: !1,
                spaceBetween: 0,
                slidesPerView: 1,
                slidesPerColumn: 1,
                slidesPerColumnFill: "column",
                slidesPerGroup: 1,
                centeredSlides: !1,
                slidesOffsetBefore: 0,
                slidesOffsetAfter: 0,
                normalizeSlideIndex: !0,
                centerInsufficientSlides: !1,
                watchOverflow: !1,
                roundLengths: !1,
                touchRatio: 1,
                touchAngle: 45,
                simulateTouch: !0,
                shortSwipes: !0,
                longSwipes: !0,
                longSwipesRatio: .5,
                longSwipesMs: 300,
                followFinger: !0,
                allowTouchMove: !0,
                threshold: 0,
                touchMoveStopPropagation: !0,
                touchStartPreventDefault: !0,
                touchStartForcePreventDefault: !1,
                touchReleaseOnEdges: !1,
                uniqueNavElements: !0,
                resistance: !0,
                resistanceRatio: .85,
                watchSlidesProgress: !1,
                watchSlidesVisibility: !1,
                grabCursor: !1,
                preventClicks: !0,
                preventClicksPropagation: !0,
                slideToClickedSlide: !1,
                preloadImages: !0,
                updateOnImagesReady: !0,
                loop: !1,
                loopAdditionalSlides: 0,
                loopedSlides: null,
                loopFillGroupWithBlank: !1,
                allowSlidePrev: !0,
                allowSlideNext: !0,
                swipeHandler: null,
                noSwiping: !0,
                noSwipingClass: "swiper-no-swiping",
                noSwipingSelector: null,
                passiveListeners: !0,
                containerModifierClass: "swiper-container-",
                slideClass: "swiper-slide",
                slideBlankClass: "swiper-slide-invisible-blank",
                slideActiveClass: "swiper-slide-active",
                slideDuplicateActiveClass: "swiper-slide-duplicate-active",
                slideVisibleClass: "swiper-slide-visible",
                slideDuplicateClass: "swiper-slide-duplicate",
                slideNextClass: "swiper-slide-next",
                slideDuplicateNextClass: "swiper-slide-duplicate-next",
                slidePrevClass: "swiper-slide-prev",
                slideDuplicatePrevClass: "swiper-slide-duplicate-prev",
                wrapperClass: "swiper-wrapper",
                runCallbacksOnInit: !0
            },
            T = {
                update: o,
                translate: c,
                transition: d,
                slide: u,
                loop: h,
                grabCursor: p,
                manipulation: f,
                events: S,
                breakpoints: C,
                checkOverflow: {
                    checkOverflow: function() {
                        var e = this,
                            t = e.isLocked;
                        e.isLocked = 1 === e.snapGrid.length, e.allowSlideNext = !e.isLocked, e.allowSlidePrev = !e.isLocked, t !== e.isLocked && e.emit(e.isLocked ? "lock" : "unlock"), t && t !== e.isLocked && (e.isEnd = !1, e.navigation.update())
                    }
                },
                classes: {
                    addClasses: function() {
                        var t = this.classNames,
                            i = this.params,
                            e = this.rtl,
                            n = this.$el,
                            a = [];
                        a.push(i.direction), i.freeMode && a.push("free-mode"), q.flexbox || a.push("no-flexbox"), i.autoHeight && a.push("autoheight"), e && a.push("rtl"), 1 < i.slidesPerColumn && a.push("multirow"), m.android && a.push("android"), m.ios && a.push("ios"), (D.isIE || D.isEdge) && (q.pointerEvents || q.prefixedPointerEvents) && a.push("wp8-" + i.direction), a.forEach(function(e) {
                            t.push(i.containerModifierClass + e)
                        }), n.addClass(t.join(" "))
                    },
                    removeClasses: function() {
                        var e = this.$el,
                            t = this.classNames;
                        e.removeClass(t.join(" "))
                    }
                },
                images: {
                    loadImage: function(e, t, i, n, a, r) {
                        var s;

                        function o() {
                            r && r()
                        }
                        e.complete && a ? o() : t ? ((s = new B.Image).onload = o, s.onerror = o, n && (s.sizes = n), i && (s.srcset = i), t && (s.src = t)) : o()
                    },
                    preloadImages: function() {
                        var e = this;

                        function t() {
                            null != e && e && !e.destroyed && (void 0 !== e.imagesLoaded && (e.imagesLoaded += 1), e.imagesLoaded === e.imagesToLoad.length && (e.params.updateOnImagesReady && e.update(), e.emit("imagesReady")))
                        }
                        e.imagesToLoad = e.$el.find("img");
                        for (var i = 0; i < e.imagesToLoad.length; i += 1) {
                            var n = e.imagesToLoad[i];
                            e.loadImage(n, n.currentSrc || n.getAttribute("src"), n.srcset || n.getAttribute("srcset"), n.sizes || n.getAttribute("sizes"), !0, t)
                        }
                    }
                }
            },
            _ = {},
            L = function(h) {
                function p() {
                    for (var e, t, a, i = [], n = arguments.length; n--;) i[n] = arguments[n];
                    (a = 1 === i.length && i[0].constructor && i[0].constructor === Object ? i[0] : (t = (e = i)[0], e[1])) || (a = {}), a = $.extend({}, a), t && !a.el && (a.el = t), h.call(this, a), Object.keys(T).forEach(function(t) {
                        Object.keys(T[t]).forEach(function(e) {
                            p.prototype[e] || (p.prototype[e] = T[t][e])
                        })
                    });
                    var r = this;
                    void 0 === r.modules && (r.modules = {}), Object.keys(r.modules).forEach(function(e) {
                        var t = r.modules[e];
                        if (t.params) {
                            var i = Object.keys(t.params)[0],
                                n = t.params[i];
                            if ("object" != typeof n || null === n) return;
                            if (!(i in a && "enabled" in n)) return;
                            !0 === a[i] && (a[i] = {
                                enabled: !0
                            }), "object" != typeof a[i] || "enabled" in a[i] || (a[i].enabled = !0), a[i] || (a[i] = {
                                enabled: !1
                            })
                        }
                    });
                    var s = $.extend({}, k);
                    r.useModulesParams(s), r.params = $.extend({}, s, _, a), r.originalParams = $.extend({}, r.params), r.passedParams = $.extend({}, a);
                    var o = (r.$ = O)(r.params.el);
                    if (t = o[0]) {
                        if (1 < o.length) {
                            var l = [];
                            return o.each(function(e, t) {
                                var i = $.extend({}, a, {
                                    el: t
                                });
                                l.push(new p(i))
                            }), l
                        }
                        t.swiper = r, o.data("swiper", r);
                        var c, d, u = o.children("." + r.params.wrapperClass);
                        return $.extend(r, {
                            $el: o,
                            el: t,
                            $wrapperEl: u,
                            wrapperEl: u[0],
                            classNames: [],
                            slides: O(),
                            slidesGrid: [],
                            snapGrid: [],
                            slidesSizesGrid: [],
                            isHorizontal: function() {
                                return "horizontal" === r.params.direction
                            },
                            isVertical: function() {
                                return "vertical" === r.params.direction
                            },
                            rtl: "rtl" === t.dir.toLowerCase() || "rtl" === o.css("direction"),
                            rtlTranslate: "horizontal" === r.params.direction && ("rtl" === t.dir.toLowerCase() || "rtl" === o.css("direction")),
                            wrongRTL: "-webkit-box" === u.css("display"),
                            activeIndex: 0,
                            realIndex: 0,
                            isBeginning: !0,
                            isEnd: !1,
                            translate: 0,
                            previousTranslate: 0,
                            progress: 0,
                            velocity: 0,
                            animating: !1,
                            allowSlideNext: r.params.allowSlideNext,
                            allowSlidePrev: r.params.allowSlidePrev,
                            touchEvents: (c = ["touchstart", "touchmove", "touchend"], d = ["mousedown", "mousemove", "mouseup"], q.pointerEvents ? d = ["pointerdown", "pointermove", "pointerup"] : q.prefixedPointerEvents && (d = ["MSPointerDown", "MSPointerMove", "MSPointerUp"]), r.touchEventsTouch = {
                                start: c[0],
                                move: c[1],
                                end: c[2]
                            }, r.touchEventsDesktop = {
                                start: d[0],
                                move: d[1],
                                end: d[2]
                            }, q.touch || !r.params.simulateTouch ? r.touchEventsTouch : r.touchEventsDesktop),
                            touchEventsData: {
                                isTouched: void 0,
                                isMoved: void 0,
                                allowTouchCallbacks: void 0,
                                touchStartTime: void 0,
                                isScrolling: void 0,
                                currentTranslate: void 0,
                                startTranslate: void 0,
                                allowThresholdMove: void 0,
                                formElements: "input, select, option, textarea, button, video",
                                lastClickTime: $.now(),
                                clickTimeout: void 0,
                                velocities: [],
                                allowMomentumBounce: void 0,
                                isTouchEvent: void 0,
                                startMoving: void 0
                            },
                            allowClick: !0,
                            allowTouchMove: r.params.allowTouchMove,
                            touches: {
                                startX: 0,
                                startY: 0,
                                currentX: 0,
                                currentY: 0,
                                diff: 0
                            },
                            imagesToLoad: [],
                            imagesLoaded: 0
                        }), r.useModules(), r.params.init && r.init(), r
                    }
                }
                h && (p.__proto__ = h), p.prototype = Object.create(h && h.prototype);
                var e = {
                    extendedDefaults: {
                        configurable: !0
                    },
                    defaults: {
                        configurable: !0
                    },
                    Class: {
                        configurable: !0
                    },
                    $: {
                        configurable: !0
                    }
                };
                return (p.prototype.constructor = p).prototype.slidesPerViewDynamic = function() {
                    var e = this.params,
                        t = this.slides,
                        i = this.slidesGrid,
                        n = this.size,
                        a = this.activeIndex,
                        r = 1;
                    if (e.centeredSlides) {
                        for (var s, o = t[a].swiperSlideSize, l = a + 1; l < t.length; l += 1) t[l] && !s && (o += t[l].swiperSlideSize, r += 1, n < o && (s = !0));
                        for (var c = a - 1; 0 <= c; c -= 1) t[c] && !s && (o += t[c].swiperSlideSize, r += 1, n < o && (s = !0))
                    } else
                        for (var d = a + 1; d < t.length; d += 1) i[d] - i[a] < n && (r += 1);
                    return r
                }, p.prototype.update = function() {
                    var i = this;
                    if (i && !i.destroyed) {
                        var e = i.snapGrid,
                            t = i.params;
                        t.breakpoints && i.setBreakpoint(), i.updateSize(), i.updateSlides(), i.updateProgress(), i.updateSlidesClasses(), i.params.freeMode ? (n(), i.params.autoHeight && i.updateAutoHeight()) : (("auto" === i.params.slidesPerView || 1 < i.params.slidesPerView) && i.isEnd && !i.params.centeredSlides ? i.slideTo(i.slides.length - 1, 0, !1, !0) : i.slideTo(i.activeIndex, 0, !1, !0)) || n(), t.watchOverflow && e !== i.snapGrid && i.checkOverflow(), i.emit("update")
                    }

                    function n() {
                        var e = i.rtlTranslate ? -1 * i.translate : i.translate,
                            t = Math.min(Math.max(e, i.maxTranslate()), i.minTranslate());
                        i.setTranslate(t), i.updateActiveIndex(), i.updateSlidesClasses()
                    }
                }, p.prototype.init = function() {
                    var e = this;
                    e.initialized || (e.emit("beforeInit"), e.params.breakpoints && e.setBreakpoint(), e.addClasses(), e.params.loop && e.loopCreate(), e.updateSize(), e.updateSlides(), e.params.watchOverflow && e.checkOverflow(), e.params.grabCursor && e.setGrabCursor(), e.params.preloadImages && e.preloadImages(), e.params.loop ? e.slideTo(e.params.initialSlide + e.loopedSlides, 0, e.params.runCallbacksOnInit) : e.slideTo(e.params.initialSlide, 0, e.params.runCallbacksOnInit), e.attachEvents(), e.initialized = !0, e.emit("init"))
                }, p.prototype.destroy = function(e, t) {
                    void 0 === e && (e = !0), void 0 === t && (t = !0);
                    var i = this,
                        n = i.params,
                        a = i.$el,
                        r = i.$wrapperEl,
                        s = i.slides;
                    return void 0 === i.params || i.destroyed || (i.emit("beforeDestroy"), i.initialized = !1, i.detachEvents(), n.loop && i.loopDestroy(), t && (i.removeClasses(), a.removeAttr("style"), r.removeAttr("style"), s && s.length && s.removeClass([n.slideVisibleClass, n.slideActiveClass, n.slideNextClass, n.slidePrevClass].join(" ")).removeAttr("style").removeAttr("data-swiper-slide-index").removeAttr("data-swiper-column").removeAttr("data-swiper-row")), i.emit("destroy"), Object.keys(i.eventsListeners).forEach(function(e) {
                        i.off(e)
                    }), !1 !== e && (i.$el[0].swiper = null, i.$el.data("swiper", null), $.deleteProps(i)), i.destroyed = !0), null
                }, p.extendDefaults = function(e) {
                    $.extend(_, e)
                }, e.extendedDefaults.get = function() {
                    return _
                }, e.defaults.get = function() {
                    return k
                }, e.Class.get = function() {
                    return h
                }, e.$.get = function() {
                    return O
                }, Object.defineProperties(p, e), p
            }(a),
            I = {
                name: "device",
                proto: {
                    device: m
                },
                static: {
                    device: m
                }
            },
            M = {
                name: "support",
                proto: {
                    support: q
                },
                static: {
                    support: q
                }
            },
            P = {
                name: "browser",
                proto: {
                    browser: D
                },
                static: {
                    browser: D
                }
            },
            A = {
                name: "resize",
                create: function() {
                    var e = this;
                    $.extend(e, {
                        resize: {
                            resizeHandler: function() {
                                e && !e.destroyed && e.initialized && (e.emit("beforeResize"), e.emit("resize"))
                            },
                            orientationChangeHandler: function() {
                                e && !e.destroyed && e.initialized && e.emit("orientationchange")
                            }
                        }
                    })
                },
                on: {
                    init: function() {
                        B.addEventListener("resize", this.resize.resizeHandler), B.addEventListener("orientationchange", this.resize.orientationChangeHandler)
                    },
                    destroy: function() {
                        B.removeEventListener("resize", this.resize.resizeHandler), B.removeEventListener("orientationchange", this.resize.orientationChangeHandler)
                    }
                }
            },
            F = {
                func: B.MutationObserver || B.WebkitMutationObserver,
                attach: function(e, t) {
                    void 0 === t && (t = {});
                    var i = this,
                        n = F.func,
                        a = new n(function(e) {
                            if (1 !== e.length) {
                                var t = function() {
                                    i.emit("observerUpdate", e[0])
                                };
                                B.requestAnimationFrame ? B.requestAnimationFrame(t) : B.setTimeout(t, 0)
                            } else i.emit("observerUpdate", e[0])
                        });
                    a.observe(e, {
                        attributes: void 0 === t.attributes || t.attributes,
                        childList: void 0 === t.childList || t.childList,
                        characterData: void 0 === t.characterData || t.characterData
                    }), i.observer.observers.push(a)
                },
                init: function() {
                    if (q.observer && this.params.observer) {
                        if (this.params.observeParents)
                            for (var e = this.$el.parents(), t = 0; t < e.length; t += 1) this.observer.attach(e[t]);
                        this.observer.attach(this.$el[0], {
                            childList: !1
                        }), this.observer.attach(this.$wrapperEl[0], {
                            attributes: !1
                        })
                    }
                },
                destroy: function() {
                    this.observer.observers.forEach(function(e) {
                        e.disconnect()
                    }), this.observer.observers = []
                }
            },
            z = {
                name: "observer",
                params: {
                    observer: !1,
                    observeParents: !1
                },
                create: function() {
                    $.extend(this, {
                        observer: {
                            init: F.init.bind(this),
                            attach: F.attach.bind(this),
                            destroy: F.destroy.bind(this),
                            observers: []
                        }
                    })
                },
                on: {
                    init: function() {
                        this.observer.init()
                    },
                    destroy: function() {
                        this.observer.destroy()
                    }
                }
            },
            N = {
                update: function(e) {
                    var t = this,
                        i = t.params,
                        n = i.slidesPerView,
                        a = i.slidesPerGroup,
                        r = i.centeredSlides,
                        s = t.params.virtual,
                        o = s.addSlidesBefore,
                        l = s.addSlidesAfter,
                        c = t.virtual,
                        d = c.from,
                        u = c.to,
                        h = c.slides,
                        p = c.slidesGrid,
                        f = c.renderSlide,
                        v = c.offset;
                    t.updateActiveIndex();
                    var m, g, y, b = t.activeIndex || 0;
                    m = t.rtlTranslate ? "right" : t.isHorizontal() ? "left" : "top", y = r ? (g = Math.floor(n / 2) + a + o, Math.floor(n / 2) + a + l) : (g = n + (a - 1) + o, a + l);
                    var w = Math.max((b || 0) - y, 0),
                        E = Math.min((b || 0) + g, h.length - 1),
                        x = (t.slidesGrid[w] || 0) - (t.slidesGrid[0] || 0);

                    function S() {
                        t.updateSlides(), t.updateProgress(), t.updateSlidesClasses(), t.lazy && t.params.lazy.enabled && t.lazy.load()
                    }
                    if ($.extend(t.virtual, {
                            from: w,
                            to: E,
                            offset: x,
                            slidesGrid: t.slidesGrid
                        }), d === w && u === E && !e) return t.slidesGrid !== p && x !== v && t.slides.css(m, x + "px"), void t.updateProgress();
                    if (t.params.virtual.renderExternal) return t.params.virtual.renderExternal.call(t, {
                        offset: x,
                        from: w,
                        to: E,
                        slides: function() {
                            for (var e = [], t = w; t <= E; t += 1) e.push(h[t]);
                            return e
                        }()
                    }), void S();
                    var C = [],
                        k = [];
                    if (e) t.$wrapperEl.find("." + t.params.slideClass).remove();
                    else
                        for (var T = d; T <= u; T += 1)(T < w || E < T) && t.$wrapperEl.find("." + t.params.slideClass + '[data-swiper-slide-index="' + T + '"]').remove();
                    for (var _ = 0; _ < h.length; _ += 1) w <= _ && _ <= E && (void 0 === u || e ? k.push(_) : (u < _ && k.push(_), _ < d && C.push(_)));
                    k.forEach(function(e) {
                        t.$wrapperEl.append(f(h[e], e))
                    }), C.sort(function(e, t) {
                        return t - e
                    }).forEach(function(e) {
                        t.$wrapperEl.prepend(f(h[e], e))
                    }), t.$wrapperEl.children(".swiper-slide").css(m, x + "px"), S()
                },
                renderSlide: function(e, t) {
                    var i = this.params.virtual;
                    if (i.cache && this.virtual.cache[t]) return this.virtual.cache[t];
                    var n = i.renderSlide ? O(i.renderSlide.call(this, e, t)) : O('<div class="' + this.params.slideClass + '" data-swiper-slide-index="' + t + '">' + e + "</div>");
                    return n.attr("data-swiper-slide-index") || n.attr("data-swiper-slide-index", t), i.cache && (this.virtual.cache[t] = n), n
                },
                appendSlide: function(e) {
                    this.virtual.slides.push(e), this.virtual.update(!0)
                },
                prependSlide: function(e) {
                    if (this.virtual.slides.unshift(e), this.params.virtual.cache) {
                        var t = this.virtual.cache,
                            i = {};
                        Object.keys(t).forEach(function(e) {
                            i[e + 1] = t[e]
                        }), this.virtual.cache = i
                    }
                    this.virtual.update(!0), this.slideNext(0)
                }
            },
            j = {
                name: "virtual",
                params: {
                    virtual: {
                        enabled: !1,
                        slides: [],
                        cache: !0,
                        renderSlide: null,
                        renderExternal: null,
                        addSlidesBefore: 0,
                        addSlidesAfter: 0
                    }
                },
                create: function() {
                    $.extend(this, {
                        virtual: {
                            update: N.update.bind(this),
                            appendSlide: N.appendSlide.bind(this),
                            prependSlide: N.prependSlide.bind(this),
                            renderSlide: N.renderSlide.bind(this),
                            slides: this.params.virtual.slides,
                            cache: {}
                        }
                    })
                },
                on: {
                    beforeInit: function() {
                        if (this.params.virtual.enabled) {
                            this.classNames.push(this.params.containerModifierClass + "virtual");
                            var e = {
                                watchSlidesProgress: !0
                            };
                            $.extend(this.params, e), $.extend(this.originalParams, e), this.params.initialSlide || this.virtual.update()
                        }
                    },
                    setTranslate: function() {
                        this.params.virtual.enabled && this.virtual.update()
                    }
                }
            },
            R = {
                handle: function(e) {
                    var t = this,
                        i = t.rtlTranslate,
                        n = e;
                    n.originalEvent && (n = n.originalEvent);
                    var a = n.keyCode || n.charCode;
                    if (!t.allowSlideNext && (t.isHorizontal() && 39 === a || t.isVertical() && 40 === a)) return !1;
                    if (!t.allowSlidePrev && (t.isHorizontal() && 37 === a || t.isVertical() && 38 === a)) return !1;
                    if (!(n.shiftKey || n.altKey || n.ctrlKey || n.metaKey || v.activeElement && v.activeElement.nodeName && ("input" === v.activeElement.nodeName.toLowerCase() || "textarea" === v.activeElement.nodeName.toLowerCase()))) {
                        if (t.params.keyboard.onlyInViewport && (37 === a || 39 === a || 38 === a || 40 === a)) {
                            var r = !1;
                            if (0 < t.$el.parents("." + t.params.slideClass).length && 0 === t.$el.parents("." + t.params.slideActiveClass).length) return;
                            var s = B.innerWidth,
                                o = B.innerHeight,
                                l = t.$el.offset();
                            i && (l.left -= t.$el[0].scrollLeft);
                            for (var c = [
                                    [l.left, l.top],
                                    [l.left + t.width, l.top],
                                    [l.left, l.top + t.height],
                                    [l.left + t.width, l.top + t.height]
                                ], d = 0; d < c.length; d += 1) {
                                var u = c[d];
                                0 <= u[0] && u[0] <= s && 0 <= u[1] && u[1] <= o && (r = !0)
                            }
                            if (!r) return
                        }
                        t.isHorizontal() ? (37 !== a && 39 !== a || (n.preventDefault ? n.preventDefault() : n.returnValue = !1), (39 === a && !i || 37 === a && i) && t.slideNext(), (37 === a && !i || 39 === a && i) && t.slidePrev()) : (38 !== a && 40 !== a || (n.preventDefault ? n.preventDefault() : n.returnValue = !1), 40 === a && t.slideNext(), 38 === a && t.slidePrev()), t.emit("keyPress", a)
                    }
                },
                enable: function() {
                    this.keyboard.enabled || (O(v).on("keydown", this.keyboard.handle), this.keyboard.enabled = !0)
                },
                disable: function() {
                    this.keyboard.enabled && (O(v).off("keydown", this.keyboard.handle), this.keyboard.enabled = !1)
                }
            },
            H = {
                name: "keyboard",
                params: {
                    keyboard: {
                        enabled: !1,
                        onlyInViewport: !0
                    }
                },
                create: function() {
                    $.extend(this, {
                        keyboard: {
                            enabled: !1,
                            enable: R.enable.bind(this),
                            disable: R.disable.bind(this),
                            handle: R.handle.bind(this)
                        }
                    })
                },
                on: {
                    init: function() {
                        this.params.keyboard.enabled && this.keyboard.enable()
                    },
                    destroy: function() {
                        this.keyboard.enabled && this.keyboard.disable()
                    }
                }
            },
            Y = {
                lastScrollTime: $.now(),
                event: -1 < B.navigator.userAgent.indexOf("firefox") ? "DOMMouseScroll" : function() {
                    var e = "onwheel",
                        t = e in v;
                    if (!t) {
                        var i = v.createElement("div");
                        i.setAttribute(e, "return;"), t = "function" == typeof i[e]
                    }
                    return !t && v.implementation && v.implementation.hasFeature && !0 !== v.implementation.hasFeature("", "") && (t = v.implementation.hasFeature("Events.wheel", "3.0")), t
                }() ? "wheel" : "mousewheel",
                normalize: function(e) {
                    var t = 0,
                        i = 0,
                        n = 0,
                        a = 0;
                    return "detail" in e && (i = e.detail), "wheelDelta" in e && (i = -e.wheelDelta / 120), "wheelDeltaY" in e && (i = -e.wheelDeltaY / 120), "wheelDeltaX" in e && (t = -e.wheelDeltaX / 120), "axis" in e && e.axis === e.HORIZONTAL_AXIS && (t = i, i = 0), n = 10 * t, a = 10 * i, "deltaY" in e && (a = e.deltaY), "deltaX" in e && (n = e.deltaX), (n || a) && e.deltaMode && (1 === e.deltaMode ? (n *= 40, a *= 40) : (n *= 800, a *= 800)), n && !t && (t = n < 1 ? -1 : 1), a && !i && (i = a < 1 ? -1 : 1), {
                        spinX: t,
                        spinY: i,
                        pixelX: n,
                        pixelY: a
                    }
                },
                handleMouseEnter: function() {
                    this.mouseEntered = !0
                },
                handleMouseLeave: function() {
                    this.mouseEntered = !1
                },
                handle: function(e) {
                    var t = e,
                        i = this,
                        n = i.params.mousewheel;
                    if (!i.mouseEntered && !n.releaseOnEdges) return !0;
                    t.originalEvent && (t = t.originalEvent);
                    var a = 0,
                        r = i.rtlTranslate ? -1 : 1,
                        s = Y.normalize(t);
                    if (n.forceToAxis)
                        if (i.isHorizontal()) {
                            if (!(Math.abs(s.pixelX) > Math.abs(s.pixelY))) return !0;
                            a = s.pixelX * r
                        } else {
                            if (!(Math.abs(s.pixelY) > Math.abs(s.pixelX))) return !0;
                            a = s.pixelY
                        }
                    else a = Math.abs(s.pixelX) > Math.abs(s.pixelY) ? -s.pixelX * r : -s.pixelY;
                    if (0 === a) return !0;
                    if (n.invert && (a = -a), i.params.freeMode) {
                        i.params.loop && i.loopFix();
                        var o = i.getTranslate() + a * n.sensitivity,
                            l = i.isBeginning,
                            c = i.isEnd;
                        if (o >= i.minTranslate() && (o = i.minTranslate()), o <= i.maxTranslate() && (o = i.maxTranslate()), i.setTransition(0), i.setTranslate(o), i.updateProgress(), i.updateActiveIndex(), i.updateSlidesClasses(), (!l && i.isBeginning || !c && i.isEnd) && i.updateSlidesClasses(), i.params.freeModeSticky && (clearTimeout(i.mousewheel.timeout), i.mousewheel.timeout = $.nextTick(function() {
                                i.slideToClosest()
                            }, 300)), i.emit("scroll", t), i.params.autoplay && i.params.autoplayDisableOnInteraction && i.autoplay.stop(), o === i.minTranslate() || o === i.maxTranslate()) return !0
                    } else {
                        if (60 < $.now() - i.mousewheel.lastScrollTime)
                            if (a < 0)
                                if (i.isEnd && !i.params.loop || i.animating) {
                                    if (n.releaseOnEdges) return !0
                                } else i.slideNext(), i.emit("scroll", t);
                        else if (i.isBeginning && !i.params.loop || i.animating) {
                            if (n.releaseOnEdges) return !0
                        } else i.slidePrev(), i.emit("scroll", t);
                        i.mousewheel.lastScrollTime = (new B.Date).getTime()
                    }
                    return t.preventDefault ? t.preventDefault() : t.returnValue = !1, !1
                },
                enable: function() {
                    if (!Y.event) return !1;
                    if (this.mousewheel.enabled) return !1;
                    var e = this.$el;
                    return "container" !== this.params.mousewheel.eventsTarged && (e = O(this.params.mousewheel.eventsTarged)), e.on("mouseenter", this.mousewheel.handleMouseEnter), e.on("mouseleave", this.mousewheel.handleMouseLeave), e.on(Y.event, this.mousewheel.handle), this.mousewheel.enabled = !0
                },
                disable: function() {
                    if (!Y.event) return !1;
                    if (!this.mousewheel.enabled) return !1;
                    var e = this.$el;
                    return "container" !== this.params.mousewheel.eventsTarged && (e = O(this.params.mousewheel.eventsTarged)), e.off(Y.event, this.mousewheel.handle), !(this.mousewheel.enabled = !1)
                }
            },
            V = {
                update: function() {
                    var e = this.params.navigation;
                    if (!this.params.loop) {
                        var t = this.navigation,
                            i = t.$nextEl,
                            n = t.$prevEl;
                        n && 0 < n.length && (this.isBeginning ? n.addClass(e.disabledClass) : n.removeClass(e.disabledClass), n[this.params.watchOverflow && this.isLocked ? "addClass" : "removeClass"](e.lockClass)), i && 0 < i.length && (this.isEnd ? i.addClass(e.disabledClass) : i.removeClass(e.disabledClass), i[this.params.watchOverflow && this.isLocked ? "addClass" : "removeClass"](e.lockClass))
                    }
                },
                onPrevClick: function(e) {
                    e.preventDefault(), this.isBeginning && !this.params.loop || this.slidePrev()
                },
                onNextClick: function(e) {
                    e.preventDefault(), this.isEnd && !this.params.loop || this.slideNext()
                },
                init: function() {
                    var e, t, i = this,
                        n = i.params.navigation;
                    (n.nextEl || n.prevEl) && (n.nextEl && (e = O(n.nextEl), i.params.uniqueNavElements && "string" == typeof n.nextEl && 1 < e.length && 1 === i.$el.find(n.nextEl).length && (e = i.$el.find(n.nextEl))), n.prevEl && (t = O(n.prevEl), i.params.uniqueNavElements && "string" == typeof n.prevEl && 1 < t.length && 1 === i.$el.find(n.prevEl).length && (t = i.$el.find(n.prevEl))), e && 0 < e.length && e.on("click", i.navigation.onNextClick), t && 0 < t.length && t.on("click", i.navigation.onPrevClick), $.extend(i.navigation, {
                        $nextEl: e,
                        nextEl: e && e[0],
                        $prevEl: t,
                        prevEl: t && t[0]
                    }))
                },
                destroy: function() {
                    var e = this.navigation,
                        t = e.$nextEl,
                        i = e.$prevEl;
                    t && t.length && (t.off("click", this.navigation.onNextClick), t.removeClass(this.params.navigation.disabledClass)), i && i.length && (i.off("click", this.navigation.onPrevClick), i.removeClass(this.params.navigation.disabledClass))
                }
            },
            G = {
                update: function() {
                    var e = this,
                        t = e.rtl,
                        a = e.params.pagination;
                    if (a.el && e.pagination.el && e.pagination.$el && 0 !== e.pagination.$el.length) {
                        var r, i = e.virtual && e.params.virtual.enabled ? e.virtual.slides.length : e.slides.length,
                            n = e.pagination.$el,
                            s = e.params.loop ? Math.ceil((i - 2 * e.loopedSlides) / e.params.slidesPerGroup) : e.snapGrid.length;
                        if (e.params.loop ? ((r = Math.ceil((e.activeIndex - e.loopedSlides) / e.params.slidesPerGroup)) > i - 1 - 2 * e.loopedSlides && (r -= i - 2 * e.loopedSlides), s - 1 < r && (r -= s), r < 0 && "bullets" !== e.params.paginationType && (r = s + r)) : r = void 0 !== e.snapIndex ? e.snapIndex : e.activeIndex || 0, "bullets" === a.type && e.pagination.bullets && 0 < e.pagination.bullets.length) {
                            var o, l, c, d = e.pagination.bullets;
                            if (a.dynamicBullets && (e.pagination.bulletSize = d.eq(0)[e.isHorizontal() ? "outerWidth" : "outerHeight"](!0), n.css(e.isHorizontal() ? "width" : "height", e.pagination.bulletSize * (a.dynamicMainBullets + 4) + "px"), 1 < a.dynamicMainBullets && void 0 !== e.previousIndex && (e.pagination.dynamicBulletIndex += r - e.previousIndex, e.pagination.dynamicBulletIndex > a.dynamicMainBullets - 1 ? e.pagination.dynamicBulletIndex = a.dynamicMainBullets - 1 : e.pagination.dynamicBulletIndex < 0 && (e.pagination.dynamicBulletIndex = 0)), o = r - e.pagination.dynamicBulletIndex, l = o + (Math.min(d.length, a.dynamicMainBullets) - 1), c = (l + o) / 2), d.removeClass(a.bulletActiveClass + " " + a.bulletActiveClass + "-next " + a.bulletActiveClass + "-next-next " + a.bulletActiveClass + "-prev " + a.bulletActiveClass + "-prev-prev " + a.bulletActiveClass + "-main"), 1 < n.length) d.each(function(e, t) {
                                var i = O(t),
                                    n = i.index();
                                n === r && i.addClass(a.bulletActiveClass), a.dynamicBullets && (o <= n && n <= l && i.addClass(a.bulletActiveClass + "-main"), n === o && i.prev().addClass(a.bulletActiveClass + "-prev").prev().addClass(a.bulletActiveClass + "-prev-prev"), n === l && i.next().addClass(a.bulletActiveClass + "-next").next().addClass(a.bulletActiveClass + "-next-next"))
                            });
                            else {
                                var u = d.eq(r);
                                if (u.addClass(a.bulletActiveClass), a.dynamicBullets) {
                                    for (var h = d.eq(o), p = d.eq(l), f = o; f <= l; f += 1) d.eq(f).addClass(a.bulletActiveClass + "-main");
                                    h.prev().addClass(a.bulletActiveClass + "-prev").prev().addClass(a.bulletActiveClass + "-prev-prev"), p.next().addClass(a.bulletActiveClass + "-next").next().addClass(a.bulletActiveClass + "-next-next")
                                }
                            }
                            if (a.dynamicBullets) {
                                var v = Math.min(d.length, a.dynamicMainBullets + 4),
                                    m = (e.pagination.bulletSize * v - e.pagination.bulletSize) / 2 - c * e.pagination.bulletSize,
                                    g = t ? "right" : "left";
                                d.css(e.isHorizontal() ? g : "top", m + "px")
                            }
                        }
                        if ("fraction" === a.type && (n.find("." + a.currentClass).text(a.formatFractionCurrent(r + 1)), n.find("." + a.totalClass).text(a.formatFractionTotal(s))), "progressbar" === a.type) {
                            var y;
                            y = a.progressbarOpposite ? e.isHorizontal() ? "vertical" : "horizontal" : e.isHorizontal() ? "horizontal" : "vertical";
                            var b = (r + 1) / s,
                                w = 1,
                                E = 1;
                            "horizontal" === y ? w = b : E = b, n.find("." + a.progressbarFillClass).transform("translate3d(0,0,0) scaleX(" + w + ") scaleY(" + E + ")").transition(e.params.speed)
                        }
                        "custom" === a.type && a.renderCustom ? (n.html(a.renderCustom(e, r + 1, s)), e.emit("paginationRender", e, n[0])) : e.emit("paginationUpdate", e, n[0]), n[e.params.watchOverflow && e.isLocked ? "addClass" : "removeClass"](a.lockClass)
                    }
                },
                render: function() {
                    var e = this,
                        t = e.params.pagination;
                    if (t.el && e.pagination.el && e.pagination.$el && 0 !== e.pagination.$el.length) {
                        var i = e.virtual && e.params.virtual.enabled ? e.virtual.slides.length : e.slides.length,
                            n = e.pagination.$el,
                            a = "";
                        if ("bullets" === t.type) {
                            for (var r = e.params.loop ? Math.ceil((i - 2 * e.loopedSlides) / e.params.slidesPerGroup) : e.snapGrid.length, s = 0; s < r; s += 1) t.renderBullet ? a += t.renderBullet.call(e, s, t.bulletClass) : a += "<" + t.bulletElement + ' class="' + t.bulletClass + '"></' + t.bulletElement + ">";
                            n.html(a), e.pagination.bullets = n.find("." + t.bulletClass)
                        }
                        "fraction" === t.type && (a = t.renderFraction ? t.renderFraction.call(e, t.currentClass, t.totalClass) : '<span class="' + t.currentClass + '"></span> / <span class="' + t.totalClass + '"></span>', n.html(a)), "progressbar" === t.type && (a = t.renderProgressbar ? t.renderProgressbar.call(e, t.progressbarFillClass) : '<span class="' + t.progressbarFillClass + '"></span>', n.html(a)), "custom" !== t.type && e.emit("paginationRender", e.pagination.$el[0])
                    }
                },
                init: function() {
                    var i = this,
                        e = i.params.pagination;
                    if (e.el) {
                        var t = O(e.el);
                        0 !== t.length && (i.params.uniqueNavElements && "string" == typeof e.el && 1 < t.length && 1 === i.$el.find(e.el).length && (t = i.$el.find(e.el)), "bullets" === e.type && e.clickable && t.addClass(e.clickableClass), t.addClass(e.modifierClass + e.type), "bullets" === e.type && e.dynamicBullets && (t.addClass("" + e.modifierClass + e.type + "-dynamic"), i.pagination.dynamicBulletIndex = 0, e.dynamicMainBullets < 1 && (e.dynamicMainBullets = 1)), "progressbar" === e.type && e.progressbarOpposite && t.addClass(e.progressbarOppositeClass), e.clickable && t.on("click", "." + e.bulletClass, function(e) {
                            e.preventDefault();
                            var t = O(this).index() * i.params.slidesPerGroup;
                            i.params.loop && (t += i.loopedSlides), i.slideTo(t)
                        }), $.extend(i.pagination, {
                            $el: t,
                            el: t[0]
                        }))
                    }
                },
                destroy: function() {
                    var e = this.params.pagination;
                    if (e.el && this.pagination.el && this.pagination.$el && 0 !== this.pagination.$el.length) {
                        var t = this.pagination.$el;
                        t.removeClass(e.hiddenClass), t.removeClass(e.modifierClass + e.type), this.pagination.bullets && this.pagination.bullets.removeClass(e.bulletActiveClass), e.clickable && t.off("click", "." + e.bulletClass)
                    }
                }
            },
            U = {
                setTranslate: function() {
                    if (this.params.scrollbar.el && this.scrollbar.el) {
                        var e = this.scrollbar,
                            t = this.rtlTranslate,
                            i = this.progress,
                            n = e.dragSize,
                            a = e.trackSize,
                            r = e.$dragEl,
                            s = e.$el,
                            o = this.params.scrollbar,
                            l = n,
                            c = (a - n) * i;
                        t ? 0 < (c = -c) ? (l = n - c, c = 0) : a < -c + n && (l = a + c) : c < 0 ? (l = n + c, c = 0) : a < c + n && (l = a - c), this.isHorizontal() ? (q.transforms3d ? r.transform("translate3d(" + c + "px, 0, 0)") : r.transform("translateX(" + c + "px)"), r[0].style.width = l + "px") : (q.transforms3d ? r.transform("translate3d(0px, " + c + "px, 0)") : r.transform("translateY(" + c + "px)"), r[0].style.height = l + "px"), o.hide && (clearTimeout(this.scrollbar.timeout), s[0].style.opacity = 1, this.scrollbar.timeout = setTimeout(function() {
                            s[0].style.opacity = 0, s.transition(400)
                        }, 1e3))
                    }
                },
                setTransition: function(e) {
                    this.params.scrollbar.el && this.scrollbar.el && this.scrollbar.$dragEl.transition(e)
                },
                updateSize: function() {
                    var e = this;
                    if (e.params.scrollbar.el && e.scrollbar.el) {
                        var t = e.scrollbar,
                            i = t.$dragEl,
                            n = t.$el;
                        i[0].style.width = "", i[0].style.height = "";
                        var a, r = e.isHorizontal() ? n[0].offsetWidth : n[0].offsetHeight,
                            s = e.size / e.virtualSize,
                            o = s * (r / e.size);
                        a = "auto" === e.params.scrollbar.dragSize ? r * s : parseInt(e.params.scrollbar.dragSize, 10), e.isHorizontal() ? i[0].style.width = a + "px" : i[0].style.height = a + "px", n[0].style.display = 1 <= s ? "none" : "", e.params.scrollbarHide && (n[0].style.opacity = 0), $.extend(t, {
                            trackSize: r,
                            divider: s,
                            moveDivider: o,
                            dragSize: a
                        }), t.$el[e.params.watchOverflow && e.isLocked ? "addClass" : "removeClass"](e.params.scrollbar.lockClass)
                    }
                },
                setDragPosition: function(e) {
                    var t, i, n = this,
                        a = n.scrollbar,
                        r = n.rtlTranslate,
                        s = a.$el,
                        o = a.dragSize,
                        l = a.trackSize;
                    t = n.isHorizontal() ? "touchstart" === e.type || "touchmove" === e.type ? e.targetTouches[0].pageX : e.pageX || e.clientX : "touchstart" === e.type || "touchmove" === e.type ? e.targetTouches[0].pageY : e.pageY || e.clientY, i = (t - s.offset()[n.isHorizontal() ? "left" : "top"] - o / 2) / (l - o), i = Math.max(Math.min(i, 1), 0), r && (i = 1 - i);
                    var c = n.minTranslate() + (n.maxTranslate() - n.minTranslate()) * i;
                    n.updateProgress(c), n.setTranslate(c), n.updateActiveIndex(), n.updateSlidesClasses()
                },
                onDragStart: function(e) {
                    var t = this.params.scrollbar,
                        i = this.scrollbar,
                        n = this.$wrapperEl,
                        a = i.$el,
                        r = i.$dragEl;
                    this.scrollbar.isTouched = !0, e.preventDefault(), e.stopPropagation(), n.transition(100), r.transition(100), i.setDragPosition(e), clearTimeout(this.scrollbar.dragTimeout), a.transition(0), t.hide && a.css("opacity", 1), this.emit("scrollbarDragStart", e)
                },
                onDragMove: function(e) {
                    var t = this.scrollbar,
                        i = this.$wrapperEl,
                        n = t.$el,
                        a = t.$dragEl;
                    this.scrollbar.isTouched && (e.preventDefault ? e.preventDefault() : e.returnValue = !1, t.setDragPosition(e), i.transition(0), n.transition(0), a.transition(0), this.emit("scrollbarDragMove", e))
                },
                onDragEnd: function(e) {
                    var t = this.params.scrollbar,
                        i = this.scrollbar,
                        n = i.$el;
                    this.scrollbar.isTouched && (this.scrollbar.isTouched = !1, t.hide && (clearTimeout(this.scrollbar.dragTimeout), this.scrollbar.dragTimeout = $.nextTick(function() {
                        n.css("opacity", 0), n.transition(400)
                    }, 1e3)), this.emit("scrollbarDragEnd", e), t.snapOnRelease && this.slideToClosest())
                },
                enableDraggable: function() {
                    var e = this;
                    if (e.params.scrollbar.el) {
                        var t = e.scrollbar,
                            i = e.touchEventsTouch,
                            n = e.touchEventsDesktop,
                            a = e.params,
                            r = t.$el,
                            s = r[0],
                            o = !(!q.passiveListener || !a.passiveListeners) && {
                                passive: !1,
                                capture: !1
                            },
                            l = !(!q.passiveListener || !a.passiveListeners) && {
                                passive: !0,
                                capture: !1
                            };
                        q.touch ? (s.addEventListener(i.start, e.scrollbar.onDragStart, o), s.addEventListener(i.move, e.scrollbar.onDragMove, o), s.addEventListener(i.end, e.scrollbar.onDragEnd, l)) : (s.addEventListener(n.start, e.scrollbar.onDragStart, o), v.addEventListener(n.move, e.scrollbar.onDragMove, o), v.addEventListener(n.end, e.scrollbar.onDragEnd, l))
                    }
                },
                disableDraggable: function() {
                    var e = this;
                    if (e.params.scrollbar.el) {
                        var t = e.scrollbar,
                            i = e.touchEventsTouch,
                            n = e.touchEventsDesktop,
                            a = e.params,
                            r = t.$el,
                            s = r[0],
                            o = !(!q.passiveListener || !a.passiveListeners) && {
                                passive: !1,
                                capture: !1
                            },
                            l = !(!q.passiveListener || !a.passiveListeners) && {
                                passive: !0,
                                capture: !1
                            };
                        q.touch ? (s.removeEventListener(i.start, e.scrollbar.onDragStart, o), s.removeEventListener(i.move, e.scrollbar.onDragMove, o), s.removeEventListener(i.end, e.scrollbar.onDragEnd, l)) : (s.removeEventListener(n.start, e.scrollbar.onDragStart, o), v.removeEventListener(n.move, e.scrollbar.onDragMove, o), v.removeEventListener(n.end, e.scrollbar.onDragEnd, l))
                    }
                },
                init: function() {
                    if (this.params.scrollbar.el) {
                        var e = this.scrollbar,
                            t = this.$el,
                            i = this.params.scrollbar,
                            n = O(i.el);
                        this.params.uniqueNavElements && "string" == typeof i.el && 1 < n.length && 1 === t.find(i.el).length && (n = t.find(i.el));
                        var a = n.find("." + this.params.scrollbar.dragClass);
                        0 === a.length && (a = O('<div class="' + this.params.scrollbar.dragClass + '"></div>'), n.append(a)), $.extend(e, {
                            $el: n,
                            el: n[0],
                            $dragEl: a,
                            dragEl: a[0]
                        }), i.draggable && e.enableDraggable()
                    }
                },
                destroy: function() {
                    this.scrollbar.disableDraggable()
                }
            },
            W = {
                setTransform: function(e, t) {
                    var i = this.rtl,
                        n = O(e),
                        a = i ? -1 : 1,
                        r = n.attr("data-swiper-parallax") || "0",
                        s = n.attr("data-swiper-parallax-x"),
                        o = n.attr("data-swiper-parallax-y"),
                        l = n.attr("data-swiper-parallax-scale"),
                        c = n.attr("data-swiper-parallax-opacity");
                    if (s || o ? (s = s || "0", o = o || "0") : this.isHorizontal() ? (s = r, o = "0") : (o = r, s = "0"), s = 0 <= s.indexOf("%") ? parseInt(s, 10) * t * a + "%" : s * t * a + "px", o = 0 <= o.indexOf("%") ? parseInt(o, 10) * t + "%" : o * t + "px", null != c) {
                        var d = c - (c - 1) * (1 - Math.abs(t));
                        n[0].style.opacity = d
                    }
                    if (null == l) n.transform("translate3d(" + s + ", " + o + ", 0px)");
                    else {
                        var u = l - (l - 1) * (1 - Math.abs(t));
                        n.transform("translate3d(" + s + ", " + o + ", 0px) scale(" + u + ")")
                    }
                },
                setTranslate: function() {
                    var n = this,
                        e = n.$el,
                        t = n.slides,
                        a = n.progress,
                        r = n.snapGrid;
                    e.children("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]").each(function(e, t) {
                        n.parallax.setTransform(t, a)
                    }), t.each(function(e, t) {
                        var i = t.progress;
                        1 < n.params.slidesPerGroup && "auto" !== n.params.slidesPerView && (i += Math.ceil(e / 2) - a * (r.length - 1)), i = Math.min(Math.max(i, -1), 1), O(t).find("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]").each(function(e, t) {
                            n.parallax.setTransform(t, i)
                        })
                    })
                },
                setTransition: function(a) {
                    void 0 === a && (a = this.params.speed);
                    var e = this.$el;
                    e.find("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]").each(function(e, t) {
                        var i = O(t),
                            n = parseInt(i.attr("data-swiper-parallax-duration"), 10) || a;
                        0 === a && (n = 0), i.transition(n)
                    })
                }
            },
            X = {
                getDistanceBetweenTouches: function(e) {
                    if (e.targetTouches.length < 2) return 1;
                    var t = e.targetTouches[0].pageX,
                        i = e.targetTouches[0].pageY,
                        n = e.targetTouches[1].pageX,
                        a = e.targetTouches[1].pageY,
                        r = Math.sqrt(Math.pow(n - t, 2) + Math.pow(a - i, 2));
                    return r
                },
                onGestureStart: function(e) {
                    var t = this.params.zoom,
                        i = this.zoom,
                        n = i.gesture;
                    if (i.fakeGestureTouched = !1, i.fakeGestureMoved = !1, !q.gestures) {
                        if ("touchstart" !== e.type || "touchstart" === e.type && e.targetTouches.length < 2) return;
                        i.fakeGestureTouched = !0, n.scaleStart = X.getDistanceBetweenTouches(e)
                    }
                    n.$slideEl && n.$slideEl.length || (n.$slideEl = O(e.target).closest(".swiper-slide"), 0 === n.$slideEl.length && (n.$slideEl = this.slides.eq(this.activeIndex)), n.$imageEl = n.$slideEl.find("img, svg, canvas"), n.$imageWrapEl = n.$imageEl.parent("." + t.containerClass), n.maxRatio = n.$imageWrapEl.attr("data-swiper-zoom") || t.maxRatio, 0 !== n.$imageWrapEl.length) ? (n.$imageEl.transition(0), this.zoom.isScaling = !0) : n.$imageEl = void 0
                },
                onGestureChange: function(e) {
                    var t = this.params.zoom,
                        i = this.zoom,
                        n = i.gesture;
                    if (!q.gestures) {
                        if ("touchmove" !== e.type || "touchmove" === e.type && e.targetTouches.length < 2) return;
                        i.fakeGestureMoved = !0, n.scaleMove = X.getDistanceBetweenTouches(e)
                    }
                    n.$imageEl && 0 !== n.$imageEl.length && (q.gestures ? this.zoom.scale = e.scale * i.currentScale : i.scale = n.scaleMove / n.scaleStart * i.currentScale, i.scale > n.maxRatio && (i.scale = n.maxRatio - 1 + Math.pow(i.scale - n.maxRatio + 1, .5)), i.scale < t.minRatio && (i.scale = t.minRatio + 1 - Math.pow(t.minRatio - i.scale + 1, .5)), n.$imageEl.transform("translate3d(0,0,0) scale(" + i.scale + ")"))
                },
                onGestureEnd: function(e) {
                    var t = this.params.zoom,
                        i = this.zoom,
                        n = i.gesture;
                    if (!q.gestures) {
                        if (!i.fakeGestureTouched || !i.fakeGestureMoved) return;
                        if ("touchend" !== e.type || "touchend" === e.type && e.changedTouches.length < 2 && !m.android) return;
                        i.fakeGestureTouched = !1, i.fakeGestureMoved = !1
                    }
                    n.$imageEl && 0 !== n.$imageEl.length && (i.scale = Math.max(Math.min(i.scale, n.maxRatio), t.minRatio), n.$imageEl.transition(this.params.speed).transform("translate3d(0,0,0) scale(" + i.scale + ")"), i.currentScale = i.scale, i.isScaling = !1, 1 === i.scale && (n.$slideEl = void 0))
                },
                onTouchStart: function(e) {
                    var t = this.zoom,
                        i = t.gesture,
                        n = t.image;
                    i.$imageEl && 0 !== i.$imageEl.length && (n.isTouched || (m.android && e.preventDefault(), n.isTouched = !0, n.touchesStart.x = "touchstart" === e.type ? e.targetTouches[0].pageX : e.pageX, n.touchesStart.y = "touchstart" === e.type ? e.targetTouches[0].pageY : e.pageY))
                },
                onTouchMove: function(e) {
                    var t = this.zoom,
                        i = t.gesture,
                        n = t.image,
                        a = t.velocity;
                    if (i.$imageEl && 0 !== i.$imageEl.length && (this.allowClick = !1, n.isTouched && i.$slideEl)) {
                        n.isMoved || (n.width = i.$imageEl[0].offsetWidth, n.height = i.$imageEl[0].offsetHeight, n.startX = $.getTranslate(i.$imageWrapEl[0], "x") || 0, n.startY = $.getTranslate(i.$imageWrapEl[0], "y") || 0, i.slideWidth = i.$slideEl[0].offsetWidth, i.slideHeight = i.$slideEl[0].offsetHeight, i.$imageWrapEl.transition(0), this.rtl && (n.startX = -n.startX, n.startY = -n.startY));
                        var r = n.width * t.scale,
                            s = n.height * t.scale;
                        if (!(r < i.slideWidth && s < i.slideHeight)) {
                            if (n.minX = Math.min(i.slideWidth / 2 - r / 2, 0), n.maxX = -n.minX, n.minY = Math.min(i.slideHeight / 2 - s / 2, 0), n.maxY = -n.minY, n.touchesCurrent.x = "touchmove" === e.type ? e.targetTouches[0].pageX : e.pageX, n.touchesCurrent.y = "touchmove" === e.type ? e.targetTouches[0].pageY : e.pageY, !n.isMoved && !t.isScaling) {
                                if (this.isHorizontal() && (Math.floor(n.minX) === Math.floor(n.startX) && n.touchesCurrent.x < n.touchesStart.x || Math.floor(n.maxX) === Math.floor(n.startX) && n.touchesCurrent.x > n.touchesStart.x)) return void(n.isTouched = !1);
                                if (!this.isHorizontal() && (Math.floor(n.minY) === Math.floor(n.startY) && n.touchesCurrent.y < n.touchesStart.y || Math.floor(n.maxY) === Math.floor(n.startY) && n.touchesCurrent.y > n.touchesStart.y)) return void(n.isTouched = !1)
                            }
                            e.preventDefault(), e.stopPropagation(), n.isMoved = !0, n.currentX = n.touchesCurrent.x - n.touchesStart.x + n.startX, n.currentY = n.touchesCurrent.y - n.touchesStart.y + n.startY, n.currentX < n.minX && (n.currentX = n.minX + 1 - Math.pow(n.minX - n.currentX + 1, .8)), n.currentX > n.maxX && (n.currentX = n.maxX - 1 + Math.pow(n.currentX - n.maxX + 1, .8)), n.currentY < n.minY && (n.currentY = n.minY + 1 - Math.pow(n.minY - n.currentY + 1, .8)), n.currentY > n.maxY && (n.currentY = n.maxY - 1 + Math.pow(n.currentY - n.maxY + 1, .8)), a.prevPositionX || (a.prevPositionX = n.touchesCurrent.x), a.prevPositionY || (a.prevPositionY = n.touchesCurrent.y), a.prevTime || (a.prevTime = Date.now()), a.x = (n.touchesCurrent.x - a.prevPositionX) / (Date.now() - a.prevTime) / 2, a.y = (n.touchesCurrent.y - a.prevPositionY) / (Date.now() - a.prevTime) / 2, Math.abs(n.touchesCurrent.x - a.prevPositionX) < 2 && (a.x = 0), Math.abs(n.touchesCurrent.y - a.prevPositionY) < 2 && (a.y = 0), a.prevPositionX = n.touchesCurrent.x, a.prevPositionY = n.touchesCurrent.y, a.prevTime = Date.now(), i.$imageWrapEl.transform("translate3d(" + n.currentX + "px, " + n.currentY + "px,0)")
                        }
                    }
                },
                onTouchEnd: function() {
                    var e = this.zoom,
                        t = e.gesture,
                        i = e.image,
                        n = e.velocity;
                    if (t.$imageEl && 0 !== t.$imageEl.length) {
                        if (!i.isTouched || !i.isMoved) return i.isTouched = !1, void(i.isMoved = !1);
                        i.isTouched = !1, i.isMoved = !1;
                        var a = 300,
                            r = 300,
                            s = n.x * a,
                            o = i.currentX + s,
                            l = n.y * r,
                            c = i.currentY + l;
                        0 !== n.x && (a = Math.abs((o - i.currentX) / n.x)), 0 !== n.y && (r = Math.abs((c - i.currentY) / n.y));
                        var d = Math.max(a, r);
                        i.currentX = o, i.currentY = c;
                        var u = i.width * e.scale,
                            h = i.height * e.scale;
                        i.minX = Math.min(t.slideWidth / 2 - u / 2, 0), i.maxX = -i.minX, i.minY = Math.min(t.slideHeight / 2 - h / 2, 0), i.maxY = -i.minY, i.currentX = Math.max(Math.min(i.currentX, i.maxX), i.minX), i.currentY = Math.max(Math.min(i.currentY, i.maxY), i.minY), t.$imageWrapEl.transition(d).transform("translate3d(" + i.currentX + "px, " + i.currentY + "px,0)")
                    }
                },
                onTransitionEnd: function() {
                    var e = this.zoom,
                        t = e.gesture;
                    t.$slideEl && this.previousIndex !== this.activeIndex && (t.$imageEl.transform("translate3d(0,0,0) scale(1)"), t.$imageWrapEl.transform("translate3d(0,0,0)"), t.$slideEl = void 0, t.$imageEl = void 0, t.$imageWrapEl = void 0, e.scale = 1, e.currentScale = 1)
                },
                toggle: function(e) {
                    var t = this.zoom;
                    t.scale && 1 !== t.scale ? t.out() : t.in(e)
                },
                in: function(e) {
                    var t, i, n, a, r, s, o, l, c, d, u, h, p, f, v, m, g, y, b = this.zoom,
                        w = this.params.zoom,
                        E = b.gesture,
                        x = b.image;
                    E.$slideEl || (E.$slideEl = this.clickedSlide ? O(this.clickedSlide) : this.slides.eq(this.activeIndex), E.$imageEl = E.$slideEl.find("img, svg, canvas"), E.$imageWrapEl = E.$imageEl.parent("." + w.containerClass)), E.$imageEl && 0 !== E.$imageEl.length && (E.$slideEl.addClass("" + w.zoomedSlideClass), i = void 0 === x.touchesStart.x && e ? (t = "touchend" === e.type ? e.changedTouches[0].pageX : e.pageX, "touchend" === e.type ? e.changedTouches[0].pageY : e.pageY) : (t = x.touchesStart.x, x.touchesStart.y), b.scale = E.$imageWrapEl.attr("data-swiper-zoom") || w.maxRatio, b.currentScale = E.$imageWrapEl.attr("data-swiper-zoom") || w.maxRatio, e ? (g = E.$slideEl[0].offsetWidth, y = E.$slideEl[0].offsetHeight, n = E.$slideEl.offset().left, a = E.$slideEl.offset().top, r = n + g / 2 - t, s = a + y / 2 - i, c = E.$imageEl[0].offsetWidth, d = E.$imageEl[0].offsetHeight, u = c * b.scale, h = d * b.scale, p = Math.min(g / 2 - u / 2, 0), f = Math.min(y / 2 - h / 2, 0), v = -p, m = -f, o = r * b.scale, l = s * b.scale, o < p && (o = p), v < o && (o = v), l < f && (l = f), m < l && (l = m)) : l = o = 0, E.$imageWrapEl.transition(300).transform("translate3d(" + o + "px, " + l + "px,0)"), E.$imageEl.transition(300).transform("translate3d(0,0,0) scale(" + b.scale + ")"))
                },
                out: function() {
                    var e = this.zoom,
                        t = this.params.zoom,
                        i = e.gesture;
                    i.$slideEl || (i.$slideEl = this.clickedSlide ? O(this.clickedSlide) : this.slides.eq(this.activeIndex), i.$imageEl = i.$slideEl.find("img, svg, canvas"), i.$imageWrapEl = i.$imageEl.parent("." + t.containerClass)), i.$imageEl && 0 !== i.$imageEl.length && (e.scale = 1, e.currentScale = 1, i.$imageWrapEl.transition(300).transform("translate3d(0,0,0)"), i.$imageEl.transition(300).transform("translate3d(0,0,0) scale(1)"), i.$slideEl.removeClass("" + t.zoomedSlideClass), i.$slideEl = void 0)
                },
                enable: function() {
                    var e = this,
                        t = e.zoom;
                    if (!t.enabled) {
                        t.enabled = !0;
                        var i = !("touchstart" !== e.touchEvents.start || !q.passiveListener || !e.params.passiveListeners) && {
                            passive: !0,
                            capture: !1
                        };
                        q.gestures ? (e.$wrapperEl.on("gesturestart", ".swiper-slide", t.onGestureStart, i), e.$wrapperEl.on("gesturechange", ".swiper-slide", t.onGestureChange, i), e.$wrapperEl.on("gestureend", ".swiper-slide", t.onGestureEnd, i)) : "touchstart" === e.touchEvents.start && (e.$wrapperEl.on(e.touchEvents.start, ".swiper-slide", t.onGestureStart, i), e.$wrapperEl.on(e.touchEvents.move, ".swiper-slide", t.onGestureChange, i), e.$wrapperEl.on(e.touchEvents.end, ".swiper-slide", t.onGestureEnd, i)), e.$wrapperEl.on(e.touchEvents.move, "." + e.params.zoom.containerClass, t.onTouchMove)
                    }
                },
                disable: function() {
                    var e = this,
                        t = e.zoom;
                    if (t.enabled) {
                        e.zoom.enabled = !1;
                        var i = !("touchstart" !== e.touchEvents.start || !q.passiveListener || !e.params.passiveListeners) && {
                            passive: !0,
                            capture: !1
                        };
                        q.gestures ? (e.$wrapperEl.off("gesturestart", ".swiper-slide", t.onGestureStart, i), e.$wrapperEl.off("gesturechange", ".swiper-slide", t.onGestureChange, i), e.$wrapperEl.off("gestureend", ".swiper-slide", t.onGestureEnd, i)) : "touchstart" === e.touchEvents.start && (e.$wrapperEl.off(e.touchEvents.start, ".swiper-slide", t.onGestureStart, i), e.$wrapperEl.off(e.touchEvents.move, ".swiper-slide", t.onGestureChange, i), e.$wrapperEl.off(e.touchEvents.end, ".swiper-slide", t.onGestureEnd, i)), e.$wrapperEl.off(e.touchEvents.move, "." + e.params.zoom.containerClass, t.onTouchMove)
                    }
                }
            },
            K = {
                loadInSlide: function(e, l) {
                    void 0 === l && (l = !0);
                    var c = this,
                        d = c.params.lazy;
                    if (void 0 !== e && 0 !== c.slides.length) {
                        var t = c.virtual && c.params.virtual.enabled,
                            u = t ? c.$wrapperEl.children("." + c.params.slideClass + '[data-swiper-slide-index="' + e + '"]') : c.slides.eq(e),
                            i = u.find("." + d.elementClass + ":not(." + d.loadedClass + "):not(." + d.loadingClass + ")");
                        !u.hasClass(d.elementClass) || u.hasClass(d.loadedClass) || u.hasClass(d.loadingClass) || (i = i.add(u[0])), 0 !== i.length && i.each(function(e, t) {
                            var n = O(t);
                            n.addClass(d.loadingClass);
                            var a = n.attr("data-background"),
                                r = n.attr("data-src"),
                                s = n.attr("data-srcset"),
                                o = n.attr("data-sizes");
                            c.loadImage(n[0], r || a, s, o, !1, function() {
                                if (null != c && c && (!c || c.params) && !c.destroyed) {
                                    if (a ? (n.css("background-image", 'url("' + a + '")'), n.removeAttr("data-background")) : (s && (n.attr("srcset", s), n.removeAttr("data-srcset")), o && (n.attr("sizes", o), n.removeAttr("data-sizes")), r && (n.attr("src", r), n.removeAttr("data-src"))), n.addClass(d.loadedClass).removeClass(d.loadingClass), u.find("." + d.preloaderClass).remove(), c.params.loop && l) {
                                        var e = u.attr("data-swiper-slide-index");
                                        if (u.hasClass(c.params.slideDuplicateClass)) {
                                            var t = c.$wrapperEl.children('[data-swiper-slide-index="' + e + '"]:not(.' + c.params.slideDuplicateClass + ")");
                                            c.lazy.loadInSlide(t.index(), !1)
                                        } else {
                                            var i = c.$wrapperEl.children("." + c.params.slideDuplicateClass + '[data-swiper-slide-index="' + e + '"]');
                                            c.lazy.loadInSlide(i.index(), !1)
                                        }
                                    }
                                    c.emit("lazyImageReady", u[0], n[0])
                                }
                            }), c.emit("lazyImageLoad", u[0], n[0])
                        })
                    }
                },
                load: function() {
                    var n = this,
                        t = n.$wrapperEl,
                        i = n.params,
                        a = n.slides,
                        e = n.activeIndex,
                        r = n.virtual && i.virtual.enabled,
                        s = i.lazy,
                        o = i.slidesPerView;

                    function l(e) {
                        if (r) {
                            if (t.children("." + i.slideClass + '[data-swiper-slide-index="' + e + '"]').length) return !0
                        } else if (a[e]) return !0;
                        return !1
                    }

                    function c(e) {
                        return r ? O(e).attr("data-swiper-slide-index") : O(e).index()
                    }
                    if ("auto" === o && (o = 0), n.lazy.initialImageLoaded || (n.lazy.initialImageLoaded = !0), n.params.watchSlidesVisibility) t.children("." + i.slideVisibleClass).each(function(e, t) {
                        var i = r ? O(t).attr("data-swiper-slide-index") : O(t).index();
                        n.lazy.loadInSlide(i)
                    });
                    else if (1 < o)
                        for (var d = e; d < e + o; d += 1) l(d) && n.lazy.loadInSlide(d);
                    else n.lazy.loadInSlide(e);
                    if (s.loadPrevNext)
                        if (1 < o || s.loadPrevNextAmount && 1 < s.loadPrevNextAmount) {
                            for (var u = s.loadPrevNextAmount, h = o, p = Math.min(e + h + Math.max(u, h), a.length), f = Math.max(e - Math.max(h, u), 0), v = e + o; v < p; v += 1) l(v) && n.lazy.loadInSlide(v);
                            for (var m = f; m < e; m += 1) l(m) && n.lazy.loadInSlide(m)
                        } else {
                            var g = t.children("." + i.slideNextClass);
                            0 < g.length && n.lazy.loadInSlide(c(g));
                            var y = t.children("." + i.slidePrevClass);
                            0 < y.length && n.lazy.loadInSlide(c(y))
                        }
                }
            },
            Q = {
                LinearSpline: function(e, t) {
                    var i, n, a, r, s, o = function(e, t) {
                        for (n = -1, i = e.length; 1 < i - n;) e[a = i + n >> 1] <= t ? n = a : i = a;
                        return i
                    };
                    return this.x = e, this.y = t, this.lastIndex = e.length - 1, this.interpolate = function(e) {
                        return e ? (s = o(this.x, e), r = s - 1, (e - this.x[r]) * (this.y[s] - this.y[r]) / (this.x[s] - this.x[r]) + this.y[r]) : 0
                    }, this
                },
                getInterpolateFunction: function(e) {
                    this.controller.spline || (this.controller.spline = this.params.loop ? new Q.LinearSpline(this.slidesGrid, e.slidesGrid) : new Q.LinearSpline(this.snapGrid, e.snapGrid))
                },
                setTranslate: function(e, t) {
                    var i, n, a = this,
                        r = a.controller.control;

                    function s(e) {
                        var t = a.rtlTranslate ? -a.translate : a.translate;
                        "slide" === a.params.controller.by && (a.controller.getInterpolateFunction(e), n = -a.controller.spline.interpolate(-t)), n && "container" !== a.params.controller.by || (i = (e.maxTranslate() - e.minTranslate()) / (a.maxTranslate() - a.minTranslate()), n = (t - a.minTranslate()) * i + e.minTranslate()), a.params.controller.inverse && (n = e.maxTranslate() - n), e.updateProgress(n), e.setTranslate(n, a), e.updateActiveIndex(), e.updateSlidesClasses()
                    }
                    if (Array.isArray(r))
                        for (var o = 0; o < r.length; o += 1) r[o] !== t && r[o] instanceof L && s(r[o]);
                    else r instanceof L && t !== r && s(r)
                },
                setTransition: function(t, e) {
                    var i, n = this,
                        a = n.controller.control;

                    function r(e) {
                        e.setTransition(t, n), 0 !== t && (e.transitionStart(), e.params.autoHeight && $.nextTick(function() {
                            e.updateAutoHeight()
                        }), e.$wrapperEl.transitionEnd(function() {
                            a && (e.params.loop && "slide" === n.params.controller.by && e.loopFix(), e.transitionEnd())
                        }))
                    }
                    if (Array.isArray(a))
                        for (i = 0; i < a.length; i += 1) a[i] !== e && a[i] instanceof L && r(a[i]);
                    else a instanceof L && e !== a && r(a)
                }
            },
            J = {
                name: "controller",
                params: {
                    controller: {
                        control: void 0,
                        inverse: !1,
                        by: "slide"
                    }
                },
                create: function() {
                    $.extend(this, {
                        controller: {
                            control: this.params.controller.control,
                            getInterpolateFunction: Q.getInterpolateFunction.bind(this),
                            setTranslate: Q.setTranslate.bind(this),
                            setTransition: Q.setTransition.bind(this)
                        }
                    })
                },
                on: {
                    update: function() {
                        this.controller.control && this.controller.spline && (this.controller.spline = void 0, delete this.controller.spline)
                    },
                    resize: function() {
                        this.controller.control && this.controller.spline && (this.controller.spline = void 0, delete this.controller.spline)
                    },
                    observerUpdate: function() {
                        this.controller.control && this.controller.spline && (this.controller.spline = void 0, delete this.controller.spline)
                    },
                    setTranslate: function(e, t) {
                        this.controller.control && this.controller.setTranslate(e, t)
                    },
                    setTransition: function(e, t) {
                        this.controller.control && this.controller.setTransition(e, t)
                    }
                }
            },
            Z = {
                makeElFocusable: function(e) {
                    return e.attr("tabIndex", "0"), e
                },
                addElRole: function(e, t) {
                    return e.attr("role", t), e
                },
                addElLabel: function(e, t) {
                    return e.attr("aria-label", t), e
                },
                disableEl: function(e) {
                    return e.attr("aria-disabled", !0), e
                },
                enableEl: function(e) {
                    return e.attr("aria-disabled", !1), e
                },
                onEnterKey: function(e) {
                    var t = this,
                        i = t.params.a11y;
                    if (13 === e.keyCode) {
                        var n = O(e.target);
                        t.navigation && t.navigation.$nextEl && n.is(t.navigation.$nextEl) && (t.isEnd && !t.params.loop || t.slideNext(), t.isEnd ? t.a11y.notify(i.lastSlideMessage) : t.a11y.notify(i.nextSlideMessage)), t.navigation && t.navigation.$prevEl && n.is(t.navigation.$prevEl) && (t.isBeginning && !t.params.loop || t.slidePrev(), t.isBeginning ? t.a11y.notify(i.firstSlideMessage) : t.a11y.notify(i.prevSlideMessage)), t.pagination && n.is("." + t.params.pagination.bulletClass) && n[0].click()
                    }
                },
                notify: function(e) {
                    var t = this.a11y.liveRegion;
                    0 !== t.length && (t.html(""), t.html(e))
                },
                updateNavigation: function() {
                    if (!this.params.loop) {
                        var e = this.navigation,
                            t = e.$nextEl,
                            i = e.$prevEl;
                        i && 0 < i.length && (this.isBeginning ? this.a11y.disableEl(i) : this.a11y.enableEl(i)), t && 0 < t.length && (this.isEnd ? this.a11y.disableEl(t) : this.a11y.enableEl(t))
                    }
                },
                updatePagination: function() {
                    var n = this,
                        a = n.params.a11y;
                    n.pagination && n.params.pagination.clickable && n.pagination.bullets && n.pagination.bullets.length && n.pagination.bullets.each(function(e, t) {
                        var i = O(t);
                        n.a11y.makeElFocusable(i), n.a11y.addElRole(i, "button"), n.a11y.addElLabel(i, a.paginationBulletMessage.replace(/{{index}}/, i.index() + 1))
                    })
                },
                init: function() {
                    var e = this;
                    e.$el.append(e.a11y.liveRegion);
                    var t, i, n = e.params.a11y;
                    e.navigation && e.navigation.$nextEl && (t = e.navigation.$nextEl), e.navigation && e.navigation.$prevEl && (i = e.navigation.$prevEl), t && (e.a11y.makeElFocusable(t), e.a11y.addElRole(t, "button"), e.a11y.addElLabel(t, n.nextSlideMessage), t.on("keydown", e.a11y.onEnterKey)), i && (e.a11y.makeElFocusable(i), e.a11y.addElRole(i, "button"), e.a11y.addElLabel(i, n.prevSlideMessage), i.on("keydown", e.a11y.onEnterKey)), e.pagination && e.params.pagination.clickable && e.pagination.bullets && e.pagination.bullets.length && e.pagination.$el.on("keydown", "." + e.params.pagination.bulletClass, e.a11y.onEnterKey)
                },
                destroy: function() {
                    var e, t, i = this;
                    i.a11y.liveRegion && 0 < i.a11y.liveRegion.length && i.a11y.liveRegion.remove(), i.navigation && i.navigation.$nextEl && (e = i.navigation.$nextEl), i.navigation && i.navigation.$prevEl && (t = i.navigation.$prevEl), e && e.off("keydown", i.a11y.onEnterKey), t && t.off("keydown", i.a11y.onEnterKey), i.pagination && i.params.pagination.clickable && i.pagination.bullets && i.pagination.bullets.length && i.pagination.$el.off("keydown", "." + i.params.pagination.bulletClass, i.a11y.onEnterKey)
                }
            },
            ee = {
                init: function() {
                    if (this.params.history) {
                        if (!B.history || !B.history.pushState) return this.params.history.enabled = !1, void(this.params.hashNavigation.enabled = !0);
                        var e = this.history;
                        e.initialized = !0, e.paths = ee.getPathValues(), (e.paths.key || e.paths.value) && (e.scrollToSlide(0, e.paths.value, this.params.runCallbacksOnInit), this.params.history.replaceState || B.addEventListener("popstate", this.history.setHistoryPopState))
                    }
                },
                destroy: function() {
                    this.params.history.replaceState || B.removeEventListener("popstate", this.history.setHistoryPopState)
                },
                setHistoryPopState: function() {
                    this.history.paths = ee.getPathValues(), this.history.scrollToSlide(this.params.speed, this.history.paths.value, !1)
                },
                getPathValues: function() {
                    var e = B.location.pathname.slice(1).split("/").filter(function(e) {
                            return "" !== e
                        }),
                        t = e.length,
                        i = e[t - 2],
                        n = e[t - 1];
                    return {
                        key: i,
                        value: n
                    }
                },
                setHistory: function(e, t) {
                    if (this.history.initialized && this.params.history.enabled) {
                        var i = this.slides.eq(t),
                            n = ee.slugify(i.attr("data-history"));
                        B.location.pathname.includes(e) || (n = e + "/" + n);
                        var a = B.history.state;
                        a && a.value === n || (this.params.history.replaceState ? B.history.replaceState({
                            value: n
                        }, null, n) : B.history.pushState({
                            value: n
                        }, null, n))
                    }
                },
                slugify: function(e) {
                    return e.toString().toLowerCase().replace(/\s+/g, "-").replace(/[^\w-]+/g, "").replace(/--+/g, "-").replace(/^-+/, "").replace(/-+$/, "")
                },
                scrollToSlide: function(e, t, i) {
                    if (t)
                        for (var n = 0, a = this.slides.length; n < a; n += 1) {
                            var r = this.slides.eq(n),
                                s = ee.slugify(r.attr("data-history"));
                            if (s === t && !r.hasClass(this.params.slideDuplicateClass)) {
                                var o = r.index();
                                this.slideTo(o, e, i)
                            }
                        } else this.slideTo(0, e, i)
                }
            },
            te = {
                onHashCange: function() {
                    var e = v.location.hash.replace("#", ""),
                        t = this.slides.eq(this.activeIndex).attr("data-hash");
                    if (e !== t) {
                        var i = this.$wrapperEl.children("." + this.params.slideClass + '[data-hash="' + e + '"]').index();
                        if (void 0 === i) return;
                        this.slideTo(i)
                    }
                },
                setHash: function() {
                    if (this.hashNavigation.initialized && this.params.hashNavigation.enabled)
                        if (this.params.hashNavigation.replaceState && B.history && B.history.replaceState) B.history.replaceState(null, null, "#" + this.slides.eq(this.activeIndex).attr("data-hash") || !1);
                        else {
                            var e = this.slides.eq(this.activeIndex),
                                t = e.attr("data-hash") || e.attr("data-history");
                            v.location.hash = t || ""
                        }
                },
                init: function() {
                    var e = this;
                    if (!(!e.params.hashNavigation.enabled || e.params.history && e.params.history.enabled)) {
                        e.hashNavigation.initialized = !0;
                        var t = v.location.hash.replace("#", "");
                        if (t)
                            for (var i = 0, n = e.slides.length; i < n; i += 1) {
                                var a = e.slides.eq(i),
                                    r = a.attr("data-hash") || a.attr("data-history");
                                if (r === t && !a.hasClass(e.params.slideDuplicateClass)) {
                                    var s = a.index();
                                    e.slideTo(s, 0, e.params.runCallbacksOnInit, !0)
                                }
                            }
                        e.params.hashNavigation.watchState && O(B).on("hashchange", e.hashNavigation.onHashCange)
                    }
                },
                destroy: function() {
                    this.params.hashNavigation.watchState && O(B).off("hashchange", this.hashNavigation.onHashCange)
                }
            },
            ie = {
                run: function() {
                    var e = this,
                        t = e.slides.eq(e.activeIndex),
                        i = e.params.autoplay.delay;
                    t.attr("data-swiper-autoplay") && (i = t.attr("data-swiper-autoplay") || e.params.autoplay.delay), e.autoplay.timeout = $.nextTick(function() {
                        e.params.autoplay.reverseDirection ? e.params.loop ? (e.loopFix(), e.slidePrev(e.params.speed, !0, !0), e.emit("autoplay")) : e.isBeginning ? e.params.autoplay.stopOnLastSlide ? e.autoplay.stop() : (e.slideTo(e.slides.length - 1, e.params.speed, !0, !0), e.emit("autoplay")) : (e.slidePrev(e.params.speed, !0, !0), e.emit("autoplay")) : e.params.loop ? (e.loopFix(), e.slideNext(e.params.speed, !0, !0), e.emit("autoplay")) : e.isEnd ? e.params.autoplay.stopOnLastSlide ? e.autoplay.stop() : (e.slideTo(0, e.params.speed, !0, !0), e.emit("autoplay")) : (e.slideNext(e.params.speed, !0, !0), e.emit("autoplay"))
                    }, i)
                },
                start: function() {
                    return void 0 === this.autoplay.timeout && !this.autoplay.running && (this.autoplay.running = !0, this.emit("autoplayStart"), this.autoplay.run(), !0)
                },
                stop: function() {
                    return !!this.autoplay.running && void 0 !== this.autoplay.timeout && (this.autoplay.timeout && (clearTimeout(this.autoplay.timeout), this.autoplay.timeout = void 0), this.autoplay.running = !1, this.emit("autoplayStop"), !0)
                },
                pause: function(e) {
                    var t = this;
                    t.autoplay.running && (t.autoplay.paused || (t.autoplay.timeout && clearTimeout(t.autoplay.timeout), t.autoplay.paused = !0, 0 !== e && t.params.autoplay.waitForTransition ? (t.$wrapperEl[0].addEventListener("transitionend", t.autoplay.onTransitionEnd), t.$wrapperEl[0].addEventListener("webkitTransitionEnd", t.autoplay.onTransitionEnd)) : (t.autoplay.paused = !1, t.autoplay.run())))
                }
            },
            ne = {
                setTranslate: function() {
                    for (var e = this.slides, t = 0; t < e.length; t += 1) {
                        var i = this.slides.eq(t),
                            n = i[0].swiperSlideOffset,
                            a = -n;
                        this.params.virtualTranslate || (a -= this.translate);
                        var r = 0;
                        this.isHorizontal() || (r = a, a = 0);
                        var s = this.params.fadeEffect.crossFade ? Math.max(1 - Math.abs(i[0].progress), 0) : 1 + Math.min(Math.max(i[0].progress, -1), 0);
                        i.css({
                            opacity: s
                        }).transform("translate3d(" + a + "px, " + r + "px, 0px)")
                    }
                },
                setTransition: function(e) {
                    var i = this,
                        t = i.slides,
                        n = i.$wrapperEl;
                    if (t.transition(e), i.params.virtualTranslate && 0 !== e) {
                        var a = !1;
                        t.transitionEnd(function() {
                            if (!a && i && !i.destroyed) {
                                a = !0, i.animating = !1;
                                for (var e = ["webkitTransitionEnd", "transitionend"], t = 0; t < e.length; t += 1) n.trigger(e[t])
                            }
                        })
                    }
                }
            },
            ae = {
                setTranslate: function() {
                    var e, t = this,
                        i = t.$el,
                        n = t.$wrapperEl,
                        a = t.slides,
                        r = t.width,
                        s = t.height,
                        o = t.rtlTranslate,
                        l = t.size,
                        c = t.params.cubeEffect,
                        d = t.isHorizontal(),
                        u = t.virtual && t.params.virtual.enabled,
                        h = 0;
                    c.shadow && (d ? (0 === (e = n.find(".swiper-cube-shadow")).length && (e = O('<div class="swiper-cube-shadow"></div>'), n.append(e)), e.css({
                        height: r + "px"
                    })) : 0 === (e = i.find(".swiper-cube-shadow")).length && (e = O('<div class="swiper-cube-shadow"></div>'), i.append(e)));
                    for (var p = 0; p < a.length; p += 1) {
                        var f = a.eq(p),
                            v = p;
                        u && (v = parseInt(f.attr("data-swiper-slide-index"), 10));
                        var m = 90 * v,
                            g = Math.floor(m / 360);
                        o && (m = -m, g = Math.floor(-m / 360));
                        var y = Math.max(Math.min(f[0].progress, 1), -1),
                            b = 0,
                            w = 0,
                            E = 0;
                        v % 4 == 0 ? (b = 4 * -g * l, E = 0) : (v - 1) % 4 == 0 ? (b = 0, E = 4 * -g * l) : (v - 2) % 4 == 0 ? (b = l + 4 * g * l, E = l) : (v - 3) % 4 == 0 && (b = -l, E = 3 * l + 4 * l * g), o && (b = -b), d || (w = b, b = 0);
                        var x = "rotateX(" + (d ? 0 : -m) + "deg) rotateY(" + (d ? m : 0) + "deg) translate3d(" + b + "px, " + w + "px, " + E + "px)";
                        if (y <= 1 && -1 < y && (h = 90 * v + 90 * y, o && (h = 90 * -v - 90 * y)), f.transform(x), c.slideShadows) {
                            var S = d ? f.find(".swiper-slide-shadow-left") : f.find(".swiper-slide-shadow-top"),
                                C = d ? f.find(".swiper-slide-shadow-right") : f.find(".swiper-slide-shadow-bottom");
                            0 === S.length && (S = O('<div class="swiper-slide-shadow-' + (d ? "left" : "top") + '"></div>'), f.append(S)), 0 === C.length && (C = O('<div class="swiper-slide-shadow-' + (d ? "right" : "bottom") + '"></div>'), f.append(C)), S.length && (S[0].style.opacity = Math.max(-y, 0)), C.length && (C[0].style.opacity = Math.max(y, 0))
                        }
                    }
                    if (n.css({
                            "-webkit-transform-origin": "50% 50% -" + l / 2 + "px",
                            "-moz-transform-origin": "50% 50% -" + l / 2 + "px",
                            "-ms-transform-origin": "50% 50% -" + l / 2 + "px",
                            "transform-origin": "50% 50% -" + l / 2 + "px"
                        }), c.shadow)
                        if (d) e.transform("translate3d(0px, " + (r / 2 + c.shadowOffset) + "px, " + -r / 2 + "px) rotateX(90deg) rotateZ(0deg) scale(" + c.shadowScale + ")");
                        else {
                            var k = Math.abs(h) - 90 * Math.floor(Math.abs(h) / 90),
                                T = 1.5 - (Math.sin(2 * k * Math.PI / 360) / 2 + Math.cos(2 * k * Math.PI / 360) / 2),
                                _ = c.shadowScale,
                                L = c.shadowScale / T,
                                I = c.shadowOffset;
                            e.transform("scale3d(" + _ + ", 1, " + L + ") translate3d(0px, " + (s / 2 + I) + "px, " + -s / 2 / L + "px) rotateX(-90deg)")
                        } var M = D.isSafari || D.isUiWebView ? -l / 2 : 0;
                    n.transform("translate3d(0px,0," + M + "px) rotateX(" + (t.isHorizontal() ? 0 : h) + "deg) rotateY(" + (t.isHorizontal() ? -h : 0) + "deg)")
                },
                setTransition: function(e) {
                    var t = this.$el,
                        i = this.slides;
                    i.transition(e).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(e), this.params.cubeEffect.shadow && !this.isHorizontal() && t.find(".swiper-cube-shadow").transition(e)
                }
            },
            re = {
                setTranslate: function() {
                    for (var e = this.slides, t = this.rtlTranslate, i = 0; i < e.length; i += 1) {
                        var n = e.eq(i),
                            a = n[0].progress;
                        this.params.flipEffect.limitRotation && (a = Math.max(Math.min(n[0].progress, 1), -1));
                        var r = n[0].swiperSlideOffset,
                            s = -180 * a,
                            o = s,
                            l = 0,
                            c = -r,
                            d = 0;
                        if (this.isHorizontal() ? t && (o = -o) : (d = c, l = -o, o = c = 0), n[0].style.zIndex = -Math.abs(Math.round(a)) + e.length, this.params.flipEffect.slideShadows) {
                            var u = this.isHorizontal() ? n.find(".swiper-slide-shadow-left") : n.find(".swiper-slide-shadow-top"),
                                h = this.isHorizontal() ? n.find(".swiper-slide-shadow-right") : n.find(".swiper-slide-shadow-bottom");
                            0 === u.length && (u = O('<div class="swiper-slide-shadow-' + (this.isHorizontal() ? "left" : "top") + '"></div>'), n.append(u)), 0 === h.length && (h = O('<div class="swiper-slide-shadow-' + (this.isHorizontal() ? "right" : "bottom") + '"></div>'), n.append(h)), u.length && (u[0].style.opacity = Math.max(-a, 0)), h.length && (h[0].style.opacity = Math.max(a, 0))
                        }
                        n.transform("translate3d(" + c + "px, " + d + "px, 0px) rotateX(" + l + "deg) rotateY(" + o + "deg)")
                    }
                },
                setTransition: function(e) {
                    var i = this,
                        t = i.slides,
                        n = i.activeIndex,
                        a = i.$wrapperEl;
                    if (t.transition(e).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(e), i.params.virtualTranslate && 0 !== e) {
                        var r = !1;
                        t.eq(n).transitionEnd(function() {
                            if (!r && i && !i.destroyed) {
                                r = !0, i.animating = !1;
                                for (var e = ["webkitTransitionEnd", "transitionend"], t = 0; t < e.length; t += 1) a.trigger(e[t])
                            }
                        })
                    }
                }
            },
            se = {
                setTranslate: function() {
                    for (var e = this.width, t = this.height, i = this.slides, n = this.$wrapperEl, a = this.slidesSizesGrid, r = this.params.coverflowEffect, s = this.isHorizontal(), o = this.translate, l = s ? e / 2 - o : t / 2 - o, c = s ? r.rotate : -r.rotate, d = r.depth, u = 0, h = i.length; u < h; u += 1) {
                        var p = i.eq(u),
                            f = a[u],
                            v = p[0].swiperSlideOffset,
                            m = (l - v - f / 2) / f * r.modifier,
                            g = s ? c * m : 0,
                            y = s ? 0 : c * m,
                            b = -d * Math.abs(m),
                            w = s ? 0 : r.stretch * m,
                            E = s ? r.stretch * m : 0;
                        Math.abs(E) < .001 && (E = 0), Math.abs(w) < .001 && (w = 0), Math.abs(b) < .001 && (b = 0), Math.abs(g) < .001 && (g = 0), Math.abs(y) < .001 && (y = 0);
                        var x = "translate3d(" + E + "px," + w + "px," + b + "px)  rotateX(" + y + "deg) rotateY(" + g + "deg)";
                        if (p.transform(x), p[0].style.zIndex = 1 - Math.abs(Math.round(m)), r.slideShadows) {
                            var S = s ? p.find(".swiper-slide-shadow-left") : p.find(".swiper-slide-shadow-top"),
                                C = s ? p.find(".swiper-slide-shadow-right") : p.find(".swiper-slide-shadow-bottom");
                            0 === S.length && (S = O('<div class="swiper-slide-shadow-' + (s ? "left" : "top") + '"></div>'), p.append(S)), 0 === C.length && (C = O('<div class="swiper-slide-shadow-' + (s ? "right" : "bottom") + '"></div>'), p.append(C)), S.length && (S[0].style.opacity = 0 < m ? m : 0), C.length && (C[0].style.opacity = 0 < -m ? -m : 0)
                        }
                    }
                    if (q.pointerEvents || q.prefixedPointerEvents) {
                        var k = n[0].style;
                        k.perspectiveOrigin = l + "px 50%"
                    }
                },
                setTransition: function(e) {
                    this.slides.transition(e).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(e)
                }
            },
            oe = {
                init: function() {
                    var e = this,
                        t = e.params,
                        i = t.thumbs,
                        n = e.constructor;
                    i.swiper instanceof n ? (e.thumbs.swiper = i.swiper, $.extend(e.thumbs.swiper.originalParams, {
                        watchSlidesProgress: !0,
                        slideToClickedSlide: !1
                    }), $.extend(e.thumbs.swiper.params, {
                        watchSlidesProgress: !0,
                        slideToClickedSlide: !1
                    })) : $.isObject(i.swiper) && (e.thumbs.swiper = new n($.extend({}, i.swiper, {
                        watchSlidesVisibility: !0,
                        watchSlidesProgress: !0,
                        slideToClickedSlide: !1
                    })), e.thumbs.swiperCreated = !0), e.thumbs.swiper.$el.addClass(e.params.thumbs.thumbsContainerClass), e.thumbs.swiper.on("tap", e.thumbs.onThumbClick)
                },
                onThumbClick: function() {
                    var e = this,
                        t = e.thumbs.swiper;
                    if (t) {
                        var i = t.clickedIndex,
                            n = t.clickedSlide;
                        if (!(n && O(n).hasClass(e.params.thumbs.slideThumbActiveClass) || null == i)) {
                            var a;
                            if (a = t.params.loop ? parseInt(O(t.clickedSlide).attr("data-swiper-slide-index"), 10) : i, e.params.loop) {
                                var r = e.activeIndex;
                                e.slides.eq(r).hasClass(e.params.slideDuplicateClass) && (e.loopFix(), e._clientLeft = e.$wrapperEl[0].clientLeft, r = e.activeIndex);
                                var s = e.slides.eq(r).prevAll('[data-swiper-slide-index="' + a + '"]').eq(0).index(),
                                    o = e.slides.eq(r).nextAll('[data-swiper-slide-index="' + a + '"]').eq(0).index();
                                a = void 0 === s ? o : void 0 === o ? s : o - r < r - s ? o : s
                            }
                            e.slideTo(a)
                        }
                    }
                },
                update: function(e) {
                    var t = this,
                        i = t.thumbs.swiper;
                    if (i) {
                        var n = "auto" === i.params.slidesPerView ? i.slidesPerViewDynamic() : i.params.slidesPerView;
                        if (t.realIndex !== i.realIndex) {
                            var a, r = i.activeIndex;
                            if (i.params.loop) {
                                i.slides.eq(r).hasClass(i.params.slideDuplicateClass) && (i.loopFix(), i._clientLeft = i.$wrapperEl[0].clientLeft, r = i.activeIndex);
                                var s = i.slides.eq(r).prevAll('[data-swiper-slide-index="' + t.realIndex + '"]').eq(0).index(),
                                    o = i.slides.eq(r).nextAll('[data-swiper-slide-index="' + t.realIndex + '"]').eq(0).index();
                                a = void 0 === s ? o : void 0 === o ? s : o - r == r - s ? r : o - r < r - s ? o : s
                            } else a = t.realIndex;
                            i.visibleSlidesIndexes.indexOf(a) < 0 && (i.params.centeredSlides ? a = r < a ? a - Math.floor(n / 2) + 1 : a + Math.floor(n / 2) - 1 : r < a && (a = a - n + 1), i.slideTo(a, e ? 0 : void 0))
                        }
                        var l = 1,
                            c = t.params.thumbs.slideThumbActiveClass;
                        if (1 < t.params.slidesPerView && !t.params.centeredSlides && (l = t.params.slidesPerView), i.slides.removeClass(c), i.params.loop)
                            for (var d = 0; d < l; d += 1) i.$wrapperEl.children('[data-swiper-slide-index="' + (t.realIndex + d) + '"]').addClass(c);
                        else
                            for (var u = 0; u < l; u += 1) i.slides.eq(t.realIndex + u).addClass(c)
                    }
                }
            },
            le = [I, M, P, A, z, j, H, {
                name: "mousewheel",
                params: {
                    mousewheel: {
                        enabled: !1,
                        releaseOnEdges: !1,
                        invert: !1,
                        forceToAxis: !1,
                        sensitivity: 1,
                        eventsTarged: "container"
                    }
                },
                create: function() {
                    $.extend(this, {
                        mousewheel: {
                            enabled: !1,
                            enable: Y.enable.bind(this),
                            disable: Y.disable.bind(this),
                            handle: Y.handle.bind(this),
                            handleMouseEnter: Y.handleMouseEnter.bind(this),
                            handleMouseLeave: Y.handleMouseLeave.bind(this),
                            lastScrollTime: $.now()
                        }
                    })
                },
                on: {
                    init: function() {
                        this.params.mousewheel.enabled && this.mousewheel.enable()
                    },
                    destroy: function() {
                        this.mousewheel.enabled && this.mousewheel.disable()
                    }
                }
            }, {
                name: "navigation",
                params: {
                    navigation: {
                        nextEl: null,
                        prevEl: null,
                        hideOnClick: !1,
                        disabledClass: "swiper-button-disabled",
                        hiddenClass: "swiper-button-hidden",
                        lockClass: "swiper-button-lock"
                    }
                },
                create: function() {
                    $.extend(this, {
                        navigation: {
                            init: V.init.bind(this),
                            update: V.update.bind(this),
                            destroy: V.destroy.bind(this),
                            onNextClick: V.onNextClick.bind(this),
                            onPrevClick: V.onPrevClick.bind(this)
                        }
                    })
                },
                on: {
                    init: function() {
                        this.navigation.init(), this.navigation.update()
                    },
                    toEdge: function() {
                        this.navigation.update()
                    },
                    fromEdge: function() {
                        this.navigation.update()
                    },
                    destroy: function() {
                        this.navigation.destroy()
                    },
                    click: function(e) {
                        var t = this.navigation,
                            i = t.$nextEl,
                            n = t.$prevEl;
                        !this.params.navigation.hideOnClick || O(e.target).is(n) || O(e.target).is(i) || (i && i.toggleClass(this.params.navigation.hiddenClass), n && n.toggleClass(this.params.navigation.hiddenClass))
                    }
                }
            }, {
                name: "pagination",
                params: {
                    pagination: {
                        el: null,
                        bulletElement: "span",
                        clickable: !1,
                        hideOnClick: !1,
                        renderBullet: null,
                        renderProgressbar: null,
                        renderFraction: null,
                        renderCustom: null,
                        progressbarOpposite: !1,
                        type: "bullets",
                        dynamicBullets: !1,
                        dynamicMainBullets: 1,
                        formatFractionCurrent: function(e) {
                            return e
                        },
                        formatFractionTotal: function(e) {
                            return e
                        },
                        bulletClass: "swiper-pagination-bullet",
                        bulletActiveClass: "swiper-pagination-bullet-active",
                        modifierClass: "swiper-pagination-",
                        currentClass: "swiper-pagination-current",
                        totalClass: "swiper-pagination-total",
                        hiddenClass: "swiper-pagination-hidden",
                        progressbarFillClass: "swiper-pagination-progressbar-fill",
                        progressbarOppositeClass: "swiper-pagination-progressbar-opposite",
                        clickableClass: "swiper-pagination-clickable",
                        lockClass: "swiper-pagination-lock"
                    }
                },
                create: function() {
                    $.extend(this, {
                        pagination: {
                            init: G.init.bind(this),
                            render: G.render.bind(this),
                            update: G.update.bind(this),
                            destroy: G.destroy.bind(this),
                            dynamicBulletIndex: 0
                        }
                    })
                },
                on: {
                    init: function() {
                        this.pagination.init(), this.pagination.render(), this.pagination.update()
                    },
                    activeIndexChange: function() {
                        this.params.loop ? this.pagination.update() : void 0 === this.snapIndex && this.pagination.update()
                    },
                    snapIndexChange: function() {
                        this.params.loop || this.pagination.update()
                    },
                    slidesLengthChange: function() {
                        this.params.loop && (this.pagination.render(), this.pagination.update())
                    },
                    snapGridLengthChange: function() {
                        this.params.loop || (this.pagination.render(), this.pagination.update())
                    },
                    destroy: function() {
                        this.pagination.destroy()
                    },
                    click: function(e) {
                        this.params.pagination.el && this.params.pagination.hideOnClick && 0 < this.pagination.$el.length && !O(e.target).hasClass(this.params.pagination.bulletClass) && this.pagination.$el.toggleClass(this.params.pagination.hiddenClass)
                    }
                }
            }, {
                name: "scrollbar",
                params: {
                    scrollbar: {
                        el: null,
                        dragSize: "auto",
                        hide: !1,
                        draggable: !1,
                        snapOnRelease: !0,
                        lockClass: "swiper-scrollbar-lock",
                        dragClass: "swiper-scrollbar-drag"
                    }
                },
                create: function() {
                    var e = this;
                    $.extend(e, {
                        scrollbar: {
                            init: U.init.bind(e),
                            destroy: U.destroy.bind(e),
                            updateSize: U.updateSize.bind(e),
                            setTranslate: U.setTranslate.bind(e),
                            setTransition: U.setTransition.bind(e),
                            enableDraggable: U.enableDraggable.bind(e),
                            disableDraggable: U.disableDraggable.bind(e),
                            setDragPosition: U.setDragPosition.bind(e),
                            onDragStart: U.onDragStart.bind(e),
                            onDragMove: U.onDragMove.bind(e),
                            onDragEnd: U.onDragEnd.bind(e),
                            isTouched: !1,
                            timeout: null,
                            dragTimeout: null
                        }
                    })
                },
                on: {
                    init: function() {
                        this.scrollbar.init(), this.scrollbar.updateSize(), this.scrollbar.setTranslate()
                    },
                    update: function() {
                        this.scrollbar.updateSize()
                    },
                    resize: function() {
                        this.scrollbar.updateSize()
                    },
                    observerUpdate: function() {
                        this.scrollbar.updateSize()
                    },
                    setTranslate: function() {
                        this.scrollbar.setTranslate()
                    },
                    setTransition: function(e) {
                        this.scrollbar.setTransition(e)
                    },
                    destroy: function() {
                        this.scrollbar.destroy()
                    }
                }
            }, {
                name: "parallax",
                params: {
                    parallax: {
                        enabled: !1
                    }
                },
                create: function() {
                    $.extend(this, {
                        parallax: {
                            setTransform: W.setTransform.bind(this),
                            setTranslate: W.setTranslate.bind(this),
                            setTransition: W.setTransition.bind(this)
                        }
                    })
                },
                on: {
                    beforeInit: function() {
                        this.params.parallax.enabled && (this.params.watchSlidesProgress = !0, this.originalParams.watchSlidesProgress = !0)
                    },
                    init: function() {
                        this.params.parallax && this.parallax.setTranslate()
                    },
                    setTranslate: function() {
                        this.params.parallax && this.parallax.setTranslate()
                    },
                    setTransition: function(e) {
                        this.params.parallax && this.parallax.setTransition(e)
                    }
                }
            }, {
                name: "zoom",
                params: {
                    zoom: {
                        enabled: !1,
                        maxRatio: 3,
                        minRatio: 1,
                        toggle: !0,
                        containerClass: "swiper-zoom-container",
                        zoomedSlideClass: "swiper-slide-zoomed"
                    }
                },
                create: function() {
                    var t = this,
                        i = {
                            enabled: !1,
                            scale: 1,
                            currentScale: 1,
                            isScaling: !1,
                            gesture: {
                                $slideEl: void 0,
                                slideWidth: void 0,
                                slideHeight: void 0,
                                $imageEl: void 0,
                                $imageWrapEl: void 0,
                                maxRatio: 3
                            },
                            image: {
                                isTouched: void 0,
                                isMoved: void 0,
                                currentX: void 0,
                                currentY: void 0,
                                minX: void 0,
                                minY: void 0,
                                maxX: void 0,
                                maxY: void 0,
                                width: void 0,
                                height: void 0,
                                startX: void 0,
                                startY: void 0,
                                touchesStart: {},
                                touchesCurrent: {}
                            },
                            velocity: {
                                x: void 0,
                                y: void 0,
                                prevPositionX: void 0,
                                prevPositionY: void 0,
                                prevTime: void 0
                            }
                        };
                    "onGestureStart onGestureChange onGestureEnd onTouchStart onTouchMove onTouchEnd onTransitionEnd toggle enable disable in out".split(" ").forEach(function(e) {
                        i[e] = X[e].bind(t)
                    }), $.extend(t, {
                        zoom: i
                    })
                },
                on: {
                    init: function() {
                        this.params.zoom.enabled && this.zoom.enable()
                    },
                    destroy: function() {
                        this.zoom.disable()
                    },
                    touchStart: function(e) {
                        this.zoom.enabled && this.zoom.onTouchStart(e)
                    },
                    touchEnd: function(e) {
                        this.zoom.enabled && this.zoom.onTouchEnd(e)
                    },
                    doubleTap: function(e) {
                        this.params.zoom.enabled && this.zoom.enabled && this.params.zoom.toggle && this.zoom.toggle(e)
                    },
                    transitionEnd: function() {
                        this.zoom.enabled && this.params.zoom.enabled && this.zoom.onTransitionEnd()
                    }
                }
            }, {
                name: "lazy",
                params: {
                    lazy: {
                        enabled: !1,
                        loadPrevNext: !1,
                        loadPrevNextAmount: 1,
                        loadOnTransitionStart: !1,
                        elementClass: "swiper-lazy",
                        loadingClass: "swiper-lazy-loading",
                        loadedClass: "swiper-lazy-loaded",
                        preloaderClass: "swiper-lazy-preloader"
                    }
                },
                create: function() {
                    $.extend(this, {
                        lazy: {
                            initialImageLoaded: !1,
                            load: K.load.bind(this),
                            loadInSlide: K.loadInSlide.bind(this)
                        }
                    })
                },
                on: {
                    beforeInit: function() {
                        this.params.lazy.enabled && this.params.preloadImages && (this.params.preloadImages = !1)
                    },
                    init: function() {
                        this.params.lazy.enabled && !this.params.loop && 0 === this.params.initialSlide && this.lazy.load()
                    },
                    scroll: function() {
                        this.params.freeMode && !this.params.freeModeSticky && this.lazy.load()
                    },
                    resize: function() {
                        this.params.lazy.enabled && this.lazy.load()
                    },
                    scrollbarDragMove: function() {
                        this.params.lazy.enabled && this.lazy.load()
                    },
                    transitionStart: function() {
                        this.params.lazy.enabled && (this.params.lazy.loadOnTransitionStart || !this.params.lazy.loadOnTransitionStart && !this.lazy.initialImageLoaded) && this.lazy.load()
                    },
                    transitionEnd: function() {
                        this.params.lazy.enabled && !this.params.lazy.loadOnTransitionStart && this.lazy.load()
                    }
                }
            }, J, {
                name: "a11y",
                params: {
                    a11y: {
                        enabled: !0,
                        notificationClass: "swiper-notification",
                        prevSlideMessage: "Previous slide",
                        nextSlideMessage: "Next slide",
                        firstSlideMessage: "This is the first slide",
                        lastSlideMessage: "This is the last slide",
                        paginationBulletMessage: "Go to slide {{index}}"
                    }
                },
                create: function() {
                    var t = this;
                    $.extend(t, {
                        a11y: {
                            liveRegion: O('<span class="' + t.params.a11y.notificationClass + '" aria-live="assertive" aria-atomic="true"></span>')
                        }
                    }), Object.keys(Z).forEach(function(e) {
                        t.a11y[e] = Z[e].bind(t)
                    })
                },
                on: {
                    init: function() {
                        this.params.a11y.enabled && (this.a11y.init(), this.a11y.updateNavigation())
                    },
                    toEdge: function() {
                        this.params.a11y.enabled && this.a11y.updateNavigation()
                    },
                    fromEdge: function() {
                        this.params.a11y.enabled && this.a11y.updateNavigation()
                    },
                    paginationUpdate: function() {
                        this.params.a11y.enabled && this.a11y.updatePagination()
                    },
                    destroy: function() {
                        this.params.a11y.enabled && this.a11y.destroy()
                    }
                }
            }, {
                name: "history",
                params: {
                    history: {
                        enabled: !1,
                        replaceState: !1,
                        key: "slides"
                    }
                },
                create: function() {
                    $.extend(this, {
                        history: {
                            init: ee.init.bind(this),
                            setHistory: ee.setHistory.bind(this),
                            setHistoryPopState: ee.setHistoryPopState.bind(this),
                            scrollToSlide: ee.scrollToSlide.bind(this),
                            destroy: ee.destroy.bind(this)
                        }
                    })
                },
                on: {
                    init: function() {
                        this.params.history.enabled && this.history.init()
                    },
                    destroy: function() {
                        this.params.history.enabled && this.history.destroy()
                    },
                    transitionEnd: function() {
                        this.history.initialized && this.history.setHistory(this.params.history.key, this.activeIndex)
                    }
                }
            }, {
                name: "hash-navigation",
                params: {
                    hashNavigation: {
                        enabled: !1,
                        replaceState: !1,
                        watchState: !1
                    }
                },
                create: function() {
                    $.extend(this, {
                        hashNavigation: {
                            initialized: !1,
                            init: te.init.bind(this),
                            destroy: te.destroy.bind(this),
                            setHash: te.setHash.bind(this),
                            onHashCange: te.onHashCange.bind(this)
                        }
                    })
                },
                on: {
                    init: function() {
                        this.params.hashNavigation.enabled && this.hashNavigation.init()
                    },
                    destroy: function() {
                        this.params.hashNavigation.enabled && this.hashNavigation.destroy()
                    },
                    transitionEnd: function() {
                        this.hashNavigation.initialized && this.hashNavigation.setHash()
                    }
                }
            }, {
                name: "autoplay",
                params: {
                    autoplay: {
                        enabled: !1,
                        delay: 3e3,
                        waitForTransition: !0,
                        disableOnInteraction: !0,
                        stopOnLastSlide: !1,
                        reverseDirection: !1
                    }
                },
                create: function() {
                    var t = this;
                    $.extend(t, {
                        autoplay: {
                            running: !1,
                            paused: !1,
                            run: ie.run.bind(t),
                            start: ie.start.bind(t),
                            stop: ie.stop.bind(t),
                            pause: ie.pause.bind(t),
                            onTransitionEnd: function(e) {
                                t && !t.destroyed && t.$wrapperEl && e.target === this && (t.$wrapperEl[0].removeEventListener("transitionend", t.autoplay.onTransitionEnd), t.$wrapperEl[0].removeEventListener("webkitTransitionEnd", t.autoplay.onTransitionEnd), t.autoplay.paused = !1, t.autoplay.running ? t.autoplay.run() : t.autoplay.stop())
                            }
                        }
                    })
                },
                on: {
                    init: function() {
                        this.params.autoplay.enabled && this.autoplay.start()
                    },
                    beforeTransitionStart: function(e, t) {
                        this.autoplay.running && (t || !this.params.autoplay.disableOnInteraction ? this.autoplay.pause(e) : this.autoplay.stop())
                    },
                    sliderFirstMove: function() {
                        this.autoplay.running && (this.params.autoplay.disableOnInteraction ? this.autoplay.stop() : this.autoplay.pause())
                    },
                    destroy: function() {
                        this.autoplay.running && this.autoplay.stop()
                    }
                }
            }, {
                name: "effect-fade",
                params: {
                    fadeEffect: {
                        crossFade: !1
                    }
                },
                create: function() {
                    $.extend(this, {
                        fadeEffect: {
                            setTranslate: ne.setTranslate.bind(this),
                            setTransition: ne.setTransition.bind(this)
                        }
                    })
                },
                on: {
                    beforeInit: function() {
                        if ("fade" === this.params.effect) {
                            this.classNames.push(this.params.containerModifierClass + "fade");
                            var e = {
                                slidesPerView: 1,
                                slidesPerColumn: 1,
                                slidesPerGroup: 1,
                                watchSlidesProgress: !0,
                                spaceBetween: 0,
                                virtualTranslate: !0
                            };
                            $.extend(this.params, e), $.extend(this.originalParams, e)
                        }
                    },
                    setTranslate: function() {
                        "fade" === this.params.effect && this.fadeEffect.setTranslate()
                    },
                    setTransition: function(e) {
                        "fade" === this.params.effect && this.fadeEffect.setTransition(e)
                    }
                }
            }, {
                name: "effect-cube",
                params: {
                    cubeEffect: {
                        slideShadows: !0,
                        shadow: !0,
                        shadowOffset: 20,
                        shadowScale: .94
                    }
                },
                create: function() {
                    $.extend(this, {
                        cubeEffect: {
                            setTranslate: ae.setTranslate.bind(this),
                            setTransition: ae.setTransition.bind(this)
                        }
                    })
                },
                on: {
                    beforeInit: function() {
                        if ("cube" === this.params.effect) {
                            this.classNames.push(this.params.containerModifierClass + "cube"), this.classNames.push(this.params.containerModifierClass + "3d");
                            var e = {
                                slidesPerView: 1,
                                slidesPerColumn: 1,
                                slidesPerGroup: 1,
                                watchSlidesProgress: !0,
                                resistanceRatio: 0,
                                spaceBetween: 0,
                                centeredSlides: !1,
                                virtualTranslate: !0
                            };
                            $.extend(this.params, e), $.extend(this.originalParams, e)
                        }
                    },
                    setTranslate: function() {
                        "cube" === this.params.effect && this.cubeEffect.setTranslate()
                    },
                    setTransition: function(e) {
                        "cube" === this.params.effect && this.cubeEffect.setTransition(e)
                    }
                }
            }, {
                name: "effect-flip",
                params: {
                    flipEffect: {
                        slideShadows: !0,
                        limitRotation: !0
                    }
                },
                create: function() {
                    $.extend(this, {
                        flipEffect: {
                            setTranslate: re.setTranslate.bind(this),
                            setTransition: re.setTransition.bind(this)
                        }
                    })
                },
                on: {
                    beforeInit: function() {
                        if ("flip" === this.params.effect) {
                            this.classNames.push(this.params.containerModifierClass + "flip"), this.classNames.push(this.params.containerModifierClass + "3d");
                            var e = {
                                slidesPerView: 1,
                                slidesPerColumn: 1,
                                slidesPerGroup: 1,
                                watchSlidesProgress: !0,
                                spaceBetween: 0,
                                virtualTranslate: !0
                            };
                            $.extend(this.params, e), $.extend(this.originalParams, e)
                        }
                    },
                    setTranslate: function() {
                        "flip" === this.params.effect && this.flipEffect.setTranslate()
                    },
                    setTransition: function(e) {
                        "flip" === this.params.effect && this.flipEffect.setTransition(e)
                    }
                }
            }, {
                name: "effect-coverflow",
                params: {
                    coverflowEffect: {
                        rotate: 50,
                        stretch: 0,
                        depth: 100,
                        modifier: 1,
                        slideShadows: !0
                    }
                },
                create: function() {
                    $.extend(this, {
                        coverflowEffect: {
                            setTranslate: se.setTranslate.bind(this),
                            setTransition: se.setTransition.bind(this)
                        }
                    })
                },
                on: {
                    beforeInit: function() {
                        "coverflow" === this.params.effect && (this.classNames.push(this.params.containerModifierClass + "coverflow"), this.classNames.push(this.params.containerModifierClass + "3d"), this.params.watchSlidesProgress = !0, this.originalParams.watchSlidesProgress = !0)
                    },
                    setTranslate: function() {
                        "coverflow" === this.params.effect && this.coverflowEffect.setTranslate()
                    },
                    setTransition: function(e) {
                        "coverflow" === this.params.effect && this.coverflowEffect.setTransition(e)
                    }
                }
            }, {
                name: "thumbs",
                params: {
                    thumbs: {
                        swiper: null,
                        slideThumbActiveClass: "swiper-slide-thumb-active",
                        thumbsContainerClass: "swiper-container-thumbs"
                    }
                },
                create: function() {
                    $.extend(this, {
                        thumbs: {
                            swiper: null,
                            init: oe.init.bind(this),
                            update: oe.update.bind(this),
                            onThumbClick: oe.onThumbClick.bind(this)
                        }
                    })
                },
                on: {
                    beforeInit: function() {
                        var e = this.params,
                            t = e.thumbs;
                        t && t.swiper && (this.thumbs.init(), this.thumbs.update(!0))
                    },
                    slideChange: function() {
                        this.thumbs.swiper && this.thumbs.update()
                    },
                    update: function() {
                        this.thumbs.swiper && this.thumbs.update()
                    },
                    resize: function() {
                        this.thumbs.swiper && this.thumbs.update()
                    },
                    observerUpdate: function() {
                        this.thumbs.swiper && this.thumbs.update()
                    },
                    setTransition: function(e) {
                        var t = this.thumbs.swiper;
                        t && t.setTransition(e)
                    },
                    beforeDestroy: function() {
                        var e = this.thumbs.swiper;
                        e && this.thumbs.swiperCreated && e && e.destroy()
                    }
                }
            }];
        return void 0 === L.use && (L.use = L.Class.use, L.installModule = L.Class.installModule), L.use(le), L
    }()
}, function(e, t, i) {
    var p = i(15);
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            t = e.element,
            i = e.container,
            n = void 0 === i ? null : i,
            a = e.options,
            r = void 0 === a ? null : a,
            s = e.config,
            l = void 0 === s ? null : s,
            o = e.submit,
            c = void 0 !== o && o,
            d = document.querySelector(t),
            u = document.querySelector(n),
            h = document.querySelector(l);
        this.initPikaday = function() {
            if (null == d) return !1;
            var e = {
                field: d,
                firstDay: 1,
                bound: !0,
                toString: function(e, t) {
                    var i = e.getFullYear(),
                        n = e.getMonth() + 1,
                        a = e.getDate(),
                        r = ("0" + n).slice(-2),
                        s = ("0" + a).slice(-2);
                    return "".concat(i, "-").concat(r, "-").concat(s)
                },
                i18n: {
                    previousMonth: "Luna anterioară",
                    nextMonth: "Luna următoare",
                    months: ["Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie", "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie"],
                    weekdays: ["Duminică", "Luni", "Marți", "Miercuri", "Joi", "Vineri", "Sâmbătă"],
                    weekdaysShort: ["Du", "Lu", "Ma", "Mi", "Jo", "Vi", "Sâ"]
                },
                onSelect: function() {
                    var e = d.closest("form");
                    null != e && 1 == c ? e.submit() : u.querySelector("label").textContent = d.value
                }
            };
            if (null != u && (e = Object.assign(e, {
                    container: u
                })), null != r && (e = Object.assign(e, r)), null != l) {
                var o = JSON.parse(h.textContent);
                e = Object.assign(e, {
                    disableDayFn: function(e) {
                        var t = e.getFullYear(),
                            i = e.getMonth() + 1,
                            n = e.getDate(),
                            a = ("0" + i).slice(-2),
                            r = ("0" + n).slice(-2),
                            s = "".concat(t, "-").concat(a, "-").concat(r);
                        if (!o.includes(s)) return e
                    },
                    minDate: new Date(o[0]),
                    maxDate: new Date(o[o.length - 1]),
                    defaultDate: new Date(o[o.length - 1])
                })
            }
            new p(e)
        }
    }
}, function(w, e, E) {
    ! function(e, t) {
        "use strict";
        var i, r, s, o, h, c, l, n, d, p, f, g, R, H, B, $, u, a, v, m, q, Y, y, b;
        try {
            i = E(! function() {
                var e = new Error("Cannot find module 'moment'");
                throw e.code = "MODULE_NOT_FOUND", e
            }())
        } catch (e) {}
        w.exports = (s = "function" == typeof(r = i), o = !!window.addEventListener, h = window.document, c = window.setTimeout, l = function(e, t, i, n) {
            o ? e.addEventListener(t, i, !!n) : e.attachEvent("on" + t, i)
        }, n = function(e, t, i, n) {
            o ? e.removeEventListener(t, i, !!n) : e.detachEvent("on" + t, i)
        }, d = function(e, t) {
            return -1 !== (" " + e.className + " ").indexOf(" " + t + " ")
        }, p = function(e, t) {
            d(e, t) || (e.className = "" === e.className ? t : e.className + " " + t)
        }, f = function(e, t) {
            var i;
            e.className = (i = (" " + e.className + " ").replace(" " + t + " ", " ")).trim ? i.trim() : i.replace(/^\s+|\s+$/g, "")
        }, m = {
            field: null,
            bound: void 0,
            ariaLabel: "Use the arrow keys to pick a date",
            position: "bottom left",
            reposition: !0,
            format: "YYYY-MM-DD",
            toString: null,
            parse: null,
            defaultDate: null,
            setDefaultDate: !(v = function(e) {
                return e.month < 0 && (e.year -= Math.ceil(Math.abs(e.month) / 12), e.month += 12), 11 < e.month && (e.year += Math.floor(Math.abs(e.month) / 12), e.month -= 12), e
            }),
            firstDay: 0,
            formatStrict: !(a = function(e, t, i) {
                var n;
                h.createEvent ? ((n = h.createEvent("HTMLEvents")).initEvent(t, !0, !1), n = u(n, i), e.dispatchEvent(n)) : h.createEventObject && (n = h.createEventObject(), n = u(n, i), e.fireEvent("on" + t, n))
            }),
            minDate: null,
            maxDate: null,
            yearRange: 10,
            showWeekNumber: !(u = function(e, t, i) {
                var n, a;
                for (n in t)(a = void 0 !== e[n]) && "object" == typeof t[n] && null !== t[n] && void 0 === t[n].nodeName ? R(t[n]) ? i && (e[n] = new Date(t[n].getTime())) : g(t[n]) ? i && (e[n] = t[n].slice(0)) : e[n] = u({}, t[n], i) : !i && a || (e[n] = t[n]);
                return e
            }),
            pickWholeWeek: !($ = function(e, t) {
                return e.getTime() === t.getTime()
            }),
            minYear: 0,
            maxYear: 9999,
            minMonth: void 0,
            maxMonth: void 0,
            startRange: null,
            endRange: null,
            isRTL: !(B = function(e) {
                R(e) && e.setHours(0, 0, 0, 0)
            }),
            yearSuffix: "",
            showMonthAfterYear: !(H = function(e, t) {
                return [31, (i = e, i % 4 == 0 && i % 100 != 0 || i % 400 == 0 ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][t];
                var i
            }),
            showDaysInNextAndPreviousMonths: !(R = function(e) {
                return /Date/.test(Object.prototype.toString.call(e)) && !isNaN(e.getTime())
            }),
            enableSelectionDaysInNextAndPreviousMonths: !(g = function(e) {
                return /Array/.test(Object.prototype.toString.call(e))
            }),
            numberOfMonths: 1,
            mainCalendar: "left",
            container: void 0,
            blurFieldOnSelect: !0,
            i18n: {
                previousMonth: "Previous Month",
                nextMonth: "Next Month",
                months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                weekdays: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                weekdaysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
            },
            theme: null,
            events: [],
            onSelect: null,
            onOpen: null,
            onClose: null,
            onDraw: null,
            keyboardInput: !0
        }, q = function(e, t, i) {
            for (t += e.firstDay; 7 <= t;) t -= 7;
            return i ? e.i18n.weekdaysShort[t] : e.i18n.weekdays[t]
        }, Y = function(e) {
            var t = [],
                i = "false";
            if (e.isEmpty) {
                if (!e.showDaysInNextAndPreviousMonths) return '<td class="is-empty"></td>';
                t.push("is-outside-current-month"), e.enableSelectionDaysInNextAndPreviousMonths || t.push("is-selection-disabled")
            }
            return e.isDisabled && t.push("is-disabled"), e.isToday && t.push("is-today"), e.isSelected && (t.push("is-selected"), i = "true"), e.hasEvent && t.push("has-event"), e.isInRange && t.push("is-inrange"), e.isStartRange && t.push("is-startrange"), e.isEndRange && t.push("is-endrange"), '<td data-day="' + e.day + '" class="' + t.join(" ") + '" aria-selected="' + i + '"><button class="pika-button pika-day" type="button" data-pika-year="' + e.year + '" data-pika-month="' + e.month + '" data-pika-day="' + e.day + '">' + e.day + "</button></td>"
        }, y = function(e, t, i, n, a, r) {
            var s, o, l, c, d, u = e._o,
                h = i === u.minYear,
                p = i === u.maxYear,
                f = '<div id="' + r + '" class="pika-title" role="heading" aria-live="assertive">',
                v = !0,
                m = !0;
            for (l = [], s = 0; s < 12; s++) l.push('<option value="' + (i === a ? s - t : 12 + s - t) + '"' + (s === n ? ' selected="selected"' : "") + (h && s < u.minMonth || p && s > u.maxMonth ? 'disabled="disabled"' : "") + ">" + u.i18n.months[s] + "</option>");
            for (c = '<div class="pika-label">' + u.i18n.months[n] + '<select class="pika-select pika-select-month" tabindex="-1">' + l.join("") + "</select></div>", o = g(u.yearRange) ? (s = u.yearRange[0], u.yearRange[1] + 1) : (s = i - u.yearRange, 1 + i + u.yearRange), l = []; s < o && s <= u.maxYear; s++) s >= u.minYear && l.push('<option value="' + s + '"' + (s === i ? ' selected="selected"' : "") + ">" + s + "</option>");
            return d = '<div class="pika-label">' + i + u.yearSuffix + '<select class="pika-select pika-select-year" tabindex="-1">' + l.join("") + "</select></div>", u.showMonthAfterYear ? f += d + c : f += c + d, h && (0 === n || u.minMonth >= n) && (v = !1), p && (11 === n || u.maxMonth <= n) && (m = !1), 0 === t && (f += '<button class="pika-prev' + (v ? "" : " is-disabled") + '" type="button">' + u.i18n.previousMonth + "</button>"), t === e._o.numberOfMonths - 1 && (f += '<button class="pika-next' + (m ? "" : " is-disabled") + '" type="button">' + u.i18n.nextMonth + "</button>"), f += "</div>"
        }, (b = function(e) {
            var n = this,
                a = n.config(e);
            n._onMouseDown = function(e) {
                if (n._v) {
                    var t = (e = e || window.event).target || e.srcElement;
                    if (t)
                        if (d(t, "is-disabled") || (!d(t, "pika-button") || d(t, "is-empty") || d(t.parentNode, "is-disabled") ? d(t, "pika-prev") ? n.prevMonth() : d(t, "pika-next") && n.nextMonth() : (n.setDate(new Date(t.getAttribute("data-pika-year"), t.getAttribute("data-pika-month"), t.getAttribute("data-pika-day"))), a.bound && c(function() {
                                n.hide(), a.blurFieldOnSelect && a.field && a.field.blur()
                            }, 100))), d(t, "pika-select")) n._c = !0;
                        else {
                            if (!e.preventDefault) return e.returnValue = !1;
                            e.preventDefault()
                        }
                }
            }, n._onChange = function(e) {
                var t = (e = e || window.event).target || e.srcElement;
                t && (d(t, "pika-select-month") ? n.gotoMonth(t.value) : d(t, "pika-select-year") && n.gotoYear(t.value))
            }, n._onKeyChange = function(e) {
                if (e = e || window.event, n.isVisible()) switch (e.keyCode) {
                    case 13:
                    case 27:
                        a.field && a.field.blur();
                        break;
                    case 37:
                        e.preventDefault(), n.adjustDate("subtract", 1);
                        break;
                    case 38:
                        n.adjustDate("subtract", 7);
                        break;
                    case 39:
                        n.adjustDate("add", 1);
                        break;
                    case 40:
                        n.adjustDate("add", 7)
                }
            }, n._onInputChange = function(e) {
                var t;
                e.firedBy !== n && (t = a.parse ? a.parse(a.field.value, a.format) : s ? (t = r(a.field.value, a.format, a.formatStrict)) && t.isValid() ? t.toDate() : null : new Date(Date.parse(a.field.value)), R(t) && n.setDate(t), n._v || n.show())
            }, n._onInputFocus = function() {
                n.show()
            }, n._onInputClick = function() {
                n.show()
            }, n._onInputBlur = function() {
                var e = h.activeElement;
                do {
                    if (d(e, "pika-single")) return
                } while (e = e.parentNode);
                n._c || (n._b = c(function() {
                    n.hide()
                }, 50)), n._c = !1
            }, n._onClick = function(e) {
                var t = (e = e || window.event).target || e.srcElement,
                    i = t;
                if (t) {
                    !o && d(t, "pika-select") && (t.onchange || (t.setAttribute("onchange", "return;"), l(t, "change", n._onChange)));
                    do {
                        if (d(i, "pika-single") || i === a.trigger) return
                    } while (i = i.parentNode);
                    n._v && t !== a.trigger && i !== a.trigger && n.hide()
                }
            }, n.el = h.createElement("div"), n.el.className = "pika-single" + (a.isRTL ? " is-rtl" : "") + (a.theme ? " " + a.theme : ""), l(n.el, "mousedown", n._onMouseDown, !0), l(n.el, "touchend", n._onMouseDown, !0), l(n.el, "change", n._onChange), a.keyboardInput && l(h, "keydown", n._onKeyChange), a.field && (a.container ? a.container.appendChild(n.el) : a.bound ? h.body.appendChild(n.el) : a.field.parentNode.insertBefore(n.el, a.field.nextSibling), l(a.field, "change", n._onInputChange), a.defaultDate || (s && a.field.value ? a.defaultDate = r(a.field.value, a.format).toDate() : a.defaultDate = new Date(Date.parse(a.field.value)), a.setDefaultDate = !0));
            var t = a.defaultDate;
            R(t) ? a.setDefaultDate ? n.setDate(t, !0) : n.gotoDate(t) : n.gotoDate(new Date), a.bound ? (this.hide(), n.el.className += " is-bound", l(a.trigger, "click", n._onInputClick), l(a.trigger, "focus", n._onInputFocus), l(a.trigger, "blur", n._onInputBlur)) : this.show()
        }).prototype = {
            config: function(e) {
                this._o || (this._o = u({}, m, !0));
                var t = u(this._o, e, !0);
                t.isRTL = !!t.isRTL, t.field = t.field && t.field.nodeName ? t.field : null, t.theme = "string" == typeof t.theme && t.theme ? t.theme : null, t.bound = !!(void 0 !== t.bound ? t.field && t.bound : t.field), t.trigger = t.trigger && t.trigger.nodeName ? t.trigger : t.field, t.disableWeekends = !!t.disableWeekends, t.disableDayFn = "function" == typeof t.disableDayFn ? t.disableDayFn : null;
                var i = parseInt(t.numberOfMonths, 10) || 1;
                if (t.numberOfMonths = 4 < i ? 4 : i, R(t.minDate) || (t.minDate = !1), R(t.maxDate) || (t.maxDate = !1), t.minDate && t.maxDate && t.maxDate < t.minDate && (t.maxDate = t.minDate = !1), t.minDate && this.setMinDate(t.minDate), t.maxDate && this.setMaxDate(t.maxDate), g(t.yearRange)) {
                    var n = (new Date).getFullYear() - 10;
                    t.yearRange[0] = parseInt(t.yearRange[0], 10) || n, t.yearRange[1] = parseInt(t.yearRange[1], 10) || n
                } else t.yearRange = Math.abs(parseInt(t.yearRange, 10)) || m.yearRange, 100 < t.yearRange && (t.yearRange = 100);
                return t
            },
            toString: function(e) {
                return e = e || this._o.format, R(this._d) ? this._o.toString ? this._o.toString(this._d, e) : s ? r(this._d).format(e) : this._d.toDateString() : ""
            },
            getMoment: function() {
                return s ? r(this._d) : null
            },
            setMoment: function(e, t) {
                s && r.isMoment(e) && this.setDate(e.toDate(), t)
            },
            getDate: function() {
                return R(this._d) ? new Date(this._d.getTime()) : null
            },
            setDate: function(e, t) {
                if (!e) return this._d = null, this._o.field && (this._o.field.value = "", a(this._o.field, "change", {
                    firedBy: this
                })), this.draw();
                if ("string" == typeof e && (e = new Date(Date.parse(e))), R(e)) {
                    var i = this._o.minDate,
                        n = this._o.maxDate;
                    R(i) && e < i ? e = i : R(n) && n < e && (e = n), this._d = new Date(e.getTime()), B(this._d), this.gotoDate(this._d), this._o.field && (this._o.field.value = this.toString(), a(this._o.field, "change", {
                        firedBy: this
                    })), t || "function" != typeof this._o.onSelect || this._o.onSelect.call(this, this.getDate())
                }
            },
            gotoDate: function(e) {
                var t = !0;
                if (R(e)) {
                    if (this.calendars) {
                        var i = new Date(this.calendars[0].year, this.calendars[0].month, 1),
                            n = new Date(this.calendars[this.calendars.length - 1].year, this.calendars[this.calendars.length - 1].month, 1),
                            a = e.getTime();
                        n.setMonth(n.getMonth() + 1), n.setDate(n.getDate() - 1), t = a < i.getTime() || n.getTime() < a
                    }
                    t && (this.calendars = [{
                        month: e.getMonth(),
                        year: e.getFullYear()
                    }], "right" === this._o.mainCalendar && (this.calendars[0].month += 1 - this._o.numberOfMonths)), this.adjustCalendars()
                }
            },
            adjustDate: function(e, t) {
                var i, n = this.getDate() || new Date,
                    a = 24 * parseInt(t) * 60 * 60 * 1e3;
                "add" === e ? i = new Date(n.valueOf() + a) : "subtract" === e && (i = new Date(n.valueOf() - a)), this.setDate(i)
            },
            adjustCalendars: function() {
                this.calendars[0] = v(this.calendars[0]);
                for (var e = 1; e < this._o.numberOfMonths; e++) this.calendars[e] = v({
                    month: this.calendars[0].month + e,
                    year: this.calendars[0].year
                });
                this.draw()
            },
            gotoToday: function() {
                this.gotoDate(new Date)
            },
            gotoMonth: function(e) {
                isNaN(e) || (this.calendars[0].month = parseInt(e, 10), this.adjustCalendars())
            },
            nextMonth: function() {
                this.calendars[0].month++, this.adjustCalendars()
            },
            prevMonth: function() {
                this.calendars[0].month--, this.adjustCalendars()
            },
            gotoYear: function(e) {
                isNaN(e) || (this.calendars[0].year = parseInt(e, 10), this.adjustCalendars())
            },
            setMinDate: function(e) {
                e instanceof Date ? (B(e), this._o.minDate = e, this._o.minYear = e.getFullYear(), this._o.minMonth = e.getMonth()) : (this._o.minDate = m.minDate, this._o.minYear = m.minYear, this._o.minMonth = m.minMonth, this._o.startRange = m.startRange), this.draw()
            },
            setMaxDate: function(e) {
                e instanceof Date ? (B(e), this._o.maxDate = e, this._o.maxYear = e.getFullYear(), this._o.maxMonth = e.getMonth()) : (this._o.maxDate = m.maxDate, this._o.maxYear = m.maxYear, this._o.maxMonth = m.maxMonth, this._o.endRange = m.endRange), this.draw()
            },
            setStartRange: function(e) {
                this._o.startRange = e
            },
            setEndRange: function(e) {
                this._o.endRange = e
            },
            draw: function(e) {
                if (this._v || e) {
                    var t, i = this._o,
                        n = i.minYear,
                        a = i.maxYear,
                        r = i.minMonth,
                        s = i.maxMonth,
                        o = "";
                    this._y <= n && (this._y = n, !isNaN(r) && this._m < r && (this._m = r)), this._y >= a && (this._y = a, !isNaN(s) && this._m > s && (this._m = s)), t = "pika-title-" + Math.random().toString(36).replace(/[^a-z]+/g, "").substr(0, 2);
                    for (var l = 0; l < i.numberOfMonths; l++) o += '<div class="pika-lendar">' + y(this, l, this.calendars[l].year, this.calendars[l].month, this.calendars[0].year, t) + this.render(this.calendars[l].year, this.calendars[l].month, t) + "</div>";
                    this.el.innerHTML = o, i.bound && "hidden" !== i.field.type && c(function() {
                        i.trigger.focus()
                    }, 1), "function" == typeof this._o.onDraw && this._o.onDraw(this), i.bound && i.field.setAttribute("aria-label", i.ariaLabel)
                }
            },
            adjustPosition: function() {
                var e, t, i, n, a, r, s, o, l, c, d, u;
                if (!this._o.container) {
                    if (this.el.style.position = "absolute", t = e = this._o.trigger, i = this.el.offsetWidth, n = this.el.offsetHeight, a = window.innerWidth || h.documentElement.clientWidth, r = window.innerHeight || h.documentElement.clientHeight, s = window.pageYOffset || h.body.scrollTop || h.documentElement.scrollTop, u = d = !0, "function" == typeof e.getBoundingClientRect) o = (c = e.getBoundingClientRect()).left + window.pageXOffset, l = c.bottom + window.pageYOffset;
                    else
                        for (o = t.offsetLeft, l = t.offsetTop + t.offsetHeight; t = t.offsetParent;) o += t.offsetLeft, l += t.offsetTop;
                    (this._o.reposition && a < o + i || -1 < this._o.position.indexOf("right") && 0 < o - i + e.offsetWidth) && (o = o - i + e.offsetWidth, d = !1), (this._o.reposition && r + s < l + n || -1 < this._o.position.indexOf("top") && 0 < l - n - e.offsetHeight) && (l = l - n - e.offsetHeight, u = !1), this.el.style.left = o + "px", this.el.style.top = l + "px", p(this.el, d ? "left-aligned" : "right-aligned"), p(this.el, u ? "bottom-aligned" : "top-aligned"), f(this.el, d ? "right-aligned" : "left-aligned"), f(this.el, u ? "top-aligned" : "bottom-aligned")
                }
            },
            render: function(e, t, i) {
                var n = this._o,
                    a = new Date,
                    r = H(e, t),
                    s = new Date(e, t, 1).getDay(),
                    o = [],
                    l = [];
                B(a), 0 < n.firstDay && (s -= n.firstDay) < 0 && (s += 7);
                for (var c = 0 === t ? 11 : t - 1, d = 11 === t ? 0 : t + 1, u = 0 === t ? e - 1 : e, h = 11 === t ? e + 1 : e, p = H(u, c), f = r + s, v = f; 7 < v;) v -= 7;
                f += 7 - v;
                for (var m, g, y, b, w, E, x, S, C = !1, k = 0, T = 0; k < f; k++) {
                    var _ = new Date(e, t, k - s + 1),
                        L = !!R(this._d) && $(_, this._d),
                        I = $(_, a),
                        M = -1 !== n.events.indexOf(_.toDateString()),
                        O = k < s || r + s <= k,
                        D = k - s + 1,
                        P = t,
                        A = e,
                        F = n.startRange && $(n.startRange, _),
                        z = n.endRange && $(n.endRange, _),
                        N = n.startRange && n.endRange && n.startRange < _ && _ < n.endRange;
                    O && (A = k < s ? (D = p + D, P = c, u) : (D -= r, P = d, h));
                    var j = {
                        day: D,
                        month: P,
                        year: A,
                        hasEvent: M,
                        isSelected: L,
                        isToday: I,
                        isDisabled: n.minDate && _ < n.minDate || n.maxDate && _ > n.maxDate || n.disableWeekends && (0 === (x = _.getDay()) || 6 === x) || n.disableDayFn && n.disableDayFn(_),
                        isEmpty: O,
                        isStartRange: F,
                        isEndRange: z,
                        isInRange: N,
                        showDaysInNextAndPreviousMonths: n.showDaysInNextAndPreviousMonths,
                        enableSelectionDaysInNextAndPreviousMonths: n.enableSelectionDaysInNextAndPreviousMonths
                    };
                    n.pickWholeWeek && L && (C = !0), l.push(Y(j)), 7 == ++T && (n.showWeekNumber && l.unshift((y = k - s, b = t, w = e, E = void 0, E = new Date(w, 0, 1), '<td class="pika-week">' + Math.ceil(((new Date(w, b, y) - E) / 864e5 + E.getDay() + 1) / 7) + "</td>")), o.push((m = l, g = n.isRTL, '<tr class="pika-row' + (n.pickWholeWeek ? " pick-whole-week" : "") + (C ? " is-selected" : "") + '">' + (g ? m.reverse() : m).join("") + "</tr>")), T = 0, C = !(l = []))
                }
                return S = o, '<table cellpadding="0" cellspacing="0" class="pika-table" role="grid" aria-labelledby="' + i + '">' + function(e) {
                    var t, i = [];
                    for (e.showWeekNumber && i.push("<th></th>"), t = 0; t < 7; t++) i.push('<th scope="col"><abbr title="' + q(e, t) + '">' + q(e, t, !0) + "</abbr></th>");
                    return "<thead><tr>" + (e.isRTL ? i.reverse() : i).join("") + "</tr></thead>"
                }(n) + "<tbody>" + S.join("") + "</tbody></table>"
            },
            isVisible: function() {
                return this._v
            },
            show: function() {
                this.isVisible() || (this._v = !0, this.draw(), f(this.el, "is-hidden"), this._o.bound && (l(h, "click", this._onClick), this.adjustPosition()), "function" == typeof this._o.onOpen && this._o.onOpen.call(this))
            },
            hide: function() {
                var e = this._v;
                !1 !== e && (this._o.bound && n(h, "click", this._onClick), this.el.style.position = "static", this.el.style.left = "auto", this.el.style.top = "auto", p(this.el, "is-hidden"), this._v = !1, void 0 !== e && "function" == typeof this._o.onClose && this._o.onClose.call(this))
            },
            destroy: function() {
                var e = this._o;
                this.hide(), n(this.el, "mousedown", this._onMouseDown, !0), n(this.el, "touchend", this._onMouseDown, !0), n(this.el, "change", this._onChange), e.keyboardInput && n(h, "keydown", this._onKeyChange), e.field && (n(e.field, "change", this._onInputChange), e.bound && (n(e.trigger, "click", this._onInputClick), n(e.trigger, "focus", this._onInputFocus), n(e.trigger, "blur", this._onInputBlur))), this.el.parentNode && this.el.parentNode.removeChild(this.el)
            }
        }, b)
    }()
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            r = e.form,
            t = e.element,
            s = void 0 === t ? ".form-element" : t,
            i = e.captcha,
            n = void 0 === i ? null : i,
            a = e.callback,
            o = void 0 === a ? null : a,
            l = document.querySelector(r),
            c = document.querySelector(n),
            d = null;

        function u(e) {
            if (!e.disabled && "file" !== e.type && "reset" !== e.type && "submit" !== e.type && "button" !== e.type) {
                if (e.classList.contains("novalidate")) return null;
                if (e.hasAttribute("data-field") && e.hasAttribute("data-field-message")) {
                    var t = e.getAttribute("data-field"),
                        i = document.getElementById(t);
                    if (null != i && 0 < i.value.length && i.value != e.value) return e.getAttribute("data-field-message")
                }
                var n = e.validity;
                if (!n.valid) {
                    if (n.valueMissing) return e.getAttribute("title") || "Câmpul este obligatoriu";
                    if (n.typeMismatch) {
                        if ("email" === e.type) return "Adresa de email nu este validă";
                        if ("url" === e.type) return "Adresa nu este validă"
                    }
                    return n.tooShort ? "Câmpul trebuie să conțină minimum " + e.getAttribute("minLength") + " caractere" : n.tooLong ? "Câmpul trebuie să conțină maximum " + e.getAttribute("maxLength") + " caractere" : n.badInput ? "Câmpul nu este valid" : n.stepMismatch ? "Câmpul nu este valid" : n.rangeOverflow ? "Valoarea maximă permisă este " + e.getAttribute("max") : n.rangeUnderflow ? "Valoarea minimă permisă este " + e.getAttribute("min") : n.patternMismatch && e.hasAttribute("title") ? e.getAttribute("title") : "Câmpul nu este valid"
                }
            }
        }

        function h(e, t) {
            if (e.classList.add("error"), "radio" === e.type && e.name) {
                var i = document.getElementsByName(e.name);
                if (0 < i.length) {
                    for (var n = 0; n < i.length; n++) i[n].form === e.form && i[n].classList.add("error");
                    e = i[i.length - 1]
                }
            }
            if (e.id || e.name) {
                var a = e.closest(s);
                a && a.setAttribute("data-error", t)
            }
        }

        function p(e) {
            if (e.classList.remove("error"), "radio" === e.type && e.name) {
                var t = document.getElementsByName(e.name);
                if (0 < t.length) {
                    for (var i = 0; i < t.length; i++) t[i].form === e.form && t[i].classList.remove("error");
                    e = t[t.length - 1]
                }
            }
            if (e.id || e.name) {
                var n = e.closest(s);
                n && n.removeAttribute("data-error")
            }
        }
        this.initValidator = function() {
            document.addEventListener("submit", function(e) {
                if (!e.target.matches(r) || null == l) return !1;
                e.preventDefault();
                for (var t, i, n = e.target.elements, a = 0; a < n.length; a++)(t = u(n[a])) && (h(n[a], t), i || (i = n[a]));
                i ? i.focus() : null != c ? (null == d && (d = grecaptcha.render(c, {
                    sitekey: document.querySelector("[data-token]").dataset.token,
                    size: "invisible",
                    callback: function(e) {
                        null != o ? o() : l.submit()
                    }
                }, !0)), grecaptcha.reset(d), grecaptcha.execute(d)) : null != o ? o() : l.submit()
            }, !1), document.addEventListener("blur", function(e) {
                if (e.target.form != l || null == l) return !1;
                var t = u(e.target);
                t ? h(e.target, t) : p(e.target)
            }, !0), document.addEventListener("change", function(e) {
                if (!(e.target.matches("select") || e.target.matches('input[type="radio"]') || e.target.matches('input[type="checkbox"]')) || e.target.form != l || null == l) return !1;
                var t = u(e.target);
                t ? h(e.target, t) : p(e.target)
            }, !0)
        }
    }
}, function(e, t, D) {
    (function(O) {
        e.exports = function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
                t = e.cfg,
                o = e.dest,
                i = (e.form, e.form),
                l = (i = void 0 !== i && i).formId,
                n = i.formField,
                a = i.captcha,
                r = e.preload,
                s = void 0 !== r && r,
                c = e.element,
                d = void 0 !== c && c,
                u = e.cookieObj,
                h = void 0 !== u && u,
                p = e.cookieObj,
                f = (p = void 0 !== p && p).cookieName,
                v = p.cookiePath,
                m = document.querySelector(t),
                g = document.querySelector(o),
                y = document.querySelector(d),
                b = document.querySelectorAll(d),
                w = document.querySelector(l),
                E = {},
                x = null,
                S = D(16),
                C = function(t) {
                    return Object.keys(t).map(function(e) {
                        return encodeURIComponent(e) + "=" + encodeURIComponent(t[e])
                    }).join("&")
                };

            function k(e, t) {
                var i, n, a, r = (i = e, E.hasOwnProperty(i) ? E[i] : null);
                if (r) {
                    if (!1 !== h && void 0 !== O.get(f)) {
                        var s = O.getJSON(f);
                        r.params = Object.assign(r.params, s)
                    }
                    n = r, a = t, (x = new XMLHttpRequest).open(n.method, n.relUrl), x.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), a.classList.add("active"), g.innerHTML = "", g.classList.add("loading"), x.send(C(n.params)), x.onload = function() {
                        if (200 <= x.status && x.status < 300) {
                            g.classList.remove("loading");
                            try {
                                var e = JSON.parse(x.responseText);
                                e.hasOwnProperty("message") && (g.innerHTML = e.message), e.hasOwnProperty("success") && 1 == e.success && null != a.closest(l) && a.closest(l).reset();
                                var t = new CustomEvent("ajaxCallXhrTrigger", {
                                    bubbles: !1,
                                    cancelable: !1,
                                    detail: {
                                        name: "ajaxCallXhr",
                                        dest: o,
                                        success: e.success,
                                        json: e.message
                                    }
                                });
                                document.dispatchEvent(t)
                            } catch (e) {
                                g.innerHTML = x.responseText, !1 !== h && null == O.get(f) && O.set(f, JSON.stringify(n.params), {
                                    expires: 1,
                                    path: v
                                })
                            }
                        } else g.classList.remove("loading")
                    }
                }
            }

            function T(e) {
                var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : null;
                if (e.hasOwnProperty("query") && e.query.hasOwnProperty("selector") && e.query.hasOwnProperty("attr")) {
                    var i = document.querySelector(e.query.selector),
                        n = e.query.attr,
                        a = null != i ? i[n] : null;
                    return e.query.hasOwnProperty("next") ? T(e.query.next, a) : a
                }
                return null != t && e.hasOwnProperty("attr") ? t[e.attr] : null
            }

            function _(e) {
                for (var t = ["relUrl", "method", "params"], i = 0; i < t.length; i++)
                    if (!e.hasOwnProperty(t[i])) return !1;
                return !0
            }

            function L(e, t) {
                var i = {};
                if (i.relUrl = t.relUrl, i.method = t.method, i.params = t.params, void 0 !== t.paramsCfg)
                    for (var n in t.paramsCfg) t.paramsCfg.hasOwnProperty(n) && (i.params[n] = T(t.paramsCfg[n]));
                E[e] = i
            }

            function I() {
                if (0 < arguments.length && void 0 !== arguments[0] && arguments[0], 1 < arguments.length && void 0 !== arguments[1] && arguments[1], null == m) return !1;
                var e = JSON.parse(m.textContent);
                for (var t in e) e.hasOwnProperty(t) && _(e[t]) && L(t, e[t])
            }

            function M(e, t) {
                I(e, t), k(e, t)
            }
            this.initAjax = function() {
                if (null == m) return !1;
                if (null != g && 0 != h) {
                    var e = document.querySelector(f);
                    null != e && (f = e.value)
                }
                null != g && null != y && (1 == s || !1 !== h && void 0 !== O.get(f)) && function() {
                    if (y.hasAttribute("data-action-select")) return M(y.getAttribute("data-action-select"), y);
                    I();
                    var i = 0;
                    [].forEach.call(b, function(e, t) {
                        i = e.classList.contains("active") ? t : 0
                    }), k(b[i].getAttribute("data-action"), b[i])
                }(), null != w && new S({
                    form: l,
                    element: n,
                    captcha: a,
                    callback: function() {
                        var e = w.querySelector("[data-action]"),
                            t = e.dataset.action;
                        I(t, e), k(t, e)
                    }
                }).initValidator(), document.addEventListener("change", function(e) {
                    if (!e.target.matches(d) || null == m) return !1;
                    var t = e.target;
                    M(t.getAttribute("data-action-select"), t)
                }), document.addEventListener("click", function(e) {
                    if (!e.target.matches("[data-action]") || e.target.closest(l)) return !1;
                    var t = e.target,
                        i = t.getAttribute("data-action");
                    I(i, t), k(i, t)
                })
            }
        }
    }).call(this, D(3))
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            s = e.element,
            t = e.baseUrl,
            o = void 0 === t ? null : t,
            n = null != document.querySelector('meta[property="og:description"]') ? encodeURIComponent(document.querySelector('meta[property="og:description"]').content) : "";

        function l(e) {
            var t = (screen.width - 570) / 2,
                i = "menubar=no,toolbar=no,status=no,width=570,height=570,top=" + (screen.height - 570) / 2 + ",left=" + t;
            window.open(e, "newWindow", i)
        }
        this.setShareLinks = function() {
            var i = encodeURIComponent(document.URL);
            document.addEventListener("click", function(e) {
                if (!e.target.matches(s)) return !1;
                var t = e.target;
                switch (!0) {
                    case t.matches(s + "-fb"):
                        e.preventDefault(), e.stopPropagation(), l("https://www.facebook.com/sharer.php?u=" + i);
                        break;
                    case t.matches(s + "-tt"):
                        e.preventDefault(), e.stopPropagation(), l("https://twitter.com/intent/tweet?url=" + i + "&text=" + n);
                        break;
                    case t.matches(s + "-gp"):
                        e.preventDefault(), e.stopPropagation(), l("https://plus.google.com/share?url=" + i);
                        break;
                    case t.matches(s + "-in"):
                        e.preventDefault(), e.stopPropagation(), l("https://www.linkedin.com/shareArticle?mini=true&url=" + i + "&title=&summary=&source=;")
                }
            })
        }, this.initShare = function() {
            document.addEventListener("click", function(e) {
                if (!e.target.matches(s)) return !1;
                e.preventDefault(), e.stopPropagation();
                var t = e.target,
                    i = t.closest("article"),
                    n = null != i ? i.querySelector("a") : null;
                if (null == n) return !1;
                var a = n.href;
                a = a && "" != a && "#" != a ? o + a : encodeURIComponent(document.URL);
                var r = n.title || n.textContent;
                if (!r || "" == r) return !1;
                switch (!0) {
                    case t.classList.contains("social-icon-fb"):
                        l("https://www.facebook.com/sharer/sharer.php?m2w&s=100&p[url]=" + encodeURI(a) + "&p[title]=" + encodeURI(r) + "&p[summary]=");
                        break;
                    case t.classList.contains("social-icon-tt"):
                        l("https://twitter.com/intent/tweet?text=" + encodeURIComponent(r) + "&url=" + encodeURIComponent(a) + "&related=digi24_hd&via=digi24_hd");
                        break;
                    case t.classList.contains("social-icon-gp"):
                        l("https://plus.google.com/share?url=" + encodeURIComponent(a));
                        break;
                    case t.classList.contains("social-icon-in"):
                        l("https://www.linkedin.com/shareArticle?mini=true&url=" + encodeURIComponent(a) + "&title=" + encodeURIComponent(r) + "&summary=&source=;");
                        break;
                    case t.classList.contains("social-icon-co"):
                        window.location.replace(a + "#comments")
                }
            })
        }, this.copyLink = function() {
            document.addEventListener("click", function(e) {
                if (!e.target.matches(s)) return !1;
                e.preventDefault();
                var t = e.target,
                    i = t.closest("article:not(.article-story)"),
                    n = null != i ? i.querySelector("a") : null,
                    a = null != n ? n.href : location.href;
                t.classList.contains("active") && t.classList.remove("active"), 1 == function(e) {
                    var t = !1,
                        i = window.pageYOffset || document.documentElement.scrollTop,
                        n = document.createElement("textarea");
                    n.style.position = "absolute", n.style.top = "".concat(i, "px"), n.style.left = "-9999px", n.style.width = "1em", n.style.height = "1em", n.style.minHeight = "auto", n.style.margin = 0, n.style.padding = 0, n.style.border = 0, n.style.boxShadow = "none", n.style.background = "transparent", n.style.fontSize = "12pt", n.style.textTransform = "none", n.style.transition = "none", n.style.outline = "none", n.value = e, n.contentEditable = !0, document.body.appendChild(n), n.focus();
                    var a = window.getSelection(),
                        r = document.createRange();
                    r.selectNodeContents(n), a.removeAllRanges(), a.addRange(r), n.setSelectionRange(0, n.value.length);
                    try {
                        t = document.execCommand("copy")
                    } catch (e) {
                        t = !1
                    }
                    return document.body.removeChild(n), t
                }(a) && (t.dataset.message = "Link copiat", t.classList.add("active"))
            })
        }
    }
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            t = e.element,
            r = e.container,
            i = e.options,
            s = void 0 === i ? {} : i,
            n = e.multiple,
            o = void 0 !== n && n,
            l = document.querySelector(t),
            c = document.querySelectorAll(t),
            a = document.getElementById(r);

        function d(e, t) {
            var i = function(e) {
                var t = e.querySelector("script");
                if (null == t) return !1;
                var i = JSON.parse(t.textContent),
                    n = {};
                for (var a in i)
                    if ("versions" != a)
                        if ("poster" != a) {
                            var r = document.getElementById(a),
                                s = i[a];
                            if (null != r) {
                                if (r.matches("a")) {
                                    r.href = s;
                                    continue
                                }
                                r.textContent = s
                            }
                        } else n.image = i.poster;
                else {
                    var o = i.versions,
                        l = [];
                    for (var c in o) {
                        var d = {};
                        d.file = o[c], d.label = c, l.push(d)
                    }
                    n.sources = l
                }
                return n
            }(e);
            if (e.classList.contains("active")) document.getElementById(r).innerHTML = "";
            else if (i.sources && i.sources.length) {
                var n = Object.assign(i, s);
                t.setup(n)
            } else if (i.image) {
                var a = document.createElement("img");
                a.src = i.image, document.getElementById(r).innerHTML = "", document.getElementById(r).appendChild(a)
            }
        }
        this.initPlayer = function() {
            if (null == a) return !1;
            var s = jwplayer(r);
            window.onload = function() {
                if (c.length && o) {
                    var e = !0,
                        t = !1,
                        i = void 0;
                    try {
                        for (var n, a = c[Symbol.iterator](); !(e = (n = a.next()).done); e = !0) {
                            var r = n.value;
                            if (r.classList.contains("active")) {
                                d(r, s);
                                break
                            }
                        }
                    } catch (e) {
                        t = !0, i = e
                    } finally {
                        try {
                            e || null == a.return || a.return()
                        } finally {
                            if (t) throw i
                        }
                    }
                } else d(l, s)
            }, document.addEventListener("click", function(e) {
                if (!e.target.closest(t) || !o) return !1;
                d(e.target.closest(t), s), window.innerWidth < 768 && (document.getElementById(r).scrollIntoView(), window.scrollBy(0, -60))
            })
        }
    }
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            h = e.element,
            t = e.container,
            i = e.trigger,
            n = e.delay,
            a = void 0 === n ? 6e4 : n,
            p = [],
            f = 0,
            v = null,
            m = document.querySelectorAll(t),
            g = document.querySelectorAll(i),
            y = -120;

        function r() {
            var e = m[f],
                t = e.getAttribute("data-timestamp").split("-");
            e.classList.add("active"), g[f].classList.add("active"), v = e.querySelectorAll(h);
            for (var i = t[0], n = parseInt(t[1]) - 1, a = t[2], r = 0; r <= v.length; r++) {
                var s = v[r];
                if (r == v.length && f < m.length - 1 && (s = m[f + 1].querySelector(h)), null != s) {
                    var o = s.textContent.trim().slice(0, 2),
                        l = s.textContent.trim().slice(3, 5),
                        c = new Date(i, n, a, o, l),
                        d = c.getTimezoneOffset();
                    c.dst() && (y = -180);
                    var u = y - d;
                    c = c.getTime() + 6e4 * u, 0 < r && c < p[r - 1] && (c += 864e5), p.push(c)
                }
            }
            b()
        }

        function b() {
            for (var e = 1; e <= p.length; e++)
                if (Date.now() > p[p.length - 1]) {
                    if (f < m.length - 1) return f++, p = [], [].forEach.call(m, function(e, t) {
                        e.classList.contains("active") && e.classList.remove("active")
                    }), [].forEach.call(g, function(e, t) {
                        e.classList.contains("active") && e.classList.remove("active")
                    }), r(), !1;
                    [].forEach.call(document.querySelectorAll(h), function(e, t) {
                        e.classList.contains("active") && e.classList.remove("active")
                    }), v[p.length - 1].classList.add("active")
                } else if (p[e] > Date.now() && Date.now() > p[e - 1]) {
                var t = Math.round(100 * (Date.now() - p[e - 1]) / (p[e] - p[e - 1]));
                v[e - 1].classList.contains("active") || ([].forEach.call(document.querySelectorAll(h), function(e, t) {
                    e.classList.contains("active") && e.classList.remove("active")
                }), v[e - 1].classList.add("active")), v[e - 1].dataset.percent = t;
                break
            }
            setTimeout(b, a)
        }
        Date.prototype.stdTimezoneOffset = function() {
            var e = new Date(this.getFullYear(), 0, 1),
                t = new Date(this.getFullYear(), 6, 1);
            return Math.max(e.getTimezoneOffset(), t.getTimezoneOffset())
        }, Date.prototype.dst = function() {
            return this.getTimezoneOffset() < this.stdTimezoneOffset()
        }, this.initSchedule = function() {
            if (null == document.querySelector(h)) return !1;
            document.addEventListener("DOMContentLoaded", r)
        }
    }
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            t = e.element,
            i = e.cfg,
            n = e.map,
            a = void 0 === n ? null : n,
            p = document.querySelectorAll(t),
            f = document.querySelector(i),
            v = document.querySelector(a),
            m = null,
            g = null,
            y = !1;

        function b(i) {
            var n;
            (n = "https://maps.googleapis.com/maps/api/js?key=AIzaSyC7TmIjoBeINcdM6HiN8ROA8VuEpRIVX2w", new Promise(function(e) {
                var t = document.createElement("script");
                t.src = n, t.type = "text/javascript", t.async = !0, t.onload = e, document.body.appendChild(t)
            })).then(function() {
                var e = new google.maps.LatLng(i[0], i[1]),
                    t = {
                        center: e,
                        zoom: 18,
                        scrollwheel: !1,
                        gestureHandling: "cooperative",
                        navigationControl: !0,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                m = new google.maps.Map(v, t), (g = new google.maps.Marker({
                    position: e,
                    map: m,
                    title: "Digi24"
                })).setMap(m), y = !0
            })
        }

        function r() {
            if (null == p || null == f) return !1;
            var e, t, i = null,
                n = JSON.parse(f.textContent),
                a = !0,
                r = !1,
                s = void 0;
            try {
                for (var o, l = p[Symbol.iterator](); !(a = (o = l.next()).done); a = !0) {
                    var c = o.value;
                    if (1 == c.checked) {
                        i = c.value;
                        break
                    }
                }
            } catch (e) {
                r = !0, s = e
            } finally {
                try {
                    a || null == l.return || l.return()
                } finally {
                    if (r) throw s
                }
            }
            if (null != i & n.hasOwnProperty(i))
                for (var d in n[i]) {
                    var u = document.getElementById(d);
                    if (null != u)
                        if (u == v) {
                            var h = n[i][d];
                            1 == y ? (e = h, t = new google.maps.LatLng(e[0], e[1]), m.setCenter(t), g.setPosition(t)) : b(h)
                        } else u.textContent = n[i][d]
                }
        }
        this.initContact = function() {
            document.addEventListener("DOMContentLoaded", r), document.addEventListener("change", function(e) {
                if (!e.target.matches(t)) return !1;
                r(), window.innerWidth < 481 && v.scrollIntoView()
            })
        }
    }
}, function(e, t) {
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            t = e.element,
            i = e.cfg,
            n = e.target,
            a = void 0 === n ? null : n,
            m = document.querySelectorAll(t),
            g = document.querySelector(i),
            r = document.querySelector(a);

        function y(e, t) {
            var i = e.querySelector("use"),
                n = i.getAttribute("xlink:href").replace(/#.*/, "#" + t);
            i.setAttribute("xlink:href", n)
        }

        function s() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : null;
            if (null == m || null == g) return !1;
            if (null == e) {
                e = m[0];
                var t = !0,
                    i = !1,
                    n = void 0;
                try {
                    for (var a, r = m[Symbol.iterator](); !(t = (a = r.next()).done); t = !0) {
                        var s = a.value;
                        if (s.classList.contains("active")) {
                            e = s;
                            break
                        }
                    }
                } catch (e) {
                    i = !0, n = e
                } finally {
                    try {
                        t || null == r.return || r.return()
                    } finally {
                        if (i) throw n
                    }
                }
            }
            var o = e.title,
                l = JSON.parse(g.textContent);
            if (null != o & l.hasOwnProperty(o))
                for (var c in l[document.getElementsByClassName("city")[0].textContent = o]) {
                    var d = document.getElementsByClassName(c)[0];
                    if (null != d)
                        if ("symbol" == c) y(d, l[o][c]);
                        else if ("forecast" == c)
                        for (var u = 0; u < l[o][c].length; u++) {
                            var h = document.getElementsByClassName(c)[u],
                                p = l[o][c][u];
                            if (null != h)
                                for (var f in p) {
                                    var v = h.getElementsByClassName(f)[0];
                                    null != v && ("symbol" == f ? y(v, p[f]) : v.textContent = p[f])
                                }
                        } else d.textContent = l[o][c]
                }
        }
        this.initWeather = function() {
            document.addEventListener("DOMContentLoaded", function() {
                s()
            }), document.addEventListener("click", function(e) {
                if (!e.target.matches(t) && !e.target.closest(t)) return !1;
                s(e.target.closest(t)), window.innerWidth < 768 && null != r && (r.scrollIntoView(), window.scrollBy(0, -60))
            })
        }
    }
}, function(e, t, i) {
    var h = i(24);
    e.exports = function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
            t = e.element,
            i = e.cfg,
            n = void 0 === i ? null : i,
            a = e.url,
            r = void 0 === a ? null : a,
            s = e.id,
            o = void 0 === s ? null : s,
            l = document.querySelector(t),
            c = document.querySelector(n),
            d = document.querySelector(r),
            u = document.querySelector(o);
        this.initDropzone = function() {
            if (null == l) return !1;
            var e = {};
            null != c && (e = JSON.parse(c.textContent)), e = Object.assign({}, e, {
                maxFilesize: 50,
                createImageThumbnails: !1,
                maxFiles: 1,
                acceptedFiles: ".jpg, .jpeg, .png, .gif, .mp4, .flv, .doc, .docx, .pdf",
                dictDefaultMessage: "Încarcă fișier",
                dictFallbackMessage: "Browser-ul nu suportă încărcarea fișierelor prin drag'n'drop",
                dictFallbackText: "Încărcarea fișierelor se efectuează folosind formularul de mai jos",
                dictFileTooBig: "Fișierul ({{filesize}}MiB) depășește dimensiunea maximă permisă ({{maxFilesize}}MiB)",
                dictInvalidFileType: "Acest tip de fișier nu este permis",
                dictResponseError: "Eroare server {{statusCode}}",
                dictCancelUpload: "Anulează",
                dictUploadCanceled: "Încărcare anulată",
                dictCancelUploadConfirmation: "Confirmare anulare",
                dictRemoveFile: "Ștergere fișier",
                dictMaxFilesExceeded: "Nu este permisă încărcarea altor fișiere"
            }), new h(t, e).on("success", function(e, t) {
                d && (d.value = t.data), u && (u.value = t.fileId)
            })
        }
    }
}, function(e, t, i) {
    "use strict";
    (function(e) {
        var t = function() {
            function n(e, t) {
                for (var i = 0; i < t.length; i++) {
                    var n = t[i];
                    n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                }
            }
            return function(e, t, i) {
                return t && n(e.prototype, t), i && n(e, i), e
            }
        }();

        function o(e, t) {
            if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
            return !t || "object" != typeof t && "function" != typeof t ? e : t
        }

        function l(e, t) {
            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
        }
        var i = function() {
                function e() {
                    l(this, e)
                }
                return t(e, [{
                    key: "on",
                    value: function(e, t) {
                        return this._callbacks = this._callbacks || {}, this._callbacks[e] || (this._callbacks[e] = []), this._callbacks[e].push(t), this
                    }
                }, {
                    key: "emit",
                    value: function(e) {
                        this._callbacks = this._callbacks || {};
                        var t = this._callbacks[e];
                        if (t) {
                            for (var i = arguments.length, n = Array(1 < i ? i - 1 : 0), a = 1; a < i; a++) n[a - 1] = arguments[a];
                            for (var r = 0, s = s = t;;) {
                                if (r >= s.length) break;
                                s[r++].apply(this, n)
                            }
                        }
                        return this
                    }
                }, {
                    key: "off",
                    value: function(e, t) {
                        if (!this._callbacks || 0 === arguments.length) return this._callbacks = {}, this;
                        var i = this._callbacks[e];
                        if (!i) return this;
                        if (1 === arguments.length) return delete this._callbacks[e], this;
                        for (var n = 0; n < i.length; n++) {
                            if (i[n] === t) {
                                i.splice(n, 1);
                                break
                            }
                        }
                        return this
                    }
                }]), e
            }(),
            a = function(e) {
                function w(e, t) {
                    l(this, w);
                    var i, n = o(this, (w.__proto__ || Object.getPrototypeOf(w)).call(this)),
                        a = void 0;
                    if (n.element = e, n.version = w.version, n.defaultOptions.previewTemplate = n.defaultOptions.previewTemplate.replace(/\n*/g, ""), n.clickableElements = [], n.listeners = [], n.files = [], "string" == typeof n.element && (n.element = document.querySelector(n.element)), !n.element || null == n.element.nodeType) throw new Error("Invalid dropzone element.");
                    if (n.element.dropzone) throw new Error("Dropzone already attached.");
                    w.instances.push(n), n.element.dropzone = n;
                    var r, s = null != (i = w.optionsForElement(n.element)) ? i : {};
                    if (n.options = w.extend({}, n.defaultOptions, s, null != t ? t : {}), n.options.forceFallback || !w.isBrowserSupported()) return r = n.options.fallback.call(n), o(n, r);
                    if (null == n.options.url && (n.options.url = n.element.getAttribute("action")), !n.options.url) throw new Error("No URL provided.");
                    if (n.options.acceptedFiles && n.options.acceptedMimeTypes) throw new Error("You can't provide both 'acceptedFiles' and 'acceptedMimeTypes'. 'acceptedMimeTypes' is deprecated.");
                    if (n.options.uploadMultiple && n.options.chunking) throw new Error("You cannot set both: uploadMultiple and chunking.");
                    return n.options.acceptedMimeTypes && (n.options.acceptedFiles = n.options.acceptedMimeTypes, delete n.options.acceptedMimeTypes), null != n.options.renameFilename && (n.options.renameFile = function(e) {
                        return n.options.renameFilename.call(n, e.name, e)
                    }), n.options.method = n.options.method.toUpperCase(), (a = n.getExistingFallback()) && a.parentNode && a.parentNode.removeChild(a), !1 !== n.options.previewsContainer && (n.options.previewsContainer ? n.previewsContainer = w.getElement(n.options.previewsContainer, "previewsContainer") : n.previewsContainer = n.element), n.options.clickable && (!0 === n.options.clickable ? n.clickableElements = [n.element] : n.clickableElements = w.getElements(n.options.clickable, "clickable")), n.init(), n
                }
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
                    e.prototype = Object.create(t && t.prototype, {
                        constructor: {
                            value: e,
                            enumerable: !1,
                            writable: !0,
                            configurable: !0
                        }
                    }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
                }(w, i), t(w, null, [{
                    key: "initClass",
                    value: function() {
                        this.prototype.Emitter = i, this.prototype.events = ["drop", "dragstart", "dragend", "dragenter", "dragover", "dragleave", "addedfile", "addedfiles", "removedfile", "thumbnail", "error", "errormultiple", "processing", "processingmultiple", "uploadprogress", "totaluploadprogress", "sending", "sendingmultiple", "success", "successmultiple", "canceled", "canceledmultiple", "complete", "completemultiple", "reset", "maxfilesexceeded", "maxfilesreached", "queuecomplete"], this.prototype.defaultOptions = {
                            url: null,
                            method: "post",
                            withCredentials: !1,
                            timeout: 3e4,
                            parallelUploads: 2,
                            uploadMultiple: !1,
                            chunking: !1,
                            forceChunking: !1,
                            chunkSize: 2e6,
                            parallelChunkUploads: !1,
                            retryChunks: !1,
                            retryChunksLimit: 3,
                            maxFilesize: 256,
                            paramName: "file",
                            createImageThumbnails: !0,
                            maxThumbnailFilesize: 10,
                            thumbnailWidth: 120,
                            thumbnailHeight: 120,
                            thumbnailMethod: "crop",
                            resizeWidth: null,
                            resizeHeight: null,
                            resizeMimeType: null,
                            resizeQuality: .8,
                            resizeMethod: "contain",
                            filesizeBase: 1e3,
                            maxFiles: null,
                            headers: null,
                            clickable: !0,
                            ignoreHiddenFiles: !0,
                            acceptedFiles: null,
                            acceptedMimeTypes: null,
                            autoProcessQueue: !0,
                            autoQueue: !0,
                            addRemoveLinks: !1,
                            previewsContainer: null,
                            hiddenInputContainer: "body",
                            capture: null,
                            renameFilename: null,
                            renameFile: null,
                            forceFallback: !1,
                            dictDefaultMessage: "Drop files here to upload",
                            dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
                            dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
                            dictFileTooBig: "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",
                            dictInvalidFileType: "You can't upload files of this type.",
                            dictResponseError: "Server responded with {{statusCode}} code.",
                            dictCancelUpload: "Cancel upload",
                            dictUploadCanceled: "Upload canceled.",
                            dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
                            dictRemoveFile: "Remove file",
                            dictRemoveFileConfirmation: null,
                            dictMaxFilesExceeded: "You can not upload any more files.",
                            dictFileSizeUnits: {
                                tb: "TB",
                                gb: "GB",
                                mb: "MB",
                                kb: "KB",
                                b: "b"
                            },
                            init: function() {},
                            params: function(e, t, i) {
                                if (i) return {
                                    dzuuid: i.file.upload.uuid,
                                    dzchunkindex: i.index,
                                    dztotalfilesize: i.file.size,
                                    dzchunksize: this.options.chunkSize,
                                    dztotalchunkcount: i.file.upload.totalChunkCount,
                                    dzchunkbyteoffset: i.index * this.options.chunkSize
                                }
                            },
                            accept: function(e, t) {
                                return t()
                            },
                            chunksUploaded: function(e, t) {
                                t()
                            },
                            fallback: function() {
                                var e = void 0;
                                this.element.className = this.element.className + " dz-browser-not-supported";
                                for (var t = 0, i = i = this.element.getElementsByTagName("div");;) {
                                    if (t >= i.length) break;
                                    var n = i[t++];
                                    if (/(^| )dz-message($| )/.test(n.className)) {
                                        (e = n).className = "dz-message";
                                        break
                                    }
                                }
                                e || (e = w.createElement('<div class="dz-message"><span></span></div>'), this.element.appendChild(e));
                                var a = e.getElementsByTagName("span")[0];
                                return a && (null != a.textContent ? a.textContent = this.options.dictFallbackMessage : null != a.innerText && (a.innerText = this.options.dictFallbackMessage)), this.element.appendChild(this.getFallbackForm())
                            },
                            resize: function(e, t, i, n) {
                                var a = {
                                        srcX: 0,
                                        srcY: 0,
                                        srcWidth: e.width,
                                        srcHeight: e.height
                                    },
                                    r = e.width / e.height;
                                null == t && null == i ? (t = a.srcWidth, i = a.srcHeight) : null == t ? t = i * r : null == i && (i = t / r);
                                var s = (t = Math.min(t, a.srcWidth)) / (i = Math.min(i, a.srcHeight));
                                if (a.srcWidth > t || a.srcHeight > i)
                                    if ("crop" === n) s < r ? (a.srcHeight = e.height, a.srcWidth = a.srcHeight * s) : (a.srcWidth = e.width, a.srcHeight = a.srcWidth / s);
                                    else {
                                        if ("contain" !== n) throw new Error("Unknown resizeMethod '" + n + "'");
                                        s < r ? i = t / r : t = i * r
                                    } return a.srcX = (e.width - a.srcWidth) / 2, a.srcY = (e.height - a.srcHeight) / 2, a.trgWidth = t, a.trgHeight = i, a
                            },
                            transformFile: function(e, t) {
                                return (this.options.resizeWidth || this.options.resizeHeight) && e.type.match(/image.*/) ? this.resizeImage(e, this.options.resizeWidth, this.options.resizeHeight, this.options.resizeMethod, t) : t(e)
                            },
                            previewTemplate: '<div class="dz-preview dz-file-preview">\n  <div class="dz-image"><img data-dz-thumbnail /></div>\n  <div class="dz-details">\n    <div class="dz-size"><span data-dz-size></span></div>\n    <div class="dz-filename"><span data-dz-name></span></div>\n  </div>\n  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>\n  <div class="dz-error-message"><span data-dz-errormessage></span></div>\n  <div class="dz-success-mark">\n    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">\n      <title>Check</title>\n      <defs></defs>\n      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">\n        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>\n      </g>\n    </svg>\n  </div>\n  <div class="dz-error-mark">\n    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">\n      <title>Error</title>\n      <defs></defs>\n      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">\n        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">\n          <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>\n        </g>\n      </g>\n    </svg>\n  </div>\n</div>',
                            drop: function(e) {
                                return this.element.classList.remove("dz-drag-hover")
                            },
                            dragstart: function(e) {},
                            dragend: function(e) {
                                return this.element.classList.remove("dz-drag-hover")
                            },
                            dragenter: function(e) {
                                return this.element.classList.add("dz-drag-hover")
                            },
                            dragover: function(e) {
                                return this.element.classList.add("dz-drag-hover")
                            },
                            dragleave: function(e) {
                                return this.element.classList.remove("dz-drag-hover")
                            },
                            paste: function(e) {},
                            reset: function() {
                                return this.element.classList.remove("dz-started")
                            },
                            addedfile: function(t) {
                                var i = this;
                                if (this.element === this.previewsContainer && this.element.classList.add("dz-started"), this.previewsContainer) {
                                    t.previewElement = w.createElement(this.options.previewTemplate.trim()), t.previewTemplate = t.previewElement, this.previewsContainer.appendChild(t.previewElement);
                                    for (var e = 0, n = n = t.previewElement.querySelectorAll("[data-dz-name]");;) {
                                        if (e >= n.length) break;
                                        var a = n[e++];
                                        a.textContent = t.name
                                    }
                                    for (var r = 0, s = s = t.previewElement.querySelectorAll("[data-dz-size]"); !(r >= s.length);)(a = s[r++]).innerHTML = this.filesize(t.size);
                                    this.options.addRemoveLinks && (t._removeLink = w.createElement('<a class="dz-remove" href="javascript:undefined;" data-dz-remove>' + this.options.dictRemoveFile + "</a>"), t.previewElement.appendChild(t._removeLink));
                                    for (var o = function(e) {
                                            return e.preventDefault(), e.stopPropagation(), t.status === w.UPLOADING ? w.confirm(i.options.dictCancelUploadConfirmation, function() {
                                                return i.removeFile(t)
                                            }) : i.options.dictRemoveFileConfirmation ? w.confirm(i.options.dictRemoveFileConfirmation, function() {
                                                return i.removeFile(t)
                                            }) : i.removeFile(t)
                                        }, l = 0, c = c = t.previewElement.querySelectorAll("[data-dz-remove]");;) {
                                        if (l >= c.length) break;
                                        c[l++].addEventListener("click", o)
                                    }
                                }
                            },
                            removedfile: function(e) {
                                return null != e.previewElement && null != e.previewElement.parentNode && e.previewElement.parentNode.removeChild(e.previewElement), this._updateMaxFilesReachedClass()
                            },
                            thumbnail: function(e, t) {
                                if (e.previewElement) {
                                    e.previewElement.classList.remove("dz-file-preview");
                                    for (var i = 0, n = n = e.previewElement.querySelectorAll("[data-dz-thumbnail]");;) {
                                        if (i >= n.length) break;
                                        var a = n[i++];
                                        a.alt = e.name, a.src = t
                                    }
                                    return setTimeout(function() {
                                        return e.previewElement.classList.add("dz-image-preview")
                                    }, 1)
                                }
                            },
                            error: function(e, t) {
                                if (e.previewElement) {
                                    e.previewElement.classList.add("dz-error"), "String" != typeof t && t.error && (t = t.error);
                                    for (var i = 0, n = n = e.previewElement.querySelectorAll("[data-dz-errormessage]");;) {
                                        if (i >= n.length) break;
                                        n[i++].textContent = t
                                    }
                                }
                            },
                            errormultiple: function() {},
                            processing: function(e) {
                                if (e.previewElement && (e.previewElement.classList.add("dz-processing"), e._removeLink)) return e._removeLink.innerHTML = this.options.dictCancelUpload
                            },
                            processingmultiple: function() {},
                            uploadprogress: function(e, t, i) {
                                if (e.previewElement)
                                    for (var n = 0, a = a = e.previewElement.querySelectorAll("[data-dz-uploadprogress]");;) {
                                        if (n >= a.length) break;
                                        var r = a[n++];
                                        "PROGRESS" === r.nodeName ? r.value = t : r.style.width = t + "%"
                                    }
                            },
                            totaluploadprogress: function() {},
                            sending: function() {},
                            sendingmultiple: function() {},
                            success: function(e) {
                                if (e.previewElement) return e.previewElement.classList.add("dz-success")
                            },
                            successmultiple: function() {},
                            canceled: function(e) {
                                return this.emit("error", e, this.options.dictUploadCanceled)
                            },
                            canceledmultiple: function() {},
                            complete: function(e) {
                                if (e._removeLink && (e._removeLink.innerHTML = this.options.dictRemoveFile), e.previewElement) return e.previewElement.classList.add("dz-complete")
                            },
                            completemultiple: function() {},
                            maxfilesexceeded: function() {},
                            maxfilesreached: function() {},
                            queuecomplete: function() {},
                            addedfiles: function() {}
                        }, this.prototype._thumbnailQueue = [], this.prototype._processingThumbnail = !1
                    }
                }, {
                    key: "extend",
                    value: function(e) {
                        for (var t = arguments.length, i = Array(1 < t ? t - 1 : 0), n = 1; n < t; n++) i[n - 1] = arguments[n];
                        for (var a = 0, r = r = i;;) {
                            if (a >= r.length) break;
                            var s = r[a++];
                            for (var o in s) {
                                var l = s[o];
                                e[o] = l
                            }
                        }
                        return e
                    }
                }]), t(w, [{
                    key: "getAcceptedFiles",
                    value: function() {
                        return this.files.filter(function(e) {
                            return e.accepted
                        }).map(function(e) {
                            return e
                        })
                    }
                }, {
                    key: "getRejectedFiles",
                    value: function() {
                        return this.files.filter(function(e) {
                            return !e.accepted
                        }).map(function(e) {
                            return e
                        })
                    }
                }, {
                    key: "getFilesWithStatus",
                    value: function(t) {
                        return this.files.filter(function(e) {
                            return e.status === t
                        }).map(function(e) {
                            return e
                        })
                    }
                }, {
                    key: "getQueuedFiles",
                    value: function() {
                        return this.getFilesWithStatus(w.QUEUED)
                    }
                }, {
                    key: "getUploadingFiles",
                    value: function() {
                        return this.getFilesWithStatus(w.UPLOADING)
                    }
                }, {
                    key: "getAddedFiles",
                    value: function() {
                        return this.getFilesWithStatus(w.ADDED)
                    }
                }, {
                    key: "getActiveFiles",
                    value: function() {
                        return this.files.filter(function(e) {
                            return e.status === w.UPLOADING || e.status === w.QUEUED
                        }).map(function(e) {
                            return e
                        })
                    }
                }, {
                    key: "init",
                    value: function() {
                        var r = this;
                        if ("form" === this.element.tagName && this.element.setAttribute("enctype", "multipart/form-data"), this.element.classList.contains("dropzone") && !this.element.querySelector(".dz-message") && this.element.appendChild(w.createElement('<div class="dz-default dz-message"><span>' + this.options.dictDefaultMessage + "</span></div>")), this.clickableElements.length) {
                            ! function a() {
                                return r.hiddenFileInput && r.hiddenFileInput.parentNode.removeChild(r.hiddenFileInput), r.hiddenFileInput = document.createElement("input"), r.hiddenFileInput.setAttribute("type", "file"), (null === r.options.maxFiles || 1 < r.options.maxFiles) && r.hiddenFileInput.setAttribute("multiple", "multiple"), r.hiddenFileInput.className = "dz-hidden-input", null !== r.options.acceptedFiles && r.hiddenFileInput.setAttribute("accept", r.options.acceptedFiles), null !== r.options.capture && r.hiddenFileInput.setAttribute("capture", r.options.capture), r.hiddenFileInput.style.visibility = "hidden", r.hiddenFileInput.style.position = "absolute", r.hiddenFileInput.style.top = "0", r.hiddenFileInput.style.left = "0", r.hiddenFileInput.style.height = "0", r.hiddenFileInput.style.width = "0", w.getElement(r.options.hiddenInputContainer, "hiddenInputContainer").appendChild(r.hiddenFileInput), r.hiddenFileInput.addEventListener("change", function() {
                                    var e = r.hiddenFileInput.files;
                                    if (e.length)
                                        for (var t = 0, i = i = e; !(t >= i.length);) {
                                            var n = i[t++];
                                            r.addFile(n)
                                        }
                                    return r.emit("addedfiles", e), a()
                                })
                            }()
                        }
                        this.URL = null !== window.URL ? window.URL : window.webkitURL;
                        for (var e = 0, t = t = this.events;;) {
                            if (e >= t.length) break;
                            var i = t[e++];
                            this.on(i, this.options[i])
                        }
                        this.on("uploadprogress", function() {
                            return r.updateTotalUploadProgress()
                        }), this.on("removedfile", function() {
                            return r.updateTotalUploadProgress()
                        }), this.on("canceled", function(e) {
                            return r.emit("complete", e)
                        }), this.on("complete", function(e) {
                            if (0 === r.getAddedFiles().length && 0 === r.getUploadingFiles().length && 0 === r.getQueuedFiles().length) return setTimeout(function() {
                                return r.emit("queuecomplete")
                            }, 0)
                        });
                        var n = function(e) {
                            return e.stopPropagation(), e.preventDefault ? e.preventDefault() : e.returnValue = !1
                        };
                        return this.listeners = [{
                            element: this.element,
                            events: {
                                dragstart: function(e) {
                                    return r.emit("dragstart", e)
                                },
                                dragenter: function(e) {
                                    return n(e), r.emit("dragenter", e)
                                },
                                dragover: function(e) {
                                    var t = void 0;
                                    try {
                                        t = e.dataTransfer.effectAllowed
                                    } catch (e) {}
                                    return e.dataTransfer.dropEffect = "move" === t || "linkMove" === t ? "move" : "copy", n(e), r.emit("dragover", e)
                                },
                                dragleave: function(e) {
                                    return r.emit("dragleave", e)
                                },
                                drop: function(e) {
                                    return n(e), r.drop(e)
                                },
                                dragend: function(e) {
                                    return r.emit("dragend", e)
                                }
                            }
                        }], this.clickableElements.forEach(function(t) {
                            return r.listeners.push({
                                element: t,
                                events: {
                                    click: function(e) {
                                        return (t !== r.element || e.target === r.element || w.elementInside(e.target, r.element.querySelector(".dz-message"))) && r.hiddenFileInput.click(), !0
                                    }
                                }
                            })
                        }), this.enable(), this.options.init.call(this)
                    }
                }, {
                    key: "destroy",
                    value: function() {
                        return this.disable(), this.removeAllFiles(!0), (null != this.hiddenFileInput ? this.hiddenFileInput.parentNode : void 0) && (this.hiddenFileInput.parentNode.removeChild(this.hiddenFileInput), this.hiddenFileInput = null), delete this.element.dropzone, w.instances.splice(w.instances.indexOf(this), 1)
                    }
                }, {
                    key: "updateTotalUploadProgress",
                    value: function() {
                        var e = void 0,
                            t = 0,
                            i = 0;
                        if (this.getActiveFiles().length) {
                            for (var n = 0, a = a = this.getActiveFiles();;) {
                                if (n >= a.length) break;
                                var r = a[n++];
                                t += r.upload.bytesSent, i += r.upload.total
                            }
                            e = 100 * t / i
                        } else e = 100;
                        return this.emit("totaluploadprogress", e, i, t)
                    }
                }, {
                    key: "_getParamName",
                    value: function(e) {
                        return "function" == typeof this.options.paramName ? this.options.paramName(e) : this.options.paramName + (this.options.uploadMultiple ? "[" + e + "]" : "")
                    }
                }, {
                    key: "_renameFile",
                    value: function(e) {
                        return "function" != typeof this.options.renameFile ? e.name : this.options.renameFile(e)
                    }
                }, {
                    key: "getFallbackForm",
                    value: function() {
                        var e, t = void 0;
                        if (e = this.getExistingFallback()) return e;
                        var i = '<div class="dz-fallback">';
                        this.options.dictFallbackText && (i += "<p>" + this.options.dictFallbackText + "</p>"), i += '<input type="file" name="' + this._getParamName(0) + '" ' + (this.options.uploadMultiple ? 'multiple="multiple"' : void 0) + ' /><input type="submit" value="Upload!"></div>';
                        var n = w.createElement(i);
                        return "FORM" !== this.element.tagName ? (t = w.createElement('<form action="' + this.options.url + '" enctype="multipart/form-data" method="' + this.options.method + '"></form>')).appendChild(n) : (this.element.setAttribute("enctype", "multipart/form-data"), this.element.setAttribute("method", this.options.method)), null != t ? t : n
                    }
                }, {
                    key: "getExistingFallback",
                    value: function() {
                        for (var e = function(e) {
                                for (var t = 0, i = i = e;;) {
                                    if (t >= i.length) break;
                                    var n = i[t++];
                                    if (/(^| )fallback($| )/.test(n.className)) return n
                                }
                            }, t = ["div", "form"], i = 0; i < t.length; i++) {
                            var n, a = t[i];
                            if (n = e(this.element.getElementsByTagName(a))) return n
                        }
                    }
                }, {
                    key: "setupEventListeners",
                    value: function() {
                        return this.listeners.map(function(n) {
                            return function() {
                                var e = [];
                                for (var t in n.events) {
                                    var i = n.events[t];
                                    e.push(n.element.addEventListener(t, i, !1))
                                }
                                return e
                            }()
                        })
                    }
                }, {
                    key: "removeEventListeners",
                    value: function() {
                        return this.listeners.map(function(n) {
                            return function() {
                                var e = [];
                                for (var t in n.events) {
                                    var i = n.events[t];
                                    e.push(n.element.removeEventListener(t, i, !1))
                                }
                                return e
                            }()
                        })
                    }
                }, {
                    key: "disable",
                    value: function() {
                        var t = this;
                        return this.clickableElements.forEach(function(e) {
                            return e.classList.remove("dz-clickable")
                        }), this.removeEventListeners(), this.disabled = !0, this.files.map(function(e) {
                            return t.cancelUpload(e)
                        })
                    }
                }, {
                    key: "enable",
                    value: function() {
                        return delete this.disabled, this.clickableElements.forEach(function(e) {
                            return e.classList.add("dz-clickable")
                        }), this.setupEventListeners()
                    }
                }, {
                    key: "filesize",
                    value: function(e) {
                        var t = 0,
                            i = "b";
                        if (0 < e) {
                            for (var n = ["tb", "gb", "mb", "kb", "b"], a = 0; a < n.length; a++) {
                                var r = n[a];
                                if (Math.pow(this.options.filesizeBase, 4 - a) / 10 <= e) {
                                    t = e / Math.pow(this.options.filesizeBase, 4 - a), i = r;
                                    break
                                }
                            }
                            t = Math.round(10 * t) / 10
                        }
                        return "<strong>" + t + "</strong> " + this.options.dictFileSizeUnits[i]
                    }
                }, {
                    key: "_updateMaxFilesReachedClass",
                    value: function() {
                        return null != this.options.maxFiles && this.getAcceptedFiles().length >= this.options.maxFiles ? (this.getAcceptedFiles().length === this.options.maxFiles && this.emit("maxfilesreached", this.files), this.element.classList.add("dz-max-files-reached")) : this.element.classList.remove("dz-max-files-reached")
                    }
                }, {
                    key: "drop",
                    value: function(e) {
                        if (e.dataTransfer) {
                            this.emit("drop", e);
                            for (var t = [], i = 0; i < e.dataTransfer.files.length; i++) t[i] = e.dataTransfer.files[i];
                            if (this.emit("addedfiles", t), t.length) {
                                var n = e.dataTransfer.items;
                                n && n.length && null != n[0].webkitGetAsEntry ? this._addFilesFromItems(n) : this.handleFiles(t)
                            }
                        }
                    }
                }, {
                    key: "paste",
                    value: function(e) {
                        if (null != (t = null != e ? e.clipboardData : void 0, i = function(e) {
                                return e.items
                            }, null != t ? i(t) : void 0)) {
                            var t, i;
                            this.emit("paste", e);
                            var n = e.clipboardData.items;
                            return n.length ? this._addFilesFromItems(n) : void 0
                        }
                    }
                }, {
                    key: "handleFiles",
                    value: function(e) {
                        for (var t = 0, i = i = e;;) {
                            if (t >= i.length) break;
                            var n = i[t++];
                            this.addFile(n)
                        }
                    }
                }, {
                    key: "_addFilesFromItems",
                    value: function(r) {
                        var s = this;
                        return function() {
                            for (var e = [], t = 0, i = i = r;;) {
                                if (t >= i.length) break;
                                var n, a = i[t++];
                                null != a.webkitGetAsEntry && (n = a.webkitGetAsEntry()) ? n.isFile ? e.push(s.addFile(a.getAsFile())) : n.isDirectory ? e.push(s._addFilesFromDirectory(n, n.name)) : e.push(void 0) : null != a.getAsFile && (null == a.kind || "file" === a.kind) ? e.push(s.addFile(a.getAsFile())) : e.push(void 0)
                            }
                            return e
                        }()
                    }
                }, {
                    key: "_addFilesFromDirectory",
                    value: function(e, r) {
                        var s = this,
                            t = e.createReader(),
                            i = function(t) {
                                return e = console, i = "log", n = function(e) {
                                    return e.log(t)
                                }, null != e && "function" == typeof e[i] ? n(e, i) : void 0;
                                var e, i, n
                            };
                        return function a() {
                            return t.readEntries(function(e) {
                                if (0 < e.length) {
                                    for (var t = 0, i = i = e; !(t >= i.length);) {
                                        var n = i[t++];
                                        n.isFile ? n.file(function(e) {
                                            if (!s.options.ignoreHiddenFiles || "." !== e.name.substring(0, 1)) return e.fullPath = r + "/" + e.name, s.addFile(e)
                                        }) : n.isDirectory && s._addFilesFromDirectory(n, r + "/" + n.name)
                                    }
                                    a()
                                }
                                return null
                            }, i)
                        }()
                    }
                }, {
                    key: "accept",
                    value: function(e, t) {
                        return this.options.maxFilesize && e.size > 1024 * this.options.maxFilesize * 1024 ? t(this.options.dictFileTooBig.replace("{{filesize}}", Math.round(e.size / 1024 / 10.24) / 100).replace("{{maxFilesize}}", this.options.maxFilesize)) : w.isValidFile(e, this.options.acceptedFiles) ? null != this.options.maxFiles && this.getAcceptedFiles().length >= this.options.maxFiles ? (t(this.options.dictMaxFilesExceeded.replace("{{maxFiles}}", this.options.maxFiles)), this.emit("maxfilesexceeded", e)) : this.options.accept.call(this, e, t) : t(this.options.dictInvalidFileType)
                    }
                }, {
                    key: "addFile",
                    value: function(t) {
                        var i = this;
                        return t.upload = {
                            uuid: w.uuidv4(),
                            progress: 0,
                            total: t.size,
                            bytesSent: 0,
                            filename: this._renameFile(t),
                            chunked: this.options.chunking && (this.options.forceChunking || t.size > this.options.chunkSize),
                            totalChunkCount: Math.ceil(t.size / this.options.chunkSize)
                        }, this.files.push(t), t.status = w.ADDED, this.emit("addedfile", t), this._enqueueThumbnail(t), this.accept(t, function(e) {
                            return e ? (t.accepted = !1, i._errorProcessing([t], e)) : (t.accepted = !0, i.options.autoQueue && i.enqueueFile(t)), i._updateMaxFilesReachedClass()
                        })
                    }
                }, {
                    key: "enqueueFiles",
                    value: function(e) {
                        for (var t = 0, i = i = e;;) {
                            if (t >= i.length) break;
                            var n = i[t++];
                            this.enqueueFile(n)
                        }
                        return null
                    }
                }, {
                    key: "enqueueFile",
                    value: function(e) {
                        var t = this;
                        if (e.status !== w.ADDED || !0 !== e.accepted) throw new Error("This file can't be queued because it has already been processed or was rejected.");
                        if (e.status = w.QUEUED, this.options.autoProcessQueue) return setTimeout(function() {
                            return t.processQueue()
                        }, 0)
                    }
                }, {
                    key: "_enqueueThumbnail",
                    value: function(e) {
                        var t = this;
                        if (this.options.createImageThumbnails && e.type.match(/image.*/) && e.size <= 1024 * this.options.maxThumbnailFilesize * 1024) return this._thumbnailQueue.push(e), setTimeout(function() {
                            return t._processThumbnailQueue()
                        }, 0)
                    }
                }, {
                    key: "_processThumbnailQueue",
                    value: function() {
                        var t = this;
                        if (!this._processingThumbnail && 0 !== this._thumbnailQueue.length) {
                            this._processingThumbnail = !0;
                            var i = this._thumbnailQueue.shift();
                            return this.createThumbnail(i, this.options.thumbnailWidth, this.options.thumbnailHeight, this.options.thumbnailMethod, !0, function(e) {
                                return t.emit("thumbnail", i, e), t._processingThumbnail = !1, t._processThumbnailQueue()
                            })
                        }
                    }
                }, {
                    key: "removeFile",
                    value: function(e) {
                        if (e.status === w.UPLOADING && this.cancelUpload(e), this.files = n(this.files, e), this.emit("removedfile", e), 0 === this.files.length) return this.emit("reset")
                    }
                }, {
                    key: "removeAllFiles",
                    value: function(e) {
                        null == e && (e = !1);
                        for (var t = 0, i = i = this.files.slice();;) {
                            if (t >= i.length) break;
                            var n = i[t++];
                            (n.status !== w.UPLOADING || e) && this.removeFile(n)
                        }
                        return null
                    }
                }, {
                    key: "resizeImage",
                    value: function(a, e, t, i, r) {
                        var s = this;
                        return this.createThumbnail(a, e, t, i, !0, function(e, t) {
                            if (null == t) return r(a);
                            var i = s.options.resizeMimeType;
                            null == i && (i = a.type);
                            var n = t.toDataURL(i, s.options.resizeQuality);
                            return "image/jpeg" !== i && "image/jpg" !== i || (n = c.restore(a.dataURL, n)), r(w.dataURItoBlob(n))
                        })
                    }
                }, {
                    key: "createThumbnail",
                    value: function(e, t, i, n, a, r) {
                        var s = this,
                            o = new FileReader;
                        return o.onload = function() {
                            if (e.dataURL = o.result, "image/svg+xml" !== e.type) return s.createThumbnailFromUrl(e, t, i, n, a, r);
                            null != r && r(o.result)
                        }, o.readAsDataURL(e)
                    }
                }, {
                    key: "createThumbnailFromUrl",
                    value: function(r, s, o, l, t, c, e) {
                        var d = this,
                            u = document.createElement("img");
                        return e && (u.crossOrigin = e), u.onload = function() {
                            var e = function(e) {
                                return e(1)
                            };
                            return "undefined" != typeof EXIF && null !== EXIF && t && (e = function(e) {
                                return EXIF.getData(u, function() {
                                    return e(EXIF.getTag(this, "Orientation"))
                                })
                            }), e(function(e) {
                                r.width = u.width, r.height = u.height;
                                var t = d.options.resize.call(d, r, s, o, l),
                                    i = document.createElement("canvas"),
                                    n = i.getContext("2d");
                                switch (i.width = t.trgWidth, i.height = t.trgHeight, 4 < e && (i.width = t.trgHeight, i.height = t.trgWidth), e) {
                                    case 2:
                                        n.translate(i.width, 0), n.scale(-1, 1);
                                        break;
                                    case 3:
                                        n.translate(i.width, i.height), n.rotate(Math.PI);
                                        break;
                                    case 4:
                                        n.translate(0, i.height), n.scale(1, -1);
                                        break;
                                    case 5:
                                        n.rotate(.5 * Math.PI), n.scale(1, -1);
                                        break;
                                    case 6:
                                        n.rotate(.5 * Math.PI), n.translate(0, -i.width);
                                        break;
                                    case 7:
                                        n.rotate(.5 * Math.PI), n.translate(i.height, -i.width), n.scale(-1, 1);
                                        break;
                                    case 8:
                                        n.rotate(-.5 * Math.PI), n.translate(-i.height, 0)
                                }
                                h(n, u, null != t.srcX ? t.srcX : 0, null != t.srcY ? t.srcY : 0, t.srcWidth, t.srcHeight, null != t.trgX ? t.trgX : 0, null != t.trgY ? t.trgY : 0, t.trgWidth, t.trgHeight);
                                var a = i.toDataURL("image/png");
                                if (null != c) return c(a, i)
                            })
                        }, null != c && (u.onerror = c), u.src = r.dataURL
                    }
                }, {
                    key: "processQueue",
                    value: function() {
                        var e = this.options.parallelUploads,
                            t = this.getUploadingFiles().length,
                            i = t;
                        if (!(e <= t)) {
                            var n = this.getQueuedFiles();
                            if (0 < n.length) {
                                if (this.options.uploadMultiple) return this.processFiles(n.slice(0, e - t));
                                for (; i < e;) {
                                    if (!n.length) return;
                                    this.processFile(n.shift()), i++
                                }
                            }
                        }
                    }
                }, {
                    key: "processFile",
                    value: function(e) {
                        return this.processFiles([e])
                    }
                }, {
                    key: "processFiles",
                    value: function(e) {
                        for (var t = 0, i = i = e;;) {
                            if (t >= i.length) break;
                            var n = i[t++];
                            n.processing = !0, n.status = w.UPLOADING, this.emit("processing", n)
                        }
                        return this.options.uploadMultiple && this.emit("processingmultiple", e), this.uploadFiles(e)
                    }
                }, {
                    key: "_getFilesWithXhr",
                    value: function(t) {
                        return this.files.filter(function(e) {
                            return e.xhr === t
                        }).map(function(e) {
                            return e
                        })
                    }
                }, {
                    key: "cancelUpload",
                    value: function(e) {
                        if (e.status === w.UPLOADING) {
                            for (var t = this._getFilesWithXhr(e.xhr), i = 0, n = n = t;;) {
                                if (i >= n.length) break;
                                n[i++].status = w.CANCELED
                            }
                            void 0 !== e.xhr && e.xhr.abort();
                            for (var a = 0, r = r = t;;) {
                                if (a >= r.length) break;
                                var s = r[a++];
                                this.emit("canceled", s)
                            }
                            this.options.uploadMultiple && this.emit("canceledmultiple", t)
                        } else e.status !== w.ADDED && e.status !== w.QUEUED || (e.status = w.CANCELED, this.emit("canceled", e), this.options.uploadMultiple && this.emit("canceledmultiple", [e]));
                        if (this.options.autoProcessQueue) return this.processQueue()
                    }
                }, {
                    key: "resolveOption",
                    value: function(e) {
                        if ("function" != typeof e) return e;
                        for (var t = arguments.length, i = Array(1 < t ? t - 1 : 0), n = 1; n < t; n++) i[n - 1] = arguments[n];
                        return e.apply(this, i)
                    }
                }, {
                    key: "uploadFile",
                    value: function(e) {
                        return this.uploadFiles([e])
                    }
                }, {
                    key: "uploadFiles",
                    value: function(o) {
                        var l = this;
                        this._transformFiles(o, function(e) {
                            if (o[0].upload.chunked) {
                                var a = o[0],
                                    r = e[0];
                                a.upload.chunks = [];
                                var n = function() {
                                    for (var e = 0; void 0 !== a.upload.chunks[e];) e++;
                                    if (!(e >= a.upload.totalChunkCount)) {
                                        0;
                                        var t = e * l.options.chunkSize,
                                            i = Math.min(t + l.options.chunkSize, a.size),
                                            n = {
                                                name: l._getParamName(0),
                                                data: r.webkitSlice ? r.webkitSlice(t, i) : r.slice(t, i),
                                                filename: a.upload.filename,
                                                chunkIndex: e
                                            };
                                        a.upload.chunks[e] = {
                                            file: a,
                                            index: e,
                                            dataBlock: n,
                                            status: w.UPLOADING,
                                            progress: 0,
                                            retries: 0
                                        }, l._uploadData(o, [n])
                                    }
                                };
                                if (a.upload.finishedChunkUpload = function(e) {
                                        var t = !0;
                                        e.status = w.SUCCESS, e.dataBlock = null, e.xhr = null;
                                        for (var i = 0; i < a.upload.totalChunkCount; i++) {
                                            if (void 0 === a.upload.chunks[i]) return n();
                                            a.upload.chunks[i].status !== w.SUCCESS && (t = !1)
                                        }
                                        t && l.options.chunksUploaded(a, function() {
                                            l._finished(o, "", null)
                                        })
                                    }, l.options.parallelChunkUploads)
                                    for (var t = 0; t < a.upload.totalChunkCount; t++) n();
                                else n()
                            } else {
                                for (var i = [], s = 0; s < o.length; s++) i[s] = {
                                    name: l._getParamName(s),
                                    data: e[s],
                                    filename: o[s].upload.filename
                                };
                                l._uploadData(o, i)
                            }
                        })
                    }
                }, {
                    key: "_getChunk",
                    value: function(e, t) {
                        for (var i = 0; i < e.upload.totalChunkCount; i++)
                            if (void 0 !== e.upload.chunks[i] && e.upload.chunks[i].xhr === t) return e.upload.chunks[i]
                    }
                }, {
                    key: "_uploadData",
                    value: function(t, e) {
                        for (var i = this, n = new XMLHttpRequest, a = 0, r = r = t;;) {
                            if (a >= r.length) break;
                            r[a++].xhr = n
                        }
                        t[0].upload.chunked && (t[0].upload.chunks[e[0].chunkIndex].xhr = n);
                        var s = this.resolveOption(this.options.method, t),
                            o = this.resolveOption(this.options.url, t);
                        n.open(s, o, !0), n.timeout = this.resolveOption(this.options.timeout, t), n.withCredentials = !!this.options.withCredentials, n.onload = function(e) {
                            i._finishedUploading(t, n, e)
                        }, n.onerror = function() {
                            i._handleUploadError(t, n)
                        }, (null != n.upload ? n.upload : n).onprogress = function(e) {
                            return i._updateFilesUploadProgress(t, n, e)
                        };
                        var l = {
                            Accept: "application/json",
                            "Cache-Control": "no-cache",
                            "X-Requested-With": "XMLHttpRequest"
                        };
                        for (var c in this.options.headers && w.extend(l, this.options.headers), l) {
                            var d = l[c];
                            d && n.setRequestHeader(c, d)
                        }
                        var u = new FormData;
                        if (this.options.params) {
                            var h = this.options.params;
                            for (var p in "function" == typeof h && (h = h.call(this, t, n, t[0].upload.chunked ? this._getChunk(t[0], n) : null)), h) {
                                var f = h[p];
                                u.append(p, f)
                            }
                        }
                        for (var v = 0, m = m = t;;) {
                            if (v >= m.length) break;
                            var g = m[v++];
                            this.emit("sending", g, n, u)
                        }
                        this.options.uploadMultiple && this.emit("sendingmultiple", t, n, u), this._addFormElementData(u);
                        for (var y = 0; y < e.length; y++) {
                            var b = e[y];
                            u.append(b.name, b.data, b.filename)
                        }
                        this.submitRequest(n, u, t)
                    }
                }, {
                    key: "_transformFiles",
                    value: function(i, n) {
                        for (var e = this, a = [], r = 0, t = function(t) {
                                e.options.transformFile.call(e, i[t], function(e) {
                                    a[t] = e, ++r === i.length && n(a)
                                })
                            }, s = 0; s < i.length; s++) t(s)
                    }
                }, {
                    key: "_addFormElementData",
                    value: function(e) {
                        if ("FORM" === this.element.tagName)
                            for (var t = 0, i = i = this.element.querySelectorAll("input, textarea, select, button");;) {
                                if (t >= i.length) break;
                                var n = i[t++],
                                    a = n.getAttribute("name"),
                                    r = n.getAttribute("type");
                                if (r && (r = r.toLowerCase()), null != a)
                                    if ("SELECT" === n.tagName && n.hasAttribute("multiple"))
                                        for (var s = 0, o = o = n.options;;) {
                                            if (s >= o.length) break;
                                            var l = o[s++];
                                            l.selected && e.append(a, l.value)
                                        } else(!r || "checkbox" !== r && "radio" !== r || n.checked) && e.append(a, n.value)
                            }
                    }
                }, {
                    key: "_updateFilesUploadProgress",
                    value: function(e, t, i) {
                        var n = void 0;
                        if (void 0 !== i) {
                            if (n = 100 * i.loaded / i.total, e[0].upload.chunked) {
                                var a = e[0],
                                    r = this._getChunk(a, t);
                                r.progress = n, r.total = i.total, r.bytesSent = i.loaded;
                                a.upload.progress = 0, a.upload.total = 0;
                                for (var s = a.upload.bytesSent = 0; s < a.upload.totalChunkCount; s++) void 0 !== a.upload.chunks[s] && void 0 !== a.upload.chunks[s].progress && (a.upload.progress += a.upload.chunks[s].progress, a.upload.total += a.upload.chunks[s].total, a.upload.bytesSent += a.upload.chunks[s].bytesSent);
                                a.upload.progress = a.upload.progress / a.upload.totalChunkCount
                            } else
                                for (var o = 0, l = l = e;;) {
                                    if (o >= l.length) break;
                                    var c = l[o++];
                                    c.upload.progress = n, c.upload.total = i.total, c.upload.bytesSent = i.loaded
                                }
                            for (var d = 0, u = u = e;;) {
                                if (d >= u.length) break;
                                var h = u[d++];
                                this.emit("uploadprogress", h, h.upload.progress, h.upload.bytesSent)
                            }
                        } else {
                            var p = !0;
                            n = 100;
                            for (var f = 0, v = v = e;;) {
                                if (f >= v.length) break;
                                var m = v[f++];
                                100 === m.upload.progress && m.upload.bytesSent === m.upload.total || (p = !1), m.upload.progress = n, m.upload.bytesSent = m.upload.total
                            }
                            if (p) return;
                            for (var g = 0, y = y = e;;) {
                                if (g >= y.length) break;
                                var b = y[g++];
                                this.emit("uploadprogress", b, n, b.upload.bytesSent)
                            }
                        }
                    }
                }, {
                    key: "_finishedUploading",
                    value: function(e, t, i) {
                        var n = void 0;
                        if (e[0].status !== w.CANCELED && 4 === t.readyState) {
                            if ("arraybuffer" !== t.responseType && "blob" !== t.responseType && (n = t.responseText, t.getResponseHeader("content-type") && ~t.getResponseHeader("content-type").indexOf("application/json"))) try {
                                n = JSON.parse(n)
                            } catch (e) {
                                i = e, n = "Invalid JSON response from server."
                            }
                            this._updateFilesUploadProgress(e), 200 <= t.status && t.status < 300 ? e[0].upload.chunked ? e[0].upload.finishedChunkUpload(this._getChunk(e[0], t)) : this._finished(e, n, i) : this._handleUploadError(e, t, n)
                        }
                    }
                }, {
                    key: "_handleUploadError",
                    value: function(e, t, i) {
                        if (e[0].status !== w.CANCELED) {
                            if (e[0].upload.chunked && this.options.retryChunks) {
                                var n = this._getChunk(e[0], t);
                                if (n.retries++ < this.options.retryChunksLimit) return void this._uploadData(e, [n.dataBlock]);
                                console.warn("Retried this chunk too often. Giving up.")
                            }
                            for (var a = 0, r = r = e;;) {
                                if (a >= r.length) break;
                                r[a++];
                                this._errorProcessing(e, i || this.options.dictResponseError.replace("{{statusCode}}", t.status), t)
                            }
                        }
                    }
                }, {
                    key: "submitRequest",
                    value: function(e, t, i) {
                        e.send(t)
                    }
                }, {
                    key: "_finished",
                    value: function(e, t, i) {
                        for (var n = 0, a = a = e;;) {
                            if (n >= a.length) break;
                            var r = a[n++];
                            r.status = w.SUCCESS, this.emit("success", r, t, i), this.emit("complete", r)
                        }
                        if (this.options.uploadMultiple && (this.emit("successmultiple", e, t, i), this.emit("completemultiple", e)), this.options.autoProcessQueue) return this.processQueue()
                    }
                }, {
                    key: "_errorProcessing",
                    value: function(e, t, i) {
                        for (var n = 0, a = a = e;;) {
                            if (n >= a.length) break;
                            var r = a[n++];
                            r.status = w.ERROR, this.emit("error", r, t, i), this.emit("complete", r)
                        }
                        if (this.options.uploadMultiple && (this.emit("errormultiple", e, t, i), this.emit("completemultiple", e)), this.options.autoProcessQueue) return this.processQueue()
                    }
                }], [{
                    key: "uuidv4",
                    value: function() {
                        return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(e) {
                            var t = 16 * Math.random() | 0;
                            return ("x" === e ? t : 3 & t | 8).toString(16)
                        })
                    }
                }]), w
            }();
        a.initClass(), a.version = "5.5.1", a.options = {}, a.optionsForElement = function(e) {
            return e.getAttribute("id") ? a.options[r(e.getAttribute("id"))] : void 0
        }, a.instances = [], a.forElement = function(e) {
            if ("string" == typeof e && (e = document.querySelector(e)), null == (null != e ? e.dropzone : void 0)) throw new Error("No Dropzone found for given element. This is probably because you're trying to access it before Dropzone had the time to initialize. Use the `init` option to setup any additional observers on your Dropzone.");
            return e.dropzone
        }, a.autoDiscover = !0, a.discover = function() {
            var r = void 0;
            if (document.querySelectorAll) r = document.querySelectorAll(".dropzone");
            else {
                r = [];
                var e = function(a) {
                    return function() {
                        for (var e = [], t = 0, i = i = a;;) {
                            if (t >= i.length) break;
                            var n = i[t++];
                            /(^| )dropzone($| )/.test(n.className) ? e.push(r.push(n)) : e.push(void 0)
                        }
                        return e
                    }()
                };
                e(document.getElementsByTagName("div")), e(document.getElementsByTagName("form"))
            }
            return function() {
                for (var e = [], t = 0, i = i = r;;) {
                    if (t >= i.length) break;
                    var n = i[t++];
                    !1 !== a.optionsForElement(n) ? e.push(new a(n)) : e.push(void 0)
                }
                return e
            }()
        }, a.blacklistedBrowsers = [/opera.*(Macintosh|Windows Phone).*version\/12/i], a.isBrowserSupported = function() {
            var e = !0;
            if (window.File && window.FileReader && window.FileList && window.Blob && window.FormData && document.querySelector)
                if ("classList" in document.createElement("a"))
                    for (var t = 0, i = i = a.blacklistedBrowsers;;) {
                        if (t >= i.length) break;
                        i[t++].test(navigator.userAgent) && (e = !1)
                    } else e = !1;
                else e = !1;
            return e
        }, a.dataURItoBlob = function(e) {
            for (var t = atob(e.split(",")[1]), i = e.split(",")[0].split(":")[1].split(";")[0], n = new ArrayBuffer(t.length), a = new Uint8Array(n), r = 0, s = t.length, o = 0 <= s; o ? r <= s : s <= r; o ? r++ : r--) a[r] = t.charCodeAt(r);
            return new Blob([n], {
                type: i
            })
        };
        var n = function(e, t) {
                return e.filter(function(e) {
                    return e !== t
                }).map(function(e) {
                    return e
                })
            },
            r = function(e) {
                return e.replace(/[\-_](\w)/g, function(e) {
                    return e.charAt(1).toUpperCase()
                })
            };
        a.createElement = function(e) {
            var t = document.createElement("div");
            return t.innerHTML = e, t.childNodes[0]
        }, a.elementInside = function(e, t) {
            if (e === t) return !0;
            for (; e = e.parentNode;)
                if (e === t) return !0;
            return !1
        }, a.getElement = function(e, t) {
            var i = void 0;
            if ("string" == typeof e ? i = document.querySelector(e) : null != e.nodeType && (i = e), null == i) throw new Error("Invalid `" + t + "` option provided. Please provide a CSS selector or a plain HTML element.");
            return i
        }, a.getElements = function(e, t) {
            var i = void 0,
                n = void 0;
            if (e instanceof Array) {
                n = [];
                try {
                    for (var a = 0, r = r = e; !(a >= r.length);) i = r[a++], n.push(this.getElement(i, t))
                } catch (e) {
                    n = null
                }
            } else if ("string" == typeof e) {
                n = [];
                for (var s = 0, o = o = document.querySelectorAll(e); !(s >= o.length);) i = o[s++], n.push(i)
            } else null != e.nodeType && (n = [e]);
            if (null == n || !n.length) throw new Error("Invalid `" + t + "` option provided. Please provide a CSS selector, a plain HTML element or a list of those.");
            return n
        }, a.confirm = function(e, t, i) {
            return window.confirm(e) ? t() : null != i ? i() : void 0
        }, a.isValidFile = function(e, t) {
            if (!t) return !0;
            t = t.split(",");
            for (var i = e.type, n = i.replace(/\/.*$/, ""), a = 0, r = r = t;;) {
                if (a >= r.length) break;
                var s = r[a++];
                if ("." === (s = s.trim()).charAt(0)) {
                    if (-1 !== e.name.toLowerCase().indexOf(s.toLowerCase(), e.name.length - s.length)) return !0
                } else if (/\/\*$/.test(s)) {
                    if (n === s.replace(/\/.*$/, "")) return !0
                } else if (i === s) return !0
            }
            return !1
        }, "undefined" != typeof jQuery && null !== jQuery && (jQuery.fn.dropzone = function(e) {
            return this.each(function() {
                return new a(this, e)
            })
        }), null !== e ? e.exports = a : window.Dropzone = a, a.ADDED = "added", a.QUEUED = "queued", a.ACCEPTED = a.QUEUED, a.UPLOADING = "uploading", a.PROCESSING = a.UPLOADING, a.CANCELED = "canceled", a.ERROR = "error", a.SUCCESS = "success";
        var h = function(e, t, i, n, a, r, s, o, l, c) {
                var d = function(e) {
                    e.naturalWidth;
                    var t = e.naturalHeight,
                        i = document.createElement("canvas");
                    i.width = 1, i.height = t;
                    var n = i.getContext("2d");
                    n.drawImage(e, 0, 0);
                    for (var a = n.getImageData(1, 0, 1, t).data, r = 0, s = t, o = t; r < o;) 0 === a[4 * (o - 1) + 3] ? s = o : r = o, o = s + r >> 1;
                    var l = o / t;
                    return 0 === l ? 1 : l
                }(t);
                return e.drawImage(t, i, n, a, r, s, o, l, c / d)
            },
            c = function() {
                function e() {
                    l(this, e)
                }
                return t(e, null, [{
                    key: "initClass",
                    value: function() {
                        this.KEY_STR = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/="
                    }
                }, {
                    key: "encode64",
                    value: function(e) {
                        for (var t = "", i = void 0, n = void 0, a = "", r = void 0, s = void 0, o = void 0, l = "", c = 0; r = (i = e[c++]) >> 2, s = (3 & i) << 4 | (n = e[c++]) >> 4, o = (15 & n) << 2 | (a = e[c++]) >> 6, l = 63 & a, isNaN(n) ? o = l = 64 : isNaN(a) && (l = 64), t = t + this.KEY_STR.charAt(r) + this.KEY_STR.charAt(s) + this.KEY_STR.charAt(o) + this.KEY_STR.charAt(l), i = n = a = "", r = s = o = l = "", c < e.length;);
                        return t
                    }
                }, {
                    key: "restore",
                    value: function(e, t) {
                        if (!e.match("data:image/jpeg;base64,")) return t;
                        var i = this.decode64(e.replace("data:image/jpeg;base64,", "")),
                            n = this.slice2Segments(i),
                            a = this.exifManipulation(t, n);
                        return "data:image/jpeg;base64," + this.encode64(a)
                    }
                }, {
                    key: "exifManipulation",
                    value: function(e, t) {
                        var i = this.getExifArray(t),
                            n = this.insertExif(e, i);
                        return new Uint8Array(n)
                    }
                }, {
                    key: "getExifArray",
                    value: function(e) {
                        for (var t = void 0, i = 0; i < e.length;) {
                            if (255 === (t = e[i])[0] & 225 === t[1]) return t;
                            i++
                        }
                        return []
                    }
                }, {
                    key: "insertExif",
                    value: function(e, t) {
                        var i = e.replace("data:image/jpeg;base64,", ""),
                            n = this.decode64(i),
                            a = n.indexOf(255, 3),
                            r = n.slice(0, a),
                            s = n.slice(a),
                            o = r;
                        return o = (o = o.concat(t)).concat(s)
                    }
                }, {
                    key: "slice2Segments",
                    value: function(e) {
                        for (var t = 0, i = [];;) {
                            if (255 === e[t] & 218 === e[t + 1]) break;
                            if (255 === e[t] & 216 === e[t + 1]) t += 2;
                            else {
                                var n = t + (256 * e[t + 2] + e[t + 3]) + 2,
                                    a = e.slice(t, n);
                                i.push(a), t = n
                            }
                            if (t > e.length) break
                        }
                        return i
                    }
                }, {
                    key: "decode64",
                    value: function(e) {
                        var t = void 0,
                            i = void 0,
                            n = "",
                            a = void 0,
                            r = void 0,
                            s = "",
                            o = 0,
                            l = [];
                        for (/[^A-Za-z0-9\+\/\=]/g.exec(e) && console.warn("There were invalid base64 characters in the input text.\nValid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\nExpect errors in decoding."), e = e.replace(/[^A-Za-z0-9\+\/\=]/g, ""); t = this.KEY_STR.indexOf(e.charAt(o++)) << 2 | (a = this.KEY_STR.indexOf(e.charAt(o++))) >> 4, i = (15 & a) << 4 | (r = this.KEY_STR.indexOf(e.charAt(o++))) >> 2, n = (3 & r) << 6 | (s = this.KEY_STR.indexOf(e.charAt(o++))), l.push(t), 64 !== r && l.push(i), 64 !== s && l.push(n), t = i = n = "", a = r = s = "", o < e.length;);
                        return l
                    }
                }]), e
            }();
        c.initClass();
        a._autoDiscoverFunction = function() {
                if (a.autoDiscover) return a.discover()
            },
            function(i, n) {
                var a = !1,
                    e = !0,
                    r = i.document,
                    s = r.documentElement,
                    t = r.addEventListener ? "addEventListener" : "attachEvent",
                    o = r.addEventListener ? "removeEventListener" : "detachEvent",
                    l = r.addEventListener ? "" : "on",
                    c = function e(t) {
                        if ("readystatechange" !== t.type || "complete" === r.readyState) return ("load" === t.type ? i : r)[o](l + t.type, e, !1), !a && (a = !0) ? n.call(i, t.type || t) : void 0
                    };
                if ("complete" !== r.readyState) {
                    if (r.createEventObject && s.doScroll) {
                        try {
                            e = !i.frameElement
                        } catch (e) {}
                        e && function t() {
                            try {
                                s.doScroll("left")
                            } catch (e) {
                                return void setTimeout(t, 50)
                            }
                            return c("poll")
                        }()
                    }
                    r[t](l + "DOMContentLoaded", c, !1), r[t](l + "readystatechange", c, !1), i[t](l + "load", c, !1)
                }
            }(window, a._autoDiscoverFunction)
    }).call(this, i(25)(e))
}, function(e, t) {
    e.exports = function(e) {
        return e.webpackPolyfill || (e.deprecate = function() {}, e.paths = [], e.children || (e.children = []), Object.defineProperty(e, "loaded", {
            enumerable: !0,
            get: function() {
                return e.l
            }
        }), Object.defineProperty(e, "id", {
            enumerable: !0,
            get: function() {
                return e.i
            }
        }), e.webpackPolyfill = 1), e
    }
}, function(e, t) {
    e.exports = function() {
        var e, t = (0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {}).element,
            i = void 0 === t ? ".ad-native" : t,
            s = document.querySelectorAll(i);

        function n(e) {
            if (e && e.data && !e.data.loaded) return !1;
            for (var t = window.innerWidth, i = 0, n = s.length; i < n; i++) {
                var a = s[i].querySelector("iframe"),
                    r = s[i].closest(".widget-cross") ? "cross" : s[i].closest(".widget-related") ? "related" : null;
                a && a.contentWindow.postMessage({
                    viewport: t,
                    layout: r
                }, "*")
            }
        }

        function a() {
            e || (e = setTimeout(function() {
                e = null, n()
            }, 66))
        }
        this.nativeAds = function() {
            if (!s.length) return !1;
            window.addEventListener("message", n, !1), window.addEventListener("resize", a, !1)
        }
    }
}]);