!function () {
    function t(e, a, i) {
        function o(r, s) {
            if (!a[r]) {
                if (!e[r]) {
                    var l = "function" == typeof require && require;
                    if (!s && l) return l(r, !0);
                    if (n) return n(r, !0);
                    var d = new Error("Cannot find module '" + r + "'");
                    throw d.code = "MODULE_NOT_FOUND", d
                }
                var c = a[r] = {exports: {}};
                e[r][0].call(c.exports, function (t) {
                    return o(e[r][1][t] || t)
                }, c, c.exports, t, e, a, i)
            }
            return a[r].exports
        }

        for (var n = "function" == typeof require && require, r = 0; r < i.length; r++) o(i[r]);
        return o
    }

    return t
}()({
    1: [function (t, e, a) {/*!
 * Bootstrap v3.3.7 (http://getbootstrap.com)
 * Copyright 2011-2016 Twitter, Inc.
 * Licensed under the MIT license
 */
        if ("undefined" == typeof jQuery) throw new Error("Bootstrap's JavaScript requires jQuery");
        +function (t) {
            "use strict";
            var e = t.fn.jquery.split(" ")[0].split(".");
            if (e[0] < 2 && e[1] < 9 || 1 == e[0] && 9 == e[1] && e[2] < 1 || e[0] > 3) throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher, but lower than version 4")
        }(jQuery), function (t) {
            "use strict";

            function e() {
                var t = document.createElement("bootstrap"), e = {
                    WebkitTransition: "webkitTransitionEnd",
                    MozTransition: "transitionend",
                    OTransition: "oTransitionEnd otransitionend",
                    transition: "transitionend"
                };
                for (var a in e) if (void 0 !== t.style[a]) return {end: e[a]};
                return !1
            }

            t.fn.emulateTransitionEnd = function (e) {
                var a = !1, i = this;
                t(this).one("bsTransitionEnd", function () {
                    a = !0
                });
                var o = function () {
                    a || t(i).trigger(t.support.transition.end)
                };
                return setTimeout(o, e), this
            }, t(function () {
                t.support.transition = e(), t.support.transition && (t.event.special.bsTransitionEnd = {
                    bindType: t.support.transition.end,
                    delegateType: t.support.transition.end,
                    handle: function (e) {
                        if (t(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
                    }
                })
            })
        }(jQuery), function (t) {
            "use strict";

            function e(e) {
                return this.each(function () {
                    var a = t(this), o = a.data("bs.alert");
                    o || a.data("bs.alert", o = new i(this)), "string" == typeof e && o[e].call(a)
                })
            }

            var a = '[data-dismiss="alert"]', i = function (e) {
                t(e).on("click", a, this.close)
            };
            i.VERSION = "3.3.7", i.TRANSITION_DURATION = 150, i.prototype.close = function (e) {
                function a() {
                    r.detach().trigger("closed.bs.alert").remove()
                }

                var o = t(this), n = o.attr("data-target");
                n || (n = o.attr("href"), n = n && n.replace(/.*(?=#[^\s]*$)/, ""));
                var r = t("#" === n ? [] : n);
                e && e.preventDefault(), r.length || (r = o.closest(".alert")), r.trigger(e = t.Event("close.bs.alert")), e.isDefaultPrevented() || (r.removeClass("in"), t.support.transition && r.hasClass("fade") ? r.one("bsTransitionEnd", a).emulateTransitionEnd(i.TRANSITION_DURATION) : a())
            };
            var o = t.fn.alert;
            t.fn.alert = e, t.fn.alert.Constructor = i, t.fn.alert.noConflict = function () {
                return t.fn.alert = o, this
            }, t(document).on("click.bs.alert.data-api", a, i.prototype.close)
        }(jQuery), function (t) {
            "use strict";

            function e(e) {
                return this.each(function () {
                    var i = t(this), o = i.data("bs.button"), n = "object" == typeof e && e;
                    o || i.data("bs.button", o = new a(this, n)), "toggle" == e ? o.toggle() : e && o.setState(e)
                })
            }

            var a = function (e, i) {
                this.$element = t(e), this.options = t.extend({}, a.DEFAULTS, i), this.isLoading = !1
            };
            a.VERSION = "3.3.7", a.DEFAULTS = {loadingText: "loading..."}, a.prototype.setState = function (e) {
                var a = "disabled", i = this.$element, o = i.is("input") ? "val" : "html", n = i.data();
                e += "Text", null == n.resetText && i.data("resetText", i[o]()), setTimeout(t.proxy(function () {
                    i[o](null == n[e] ? this.options[e] : n[e]), "loadingText" == e ? (this.isLoading = !0, i.addClass(a).attr(a, a).prop(a, !0)) : this.isLoading && (this.isLoading = !1, i.removeClass(a).removeAttr(a).prop(a, !1))
                }, this), 0)
            }, a.prototype.toggle = function () {
                var t = !0, e = this.$element.closest('[data-toggle="buttons"]');
                if (e.length) {
                    var a = this.$element.find("input");
                    "radio" == a.prop("type") ? (a.prop("checked") && (t = !1), e.find(".active").removeClass("active"), this.$element.addClass("active")) : "checkbox" == a.prop("type") && (a.prop("checked") !== this.$element.hasClass("active") && (t = !1), this.$element.toggleClass("active")), a.prop("checked", this.$element.hasClass("active")), t && a.trigger("change")
                } else this.$element.attr("aria-pressed", !this.$element.hasClass("active")), this.$element.toggleClass("active")
            };
            var i = t.fn.button;
            t.fn.button = e, t.fn.button.Constructor = a, t.fn.button.noConflict = function () {
                return t.fn.button = i, this
            }, t(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function (a) {
                var i = t(a.target).closest(".btn");
                e.call(i, "toggle"), t(a.target).is('input[type="radio"], input[type="checkbox"]') || (a.preventDefault(), i.is("input,button") ? i.trigger("focus") : i.find("input:visible,button:visible").first().trigger("focus"))
            }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function (e) {
                t(e.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(e.type))
            })
        }(jQuery), function (t) {
            "use strict";

            function e(e) {
                return this.each(function () {
                    var i = t(this), o = i.data("bs.carousel"),
                        n = t.extend({}, a.DEFAULTS, i.data(), "object" == typeof e && e),
                        r = "string" == typeof e ? e : n.slide;
                    o || i.data("bs.carousel", o = new a(this, n)), "number" == typeof e ? o.to(e) : r ? o[r]() : n.interval && o.pause().cycle()
                })
            }

            var a = function (e, a) {
                this.$element = t(e), this.$indicators = this.$element.find(".carousel-indicators"), this.options = a, this.paused = null, this.sliding = null, this.interval = null, this.$active = null, this.$items = null, this.options.keyboard && this.$element.on("keydown.bs.carousel", t.proxy(this.keydown, this)), "hover" == this.options.pause && !("ontouchstart" in document.documentElement) && this.$element.on("mouseenter.bs.carousel", t.proxy(this.pause, this)).on("mouseleave.bs.carousel", t.proxy(this.cycle, this))
            };
            a.VERSION = "3.3.7", a.TRANSITION_DURATION = 600, a.DEFAULTS = {
                interval: 5e3,
                pause: "hover",
                wrap: !0,
                keyboard: !0
            }, a.prototype.keydown = function (t) {
                if (!/input|textarea/i.test(t.target.tagName)) {
                    switch (t.which) {
                        case 37:
                            this.prev();
                            break;
                        case 39:
                            this.next();
                            break;
                        default:
                            return
                    }
                    t.preventDefault()
                }
            }, a.prototype.cycle = function (e) {
                return e || (this.paused = !1), this.interval && clearInterval(this.interval), this.options.interval && !this.paused && (this.interval = setInterval(t.proxy(this.next, this), this.options.interval)), this
            }, a.prototype.getItemIndex = function (t) {
                return this.$items = t.parent().children(".item"), this.$items.index(t || this.$active)
            }, a.prototype.getItemForDirection = function (t, e) {
                var a = this.getItemIndex(e);
                if (("prev" == t && 0 === a || "next" == t && a == this.$items.length - 1) && !this.options.wrap) return e;
                var i = "prev" == t ? -1 : 1, o = (a + i) % this.$items.length;
                return this.$items.eq(o)
            }, a.prototype.to = function (t) {
                var e = this, a = this.getItemIndex(this.$active = this.$element.find(".item.active"));
                if (!(t > this.$items.length - 1 || t < 0)) return this.sliding ? this.$element.one("slid.bs.carousel", function () {
                    e.to(t)
                }) : a == t ? this.pause().cycle() : this.slide(t > a ? "next" : "prev", this.$items.eq(t))
            }, a.prototype.pause = function (e) {
                return e || (this.paused = !0), this.$element.find(".next, .prev").length && t.support.transition && (this.$element.trigger(t.support.transition.end), this.cycle(!0)), this.interval = clearInterval(this.interval), this
            }, a.prototype.next = function () {
                if (!this.sliding) return this.slide("next")
            }, a.prototype.prev = function () {
                if (!this.sliding) return this.slide("prev")
            }, a.prototype.slide = function (e, i) {
                var o = this.$element.find(".item.active"), n = i || this.getItemForDirection(e, o), r = this.interval,
                    s = "next" == e ? "left" : "right", l = this;
                if (n.hasClass("active")) return this.sliding = !1;
                var d = n[0], c = t.Event("slide.bs.carousel", {relatedTarget: d, direction: s});
                if (this.$element.trigger(c), !c.isDefaultPrevented()) {
                    if (this.sliding = !0, r && this.pause(), this.$indicators.length) {
                        this.$indicators.find(".active").removeClass("active");
                        var p = t(this.$indicators.children()[this.getItemIndex(n)]);
                        p && p.addClass("active")
                    }
                    var u = t.Event("slid.bs.carousel", {relatedTarget: d, direction: s});
                    return t.support.transition && this.$element.hasClass("slide") ? (n.addClass(e), n[0].offsetWidth, o.addClass(s), n.addClass(s), o.one("bsTransitionEnd", function () {
                        n.removeClass([e, s].join(" ")).addClass("active"), o.removeClass(["active", s].join(" ")), l.sliding = !1, setTimeout(function () {
                            l.$element.trigger(u)
                        }, 0)
                    }).emulateTransitionEnd(a.TRANSITION_DURATION)) : (o.removeClass("active"), n.addClass("active"), this.sliding = !1, this.$element.trigger(u)), r && this.cycle(), this
                }
            };
            var i = t.fn.carousel;
            t.fn.carousel = e, t.fn.carousel.Constructor = a, t.fn.carousel.noConflict = function () {
                return t.fn.carousel = i, this
            };
            var o = function (a) {
                var i, o = t(this),
                    n = t(o.attr("data-target") || (i = o.attr("href")) && i.replace(/.*(?=#[^\s]+$)/, ""));
                if (n.hasClass("carousel")) {
                    var r = t.extend({}, n.data(), o.data()), s = o.attr("data-slide-to");
                    s && (r.interval = !1), e.call(n, r), s && n.data("bs.carousel").to(s), a.preventDefault()
                }
            };
            t(document).on("click.bs.carousel.data-api", "[data-slide]", o).on("click.bs.carousel.data-api", "[data-slide-to]", o), t(window).on("load", function () {
                t('[data-ride="carousel"]').each(function () {
                    var a = t(this);
                    e.call(a, a.data())
                })
            })
        }(jQuery), function (t) {
            "use strict";

            function e(e) {
                var a, i = e.attr("data-target") || (a = e.attr("href")) && a.replace(/.*(?=#[^\s]+$)/, "");
                return t(i)
            }

            function a(e) {
                return this.each(function () {
                    var a = t(this), o = a.data("bs.collapse"),
                        n = t.extend({}, i.DEFAULTS, a.data(), "object" == typeof e && e);
                    !o && n.toggle && /show|hide/.test(e) && (n.toggle = !1), o || a.data("bs.collapse", o = new i(this, n)), "string" == typeof e && o[e]()
                })
            }

            var i = function (e, a) {
                this.$element = t(e), this.options = t.extend({}, i.DEFAULTS, a), this.$trigger = t('[data-toggle="collapse"][href="#' + e.id + '"],[data-toggle="collapse"][data-target="#' + e.id + '"]'), this.transitioning = null, this.options.parent ? this.$parent = this.getParent() : this.addAriaAndCollapsedClass(this.$element, this.$trigger), this.options.toggle && this.toggle()
            };
            i.VERSION = "3.3.7", i.TRANSITION_DURATION = 350, i.DEFAULTS = {toggle: !0}, i.prototype.dimension = function () {
                return this.$element.hasClass("width") ? "width" : "height"
            }, i.prototype.show = function () {
                if (!this.transitioning && !this.$element.hasClass("in")) {
                    var e, o = this.$parent && this.$parent.children(".panel").children(".in, .collapsing");
                    if (!(o && o.length && (e = o.data("bs.collapse")) && e.transitioning)) {
                        var n = t.Event("show.bs.collapse");
                        if (this.$element.trigger(n), !n.isDefaultPrevented()) {
                            o && o.length && (a.call(o, "hide"), e || o.data("bs.collapse", null));
                            var r = this.dimension();
                            this.$element.removeClass("collapse").addClass("collapsing")[r](0).attr("aria-expanded", !0), this.$trigger.removeClass("collapsed").attr("aria-expanded", !0), this.transitioning = 1;
                            var s = function () {
                                this.$element.removeClass("collapsing").addClass("collapse in")[r](""), this.transitioning = 0, this.$element.trigger("shown.bs.collapse")
                            };
                            if (!t.support.transition) return s.call(this);
                            var l = t.camelCase(["scroll", r].join("-"));
                            this.$element.one("bsTransitionEnd", t.proxy(s, this)).emulateTransitionEnd(i.TRANSITION_DURATION)[r](this.$element[0][l])
                        }
                    }
                }
            }, i.prototype.hide = function () {
                if (!this.transitioning && this.$element.hasClass("in")) {
                    var e = t.Event("hide.bs.collapse");
                    if (this.$element.trigger(e), !e.isDefaultPrevented()) {
                        var a = this.dimension();
                        this.$element[a](this.$element[a]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded", !1), this.$trigger.addClass("collapsed").attr("aria-expanded", !1), this.transitioning = 1;
                        var o = function () {
                            this.transitioning = 0, this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")
                        };
                        if (!t.support.transition) return o.call(this);
                        this.$element[a](0).one("bsTransitionEnd", t.proxy(o, this)).emulateTransitionEnd(i.TRANSITION_DURATION)
                    }
                }
            }, i.prototype.toggle = function () {
                this[this.$element.hasClass("in") ? "hide" : "show"]()
            }, i.prototype.getParent = function () {
                return t(this.options.parent).find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]').each(t.proxy(function (a, i) {
                    var o = t(i);
                    this.addAriaAndCollapsedClass(e(o), o)
                }, this)).end()
            }, i.prototype.addAriaAndCollapsedClass = function (t, e) {
                var a = t.hasClass("in");
                t.attr("aria-expanded", a), e.toggleClass("collapsed", !a).attr("aria-expanded", a)
            };
            var o = t.fn.collapse;
            t.fn.collapse = a, t.fn.collapse.Constructor = i, t.fn.collapse.noConflict = function () {
                return t.fn.collapse = o, this
            }, t(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function (i) {
                var o = t(this);
                o.attr("data-target") || i.preventDefault();
                var n = e(o), r = n.data("bs.collapse"), s = r ? "toggle" : o.data();
                a.call(n, s)
            })
        }(jQuery), function (t) {
            "use strict";

            function e(e) {
                var a = e.attr("data-target");
                a || (a = e.attr("href"), a = a && /#[A-Za-z]/.test(a) && a.replace(/.*(?=#[^\s]*$)/, ""));
                var i = a && t(a);
                return i && i.length ? i : e.parent()
            }

            function a(a) {
                a && 3 === a.which || (t(o).remove(), t(n).each(function () {
                    var i = t(this), o = e(i), n = {relatedTarget: this};
                    o.hasClass("open") && (a && "click" == a.type && /input|textarea/i.test(a.target.tagName) && t.contains(o[0], a.target) || (o.trigger(a = t.Event("hide.bs.dropdown", n)), a.isDefaultPrevented() || (i.attr("aria-expanded", "false"), o.removeClass("open").trigger(t.Event("hidden.bs.dropdown", n)))))
                }))
            }

            function i(e) {
                return this.each(function () {
                    var a = t(this), i = a.data("bs.dropdown");
                    i || a.data("bs.dropdown", i = new r(this)), "string" == typeof e && i[e].call(a)
                })
            }

            var o = ".dropdown-backdrop", n = '[data-toggle="dropdown"]', r = function (e) {
                t(e).on("click.bs.dropdown", this.toggle)
            };
            r.VERSION = "3.3.7", r.prototype.toggle = function (i) {
                var o = t(this);
                if (!o.is(".disabled, :disabled")) {
                    var n = e(o), r = n.hasClass("open");
                    if (a(), !r) {
                        "ontouchstart" in document.documentElement && !n.closest(".navbar-nav").length && t(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(t(this)).on("click", a);
                        var s = {relatedTarget: this};
                        if (n.trigger(i = t.Event("show.bs.dropdown", s)), i.isDefaultPrevented()) return;
                        o.trigger("focus").attr("aria-expanded", "true"), n.toggleClass("open").trigger(t.Event("shown.bs.dropdown", s))
                    }
                    return !1
                }
            }, r.prototype.keydown = function (a) {
                if (/(38|40|27|32)/.test(a.which) && !/input|textarea/i.test(a.target.tagName)) {
                    var i = t(this);
                    if (a.preventDefault(), a.stopPropagation(), !i.is(".disabled, :disabled")) {
                        var o = e(i), r = o.hasClass("open");
                        if (!r && 27 != a.which || r && 27 == a.which) return 27 == a.which && o.find(n).trigger("focus"), i.trigger("click");
                        var s = o.find(".dropdown-menu li:not(.disabled):visible a");
                        if (s.length) {
                            var l = s.index(a.target);
                            38 == a.which && l > 0 && l--, 40 == a.which && l < s.length - 1 && l++, ~l || (l = 0), s.eq(l).trigger("focus")
                        }
                    }
                }
            };
            var s = t.fn.dropdown;
            t.fn.dropdown = i, t.fn.dropdown.Constructor = r, t.fn.dropdown.noConflict = function () {
                return t.fn.dropdown = s, this
            }, t(document).on("click.bs.dropdown.data-api", a).on("click.bs.dropdown.data-api", ".dropdown form", function (t) {
                t.stopPropagation()
            }).on("click.bs.dropdown.data-api", n, r.prototype.toggle).on("keydown.bs.dropdown.data-api", n, r.prototype.keydown).on("keydown.bs.dropdown.data-api", ".dropdown-menu", r.prototype.keydown)
        }(jQuery), function (t) {
            "use strict";

            function e(e, i) {
                return this.each(function () {
                    var o = t(this), n = o.data("bs.modal"),
                        r = t.extend({}, a.DEFAULTS, o.data(), "object" == typeof e && e);
                    n || o.data("bs.modal", n = new a(this, r)), "string" == typeof e ? n[e](i) : r.show && n.show(i)
                })
            }

            var a = function (e, a) {
                this.options = a, this.$body = t(document.body), this.$element = t(e), this.$dialog = this.$element.find(".modal-dialog"), this.$backdrop = null, this.isShown = null, this.originalBodyPad = null, this.scrollbarWidth = 0, this.ignoreBackdropClick = !1, this.options.remote && this.$element.find(".modal-content").load(this.options.remote, t.proxy(function () {
                    this.$element.trigger("loaded.bs.modal")
                }, this))
            };
            a.VERSION = "3.3.7", a.TRANSITION_DURATION = 300, a.BACKDROP_TRANSITION_DURATION = 150, a.DEFAULTS = {
                backdrop: !0,
                keyboard: !0,
                show: !0
            }, a.prototype.toggle = function (t) {
                return this.isShown ? this.hide() : this.show(t)
            }, a.prototype.show = function (e) {
                var i = this, o = t.Event("show.bs.modal", {relatedTarget: e});
                this.$element.trigger(o), this.isShown || o.isDefaultPrevented() || (this.isShown = !0, this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("modal-open"), this.escape(), this.resize(), this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', t.proxy(this.hide, this)), this.$dialog.on("mousedown.dismiss.bs.modal", function () {
                    i.$element.one("mouseup.dismiss.bs.modal", function (e) {
                        t(e.target).is(i.$element) && (i.ignoreBackdropClick = !0)
                    })
                }), this.backdrop(function () {
                    var o = t.support.transition && i.$element.hasClass("fade");
                    i.$element.parent().length || i.$element.appendTo(i.$body), i.$element.show().scrollTop(0), i.adjustDialog(), o && i.$element[0].offsetWidth, i.$element.addClass("in"), i.enforceFocus();
                    var n = t.Event("shown.bs.modal", {relatedTarget: e});
                    o ? i.$dialog.one("bsTransitionEnd", function () {
                        i.$element.trigger("focus").trigger(n)
                    }).emulateTransitionEnd(a.TRANSITION_DURATION) : i.$element.trigger("focus").trigger(n)
                }))
            }, a.prototype.hide = function (e) {
                e && e.preventDefault(), e = t.Event("hide.bs.modal"), this.$element.trigger(e), this.isShown && !e.isDefaultPrevented() && (this.isShown = !1, this.escape(), this.resize(), t(document).off("focusin.bs.modal"), this.$element.removeClass("in").off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"), this.$dialog.off("mousedown.dismiss.bs.modal"), t.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", t.proxy(this.hideModal, this)).emulateTransitionEnd(a.TRANSITION_DURATION) : this.hideModal())
            }, a.prototype.enforceFocus = function () {
                t(document).off("focusin.bs.modal").on("focusin.bs.modal", t.proxy(function (t) {
                    document === t.target || this.$element[0] === t.target || this.$element.has(t.target).length || this.$element.trigger("focus")
                }, this))
            }, a.prototype.escape = function () {
                this.isShown && this.options.keyboard ? this.$element.on("keydown.dismiss.bs.modal", t.proxy(function (t) {
                    27 == t.which && this.hide()
                }, this)) : this.isShown || this.$element.off("keydown.dismiss.bs.modal")
            }, a.prototype.resize = function () {
                this.isShown ? t(window).on("resize.bs.modal", t.proxy(this.handleUpdate, this)) : t(window).off("resize.bs.modal")
            }, a.prototype.hideModal = function () {
                var t = this;
                this.$element.hide(), this.backdrop(function () {
                    t.$body.removeClass("modal-open"), t.resetAdjustments(), t.resetScrollbar(), t.$element.trigger("hidden.bs.modal")
                })
            }, a.prototype.removeBackdrop = function () {
                this.$backdrop && this.$backdrop.remove(), this.$backdrop = null
            }, a.prototype.backdrop = function (e) {
                var i = this, o = this.$element.hasClass("fade") ? "fade" : "";
                if (this.isShown && this.options.backdrop) {
                    var n = t.support.transition && o;
                    if (this.$backdrop = t(document.createElement("div")).addClass("modal-backdrop " + o).appendTo(this.$body), this.$element.on("click.dismiss.bs.modal", t.proxy(function (t) {
                        if (this.ignoreBackdropClick) return void(this.ignoreBackdropClick = !1);
                        t.target === t.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus() : this.hide())
                    }, this)), n && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !e) return;
                    n ? this.$backdrop.one("bsTransitionEnd", e).emulateTransitionEnd(a.BACKDROP_TRANSITION_DURATION) : e()
                } else if (!this.isShown && this.$backdrop) {
                    this.$backdrop.removeClass("in");
                    var r = function () {
                        i.removeBackdrop(), e && e()
                    };
                    t.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", r).emulateTransitionEnd(a.BACKDROP_TRANSITION_DURATION) : r()
                } else e && e()
            }, a.prototype.handleUpdate = function () {
                this.adjustDialog()
            }, a.prototype.adjustDialog = function () {
                var t = this.$element[0].scrollHeight > document.documentElement.clientHeight;
                this.$element.css({
                    paddingLeft: !this.bodyIsOverflowing && t ? this.scrollbarWidth : "",
                    paddingRight: this.bodyIsOverflowing && !t ? this.scrollbarWidth : ""
                })
            }, a.prototype.resetAdjustments = function () {
                this.$element.css({paddingLeft: "", paddingRight: ""})
            }, a.prototype.checkScrollbar = function () {
                var t = window.innerWidth;
                if (!t) {
                    var e = document.documentElement.getBoundingClientRect();
                    t = e.right - Math.abs(e.left)
                }
                this.bodyIsOverflowing = document.body.clientWidth < t, this.scrollbarWidth = this.measureScrollbar()
            }, a.prototype.setScrollbar = function () {
                var t = parseInt(this.$body.css("padding-right") || 0, 10);
                this.originalBodyPad = document.body.style.paddingRight || "", this.bodyIsOverflowing && this.$body.css("padding-right", t + this.scrollbarWidth)
            }, a.prototype.resetScrollbar = function () {
                this.$body.css("padding-right", this.originalBodyPad)
            }, a.prototype.measureScrollbar = function () {
                var t = document.createElement("div");
                t.className = "modal-scrollbar-measure", this.$body.append(t);
                var e = t.offsetWidth - t.clientWidth;
                return this.$body[0].removeChild(t), e
            };
            var i = t.fn.modal;
            t.fn.modal = e, t.fn.modal.Constructor = a, t.fn.modal.noConflict = function () {
                return t.fn.modal = i, this
            }, t(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function (a) {
                var i = t(this), o = i.attr("href"),
                    n = t(i.attr("data-target") || o && o.replace(/.*(?=#[^\s]+$)/, "")),
                    r = n.data("bs.modal") ? "toggle" : t.extend({remote: !/#/.test(o) && o}, n.data(), i.data());
                i.is("a") && a.preventDefault(), n.one("show.bs.modal", function (t) {
                    t.isDefaultPrevented() || n.one("hidden.bs.modal", function () {
                        i.is(":visible") && i.trigger("focus")
                    })
                }), e.call(n, r, this)
            })
        }(jQuery), function (t) {
            "use strict";

            function e(e) {
                return this.each(function () {
                    var i = t(this), o = i.data("bs.tooltip"), n = "object" == typeof e && e;
                    !o && /destroy|hide/.test(e) || (o || i.data("bs.tooltip", o = new a(this, n)), "string" == typeof e && o[e]())
                })
            }

            var a = function (t, e) {
                this.type = null, this.options = null, this.enabled = null, this.timeout = null, this.hoverState = null, this.$element = null, this.inState = null, this.init("tooltip", t, e)
            };
            a.VERSION = "3.3.7", a.TRANSITION_DURATION = 150, a.DEFAULTS = {
                animation: !0,
                placement: "top",
                selector: !1,
                template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
                trigger: "hover focus",
                title: "",
                delay: 0,
                html: !1,
                container: !1,
                viewport: {selector: "body", padding: 0}
            }, a.prototype.init = function (e, a, i) {
                if (this.enabled = !0, this.type = e, this.$element = t(a), this.options = this.getOptions(i), this.$viewport = this.options.viewport && t(t.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : this.options.viewport.selector || this.options.viewport), this.inState = {
                    click: !1,
                    hover: !1,
                    focus: !1
                }, this.$element[0] instanceof document.constructor && !this.options.selector) throw new Error("`selector` option must be specified when initializing " + this.type + " on the window.document object!");
                for (var o = this.options.trigger.split(" "), n = o.length; n--;) {
                    var r = o[n];
                    if ("click" == r) this.$element.on("click." + this.type, this.options.selector, t.proxy(this.toggle, this)); else if ("manual" != r) {
                        var s = "hover" == r ? "mouseenter" : "focusin", l = "hover" == r ? "mouseleave" : "focusout";
                        this.$element.on(s + "." + this.type, this.options.selector, t.proxy(this.enter, this)), this.$element.on(l + "." + this.type, this.options.selector, t.proxy(this.leave, this))
                    }
                }
                this.options.selector ? this._options = t.extend({}, this.options, {
                    trigger: "manual",
                    selector: ""
                }) : this.fixTitle()
            }, a.prototype.getDefaults = function () {
                return a.DEFAULTS
            }, a.prototype.getOptions = function (e) {
                return e = t.extend({}, this.getDefaults(), this.$element.data(), e), e.delay && "number" == typeof e.delay && (e.delay = {
                    show: e.delay,
                    hide: e.delay
                }), e
            }, a.prototype.getDelegateOptions = function () {
                var e = {}, a = this.getDefaults();
                return this._options && t.each(this._options, function (t, i) {
                    a[t] != i && (e[t] = i)
                }), e
            }, a.prototype.enter = function (e) {
                var a = e instanceof this.constructor ? e : t(e.currentTarget).data("bs." + this.type);
                return a || (a = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, a)), e instanceof t.Event && (a.inState["focusin" == e.type ? "focus" : "hover"] = !0), a.tip().hasClass("in") || "in" == a.hoverState ? void(a.hoverState = "in") : (clearTimeout(a.timeout), a.hoverState = "in", a.options.delay && a.options.delay.show ? void(a.timeout = setTimeout(function () {
                    "in" == a.hoverState && a.show()
                }, a.options.delay.show)) : a.show())
            }, a.prototype.isInStateTrue = function () {
                for (var t in this.inState) if (this.inState[t]) return !0;
                return !1
            }, a.prototype.leave = function (e) {
                var a = e instanceof this.constructor ? e : t(e.currentTarget).data("bs." + this.type);
                if (a || (a = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, a)), e instanceof t.Event && (a.inState["focusout" == e.type ? "focus" : "hover"] = !1), !a.isInStateTrue()) {
                    if (clearTimeout(a.timeout), a.hoverState = "out", !a.options.delay || !a.options.delay.hide) return a.hide();
                    a.timeout = setTimeout(function () {
                        "out" == a.hoverState && a.hide()
                    }, a.options.delay.hide)
                }
            }, a.prototype.show = function () {
                var e = t.Event("show.bs." + this.type);
                if (this.hasContent() && this.enabled) {
                    this.$element.trigger(e);
                    var i = t.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
                    if (e.isDefaultPrevented() || !i) return;
                    var o = this, n = this.tip(), r = this.getUID(this.type);
                    this.setContent(), n.attr("id", r), this.$element.attr("aria-describedby", r), this.options.animation && n.addClass("fade");
                    var s = "function" == typeof this.options.placement ? this.options.placement.call(this, n[0], this.$element[0]) : this.options.placement,
                        l = /\s?auto?\s?/i, d = l.test(s);
                    d && (s = s.replace(l, "") || "top"), n.detach().css({
                        top: 0,
                        left: 0,
                        display: "block"
                    }).addClass(s).data("bs." + this.type, this), this.options.container ? n.appendTo(this.options.container) : n.insertAfter(this.$element), this.$element.trigger("inserted.bs." + this.type);
                    var c = this.getPosition(), p = n[0].offsetWidth, u = n[0].offsetHeight;
                    if (d) {
                        var h = s, f = this.getPosition(this.$viewport);
                        s = "bottom" == s && c.bottom + u > f.bottom ? "top" : "top" == s && c.top - u < f.top ? "bottom" : "right" == s && c.right + p > f.width ? "left" : "left" == s && c.left - p < f.left ? "right" : s, n.removeClass(h).addClass(s)
                    }
                    var m = this.getCalculatedOffset(s, c, p, u);
                    this.applyPlacement(m, s);
                    var g = function () {
                        var t = o.hoverState;
                        o.$element.trigger("shown.bs." + o.type), o.hoverState = null, "out" == t && o.leave(o)
                    };
                    t.support.transition && this.$tip.hasClass("fade") ? n.one("bsTransitionEnd", g).emulateTransitionEnd(a.TRANSITION_DURATION) : g()
                }
            }, a.prototype.applyPlacement = function (e, a) {
                var i = this.tip(), o = i[0].offsetWidth, n = i[0].offsetHeight, r = parseInt(i.css("margin-top"), 10),
                    s = parseInt(i.css("margin-left"), 10);
                isNaN(r) && (r = 0), isNaN(s) && (s = 0), e.top += r, e.left += s, t.offset.setOffset(i[0], t.extend({
                    using: function (t) {
                        i.css({top: Math.round(t.top), left: Math.round(t.left)})
                    }
                }, e), 0), i.addClass("in");
                var l = i[0].offsetWidth, d = i[0].offsetHeight;
                "top" == a && d != n && (e.top = e.top + n - d);
                var c = this.getViewportAdjustedDelta(a, e, l, d);
                c.left ? e.left += c.left : e.top += c.top;
                var p = /top|bottom/.test(a), u = p ? 2 * c.left - o + l : 2 * c.top - n + d,
                    h = p ? "offsetWidth" : "offsetHeight";
                i.offset(e), this.replaceArrow(u, i[0][h], p)
            }, a.prototype.replaceArrow = function (t, e, a) {
                this.arrow().css(a ? "left" : "top", 50 * (1 - t / e) + "%").css(a ? "top" : "left", "")
            }, a.prototype.setContent = function () {
                var t = this.tip(), e = this.getTitle();
                t.find(".tooltip-inner")[this.options.html ? "html" : "text"](e), t.removeClass("fade in top bottom left right")
            }, a.prototype.hide = function (e) {
                function i() {
                    "in" != o.hoverState && n.detach(), o.$element && o.$element.removeAttr("aria-describedby").trigger("hidden.bs." + o.type), e && e()
                }

                var o = this, n = t(this.$tip), r = t.Event("hide.bs." + this.type);
                if (this.$element.trigger(r), !r.isDefaultPrevented()) return n.removeClass("in"), t.support.transition && n.hasClass("fade") ? n.one("bsTransitionEnd", i).emulateTransitionEnd(a.TRANSITION_DURATION) : i(), this.hoverState = null, this
            }, a.prototype.fixTitle = function () {
                var t = this.$element;
                (t.attr("title") || "string" != typeof t.attr("data-original-title")) && t.attr("data-original-title", t.attr("title") || "").attr("title", "")
            }, a.prototype.hasContent = function () {
                return this.getTitle()
            }, a.prototype.getPosition = function (e) {
                e = e || this.$element;
                var a = e[0], i = "BODY" == a.tagName, o = a.getBoundingClientRect();
                null == o.width && (o = t.extend({}, o, {width: o.right - o.left, height: o.bottom - o.top}));
                var n = window.SVGElement && a instanceof window.SVGElement,
                    r = i ? {top: 0, left: 0} : n ? null : e.offset(),
                    s = {scroll: i ? document.documentElement.scrollTop || document.body.scrollTop : e.scrollTop()},
                    l = i ? {width: t(window).width(), height: t(window).height()} : null;
                return t.extend({}, o, s, l, r)
            }, a.prototype.getCalculatedOffset = function (t, e, a, i) {
                return "bottom" == t ? {
                    top: e.top + e.height,
                    left: e.left + e.width / 2 - a / 2
                } : "top" == t ? {
                    top: e.top - i,
                    left: e.left + e.width / 2 - a / 2
                } : "left" == t ? {
                    top: e.top + e.height / 2 - i / 2,
                    left: e.left - a
                } : {top: e.top + e.height / 2 - i / 2, left: e.left + e.width}
            }, a.prototype.getViewportAdjustedDelta = function (t, e, a, i) {
                var o = {top: 0, left: 0};
                if (!this.$viewport) return o;
                var n = this.options.viewport && this.options.viewport.padding || 0,
                    r = this.getPosition(this.$viewport);
                if (/right|left/.test(t)) {
                    var s = e.top - n - r.scroll, l = e.top + n - r.scroll + i;
                    s < r.top ? o.top = r.top - s : l > r.top + r.height && (o.top = r.top + r.height - l)
                } else {
                    var d = e.left - n, c = e.left + n + a;
                    d < r.left ? o.left = r.left - d : c > r.right && (o.left = r.left + r.width - c)
                }
                return o
            }, a.prototype.getTitle = function () {
                var t = this.$element, e = this.options;
                return t.attr("data-original-title") || ("function" == typeof e.title ? e.title.call(t[0]) : e.title)
            }, a.prototype.getUID = function (t) {
                do {
                    t += ~~(1e6 * Math.random())
                } while (document.getElementById(t));
                return t
            }, a.prototype.tip = function () {
                if (!this.$tip && (this.$tip = t(this.options.template), 1 != this.$tip.length)) throw new Error(this.type + " `template` option must consist of exactly 1 top-level element!");
                return this.$tip
            }, a.prototype.arrow = function () {
                return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
            }, a.prototype.enable = function () {
                this.enabled = !0
            }, a.prototype.disable = function () {
                this.enabled = !1
            }, a.prototype.toggleEnabled = function () {
                this.enabled = !this.enabled
            }, a.prototype.toggle = function (e) {
                var a = this;
                e && ((a = t(e.currentTarget).data("bs." + this.type)) || (a = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, a))), e ? (a.inState.click = !a.inState.click, a.isInStateTrue() ? a.enter(a) : a.leave(a)) : a.tip().hasClass("in") ? a.leave(a) : a.enter(a)
            }, a.prototype.destroy = function () {
                var t = this;
                clearTimeout(this.timeout), this.hide(function () {
                    t.$element.off("." + t.type).removeData("bs." + t.type), t.$tip && t.$tip.detach(), t.$tip = null, t.$arrow = null, t.$viewport = null, t.$element = null
                })
            };
            var i = t.fn.tooltip;
            t.fn.tooltip = e, t.fn.tooltip.Constructor = a, t.fn.tooltip.noConflict = function () {
                return t.fn.tooltip = i, this
            }
        }(jQuery), function (t) {
            "use strict";

            function e(e) {
                return this.each(function () {
                    var i = t(this), o = i.data("bs.popover"), n = "object" == typeof e && e;
                    !o && /destroy|hide/.test(e) || (o || i.data("bs.popover", o = new a(this, n)), "string" == typeof e && o[e]())
                })
            }

            var a = function (t, e) {
                this.init("popover", t, e)
            };
            if (!t.fn.tooltip) throw new Error("Popover requires tooltip.js");
            a.VERSION = "3.3.7", a.DEFAULTS = t.extend({}, t.fn.tooltip.Constructor.DEFAULTS, {
                placement: "right",
                trigger: "click",
                content: "",
                template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
            }), a.prototype = t.extend({}, t.fn.tooltip.Constructor.prototype), a.prototype.constructor = a, a.prototype.getDefaults = function () {
                return a.DEFAULTS
            }, a.prototype.setContent = function () {
                var t = this.tip(), e = this.getTitle(), a = this.getContent();
                t.find(".popover-title")[this.options.html ? "html" : "text"](e), t.find(".popover-content").children().detach().end()[this.options.html ? "string" == typeof a ? "html" : "append" : "text"](a), t.removeClass("fade top bottom left right in"), t.find(".popover-title").html() || t.find(".popover-title").hide()
            }, a.prototype.hasContent = function () {
                return this.getTitle() || this.getContent()
            }, a.prototype.getContent = function () {
                var t = this.$element, e = this.options;
                return t.attr("data-content") || ("function" == typeof e.content ? e.content.call(t[0]) : e.content)
            }, a.prototype.arrow = function () {
                return this.$arrow = this.$arrow || this.tip().find(".arrow")
            };
            var i = t.fn.popover;
            t.fn.popover = e, t.fn.popover.Constructor = a, t.fn.popover.noConflict = function () {
                return t.fn.popover = i, this
            }
        }(jQuery), function (t) {
            "use strict";

            function e(a, i) {
                this.$body = t(document.body), this.$scrollElement = t(t(a).is(document.body) ? window : a), this.options = t.extend({}, e.DEFAULTS, i), this.selector = (this.options.target || "") + " .nav li > a", this.offsets = [], this.targets = [], this.activeTarget = null, this.scrollHeight = 0, this.$scrollElement.on("scroll.bs.scrollspy", t.proxy(this.process, this)), this.refresh(), this.process()
            }

            function a(a) {
                return this.each(function () {
                    var i = t(this), o = i.data("bs.scrollspy"), n = "object" == typeof a && a;
                    o || i.data("bs.scrollspy", o = new e(this, n)), "string" == typeof a && o[a]()
                })
            }

            e.VERSION = "3.3.7", e.DEFAULTS = {offset: 10}, e.prototype.getScrollHeight = function () {
                return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
            }, e.prototype.refresh = function () {
                var e = this, a = "offset", i = 0;
                this.offsets = [], this.targets = [], this.scrollHeight = this.getScrollHeight(), t.isWindow(this.$scrollElement[0]) || (a = "position", i = this.$scrollElement.scrollTop()), this.$body.find(this.selector).map(function () {
                    var e = t(this), o = e.data("target") || e.attr("href"), n = /^#./.test(o) && t(o);
                    return n && n.length && n.is(":visible") && [[n[a]().top + i, o]] || null
                }).sort(function (t, e) {
                    return t[0] - e[0]
                }).each(function () {
                    e.offsets.push(this[0]), e.targets.push(this[1])
                })
            }, e.prototype.process = function () {
                var t, e = this.$scrollElement.scrollTop() + this.options.offset, a = this.getScrollHeight(),
                    i = this.options.offset + a - this.$scrollElement.height(), o = this.offsets, n = this.targets,
                    r = this.activeTarget;
                if (this.scrollHeight != a && this.refresh(), e >= i) return r != (t = n[n.length - 1]) && this.activate(t);
                if (r && e < o[0]) return this.activeTarget = null, this.clear();
                for (t = o.length; t--;) r != n[t] && e >= o[t] && (void 0 === o[t + 1] || e < o[t + 1]) && this.activate(n[t])
            }, e.prototype.activate = function (e) {
                this.activeTarget = e, this.clear();
                var a = this.selector + '[data-target="' + e + '"],' + this.selector + '[href="' + e + '"]',
                    i = t(a).parents("li").addClass("active");
                i.parent(".dropdown-menu").length && (i = i.closest("li.dropdown").addClass("active")), i.trigger("activate.bs.scrollspy")
            }, e.prototype.clear = function () {
                t(this.selector).parentsUntil(this.options.target, ".active").removeClass("active")
            };
            var i = t.fn.scrollspy;
            t.fn.scrollspy = a, t.fn.scrollspy.Constructor = e, t.fn.scrollspy.noConflict = function () {
                return t.fn.scrollspy = i, this
            }, t(window).on("load.bs.scrollspy.data-api", function () {
                t('[data-spy="scroll"]').each(function () {
                    var e = t(this);
                    a.call(e, e.data())
                })
            })
        }(jQuery), function (t) {
            "use strict";

            function e(e) {
                return this.each(function () {
                    var i = t(this), o = i.data("bs.tab");
                    o || i.data("bs.tab", o = new a(this)), "string" == typeof e && o[e]()
                })
            }

            var a = function (e) {
                this.element = t(e)
            };
            a.VERSION = "3.3.7", a.TRANSITION_DURATION = 150, a.prototype.show = function () {
                var e = this.element, a = e.closest("ul:not(.dropdown-menu)"), i = e.data("target");
                if (i || (i = e.attr("href"), i = i && i.replace(/.*(?=#[^\s]*$)/, "")), !e.parent("li").hasClass("active")) {
                    var o = a.find(".active:last a"), n = t.Event("hide.bs.tab", {relatedTarget: e[0]}),
                        r = t.Event("show.bs.tab", {relatedTarget: o[0]});
                    if (o.trigger(n), e.trigger(r), !r.isDefaultPrevented() && !n.isDefaultPrevented()) {
                        var s = t(i);
                        this.activate(e.closest("li"), a), this.activate(s, s.parent(), function () {
                            o.trigger({type: "hidden.bs.tab", relatedTarget: e[0]}), e.trigger({
                                type: "shown.bs.tab",
                                relatedTarget: o[0]
                            })
                        })
                    }
                }
            }, a.prototype.activate = function (e, i, o) {
                function n() {
                    r.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !1), e.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded", !0), s ? (e[0].offsetWidth, e.addClass("in")) : e.removeClass("fade"), e.parent(".dropdown-menu").length && e.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !0), o && o()
                }

                var r = i.find("> .active"),
                    s = o && t.support.transition && (r.length && r.hasClass("fade") || !!i.find("> .fade").length);
                r.length && s ? r.one("bsTransitionEnd", n).emulateTransitionEnd(a.TRANSITION_DURATION) : n(), r.removeClass("in")
            };
            var i = t.fn.tab;
            t.fn.tab = e, t.fn.tab.Constructor = a, t.fn.tab.noConflict = function () {
                return t.fn.tab = i, this
            };
            var o = function (a) {
                a.preventDefault(), e.call(t(this), "show")
            };
            t(document).on("click.bs.tab.data-api", '[data-toggle="tab"]', o).on("click.bs.tab.data-api", '[data-toggle="pill"]', o)
        }(jQuery), function (t) {
            "use strict";

            function e(e) {
                return this.each(function () {
                    var i = t(this), o = i.data("bs.affix"), n = "object" == typeof e && e;
                    o || i.data("bs.affix", o = new a(this, n)), "string" == typeof e && o[e]()
                })
            }

            var a = function (e, i) {
                this.options = t.extend({}, a.DEFAULTS, i), this.$target = t(this.options.target).on("scroll.bs.affix.data-api", t.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", t.proxy(this.checkPositionWithEventLoop, this)), this.$element = t(e), this.affixed = null, this.unpin = null, this.pinnedOffset = null, this.checkPosition()
            };
            a.VERSION = "3.3.7", a.RESET = "affix affix-top affix-bottom", a.DEFAULTS = {
                offset: 0,
                target: window
            }, a.prototype.getState = function (t, e, a, i) {
                var o = this.$target.scrollTop(), n = this.$element.offset(), r = this.$target.height();
                if (null != a && "top" == this.affixed) return o < a && "top";
                if ("bottom" == this.affixed) return null != a ? !(o + this.unpin <= n.top) && "bottom" : !(o + r <= t - i) && "bottom";
                var s = null == this.affixed, l = s ? o : n.top, d = s ? r : e;
                return null != a && o <= a ? "top" : null != i && l + d >= t - i && "bottom"
            }, a.prototype.getPinnedOffset = function () {
                if (this.pinnedOffset) return this.pinnedOffset;
                this.$element.removeClass(a.RESET).addClass("affix");
                var t = this.$target.scrollTop(), e = this.$element.offset();
                return this.pinnedOffset = e.top - t
            }, a.prototype.checkPositionWithEventLoop = function () {
                setTimeout(t.proxy(this.checkPosition, this), 1)
            }, a.prototype.checkPosition = function () {
                if (this.$element.is(":visible")) {
                    var e = this.$element.height(), i = this.options.offset, o = i.top, n = i.bottom,
                        r = Math.max(t(document).height(), t(document.body).height());
                    "object" != typeof i && (n = o = i), "function" == typeof o && (o = i.top(this.$element)), "function" == typeof n && (n = i.bottom(this.$element));
                    var s = this.getState(r, e, o, n);
                    if (this.affixed != s) {
                        null != this.unpin && this.$element.css("top", "");
                        var l = "affix" + (s ? "-" + s : ""), d = t.Event(l + ".bs.affix");
                        if (this.$element.trigger(d), d.isDefaultPrevented()) return;
                        this.affixed = s, this.unpin = "bottom" == s ? this.getPinnedOffset() : null, this.$element.removeClass(a.RESET).addClass(l).trigger(l.replace("affix", "affixed") + ".bs.affix")
                    }
                    "bottom" == s && this.$element.offset({top: r - e - n})
                }
            };
            var i = t.fn.affix;
            t.fn.affix = e, t.fn.affix.Constructor = a, t.fn.affix.noConflict = function () {
                return t.fn.affix = i, this
            }, t(window).on("load", function () {
                t('[data-spy="affix"]').each(function () {
                    var a = t(this), i = a.data();
                    i.offset = i.offset || {}, null != i.offsetBottom && (i.offset.bottom = i.offsetBottom), null != i.offsetTop && (i.offset.top = i.offsetTop), e.call(a, i)
                })
            })
        }(jQuery)
    }, {}],
    2: [function (t, e, a) {
        t("../../../Themer/src/js/jquery.lazyload"), t("../../../Themer/src/js/jquery-smartphoto"), function (t) {
            function e() {
                t(".wpcom-adv-menu").each(function (e, a) {
                    var i = t(a), o = t(".wpcom-adv-menu"), n = t("body").width(), r = o.closest(".container").width();
                    i.find(">.menu-item-style").each(function (e, a) {
                        var i = t(a), s = i.find(">.menu-item-wrap"), l = i.position().left, d = s.outerWidth(),
                            c = o.offset().left - (n - r) / 2, p = "";
                        l + d > r - c && (p = -(i.offset().left + d - r - (n - r) / 2)), s.css("left", p)
                    })
                })
            }

            function a() {
                var e = "暂未设置地图接口，如果您是网站管理员，请前往【主题设置>常规设置>地图接口】进行设置", a = [], i = [];
                for (var o in window.wpcom_maps) 1 == window.wpcom_maps[o].type ? i.push(window.wpcom_maps[o]) : a.push(window.wpcom_maps[o]);
                if (a.length && !a[0].key) alert(e); else if (a.length) {
                    window.HOST_TYPE = "2", window.BMap_loadScriptTime = (new Date).getTime();
                    var n = "//api.map.baidu.com/getscript?v=2.0&ak=" + a[0].key + "&services=&t=20181212102408";
                    t.getScript(n, function () {
                        for (var t = [], e = [], i = [], o = 0; o < a.length; o++) !function (o) {
                            var n = a[o];
                            t[o] = new BMap.Map(n.id, {enableMapClick: !1});
                            var r = new BMap.Point(n.pos[0], n.pos[1]);
                            e[o] = new BMap.Marker(r), t[o].centerAndZoom(r, 16), t[o].addOverlay(e[o]), n.scrollWheelZoom && t[o].enableScrollWheelZoom(), t[o].setMapStyle({
                                styleJson: [{
                                    featureType: "all",
                                    elementType: "all",
                                    stylers: {lightness: 25, saturation: -25}
                                }]
                            }), n.html && (i[o] = new BMap.InfoWindow(n.html), e[o].openInfoWindow(i[o]), e[o].addEventListener("click", function () {
                                this.openInfoWindow(i[o])
                            }))
                        }(o)
                    })
                }
                if (i.length && !i[0].key) alert(e); else if (i.length) {
                    var r = "//maps.googleapis.com/maps/api/js?key=" + i[0].key;
                    t.getScript(r, function () {
                        for (var t = [], e = [], a = [], o = 0; o < i.length; o++) !function (o) {
                            var n = i[o], r = {
                                zoom: 15,
                                center: {lat: n.pos[0], lng: n.pos[1]},
                                scrollwheel: !!n.scrollWheelZoom,
                                styles: [{
                                    elementType: "geometry",
                                    stylers: [{lightness: 45}, {saturation: -25}]
                                }, {featureType: "poi", stylers: [{visibility: "off"}]}, {
                                    featureType: "transit",
                                    stylers: [{visibility: "off"}]
                                }],
                                disableDefaultUI: !0
                            };
                            t[o] = new google.maps.Map(document.getElementById(n.id), r);
                            var s = {position: r.center, map: t[o]};
                            n.icon && (s.icon = {
                                url: n.icon,
                                size: new google.maps.Size(27, 27),
                                scaledSize: new google.maps.Size(27, 27)
                            }), e[o] = new google.maps.Marker(s), n.html && (a[o] = new google.maps.InfoWindow({
                                content: n.html,
                                maxWidth: 500
                            }), a[o].open(t[o], e[o]), e[o].addListener("click", function () {
                                a[o].open(t[o], e[o])
                            }))
                        }(o)
                    })
                }
            }

            function o() {
                t(".bdshare_popup_box").length ? t(".bdshare_popup_box").addClass("j-share") : setTimeout(function () {
                    o()
                }, 3)
            }

            function n(e, a) {
                t(document).on("click", "a.j-wpcom-lightbox", function (e) {
                    e.preventDefault();
                    var a = "baiduboxapp://v19/utils/previewImage?params=" + encodeURIComponent(JSON.stringify({
                        urls: d,
                        current: t(this).attr("href")
                    })), i = document.createElement("iframe");
                    i.style.display = "none", i.src = a;
                    var o = document.body;
                    o.appendChild(i), setTimeout(function () {
                        o.removeChild(i), i = null
                    }, 0)
                })
            }

            var r = t(window), s = navigator.userAgent.toLowerCase(), l = 1, d = [],
                c = void 0 !== _wpcom_js.webp && _wpcom_js.webp ? _wpcom_js.webp : null;
            (t(".wpcom-user-list").length || t(".wpcom-member").length) && (l = 0), l && void 0 !== _wpcom_js.lightbox && 1 == _wpcom_js.lightbox && t(".entry-content img").each(function (e, a) {
                var i = t(a), o = i.parent(), n = i.data("original");
                if (n = n || i.attr("src"), n && n.match(/^\/\//) && (n = window.location.protocol + n), "a" === o.prop("tagName").toLowerCase()) {
                    var r = o.attr("href");
                    (r == n || r && r.match(/.*(\.png|\.jpg|\.jpeg|\.gif|\.webp|\.bmp)$/i)) && (o.addClass("j-wpcom-lightbox"), "micromessenger" != s.match(/MicroMessenger/i) && "baiduboxapp" != s.match(/baiduboxapp/i) || d.push(n))
                } else i.replaceWith('<a class="j-wpcom-lightbox" href="' + n + '">' + a.outerHTML + "</a>"), "micromessenger" != s.match(/MicroMessenger/i) && "baiduboxapp" != s.match(/baiduboxapp/i) || d.push(n)
            });
            var p = t("#wpcom-video, .j-wpcom-video, .wp-block-video video");
            if (p.length) {
                t.getScript("//cdn.bootcss.com/plyr/3.5.6/plyr.min.js", function () {
                    t("#wpcom-video").length && new Plyr("#wpcom-video", {
                        update: !0,
                        controls: ["play-large", "play", "progress", "current-time", "mute", "volume", "fullscreen"],
                        ratio: "860:" + (void 0 !== _wpcom_js.video_height ? _wpcom_js.video_height : "483")
                    }), t(".j-wpcom-video,.wp-block-video video").length && Plyr.setup(".j-wpcom-video,.wp-block-video video", {
                        update: !0,
                        controls: ["play-large", "play", "progress", "current-time", "mute", "volume", "fullscreen"],
                        ratio: "16:9"
                    });
                    var e = [];
                    if (p.each(function (a, i) {
                        var o = t(i).attr("src");
                        o = o || t(i).find("source").attr("src"), o.search(/(\.m3u8|m3u8\?)/i) > -1 && e.push(i)
                    }), e.length) {
                        t.getScript("//cdn.bootcss.com/hls.js/0.12.5-beta.2/hls.min.js", function () {
                            for (var a in e) if (Hls.isSupported()) {
                                var o = new Hls, n = t(e[a]).attr("src");
                                n = n || t(e[a]).find("source").attr("src"), o.loadSource(n), o.attachMedia(e[a])
                            } else e[a].src = source[i]
                        })
                    }
                })
            }
            t(document).ready(function () {
                if ("baiduboxapp" == s.match(/baiduboxapp/i)) n(); else {
                    var i = t(".entry-content .j-wpcom-lightbox");
                    i.length && (i.find("noscript").remove(), i.SmartPhoto({nav: !1}))
                }
                t(".j-lazy").lazyload({
                    webp: c,
                    threshold: 250,
                    effect: "fadeIn"
                }), /(iPhone|iPad|iPod|iOS|Android)/i.test(navigator.userAgent) && t("body").addClass("is-mobile"), t(document).on("click", 'a[href^="#"]', function (e) {
                    var a = t(this).attr("role");
                    if ("tab" != a && "button" != a && (e.preventDefault(), this.hash)) {
                        var i = t(this.hash).length ? t(this.hash).offset().top : 0;
                        i = i - t("header.header").outerHeight() - 10, i = t("#wpadminbar").length ? i - t("#wpadminbar").outerHeight() : i, i = i < 0 ? 0 : i, t("html, body").animate({scrollTop: i}, 400)
                    }
                }).on("click", ".j-footer-bar-icon", function (e) {
                    e.preventDefault();
                    var a = t(this),
                        i = '<div class="modal" id="footer-bar">\n            <div class="modal-dialog modal-sm">\n                <div class="modal-content">\n                    <div class="modal-header">\n                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h4 class="modal-title">二维码</h4>\n                    </div>\n                    <div class="modal-body">\n                        <img src="' + a.attr("href") + '">\n                    </div>\n                </div>\n            </div>\n        </div>';
                    return 0 === t("#footer-bar").length ? t("body").append(i) : t("#footer-bar").find(".modal-body img").attr("src", a.attr("href")), t("#footer-bar").modal(), !1
                }), t('.wp-block-wpcom-tabs a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
                    t(window).trigger("scroll")
                }), t(".wp-block-wpcom-accordion").on("shown.bs.collapse", function () {
                    t(window).trigger("scroll")
                }), t(".modal-video").on("shown.bs.modal", function (e) {
                    var a = t(this).closest(".video-wrap");
                    t(".modal-body", this).html(a.find(".video-code").html())
                }).on("hidden.bs.modal", function (e) {
                    t(".modal-body", this).html("")
                });
                var l = 0, d = setInterval(function () {
                    l++, void 0 !== window.wpcom_maps && window.wpcom_maps.length ? (clearInterval(d), a()) : l > 5 && clearInterval(d)
                }, 1e3);
                t(document).on("DOMNodeInserted", ".widget_shopping_cart_content,.woocommerce-cart-form", function () {
                    t(this).find(".j-lazy").lazyload({
                        webp: c,
                        threshold: 250,
                        effect: "fadeIn"
                    }), t(window).trigger("scroll")
                }).on("DOMNodeInserted", "header.header", function () {
                    e()
                }).on("DOMSubtreeModified", "header.header .wpcom-adv-menu>li>a>img", function () {
                    setTimeout(function () {
                        e()
                    }, 300)
                }), t("header.header").trigger("DOMNodeInserted"), t(".shopping-cart").on("mouseenter", ".cart-contents", function () {
                    t(window).trigger("scroll")
                }), t("body").on("click", ".navbar-toggle", function () {
                    var e = t("body");
                    e.hasClass("navbar-on") ? e.removeClass("navbar-on navbar-ing") : (e.addClass("navbar-on navbar-ing"), setTimeout(function () {
                        e.removeClass("navbar-ing")
                    }, 500)), 0 == t(".navbar-on-shadow").length && t("#wrap").append('<div class="navbar-on-shadow"></div>'), setTimeout(function () {
                        t(window).trigger("scroll")
                    }, 500)
                }).on("click", ".m-dropdown", function () {
                    var e = t(this).parent();
                    e.find("> .dropdown-menu").slideToggle("fast"), e.toggleClass("dropdown-open"), t(window).trigger("scroll")
                }), t("#wrap").on("click", ".navbar-on-shadow", function () {
                    t("body").hasClass("navbar-ing") || t(".navbar-toggle").trigger("click")
                }), t(".woocommerce").off("click.quantity").on("click.quantity", ".qty-down,.qty-up", function () {
                    var e = t(this).hasClass("qty-down") ? 0 : 1, a = t(this).parent().find(".qty"), i = a.val();
                    i = e ? ++i : --i, i = a.attr("min") && i < a.attr("min") ? a.attr("min") : i, i = a.attr("max") && i > a.attr("max") ? a.attr("max") : i, a.val(i).trigger("change")
                }).off("blur.quantity").on("blur.quantity", ".qty", function () {
                    var e = t(this), a = e.val();
                    a = e.attr("min") && a < e.attr("min") ? e.attr("min") : a, a = e.attr("max") && a > e.attr("max") ? e.attr("max") : a, e.val(a)
                });
                var p, u;
                r.scroll(function () {
                    r.scrollTop() > 100 ? t("#j-top").fadeIn("slow") : t("#j-top").fadeOut("slow")
                }), t(".action").on("mouseenter", ".wechat", function () {
                    clearTimeout(u), t(".contact-wrap").hide(), t(".wechat-wrap").show()
                }).on("mouseleave", ".wechat", function () {
                    u = setTimeout(function () {
                        t(".wechat-wrap").hide()
                    }, 300)
                }).on("mouseenter", ".contact", function () {
                    clearTimeout(p), t(".wechat-wrap").hide(), t(".contact-wrap").show()
                }).on("mouseleave", ".contact", function () {
                    p = setTimeout(function () {
                        t(".contact-wrap").hide()
                    }, 300)
                }).on("click", "#j-top", function () {
                    t("html, body").animate({scrollTop: 0}, "slow")
                }).on("mouseenter", ".bds_more", function () {
                    t(this).hasClass("share") ? t(".bdshare_popup_box").length ? t(".bdshare_popup_box").addClass("j-share") : setTimeout(function () {
                        o()
                    }, 15) : t(".bdshare_popup_box").removeClass("j-share")
                })
            }), window.setup_share = function () {
                t(document).on("click", ".a-box.share", function (e) {
                    e.preventDefault(), t(".at-svc-compact .at-icon-wrapper").trigger("click")
                })
            }, function () {
                if ("micromessenger" == s.match(/MicroMessenger/i)) {
                    var e, a = location.href.split("#")[0], i = document.querySelector("body").classList, o = 0;
                    if (i.contains("page")) for (var n = 0; n < i.length; n++) (e = i[n].match(/page-id-(\d+)$/)) && (o = e[1]); else if (i.contains("single")) for (var n = 0; n < i.length; n++) (e = i[n].match(/postid-(\d+)$/)) && (o = e[1]);
                    t.ajax({
                        url: _wpcom_js.ajaxurl,
                        type: "POST",
                        data: {action: "wpcom_wx_config", url: encodeURIComponent(a), ID: o},
                        dataType: "json",
                        success: function (e) {
                            if (e.signature) {
                                var i = e.thumb;
                                i.match(/^\/\//) && (i = window.location.protocol + i);
                                var o = document.title, n = t("meta[name=description]").attr("content");
                                n = n || e.desc;
                                var r = document.createElement("script");
                                r.src = "//res.wx.qq.com/open/js/jweixin-1.2.0.js", r.onload = function () {
                                    window.wx.config({
                                        debug: !1,
                                        appId: e.appId,
                                        timestamp: e.timestamp,
                                        nonceStr: e.noncestr,
                                        signature: e.signature,
                                        jsApiList: ["onMenuShareTimeline", "onMenuShareAppMessage", "onMenuShareQQ", "onMenuShareWeibo", "previewImage"]
                                    }), wx.ready(function () {
                                        var e = {imgUrl: i, link: a, desc: n, title: o},
                                            r = {imgUrl: i, link: a, title: o};
                                        wx.onMenuShareAppMessage(e), wx.onMenuShareTimeline(r), wx.onMenuShareQQ(e), wx.onMenuShareWeibo(e), t(".entry-content").find("a.j-wpcom-lightbox").each(function (e, a) {
                                            t(a).off("click.lightbox")
                                        }), t(".entry-content a.j-wpcom-lightbox .j-lazy").lazyload({
                                            webp: c,
                                            threshold: 250,
                                            effect: "fadeIn"
                                        }), t(document).on("click", "a.j-wpcom-lightbox", function (e) {
                                            e.preventDefault(), wx.previewImage({
                                                current: t(this).attr("href"),
                                                urls: d
                                            })
                                        })
                                    }), wx.error(function (t) {
                                        console.log(t)
                                    })
                                }, document.body.appendChild(r)
                            }
                        }
                    })
                }
            }(), window.wpcom_map = function (t, e, a, i, o, n, r) {
                void 0 === window.wpcom_maps && (window.wpcom_maps = []), window.wpcom_maps.push({
                    id: t,
                    html: e,
                    pos: a,
                    scrollWheelZoom: i,
                    key: o,
                    type: n,
                    icon: r
                })
            }
        }(jQuery)
    }, {"../../../Themer/src/js/jquery-smartphoto": 3, "../../../Themer/src/js/jquery.lazyload": 4}],
    3: [function (t, e, a) {
        (function (e) {
            /**
             * Modules in this bundle
             * @license
             *
             * smartphoto:
             *   license: MIT (http://opensource.org/licenses/MIT)
             *   author: appleple
             *   homepage: http://developer.a-blogcms.jp
             *   version: 1.3.6
             *
             * a-template:
             *   license: MIT (http://opensource.org/licenses/MIT)
             *   author: steelydylan
             *   version: 0.5.4
             *
             * custom-event-polyfill:
             *   license: MIT (http://opensource.org/licenses/MIT)
             *   contributors: Frank Panetta, Mikhail Reenko <reenko@yandex.ru>, Joscha Feth <joscha@feth.com>
             *   homepage: https://github.com/krambuhl/custom-event-polyfill#readme
             *   version: 0.3.0
             *
             * es6-promise-polyfill:
             *   license: MIT (http://opensource.org/licenses/MIT)
             *   author: Roman Dvornov <rdvornov@gmail.com>
             *   homepage: https://github.com/lahmatiy/es6-promise-polyfill#readme
             *   version: 1.2.0
             *
             * ie-array-find-polyfill:
             *   license: MIT (http://opensource.org/licenses/MIT)
             *   author: Carlos Abdalla
             *   homepage: https://github.com/abdalla/ie-array-find-polyfill#readme
             *   version: 1.1.0
             *
             * morphdom:
             *   license: MIT (http://opensource.org/licenses/MIT)
             *   author: Patrick Steele-Idem <pnidem@gmail.com>
             *   homepage: https://github.com/patrick-steele-idem/morphdom#readme
             *   version: 2.3.3
             *
             * process:
             *   license: MIT (http://opensource.org/licenses/MIT)
             *   author: Roman Shtylman <shtylman@gmail.com>
             *   homepage: https://github.com/shtylman/node-process#readme
             *   version: 0.11.10
             *
             * timers-browserify:
             *   licenses: MIT (http://opensource.org/licenses/MIT)
             *   author: J. Ryan Stinnett <jryans@gmail.com>
             *   contributors: Guy Bedford <guybedford@gmail.com>, Ionut-Cristian Florescu <ionut.florescu@gmail.com>, James Halliday <mail@substack.net>, Jan Schär <jscissr@gmail.com>, Johannes Ewald <johannes.ewald@peerigon.com>, Jonathan Prins <jon@blip.tv>, Matt Esch <matt@mattesch.info>
             *   homepage: https://github.com/jryans/timers-browserify
             *   version: 1.4.2
             *
             * This header is generated by licensify (https://github.com/twada/licensify)
             */
            !function () {
                function e(a, i, o) {
                    function n(s, l) {
                        if (!i[s]) {
                            if (!a[s]) {
                                var d = "function" == typeof t && t;
                                if (!l && d) return d(s, !0);
                                if (r) return r(s, !0);
                                var c = new Error("Cannot find module '" + s + "'");
                                throw c.code = "MODULE_NOT_FOUND", c
                            }
                            var p = i[s] = {exports: {}};
                            a[s][0].call(p.exports, function (t) {
                                return n(a[s][1][t] || t)
                            }, p, p.exports, e, a, i, o)
                        }
                        return i[s].exports
                    }

                    for (var r = "function" == typeof t && t, s = 0; s < o.length; s++) n(o[s]);
                    return n
                }

                return e
            }()({
                1: [function (t, e, a) {
                    "use strict";

                    function i(t) {
                        if (Array.isArray(t)) {
                            for (var e = 0, a = Array(t.length); e < t.length; e++) a[e] = t[e];
                            return a
                        }
                        return Array.from(t)
                    }

                    function o(t, e) {
                        if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                    }

                    Object.defineProperty(a, "__esModule", {value: !0});
                    var n = function () {
                        function t(t, e) {
                            for (var a = 0; a < e.length; a++) {
                                var i = e[a];
                                i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i)
                            }
                        }

                        return function (e, a, i) {
                            return a && t(e.prototype, a), i && t(e, i), e
                        }
                    }();
                    t("ie-array-find-polyfill");
                    var r = t("morphdom"), s = function (t) {
                            return t && t.__esModule ? t : {default: t}
                        }(r), l = t("./util"),
                        d = "input paste copy click change keydown keyup keypress contextmenu mouseup mousedown mousemove touchstart touchend touchmove compositionstart compositionend focus",
                        c = d.replace(/([a-z]+)/g, "[data-action-$1],") + "[data-action]", p = function () {
                            function t(e) {
                                var a = this;
                                o(this, t), this.atemplate = [], e && Object.keys(e).forEach(function (t) {
                                    a[t] = e[t]
                                }), this.data || (this.data = {}), this.templates || (this.templates = []);
                                for (var i = this.templates, n = i.length, r = 0, s = n; r < s; r += 1) {
                                    var d = this.templates[r], c = (0, l.selector)("#" + d).innerHTML;
                                    this.atemplate.push({id: d, html: c, binded: !1})
                                }
                            }

                            return n(t, [{
                                key: "addDataBind", value: function (t) {
                                    var e = this;
                                    (0, l.on)(t, "[data-bind]", "input change click", function (t) {
                                        var a = t.delegateTarget, i = a.getAttribute("data-bind"),
                                            o = a.getAttribute("href"), n = a.value;
                                        o && (n = n.replace("#", "")), "checkbox" === a.getAttribute("type") ? function () {
                                            var t = [], e = document.querySelectorAll('[data-bind="' + i + '"]');
                                            [].forEach.call(e, function (e) {
                                                e.checked && t.push(e.value)
                                            })
                                        }() : "radio" !== a.getAttribute("type") && e.updateDataByString(i, n)
                                    })
                                }
                            }, {
                                key: "addActionBind", value: function (t) {
                                    var e = this;
                                    (0, l.on)(t, c, d, function (t) {
                                        var a = t.delegateTarget, o = d.split(" "), n = "action";
                                        o.forEach(function (e) {
                                            a.getAttribute("data-action-" + e) && t.type === e && (n += "-" + e)
                                        });
                                        var r = a.getAttribute("data-" + n);
                                        if (r) {
                                            var s = r.replace(/\(.*?\);?/, ""), l = r.replace(/(.*?)\((.*?)\);?/, "$2"),
                                                c = l.split(",");
                                            if (e.e = t, e.method && e.method[s]) {
                                                var p;
                                                (p = e.method)[s].apply(p, i(c))
                                            } else e[s] && e[s].apply(e, i(c))
                                        }
                                    })
                                }
                            }, {
                                key: "addTemplate", value: function (t, e) {
                                    this.atemplate.push({id: t, html: e, binded: !1}), this.templates.push(t)
                                }
                            }, {
                                key: "getData", value: function () {
                                    return JSON.parse(JSON.stringify(this.data))
                                }
                            }, {
                                key: "saveData", value: function (t) {
                                    var e = JSON.stringify(this.data);
                                    localStorage.setItem(t, e)
                                }
                            }, {
                                key: "setData", value: function (t) {
                                    var e = this;
                                    Object.keys(t).forEach(function (a) {
                                        "function" != typeof t[a] && (e.data[a] = t[a])
                                    })
                                }
                            }, {
                                key: "loadData", value: function (t) {
                                    var e = JSON.parse(localStorage.getItem(t));
                                    e && this.setData(e)
                                }
                            }, {
                                key: "getRand", value: function (t, e) {
                                    return ~~(Math.random() * (e - t + 1)) + t
                                }
                            }, {
                                key: "getRandText", value: function (t) {
                                    for (var e = "", a = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", i = a.length, o = 0; o < t; o += 1) e += a.charAt(Math.floor(this.getRand(0, i)));
                                    return e
                                }
                            }, {
                                key: "getDataFromObj", value: function (t, e) {
                                    t = t.replace(/\[([\w\-\.ぁ-んァ-ヶ亜-熙]+)\]/g, ".$1"), t = t.replace(/^\./, "");
                                    for (var a = t.split("."); a.length;) {
                                        var i = a.shift();
                                        if (!(i in e)) return null;
                                        e = e[i]
                                    }
                                    return e
                                }
                            }, {
                                key: "getDataByString", value: function (t) {
                                    var e = this.data;
                                    return this.getDataFromObj(t, e)
                                }
                            }, {
                                key: "updateDataByString", value: function (t, e) {
                                    for (var a = this.data, i = t.split("."); i.length > 1;) a = a[i.shift()];
                                    a[i.shift()] = e
                                }
                            }, {
                                key: "removeDataByString", value: function (t) {
                                    for (var e = this.data, a = t.split("."); a.length > 1;) e = e[a.shift()];
                                    var i = a.shift();
                                    i.match(/^\d+$/) ? e.splice(Number(i), 1) : delete e[i]
                                }
                            }, {
                                key: "resolveBlock", value: function (t, e, a) {
                                    var i = this,
                                        o = t.match(/<!-- BEGIN ([\w\-\.ぁ-んァ-ヶ亜-熙]+):touch#([\w\-\.ぁ-んァ-ヶ亜-熙]+) -->/g),
                                        n = t.match(/<!-- BEGIN ([\w\-\.ぁ-んァ-ヶ亜-熙]+):touchnot#([\w\-\.ぁ-んァ-ヶ亜-熙]+) -->/g),
                                        r = t.match(/<!-- BEGIN ([\w\-\.ぁ-んァ-ヶ亜-熙]+):exist -->/g),
                                        s = t.match(/<!-- BEGIN ([\w\-\.ぁ-んァ-ヶ亜-熙]+):empty -->/g);
                                    if (o) for (var l = 0, d = o.length; l < d; l += 1) {
                                        var c = o[l];
                                        c = c.replace(/([\w\-\.ぁ-んァ-ヶ亜-熙]+):touch#([\w\-\.ぁ-んァ-ヶ亜-熙]+)/, "($1):touch#($2)");
                                        var p = c.replace(/BEGIN/, "END"),
                                            u = new RegExp(c + "(([\\n\\r\\t]|.)*?)" + p, "g");
                                        t = t.replace(u, function (t, a, o, n) {
                                            return "" + ("function" == typeof e[a] ? e[a].apply(i) : i.getDataFromObj(a, e)) === o ? n : ""
                                        })
                                    }
                                    if (n) for (var h = 0, f = n.length; h < f; h += 1) {
                                        var m = n[h];
                                        m = m.replace(/([\w\-\.ぁ-んァ-ヶ亜-熙]+):touchnot#([\w\-\.ぁ-んァ-ヶ亜-熙]+)/, "($1):touchnot#($2)");
                                        var g = m.replace(/BEGIN/, "END"),
                                            v = new RegExp(m + "(([\\n\\r\\t]|.)*?)" + g, "g");
                                        t = t.replace(v, function (t, a, o, n) {
                                            return "" + ("function" == typeof e[a] ? e[a].apply(i) : i.getDataFromObj(a, e)) !== o ? n : ""
                                        })
                                    }
                                    if (r) for (var w = 0, y = r.length; w < y; w += 1) {
                                        var b = r[w];
                                        b = b.replace(/([\w\-\.ぁ-んァ-ヶ亜-熙]+):exist/, "($1):exist");
                                        var x = b.replace(/BEGIN/, "END"),
                                            T = new RegExp(b + "(([\\n\\r\\t]|.)*?)" + x, "g");
                                        t = t.replace(T, function (t, a, o) {
                                            var n = "function" == typeof e[a] ? e[a].apply(i) : i.getDataFromObj(a, e);
                                            return n || 0 === n ? o : ""
                                        })
                                    }
                                    if (s) for (var C = 0, S = s.length; C < S; C += 1) {
                                        var k = s[C];
                                        k = k.replace(/([\w\-\.ぁ-んァ-ヶ亜-熙]+):empty/, "($1):empty");
                                        var E = k.replace(/BEGIN/, "END"),
                                            P = new RegExp(k + "(([\\n\\r\\t]|.)*?)" + E, "g");
                                        t = t.replace(P, function (t, a, o) {
                                            var n = "function" == typeof e[a] ? e[a].apply(i) : i.getDataFromObj(a, e);
                                            return n || 0 === n ? "" : o
                                        })
                                    }
                                    return t = t.replace(/{([\w\-\.ぁ-んァ-ヶ亜-熙]+)}(\[([\w\-\.ぁ-んァ-ヶ亜-熙]+)\])*/g, function (t, o, n, r) {
                                        var s = void 0;
                                        if ("" + o == "i") s = a; else {
                                            if (!e[o] && 0 !== e[o]) return r && i.convert && i.convert[r] ? i.convert[r].call(i, "") : "";
                                            s = "function" == typeof e[o] ? e[o].apply(i) : e[o]
                                        }
                                        return r && i.convert && i.convert[r] ? i.convert[r].call(i, s) : s
                                    })
                                }
                            }, {
                                key: "resolveAbsBlock", value: function (t) {
                                    var e = this;
                                    return t = t.replace(/{(.*?)}/g, function (t, a) {
                                        var i = e.getDataByString(a);
                                        return void 0 !== i ? "function" == typeof i ? i.apply(e) : i : t
                                    })
                                }
                            }, {
                                key: "resolveInclude", value: function (t) {
                                    return t = t.replace(/<!-- #include id="(.*?)" -->/g, function (t, e) {
                                        return (0, l.selector)("#" + e).innerHTML
                                    })
                                }
                            }, {
                                key: "resolveWith", value: function (t) {
                                    return t = t.replace(/<!-- BEGIN ([\w\-\.ぁ-んァ-ヶ亜-熙]+):with -->(([\n\r\t]|.)*?)<!-- END ([\w\-\.ぁ-んァ-ヶ亜-熙]+):with -->/g, function (t, e) {
                                        return t = t.replace(/data\-bind=['"](.*?)['"]/g, "data-bind='" + e + ".$1'")
                                    })
                                }
                            }, {
                                key: "resolveLoop", value: function (t) {
                                    var e = this;
                                    return t = t.replace(/<!-- BEGIN ([\w\-\.ぁ-んァ-ヶ亜-熙]+?):loop -->(([\n\r\t]|.)*?)<!-- END ([\w\-\.ぁ-んァ-ヶ亜-熙]+?):loop -->/g, function (t, a, i) {
                                        var o = e.getDataByString(a), n = [];
                                        n = "function" == typeof o ? o.apply(e) : o;
                                        var r = "";
                                        if (n instanceof Array) for (var s = 0, l = n.length; s < l; s += 1) r += e.resolveBlock(i, n[s], s);
                                        return r = r.replace(/\\([^\\])/g, "$1")
                                    })
                                }
                            }, {
                                key: "removeData", value: function (t) {
                                    var e = this.data;
                                    return Object.keys(e).forEach(function (a) {
                                        for (var i = 0, o = t.length; i < o; i += 1) a === t[i] && delete e[a]
                                    }), this
                                }
                            }, {
                                key: "hasLoop", value: function (t) {
                                    return !!t.match(/<!-- BEGIN ([\w\-\.ぁ-んァ-ヶ亜-熙]+?):loop -->(([\n\r\t]|.)*?)<!-- END ([\w\-\.ぁ-んァ-ヶ亜-熙]+?):loop -->/g)
                                }
                            }, {
                                key: "getHtml", value: function (t, e) {
                                    var a = this.atemplate.find(function (e) {
                                        return e.id === t
                                    }), i = "";
                                    if (a && a.html && (i = a.html), e && (i = t), !i) return "";
                                    var o = this.data;
                                    for (i = this.resolveInclude(i), i = this.resolveWith(i); this.hasLoop(i);) i = this.resolveLoop(i);
                                    return i = this.resolveBlock(i, o), i = i.replace(/\\([^\\])/g, "$1"), i = this.resolveAbsBlock(i), i.replace(/^([\t ])*\n/gm, "")
                                }
                            }, {
                                key: "update", value: function () {
                                    var t = this,
                                        e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "html",
                                        a = arguments[1], i = this.templates;
                                    this.beforeUpdated && this.beforeUpdated();
                                    for (var o = 0, n = i.length; o < n; o += 1) !function (o, n) {
                                        var r = i[o], d = "#" + r, c = t.getHtml(r),
                                            p = (0, l.selector)("[data-id='" + r + "']");
                                        if (p) if ("text" === e) p.innerText = c; else if (a) {
                                            var u = document.createElement("div");
                                            u.innerHTML = c;
                                            var h = u.querySelector(a).outerHTML;
                                            (0, s.default)(p.querySelector(a), h)
                                        } else (0, s.default)(p, "<div data-id='" + r + "'>" + c + "</div>"); else (0, l.selector)(d).insertAdjacentHTML("afterend", '<div data-id="' + r + '"></div>'), "text" === e ? (0, l.selector)("[data-id='" + r + "']").innerText = c : (0, l.selector)("[data-id='" + r + "']").innerHTML = c;
                                        var f = t.atemplate.find(function (t) {
                                            return t.id === r
                                        });
                                        f.binded || (f.binded = !0, t.addDataBind((0, l.selector)("[data-id='" + r + "']")), t.addActionBind((0, l.selector)("[data-id='" + r + "']")))
                                    }(o);
                                    return this.updateBindingData(a), this.onUpdated && this.onUpdated(a), this
                                }
                            }, {
                                key: "updateBindingData", value: function (t) {
                                    for (var e = this, a = this.templates, i = 0, o = a.length; i < o; i += 1) {
                                        var n = a[i], r = (0, l.selector)("[data-id='" + n + "']");
                                        t && (r = r.querySelector(t));
                                        var s = r.querySelectorAll("[data-bind]");
                                        [].forEach.call(s, function (t) {
                                            var a = e.getDataByString(t.getAttribute("data-bind"));
                                            "checkbox" === t.getAttribute("type") || "radio" === t.getAttribute("type") ? a === t.value && (t.checked = !0) : t.value = a
                                        });
                                        var d = r.querySelectorAll("[data-bind-oneway]");
                                        [].forEach.call(d, function (t) {
                                            var a = e.getDataByString(t.getAttribute("data-bind-oneway"));
                                            "checkbox" === t.getAttribute("type") || "radio" === t.getAttribute("type") ? a === t.value && (t.checked = !0) : t.value = a
                                        })
                                    }
                                    return this
                                }
                            }, {
                                key: "applyMethod", value: function (t) {
                                    for (var e, a = arguments.length, i = Array(a > 1 ? a - 1 : 0), o = 1; o < a; o++) i[o - 1] = arguments[o];
                                    return (e = this.method)[t].apply(e, i)
                                }
                            }, {
                                key: "getComputedProp", value: function (t) {
                                    return this.data[t].apply(this)
                                }
                            }, {
                                key: "remove", value: function (t) {
                                    for (var e = this.data, a = t.split("."); a.length > 1;) e = e[a.shift()];
                                    var i = a.shift();
                                    return i.match(/^\d+$/) ? e.splice(Number(i), 1) : delete e[i], this
                                }
                            }]), t
                        }();
                    a.default = p, e.exports = a.default
                }, {"./util": 2, "ie-array-find-polyfill": 5, morphdom: 6}],
                2: [function (t, e, a) {
                    "use strict";
                    Object.defineProperty(a, "__esModule", {value: !0});
                    var i = a.matches = function (t, e) {
                        for (var a = (t.document || t.ownerDocument).querySelectorAll(e), i = a.length; --i >= 0 && a.item(i) !== t;) ;
                        return i > -1
                    }, o = (a.selector = function (t) {
                        return document.querySelector(t)
                    }, a.findAncestor = function (t, e) {
                        if ("function" == typeof t.closest) return t.closest(e) || null;
                        for (; t && t !== document;) {
                            if (i(t, e)) return t;
                            t = t.parentElement
                        }
                        return null
                    });
                    a.on = function (t, e, a, i) {
                        a.split(" ").forEach(function (a) {
                            t.addEventListener(a, function (t) {
                                var a = (t.target, o(t.target, e));
                                a && (t.delegateTarget = a, i(t))
                            })
                        })
                    }
                }, {}],
                3: [function (t, e, a) {
                    try {
                        var i = new window.CustomEvent("test");
                        if (i.preventDefault(), !0 !== i.defaultPrevented) throw new Error("Could not prevent default")
                    } catch (t) {
                        var o = function (t, e) {
                            var a, i;
                            return e = e || {
                                bubbles: !1,
                                cancelable: !1,
                                detail: void 0
                            }, a = document.createEvent("CustomEvent"), a.initCustomEvent(t, e.bubbles, e.cancelable, e.detail), i = a.preventDefault, a.preventDefault = function () {
                                i.call(this);
                                try {
                                    Object.defineProperty(this, "defaultPrevented", {
                                        get: function () {
                                            return !0
                                        }
                                    })
                                } catch (t) {
                                    this.defaultPrevented = !0
                                }
                            }, a
                        };
                        o.prototype = window.Event.prototype, window.CustomEvent = o
                    }
                }, {}],
                4: [function (t, a, i) {
                    (function (t, e) {
                        !function (t) {
                            function a(t) {
                                return "[object Array]" === Object.prototype.toString.call(t)
                            }

                            function o() {
                                for (var t = 0; t < k.length; t++) k[t][0](k[t][1]);
                                k = [], w = !1
                            }

                            function n(t, e) {
                                k.push([t, e]), w || (w = !0, S(o, 0))
                            }

                            function r(t, e) {
                                function a(t) {
                                    d(e, t)
                                }

                                function i(t) {
                                    p(e, t)
                                }

                                try {
                                    t(a, i)
                                } catch (t) {
                                    i(t)
                                }
                            }

                            function s(t) {
                                var e = t.owner, a = e.state_, i = e.data_, o = t[a], n = t.then;
                                if ("function" == typeof o) {
                                    a = x;
                                    try {
                                        i = o(i)
                                    } catch (t) {
                                        p(n, t)
                                    }
                                }
                                l(n, i) || (a === x && d(n, i), a === T && p(n, i))
                            }

                            function l(t, e) {
                                var a;
                                try {
                                    if (t === e) throw new TypeError("A promises callback cannot return that same promise.");
                                    if (e && ("function" == typeof e || "object" == typeof e)) {
                                        var i = e.then;
                                        if ("function" == typeof i) return i.call(e, function (i) {
                                            a || (a = !0, e !== i ? d(t, i) : c(t, i))
                                        }, function (e) {
                                            a || (a = !0, p(t, e))
                                        }), !0
                                    }
                                } catch (e) {
                                    return a || p(t, e), !0
                                }
                                return !1
                            }

                            function d(t, e) {
                                t !== e && l(t, e) || c(t, e)
                            }

                            function c(t, e) {
                                t.state_ === y && (t.state_ = b, t.data_ = e, n(h, t))
                            }

                            function p(t, e) {
                                t.state_ === y && (t.state_ = b, t.data_ = e, n(f, t))
                            }

                            function u(t) {
                                var e = t.then_;
                                t.then_ = void 0;
                                for (var a = 0; a < e.length; a++) s(e[a])
                            }

                            function h(t) {
                                t.state_ = x, u(t)
                            }

                            function f(t) {
                                t.state_ = T, u(t)
                            }

                            function m(t) {
                                if ("function" != typeof t) throw new TypeError("Promise constructor takes a function argument");
                                if (this instanceof m == 0) throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.");
                                this.then_ = [], r(t, this)
                            }

                            var g = t.Promise,
                                v = g && "resolve" in g && "reject" in g && "all" in g && "race" in g && function () {
                                    var t;
                                    return new g(function (e) {
                                        t = e
                                    }), "function" == typeof t
                                }();
                            void 0 !== i && i ? (i.Promise = v ? g : m, i.Polyfill = m) : "function" == typeof define && define.amd ? define(function () {
                                return v ? g : m
                            }) : v || (t.Promise = m);
                            var w, y = "pending", b = "sealed", x = "fulfilled", T = "rejected", C = function () {
                            }, S = void 0 !== e ? e : setTimeout, k = [];
                            m.prototype = {
                                constructor: m,
                                state_: y,
                                then_: null,
                                data_: void 0,
                                then: function (t, e) {
                                    var a = {owner: this, then: new this.constructor(C), fulfilled: t, rejected: e};
                                    return this.state_ === x || this.state_ === T ? n(s, a) : this.then_.push(a), a.then
                                },
                                catch: function (t) {
                                    return this.then(null, t)
                                }
                            }, m.all = function (t) {
                                var e = this;
                                if (!a(t)) throw new TypeError("You must pass an array to Promise.all().");
                                return new e(function (e, a) {
                                    for (var i, o = [], n = 0, r = 0; r < t.length; r++) i = t[r], i && "function" == typeof i.then ? i.then(function (t) {
                                        return n++, function (a) {
                                            o[t] = a, --n || e(o)
                                        }
                                    }(r), a) : o[r] = i;
                                    n || e(o)
                                })
                            }, m.race = function (t) {
                                var e = this;
                                if (!a(t)) throw new TypeError("You must pass an array to Promise.race().");
                                return new e(function (e, a) {
                                    for (var i, o = 0; o < t.length; o++) i = t[o], i && "function" == typeof i.then ? i.then(e, a) : e(i)
                                })
                            }, m.resolve = function (t) {
                                var e = this;
                                return t && "object" == typeof t && t.constructor === e ? t : new e(function (e) {
                                    e(t)
                                })
                            }, m.reject = function (t) {
                                return new this(function (e, a) {
                                    a(t)
                                })
                            }
                        }("undefined" != typeof window ? window : void 0 !== t ? t : "undefined" != typeof self ? self : this)
                    }).call(this, void 0 !== e ? e : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, t("timers").setImmediate)
                }, {timers: 8}],
                5: [function (t, e, a) {
                    "use strict";
                    Array.prototype.find || Object.defineProperty(Array.prototype, "find", {
                        value: function (t) {
                            if (null == this) throw new TypeError("this is null or not defined");
                            var e = Object(this), a = e.length >>> 0;
                            if ("function" != typeof t) throw new TypeError("predicate must be a function");
                            for (var i = arguments[1], o = 0; o < a;) {
                                var n = e[o];
                                if (t.call(i, n, o, e)) return n;
                                o++
                            }
                        }
                    })
                }, {}],
                6: [function (t, e, a) {
                    "use strict";

                    function i(t) {
                        !p && f.createRange && (p = f.createRange(), p.selectNode(f.body));
                        var e;
                        return p && p.createContextualFragment ? e = p.createContextualFragment(t) : (e = f.createElement("body"), e.innerHTML = t), e.childNodes[0]
                    }

                    function o(t, e) {
                        var a = t.nodeName, i = e.nodeName;
                        return a === i || !!(e.actualize && a.charCodeAt(0) < 91 && i.charCodeAt(0) > 90) && a === i.toUpperCase()
                    }

                    function n(t, e) {
                        return e && e !== h ? f.createElementNS(e, t) : f.createElement(t)
                    }

                    function r(t, e) {
                        for (var a = t.firstChild; a;) {
                            var i = a.nextSibling;
                            e.appendChild(a), a = i
                        }
                        return e
                    }

                    function s(t, e) {
                        var a, i, o, n, r, s = e.attributes;
                        for (a = s.length - 1; a >= 0; --a) i = s[a], o = i.name, n = i.namespaceURI, r = i.value, n ? (o = i.localName || o, t.getAttributeNS(n, o) !== r && t.setAttributeNS(n, o, r)) : t.getAttribute(o) !== r && t.setAttribute(o, r);
                        for (s = t.attributes, a = s.length - 1; a >= 0; --a) i = s[a], !1 !== i.specified && (o = i.name, n = i.namespaceURI, n ? (o = i.localName || o, g(e, n, o) || t.removeAttributeNS(n, o)) : g(e, null, o) || t.removeAttribute(o))
                    }

                    function l(t, e, a) {
                        t[a] !== e[a] && (t[a] = e[a], t[a] ? t.setAttribute(a, "") : t.removeAttribute(a, ""))
                    }

                    function d() {
                    }

                    function c(t) {
                        return t.id
                    }

                    var p, u, h = "http://www.w3.org/1999/xhtml",
                        f = "undefined" == typeof document ? void 0 : document,
                        m = f ? f.body || f.createElement("div") : {};
                    u = m.hasAttributeNS ? function (t, e, a) {
                        return t.hasAttributeNS(e, a)
                    } : m.hasAttribute ? function (t, e, a) {
                        return t.hasAttribute(a)
                    } : function (t, e, a) {
                        return null != t.getAttributeNode(e, a)
                    };
                    var g = u, v = {
                        OPTION: function (t, e) {
                            l(t, e, "selected")
                        }, INPUT: function (t, e) {
                            l(t, e, "checked"), l(t, e, "disabled"), t.value !== e.value && (t.value = e.value), g(e, null, "value") || t.removeAttribute("value")
                        }, TEXTAREA: function (t, e) {
                            var a = e.value;
                            t.value !== a && (t.value = a);
                            var i = t.firstChild;
                            if (i) {
                                var o = i.nodeValue;
                                if (o == a || !a && o == t.placeholder) return;
                                i.nodeValue = a
                            }
                        }, SELECT: function (t, e) {
                            if (!g(e, null, "multiple")) {
                                for (var a = 0, i = e.firstChild; i;) {
                                    var o = i.nodeName;
                                    if (o && "OPTION" === o.toUpperCase()) {
                                        if (g(i, null, "selected")) break;
                                        a++
                                    }
                                    i = i.nextSibling
                                }
                                t.selectedIndex = a
                            }
                        }
                    }, w = 1, y = 3, b = 8, x = function (t) {
                        return function (e, a, s) {
                            function l(t) {
                                T ? T.push(t) : T = [t]
                            }

                            function p(t, e) {
                                if (t.nodeType === w) for (var a = t.firstChild; a;) {
                                    var i = void 0;
                                    e && (i = C(a)) ? l(i) : (_(a), a.firstChild && p(a, e)), a = a.nextSibling
                                }
                            }

                            function u(t, e, a) {
                                !1 !== I(t) && (e && e.removeChild(t), _(t), p(t, a))
                            }

                            function h(t) {
                                if (t.nodeType === w) for (var e = t.firstChild; e;) {
                                    var a = C(e);
                                    a && (N[a] = e), h(e), e = e.nextSibling
                                }
                            }

                            function m(t) {
                                k(t);
                                for (var e = t.firstChild; e;) {
                                    var a = e.nextSibling, i = C(e);
                                    if (i) {
                                        var n = N[i];
                                        n && o(e, n) && (e.parentNode.replaceChild(n, e), g(n, e))
                                    }
                                    m(e), e = a
                                }
                            }

                            function g(i, n, r) {
                                var s, d = C(n);
                                if (d && delete N[d], !a.isSameNode || !a.isSameNode(e)) {
                                    if (!r) {
                                        if (!1 === E(i, n)) return;
                                        if (t(i, n), P(i), !1 === D(i, n)) return
                                    }
                                    if ("TEXTAREA" !== i.nodeName) {
                                        var c, p, h, x, T = n.firstChild, k = i.firstChild;
                                        t:for (; T;) {
                                            for (h = T.nextSibling, c = C(T); k;) {
                                                if (p = k.nextSibling, T.isSameNode && T.isSameNode(k)) {
                                                    T = h, k = p;
                                                    continue t
                                                }
                                                s = C(k);
                                                var I = k.nodeType, _ = void 0;
                                                if (I === T.nodeType && (I === w ? (c ? c !== s && ((x = N[c]) ? k.nextSibling === x ? _ = !1 : (i.insertBefore(x, k), p = k.nextSibling, s ? l(s) : u(k, i, !0), k = x) : _ = !1) : s && (_ = !1), (_ = !1 !== _ && o(k, T)) && g(k, T)) : I !== y && I != b || (_ = !0, k.nodeValue !== T.nodeValue && (k.nodeValue = T.nodeValue))), _) {
                                                    T = h, k = p;
                                                    continue t
                                                }
                                                s ? l(s) : u(k, i, !0), k = p
                                            }
                                            if (c && (x = N[c]) && o(x, T)) i.appendChild(x), g(x, T); else {
                                                var A = S(T);
                                                !1 !== A && (A && (T = A), T.actualize && (T = T.actualize(i.ownerDocument || f)), i.appendChild(T), m(T))
                                            }
                                            T = h, k = p
                                        }
                                        for (; k;) p = k.nextSibling, (s = C(k)) ? l(s) : u(k, i, !0), k = p
                                    }
                                    var M = v[i.nodeName];
                                    M && M(i, n)
                                }
                            }

                            if (s || (s = {}), "string" == typeof a) if ("#document" === e.nodeName || "HTML" === e.nodeName) {
                                var x = a;
                                a = f.createElement("html"), a.innerHTML = x
                            } else a = i(a);
                            var T, C = s.getNodeKey || c, S = s.onBeforeNodeAdded || d, k = s.onNodeAdded || d,
                                E = s.onBeforeElUpdated || d, P = s.onElUpdated || d, I = s.onBeforeNodeDiscarded || d,
                                _ = s.onNodeDiscarded || d, D = s.onBeforeElChildrenUpdated || d,
                                A = !0 === s.childrenOnly, N = {};
                            h(e);
                            var M = e, B = M.nodeType, z = a.nodeType;
                            if (!A) if (B === w) z === w ? o(e, a) || (_(e), M = r(e, n(a.nodeName, a.namespaceURI))) : M = a; else if (B === y || B === b) {
                                if (z === B) return M.nodeValue !== a.nodeValue && (M.nodeValue = a.nodeValue), M;
                                M = a
                            }
                            if (M === a) _(e); else if (g(M, a, A), T) for (var O = 0, j = T.length; O < j; O++) {
                                var L = N[T[O]];
                                L && u(L, L.parentNode, !1)
                            }
                            return !A && M !== e && e.parentNode && (M.actualize && (M = M.actualize(e.ownerDocument || f)), e.parentNode.replaceChild(M, e)), M
                        }
                    }(s);
                    e.exports = x
                }, {}],
                7: [function (t, e, a) {
                    function i() {
                        throw new Error("setTimeout has not been defined")
                    }

                    function o() {
                        throw new Error("clearTimeout has not been defined")
                    }

                    function n(t) {
                        if (p === setTimeout) return setTimeout(t, 0);
                        if ((p === i || !p) && setTimeout) return p = setTimeout, setTimeout(t, 0);
                        try {
                            return p(t, 0)
                        } catch (e) {
                            try {
                                return p.call(null, t, 0)
                            } catch (e) {
                                return p.call(this, t, 0)
                            }
                        }
                    }

                    function r(t) {
                        if (u === clearTimeout) return clearTimeout(t);
                        if ((u === o || !u) && clearTimeout) return u = clearTimeout, clearTimeout(t);
                        try {
                            return u(t)
                        } catch (e) {
                            try {
                                return u.call(null, t)
                            } catch (e) {
                                return u.call(this, t)
                            }
                        }
                    }

                    function s() {
                        g && f && (g = !1, f.length ? m = f.concat(m) : v = -1, m.length && l())
                    }

                    function l() {
                        if (!g) {
                            var t = n(s);
                            g = !0;
                            for (var e = m.length; e;) {
                                for (f = m, m = []; ++v < e;) f && f[v].run();
                                v = -1, e = m.length
                            }
                            f = null, g = !1, r(t)
                        }
                    }

                    function d(t, e) {
                        this.fun = t, this.array = e
                    }

                    function c() {
                    }

                    var p, u, h = e.exports = {};
                    !function () {
                        try {
                            p = "function" == typeof setTimeout ? setTimeout : i
                        } catch (t) {
                            p = i
                        }
                        try {
                            u = "function" == typeof clearTimeout ? clearTimeout : o
                        } catch (t) {
                            u = o
                        }
                    }();
                    var f, m = [], g = !1, v = -1;
                    h.nextTick = function (t) {
                        var e = new Array(arguments.length - 1);
                        if (arguments.length > 1) for (var a = 1; a < arguments.length; a++) e[a - 1] = arguments[a];
                        m.push(new d(t, e)), 1 !== m.length || g || n(l)
                    }, d.prototype.run = function () {
                        this.fun.apply(null, this.array)
                    }, h.title = "browser", h.browser = !0, h.env = {}, h.argv = [], h.version = "", h.versions = {}, h.on = c, h.addListener = c, h.once = c, h.off = c, h.removeListener = c, h.removeAllListeners = c, h.emit = c, h.prependListener = c, h.prependOnceListener = c, h.listeners = function (t) {
                        return []
                    }, h.binding = function (t) {
                        throw new Error("process.binding is not supported")
                    }, h.cwd = function () {
                        return "/"
                    }, h.chdir = function (t) {
                        throw new Error("process.chdir is not supported")
                    }, h.umask = function () {
                        return 0
                    }
                }, {}],
                8: [function (t, e, a) {
                    (function (e, i) {
                        function o(t, e) {
                            this._id = t, this._clearFn = e
                        }

                        var n = t("process/browser.js").nextTick, r = Function.prototype.apply,
                            s = Array.prototype.slice, l = {}, d = 0;
                        a.setTimeout = function () {
                            return new o(r.call(setTimeout, window, arguments), clearTimeout)
                        }, a.setInterval = function () {
                            return new o(r.call(setInterval, window, arguments), clearInterval)
                        }, a.clearTimeout = a.clearInterval = function (t) {
                            t.close()
                        }, o.prototype.unref = o.prototype.ref = function () {
                        }, o.prototype.close = function () {
                            this._clearFn.call(window, this._id)
                        }, a.enroll = function (t, e) {
                            clearTimeout(t._idleTimeoutId), t._idleTimeout = e
                        }, a.unenroll = function (t) {
                            clearTimeout(t._idleTimeoutId), t._idleTimeout = -1
                        }, a._unrefActive = a.active = function (t) {
                            clearTimeout(t._idleTimeoutId);
                            var e = t._idleTimeout;
                            e >= 0 && (t._idleTimeoutId = setTimeout(function () {
                                t._onTimeout && t._onTimeout()
                            }, e))
                        }, a.setImmediate = "function" == typeof e ? e : function (t) {
                            var e = d++, i = !(arguments.length < 2) && s.call(arguments, 1);
                            return l[e] = !0, n(function () {
                                l[e] && (i ? t.apply(null, i) : t.call(null), a.clearImmediate(e))
                            }), e
                        }, a.clearImmediate = "function" == typeof i ? i : function (t) {
                            delete l[t]
                        }
                    }).call(this, t("timers").setImmediate, t("timers").clearImmediate)
                }, {"process/browser.js": 7, timers: 8}],
                9: [function (t, e, a) {
                    "use strict";
                    var i = t("../index"), o = function (t) {
                        t.fn.SmartPhoto = function (t) {
                            return "strings" == typeof t || new i(this, t), this
                        }
                    };
                    if ("function" == typeof define && define.amd) define(["jquery"], o); else {
                        var n = window.jQuery ? window.jQuery : window.$;
                        void 0 !== n && o(n)
                    }
                    e.exports = o
                }, {"../index": 11}],
                10: [function (t, e, a) {
                    "use strict";

                    function i(t, e) {
                        if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                    }

                    function o(t, e) {
                        if (!t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                        return !e || "object" != typeof e && "function" != typeof e ? t : e
                    }

                    function n(t, e) {
                        if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function, not " + typeof e);
                        t.prototype = Object.create(e && e.prototype, {
                            constructor: {
                                value: t,
                                enumerable: !1,
                                writable: !0,
                                configurable: !0
                            }
                        }), e && (Object.setPrototypeOf ? Object.setPrototypeOf(t, e) : t.__proto__ = e)
                    }

                    Object.defineProperty(a, "__esModule", {value: !0});
                    var r = function () {
                        function t(t, e) {
                            for (var a = 0; a < e.length; a++) {
                                var i = e[a];
                                i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i)
                            }
                        }

                        return function (e, a, i) {
                            return a && t(e.prototype, a), i && t(e, i), e
                        }
                    }(), s = t("a-template"), l = function (t) {
                        return t && t.__esModule ? t : {default: t}
                    }(s);
                    t("custom-event-polyfill");
                    var d = '<div class="\\{classNames.smartPhoto\\}"\x3c!-- BEGIN hide:exist --\x3e aria-hidden="true"\x3c!-- END hide:exist --\x3e\x3c!-- BEGIN hide:empty --\x3e aria-hidden="false"\x3c!-- END hide:empty --\x3e role="dialog">\n\t<div class="\\{classNames.smartPhotoBody\\}">\n\t\t<div class="\\{classNames.smartPhotoInner\\}">\n\t\t\t   <div class="\\{classNames.smartPhotoHeader\\}">\n\t\t\t\t\t<span class="\\{classNames.smartPhotoCount\\}">{currentIndex}[increment]/{total}</span>\n\t\t\t\t\t<span class="\\{classNames.smartPhotoCaption\\}" aria-live="polite" tabindex="-1">\x3c!-- BEGIN groupItems:loop --\x3e\x3c!-- \\BEGIN currentIndex:touch#{index} --\x3e{caption}\x3c!-- \\END currentIndex:touch#{index} --\x3e\x3c!-- END groupItems:loop --\x3e</span>\n\t\t\t\t\t<button class="\\{classNames.smartPhotoDismiss\\}" data-action-click="hidePhoto()"><span class="smartphoto-sr-only">\\{message.closeDialog\\}</span></button>\n\t\t\t\t</div>\n\t\t\t\t<div class="\\{classNames.smartPhotoContent\\}"\x3c!-- BEGIN isSmartPhone:exist --\x3e data-action-touchstart="beforeDrag" data-action-touchmove="onDrag" data-action-touchend="afterDrag(false)"\x3c!-- END isSmartPhone:exist --\x3e\x3c!-- BEGIN isSmartPhone:empty --\x3e data-action-click="hidePhoto()"\x3c!-- END isSmartPhone:empty --\x3e>\n\t\t\t\t</div>\n\t\t\t\t<ul style="transform:translate({translateX}[round]px,{translateY}[round]px);" class="\\{classNames.smartPhotoList\\}\x3c!-- BEGIN onMoveClass:exist --\x3e \\{classNames.smartPhotoListOnMove\\}\x3c!-- END onMoveClass:exist --\x3e">\n\t\t\t\t\t\x3c!-- BEGIN groupItems:loop --\x3e\n\t\t\t\t\t<li style="transform:translate({translateX}[round]px,{translateY}[round]px);" class="\x3c!-- \\BEGIN currentIndex:touch#{index} --\x3ecurrent\x3c!-- \\END currentIndex:touch#{index} --\x3e">\n\t\t\t\t\t\t\x3c!-- BEGIN processed:exist --\x3e\n\t\t\t\t\t\t<div style="transform:translate({x}[round]px,{y}[round]px) scale({scale});" class="\\\\{classNames.smartPhotoImgWrap\\\\}"\x3c!-- \\BEGIN isSmartPhone:empty --\x3e data-action-mousemove="onDrag" data-action-mousedown="beforeDrag" data-action-mouseup="afterDrag"\x3c!-- \\END isSmartPhone:empty --\x3e\x3c!-- \\BEGIN isSmartPhone:exist --\x3e data-action-touchstart="beforeDrag" data-action-touchmove="onDrag" data-action-touchend="afterDrag"\x3c!-- \\END isSmartPhone:exist --\x3e>\n\t\t\t\t\t\t\t<img style="\x3c!-- \\BEGIN currentIndex:touch#{index} --\x3etransform:translate(\\{photoPosX\\}[virtualPos]px,\\{photoPosY\\}[virtualPos]px) scale(\\{scaleSize\\});\x3c!-- \\END currentIndex:touch#{index} --\x3ewidth:{width}px;" src="{src}" class="\\\\{classNames.smartPhotoImg\\\\}\x3c!-- \\BEGIN scale:exist --\x3e  \\\\{classNames.smartPhotoImgOnMove\\\\}\x3c!-- \\END scale:exist --\x3e\x3c!-- \\BEGIN elastic:exist --\x3e \\\\{classNames.smartPhotoImgElasticMove\\\\}\x3c!-- \\END elastic:exist --\x3e\x3c!-- \\BEGIN appear:exist --\x3e active\x3c!-- \\END appear:exist --\x3e" ondragstart="return false;">\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\x3c!-- END processed:exist --\x3e\n\t\t\t\t\t\t\x3c!-- BEGIN processed:empty --\x3e\n\t\t\t\t\t\t<div class="\\\\{classNames.smartPhotoLoaderWrap\\\\}">\n\t\t\t\t\t\t\t<span class="\\\\{classNames.smartPhotoLoader\\\\}"></span>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\x3c!-- END processed:empty --\x3e\n\t\t\t\t\t</li>\n\t\t\t\t\t\x3c!-- END groupItems:loop --\x3e\n\t\t\t\t</ul>\n\t\t\t\t\x3c!-- BEGIN arrows:exist --\x3e\n\t\t\t\t<ul class="\\{classNames.smartPhotoArrows\\}"\x3c!-- BEGIN hideUi:exist --\x3e aria-hidden="true"\x3c!-- END hideUi:exist --\x3e\x3c!-- BEGIN hideUi:exist --\x3e aria-hidden="false"\x3c!-- END hideUi:exist --\x3e>\n\t\t\t\t\t<li class="\\{classNames.smartPhotoArrowLeft\\}\x3c!-- BEGIN isSmartPhone:exist --\x3e \\{classNames.smartPhotoArrowHideIcon\\}\x3c!-- END isSmartPhone:exist --\x3e"\x3c!-- BEGIN showPrevArrow:empty --\x3e aria-hidden="true"\x3c!-- END showPrevArrow:empty --\x3e><a href="#" data-action-click="gotoSlide({prev})" role="button"><span class="smartphoto-sr-only">\\{message.gotoPrevImage\\}</span></a></li>\n\t\t\t\t\t<li class="\\{classNames.smartPhotoArrowRight\\}\x3c!-- BEGIN isSmartPhone:exist --\x3e \\{classNames.smartPhotoArrowHideIcon\\}\x3c!-- END isSmartPhone:exist --\x3e"\x3c!-- BEGIN showNextArrow:empty --\x3e aria-hidden="true"\x3c!-- END showNextArrow:empty --\x3e><a href="#" data-action-click="gotoSlide({next})" role="button"><span class="smartphoto-sr-only">\\{message.gotoNextImage\\}</span></a></li>\n\t\t\t\t</ul>\n\t\t\t\t\x3c!-- END arrows:exist --\x3e\n\t\t\t\t\x3c!-- BEGIN nav:exist --\x3e\n\t\t\t\t<nav class="\\{classNames.smartPhotoNav\\}"\x3c!-- BEGIN hideUi:exist --\x3e aria-hidden="true"\x3c!-- END hideUi:exist --\x3e\x3c!-- BEGIN hideUi:exist --\x3e aria-hidden="false"\x3c!-- END hideUi:exist --\x3e>\n\t\t\t\t\t<ul>\n\t\t\t\t\t\t\x3c!-- BEGIN groupItems:loop --\x3e\n\t\t\t\t\t\t<li><a href="#" data-action-click="gotoSlide({index})" class="\x3c!-- \\BEGIN currentIndex:touch#{index} --\x3ecurrent\x3c!-- \\END currentIndex:touch#{index} --\x3e" style="background-image:url({thumb});" role="button"><span class="smartphoto-sr-only">go to {caption}</span></a></li>\n\t\t\t\t\t\t\x3c!-- END groupItems:loop --\x3e\n\t\t\t\t\t</ul>\n\t\t\t\t</nav>\n\t\t\t\t\x3c!-- END nav:exist --\x3e\n\t\t</div>\n\t\t\x3c!-- BEGIN appearEffect:exist --\x3e\n\t\t<img src=\\{appearEffect.img\\}\n\t\tclass="\\{classNames.smartPhotoImgClone\\}"\n\t\tstyle="width:\\{appearEffect.width\\}px;height:\\{appearEffect.height\\}px;transform:translate(\\{appearEffect.left\\}px,\\{appearEffect.top\\}px) scale(1)" />\n\t\t\x3c!-- END appearEffect:exist --\x3e\n\t</div>\n</div>\n',
                        c = t("../lib/util"), p = t("es6-promise-polyfill").Promise, u = {
                            classNames: {
                                smartPhoto: "smartphoto",
                                smartPhotoClose: "smartphoto-close",
                                smartPhotoBody: "smartphoto-body",
                                smartPhotoInner: "smartphoto-inner",
                                smartPhotoContent: "smartphoto-content",
                                smartPhotoImg: "smartphoto-img",
                                smartPhotoImgOnMove: "smartphoto-img-onmove",
                                smartPhotoImgElasticMove: "smartphoto-img-elasticmove",
                                smartPhotoImgWrap: "smartphoto-img-wrap",
                                smartPhotoArrows: "smartphoto-arrows",
                                smartPhotoNav: "smartphoto-nav",
                                smartPhotoArrowRight: "smartphoto-arrow-right",
                                smartPhotoArrowLeft: "smartphoto-arrow-left",
                                smartPhotoArrowHideIcon: "smartphoto-arrow-hide",
                                smartPhotoImgLeft: "smartphoto-img-left",
                                smartPhotoImgRight: "smartphoto-img-right",
                                smartPhotoList: "smartphoto-list",
                                smartPhotoListOnMove: "smartphoto-list-onmove",
                                smartPhotoHeader: "smartphoto-header",
                                smartPhotoCount: "smartphoto-count",
                                smartPhotoCaption: "smartphoto-caption",
                                smartPhotoDismiss: "smartphoto-dismiss",
                                smartPhotoLoader: "smartphoto-loader",
                                smartPhotoLoaderWrap: "smartphoto-loader-wrap",
                                smartPhotoImgClone: "smartphoto-img-clone"
                            },
                            message: {
                                gotoNextImage: "go to the next image",
                                gotoPrevImage: "go to the previous image",
                                closeDialog: "close the image dialog"
                            },
                            arrows: !0,
                            nav: !0,
                            showAnimation: !0,
                            verticalGravity: !1,
                            useOrientationApi: !1,
                            useHistoryApi: !0,
                            swipeTopToClose: !1,
                            swipeBottomToClose: !0,
                            swipeOffset: 100,
                            headerHeight: 60,
                            footerHeight: 60,
                            forceInterval: 10,
                            registance: .5,
                            loadOffset: 2,
                            resizeStyle: "fit"
                        }, h = function (t) {
                            function e(t, a) {
                                i(this, e);
                                var n = o(this, (e.__proto__ || Object.getPrototypeOf(e)).call(this));
                                n.data = c.extend({}, u, a), n.data.currentIndex = 0, n.data.oldIndex = 0, n.data.hide = !0, n.data.group = {}, n.data.scaleSize = 1, n.data.scale = !1, n.pos = {
                                    x: 0,
                                    y: 0
                                }, n.data.photoPosX = 0, n.data.photoPosY = 0, n.convert = {
                                    increment: n.increment,
                                    virtualPos: n.virtualPos,
                                    round: n.round
                                }, n.data.groupItems = n.groupItems, n.elements = "string" == typeof t ? document.querySelectorAll(t) : t;
                                var r = new Date;
                                n.tapSecond = r.getTime(), n.onListMove = !1, n.clicked = !1, n.id = n._getUniqId(), n.vx = 0, n.vy = 0, n.data.appearEffect = null, n.addTemplate(n.id, d), n.data.isSmartPhone = n._isSmartPhone();
                                var s = document.querySelector("body");
                                c.append(s, "<div data-id='" + n.id + "'></div>"), [].forEach.call(n.elements, function (t) {
                                    n.addNewItem(t)
                                }), n.update();
                                var l = n._getCurrentItemByHash();
                                return l && c.triggerEvent(l.element, "click"), setInterval(function () {
                                    n._doAnim()
                                }, n.data.forceInterval), n.data.isSmartPhone ? (window.addEventListener("orientationchange", function () {
                                    n.groupItems() && (n._resetTranslate(), n._setPosByCurrentIndex(), n._setHashByCurrentIndex(), n._setSizeByScreen(), n.update())
                                }), n.data.useOrientationApi ? (window.addEventListener("deviceorientation", function (t) {
                                    var e = window, a = e.orientation;
                                    t && t.gamma && !n.data.appearEffect && (n.isBeingZoomed || n.photoSwipable || n.data.elastic || !n.data.scale || (0 === a ? n._calcGravity(t.gamma, t.beta) : 90 === a ? n._calcGravity(t.beta, t.gamma) : -90 === a ? n._calcGravity(-t.beta, -t.gamma) : 180 === a && n._calcGravity(-t.gamma, -t.beta)))
                                }), n) : o(n)) : (window.addEventListener("resize", function () {
                                    n.groupItems() && (n._resetTranslate(), n._setPosByCurrentIndex(), n._setSizeByScreen(), n.update())
                                }), window.addEventListener("keydown", function (t) {
                                    var e = t.keyCode || t.which;
                                    !0 !== n.data.hide && (37 === e ? n.gotoSlide(n.data.prev) : 39 === e ? n.gotoSlide(n.data.next) : 27 === e && n.hidePhoto())
                                }), o(n))
                            }

                            return n(e, t), r(e, [{
                                key: "on", value: function (t, e) {
                                    var a = this;
                                    this._getElementByClass(this.data.classNames.smartPhoto).addEventListener(t, function (t) {
                                        e.call(a, t)
                                    })
                                }
                            }, {
                                key: "increment", value: function (t) {
                                    return t + 1
                                }
                            }, {
                                key: "round", value: function (t) {
                                    return Math.round(t)
                                }
                            }, {
                                key: "virtualPos", value: function (t) {
                                    return (t = parseInt(t, 10)) / this._getSelectedItem().scale / this.data.scaleSize
                                }
                            }, {
                                key: "groupItems", value: function () {
                                    return this.data.group[this.data.currentGroup]
                                }
                            }, {
                                key: "_resetTranslate", value: function () {
                                    var t = this;
                                    this.groupItems().forEach(function (e, a) {
                                        e.translateX = t._getWindowWidth() * a
                                    })
                                }
                            }, {
                                key: "addNewItem", value: function (t) {
                                    var e = this, a = t.getAttribute("data-group") || "nogroup", i = this.data.group;
                                    "nogroup" === a && t.setAttribute("data-group", "nogroup"), i[a] || (i[a] = []);
                                    var o = i[a].length, n = document.querySelector("body"), r = t.getAttribute("href"),
                                        s = t.querySelector("img"), l = r;
                                    s && (l = s.currentSrc ? s.currentSrc : s.src);
                                    var d = {
                                        src: r,
                                        thumb: l,
                                        caption: t.getAttribute("data-caption"),
                                        groupId: a,
                                        translateX: this._getWindowWidth() * o,
                                        index: o,
                                        translateY: 0,
                                        width: 50,
                                        height: 50,
                                        id: t.getAttribute("data-id") || o,
                                        loaded: !1,
                                        processed: !1,
                                        element: t
                                    };
                                    i[a].push(d), this.data.currentGroup = a, t.getAttribute("data-id") || t.setAttribute("data-id", o), t.setAttribute("data-index", o), jQuery(t).on("click.lightbox", function (a) {
                                        a.preventDefault(), e.data.currentGroup = t.getAttribute("data-group"), e.data.currentIndex = parseInt(t.getAttribute("data-index"), 10), e._setHashByCurrentIndex();
                                        var i = e._getSelectedItem();
                                        i.loaded ? (e._initPhoto(), e.addAppearEffect(t, i), e.clicked = !0, e.update(), n.style.overflow = "hidden", e._fireEvent("open")) : e._loadItem(i).then(function () {
                                            e._initPhoto(), e.addAppearEffect(t, i), e.clicked = !0, e.update(), n.style.overflow = "hidden", e._fireEvent("open")
                                        })
                                    })
                                }
                            }, {
                                key: "_initPhoto", value: function () {
                                    this.data.total = this.groupItems().length, this.data.hide = !1, this.data.photoPosX = 0, this.data.photoPosY = 0, this._setPosByCurrentIndex(), this._setSizeByScreen(), this.setArrow(), "fill" === this.data.resizeStyle && this.data.isSmartPhone && (this.data.scale = !0, this.data.hideUi = !0, this.data.scaleSize = this._getScaleBoarder())
                                }
                            }, {
                                key: "onUpdated", value: function () {
                                    var t = this;
                                    if (this.data.appearEffect && this.data.appearEffect.once && (this.data.appearEffect.once = !1, this.execEffect().then(function () {
                                        t.data.appearEffect = null, t.data.appear = !0, t.update()
                                    })), this.clicked) {
                                        this.clicked = !1;
                                        var e = this.data.classNames;
                                        this._getElementByClass(e.smartPhotoCaption).focus()
                                    }
                                }
                            }, {
                                key: "execEffect", value: function () {
                                    var t = this;
                                    return new p(function (e) {
                                        c.isOldIE() && e();
                                        var a = t.data, i = a.appearEffect, o = a.classNames,
                                            n = t._getElementByClass(o.smartPhotoImgClone), r = function t() {
                                                n.removeEventListener("transitionend", t, !0), e()
                                            };
                                        n.addEventListener("transitionend", r, !0), setTimeout(function () {
                                            n.style.transform = "translate(" + i.afterX + "px, " + i.afterY + "px) scale(" + i.scale + ")"
                                        }, 10)
                                    })
                                }
                            }, {
                                key: "addAppearEffect", value: function (t, e) {
                                    if (!1 === this.data.showAnimation) return void(this.data.appear = !0);
                                    var a = t.querySelector("img"), i = c.getViewPos(a), o = {}, n = 1;
                                    o.width = a.offsetWidth, o.height = a.offsetHeight, o.top = i.top, o.left = i.left, o.once = !0, o.img = e.src;
                                    var r = this._getWindowWidth(), s = this._getWindowHeight(),
                                        l = s - this.data.headerHeight - this.data.footerHeight;
                                    "fill" === this.data.resizeStyle && this.data.isSmartPhone ? n = a.offsetWidth > a.offsetHeight ? s / a.offsetHeight : r / a.offsetWidth : (o.width >= o.height ? n = e.height < l ? e.width / o.width : l / o.height : o.height > o.width && (n = e.height < l ? e.height / o.height : l / o.height), o.width * n > r && (n = r / o.width));
                                    var d = (n - 1) / 2 * a.offsetWidth + (r - a.offsetWidth * n) / 2,
                                        p = (n - 1) / 2 * a.offsetHeight + (s - a.offsetHeight * n) / 2;
                                    o.afterX = d, o.afterY = p, o.scale = n, this.data.appearEffect = o
                                }
                            }, {
                                key: "hidePhoto", value: function () {
                                    var t = this,
                                        e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "bottom";
                                    this.data.hide = !0, this.data.appear = !1, this.data.appearEffect = null, this.data.hideUi = !1, this.data.scale = !1, this.data.scaleSize = 1;
                                    var a = void 0 !== window.pageXOffset ? window.pageXOffset : (document.documentElement || document.body.parentNode || document.body).scrollLeft,
                                        i = void 0 !== window.pageYOffset ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop,
                                        o = document.querySelector("body");
                                    window.location.hash && this._setHash(""), window.scroll(a, i), this._doHideEffect(e).then(function () {
                                        t.update(), o.style.overflow = "", t._fireEvent("close")
                                    })
                                }
                            }, {
                                key: "_doHideEffect", value: function (t) {
                                    var e = this;
                                    return new p(function (a) {
                                        c.isOldIE() && a();
                                        var i = e.data.classNames, o = e._getElementByClass(i.smartPhoto),
                                            n = e._getElementByQuery(".current ." + i.smartPhotoImg),
                                            r = e._getWindowHeight(), s = function t() {
                                                o.removeEventListener("transitionend", t, !0), a()
                                            };
                                        o.style.opacity = 0, "bottom" === t ? n.style.transform = "translateY(" + r + "px)" : "top" === t && (n.style.transform = "translateY(-" + r + "px)"), o.addEventListener("transitionend", s, !0)
                                    })
                                }
                            }, {
                                key: "_getElementByClass", value: function (t) {
                                    return document.querySelector('[data-id="' + this.id + '"] .' + t)
                                }
                            }, {
                                key: "_getElementByQuery", value: function (t) {
                                    return document.querySelector('[data-id="' + this.id + '"] ' + t)
                                }
                            }, {
                                key: "_getTouchPos", value: function () {
                                    var t = 0, e = 0, a = "undefined" == typeof event ? this.e : event;
                                    return this._isTouched(a) ? (t = a.touches[0].pageX, e = a.touches[0].pageY) : a.pageX && (t = a.pageX, e = a.pageY), {
                                        x: t,
                                        y: e
                                    }
                                }
                            }, {
                                key: "_getGesturePos", value: function (t) {
                                    var e = t.touches;
                                    return [{x: e[0].pageX, y: e[0].pageY}, {x: e[1].pageX, y: e[1].pageY}]
                                }
                            }, {
                                key: "_setPosByCurrentIndex", value: function () {
                                    var t = this, e = this.groupItems(), a = -1 * e[this.data.currentIndex].translateX;
                                    this.pos.x = a, setTimeout(function () {
                                        t.data.translateX = a, t.data.translateY = 0, t._listUpdate()
                                    }, 1)
                                }
                            }, {
                                key: "_setHashByCurrentIndex", value: function () {
                                    var t = void 0 !== window.pageXOffset ? window.pageXOffset : (document.documentElement || document.body.parentNode || document.body).scrollLeft,
                                        e = void 0 !== window.pageYOffset ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop,
                                        a = this.groupItems(), i = a[this.data.currentIndex].id, o = this.data.currentGroup,
                                        n = "group=" + o + "&photo=" + i;
                                    this._setHash(n), window.scroll(t, e)
                                }
                            }, {
                                key: "_setHash", value: function (t) {
                                    window.history && window.history.pushState && this.data.useHistoryApi && (t ? window.history.replaceState(null, null, "" + location.pathname + location.search + "#" + t) : window.history.replaceState(null, null, "" + location.pathname + location.search))
                                }
                            }, {
                                key: "_getCurrentItemByHash", value: function () {
                                    var t = this.data.group, e = location.hash.substr(1), a = c.parseQuery(e), i = null,
                                        o = function (t) {
                                            a.group === t.groupId && a.photo === t.id && (i = t)
                                        };
                                    return Object.keys(t).forEach(function (e) {
                                        t[e].forEach(o)
                                    }), i
                                }
                            }, {
                                key: "_loadItem", value: function (t) {
                                    return new p(function (e) {
                                        var a = new Image;
                                        a.onload = function () {
                                            t.width = a.width, t.height = a.height, t.loaded = !0, e()
                                        }, a.onerror = function () {
                                            e()
                                        }, a.src = t.src
                                    })
                                }
                            }, {
                                key: "_getItemByIndex", value: function (t) {
                                    var e = this.data;
                                    return e.group[e.currentGroup][t] ? e.group[e.currentGroup][t] : null
                                }
                            }, {
                                key: "_loadNeighborItems", value: function () {
                                    for (var t = this, e = this.data.currentIndex, a = this.data.loadOffset, i = e - a, o = e + a, n = [], r = i; r < o; r++) {
                                        var s = this._getItemByIndex(r);
                                        s && !s.loaded && n.push(this._loadItem(s))
                                    }
                                    n.length && p.all(n).then(function () {
                                        t._initPhoto(), t.update()
                                    })
                                }
                            }, {
                                key: "_setSizeByScreen", value: function () {
                                    var t = this._getWindowWidth(), e = this._getWindowHeight(), a = this.data.headerHeight,
                                        i = this.data.footerHeight, o = e - (a + i);
                                    this.groupItems().forEach(function (a) {
                                        a.loaded && (a.processed = !0, a.scale = o / a.height, a.height < o && (a.scale = 1), a.x = (a.scale - 1) / 2 * a.width + (t - a.width * a.scale) / 2, a.y = (a.scale - 1) / 2 * a.height + (e - a.height * a.scale) / 2, a.width * a.scale > t && (a.scale = t / a.width, a.x = (a.scale - 1) / 2 * a.width))
                                    })
                                }
                            }, {
                                key: "_slideList", value: function () {
                                    var t = this;
                                    this.data.scaleSize = 1, this.isBeingZoomed = !1, this.data.hideUi = !1, this.data.scale = !1, this.data.photoPosX = 0, this.data.photoPosY = 0, this.data.onMoveClass = !0, this._setPosByCurrentIndex(), this._setHashByCurrentIndex(), this._setSizeByScreen(), setTimeout(function () {
                                        var e = t._getSelectedItem();
                                        t.data.onMoveClass = !1, t.setArrow(), t.update(), t.data.oldIndex !== t.data.currentIndex && t._fireEvent("change"), t.data.oldIndex = t.data.currentIndex, t._loadNeighborItems(), e.loaded || t._loadItem(e).then(function () {
                                            t._initPhoto(), t.update()
                                        })
                                    }, 200)
                                }
                            }, {
                                key: "gotoSlide", value: function (t) {
                                    this.e && this.e.preventDefault && this.e.preventDefault(), this.data.currentIndex = parseInt(t, 10), this.data.currentIndex || (this.data.currentIndex = 0), this._slideList()
                                }
                            }, {
                                key: "setArrow", value: function () {
                                    var t = this.groupItems(), e = t.length, a = this.data.currentIndex + 1,
                                        i = this.data.currentIndex - 1;
                                    this.data.showNextArrow = !1, this.data.showPrevArrow = !1, a !== e && (this.data.next = a, this.data.showNextArrow = !0), -1 !== i && (this.data.prev = i, this.data.showPrevArrow = !0)
                                }
                            }, {
                                key: "beforeDrag", value: function () {
                                    if (this._isGestured(this.e)) return void this.beforeGesture();
                                    if (this.isBeingZoomed = !1, this.data.scale) return void this.beforePhotoDrag();
                                    var t = this._getTouchPos();
                                    this.isSwipable = !0, this.dragStart = !0, this.firstPos = t, this.oldPos = t
                                }
                            }, {
                                key: "afterDrag", value: function () {
                                    var t = this.groupItems(), e = new Date, a = e.getTime(), i = this.tapSecond - a, o = 0,
                                        n = 0;
                                    return this.isSwipable = !1, this.onListMove = !1, this.oldPos && (o = this.oldPos.x - this.firstPos.x, n = this.oldPos.y - this.firstPos.y), this.isBeingZoomed ? void this.afterGesture() : this.data.scale ? void this.afterPhotoDrag() : c.isSmartPhone() || 0 !== o || 0 !== n ? Math.abs(i) <= 500 && 0 === o && 0 === n ? (this.e.preventDefault(), void this.zoomPhoto()) : (this.tapSecond = a, this._fireEvent("swipeend"), "horizontal" === this.moveDir && (o >= this.data.swipeOffset && 0 !== this.data.currentIndex ? this.data.currentIndex -= 1 : o <= -this.data.swipeOffset && this.data.currentIndex !== t.length - 1 && (this.data.currentIndex += 1), this._slideList()), void("vertical" === this.moveDir && (this.data.swipeBottomToClose && n >= this.data.swipeOffset ? this.hidePhoto("bottom") : this.data.swipeTopToClose && n <= -this.data.swipeOffset ? this.hidePhoto("top") : (this.data.translateY = 0, this._slideList())))) : void this.zoomPhoto()
                                }
                            }, {
                                key: "onDrag", value: function () {
                                    if (this.e.preventDefault(), this._isGestured(this.e) && !1 === this.onListMove) return void this.onGesture();
                                    if (!this.isBeingZoomed) {
                                        if (this.data.scale) return void this.onPhotoDrag();
                                        if (this.isSwipable) {
                                            var t = this._getTouchPos(), e = t.x - this.oldPos.x, a = t.y - this.firstPos.y;
                                            this.dragStart && (this._fireEvent("swipestart"), this.dragStart = !1, Math.abs(e) > Math.abs(a) ? this.moveDir = "horizontal" : this.moveDir = "vertical"), "horizontal" === this.moveDir ? (this.pos.x += e, this.data.translateX = this.pos.x) : this.data.translateY = a, this.onListMove = !0, this.oldPos = t, this._listUpdate()
                                        }
                                    }
                                }
                            }, {
                                key: "zoomPhoto", value: function () {
                                    var t = this;
                                    this.data.hideUi = !0, this.data.scaleSize = this._getScaleBoarder(), this.data.scaleSize <= 1 || (this.data.photoPosX = 0, this.data.photoPosY = 0, this._photoUpdate(), setTimeout(function () {
                                        t.data.scale = !0, t._photoUpdate(), t._fireEvent("zoomin")
                                    }, 300))
                                }
                            }, {
                                key: "zoomOutPhoto", value: function () {
                                    this.data.scaleSize = 1, this.isBeingZoomed = !1, this.data.hideUi = !1, this.data.scale = !1, this.data.photoPosX = 0, this.data.photoPosY = 0, this._photoUpdate(), this._fireEvent("zoomout")
                                }
                            }, {
                                key: "beforePhotoDrag", value: function () {
                                    var t = this._getTouchPos();
                                    this.photoSwipable = !0, this.data.photoPosX || (this.data.photoPosX = 0), this.data.photoPosY || (this.data.photoPosY = 0), this.oldPhotoPos = t, this.firstPhotoPos = t
                                }
                            }, {
                                key: "onPhotoDrag", value: function () {
                                    if (this.photoSwipable) {
                                        this.e.preventDefault();
                                        var t = this._getTouchPos(), e = t.x - this.oldPhotoPos.x,
                                            a = t.y - this.oldPhotoPos.y, i = this._round(this.data.scaleSize * e, 6),
                                            o = this._round(this.data.scaleSize * a, 6);
                                        "number" == typeof i && (this.data.photoPosX += i, this.photoVX = i), "number" == typeof o && (this.data.photoPosY += o, this.photoVY = o), this.oldPhotoPos = t, this._photoUpdate()
                                    }
                                }
                            }, {
                                key: "afterPhotoDrag", value: function () {
                                    if (this.oldPhotoPos.x === this.firstPhotoPos.x && this.photoSwipable) this.photoSwipable = !1, this.zoomOutPhoto(); else {
                                        this.photoSwipable = !1;
                                        var t = this._getSelectedItem(), e = this._makeBound(t),
                                            a = this.data.swipeOffset * this.data.scaleSize, i = 0, o = 0;
                                        if (this.data.photoPosX > e.maxX ? i = -1 : this.data.photoPosX < e.minX && (i = 1), this.data.photoPosY > e.maxY ? o = -1 : this.data.photoPosY < e.minY && (o = 1), this.data.photoPosX - e.maxX > a && 0 !== this.data.currentIndex) return void this.gotoSlide(this.data.prev);
                                        if (e.minX - this.data.photoPosX > a && this.data.currentIndex + 1 !== this.data.total) return void this.gotoSlide(this.data.next);
                                        0 === i && 0 === o ? (this.vx = this.photoVX / 5, this.vy = this.photoVY / 5) : this._registerElasticForce(i, o)
                                    }
                                }
                            }, {
                                key: "beforeGesture", value: function () {
                                    this._fireEvent("gesturestart");
                                    var t = this._getGesturePos(this.e), e = this._getDistance(t[0], t[1]);
                                    this.isBeingZoomed = !0, this.oldDistance = e, this.data.scale = !0, this.e.preventDefault()
                                }
                            }, {
                                key: "onGesture", value: function () {
                                    var t = this._getGesturePos(this.e), e = this._getDistance(t[0], t[1]),
                                        a = (e - this.oldDistance) / 100, i = this.data.scaleSize, o = this.data.photoPosX,
                                        n = this.data.photoPosY;
                                    this.isBeingZoomed = !0, this.data.scaleSize += this._round(a, 6), this.data.scaleSize < .2 && (this.data.scaleSize = .2), this.data.scaleSize < i && (this.data.photoPosX = (1 + this.data.scaleSize - i) * o, this.data.photoPosY = (1 + this.data.scaleSize - i) * n), this.data.scaleSize < 1 || this.data.scaleSize > this._getScaleBoarder() ? this.data.hideUi = !0 : this.data.hideUi = !1, this.oldDistance = e, this.e.preventDefault(), this._photoUpdate()
                                }
                            }, {
                                key: "afterGesture", value: function () {
                                    this.data.scaleSize > this._getScaleBoarder() || (this.data.photoPosX = 0, this.data.photoPosY = 0, this.data.scale = !1, this.data.scaleSize = 1, this.data.hideUi = !1, this._fireEvent("gestureend"), this._photoUpdate())
                                }
                            }, {
                                key: "_getForceAndTheta", value: function (t, e) {
                                    return {force: Math.sqrt(t * t + e * e), theta: Math.atan2(e, t)}
                                }
                            }, {
                                key: "_getScaleBoarder", value: function () {
                                    var t = this._getSelectedItem(), e = this._getWindowWidth(),
                                        a = this._getWindowHeight();
                                    return c.isSmartPhone() ? t.width > t.height ? a / (t.height * t.scale) : e / (t.width * t.scale) : 1 / t.scale
                                }
                            }, {
                                key: "_makeBound", value: function (t) {
                                    var e = t.width * t.scale * this.data.scaleSize,
                                        a = t.height * t.scale * this.data.scaleSize, i = void 0, o = void 0, n = void 0,
                                        r = void 0, s = this._getWindowWidth(), l = this._getWindowHeight();
                                    return s > e ? (n = (s - e) / 2, i = -1 * n) : (n = (e - s) / 2, i = -1 * n), l > a ? (r = (l - a) / 2, o = -1 * r) : (r = (a - l) / 2, o = -1 * r), {
                                        minX: this._round(i, 6) * this.data.scaleSize,
                                        minY: this._round(o, 6) * this.data.scaleSize,
                                        maxX: this._round(n, 6) * this.data.scaleSize,
                                        maxY: this._round(r, 6) * this.data.scaleSize
                                    }
                                }
                            }, {
                                key: "_registerElasticForce", value: function (t, e) {
                                    var a = this, i = this._getSelectedItem(), o = this._makeBound(i);
                                    this.data.elastic = !0, 1 === t ? this.data.photoPosX = o.minX : -1 === t && (this.data.photoPosX = o.maxX), 1 === e ? this.data.photoPosY = o.minY : -1 === e && (this.data.photoPosY = o.maxY), this._photoUpdate(), setTimeout(function () {
                                        a.data.elastic = !1, a._photoUpdate()
                                    }, 300)
                                }
                            }, {
                                key: "_getSelectedItem", value: function () {
                                    var t = this.data, e = t.currentIndex;
                                    return t.group[t.currentGroup][e]
                                }
                            }, {
                                key: "_getUniqId", value: function () {
                                    return (Date.now().toString(36) + Math.random().toString(36).substr(2, 5)).toUpperCase()
                                }
                            }, {
                                key: "_getDistance", value: function (t, e) {
                                    var a = t.x - e.x, i = t.y - e.y;
                                    return Math.sqrt(a * a + i * i)
                                }
                            }, {
                                key: "_round", value: function (t, e) {
                                    var a = Math.pow(10, e);
                                    return t *= a, t = Math.round(t), t /= a
                                }
                            }, {
                                key: "_isTouched", value: function (t) {
                                    return !(!t || !t.touches)
                                }
                            }, {
                                key: "_isGestured", value: function (t) {
                                    return !!(t && t.touches && t.touches.length > 1)
                                }
                            }, {
                                key: "_isSmartPhone", value: function () {
                                    var t = navigator.userAgent;
                                    return t.indexOf("iPhone") > 0 || t.indexOf("iPad") > 0 || t.indexOf("ipod") > 0 || t.indexOf("Android") > 0
                                }
                            }, {
                                key: "_calcGravity", value: function (t, e) {
                                    (t > 5 || t < -5) && (this.vx += .05 * t), !1 !== this.data.verticalGravity && (e > 5 || e < -5) && (this.vy += .05 * e)
                                }
                            }, {
                                key: "_photoUpdate", value: function () {
                                    var t = this.data.classNames, e = this._getElementByQuery(".current"),
                                        a = e.querySelector("." + t.smartPhotoImg),
                                        i = this._getElementByQuery("." + t.smartPhotoNav),
                                        o = this._getElementByQuery("." + t.smartPhotoArrows),
                                        n = this.virtualPos(this.data.photoPosX), r = this.virtualPos(this.data.photoPosY),
                                        s = this.data.scaleSize, l = "translate(" + n + "px," + r + "px) scale(" + s + ")";
                                    a.style.transform = l, this.data.scale ? c.addClass(a, t.smartPhotoImgOnMove) : c.removeClass(a, t.smartPhotoImgOnMove), this.data.elastic ? c.addClass(a, t.smartPhotoImgElasticMove) : c.removeClass(a, t.smartPhotoImgElasticMove), this.data.hideUi ? (i && i.setAttribute("aria-hidden", "true"), o && o.setAttribute("aria-hidden", "true")) : (i && i.setAttribute("aria-hidden", "false"), o && o.setAttribute("aria-hidden", "false"))
                                }
                            }, {
                                key: "_getWindowWidth", value: function () {
                                    return document && document.documentElement ? document.documentElement.clientWidth : window && window.innerWidth ? window.innerWidth : 0
                                }
                            }, {
                                key: "_getWindowHeight", value: function () {
                                    return document && document.documentElement ? document.documentElement.clientHeight : window && window.innerHeight ? window.innerHeight : 0
                                }
                            }, {
                                key: "_listUpdate", value: function () {
                                    var t = this.data.classNames, e = this._getElementByQuery("." + t.smartPhotoList),
                                        a = "translate(" + this.data.translateX + "px," + this.data.translateY + "px)";
                                    e.style.transform = a, this.data.onMoveClass ? c.addClass(e, t.smartPhotoListOnMove) : c.removeClass(e, t.smartPhotoListOnMove)
                                }
                            }, {
                                key: "_fireEvent", value: function (t) {
                                    var e = this._getElementByClass(this.data.classNames.smartPhoto);
                                    c.triggerEvent(e, t)
                                }
                            }, {
                                key: "_doAnim", value: function () {
                                    if (!(this.isBeingZoomed || this.isSwipable || this.photoSwipable || this.data.elastic) && this.data.scale) {
                                        this.data.photoPosX += this.vx, this.data.photoPosY += this.vy;
                                        var t = this._getSelectedItem(), e = this._makeBound(t);
                                        this.data.photoPosX < e.minX ? (this.data.photoPosX = e.minX, this.vx *= -.2) : this.data.photoPosX > e.maxX && (this.data.photoPosX = e.maxX, this.vx *= -.2), this.data.photoPosY < e.minY ? (this.data.photoPosY = e.minY, this.vy *= -.2) : this.data.photoPosY > e.maxY && (this.data.photoPosY = e.maxY, this.vy *= -.2);
                                        var a = this._getForceAndTheta(this.vx, this.vy), i = a.force, o = a.theta;
                                        i -= this.data.registance, Math.abs(i) < .5 || (this.vx = Math.cos(o) * i, this.vy = Math.sin(o) * i, this._photoUpdate())
                                    }
                                }
                            }]), e
                        }(l.default);
                    a.default = h, e.exports = a.default
                }, {"../lib/util": 12, "a-template": 1, "custom-event-polyfill": 3, "es6-promise-polyfill": 4}],
                11: [function (t, e, a) {
                    "use strict";
                    e.exports = t("./core/")
                }, {"./core/": 10}],
                12: [function (t, e, a) {
                    "use strict";

                    function i(t) {
                        t = t || {};
                        for (var e = 1; e < arguments.length; e++) {
                            var a = arguments[e];
                            if (a) for (var n in a) a.hasOwnProperty(n) && ("object" === o(a[n]) ? t[n] = i(t[n], a[n]) : t[n] = a[n])
                        }
                        return t
                    }

                    Object.defineProperty(a, "__esModule", {value: !0});
                    var o = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
                        return typeof t
                    } : function (t) {
                        return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
                    }, n = (a.isSmartPhone = function () {
                        var t = navigator.userAgent;
                        return t.indexOf("iPhone") > 0 || t.indexOf("iPad") > 0 || t.indexOf("ipod") > 0 || t.indexOf("Android") > 0
                    }, a.extend = i, a.triggerEvent = function (t, e, a) {
                        var i = void 0;
                        window.CustomEvent ? i = new CustomEvent(e, {cancelable: !0}) : (i = document.createEvent("CustomEvent"), i.initCustomEvent(e, !1, !1, a)), t.dispatchEvent(i)
                    }, a.parseQuery = function (t) {
                        for (var e, a, i, o = t.split("&"), n = {}, r = 0, s = o.length; r < s; r++) e = o[r].split("="), void 0 !== e[0] && (a = e[0], i = void 0 !== e[1] ? e.slice(1).join("=") : a, n[a] = decodeURIComponent(i));
                        return n
                    }, a.getViewPos = function (t) {
                        return {left: t.getBoundingClientRect().left, top: t.getBoundingClientRect().top}
                    }, a.removeElement = function (t) {
                        t && t.parentNode && t.parentNode.removeChild(t)
                    }, a.append = function (t, e) {
                        var a = document.createElement("div");
                        for (a.innerHTML = e; a.children.length > 0;) t.appendChild(a.children[0])
                    }, a.addClass = function (t, e) {
                        t.classList ? t.classList.add(e) : t.className += " " + e
                    }, a.removeClass = function (t, e) {
                        t.classList ? t.classList.remove(e) : t.className = t.className.replace(new RegExp("(^|\\b)" + e.split(" ").join("|") + "(\\b|$)", "gi"), " ")
                    }, a.getBrowser = function () {
                        var t = window.navigator.userAgent.toLowerCase(), e = window.navigator.appVersion.toLowerCase(),
                            a = "unknown";
                        return -1 != t.indexOf("msie") ? a = -1 != e.indexOf("msie 6.") ? "ie6" : -1 != e.indexOf("msie 7.") ? "ie7" : -1 != e.indexOf("msie 8.") ? "ie8" : -1 != e.indexOf("msie 9.") ? "ie9" : -1 != e.indexOf("msie 10.") ? "ie10" : "ie" : -1 != t.indexOf("trident/7") ? a = "ie11" : -1 != t.indexOf("chrome") ? a = "chrome" : -1 != t.indexOf("safari") ? a = "safari" : -1 != t.indexOf("opera") ? a = "opera" : -1 != t.indexOf("firefox") && (a = "firefox"), a
                    });
                    a.isOldIE = function () {
                        var t = n();
                        return -1 !== t.indexOf("ie") && parseInt(t.replace(/[^0-9]/g, "")) <= 10
                    }
                }, {}]
            }, {}, [9])
        }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
    }, {}],
    4: [function (t, e, a) {/*!
 * Lazy Load - jQuery plugin for lazy loading images
 *
 * Copyright (c) 2007-2015 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/lazyload
 *
 * Version:  1.9.7
 *
 */
        !function (t, e, a, i) {
            var o = t(e), n = function () {
                try {
                    return 0 === a.createElement("canvas").toDataURL("image/webp").indexOf("data:image/webp")
                } catch (t) {
                    return !1
                }
            }();
            t.fn.lazyload = function (i) {
                function r() {
                    var e = 0;
                    d.each(function () {
                        var a = t(this);
                        if (!c.skip_invisible || a.is(":visible")) if (t.abovethetop(this, c) || t.leftofbegin(this, c)) ; else if (t.belowthefold(this, c) || t.rightoffold(this, c)) {
                            if (++e > c.failure_limit) return !1
                        } else a.trigger("appear"), e = 0
                    })
                }

                function s(t) {
                    return t && t.split("?").length > 1 ? t.match(/([&?]+)x-oss-process=/i) ? t = t.replace(/([&?]+)x-oss-process=/i, "$1x-oss-process=image/format,webp,") : t.match(/([&?]+)imageMogr2/i) ? t = t.replace(/([&?]+)imageMogr2\//i, "$1imageMogr2/format/webp/") : t += c.webp.replace("?", "&") : t && (t += c.webp), t
                }

                var l, d = this, c = {
                    threshold: 0,
                    failure_limit: 500,
                    event: "scroll",
                    effect: "show",
                    container: e,
                    data_attribute: "original",
                    skip_invisible: !1,
                    appear: null,
                    load: null,
                    webp: null,
                    placeholder: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                };
                /*!
 * Lazy Load - jQuery plugin for lazy loading images
 *
 * Copyright (c) 2007-2015 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/lazyload
 *
 * Version:  1.9.7
 *
 */
                return i && (void 0 !== i.failurelimit && (i.failure_limit = i.failurelimit, delete i.failurelimit), void 0 !== i.effectspeed && (i.effect_speed = i.effectspeed, delete i.effectspeed), t.extend(c, i)), l = void 0 === c.container || c.container === e ? o : t(c.container), 0 === c.event.indexOf("scroll") && l.on(c.event, function () {
                    return r()
                }), this.each(function () {
                    var e = this, a = t(e);
                    e.loaded = !1, void 0 !== a.attr("src") && !1 !== a.attr("src") || a.is("img") && a.attr("src", c.placeholder), a.one("appear", function () {
                        if (!this.loaded) {
                            if (c.appear) {
                                var i = d.length;
                                c.appear.call(e, i, c)
                            }
                            var o = a.attr("data-" + c.data_attribute);
                            o && n && c.webp && (o = s(o));
                            var r = a.attr("data-srcset"), l = a.css("display");
                            o && t("<img />").one("load", function () {
                                a.hide(), a.is("img") ? (r && a.attr("srcset", r), a.attr("src", o), a.hasClass("fluidbox__thumb") && setTimeout(function () {
                                    a.closest("a.fluidbox").fluidbox("reposition")
                                }, 200)) : a.css("background-image", "url('" + o + "')"), a[c.effect](c.effect_speed).css("display", l), e.loaded = !0;
                                var i = t.grep(d, function (t) {
                                    return !t.loaded
                                });
                                if (d = t(i), c.load) {
                                    var n = d.length;
                                    c.load.call(e, n, c)
                                }
                                a.trigger("DOMSubtreeModified")
                            }).attr("src", o)
                        }
                    }), 0 !== c.event.indexOf("scroll") && a.on(c.event, function () {
                        e.loaded || a.trigger("appear")
                    })
                }), o.on("resize", function () {
                    r()
                }), /(?:iphone|ipod|ipad).*os 5/gi.test(navigator.appVersion) && o.on("pageshow", function (e) {
                    e.originalEvent && e.originalEvent.persisted && d.each(function () {
                        t(this).trigger("appear")
                    })
                }), t(a).ready(function () {
                    r()
                }), this
            }, t.belowthefold = function (a, i) {
                return (void 0 === i.container || i.container === e ? (e.innerHeight ? e.innerHeight : o.height()) + o.scrollTop() : t(i.container).offset().top + t(i.container).height()) <= t(a).offset().top - i.threshold
            }, t.rightoffold = function (a, i) {
                return (void 0 === i.container || i.container === e ? o.width() + o.scrollLeft() : t(i.container).offset().left + t(i.container).width()) <= t(a).offset().left - i.threshold
            }, t.abovethetop = function (a, i) {
                return (void 0 === i.container || i.container === e ? o.scrollTop() : t(i.container).offset().top) >= t(a).offset().top + i.threshold + t(a).height()
            }, t.leftofbegin = function (a, i) {
                return (void 0 === i.container || i.container === e ? o.scrollLeft() : t(i.container).offset().left) >= t(a).offset().left + i.threshold + t(a).width()
            }, t.inviewport = function (e, a) {
                return !(t.rightoffold(e, a) || t.leftofbegin(e, a) || t.belowthefold(e, a) || t.abovethetop(e, a))
            }, t.extend(t.expr[":"], {
                "below-the-fold": function (e) {
                    return t.belowthefold(e, {threshold: 0})
                }, "above-the-top": function (e) {
                    return !t.belowthefold(e, {threshold: 0})
                }, "right-of-screen": function (e) {
                    return t.rightoffold(e, {threshold: 0})
                }, "left-of-screen": function (e) {
                    return !t.rightoffold(e, {threshold: 0})
                }, "in-viewport": function (e) {
                    return t.inviewport(e, {threshold: 0})
                }, "above-the-fold": function (e) {
                    return !t.belowthefold(e, {threshold: 0})
                }, "right-of-fold": function (e) {
                    return t.rightoffold(e, {threshold: 0})
                }, "left-of-fold": function (e) {
                    return !t.rightoffold(e, {threshold: 0})
                }
            })
        }(jQuery, window, document)
    }, {}],
    5: [function (t, e, a) {
        !function (t) {
            t.fn.qrcode = function (e) {
                function a(t) {
                    this.mode = s, this.data = t
                }

                function i(t, e) {
                    this.typeNumber = t, this.errorCorrectLevel = e, this.modules = null, this.moduleCount = 0, this.dataCache = null, this.dataList = []
                }

                function o(t, e) {
                    if (void 0 == t.length) throw Error(t.length + "/" + e);
                    for (var a = 0; a < t.length && 0 == t[a];) a++;
                    this.num = Array(t.length - a + e);
                    for (var i = 0; i < t.length - a; i++) this.num[i] = t[i + a]
                }

                function n(t, e) {
                    this.totalCount = t, this.dataCount = e
                }

                function r() {
                    this.buffer = [], this.length = 0
                }

                var s;
                a.prototype = {
                    getLength: function () {
                        return this.data.length
                    }, write: function (t) {
                        for (var e = 0; e < this.data.length; e++) t.put(this.data.charCodeAt(e), 8)
                    }
                }, i.prototype = {
                    addData: function (t) {
                        this.dataList.push(new a(t)), this.dataCache = null
                    }, isDark: function (t, e) {
                        if (0 > t || this.moduleCount <= t || 0 > e || this.moduleCount <= e) throw Error(t + "," + e);
                        return this.modules[t][e]
                    }, getModuleCount: function () {
                        return this.moduleCount
                    }, make: function () {
                        if (1 > this.typeNumber) {
                            for (var t = 1, t = 1; 40 > t; t++) {
                                for (var e = n.getRSBlocks(t, this.errorCorrectLevel), a = new r, i = 0, o = 0; o < e.length; o++) i += e[o].dataCount;
                                for (o = 0; o < this.dataList.length; o++) e = this.dataList[o], a.put(e.mode, 4), a.put(e.getLength(), l.getLengthInBits(e.mode, t)), e.write(a);
                                if (a.getLengthInBits() <= 8 * i) break
                            }
                            this.typeNumber = t
                        }
                        this.makeImpl(!1, this.getBestMaskPattern())
                    }, makeImpl: function (t, e) {
                        this.moduleCount = 4 * this.typeNumber + 17, this.modules = Array(this.moduleCount);
                        for (var a = 0; a < this.moduleCount; a++) {
                            this.modules[a] = Array(this.moduleCount);
                            for (var o = 0; o < this.moduleCount; o++) this.modules[a][o] = null
                        }
                        this.setupPositionProbePattern(0, 0), this.setupPositionProbePattern(this.moduleCount - 7, 0), this.setupPositionProbePattern(0, this.moduleCount - 7), this.setupPositionAdjustPattern(), this.setupTimingPattern(), this.setupTypeInfo(t, e), 7 <= this.typeNumber && this.setupTypeNumber(t), null == this.dataCache && (this.dataCache = i.createData(this.typeNumber, this.errorCorrectLevel, this.dataList)), this.mapData(this.dataCache, e)
                    }, setupPositionProbePattern: function (t, e) {
                        for (var a = -1; 7 >= a; a++) if (!(-1 >= t + a || this.moduleCount <= t + a)) for (var i = -1; 7 >= i; i++) -1 >= e + i || this.moduleCount <= e + i || (this.modules[t + a][e + i] = 0 <= a && 6 >= a && (0 == i || 6 == i) || 0 <= i && 6 >= i && (0 == a || 6 == a) || 2 <= a && 4 >= a && 2 <= i && 4 >= i)
                    }, getBestMaskPattern: function () {
                        for (var t = 0, e = 0, a = 0; 8 > a; a++) {
                            this.makeImpl(!0, a);
                            var i = l.getLostPoint(this);
                            (0 == a || t > i) && (t = i, e = a)
                        }
                        return e
                    }, createMovieClip: function (t, e, a) {
                        for (t = t.createEmptyMovieClip(e, a), this.make(), e = 0; e < this.modules.length; e++) for (var a = 1 * e, i = 0; i < this.modules[e].length; i++) {
                            var o = 1 * i;
                            this.modules[e][i] && (t.beginFill(0, 100), t.moveTo(o, a), t.lineTo(o + 1, a), t.lineTo(o + 1, a + 1), t.lineTo(o, a + 1), t.endFill())
                        }
                        return t
                    }, setupTimingPattern: function () {
                        for (var t = 8; t < this.moduleCount - 8; t++) null == this.modules[t][6] && (this.modules[t][6] = 0 == t % 2);
                        for (t = 8; t < this.moduleCount - 8; t++) null == this.modules[6][t] && (this.modules[6][t] = 0 == t % 2)
                    }, setupPositionAdjustPattern: function () {
                        for (var t = l.getPatternPosition(this.typeNumber), e = 0; e < t.length; e++) for (var a = 0; a < t.length; a++) {
                            var i = t[e], o = t[a];
                            if (null == this.modules[i][o]) for (var n = -2; 2 >= n; n++) for (var r = -2; 2 >= r; r++) this.modules[i + n][o + r] = -2 == n || 2 == n || -2 == r || 2 == r || 0 == n && 0 == r
                        }
                    }, setupTypeNumber: function (t) {
                        for (var e = l.getBCHTypeNumber(this.typeNumber), a = 0; 18 > a; a++) {
                            var i = !t && 1 == (e >> a & 1);
                            this.modules[Math.floor(a / 3)][a % 3 + this.moduleCount - 8 - 3] = i
                        }
                        for (a = 0; 18 > a; a++) i = !t && 1 == (e >> a & 1), this.modules[a % 3 + this.moduleCount - 8 - 3][Math.floor(a / 3)] = i
                    }, setupTypeInfo: function (t, e) {
                        for (var a = l.getBCHTypeInfo(this.errorCorrectLevel << 3 | e), i = 0; 15 > i; i++) {
                            var o = !t && 1 == (a >> i & 1);
                            6 > i ? this.modules[i][8] = o : 8 > i ? this.modules[i + 1][8] = o : this.modules[this.moduleCount - 15 + i][8] = o
                        }
                        for (i = 0; 15 > i; i++) o = !t && 1 == (a >> i & 1), 8 > i ? this.modules[8][this.moduleCount - i - 1] = o : 9 > i ? this.modules[8][15 - i - 1 + 1] = o : this.modules[8][15 - i - 1] = o;
                        this.modules[this.moduleCount - 8][8] = !t
                    }, mapData: function (t, e) {
                        for (var a = -1, i = this.moduleCount - 1, o = 7, n = 0, r = this.moduleCount - 1; 0 < r; r -= 2) for (6 == r && r--; ;) {
                            for (var s = 0; 2 > s; s++) if (null == this.modules[i][r - s]) {
                                var d = !1;
                                n < t.length && (d = 1 == (t[n] >>> o & 1)), l.getMask(e, i, r - s) && (d = !d), this.modules[i][r - s] = d, o--, -1 == o && (n++, o = 7)
                            }
                            if (0 > (i += a) || this.moduleCount <= i) {
                                i -= a, a = -a;
                                break
                            }
                        }
                    }
                }, i.PAD0 = 236, i.PAD1 = 17, i.createData = function (t, e, a) {
                    for (var e = n.getRSBlocks(t, e), o = new r, s = 0; s < a.length; s++) {
                        var d = a[s];
                        o.put(d.mode, 4), o.put(d.getLength(), l.getLengthInBits(d.mode, t)), d.write(o)
                    }
                    for (s = t = 0; s < e.length; s++) t += e[s].dataCount;
                    if (o.getLengthInBits() > 8 * t) throw Error("code length overflow. (" + o.getLengthInBits() + ">" + 8 * t + ")");
                    for (o.getLengthInBits() + 4 <= 8 * t && o.put(0, 4); 0 != o.getLengthInBits() % 8;) o.putBit(!1);
                    for (; !(o.getLengthInBits() >= 8 * t) && (o.put(i.PAD0, 8), !(o.getLengthInBits() >= 8 * t));) o.put(i.PAD1, 8);
                    return i.createBytes(o, e)
                }, i.createBytes = function (t, e) {
                    for (var a = 0, i = 0, n = 0, r = Array(e.length), s = Array(e.length), d = 0; d < e.length; d++) {
                        var c = e[d].dataCount, p = e[d].totalCount - c, i = Math.max(i, c), n = Math.max(n, p);
                        r[d] = Array(c);
                        for (var u = 0; u < r[d].length; u++) r[d][u] = 255 & t.buffer[u + a];
                        for (a += c, u = l.getErrorCorrectPolynomial(p), c = new o(r[d], u.getLength() - 1).mod(u), s[d] = Array(u.getLength() - 1), u = 0; u < s[d].length; u++) p = u + c.getLength() - s[d].length, s[d][u] = 0 <= p ? c.get(p) : 0
                    }
                    for (u = d = 0; u < e.length; u++) d += e[u].totalCount;
                    for (a = Array(d), u = c = 0; u < i; u++) for (d = 0; d < e.length; d++) u < r[d].length && (a[c++] = r[d][u]);
                    for (u = 0; u < n; u++) for (d = 0; d < e.length; d++) u < s[d].length && (a[c++] = s[d][u]);
                    return a
                }, s = 4;
                for (var l = {
                    PATTERN_POSITION_TABLE: [[], [6, 18], [6, 22], [6, 26], [6, 30], [6, 34], [6, 22, 38], [6, 24, 42], [6, 26, 46], [6, 28, 50], [6, 30, 54], [6, 32, 58], [6, 34, 62], [6, 26, 46, 66], [6, 26, 48, 70], [6, 26, 50, 74], [6, 30, 54, 78], [6, 30, 56, 82], [6, 30, 58, 86], [6, 34, 62, 90], [6, 28, 50, 72, 94], [6, 26, 50, 74, 98], [6, 30, 54, 78, 102], [6, 28, 54, 80, 106], [6, 32, 58, 84, 110], [6, 30, 58, 86, 114], [6, 34, 62, 90, 118], [6, 26, 50, 74, 98, 122], [6, 30, 54, 78, 102, 126], [6, 26, 52, 78, 104, 130], [6, 30, 56, 82, 108, 134], [6, 34, 60, 86, 112, 138], [6, 30, 58, 86, 114, 142], [6, 34, 62, 90, 118, 146], [6, 30, 54, 78, 102, 126, 150], [6, 24, 50, 76, 102, 128, 154], [6, 28, 54, 80, 106, 132, 158], [6, 32, 58, 84, 110, 136, 162], [6, 26, 54, 82, 110, 138, 166], [6, 30, 58, 86, 114, 142, 170]],
                    G15: 1335,
                    G18: 7973,
                    G15_MASK: 21522,
                    getBCHTypeInfo: function (t) {
                        for (var e = t << 10; 0 <= l.getBCHDigit(e) - l.getBCHDigit(l.G15);) e ^= l.G15 << l.getBCHDigit(e) - l.getBCHDigit(l.G15);
                        return (t << 10 | e) ^ l.G15_MASK
                    },
                    getBCHTypeNumber: function (t) {
                        for (var e = t << 12; 0 <= l.getBCHDigit(e) - l.getBCHDigit(l.G18);) e ^= l.G18 << l.getBCHDigit(e) - l.getBCHDigit(l.G18);
                        return t << 12 | e
                    },
                    getBCHDigit: function (t) {
                        for (var e = 0; 0 != t;) e++, t >>>= 1;
                        return e
                    },
                    getPatternPosition: function (t) {
                        return l.PATTERN_POSITION_TABLE[t - 1]
                    },
                    getMask: function (t, e, a) {
                        switch (t) {
                            case 0:
                                return 0 == (e + a) % 2;
                            case 1:
                                return 0 == e % 2;
                            case 2:
                                return 0 == a % 3;
                            case 3:
                                return 0 == (e + a) % 3;
                            case 4:
                                return 0 == (Math.floor(e / 2) + Math.floor(a / 3)) % 2;
                            case 5:
                                return 0 == e * a % 2 + e * a % 3;
                            case 6:
                                return 0 == (e * a % 2 + e * a % 3) % 2;
                            case 7:
                                return 0 == (e * a % 3 + (e + a) % 2) % 2;
                            default:
                                throw Error("bad maskPattern:" + t)
                        }
                    },
                    getErrorCorrectPolynomial: function (t) {
                        for (var e = new o([1], 0), a = 0; a < t; a++) e = e.multiply(new o([1, d.gexp(a)], 0));
                        return e
                    },
                    getLengthInBits: function (t, e) {
                        if (1 <= e && 10 > e) switch (t) {
                            case 1:
                                return 10;
                            case 2:
                                return 9;
                            case s:
                            case 8:
                                return 8;
                            default:
                                throw Error("mode:" + t)
                        } else if (27 > e) switch (t) {
                            case 1:
                                return 12;
                            case 2:
                                return 11;
                            case s:
                                return 16;
                            case 8:
                                return 10;
                            default:
                                throw Error("mode:" + t)
                        } else {
                            if (!(41 > e)) throw Error("type:" + e);
                            switch (t) {
                                case 1:
                                    return 14;
                                case 2:
                                    return 13;
                                case s:
                                    return 16;
                                case 8:
                                    return 12;
                                default:
                                    throw Error("mode:" + t)
                            }
                        }
                    },
                    getLostPoint: function (t) {
                        for (var e = t.getModuleCount(), a = 0, i = 0; i < e; i++) for (var o = 0; o < e; o++) {
                            for (var n = 0, r = t.isDark(i, o), s = -1; 1 >= s; s++) if (!(0 > i + s || e <= i + s)) for (var l = -1; 1 >= l; l++) 0 > o + l || e <= o + l || 0 == s && 0 == l || r == t.isDark(i + s, o + l) && n++;
                            5 < n && (a += 3 + n - 5)
                        }
                        for (i = 0; i < e - 1; i++) for (o = 0; o < e - 1; o++) n = 0, t.isDark(i, o) && n++, t.isDark(i + 1, o) && n++, t.isDark(i, o + 1) && n++, t.isDark(i + 1, o + 1) && n++, (0 == n || 4 == n) && (a += 3);
                        for (i = 0; i < e; i++) for (o = 0; o < e - 6; o++) t.isDark(i, o) && !t.isDark(i, o + 1) && t.isDark(i, o + 2) && t.isDark(i, o + 3) && t.isDark(i, o + 4) && !t.isDark(i, o + 5) && t.isDark(i, o + 6) && (a += 40);
                        for (o = 0; o < e; o++) for (i = 0; i < e - 6; i++) t.isDark(i, o) && !t.isDark(i + 1, o) && t.isDark(i + 2, o) && t.isDark(i + 3, o) && t.isDark(i + 4, o) && !t.isDark(i + 5, o) && t.isDark(i + 6, o) && (a += 40);
                        for (o = n = 0; o < e; o++) for (i = 0; i < e; i++) t.isDark(i, o) && n++;
                        return t = Math.abs(100 * n / e / e - 50) / 5, a + 10 * t
                    }
                }, d = {
                    glog: function (t) {
                        if (1 > t) throw Error("glog(" + t + ")");
                        return d.LOG_TABLE[t]
                    }, gexp: function (t) {
                        for (; 0 > t;) t += 255;
                        for (; 256 <= t;) t -= 255;
                        return d.EXP_TABLE[t]
                    }, EXP_TABLE: Array(256), LOG_TABLE: Array(256)
                }, c = 0; 8 > c; c++) d.EXP_TABLE[c] = 1 << c;
                for (c = 8; 256 > c; c++) d.EXP_TABLE[c] = d.EXP_TABLE[c - 4] ^ d.EXP_TABLE[c - 5] ^ d.EXP_TABLE[c - 6] ^ d.EXP_TABLE[c - 8];
                for (c = 0; 255 > c; c++) d.LOG_TABLE[d.EXP_TABLE[c]] = c;
                return o.prototype = {
                    get: function (t) {
                        return this.num[t]
                    }, getLength: function () {
                        return this.num.length
                    }, multiply: function (t) {
                        for (var e = Array(this.getLength() + t.getLength() - 1), a = 0; a < this.getLength(); a++) for (var i = 0; i < t.getLength(); i++) e[a + i] ^= d.gexp(d.glog(this.get(a)) + d.glog(t.get(i)));
                        return new o(e, 0)
                    }, mod: function (t) {
                        if (0 > this.getLength() - t.getLength()) return this;
                        for (var e = d.glog(this.get(0)) - d.glog(t.get(0)), a = Array(this.getLength()), i = 0; i < this.getLength(); i++) a[i] = this.get(i);
                        for (i = 0; i < t.getLength(); i++) a[i] ^= d.gexp(d.glog(t.get(i)) + e);
                        return new o(a, 0).mod(t)
                    }
                }, n.RS_BLOCK_TABLE = [[1, 26, 19], [1, 26, 16], [1, 26, 13], [1, 26, 9], [1, 44, 34], [1, 44, 28], [1, 44, 22], [1, 44, 16], [1, 70, 55], [1, 70, 44], [2, 35, 17], [2, 35, 13], [1, 100, 80], [2, 50, 32], [2, 50, 24], [4, 25, 9], [1, 134, 108], [2, 67, 43], [2, 33, 15, 2, 34, 16], [2, 33, 11, 2, 34, 12], [2, 86, 68], [4, 43, 27], [4, 43, 19], [4, 43, 15], [2, 98, 78], [4, 49, 31], [2, 32, 14, 4, 33, 15], [4, 39, 13, 1, 40, 14], [2, 121, 97], [2, 60, 38, 2, 61, 39], [4, 40, 18, 2, 41, 19], [4, 40, 14, 2, 41, 15], [2, 146, 116], [3, 58, 36, 2, 59, 37], [4, 36, 16, 4, 37, 17], [4, 36, 12, 4, 37, 13], [2, 86, 68, 2, 87, 69], [4, 69, 43, 1, 70, 44], [6, 43, 19, 2, 44, 20], [6, 43, 15, 2, 44, 16], [4, 101, 81], [1, 80, 50, 4, 81, 51], [4, 50, 22, 4, 51, 23], [3, 36, 12, 8, 37, 13], [2, 116, 92, 2, 117, 93], [6, 58, 36, 2, 59, 37], [4, 46, 20, 6, 47, 21], [7, 42, 14, 4, 43, 15], [4, 133, 107], [8, 59, 37, 1, 60, 38], [8, 44, 20, 4, 45, 21], [12, 33, 11, 4, 34, 12], [3, 145, 115, 1, 146, 116], [4, 64, 40, 5, 65, 41], [11, 36, 16, 5, 37, 17], [11, 36, 12, 5, 37, 13], [5, 109, 87, 1, 110, 88], [5, 65, 41, 5, 66, 42], [5, 54, 24, 7, 55, 25], [11, 36, 12], [5, 122, 98, 1, 123, 99], [7, 73, 45, 3, 74, 46], [15, 43, 19, 2, 44, 20], [3, 45, 15, 13, 46, 16], [1, 135, 107, 5, 136, 108], [10, 74, 46, 1, 75, 47], [1, 50, 22, 15, 51, 23], [2, 42, 14, 17, 43, 15], [5, 150, 120, 1, 151, 121], [9, 69, 43, 4, 70, 44], [17, 50, 22, 1, 51, 23], [2, 42, 14, 19, 43, 15], [3, 141, 113, 4, 142, 114], [3, 70, 44, 11, 71, 45], [17, 47, 21, 4, 48, 22], [9, 39, 13, 16, 40, 14], [3, 135, 107, 5, 136, 108], [3, 67, 41, 13, 68, 42], [15, 54, 24, 5, 55, 25], [15, 43, 15, 10, 44, 16], [4, 144, 116, 4, 145, 117], [17, 68, 42], [17, 50, 22, 6, 51, 23], [19, 46, 16, 6, 47, 17], [2, 139, 111, 7, 140, 112], [17, 74, 46], [7, 54, 24, 16, 55, 25], [34, 37, 13], [4, 151, 121, 5, 152, 122], [4, 75, 47, 14, 76, 48], [11, 54, 24, 14, 55, 25], [16, 45, 15, 14, 46, 16], [6, 147, 117, 4, 148, 118], [6, 73, 45, 14, 74, 46], [11, 54, 24, 16, 55, 25], [30, 46, 16, 2, 47, 17], [8, 132, 106, 4, 133, 107], [8, 75, 47, 13, 76, 48], [7, 54, 24, 22, 55, 25], [22, 45, 15, 13, 46, 16], [10, 142, 114, 2, 143, 115], [19, 74, 46, 4, 75, 47], [28, 50, 22, 6, 51, 23], [33, 46, 16, 4, 47, 17], [8, 152, 122, 4, 153, 123], [22, 73, 45, 3, 74, 46], [8, 53, 23, 26, 54, 24], [12, 45, 15, 28, 46, 16], [3, 147, 117, 10, 148, 118], [3, 73, 45, 23, 74, 46], [4, 54, 24, 31, 55, 25], [11, 45, 15, 31, 46, 16], [7, 146, 116, 7, 147, 117], [21, 73, 45, 7, 74, 46], [1, 53, 23, 37, 54, 24], [19, 45, 15, 26, 46, 16], [5, 145, 115, 10, 146, 116], [19, 75, 47, 10, 76, 48], [15, 54, 24, 25, 55, 25], [23, 45, 15, 25, 46, 16], [13, 145, 115, 3, 146, 116], [2, 74, 46, 29, 75, 47], [42, 54, 24, 1, 55, 25], [23, 45, 15, 28, 46, 16], [17, 145, 115], [10, 74, 46, 23, 75, 47], [10, 54, 24, 35, 55, 25], [19, 45, 15, 35, 46, 16], [17, 145, 115, 1, 146, 116], [14, 74, 46, 21, 75, 47], [29, 54, 24, 19, 55, 25], [11, 45, 15, 46, 46, 16], [13, 145, 115, 6, 146, 116], [14, 74, 46, 23, 75, 47], [44, 54, 24, 7, 55, 25], [59, 46, 16, 1, 47, 17], [12, 151, 121, 7, 152, 122], [12, 75, 47, 26, 76, 48], [39, 54, 24, 14, 55, 25], [22, 45, 15, 41, 46, 16], [6, 151, 121, 14, 152, 122], [6, 75, 47, 34, 76, 48], [46, 54, 24, 10, 55, 25], [2, 45, 15, 64, 46, 16], [17, 152, 122, 4, 153, 123], [29, 74, 46, 14, 75, 47], [49, 54, 24, 10, 55, 25], [24, 45, 15, 46, 46, 16], [4, 152, 122, 18, 153, 123], [13, 74, 46, 32, 75, 47], [48, 54, 24, 14, 55, 25], [42, 45, 15, 32, 46, 16], [20, 147, 117, 4, 148, 118], [40, 75, 47, 7, 76, 48], [43, 54, 24, 22, 55, 25], [10, 45, 15, 67, 46, 16], [19, 148, 118, 6, 149, 119], [18, 75, 47, 31, 76, 48], [34, 54, 24, 34, 55, 25], [20, 45, 15, 61, 46, 16]], n.getRSBlocks = function (t, e) {
                    var a = n.getRsBlockTable(t, e);
                    if (void 0 == a) throw Error("bad rs block @ typeNumber:" + t + "/errorCorrectLevel:" + e);
                    for (var i = a.length / 3, o = [], r = 0; r < i; r++) for (var s = a[3 * r + 0], l = a[3 * r + 1], d = a[3 * r + 2], c = 0; c < s; c++) o.push(new n(l, d));
                    return o
                }, n.getRsBlockTable = function (t, e) {
                    switch (e) {
                        case 1:
                            return n.RS_BLOCK_TABLE[4 * (t - 1) + 0];
                        case 0:
                            return n.RS_BLOCK_TABLE[4 * (t - 1) + 1];
                        case 3:
                            return n.RS_BLOCK_TABLE[4 * (t - 1) + 2];
                        case 2:
                            return n.RS_BLOCK_TABLE[4 * (t - 1) + 3]
                    }
                }, r.prototype = {
                    get: function (t) {
                        return 1 == (this.buffer[Math.floor(t / 8)] >>> 7 - t % 8 & 1)
                    }, put: function (t, e) {
                        for (var a = 0; a < e; a++) this.putBit(1 == (t >>> e - a - 1 & 1))
                    }, getLengthInBits: function () {
                        return this.length
                    }, putBit: function (t) {
                        var e = Math.floor(this.length / 8);
                        this.buffer.length <= e && this.buffer.push(0), t && (this.buffer[e] |= 128 >>> this.length % 8), this.length++
                    }
                }, "string" == typeof e && (e = {text: e}), e = t.extend({}, {
                    render: "canvas",
                    width: 256,
                    height: 256,
                    typeNumber: -1,
                    correctLevel: 2,
                    background: "#ffffff",
                    foreground: "#000000"
                }, e), this.each(function () {
                    var a;
                    if ("canvas" == e.render) {
                        a = new i(e.typeNumber, e.correctLevel), a.addData(e.text), a.make();
                        var o = document.createElement("canvas");
                        o.width = e.width, o.height = e.height;
                        for (var n = o.getContext("2d"), r = e.width / a.getModuleCount(), s = e.height / a.getModuleCount(), l = 0; l < a.getModuleCount(); l++) for (var d = 0; d < a.getModuleCount(); d++) {
                            n.fillStyle = a.isDark(l, d) ? e.foreground : e.background;
                            var c = Math.ceil((d + 1) * r) - Math.floor(d * r),
                                p = Math.ceil((l + 1) * r) - Math.floor(l * r);
                            n.fillRect(Math.round(d * r), Math.round(l * s), c, p)
                        }
                    } else for (a = new i(e.typeNumber, e.correctLevel), a.addData(e.text), a.make(), o = t("<table></table>").css("width", e.width + "px").css("height", e.height + "px").css("border", "0px").css("border-collapse", "collapse").css("background-color", e.background), n = e.width / a.getModuleCount(), r = e.height / a.getModuleCount(), s = 0; s < a.getModuleCount(); s++) for (l = t("<tr></tr>").css("height", r + "px").appendTo(o), d = 0; d < a.getModuleCount(); d++) t("<td></td>").css("width", n + "px").css("background-color", a.isDark(s, d) ? e.foreground : e.background).appendTo(l);
                    a = o, jQuery(a).appendTo(this)
                })
            }
        }(jQuery)
    }, {}],
    6: [function (t, e, a) {
        !function (t) {
            t(document).ready(function () {
                "Microsoft Internet Explorer" == navigator.appName && "9." == navigator.appVersion.match(/9./i) && t(".edit-cover, .edit-avatar").hide();
                var e, a, i = 0;
                t(document).on("click", ".edit-avatar, .edit-cover", function (o) {
                    o.preventDefault(), i = t(this).hasClass("edit-cover") ? 1 : 0, a = t(this).data("user");
                    var n = cropperModal({
                        lg: i,
                        title: _wpcom_js.cropper.title,
                        desc: i ? _wpcom_js.cropper.desc_1 : _wpcom_js.cropper.desc_0,
                        btn: _wpcom_js.cropper.btn,
                        loading: _wpcom_js.cropper.loading,
                        apply: _wpcom_js.cropper.apply,
                        cancel: _wpcom_js.cropper.cancel
                    });
                    t("#crop-modal").length ? t("#crop-modal").replaceWith(n) : t("body").append(n), e && (e.destroy(), e = null, t(".crop-img-wrap").hide(), t(".crop-img-btn").show(), t("#crop-img").remove(), t(".crop-notice").text("")), t("#crop-modal").modal("show")
                }).on("change", "#img-file", function (a) {
                    if (t(".crop-notice").text(""), !this.files.length) return !1;
                    if (this.files[0].size / 1024 > 5120) return alert(_wpcom_js.cropper.alert_size), !1;
                    if (this.files[0].type.match(/image.*/)) {
                        var o;
                        o = window.URL.createObjectURL(this.files[0]), t(".crop-img-wrap").append('<img id="crop-img" src="' + o + '">').show(), t(".crop-img-btn").hide(), e = new Cropper(document.getElementById("crop-img"), {
                            aspectRatio: i ? 2.7 : 1,
                            minContainerHeight: 300,
                            viewMode: i ? 3 : 1,
                            ready: function () {
                                var t = {width: 300, height: 300};
                                i && (t = {width: 810, height: 300, left: 44}), e.setCropBoxData(t)
                            }
                        }), t(this).val("")
                    } else alert(_wpcom_js.cropper.alert_filetype)
                }).on("click", ".j-crop-close", function () {
                    e && e.destroy(), e = null, t(".crop-img-wrap").hide(), t(".crop-img-btn").show(), t("#crop-img").remove(), t(".crop-notice").text("")
                }).on("click", ".j-crop-apply", function () {
                    var o = t(this).button("loading"), n = t(".crop-notice");
                    if (n.text(""), e) {
                        if (e.crop().cropped) {
                            var r = {
                                minWidth: 200,
                                minHeight: 200,
                                maxWidth: 600,
                                maxHeight: 600,
                                fillColor: "#fff",
                                imageSmoothingQuality: "high"
                            };
                            i && (r = {
                                minWidth: 810,
                                minHeight: 300,
                                maxWidth: 1620,
                                maxHeight: 600,
                                fillColor: "#fff",
                                imageSmoothingQuality: "high"
                            });
                            var s = t.extend(e.getCropBoxData(), r),
                                l = e.getCroppedCanvas(s).toDataURL("image/jpeg", .95);
                            if (l) {
                                var d = new FormData;
                                d.append("action", "wpcom_cropped_upload"), d.append("nonce", t("#wpcom_cropper_nonce").val()), d.append("image", l), d.append("type", i), a && d.append("user", a), t.ajax(_wpcom_js.ajaxurl, {
                                    method: "POST",
                                    data: d,
                                    dataType: "json",
                                    processData: !1,
                                    contentType: !1,
                                    success: function (e) {
                                        "1" == e.result ? (i ? t(".wpcom-profile-head").css("background-image", "url(" + e.url + ")") : t(".member-account-avatar img.avatar,.wpcom-ph-avatar img.avatar,#j-user-wrap img.avatar").replaceWith('<img class="avatar photo" src="' + e.url + "?t=" + Date.parse(new Date) / 1e3 + '">'), t("#crop-modal").modal("hide")) : "-1" == e.result ? n.text(_wpcom_js.cropper.err_nonce) : "-2" == e.result ? n.text(_wpcom_js.cropper.err_fail) : "-3" == e.result && n.text(_wpcom_js.cropper.err_login), o.button("reset")
                                    },
                                    error: function () {
                                        alert(_wpcom_js.cropper.ajaxerr), o.button("reset")
                                    }
                                })
                            } else o.button("reset")
                        } else o.button("reset")
                    } else n.text(_wpcom_js.cropper.err_empty), o.button("reset")
                }).on("click", ".j-social-unbind", function () {
                    var e = t(this);
                    if (e.hasClass("disabled")) return !1;
                    var a = e.data("name");
                    e.addClass("disabled").text("处理中..."), confirm("是否确定解除绑定？") ? t.ajax({
                        type: "POST",
                        url: _wpcom_js.ajaxurl,
                        data: {action: "wpcom_social_unbind", name: a},
                        dataType: "json",
                        success: function (t) {
                            e.removeClass("disabled").text("解除绑定"), 1 == t.result ? (alert("解绑成功！"), e.parent().html(t.error)) : t.error && alert(t.error)
                        },
                        error: function () {
                            e.removeClass("disabled").text("解除绑定")
                        }
                    }) : e.removeClass("disabled").text("解除绑定")
                }).on("click", "a", function (e) {
                    var a = t(this), i = a.attr("href"), o = i ? i.match(/(\?|&)modal-type=(login|register)/i) : null;
                    if (o && o[2]) {
                        if (t("body.navbar-on").length) return;
                        e.preventDefault();
                        var n = t("#login-form-modal"), r = t(window).height();
                        0 === n.length && (t("body").append('<div class="modal" id="login-form-modal" data-backdrop="static">\n            <div class="modal-dialog">\n                <div class="modal-content"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>\n                    <div class="modal-body"></div>\n                </div>\n            </div>\n        </div>'), n = t("#login-form-modal"));
                        var s = n.find(".modal-body");
                        s.html(""), n.modal("show"), t.ajax({
                            type: "POST",
                            url: _wpcom_js.ajaxurl,
                            data: {action: "wpcom_login_modal", type: o[2]},
                            dataType: "html",
                            success: function (e) {
                                if ("undefined" == typeof is_load_login) {
                                    var a = void 0 !== _wpcom_js.framework_url ? _wpcom_js.framework_url : _wpcom_js.theme_url + "/themer";
                                    t.getScript(a + "/assets/js/login.js", function () {
                                        s.html(e), t(document).trigger("init_captcha"), setTimeout(function () {
                                            s.css("height", "");
                                            var t = (r - s.height()) / 2 - 60;
                                            n.find(".modal-dialog").css("margin-top", t <= 0 ? 30 : t), s.css("height", s.height())
                                        }, 50)
                                    })
                                } else s.html(e), t(document).trigger("init_captcha"), setTimeout(function () {
                                    s.css("height", "");
                                    var t = (r - s.height()) / 2 - 60;
                                    n.find(".modal-dialog").css("margin-top", t <= 0 ? 30 : t), s.css("height", s.height())
                                }, 50)
                            },
                            error: function () {
                            }
                        })
                    }
                })
            });
            var e = t("#j-user-wrap");
            e.length && t.ajax({
                type: "POST",
                url: _wpcom_js.ajaxurl,
                data: {action: "wpcom_is_login"},
                dataType: "json",
                success: function (a) {
                    if (0 == a.result) {
                        var i = '<ul class="profile"><li class="menu-item dropdown"><a class="menu-item-user" href="' + (a.account ? a.account : a.url) + '"> ' + a.avatar + a.display_name + "</a>";
                        if (a.menus && a.menus.length) {
                            i += '<ul class="dropdown-menu">';
                            for (var o = 0; o < a.menus.length; o++) i += '<li><a href="' + a.menus[o].url + '">' + a.menus[o].title + "</a></li>";
                            i += "</ul>"
                        }
                        i += "</li></ul>", e.html(i)
                    } else e.find(".login").addClass("cur");
                    t("header.header").trigger("DOMNodeInserted"), a.wc && (a.wc.fragments && a.wc.fragments["a.cart-contents"] && t("header .shopping-cart").html(a.wc.fragments["a.cart-contents"]), setTimeout(function () {
                        a.wc.fragments && a.wc.fragments["div.widget_shopping_cart_content"] && t("header .shopping-cart").append(a.wc.fragments["div.widget_shopping_cart_content"]), t("header.header").trigger("DOMNodeInserted")
                    }, 100))
                }
            }), t(".social-login-wrap").on("submit", "#sl-form-create", function () {
                var e = t(this);
                if (e.find(".sl-input-submit.disabled").length) return !1;
                e.find(".sl-input-submit").addClass("disabled");
                for (var a = 0, i = e.find(".sl-input input"), o = 0; o < i.length; o++) {
                    var n = t(i[o]).val();
                    "" == t.trim(n) && (t(i[o]).addClass("error"), a = 1)
                }
                return a ? e.find(".sl-input-submit").removeClass("disabled") : t.ajax({
                    url: _wpcom_js.ajaxurl,
                    data: t(this).serialize() + "&action=wpcom_sl_login",
                    type: "POST",
                    dataType: "json",
                    success: function (t) {
                        e.find(".sl-input-submit").removeClass("disabled"), "-1" == t ? e.find(".sl-result").text("请求出错，请重试！").addClass("error") : "1" == t.result ? e.find(".sl-result").text("用户名或密码不能为空").addClass("error") : "2" == t.result ? e.find(".sl-result").text("用户名或密码错误").addClass("error") : "3" == t.result ? e.find(".sl-result").text("第三方应用授权失败，请重试").addClass("error") : "4" == t.result ? e.find(".sl-result").text("第三方帐号已与本站其他帐号绑定").addClass("error") : "0" == t.result && (e.find(".sl-result").text("绑定成功！").removeClass("error"), setTimeout(function () {
                            window.location.href = t.redirect
                        }, 100))
                    },
                    error: function (t) {
                        e.find(".sl-result").text("请求出错，请重试！").addClass("error"), e.find(".sl-input-submit").removeClass("disabled")
                    }
                }), !1
            }).on("submit", "#sl-form-bind", function () {
                var e = t(this);
                if (e.find(".sl-input-submit.disabled").length) return !1;
                e.find(".sl-input-submit").addClass("disabled");
                for (var a = 0, i = e.find(".sl-input input"), o = 0; o < i.length; o++) {
                    var n = t(i[o]).val();
                    "" == t.trim(n) && (t(i[o]).addClass("error"), a = 1)
                }
                return a ? e.find(".sl-input-submit").removeClass("disabled") : t.ajax({
                    url: _wpcom_js.ajaxurl,
                    data: t(this).serialize() + "&action=wpcom_sl_create",
                    type: "POST",
                    dataType: "json",
                    success: function (t) {
                        "-1" == t ? e.find(".sl-result").text("请求出错，请重试！").addClass("error") : "1" == t.result ? e.find(".sl-result").text("请输入电子邮箱").addClass("error") : "2" == t.result ? e.find(".sl-result").text("请输入正确的电子邮箱").addClass("error") : "3" == t.result ? e.find(".sl-result").text("第三方应用授权失败，请重试").addClass("error") : "4" == t.result ? e.find(".sl-result").text("第三方帐号已与本站其他帐号绑定").addClass("error") : "5" == t.result ? e.find(".sl-result").text("该邮箱已被注册").addClass("error") : "0" == t.result ? (e.find(".sl-result").text("注册成功！").removeClass("error"), setTimeout(function () {
                            window.location.href = t.redirect
                        }, 100)) : t.result && t.msg && e.find(".sl-result").text(t.msg).addClass("error"), e.find(".sl-input-submit").removeClass("disabled")
                    },
                    error: function (t) {
                        e.find(".sl-result").text("请求出错，请重试！").addClass("error"), e.find(".sl-input-submit").removeClass("disabled")
                    }
                }), !1
            }).on("input change", ".sl-input input", function () {
                var e = t(this);
                e.removeClass("error"), e.closest(".sl-info-form").find(".sl-result").text("")
            }).on("click", ".sl-form-title", function () {
                var e = t(this).closest(".sl-form-item");
                t(".sl-form-item").removeClass("active"), e.addClass("active")
            })
        }(jQuery)
    }, {}],
    7: [function (t, e, a) {/*!
 * Swiper 3.3.1
 * Most modern mobile touch slider and framework with hardware accelerated transitions
 *
 * http://www.idangero.us/swiper/
 *
 * Copyright 2016, Vladimir Kharlampidi
 * The iDangero.us
 * http://www.idangero.us/
 *
 * Licensed under MIT
 *
 * Released on: February 7, 2016
 */
        !function () {
            "use strict";
            var t, e = function (a, i) {
                function o(t) {
                    return Math.floor(t)
                }

                function n() {
                    y.autoplayTimeoutId = setTimeout(function () {
                        y.params.loop ? (y.fixLoop(), y._slideNext(), y.emit("onAutoplay", y)) : y.isEnd ? i.autoplayStopOnLast ? y.stopAutoplay() : (y._slideTo(0), y.emit("onAutoplay", y)) : (y._slideNext(), y.emit("onAutoplay", y))
                    }, y.params.autoplay)
                }

                function r(e, a) {
                    var i = t(e.target);
                    if (!i.is(a)) if ("string" == typeof a) i = i.parents(a); else if (a.nodeType) {
                        var o;
                        return i.parents().each(function (t, e) {
                            e === a && (o = a)
                        }), o ? a : void 0
                    }
                    if (0 !== i.length) return i[0]
                }

                function s(t, e) {
                    e = e || {};
                    var a = window.MutationObserver || window.WebkitMutationObserver, i = new a(function (t) {
                        t.forEach(function (t) {
                            y.onResize(!0), y.emit("onObserverUpdate", y, t)
                        })
                    });
                    i.observe(t, {
                        attributes: void 0 === e.attributes || e.attributes,
                        childList: void 0 === e.childList || e.childList,
                        characterData: void 0 === e.characterData || e.characterData
                    }), y.observers.push(i)
                }

                function l(t) {
                    t.originalEvent && (t = t.originalEvent);
                    var e = t.keyCode || t.charCode;
                    if (!y.params.allowSwipeToNext && (y.isHorizontal() && 39 === e || !y.isHorizontal() && 40 === e)) return !1;
                    if (!y.params.allowSwipeToPrev && (y.isHorizontal() && 37 === e || !y.isHorizontal() && 38 === e)) return !1;
                    if (!(t.shiftKey || t.altKey || t.ctrlKey || t.metaKey || document.activeElement && document.activeElement.nodeName && ("input" === document.activeElement.nodeName.toLowerCase() || "textarea" === document.activeElement.nodeName.toLowerCase()))) {
                        if (37 === e || 39 === e || 38 === e || 40 === e) {
                            var a = !1;
                            if (y.container.parents(".swiper-slide").length > 0 && 0 === y.container.parents(".swiper-slide-active").length) return;
                            var i = {left: window.pageXOffset, top: window.pageYOffset}, o = window.innerWidth,
                                n = window.innerHeight, r = y.container.offset();
                            y.rtl && (r.left = r.left - y.container[0].scrollLeft);
                            for (var s = [[r.left, r.top], [r.left + y.width, r.top], [r.left, r.top + y.height], [r.left + y.width, r.top + y.height]], l = 0; l < s.length; l++) {
                                var d = s[l];
                                d[0] >= i.left && d[0] <= i.left + o && d[1] >= i.top && d[1] <= i.top + n && (a = !0)
                            }
                            if (!a) return
                        }
                        y.isHorizontal() ? (37 !== e && 39 !== e || (t.preventDefault ? t.preventDefault() : t.returnValue = !1), (39 === e && !y.rtl || 37 === e && y.rtl) && y.slideNext(), (37 === e && !y.rtl || 39 === e && y.rtl) && y.slidePrev()) : (38 !== e && 40 !== e || (t.preventDefault ? t.preventDefault() : t.returnValue = !1), 40 === e && y.slideNext(), 38 === e && y.slidePrev())
                    }
                }

                function d(t) {
                    t.originalEvent && (t = t.originalEvent);
                    var e = y.mousewheel.event, a = 0, i = y.rtl ? -1 : 1;
                    if ("mousewheel" === e) if (y.params.mousewheelForceToAxis) if (y.isHorizontal()) {
                        if (!(Math.abs(t.wheelDeltaX) > Math.abs(t.wheelDeltaY))) return;
                        a = t.wheelDeltaX * i
                    } else {
                        if (!(Math.abs(t.wheelDeltaY) > Math.abs(t.wheelDeltaX))) return;
                        a = t.wheelDeltaY
                    } else a = Math.abs(t.wheelDeltaX) > Math.abs(t.wheelDeltaY) ? -t.wheelDeltaX * i : -t.wheelDeltaY; else if ("DOMMouseScroll" === e) a = -t.detail; else if ("wheel" === e) if (y.params.mousewheelForceToAxis) if (y.isHorizontal()) {
                        if (!(Math.abs(t.deltaX) > Math.abs(t.deltaY))) return;
                        a = -t.deltaX * i
                    } else {
                        if (!(Math.abs(t.deltaY) > Math.abs(t.deltaX))) return;
                        a = -t.deltaY
                    } else a = Math.abs(t.deltaX) > Math.abs(t.deltaY) ? -t.deltaX * i : -t.deltaY;
                    if (0 !== a) {
                        if (y.params.mousewheelInvert && (a = -a), y.params.freeMode) {
                            var o = y.getWrapperTranslate() + a * y.params.mousewheelSensitivity, n = y.isBeginning,
                                r = y.isEnd;
                            if (o >= y.minTranslate() && (o = y.minTranslate()), o <= y.maxTranslate() && (o = y.maxTranslate()), y.setWrapperTransition(0), y.setWrapperTranslate(o), y.updateProgress(), y.updateActiveIndex(), (!n && y.isBeginning || !r && y.isEnd) && y.updateClasses(), y.params.freeModeSticky ? (clearTimeout(y.mousewheel.timeout), y.mousewheel.timeout = setTimeout(function () {
                                y.slideReset()
                            }, 300)) : y.params.lazyLoading && y.lazy && y.lazy.load(), 0 === o || o === y.maxTranslate()) return
                        } else {
                            if ((new window.Date).getTime() - y.mousewheel.lastScrollTime > 60) if (a < 0) if (y.isEnd && !y.params.loop || y.animating) {
                                if (y.params.mousewheelReleaseOnEdges) return !0
                            } else y.slideNext(); else if (y.isBeginning && !y.params.loop || y.animating) {
                                if (y.params.mousewheelReleaseOnEdges) return !0
                            } else y.slidePrev();
                            y.mousewheel.lastScrollTime = (new window.Date).getTime()
                        }
                        return y.params.autoplay && y.stopAutoplay(), t.preventDefault ? t.preventDefault() : t.returnValue = !1, !1
                    }
                }

                function c(e, a) {
                    e = t(e);
                    var i, o, n, r = y.rtl ? -1 : 1;
                    i = e.attr("data-swiper-parallax") || "0", o = e.attr("data-swiper-parallax-x"), n = e.attr("data-swiper-parallax-y"), o || n ? (o = o || "0", n = n || "0") : y.isHorizontal() ? (o = i, n = "0") : (n = i, o = "0"), o = o.indexOf("%") >= 0 ? parseInt(o, 10) * a * r + "%" : o * a * r + "px", n = n.indexOf("%") >= 0 ? parseInt(n, 10) * a + "%" : n * a + "px", e.transform("translate3d(" + o + ", " + n + ",0px)")
                }

                function p(t) {
                    return 0 !== t.indexOf("on") && (t = t[0] !== t[0].toUpperCase() ? "on" + t[0].toUpperCase() + t.substring(1) : "on" + t), t
                }

                if (!(this instanceof e)) return new e(a, i);
                var u = {
                    direction: "horizontal",
                    touchEventsTarget: "container",
                    initialSlide: 0,
                    speed: 300,
                    autoplay: !1,
                    autoplayDisableOnInteraction: !0,
                    autoplayStopOnLast: !1,
                    iOSEdgeSwipeDetection: !1,
                    iOSEdgeSwipeThreshold: 20,
                    freeMode: !1,
                    freeModeMomentum: !0,
                    freeModeMomentumRatio: 1,
                    freeModeMomentumBounce: !0,
                    freeModeMomentumBounceRatio: 1,
                    freeModeSticky: !1,
                    freeModeMinimumVelocity: .02,
                    autoHeight: !1,
                    setWrapperSize: !1,
                    virtualTranslate: !1,
                    effect: "slide",
                    coverflow: {rotate: 50, stretch: 0, depth: 100, modifier: 1, slideShadows: !0},
                    flip: {slideShadows: !0, limitRotation: !0},
                    cube: {slideShadows: !0, shadow: !0, shadowOffset: 20, shadowScale: .94},
                    fade: {crossFade: !1},
                    parallax: !1,
                    scrollbar: null,
                    scrollbarHide: !0,
                    scrollbarDraggable: !1,
                    scrollbarSnapOnRelease: !1,
                    keyboardControl: !1,
                    mousewheelControl: !1,
                    mousewheelReleaseOnEdges: !1,
                    mousewheelInvert: !1,
                    mousewheelForceToAxis: !1,
                    mousewheelSensitivity: 1,
                    hashnav: !1,
                    breakpoints: void 0,
                    spaceBetween: 0,
                    slidesPerView: 1,
                    slidesPerColumn: 1,
                    slidesPerColumnFill: "column",
                    slidesPerGroup: 1,
                    centeredSlides: !1,
                    slidesOffsetBefore: 0,
                    slidesOffsetAfter: 0,
                    roundLengths: !1,
                    touchRatio: 1,
                    touchAngle: 45,
                    simulateTouch: !0,
                    shortSwipes: !0,
                    longSwipes: !0,
                    longSwipesRatio: .5,
                    longSwipesMs: 300,
                    followFinger: !0,
                    onlyExternal: !1,
                    threshold: 0,
                    touchMoveStopPropagation: !0,
                    uniqueNavElements: !0,
                    pagination: null,
                    paginationElement: "span",
                    paginationClickable: !1,
                    paginationHide: !1,
                    paginationBulletRender: null,
                    paginationProgressRender: null,
                    paginationFractionRender: null,
                    paginationCustomRender: null,
                    paginationType: "bullets",
                    resistance: !0,
                    resistanceRatio: .85,
                    nextButton: null,
                    prevButton: null,
                    watchSlidesProgress: !1,
                    watchSlidesVisibility: !1,
                    grabCursor: !1,
                    preventClicks: !0,
                    preventClicksPropagation: !0,
                    slideToClickedSlide: !1,
                    lazyLoading: !1,
                    lazyLoadingInPrevNext: !1,
                    lazyLoadingInPrevNextAmount: 1,
                    lazyLoadingOnTransitionStart: !1,
                    preloadImages: !0,
                    updateOnImagesReady: !0,
                    loop: !1,
                    loopAdditionalSlides: 0,
                    loopedSlides: null,
                    control: void 0,
                    controlInverse: !1,
                    controlBy: "slide",
                    allowSwipeToPrev: !0,
                    allowSwipeToNext: !0,
                    swipeHandler: null,
                    noSwiping: !0,
                    noSwipingClass: "swiper-no-swiping",
                    slideClass: "swiper-slide",
                    slideActiveClass: "swiper-slide-active",
                    slideVisibleClass: "swiper-slide-visible",
                    slideDuplicateClass: "swiper-slide-duplicate",
                    slideNextClass: "swiper-slide-next",
                    slidePrevClass: "swiper-slide-prev",
                    wrapperClass: "swiper-wrapper",
                    bulletClass: "swiper-pagination-bullet",
                    bulletActiveClass: "swiper-pagination-bullet-active",
                    buttonDisabledClass: "swiper-button-disabled",
                    paginationCurrentClass: "swiper-pagination-current",
                    paginationTotalClass: "swiper-pagination-total",
                    paginationHiddenClass: "swiper-pagination-hidden",
                    paginationProgressbarClass: "swiper-pagination-progressbar",
                    observer: !1,
                    observeParents: !1,
                    a11y: !1,
                    prevSlideMessage: "Previous slide",
                    nextSlideMessage: "Next slide",
                    firstSlideMessage: "This is the first slide",
                    lastSlideMessage: "This is the last slide",
                    paginationBulletMessage: "Go to slide {{index}}",
                    runCallbacksOnInit: !0
                }, h = i && i.virtualTranslate;
                i = i || {};
                var f = {};
                for (var m in i) if ("object" != typeof i[m] || null === i[m] || (i[m].nodeType || i[m] === window || i[m] === document || "undefined" != typeof Dom7 && i[m] instanceof Dom7 || "undefined" != typeof jQuery && i[m] instanceof jQuery)) f[m] = i[m]; else {
                    f[m] = {};
                    for (var g in i[m]) f[m][g] = i[m][g]
                }
                for (var v in u) if (void 0 === i[v]) i[v] = u[v]; else if ("object" == typeof i[v]) for (var w in u[v]) void 0 === i[v][w] && (i[v][w] = u[v][w]);
                var y = this;
                if (y.params = i, y.originalParams = f, y.classNames = [], void 0 !== t && "undefined" != typeof Dom7 && (t = Dom7), (void 0 !== t || (t = "undefined" == typeof Dom7 ? window.Dom7 || window.Zepto || window.jQuery : Dom7)) && (y.$ = t, y.currentBreakpoint = void 0, y.getActiveBreakpoint = function () {
                    if (!y.params.breakpoints) return !1;
                    var t, e = !1, a = [];
                    for (t in y.params.breakpoints) y.params.breakpoints.hasOwnProperty(t) && a.push(t);
                    a.sort(function (t, e) {
                        return parseInt(t, 10) > parseInt(e, 10)
                    });
                    for (var i = 0; i < a.length; i++) (t = a[i]) >= window.innerWidth && !e && (e = t);
                    return e || "max"
                }, y.setBreakpoint = function () {
                    var t = y.getActiveBreakpoint();
                    if (t && y.currentBreakpoint !== t) {
                        var e = t in y.params.breakpoints ? y.params.breakpoints[t] : y.originalParams,
                            a = y.params.loop && e.slidesPerView !== y.params.slidesPerView;
                        for (var i in e) y.params[i] = e[i];
                        y.currentBreakpoint = t, a && y.destroyLoop && y.reLoop(!0)
                    }
                }, y.params.breakpoints && y.setBreakpoint(), y.container = t(a), 0 !== y.container.length)) {
                    if (y.container.length > 1) {
                        var b = [];
                        return y.container.each(function () {
                            b.push(new e(this, i))
                        }), b
                    }
                    y.container[0].swiper = y, y.container.data("swiper", y), y.classNames.push("swiper-container-" + y.params.direction), y.params.freeMode && y.classNames.push("swiper-container-free-mode"), y.support.flexbox || (y.classNames.push("swiper-container-no-flexbox"), y.params.slidesPerColumn = 1), y.params.autoHeight && y.classNames.push("swiper-container-autoheight"), (y.params.parallax || y.params.watchSlidesVisibility) && (y.params.watchSlidesProgress = !0), ["cube", "coverflow", "flip"].indexOf(y.params.effect) >= 0 && (y.support.transforms3d ? (y.params.watchSlidesProgress = !0, y.classNames.push("swiper-container-3d")) : y.params.effect = "slide"), "slide" !== y.params.effect && y.classNames.push("swiper-container-" + y.params.effect), "cube" === y.params.effect && (y.params.resistanceRatio = 0, y.params.slidesPerView = 1, y.params.slidesPerColumn = 1, y.params.slidesPerGroup = 1, y.params.centeredSlides = !1, y.params.spaceBetween = 0, y.params.virtualTranslate = !0, y.params.setWrapperSize = !1), "fade" !== y.params.effect && "flip" !== y.params.effect || (y.params.slidesPerView = 1, y.params.slidesPerColumn = 1, y.params.slidesPerGroup = 1, y.params.watchSlidesProgress = !0, y.params.spaceBetween = 0, y.params.setWrapperSize = !1, void 0 === h && (y.params.virtualTranslate = !0)), y.params.grabCursor && y.support.touch && (y.params.grabCursor = !1), y.wrapper = y.container.children("." + y.params.wrapperClass), y.params.pagination && (y.paginationContainer = t(y.params.pagination), y.params.uniqueNavElements && "string" == typeof y.params.pagination && y.paginationContainer.length > 1 && 1 === y.container.find(y.params.pagination).length && (y.paginationContainer = y.container.find(y.params.pagination)), "bullets" === y.params.paginationType && y.params.paginationClickable ? y.paginationContainer.addClass("swiper-pagination-clickable") : y.params.paginationClickable = !1, y.paginationContainer.addClass("swiper-pagination-" + y.params.paginationType)), (y.params.nextButton || y.params.prevButton) && (y.params.nextButton && (y.nextButton = t(y.params.nextButton), y.params.uniqueNavElements && "string" == typeof y.params.nextButton && y.nextButton.length > 1 && 1 === y.container.find(y.params.nextButton).length && (y.nextButton = y.container.find(y.params.nextButton))), y.params.prevButton && (y.prevButton = t(y.params.prevButton), y.params.uniqueNavElements && "string" == typeof y.params.prevButton && y.prevButton.length > 1 && 1 === y.container.find(y.params.prevButton).length && (y.prevButton = y.container.find(y.params.prevButton)))), y.isHorizontal = function () {
                        return "horizontal" === y.params.direction
                    }, y.rtl = y.isHorizontal() && ("rtl" === y.container[0].dir.toLowerCase() || "rtl" === y.container.css("direction")), y.rtl && y.classNames.push("swiper-container-rtl"), y.rtl && (y.wrongRTL = "-webkit-box" === y.wrapper.css("display")), y.params.slidesPerColumn > 1 && y.classNames.push("swiper-container-multirow"), y.device.android && y.classNames.push("swiper-container-android"), y.container.addClass(y.classNames.join(" ")), y.translate = 0, y.progress = 0, y.velocity = 0, y.lockSwipeToNext = function () {
                        y.params.allowSwipeToNext = !1
                    }, y.lockSwipeToPrev = function () {
                        y.params.allowSwipeToPrev = !1
                    }, y.lockSwipes = function () {
                        y.params.allowSwipeToNext = y.params.allowSwipeToPrev = !1
                    }, y.unlockSwipeToNext = function () {
                        y.params.allowSwipeToNext = !0
                    }, y.unlockSwipeToPrev = function () {
                        y.params.allowSwipeToPrev = !0
                    }, y.unlockSwipes = function () {
                        y.params.allowSwipeToNext = y.params.allowSwipeToPrev = !0
                    }, y.params.grabCursor && (y.container[0].style.cursor = "move", y.container[0].style.cursor = "-webkit-grab", y.container[0].style.cursor = "-moz-grab", y.container[0].style.cursor = "grab"), y.imagesToLoad = [], y.imagesLoaded = 0, y.loadImage = function (t, e, a, i, o) {
                        function n() {
                            o && o()
                        }

                        var r;
                        t.complete && i ? n() : e ? (r = new window.Image, r.onload = n, r.onerror = n, a && (r.srcset = a), e && (r.src = e)) : n()
                    }, y.preloadImages = function () {
                        function t() {
                            void 0 !== y && null !== y && (void 0 !== y.imagesLoaded && y.imagesLoaded++, y.imagesLoaded === y.imagesToLoad.length && (y.params.updateOnImagesReady && y.update(), y.emit("onImagesReady", y)))
                        }

                        y.imagesToLoad = y.container.find("img");
                        for (var e = 0; e < y.imagesToLoad.length; e++) y.loadImage(y.imagesToLoad[e], y.imagesToLoad[e].currentSrc || y.imagesToLoad[e].getAttribute("src"), y.imagesToLoad[e].srcset || y.imagesToLoad[e].getAttribute("srcset"), !0, t)
                    }, y.autoplayTimeoutId = void 0, y.autoplaying = !1, y.autoplayPaused = !1, y.startAutoplay = function () {
                        return void 0 === y.autoplayTimeoutId && (!!y.params.autoplay && (!y.autoplaying && (y.autoplaying = !0, y.emit("onAutoplayStart", y), void n())))
                    }, y.stopAutoplay = function (t) {
                        y.autoplayTimeoutId && (y.autoplayTimeoutId && clearTimeout(y.autoplayTimeoutId), y.autoplaying = !1, y.autoplayTimeoutId = void 0, y.emit("onAutoplayStop", y))
                    }, y.pauseAutoplay = function (t) {
                        y.autoplayPaused || (y.autoplayTimeoutId && clearTimeout(y.autoplayTimeoutId), y.autoplayPaused = !0, 0 === t ? (y.autoplayPaused = !1, n()) : y.wrapper.transitionEnd(function () {
                            y && (y.autoplayPaused = !1, y.autoplaying ? n() : y.stopAutoplay())
                        }))
                    }, y.minTranslate = function () {
                        return -y.snapGrid[0]
                    }, y.maxTranslate = function () {
                        return -y.snapGrid[y.snapGrid.length - 1]
                    }, y.updateAutoHeight = function () {
                        var t = y.slides.eq(y.activeIndex)[0];
                        if (void 0 !== t) {
                            var e = t.offsetHeight;
                            e && y.wrapper.css("height", e + "px")
                        }
                    }, y.updateContainerSize = function () {
                        var t, e;
                        t = void 0 !== y.params.width ? y.params.width : y.container[0].clientWidth, e = void 0 !== y.params.height ? y.params.height : y.container[0].clientHeight, 0 === t && y.isHorizontal() || 0 === e && !y.isHorizontal() || (t = t - parseInt(y.container.css("padding-left"), 10) - parseInt(y.container.css("padding-right"), 10), e = e - parseInt(y.container.css("padding-top"), 10) - parseInt(y.container.css("padding-bottom"), 10), y.width = t, y.height = e, y.size = y.isHorizontal() ? y.width : y.height)
                    }, y.updateSlidesSize = function () {
                        y.slides = y.wrapper.children("." + y.params.slideClass), y.snapGrid = [], y.slidesGrid = [], y.slidesSizesGrid = [];
                        var t, e = y.params.spaceBetween, a = -y.params.slidesOffsetBefore, i = 0, n = 0;
                        if (void 0 !== y.size) {
                            "string" == typeof e && e.indexOf("%") >= 0 && (e = parseFloat(e.replace("%", "")) / 100 * y.size), y.virtualSize = -e, y.rtl ? y.slides.css({
                                marginLeft: "",
                                marginTop: ""
                            }) : y.slides.css({marginRight: "", marginBottom: ""});
                            var r;
                            y.params.slidesPerColumn > 1 && (r = Math.floor(y.slides.length / y.params.slidesPerColumn) === y.slides.length / y.params.slidesPerColumn ? y.slides.length : Math.ceil(y.slides.length / y.params.slidesPerColumn) * y.params.slidesPerColumn, "auto" !== y.params.slidesPerView && "row" === y.params.slidesPerColumnFill && (r = Math.max(r, y.params.slidesPerView * y.params.slidesPerColumn)));
                            var s, l = y.params.slidesPerColumn, d = r / l,
                                c = d - (y.params.slidesPerColumn * d - y.slides.length);
                            for (t = 0; t < y.slides.length; t++) {
                                s = 0;
                                var p = y.slides.eq(t);
                                if (y.params.slidesPerColumn > 1) {
                                    var u, h, f;
                                    "column" === y.params.slidesPerColumnFill ? (h = Math.floor(t / l), f = t - h * l, (h > c || h === c && f === l - 1) && ++f >= l && (f = 0, h++), u = h + f * r / l, p.css({
                                        "-webkit-box-ordinal-group": u,
                                        "-moz-box-ordinal-group": u,
                                        "-ms-flex-order": u,
                                        "-webkit-order": u,
                                        order: u
                                    })) : (f = Math.floor(t / d), h = t - f * d), p.css({"margin-top": 0 !== f && y.params.spaceBetween && y.params.spaceBetween + "px"}).attr("data-swiper-column", h).attr("data-swiper-row", f)
                                }
                                "none" !== p.css("display") && ("auto" === y.params.slidesPerView ? (s = y.isHorizontal() ? p.outerWidth(!0) : p.outerHeight(!0), y.params.roundLengths && (s = o(s))) : (s = (y.size - (y.params.slidesPerView - 1) * e) / y.params.slidesPerView, y.params.roundLengths && (s = o(s)), y.isHorizontal() ? y.slides[t].style.width = s + "px" : y.slides[t].style.height = s + "px"), y.slides[t].swiperSlideSize = s, y.slidesSizesGrid.push(s), y.params.centeredSlides ? (a = a + s / 2 + i / 2 + e, 0 === t && (a = a - y.size / 2 - e), Math.abs(a) < .001 && (a = 0), n % y.params.slidesPerGroup == 0 && y.snapGrid.push(a), y.slidesGrid.push(a)) : (n % y.params.slidesPerGroup == 0 && y.snapGrid.push(a), y.slidesGrid.push(a), a = a + s + e), y.virtualSize += s + e, i = s, n++)
                            }
                            y.virtualSize = Math.max(y.virtualSize, y.size) + y.params.slidesOffsetAfter;
                            var m;
                            if (y.rtl && y.wrongRTL && ("slide" === y.params.effect || "coverflow" === y.params.effect) && y.wrapper.css({width: y.virtualSize + y.params.spaceBetween + "px"}), y.support.flexbox && !y.params.setWrapperSize || (y.isHorizontal() ? y.wrapper.css({width: y.virtualSize + y.params.spaceBetween + "px"}) : y.wrapper.css({height: y.virtualSize + y.params.spaceBetween + "px"})), y.params.slidesPerColumn > 1 && (y.virtualSize = (s + y.params.spaceBetween) * r, y.virtualSize = Math.ceil(y.virtualSize / y.params.slidesPerColumn) - y.params.spaceBetween, y.wrapper.css({width: y.virtualSize + y.params.spaceBetween + "px"}), y.params.centeredSlides)) {
                                for (m = [], t = 0; t < y.snapGrid.length; t++) y.snapGrid[t] < y.virtualSize + y.snapGrid[0] && m.push(y.snapGrid[t]);
                                y.snapGrid = m
                            }
                            if (!y.params.centeredSlides) {
                                for (m = [], t = 0; t < y.snapGrid.length; t++) y.snapGrid[t] <= y.virtualSize - y.size && m.push(y.snapGrid[t]);
                                y.snapGrid = m, Math.floor(y.virtualSize - y.size) - Math.floor(y.snapGrid[y.snapGrid.length - 1]) > 1 && y.snapGrid.push(y.virtualSize - y.size)
                            }
                            0 === y.snapGrid.length && (y.snapGrid = [0]), 0 !== y.params.spaceBetween && (y.isHorizontal() ? y.rtl ? y.slides.css({marginLeft: e + "px"}) : y.slides.css({marginRight: e + "px"}) : y.slides.css({marginBottom: e + "px"})), y.params.watchSlidesProgress && y.updateSlidesOffset()
                        }
                    }, y.updateSlidesOffset = function () {
                        for (var t = 0; t < y.slides.length; t++) y.slides[t].swiperSlideOffset = y.isHorizontal() ? y.slides[t].offsetLeft : y.slides[t].offsetTop
                    }, y.updateSlidesProgress = function (t) {
                        if (void 0 === t && (t = y.translate || 0), 0 !== y.slides.length) {
                            void 0 === y.slides[0].swiperSlideOffset && y.updateSlidesOffset();
                            var e = -t;
                            y.rtl && (e = t), y.slides.removeClass(y.params.slideVisibleClass);
                            for (var a = 0; a < y.slides.length; a++) {
                                var i = y.slides[a],
                                    o = (e - i.swiperSlideOffset) / (i.swiperSlideSize + y.params.spaceBetween);
                                if (y.params.watchSlidesVisibility) {
                                    var n = -(e - i.swiperSlideOffset), r = n + y.slidesSizesGrid[a];
                                    (n >= 0 && n < y.size || r > 0 && r <= y.size || n <= 0 && r >= y.size) && y.slides.eq(a).addClass(y.params.slideVisibleClass)
                                }
                                i.progress = y.rtl ? -o : o
                            }
                        }
                    }, y.updateProgress = function (t) {
                        void 0 === t && (t = y.translate || 0);
                        var e = y.maxTranslate() - y.minTranslate(), a = y.isBeginning, i = y.isEnd;
                        0 === e ? (y.progress = 0, y.isBeginning = y.isEnd = !0) : (y.progress = (t - y.minTranslate()) / e, y.isBeginning = y.progress <= 0, y.isEnd = y.progress >= 1), y.isBeginning && !a && y.emit("onReachBeginning", y), y.isEnd && !i && y.emit("onReachEnd", y), y.params.watchSlidesProgress && y.updateSlidesProgress(t), y.emit("onProgress", y, y.progress)
                    }, y.updateActiveIndex = function () {
                        var t, e, a, i = y.rtl ? y.translate : -y.translate;
                        for (e = 0; e < y.slidesGrid.length; e++) void 0 !== y.slidesGrid[e + 1] ? i >= y.slidesGrid[e] && i < y.slidesGrid[e + 1] - (y.slidesGrid[e + 1] - y.slidesGrid[e]) / 2 ? t = e : i >= y.slidesGrid[e] && i < y.slidesGrid[e + 1] && (t = e + 1) : i >= y.slidesGrid[e] && (t = e);
                        (t < 0 || void 0 === t) && (t = 0), a = Math.floor(t / y.params.slidesPerGroup), a >= y.snapGrid.length && (a = y.snapGrid.length - 1), t !== y.activeIndex && (y.snapIndex = a, y.previousIndex = y.activeIndex, y.activeIndex = t, y.updateClasses())
                    }, y.updateClasses = function () {
                        y.slides.removeClass(y.params.slideActiveClass + " " + y.params.slideNextClass + " " + y.params.slidePrevClass);
                        var e = y.slides.eq(y.activeIndex);
                        e.addClass(y.params.slideActiveClass);
                        var a = e.next("." + y.params.slideClass).addClass(y.params.slideNextClass);
                        y.params.loop && 0 === a.length && y.slides.eq(0).addClass(y.params.slideNextClass);
                        var i = e.prev("." + y.params.slideClass).addClass(y.params.slidePrevClass);
                        if (y.params.loop && 0 === i.length && y.slides.eq(-1).addClass(y.params.slidePrevClass), y.paginationContainer && y.paginationContainer.length > 0) {
                            var o,
                                n = y.params.loop ? Math.ceil((y.slides.length - 2 * y.loopedSlides) / y.params.slidesPerGroup) : y.snapGrid.length;
                            if (y.params.loop ? (o = Math.ceil((y.activeIndex - y.loopedSlides) / y.params.slidesPerGroup), o > y.slides.length - 1 - 2 * y.loopedSlides && (o -= y.slides.length - 2 * y.loopedSlides), o > n - 1 && (o -= n), o < 0 && "bullets" !== y.params.paginationType && (o = n + o)) : o = void 0 !== y.snapIndex ? y.snapIndex : y.activeIndex || 0, "bullets" === y.params.paginationType && y.bullets && y.bullets.length > 0 && (y.bullets.removeClass(y.params.bulletActiveClass), y.paginationContainer.length > 1 ? y.bullets.each(function () {
                                t(this).index() === o && t(this).addClass(y.params.bulletActiveClass)
                            }) : y.bullets.eq(o).addClass(y.params.bulletActiveClass)), "fraction" === y.params.paginationType && (y.paginationContainer.find("." + y.params.paginationCurrentClass).text(o + 1), y.paginationContainer.find("." + y.params.paginationTotalClass).text(n)), "progress" === y.params.paginationType) {
                                var r = (o + 1) / n, s = r, l = 1;
                                y.isHorizontal() || (l = r, s = 1), y.paginationContainer.find("." + y.params.paginationProgressbarClass).transform("translate3d(0,0,0) scaleX(" + s + ") scaleY(" + l + ")").transition(y.params.speed)
                            }
                            "custom" === y.params.paginationType && y.params.paginationCustomRender && (y.paginationContainer.html(y.params.paginationCustomRender(y, o + 1, n)), y.emit("onPaginationRendered", y, y.paginationContainer[0]))
                        }
                        y.params.loop || (y.params.prevButton && y.prevButton && y.prevButton.length > 0 && (y.isBeginning ? (y.prevButton.addClass(y.params.buttonDisabledClass), y.params.a11y && y.a11y && y.a11y.disable(y.prevButton)) : (y.prevButton.removeClass(y.params.buttonDisabledClass), y.params.a11y && y.a11y && y.a11y.enable(y.prevButton))), y.params.nextButton && y.nextButton && y.nextButton.length > 0 && (y.isEnd ? (y.nextButton.addClass(y.params.buttonDisabledClass), y.params.a11y && y.a11y && y.a11y.disable(y.nextButton)) : (y.nextButton.removeClass(y.params.buttonDisabledClass), y.params.a11y && y.a11y && y.a11y.enable(y.nextButton))))
                    }, y.updatePagination = function () {
                        if (y.params.pagination && y.paginationContainer && y.paginationContainer.length > 0) {
                            var t = "";
                            if ("bullets" === y.params.paginationType) {
                                for (var e = y.params.loop ? Math.ceil((y.slides.length - 2 * y.loopedSlides) / y.params.slidesPerGroup) : y.snapGrid.length, a = 0; a < e; a++) y.params.paginationBulletRender ? t += y.params.paginationBulletRender(a, y.params.bulletClass) : t += "<" + y.params.paginationElement + ' class="' + y.params.bulletClass + '"></' + y.params.paginationElement + ">";
                                y.paginationContainer.html(t), y.bullets = y.paginationContainer.find("." + y.params.bulletClass), y.params.paginationClickable && y.params.a11y && y.a11y && y.a11y.initPagination()
                            }
                            "fraction" === y.params.paginationType && (t = y.params.paginationFractionRender ? y.params.paginationFractionRender(y, y.params.paginationCurrentClass, y.params.paginationTotalClass) : '<span class="' + y.params.paginationCurrentClass + '"></span> / <span class="' + y.params.paginationTotalClass + '"></span>', y.paginationContainer.html(t)), "progress" === y.params.paginationType && (t = y.params.paginationProgressRender ? y.params.paginationProgressRender(y, y.params.paginationProgressbarClass) : '<span class="' + y.params.paginationProgressbarClass + '"></span>', y.paginationContainer.html(t)), "custom" !== y.params.paginationType && y.emit("onPaginationRendered", y, y.paginationContainer[0])
                        }
                    }, y.update = function (t) {
                        function e() {
                            a = Math.min(Math.max(y.translate, y.maxTranslate()), y.minTranslate()), y.setWrapperTranslate(a), y.updateActiveIndex(), y.updateClasses()
                        }

                        if (y.updateContainerSize(), y.updateSlidesSize(), y.updateProgress(), y.updatePagination(), y.updateClasses(), y.params.scrollbar && y.scrollbar && y.scrollbar.set(), t) {
                            var a;
                            y.controller && y.controller.spline && (y.controller.spline = void 0), y.params.freeMode ? (e(), y.params.autoHeight && y.updateAutoHeight()) : (("auto" === y.params.slidesPerView || y.params.slidesPerView > 1) && y.isEnd && !y.params.centeredSlides ? y.slideTo(y.slides.length - 1, 0, !1, !0) : y.slideTo(y.activeIndex, 0, !1, !0)) || e()
                        } else y.params.autoHeight && y.updateAutoHeight()
                    }, y.onResize = function (t) {
                        y.params.breakpoints && y.setBreakpoint();
                        var e = y.params.allowSwipeToPrev, a = y.params.allowSwipeToNext;
                        y.params.allowSwipeToPrev = y.params.allowSwipeToNext = !0, y.updateContainerSize(), y.updateSlidesSize(), ("auto" === y.params.slidesPerView || y.params.freeMode || t) && y.updatePagination(), y.params.scrollbar && y.scrollbar && y.scrollbar.set(), y.controller && y.controller.spline && (y.controller.spline = void 0);
                        var i = !1;
                        if (y.params.freeMode) {
                            var o = Math.min(Math.max(y.translate, y.maxTranslate()), y.minTranslate());
                            y.setWrapperTranslate(o), y.updateActiveIndex(), y.updateClasses(), y.params.autoHeight && y.updateAutoHeight()
                        } else y.updateClasses(), i = ("auto" === y.params.slidesPerView || y.params.slidesPerView > 1) && y.isEnd && !y.params.centeredSlides ? y.slideTo(y.slides.length - 1, 0, !1, !0) : y.slideTo(y.activeIndex, 0, !1, !0);
                        y.params.lazyLoading && !i && y.lazy && y.lazy.load(), y.params.allowSwipeToPrev = e, y.params.allowSwipeToNext = a
                    };
                    var x = ["mousedown", "mousemove", "mouseup"];
                    window.navigator.pointerEnabled ? x = ["pointerdown", "pointermove", "pointerup"] : window.navigator.msPointerEnabled && (x = ["MSPointerDown", "MSPointerMove", "MSPointerUp"]), y.touchEvents = {
                        start: y.support.touch || !y.params.simulateTouch ? "touchstart" : x[0],
                        move: y.support.touch || !y.params.simulateTouch ? "touchmove" : x[1],
                        end: y.support.touch || !y.params.simulateTouch ? "touchend" : x[2]
                    }, (window.navigator.pointerEnabled || window.navigator.msPointerEnabled) && ("container" === y.params.touchEventsTarget ? y.container : y.wrapper).addClass("swiper-wp8-" + y.params.direction), y.initEvents = function (t) {
                        var e = t ? "off" : "on", a = t ? "removeEventListener" : "addEventListener",
                            o = "container" === y.params.touchEventsTarget ? y.container[0] : y.wrapper[0],
                            n = y.support.touch ? o : document, r = !!y.params.nested;
                        y.browser.ie ? (o[a](y.touchEvents.start, y.onTouchStart, !1), n[a](y.touchEvents.move, y.onTouchMove, r), n[a](y.touchEvents.end, y.onTouchEnd, !1)) : (y.support.touch && (o[a](y.touchEvents.start, y.onTouchStart, !1), o[a](y.touchEvents.move, y.onTouchMove, r), o[a](y.touchEvents.end, y.onTouchEnd, !1)), !i.simulateTouch || y.device.ios || y.device.android || (o[a]("mousedown", y.onTouchStart, !1), document[a]("mousemove", y.onTouchMove, r), document[a]("mouseup", y.onTouchEnd, !1))), window[a]("resize", y.onResize), y.params.nextButton && y.nextButton && y.nextButton.length > 0 && (y.nextButton[e]("click", y.onClickNext), y.params.a11y && y.a11y && y.nextButton[e]("keydown", y.a11y.onEnterKey)), y.params.prevButton && y.prevButton && y.prevButton.length > 0 && (y.prevButton[e]("click", y.onClickPrev), y.params.a11y && y.a11y && y.prevButton[e]("keydown", y.a11y.onEnterKey)), y.params.pagination && y.params.paginationClickable && (y.paginationContainer[e]("click", "." + y.params.bulletClass, y.onClickIndex), y.params.a11y && y.a11y && y.paginationContainer[e]("keydown", "." + y.params.bulletClass, y.a11y.onEnterKey)), (y.params.preventClicks || y.params.preventClicksPropagation) && o[a]("click", y.preventClicks, !0)
                    }, y.attachEvents = function () {
                        y.initEvents()
                    }, y.detachEvents = function () {
                        y.initEvents(!0)
                    }, y.allowClick = !0, y.preventClicks = function (t) {
                        y.allowClick || (y.params.preventClicks && t.preventDefault(), y.params.preventClicksPropagation && y.animating && (t.stopPropagation(), t.stopImmediatePropagation()))
                    }, y.onClickNext = function (t) {
                        t.preventDefault(), y.isEnd && !y.params.loop || y.slideNext()
                    }, y.onClickPrev = function (t) {
                        t.preventDefault(), y.isBeginning && !y.params.loop || y.slidePrev()
                    }, y.onClickIndex = function (e) {
                        e.preventDefault();
                        var a = t(this).index() * y.params.slidesPerGroup;
                        y.params.loop && (a += y.loopedSlides), y.slideTo(a)
                    }, y.updateClickedSlide = function (e) {
                        var a = r(e, "." + y.params.slideClass), i = !1;
                        if (a) for (var o = 0; o < y.slides.length; o++) y.slides[o] === a && (i = !0);
                        if (!a || !i) return y.clickedSlide = void 0, void(y.clickedIndex = void 0);
                        if (y.clickedSlide = a, y.clickedIndex = t(a).index(), y.params.slideToClickedSlide && void 0 !== y.clickedIndex && y.clickedIndex !== y.activeIndex) {
                            var n, s = y.clickedIndex;
                            if (y.params.loop) {
                                if (y.animating) return;
                                n = t(y.clickedSlide).attr("data-swiper-slide-index"), y.params.centeredSlides ? s < y.loopedSlides - y.params.slidesPerView / 2 || s > y.slides.length - y.loopedSlides + y.params.slidesPerView / 2 ? (y.fixLoop(), s = y.wrapper.children("." + y.params.slideClass + '[data-swiper-slide-index="' + n + '"]:not(.swiper-slide-duplicate)').eq(0).index(), setTimeout(function () {
                                    y.slideTo(s)
                                }, 0)) : y.slideTo(s) : s > y.slides.length - y.params.slidesPerView ? (y.fixLoop(), s = y.wrapper.children("." + y.params.slideClass + '[data-swiper-slide-index="' + n + '"]:not(.swiper-slide-duplicate)').eq(0).index(), setTimeout(function () {
                                    y.slideTo(s)
                                }, 0)) : y.slideTo(s)
                            } else y.slideTo(s)
                        }
                    };
                    var T, C, S, k, E, P, I, _, D, A, N = "input, select, textarea, button", M = Date.now(), B = [];
                    y.animating = !1, y.touches = {startX: 0, startY: 0, currentX: 0, currentY: 0, diff: 0};
                    var z, O;
                    if (y.onTouchStart = function (e) {
                        if (e.originalEvent && (e = e.originalEvent), (z = "touchstart" === e.type) || !("which" in e) || 3 !== e.which) {
                            if (y.params.noSwiping && r(e, "." + y.params.noSwipingClass)) return void(y.allowClick = !0);
                            if (!y.params.swipeHandler || r(e, y.params.swipeHandler)) {
                                var a = y.touches.currentX = "touchstart" === e.type ? e.targetTouches[0].pageX : e.pageX,
                                    i = y.touches.currentY = "touchstart" === e.type ? e.targetTouches[0].pageY : e.pageY;
                                if (!(y.device.ios && y.params.iOSEdgeSwipeDetection && a <= y.params.iOSEdgeSwipeThreshold)) {
                                    if (T = !0, C = !1, S = !0, E = void 0, O = void 0, y.touches.startX = a, y.touches.startY = i, k = Date.now(), y.allowClick = !0, y.updateContainerSize(), y.swipeDirection = void 0, y.params.threshold > 0 && (_ = !1), "touchstart" !== e.type) {
                                        var o = !0;
                                        t(e.target).is(N) && (o = !1), document.activeElement && t(document.activeElement).is(N) && document.activeElement.blur(), o && e.preventDefault()
                                    }
                                    y.emit("onTouchStart", y, e)
                                }
                            }
                        }
                    }, y.onTouchMove = function (e) {
                        if (e.originalEvent && (e = e.originalEvent), !z || "mousemove" !== e.type) {
                            if (e.preventedByNestedSwiper) return y.touches.startX = "touchmove" === e.type ? e.targetTouches[0].pageX : e.pageX, void(y.touches.startY = "touchmove" === e.type ? e.targetTouches[0].pageY : e.pageY);
                            if (y.params.onlyExternal) return y.allowClick = !1, void(T && (y.touches.startX = y.touches.currentX = "touchmove" === e.type ? e.targetTouches[0].pageX : e.pageX, y.touches.startY = y.touches.currentY = "touchmove" === e.type ? e.targetTouches[0].pageY : e.pageY, k = Date.now()));
                            if (z && document.activeElement && e.target === document.activeElement && t(e.target).is(N)) return C = !0, void(y.allowClick = !1);
                            if (S && y.emit("onTouchMove", y, e), !(e.targetTouches && e.targetTouches.length > 1)) {
                                if (y.touches.currentX = "touchmove" === e.type ? e.targetTouches[0].pageX : e.pageX, y.touches.currentY = "touchmove" === e.type ? e.targetTouches[0].pageY : e.pageY, void 0 === E) {
                                    var a = 180 * Math.atan2(Math.abs(y.touches.currentY - y.touches.startY), Math.abs(y.touches.currentX - y.touches.startX)) / Math.PI;
                                    E = y.isHorizontal() ? a > y.params.touchAngle : 90 - a > y.params.touchAngle
                                }
                                if (E && y.emit("onTouchMoveOpposite", y, e), void 0 === O && y.browser.ieTouch && (y.touches.currentX === y.touches.startX && y.touches.currentY === y.touches.startY || (O = !0)), T) {
                                    if (E) return void(T = !1);
                                    if (O || !y.browser.ieTouch) {
                                        y.allowClick = !1, y.emit("onSliderMove", y, e), e.preventDefault(), y.params.touchMoveStopPropagation && !y.params.nested && e.stopPropagation(), C || (i.loop && y.fixLoop(), I = y.getWrapperTranslate(), y.setWrapperTransition(0), y.animating && y.wrapper.trigger("webkitTransitionEnd transitionend oTransitionEnd MSTransitionEnd msTransitionEnd"), y.params.autoplay && y.autoplaying && (y.params.autoplayDisableOnInteraction ? y.stopAutoplay() : y.pauseAutoplay()), A = !1, y.params.grabCursor && (y.container[0].style.cursor = "move", y.container[0].style.cursor = "-webkit-grabbing", y.container[0].style.cursor = "-moz-grabbin", y.container[0].style.cursor = "grabbing")), C = !0;
                                        var o = y.touches.diff = y.isHorizontal() ? y.touches.currentX - y.touches.startX : y.touches.currentY - y.touches.startY;
                                        o *= y.params.touchRatio, y.rtl && (o = -o), y.swipeDirection = o > 0 ? "prev" : "next", P = o + I;
                                        var n = !0;
                                        if (o > 0 && P > y.minTranslate() ? (n = !1, y.params.resistance && (P = y.minTranslate() - 1 + Math.pow(-y.minTranslate() + I + o, y.params.resistanceRatio))) : o < 0 && P < y.maxTranslate() && (n = !1, y.params.resistance && (P = y.maxTranslate() + 1 - Math.pow(y.maxTranslate() - I - o, y.params.resistanceRatio))), n && (e.preventedByNestedSwiper = !0), !y.params.allowSwipeToNext && "next" === y.swipeDirection && P < I && (P = I), !y.params.allowSwipeToPrev && "prev" === y.swipeDirection && P > I && (P = I), y.params.followFinger) {
                                            if (y.params.threshold > 0) {
                                                if (!(Math.abs(o) > y.params.threshold || _)) return void(P = I);
                                                if (!_) return _ = !0,
                                                    y.touches.startX = y.touches.currentX, y.touches.startY = y.touches.currentY, P = I, void(y.touches.diff = y.isHorizontal() ? y.touches.currentX - y.touches.startX : y.touches.currentY - y.touches.startY)
                                            }
                                            (y.params.freeMode || y.params.watchSlidesProgress) && y.updateActiveIndex(), y.params.freeMode && (0 === B.length && B.push({
                                                position: y.touches[y.isHorizontal() ? "startX" : "startY"],
                                                time: k
                                            }), B.push({
                                                position: y.touches[y.isHorizontal() ? "currentX" : "currentY"],
                                                time: (new window.Date).getTime()
                                            })), y.updateProgress(P), y.setWrapperTranslate(P)
                                        }
                                    }
                                }
                            }
                        }
                    }, y.onTouchEnd = function (e) {
                        if (e.originalEvent && (e = e.originalEvent), S && y.emit("onTouchEnd", y, e), S = !1, T) {
                            y.params.grabCursor && C && T && (y.container[0].style.cursor = "move", y.container[0].style.cursor = "-webkit-grab", y.container[0].style.cursor = "-moz-grab", y.container[0].style.cursor = "grab");
                            var a = Date.now(), i = a - k;
                            if (y.allowClick && (y.updateClickedSlide(e), y.emit("onTap", y, e), i < 300 && a - M > 300 && (D && clearTimeout(D), D = setTimeout(function () {
                                y && (y.params.paginationHide && y.paginationContainer.length > 0 && !t(e.target).hasClass(y.params.bulletClass) && y.paginationContainer.toggleClass(y.params.paginationHiddenClass), y.emit("onClick", y, e))
                            }, 300)), i < 300 && a - M < 300 && (D && clearTimeout(D), y.emit("onDoubleTap", y, e))), M = Date.now(), setTimeout(function () {
                                y && (y.allowClick = !0)
                            }, 0), !T || !C || !y.swipeDirection || 0 === y.touches.diff || P === I) return void(T = C = !1);
                            T = C = !1;
                            var o;
                            if (o = y.params.followFinger ? y.rtl ? y.translate : -y.translate : -P, y.params.freeMode) {
                                if (o < -y.minTranslate()) return void y.slideTo(y.activeIndex);
                                if (o > -y.maxTranslate()) return void(y.slides.length < y.snapGrid.length ? y.slideTo(y.snapGrid.length - 1) : y.slideTo(y.slides.length - 1));
                                if (y.params.freeModeMomentum) {
                                    if (B.length > 1) {
                                        var n = B.pop(), r = B.pop(), s = n.position - r.position, l = n.time - r.time;
                                        y.velocity = s / l, y.velocity = y.velocity / 2, Math.abs(y.velocity) < y.params.freeModeMinimumVelocity && (y.velocity = 0), (l > 150 || (new window.Date).getTime() - n.time > 300) && (y.velocity = 0)
                                    } else y.velocity = 0;
                                    B.length = 0;
                                    var d = 1e3 * y.params.freeModeMomentumRatio, c = y.velocity * d,
                                        p = y.translate + c;
                                    y.rtl && (p = -p);
                                    var u, h = !1, f = 20 * Math.abs(y.velocity) * y.params.freeModeMomentumBounceRatio;
                                    if (p < y.maxTranslate()) y.params.freeModeMomentumBounce ? (p + y.maxTranslate() < -f && (p = y.maxTranslate() - f), u = y.maxTranslate(), h = !0, A = !0) : p = y.maxTranslate(); else if (p > y.minTranslate()) y.params.freeModeMomentumBounce ? (p - y.minTranslate() > f && (p = y.minTranslate() + f), u = y.minTranslate(), h = !0, A = !0) : p = y.minTranslate(); else if (y.params.freeModeSticky) {
                                        var m, g = 0;
                                        for (g = 0; g < y.snapGrid.length; g += 1) if (y.snapGrid[g] > -p) {
                                            m = g;
                                            break
                                        }
                                        p = Math.abs(y.snapGrid[m] - p) < Math.abs(y.snapGrid[m - 1] - p) || "next" === y.swipeDirection ? y.snapGrid[m] : y.snapGrid[m - 1], y.rtl || (p = -p)
                                    }
                                    if (0 !== y.velocity) d = y.rtl ? Math.abs((-p - y.translate) / y.velocity) : Math.abs((p - y.translate) / y.velocity); else if (y.params.freeModeSticky) return void y.slideReset();
                                    y.params.freeModeMomentumBounce && h ? (y.updateProgress(u), y.setWrapperTransition(d), y.setWrapperTranslate(p), y.onTransitionStart(), y.animating = !0, y.wrapper.transitionEnd(function () {
                                        y && A && (y.emit("onMomentumBounce", y), y.setWrapperTransition(y.params.speed), y.setWrapperTranslate(u), y.wrapper.transitionEnd(function () {
                                            y && y.onTransitionEnd()
                                        }))
                                    })) : y.velocity ? (y.updateProgress(p), y.setWrapperTransition(d), y.setWrapperTranslate(p), y.onTransitionStart(), y.animating || (y.animating = !0, y.wrapper.transitionEnd(function () {
                                        y && y.onTransitionEnd()
                                    }))) : y.updateProgress(p), y.updateActiveIndex()
                                }
                                return void((!y.params.freeModeMomentum || i >= y.params.longSwipesMs) && (y.updateProgress(), y.updateActiveIndex()))
                            }
                            var v, w = 0, b = y.slidesSizesGrid[0];
                            for (v = 0; v < y.slidesGrid.length; v += y.params.slidesPerGroup) void 0 !== y.slidesGrid[v + y.params.slidesPerGroup] ? o >= y.slidesGrid[v] && o < y.slidesGrid[v + y.params.slidesPerGroup] && (w = v, b = y.slidesGrid[v + y.params.slidesPerGroup] - y.slidesGrid[v]) : o >= y.slidesGrid[v] && (w = v, b = y.slidesGrid[y.slidesGrid.length - 1] - y.slidesGrid[y.slidesGrid.length - 2]);
                            var x = (o - y.slidesGrid[w]) / b;
                            if (i > y.params.longSwipesMs) {
                                if (!y.params.longSwipes) return void y.slideTo(y.activeIndex);
                                "next" === y.swipeDirection && (x >= y.params.longSwipesRatio ? y.slideTo(w + y.params.slidesPerGroup) : y.slideTo(w)), "prev" === y.swipeDirection && (x > 1 - y.params.longSwipesRatio ? y.slideTo(w + y.params.slidesPerGroup) : y.slideTo(w))
                            } else {
                                if (!y.params.shortSwipes) return void y.slideTo(y.activeIndex);
                                "next" === y.swipeDirection && y.slideTo(w + y.params.slidesPerGroup), "prev" === y.swipeDirection && y.slideTo(w)
                            }
                        }
                    }, y._slideTo = function (t, e) {
                        return y.slideTo(t, e, !0, !0)
                    }, y.slideTo = function (t, e, a, i) {
                        void 0 === a && (a = !0), void 0 === t && (t = 0), t < 0 && (t = 0), y.snapIndex = Math.floor(t / y.params.slidesPerGroup), y.snapIndex >= y.snapGrid.length && (y.snapIndex = y.snapGrid.length - 1);
                        var o = -y.snapGrid[y.snapIndex];
                        y.params.autoplay && y.autoplaying && (i || !y.params.autoplayDisableOnInteraction ? y.pauseAutoplay(e) : y.stopAutoplay()), y.updateProgress(o);
                        for (var n = 0; n < y.slidesGrid.length; n++) -Math.floor(100 * o) >= Math.floor(100 * y.slidesGrid[n]) && (t = n);
                        return !(!y.params.allowSwipeToNext && o < y.translate && o < y.minTranslate()) && (!(!y.params.allowSwipeToPrev && o > y.translate && o > y.maxTranslate() && (y.activeIndex || 0) !== t) && (void 0 === e && (e = y.params.speed), y.previousIndex = y.activeIndex || 0, y.activeIndex = t, y.rtl && -o === y.translate || !y.rtl && o === y.translate ? (y.params.autoHeight && y.updateAutoHeight(), y.updateClasses(), "slide" !== y.params.effect && y.setWrapperTranslate(o), !1) : (y.updateClasses(), y.onTransitionStart(a), 0 === e ? (y.setWrapperTranslate(o), y.setWrapperTransition(0), y.onTransitionEnd(a)) : (y.setWrapperTranslate(o), y.setWrapperTransition(e), y.animating || (y.animating = !0, y.wrapper.transitionEnd(function () {
                            y && y.onTransitionEnd(a)
                        }))), !0)))
                    }, y.onTransitionStart = function (t) {
                        void 0 === t && (t = !0), y.params.autoHeight && y.updateAutoHeight(), y.lazy && y.lazy.onTransitionStart(), t && (y.emit("onTransitionStart", y), y.activeIndex !== y.previousIndex && (y.emit("onSlideChangeStart", y), y.activeIndex > y.previousIndex ? y.emit("onSlideNextStart", y) : y.emit("onSlidePrevStart", y)))
                    }, y.onTransitionEnd = function (t) {
                        y.animating = !1, y.setWrapperTransition(0), void 0 === t && (t = !0), y.lazy && y.lazy.onTransitionEnd(), t && (y.emit("onTransitionEnd", y), y.activeIndex !== y.previousIndex && (y.emit("onSlideChangeEnd", y), y.activeIndex > y.previousIndex ? y.emit("onSlideNextEnd", y) : y.emit("onSlidePrevEnd", y))), y.params.hashnav && y.hashnav && y.hashnav.setHash()
                    }, y.slideNext = function (t, e, a) {
                        if (y.params.loop) {
                            if (y.animating) return !1;
                            y.fixLoop();
                            y.container[0].clientLeft;
                            return y.slideTo(y.activeIndex + y.params.slidesPerGroup, e, t, a)
                        }
                        return y.slideTo(y.activeIndex + y.params.slidesPerGroup, e, t, a)
                    }, y._slideNext = function (t) {
                        return y.slideNext(!0, t, !0)
                    }, y.slidePrev = function (t, e, a) {
                        if (y.params.loop) {
                            if (y.animating) return !1;
                            y.fixLoop();
                            y.container[0].clientLeft;
                            return y.slideTo(y.activeIndex - 1, e, t, a)
                        }
                        return y.slideTo(y.activeIndex - 1, e, t, a)
                    }, y._slidePrev = function (t) {
                        return y.slidePrev(!0, t, !0)
                    }, y.slideReset = function (t, e, a) {
                        return y.slideTo(y.activeIndex, e, t)
                    }, y.setWrapperTransition = function (t, e) {
                        y.wrapper.transition(t), "slide" !== y.params.effect && y.effects[y.params.effect] && y.effects[y.params.effect].setTransition(t), y.params.parallax && y.parallax && y.parallax.setTransition(t), y.params.scrollbar && y.scrollbar && y.scrollbar.setTransition(t), y.params.control && y.controller && y.controller.setTransition(t, e), y.emit("onSetTransition", y, t)
                    }, y.setWrapperTranslate = function (t, e, a) {
                        var i = 0, n = 0;
                        y.isHorizontal() ? i = y.rtl ? -t : t : n = t, y.params.roundLengths && (i = o(i), n = o(n)), y.params.virtualTranslate || (y.support.transforms3d ? y.wrapper.transform("translate3d(" + i + "px, " + n + "px, 0px)") : y.wrapper.transform("translate(" + i + "px, " + n + "px)")), y.translate = y.isHorizontal() ? i : n;
                        var r, s = y.maxTranslate() - y.minTranslate();
                        r = 0 === s ? 0 : (t - y.minTranslate()) / s, r !== y.progress && y.updateProgress(t), e && y.updateActiveIndex(), "slide" !== y.params.effect && y.effects[y.params.effect] && y.effects[y.params.effect].setTranslate(y.translate), y.params.parallax && y.parallax && y.parallax.setTranslate(y.translate), y.params.scrollbar && y.scrollbar && y.scrollbar.setTranslate(y.translate), y.params.control && y.controller && y.controller.setTranslate(y.translate, a), y.emit("onSetTranslate", y, y.translate)
                    }, y.getTranslate = function (t, e) {
                        var a, i, o, n;
                        return void 0 === e && (e = "x"), y.params.virtualTranslate ? y.rtl ? -y.translate : y.translate : (o = window.getComputedStyle(t, null), window.WebKitCSSMatrix ? (i = o.transform || o.webkitTransform, i.split(",").length > 6 && (i = i.split(", ").map(function (t) {
                            return t.replace(",", ".")
                        }).join(", ")), n = new window.WebKitCSSMatrix("none" === i ? "" : i)) : (n = o.MozTransform || o.OTransform || o.MsTransform || o.msTransform || o.transform || o.getPropertyValue("transform").replace("translate(", "matrix(1, 0, 0, 1,"), a = n.toString().split(",")), "x" === e && (i = window.WebKitCSSMatrix ? n.m41 : 16 === a.length ? parseFloat(a[12]) : parseFloat(a[4])), "y" === e && (i = window.WebKitCSSMatrix ? n.m42 : 16 === a.length ? parseFloat(a[13]) : parseFloat(a[5])), y.rtl && i && (i = -i), i || 0)
                    }, y.getWrapperTranslate = function (t) {
                        return void 0 === t && (t = y.isHorizontal() ? "x" : "y"), y.getTranslate(y.wrapper[0], t)
                    }, y.observers = [], y.initObservers = function () {
                        if (y.params.observeParents) for (var t = y.container.parents(), e = 0; e < t.length; e++) s(t[e]);
                        s(y.container[0], {childList: !1}), s(y.wrapper[0], {attributes: !1})
                    }, y.disconnectObservers = function () {
                        for (var t = 0; t < y.observers.length; t++) y.observers[t].disconnect();
                        y.observers = []
                    }, y.createLoop = function () {
                        y.wrapper.children("." + y.params.slideClass + "." + y.params.slideDuplicateClass).remove();
                        var e = y.wrapper.children("." + y.params.slideClass);
                        "auto" !== y.params.slidesPerView || y.params.loopedSlides || (y.params.loopedSlides = e.length), y.loopedSlides = parseInt(y.params.loopedSlides || y.params.slidesPerView, 10), y.loopedSlides = y.loopedSlides + y.params.loopAdditionalSlides, y.loopedSlides > e.length && (y.loopedSlides = e.length);
                        var a, i = [], o = [];
                        for (e.each(function (a, n) {
                            var r = t(this);
                            a < y.loopedSlides && o.push(n), a < e.length && a >= e.length - y.loopedSlides && i.push(n), r.attr("data-swiper-slide-index", a)
                        }), a = 0; a < o.length; a++) y.wrapper.append(t(o[a].cloneNode(!0)).addClass(y.params.slideDuplicateClass));
                        for (a = i.length - 1; a >= 0; a--) y.wrapper.prepend(t(i[a].cloneNode(!0)).addClass(y.params.slideDuplicateClass))
                    }, y.destroyLoop = function () {
                        y.wrapper.children("." + y.params.slideClass + "." + y.params.slideDuplicateClass).remove(), y.slides.removeAttr("data-swiper-slide-index")
                    }, y.reLoop = function (t) {
                        var e = y.activeIndex - y.loopedSlides;
                        y.destroyLoop(), y.createLoop(), y.updateSlidesSize(), t && y.slideTo(e + y.loopedSlides, 0, !1)
                    }, y.fixLoop = function () {
                        var t;
                        y.activeIndex < y.loopedSlides ? (t = y.slides.length - 3 * y.loopedSlides + y.activeIndex, t += y.loopedSlides, y.slideTo(t, 0, !1, !0)) : ("auto" === y.params.slidesPerView && y.activeIndex >= 2 * y.loopedSlides || y.activeIndex > y.slides.length - 2 * y.params.slidesPerView) && (t = -y.slides.length + y.activeIndex + y.loopedSlides, t += y.loopedSlides, y.slideTo(t, 0, !1, !0))
                    }, y.appendSlide = function (t) {
                        if (y.params.loop && y.destroyLoop(), "object" == typeof t && t.length) for (var e = 0; e < t.length; e++) t[e] && y.wrapper.append(t[e]); else y.wrapper.append(t);
                        y.params.loop && y.createLoop(), y.params.observer && y.support.observer || y.update(!0)
                    }, y.prependSlide = function (t) {
                        y.params.loop && y.destroyLoop();
                        var e = y.activeIndex + 1;
                        if ("object" == typeof t && t.length) {
                            for (var a = 0; a < t.length; a++) t[a] && y.wrapper.prepend(t[a]);
                            e = y.activeIndex + t.length
                        } else y.wrapper.prepend(t);
                        y.params.loop && y.createLoop(), y.params.observer && y.support.observer || y.update(!0), y.slideTo(e, 0, !1)
                    }, y.removeSlide = function (t) {
                        y.params.loop && (y.destroyLoop(), y.slides = y.wrapper.children("." + y.params.slideClass));
                        var e, a = y.activeIndex;
                        if ("object" == typeof t && t.length) {
                            for (var i = 0; i < t.length; i++) e = t[i], y.slides[e] && y.slides.eq(e).remove(), e < a && a--;
                            a = Math.max(a, 0)
                        } else e = t, y.slides[e] && y.slides.eq(e).remove(), e < a && a--, a = Math.max(a, 0);
                        y.params.loop && y.createLoop(), y.params.observer && y.support.observer || y.update(!0), y.params.loop ? y.slideTo(a + y.loopedSlides, 0, !1) : y.slideTo(a, 0, !1)
                    }, y.removeAllSlides = function () {
                        for (var t = [], e = 0; e < y.slides.length; e++) t.push(e);
                        y.removeSlide(t)
                    }, y.effects = {
                        fade: {
                            setTranslate: function () {
                                for (var t = 0; t < y.slides.length; t++) {
                                    var e = y.slides.eq(t), a = e[0].swiperSlideOffset, i = -a;
                                    y.params.virtualTranslate || (i -= y.translate);
                                    var o = 0;
                                    y.isHorizontal() || (o = i, i = 0);
                                    var n = y.params.fade.crossFade ? Math.max(1 - Math.abs(e[0].progress), 0) : 1 + Math.min(Math.max(e[0].progress, -1), 0);
                                    e.css({opacity: n}).transform("translate3d(" + i + "px, " + o + "px, 0px)")
                                }
                            }, setTransition: function (t) {
                                if (y.slides.transition(t), y.params.virtualTranslate && 0 !== t) {
                                    var e = !1;
                                    y.slides.transitionEnd(function () {
                                        if (!e && y) {
                                            e = !0, y.animating = !1;
                                            for (var t = ["webkitTransitionEnd", "transitionend", "oTransitionEnd", "MSTransitionEnd", "msTransitionEnd"], a = 0; a < t.length; a++) y.wrapper.trigger(t[a])
                                        }
                                    })
                                }
                            }
                        }, flip: {
                            setTranslate: function () {
                                for (var e = 0; e < y.slides.length; e++) {
                                    var a = y.slides.eq(e), i = a[0].progress;
                                    y.params.flip.limitRotation && (i = Math.max(Math.min(a[0].progress, 1), -1));
                                    var o = a[0].swiperSlideOffset, n = -180 * i, r = n, s = 0, l = -o, d = 0;
                                    if (y.isHorizontal() ? y.rtl && (r = -r) : (d = l, l = 0, s = -r, r = 0), a[0].style.zIndex = -Math.abs(Math.round(i)) + y.slides.length, y.params.flip.slideShadows) {
                                        var c = y.isHorizontal() ? a.find(".swiper-slide-shadow-left") : a.find(".swiper-slide-shadow-top"),
                                            p = y.isHorizontal() ? a.find(".swiper-slide-shadow-right") : a.find(".swiper-slide-shadow-bottom");
                                        0 === c.length && (c = t('<div class="swiper-slide-shadow-' + (y.isHorizontal() ? "left" : "top") + '"></div>'), a.append(c)), 0 === p.length && (p = t('<div class="swiper-slide-shadow-' + (y.isHorizontal() ? "right" : "bottom") + '"></div>'), a.append(p)), c.length && (c[0].style.opacity = Math.max(-i, 0)), p.length && (p[0].style.opacity = Math.max(i, 0))
                                    }
                                    a.transform("translate3d(" + l + "px, " + d + "px, 0px) rotateX(" + s + "deg) rotateY(" + r + "deg)")
                                }
                            }, setTransition: function (e) {
                                if (y.slides.transition(e).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(e), y.params.virtualTranslate && 0 !== e) {
                                    var a = !1;
                                    y.slides.eq(y.activeIndex).transitionEnd(function () {
                                        if (!a && y && t(this).hasClass(y.params.slideActiveClass)) {
                                            a = !0, y.animating = !1;
                                            for (var e = ["webkitTransitionEnd", "transitionend", "oTransitionEnd", "MSTransitionEnd", "msTransitionEnd"], i = 0; i < e.length; i++) y.wrapper.trigger(e[i])
                                        }
                                    })
                                }
                            }
                        }, cube: {
                            setTranslate: function () {
                                var e, a = 0;
                                y.params.cube.shadow && (y.isHorizontal() ? (e = y.wrapper.find(".swiper-cube-shadow"), 0 === e.length && (e = t('<div class="swiper-cube-shadow"></div>'), y.wrapper.append(e)), e.css({height: y.width + "px"})) : (e = y.container.find(".swiper-cube-shadow"), 0 === e.length && (e = t('<div class="swiper-cube-shadow"></div>'), y.container.append(e))));
                                for (var i = 0; i < y.slides.length; i++) {
                                    var o = y.slides.eq(i), n = 90 * i, r = Math.floor(n / 360);
                                    y.rtl && (n = -n, r = Math.floor(-n / 360));
                                    var s = Math.max(Math.min(o[0].progress, 1), -1), l = 0, d = 0, c = 0;
                                    i % 4 == 0 ? (l = 4 * -r * y.size, c = 0) : (i - 1) % 4 == 0 ? (l = 0, c = 4 * -r * y.size) : (i - 2) % 4 == 0 ? (l = y.size + 4 * r * y.size, c = y.size) : (i - 3) % 4 == 0 && (l = -y.size, c = 3 * y.size + 4 * y.size * r), y.rtl && (l = -l), y.isHorizontal() || (d = l, l = 0);
                                    var p = "rotateX(" + (y.isHorizontal() ? 0 : -n) + "deg) rotateY(" + (y.isHorizontal() ? n : 0) + "deg) translate3d(" + l + "px, " + d + "px, " + c + "px)";
                                    if (s <= 1 && s > -1 && (a = 90 * i + 90 * s, y.rtl && (a = 90 * -i - 90 * s)), o.transform(p), y.params.cube.slideShadows) {
                                        var u = y.isHorizontal() ? o.find(".swiper-slide-shadow-left") : o.find(".swiper-slide-shadow-top"),
                                            h = y.isHorizontal() ? o.find(".swiper-slide-shadow-right") : o.find(".swiper-slide-shadow-bottom");
                                        0 === u.length && (u = t('<div class="swiper-slide-shadow-' + (y.isHorizontal() ? "left" : "top") + '"></div>'), o.append(u)), 0 === h.length && (h = t('<div class="swiper-slide-shadow-' + (y.isHorizontal() ? "right" : "bottom") + '"></div>'), o.append(h)), u.length && (u[0].style.opacity = Math.max(-s, 0)), h.length && (h[0].style.opacity = Math.max(s, 0))
                                    }
                                }
                                if (y.wrapper.css({
                                    "-webkit-transform-origin": "50% 50% -" + y.size / 2 + "px",
                                    "-moz-transform-origin": "50% 50% -" + y.size / 2 + "px",
                                    "-ms-transform-origin": "50% 50% -" + y.size / 2 + "px",
                                    "transform-origin": "50% 50% -" + y.size / 2 + "px"
                                }), y.params.cube.shadow) if (y.isHorizontal()) e.transform("translate3d(0px, " + (y.width / 2 + y.params.cube.shadowOffset) + "px, " + -y.width / 2 + "px) rotateX(90deg) rotateZ(0deg) scale(" + y.params.cube.shadowScale + ")"); else {
                                    var f = Math.abs(a) - 90 * Math.floor(Math.abs(a) / 90),
                                        m = 1.5 - (Math.sin(2 * f * Math.PI / 360) / 2 + Math.cos(2 * f * Math.PI / 360) / 2),
                                        g = y.params.cube.shadowScale, v = y.params.cube.shadowScale / m,
                                        w = y.params.cube.shadowOffset;
                                    e.transform("scale3d(" + g + ", 1, " + v + ") translate3d(0px, " + (y.height / 2 + w) + "px, " + -y.height / 2 / v + "px) rotateX(-90deg)")
                                }
                                var b = y.isSafari || y.isUiWebView ? -y.size / 2 : 0;
                                y.wrapper.transform("translate3d(0px,0," + b + "px) rotateX(" + (y.isHorizontal() ? 0 : a) + "deg) rotateY(" + (y.isHorizontal() ? -a : 0) + "deg)")
                            }, setTransition: function (t) {
                                y.slides.transition(t).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(t), y.params.cube.shadow && !y.isHorizontal() && y.container.find(".swiper-cube-shadow").transition(t)
                            }
                        }, coverflow: {
                            setTranslate: function () {
                                for (var e = y.translate, a = y.isHorizontal() ? -e + y.width / 2 : -e + y.height / 2, i = y.isHorizontal() ? y.params.coverflow.rotate : -y.params.coverflow.rotate, o = y.params.coverflow.depth, n = 0, r = y.slides.length; n < r; n++) {
                                    var s = y.slides.eq(n), l = y.slidesSizesGrid[n], d = s[0].swiperSlideOffset,
                                        c = (a - d - l / 2) / l * y.params.coverflow.modifier,
                                        p = y.isHorizontal() ? i * c : 0, u = y.isHorizontal() ? 0 : i * c,
                                        h = -o * Math.abs(c), f = y.isHorizontal() ? 0 : y.params.coverflow.stretch * c,
                                        m = y.isHorizontal() ? y.params.coverflow.stretch * c : 0;
                                    Math.abs(m) < .001 && (m = 0), Math.abs(f) < .001 && (f = 0), Math.abs(h) < .001 && (h = 0), Math.abs(p) < .001 && (p = 0), Math.abs(u) < .001 && (u = 0);
                                    var g = "translate3d(" + m + "px," + f + "px," + h + "px)  rotateX(" + u + "deg) rotateY(" + p + "deg)";
                                    if (s.transform(g), s[0].style.zIndex = 1 - Math.abs(Math.round(c)), y.params.coverflow.slideShadows) {
                                        var v = y.isHorizontal() ? s.find(".swiper-slide-shadow-left") : s.find(".swiper-slide-shadow-top"),
                                            w = y.isHorizontal() ? s.find(".swiper-slide-shadow-right") : s.find(".swiper-slide-shadow-bottom");
                                        0 === v.length && (v = t('<div class="swiper-slide-shadow-' + (y.isHorizontal() ? "left" : "top") + '"></div>'), s.append(v)), 0 === w.length && (w = t('<div class="swiper-slide-shadow-' + (y.isHorizontal() ? "right" : "bottom") + '"></div>'), s.append(w)), v.length && (v[0].style.opacity = c > 0 ? c : 0), w.length && (w[0].style.opacity = -c > 0 ? -c : 0)
                                    }
                                }
                                if (y.browser.ie) {
                                    y.wrapper[0].style.perspectiveOrigin = a + "px 50%"
                                }
                            }, setTransition: function (t) {
                                y.slides.transition(t).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(t)
                            }
                        }
                    }, y.lazy = {
                        initialImageLoaded: !1, loadImageInSlide: function (e, a) {
                            if (void 0 !== e && (void 0 === a && (a = !0), 0 !== y.slides.length)) {
                                var i = y.slides.eq(e),
                                    o = i.find(".swiper-lazy:not(.swiper-lazy-loaded):not(.swiper-lazy-loading)");
                                !i.hasClass("swiper-lazy") || i.hasClass("swiper-lazy-loaded") || i.hasClass("swiper-lazy-loading") || (o = o.add(i[0])), 0 !== o.length && o.each(function () {
                                    var e = t(this);
                                    e.addClass("swiper-lazy-loading");
                                    var o = e.attr("data-background"), n = e.attr("data-src"),
                                        r = e.attr("data-srcset");
                                    y.loadImage(e[0], n || o, r, !1, function () {
                                        if (o ? (e.css("background-image", 'url("' + o + '")'), e.removeAttr("data-background")) : (r && (e.attr("srcset", r), e.removeAttr("data-srcset")), n && (e.attr("src", n), e.removeAttr("data-src"))), e.addClass("swiper-lazy-loaded").removeClass("swiper-lazy-loading"), i.find(".swiper-lazy-preloader, .preloader").remove(), y.params.loop && a) {
                                            var t = i.attr("data-swiper-slide-index");
                                            if (i.hasClass(y.params.slideDuplicateClass)) {
                                                var s = y.wrapper.children('[data-swiper-slide-index="' + t + '"]:not(.' + y.params.slideDuplicateClass + ")");
                                                y.lazy.loadImageInSlide(s.index(), !1)
                                            } else {
                                                var l = y.wrapper.children("." + y.params.slideDuplicateClass + '[data-swiper-slide-index="' + t + '"]');
                                                y.lazy.loadImageInSlide(l.index(), !1)
                                            }
                                        }
                                        y.emit("onLazyImageReady", y, i[0], e[0])
                                    }), y.emit("onLazyImageLoad", y, i[0], e[0])
                                })
                            }
                        }, load: function () {
                            var e;
                            if (y.params.watchSlidesVisibility) y.wrapper.children("." + y.params.slideVisibleClass).each(function () {
                                y.lazy.loadImageInSlide(t(this).index())
                            }); else if (y.params.slidesPerView > 1) for (e = y.activeIndex; e < y.activeIndex + y.params.slidesPerView; e++) y.slides[e] && y.lazy.loadImageInSlide(e); else y.lazy.loadImageInSlide(y.activeIndex);
                            if (y.params.lazyLoadingInPrevNext) if (y.params.slidesPerView > 1 || y.params.lazyLoadingInPrevNextAmount && y.params.lazyLoadingInPrevNextAmount > 1) {
                                var a = y.params.lazyLoadingInPrevNextAmount, i = y.params.slidesPerView,
                                    o = Math.min(y.activeIndex + i + Math.max(a, i), y.slides.length),
                                    n = Math.max(y.activeIndex - Math.max(i, a), 0);
                                for (e = y.activeIndex + y.params.slidesPerView; e < o; e++) y.slides[e] && y.lazy.loadImageInSlide(e);
                                for (e = n; e < y.activeIndex; e++) y.slides[e] && y.lazy.loadImageInSlide(e)
                            } else {
                                var r = y.wrapper.children("." + y.params.slideNextClass);
                                r.length > 0 && y.lazy.loadImageInSlide(r.index());
                                var s = y.wrapper.children("." + y.params.slidePrevClass);
                                s.length > 0 && y.lazy.loadImageInSlide(s.index())
                            }
                        }, onTransitionStart: function () {
                            y.params.lazyLoading && (y.params.lazyLoadingOnTransitionStart || !y.params.lazyLoadingOnTransitionStart && !y.lazy.initialImageLoaded) && y.lazy.load()
                        }, onTransitionEnd: function () {
                            y.params.lazyLoading && !y.params.lazyLoadingOnTransitionStart && y.lazy.load()
                        }
                    }, y.scrollbar = {
                        isTouched: !1, setDragPosition: function (t) {
                            var e = y.scrollbar,
                                a = y.isHorizontal() ? "touchstart" === t.type || "touchmove" === t.type ? t.targetTouches[0].pageX : t.pageX || t.clientX : "touchstart" === t.type || "touchmove" === t.type ? t.targetTouches[0].pageY : t.pageY || t.clientY,
                                i = a - e.track.offset()[y.isHorizontal() ? "left" : "top"] - e.dragSize / 2,
                                o = -y.minTranslate() * e.moveDivider, n = -y.maxTranslate() * e.moveDivider;
                            i < o ? i = o : i > n && (i = n), i = -i / e.moveDivider, y.updateProgress(i), y.setWrapperTranslate(i, !0)
                        }, dragStart: function (t) {
                            var e = y.scrollbar;
                            e.isTouched = !0, t.preventDefault(), t.stopPropagation(), e.setDragPosition(t), clearTimeout(e.dragTimeout), e.track.transition(0), y.params.scrollbarHide && e.track.css("opacity", 1), y.wrapper.transition(100), e.drag.transition(100), y.emit("onScrollbarDragStart", y)
                        }, dragMove: function (t) {
                            var e = y.scrollbar;
                            e.isTouched && (t.preventDefault ? t.preventDefault() : t.returnValue = !1, e.setDragPosition(t), y.wrapper.transition(0), e.track.transition(0), e.drag.transition(0), y.emit("onScrollbarDragMove", y))
                        }, dragEnd: function (t) {
                            var e = y.scrollbar;
                            e.isTouched && (e.isTouched = !1, y.params.scrollbarHide && (clearTimeout(e.dragTimeout), e.dragTimeout = setTimeout(function () {
                                e.track.css("opacity", 0), e.track.transition(400)
                            }, 1e3)), y.emit("onScrollbarDragEnd", y), y.params.scrollbarSnapOnRelease && y.slideReset())
                        }, enableDraggable: function () {
                            var e = y.scrollbar, a = y.support.touch ? e.track : document;
                            t(e.track).on(y.touchEvents.start, e.dragStart), t(a).on(y.touchEvents.move, e.dragMove), t(a).on(y.touchEvents.end, e.dragEnd)
                        }, disableDraggable: function () {
                            var e = y.scrollbar, a = y.support.touch ? e.track : document;
                            t(e.track).off(y.touchEvents.start, e.dragStart), t(a).off(y.touchEvents.move, e.dragMove), t(a).off(y.touchEvents.end, e.dragEnd)
                        }, set: function () {
                            if (y.params.scrollbar) {
                                var e = y.scrollbar;
                                e.track = t(y.params.scrollbar), y.params.uniqueNavElements && "string" == typeof y.params.scrollbar && e.track.length > 1 && 1 === y.container.find(y.params.scrollbar).length && (e.track = y.container.find(y.params.scrollbar)), e.drag = e.track.find(".swiper-scrollbar-drag"), 0 === e.drag.length && (e.drag = t('<div class="swiper-scrollbar-drag"></div>'), e.track.append(e.drag)), e.drag[0].style.width = "", e.drag[0].style.height = "", e.trackSize = y.isHorizontal() ? e.track[0].offsetWidth : e.track[0].offsetHeight, e.divider = y.size / y.virtualSize, e.moveDivider = e.divider * (e.trackSize / y.size), e.dragSize = e.trackSize * e.divider, y.isHorizontal() ? e.drag[0].style.width = e.dragSize + "px" : e.drag[0].style.height = e.dragSize + "px", e.divider >= 1 ? e.track[0].style.display = "none" : e.track[0].style.display = "", y.params.scrollbarHide && (e.track[0].style.opacity = 0)
                            }
                        }, setTranslate: function () {
                            if (y.params.scrollbar) {
                                var t, e = y.scrollbar, a = (y.translate, e.dragSize);
                                t = (e.trackSize - e.dragSize) * y.progress, y.rtl && y.isHorizontal() ? (t = -t, t > 0 ? (a = e.dragSize - t, t = 0) : -t + e.dragSize > e.trackSize && (a = e.trackSize + t)) : t < 0 ? (a = e.dragSize + t, t = 0) : t + e.dragSize > e.trackSize && (a = e.trackSize - t), y.isHorizontal() ? (y.support.transforms3d ? e.drag.transform("translate3d(" + t + "px, 0, 0)") : e.drag.transform("translateX(" + t + "px)"), e.drag[0].style.width = a + "px") : (y.support.transforms3d ? e.drag.transform("translate3d(0px, " + t + "px, 0)") : e.drag.transform("translateY(" + t + "px)"), e.drag[0].style.height = a + "px"), y.params.scrollbarHide && (clearTimeout(e.timeout), e.track[0].style.opacity = 1, e.timeout = setTimeout(function () {
                                    e.track[0].style.opacity = 0, e.track.transition(400)
                                }, 1e3))
                            }
                        }, setTransition: function (t) {
                            y.params.scrollbar && y.scrollbar.drag.transition(t)
                        }
                    }, y.controller = {
                        LinearSpline: function (t, e) {
                            this.x = t, this.y = e, this.lastIndex = t.length - 1;
                            var a, i;
                            this.x.length;
                            this.interpolate = function (t) {
                                return t ? (i = o(this.x, t), a = i - 1, (t - this.x[a]) * (this.y[i] - this.y[a]) / (this.x[i] - this.x[a]) + this.y[a]) : 0
                            };
                            var o = function () {
                                var t, e, a;
                                return function (i, o) {
                                    for (e = -1, t = i.length; t - e > 1;) i[a = t + e >> 1] <= o ? e = a : t = a;
                                    return t
                                }
                            }()
                        }, getInterpolateFunction: function (t) {
                            y.controller.spline || (y.controller.spline = y.params.loop ? new y.controller.LinearSpline(y.slidesGrid, t.slidesGrid) : new y.controller.LinearSpline(y.snapGrid, t.snapGrid))
                        }, setTranslate: function (t, a) {
                            function i(e) {
                                t = e.rtl && "horizontal" === e.params.direction ? -y.translate : y.translate, "slide" === y.params.controlBy && (y.controller.getInterpolateFunction(e), n = -y.controller.spline.interpolate(-t)), n && "container" !== y.params.controlBy || (o = (e.maxTranslate() - e.minTranslate()) / (y.maxTranslate() - y.minTranslate()), n = (t - y.minTranslate()) * o + e.minTranslate()), y.params.controlInverse && (n = e.maxTranslate() - n), e.updateProgress(n), e.setWrapperTranslate(n, !1, y), e.updateActiveIndex()
                            }

                            var o, n, r = y.params.control;
                            if (y.isArray(r)) for (var s = 0; s < r.length; s++) r[s] !== a && r[s] instanceof e && i(r[s]); else r instanceof e && a !== r && i(r)
                        }, setTransition: function (t, a) {
                            function i(e) {
                                e.setWrapperTransition(t, y), 0 !== t && (e.onTransitionStart(), e.wrapper.transitionEnd(function () {
                                    n && (e.params.loop && "slide" === y.params.controlBy && e.fixLoop(), e.onTransitionEnd())
                                }))
                            }

                            var o, n = y.params.control;
                            if (y.isArray(n)) for (o = 0; o < n.length; o++) n[o] !== a && n[o] instanceof e && i(n[o]); else n instanceof e && a !== n && i(n)
                        }
                    }, y.hashnav = {
                        init: function () {
                            if (y.params.hashnav) {
                                y.hashnav.initialized = !0;
                                var t = document.location.hash.replace("#", "");
                                if (t) for (var e = 0, a = y.slides.length; e < a; e++) {
                                    var i = y.slides.eq(e), o = i.attr("data-hash");
                                    if (o === t && !i.hasClass(y.params.slideDuplicateClass)) {
                                        var n = i.index();
                                        y.slideTo(n, 0, y.params.runCallbacksOnInit, !0)
                                    }
                                }
                            }
                        }, setHash: function () {
                            y.hashnav.initialized && y.params.hashnav && (document.location.hash = y.slides.eq(y.activeIndex).attr("data-hash") || "")
                        }
                    }, y.disableKeyboardControl = function () {
                        y.params.keyboardControl = !1, t(document).off("keydown", l)
                    }, y.enableKeyboardControl = function () {
                        y.params.keyboardControl = !0, t(document).on("keydown", l)
                    }, y.mousewheel = {
                        event: !1,
                        lastScrollTime: (new window.Date).getTime()
                    }, y.params.mousewheelControl) {
                        try {
                            new window.WheelEvent("wheel"), y.mousewheel.event = "wheel"
                        } catch (t) {
                            (window.WheelEvent || y.container[0] && "wheel" in y.container[0]) && (y.mousewheel.event = "wheel")
                        }
                        !y.mousewheel.event && window.WheelEvent, y.mousewheel.event || void 0 === document.onmousewheel || (y.mousewheel.event = "mousewheel"), y.mousewheel.event || (y.mousewheel.event = "DOMMouseScroll")
                    }
                    y.disableMousewheelControl = function () {
                        return !!y.mousewheel.event && (y.container.off(y.mousewheel.event, d), !0)
                    }, y.enableMousewheelControl = function () {
                        return !!y.mousewheel.event && (y.container.on(y.mousewheel.event, d), !0)
                    }, y.parallax = {
                        setTranslate: function () {
                            y.container.children("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]").each(function () {
                                c(this, y.progress)
                            }), y.slides.each(function () {
                                var e = t(this);
                                e.find("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]").each(function () {
                                    c(this, Math.min(Math.max(e[0].progress, -1), 1))
                                })
                            })
                        }, setTransition: function (e) {
                            void 0 === e && (e = y.params.speed), y.container.find("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]").each(function () {
                                var a = t(this), i = parseInt(a.attr("data-swiper-parallax-duration"), 10) || e;
                                0 === e && (i = 0), a.transition(i)
                            })
                        }
                    }, y._plugins = [];
                    for (var j in y.plugins) {
                        var L = y.plugins[j](y, y.params[j]);
                        L && y._plugins.push(L)
                    }
                    return y.callPlugins = function (t) {
                        for (var e = 0; e < y._plugins.length; e++) t in y._plugins[e] && y._plugins[e][t](arguments[1], arguments[2], arguments[3], arguments[4], arguments[5])
                    }, y.emitterEventListeners = {}, y.emit = function (t) {
                        y.params[t] && y.params[t](arguments[1], arguments[2], arguments[3], arguments[4], arguments[5]);
                        var e;
                        if (y.emitterEventListeners[t]) for (e = 0; e < y.emitterEventListeners[t].length; e++) y.emitterEventListeners[t][e](arguments[1], arguments[2], arguments[3], arguments[4], arguments[5]);
                        y.callPlugins && y.callPlugins(t, arguments[1], arguments[2], arguments[3], arguments[4], arguments[5])
                    }, y.on = function (t, e) {
                        return t = p(t), y.emitterEventListeners[t] || (y.emitterEventListeners[t] = []), y.emitterEventListeners[t].push(e), y
                    }, y.off = function (t, e) {
                        var a;
                        if (t = p(t), void 0 === e) return y.emitterEventListeners[t] = [], y;
                        if (y.emitterEventListeners[t] && 0 !== y.emitterEventListeners[t].length) {
                            for (a = 0; a < y.emitterEventListeners[t].length; a++) y.emitterEventListeners[t][a] === e && y.emitterEventListeners[t].splice(a, 1);
                            return y
                        }
                    }, y.once = function (t, e) {
                        t = p(t);
                        var a = function () {
                            e(arguments[0], arguments[1], arguments[2], arguments[3], arguments[4]), y.off(t, a)
                        };
                        return y.on(t, a), y
                    }, y.a11y = {
                        makeFocusable: function (t) {
                            return t.attr("tabIndex", "0"), t
                        },
                        addRole: function (t, e) {
                            return t.attr("role", e), t
                        },
                        addLabel: function (t, e) {
                            return t.attr("aria-label", e), t
                        },
                        disable: function (t) {
                            return t.attr("aria-disabled", !0), t
                        },
                        enable: function (t) {
                            return t.attr("aria-disabled", !1), t
                        },
                        onEnterKey: function (e) {
                            13 === e.keyCode && (t(e.target).is(y.params.nextButton) ? (y.onClickNext(e), y.isEnd ? y.a11y.notify(y.params.lastSlideMessage) : y.a11y.notify(y.params.nextSlideMessage)) : t(e.target).is(y.params.prevButton) && (y.onClickPrev(e), y.isBeginning ? y.a11y.notify(y.params.firstSlideMessage) : y.a11y.notify(y.params.prevSlideMessage)), t(e.target).is("." + y.params.bulletClass) && t(e.target)[0].click())
                        },
                        liveRegion: t('<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>'),
                        notify: function (t) {
                            var e = y.a11y.liveRegion;
                            0 !== e.length && (e.html(""), e.html(t))
                        },
                        init: function () {
                            y.params.nextButton && y.nextButton && y.nextButton.length > 0 && (y.a11y.makeFocusable(y.nextButton), y.a11y.addRole(y.nextButton, "button"), y.a11y.addLabel(y.nextButton, y.params.nextSlideMessage)), y.params.prevButton && y.prevButton && y.prevButton.length > 0 && (y.a11y.makeFocusable(y.prevButton), y.a11y.addRole(y.prevButton, "button"), y.a11y.addLabel(y.prevButton, y.params.prevSlideMessage)), t(y.container).append(y.a11y.liveRegion)
                        },
                        initPagination: function () {
                            y.params.pagination && y.params.paginationClickable && y.bullets && y.bullets.length && y.bullets.each(function () {
                                var e = t(this);
                                y.a11y.makeFocusable(e), y.a11y.addRole(e, "button"), y.a11y.addLabel(e, y.params.paginationBulletMessage.replace(/{{index}}/, e.index() + 1))
                            })
                        },
                        destroy: function () {
                            y.a11y.liveRegion && y.a11y.liveRegion.length > 0 && y.a11y.liveRegion.remove()
                        }
                    }, y.init = function () {
                        y.params.loop && y.createLoop(), y.updateContainerSize(), y.updateSlidesSize(), y.updatePagination(), y.params.scrollbar && y.scrollbar && (y.scrollbar.set(), y.params.scrollbarDraggable && y.scrollbar.enableDraggable()), "slide" !== y.params.effect && y.effects[y.params.effect] && (y.params.loop || y.updateProgress(), y.effects[y.params.effect].setTranslate()), y.params.loop ? y.slideTo(y.params.initialSlide + y.loopedSlides, 0, y.params.runCallbacksOnInit) : (y.slideTo(y.params.initialSlide, 0, y.params.runCallbacksOnInit), 0 === y.params.initialSlide && (y.parallax && y.params.parallax && y.parallax.setTranslate(), y.lazy && y.params.lazyLoading && (y.lazy.load(), y.lazy.initialImageLoaded = !0))), y.attachEvents(), y.params.observer && y.support.observer && y.initObservers(), y.params.preloadImages && !y.params.lazyLoading && y.preloadImages(), y.params.autoplay && y.startAutoplay(), y.params.keyboardControl && y.enableKeyboardControl && y.enableKeyboardControl(), y.params.mousewheelControl && y.enableMousewheelControl && y.enableMousewheelControl(), y.params.hashnav && y.hashnav && y.hashnav.init(), y.params.a11y && y.a11y && y.a11y.init(), y.emit("onInit", y)
                    }, y.cleanupStyles = function () {
                        y.container.removeClass(y.classNames.join(" ")).removeAttr("style"), y.wrapper.removeAttr("style"),
                        y.slides && y.slides.length && y.slides.removeClass([y.params.slideVisibleClass, y.params.slideActiveClass, y.params.slideNextClass, y.params.slidePrevClass].join(" ")).removeAttr("style").removeAttr("data-swiper-column").removeAttr("data-swiper-row"), y.paginationContainer && y.paginationContainer.length && y.paginationContainer.removeClass(y.params.paginationHiddenClass), y.bullets && y.bullets.length && y.bullets.removeClass(y.params.bulletActiveClass), y.params.prevButton && t(y.params.prevButton).removeClass(y.params.buttonDisabledClass), y.params.nextButton && t(y.params.nextButton).removeClass(y.params.buttonDisabledClass), y.params.scrollbar && y.scrollbar && (y.scrollbar.track && y.scrollbar.track.length && y.scrollbar.track.removeAttr("style"), y.scrollbar.drag && y.scrollbar.drag.length && y.scrollbar.drag.removeAttr("style"))
                    }, y.destroy = function (t, e) {
                        y.detachEvents(), y.stopAutoplay(), y.params.scrollbar && y.scrollbar && y.params.scrollbarDraggable && y.scrollbar.disableDraggable(), y.params.loop && y.destroyLoop(), e && y.cleanupStyles(), y.disconnectObservers(), y.params.keyboardControl && y.disableKeyboardControl && y.disableKeyboardControl(), y.params.mousewheelControl && y.disableMousewheelControl && y.disableMousewheelControl(), y.params.a11y && y.a11y && y.a11y.destroy(), y.emit("onDestroy"), !1 !== t && (y = null)
                    }, y.init(), y
                }
            };
            e.prototype = {
                isSafari: function () {
                    var t = navigator.userAgent.toLowerCase();
                    return t.indexOf("safari") >= 0 && t.indexOf("chrome") < 0 && t.indexOf("android") < 0
                }(),
                isUiWebView: /(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(navigator.userAgent),
                isArray: function (t) {
                    return "[object Array]" === Object.prototype.toString.apply(t)
                },
                browser: {
                    ie: window.navigator.pointerEnabled || window.navigator.msPointerEnabled,
                    ieTouch: window.navigator.msPointerEnabled && window.navigator.msMaxTouchPoints > 1 || window.navigator.pointerEnabled && window.navigator.maxTouchPoints > 1
                },
                device: function () {
                    var t = navigator.userAgent, e = t.match(/(Android);?[\s\/]+([\d.]+)?/),
                        a = t.match(/(iPad).*OS\s([\d_]+)/), i = t.match(/(iPod)(.*OS\s([\d_]+))?/),
                        o = !a && t.match(/(iPhone\sOS)\s([\d_]+)/);
                    return {ios: a || o || i, android: e}
                }(),
                support: {
                    touch: window.Modernizr && !0 === Modernizr.touch || function () {
                        return !!("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch)
                    }(), transforms3d: window.Modernizr && !0 === Modernizr.csstransforms3d || function () {
                        var t = document.createElement("div").style;
                        return "webkitPerspective" in t || "MozPerspective" in t || "OPerspective" in t || "MsPerspective" in t || "perspective" in t
                    }(), flexbox: function () {
                        for (var t = document.createElement("div").style, e = "alignItems webkitAlignItems webkitBoxAlign msFlexAlign mozBoxAlign webkitFlexDirection msFlexDirection mozBoxDirection mozBoxOrient webkitBoxDirection webkitBoxOrient".split(" "), a = 0; a < e.length; a++) if (e[a] in t) return !0
                    }(), observer: function () {
                        return "MutationObserver" in window || "WebkitMutationObserver" in window
                    }()
                },
                plugins: {}
            };
            for (var a = ["jQuery", "Zepto", "Dom7"], i = 0; i < a.length; i++) window[a[i]] && function (t) {
                t.fn.swiper = function (a) {
                    var i;
                    return t(this).each(function () {
                        var t = new e(this, a);
                        i || (i = t)
                    }), i
                }
            }(window[a[i]]);
            var o;
            o = "undefined" == typeof Dom7 ? window.Dom7 || window.Zepto || window.jQuery : Dom7, o && ("transitionEnd" in o.fn || (o.fn.transitionEnd = function (t) {
                function e(n) {
                    if (n.target === this) for (t.call(this, n), a = 0; a < i.length; a++) o.off(i[a], e)
                }

                var a,
                    i = ["webkitTransitionEnd", "transitionend", "oTransitionEnd", "MSTransitionEnd", "msTransitionEnd"],
                    o = this;
                if (t) for (a = 0; a < i.length; a++) o.on(i[a], e);
                return this
            }), "transform" in o.fn || (o.fn.transform = function (t) {
                for (var e = 0; e < this.length; e++) {
                    var a = this[e].style;
                    a.webkitTransform = a.MsTransform = a.msTransform = a.MozTransform = a.OTransform = a.transform = t
                }
                return this
            }), "transition" in o.fn || (o.fn.transition = function (t) {
                "string" != typeof t && (t += "ms");
                for (var e = 0; e < this.length; e++) {
                    var a = this[e].style;
                    a.webkitTransitionDuration = a.MsTransitionDuration = a.msTransitionDuration = a.MozTransitionDuration = a.OTransitionDuration = a.transitionDuration = t
                }
                return this
            })), window.Swiper = e
        }(), void 0 !== e ? e.exports = window.Swiper : "function" == typeof define && define.amd && define([], function () {
            "use strict";
            return window.Swiper
        })
    }, {}],
    8: [function (t, e, a) {
        function i() {
            if (!r) {
                var t = document.getElementsByTagName("head")[0], e = document.createElement("link");
                e.href = "https://fonts.googleapis.com/css?family=Noto+Sans+SC|Noto+Serif+SC:900&display=swap", e.rel = "stylesheet", e.type = "text/css", t.appendChild(e), r = 1
            }
        }

        function o(t) {
            if (t.num && t.num > 8) return !1;
            var e = document.createElement("canvas"), a = e.getContext("2d");
            e.width = 640, e.height = 1e4;
            var i = 0;
            a.fillStyle = "#fff", a.fillRect(0, 0, e.width, e.height);
            var r = new Image;
            r.crossOrigin = "anonymous", t.head.match(/^\/\//) && (t.head = window.location.protocol + t.head), r.src = t.head, r.onerror = function (t) {
                alert("生成海报图片失败"), $(".mobile-share-bg,.mobile-share-wrap").remove()
            }, r.onload = function () {
                i += 640 / r.width * r.height, a.drawImage(this, 0, 0, r.width, r.height, 0, 0, 640, 640 / r.width * r.height);
                var s = new Date(1e3 * t.timestamp), l = s.getDate(), d = s.getFullYear(), c = s.getMonth() + 1;
                l = l < 10 ? "0" + l : "" + l, c = c < 10 ? "0" + c : "" + c, c = d + "/" + c;
                var p = 0, u = 0;
                a.fillStyle = "#fff", a.textAlign = "center", a.font = "68px Noto Sans SC";
                for (var h = 0; h < l.length; h++) p += a.measureText(l[h]).width;
                a.fillText(l, 80, i - 72), a.fillStyle = "#fff", a.textAlign = "center", a.font = "30px Noto Sans SC";
                for (var h = 0; h < c.length; h++) u += a.measureText(c[h]).width;
                a.fillText(c, 80, i - 28);
                var f = parseInt(u > p ? u : p);
                a.moveTo(80 - f / 2, i - 60), a.lineTo(80 - f / 2 + f, i - 60), a.lineWidth = 1, a.strokeStyle = "rgba(255,255,255, 1)", a.stroke(), a.fillStyle = "#000", a.textAlign = "center", a.font = "900 40px Noto Serif SC", i += 80, i = n(jQuery("<div>").html(t.title).text(), 320, i, 54, a), a.textAlign = "left", a.fillStyle = "#333", a.font = "400 28px Noto Sans SC", i += 30, i = n(jQuery("<div>").html(t.excerpt).text(), 30, i, 44, a), i += 100, a.lineWidth = 1, a.beginPath(), a.setLineDash([7, 7]), a.strokeStyle = "#ccc", a.moveTo(0, i), a.lineTo(640, i), a.stroke();
                var m = new Image;
                m.crossOrigin = "anonymous", t.logo.match(/^\/\//) && (t.logo = window.location.protocol + t.logo), m.src = t.logo, m.onerror = function (t) {
                    alert("生成海报图片失败"), $(".mobile-share-bg,.mobile-share-wrap").remove()
                }, m.onload = function () {
                    i += 40;
                    var n = 400 / m.width * m.height;
                    n = n > 100 ? 100 : n;
                    var r = m.width / (m.height / n);
                    r = r > 400 ? 400 : r, n = r / m.width * m.height, a.drawImage(this, 0, 0, m.width, m.height, 30, i + (100 - n) / 2, r, n);
                    var s = new Image;
                    s.src = t.qrcode, s.onerror = function (t) {
                        alert("生成海报图片失败"), $(".mobile-share-bg,.mobile-share-wrap").remove()
                    }, s.onload = function () {
                        a.drawImage(this, 0, 0, s.width, s.height, 510, i, 100, 100 / s.width * s.height);
                        var r = 100 / s.width * s.height;
                        i += r > n ? r : n, i += 40;
                        var l = a.getImageData(0, 0, 640, i);
                        e.height = i, a.putImageData(l, 0, 0);
                        var d = e.toDataURL("image/jpeg", 1);
                        t.callback(d), setTimeout(function () {
                            a.clearRect(0, 0, e.width, e.height), t.num = t.num ? t.num + 1 : 1, o(t)
                        }, 500)
                    }
                }
            }
        }

        function n(t, e, a, i, o) {
            for (var n = 0, r = 0, s = 0, l = 0; l < t.length; l++) s = o.measureText(t[l]).width, n += s, n > 560 && (o.fillText(t.substring(r, l), e, a), a += i, n = 0, r = l), l == t.length - 1 && (o.fillText(t.substring(r, l + 1), e, a), a += i);
            return a
        }

        var r = 0;
        e.exports = {loadFont: i, buildCanvas: o}
    }, {}],
    9: [function (t, e, a) {
        t("../../../Themer/src/js/bootstrap"), t("../../../Themer/src/js/swiper.jquery");
        var i = t("../../../Themer/src/js/text-image");
        t("../../../Themer/src/js/member"), t("../../../Themer/src/js/common"), t("../../../Themer/src/js/jquery.qrcode.min"), function (t) {
            function e() {
                d.offset().top + d.outerHeight() > o.scrollTop() + n ? (d.addClass("fixed"), d.find(".entry-bar-inner").css("width", t(".main").width())) : d.removeClass("fixed")
            }

            function a(e) {
                var a = e.parent(), i = a.offset().top, r = 0, s = 0, l = 0, d = e.closest(".container").find(".main");
                setTimeout(function () {
                    i = a.offset().top + parseInt(a.css("paddingTop")), r = e.outerHeight()
                }, 2e3), d.length && (t(document).on("DOMSubtreeModified", function () {
                    r = e.outerHeight(), l = d.outerHeight(), s = d.offset().top + l
                }), o.scroll(function () {
                    if (!(l <= r)) {
                        var t = o.scrollTop();
                        n - i > r ? t + r + i > s ? e.removeClass("fixed").addClass("abs").css({
                            bottom: 0,
                            top: "auto"
                        }) : e.removeClass("abs").addClass("fixed").css({
                            bottom: "auto",
                            top: i
                        }) : t + n > s ? e.addClass("abs").removeClass("fixed") : t + n > i + r ? e.addClass("fixed").removeClass("abs") : e.removeClass("fixed").removeClass("abs")
                    }
                }))
            }

            var o = t(window), n = o.height(), r = 0,
                s = void 0 !== _wpcom_js.webp && _wpcom_js.webp ? _wpcom_js.webp : null,
                l = t(".navbar-toggle").is(":hidden");
            t(document).ready(function () {
                function e() {
                    if (!l) for (var e = t("header li.dropdown"), a = 0; a < e.length; a++) {
                        var i = t(e[a]);
                        0 == i.find(".m-dropdown").length && i.append('<div class="m-dropdown"><i class="fa fa-angle-down"></i></div>')
                    }
                }

                e(), o.resize(function () {
                    l = t(".navbar-toggle").is(":hidden"), n = o.height(), t(document).trigger("DOMSubtreeModified"), e()
                }), new Swiper(".swiper-container", {
                    onInit: function (e) {
                        t(e.container[0]).on("click", ".swiper-button-next", function () {
                            e.slideNext()
                        }).on("click", ".swiper-button-prev", function () {
                            e.slidePrev()
                        }).find(".j-lazy").lazyload({
                            webp: s,
                            threshold: 250,
                            effect: "fadeIn"
                        }), setTimeout(function () {
                            jQuery(window).trigger("scroll")
                        }, 800)
                    },
                    pagination: ".swiper-pagination",
                    paginationClickable: !0,
                    simulateTouch: !1,
                    loop: !0,
                    autoplay: _wpcom_js.slide_speed ? _wpcom_js.slide_speed : 5e3,
                    effect: "slide",
                    onSlideChangeEnd: function () {
                        jQuery(window).trigger("scroll")
                    }
                });
                var r = t(".entry .entry-video");
                r.length && r.height(parseInt(r.width() / (860 / (void 0 !== _wpcom_js.video_height ? _wpcom_js.video_height : 483))));
                var d = t(".sidebar"), c = t(".j-qrcode");
                c.length && t.each(c, function (e, a) {
                    var i = t(a), o = i.data("text");
                    i.qrcode({text: o})
                }), t(document).on("DOMNodeInserted", ".navbar-action", function () {
                    e()
                }), t(".modules-navs").each(function (e, a) {
                    var i = t(a), o = 0, n = i.find(".list-navs>.navs-link");
                    n.outerHeight(""), n.each(function (e, a) {
                        var i = t(a).outerHeight();
                        i > o && (o = i)
                    }), n.outerHeight(o)
                });
                var p = t("#wrap"), u = p.height(), h = t("footer.footer"), f = t(".member-form-wrap");
                if (t(document).on("DOMSubtreeModified", function () {
                    u = p.height(), p.css("min-height", n - p.offset().top - h.outerHeight()), f.length && t(".page-template-page-fullnotitle").length && (f.outerHeight(), f.css("margin-top", (u - f.outerHeight()) / 2))
                }).on("click", ".j-mobile-share", function () {
                    var e = t(this), a = e.data("id");
                    t("body").append('<div class="mobile-share-bg"><div class="top_tips">请长按图片，将内容推荐给好友</div></div><div class="mobile-share-wrap"><div class="loading">分享海报生成中...</div></div>'), i.loadFont(), t.ajax({
                        url: _wpcom_js.ajaxurl,
                        data: {id: a, action: "wpcom_mobile_share"},
                        method: "POST",
                        dataType: "json",
                        timeout: 1e4,
                        success: function (a) {
                            a.callback = function (e) {
                                t(".mobile-share-wrap").html('<img src="' + e + '"><div class="mobile-share-close">×</div>'), t(".mobile-share-bg .top_tips").show()
                            };
                            var o = t(".meta-item.wechat");
                            o = o.length ? o : e.closest(".kx-meta").find(".wechat-img"), a.qrcode = o.find("canvas")[0].toDataURL(), a.head && a.logo && a.qrcode ? i.buildCanvas(a) : (alert("生成分享海报失败"), t(".mobile-share-bg,.mobile-share-wrap").remove())
                        },
                        error: function () {
                            alert("获取分享海报失败"), t(".mobile-share-bg,.mobile-share-wrap").remove()
                        }
                    })
                }).on("click", ".mobile-share-close", function () {
                    t(".mobile-share-bg,.mobile-share-wrap").remove()
                }).on("click", ".kx-new", function () {
                    window.location.href = window.location.href
                }).on("click", ".widget-kx-list .kx-title", function () {
                    var e = t(this);
                    e.next().slideToggle("fast"), e.closest(".kx-item").toggleClass("active"), o.trigger("scroll")
                }), d.length && d.find(".widget").length && o.width() > 991) for (var m = 0; m < d.length; m++) a(t(d[m]));
                var g = t(".kx-list");
                if (g.length) {
                    window.kxDate = g.find(".kx-date");
                    var v;
                    v = t("#wpadminbar").length ? t("#wpadminbar").outerHeight() + t("header.header").outerHeight() : t("header.header").outerHeight();
                    var w = kxDate.first().offset().top, y = {$el: null}, b = t(".kx-new"),
                        x = kxDate.first().outerHeight();
                    o.scroll(function () {
                        var e = o.scrollTop(), a = kxDate.length - 1;
                        t.each(kxDate, function (i, o) {
                            var n = t(o), r = n.offset().top - e - v;
                            return r > 0 && y.$el && y.top < 0 ? (kxDate.removeClass("fixed"), y.$el.addClass("fixed").css("top", v), b.addClass("fixed").css("top", v + 36), void g.css("padding-top", x)) : 0 == i && r <= 0 ? (w - v >= e ? (kxDate.removeClass("fixed"), b.removeClass("fixed"), g.css("padding-top", 0)) : (kxDate.removeClass("fixed"), n.addClass("fixed").css("top", v), b.addClass("fixed").css("top", v + 36), g.css("padding-top", x)), y.$el = n, void(y.top = r)) : (i == a && r <= 0 && (kxDate.removeClass("fixed"), n.addClass("fixed").css("top", v), b.addClass("fixed").css("top", v + 36), g.css("padding-top", x)), y.$el = n, void(y.top = r))
                        })
                    }), setInterval(function () {
                        var e = t(".kx-item").first().data("id");
                        t.ajax({
                            url: _wpcom_js.ajaxurl,
                            data: {id: e, action: "wpcom_new_kuaixun"},
                            method: "POST",
                            dataType: "text",
                            success: function (e) {
                                e >= 1 && t(".kx-new").html("您有" + e + "条新消息！").show()
                            }
                        })
                    }, 1e4)
                }
                t(".kx-list,.widget-kx-list,.entry-footer").on("click", ".share-icon", function () {
                    var e = t(this), a = e.closest(".kx-item"), i = "";
                    if (a.length && a.closest(".widget-kx-list").length) {
                        var o = encodeURIComponent(t.trim(a.find(".kx-title").text())),
                            n = encodeURIComponent(t.trim(a.find(".kx-content p").text()).replace("[原文链接]", "")),
                            r = a.find(".kx-share").data("url"), s = "";
                        a.find(".kx-content img").length && (s = encodeURIComponent(a.find(".kx-content img").attr("src")))
                    } else if (a.length && a.hasClass("entry-footer")) {
                        a = t(".entry");
                        var o = encodeURIComponent(t.trim(a.find(".entry-title").text())),
                            n = encodeURIComponent(t.trim(a.find(".entry-content").text()).replace("[原文链接]", "")),
                            r = encodeURIComponent(window.location.href), s = "";
                        a.find(".entry-content img").length && (s = encodeURIComponent(a.find(".entry-content img").attr("src")))
                    } else if (a.length) {
                        var o = encodeURIComponent(t.trim(a.find("h2").text())),
                            n = encodeURIComponent(t.trim(a.find(".kx-content p").text()).replace("[原文链接]", "")),
                            r = e.closest(".kx-meta").data("url"), s = "";
                        a.find(".kx-content img").length && (s = encodeURIComponent(a.find(".kx-content img").attr("src")))
                    }
                    if (e.hasClass("weibo")) i = "http://service.weibo.com/share/share.php?url=" + r + "&title=" + o + "&pic=" + s + "&searchPic=true"; else if (e.hasClass("qq")) i = "https://connect.qq.com/widget/shareqq/index.html?url=" + r + "&title=" + o + "&desc=" + n + "&summary=&site=&pics=" + s; else if (e.hasClass("copy")) if (void 0 !== document.execCommand) {
                        var l = decodeURIComponent(o) + "\r\n" + decodeURIComponent(n) + "\r\n" + decodeURIComponent(r),
                            d = document.createElement("textarea");
                        d.value = l, t("body").append(d), d.style.position = "fixed", d.style.height = 0, d.select(), document.execCommand("copy"), d.remove(), alert("复制成功！")
                    } else alert("浏览器暂不支持拷贝功能");
                    i && window.open(i)
                })
            }), t(".navbar-search").on("click", ".j-navbar-search", function () {
                var e = t(this).parent();
                l ? e.hasClass("active") ? e.submit() : (e.addClass("active"), e.find(".navbar-search-input").focus()) : e.submit()
            }).on("keydown", ".navbar-search-input", function () {
                t(this).parent().removeClass("warning")
            }).on("submit", function () {
                var e = t(this);
                if ("" == t.trim(e.find(".navbar-search-input").val())) return e.addClass("warning"), e.find(".navbar-search-input").focus(), !1
            }), t(document).on("click", function (e) {
                0 == t(e.target).closest(".navbar-search").length && t(".navbar-search").removeClass("active warning")
            }), t("body").on("click", "#j-reading-back", function () {
                t("body").removeClass("reading"), t(this).remove(), o.trigger("scroll")
            }).on("click", "#j-reading", function () {
                t("body").addClass("reading").append('<div class="reading-back" id="j-reading-back"><i class="fa fa-reply"></i></div>')
            }), t(".entry").on("click", ".btn-zan", function () {
                var e = t(this);
                if (!e.hasClass("liked")) {
                    var a = e.data("id");
                    t.ajax({
                        type: "POST",
                        url: _wpcom_js.ajaxurl,
                        data: {action: "wpcom_like_it", id: a},
                        dataType: "json",
                        success: function (t) {
                            0 == t.result ? e.addClass("liked").find("span").html("(" + t.likes + ")") : -2 == t.result && e.addClass("liked")
                        }
                    })
                }
            }).on("click", ".j-heart", function () {
                var e = t(this), a = e.data("id");
                t.ajax({
                    type: "POST",
                    url: _wpcom_js.ajaxurl,
                    data: {action: "wpcom_heart_it", id: a},
                    dataType: "json",
                    success: function (a) {
                        0 == a.result ? e.addClass("hearted").find("span").html(a.favorites) : 1 == a.result ? e.removeClass("hearted").find("span").html(a.favorites) : -1 == a.result && t("#login-modal").modal()
                    }
                })
            }), t("#commentform").on("submit", function () {
                var e = t(".comment-form-comment textarea"), a = 0, i = 0, o = t(this).find("input.required");
                if ("" == t.trim(e.val()) && (e.addClass("error").focus(), i = 1, a = 1), o.each(function (e, o) {
                    var n = t(o);
                    "" == t.trim(n.val()) && (n.addClass("error"), 0 == i && (n.focus(), i = 1), a = 1)
                }), a) return !1
            }).on("keydown", ".required", function () {
                t(this).removeClass("error")
            }), t("#comments, #reviews").on("click", ".comment-must-login,#must-submit,.comment-reply-login", function () {
                return t("#login-modal").modal(), !1
            });
            var d = t(".entry-bar");
            d.length && o.width() > 767 && (e(), o.scroll(function () {
                e()
            })), t("#wrap").on("click", ".j-newslist .tab", function () {
                var e = t(this), a = e.parent(), i = e.closest(".main-list").find(".tab-wrap");
                a.find(".tab").removeClass("active"), e.addClass("active"), i.removeClass("active"), i.eq(e.index()).addClass("active");
                var o = e.find("a").data("id");
                if (o && 1 != e.data("loaded")) {
                    i.eq(e.index()).addClass("loading");
                    var n = a.data("type"), r = a.data("per_page");
                    t.ajax({
                        type: "POST",
                        url: _wpcom_js.ajaxurl,
                        data: {action: "wpcom_load_posts", id: o, type: n || "default", per_page: r},
                        dataType: "html",
                        success: function (a) {
                            if (i.eq(e.index()).removeClass("loading"), "0" == a) i.eq(e.index()).html('<li class="item"><p style="text-align: center;color:#999;margin:10px 0;">暂无内容</p></li>'); else {
                                var o = t(a);
                                i.eq(e.index()).html(o), o.find(".j-lazy").lazyload({
                                    webp: s,
                                    threshold: 250,
                                    effect: "fadeIn"
                                }), t(window).trigger("scroll")
                            }
                            e.data("loaded", 1)
                        },
                        error: function () {
                            i.eq(e.index()).html('<li class="item"><p style="text-align: center;color:#999;margin:10px 0;">加载失败，请稍后再试！</p></li>'), i.eq(e.index()).removeClass("loading")
                        }
                    })
                }
            }).on("click", ".j-load-more, .j-user-posts, .j-user-comments, .j-user-favorites, .j-load-kx", function () {
                if (!r) {
                    r = 1;
                    var e = t(this);
                    if (e.hasClass("disabled")) return void(r = 0);
                    var a = null, i = e.data("page");
                    if (i = i ? i + 1 : 2, e.hasClass("j-user-posts")) {
                        var o = t(".profile-posts-list").data("user");
                        a = {action: "wpcom_user_posts", user: o || 0, page: i}
                    } else if (e.hasClass("j-user-comments")) {
                        var o = t(".profile-comments-list").data("user");
                        a = {action: "wpcom_user_comments", user: o || 0, page: i}
                    } else if (e.hasClass("j-user-favorites")) {
                        var o = t(".profile-favorites-list").data("user");
                        a = {action: "wpcom_user_favorites", user: o || 0, page: i}
                    } else if (e.hasClass("j-load-kx")) a = {action: "wpcom_load_kuaixun", page: i}; else {
                        var o = e.data("id"), n = e.data("exclude"), l = e.closest(".main-list").find(".j-newslist"),
                            d = l.data("type"), c = l.data("per_page");
                        console.log(n), a = {
                            action: "wpcom_load_posts",
                            id: o,
                            page: i,
                            type: d || "default",
                            per_page: c,
                            exclude: n
                        }
                    }
                    e.parent().addClass("loading"), t.ajax({
                        type: "POST",
                        url: _wpcom_js.ajaxurl,
                        data: a,
                        dataType: "html",
                        success: function (a) {
                            if ("0" == a) e.addClass("disabled").text("已经到底了"); else {
                                var o = t(a);
                                if (e.hasClass("j-load-more")) e.parent().before(o); else if (e.hasClass("j-load-kx")) {
                                    t(o[0]).text() == t(".kx-list .kx-date:last").text() && o.first().hide(), e.parent().before(o), e.parent().parent().find(".kx-date:hidden").remove(), window.kxDate = t(".kx-list .kx-date");
                                    var n = o.find(".j-qrcode");
                                    n.length && t.each(n, function (e, a) {
                                        var i = t(a), o = i.data("text");
                                        i.qrcode({text: o})
                                    })
                                } else e.parent().prev().append(o);
                                o.find(".j-lazy").lazyload({
                                    webp: s,
                                    threshold: 250,
                                    effect: "fadeIn"
                                }), e.data("page", i), t(window).trigger("scroll")
                            }
                            e.parent().removeClass("loading"), r = 0
                        },
                        error: function () {
                            e.parent().removeClass("loading"), r = 0
                        }
                    })
                }
            }), t(".special-wrap").on("click", ".load-more", function () {
                var e = t(this);
                if (!e.hasClass("disabled")) {
                    var a = e.data("page");
                    a = a ? a + 1 : 2, e.parent().addClass("loading"), t.ajax({
                        type: "POST",
                        url: _wpcom_js.ajaxurl,
                        data: {action: "wpcom_load_special", page: a},
                        dataType: "html",
                        success: function (t) {
                            "0" == t ? e.addClass("disabled").text("已经到底了") : (e.closest(".special-wrap").find(".special-list").append(t), e.data("page", a)), e.parent().removeClass("loading")
                        },
                        error: function () {
                            e.parent().removeClass("loading")
                        }
                    })
                }
            })
        }(jQuery)
    }, {
        "../../../Themer/src/js/bootstrap": 1,
        "../../../Themer/src/js/common": 2,
        "../../../Themer/src/js/jquery.qrcode.min": 5,
        "../../../Themer/src/js/member": 6,
        "../../../Themer/src/js/swiper.jquery": 7,
        "../../../Themer/src/js/text-image": 8
    }]
}, {}, [9]);