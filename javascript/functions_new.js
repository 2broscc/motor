/*
 * functions.js
 *
 * Copyright (c) 2007 UiD Team
 * All Rights Reserved
 *
 */
var imgLoader = new Image();
var switchers = new Array();
var currentstyle = false;
var wait_flag = false;
var states = new Cookie("states", 30 * 24 * 60, "/");
var tagstack = new Array();
var noredirect = false;
var rb;
var html_clicked = false;
var ptimer = null;

jQuery.expr[':'].regex = function (elem, index, match) {
    var matchParams = match[3].split(',');

    var validLabels = /^(data|css):/;
    var attr = {
        method: matchParams[0].match(validLabels) ? matchParams[0].split(':')[0] : 'attr',
        property: matchParams.shift().replace(validLabels, '')
    };

    var regexFlags = 'ig';
    var regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g, ''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
};

jQuery.fn.extend({
    defuscate: function (settings) {
        settings = jQuery.extend({
            link: false,
            find: /\b(mailto:)?([A-Z0-9._%-]+) *\([^)]+\) *((?:[A-Z0-9-]+\.)+[A-Z]{2,6})\b/gi,
            replace: '$2@$3'
        }, settings);
        return this.each(function () {
            if ($(this).is('a[href]') && settings.find.test($(this).attr('href'))) {
                $(this).attr('href', 'mailto:' + $(this).attr('href').replace(settings.find, settings.replace));
                var is_link = true;
            }
            if (settings.find.test($(this).html())) {
                $(this).html($(this).html().replace(settings.find, (settings.link && !is_link ? '<a href="mailto:' + settings.replace + '">' + settings.replace + '</a>' : settings.replace)));
            }
        });
    },
    panelhandler: function (options) {
        options = jQuery.extend({
            speed: 'normal',
            pre_change: function () {},
            post_change: function () {}
        }, options);
        return this.each(function () {
            var swither = $(this);
            var cont = swither.parent();
            var state = 0;
            switch (cont.attr('class')) {
            case 'opened':
                state = 1;
                break;
            case 'closed':
                state = -1;
                break;
            case 'cookie':
            default:
                state = states.GetItem('panel');
                if (typeof(state) == 'undefined') state = 1;
                break;
            }
            if (state == 1) {
                $('#statusbar').hide();
                $('#panel').show();
                cont.removeClass().addClass('opened');
            } else {
                $('#panel').hide();
                $('#statusbar').show();
                cont.removeClass().addClass('closed');
            }
            states.SetItem('panel', state);
            swither.click(function () {
                if (wait(true)) return false;
                options.pre_change();
                var c = $(this).parent();
                var s1 = '';
                var s2 = '';
                var st = -1;
                var cn = '';
                if (states.GetItem('panel') == 1) {
                    s1 = '#panel';
                    s2 = '#statusbar';
                    st = -1;
                    cn = 'closed';
                } else {
                    s1 = '#statusbar';
                    s2 = '#panel';
                    st = 1;
                    cn = 'opened';
                }
                if (guianimations) {
                    $(s1).slideUp(options.speed, function () {
                        $(s2).slideDown(options.speed, function () {
                            states.SetItem('panel', st);
                            c.removeClass().addClass(cn);
                            options.post_change();
                            wait(false);
                        });
                    });
                } else {
                    $(s1).hide();
                    $(s2).show();
                    states.SetItem('panel', st);
                    c.removeClass().addClass(cn);
                    options.post_change();
                    wait(false);
                }
                return false;
            });
        });
    },
    sectionhandler: function (options) {
        options = jQuery.extend({
            speed: 'normal',
            pre_change: function () {},
            post_change: function () {}
        }, options);
        in_array = function (needle, stack) {
            var x;
            for (x in stack) {
                if (stack[x] === needle) {
                    return true;
                }
            }
            return false;
        };
        get_type = function (flags) {
            var x;
            for (x in flags) {
                if (flags[x] == 'normal') return 'normal';
                if (flags[x] == 'divided') return 'divided';
                if (flags[x] == 'notoggle') return 'notoggle';
            }
            return false;
        };
        get_state = function (flags) {
            var x;
            for (x in flags) {
                if (flags[x] == 'opened') return 'opened';
                if (flags[x] == 'closed') return 'closed';
                if (flags[x] == 'cookie') return 'cookie';
                if (flags[x] == 'auto') return 'auto';
            }
            return false;
        };
        return this.each(function () {
            var secti = $(this);
            var flags = secti.attr('class').split(' ');
            var stype = get_type(flags);
            var state = get_state(flags);
            var sbody = $('div.s_body', secti);
            var shead = $('div.s_head', secti);
            var saves = in_array('save', flags);
            if (!stype || (!state && stype != 'notoggle')) return;
            switch (stype) {
            case 'normal':
                switch (state) {
                case 'closed':
                    sbody.hide();
                    break;
                case 'opened':
                    sbody.show();
                    break;
                case 'auto':
                case 'cookie':
                    var st = states.GetItem(secti.attr('id'));
                    if (typeof(st) == 'undefined' || !st) {
                        sbody.show();
                    } else {
                        secti.addClass('closed');
                        sbody.hide();
                    }
                    break;
                default:
                    break;
                }
                shead.click(function () {
                    if (wait(true)) return false;
                    var ret = options.pre_change();
                    if (typeof ret == 'boolean' && !ret) {
                        wait(false);
                        return false;
                    }
                    if (secti.is('.closed')) {
                        secti.toggleClass('closed');
                        if (guianimations) {
                            sbody.slideToggle(options.speed, function () {
                                options.post_change();
                                wait(false);
                            });
                        } else {
                            sbody.show();
                            options.post_change();
                            wait(false);
                        }
                        if (saves) states.SetItem(secti.attr('id'), 0);
                    } else {
                        if (guianimations) {
                            sbody.slideToggle(options.speed, function () {
                                secti.toggleClass('closed');
                                options.post_change();
                                wait(false);
                            });
                        } else {
                            sbody.hide();
                            secti.toggleClass('closed');
                            options.post_change();
                            wait(false);
                        }
                        if (saves) states.SetItem(secti.attr('id'), 1);
                    }
                    return false;
                });
                break;
            case 'divided':
                var children = $('.s_body > div', secti);
                var i, a = -1;
                switch (state) {
                case 'closed':
                    children.hide();
                    sbody.hide();
                    secti.addClass('closed');
                    states.SetItem(secti.attr('id'), -1);
                    break;
                case 'opened':
                case 'auto':
                    var arr_children = children.get();
                    for (i in arr_children) {
                        if ($(arr_children[i]).is('.opened')) {
                            a = parseInt(i, 10) + 1;
                            break;
                        }
                    }
                    if (a == -1) {
                        secti.addClass('closed');
                        sbody.hide();
                        children.hide();
                    } else {
                        children.hide().eq(a - 1).show();
                        secti.removeClass('closed');
                        sbody.show();
                    }
                    states.SetItem(secti.attr('id'), a);
                    break;
                case 'cookie':
                    a = states.GetItem(secti.attr('id'));
                    if (typeof(a) == 'undefined') a = 1;
                    if (a == -1) {
                        children.hide();
                        secti.addClass('closed');
                        sbody.hide();
                    } else {
                        children.hide().eq(a - 1).show();
                        secti.removeClass('closed');
                        sbody.show();
                    }
                    states.SetItem(secti.attr('id'), a);
                    break;
                default:
                    break;
                }
                shead.click(function () {
                    if (wait(true)) return false;
                    options.pre_change();
                    var children = $('.s_body > div', secti);
                    var active = parseInt(states.GetItem(secti.attr('id')), 10);
                    if (active == -1) {
                        children.hide().eq(0).show();
                        secti.removeClass('closed');
                        if (guianimations) {
                            sbody.slideDown(options.speed, function () {
                                options.post_change();
                                wait(false);
                            });
                        } else {
                            sbody.show();
                            options.post_change();
                            wait(false);
                        }
                        states.SetItem(secti.attr('id'), 1);
                    } else if (active == children.length) {
                        if (guianimations) {
                            sbody.slideUp(options.speed, function () {
                                secti.addClass('closed');
                                children.hide();
                                options.post_change();
                                wait(false);
                            });
                        } else {
                            sbody.hide();
                            secti.addClass('closed');
                            children.hide();
                            options.post_change();
                            wait(false);
                        }
                        states.SetItem(secti.attr('id'), -1);
                    } else {
                        if (guianimations) {
                            sbody.slideUp(options.speed, function () {
                                children.hide().eq(active).show();
                                sbody.slideDown(options.speed, function () {
                                    options.post_change();
                                    wait(false);
                                });
                            });
                        } else {
                            sbody.hide();
                            children.hide().eq(active).show();
                            sbody.show();
                            options.post_change();
                            wait(false);
                        }
                        states.SetItem(secti.attr('id'), active + 1);
                    }
                    return false;
                });
                break;
            default:
                break;
            }
            return;
        });
    },
    mouseclicks: function (options) {
        options = jQuery.extend({
            sc_callback: function () {},
            dc_callback: function () {},
            sc_function: function () {},
            dc_latency: 300
        }, options);
        var mouseclick_flag = false;
        var mouseclick_timer;
        mouseclick_func = function (obj, c, o) {
            o.sc_function(obj);
            if (mouseclick_flag) {
                clearTimeout(mouseclick_timer);
                mouseclick_flag = false;
            } else {
                mouseclick_flag = true;
                mouseclick_timer = setTimeout(function () {
                    mouseclick_func(obj, 0, o);
                }, o.dc_latency);
                return false;
            }
            if (c) o.dc_callback(obj);
            else
            o.sc_callback(obj);
            return false;
        };
        return this.each(function () {
            $(this).click(function () {
                mouseclick_func(this, 1, options);
                return false;
            });
        });
    },
    mousestay: function (options) {
        options = jQuery.extend({
            latency: 1000,
            mousestay: function () {},
            mouseout: function () {}
        }, options);
        trackmouse = function (obj, e, o, ev) {
            var objid = obj.id;
            if (e) {
                clearTimeout(stayflags[objid][0]);
                stayflags[objid][1] = true;
                stayflags[objid][0] = setTimeout(function () {
                    stayflags[objid][1] = false;
                    o.mousestay(ev, obj);
                }, o.latency);
            } else {
                clearTimeout(stayflags[objid][0]);
                if (!stayflags[objid][1]) o.mouseout(ev, obj);
                stayflags[objid][1] = false;
            }
        };
        return this.each(function () {
            try {
                stayflags[this.id] = new Array(null, false);
            } catch (err) {
                stayflags = new Array();
                stayflags[this.id] = new Array(null, false);
            }
            $(this).hover(function (e) {
                trackmouse(this, true, options, e);
            }, function (e) {
                trackmouse(this, false, options, e);
            });
        });
    },
    inputbox: function (options) {
        options = jQuery.extend({
            checker: function () {}
        }, options);
        setflag = function (e, text, obj) {
            if (typeof text != 'string') {
                text = $(this).val();
            }
            if (typeof obj != 'object') {
                obj = $(this);
            }
            var state = options.checker(text, obj, e);
            var obj = obj.parent();
            var flag = obj.find('div.state');
            if (flag.size() == 1 && typeof state == 'object') {
                obj.removeClass('unknown error ok default').addClass(state.className);
                flag.attr('title', state.tooltipText);
            }
        };
        return this.each(function () {
            var field = $(this).find('input');
            field.bind('keyup change blur', setflag);
            setflag(false, field.val(), field);
        });
    }
});

function wait(m) {
    if (m) {
        if (wait_flag) return true;
        wait_flag = true;
        return false;
    } else {
        wait_flag = false;
        return false;
    }
}
function set_inputbox_state(selector, classstr, message) {
    var obj = $(selector);
    var flag = obj.find('div.state');
    if (flag.size() == 1) {
        obj.removeClass('unknown error ok default').addClass(classstr);
        flag.attr('title', message);
    }
};

function tabs_initialize() {
    $('ul#picker li').bind('click', function () {
        tabs_switch($(this).attr('id').replace(/p_(.*)/, '$1'));
    });
    return false;
}
function tabs_switch(tabid) {
    if (typeof tabid != 'string' || tabid.length == 0) {
        return false;
    }
    var current = tabs_get_active();
    if (typeof current == 'string' || current.length > 0) {
        if (current == tabid) return false;
        tabs_hide(current, tabid);
    } else {
        tabs_show(tabid);
    }
    return false;
}
function tabs_hide(tabid, toshow) {
    $('ul#picker li#p_' + tabid).removeClass('active');
    $('div#container div#c_' + tabid).fadeOut((guianimations ? 100 : 0), function () {
        tabs_show(toshow);
    });
    $('div#container div#c_' + tabid).removeClass('active');
    return false;
}
function tabs_show(tabid) {
    states.SetItem('selected_tab', tabid);
    $('ul#picker li#p_' + tabid).addClass('active');
    tabs_interact({
        target: tabid,
        method: 'getPageData'
    });
    $('div#container div#c_' + tabid).fadeIn((guianimations ? 100 : 0), function () {
        $('div#container div#c_' + tabid).addClass('active');
    });
    return false;
}
function tabs_get_active() {
    var tabid = $('ul#picker li.active').attr('id');
    if (typeof tabid != 'string' || tabid.length == 0) {
        return false;
    } else {
        return tabid.replace(/p_(.*)/, '$1');
    }
}
function tabs_set_label(tabid, label) {
    if (typeof tabid != 'string' || typeof label != 'string' || tabid.length == 0 || label.length == 0) {
        return false;
    } else {
        $('ul#picker li#p_' + tabid).html(label);
        return true;
    }
}
function tabs_interact(hash) {
    var target;
    var active = tabs_get_active();
    if (typeof hash.target == 'string' && hash.target.length > 0) {
        target = hash.target;
    } else {
        target = active;
    }
    if (!loggedin || target.length == 0 || typeof hash != 'object' || typeof hash.method != 'string' || hash.method.length == 0) {
        return false;
    }
    hash.target = target;
    $.getJSON(url_base + 'do/tabs.php', hash, function (ret) {
        pagetimer('restart');
        if (typeof ret.error != 'undefined') {
            alert(ret.error);
        } else {
            if (target == active) tabs_set_pager(ret.currentPage, ret.totalPages);
            if (typeof ret.returnValue == 'string' && ret.returnValue.length > 0) {
                $('div#container div#c_' + target).html(ret.returnValue);
            }
            if (typeof ret.execScript == 'string' && ret.execScript.length > 0) {
                eval(ret.execScript);
            }
        }
    });
    return false;
}
function tabs_set_pager(current, total) {
    current = parseInt(current);
    total = parseInt(total);
    if (total < 1 || current < 1 || current > total) {
        return false;
    }
    var pager = $('ul#pager');
    if (total < 2) {
        pager.addClass('hidden');
    } else {
        var prevb = $('ul#pager li#prevpage');
        var nextb = $('ul#pager li#nextpage');
        var currd = $('ul#pager li#pagedisp span#pager_current');
        var totld = $('ul#pager li#pagedisp span#pager_total');
        currd.html(current);
        totld.html(total);
        prevb.removeAttr('onclick');
        nextb.removeAttr('onclick');
        if (current == 1) {
            prevb.unbind().addClass('disabled');
        } else {
            prevb.unbind().bind('click', function () {
                tabs_interact({
                    method: 'gotoPage',
                    page: current - 1
                });
            }).removeClass('disabled');
        }
        if (current >= total) {
            nextb.unbind().addClass('disabled');
        } else {
            nextb.unbind().bind('click', function () {
                tabs_interact({
                    method: 'gotoPage',
                    page: current + 1
                });
            }).removeClass('disabled');
        }
        pager.removeClass('hidden');
    }
    return false;
}
function make_bookmarks_sortable() {
    $('div#c_bookmarks').sortable('destroy');
    var cnt = $('div#c_bookmarks div.bookmark').size();
    if (cnt > 1) {
        $('div#c_bookmarks').sortable({
            axis: 'y',
            items: 'div.bookmark',
            containment: 'parent',
            tolerance: 'pointer',
            update: function () {
                var tids = [];
                var ords = [];
                $('div#c_bookmarks div.bookmark').each(function () {
                    tids.push(parseInt($(this).attr('class').replace(/.*t([0-9]+).*/, "$1")));
                    ords.push(parseInt($(this).attr('class').replace(/.*o([0-9]+).*/, "$1")));
                });
                var prev = 0;
                var subj;
                var dist;
                var flag = false;
                for (var i in ords) {
                    dist = prev - ords[i];
                    if (Math.abs(dist) == 2 && !flag) {
                        flag = true;
                        prev = ords[i];
                        continue;
                    }
                    if (Math.abs(dist) != 1 || ords[i] < prev) {
                        subj = tids[i];
                        if (!flag) dist++;
                        break;
                    }
                    prev = ords[i];
                }
                tabs_interact({
                    target: 'bookmarks',
                    method: 'move',
                    tid: subj,
                    offs: (dist < 0 ? '-' : '+') + Math.abs(dist)
                });
            }
        });
    }
    if (cnt > 0) {
        $('div#c_bookmarks div.bookmark').hover(function () {
            $(this).find('div.buttons').fadeIn(guianimations ? 100 : 0);
        }, function () {
            $(this).find('div.buttons').fadeOut(guianimations ? 100 : 0);
        });
    }
}
function load_rss_feed(name) {
    if (typeof name == 'string' && name.length > 0) {
        $('#c_rssfeeds').rssNews('destroy').rssNews({
            feed: url_base + 'cache/rss/' + name,
            title: {
                selector: 'li#p_rssfeeds',
                prefix: 'RSS'
            }
        });
    }
    return false;
}
function switcher(sw, bl) {
    if (!sw || !bl) return false;
    var toHide = $('ul#' + sw + ' li.block.' + switchers[sw]);
    var toShow = $('ul#' + sw + ' li.block.' + bl);
    if (guianimations) {
        if (switchers[sw]) toHide.slideUp('fast');
        if (switchers[sw] != bl) toShow.slideDown('fast', function () {
            $('div.textarea textarea:visible', toShow).resizable({
                minHeight: 110,
                handles: 's'
            });
        });
    } else {
        if (switchers[sw]) toHide.hide();
        if (switchers[sw] != bl) toShow.show(function () {
            $('div.textarea textarea:visible', toShow).resizable({
                minHeight: 110,
                handles: 's'
            });
        });
    }
    switchers[sw] = switchers[sw] != bl ? bl : -1;
    return false;
}
function ScrollTo($target, speed, size) {
    var targetOffset = $target.offset().top;
    var viewportHeight = window.innerHeight ? window.innerHeight : $(window).height();
    var scrlTop = $('html, body').scrollTop();
    if (targetOffset + size > scrlTop + viewportHeight || targetOffset < scrlTop) {
        var t = ((size < viewportHeight && targetOffset >= scrlTop) ? targetOffset + size - viewportHeight : targetOffset);
        $('html, body').animate({
            scrollTop: t
        }, speed);
    }
}
function getratio(d, u, c) {
    if (typeof d != "number" || typeof u != "number" || typeof c != "boolean") return false;
    var r = (!d || !u) ? 0 : Math.round((u / d) * 1000) / 1000;
    var s = new String(r);
    var z = '';
    if (r == 0) {
        t = 'Nincs';
    } else if (r > 100) {
        t = "&gt;100";
    } else if (s.lastIndexOf('.') != -1) {
        t = r;
        var q = 3 - s.substr(s.lastIndexOf('.') + 1).length;
        for (var i = 0; i < q; ++i) t += '0';
    } else {
        t = r + '.000';
    }
    return c ? '<span class="' + getratiolevel(r) + '">' + t + '</span>' : r;
}
function getratiolevel(r) {
    if (typeof r != "number") {
        return ("ratio0");
    } else if (r < 0.5) {
        return ("ratio1");
    } else if (r < 0.8) {
        return ("ratio2");
    } else if (r < 1.2) {
        return ("ratio3");
    } else if (r < 2) {
        return ("ratio4");
    } else {
        return ("ratio5");
    }
}
function set_ratiobar(d, u, f) {
    if (typeof u != "number" || typeof d != "number" || typeof f != "number") return false;
    var dnlbar = (d > 0) ? Math.round(((d / (d + u)) * 100)) : 50;
    var uplbar = 100 - dnlbar;
    rb.ratio.html(getratio(d, u, true) + (!f || !d || !u ? '' : (f < 0 ? ' -' : ' +')));
    if (!d || !u) {
        var ustr = '<span>' + (f ? '' : '50%') + '</span>';
        var dstr = '<span>' + (f ? '' : '50%') + '</span>';
    } else if (f == 0) {
        var ustr = '<span>' + uplbar + '%</span>';
        var dstr = '<span>' + dnlbar + '%</span>';
    } else if (f == -1) {
        var ustr = '';
        var dstr = '<span>le: ' + bytes_to_string((uploaded / (u / d)) - downloaded, (dnlbar > 30 ? 3 : 1), '') + '</span>';
    } else {
        var ustr = '<span>fel: ' + bytes_to_string(((u / d) * downloaded) - uploaded, (uplbar > 30 ? 3 : 1), '') + '</span>';
        var dstr = '';
    }
    rb.ul.css('width', uplbar + '%').html(uplbar >= (!f ? 18 : 0) ? ustr : '');
    rb.dl.css('width', dnlbar + '%').html(dnlbar >= (!f ? 18 : 0) ? dstr : '');
    return false;
}
function track_ratiobar(e) {
    if (wait(true)) return;
    if (typeof uploaded != "number" || typeof downloaded != "number" || uploaded < 0 || downloaded < 0) {
        wait(false);
        return false;
    }
    var l = e.pageX - rb.offset.left;
    if (!l) l++;
    var u = (l / rb.width) * (downloaded + uploaded);
    var d = (downloaded + uploaded) - u;
    set_ratiobar(d, u, ((l < rb.marker) ? -1 : 1));
    wait(false);
    return false;
}
function bytes_to_string(bytes, precision, unit) {
    if (typeof bytes != "number") return false;
    if (typeof precision != "number") precision = 2;
    if (typeof unit != "string") unit = 'B';
    var r = new Array('', 'k', 'M', 'G', 'T', 'P', 'E');
    for (var i = 0; i < r.length && bytes >= 1024; i++) bytes /= 1024;
    return (Math.round(bytes * Math.pow(10, precision)) / Math.pow(10, precision)) + r[(bytes >= 1024 ? i - 1 : i)] + unit;
}
function submitform(id) {
    $('form#' + id)[0].submit();
    return false;
}
function dltorrent(id) {
    return download(url_base + 'download.php?id=' + id);
}
function download(url) {
    window.location.replace(url);
    return false;
}

// it'S may be useful
function goback() {
    history.back();
    return false;
}
function gotourl(url) {
    window.location = url;
    return false;
}
function radioPopup() {
    window.open('http://www.last.fm/webclient/popup/?radioURL=lastfm://group/UiD&resourceID=undefined&resourceType=undefined', '_blank', 'height=300,width=300,top=10,left=10,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,copyhistory=no,resizable=no');
    return false;
}
function gotouser(id) {
    return gotourl(url_base + "user.php?uid=" + id);
}
function pagetimer(action) {
    if (typeof idletimems != 'undefined' && idletimems > 0) {
        if (action == 'start') {
            ptimer = setTimeout("timeout()", idletimems);
        } else if (action == 'restart') {
            clearTimeout(ptimer);
            pagetimer('start');
        } else if (action == 'stop') {
            clearTimeout(ptimer);
        }
    }
}
function timeout() {
    $.post('index.php', {
        timeout: 1
    }, function (res) {
        $.fn.colorbox({
            width: '392px',
            title: 'Bejelentkezés',
            html: res,
            overlayClose: false,
            onLoad: function () {
                $('#cboxClose').hide();
                $(document).unbind('keydown.cbox_close');
            }
        });
        noredirect = true;
        $.getScript(url_base + 'js/md5.js', function () {
            $.getScript(url_base + 'js/jquery.form.js', function () {
                $.getScript(url_base + 'js/login.js');
            });
        });
    });
    return false;
}
function news_toggle(id) {
    $('div#news_' + id + ' div.n_text').slideToggle('fast', function () {
        $('div#news_' + id).toggleClass('hidden');
    });
    return false;
}

//!!!
function loading_gif(on) {
    var o = $('div#loading');
    if (!o.size()) {
        $('body').prepend('<div id="loading"><img src="' + imgLoader.src + '" alt="Betöltés..." /></div>');
        o = $('div#loading');
    }
    if (on) {
        o.show();
        o.css({
            marginLeft: '-' + (Math.round(o.width() / 2)) + 'px',
            marginTop: '-' + (Math.round(o.height() / 2) + 100) + 'px'
        });
    } else {
        o.hide();
    }
}
function delmodcomment(id) {
    if (!id) return false;
    if (wait(true)) return false;
    $.post('modcomments.php', {
        action: 'delete',
        id: id
    }, function () {
        if (id.charAt(0) == 't') {
            id = id.substr(1);
            $('tr#t' + id + ' img.fl_mod').removeClass('faulty').removeClass('unchecked').removeClass('welldone').addClass('welldone');
            $('li#btn_check_' + id + ' img').attr('src', theme_path + '/tflag_modcheck_2.png');
        } else {
            id = id.substr(1);
        }
        $('div#mc' + id).remove();
        wait(false);
    });
    return false;
}
function tcheck(id) {
    if (!id) return false;
    if (wait(true)) return false;
    $.getJSON(url_base + 'do/tcheck.php', {
        id: id
    }, function (res) {
        pagetimer('restart');
        if (res['success']) {
            var li = $('li#btn_check_' + id);
            var sp = $('span', li);
            var im = $('img', li);
            li.attr('onclick', res['onclick']);
            sp.html(res['checker']);
            switch (res['state']) {
            case 'faulty':
                im.attr('src', theme_path + '/tflag_modcheck_1.png');
                break;
            case 'unchecked':
                im.attr('src', theme_path + '/tflag_modcheck_0.png');
                break;
            case 'welldone':
                im.attr('src', theme_path + '/tflag_modcheck_2.png');
            }
            $('div#t' + id + ' li.fl_mod').removeClass('faulty unchecked welldone').addClass(res['state']);
        } else {
            alert('Ismeretlen hiba!');
        }
        wait(false);
    });
    return false;
}
function peertest(link, id) {
    if (!id) return false;
    if (wait(true)) return false;
    $(link).html('teszt...');
    $.post(url_base + 'do/peertest.php', {
        id: id
    }, function (res) {
        pagetimer('restart');
        if (res == 'error') {
            alert('Ismeretlen hiba!');
        } else {
            $(link).removeClass().addClass(res == '1' ? 'passive' : 'active').html(res == '1' ? 'Passzív' : 'Aktív');
        }
        wait(false);
    });
    return false;
}
function tthanks(id) {
    if (!id) return false;
    if (wait(true)) return false;
    $.post(url_base + 'do/thankyou.php', {
        id: id
    }, function (res) {
        pagetimer('restart');
        if (res == 'error') {
            alert('Ismeretlen hiba!');
        } else {
            $('div#thanks').html(res);
        }
        wait(false);
    });
    return false;
}
function thide(id) {
    if (!id) return false;
    if (wait(true)) return false;
    $.post(url_base + 'do/thide.php', {
        id: id
    }, function (res) {
        pagetimer('restart');
        var btn = $('li#btn_hide_' + id);
        if (res == 'hidden') {
            btn.find('span').html('Torrent mutatása');
            btn.find('img').attr('src', theme_path + '/icon_hidden.png');
            $('div#t' + id + ' li.fl_hdn').removeClass('h');
        } else {
            btn.find('span').html('Torrent rejtése');
            btn.find('img').attr('src', theme_path + '/icon_hide.png');
            $('div#t' + id + ' li.fl_hdn').addClass('h');
        }
        wait(false);
    });
    return false;
}
function tlock(id) {
    if (!id) return false;
    if (wait(true)) return false;
    $.post(url_base + 'do/tlock.php', {
        id: id
    }, function (res) {
        pagetimer('restart');
        var btn = $('li#btn_lock_' + id);
        if (res == 'locked') {
            btn.find('span').html('Hozzászólás engedése');
            btn.find('img').attr('src', theme_path + '/icon_locked.png');
            $('div#t' + id + ' li.fl_cml').removeClass('h');
        } else {
            btn.find('span').html('Hozzászólás letiltása');
            btn.find('img').attr('src', theme_path + '/icon_lock.png');
            $('div#t' + id + ' li.fl_cml').addClass('h');
        }
        wait(false);
    });
    return false;
}
function report(id, m, obj) {
    if (!id) return false;
    if (wait(true)) return false;
    var problem = prompt(m, '');
    if (problem !== null && problem !== '') {
        $.post(url_base + 'do/report.php', {
            problem: problem,
            id: id,
            obj: obj
        }, function (res) {
            pagetimer('restart');
            if (res != 'ok') {
                alert('Feldolgozási hiba!');
            } else {
                alert('Jelentésedet regisztráltuk, köszönjük a segítőkészséged!');
                $('#report').hide();
            }
            wait(false);
        });
    } else {
        wait(false);
    }
    return false;
}
function treport(id) {
    return report(id, 'A probléma a torrenttel kapcsolatban:', 1);
}
function ureport(id) {
    return report(id, 'A probléma a felhasználóval kapcsolatban:', 2);
}
function isvalidnick(nick) {
    if (typeof nick != 'string') return 1;
    if (nick.length < 3 || nick.length > 15) return 1;
    if (!(/^[a-z0-9]*$/i).test(nick)) return 2;
    return 0;
}
function isvalidemail(email) {
    if (typeof email != 'string') return false;
    return (/^[\w.-]+@([\w.-]+\.)+[a-z]{2,6}$/i).test(email);
}
function isvalidurl(url) {
    if (typeof url != 'string') return false;
    return (/^(http|https|ftp):\/\/(([a-z0-9][a-z0-9_-]*)(\.[a-z0-9][a-z0-9_-]*)+)(:\d{1,5})?\//i).test(url);
}
function get_cookie(name) {
    var start = document.cookie.indexOf(name + "=");
    var len = start + name.length + 1;
    if ((!start) && (name != document.cookie.substring(0, name.length))) {
        return null;
    }
    if (start == -1) return null;
    var end = document.cookie.indexOf(";", len);
    if (end == -1) end = document.cookie.length;
    return unescape(document.cookie.substring(len, end));
}
function set_cookie(name, value, expires, path, domain, secure) {
    var today = new Date();
    today.setTime(today.getTime());
    if (expires) {
        expires = expires * 1000 * 60;
    }
    var expires_date = new Date(today.getTime() + (expires));
    document.cookie = name + "=" + escape(value) + ((expires) ? ";expires=" + expires_date.toGMTString() : "") + ((path) ? ";path=" + path : "") + ((domain) ? ";domain=" + domain : "") + ((secure) ? ";secure" : "");
}
function delete_cookie(name, path, domain) {
    if (get_cookie(name)) document.cookie = name + "=" + ((path) ? ";path=" + path : "") + ((domain) ? ";domain=" + domain : "") + ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}
function Cookie(name, duration, path, domain, secure) {
    this.affix = "";
    if (duration) {
        var date = new Date();
        date.setTime(date.getTime() + (1000 * 60 * duration));
        this.affix = "; expires=" + date.toGMTString();
    }
    if (path) this.affix += "; path=" + path;
    if (domain) this.affix += "; domain=" + domain;
    if (secure) this.affix += "; secure=" + secure;

    function getValue() {
        var m = document.cookie.match(new RegExp("(" + name + "=[^;]*)(;|$)"));
        return m ? m[1] : null;
    }
    this.cookieExists = function () {
        return getValue() ? true : false;
    };
    this.Delete = function () {
        document.cookie = name + "=noop; expires=Thu, 01-Jan-1970 00:00:01 GMT";
    };
    this.SetItem = function (key, value) {
        var ck = getValue();
        if (/[;, ]/.test(value)) {
            value = window.encodeURI ? encodeURI(value) : escape(value);
        }
        if (value) {
            var attrPair = "@" + key + value;
            if (ck) {
                if (new RegExp("@" + key).test(ck)) {
                    document.cookie = ck.replace(new RegExp("@" + key + "[^@;]*"), attrPair) + this.affix;
                } else {
                    document.cookie = ck.replace(new RegExp("(" + name + "=[^;]*)(;|$)"), "$1" + attrPair) + this.affix;
                }
            } else {
                document.cookie = name + "=" + attrPair + this.affix;
            }
        } else {
            if (new RegExp("@" + key).test(ck)) {
                document.cookie = ck.replace(new RegExp("@" + key + "[^@;]*"), "") + this.affix;
            }
        }
    };
    this.GetItem = function (key) {
        var ck = getValue();
        if (ck) {
            var m = ck.match(new RegExp("@" + key + "([^@;]*)"));
            if (m) {
                var value = m[1];
                if (value) {
                    return window.decodeURI ? decodeURI(value) : unescape(value);
                }
            }
        }
    };
}
function bbcolor() {
    $('select#colors').css('background-color', $('select#colors').val());
    switch ($('select#colors').val()) {
    case 'black':
        $('select#colors').css('color', 'white');
        break;
    case 'white':
        $('select#colors').css('color', 'black');
        break;
    case 'green':
        $('select#colors').css('color', 'lime');
        break;
    case 'maroon':
        $('select#colors').css('color', 'red');
        break;
    case 'olive':
        $('select#colors').css('color', 'yellow');
        break;
    case 'navy':
        $('select#colors').css('color', 'aqua');
        break;
    case 'purple':
        $('select#colors').css('color', 'fuchsia');
        break;
    case 'gray':
        $('select#colors').css('color', 'white');
        break;
    case 'yellow':
        $('select#colors').css('color', 'olive');
        break;
    case 'lime':
        $('select#colors').css('color', 'green');
        break;
    case 'aqua':
        $('select#colors').css('color', 'navy');
        break;
    case 'fuchsia':
        $('select#colors').css('color', 'purple');
        break;
    case 'silver':
        $('select#colors').css('color', 'black');
        break;
    case 'red':
        $('select#colors').css('color', 'maroon');
        break;
    case 'blue':
        $('select#colors').css('color', 'aqua');
        break;
    case 'teal':
        $('select#colors').css('color', 'aqua');
        break;
    default:
        break;
    }
}
function getbbtag(tag, which) {
    switch (tag) {
    case 'size':
        o = "[size=" + $('select#sizes').val() + "]";
        c = "[/size]";
        break;
    case 'color':
        o = "[color=" + $('select#colors').val() + "]";
        c = "[/color]";
        break;
    case 'bold':
        o = "[b]";
        c = "[/b]";
        break;
    case 'italic':
        o = "[i]";
        c = "[/i]";
        break;
    case 'underline':
        o = "[u]";
        c = "[/u]";
        break;
    case 'overline':
        o = "[o]";
        c = "[/o]";
        break;
    case 'strikethrough':
        o = "[s]";
        c = "[/s]";
        break;
    case 'alignleft':
        o = "[align=left]";
        c = "[/align]";
        break;
    case 'aligncenter':
        o = "[align=center]";
        c = "[/align]";
        break;
    case 'alignright':
        o = "[align=right]";
        c = "[/align]";
        break;
    case 'alignjustify':
        o = "[align=justify]";
        c = "[/align]";
        break;
    case 'quote':
        o = "[quote]";
        c = "[/quote]";
        break;
    case 'spoiler':
        o = "[spoiler]";
        c = "[/spoiler]";
        break;
    case 'url':
        o = "[url]";
        c = "[/url]";
        break;
    case 'mail':
        o = "[email]";
        c = "[/email]";
        break;
    case 'google':
        o = "[google]";
        c = "[/google]";
        break;
    case 'image':
        o = "[img]";
        c = "[/img]";
        break;
    case 'flash':
        o = "[swf=400x300]";
        c = "[/swf]";
        break;
    case 'youtube':
        o = "[youtube]";
        c = "[/youtube]";
        break;
    case 'media':
        o = "[wmp=400x300]";
        c = "[/wmp]";
        break;
    case 'list':
        o = "[list]";
        c = "[/list]";
        break;
    default:
        break;
    }
    if (which == 'o') return o;
    if (which == 'c') return c;
}
function addbb(tag) {
    var opos = 0;
    var cpos = 0;
    var spos = 0;
    textarea = $('textarea#' + bbttext).get(0);
    textarea.focus();
    spos = textarea.scrollTop;
    if (document.selected) {
        selected = document.selected.createRange().text;
        if ($.browser.msie) {
            var range = document.selected.createRange();
            var rangeCopy = range.duplicate();
            rangeCopy.moveToElementText(textarea);
            opos = -1;
            while (rangeCopy.inRange(range)) {
                rangeCopy.moveStart("character");
                opos++;
            }
        } else {
            opos = textarea.selectionStart;
            cpos = textarea.selectionEnd;
        }
    } else if (textarea.selectionStart || textarea.selectionStart == "0") {
        opos = textarea.selectionStart;
        cpos = textarea.selectionEnd;
        selected = textarea.value.substring(opos, cpos);
    } else {
        selected = "";
    }
    var otag = "";
    var ctag = "";
    var n = tagstack.length;
    if (tag == 'close_tags') {
        for (i = n - 1; i >= 0; i--) {
            ctag += tagstack[i];
            tagstack.pop();
        }
    } else if (tag == 'clean_tags') {
        selected = selected.replace(new RegExp("\\[(.*?)\\]", "g"), "");
    } else {
        otag = getbbtag(tag, 'o');
        ctag = getbbtag(tag, 'c');
        if (selected == "") {
            var topen = false;
            for (var i = 0; i < n; i++) {
                if (tagstack[i] == tag) {
                    topen = true;
                    break;
                }
            }
            if (!topen) {
                if (ctag) {
                    tagstack.push(tag);
                }
                ctag = "";
            } else {
                tagstack.pop();
                otag = "";
            }
        }
    }
    var str = otag + selected + ctag;
    var start = opos + otag.length + selected.length + ctag.length;
    var end = start;
    if (document.selected) {
        newSelection = document.selected.createRange();
        newSelection.text = str;
    } else if (opos || opos == "0") {
        textarea.value = textarea.value.substr(0, opos) + str + textarea.value.substr(cpos, textarea.value.length);
    } else {
        textarea.value += str;
    }
    if (textarea.createTextRange) {
        range = textarea.createTextRange();
        range.collapse(true);
        range.moveStart("character", start);
        range.moveEnd("character", end - start);
        range.select();
    } else if (textarea.setSelectionRange) {
        textarea.setSelectionRange(start, end);
    }
    textarea.scrollTop = spos;
    textarea.focus();
}
function smileyselector() {
    var link = 'smileyselector.php?form=' + bbtform + '&text=' + bbttext;
    var newwin = window.open(link, 'moresmile', 'height=500,width=550,resizable=no,scrollbars=yes');
    if (window.focus) newwin.focus();
}



//useful

function post_data(phpfile, arguments) {
    if (phpfile === '') return false;
    if (arguments === '') return false;
    var argumentlist = arguments.split(';');
    do {
        var formid = String(Math.random()).replace('.', '');
    } while ($('#' + formid).size() > 0);
    var appendstring = '<form method="post" action="' + phpfile + '" name="' + formid + '" id="' + formid + '">';
    for (x in argumentlist) {
        var argdata = argumentlist[x].split(':');
        appendstring = appendstring + '<input type="hidden" name="' + argdata[0] + '" value="' + argdata[1] + '" />';
    }
    $('body').append(appendstring + '</form>');
    $('#' + formid).get(0).submit();
    return false;
}
function a_opt(action, id, type) {
    switch (action) {
    case 1:
        post_data(type + '.php', 'module:edit;id:' + id);
        break;
    case 2:
        if (confirm('Biztosan törlöd?')) post_data(type + '.php', 'module:delete;id:' + id);
        break;
    case 3:
        post_data(type + '.php', 'module:new');
        break;
    case 4:
        post_data(type + '.php', 'module:up;id:' + id);
        break;
    case 5:
        post_data(type + '.php', 'module:down;id:' + id);
        break;
    default:
        return false;
    }
    return false;
}
function a_submit() {
    if ($('#title').val() === '') {
        alert('A cikknek nincs címe!');
    } else if ($('#text').val() === '') {
        alert('A cikknek nincs szövege!');
    } else {
        document.editor.submit();
    }
}
function selectText(selector) {
    var selection, range, doc, win;
    var node = $(selector);
    if (node.size() < 1) {
        return false;
    } else {
        node = node.get(0);
        if ((doc = node.ownerDocument) && (win = doc.defaultView) && (typeof win.getSelection != 'undefined') && (typeof doc.createRange != 'undefined') && (selection = window.getSelection()) && (typeof selection.removeAllRanges != 'undefined')) {
            range = doc.createRange();
            range.selectNode(node);
            selection.removeAllRanges();
            selection.addRange(range);
        } else if (document.body && (typeof document.body.createTextRange != 'undefined') && (range = document.body.createTextRange())) {
            range.moveToElementText(node);
            range.select();
        }
        return false;
    }
}
function charlimit(field, limit, disp) {
    if ($('#' + field).val().length > limit) {
        $('#' + field).val($('#' + field).val().substr(0, limit));
        alert('Túllépted a megengedett ' + limit + ' karakteres határt!');
    }
    if (disp) $('#' + disp).html(limit - $('#' + field).val().length);
}
function jshtmlentities(str) {
    str = str.replace(/&/g, '&amp;');
    str = str.replace(/\'/g, '&apos;');
    str = str.replace(/\"/g, '&quot;');
    str = str.replace(/</g, '&lt;');
    str = str.replace(/>/g, '&gt;');
    return str;
}
function polledit(id) {
    $('input#' + id).val($('input#' + id).val().replace("\"", ""));
    $('input#' + id).val($('input#' + id).val().substr(0, 60));
}

//slider of the menu

function menuslider() {
    function li_pos(i) {
        if (i > 0) {
            return li_base + (i * li_w);
        } else {
            return li_b1st;
        }
    }
    function mslide(i) {
        if (guianimations) {
            li_slider.dequeue().animate({
                left: li_pos(i)
            }, 'normal');
        } else {
            li_slider.css('left', li_pos(i) + 'px');
        }
    }
    if ($('ul#menuitems').size() != 1) return;
    $('ul#menuitems').append('<div id="slider" class="sslider"></div>');
    var li_list = $('#menuitems>li');
    var li_slider = $('#sslider');
    var li_w = li_list.eq(1).width();
    var li_w1st = li_list.eq(0).width();
    var li_wsld = li_slider.width();
    var li_base = parseInt(li_w1st - li_w + ((li_w - li_wsld) / 2));
    var li_b1st = parseInt((li_w1st - li_wsld) / 2);
    var li_active = li_list.index($('#menuitems>li.active')[0]);
    li_active = (li_active < 0 ? 0 : li_active);
    li_slider.css('left', li_pos(li_active) + 'px');
    li_list.each(function (i) {
        $(this).hover(function () {
            mslide(i);
        }, function () {
            mslide(li_active);
        });
    });
}
function table_styles(id, is) {
    if (typeof is == 'undefined') is = false;
    if (typeof id == 'undefined') id = false;
    $((!id ? 'table.skinned' : id)).each(function () {
        var trstack = $('tr', this).not('.noskin');
        $('td:first-child', trstack).addClass('mostleft');
        $('td:last-child', trstack).addClass('mostright');
        $('td.vsep', trstack).prev().addClass('mostright');
        $('td.vsep', trstack).next().addClass('mostleft');
        $(trstack).filter('tr:first-child').addClass('tshead');
        trstack = $(trstack).not(':first-child');
        $(trstack).filter('tr:nth-child(odd)').addClass('ts' + (is ? 'even' : 'odd'));
        $(trstack).filter('tr:nth-child(even)').addClass('ts' + (is ? 'odd' : 'even'));
        $(trstack).filter('tr:last-child').addClass('tsfoot');
        $(trstack).filter('.tssep').addClass('nohover');
    });
}
function blank_targeted_anchors() {
    $('a._blank, a[rel="external"]').attr('target', '_blank');
}
function parseStyle(styles) {
    var newStyles = {};
    if (typeof styles == 'string') {
        styles = styles.toLowerCase().split(';');
        for (var i = 0; i < styles.length; i++) {
            rule = styles[i].split(':');
            if (rule.length == 2) {
                newStyles[jQuery.trim(rule[0].replace(/\-(\w)/g, function (m, c) {
                    return c.toUpperCase();
                }))] = jQuery.trim(rule[1]);
            }
        }
    }
    return newStyles;
}
$(function () {
    imgLoader.src = theme_path + '/loading.gif';
    $('div.section').not('.noinit').sectionhandler();
    var warn = $('div#panel img.warn');
    if (warn.length) {
        var wbi = new Image();
        var wbf = $('#warn_balloon.forced');
        var wbn = $('#warn_balloon');
        wbi.src = theme_path + '/warn_balloon.png';
        warn.mousestay({
            latency: 600,
            mousestay: function () {
                if (guianimations) wbn.not('.forced').fadeIn('fast');
                else
                wbn.not('.forced').show();
            },
            mouseout: function () {
                if (guianimations) wbn.not('.forced').fadeOut('fast');
                else
                wbn.not('.forced').hide();
            }
        });
        if (wbf.length) {
            $('div#panelswitcher').panelhandler({
                pre_change: function () {
                    if ($('#panelcontainer').attr('class') != 'closed') $('#warn_balloon.forced').hide();
                },
                post_change: function () {
                    if ($('#panelcontainer').attr('class') != 'closed') $('#warn_balloon.forced').show();
                }
            });
            $('div.close', wbf).click(function () {
                if (guianimations) wbf.fadeOut('fast').removeClass('forced').unbind('click');
                else
                wbf.hide().removeClass('forced').unbind('click');
            });
        } else {
            $('div#panelswitcher').panelhandler();
        }
    } else {
        $('div#panelswitcher').panelhandler();
    }
    if (loggedin) {
        $('div#banners').mousestay({
            latency: 600,
            mousestay: function () {
                if (guianimations) $('div#banners').dequeue().switchClass('banners_closed', 'banners_opened', 'slow');
                else
                $('div#banners').removeClass('banners_closed').addClass('banners_opened');
            },
            mouseout: function () {
                if (guianimations) $('div#banners').dequeue().switchClass('banners_opened', 'banners_closed', 'slow');
                else
                $('div#banners').removeClass('banners_opened').addClass('banners_closed');
            }
        });
    }
    table_styles();
    blank_targeted_anchors();
    $('a[href]').defuscate();
    menuslider();
    if (loggedin) {
        tabs_initialize();
        make_bookmarks_sortable();
    }
    tabs_interact({
        target: 'rssfeeds',
        method: 'gotoPage',
        page: -1
    });
    if (loggedin && $('div#ratiometer').size() == 1 && uploaded > 0 && downloaded > 0) {
        rb = {
            meter: $('div#ratiometer'),
            ratio: $('span#rt_value'),
            ul: $('div#ul'),
            dl: $('div#dl'),
            width: $('div#ratiometer').width(),
            marker: (uploaded / (downloaded + uploaded)) * ($('div#ratiometer').width()),
            offset: $('div#ratiometer').offset(),
            record: function (e) {
                rb.event = e;
            }
        };
        rb.meter.mousestay({
            latency: 600,
            mousestay: function () {
                rb.meter.bind('mousemove', track_ratiobar);
                track_ratiobar(rb.event);
            },
            mouseout: function () {
                rb.meter.unbind('mousemove').bind('mousemove', rb.record);
                set_ratiobar(downloaded, uploaded, 0);
            }
        }).bind('mousemove', rb.record);
    }
    $('div.avatar').mousestay({
        latency: 600,
        mousestay: function (e, obj) {
            if (guianimations) {
                $('img.as_enabled', obj).fadeIn('normal');
            } else {
                $('img.as_enabled', obj).show();
            }
        },
        mouseout: function (e, obj) {
            if (guianimations) {
                $('img.as_enabled', obj).fadeOut('normal');
            } else {
                $('img.as_enabled', obj).hide();
            }
        }
    });
    $('html').click(function (e) {
        if (html_clicked) return;
        html_clicked = true;
        $('#background_credit').fadeOut('slow', function () {
            $('#wrapper1').show();
            html_clicked = false;
        });
    });
    $('html').dblclick(function (e) {
        if ($(e.target).is('html') || $(e.target).is('body')) {
            if (html_clicked) return;
            html_clicked = true;
            $('#wrapper1').hide();
            $('#background_credit').fadeIn('slow', function () {
                html_clicked = false;
            });
        }
    });
    $('div.textarea textarea:visible').resizable({
        minHeight: 110,
        handles: 's'
    });
    $('.bb-spoiler').live('click', function () {
        $(this).find('.layer').toggle('fast');
    });
    if (loggedin) pagetimer('start');
});