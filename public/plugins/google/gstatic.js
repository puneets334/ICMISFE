(function () {/*

 Copyright The Closure Library Authors.
 SPDX-License-Identifier: Apache-2.0
 */
    var a = "' of type ", l = "SCRIPT", aa = "Uneven number of arguments", p = "array", q = "function",
        ba = "google.charts.load", ca = "hasOwnProperty", r = "number", u = "object", v = "pre-45",
        da = "propertyIsEnumerable", w = "script", x = "string", ea = "text/javascript", fa = "toLocaleString";

    function z() {
        return function (b) {
            return b
        }
    }

    function A() {
        return function () {
        }
    }

    function C(b) {
        return function () {
            return this[b]
        }
    }

    function E(b) {
        return function () {
            return b
        }
    }

    var F, G = G || {};
    G.scope = {};
    G.Nk = function (b) {
        var c = 0;
        return function () {
            return c < b.length ? {done: !1, value: b[c++]} : {done: !0}
        }
    };
    G.Mk = function (b) {
        return {next: G.Nk(b)}
    };
    G.zd = function (b) {
        var c = "undefined" != typeof Symbol && Symbol.iterator && b[Symbol.iterator];
        return c ? c.call(b) : G.Mk(b)
    };
    G.Lk = function (b) {
        for (var c, d = []; !(c = b.next()).done;)d.push(c.value);
        return d
    };
    G.xg = function (b) {
        return b instanceof Array ? b : G.Lk(G.zd(b))
    };
    G.St = function (b, c, d) {
        b instanceof String && (b = String(b));
        for (var e = b.length, f = 0; f < e; f++) {
            var g = b[f];
            if (c.call(d, g, f, b))return {vm: f, Fo: g}
        }
        return {vm: -1, Fo: void 0}
    };
    G.tj = !1;
    G.Zo = !1;
    G.$o = !1;
    G.Er = !1;
    G.defineProperty = G.tj || typeof Object.defineProperties == q ? Object.defineProperty : function (b, c, d) {
        b != Array.prototype && b != Object.prototype && (b[c] = d.value)
    };
    G.$l = function (b) {
        return "undefined" != typeof window && window === b ? b : "undefined" != typeof global && null != global ? global : b
    };
    G.global = G.$l(this);
    G.Hi = function (b, c) {
        if (c) {
            var d = G.global;
            b = b.split(".");
            for (var e = 0; e < b.length - 1; e++) {
                var f = b[e];
                f in d || (d[f] = {});
                d = d[f]
            }
            b = b[b.length - 1];
            e = d[b];
            c = c(e);
            c != e && null != c && G.defineProperty(d, b, {configurable: !0, writable: !0, value: c})
        }
    };
    G.ml = function (b) {
        if (null == b)throw new TypeError("The 'this' value for String.prototype.repeat must not be null or undefined");
        return b + ""
    };
    G.Hi("String.prototype.repeat", function (b) {
        return b ? b : function (c) {
            var d = G.ml(this);
            if (0 > c || 1342177279 < c)throw new RangeError("Invalid count value");
            c |= 0;
            for (var e = ""; c;)if (c & 1 && (e += d), c >>>= 1) d += d;
            return e
        }
    });
    G.Uj = !1;
    G.Hi("Promise", function (b) {
        function c(k) {
            this.oa = g.Xa;
            this.Fa = void 0;
            this.ec = [];
            var m = this.we();
            try {
                k(m.resolve, m.reject)
            } catch (n) {
                m.reject(n)
            }
        }

        function d() {
            this.mb = null
        }

        function e(k) {
            return k instanceof c ? k : new c(function (m) {
                m(k)
            })
        }

        if (b && !G.Uj)return b;
        d.prototype.Ag = function (k) {
            if (null == this.mb) {
                this.mb = [];
                var m = this;
                this.Bg(function () {
                    m.Il()
                })
            }
            this.mb.push(k)
        };
        var f = G.global.setTimeout;
        d.prototype.Bg = function (k) {
            f(k, 0)
        };
        d.prototype.Il = function () {
            for (; this.mb && this.mb.length;) {
                var k = this.mb;
                this.mb =
                    [];
                for (var m = 0; m < k.length; ++m) {
                    var n = k[m];
                    k[m] = null;
                    try {
                        n()
                    } catch (t) {
                        this.Zk(t)
                    }
                }
            }
            this.mb = null
        };
        d.prototype.Zk = function (k) {
            this.Bg(function () {
                throw k;
            })
        };
        var g = {Xa: 0, kb: 1, Ga: 2};
        c.prototype.we = function () {
            function k(t) {
                return function (y) {
                    n || (n = !0, t.call(m, y))
                }
            }

            var m = this, n = !1;
            return {resolve: k(this.Hn), reject: k(this.lf)}
        };
        c.prototype.Hn = function (k) {
            if (k === this) this.lf(new TypeError("A Promise cannot resolve to itself")); else if (k instanceof c) this.co(k); else {
                a:switch (typeof k) {
                    case u:
                        var m = null != k;
                        break a;
                    case q:
                        m = !0;
                        break a;
                    default:
                        m = !1
                }
                m ? this.Gn(k) : this.hh(k)
            }
        };
        c.prototype.Gn = function (k) {
            var m = void 0;
            try {
                m = k.then
            } catch (n) {
                this.lf(n);
                return
            }
            typeof m == q ? this.eo(m, k) : this.hh(k)
        };
        c.prototype.lf = function (k) {
            this.Ui(g.Ga, k)
        };
        c.prototype.hh = function (k) {
            this.Ui(g.kb, k)
        };
        c.prototype.Ui = function (k, m) {
            if (this.oa != g.Xa)throw Error("Cannot settle(" + k + ", " + m + "): Promise already settled in state" + this.oa);
            this.oa = k;
            this.Fa = m;
            this.Kl()
        };
        c.prototype.Kl = function () {
            if (null != this.ec) {
                for (var k = 0; k < this.ec.length; ++k)h.Ag(this.ec[k]);
                this.ec = null
            }
        };
        var h = new d;
        c.prototype.co = function (k) {
            var m = this.we();
            k.$c(m.resolve, m.reject)
        };
        c.prototype.eo = function (k, m) {
            var n = this.we();
            try {
                k.call(m, n.resolve, n.reject)
            } catch (t) {
                n.reject(t)
            }
        };
        c.prototype.then = function (k, m) {
            function n(B, D) {
                return typeof B == q ? function (V) {
                    try {
                        t(B(V))
                    } catch (W) {
                        y(W)
                    }
                } : D
            }

            var t, y, X = new c(function (B, D) {
                t = B;
                y = D
            });
            this.$c(n(k, t), n(m, y));
            return X
        };
        c.prototype["catch"] = function (k) {
            return this.then(void 0, k)
        };
        c.prototype.$c = function (k, m) {
            function n() {
                switch (t.oa) {
                    case g.kb:
                        k(t.Fa);
                        break;
                    case g.Ga:
                        m(t.Fa);
                        break;
                    default:
                        throw Error("Unexpected state: " + t.oa);
                }
            }

            var t = this;
            null == this.ec ? h.Ag(n) : this.ec.push(n)
        };
        c.resolve = e;
        c.reject = function (k) {
            return new c(function (m, n) {
                n(k)
            })
        };
        c.race = function (k) {
            return new c(function (m, n) {
                for (var t = G.zd(k), y = t.next(); !y.done; y = t.next())e(y.value).$c(m, n)
            })
        };
        c.all = function (k) {
            var m = G.zd(k), n = m.next();
            return n.done ? e([]) : new c(function (t, y) {
                function X(V) {
                    return function (W) {
                        B[V] = W;
                        D--;
                        0 == D && t(B)
                    }
                }

                var B = [], D = 0;
                do B.push(void 0), D++, e(n.value).$c(X(B.length -
                    1), y), n = m.next(); while (!n.done)
            })
        };
        return c
    });
    var H = H || {};
    H.global = this || self;
    H.Zg = function (b, c, d) {
        b = b.split(".");
        d = d || H.global;
        b[0] in d || "undefined" == typeof d.execScript || d.execScript("var " + b[0]);
        for (var e; b.length && (e = b.shift());)b.length || void 0 === c ? d = d[e] && d[e] !== Object.prototype[e] ? d[e] : d[e] = {} : d[e] = c
    };
    H.define = function (b, c) {
        return c
    };
    H.Sj = 2012;
    H.la = !0;
    H.R = "en";
    H.je = !0;
    H.Ir = !1;
    H.Oj = !H.la;
    H.Qp = !1;
    H.bw = function (b) {
        if (H.di())throw Error("goog.provide cannot be used within a module.");
        H.Ng(b)
    };
    H.Ng = function (b, c) {
        H.Zg(b, c)
    };
    H.Jh = function () {
        null === H.xe && (H.xe = H.em());
        return H.xe
    };
    H.ek = /^[\w+/_-]+[=]{0,2}$/;
    H.xe = null;
    H.em = function () {
        var b = H.global.document;
        return (b = b.querySelector && b.querySelector("script[nonce]")) && (b = b.nonce || b.getAttribute("nonce")) && H.ek.test(b) ? b : ""
    };
    H.Dk = /^[a-zA-Z_$][a-zA-Z0-9._$]*$/;
    H.ff = function (b) {
        if (typeof b !== x || !b || -1 == b.search(H.Dk))throw Error("Invalid module identifier");
        if (!H.ci())throw Error("Module " + b + " has been loaded incorrectly. Note, modules cannot be loaded as normal scripts. They require some kind of pre-processing step. You're likely trying to load a module via a script tag or as a part of a concatenated bundle without rewriting the module. For more info see: https://github.com/google/closure-library/wiki/goog.module:-an-ES6-module-like-alternative-to-goog.provide.");
        if (H.Ba.Jc)throw Error("goog.module may only be called once per module.");
        H.Ba.Jc = b
    };
    H.ff.get = E(null);
    H.ff.su = E(null);
    H.oc = {Vf: "es6", de: "goog"};
    H.Ba = null;
    H.di = function () {
        return H.ci() || H.Dm()
    };
    H.ci = function () {
        return !!H.Ba && H.Ba.type == H.oc.de
    };
    H.Dm = function () {
        if (H.Ba && H.Ba.type == H.oc.Vf)return !0;
        var b = H.global.$jscomp;
        return b ? typeof b.Ge != q ? !1 : !!b.Ge() : !1
    };
    H.ff.ye = function () {
        H.Ba.ye = !0
    };
    H.Bt = function (b) {
        if (H.Ba) H.Ba.Jc = b; else {
            var c = H.global.$jscomp;
            if (!c || typeof c.Ge != q)throw Error('Module with namespace "' + b + '" has been loaded incorrectly.');
            c = c.En(c.Ge());
            H.vi[b] = {Ml: c, type: H.oc.Vf, ln: b}
        }
    };
    H.Vw = function (b) {
        if (H.Oj)throw b = b || "", Error("Importing test-only code into non-debug environment" + (b ? ": " + b : "."));
    };
    H.Yt = A();
    H.sb = function (b) {
        b = b.split(".");
        for (var c = H.global, d = 0; d < b.length; d++)if (c = c[b[d]], null == c)return null;
        return c
    };
    H.Iu = function (b, c) {
        c = c || H.global;
        for (var d in b)c[d] = b[d]
    };
    H.ss = A();
    H.xx = !1;
    H.Rp = !0;
    H.wi = function (b) {
        H.global.console && H.global.console.error(b)
    };
    H.En = A();
    H.mw = function () {
        return {}
    };
    H.al = "";
    H.Lb = A();
    H.qs = function () {
        throw Error("unimplemented abstract method");
    };
    H.ts = A();
    H.Uu = [];
    H.Nq = !0;
    H.sk = H.la;
    H.vi = {};
    H.Cp = !1;
    H.cs = "detect";
    H.Yo = !1;
    H.ds = "";
    H.yk = "transpile.js";
    H.Te = null;
    H.Do = function () {
        if (null == H.Te) {
            try {
                var b = !eval('"use strict";let x = 1; function f() { return typeof x; };f() == "number";')
            } catch (c) {
                b = !1
            }
            H.Te = b
        }
        return H.Te
    };
    H.Jo = function (b) {
        return "(function(){" + b + "\n;})();\n"
    };
    H.Gv = function (b) {
        var c = H.Ba;
        try {
            H.Ba = {Jc: "", ye: !1, type: H.oc.de};
            if (H.Sa(b))var d = b.call(void 0, {}); else if (typeof b === x) H.Do() && (b = H.Jo(b)), d = H.Ym.call(void 0, b); else throw Error("Invalid module definition");
            var e = H.Ba.Jc;
            if (typeof e === x && e) H.Ba.ye ? H.Ng(e, d) : H.sk && Object.seal && typeof d == u && null != d && Object.seal(d), H.vi[e] = {
                Ml: d,
                type: H.oc.de,
                ln: H.Ba.Jc
            }; else throw Error('Invalid module name "' + e + '"');
        } finally {
            H.Ba = c
        }
    };
    H.Ym = function (b) {
        eval(b);
        return {}
    };
    H.Rv = function (b) {
        b = b.split("/");
        for (var c = 0; c < b.length;)"." == b[c] ? b.splice(c, 1) : c && ".." == b[c] && b[c - 1] && ".." != b[c - 1] ? b.splice(--c, 2) : c++;
        return b.join("/")
    };
    H.Vm = function (b) {
        if (H.global.Hj)return H.global.Hj(b);
        try {
            var c = new H.global.XMLHttpRequest;
            c.open("get", b, !1);
            c.send();
            return 0 == c.status || 200 == c.status ? c.responseText : null
        } catch (d) {
            return null
        }
    };
    H.rx = function (b, c, d) {
        var e = H.global.$jscomp;
        e || (H.global.$jscomp = e = {});
        var f = e.Af;
        if (!f) {
            var g = H.al + H.yk, h = H.Vm(g);
            if (h) {
                (function () {
                    (0, eval)(h + "\n//# sourceURL=" + g)
                }).call(H.global);
                if (H.global.$gwtExport && H.global.$gwtExport.$jscomp && !H.global.$gwtExport.$jscomp.transpile)throw Error('The transpiler did not properly export the "transpile" method. $gwtExport: ' + JSON.stringify(H.global.$gwtExport));
                H.global.$jscomp.Af = H.global.$gwtExport.$jscomp.transpile;
                e = H.global.$jscomp;
                f = e.Af
            }
        }
        if (!f) {
            var k = " requires transpilation but no transpiler was found.";
            k += ' Please add "//javascript/closure:transpiler" as a data dependency to ensure it is included.';
            f = e.Af = function (m, n) {
                H.wi(n + k);
                return m
            }
        }
        return f(b, c, d)
    };
    H.pa = function (b) {
        var c = typeof b;
        if (c == u)if (b) {
            if (b instanceof Array)return p;
            if (b instanceof Object)return c;
            var d = Object.prototype.toString.call(b);
            if ("[object Window]" == d)return u;
            if ("[object Array]" == d || typeof b.length == r && "undefined" != typeof b.splice && "undefined" != typeof b.propertyIsEnumerable && !b.propertyIsEnumerable("splice"))return p;
            if ("[object Function]" == d || "undefined" != typeof b.call && "undefined" != typeof b.propertyIsEnumerable && !b.propertyIsEnumerable("call"))return q
        } else return "null";
        else if (c == q && "undefined" == typeof b.call)return u;
        return c
    };
    H.isArray = function (b) {
        return H.pa(b) == p
    };
    H.ka = function (b) {
        var c = H.pa(b);
        return c == p || c == u && typeof b.length == r
    };
    H.cv = function (b) {
        return H.Ea(b) && typeof b.getFullYear == q
    };
    H.Sa = function (b) {
        return H.pa(b) == q
    };
    H.Ea = function (b) {
        var c = typeof b;
        return c == u && null != b || c == q
    };
    H.Lh = function (b) {
        return b[H.Ab] || (b[H.Ab] = ++H.vo)
    };
    H.Nu = function (b) {
        return !!b[H.Ab]
    };
    H.Dn = function (b) {
        null !== b && "removeAttribute" in b && b.removeAttribute(H.Ab);
        try {
            delete b[H.Ab]
        } catch (c) {
        }
    };
    H.Ab = "closure_uid_" + (1E9 * Math.random() >>> 0);
    H.vo = 0;
    H.qu = H.Lh;
    H.hw = H.Dn;
    H.ol = function (b) {
        var c = H.pa(b);
        if (c == u || c == p) {
            if (typeof b.clone === q)return b.clone();
            c = c == p ? [] : {};
            for (var d in b)c[d] = H.ol(b[d]);
            return c
        }
        return b
    };
    H.cl = function (b, c, d) {
        return b.call.apply(b.bind, arguments)
    };
    H.bl = function (b, c, d) {
        if (!b)throw Error();
        if (2 < arguments.length) {
            var e = Array.prototype.slice.call(arguments, 2);
            return function () {
                var f = Array.prototype.slice.call(arguments);
                Array.prototype.unshift.apply(f, e);
                return b.apply(c, f)
            }
        }
        return function () {
            return b.apply(c, arguments)
        }
    };
    H.bind = function (b, c, d) {
        H.bind = Function.prototype.bind && -1 != Function.prototype.bind.toString().indexOf("native code") ? H.cl : H.bl;
        return H.bind.apply(null, arguments)
    };
    H.Mb = function (b, c) {
        var d = Array.prototype.slice.call(arguments, 1);
        return function () {
            var e = d.slice();
            e.push.apply(e, arguments);
            return b.apply(this, e)
        }
    };
    H.Mv = function (b, c) {
        for (var d in c)b[d] = c[d]
    };
    H.now = H.je && Date.now || function () {
            return +new Date
        };
    H.Hu = function (b) {
        if (H.global.execScript) H.global.execScript(b, "JavaScript"); else if (H.global.eval) {
            if (null == H.jd) {
                try {
                    H.global.eval("var _evalTest_ = 1;")
                } catch (e) {
                }
                if ("undefined" != typeof H.global._evalTest_) {
                    try {
                        delete H.global._evalTest_
                    } catch (e) {
                    }
                    H.jd = !0
                } else H.jd = !1
            }
            if (H.jd) H.global.eval(b); else {
                var c = H.global.document, d = c.createElement(w);
                d.type = ea;
                d.defer = !1;
                d.appendChild(c.createTextNode(b));
                c.head.appendChild(d);
                c.head.removeChild(d)
            }
        } else throw Error("goog.globalEval not available");
    };
    H.jd = null;
    H.nu = function (b, c) {
        function d(g) {
            g = g.split("-");
            for (var h = [], k = 0; k < g.length; k++)h.push(e(g[k]));
            return h.join("-")
        }

        function e(g) {
            return H.Sg[g] || g
        }

        if ("." == String(b).charAt(0))throw Error('className passed in goog.getCssName must not start with ".". You passed: ' + b);
        var f = H.Sg ? "BY_WHOLE" == H.vl ? e : d : z();
        b = c ? b + "-" + f(c) : f(b);
        return H.global.Gj ? H.global.Gj(b) : b
    };
    H.Cw = function (b, c) {
        H.Sg = b;
        H.vl = c
    };
    H.tu = function (b, c, d) {
        d && d.b && (b = b.replace(/</g, "&lt;"));
        c && (b = b.replace(/\{\$([^}]+)}/g, function (e, f) {
            return null != c && f in c ? c[f] : e
        }));
        return b
    };
    H.uu = z();
    H.Ac = function (b, c) {
        H.Zg(b, c, void 0)
    };
    H.Ot = function (b, c, d) {
        b[c] = d
    };
    H.ub = function (b, c) {
        function d() {
        }

        d.prototype = c.prototype;
        b.prototype = new d;
        b.prototype.constructor = b;
        b.Qs = function (e, f, g) {
            for (var h = Array(arguments.length - 2), k = 2; k < arguments.length; k++)h[k - 2] = arguments[k];
            return c.prototype[f].apply(e, h)
        }
    };
    H.scope = function (b) {
        if (H.di())throw Error("goog.scope is not supported within a module.");
        b.call(H.global)
    };
    H.Ia = function (b, c) {
        var d = c.constructor, e = c.ko;
        d && d != Object.prototype.constructor || (d = function () {
            throw Error("cannot instantiate an interface (no constructor defined).");
        });
        d = H.Ia.rl(d, b);
        b && H.ub(d, b);
        delete c.constructor;
        delete c.ko;
        H.Ia.wg(d.prototype, c);
        null != e && (e instanceof Function ? e(d) : H.Ia.wg(d, e));
        return d
    };
    H.Ia.rk = H.la;
    H.Ia.rl = function (b, c) {
        function d() {
            var f = b.apply(this, arguments) || this;
            f[H.Ab] = f[H.Ab];
            this.constructor === d && e && Object.seal instanceof Function && Object.seal(f);
            return f
        }

        if (!H.Ia.rk)return b;
        var e = !H.Ia.Om(c);
        return d
    };
    H.Ia.Om = function (b) {
        return b && b.prototype && b.prototype[H.Ak]
    };
    H.Ia.fg = ["constructor", ca, "isPrototypeOf", da, fa, "toString", "valueOf"];
    H.Ia.wg = function (b, c) {
        for (var d in c)Object.prototype.hasOwnProperty.call(c, d) && (b[d] = c[d]);
        for (var e = 0; e < H.Ia.fg.length; e++)d = H.Ia.fg[e], Object.prototype.hasOwnProperty.call(c, d) && (b[d] = c[d])
    };
    H.kx = A();
    H.Ak = "goog_defineClass_legacy_unsealable";
    H.Xc = "";
    H.wd = z();
    H.Rg = function (b) {
        var c = null, d = H.global.trustedTypes || H.global.TrustedTypes;
        if (!d || !d.createPolicy)return c;
        try {
            c = d.createPolicy(b, {createHTML: H.wd, createScript: H.wd, createScriptURL: H.wd, createURL: H.wd})
        } catch (e) {
            H.wi(e.message)
        }
        return c
    };
    H.fs = H.Xc ? H.Rg(H.Xc + "#base") : null;
    H.debug = {};
    H.debug.Error = function (b) {
        if (Error.captureStackTrace) Error.captureStackTrace(this, H.debug.Error); else {
            var c = Error().stack;
            c && (this.stack = c)
        }
        b && (this.message = String(b))
    };
    H.ub(H.debug.Error, Error);
    H.debug.Error.prototype.name = "CustomError";
    H.a = {};
    H.a.ra = {jb: 1, ap: 2, Wc: 3, qp: 4, Tp: 5, Sp: 6, qr: 7, xp: 8, Qc: 9, Kp: 10, Pj: 11, ar: 12};
    H.m = {};
    H.m.wa = H.la;
    H.m.kc = function (b, c) {
        H.debug.Error.call(this, H.m.mo(b, c))
    };
    H.ub(H.m.kc, H.debug.Error);
    H.m.kc.prototype.name = "AssertionError";
    H.m.Lj = function (b) {
        throw b;
    };
    H.m.ze = H.m.Lj;
    H.m.mo = function (b, c) {
        b = b.split("%s");
        for (var d = "", e = b.length - 1, f = 0; f < e; f++)d += b[f] + (f < c.length ? c[f] : "%s");
        return d + b[e]
    };
    H.m.Pa = function (b, c, d, e) {
        var f = "Assertion failed";
        if (d) {
            f += ": " + d;
            var g = e
        } else b && (f += ": " + b, g = c);
        b = new H.m.kc("" + f, g || []);
        H.m.ze(b)
    };
    H.m.Gw = function (b) {
        H.m.wa && (H.m.ze = b)
    };
    H.m.assert = function (b, c, d) {
        H.m.wa && !b && H.m.Pa("", null, c, Array.prototype.slice.call(arguments, 2));
        return b
    };
    H.m.Ds = function (b, c, d) {
        H.m.wa && null == b && H.m.Pa("Expected to exist: %s.", [b], c, Array.prototype.slice.call(arguments, 2));
        return b
    };
    H.m.ua = function (b, c) {
        H.m.wa && H.m.ze(new H.m.kc("Failure" + (b ? ": " + b : ""), Array.prototype.slice.call(arguments, 1)))
    };
    H.m.Ls = function (b, c, d) {
        H.m.wa && typeof b !== r && H.m.Pa("Expected number but got %s: %s.", [H.pa(b), b], c, Array.prototype.slice.call(arguments, 2));
        return b
    };
    H.m.Os = function (b, c, d) {
        H.m.wa && typeof b !== x && H.m.Pa("Expected string but got %s: %s.", [H.pa(b), b], c, Array.prototype.slice.call(arguments, 2));
        return b
    };
    H.m.Fs = function (b, c, d) {
        H.m.wa && !H.Sa(b) && H.m.Pa("Expected function but got %s: %s.", [H.pa(b), b], c, Array.prototype.slice.call(arguments, 2));
        return b
    };
    H.m.Ms = function (b, c, d) {
        H.m.wa && !H.Ea(b) && H.m.Pa("Expected object but got %s: %s.", [H.pa(b), b], c, Array.prototype.slice.call(arguments, 2));
        return b
    };
    H.m.As = function (b, c, d) {
        H.m.wa && !H.isArray(b) && H.m.Pa("Expected array but got %s: %s.", [H.pa(b), b], c, Array.prototype.slice.call(arguments, 2));
        return b
    };
    H.m.Bs = function (b, c, d) {
        H.m.wa && "boolean" !== typeof b && H.m.Pa("Expected boolean but got %s: %s.", [H.pa(b), b], c, Array.prototype.slice.call(arguments, 2));
        return b
    };
    H.m.Cs = function (b, c, d) {
        !H.m.wa || H.Ea(b) && b.nodeType == H.a.ra.jb || H.m.Pa("Expected Element but got %s: %s.", [H.pa(b), b], c, Array.prototype.slice.call(arguments, 2));
        return b
    };
    H.m.Gs = function (b, c, d, e) {
        !H.m.wa || b instanceof c || H.m.Pa("Expected instanceof %s but got %s.", [H.m.Kh(c), H.m.Kh(b)], d, Array.prototype.slice.call(arguments, 3));
        return b
    };
    H.m.Es = function (b, c, d) {
        !H.m.wa || typeof b == r && isFinite(b) || H.m.Pa("Expected %s to be a finite number but it is not.", [b], c, Array.prototype.slice.call(arguments, 2));
        return b
    };
    H.m.Ns = function () {
        for (var b in Object.prototype)H.m.ua(b + " should not be enumerable in Object.prototype.")
    };
    H.m.Kh = function (b) {
        return b instanceof Function ? b.displayName || b.name || "unknown type name" : b instanceof Object ? b.constructor.displayName || b.constructor.name || Object.prototype.toString.call(b) : null === b ? "null" : typeof b
    };
    H.g = {};
    H.ab = H.je;
    H.g.Za = 2012 < H.Sj;
    H.g.qn = function (b) {
        return b[b.length - 1]
    };
    H.g.Cv = H.g.qn;
    H.g.indexOf = H.ab && (H.g.Za || Array.prototype.indexOf) ? function (b, c, d) {
        return Array.prototype.indexOf.call(b, c, d)
    } : function (b, c, d) {
        d = null == d ? 0 : 0 > d ? Math.max(0, b.length + d) : d;
        if (typeof b === x)return typeof c !== x || 1 != c.length ? -1 : b.indexOf(c, d);
        for (; d < b.length; d++)if (d in b && b[d] === c)return d;
        return -1
    };
    H.g.lastIndexOf = H.ab && (H.g.Za || Array.prototype.lastIndexOf) ? function (b, c, d) {
        return Array.prototype.lastIndexOf.call(b, c, null == d ? b.length - 1 : d)
    } : function (b, c, d) {
        d = null == d ? b.length - 1 : d;
        0 > d && (d = Math.max(0, b.length + d));
        if (typeof b === x)return typeof c !== x || 1 != c.length ? -1 : b.lastIndexOf(c, d);
        for (; 0 <= d; d--)if (d in b && b[d] === c)return d;
        return -1
    };
    H.g.forEach = H.ab && (H.g.Za || Array.prototype.forEach) ? function (b, c, d) {
        Array.prototype.forEach.call(b, c, d)
    } : function (b, c, d) {
        for (var e = b.length, f = typeof b === x ? b.split("") : b, g = 0; g < e; g++)g in f && c.call(d, f[g], g, b)
    };
    H.g.gh = function (b, c) {
        var d = b.length, e = typeof b === x ? b.split("") : b;
        for (--d; 0 <= d; --d)d in e && c.call(void 0, e[d], d, b)
    };
    H.g.filter = H.ab && (H.g.Za || Array.prototype.filter) ? function (b, c, d) {
        return Array.prototype.filter.call(b, c, d)
    } : function (b, c, d) {
        for (var e = b.length, f = [], g = 0, h = typeof b === x ? b.split("") : b, k = 0; k < e; k++)if (k in h) {
            var m = h[k];
            c.call(d, m, k, b) && (f[g++] = m)
        }
        return f
    };
    H.g.map = H.ab && (H.g.Za || Array.prototype.map) ? function (b, c, d) {
        return Array.prototype.map.call(b, c, d)
    } : function (b, c, d) {
        for (var e = b.length, f = Array(e), g = typeof b === x ? b.split("") : b, h = 0; h < e; h++)h in g && (f[h] = c.call(d, g[h], h, b));
        return f
    };
    H.g.reduce = H.ab && (H.g.Za || Array.prototype.reduce) ? function (b, c, d, e) {
        e && (c = H.bind(c, e));
        return Array.prototype.reduce.call(b, c, d)
    } : function (b, c, d, e) {
        var f = d;
        H.g.forEach(b, function (g, h) {
            f = c.call(e, f, g, h, b)
        });
        return f
    };
    H.g.reduceRight = H.ab && (H.g.Za || Array.prototype.reduceRight) ? function (b, c, d, e) {
        e && (c = H.bind(c, e));
        return Array.prototype.reduceRight.call(b, c, d)
    } : function (b, c, d, e) {
        var f = d;
        H.g.gh(b, function (g, h) {
            f = c.call(e, f, g, h, b)
        });
        return f
    };
    H.g.some = H.ab && (H.g.Za || Array.prototype.some) ? function (b, c, d) {
        return Array.prototype.some.call(b, c, d)
    } : function (b, c, d) {
        for (var e = b.length, f = typeof b === x ? b.split("") : b, g = 0; g < e; g++)if (g in f && c.call(d, f[g], g, b))return !0;
        return !1
    };
    H.g.every = H.ab && (H.g.Za || Array.prototype.every) ? function (b, c, d) {
        return Array.prototype.every.call(b, c, d)
    } : function (b, c, d) {
        for (var e = b.length, f = typeof b === x ? b.split("") : b, g = 0; g < e; g++)if (g in f && !c.call(d, f[g], g, b))return !1;
        return !0
    };
    H.g.count = function (b, c, d) {
        var e = 0;
        H.g.forEach(b, function (f, g, h) {
            c.call(d, f, g, h) && ++e
        }, d);
        return e
    };
    H.g.find = function (b, c, d) {
        c = H.g.findIndex(b, c, d);
        return 0 > c ? null : typeof b === x ? b.charAt(c) : b[c]
    };
    H.g.findIndex = function (b, c, d) {
        for (var e = b.length, f = typeof b === x ? b.split("") : b, g = 0; g < e; g++)if (g in f && c.call(d, f[g], g, b))return g;
        return -1
    };
    H.g.Tt = function (b, c, d) {
        c = H.g.Nl(b, c, d);
        return 0 > c ? null : typeof b === x ? b.charAt(c) : b[c]
    };
    H.g.Nl = function (b, c, d) {
        var e = b.length, f = typeof b === x ? b.split("") : b;
        for (--e; 0 <= e; e--)if (e in f && c.call(d, f[e], e, b))return e;
        return -1
    };
    H.g.contains = function (b, c) {
        return 0 <= H.g.indexOf(b, c)
    };
    H.g.za = function (b) {
        return 0 == b.length
    };
    H.g.clear = function (b) {
        if (!H.isArray(b))for (var c = b.length - 1; 0 <= c; c--)delete b[c];
        b.length = 0
    };
    H.g.Ru = function (b, c) {
        H.g.contains(b, c) || b.push(c)
    };
    H.g.Th = function (b, c, d) {
        H.g.splice(b, d, 0, c)
    };
    H.g.Tu = function (b, c, d) {
        H.Mb(H.g.splice, b, d, 0).apply(null, c)
    };
    H.g.insertBefore = function (b, c, d) {
        var e;
        2 == arguments.length || 0 > (e = H.g.indexOf(b, d)) ? b.push(c) : H.g.Th(b, c, e)
    };
    H.g.remove = function (b, c) {
        c = H.g.indexOf(b, c);
        var d;
        (d = 0 <= c) && H.g.gc(b, c);
        return d
    };
    H.g.jw = function (b, c) {
        c = H.g.lastIndexOf(b, c);
        return 0 <= c ? (H.g.gc(b, c), !0) : !1
    };
    H.g.gc = function (b, c) {
        return 1 == Array.prototype.splice.call(b, c, 1).length
    };
    H.g.iw = function (b, c, d) {
        c = H.g.findIndex(b, c, d);
        return 0 <= c ? (H.g.gc(b, c), !0) : !1
    };
    H.g.gw = function (b, c, d) {
        var e = 0;
        H.g.gh(b, function (f, g) {
            c.call(d, f, g, b) && H.g.gc(b, g) && e++
        });
        return e
    };
    H.g.concat = function (b) {
        return Array.prototype.concat.apply([], arguments)
    };
    H.g.join = function (b) {
        return Array.prototype.concat.apply([], arguments)
    };
    H.g.gb = function (b) {
        var c = b.length;
        if (0 < c) {
            for (var d = Array(c), e = 0; e < c; e++)d[e] = b[e];
            return d
        }
        return []
    };
    H.g.clone = H.g.gb;
    H.g.extend = function (b, c) {
        for (var d = 1; d < arguments.length; d++) {
            var e = arguments[d];
            if (H.ka(e)) {
                var f = b.length || 0, g = e.length || 0;
                b.length = f + g;
                for (var h = 0; h < g; h++)b[f + h] = e[h]
            } else b.push(e)
        }
    };
    H.g.splice = function (b, c, d, e) {
        return Array.prototype.splice.apply(b, H.g.slice(arguments, 1))
    };
    H.g.slice = function (b, c, d) {
        return 2 >= arguments.length ? Array.prototype.slice.call(b, c) : Array.prototype.slice.call(b, c, d)
    };
    H.g.An = function (b, c) {
        c = c || b;
        for (var d = {}, e = 0, f = 0; f < b.length;) {
            var g = b[f++];
            var h = g;
            h = H.Ea(h) ? "o" + H.Lh(h) : (typeof h).charAt(0) + h;
            Object.prototype.hasOwnProperty.call(d, h) || (d[h] = !0, c[e++] = g)
        }
        c.length = e
    };
    H.g.Cg = function (b, c, d) {
        return H.g.Dg(b, d || H.g.ob, !1, c)
    };
    H.g.Ts = function (b, c, d) {
        return H.g.Dg(b, c, !0, void 0, d)
    };
    H.g.Dg = function (b, c, d, e, f) {
        for (var g = 0, h = b.length, k; g < h;) {
            var m = g + (h - g >>> 1);
            var n = d ? c.call(f, b[m], m, b) : c(e, b[m]);
            0 < n ? g = m + 1 : (h = m, k = !n)
        }
        return k ? g : -g - 1
    };
    H.g.sort = function (b, c) {
        b.sort(c || H.g.ob)
    };
    H.g.dx = function (b, c) {
        for (var d = Array(b.length), e = 0; e < b.length; e++)d[e] = {index: e, value: b[e]};
        var f = c || H.g.ob;
        H.g.sort(d, function (g, h) {
            return f(g.value, h.value) || g.index - h.index
        });
        for (e = 0; e < b.length; e++)b[e] = d[e].value
    };
    H.g.ho = function (b, c, d) {
        var e = d || H.g.ob;
        H.g.sort(b, function (f, g) {
            return e(c(f), c(g))
        })
    };
    H.g.ax = function (b, c, d) {
        H.g.ho(b, function (e) {
            return e[c]
        }, d)
    };
    H.g.mi = function (b) {
        for (var c = H.g.ob, d = 1; d < b.length; d++)if (0 < c(b[d - 1], b[d]))return !1;
        return !0
    };
    H.g.Ib = function (b, c) {
        if (!H.ka(b) || !H.ka(c) || b.length != c.length)return !1;
        for (var d = b.length, e = H.g.Vg, f = 0; f < d; f++)if (!e(b[f], c[f]))return !1;
        return !0
    };
    H.g.ft = function (b, c, d) {
        d = d || H.g.ob;
        for (var e = Math.min(b.length, c.length), f = 0; f < e; f++) {
            var g = d(b[f], c[f]);
            if (0 != g)return g
        }
        return H.g.ob(b.length, c.length)
    };
    H.g.ob = function (b, c) {
        return b > c ? 1 : b < c ? -1 : 0
    };
    H.g.Wu = function (b, c) {
        return -H.g.ob(b, c)
    };
    H.g.Vg = function (b, c) {
        return b === c
    };
    H.g.Rs = function (b, c, d) {
        d = H.g.Cg(b, c, d);
        return 0 > d ? (H.g.Th(b, c, -(d + 1)), !0) : !1
    };
    H.g.Ss = function (b, c, d) {
        c = H.g.Cg(b, c, d);
        return 0 <= c ? H.g.gc(b, c) : !1
    };
    H.g.Vs = function (b, c, d) {
        for (var e = {}, f = 0; f < b.length; f++) {
            var g = b[f], h = c.call(d, g, f, b);
            void 0 !== h && (e[h] || (e[h] = [])).push(g)
        }
        return e
    };
    H.g.ro = function (b, c, d) {
        var e = {};
        H.g.forEach(b, function (f, g) {
            e[c.call(d, f, g, b)] = f
        });
        return e
    };
    H.g.Kd = function (b, c, d) {
        var e = [], f = 0, g = b;
        d = d || 1;
        void 0 !== c && (f = b, g = c);
        if (0 > d * (g - f))return [];
        if (0 < d)for (b = f; b < g; b += d)e.push(b); else for (b = f; b > g; b += d)e.push(b);
        return e
    };
    H.g.repeat = function (b, c) {
        for (var d = [], e = 0; e < c; e++)d[e] = b;
        return d
    };
    H.g.flatten = function (b) {
        for (var c = [], d = 0; d < arguments.length; d++) {
            var e = arguments[d];
            if (H.isArray(e))for (var f = 0; f < e.length; f += 8192) {
                var g = H.g.slice(e, f, f + 8192);
                g = H.g.flatten.apply(null, g);
                for (var h = 0; h < g.length; h++)c.push(g[h])
            } else c.push(e)
        }
        return c
    };
    H.g.rotate = function (b, c) {
        b.length && (c %= b.length, 0 < c ? Array.prototype.unshift.apply(b, b.splice(-c, c)) : 0 > c && Array.prototype.push.apply(b, b.splice(0, -c)));
        return b
    };
    H.g.Ov = function (b, c, d) {
        c = Array.prototype.splice.call(b, c, 1);
        Array.prototype.splice.call(b, d, 0, c[0])
    };
    H.g.mj = function (b) {
        if (!arguments.length)return [];
        for (var c = [], d = arguments[0].length, e = 1; e < arguments.length; e++)arguments[e].length < d && (d = arguments[e].length);
        for (e = 0; e < d; e++) {
            for (var f = [], g = 0; g < arguments.length; g++)f.push(arguments[g][e]);
            c.push(f)
        }
        return c
    };
    H.g.$w = function (b, c) {
        c = c || Math.random;
        for (var d = b.length - 1; 0 < d; d--) {
            var e = Math.floor(c() * (d + 1)), f = b[d];
            b[d] = b[e];
            b[e] = f
        }
    };
    H.g.lt = function (b, c) {
        var d = [];
        H.g.forEach(c, function (e) {
            d.push(b[e])
        });
        return d
    };
    H.g.it = function (b, c, d) {
        return H.g.concat.apply([], H.g.map(b, c, d))
    };
    H.async = {};
    H.async.Sc = function (b, c, d) {
        this.Um = d;
        this.ul = b;
        this.Fn = c;
        this.Bd = 0;
        this.vd = null
    };
    H.async.Sc.prototype.get = function () {
        if (0 < this.Bd) {
            this.Bd--;
            var b = this.vd;
            this.vd = b.next;
            b.next = null
        } else b = this.ul();
        return b
    };
    H.async.Sc.prototype.put = function (b) {
        this.Fn(b);
        this.Bd < this.Um && (this.Bd++, b.next = this.vd, this.vd = b)
    };
    H.debug.na = {};
    H.debug.Up = A();
    H.debug.na.fc = [];
    H.debug.na.gf = [];
    H.debug.na.Ei = !1;
    H.debug.na.register = function (b) {
        H.debug.na.fc[H.debug.na.fc.length] = b;
        if (H.debug.na.Ei)for (var c = H.debug.na.gf, d = 0; d < c.length; d++)b(H.bind(c[d].Ko, c[d]))
    };
    H.debug.na.Nv = function (b) {
        H.debug.na.Ei = !0;
        for (var c = H.bind(b.Ko, b), d = 0; d < H.debug.na.fc.length; d++)H.debug.na.fc[d](c);
        H.debug.na.gf.push(b)
    };
    H.debug.na.wx = function (b) {
        var c = H.debug.na.gf;
        b = H.bind(b.F, b);
        for (var d = 0; d < H.debug.na.fc.length; d++)H.debug.na.fc[d](b);
        c.length--
    };
    H.c = {};
    H.c.A = {};
    H.c.A.startsWith = function (b, c) {
        return 0 == b.lastIndexOf(c, 0)
    };
    H.c.A.endsWith = function (b, c) {
        var d = b.length - c.length;
        return 0 <= d && b.indexOf(c, d) == d
    };
    H.c.A.Cb = function (b, c) {
        return 0 == H.c.A.ad(c, b.substr(0, c.length))
    };
    H.c.A.Gg = function (b, c) {
        return 0 == H.c.A.ad(c, b.substr(b.length - c.length, c.length))
    };
    H.c.A.Hg = function (b, c) {
        return b.toLowerCase() == c.toLowerCase()
    };
    H.c.A.Ic = function (b) {
        return /^[\s\xa0]*$/.test(b)
    };
    H.c.A.trim = H.je && String.prototype.trim ? function (b) {
        return b.trim()
    } : function (b) {
        return /^[\s\xa0]*([\s\S]*?)[\s\xa0]*$/.exec(b)[1]
    };
    H.c.A.ad = function (b, c) {
        b = String(b).toLowerCase();
        c = String(c).toLowerCase();
        return b < c ? -1 : b == c ? 0 : 1
    };
    H.c.A.Kc = function (b, c) {
        return b.replace(/(\r\n|\r|\n)/g, c ? "<br />" : "<br>")
    };
    H.c.A.Da = function (b, c) {
        if (c) b = b.replace(H.c.A.Ef, "&amp;").replace(H.c.A.cg, "&lt;").replace(H.c.A.$f, "&gt;").replace(H.c.A.jg, "&quot;").replace(H.c.A.lg, "&#39;").replace(H.c.A.eg, "&#0;"); else {
            if (!H.c.A.rj.test(b))return b;
            -1 != b.indexOf("&") && (b = b.replace(H.c.A.Ef, "&amp;"));
            -1 != b.indexOf("<") && (b = b.replace(H.c.A.cg, "&lt;"));
            -1 != b.indexOf(">") && (b = b.replace(H.c.A.$f, "&gt;"));
            -1 != b.indexOf('"') && (b = b.replace(H.c.A.jg, "&quot;"));
            -1 != b.indexOf("'") && (b = b.replace(H.c.A.lg, "&#39;"));
            -1 != b.indexOf("\x00") &&
            (b = b.replace(H.c.A.eg, "&#0;"))
        }
        return b
    };
    H.c.A.Ef = /&/g;
    H.c.A.cg = /</g;
    H.c.A.$f = />/g;
    H.c.A.jg = /"/g;
    H.c.A.lg = /'/g;
    H.c.A.eg = /\x00/g;
    H.c.A.rj = /[\x00&<>"']/;
    H.c.A.kj = function (b) {
        return H.c.A.Kc(b.replace(/  /g, " &#160;"), void 0)
    };
    H.c.A.contains = function (b, c) {
        return -1 != b.indexOf(c)
    };
    H.c.A.bd = function (b, c) {
        return H.c.A.contains(b.toLowerCase(), c.toLowerCase())
    };
    H.c.A.Eb = function (b, c) {
        var d = 0;
        b = H.c.A.trim(String(b)).split(".");
        c = H.c.A.trim(String(c)).split(".");
        for (var e = Math.max(b.length, c.length), f = 0; 0 == d && f < e; f++) {
            var g = b[f] || "", h = c[f] || "";
            do {
                g = /(\d*)(\D*)(.*)/.exec(g) || ["", "", "", ""];
                h = /(\d*)(\D*)(.*)/.exec(h) || ["", "", "", ""];
                if (0 == g[0].length && 0 == h[0].length)break;
                d = H.c.A.te(0 == g[1].length ? 0 : parseInt(g[1], 10), 0 == h[1].length ? 0 : parseInt(h[1], 10)) || H.c.A.te(0 == g[2].length, 0 == h[2].length) || H.c.A.te(g[2], h[2]);
                g = g[3];
                h = h[3]
            } while (0 == d)
        }
        return d
    };
    H.c.A.te = function (b, c) {
        return b < c ? -1 : b > c ? 1 : 0
    };
    H.h = {};
    H.h.userAgent = {};
    H.h.userAgent.G = {};
    H.h.userAgent.G.wh = function () {
        var b = H.h.userAgent.G.bm();
        return b && (b = b.userAgent) ? b : ""
    };
    H.h.userAgent.G.bm = function () {
        return H.global.navigator
    };
    H.h.userAgent.G.ij = H.h.userAgent.G.wh();
    H.h.userAgent.G.Xw = function (b) {
        H.h.userAgent.G.ij = b || H.h.userAgent.G.wh()
    };
    H.h.userAgent.G.Zb = function () {
        return H.h.userAgent.G.ij
    };
    H.h.userAgent.G.S = function (b) {
        return H.c.A.contains(H.h.userAgent.G.Zb(), b)
    };
    H.h.userAgent.G.ef = function (b) {
        return H.c.A.bd(H.h.userAgent.G.Zb(), b)
    };
    H.h.userAgent.G.$g = function (b) {
        for (var c = /(\w[\w ]+)\/([^\s]+)\s*(?:\((.*?)\))?/g, d = [], e; e = c.exec(b);)d.push([e[1], e[2], e[3] || void 0]);
        return d
    };
    H.object = {};
    H.object.is = function (b, c) {
        return b === c ? 0 !== b || 1 / b === 1 / c : b !== b && c !== c
    };
    H.object.forEach = function (b, c, d) {
        for (var e in b)c.call(d, b[e], e, b)
    };
    H.object.filter = function (b, c, d) {
        var e = {}, f;
        for (f in b)c.call(d, b[f], f, b) && (e[f] = b[f]);
        return e
    };
    H.object.map = function (b, c, d) {
        var e = {}, f;
        for (f in b)e[f] = c.call(d, b[f], f, b);
        return e
    };
    H.object.some = function (b, c, d) {
        for (var e in b)if (c.call(d, b[e], e, b))return !0;
        return !1
    };
    H.object.every = function (b, c, d) {
        for (var e in b)if (!c.call(d, b[e], e, b))return !1;
        return !0
    };
    H.object.qb = function (b) {
        var c = 0, d;
        for (d in b)c++;
        return c
    };
    H.object.lu = function (b) {
        for (var c in b)return c
    };
    H.object.mu = function (b) {
        for (var c in b)return b[c]
    };
    H.object.contains = function (b, c) {
        return H.object.Gb(b, c)
    };
    H.object.ea = function (b) {
        var c = [], d = 0, e;
        for (e in b)c[d++] = b[e];
        return c
    };
    H.object.ja = function (b) {
        var c = [], d = 0, e;
        for (e in b)c[d++] = e;
        return c
    };
    H.object.Gu = function (b, c) {
        var d = H.ka(c), e = d ? c : arguments;
        for (d = d ? 0 : 1; d < e.length; d++) {
            if (null == b)return;
            b = b[e[d]]
        }
        return b
    };
    H.object.Fb = function (b, c) {
        return null !== b && c in b
    };
    H.object.Gb = function (b, c) {
        for (var d in b)if (b[d] == c)return !0;
        return !1
    };
    H.object.Ol = function (b, c, d) {
        for (var e in b)if (c.call(d, b[e], e, b))return e
    };
    H.object.Ut = function (b, c, d) {
        return (c = H.object.Ol(b, c, d)) && b[c]
    };
    H.object.za = function (b) {
        for (var c in b)return !1;
        return !0
    };
    H.object.clear = function (b) {
        for (var c in b)delete b[c]
    };
    H.object.remove = function (b, c) {
        var d;
        (d = c in b) && delete b[c];
        return d
    };
    H.object.add = function (b, c, d) {
        if (null !== b && c in b)throw Error('The object already contains the key "' + c + '"');
        H.object.set(b, c, d)
    };
    H.object.get = function (b, c, d) {
        return null !== b && c in b ? b[c] : d
    };
    H.object.set = function (b, c, d) {
        b[c] = d
    };
    H.object.Kw = function (b, c, d) {
        return c in b ? b[c] : b[c] = d
    };
    H.object.Zw = function (b, c, d) {
        if (c in b)return b[c];
        d = d();
        return b[c] = d
    };
    H.object.Ib = function (b, c) {
        for (var d in b)if (!(d in c) || b[d] !== c[d])return !1;
        for (var e in c)if (!(e in b))return !1;
        return !0
    };
    H.object.clone = function (b) {
        var c = {}, d;
        for (d in b)c[d] = b[d];
        return c
    };
    H.object.Ao = function (b) {
        var c = H.pa(b);
        if (c == u || c == p) {
            if (H.Sa(b.clone))return b.clone();
            c = c == p ? [] : {};
            for (var d in b)c[d] = H.object.Ao(b[d]);
            return c
        }
        return b
    };
    H.object.to = function (b) {
        var c = {}, d;
        for (d in b)c[b[d]] = d;
        return c
    };
    H.object.ig = ["constructor", ca, "isPrototypeOf", da, fa, "toString", "valueOf"];
    H.object.extend = function (b, c) {
        for (var d, e, f = 1; f < arguments.length; f++) {
            e = arguments[f];
            for (d in e)b[d] = e[d];
            for (var g = 0; g < H.object.ig.length; g++)d = H.object.ig[g], Object.prototype.hasOwnProperty.call(e, d) && (b[d] = e[d])
        }
    };
    H.object.create = function (b) {
        var c = arguments.length;
        if (1 == c && H.isArray(arguments[0]))return H.object.create.apply(null, arguments[0]);
        if (c % 2)throw Error(aa);
        for (var d = {}, e = 0; e < c; e += 2)d[arguments[e]] = arguments[e + 1];
        return d
    };
    H.object.sl = function (b) {
        var c = arguments.length;
        if (1 == c && H.isArray(arguments[0]))return H.object.sl.apply(null, arguments[0]);
        for (var d = {}, e = 0; e < c; e++)d[arguments[e]] = !0;
        return d
    };
    H.object.rt = function (b) {
        var c = b;
        Object.isFrozen && !Object.isFrozen(b) && (c = Object.create(b), Object.freeze(c));
        return c
    };
    H.object.hv = function (b) {
        return !!Object.isFrozen && Object.isFrozen(b)
    };
    H.object.ku = function (b, c, d) {
        if (!b)return [];
        if (!Object.getOwnPropertyNames || !Object.getPrototypeOf)return H.object.ja(b);
        for (var e = {}; b && (b !== Object.prototype || c) && (b !== Function.prototype || d);) {
            for (var f = Object.getOwnPropertyNames(b), g = 0; g < f.length; g++)e[f[g]] = !0;
            b = Object.getPrototypeOf(b)
        }
        return H.object.ja(e)
    };
    H.object.Fu = function (b) {
        return (b = Object.getPrototypeOf(b.prototype)) && b.constructor
    };
    H.h.userAgent.B = {};
    H.h.userAgent.B.Ai = function () {
        return H.h.userAgent.G.S("Opera")
    };
    H.h.userAgent.B.jn = function () {
        return H.h.userAgent.G.S("Trident") || H.h.userAgent.G.S("MSIE")
    };
    H.h.userAgent.B.cf = function () {
        return H.h.userAgent.G.S("Edge")
    };
    H.h.userAgent.B.yi = function () {
        return H.h.userAgent.G.S("Edg/")
    };
    H.h.userAgent.B.zi = function () {
        return H.h.userAgent.G.S("OPR")
    };
    H.h.userAgent.B.df = function () {
        return H.h.userAgent.G.S("Firefox") || H.h.userAgent.G.S("FxiOS")
    };
    H.h.userAgent.B.Bi = function () {
        return H.h.userAgent.G.S("Safari") && !(H.h.userAgent.B.af() || H.h.userAgent.B.bf() || H.h.userAgent.B.Ai() || H.h.userAgent.B.cf() || H.h.userAgent.B.yi() || H.h.userAgent.B.zi() || H.h.userAgent.B.df() || H.h.userAgent.B.li() || H.h.userAgent.G.S("Android"))
    };
    H.h.userAgent.B.bf = function () {
        return H.h.userAgent.G.S("Coast")
    };
    H.h.userAgent.B.kn = function () {
        return (H.h.userAgent.G.S("iPad") || H.h.userAgent.G.S("iPhone")) && !H.h.userAgent.B.Bi() && !H.h.userAgent.B.af() && !H.h.userAgent.B.bf() && !H.h.userAgent.B.df() && H.h.userAgent.G.S("AppleWebKit")
    };
    H.h.userAgent.B.af = function () {
        return (H.h.userAgent.G.S("Chrome") || H.h.userAgent.G.S("CriOS")) && !H.h.userAgent.B.cf()
    };
    H.h.userAgent.B.hn = function () {
        return H.h.userAgent.G.S("Android") && !(H.h.userAgent.B.Zh() || H.h.userAgent.B.Am() || H.h.userAgent.B.Ze() || H.h.userAgent.B.li())
    };
    H.h.userAgent.B.Ze = H.h.userAgent.B.Ai;
    H.h.userAgent.B.xd = H.h.userAgent.B.jn;
    H.h.userAgent.B.vb = H.h.userAgent.B.cf;
    H.h.userAgent.B.ym = H.h.userAgent.B.yi;
    H.h.userAgent.B.sv = H.h.userAgent.B.zi;
    H.h.userAgent.B.Am = H.h.userAgent.B.df;
    H.h.userAgent.B.wv = H.h.userAgent.B.Bi;
    H.h.userAgent.B.bv = H.h.userAgent.B.bf;
    H.h.userAgent.B.kv = H.h.userAgent.B.kn;
    H.h.userAgent.B.Zh = H.h.userAgent.B.af;
    H.h.userAgent.B.Zu = H.h.userAgent.B.hn;
    H.h.userAgent.B.li = function () {
        return H.h.userAgent.G.S("Silk")
    };
    H.h.userAgent.B.Ec = function () {
        function b(f) {
            f = H.g.find(f, e);
            return d[f] || ""
        }

        var c = H.h.userAgent.G.Zb();
        if (H.h.userAgent.B.xd())return H.h.userAgent.B.am(c);
        c = H.h.userAgent.G.$g(c);
        var d = {};
        H.g.forEach(c, function (f) {
            d[f[0]] = f[1]
        });
        var e = H.Mb(H.object.Fb, d);
        return H.h.userAgent.B.Ze() ? b(["Version", "Opera"]) : H.h.userAgent.B.vb() ? b(["Edge"]) : H.h.userAgent.B.ym() ? b(["Edg"]) : H.h.userAgent.B.Zh() ? b(["Chrome", "CriOS"]) : (c = c[2]) && c[1] || ""
    };
    H.h.userAgent.B.Ta = function (b) {
        return 0 <= H.c.A.Eb(H.h.userAgent.B.Ec(), b)
    };
    H.h.userAgent.B.am = function (b) {
        var c = /rv: *([\d\.]*)/.exec(b);
        if (c && c[1])return c[1];
        c = "";
        var d = /MSIE +([\d\.]+)/.exec(b);
        if (d && d[1])if (b = /Trident\/(\d.\d)/.exec(b), "7.0" == d[1])if (b && b[1])switch (b[1]) {
            case "4.0":
                c = "8.0";
                break;
            case "5.0":
                c = "9.0";
                break;
            case "6.0":
                c = "10.0";
                break;
            case "7.0":
                c = "11.0"
        } else c = "7.0"; else c = d[1];
        return c
    };
    H.a.m = {};
    H.a.m.pe = function (b) {
        if (H.m.wa) {
            var c = H.a.m.ac(b);
            c && (!b || !(b instanceof c.Location) && b instanceof c.Element) && H.m.ua("Argument is not a Location (or a non-Element mock); got: %s", H.a.m.Ug(b))
        }
    };
    H.a.m.xa = function (b, c) {
        if (H.m.wa) {
            var d = H.a.m.ac(b);
            d && "undefined" != typeof d[c] && (b && (b instanceof d[c] || !(b instanceof d.Location || b instanceof d.Element)) || H.m.ua("Argument is not a %s (or a non-Element, non-Location mock); got: %s", c, H.a.m.Ug(b)))
        }
        return b
    };
    H.a.m.Ok = function (b) {
        H.a.m.xa(b, "HTMLAnchorElement")
    };
    H.a.m.Qk = function (b) {
        return H.a.m.xa(b, "HTMLButtonElement")
    };
    H.a.m.Wk = function (b) {
        H.a.m.xa(b, "HTMLLinkElement")
    };
    H.a.m.Uk = function (b) {
        H.a.m.xa(b, "HTMLImageElement")
    };
    H.a.m.Pk = function (b) {
        H.a.m.xa(b, "HTMLAudioElement")
    };
    H.a.m.Yk = function (b) {
        H.a.m.xa(b, "HTMLVideoElement")
    };
    H.a.m.Vk = function (b) {
        return H.a.m.xa(b, "HTMLInputElement")
    };
    H.a.m.Is = function (b) {
        return H.a.m.xa(b, "HTMLTextAreaElement")
    };
    H.a.m.Hs = function (b) {
        return H.a.m.xa(b, "HTMLCanvasElement")
    };
    H.a.m.Rk = function (b) {
        H.a.m.xa(b, "HTMLEmbedElement")
    };
    H.a.m.Sk = function (b) {
        return H.a.m.xa(b, "HTMLFormElement")
    };
    H.a.m.Tk = function (b) {
        H.a.m.xa(b, "HTMLFrameElement")
    };
    H.a.m.yg = function (b) {
        H.a.m.xa(b, "HTMLIFrameElement")
    };
    H.a.m.Xk = function (b) {
        H.a.m.xa(b, "HTMLObjectElement")
    };
    H.a.m.zg = function (b) {
        H.a.m.xa(b, "HTMLScriptElement")
    };
    H.a.m.Ug = function (b) {
        if (H.Ea(b))try {
            return b.constructor.displayName || b.constructor.name || Object.prototype.toString.call(b)
        } catch (c) {
            return "<object could not be stringified>"
        } else return void 0 === b ? "undefined" : null === b ? "null" : typeof b
    };
    H.a.m.ac = function (b) {
        try {
            var c = b && b.ownerDocument, d = c && (c.defaultView || c.parentWindow);
            d = d || H.global;
            if (d.Element && d.Location)return d
        } catch (e) {
        }
        return null
    };
    H.U = {};
    H.U.Mg = function (b) {
        return function () {
            return b
        }
    };
    H.U.Vp = E(!1);
    H.U.es = E(!0);
    H.U.cr = E(null);
    H.U.Sh = z();
    H.U.error = function (b) {
        return function () {
            throw Error(b);
        }
    };
    H.U.ua = function (b) {
        return function () {
            throw b;
        }
    };
    H.U.lock = function (b, c) {
        c = c || 0;
        return function () {
            return b.apply(this, Array.prototype.slice.call(arguments, 0, c))
        }
    };
    H.U.Uv = function (b) {
        return function () {
            return arguments[b]
        }
    };
    H.U.$v = function (b, c) {
        var d = Array.prototype.slice.call(arguments, 1);
        return function () {
            var e = Array.prototype.slice.call(arguments);
            e.push.apply(e, d);
            return b.apply(this, e)
        }
    };
    H.U.Ax = function (b, c) {
        return H.U.Wn(b, H.U.Mg(c))
    };
    H.U.Mt = function (b, c) {
        return function (d) {
            return c ? b == d : b === d
        }
    };
    H.U.gt = function (b, c) {
        var d = arguments, e = d.length;
        return function () {
            var f;
            e && (f = d[e - 1].apply(this, arguments));
            for (var g = e - 2; 0 <= g; g--)f = d[g].call(this, f);
            return f
        }
    };
    H.U.Wn = function (b) {
        var c = arguments, d = c.length;
        return function () {
            for (var e, f = 0; f < d; f++)e = c[f].apply(this, arguments);
            return e
        }
    };
    H.U.and = function (b) {
        var c = arguments, d = c.length;
        return function () {
            for (var e = 0; e < d; e++)if (!c[e].apply(this, arguments))return !1;
            return !0
        }
    };
    H.U.or = function (b) {
        var c = arguments, d = c.length;
        return function () {
            for (var e = 0; e < d; e++)if (c[e].apply(this, arguments))return !0;
            return !1
        }
    };
    H.U.on = function (b) {
        return function () {
            return !b.apply(this, arguments)
        }
    };
    H.U.create = function (b, c) {
        function d() {
        }

        d.prototype = b.prototype;
        var e = new d;
        b.apply(e, Array.prototype.slice.call(arguments, 1));
        return e
    };
    H.U.Cj = !0;
    H.U.hl = function (b) {
        var c = !1, d;
        return function () {
            if (!H.U.Cj)return b();
            c || (d = b(), c = !0);
            return d
        }
    };
    H.U.once = function (b) {
        var c = b;
        return function () {
            if (c) {
                var d = c;
                c = null;
                d()
            }
        }
    };
    H.U.At = function (b, c, d) {
        var e = 0;
        return function (f) {
            H.global.clearTimeout(e);
            var g = arguments;
            e = H.global.setTimeout(function () {
                b.apply(d, g)
            }, c)
        }
    };
    H.U.mx = function (b, c, d) {
        function e() {
            g = H.global.setTimeout(f, c);
            b.apply(d, k)
        }

        function f() {
            g = 0;
            h && (h = !1, e())
        }

        var g = 0, h = !1, k = [];
        return function (m) {
            k = arguments;
            g ? h = !0 : e()
        }
    };
    H.U.dw = function (b, c, d) {
        function e() {
            f = 0
        }

        var f = 0;
        return function (g) {
            f || (f = H.global.setTimeout(e, c), b.apply(d, arguments))
        }
    };
    H.a.qq = A();
    H.a.f = function (b) {
        this.no = b
    };
    H.a.f.prototype.toString = C("no");
    H.a.f.Mo = new H.a.f("A");
    H.a.f.No = new H.a.f("ABBR");
    H.a.f.Po = new H.a.f("ACRONYM");
    H.a.f.Qo = new H.a.f("ADDRESS");
    H.a.f.Uo = new H.a.f("APPLET");
    H.a.f.Vo = new H.a.f("AREA");
    H.a.f.Wo = new H.a.f("ARTICLE");
    H.a.f.Xo = new H.a.f("ASIDE");
    H.a.f.bp = new H.a.f("AUDIO");
    H.a.f.cp = new H.a.f("B");
    H.a.f.ep = new H.a.f("BASE");
    H.a.f.fp = new H.a.f("BASEFONT");
    H.a.f.gp = new H.a.f("BDI");
    H.a.f.hp = new H.a.f("BDO");
    H.a.f.kp = new H.a.f("BIG");
    H.a.f.lp = new H.a.f("BLOCKQUOTE");
    H.a.f.mp = new H.a.f("BODY");
    H.a.f.Qf = new H.a.f("BR");
    H.a.f.np = new H.a.f("BUTTON");
    H.a.f.op = new H.a.f("CANVAS");
    H.a.f.pp = new H.a.f("CAPTION");
    H.a.f.rp = new H.a.f("CENTER");
    H.a.f.sp = new H.a.f("CITE");
    H.a.f.tp = new H.a.f("CODE");
    H.a.f.up = new H.a.f("COL");
    H.a.f.vp = new H.a.f("COLGROUP");
    H.a.f.wp = new H.a.f("COMMAND");
    H.a.f.yp = new H.a.f("DATA");
    H.a.f.zp = new H.a.f("DATALIST");
    H.a.f.Ap = new H.a.f("DD");
    H.a.f.Bp = new H.a.f("DEL");
    H.a.f.Dp = new H.a.f("DETAILS");
    H.a.f.Ep = new H.a.f("DFN");
    H.a.f.Fp = new H.a.f("DIALOG");
    H.a.f.Gp = new H.a.f("DIR");
    H.a.f.Hp = new H.a.f("DIV");
    H.a.f.Ip = new H.a.f("DL");
    H.a.f.Lp = new H.a.f("DT");
    H.a.f.Op = new H.a.f("EM");
    H.a.f.Pp = new H.a.f("EMBED");
    H.a.f.Wp = new H.a.f("FIELDSET");
    H.a.f.Xp = new H.a.f("FIGCAPTION");
    H.a.f.Yp = new H.a.f("FIGURE");
    H.a.f.Zp = new H.a.f("FONT");
    H.a.f.$p = new H.a.f("FOOTER");
    H.a.f.aq = new H.a.f("FORM");
    H.a.f.bq = new H.a.f("FRAME");
    H.a.f.cq = new H.a.f("FRAMESET");
    H.a.f.fq = new H.a.f("H1");
    H.a.f.gq = new H.a.f("H2");
    H.a.f.hq = new H.a.f("H3");
    H.a.f.iq = new H.a.f("H4");
    H.a.f.jq = new H.a.f("H5");
    H.a.f.kq = new H.a.f("H6");
    H.a.f.lq = new H.a.f("HEAD");
    H.a.f.mq = new H.a.f("HEADER");
    H.a.f.nq = new H.a.f("HGROUP");
    H.a.f.oq = new H.a.f("HR");
    H.a.f.pq = new H.a.f("HTML");
    H.a.f.rq = new H.a.f("I");
    H.a.f.uq = new H.a.f("IFRAME");
    H.a.f.vq = new H.a.f("IMG");
    H.a.f.wq = new H.a.f("INPUT");
    H.a.f.xq = new H.a.f("INS");
    H.a.f.Cq = new H.a.f("ISINDEX");
    H.a.f.Fq = new H.a.f("KBD");
    H.a.f.Gq = new H.a.f("KEYGEN");
    H.a.f.Hq = new H.a.f("LABEL");
    H.a.f.Jq = new H.a.f("LEGEND");
    H.a.f.Kq = new H.a.f("LI");
    H.a.f.Lq = new H.a.f("LINK");
    H.a.f.Pq = new H.a.f("MAIN");
    H.a.f.Qq = new H.a.f("MAP");
    H.a.f.Rq = new H.a.f("MARK");
    H.a.f.Sq = new H.a.f("MATH");
    H.a.f.Tq = new H.a.f("MENU");
    H.a.f.Uq = new H.a.f("MENUITEM");
    H.a.f.Vq = new H.a.f("META");
    H.a.f.Wq = new H.a.f("METER");
    H.a.f.Yq = new H.a.f("NAV");
    H.a.f.Zq = new H.a.f("NOFRAMES");
    H.a.f.$q = new H.a.f("NOSCRIPT");
    H.a.f.dr = new H.a.f("OBJECT");
    H.a.f.fr = new H.a.f("OL");
    H.a.f.gr = new H.a.f("OPTGROUP");
    H.a.f.ir = new H.a.f("OPTION");
    H.a.f.jr = new H.a.f("OUTPUT");
    H.a.f.kr = new H.a.f("P");
    H.a.f.lr = new H.a.f("PARAM");
    H.a.f.mr = new H.a.f("PICTURE");
    H.a.f.pr = new H.a.f("PRE");
    H.a.f.rr = new H.a.f("PROGRESS");
    H.a.f.Q = new H.a.f("Q");
    H.a.f.sr = new H.a.f("RP");
    H.a.f.tr = new H.a.f("RT");
    H.a.f.ur = new H.a.f("RTC");
    H.a.f.vr = new H.a.f("RUBY");
    H.a.f.xr = new H.a.f("S");
    H.a.f.Ar = new H.a.f("SAMP");
    H.a.f.Br = new H.a.f(l);
    H.a.f.Cr = new H.a.f("SECTION");
    H.a.f.Dr = new H.a.f("SELECT");
    H.a.f.Fr = new H.a.f("SMALL");
    H.a.f.Gr = new H.a.f("SOURCE");
    H.a.f.Hr = new H.a.f("SPAN");
    H.a.f.Jr = new H.a.f("STRIKE");
    H.a.f.Kr = new H.a.f("STRONG");
    H.a.f.Lr = new H.a.f("STYLE");
    H.a.f.Mr = new H.a.f("SUB");
    H.a.f.Nr = new H.a.f("SUMMARY");
    H.a.f.Or = new H.a.f("SUP");
    H.a.f.Pr = new H.a.f("SVG");
    H.a.f.Qr = new H.a.f("TABLE");
    H.a.f.Rr = new H.a.f("TBODY");
    H.a.f.Sr = new H.a.f("TD");
    H.a.f.Tr = new H.a.f("TEMPLATE");
    H.a.f.Ur = new H.a.f("TEXTAREA");
    H.a.f.Vr = new H.a.f("TFOOT");
    H.a.f.Wr = new H.a.f("TH");
    H.a.f.Xr = new H.a.f("THEAD");
    H.a.f.Yr = new H.a.f("TIME");
    H.a.f.Zr = new H.a.f("TITLE");
    H.a.f.$r = new H.a.f("TR");
    H.a.f.bs = new H.a.f("TRACK");
    H.a.f.gs = new H.a.f("TT");
    H.a.f.js = new H.a.f("U");
    H.a.f.ks = new H.a.f("UL");
    H.a.f.ls = new H.a.f("VAR");
    H.a.f.ms = new H.a.f("VIDEO");
    H.a.f.ns = new H.a.f("WBR");
    H.a.tags = {};
    H.a.tags.Hk = {
        area: !0,
        base: !0,
        br: !0,
        col: !0,
        command: !0,
        embed: !0,
        hr: !0,
        img: !0,
        input: !0,
        keygen: !0,
        link: !0,
        meta: !0,
        param: !0,
        source: !0,
        track: !0,
        wbr: !0
    };
    H.a.tags.Qm = function (b) {
        return !0 === H.a.tags.Hk[b]
    };
    H.b = {};
    H.b.Nb = {};
    H.b.Nb.Sb = H.Xc ? H.Rg(H.Xc + "#html") : null;
    H.c.hs = A();
    H.c.L = function (b, c) {
        this.yf = b === H.c.L.Zf && c || "";
        this.wk = H.c.L.og
    };
    H.c.L.prototype.Ra = !0;
    H.c.L.prototype.Ca = C("yf");
    H.la && (H.c.L.prototype.toString = function () {
        return "Const{" + this.yf + "}"
    });
    H.c.L.F = function (b) {
        if (b instanceof H.c.L && b.constructor === H.c.L && b.wk === H.c.L.og)return b.yf;
        H.m.ua("expected object of type Const, got '" + b + "'");
        return "type_error:Const"
    };
    H.c.L.from = function (b) {
        return new H.c.L(H.c.L.Zf, b)
    };
    H.c.L.og = {};
    H.c.L.Zf = {};
    H.c.L.EMPTY = H.c.L.from("");
    H.b.V = function () {
        this.Fd = "";
        this.mk = H.b.V.ta
    };
    H.b.V.prototype.Ra = !0;
    H.b.V.ta = {};
    H.b.V.Cc = function (b) {
        b = H.c.L.F(b);
        return 0 === b.length ? H.b.V.EMPTY : H.b.V.rc(b)
    };
    H.b.V.$t = function (b, c) {
        for (var d = [], e = 1; e < arguments.length; e++)d.push(H.b.V.Yi(arguments[e]));
        return H.b.V.rc("(" + H.c.L.F(b) + ")(" + d.join(", ") + ");")
    };
    H.b.V.cu = function (b) {
        return H.b.V.rc(H.b.V.Yi(b))
    };
    H.b.V.prototype.Ca = function () {
        return this.Fd.toString()
    };
    H.la && (H.b.V.prototype.toString = function () {
        return "SafeScript{" + this.Fd + "}"
    });
    H.b.V.F = function (b) {
        return H.b.V.hj(b).toString()
    };
    H.b.V.hj = function (b) {
        if (b instanceof H.b.V && b.constructor === H.b.V && b.mk === H.b.V.ta)return b.Fd;
        H.m.ua("expected object of type SafeScript, got '" + b + a + H.pa(b));
        return "type_error:SafeScript"
    };
    H.b.V.Yi = function (b) {
        return JSON.stringify(b).replace(/</g, "\\x3c")
    };
    H.b.V.rc = function (b) {
        return (new H.b.V).Kb(b)
    };
    H.b.V.prototype.Kb = function (b) {
        this.Fd = H.b.Nb.Sb ? H.b.Nb.Sb.createScript(b) : b;
        return this
    };
    H.b.V.EMPTY = H.b.V.rc("");
    H.i = {};
    H.i.j = {};
    H.i.j.Vj = !1;
    H.i.j.bg = H.i.j.Vj || ("ar" == H.R.substring(0, 2).toLowerCase() || "fa" == H.R.substring(0, 2).toLowerCase() || "he" == H.R.substring(0, 2).toLowerCase() || "iw" == H.R.substring(0, 2).toLowerCase() || "ps" == H.R.substring(0, 2).toLowerCase() || "sd" == H.R.substring(0, 2).toLowerCase() || "ug" == H.R.substring(0, 2).toLowerCase() || "ur" == H.R.substring(0, 2).toLowerCase() || "yi" == H.R.substring(0, 2).toLowerCase()) && (2 == H.R.length || "-" == H.R.substring(2, 3) || "_" == H.R.substring(2, 3)) || 3 <= H.R.length && "ckb" == H.R.substring(0, 3).toLowerCase() &&
        (3 == H.R.length || "-" == H.R.substring(3, 4) || "_" == H.R.substring(3, 4)) || 7 <= H.R.length && ("-" == H.R.substring(2, 3) || "_" == H.R.substring(2, 3)) && ("adlm" == H.R.substring(3, 7).toLowerCase() || "arab" == H.R.substring(3, 7).toLowerCase() || "hebr" == H.R.substring(3, 7).toLowerCase() || "nkoo" == H.R.substring(3, 7).toLowerCase() || "rohg" == H.R.substring(3, 7).toLowerCase() || "thaa" == H.R.substring(3, 7).toLowerCase()) || 8 <= H.R.length && ("-" == H.R.substring(3, 4) || "_" == H.R.substring(3, 4)) && ("adlm" == H.R.substring(4, 8).toLowerCase() || "arab" ==
        H.R.substring(4, 8).toLowerCase() || "hebr" == H.R.substring(4, 8).toLowerCase() || "nkoo" == H.R.substring(4, 8).toLowerCase() || "rohg" == H.R.substring(4, 8).toLowerCase() || "thaa" == H.R.substring(4, 8).toLowerCase());
    H.i.j.Rb = {ak: "\u202a", ik: "\u202b", hg: "\u202c", bk: "\u200e", jk: "\u200f"};
    H.i.j.$ = {yb: 1, zb: -1, Wa: 0};
    H.i.j.Vc = "right";
    H.i.j.Tc = "left";
    H.i.j.tq = H.i.j.bg ? H.i.j.Tc : H.i.j.Vc;
    H.i.j.sq = H.i.j.bg ? H.i.j.Vc : H.i.j.Tc;
    H.i.j.qo = function (b) {
        return typeof b == r ? 0 < b ? H.i.j.$.yb : 0 > b ? H.i.j.$.zb : H.i.j.$.Wa : null == b ? null : b ? H.i.j.$.zb : H.i.j.$.yb
    };
    H.i.j.cc = "A-Za-z\u00c0-\u00d6\u00d8-\u00f6\u00f8-\u02b8\u0300-\u0590\u0900-\u1fff\u200e\u2c00-\ud801\ud804-\ud839\ud83c-\udbff\uf900-\ufb1c\ufe00-\ufe6f\ufefd-\uffff";
    H.i.j.hc = "\u0591-\u06ef\u06fa-\u08ff\u200f\ud802-\ud803\ud83a-\ud83b\ufb1d-\ufdff\ufe70-\ufefc";
    H.i.j.um = /<[^>]*>|&[^;]+;/g;
    H.i.j.wb = function (b, c) {
        return c ? b.replace(H.i.j.um, "") : b
    };
    H.i.j.Kn = new RegExp("[" + H.i.j.hc + "]");
    H.i.j.an = new RegExp("[" + H.i.j.cc + "]");
    H.i.j.Se = function (b, c) {
        return H.i.j.Kn.test(H.i.j.wb(b, c))
    };
    H.i.j.Mu = H.i.j.Se;
    H.i.j.Qh = function (b) {
        return H.i.j.an.test(H.i.j.wb(b, void 0))
    };
    H.i.j.dn = new RegExp("^[" + H.i.j.cc + "]");
    H.i.j.Pn = new RegExp("^[" + H.i.j.hc + "]");
    H.i.j.Lm = function (b) {
        return H.i.j.Pn.test(b)
    };
    H.i.j.Hm = function (b) {
        return H.i.j.dn.test(b)
    };
    H.i.j.pv = function (b) {
        return !H.i.j.Hm(b) && !H.i.j.Lm(b)
    };
    H.i.j.bn = new RegExp("^[^" + H.i.j.hc + "]*[" + H.i.j.cc + "]");
    H.i.j.Mn = new RegExp("^[^" + H.i.j.cc + "]*[" + H.i.j.hc + "]");
    H.i.j.Wi = function (b, c) {
        return H.i.j.Mn.test(H.i.j.wb(b, c))
    };
    H.i.j.vv = H.i.j.Wi;
    H.i.j.jo = function (b, c) {
        return H.i.j.bn.test(H.i.j.wb(b, c))
    };
    H.i.j.nv = H.i.j.jo;
    H.i.j.ki = /^http:\/\/.*/;
    H.i.j.qv = function (b, c) {
        b = H.i.j.wb(b, c);
        return H.i.j.ki.test(b) || !H.i.j.Qh(b) && !H.i.j.Se(b)
    };
    H.i.j.cn = new RegExp("[" + H.i.j.cc + "][^" + H.i.j.hc + "]*$");
    H.i.j.Nn = new RegExp("[" + H.i.j.hc + "][^" + H.i.j.cc + "]*$");
    H.i.j.Fl = function (b, c) {
        return H.i.j.cn.test(H.i.j.wb(b, c))
    };
    H.i.j.mv = H.i.j.Fl;
    H.i.j.Gl = function (b, c) {
        return H.i.j.Nn.test(H.i.j.wb(b, c))
    };
    H.i.j.tv = H.i.j.Gl;
    H.i.j.On = /^(ar|ckb|dv|he|iw|fa|nqo|ps|sd|ug|ur|yi|.*[-_](Adlm|Arab|Hebr|Nkoo|Rohg|Thaa))(?!.*[-_](Latn|Cyrl)($|-|_))($|-|_)/i;
    H.i.j.uv = function (b) {
        return H.i.j.On.test(b)
    };
    H.i.j.el = /(\(.*?\)+)|(\[.*?\]+)|(\{.*?\}+)|(<.*?>+)/g;
    H.i.j.Ku = function (b, c) {
        c = (void 0 === c ? H.i.j.Se(b) : c) ? H.i.j.Rb.jk : H.i.j.Rb.bk;
        return b.replace(H.i.j.el, c + "$&" + c)
    };
    H.i.j.Jt = function (b) {
        return "<" == b.charAt(0) ? b.replace(/<\w+/, "$& dir=rtl") : "\n<span dir=rtl>" + b + "</span>"
    };
    H.i.j.Kt = function (b) {
        return H.i.j.Rb.ik + b + H.i.j.Rb.hg
    };
    H.i.j.Ht = function (b) {
        return "<" == b.charAt(0) ? b.replace(/<\w+/, "$& dir=ltr") : "\n<span dir=ltr>" + b + "</span>"
    };
    H.i.j.It = function (b) {
        return H.i.j.Rb.ak + b + H.i.j.Rb.hg
    };
    H.i.j.Bl = /:\s*([.\d][.\w]*)\s+([.\d][.\w]*)\s+([.\d][.\w]*)\s+([.\d][.\w]*)/g;
    H.i.j.Sm = /left/gi;
    H.i.j.Jn = /right/gi;
    H.i.j.oo = /%%%%/g;
    H.i.j.Lv = function (b) {
        return b.replace(H.i.j.Bl, ":$1 $4 $3 $2").replace(H.i.j.Sm, "%%%%").replace(H.i.j.Jn, H.i.j.Tc).replace(H.i.j.oo, H.i.j.Vc)
    };
    H.i.j.Dl = /([\u0591-\u05f2])"/g;
    H.i.j.fo = /([\u0591-\u05f2])'/g;
    H.i.j.Qv = function (b) {
        return b.replace(H.i.j.Dl, "$1\u05f4").replace(H.i.j.fo, "$1\u05f3")
    };
    H.i.j.Io = /\s+/;
    H.i.j.sm = /[\d\u06f0-\u06f9]/;
    H.i.j.Ln = .4;
    H.i.j.Yg = function (b, c) {
        var d = 0, e = 0, f = !1;
        b = H.i.j.wb(b, c).split(H.i.j.Io);
        for (c = 0; c < b.length; c++) {
            var g = b[c];
            H.i.j.Wi(g) ? (d++, e++) : H.i.j.ki.test(g) ? f = !0 : H.i.j.Qh(g) ? e++ : H.i.j.sm.test(g) && (f = !0)
        }
        return 0 == e ? f ? H.i.j.$.yb : H.i.j.$.Wa : d / e > H.i.j.Ln ? H.i.j.$.zb : H.i.j.$.yb
    };
    H.i.j.Ct = function (b, c) {
        return H.i.j.Yg(b, c) == H.i.j.$.zb
    };
    H.i.j.Dw = function (b, c) {
        b && (c = H.i.j.qo(c)) && (b.style.textAlign = c == H.i.j.$.zb ? H.i.j.Vc : H.i.j.Tc, b.dir = c == H.i.j.$.zb ? "rtl" : "ltr")
    };
    H.i.j.Ew = function (b, c) {
        switch (H.i.j.Yg(c)) {
            case H.i.j.$.yb:
                b.dir = "ltr";
                break;
            case H.i.j.$.zb:
                b.dir = "rtl";
                break;
            default:
                b.removeAttribute("dir")
        }
    };
    H.i.j.Mp = A();
    H.b.I = function (b, c) {
        this.jf = b === H.b.I.mc && c || "";
        this.zk = H.b.I.ta
    };
    H.b.I.prototype.Ra = !0;
    H.b.I.prototype.Ca = function () {
        return this.jf.toString()
    };
    H.b.I.prototype.Ue = !0;
    H.b.I.prototype.rb = function () {
        return H.i.j.$.yb
    };
    H.la && (H.b.I.prototype.toString = function () {
        return "TrustedResourceUrl{" + this.jf + "}"
    });
    H.b.I.F = function (b) {
        return H.b.I.Td(b).toString()
    };
    H.b.I.Td = function (b) {
        if (b instanceof H.b.I && b.constructor === H.b.I && b.zk === H.b.I.ta)return b.jf;
        H.m.ua("expected object of type TrustedResourceUrl, got '" + b + a + H.pa(b));
        return "type_error:TrustedResourceUrl"
    };
    H.b.I.format = function (b, c) {
        var d = H.c.L.F(b);
        if (!H.b.I.Aj.test(d))throw Error("Invalid TrustedResourceUrl format: " + d);
        b = d.replace(H.b.I.Wj, function (e, f) {
            if (!Object.prototype.hasOwnProperty.call(c, f))throw Error('Found marker, "' + f + '", in format string, "' + d + '", but no valid label mapping found in args: ' + JSON.stringify(c));
            e = c[f];
            return e instanceof H.c.L ? H.c.L.F(e) : encodeURIComponent(String(e))
        });
        return H.b.I.uc(b)
    };
    H.b.I.Wj = /%{(\w+)}/g;
    H.b.I.Aj = /^((https:)?\/\/[0-9a-z.:[\]-]+\/|\/[^/\\]|[^:/\\%]+\/|[^:/\\%]*[?#]|about:blank#)/i;
    H.b.I.Ck = /^([^?#]*)(\?[^#]*)?(#[\s\S]*)?/;
    H.b.I.Xt = function (b, c, d, e) {
        b = H.b.I.format(b, c);
        b = H.b.I.F(b);
        b = H.b.I.Ck.exec(b);
        c = b[3] || "";
        return H.b.I.uc(b[1] + H.b.I.Xi("?", b[2] || "", d) + H.b.I.Xi("#", c, e))
    };
    H.b.I.Cc = function (b) {
        return H.b.I.uc(H.c.L.F(b))
    };
    H.b.I.au = function (b) {
        for (var c = "", d = 0; d < b.length; d++)c += H.c.L.F(b[d]);
        return H.b.I.uc(c)
    };
    H.b.I.ta = {};
    H.b.I.uc = function (b) {
        b = H.b.Nb.Sb ? H.b.Nb.Sb.createScriptURL(b) : b;
        return new H.b.I(H.b.I.mc, b)
    };
    H.b.I.Xi = function (b, c, d) {
        if (null == d)return c;
        if (typeof d === x)return d ? b + encodeURIComponent(d) : "";
        for (var e in d) {
            var f = d[e];
            f = H.isArray(f) ? f : [f];
            for (var g = 0; g < f.length; g++) {
                var h = f[g];
                null != h && (c || (c = b), c += (c.length > b.length ? "&" : "") + encodeURIComponent(e) + "=" + encodeURIComponent(String(h)))
            }
        }
        return c
    };
    H.b.I.mc = {};
    H.Qa = {};
    H.Qa.url = {};
    H.Qa.url.ql = function (b) {
        return H.Qa.url.Mh().createObjectURL(b)
    };
    H.Qa.url.pw = function (b) {
        H.Qa.url.Mh().revokeObjectURL(b)
    };
    H.Qa.url.Mh = function () {
        var b = H.Qa.url.eh();
        if (null != b)return b;
        throw Error("This browser doesn't seem to support blob URLs");
    };
    H.Qa.url.eh = function () {
        return void 0 !== H.global.URL && void 0 !== H.global.URL.createObjectURL ? H.global.URL : void 0 !== H.global.webkitURL && void 0 !== H.global.webkitURL.createObjectURL ? H.global.webkitURL : void 0 !== H.global.createObjectURL ? H.global : null
    };
    H.Qa.url.Us = function () {
        return null != H.Qa.url.eh()
    };
    H.b.u = function (b, c) {
        this.hf = b === H.b.u.mc && c || "";
        this.qk = H.b.u.ta
    };
    H.b.u.qa = "about:invalid#zClosurez";
    H.b.u.prototype.Ra = !0;
    H.b.u.prototype.Ca = function () {
        return this.hf.toString()
    };
    H.b.u.prototype.Ue = !0;
    H.b.u.prototype.rb = function () {
        return H.i.j.$.yb
    };
    H.la && (H.b.u.prototype.toString = function () {
        return "SafeUrl{" + this.hf + "}"
    });
    H.b.u.F = function (b) {
        if (b instanceof H.b.u && b.constructor === H.b.u && b.qk === H.b.u.ta)return b.hf;
        H.m.ua("expected object of type SafeUrl, got '" + b + a + H.pa(b));
        return "type_error:SafeUrl"
    };
    H.b.u.Cc = function (b) {
        return H.b.u.ya(H.c.L.F(b))
    };
    H.b.he = /^(?:audio\/(?:3gpp2|3gpp|aac|L16|midi|mp3|mp4|mpeg|oga|ogg|opus|x-m4a|x-wav|wav|webm)|image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp|x-icon)|text\/csv|video\/(?:mpeg|mp4|ogg|webm|quicktime))(?:;\w+=(?:\w+|"[\w;=]+"))*$/i;
    H.b.u.xv = function (b) {
        return H.b.he.test(b)
    };
    H.b.u.Zt = function (b) {
        b = H.b.he.test(b.type) ? H.Qa.url.ql(b) : H.b.u.qa;
        return H.b.u.ya(b)
    };
    H.b.Kj = /^data:([^,]*);base64,[a-z0-9+\/]+=*$/i;
    H.b.u.Ql = function (b) {
        b = b.replace(/(%0A|%0D)/g, "");
        var c = b.match(H.b.Kj);
        c = c && H.b.he.test(c[1]);
        return H.b.u.ya(c ? b : H.b.u.qa)
    };
    H.b.u.hu = function (b) {
        H.c.A.Cb(b, "tel:") || (b = H.b.u.qa);
        return H.b.u.ya(b)
    };
    H.b.uk = /^sip[s]?:[+a-z0-9_.!$%&'*\/=^`{|}~-]+@([a-z0-9-]+\.)+[a-z0-9]{2,63}$/i;
    H.b.u.eu = function (b) {
        H.b.uk.test(decodeURIComponent(b)) || (b = H.b.u.qa);
        return H.b.u.ya(b)
    };
    H.b.u.bu = function (b) {
        H.c.A.Cb(b, "fb-messenger://share") || (b = H.b.u.qa);
        return H.b.u.ya(b)
    };
    H.b.u.ju = function (b) {
        H.c.A.Cb(b, "whatsapp://send") || (b = H.b.u.qa);
        return H.b.u.ya(b)
    };
    H.b.u.fu = function (b) {
        H.c.A.Cb(b, "sms:") && H.b.u.Mm(b) || (b = H.b.u.qa);
        return H.b.u.ya(b)
    };
    H.b.u.Mm = function (b) {
        var c = b.indexOf("#");
        0 < c && (b = b.substring(0, c));
        c = b.match(/[?&]body=/gi);
        if (!c)return !0;
        if (1 < c.length)return !1;
        b = b.match(/[?&]body=([^&]*)/)[1];
        if (!b)return !0;
        try {
            decodeURIComponent(b)
        } catch (d) {
            return !1
        }
        return /^(?:[a-z0-9\-_.~]|%[0-9a-f]{2})+$/i.test(b)
    };
    H.b.u.gu = function (b) {
        H.c.A.Cb(b, "ssh://") || (b = H.b.u.qa);
        return H.b.u.ya(b)
    };
    H.b.u.ww = function (b, c) {
        return H.b.u.nf(/^chrome-extension:\/\/([^\/]+)\//, b, c)
    };
    H.b.u.yw = function (b, c) {
        return H.b.u.nf(/^moz-extension:\/\/([^\/]+)\//, b, c)
    };
    H.b.u.xw = function (b, c) {
        return H.b.u.nf(/^ms-browser-extension:\/\/([^\/]+)\//, b, c)
    };
    H.b.u.nf = function (b, c, d) {
        (b = b.exec(c)) ? (b = b[1], -1 == (d instanceof H.c.L ? [H.c.L.F(d)] : d.map(function (e) {
            return H.c.L.F(e)
        })).indexOf(b) && (c = H.b.u.qa)) : c = H.b.u.qa;
        return H.b.u.ya(c)
    };
    H.b.u.iu = function (b) {
        return H.b.u.ya(H.b.I.F(b))
    };
    H.b.ie = /^(?:(?:https?|mailto|ftp):|[^:/?#]*(?:[/?#]|$))/i;
    H.b.u.zr = H.b.ie;
    H.b.u.Nd = function (b) {
        if (b instanceof H.b.u)return b;
        b = typeof b == u && b.Ra ? b.Ca() : String(b);
        H.b.ie.test(b) || (b = H.b.u.qa);
        return H.b.u.ya(b)
    };
    H.b.u.Ma = function (b, c) {
        if (b instanceof H.b.u)return b;
        b = typeof b == u && b.Ra ? b.Ca() : String(b);
        if (c && /^data:/i.test(b) && (c = H.b.u.Ql(b), c.Ca() == b))return c;
        H.b.ie.test(b) || (b = H.b.u.qa);
        return H.b.u.ya(b)
    };
    H.b.u.ta = {};
    H.b.u.ya = function (b) {
        return new H.b.u(H.b.u.mc, b)
    };
    H.b.u.Oo = H.b.u.ya("about:blank");
    H.b.u.mc = {};
    H.b.D = function () {
        this.Hd = "";
        this.pk = H.b.D.ta
    };
    H.b.D.prototype.Ra = !0;
    H.b.D.ta = {};
    H.b.D.Cc = function (b) {
        b = H.c.L.F(b);
        return 0 === b.length ? H.b.D.EMPTY : H.b.D.sc(b)
    };
    H.b.D.prototype.Ca = C("Hd");
    H.la && (H.b.D.prototype.toString = function () {
        return "SafeStyle{" + this.Hd + "}"
    });
    H.b.D.F = function (b) {
        if (b instanceof H.b.D && b.constructor === H.b.D && b.pk === H.b.D.ta)return b.Hd;
        H.m.ua("expected object of type SafeStyle, got '" + b + a + H.pa(b));
        return "type_error:SafeStyle"
    };
    H.b.D.sc = function (b) {
        return (new H.b.D).Kb(b)
    };
    H.b.D.prototype.Kb = function (b) {
        this.Hd = b;
        return this
    };
    H.b.D.EMPTY = H.b.D.sc("");
    H.b.D.qa = "zClosurez";
    H.b.D.create = function (b) {
        var c = "", d;
        for (d in b) {
            if (!/^[-_a-zA-Z0-9]+$/.test(d))throw Error("Name allows only [-_a-zA-Z0-9], got: " + d);
            var e = b[d];
            null != e && (e = H.isArray(e) ? H.g.map(e, H.b.D.Oi).join(" ") : H.b.D.Oi(e), c += d + ":" + e + ";")
        }
        return c ? H.b.D.sc(c) : H.b.D.EMPTY
    };
    H.b.D.Oi = function (b) {
        if (b instanceof H.b.u)return 'url("' + H.b.u.F(b).replace(/</g, "%3c").replace(/[\\"]/g, "\\$&") + '")';
        b = b instanceof H.c.L ? H.c.L.F(b) : H.b.D.Tn(String(b));
        if (/[{;}]/.test(b))throw new H.m.kc("Value does not allow [{;}], got: %s.", [b]);
        return b
    };
    H.b.D.Tn = function (b) {
        var c = b.replace(H.b.D.Yf, "$1").replace(H.b.D.Yf, "$1").replace(H.b.D.pg, "url");
        if (H.b.D.Ek.test(c)) {
            if (H.b.D.Ij.test(b))return H.m.ua("String value disallows comments, got: " + b), H.b.D.qa;
            if (!H.b.D.om(b))return H.m.ua("String value requires balanced quotes, got: " + b), H.b.D.qa;
            if (!H.b.D.pm(b))return H.m.ua("String value requires balanced square brackets and one identifier per pair of brackets, got: " + b), H.b.D.qa
        } else return H.m.ua("String value allows only " + H.b.D.sg + " and simple functions, got: " +
            b), H.b.D.qa;
        return H.b.D.Un(b)
    };
    H.b.D.om = function (b) {
        for (var c = !0, d = !0, e = 0; e < b.length; e++) {
            var f = b.charAt(e);
            "'" == f && d ? c = !c : '"' == f && c && (d = !d)
        }
        return c && d
    };
    H.b.D.pm = function (b) {
        for (var c = !0, d = /^[-_a-zA-Z0-9]$/, e = 0; e < b.length; e++) {
            var f = b.charAt(e);
            if ("]" == f) {
                if (c)return !1;
                c = !0
            } else if ("[" == f) {
                if (!c)return !1;
                c = !1
            } else if (!c && !d.test(f))return !1
        }
        return c
    };
    H.b.D.sg = "[-,.\"'%_!# a-zA-Z0-9\\[\\]]";
    H.b.D.Ek = new RegExp("^" + H.b.D.sg + "+$");
    H.b.D.pg = /\b(url\([ \t\n]*)('[ -&(-\[\]-~]*'|"[ !#-\[\]-~]*"|[!#-&*-\[\]-~]*)([ \t\n]*\))/g;
    H.b.D.qj = "calc cubic-bezier fit-content hsl hsla matrix minmax repeat rgb rgba (rotate|scale|translate)(X|Y|Z|3d)?".split(" ");
    H.b.D.Yf = new RegExp("\\b(" + H.b.D.qj.join("|") + ")\\([-+*/0-9a-z.%\\[\\], ]+\\)", "g");
    H.b.D.Ij = /\/\*/;
    H.b.D.Un = function (b) {
        return b.replace(H.b.D.pg, function (c, d, e, f) {
            var g = "";
            e = e.replace(/^(['"])(.*)\1$/, function (h, k, m) {
                g = k;
                return m
            });
            c = H.b.u.Nd(e).Ca();
            return d + g + c + g + f
        })
    };
    H.b.D.concat = function (b) {
        function c(e) {
            H.isArray(e) ? H.g.forEach(e, c) : d += H.b.D.F(e)
        }

        var d = "";
        H.g.forEach(arguments, c);
        return d ? H.b.D.sc(d) : H.b.D.EMPTY
    };
    H.b.X = function () {
        this.Gd = "";
        this.nk = H.b.X.ta
    };
    H.b.X.prototype.Ra = !0;
    H.b.X.ta = {};
    H.b.X.tt = function (b, c) {
        if (H.c.A.contains(b, "<"))throw Error("Selector does not allow '<', got: " + b);
        var d = b.replace(/('|")((?!\1)[^\r\n\f\\]|\\[\s\S])*\1/g, "");
        if (!/^[-_a-zA-Z0-9#.:* ,>+~[\]()=^$|]+$/.test(d))throw Error("Selector allows only [-_a-zA-Z0-9#.:* ,>+~[\\]()=^$|] and strings, got: " + b);
        if (!H.b.X.nm(d))throw Error("() and [] in selector must be balanced, got: " + b);
        c instanceof H.b.D || (c = H.b.D.create(c));
        b = b + "{" + H.b.D.F(c).replace(/</g, "\\3C ") + "}";
        return H.b.X.tc(b)
    };
    H.b.X.nm = function (b) {
        for (var c = {"(": ")", "[": "]"}, d = [], e = 0; e < b.length; e++) {
            var f = b[e];
            if (c[f]) d.push(c[f]); else if (H.object.contains(c, f) && d.pop() != f)return !1
        }
        return 0 == d.length
    };
    H.b.X.concat = function (b) {
        function c(e) {
            H.isArray(e) ? H.g.forEach(e, c) : d += H.b.X.F(e)
        }

        var d = "";
        H.g.forEach(arguments, c);
        return H.b.X.tc(d)
    };
    H.b.X.Cc = function (b) {
        b = H.c.L.F(b);
        return 0 === b.length ? H.b.X.EMPTY : H.b.X.tc(b)
    };
    H.b.X.prototype.Ca = C("Gd");
    H.la && (H.b.X.prototype.toString = function () {
        return "SafeStyleSheet{" + this.Gd + "}"
    });
    H.b.X.F = function (b) {
        if (b instanceof H.b.X && b.constructor === H.b.X && b.nk === H.b.X.ta)return b.Gd;
        H.m.ua("expected object of type SafeStyleSheet, got '" + b + a + H.pa(b));
        return "type_error:SafeStyleSheet"
    };
    H.b.X.tc = function (b) {
        return (new H.b.X).Kb(b)
    };
    H.b.X.prototype.Kb = function (b) {
        this.Gd = b;
        return this
    };
    H.b.X.EMPTY = H.b.X.tc("");
    H.b.s = function () {
        this.Ed = "";
        this.lk = H.b.s.ta;
        this.hd = null
    };
    H.b.s.Ua = H.la;
    H.b.s.xk = !0;
    H.b.s.prototype.Ue = !0;
    H.b.s.prototype.rb = C("hd");
    H.b.s.prototype.Ra = !0;
    H.b.s.prototype.Ca = function () {
        return this.Ed.toString()
    };
    H.la && (H.b.s.prototype.toString = function () {
        return "SafeHtml{" + this.Ed + "}"
    });
    H.b.s.F = function (b) {
        return H.b.s.xb(b).toString()
    };
    H.b.s.xb = function (b) {
        if (b instanceof H.b.s && b.constructor === H.b.s && b.lk === H.b.s.ta)return b.Ed;
        H.m.ua("expected object of type SafeHtml, got '" + b + a + H.pa(b));
        return "type_error:SafeHtml"
    };
    H.b.s.Da = function (b) {
        if (b instanceof H.b.s)return b;
        var c = typeof b == u, d = null;
        c && b.Ue && (d = b.rb());
        return H.b.s.Oa(H.c.A.Da(c && b.Ra ? b.Ca() : String(b)), d)
    };
    H.b.s.Pu = function (b) {
        if (b instanceof H.b.s)return b;
        b = H.b.s.Da(b);
        return H.b.s.Oa(H.c.A.Kc(H.b.s.F(b)), b.rb())
    };
    H.b.s.Qu = function (b) {
        if (b instanceof H.b.s)return b;
        b = H.b.s.Da(b);
        return H.b.s.Oa(H.c.A.kj(H.b.s.F(b)), b.rb())
    };
    H.b.s.from = H.b.s.Da;
    H.b.s.rg = /^[a-zA-Z0-9-]+$/;
    H.b.s.Bk = {action: !0, cite: !0, data: !0, formaction: !0, href: !0, manifest: !0, poster: !0, src: !0};
    H.b.s.fk = {
        APPLET: !0,
        BASE: !0,
        EMBED: !0,
        IFRAME: !0,
        LINK: !0,
        MATH: !0,
        META: !0,
        OBJECT: !0,
        SCRIPT: !0,
        STYLE: !0,
        SVG: !0,
        TEMPLATE: !0
    };
    H.b.s.create = function (b, c, d) {
        H.b.s.Go(String(b));
        return H.b.s.Hb(String(b), c, d)
    };
    H.b.s.Go = function (b) {
        if (!H.b.s.rg.test(b))throw Error(H.b.s.Ua ? "Invalid tag name <" + b + ">." : "");
        if (b.toUpperCase() in H.b.s.fk)throw Error(H.b.s.Ua ? "Tag name <" + b + "> is not allowed for SafeHtml." : "");
    };
    H.b.s.pt = function (b, c, d, e) {
        b && H.b.I.F(b);
        var f = {};
        f.src = b || null;
        f.srcdoc = c && H.b.s.F(c);
        b = H.b.s.dd(f, {sandbox: ""}, d);
        return H.b.s.Hb("iframe", b, e)
    };
    H.b.s.ut = function (b, c, d, e) {
        if (!H.b.s.il())throw Error(H.b.s.Ua ? "The browser does not support sandboxed iframes." : "");
        var f = {};
        f.src = b ? H.b.u.F(H.b.u.Nd(b)) : null;
        f.srcdoc = c || null;
        f.sandbox = "";
        b = H.b.s.dd(f, {}, d);
        return H.b.s.Hb("iframe", b, e)
    };
    H.b.s.il = function () {
        return H.global.HTMLIFrameElement && "sandbox" in H.global.HTMLIFrameElement.prototype
    };
    H.b.s.vt = function (b, c) {
        H.b.I.F(b);
        b = H.b.s.dd({src: b}, {}, c);
        return H.b.s.Hb(w, b)
    };
    H.b.s.createScript = function (b, c) {
        for (var d in c) {
            var e = d.toLowerCase();
            if ("language" == e || "src" == e || "text" == e || "type" == e)throw Error(H.b.s.Ua ? 'Cannot set "' + e + '" attribute' : "");
        }
        d = "";
        b = H.g.concat(b);
        for (e = 0; e < b.length; e++)d += H.b.V.F(b[e]);
        b = H.b.s.Oa(d, H.i.j.$.Wa);
        return H.b.s.Hb(w, c, b)
    };
    H.b.s.wt = function (b, c) {
        c = H.b.s.dd({type: "text/css"}, {}, c);
        var d = "";
        b = H.g.concat(b);
        for (var e = 0; e < b.length; e++)d += H.b.X.F(b[e]);
        b = H.b.s.Oa(d, H.i.j.$.Wa);
        return H.b.s.Hb("style", c, b)
    };
    H.b.s.st = function (b, c) {
        b = H.b.u.F(H.b.u.Nd(b));
        (H.h.userAgent.B.xd() || H.h.userAgent.B.vb()) && H.c.A.contains(b, ";") && (b = "'" + b.replace(/'/g, "%27") + "'");
        return H.b.s.Hb("meta", {"http-equiv": "refresh", content: (c || 0) + "; url=" + b})
    };
    H.b.s.Sl = function (b, c, d) {
        if (d instanceof H.c.L) d = H.c.L.F(d); else if ("style" == c.toLowerCase())if (H.b.s.xk) d = H.b.s.hm(d); else throw Error(H.b.s.Ua ? 'Attribute "style" not supported.' : ""); else {
            if (/^on/i.test(c))throw Error(H.b.s.Ua ? 'Attribute "' + c + '" requires goog.string.Const value, "' + d + '" given.' : "");
            if (c.toLowerCase() in H.b.s.Bk)if (d instanceof H.b.I) d = H.b.I.F(d); else if (d instanceof H.b.u) d = H.b.u.F(d); else if (typeof d === x) d = H.b.u.Nd(d).Ca(); else throw Error(H.b.s.Ua ? 'Attribute "' + c + '" on tag "' +
                b + '" requires goog.html.SafeUrl, goog.string.Const, or string, value "' + d + '" given.' : "");
        }
        d.Ra && (d = d.Ca());
        return c + '="' + H.c.A.Da(String(d)) + '"'
    };
    H.b.s.hm = function (b) {
        if (!H.Ea(b))throw Error(H.b.s.Ua ? 'The "style" attribute requires goog.html.SafeStyle or map of style properties, ' + typeof b + " given: " + b : "");
        b instanceof H.b.D || (b = H.b.D.create(b));
        return H.b.D.F(b)
    };
    H.b.s.yt = function (b, c, d, e) {
        c = H.b.s.create(c, d, e);
        c.hd = b;
        return c
    };
    H.b.s.join = function (b, c) {
        function d(g) {
            H.isArray(g) ? H.g.forEach(g, d) : (g = H.b.s.Da(g), f.push(H.b.s.F(g)), g = g.rb(), e == H.i.j.$.Wa ? e = g : g != H.i.j.$.Wa && e != g && (e = null))
        }

        b = H.b.s.Da(b);
        var e = b.rb(), f = [];
        H.g.forEach(c, d);
        return H.b.s.Oa(f.join(H.b.s.F(b)), e)
    };
    H.b.s.concat = function (b) {
        return H.b.s.join(H.b.s.EMPTY, Array.prototype.slice.call(arguments))
    };
    H.b.s.jt = function (b, c) {
        var d = H.b.s.concat(H.g.slice(arguments, 1));
        d.hd = b;
        return d
    };
    H.b.s.ta = {};
    H.b.s.Oa = function (b, c) {
        return (new H.b.s).Kb(b, c)
    };
    H.b.s.prototype.Kb = function (b, c) {
        this.Ed = H.b.Nb.Sb ? H.b.Nb.Sb.createHTML(b) : b;
        this.hd = c;
        return this
    };
    H.b.s.Hb = function (b, c, d) {
        var e = null;
        var f = "<" + b + H.b.s.lo(b, c);
        null == d ? d = [] : H.isArray(d) || (d = [d]);
        H.a.tags.Qm(b.toLowerCase()) ? f += ">" : (e = H.b.s.concat(d), f += ">" + H.b.s.F(e) + "</" + b + ">", e = e.rb());
        (b = c && c.dir) && (e = /^(ltr|rtl|auto)$/i.test(b) ? H.i.j.$.Wa : null);
        return H.b.s.Oa(f, e)
    };
    H.b.s.lo = function (b, c) {
        var d = "";
        if (c)for (var e in c) {
            if (!H.b.s.rg.test(e))throw Error(H.b.s.Ua ? 'Invalid attribute name "' + e + '".' : "");
            var f = c[e];
            null != f && (d += " " + H.b.s.Sl(b, e, f))
        }
        return d
    };
    H.b.s.dd = function (b, c, d) {
        var e = {}, f;
        for (f in b)e[f] = b[f];
        for (f in c)e[f] = c[f];
        if (d)for (f in d) {
            var g = f.toLowerCase();
            if (g in b)throw Error(H.b.s.Ua ? 'Cannot override "' + g + '" attribute, got "' + f + '" with value "' + d[f] + '"' : "");
            g in c && delete e[g];
            e[f] = d[f]
        }
        return e
    };
    H.b.s.Jp = H.b.s.Oa("<!DOCTYPE html>", H.i.j.$.Wa);
    H.b.s.EMPTY = H.b.s.Oa("", H.i.j.$.Wa);
    H.b.s.Qf = H.b.s.Oa("<br>", H.i.j.$.Wa);
    H.b.hb = {};
    H.b.hb.Li = function (b, c) {
        return H.b.s.Oa(c, null)
    };
    H.b.hb.tw = function (b, c) {
        return H.b.V.rc(c)
    };
    H.b.hb.uw = function (b, c) {
        return H.b.D.sc(c)
    };
    H.b.hb.vw = function (b, c) {
        return H.b.X.tc(c)
    };
    H.b.hb.Rn = function (b, c) {
        return H.b.u.ya(c)
    };
    H.b.hb.tx = function (b, c) {
        return H.b.I.uc(c)
    };
    H.a.N = {};
    H.a.N.Dq = {Ro: "afterbegin", So: "afterend", ip: "beforebegin", jp: "beforeend"};
    H.a.N.Su = function (b, c, d) {
        b.insertAdjacentHTML(c, H.b.s.xb(d))
    };
    H.a.N.tk = {MATH: !0, SCRIPT: !0, STYLE: !0, SVG: !0, TEMPLATE: !0};
    H.a.N.Em = H.U.hl(function () {
        if (H.la && "undefined" === typeof document)return !1;
        var b = document.createElement("div"), c = document.createElement("div");
        c.appendChild(document.createElement("div"));
        b.appendChild(c);
        if (H.la && !b.firstChild)return !1;
        c = b.firstChild.firstChild;
        b.innerHTML = H.b.s.xb(H.b.s.EMPTY);
        return !c.parentElement
    });
    H.a.N.Bo = function (b, c) {
        if (H.a.N.Em())for (; b.lastChild;)b.removeChild(b.lastChild);
        b.innerHTML = H.b.s.xb(c)
    };
    H.a.N.rf = function (b, c) {
        if (H.m.wa && H.a.N.tk[b.tagName.toUpperCase()])throw Error("goog.dom.safe.setInnerHtml cannot be used to set content of " + b.tagName + ".");
        H.a.N.Bo(b, c)
    };
    H.a.N.Qw = function (b, c) {
        b.outerHTML = H.b.s.xb(c)
    };
    H.a.N.Hw = function (b, c) {
        c = c instanceof H.b.u ? c : H.b.u.Ma(c);
        H.a.m.Sk(b).action = H.b.u.F(c)
    };
    H.a.N.Bw = function (b, c) {
        c = c instanceof H.b.u ? c : H.b.u.Ma(c);
        H.a.m.Qk(b).formAction = H.b.u.F(c)
    };
    H.a.N.Mw = function (b, c) {
        c = c instanceof H.b.u ? c : H.b.u.Ma(c);
        H.a.m.Vk(b).formAction = H.b.u.F(c)
    };
    H.a.N.Uw = function (b, c) {
        b.style.cssText = H.b.D.F(c)
    };
    H.a.N.Cl = function (b) {
        b.write(H.b.s.xb(H.b.s.EMPTY))
    };
    H.a.N.zw = function (b, c) {
        H.a.m.Ok(b);
        c = c instanceof H.b.u ? c : H.b.u.Ma(c);
        b.href = H.b.u.F(c)
    };
    H.a.N.Yn = function (b, c) {
        H.a.m.Uk(b);
        c = c instanceof H.b.u ? c : H.b.u.Ma(c, /^data:image\//i.test(c));
        b.src = H.b.u.F(c)
    };
    H.a.N.Aw = function (b, c) {
        H.a.m.Pk(b);
        c = c instanceof H.b.u ? c : H.b.u.Ma(c, /^data:audio\//i.test(c));
        b.src = H.b.u.F(c)
    };
    H.a.N.Yw = function (b, c) {
        H.a.m.Yk(b);
        c = c instanceof H.b.u ? c : H.b.u.Ma(c, /^data:video\//i.test(c));
        b.src = H.b.u.F(c)
    };
    H.a.N.Fw = function (b, c) {
        H.a.m.Rk(b);
        b.src = H.b.I.Td(c)
    };
    H.a.N.Jw = function (b, c) {
        H.a.m.Tk(b);
        b.src = H.b.I.F(c)
    };
    H.a.N.Xn = function (b) {
        var c = H.b.I.Cc(H.c.L.EMPTY);
        H.a.m.yg(b);
        b.src = H.b.I.F(c)
    };
    H.a.N.Lw = function (b, c) {
        H.a.m.yg(b);
        b.srcdoc = H.b.s.xb(c)
    };
    H.a.N.Nw = function (b, c, d) {
        H.a.m.Wk(b);
        b.rel = d;
        H.c.A.bd(d, "stylesheet") ? b.href = H.b.I.F(c) : b.href = c instanceof H.b.I ? H.b.I.F(c) : c instanceof H.b.u ? H.b.u.F(c) : H.b.u.F(H.b.u.Ma(c))
    };
    H.a.N.Pw = function (b, c) {
        H.a.m.Xk(b);
        b.data = H.b.I.Td(c)
    };
    H.a.N.bo = function (b, c) {
        H.a.m.zg(b);
        b.src = H.b.I.Td(c);
        (c = H.Jh()) && b.setAttribute("nonce", c)
    };
    H.a.N.Tw = function (b, c) {
        H.a.m.zg(b);
        b.text = H.b.V.hj(c);
        (c = H.Jh()) && b.setAttribute("nonce", c)
    };
    H.a.N.Ow = function (b, c) {
        H.a.m.pe(b);
        c = c instanceof H.b.u ? c : H.b.u.Ma(c);
        b.href = H.b.u.F(c)
    };
    H.a.N.Ps = function (b, c) {
        H.a.m.pe(b);
        c = c instanceof H.b.u ? c : H.b.u.Ma(c);
        b.assign(H.b.u.F(c))
    };
    H.a.N.lw = function (b, c) {
        H.a.m.pe(b);
        c = c instanceof H.b.u ? c : H.b.u.Ma(c);
        b.replace(H.b.u.F(c))
    };
    H.a.N.Xv = function (b, c, d, e, f) {
        b = b instanceof H.b.u ? b : H.b.u.Ma(b);
        return (c || H.global).open(H.b.u.F(b), d ? H.c.L.F(d) : "", e, f)
    };
    H.a.N.Zv = function (b, c) {
        return H.a.N.parseFromString(b, c, "text/html")
    };
    H.a.N.parseFromString = function (b, c, d) {
        return b.parseFromString(H.b.s.xb(c), d)
    };
    H.a.N.qt = function (b) {
        if (!/^image\/.*/g.test(b.type))throw Error("goog.dom.safe.createImageFromBlob only accepts MIME type image/.*.");
        var c = H.global.URL.createObjectURL(b);
        b = new H.global.Image;
        b.onload = function () {
            H.global.URL.revokeObjectURL(c)
        };
        H.a.N.Yn(b, H.b.hb.Rn(H.c.L.from("Image blob URL."), c));
        return b
    };
    H.c.Nj = !1;
    H.c.Tj = !1;
    H.c.qg = {dg: "\u00a0"};
    H.c.startsWith = H.c.A.startsWith;
    H.c.endsWith = H.c.A.endsWith;
    H.c.Cb = H.c.A.Cb;
    H.c.Gg = H.c.A.Gg;
    H.c.Hg = H.c.A.Hg;
    H.c.jx = function (b, c) {
        for (var d = b.split("%s"), e = "", f = Array.prototype.slice.call(arguments, 1); f.length && 1 < d.length;)e += d.shift() + f.shift();
        return e + d.join("%s")
    };
    H.c.ct = function (b) {
        return b.replace(/[\s\xa0]+/g, " ").replace(/^\s+|\s+$/g, "")
    };
    H.c.Ic = H.c.A.Ic;
    H.c.fv = function (b) {
        return 0 == b.length
    };
    H.c.za = H.c.Ic;
    H.c.zm = function (b) {
        return H.c.Ic(H.c.en(b))
    };
    H.c.ev = H.c.zm;
    H.c.$u = function (b) {
        return !/[^\t\n\r ]/.test(b)
    };
    H.c.Xu = function (b) {
        return !/[^a-zA-Z]/.test(b)
    };
    H.c.rv = function (b) {
        return !/[^0-9]/.test(b)
    };
    H.c.Yu = function (b) {
        return !/[^a-zA-Z0-9]/.test(b)
    };
    H.c.yv = function (b) {
        return " " == b
    };
    H.c.zv = function (b) {
        return 1 == b.length && " " <= b && "~" >= b || "\u0080" <= b && "\ufffd" >= b
    };
    H.c.hx = function (b) {
        return b.replace(/(\r\n|\r|\n)+/g, " ")
    };
    H.c.kl = function (b) {
        return b.replace(/(\r\n|\r|\n)/g, "\n")
    };
    H.c.Tv = function (b) {
        return b.replace(/\xa0|\s/g, " ")
    };
    H.c.Sv = function (b) {
        return b.replace(/\xa0|[ \t]+/g, " ")
    };
    H.c.bt = function (b) {
        return b.replace(/[\t\r\n ]+/g, " ").replace(/^[\t\r\n ]+|[\t\r\n ]+$/g, "")
    };
    H.c.trim = H.c.A.trim;
    H.c.trimLeft = function (b) {
        return b.replace(/^[\s\xa0]+/, "")
    };
    H.c.trimRight = function (b) {
        return b.replace(/[\s\xa0]+$/, "")
    };
    H.c.ad = H.c.A.ad;
    H.c.Fi = function (b, c, d) {
        if (b == c)return 0;
        if (!b)return -1;
        if (!c)return 1;
        for (var e = b.toLowerCase().match(d), f = c.toLowerCase().match(d), g = Math.min(e.length, f.length), h = 0; h < g; h++) {
            d = e[h];
            var k = f[h];
            if (d != k)return b = parseInt(d, 10), !isNaN(b) && (c = parseInt(k, 10), !isNaN(c) && b - c) ? b - c : d < k ? -1 : 1
        }
        return e.length != f.length ? e.length - f.length : b < c ? -1 : 1
    };
    H.c.Vu = function (b, c) {
        return H.c.Fi(b, c, /\d+|\D+/g)
    };
    H.c.Pl = function (b, c) {
        return H.c.Fi(b, c, /\d+|\.\d+|\D+/g)
    };
    H.c.Vv = H.c.Pl;
    H.c.Nc = function (b) {
        return encodeURIComponent(String(b))
    };
    H.c.Ud = function (b) {
        return decodeURIComponent(b.replace(/\+/g, " "))
    };
    H.c.Kc = H.c.A.Kc;
    H.c.Da = function (b, c) {
        b = H.c.A.Da(b, c);
        H.c.Nj && (b = b.replace(H.c.Rj, "&#101;"));
        return b
    };
    H.c.Rj = /e/g;
    H.c.fj = function (b) {
        return H.c.contains(b, "&") ? !H.c.Tj && "document" in H.global ? H.c.gj(b) : H.c.yo(b) : b
    };
    H.c.ux = function (b, c) {
        return H.c.contains(b, "&") ? H.c.gj(b, c) : b
    };
    H.c.gj = function (b, c) {
        var d = {"&amp;": "&", "&lt;": "<", "&gt;": ">", "&quot;": '"'};
        var e = c ? c.createElement("div") : H.global.document.createElement("div");
        return b.replace(H.c.Yj, function (f, g) {
            var h = d[f];
            if (h)return h;
            "#" == g.charAt(0) && (g = Number("0" + g.substr(1)), isNaN(g) || (h = String.fromCharCode(g)));
            h || (H.a.N.rf(e, H.b.hb.Li(H.c.L.from("Single HTML entity."), f + " ")), h = e.firstChild.nodeValue.slice(0, -1));
            return d[f] = h
        })
    };
    H.c.yo = function (b) {
        return b.replace(/&([^;]+);/g, function (c, d) {
            switch (d) {
                case "amp":
                    return "&";
                case "lt":
                    return "<";
                case "gt":
                    return ">";
                case "quot":
                    return '"';
                default:
                    return "#" != d.charAt(0) || (d = Number("0" + d.substr(1)), isNaN(d)) ? c : String.fromCharCode(d)
            }
        })
    };
    H.c.Yj = /&([^;\s<&]+);?/g;
    H.c.kj = function (b) {
        return H.c.Kc(b.replace(/  /g, " &#160;"), void 0)
    };
    H.c.aw = function (b) {
        return b.replace(/(^|[\n ]) /g, "$1" + H.c.qg.dg)
    };
    H.c.ix = function (b, c) {
        for (var d = c.length, e = 0; e < d; e++) {
            var f = 1 == d ? c : c.charAt(e);
            if (b.charAt(0) == f && b.charAt(b.length - 1) == f)return b.substring(1, b.length - 1)
        }
        return b
    };
    H.c.truncate = function (b, c, d) {
        d && (b = H.c.fj(b));
        b.length > c && (b = b.substring(0, c - 3) + "...");
        d && (b = H.c.Da(b));
        return b
    };
    H.c.sx = function (b, c, d, e) {
        d && (b = H.c.fj(b));
        e && b.length > c ? (e > c && (e = c), b = b.substring(0, c - e) + "..." + b.substring(b.length - e)) : b.length > c && (e = Math.floor(c / 2), b = b.substring(0, e + c % 2) + "..." + b.substring(b.length - e));
        d && (b = H.c.Da(b));
        return b
    };
    H.c.vf = {
        "\x00": "\\0",
        "\b": "\\b",
        "\f": "\\f",
        "\n": "\\n",
        "\r": "\\r",
        "\t": "\\t",
        "\x0B": "\\x0B",
        '"': '\\"',
        "\\": "\\\\",
        "<": "\\u003C"
    };
    H.c.yd = {"'": "\\'"};
    H.c.quote = function (b) {
        b = String(b);
        for (var c = ['"'], d = 0; d < b.length; d++) {
            var e = b.charAt(d), f = e.charCodeAt(0);
            c[d + 1] = H.c.vf[e] || (31 < f && 127 > f ? e : H.c.Xg(e))
        }
        c.push('"');
        return c.join("")
    };
    H.c.Nt = function (b) {
        for (var c = [], d = 0; d < b.length; d++)c[d] = H.c.Xg(b.charAt(d));
        return c.join("")
    };
    H.c.Xg = function (b) {
        if (b in H.c.yd)return H.c.yd[b];
        if (b in H.c.vf)return H.c.yd[b] = H.c.vf[b];
        var c = b.charCodeAt(0);
        if (31 < c && 127 > c)var d = b; else {
            if (256 > c) {
                if (d = "\\x", 16 > c || 256 < c) d += "0"
            } else d = "\\u", 4096 > c && (d += "0");
            d += c.toString(16).toUpperCase()
        }
        return H.c.yd[b] = d
    };
    H.c.contains = H.c.A.contains;
    H.c.bd = H.c.A.bd;
    H.c.mt = function (b, c) {
        return b && c ? b.split(c).length - 1 : 0
    };
    H.c.gc = z();
    H.c.remove = function (b, c) {
        return b.replace(c, "")
    };
    H.c.fw = function (b, c) {
        c = new RegExp(H.c.kf(c), "g");
        return b.replace(c, "")
    };
    H.c.kw = function (b, c, d) {
        c = new RegExp(H.c.kf(c), "g");
        return b.replace(c, d.replace(/\$/g, "$$$$"))
    };
    H.c.kf = function (b) {
        return String(b).replace(/([-()\[\]{}+?*.$\^|,:#<!\\])/g, "\\$1").replace(/\x08/g, "\\x08")
    };
    H.c.repeat = String.prototype.repeat ? function (b, c) {
        return b.repeat(c)
    } : function (b, c) {
        return Array(c + 1).join(b)
    };
    H.c.Yv = function (b, c, d) {
        b = void 0 !== d ? b.toFixed(d) : String(b);
        d = b.indexOf(".");
        -1 == d && (d = b.length);
        return H.c.repeat("0", Math.max(0, c - d)) + b
    };
    H.c.en = function (b) {
        return null == b ? "" : String(b)
    };
    H.c.gl = function (b) {
        return Array.prototype.join.call(arguments, "")
    };
    H.c.Gh = function () {
        return Math.floor(2147483648 * Math.random()).toString(36) + Math.abs(Math.floor(2147483648 * Math.random()) ^ H.now()).toString(36)
    };
    H.c.Eb = H.c.A.Eb;
    H.c.Ou = function (b) {
        for (var c = 0, d = 0; d < b.length; ++d)c = 31 * c + b.charCodeAt(d) >>> 0;
        return c
    };
    H.c.zo = 2147483648 * Math.random() | 0;
    H.c.xt = function () {
        return "goog_" + H.c.zo++
    };
    H.c.ox = function (b) {
        var c = Number(b);
        return 0 == c && H.c.Ic(b) ? NaN : c
    };
    H.c.lv = function (b) {
        return /^[a-z]+([A-Z][a-z]*)*$/.test(b)
    };
    H.c.Av = function (b) {
        return /^([A-Z][a-z]*)+$/.test(b)
    };
    H.c.nx = function (b) {
        return String(b).replace(/\-([a-z])/g, function (c, d) {
            return d.toUpperCase()
        })
    };
    H.c.px = function (b) {
        return String(b).replace(/([A-Z])/g, "-$1").toLowerCase()
    };
    H.c.qx = function (b, c) {
        c = typeof c === x ? H.c.kf(c) : "\\s";
        return b.replace(new RegExp("(^" + (c ? "|[" + c + "]+" : "") + ")([a-z])", "g"), function (d, e, f) {
            return e + f.toUpperCase()
        })
    };
    H.c.Ys = function (b) {
        return String(b.charAt(0)).toUpperCase() + String(b.substr(1)).toLowerCase()
    };
    H.c.parseInt = function (b) {
        isFinite(b) && (b = String(b));
        return typeof b === x ? /^\s*-?0x/i.test(b) ? parseInt(b, 16) : parseInt(b, 10) : NaN
    };
    H.c.bx = function (b, c, d) {
        b = b.split(c);
        for (var e = []; 0 < d && b.length;)e.push(b.shift()), d--;
        b.length && e.push(b.join(c));
        return e
    };
    H.c.Dv = function (b, c) {
        if (c) typeof c == x && (c = [c]); else return b;
        for (var d = -1, e = 0; e < c.length; e++)if ("" != c[e]) {
            var f = b.lastIndexOf(c[e]);
            f > d && (d = f)
        }
        return -1 == d ? b : b.slice(d + 1)
    };
    H.c.Gt = function (b, c) {
        var d = [], e = [];
        if (b == c)return 0;
        if (!b.length || !c.length)return Math.max(b.length, c.length);
        for (var f = 0; f < c.length + 1; f++)d[f] = f;
        for (f = 0; f < b.length; f++) {
            e[0] = f + 1;
            for (var g = 0; g < c.length; g++)e[g + 1] = Math.min(e[g] + 1, d[g + 1] + 1, d[g] + Number(b[f] != c[g]));
            for (g = 0; g < d.length; g++)d[g] = e[g]
        }
        return e[c.length]
    };
    H.h.userAgent.ca = {};
    H.h.userAgent.ca.Jm = function () {
        return H.h.userAgent.G.S("Presto")
    };
    H.h.userAgent.ca.Nm = function () {
        return H.h.userAgent.G.S("Trident") || H.h.userAgent.G.S("MSIE")
    };
    H.h.userAgent.ca.vb = function () {
        return H.h.userAgent.G.S("Edge")
    };
    H.h.userAgent.ca.oi = function () {
        return H.h.userAgent.G.ef("WebKit") && !H.h.userAgent.ca.vb()
    };
    H.h.userAgent.ca.Bm = function () {
        return H.h.userAgent.G.S("Gecko") && !H.h.userAgent.ca.oi() && !H.h.userAgent.ca.Nm() && !H.h.userAgent.ca.vb()
    };
    H.h.userAgent.ca.Ec = function () {
        var b = H.h.userAgent.G.Zb();
        if (b) {
            b = H.h.userAgent.G.$g(b);
            var c = H.h.userAgent.ca.Yl(b);
            if (c)return "Gecko" == c[0] ? H.h.userAgent.ca.lm(b) : c[1];
            b = b[0];
            var d;
            if (b && (d = b[2]) && (d = /Trident\/([^\s;]+)/.exec(d)))return d[1]
        }
        return ""
    };
    H.h.userAgent.ca.Yl = function (b) {
        if (!H.h.userAgent.ca.vb())return b[1];
        for (var c = 0; c < b.length; c++) {
            var d = b[c];
            if ("Edge" == d[0])return d
        }
    };
    H.h.userAgent.ca.Ta = function (b) {
        return 0 <= H.c.Eb(H.h.userAgent.ca.Ec(), b)
    };
    H.h.userAgent.ca.lm = function (b) {
        return (b = H.g.find(b, function (c) {
                return "Firefox" == c[0]
            })) && b[1] || ""
    };
    H.h.userAgent.platform = {};
    H.h.userAgent.platform.Yh = function () {
        return H.h.userAgent.G.S("Android")
    };
    H.h.userAgent.platform.hi = function () {
        return H.h.userAgent.G.S("iPod")
    };
    H.h.userAgent.platform.gi = function () {
        return H.h.userAgent.G.S("iPhone") && !H.h.userAgent.G.S("iPod") && !H.h.userAgent.G.S("iPad")
    };
    H.h.userAgent.platform.fi = function () {
        return H.h.userAgent.G.S("iPad")
    };
    H.h.userAgent.platform.ei = function () {
        return H.h.userAgent.platform.gi() || H.h.userAgent.platform.fi() || H.h.userAgent.platform.hi()
    };
    H.h.userAgent.platform.ji = function () {
        return H.h.userAgent.G.S("Macintosh")
    };
    H.h.userAgent.platform.Gm = function () {
        return H.h.userAgent.G.S("Linux")
    };
    H.h.userAgent.platform.si = function () {
        return H.h.userAgent.G.S("Windows")
    };
    H.h.userAgent.platform.$h = function () {
        return H.h.userAgent.G.S("CrOS")
    };
    H.h.userAgent.platform.av = function () {
        return H.h.userAgent.G.S("CrKey")
    };
    H.h.userAgent.platform.ii = function () {
        return H.h.userAgent.G.ef("KaiOS")
    };
    H.h.userAgent.platform.Cm = function () {
        return H.h.userAgent.G.ef("GAFP")
    };
    H.h.userAgent.platform.Ec = function () {
        var b = H.h.userAgent.G.Zb(), c = "";
        H.h.userAgent.platform.si() ? (c = /Windows (?:NT|Phone) ([0-9.]+)/, c = (b = c.exec(b)) ? b[1] : "0.0") : H.h.userAgent.platform.ei() ? (c = /(?:iPhone|iPod|iPad|CPU)\s+OS\s+(\S+)/, c = (b = c.exec(b)) && b[1].replace(/_/g, ".")) : H.h.userAgent.platform.ji() ? (c = /Mac OS X ([0-9_.]+)/, c = (b = c.exec(b)) ? b[1].replace(/_/g, ".") : "10") : H.h.userAgent.platform.ii() ? (c = /(?:KaiOS)\/(\S+)/i, c = (b = c.exec(b)) && b[1]) : H.h.userAgent.platform.Yh() ? (c = /Android\s+([^\);]+)(\)|;)/,
            c = (b = c.exec(b)) && b[1]) : H.h.userAgent.platform.$h() && (c = /(?:CrOS\s+(?:i686|x86_64)\s+([0-9.]+))/, c = (b = c.exec(b)) && b[1]);
        return c || ""
    };
    H.h.userAgent.platform.Ta = function (b) {
        return 0 <= H.c.Eb(H.h.userAgent.platform.Ec(), b)
    };
    H.fb = {};
    H.fb.object = function (b, c) {
        return c
    };
    H.fb.uf = function (b) {
        H.fb.uf[" "](b);
        return b
    };
    H.fb.uf[" "] = H.Lb;
    H.fb.Ws = function (b, c) {
        try {
            return H.fb.uf(b[c]), !0
        } catch (d) {
        }
        return !1
    };
    H.fb.cache = function (b, c, d, e) {
        e = e ? e(c) : c;
        return Object.prototype.hasOwnProperty.call(b, e) ? b[e] : b[e] = d(c)
    };
    H.userAgent = {};
    H.userAgent.If = !1;
    H.userAgent.Gf = !1;
    H.userAgent.Hf = !1;
    H.userAgent.Nf = !1;
    H.userAgent.$d = !1;
    H.userAgent.Lf = !1;
    H.userAgent.sj = !1;
    H.userAgent.lc = H.userAgent.If || H.userAgent.Gf || H.userAgent.Hf || H.userAgent.$d || H.userAgent.Nf || H.userAgent.Lf;
    H.userAgent.jm = function () {
        return H.h.userAgent.G.Zb()
    };
    H.userAgent.Pe = function () {
        return H.global.navigator || null
    };
    H.userAgent.vu = function () {
        return H.userAgent.Pe()
    };
    H.userAgent.gg = H.userAgent.lc ? H.userAgent.Lf : H.h.userAgent.B.Ze();
    H.userAgent.ma = H.userAgent.lc ? H.userAgent.If : H.h.userAgent.B.xd();
    H.userAgent.Uf = H.userAgent.lc ? H.userAgent.Gf : H.h.userAgent.ca.vb();
    H.userAgent.Np = H.userAgent.Uf || H.userAgent.ma;
    H.userAgent.be = H.userAgent.lc ? H.userAgent.Hf : H.h.userAgent.ca.Bm();
    H.userAgent.pc = H.userAgent.lc ? H.userAgent.Nf || H.userAgent.$d : H.h.userAgent.ca.oi();
    H.userAgent.Im = function () {
        return H.userAgent.pc && H.h.userAgent.G.S("Mobile")
    };
    H.userAgent.Xq = H.userAgent.$d || H.userAgent.Im();
    H.userAgent.yr = H.userAgent.pc;
    H.userAgent.zl = function () {
        var b = H.userAgent.Pe();
        return b && b.platform || ""
    };
    H.userAgent.nr = H.userAgent.zl();
    H.userAgent.Kf = !1;
    H.userAgent.Of = !1;
    H.userAgent.Jf = !1;
    H.userAgent.Pf = !1;
    H.userAgent.Ff = !1;
    H.userAgent.Yd = !1;
    H.userAgent.Xd = !1;
    H.userAgent.Zd = !1;
    H.userAgent.vj = !1;
    H.userAgent.uj = !1;
    H.userAgent.Na = H.userAgent.Kf || H.userAgent.Of || H.userAgent.Jf || H.userAgent.Pf || H.userAgent.Ff || H.userAgent.Yd || H.userAgent.Xd || H.userAgent.Zd;
    H.userAgent.Oq = H.userAgent.Na ? H.userAgent.Kf : H.h.userAgent.platform.ji();
    H.userAgent.os = H.userAgent.Na ? H.userAgent.Of : H.h.userAgent.platform.si();
    H.userAgent.Fm = function () {
        return H.h.userAgent.platform.Gm() || H.h.userAgent.platform.$h()
    };
    H.userAgent.Mq = H.userAgent.Na ? H.userAgent.Jf : H.userAgent.Fm();
    H.userAgent.Rm = function () {
        var b = H.userAgent.Pe();
        return !!b && H.c.contains(b.appVersion || "", "X11")
    };
    H.userAgent.ps = H.userAgent.Na ? H.userAgent.Pf : H.userAgent.Rm();
    H.userAgent.To = H.userAgent.Na ? H.userAgent.Ff : H.h.userAgent.platform.Yh();
    H.userAgent.Aq = H.userAgent.Na ? H.userAgent.Yd : H.h.userAgent.platform.gi();
    H.userAgent.zq = H.userAgent.Na ? H.userAgent.Xd : H.h.userAgent.platform.fi();
    H.userAgent.Bq = H.userAgent.Na ? H.userAgent.Zd : H.h.userAgent.platform.hi();
    H.userAgent.yq = H.userAgent.Na ? H.userAgent.Yd || H.userAgent.Xd || H.userAgent.Zd : H.h.userAgent.platform.ei();
    H.userAgent.Eq = H.userAgent.Na ? H.userAgent.vj : H.h.userAgent.platform.ii();
    H.userAgent.eq = H.userAgent.Na ? H.userAgent.uj : H.h.userAgent.platform.Cm();
    H.userAgent.Al = function () {
        var b = "", c = H.userAgent.mm();
        c && (b = c ? c[1] : "");
        return H.userAgent.ma && (c = H.userAgent.oh(), null != c && c > parseFloat(b)) ? String(c) : b
    };
    H.userAgent.mm = function () {
        var b = H.userAgent.jm();
        if (H.userAgent.be)return /rv:([^\);]+)(\)|;)/.exec(b);
        if (H.userAgent.Uf)return /Edge\/([\d\.]+)/.exec(b);
        if (H.userAgent.ma)return /\b(?:MSIE|rv)[: ]([^\);]+)(\)|;)/.exec(b);
        if (H.userAgent.pc)return /WebKit\/(\S+)/.exec(b);
        if (H.userAgent.gg)return /(?:Version)[ \/]?(\S+)/.exec(b)
    };
    H.userAgent.oh = function () {
        var b = H.global.document;
        return b ? b.documentMode : void 0
    };
    H.userAgent.VERSION = H.userAgent.Al();
    H.userAgent.compare = function (b, c) {
        return H.c.Eb(b, c)
    };
    H.userAgent.Pm = {};
    H.userAgent.Ta = function (b) {
        return H.userAgent.sj || H.fb.cache(H.userAgent.Pm, b, function () {
                return 0 <= H.c.Eb(H.userAgent.VERSION, b)
            })
    };
    H.userAgent.Bv = H.userAgent.Ta;
    H.userAgent.Hc = function (b) {
        return Number(H.userAgent.Qj) >= b
    };
    H.userAgent.dv = H.userAgent.Hc;
    var ha;
    ha = H.global.document && H.userAgent.ma ? H.userAgent.oh() : void 0;
    H.userAgent.Qj = ha;
    H.a.fa = {};
    H.a.fa.xj = !1;
    H.a.fa.yj = !1;
    H.a.fa.yl = function () {
        try {
            return !!(new self.OffscreenCanvas(0, 0)).getContext("2d")
        } catch (b) {
        }
        return !1
    };
    H.a.fa.er = !H.a.fa.xj && (H.a.fa.yj || H.a.fa.yl());
    H.a.fa.Dj = !H.userAgent.ma || H.userAgent.Hc(9);
    H.a.fa.Ej = !H.userAgent.be && !H.userAgent.ma || H.userAgent.ma && H.userAgent.Hc(9) || H.userAgent.be && H.userAgent.Ta("1.9.1");
    H.a.fa.Rf = H.userAgent.ma && !H.userAgent.Ta("9");
    H.a.fa.Fj = H.userAgent.ma || H.userAgent.gg || H.userAgent.pc;
    H.a.fa.Zj = H.userAgent.ma;
    H.a.fa.Iq = H.userAgent.ma && !H.userAgent.Hc(9);
    H.C = {};
    H.C.cw = function (b) {
        return Math.floor(Math.random() * b)
    };
    H.C.vx = function (b, c) {
        return b + Math.random() * (c - b)
    };
    H.C.$s = function (b, c, d) {
        return Math.min(Math.max(b, c), d)
    };
    H.C.Di = function (b, c) {
        b %= c;
        return 0 > b * c ? b + c : b
    };
    H.C.Ev = function (b, c, d) {
        return b + d * (c - b)
    };
    H.C.Pv = function (b, c, d) {
        return Math.abs(b - c) <= (d || 1E-6)
    };
    H.C.xf = function (b) {
        return H.C.Di(b, 360)
    };
    H.C.ex = function (b) {
        return H.C.Di(b, 2 * Math.PI)
    };
    H.C.ej = function (b) {
        return b * Math.PI / 180
    };
    H.C.po = function (b) {
        return 180 * b / Math.PI
    };
    H.C.vs = function (b, c) {
        return c * Math.cos(H.C.ej(b))
    };
    H.C.ws = function (b, c) {
        return c * Math.sin(H.C.ej(b))
    };
    H.C.angle = function (b, c, d, e) {
        return H.C.xf(H.C.po(Math.atan2(e - c, d - b)))
    };
    H.C.us = function (b, c) {
        b = H.C.xf(c) - H.C.xf(b);
        180 < b ? b -= 360 : -180 >= b && (b = 360 + b);
        return b
    };
    H.C.sign = function (b) {
        return 0 < b ? 1 : 0 > b ? -1 : b
    };
    H.C.Iv = function (b, c, d, e) {
        d = d || function (t, y) {
                return t == y
            };
        e = e || function (t) {
                return b[t]
            };
        for (var f = b.length, g = c.length, h = [], k = 0; k < f + 1; k++)h[k] = [], h[k][0] = 0;
        for (var m = 0; m < g + 1; m++)h[0][m] = 0;
        for (k = 1; k <= f; k++)for (m = 1; m <= g; m++)d(b[k - 1], c[m - 1]) ? h[k][m] = h[k - 1][m - 1] + 1 : h[k][m] = Math.max(h[k - 1][m], h[k][m - 1]);
        var n = [];
        k = f;
        for (m = g; 0 < k && 0 < m;)d(b[k - 1], c[m - 1]) ? (n.unshift(e(k - 1, m - 1)), k--, m--) : h[k - 1][m] > h[k][m - 1] ? k-- : m--;
        return n
    };
    H.C.zf = function (b) {
        return H.g.reduce(arguments, function (c, d) {
            return c + d
        }, 0)
    };
    H.C.$k = function (b) {
        return H.C.zf.apply(null, arguments) / arguments.length
    };
    H.C.Sn = function (b) {
        var c = arguments.length;
        if (2 > c)return 0;
        var d = H.C.$k.apply(null, arguments);
        return H.C.zf.apply(null, H.g.map(arguments, function (e) {
                return Math.pow(e - d, 2)
            })) / (c - 1)
    };
    H.C.fx = function (b) {
        return Math.sqrt(H.C.Sn.apply(null, arguments))
    };
    H.C.jv = function (b) {
        return isFinite(b) && 0 == b % 1
    };
    H.C.gv = function (b) {
        return isFinite(b)
    };
    H.C.ov = function (b) {
        return 0 == b && 0 > 1 / b
    };
    H.C.Hv = function (b) {
        if (0 < b) {
            var c = Math.round(Math.log(b) * Math.LOG10E);
            return c - (parseFloat("1e" + c) > b ? 1 : 0)
        }
        return 0 == b ? -Infinity : NaN
    };
    H.C.rw = function (b, c) {
        return Math.floor(b + (c || 2E-15))
    };
    H.C.qw = function (b, c) {
        return Math.ceil(b - (c || 2E-15))
    };
    H.C.ga = function (b, c) {
        this.x = void 0 !== b ? b : 0;
        this.y = void 0 !== c ? c : 0
    };
    H.C.ga.prototype.clone = function () {
        return new H.C.ga(this.x, this.y)
    };
    H.la && (H.C.ga.prototype.toString = function () {
        return "(" + this.x + ", " + this.y + ")"
    });
    H.C.ga.prototype.Ib = function (b) {
        return b instanceof H.C.ga && H.C.ga.Ib(this, b)
    };
    H.C.ga.Ib = function (b, c) {
        return b == c ? !0 : b && c ? b.x == c.x && b.y == c.y : !1
    };
    H.C.ga.Et = function (b, c) {
        var d = b.x - c.x;
        b = b.y - c.y;
        return Math.sqrt(d * d + b * b)
    };
    H.C.ga.Jv = function (b) {
        return Math.sqrt(b.x * b.x + b.y * b.y)
    };
    H.C.ga.azimuth = function (b) {
        return H.C.angle(0, 0, b.x, b.y)
    };
    H.C.ga.cx = function (b, c) {
        var d = b.x - c.x;
        b = b.y - c.y;
        return d * d + b * b
    };
    H.C.ga.Dt = function (b, c) {
        return new H.C.ga(b.x - c.x, b.y - c.y)
    };
    H.C.ga.zf = function (b, c) {
        return new H.C.ga(b.x + c.x, b.y + c.y)
    };
    F = H.C.ga.prototype;
    F.ceil = function () {
        this.x = Math.ceil(this.x);
        this.y = Math.ceil(this.y);
        return this
    };
    F.floor = function () {
        this.x = Math.floor(this.x);
        this.y = Math.floor(this.y);
        return this
    };
    F.round = function () {
        this.x = Math.round(this.x);
        this.y = Math.round(this.y);
        return this
    };
    F.translate = function (b, c) {
        b instanceof H.C.ga ? (this.x += b.x, this.y += b.y) : (this.x += Number(b), typeof c === r && (this.y += c));
        return this
    };
    F.scale = function (b, c) {
        this.x *= b;
        this.y *= typeof c === r ? c : b;
        return this
    };
    H.C.Ub = function (b, c) {
        this.width = b;
        this.height = c
    };
    H.C.Ub.Ib = function (b, c) {
        return b == c ? !0 : b && c ? b.width == c.width && b.height == c.height : !1
    };
    H.C.Ub.prototype.clone = function () {
        return new H.C.Ub(this.width, this.height)
    };
    H.la && (H.C.Ub.prototype.toString = function () {
        return "(" + this.width + " x " + this.height + ")"
    });
    F = H.C.Ub.prototype;
    F.aspectRatio = function () {
        return this.width / this.height
    };
    F.za = function () {
        return !(this.width * this.height)
    };
    F.ceil = function () {
        this.width = Math.ceil(this.width);
        this.height = Math.ceil(this.height);
        return this
    };
    F.floor = function () {
        this.width = Math.floor(this.width);
        this.height = Math.floor(this.height);
        return this
    };
    F.round = function () {
        this.width = Math.round(this.width);
        this.height = Math.round(this.height);
        return this
    };
    F.scale = function (b, c) {
        this.width *= b;
        this.height *= typeof c === r ? c : b;
        return this
    };
    H.a.zj = !1;
    H.a.Mf = !1;
    H.a.Jj = H.a.zj || H.a.Mf;
    H.a.Je = function (b) {
        return b ? new H.a.Qb(H.a.tb(b)) : H.a.wl || (H.a.wl = new H.a.Qb)
    };
    H.a.Tl = function () {
        return document
    };
    H.a.Ke = function (b) {
        return H.a.Ne(document, b)
    };
    H.a.Ne = function (b, c) {
        return typeof c === x ? b.getElementById(c) : c
    };
    H.a.dm = function (b) {
        return H.a.Ih(document, b)
    };
    H.a.Ih = function (b, c) {
        return H.a.Ne(b, c)
    };
    H.a.nj = H.a.Ke;
    H.a.getElementsByTagName = function (b, c) {
        return (c || document).getElementsByTagName(String(b))
    };
    H.a.Oe = function (b, c, d) {
        return H.a.md(document, b, c, d)
    };
    H.a.Xl = function (b, c, d) {
        return H.a.Me(document, b, c, d)
    };
    H.a.rh = function (b, c) {
        var d = c || document;
        return H.a.se(d) ? d.querySelectorAll("." + b) : H.a.md(document, "*", b, c)
    };
    H.a.Le = function (b, c) {
        var d = c || document;
        return (d.getElementsByClassName ? d.getElementsByClassName(b)[0] : H.a.Me(document, "*", b, c)) || null
    };
    H.a.Hh = function (b, c) {
        return H.a.Le(b, c)
    };
    H.a.se = function (b) {
        return !(!b.querySelectorAll || !b.querySelector)
    };
    H.a.md = function (b, c, d, e) {
        b = e || b;
        c = c && "*" != c ? String(c).toUpperCase() : "";
        if (H.a.se(b) && (c || d))return b.querySelectorAll(c + (d ? "." + d : ""));
        if (d && b.getElementsByClassName) {
            b = b.getElementsByClassName(d);
            if (c) {
                e = {};
                for (var f = 0, g = 0, h; h = b[g]; g++)c == h.nodeName && (e[f++] = h);
                e.length = f;
                return e
            }
            return b
        }
        b = b.getElementsByTagName(c || "*");
        if (d) {
            e = {};
            for (g = f = 0; h = b[g]; g++)c = h.className, typeof c.split == q && H.g.contains(c.split(/\s+/), d) && (e[f++] = h);
            e.length = f;
            return e
        }
        return b
    };
    H.a.Me = function (b, c, d, e) {
        var f = e || b, g = c && "*" != c ? String(c).toUpperCase() : "";
        return H.a.se(f) && (g || d) ? f.querySelector(g + (d ? "." + d : "")) : H.a.md(b, c, d, e)[0] || null
    };
    H.a.oj = H.a.Oe;
    H.a.Qd = function (b, c) {
        H.object.forEach(c, function (d, e) {
            d && typeof d == u && d.Ra && (d = d.Ca());
            "style" == e ? b.style.cssText = d : "class" == e ? b.className = d : "for" == e ? b.htmlFor = d : H.a.Tf.hasOwnProperty(e) ? b.setAttribute(H.a.Tf[e], d) : H.c.startsWith(e, "aria-") || H.c.startsWith(e, "data-") ? b.setAttribute(e, d) : b[e] = d
        })
    };
    H.a.Tf = {
        cellpadding: "cellPadding",
        cellspacing: "cellSpacing",
        colspan: "colSpan",
        frameborder: "frameBorder",
        height: "height",
        maxlength: "maxLength",
        nonce: "nonce",
        role: "role",
        rowspan: "rowSpan",
        type: "type",
        usemap: "useMap",
        valign: "vAlign",
        width: "width"
    };
    H.a.Nh = function (b) {
        return H.a.Oh(b || window)
    };
    H.a.Oh = function (b) {
        b = b.document;
        b = H.a.Gc(b) ? b.documentElement : b.body;
        return new H.C.Ub(b.clientWidth, b.clientHeight)
    };
    H.a.Ul = function () {
        return H.a.He(window)
    };
    H.a.ou = function (b) {
        return H.a.He(b)
    };
    H.a.He = function (b) {
        var c = b.document, d = 0;
        if (c) {
            d = c.body;
            var e = c.documentElement;
            if (!e || !d)return 0;
            b = H.a.Oh(b).height;
            if (H.a.Gc(c) && e.scrollHeight) d = e.scrollHeight != b ? e.scrollHeight : e.offsetHeight; else {
                c = e.scrollHeight;
                var f = e.offsetHeight;
                e.clientHeight != f && (c = d.scrollHeight, f = d.offsetHeight);
                d = c > b ? c > f ? c : f : c < f ? c : f
            }
        }
        return d
    };
    H.a.xu = function (b) {
        return H.a.Je((b || H.global || window).document).ph()
    };
    H.a.ph = function () {
        return H.a.qh(document)
    };
    H.a.qh = function (b) {
        var c = H.a.Ie(b);
        b = H.a.ac(b);
        return H.userAgent.ma && H.userAgent.Ta("10") && b.pageYOffset != c.scrollTop ? new H.C.ga(c.scrollLeft, c.scrollTop) : new H.C.ga(b.pageXOffset || c.scrollLeft, b.pageYOffset || c.scrollTop)
    };
    H.a.Vl = function () {
        return H.a.Ie(document)
    };
    H.a.Ie = function (b) {
        return b.scrollingElement ? b.scrollingElement : !H.userAgent.pc && H.a.Gc(b) ? b.documentElement : b.body || b.documentElement
    };
    H.a.$b = function (b) {
        return b ? H.a.ac(b) : window
    };
    H.a.ac = function (b) {
        return b.parentWindow || b.defaultView
    };
    H.a.ve = function (b, c, d) {
        return H.a.Pg(document, arguments)
    };
    H.a.Pg = function (b, c) {
        var d = String(c[0]), e = c[1];
        if (!H.a.fa.Dj && e && (e.name || e.type)) {
            d = ["<", d];
            e.name && d.push(' name="', H.c.Da(e.name), '"');
            if (e.type) {
                d.push(' type="', H.c.Da(e.type), '"');
                var f = {};
                H.object.extend(f, e);
                delete f.type;
                e = f
            }
            d.push(">");
            d = d.join("")
        }
        d = H.a.cb(b, d);
        e && (typeof e === x ? d.className = e : H.isArray(e) ? d.className = e.join(" ") : H.a.Qd(d, e));
        2 < c.length && H.a.vg(b, d, c, 2);
        return d
    };
    H.a.vg = function (b, c, d, e) {
        function f(h) {
            h && c.appendChild(typeof h === x ? b.createTextNode(h) : h)
        }

        for (; e < d.length; e++) {
            var g = d[e];
            H.ka(g) && !H.a.Xe(g) ? H.g.forEach(H.a.Ye(g) ? H.g.gb(g) : g, f) : f(g)
        }
    };
    H.a.pj = H.a.ve;
    H.a.createElement = function (b) {
        return H.a.cb(document, b)
    };
    H.a.cb = function (b, c) {
        c = String(c);
        "application/xhtml+xml" === b.contentType && (c = c.toLowerCase());
        return b.createElement(c)
    };
    H.a.createTextNode = function (b) {
        return document.createTextNode(String(b))
    };
    H.a.tl = function (b, c, d) {
        return H.a.Qg(document, b, c, !!d)
    };
    H.a.Qg = function (b, c, d, e) {
        for (var f = H.a.cb(b, "TABLE"), g = f.appendChild(H.a.cb(b, "TBODY")), h = 0; h < c; h++) {
            for (var k = H.a.cb(b, "TR"), m = 0; m < d; m++) {
                var n = H.a.cb(b, "TD");
                e && H.a.sf(n, H.c.qg.dg);
                k.appendChild(n)
            }
            g.appendChild(k)
        }
        return f
    };
    H.a.kt = function (b) {
        var c = H.g.map(arguments, H.c.L.F);
        c = H.b.hb.Li(H.c.L.from("Constant HTML string, that gets turned into a Node later, so it will be automatically balanced."), c.join(""));
        return H.a.Mi(c)
    };
    H.a.Mi = function (b) {
        return H.a.Ni(document, b)
    };
    H.a.Ni = function (b, c) {
        var d = H.a.cb(b, "DIV");
        H.a.fa.Zj ? (H.a.N.rf(d, H.b.s.concat(H.b.s.Qf, c)), d.removeChild(d.firstChild)) : H.a.N.rf(d, c);
        return H.a.nl(b, d)
    };
    H.a.nl = function (b, c) {
        if (1 == c.childNodes.length)return c.removeChild(c.firstChild);
        for (b = b.createDocumentFragment(); c.firstChild;)b.appendChild(c.firstChild);
        return b
    };
    H.a.xm = function () {
        return H.a.Gc(document)
    };
    H.a.Gc = function (b) {
        return H.a.Jj ? H.a.Mf : "CSS1Compat" == b.compatMode
    };
    H.a.canHaveChildren = function (b) {
        if (b.nodeType != H.a.ra.jb)return !1;
        switch (b.tagName) {
            case "APPLET":
            case "AREA":
            case "BASE":
            case "BR":
            case "COL":
            case "COMMAND":
            case "EMBED":
            case "FRAME":
            case "HR":
            case "IMG":
            case "INPUT":
            case "IFRAME":
            case "ISINDEX":
            case "KEYGEN":
            case "LINK":
            case "NOFRAMES":
            case "NOSCRIPT":
            case "META":
            case "OBJECT":
            case "PARAM":
            case l:
            case "SOURCE":
            case "STYLE":
            case "TRACK":
            case "WBR":
                return !1
        }
        return !0
    };
    H.a.appendChild = function (b, c) {
        b.appendChild(c)
    };
    H.a.append = function (b, c) {
        H.a.vg(H.a.tb(b), b, arguments, 1)
    };
    H.a.mf = function (b) {
        for (var c; c = b.firstChild;)b.removeChild(c)
    };
    H.a.Wh = function (b, c) {
        c.parentNode && c.parentNode.insertBefore(b, c)
    };
    H.a.Vh = function (b, c) {
        c.parentNode && c.parentNode.insertBefore(b, c.nextSibling)
    };
    H.a.Uh = function (b, c, d) {
        b.insertBefore(c, b.childNodes[d] || null)
    };
    H.a.removeNode = function (b) {
        return b && b.parentNode ? b.parentNode.removeChild(b) : null
    };
    H.a.Ki = function (b, c) {
        var d = c.parentNode;
        d && d.replaceChild(b, c)
    };
    H.a.fh = function (b) {
        var c, d = b.parentNode;
        if (d && d.nodeType != H.a.ra.Pj) {
            if (b.removeNode)return b.removeNode(!1);
            for (; c = b.firstChild;)d.insertBefore(c, b);
            return H.a.removeNode(b)
        }
    };
    H.a.mh = function (b) {
        return H.a.fa.Ej && void 0 != b.children ? b.children : H.g.filter(b.childNodes, function (c) {
            return c.nodeType == H.a.ra.jb
        })
    };
    H.a.sh = function (b) {
        return void 0 !== b.firstElementChild ? b.firstElementChild : H.a.od(b.firstChild, !0)
    };
    H.a.vh = function (b) {
        return void 0 !== b.lastElementChild ? b.lastElementChild : H.a.od(b.lastChild, !1)
    };
    H.a.xh = function (b) {
        return void 0 !== b.nextElementSibling ? b.nextElementSibling : H.a.od(b.nextSibling, !0)
    };
    H.a.Eh = function (b) {
        return void 0 !== b.previousElementSibling ? b.previousElementSibling : H.a.od(b.previousSibling, !1)
    };
    H.a.od = function (b, c) {
        for (; b && b.nodeType != H.a.ra.jb;)b = c ? b.nextSibling : b.previousSibling;
        return b
    };
    H.a.yh = function (b) {
        if (!b)return null;
        if (b.firstChild)return b.firstChild;
        for (; b && !b.nextSibling;)b = b.parentNode;
        return b ? b.nextSibling : null
    };
    H.a.Fh = function (b) {
        if (!b)return null;
        if (!b.previousSibling)return b.parentNode;
        for (b = b.previousSibling; b && b.lastChild;)b = b.lastChild;
        return b
    };
    H.a.Xe = function (b) {
        return H.Ea(b) && 0 < b.nodeType
    };
    H.a.Ve = function (b) {
        return H.Ea(b) && b.nodeType == H.a.ra.jb
    };
    H.a.pi = function (b) {
        return H.Ea(b) && b.window == b
    };
    H.a.Dh = function (b) {
        var c;
        if (H.a.fa.Fj && !(H.userAgent.ma && H.userAgent.Ta("9") && !H.userAgent.Ta("10") && H.global.SVGElement && b instanceof H.global.SVGElement) && (c = b.parentElement))return c;
        c = b.parentNode;
        return H.a.Ve(c) ? c : null
    };
    H.a.contains = function (b, c) {
        if (!b || !c)return !1;
        if (b.contains && c.nodeType == H.a.ra.jb)return b == c || b.contains(c);
        if ("undefined" != typeof b.compareDocumentPosition)return b == c || !!(b.compareDocumentPosition(c) & 16);
        for (; c && b != c;)c = c.parentNode;
        return c == b
    };
    H.a.Jg = function (b, c) {
        if (b == c)return 0;
        if (b.compareDocumentPosition)return b.compareDocumentPosition(c) & 2 ? 1 : -1;
        if (H.userAgent.ma && !H.userAgent.Hc(9)) {
            if (b.nodeType == H.a.ra.Qc)return -1;
            if (c.nodeType == H.a.ra.Qc)return 1
        }
        if ("sourceIndex" in b || b.parentNode && "sourceIndex" in b.parentNode) {
            var d = b.nodeType == H.a.ra.jb, e = c.nodeType == H.a.ra.jb;
            if (d && e)return b.sourceIndex - c.sourceIndex;
            var f = b.parentNode, g = c.parentNode;
            return f == g ? H.a.Lg(b, c) : !d && H.a.contains(f, c) ? -1 * H.a.Kg(b, c) : !e && H.a.contains(g, b) ? H.a.Kg(c,
                b) : (d ? b.sourceIndex : f.sourceIndex) - (e ? c.sourceIndex : g.sourceIndex)
        }
        e = H.a.tb(b);
        d = e.createRange();
        d.selectNode(b);
        d.collapse(!0);
        b = e.createRange();
        b.selectNode(c);
        b.collapse(!0);
        return d.compareBoundaryPoints(H.global.Range.START_TO_END, b)
    };
    H.a.Kg = function (b, c) {
        var d = b.parentNode;
        if (d == c)return -1;
        for (; c.parentNode != d;)c = c.parentNode;
        return H.a.Lg(c, b)
    };
    H.a.Lg = function (b, c) {
        for (; c = c.previousSibling;)if (c == b)return -1;
        return 1
    };
    H.a.ah = function (b) {
        var c, d = arguments.length;
        if (!d)return null;
        if (1 == d)return arguments[0];
        var e = [], f = Infinity;
        for (c = 0; c < d; c++) {
            for (var g = [], h = arguments[c]; h;)g.unshift(h), h = h.parentNode;
            e.push(g);
            f = Math.min(f, g.length)
        }
        g = null;
        for (c = 0; c < f; c++) {
            h = e[0][c];
            for (var k = 1; k < d; k++)if (h != e[k][c])return g;
            g = h
        }
        return g
    };
    H.a.iv = function (b) {
        return 16 == (b.ownerDocument.compareDocumentPosition(b) & 16)
    };
    H.a.tb = function (b) {
        return b.nodeType == H.a.ra.Qc ? b : b.ownerDocument || b.document
    };
    H.a.th = function (b) {
        return b.contentDocument || b.contentWindow.document
    };
    H.a.uh = function (b) {
        try {
            return b.contentWindow || (b.contentDocument ? H.a.$b(b.contentDocument) : null)
        } catch (c) {
        }
        return null
    };
    H.a.sf = function (b, c) {
        if ("textContent" in b) b.textContent = c; else if (b.nodeType == H.a.ra.Wc) b.data = String(c); else if (b.firstChild && b.firstChild.nodeType == H.a.ra.Wc) {
            for (; b.lastChild != b.firstChild;)b.removeChild(b.lastChild);
            b.firstChild.data = String(c)
        } else H.a.mf(b), b.appendChild(H.a.tb(b).createTextNode(String(c)))
    };
    H.a.Ch = function (b) {
        if ("outerHTML" in b)return b.outerHTML;
        var c = H.a.cb(H.a.tb(b), "DIV");
        c.appendChild(b.cloneNode(!0));
        return c.innerHTML
    };
    H.a.bh = function (b, c) {
        var d = [];
        return H.a.Be(b, c, d, !0) ? d[0] : void 0
    };
    H.a.dh = function (b, c) {
        var d = [];
        H.a.Be(b, c, d, !1);
        return d
    };
    H.a.Be = function (b, c, d, e) {
        if (null != b)for (b = b.firstChild; b;) {
            if (c(b) && (d.push(b), e) || H.a.Be(b, c, d, e))return !0;
            b = b.nextSibling
        }
        return !1
    };
    H.a.Qt = function (b, c) {
        for (b = H.a.nh(b); 0 < b.length;) {
            var d = b.pop();
            if (c(d))return d;
            for (d = d.lastElementChild; d; d = d.previousElementSibling)b.push(d)
        }
        return null
    };
    H.a.Rt = function (b, c) {
        var d = [];
        for (b = H.a.nh(b); 0 < b.length;) {
            var e = b.pop();
            c(e) && d.push(e);
            for (e = e.lastElementChild; e; e = e.previousElementSibling)b.push(e)
        }
        return d
    };
    H.a.nh = function (b) {
        if (b.nodeType == H.a.ra.Qc)return [b.documentElement];
        var c = [];
        for (b = b.lastElementChild; b; b = b.previousElementSibling)c.push(b);
        return c
    };
    H.a.ng = {SCRIPT: 1, STYLE: 1, HEAD: 1, IFRAME: 1, OBJECT: 1};
    H.a.Uc = {IMG: " ", BR: "\n"};
    H.a.We = function (b) {
        return H.a.Rh(b) && H.a.ni(b)
    };
    H.a.Ri = function (b, c) {
        c ? b.tabIndex = 0 : (b.tabIndex = -1, b.removeAttribute("tabIndex"))
    };
    H.a.ai = function (b) {
        var c;
        return (c = H.a.mn(b) ? !b.disabled && (!H.a.Rh(b) || H.a.ni(b)) : H.a.We(b)) && H.userAgent.ma ? H.a.rm(b) : c
    };
    H.a.Rh = function (b) {
        return H.userAgent.ma && !H.userAgent.Ta("9") ? (b = b.getAttributeNode("tabindex"), null != b && b.specified) : b.hasAttribute("tabindex")
    };
    H.a.ni = function (b) {
        b = b.tabIndex;
        return typeof b === r && 0 <= b && 32768 > b
    };
    H.a.mn = function (b) {
        return "A" == b.tagName && b.hasAttribute("href") || "INPUT" == b.tagName || "TEXTAREA" == b.tagName || "SELECT" == b.tagName || "BUTTON" == b.tagName
    };
    H.a.rm = function (b) {
        b = !H.Sa(b.getBoundingClientRect) || H.userAgent.ma && null == b.parentElement ? {
            height: b.offsetHeight,
            width: b.offsetWidth
        } : b.getBoundingClientRect();
        return null != b && 0 < b.height && 0 < b.width
    };
    H.a.qd = function (b) {
        if (H.a.fa.Rf && null !== b && "innerText" in b) b = H.c.kl(b.innerText); else {
            var c = [];
            H.a.Re(b, c, !0);
            b = c.join("")
        }
        b = b.replace(/ \xAD /g, " ").replace(/\xAD/g, "");
        b = b.replace(/\u200B/g, "");
        H.a.fa.Rf || (b = b.replace(/ +/g, " "));
        " " != b && (b = b.replace(/^\s*/, ""));
        return b
    };
    H.a.Cu = function (b) {
        var c = [];
        H.a.Re(b, c, !1);
        return c.join("")
    };
    H.a.Re = function (b, c, d) {
        if (!(b.nodeName in H.a.ng))if (b.nodeType == H.a.ra.Wc) d ? c.push(String(b.nodeValue).replace(/(\r\n|\r|\n)/g, "")) : c.push(b.nodeValue); else if (b.nodeName in H.a.Uc) c.push(H.a.Uc[b.nodeName]); else for (b = b.firstChild; b;)H.a.Re(b, c, d), b = b.nextSibling
    };
    H.a.Ah = function (b) {
        return H.a.qd(b).length
    };
    H.a.Bh = function (b, c) {
        c = c || H.a.tb(b).body;
        for (var d = []; b && b != c;) {
            for (var e = b; e = e.previousSibling;)d.unshift(H.a.qd(e));
            b = b.parentNode
        }
        return H.c.trimLeft(d.join("")).replace(/ +/g, " ").length
    };
    H.a.zh = function (b, c, d) {
        b = [b];
        for (var e = 0, f = null; 0 < b.length && e < c;)if (f = b.pop(), !(f.nodeName in H.a.ng))if (f.nodeType == H.a.ra.Wc) {
            var g = f.nodeValue.replace(/(\r\n|\r|\n)/g, "").replace(/ +/g, " ");
            e += g.length
        } else if (f.nodeName in H.a.Uc) e += H.a.Uc[f.nodeName].length; else for (g = f.childNodes.length - 1; 0 <= g; g--)b.push(f.childNodes[g]);
        H.Ea(d) && (d.ew = f ? f.nodeValue.length + c - e - 1 : 0, d.node = f);
        return f
    };
    H.a.Ye = function (b) {
        if (b && typeof b.length == r) {
            if (H.Ea(b))return typeof b.item == q || typeof b.item == x;
            if (H.Sa(b))return typeof b.item == q
        }
        return !1
    };
    H.a.Fe = function (b, c, d, e) {
        if (!c && !d)return null;
        var f = c ? String(c).toUpperCase() : null;
        return H.a.Ee(b, function (g) {
            return (!f || g.nodeName == f) && (!d || typeof g.className === x && H.g.contains(g.className.split(/\s+/), d))
        }, !0, e)
    };
    H.a.jh = function (b, c, d) {
        return H.a.Fe(b, null, c, d)
    };
    H.a.Ee = function (b, c, d, e) {
        b && !d && (b = b.parentNode);
        for (d = 0; b && (null == e || d <= e);) {
            if (c(b))return b;
            b = b.parentNode;
            d++
        }
        return null
    };
    H.a.ih = function (b) {
        try {
            var c = b && b.activeElement;
            return c && c.nodeName ? c : null
        } catch (d) {
            return null
        }
    };
    H.a.Bu = function () {
        var b = H.a.$b();
        return void 0 !== b.devicePixelRatio ? b.devicePixelRatio : b.matchMedia ? H.a.Ad(3) || H.a.Ad(2) || H.a.Ad(1.5) || H.a.Ad(1) || .75 : 1
    };
    H.a.Ad = function (b) {
        return H.a.$b().matchMedia("(min-resolution: " + b + "dppx),(min--moz-device-pixel-ratio: " + b + "),(min-resolution: " + 96 * b + "dpi)").matches ? b : 0
    };
    H.a.lh = function (b) {
        return b.getContext("2d")
    };
    H.a.Qb = function (b) {
        this.ia = b || H.global.document || document
    };
    F = H.a.Qb.prototype;
    F.Je = H.a.Je;
    F.Tl = C("ia");
    F.Ke = function (b) {
        return H.a.Ne(this.ia, b)
    };
    F.dm = function (b) {
        return H.a.Ih(this.ia, b)
    };
    F.nj = H.a.Qb.prototype.Ke;
    F.getElementsByTagName = function (b, c) {
        return (c || this.ia).getElementsByTagName(String(b))
    };
    F.Oe = function (b, c, d) {
        return H.a.md(this.ia, b, c, d)
    };
    F.Xl = function (b, c, d) {
        return H.a.Me(this.ia, b, c, d)
    };
    F.rh = function (b, c) {
        return H.a.rh(b, c || this.ia)
    };
    F.Le = function (b, c) {
        return H.a.Le(b, c || this.ia)
    };
    F.Hh = function (b, c) {
        return H.a.Hh(b, c || this.ia)
    };
    F.oj = H.a.Qb.prototype.Oe;
    F.Qd = H.a.Qd;
    F.Nh = function (b) {
        return H.a.Nh(b || this.$b())
    };
    F.Ul = function () {
        return H.a.He(this.$b())
    };
    F.ve = function (b, c, d) {
        return H.a.Pg(this.ia, arguments)
    };
    F.pj = H.a.Qb.prototype.ve;
    F.createElement = function (b) {
        return H.a.cb(this.ia, b)
    };
    F.createTextNode = function (b) {
        return this.ia.createTextNode(String(b))
    };
    F.tl = function (b, c, d) {
        return H.a.Qg(this.ia, b, c, !!d)
    };
    F.Mi = function (b) {
        return H.a.Ni(this.ia, b)
    };
    F.xm = function () {
        return H.a.Gc(this.ia)
    };
    F.$b = function () {
        return H.a.ac(this.ia)
    };
    F.Vl = function () {
        return H.a.Ie(this.ia)
    };
    F.ph = function () {
        return H.a.qh(this.ia)
    };
    F.ih = function (b) {
        return H.a.ih(b || this.ia)
    };
    F.appendChild = H.a.appendChild;
    F.append = H.a.append;
    F.canHaveChildren = H.a.canHaveChildren;
    F.mf = H.a.mf;
    F.Wh = H.a.Wh;
    F.Vh = H.a.Vh;
    F.Uh = H.a.Uh;
    F.removeNode = H.a.removeNode;
    F.Ki = H.a.Ki;
    F.fh = H.a.fh;
    F.mh = H.a.mh;
    F.sh = H.a.sh;
    F.vh = H.a.vh;
    F.xh = H.a.xh;
    F.Eh = H.a.Eh;
    F.yh = H.a.yh;
    F.Fh = H.a.Fh;
    F.Xe = H.a.Xe;
    F.Ve = H.a.Ve;
    F.pi = H.a.pi;
    F.Dh = H.a.Dh;
    F.contains = H.a.contains;
    F.Jg = H.a.Jg;
    F.ah = H.a.ah;
    F.tb = H.a.tb;
    F.th = H.a.th;
    F.uh = H.a.uh;
    F.sf = H.a.sf;
    F.Ch = H.a.Ch;
    F.bh = H.a.bh;
    F.dh = H.a.dh;
    F.We = H.a.We;
    F.Ri = H.a.Ri;
    F.ai = H.a.ai;
    F.qd = H.a.qd;
    F.Ah = H.a.Ah;
    F.Bh = H.a.Bh;
    F.zh = H.a.zh;
    F.Ye = H.a.Ye;
    F.Fe = H.a.Fe;
    F.jh = H.a.jh;
    F.Ee = H.a.Ee;
    F.lh = H.a.lh;
    H.async.bj = function (b) {
        H.global.setTimeout(function () {
            throw b;
        }, 0)
    };
    H.async.Ka = function (b, c, d) {
        var e = b;
        c && (e = H.bind(b, c));
        e = H.async.Ka.lj(e);
        H.Sa(H.global.setImmediate) && (d || H.async.Ka.Eo()) ? H.global.setImmediate(e) : (H.async.Ka.Si || (H.async.Ka.Si = H.async.Ka.gm()), H.async.Ka.Si(e))
    };
    H.async.Ka.Eo = function () {
        return H.global.Window && H.global.Window.prototype && !H.h.userAgent.B.vb() && H.global.Window.prototype.setImmediate == H.global.setImmediate ? !1 : !0
    };
    H.async.Ka.gm = function () {
        var b = H.global.MessageChannel;
        "undefined" === typeof b && "undefined" !== typeof window && window.postMessage && window.addEventListener && !H.h.userAgent.ca.Jm() && (b = function () {
            var f = H.a.createElement("IFRAME");
            f.style.display = "none";
            H.a.N.Xn(f);
            document.documentElement.appendChild(f);
            var g = f.contentWindow;
            f = g.document;
            f.open();
            H.a.N.Cl(f);
            f.close();
            var h = "callImmediate" + Math.random(),
                k = "file:" == g.location.protocol ? "*" : g.location.protocol + "//" + g.location.host;
            f = H.bind(function (m) {
                if (("*" ==
                    k || m.origin == k) && m.data == h) this.port1.onmessage()
            }, this);
            g.addEventListener("message", f, !1);
            this.port1 = {};
            this.port2 = {
                postMessage: function () {
                    g.postMessage(h, k)
                }
            }
        });
        if ("undefined" !== typeof b && !H.h.userAgent.B.xd()) {
            var c = new b, d = {}, e = d;
            c.port1.onmessage = function () {
                if (void 0 !== d.next) {
                    d = d.next;
                    var f = d.Ig;
                    d.Ig = null;
                    f()
                }
            };
            return function (f) {
                e.next = {Ig: f};
                e = e.next;
                c.port2.postMessage(0)
            }
        }
        return "undefined" !== typeof document && "onreadystatechange" in H.a.createElement(l) ? function (f) {
            var g = H.a.createElement(l);
            g.onreadystatechange = function () {
                g.onreadystatechange = null;
                g.parentNode.removeChild(g);
                g = null;
                f();
                f = null
            };
            document.documentElement.appendChild(g)
        } : function (f) {
            H.global.setTimeout(f, 0)
        }
    };
    H.async.Ka.lj = H.U.Sh;
    H.debug.na.register(function (b) {
        H.async.Ka.lj = b
    });
    H.async.bb = function () {
        this.Wd = this.jc = null
    };
    H.async.bb.ae = 100;
    H.async.bb.Bc = new H.async.Sc(function () {
        return new H.async.le
    }, function (b) {
        b.reset()
    }, H.async.bb.ae);
    H.async.bb.prototype.add = function (b, c) {
        var d = H.async.bb.Bc.get();
        d.set(b, c);
        this.Wd ? this.Wd.next = d : this.jc = d;
        this.Wd = d
    };
    H.async.bb.prototype.remove = function () {
        var b = null;
        this.jc && (b = this.jc, this.jc = this.jc.next, this.jc || (this.Wd = null), b.next = null);
        return b
    };
    H.async.le = function () {
        this.next = this.scope = this.Ce = null
    };
    H.async.le.prototype.set = function (b, c) {
        this.Ce = b;
        this.scope = c;
        this.next = null
    };
    H.async.le.prototype.reset = function () {
        this.next = this.scope = this.Ce = null
    };
    H.wj = !1;
    H.async.W = function (b, c) {
        H.async.W.Od || H.async.W.wm();
        H.async.W.Vd || (H.async.W.Od(), H.async.W.Vd = !0);
        H.async.W.Cf.add(b, c)
    };
    H.async.W.wm = function () {
        if (H.wj || H.global.Promise && H.global.Promise.resolve) {
            var b = H.global.Promise.resolve(void 0);
            H.async.W.Od = function () {
                b.then(H.async.W.Id)
            }
        } else H.async.W.Od = function () {
            H.async.Ka(H.async.W.Id)
        }
    };
    H.async.W.Wt = function (b) {
        H.async.W.Od = function () {
            H.async.Ka(H.async.W.Id);
            b && b(H.async.W.Id)
        }
    };
    H.async.W.Vd = !1;
    H.async.W.Cf = new H.async.bb;
    H.la && (H.async.W.ow = function () {
        H.async.W.Vd = !1;
        H.async.W.Cf = new H.async.bb
    });
    H.async.W.Id = function () {
        for (var b; b = H.async.W.Cf.remove();) {
            try {
                b.Ce.call(b.scope)
            } catch (c) {
                H.async.bj(c)
            }
            H.async.bb.Bc.put(b)
        }
        H.async.W.Vd = !1
    };
    H.o = {};
    H.o.sa = "StopIteration" in H.global ? H.global.StopIteration : {message: "StopIteration", stack: ""};
    H.o.Iterator = A();
    H.o.Iterator.prototype.next = function () {
        throw H.o.sa;
    };
    H.o.Iterator.prototype.me = function () {
        return this
    };
    H.o.da = function (b) {
        if (b instanceof H.o.Iterator)return b;
        if (typeof b.me == q)return b.me(!1);
        if (H.ka(b)) {
            var c = 0, d = new H.o.Iterator;
            d.next = function () {
                for (; ;) {
                    if (c >= b.length)throw H.o.sa;
                    if (c in b)return b[c++];
                    c++
                }
            };
            return d
        }
        throw Error("Not implemented");
    };
    H.o.forEach = function (b, c, d) {
        if (H.ka(b))try {
            H.g.forEach(b, c, d)
        } catch (e) {
            if (e !== H.o.sa)throw e;
        } else {
            b = H.o.da(b);
            try {
                for (; ;)c.call(d, b.next(), void 0, b)
            } catch (e) {
                if (e !== H.o.sa)throw e;
            }
        }
    };
    H.o.filter = function (b, c, d) {
        var e = H.o.da(b);
        b = new H.o.Iterator;
        b.next = function () {
            for (; ;) {
                var f = e.next();
                if (c.call(d, f, void 0, e))return f
            }
        };
        return b
    };
    H.o.Pt = function (b, c, d) {
        return H.o.filter(b, H.U.on(c), d)
    };
    H.o.Kd = function (b, c, d) {
        var e = 0, f = b, g = d || 1;
        1 < arguments.length && (e = b, f = +c);
        if (0 == g)throw Error("Range step argument must not be zero");
        var h = new H.o.Iterator;
        h.next = function () {
            if (0 < g && e >= f || 0 > g && e <= f)throw H.o.sa;
            var k = e;
            e += g;
            return k
        };
        return h
    };
    H.o.join = function (b, c) {
        return H.o.gb(b).join(c)
    };
    H.o.map = function (b, c, d) {
        var e = H.o.da(b);
        b = new H.o.Iterator;
        b.next = function () {
            var f = e.next();
            return c.call(d, f, void 0, e)
        };
        return b
    };
    H.o.reduce = function (b, c, d, e) {
        var f = d;
        H.o.forEach(b, function (g) {
            f = c.call(e, f, g)
        });
        return f
    };
    H.o.some = function (b, c, d) {
        b = H.o.da(b);
        try {
            for (; ;)if (c.call(d, b.next(), void 0, b))return !0
        } catch (e) {
            if (e !== H.o.sa)throw e;
        }
        return !1
    };
    H.o.every = function (b, c, d) {
        b = H.o.da(b);
        try {
            for (; ;)if (!c.call(d, b.next(), void 0, b))return !1
        } catch (e) {
            if (e !== H.o.sa)throw e;
        }
        return !0
    };
    H.o.Zs = function (b) {
        return H.o.ll(arguments)
    };
    H.o.ll = function (b) {
        var c = H.o.da(b);
        b = new H.o.Iterator;
        var d = null;
        b.next = function () {
            for (; ;) {
                if (null == d) {
                    var e = c.next();
                    d = H.o.da(e)
                }
                try {
                    return d.next()
                } catch (f) {
                    if (f !== H.o.sa)throw f;
                    d = null
                }
            }
        };
        return b
    };
    H.o.Ft = function (b, c, d) {
        var e = H.o.da(b);
        b = new H.o.Iterator;
        var f = !0;
        b.next = function () {
            for (; ;) {
                var g = e.next();
                if (!f || !c.call(d, g, void 0, e))return f = !1, g
            }
        };
        return b
    };
    H.o.lx = function (b, c, d) {
        var e = H.o.da(b);
        b = new H.o.Iterator;
        b.next = function () {
            var f = e.next();
            if (c.call(d, f, void 0, e))return f;
            throw H.o.sa;
        };
        return b
    };
    H.o.gb = function (b) {
        if (H.ka(b))return H.g.gb(b);
        b = H.o.da(b);
        var c = [];
        H.o.forEach(b, function (d) {
            c.push(d)
        });
        return c
    };
    H.o.Ib = function (b, c) {
        b = H.o.Lo({}, b, c);
        var d = H.g.Vg;
        return H.o.every(b, function (e) {
            return d(e[0], e[1])
        })
    };
    H.o.nn = function (b) {
        try {
            H.o.da(b).next()
        } catch (c) {
            if (c != H.o.sa)throw c;
        }
    };
    H.o.product = function (b) {
        if (H.g.some(arguments, function (f) {
                return !f.length
            }) || !arguments.length)return new H.o.Iterator;
        var c = new H.o.Iterator, d = arguments, e = H.g.repeat(0, d.length);
        c.next = function () {
            if (e) {
                for (var f = H.g.map(e, function (h, k) {
                    return d[k][h]
                }), g = e.length - 1; 0 <= g; g--) {
                    if (e[g] < d[g].length - 1) {
                        e[g]++;
                        break
                    }
                    if (0 == g) {
                        e = null;
                        break
                    }
                    e[g] = 0
                }
                return f
            }
            throw H.o.sa;
        };
        return c
    };
    H.o.zt = function (b) {
        var c = H.o.da(b), d = [], e = 0;
        b = new H.o.Iterator;
        var f = !1;
        b.next = function () {
            var g = null;
            if (!f)try {
                return g = c.next(), d.push(g), g
            } catch (h) {
                if (h != H.o.sa || H.g.za(d))throw h;
                f = !0
            }
            g = d[e];
            e = (e + 1) % d.length;
            return g
        };
        return b
    };
    H.o.count = function (b, c) {
        var d = b || 0, e = void 0 !== c ? c : 1;
        b = new H.o.Iterator;
        b.next = function () {
            var f = d;
            d += e;
            return f
        };
        return b
    };
    H.o.repeat = function (b) {
        var c = new H.o.Iterator;
        c.next = H.U.Mg(b);
        return c
    };
    H.o.rs = function (b) {
        var c = H.o.da(b), d = 0;
        b = new H.o.Iterator;
        b.next = function () {
            return d += c.next()
        };
        return b
    };
    H.o.mj = function (b) {
        var c = arguments, d = new H.o.Iterator;
        if (0 < c.length) {
            var e = H.g.map(c, H.o.da);
            d.next = function () {
                return H.g.map(e, function (f) {
                    return f.next()
                })
            }
        }
        return d
    };
    H.o.Lo = function (b, c) {
        var d = H.g.slice(arguments, 1), e = new H.o.Iterator;
        if (0 < d.length) {
            var f = H.g.map(d, H.o.da);
            e.next = function () {
                var g = !1, h = H.g.map(f, function (k) {
                    try {
                        var m = k.next();
                        g = !0
                    } catch (n) {
                        if (n !== H.o.sa)throw n;
                        m = b
                    }
                    return m
                });
                if (!g)throw H.o.sa;
                return h
            }
        }
        return e
    };
    H.o.ht = function (b, c) {
        var d = H.o.da(c);
        return H.o.filter(b, function () {
            return !!d.next()
        })
    };
    H.o.ee = function (b, c) {
        this.iterator = H.o.da(b);
        this.ui = c || H.U.Sh
    };
    H.ub(H.o.ee, H.o.Iterator);
    H.o.ee.prototype.next = function () {
        for (; this.vc == this.$i;)this.fd = this.iterator.next(), this.vc = this.ui(this.fd);
        for (var b = this.$i = this.vc, c = this.$i, d = []; this.vc == c;) {
            d.push(this.fd);
            try {
                this.fd = this.iterator.next()
            } catch (e) {
                if (e !== H.o.sa)throw e;
                break
            }
            this.vc = this.ui(this.fd)
        }
        return [b, d]
    };
    H.o.Ju = function (b, c) {
        return new H.o.ee(b, c)
    };
    H.o.gx = function (b, c, d) {
        var e = H.o.da(b);
        b = new H.o.Iterator;
        b.next = function () {
            var f = H.o.gb(e.next());
            return c.apply(d, H.g.concat(f, void 0, e))
        };
        return b
    };
    H.o.tee = function (b, c) {
        function d() {
            var g = e.next();
            H.g.forEach(f, function (h) {
                h.push(g)
            })
        }

        var e = H.o.da(b), f = H.g.map(H.g.Kd(typeof c === r ? c : 2), function () {
            return []
        });
        return H.g.map(f, function (g) {
            var h = new H.o.Iterator;
            h.next = function () {
                H.g.za(g) && d();
                return g.shift()
            };
            return h
        })
    };
    H.o.Lt = function (b, c) {
        return H.o.mj(H.o.count(c), b)
    };
    H.o.Tm = function (b, c) {
        var d = H.o.da(b);
        b = new H.o.Iterator;
        var e = c;
        b.next = function () {
            if (0 < e--)return d.next();
            throw H.o.sa;
        };
        return b
    };
    H.o.pl = function (b, c) {
        for (b = H.o.da(b); 0 < c--;)H.o.nn(b);
        return b
    };
    H.o.slice = function (b, c, d) {
        b = H.o.pl(b, c);
        typeof d === r && (b = H.o.Tm(b, d - c));
        return b
    };
    H.o.qm = function (b) {
        var c = [];
        H.g.An(b, c);
        return b.length != c.length
    };
    H.o.rn = function (b, c) {
        b = H.o.gb(b);
        c = H.g.repeat(b, typeof c === r ? c : b.length);
        c = H.o.product.apply(void 0, c);
        return H.o.filter(c, function (d) {
            return !H.o.qm(d)
        })
    };
    H.o.dt = function (b, c) {
        function d(g) {
            return e[g]
        }

        var e = H.o.gb(b);
        b = H.o.Kd(e.length);
        c = H.o.rn(b, c);
        var f = H.o.filter(c, function (g) {
            return H.g.mi(g)
        });
        c = new H.o.Iterator;
        c.next = function () {
            return H.g.map(f.next(), d)
        };
        return c
    };
    H.o.et = function (b, c) {
        function d(g) {
            return e[g]
        }

        var e = H.o.gb(b);
        b = H.g.Kd(e.length);
        c = H.g.repeat(b, c);
        c = H.o.product.apply(void 0, c);
        var f = H.o.filter(c, function (g) {
            return H.g.mi(g)
        });
        c = new H.o.Iterator;
        c.next = function () {
            return H.g.map(f.next(), d)
        };
        return c
    };
    H.Jd = {};
    H.Jd.wr = A();
    H.Thenable = A();
    H.Thenable.prototype.then = A();
    H.Thenable.ag = "$goog_Thenable";
    H.Thenable.tg = function (b) {
        b.prototype[H.Thenable.ag] = !0
    };
    H.Thenable.bi = function (b) {
        if (!b)return !1;
        try {
            return !!b[H.Thenable.ag]
        } catch (c) {
            return !1
        }
    };
    H.Promise = function (b, c) {
        this.oa = H.Promise.aa.Xa;
        this.Fa = void 0;
        this.Vb = this.nb = this.va = null;
        this.Ae = !1;
        0 < H.Promise.Bb ? this.Sd = 0 : 0 == H.Promise.Bb && (this.sd = !1);
        H.Promise.$a && (this.wf = [], I(this, Error("created")), this.Tg = 0);
        if (b != H.Lb)try {
            var d = this;
            b.call(c, function (e) {
                J(d, H.Promise.aa.kb, e)
            }, function (e) {
                if (H.la && !(e instanceof H.Promise.Pb))try {
                    if (e instanceof Error)throw e;
                    throw Error("Promise rejected.");
                } catch (f) {
                }
                J(d, H.Promise.aa.Ga, e)
            })
        } catch (e) {
            J(this, H.Promise.aa.Ga, e)
        }
    };
    H.Promise.$a = !1;
    H.Promise.Bb = 0;
    H.Promise.aa = {Xa: 0, Bj: 1, kb: 2, Ga: 3};
    H.Promise.Sf = function () {
        this.next = this.context = this.dc = this.Lc = this.Db = null;
        this.Yc = !1
    };
    H.Promise.Sf.prototype.reset = function () {
        this.context = this.dc = this.Lc = this.Db = null;
        this.Yc = !1
    };
    H.Promise.ae = 100;
    H.Promise.Bc = new H.async.Sc(function () {
        return new H.Promise.Sf
    }, function (b) {
        b.reset()
    }, H.Promise.ae);
    H.Promise.kh = function (b, c, d) {
        var e = H.Promise.Bc.get();
        e.Lc = b;
        e.dc = c;
        e.context = d;
        return e
    };
    H.Promise.In = function (b) {
        H.Promise.Bc.put(b)
    };
    H.Promise.resolve = function (b) {
        if (b instanceof H.Promise)return b;
        var c = new H.Promise(H.Lb);
        J(c, H.Promise.aa.kb, b);
        return c
    };
    H.Promise.reject = function (b) {
        return new H.Promise(function (c, d) {
            d(b)
        })
    };
    H.Promise.Ld = function (b, c, d) {
        H.Promise.Ci(b, c, d, null) || H.async.W(H.Mb(c, b))
    };
    H.Promise.race = function (b) {
        return new H.Promise(function (c, d) {
            b.length || c(void 0);
            for (var e = 0, f; e < b.length; e++)f = b[e], H.Promise.Ld(f, c, d)
        })
    };
    H.Promise.all = function (b) {
        return new H.Promise(function (c, d) {
            var e = b.length, f = [];
            if (e)for (var g = function (n, t) {
                e--;
                f[n] = t;
                0 == e && c(f)
            }, h = function (n) {
                d(n)
            }, k = 0, m; k < b.length; k++)m = b[k], H.Promise.Ld(m, H.Mb(g, k), h); else c(f)
        })
    };
    H.Promise.allSettled = function (b) {
        return new H.Promise(function (c) {
            var d = b.length, e = [];
            if (d)for (var f = function (k, m, n) {
                d--;
                e[k] = m ? {Rl: !0, value: n} : {Rl: !1, reason: n};
                0 == d && c(e)
            }, g = 0, h; g < b.length; g++)h = b[g], H.Promise.Ld(h, H.Mb(f, g, !0), H.Mb(f, g, !1)); else c(e)
        })
    };
    H.Promise.Vt = function (b) {
        return new H.Promise(function (c, d) {
            var e = b.length, f = [];
            if (e)for (var g = function (n) {
                c(n)
            }, h = function (n, t) {
                e--;
                f[n] = t;
                0 == e && d(f)
            }, k = 0, m; k < b.length; k++)m = b[k], H.Promise.Ld(m, g, H.Mb(h, k)); else c(void 0)
        })
    };
    H.Promise.zx = function () {
        var b, c, d = new H.Promise(function (e, f) {
            b = e;
            c = f
        });
        return new H.Promise.kk(d, b, c)
    };
    H.Promise.prototype.then = function (b, c, d) {
        H.Promise.$a && I(this, Error("then"));
        return ia(this, H.Sa(b) ? b : null, H.Sa(c) ? c : null, d)
    };
    H.Thenable.tg(H.Promise);
    H.Promise.prototype.cancel = function (b) {
        if (this.oa == H.Promise.aa.Xa) {
            var c = new H.Promise.Pb(b);
            H.async.W(function () {
                ja(this, c)
            }, this)
        }
    };
    function ja(b, c) {
        if (b.oa == H.Promise.aa.Xa)if (b.va) {
            var d = b.va;
            if (d.nb) {
                for (var e = 0, f = null, g = null, h = d.nb; h && (h.Yc || (e++, h.Db == b && (f = h), !(f && 1 < e))); h = h.next)f || (g = h);
                f && (d.oa == H.Promise.aa.Xa && 1 == e ? ja(d, c) : (g ? (e = g, e.next == d.Vb && (d.Vb = e), e.next = e.next.next) : ka(d), la(d, f, H.Promise.aa.Ga, c)))
            }
            b.va = null
        } else J(b, H.Promise.aa.Ga, c)
    }

    function ma(b, c) {
        b.nb || b.oa != H.Promise.aa.kb && b.oa != H.Promise.aa.Ga || na(b);
        b.Vb ? b.Vb.next = c : b.nb = c;
        b.Vb = c
    }

    function ia(b, c, d, e) {
        var f = H.Promise.kh(null, null, null);
        f.Db = new H.Promise(function (g, h) {
            f.Lc = c ? function (k) {
                try {
                    var m = c.call(e, k);
                    g(m)
                } catch (n) {
                    h(n)
                }
            } : g;
            f.dc = d ? function (k) {
                try {
                    var m = d.call(e, k);
                    void 0 === m && k instanceof H.Promise.Pb ? h(k) : g(m)
                } catch (n) {
                    h(n)
                }
            } : h
        });
        f.Db.va = b;
        ma(b, f);
        return f.Db
    }

    H.Promise.prototype.wo = function (b) {
        this.oa = H.Promise.aa.Xa;
        J(this, H.Promise.aa.kb, b)
    };
    H.Promise.prototype.xo = function (b) {
        this.oa = H.Promise.aa.Xa;
        J(this, H.Promise.aa.Ga, b)
    };
    function J(b, c, d) {
        b.oa == H.Promise.aa.Xa && (b === d && (c = H.Promise.aa.Ga, d = new TypeError("Promise cannot resolve to itself")), b.oa = H.Promise.aa.Bj, H.Promise.Ci(d, b.wo, b.xo, b) || (b.Fa = d, b.oa = c, b.va = null, na(b), c != H.Promise.aa.Ga || d instanceof H.Promise.Pb || H.Promise.Ik(b, d)))
    }

    H.Promise.Ci = function (b, c, d, e) {
        if (b instanceof H.Promise)return H.Promise.$a && I(b, Error("then")), ma(b, H.Promise.kh(c || H.Lb, d || null, e)), !0;
        if (H.Thenable.bi(b))return b.then(c, d, e), !0;
        if (H.Ea(b))try {
            var f = b.then;
            if (H.Sa(f))return H.Promise.uo(b, f, c, d, e), !0
        } catch (g) {
            return d.call(e, g), !0
        }
        return !1
    };
    H.Promise.uo = function (b, c, d, e, f) {
        function g(m) {
            k || (k = !0, e.call(f, m))
        }

        function h(m) {
            k || (k = !0, d.call(f, m))
        }

        var k = !1;
        try {
            c.call(b, h, g)
        } catch (m) {
            g(m)
        }
    };
    function na(b) {
        b.Ae || (b.Ae = !0, H.async.W(b.Jl, b))
    }

    function ka(b) {
        var c = null;
        b.nb && (c = b.nb, b.nb = c.next, c.next = null);
        b.nb || (b.Vb = null);
        return c
    }

    H.Promise.prototype.Jl = function () {
        for (var b; b = ka(this);)H.Promise.$a && this.Tg++, la(this, b, this.oa, this.Fa);
        this.Ae = !1
    };
    function la(b, c, d, e) {
        if (d == H.Promise.aa.Ga && c.dc && !c.Yc)if (0 < H.Promise.Bb)for (; b && b.Sd; b = b.va)H.global.clearTimeout(b.Sd), b.Sd = 0; else if (0 == H.Promise.Bb)for (; b && b.sd; b = b.va)b.sd = !1;
        if (c.Db) c.Db.va = null, H.Promise.Xh(c, d, e); else try {
            c.Yc ? c.Lc.call(c.context) : H.Promise.Xh(c, d, e)
        } catch (f) {
            H.Promise.td.call(null, f)
        }
        H.Promise.In(c)
    }

    H.Promise.Xh = function (b, c, d) {
        c == H.Promise.aa.kb ? b.Lc.call(b.context, d) : b.dc && b.dc.call(b.context, d)
    };
    function I(b, c) {
        if (H.Promise.$a && typeof c.stack === x) {
            var d = c.stack.split("\n", 4)[3];
            c = c.message;
            c += Array(11 - c.length).join(" ");
            b.wf.push(c + d)
        }
    }

    function oa(b, c) {
        if (H.Promise.$a && c && typeof c.stack === x && b.wf.length) {
            for (var d = ["Promise trace:"], e = b; e; e = e.va) {
                for (var f = b.Tg; 0 <= f; f--)d.push(e.wf[f]);
                d.push("Value: [" + (e.oa == H.Promise.aa.Ga ? "REJECTED" : "FULFILLED") + "] <" + String(e.Fa) + ">")
            }
            c.stack += "\n\n" + d.join("\n")
        }
    }

    H.Promise.Ik = function (b, c) {
        0 < H.Promise.Bb ? b.Sd = H.global.setTimeout(function () {
            oa(b, c);
            H.Promise.td.call(null, c)
        }, H.Promise.Bb) : 0 == H.Promise.Bb && (b.sd = !0, H.async.W(function () {
                b.sd && (oa(b, c), H.Promise.td.call(null, c))
            }))
    };
    H.Promise.td = H.async.bj;
    H.Promise.Ww = function (b) {
        H.Promise.td = b
    };
    H.Promise.Pb = function (b) {
        H.debug.Error.call(this, b)
    };
    H.ub(H.Promise.Pb, H.debug.Error);
    H.Promise.Pb.prototype.name = "cancel";
    H.Promise.kk = function (b, c, d) {
        this.Jd = b;
        this.resolve = c;
        this.reject = d
    };
    /*
     Portions of this code are from MochiKit, received by
     The Closure Authors under the MIT license. All other code is Copyright
     2005-2009 The Closure Authors. All Rights Reserved.
     */
    H.async.J = function (b, c) {
        this.Pd = [];
        this.Gi = b;
        this.Wg = c || null;
        this.bc = this.Wb = !1;
        this.Fa = void 0;
        this.tf = this.dl = this.qe = !1;
        this.Rd = 0;
        this.va = null;
        this.Zc = 0;
        H.async.J.$a && (this.ue = null, Error.captureStackTrace && (b = {stack: ""}, Error.captureStackTrace(b, H.async.J), typeof b.stack == x && (this.ue = b.stack.replace(/^[^\n]*\n/, ""))))
    };
    H.async.J.vk = !1;
    H.async.J.$a = !1;
    F = H.async.J.prototype;
    F.cancel = function (b) {
        if (this.Wb) this.Fa instanceof H.async.J && this.Fa.cancel(); else {
            if (this.va) {
                var c = this.va;
                delete this.va;
                b ? c.cancel(b) : (c.Zc--, 0 >= c.Zc && c.cancel())
            }
            this.Gi ? this.Gi.call(this.Wg, this) : this.tf = !0;
            this.Wb || this.pb(new H.async.J.Ob(this))
        }
    };
    F.Og = function (b, c) {
        this.qe = !1;
        K(this, b, c)
    };
    function K(b, c, d) {
        b.Wb = !0;
        b.Fa = d;
        b.bc = !c;
        pa(b)
    }

    function qa(b) {
        if (b.Wb) {
            if (!b.tf)throw new H.async.J.Pc(b);
            b.tf = !1
        }
    }

    F.qc = function (b) {
        qa(this);
        K(this, !0, b)
    };
    F.pb = function (b) {
        qa(this);
        ra(this, b);
        K(this, !1, b)
    };
    function ra(b, c) {
        H.async.J.$a && b.ue && H.Ea(c) && c.stack && /^[^\n]+(\n   [^\n]+)+/.test(c.stack) && (c.stack = c.stack + "\nDEFERRED OPERATION:\n" + b.ue)
    }

    function L(b, c, d) {
        return M(b, c, null, d)
    }

    function sa(b, c) {
        M(b, null, c, void 0)
    }

    function M(b, c, d, e) {
        b.Pd.push([c, d, e]);
        b.Wb && pa(b);
        return b
    }

    F.then = function (b, c, d) {
        var e, f, g = new H.Promise(function (h, k) {
            e = h;
            f = k
        });
        M(this, e, function (h) {
            h instanceof H.async.J.Ob ? g.cancel() : f(h)
        });
        return g.then(b, c, d)
    };
    H.Thenable.tg(H.async.J);
    H.async.J.prototype.fl = function () {
        var b = new H.async.J;
        M(this, b.qc, b.pb, b);
        b.va = this;
        this.Zc++;
        return b
    };
    function ta(b) {
        return H.g.some(b.Pd, function (c) {
            return H.Sa(c[1])
        })
    }

    function pa(b) {
        b.Rd && b.Wb && ta(b) && (H.async.J.Co(b.Rd), b.Rd = 0);
        b.va && (b.va.Zc--, delete b.va);
        for (var c = b.Fa, d = !1, e = !1; b.Pd.length && !b.qe;) {
            var f = b.Pd.shift(), g = f[0], h = f[1];
            f = f[2];
            if (g = b.bc ? h : g)try {
                var k = g.call(f || b.Wg, c);
                void 0 !== k && (b.bc = b.bc && (k == c || k instanceof Error), b.Fa = c = k);
                if (H.Thenable.bi(c) || typeof H.global.Promise === q && c instanceof H.global.Promise) e = !0, b.qe = !0
            } catch (m) {
                c = m, b.bc = !0, ra(b, c), ta(b) || (d = !0)
            }
        }
        b.Fa = c;
        e ? (e = H.bind(b.Og, b, !0), k = H.bind(b.Og, b, !1), c instanceof H.async.J ? (M(c, e, k),
            c.dl = !0) : c.then(e, k)) : H.async.J.vk && c instanceof Error && !(c instanceof H.async.J.Ob) && (d = b.bc = !0);
        d && (b.Rd = H.async.J.Vn(c))
    }

    H.async.J.Zi = function (b) {
        var c = new H.async.J;
        c.qc(b);
        return c
    };
    H.async.J.du = function (b) {
        var c = new H.async.J;
        b.then(function (d) {
            c.qc(d)
        }, function (d) {
            c.pb(d)
        });
        return c
    };
    H.async.J.ua = function (b) {
        var c = new H.async.J;
        c.pb(b);
        return c
    };
    H.async.J.Xs = function () {
        var b = new H.async.J;
        b.cancel();
        return b
    };
    H.async.J.yx = function (b, c, d) {
        return b instanceof H.async.J ? L(b.fl(), c, d) : L(H.async.J.Zi(b), c, d)
    };
    H.async.J.Pc = function () {
        H.debug.Error.call(this)
    };
    H.ub(H.async.J.Pc, H.debug.Error);
    H.async.J.Pc.prototype.message = "Deferred has already fired";
    H.async.J.Pc.prototype.name = "AlreadyCalledError";
    H.async.J.Ob = function () {
        H.debug.Error.call(this)
    };
    H.ub(H.async.J.Ob, H.debug.Error);
    H.async.J.Ob.prototype.message = "Deferred was canceled";
    H.async.J.Ob.prototype.name = "CanceledError";
    H.async.J.Wf = function (b) {
        this.Fc = H.global.setTimeout(H.bind(this.aj, this), 0);
        this.Hl = b
    };
    H.async.J.Wf.prototype.aj = function () {
        delete H.async.J.zc[this.Fc];
        throw this.Hl;
    };
    H.async.J.zc = {};
    H.async.J.Vn = function (b) {
        b = new H.async.J.Wf(b);
        H.async.J.zc[b.Fc] = b;
        return b.Fc
    };
    H.async.J.Co = function (b) {
        var c = H.async.J.zc[b];
        c && (H.global.clearTimeout(c.Fc), delete H.async.J.zc[b])
    };
    H.async.J.Js = function () {
        var b = H.async.J.zc, c;
        for (c in b) {
            var d = b[c];
            H.global.clearTimeout(d.Fc);
            d.aj()
        }
    };
    H.M = {};
    H.M.O = {};
    H.M.O.ce = "closure_verification";
    H.M.O.Mj = 5E3;
    H.M.O.pf = [];
    H.M.O.Qn = function (b, c) {
        function d() {
            var f = b.shift();
            f = H.M.O.Md(f, c);
            b.length && M(f, d, d, void 0);
            return f
        }

        if (!b.length)return H.async.J.Zi(null);
        var e = H.M.O.pf.length;
        H.g.extend(H.M.O.pf, b);
        if (e)return H.M.O.Pi;
        b = H.M.O.pf;
        H.M.O.Pi = d();
        return H.M.O.Pi
    };
    H.M.O.Md = function (b, c) {
        var d = c || {};
        c = d.document || document;
        var e = H.b.I.F(b), f = H.a.createElement(l), g = {Qi: f, dj: void 0}, h = new H.async.J(H.M.O.jl, g), k = null,
            m = null != d.timeout ? d.timeout : H.M.O.Mj;
        0 < m && (k = window.setTimeout(function () {
            H.M.O.cd(f, !0);
            h.pb(new H.M.O.Error(H.M.O.Rc.TIMEOUT, "Timeout reached for loading script " + e))
        }, m), g.dj = k);
        f.onload = f.onreadystatechange = function () {
            f.readyState && "loaded" != f.readyState && "complete" != f.readyState || (H.M.O.cd(f, d.at || !1, k), h.qc(null))
        };
        f.onerror = function () {
            H.M.O.cd(f,
                !0, k);
            h.pb(new H.M.O.Error(H.M.O.Rc.$j, "Error while loading script " + e))
        };
        g = d.attributes || {};
        H.object.extend(g, {type: ea, charset: "UTF-8"});
        H.a.Qd(f, g);
        H.a.N.bo(f, b);
        H.M.O.fm(c).appendChild(f);
        return h
    };
    H.M.O.sw = function (b, c, d) {
        H.global[H.M.O.ce] || (H.global[H.M.O.ce] = {});
        var e = H.global[H.M.O.ce], f = H.b.I.F(b);
        if (void 0 !== e[c])return H.async.J.ua(new H.M.O.Error(H.M.O.Rc.Gk, "Verification object " + c + " already defined."));
        b = H.M.O.Md(b, d);
        var g = new H.async.J(H.bind(b.cancel, b));
        L(b, function () {
            var h = e[c];
            void 0 !== h ? (g.qc(h), delete e[c]) : g.pb(new H.M.O.Error(H.M.O.Rc.Fk, "Script " + f + " loaded, but verification object " + c + " was not defined."))
        });
        sa(b, function (h) {
            void 0 !== e[c] && delete e[c];
            g.pb(h)
        });
        return g
    };
    H.M.O.fm = function (b) {
        var c = H.a.getElementsByTagName("HEAD", b);
        return !c || H.g.za(c) ? b.documentElement : c[0]
    };
    H.M.O.jl = function () {
        if (this && this.Qi) {
            var b = this.Qi;
            b && b.tagName == l && H.M.O.cd(b, !0, this.dj)
        }
    };
    H.M.O.cd = function (b, c, d) {
        null != d && H.global.clearTimeout(d);
        b.onload = H.Lb;
        b.onerror = H.Lb;
        b.onreadystatechange = H.Lb;
        c && window.setTimeout(function () {
            H.a.removeNode(b)
        }, 0)
    };
    H.M.O.Rc = {$j: 0, TIMEOUT: 1, Fk: 2, Gk: 3};
    H.M.O.Error = function (b, c) {
        var d = "Jsloader error (code #" + b + ")";
        c && (d += ": " + c);
        H.debug.Error.call(this, d);
        this.code = b
    };
    H.ub(H.M.O.Error, H.debug.Error);
    H.P = {};
    H.P.Map = function (b, c) {
        this.Aa = {};
        this.Z = [];
        this.Oc = this.Y = 0;
        var d = arguments.length;
        if (1 < d) {
            if (d % 2)throw Error(aa);
            for (var e = 0; e < d; e += 2)this.set(arguments[e], arguments[e + 1])
        } else b && this.addAll(b)
    };
    F = H.P.Map.prototype;
    F.qb = C("Y");
    F.ea = function () {
        N(this);
        for (var b = [], c = 0; c < this.Z.length; c++)b.push(this.Aa[this.Z[c]]);
        return b
    };
    F.ja = function () {
        N(this);
        return this.Z.concat()
    };
    F.Fb = function (b) {
        return H.P.Map.Jb(this.Aa, b)
    };
    F.Gb = function (b) {
        for (var c = 0; c < this.Z.length; c++) {
            var d = this.Z[c];
            if (H.P.Map.Jb(this.Aa, d) && this.Aa[d] == b)return !0
        }
        return !1
    };
    F.Ib = function (b, c) {
        if (this === b)return !0;
        if (this.Y != b.qb())return !1;
        c = c || H.P.Map.xl;
        N(this);
        for (var d, e = 0; d = this.Z[e]; e++)if (!c(this.get(d), b.get(d)))return !1;
        return !0
    };
    H.P.Map.xl = function (b, c) {
        return b === c
    };
    F = H.P.Map.prototype;
    F.za = function () {
        return 0 == this.Y
    };
    F.clear = function () {
        this.Aa = {};
        this.Oc = this.Y = this.Z.length = 0
    };
    F.remove = function (b) {
        return H.P.Map.Jb(this.Aa, b) ? (delete this.Aa[b], this.Y--, this.Oc++, this.Z.length > 2 * this.Y && N(this), !0) : !1
    };
    function N(b) {
        if (b.Y != b.Z.length) {
            for (var c = 0, d = 0; c < b.Z.length;) {
                var e = b.Z[c];
                H.P.Map.Jb(b.Aa, e) && (b.Z[d++] = e);
                c++
            }
            b.Z.length = d
        }
        if (b.Y != b.Z.length) {
            var f = {};
            for (d = c = 0; c < b.Z.length;)e = b.Z[c], H.P.Map.Jb(f, e) || (b.Z[d++] = e, f[e] = 1), c++;
            b.Z.length = d
        }
    }

    F.get = function (b, c) {
        return H.P.Map.Jb(this.Aa, b) ? this.Aa[b] : c
    };
    F.set = function (b, c) {
        H.P.Map.Jb(this.Aa, b) || (this.Y++, this.Z.push(b), this.Oc++);
        this.Aa[b] = c
    };
    F.addAll = function (b) {
        if (b instanceof H.P.Map)for (var c = b.ja(), d = 0; d < c.length; d++)this.set(c[d], b.get(c[d])); else for (c in b)this.set(c, b[c])
    };
    F.forEach = function (b, c) {
        for (var d = this.ja(), e = 0; e < d.length; e++) {
            var f = d[e], g = this.get(f);
            b.call(c, g, f, this)
        }
    };
    F.clone = function () {
        return new H.P.Map(this)
    };
    F.to = function () {
        for (var b = new H.P.Map, c = 0; c < this.Z.length; c++) {
            var d = this.Z[c];
            b.set(this.Aa[d], d)
        }
        return b
    };
    F.ro = function () {
        N(this);
        for (var b = {}, c = 0; c < this.Z.length; c++) {
            var d = this.Z[c];
            b[d] = this.Aa[d]
        }
        return b
    };
    F.me = function (b) {
        N(this);
        var c = 0, d = this.Oc, e = this, f = new H.o.Iterator;
        f.next = function () {
            if (d != e.Oc)throw Error("The map has changed since the iterator was created");
            if (c >= e.Z.length)throw H.o.sa;
            var g = e.Z[c++];
            return b ? g : e.Aa[g]
        };
        return f
    };
    H.P.Map.Jb = function (b, c) {
        return Object.prototype.hasOwnProperty.call(b, c)
    };
    H.P.qb = function (b) {
        return b.qb && typeof b.qb == q ? b.qb() : H.ka(b) || typeof b === x ? b.length : H.object.qb(b)
    };
    H.P.ea = function (b) {
        if (b.ea && typeof b.ea == q)return b.ea();
        if (typeof b === x)return b.split("");
        if (H.ka(b)) {
            for (var c = [], d = b.length, e = 0; e < d; e++)c.push(b[e]);
            return c
        }
        return H.object.ea(b)
    };
    H.P.ja = function (b) {
        if (b.ja && typeof b.ja == q)return b.ja();
        if (!b.ea || typeof b.ea != q) {
            if (H.ka(b) || typeof b === x) {
                var c = [];
                b = b.length;
                for (var d = 0; d < b; d++)c.push(d);
                return c
            }
            return H.object.ja(b)
        }
    };
    H.P.contains = function (b, c) {
        return b.contains && typeof b.contains == q ? b.contains(c) : b.Gb && typeof b.Gb == q ? b.Gb(c) : H.ka(b) || typeof b === x ? H.g.contains(b, c) : H.object.Gb(b, c)
    };
    H.P.za = function (b) {
        return b.za && typeof b.za == q ? b.za() : H.ka(b) || typeof b === x ? H.g.za(b) : H.object.za(b)
    };
    H.P.clear = function (b) {
        b.clear && typeof b.clear == q ? b.clear() : H.ka(b) ? H.g.clear(b) : H.object.clear(b)
    };
    H.P.forEach = function (b, c, d) {
        if (b.forEach && typeof b.forEach == q) b.forEach(c, d); else if (H.ka(b) || typeof b === x) H.g.forEach(b, c, d); else for (var e = H.P.ja(b), f = H.P.ea(b), g = f.length, h = 0; h < g; h++)c.call(d, f[h], e && e[h], b)
    };
    H.P.filter = function (b, c, d) {
        if (typeof b.filter == q)return b.filter(c, d);
        if (H.ka(b) || typeof b === x)return H.g.filter(b, c, d);
        var e = H.P.ja(b), f = H.P.ea(b), g = f.length;
        if (e) {
            var h = {};
            for (var k = 0; k < g; k++)c.call(d, f[k], e[k], b) && (h[e[k]] = f[k])
        } else for (h = [], k = 0; k < g; k++)c.call(d, f[k], void 0, b) && h.push(f[k]);
        return h
    };
    H.P.map = function (b, c, d) {
        if (typeof b.map == q)return b.map(c, d);
        if (H.ka(b) || typeof b === x)return H.g.map(b, c, d);
        var e = H.P.ja(b), f = H.P.ea(b), g = f.length;
        if (e) {
            var h = {};
            for (var k = 0; k < g; k++)h[e[k]] = c.call(d, f[k], e[k], b)
        } else for (h = [], k = 0; k < g; k++)h[k] = c.call(d, f[k], void 0, b);
        return h
    };
    H.P.some = function (b, c, d) {
        if (typeof b.some == q)return b.some(c, d);
        if (H.ka(b) || typeof b === x)return H.g.some(b, c, d);
        for (var e = H.P.ja(b), f = H.P.ea(b), g = f.length, h = 0; h < g; h++)if (c.call(d, f[h], e && e[h], b))return !0;
        return !1
    };
    H.P.every = function (b, c, d) {
        if (typeof b.every == q)return b.every(c, d);
        if (H.ka(b) || typeof b === x)return H.g.every(b, c, d);
        for (var e = H.P.ja(b), f = H.P.ea(b), g = f.length, h = 0; h < g; h++)if (!c.call(d, f[h], e && e[h], b))return !1;
        return !0
    };
    H.uri = {};
    H.uri.l = {};
    H.uri.l.nc = {Df: 38, EQUAL: 61, Xj: 35, gk: 63};
    H.uri.l.re = function (b, c, d, e, f, g, h) {
        var k = "";
        b && (k += b + ":");
        d && (k += "//", c && (k += c + "@"), k += d, e && (k += ":" + e));
        f && (k += f);
        g && (k += "?" + g);
        h && (k += "#" + h);
        return k
    };
    H.uri.l.io = /^(?:([^:/?#.]+):)?(?:\/\/(?:([^/?#]*)@)?([^/#?]*?)(?::([0-9]+))?(?=[/#?]|$))?([^?#]+)?(?:\?([^#]*))?(?:#([\s\S]*))?$/;
    H.uri.l.T = {Tb: 1, ke: 2, ib: 3, lb: 4, fe: 5, ge: 6, Xf: 7};
    H.uri.l.split = function (b) {
        return b.match(H.uri.l.io)
    };
    H.uri.l.gd = function (b, c) {
        return b ? c ? decodeURI(b) : decodeURIComponent(b) : b
    };
    H.uri.l.Xb = function (b, c) {
        return H.uri.l.split(c)[b] || null
    };
    H.uri.l.Dc = function (b) {
        return H.uri.l.Xb(H.uri.l.T.Tb, b)
    };
    H.uri.l.pu = function (b) {
        b = H.uri.l.Dc(b);
        !b && H.global.self && H.global.self.location && (b = H.global.self.location.protocol, b = b.substr(0, b.length - 1));
        return b ? b.toLowerCase() : ""
    };
    H.uri.l.km = function () {
        return H.uri.l.Xb(H.uri.l.T.ke, void 0)
    };
    H.uri.l.rd = function () {
        return H.uri.l.gd(H.uri.l.km())
    };
    H.uri.l.Wl = function () {
        return H.uri.l.Xb(H.uri.l.T.ib, void 0)
    };
    H.uri.l.ld = function () {
        return H.uri.l.gd(H.uri.l.Wl(), !0)
    };
    H.uri.l.pd = function () {
        return Number(H.uri.l.Xb(H.uri.l.T.lb, void 0)) || null
    };
    H.uri.l.cm = function () {
        return H.uri.l.Xb(H.uri.l.T.fe, void 0)
    };
    H.uri.l.Yb = function () {
        return H.uri.l.gd(H.uri.l.cm(), !0)
    };
    H.uri.l.Qe = function () {
        return H.uri.l.Xb(H.uri.l.T.ge, void 0)
    };
    H.uri.l.Zl = function () {
        var b = (void 0).indexOf("#");
        return 0 > b ? null : (void 0).substr(b + 1)
    };
    H.uri.l.Iw = function (b, c) {
        return H.uri.l.Bn(b) + (c ? "#" + c : "")
    };
    H.uri.l.nd = function () {
        return H.uri.l.gd(H.uri.l.Zl())
    };
    H.uri.l.ru = function (b) {
        b = H.uri.l.split(b);
        return H.uri.l.re(b[H.uri.l.T.Tb], b[H.uri.l.T.ke], b[H.uri.l.T.ib], b[H.uri.l.T.lb])
    };
    H.uri.l.wu = function (b) {
        b = H.uri.l.split(b);
        return H.uri.l.re(b[H.uri.l.T.Tb], null, b[H.uri.l.T.ib], b[H.uri.l.T.lb])
    };
    H.uri.l.Au = function (b) {
        b = H.uri.l.split(b);
        return H.uri.l.re(null, null, null, null, b[H.uri.l.T.fe], b[H.uri.l.T.ge], b[H.uri.l.T.Xf])
    };
    H.uri.l.Bn = function (b) {
        var c = b.indexOf("#");
        return 0 > c ? b : b.substr(0, c)
    };
    H.uri.l.tm = function (b, c) {
        b = H.uri.l.split(b);
        c = H.uri.l.split(c);
        return b[H.uri.l.T.ib] == c[H.uri.l.T.ib] && b[H.uri.l.T.Tb] == c[H.uri.l.T.Tb] && b[H.uri.l.T.lb] == c[H.uri.l.T.lb]
    };
    H.uri.l.Ks = A();
    H.uri.l.pn = function (b, c) {
        if (b) {
            b = b.split("&");
            for (var d = 0; d < b.length; d++) {
                var e = b[d].indexOf("="), f = null;
                if (0 <= e) {
                    var g = b[d].substring(0, e);
                    f = b[d].substring(e + 1)
                } else g = b[d];
                c(g, f ? H.c.Ud(f) : "")
            }
        }
    };
    H.uri.l.Vi = function (b) {
        var c = b.indexOf("#");
        0 > c && (c = b.length);
        var d = b.indexOf("?");
        if (0 > d || d > c) {
            d = c;
            var e = ""
        } else e = b.substring(d + 1, c);
        return [b.substr(0, d), e, b.substr(c)]
    };
    H.uri.l.ti = function (b) {
        return b[0] + (b[1] ? "?" + b[1] : "") + b[2]
    };
    H.uri.l.ug = function (b, c) {
        return c ? b ? b + "&" + c : c : b
    };
    H.uri.l.oe = function (b, c) {
        if (!c)return b;
        b = H.uri.l.Vi(b);
        b[1] = H.uri.l.ug(b[1], c);
        return H.uri.l.ti(b)
    };
    H.uri.l.ne = function (b, c, d) {
        if (H.isArray(c))for (var e = 0; e < c.length; e++)H.uri.l.ne(b, String(c[e]), d); else null != c && d.push(b + ("" === c ? "" : "=" + H.c.Nc(c)))
    };
    H.uri.l.Eg = function (b, c) {
        var d = [];
        for (c = c || 0; c < b.length; c += 2)H.uri.l.ne(b[c], b[c + 1], d);
        return d.join("&")
    };
    H.uri.l.Fg = function (b) {
        var c = [], d;
        for (d in b)H.uri.l.ne(d, b[d], c);
        return c.join("&")
    };
    H.uri.l.xs = function (b, c) {
        var d = 2 == arguments.length ? H.uri.l.Eg(arguments[1], 0) : H.uri.l.Eg(arguments, 1);
        return H.uri.l.oe(b, d)
    };
    H.uri.l.ys = function (b, c) {
        c = H.uri.l.Fg(c);
        return H.uri.l.oe(b, c)
    };
    H.uri.l.Jk = function (b, c, d) {
        d = null != d ? "=" + H.c.Nc(d) : "";
        return H.uri.l.oe(b, c + d)
    };
    H.uri.l.kd = function (b, c, d, e) {
        for (var f = d.length; 0 <= (c = b.indexOf(d, c)) && c < e;) {
            var g = b.charCodeAt(c - 1);
            if (g == H.uri.l.nc.Df || g == H.uri.l.nc.gk)if (g = b.charCodeAt(c + f), !g || g == H.uri.l.nc.EQUAL || g == H.uri.l.nc.Df || g == H.uri.l.nc.Xj)return c;
            c += f + 1
        }
        return -1
    };
    H.uri.l.ud = /#|$/;
    H.uri.l.Lu = function (b, c) {
        return 0 <= H.uri.l.kd(b, 0, c, b.search(H.uri.l.ud))
    };
    H.uri.l.yu = function (b, c) {
        var d = b.search(H.uri.l.ud), e = H.uri.l.kd(b, 0, c, d);
        if (0 > e)return null;
        var f = b.indexOf("&", e);
        if (0 > f || f > d) f = d;
        e += c.length + 1;
        return H.c.Ud(b.substr(e, f - e))
    };
    H.uri.l.zu = function (b, c) {
        for (var d = b.search(H.uri.l.ud), e = 0, f, g = []; 0 <= (f = H.uri.l.kd(b, e, c, d));) {
            e = b.indexOf("&", f);
            if (0 > e || e > d) e = d;
            f += c.length + 1;
            g.push(H.c.Ud(b.substr(f, e - f)))
        }
        return g
    };
    H.uri.l.so = /[?&]($|#)/;
    H.uri.l.Cn = function (b, c) {
        for (var d = b.search(H.uri.l.ud), e = 0, f, g = []; 0 <= (f = H.uri.l.kd(b, e, c, d));)g.push(b.substring(e, f)), e = Math.min(b.indexOf("&", f) + 1 || d, d);
        g.push(b.substr(e));
        return g.join("").replace(H.uri.l.so, "$1")
    };
    H.uri.l.$n = function (b) {
        var c = H.uri.l.mg.kg, d = H.c.Gh();
        return H.uri.l.Jk(H.uri.l.Cn(b, c), c, d)
    };
    H.uri.l.Rw = function (b, c) {
        b = H.uri.l.Vi(b);
        var d = b[1], e = [];
        d && H.g.forEach(d.split("&"), function (f) {
            var g = f.indexOf("=");
            c.hasOwnProperty(0 <= g ? f.substr(0, g) : f) || e.push(f)
        });
        b[1] = H.uri.l.ug(e.join("&"), H.uri.l.Fg(c));
        return H.uri.l.ti(b)
    };
    H.uri.l.zs = function (b, c) {
        H.c.endsWith(b, "/") && (b = b.substr(0, b.length - 1));
        H.c.startsWith(c, "/") && (c = c.substr(1));
        return H.c.gl(b, "/", c)
    };
    H.uri.l.Mc = function (b) {
        H.uri.l.split(b)
    };
    H.uri.l.mg = {kg: "zx"};
    H.uri.l.fn = function (b) {
        return H.uri.l.$n(b)
    };
    H.H = function (b, c) {
        this.xc = this.Bf = this.ic = "";
        this.Dd = null;
        this.De = this.Cd = "";
        this.Ja = this.Km = !1;
        var d;
        b instanceof H.H ? (this.Ja = void 0 !== c ? c : b.Ja, O(this, b.Dc()), P(this, b.rd()), Q(this, b.ld()), R(this, b.pd()), this.Mc(b.Yb()), S(this, b.Qe().clone()), T(this, b.nd())) : b && (d = H.uri.l.split(String(b))) ? (this.Ja = !!c, O(this, d[H.uri.l.T.Tb] || "", !0), P(this, d[H.uri.l.T.ke] || "", !0), Q(this, d[H.uri.l.T.ib] || "", !0), R(this, d[H.uri.l.T.lb]), this.Mc(d[H.uri.l.T.fe] || "", !0), S(this, d[H.uri.l.T.ge] || "", !0), T(this, d[H.uri.l.T.Xf] ||
            "", !0)) : (this.Ja = !!c, this.La = new H.H.Ya(null, this.Ja))
    };
    H.H.hk = H.uri.l.mg.kg;
    F = H.H.prototype;
    F.toString = function () {
        var b = [], c = this.Dc();
        c && b.push(H.H.yc(c, H.H.Ii, !0), ":");
        var d = this.ld();
        if (d || "file" == c) b.push("//"), (c = this.rd()) && b.push(H.H.yc(c, H.H.Ii, !0), "@"), b.push(H.H.Ji(H.c.Nc(d))), d = this.pd(), null != d && b.push(":", String(d));
        if (d = this.Yb()) this.xc && "/" != d.charAt(0) && b.push("/"), b.push(H.H.yc(d, "/" == d.charAt(0) ? H.H.vn : H.H.yn, !0));
        (d = this.La.toString()) && b.push("?", d);
        (d = this.nd()) && b.push("#", H.H.yc(d, H.H.wn));
        return b.join("")
    };
    F.resolve = function (b) {
        var c = this.clone(), d = !!b.ic;
        d ? O(c, b.Dc()) : d = !!b.Bf;
        d ? P(c, b.rd()) : d = !!b.xc;
        d ? Q(c, b.ld()) : d = null != b.Dd;
        var e = b.Yb();
        if (d) R(c, b.pd()); else if (d = !!b.Cd) {
            if ("/" != e.charAt(0))if (this.xc && !this.Cd) e = "/" + e; else {
                var f = c.Yb().lastIndexOf("/");
                -1 != f && (e = c.Yb().substr(0, f + 1) + e)
            }
            e = H.H.zn(e)
        }
        d ? c.Mc(e) : d = "" !== b.La.toString();
        d ? S(c, b.Qe().clone()) : d = !!b.De;
        d && T(c, b.nd());
        return c
    };
    F.clone = function () {
        return new H.H(this)
    };
    F.Dc = C("ic");
    function O(b, c, d) {
        U(b);
        b.ic = d ? H.H.wc(c, !0) : c;
        b.ic && (b.ic = b.ic.replace(/:$/, ""))
    }

    F.rd = C("Bf");
    function P(b, c, d) {
        U(b);
        b.Bf = d ? H.H.wc(c) : c
    }

    F.ld = C("xc");
    function Q(b, c, d) {
        U(b);
        b.xc = d ? H.H.wc(c, !0) : c
    }

    F.pd = C("Dd");
    function R(b, c) {
        U(b);
        if (c) {
            c = Number(c);
            if (isNaN(c) || 0 > c)throw Error("Bad port number " + c);
            b.Dd = c
        } else b.Dd = null
    }

    F.Yb = C("Cd");
    F.Mc = function (b, c) {
        U(this);
        this.Cd = c ? H.H.wc(b, !0) : b
    };
    function S(b, c, d) {
        U(b);
        c instanceof H.H.Ya ? (b.La = c, b.La.qf(b.Ja)) : (d || (c = H.H.yc(c, H.H.xn)), b.La = new H.H.Ya(c, b.Ja))
    }

    F.Qe = C("La");
    F.getQuery = function () {
        return this.La.toString()
    };
    F.nd = C("De");
    function T(b, c, d) {
        U(b);
        b.De = d ? H.H.wc(c) : c
    }

    F.fn = function () {
        U(this);
        var b = H.H.hk, c = H.c.Gh();
        U(this);
        this.La.set(b, c);
        return this
    };
    F.removeParameter = function (b) {
        U(this);
        this.La.remove(b);
        return this
    };
    function U(b) {
        if (b.Km)throw Error("Tried to modify a read-only Uri");
    }

    F.qf = function (b) {
        this.Ja = b;
        this.La && this.La.qf(b)
    };
    H.H.parse = function (b, c) {
        return b instanceof H.H ? b.clone() : new H.H(b, c)
    };
    H.H.create = function (b, c, d, e, f, g, h, k) {
        k = new H.H(null, k);
        b && O(k, b);
        c && P(k, c);
        d && Q(k, d);
        e && R(k, e);
        f && k.Mc(f);
        g && S(k, g);
        h && T(k, h);
        return k
    };
    H.H.resolve = function (b, c) {
        b instanceof H.H || (b = H.H.parse(b));
        c instanceof H.H || (c = H.H.parse(c));
        return b.resolve(c)
    };
    H.H.zn = function (b) {
        if (".." == b || "." == b)return "";
        if (H.c.contains(b, "./") || H.c.contains(b, "/.")) {
            var c = H.c.startsWith(b, "/");
            b = b.split("/");
            for (var d = [], e = 0; e < b.length;) {
                var f = b[e++];
                "." == f ? c && e == b.length && d.push("") : ".." == f ? ((1 < d.length || 1 == d.length && "" != d[0]) && d.pop(), c && e == b.length && d.push("")) : (d.push(f), c = !0)
            }
            return d.join("/")
        }
        return b
    };
    H.H.wc = function (b, c) {
        return b ? c ? decodeURI(b.replace(/%25/g, "%2525")) : decodeURIComponent(b) : ""
    };
    H.H.yc = function (b, c, d) {
        return typeof b === x ? (b = encodeURI(b).replace(c, H.H.El), d && (b = H.H.Ji(b)), b) : null
    };
    H.H.El = function (b) {
        b = b.charCodeAt(0);
        return "%" + (b >> 4 & 15).toString(16) + (b & 15).toString(16)
    };
    H.H.Ji = function (b) {
        return b.replace(/%25([0-9a-fA-F]{2})/g, "%$1")
    };
    H.H.Ii = /[#\/\?@]/g;
    H.H.yn = /[#\?:]/g;
    H.H.vn = /[#\?]/g;
    H.H.xn = /[#\?@]/g;
    H.H.wn = /#/g;
    H.H.tm = function (b, c) {
        b = H.uri.l.split(b);
        c = H.uri.l.split(c);
        return b[H.uri.l.T.ib] == c[H.uri.l.T.ib] && b[H.uri.l.T.lb] == c[H.uri.l.T.lb]
    };
    H.H.Ya = function (b, c) {
        this.Y = this.ba = null;
        this.Ha = b || null;
        this.Ja = !!c
    };
    function Y(b) {
        b.ba || (b.ba = new H.P.Map, b.Y = 0, b.Ha && H.uri.l.pn(b.Ha, function (c, d) {
            b.add(H.c.Ud(c), d)
        }))
    }

    H.H.Ya.ot = function (b, c, d) {
        c = H.P.ja(b);
        if ("undefined" == typeof c)throw Error("Keys are undefined");
        d = new H.H.Ya(null, d);
        b = H.P.ea(b);
        for (var e = 0; e < c.length; e++) {
            var f = c[e], g = b[e];
            H.isArray(g) ? ua(d, f, g) : d.add(f, g)
        }
        return d
    };
    H.H.Ya.nt = function (b, c, d, e) {
        if (b.length != c.length)throw Error("Mismatched lengths for keys/values");
        d = new H.H.Ya(null, e);
        for (e = 0; e < b.length; e++)d.add(b[e], c[e]);
        return d
    };
    F = H.H.Ya.prototype;
    F.qb = function () {
        Y(this);
        return this.Y
    };
    F.add = function (b, c) {
        Y(this);
        this.Ha = null;
        b = Z(this, b);
        var d = this.ba.get(b);
        d || this.ba.set(b, d = []);
        d.push(c);
        this.Y += 1;
        return this
    };
    F.remove = function (b) {
        Y(this);
        b = Z(this, b);
        return this.ba.Fb(b) ? (this.Ha = null, this.Y -= this.ba.get(b).length, this.ba.remove(b)) : !1
    };
    F.clear = function () {
        this.ba = this.Ha = null;
        this.Y = 0
    };
    F.za = function () {
        Y(this);
        return 0 == this.Y
    };
    F.Fb = function (b) {
        Y(this);
        b = Z(this, b);
        return this.ba.Fb(b)
    };
    F.Gb = function (b) {
        var c = this.ea();
        return H.g.contains(c, b)
    };
    F.forEach = function (b, c) {
        Y(this);
        this.ba.forEach(function (d, e) {
            H.g.forEach(d, function (f) {
                b.call(c, f, e, this)
            }, this)
        }, this)
    };
    F.ja = function () {
        Y(this);
        for (var b = this.ba.ea(), c = this.ba.ja(), d = [], e = 0; e < c.length; e++)for (var f = b[e], g = 0; g < f.length; g++)d.push(c[e]);
        return d
    };
    F.ea = function (b) {
        Y(this);
        var c = [];
        if (typeof b === x) this.Fb(b) && (c = H.g.concat(c, this.ba.get(Z(this, b)))); else {
            b = this.ba.ea();
            for (var d = 0; d < b.length; d++)c = H.g.concat(c, b[d])
        }
        return c
    };
    F.set = function (b, c) {
        Y(this);
        this.Ha = null;
        b = Z(this, b);
        this.Fb(b) && (this.Y -= this.ba.get(b).length);
        this.ba.set(b, [c]);
        this.Y += 1;
        return this
    };
    F.get = function (b, c) {
        if (!b)return c;
        b = this.ea(b);
        return 0 < b.length ? String(b[0]) : c
    };
    function ua(b, c, d) {
        b.remove(c);
        0 < d.length && (b.Ha = null, b.ba.set(Z(b, c), H.g.clone(d)), b.Y += d.length)
    }

    F.toString = function () {
        if (this.Ha)return this.Ha;
        if (!this.ba)return "";
        for (var b = [], c = this.ba.ja(), d = 0; d < c.length; d++) {
            var e = c[d], f = H.c.Nc(e);
            e = this.ea(e);
            for (var g = 0; g < e.length; g++) {
                var h = f;
                "" !== e[g] && (h += "=" + H.c.Nc(e[g]));
                b.push(h)
            }
        }
        return this.Ha = b.join("&")
    };
    F.clone = function () {
        var b = new H.H.Ya;
        b.Ha = this.Ha;
        this.ba && (b.ba = this.ba.clone(), b.Y = this.Y);
        return b
    };
    function Z(b, c) {
        c = String(c);
        b.Ja && (c = c.toLowerCase());
        return c
    }

    F.qf = function (b) {
        b && !this.Ja && (Y(this), this.Ha = null, this.ba.forEach(function (c, d) {
            var e = d.toLowerCase();
            d != e && (this.remove(d), ua(this, e, c))
        }, this));
        this.Ja = b
    };
    F.extend = function (b) {
        for (var c = 0; c < arguments.length; c++)H.P.forEach(arguments[c], function (d, e) {
            this.add(e, d)
        }, this)
    };
    var google = {v: {}};
    google.v.w = {};
    google.v.w.ha = {};
    google.v.w.ha.ri = function () {
        return new Promise(function (b) {
            if ("undefined" == typeof window || "complete" === document.readyState) b(); else if (window.addEventListener) document.addEventListener("DOMContentLoaded", b, !0), window.addEventListener("load", b, !0); else if (window.attachEvent) window.attachEvent("onload", b); else {
                var c = window.onload;
                H.Sa(c) ? window.onload = function (d) {
                    c(d);
                    b()
                } : window.onload = b
            }
        })
    };
    H.Ac("google.charts.loader.Utils.isWindowLoaded", google.v.w.ha.ri);
    google.v.w.ha.eb = {};
    google.v.w.ha.nw = function () {
        google.v.w.ha.eb = {}
    };
    google.v.w.ha.Eu = function (b) {
        return google.v.w.ha.eb[b] && google.v.w.ha.eb[b].Jd
    };
    google.v.w.ha.Du = function (b) {
        return google.v.w.ha.eb[b] && google.v.w.ha.eb[b].loaded
    };
    google.v.w.ha.Sw = function (b, c) {
        google.v.w.ha.eb[b] = {Jd: c, loaded: !1}
    };
    google.v.w.ha.ao = function (b) {
        google.v.w.ha.eb[b] || (google.v.w.ha.eb[b] = {loaded: !1});
        google.v.w.ha.eb[b].loaded = !0
    };
    google.v.w.Va = {};
    google.v.w.Va.cj = 3E4;
    google.v.w.Va.Kv = function (b, c) {
        return {format: b, Kk: c}
    };
    google.v.w.Va.im = function (b) {
        return H.b.I.format(b.format, b.Kk)
    };
    google.v.w.Va.load = function (b, c) {
        var d = H.b.I.format(b, c), e = H.M.O.Md(d, {timeout: google.v.w.Va.cj, attributes: {async: !1, defer: !1}});
        return new Promise(function (f) {
            google.v.w.ha.ao(d.toString());
            L(e, f)
        })
    };
    google.v.w.Va.Fv = function (b) {
        b = H.g.map(b, google.v.w.Va.im);
        if (H.g.za(b))return Promise.resolve();
        var c = {timeout: google.v.w.Va.cj, attributes: {async: !1, defer: !1}}, d = [];
        !H.userAgent.ma || H.userAgent.Ta(11) ? H.g.forEach(b, function (e) {
            d.push(H.M.O.Md(e, c))
        }) : d.push(H.M.O.Qn(b, c));
        return Promise.all(H.g.map(d, function (e) {
            return new Promise(function (f) {
                return L(e, f)
            })
        }))
    };
    google.v.w.K = {};
    if (H.sb(ba))throw Error("Google Charts loader.js can only be loaded once.");
    google.v.w.K.Ho = {
        1: "1.0",
        "1.0": "current",
        "1.1": "upcoming",
        41: v,
        42: v,
        43: v,
        44: v,
        46: "46.1",
        "46.1": "46.2",
        previous: "45.2",
        current: "46",
        upcoming: "47"
    };
    google.v.w.K.gn = function (b) {
        var c = b, d = b.match(/^testing-/);
        d && (c = c.replace(/^testing-/, ""));
        b = c;
        do {
            var e = google.v.w.K.Ho[c];
            e && (c = e)
        } while (e);
        d = (d ? "testing-" : "") + c;
        return {version: c == v ? b : d, $m: d}
    };
    google.v.w.K.jj = null;
    google.v.w.K.Zm = function (b) {
        var c = google.v.w.K.gn(b), d = H.c.L.from("https://www.gstatic.com/charts/%{version}/loader.js");
        return google.v.w.Va.load(d, {version: c.$m}).then(function () {
            var e = H.sb("google.charts.loader.VersionSpecific.load") || H.sb("google.charts.loader.publicLoad") || H.sb("google.charts.versionSpecific.load");
            if (!e)throw Error("Bad version: " + b);
            google.v.w.K.jj = function (f) {
                f = e(c.version, f);
                if (null == f || null == f.then) {
                    var g = H.sb("google.charts.loader.publicSetOnLoadCallback") || H.sb("google.charts.versionSpecific.setOnLoadCallback");
                    f = new Promise(function (h) {
                        g(h)
                    });
                    f.then = g
                }
                return f
            }
        })
    };
    google.v.w.K.$e = null;
    google.v.w.K.ed = null;
    google.v.w.K.Wm = function (b, c) {
        if (!google.v.w.K.$e) {
            if (c.enableUrlSettings && window.URLSearchParams)try {
                b = (new URLSearchParams(top.location.search)).get("charts-version") || b
            } catch (d) {
                console.info("Failed to get charts-version from top URL", d)
            }
            google.v.w.K.$e = google.v.w.K.Zm(b)
        }
        return google.v.w.K.ed = google.v.w.K.$e.then(function () {
            return google.v.w.K.jj(c)
        })
    };
    google.v.w.K.Zn = function (b) {
        if (!google.v.w.K.ed)throw Error("Must call google.charts.load before google.charts.setOnLoadCallback");
        return b ? google.v.w.K.ed.then(b) : google.v.w.K.ed
    };
    google.v.load = function (b) {
        for (var c = [], d = 0; d < arguments.length; ++d)c[d - 0] = arguments[d];
        d = 0;
        "visualization" === c[d] && d++;
        var e = "current";
        typeof c[d] === x && (e = c[d], d++);
        var f = {};
        H.Ea(c[d]) && (f = c[d]);
        return google.v.w.K.Wm(e, f)
    };
    H.Ac(ba, google.v.load);
    google.v.Ti = google.v.w.K.Zn;
    H.Ac("google.charts.setOnLoadCallback", google.v.Ti);
    google.v.w.K.ck = H.c.L.from("https://maps.googleapis.com/maps/api/js?jsapiRedirect=true&key=%{key}&v=%{version}&libraries=%{libraries}");
    google.v.w.K.dk = H.c.L.from("https://maps-api-ssl.google.com/maps?jsapiRedirect=true&file=googleapi&key=%{key}&v=%{version}&libraries=%{libraries}");
    google.v.w.K.Xm = function (b, c, d) {
        console.warn("Loading Maps API with the jsapi loader is deprecated.");
        d = d || {};
        b = google.v.w.K.xi(d.callback);
        google.v.w.Va.load("2" === c ? google.v.w.K.dk : google.v.w.K.ck, {
            key: d.key || d.client || "",
            version: c || "",
            libraries: d.libraries || ""
        }).then(b)
    };
    google.v.w.K.xi = function (b) {
        return function () {
            if (typeof b === x && "" !== b)try {
                H.sb(b)()
            } catch (c) {
                throw Error("Callback failed with: " + c);
            }
        }
    };
    google.v.w.K.Ph = function (b) {
        for (var c = [], d = 0; d < arguments.length; ++d)c[d - 0] = arguments[d];
        if ("maps" === c[0]) google.v.w.K.Xm.apply(google.v.w.K, G.xg(c)); else {
            if ("visualization" !== c[0])throw Error('Module "' + c[0] + '" is not supported.');
            google.v.load.apply(google.v, G.xg(c))
        }
    };
    google.v.w.K.tn = function (b) {
        typeof b === x && (b = google.v.w.K.xi(b), google.v.w.ha.ri().then(b))
    };
    google.v.w.K.sn = function (b) {
        if (typeof b === x)try {
            if ("" !== b)for (var c = JSON.parse(b).modules, d = G.zd(c), e = d.next(); !e.done; e = d.next()) {
                var f = e.value;
                google.v.w.K.Ph(f.name, f.version, f)
            }
        } catch (g) {
            throw Error("Autoload failed with: " + g);
        }
    };
    google.v.w.K.Ll = function () {
        H.sb("google.load") || (H.Ac("google.load", google.v.w.K.Ph), H.Ac("google.setOnLoadCallback", google.v.Ti))
    };
    google.v.w.K.un = function () {
        google.v.w.K.Ll();
        var b = document.getElementsByTagName(w);
        b = b[b.length - 1].getAttribute("src");
        b = (new H.H(b)).La.toString();
        b = new H.H.Ya(b);
        google.v.w.K.tn(b.get("callback"));
        google.v.w.K.sn(b.get("autoload"))
    };
    google.v.w.K.un();
}).call(this);
