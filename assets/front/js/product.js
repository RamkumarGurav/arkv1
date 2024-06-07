/*! lightslider - v1.1.5 - 2015-10-31
* https://github.com/sachinchoolur/lightslider
* Copyright (c) 2015 Sachin N; Licensed MIT */
(function ($, undefined) {
    'use strict';
    var defaults = {
        item: 3,
        autoWidth: false,
        slideMove: 1,
        slideMargin: 10,
        addClass: '',
        mode: 'slide',
        useCSS: true,
        cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',
        easing: 'linear', //'for jquery animation',//
        speed: 400, //ms'
        auto: false,
        pauseOnHover: false,
        loop: false,
        slideEndAnimation: true,
        pause: 2000,
        keyPress: false,
        controls: true,
        prevHtml: '',
        nextHtml: '',
        rtl: false,
        adaptiveHeight: false,
        vertical: false,
        verticalHeight: 500,
        vThumbWidth: 100,
        thumbItem: 10,
        pager: true,
        gallery: false,
        galleryMargin: 5,
        thumbMargin: 5,
        currentPagerPosition: 'middle',
        enableTouch: true,
        enableDrag: true,
        freeMove: true,
        swipeThreshold: 40,
        responsive: [],
        /* jshint ignore:start */
        onBeforeStart: function ($el) {},
        onSliderLoad: function ($el) {},
        onBeforeSlide: function ($el, scene) {},
        onAfterSlide: function ($el, scene) {},
        onBeforeNextSlide: function ($el, scene) {},
        onBeforePrevSlide: function ($el, scene) {}
        /* jshint ignore:end */
    };
    $.fn.lightSlider = function (options) {
        if (this.length === 0) {
            return this;
        }

        if (this.length > 1) {
            this.each(function () {
                $(this).lightSlider(options);
            });
            return this;
        }

        var plugin = {},
            settings = $.extend(true, {}, defaults, options),
            settingsTemp = {},
            $el = this;
        plugin.$el = this;

        if (settings.mode === 'fade') {
            settings.vertical = false;
        }
        var $children = $el.children(),
            windowW = $(window).width(),
            breakpoint = null,
            resposiveObj = null,
            length = 0,
            w = 0,
            on = false,
            elSize = 0,
            $slide = '',
            scene = 0,
            property = (settings.vertical === true) ? 'height' : 'width',
            gutter = (settings.vertical === true) ? 'margin-bottom' : 'margin-right',
            slideValue = 0,
            pagerWidth = 0,
            slideWidth = 0,
            thumbWidth = 0,
            interval = null,
            isTouch = ('ontouchstart' in document.documentElement);
        var refresh = {};

        refresh.chbreakpoint = function () {
            windowW = $(window).width();
            if (settings.responsive.length) {
                var item;
                if (settings.autoWidth === false) {
                    item = settings.item;
                }
                if (windowW < settings.responsive[0].breakpoint) {
                    for (var i = 0; i < settings.responsive.length; i++) {
                        if (windowW < settings.responsive[i].breakpoint) {
                            breakpoint = settings.responsive[i].breakpoint;
                            resposiveObj = settings.responsive[i];
                        }
                    }
                }
                if (typeof resposiveObj !== 'undefined' && resposiveObj !== null) {
                    for (var j in resposiveObj.settings) {
                        if (resposiveObj.settings.hasOwnProperty(j)) {
                            if (typeof settingsTemp[j] === 'undefined' || settingsTemp[j] === null) {
                                settingsTemp[j] = settings[j];
                            }
                            settings[j] = resposiveObj.settings[j];
                        }
                    }
                }
                if (!$.isEmptyObject(settingsTemp) && windowW > settings.responsive[0].breakpoint) {
                    for (var k in settingsTemp) {
                        if (settingsTemp.hasOwnProperty(k)) {
                            settings[k] = settingsTemp[k];
                        }
                    }
                }
                if (settings.autoWidth === false) {
                    if (slideValue > 0 && slideWidth > 0) {
                        if (item !== settings.item) {
                            scene = Math.round(slideValue / ((slideWidth + settings.slideMargin) * settings.slideMove));
                        }
                    }
                }
            }
        };

        refresh.calSW = function () {
            if (settings.autoWidth === false) {
                slideWidth = (elSize - ((settings.item * (settings.slideMargin)) - settings.slideMargin)) / settings.item;
            }
        };

        refresh.calWidth = function (cln) {
            var ln = cln === true ? $slide.find('.lslide').length : $children.length;
            if (settings.autoWidth === false) {
                w = ln * (slideWidth + settings.slideMargin);
            } else {
                w = 0;
                for (var i = 0; i < ln; i++) {
                    w += (parseInt($children.eq(i).width()) + settings.slideMargin);
                }
            }
            return w;
        };
        plugin = {
            doCss: function () {
                var support = function () {
                    var transition = ['transition', 'MozTransition', 'WebkitTransition', 'OTransition', 'msTransition', 'KhtmlTransition'];
                    var root = document.documentElement;
                    for (var i = 0; i < transition.length; i++) {
                        if (transition[i] in root.style) {
                            return true;
                        }
                    }
                };
                if (settings.useCSS && support()) {
                    return true;
                }
                return false;
            },
            keyPress: function () {
                if (settings.keyPress) {
                    $(document).on('keyup.lightslider', function (e) {
                        if (!$(':focus').is('input, textarea')) {
                            if (e.preventDefault) {
                                e.preventDefault();
                            } else {
                                e.returnValue = false;
                            }
                            if (e.keyCode === 37) {
                                $el.goToPrevSlide();
                            } else if (e.keyCode === 39) {
                                $el.goToNextSlide();
                            }
                        }
                    });
                }
            },
            controls: function () {
                if (settings.controls) {
                    $el.after('<div class="lSAction"><a class="lSPrev">' + settings.prevHtml + '</a><a class="lSNext">' + settings.nextHtml + '</a></div>');
                    if (!settings.autoWidth) {
                        if (length <= settings.item) {
                            $slide.find('.lSAction').hide();
                        }
                    } else {
                        if (refresh.calWidth(false) < elSize) {
                            $slide.find('.lSAction').hide();
                        }
                    }
                    $slide.find('.lSAction a').on('click', function (e) {
                        if (e.preventDefault) {
                            e.preventDefault();
                        } else {
                            e.returnValue = false;
                        }
                        if ($(this).attr('class') === 'lSPrev') {
                            $el.goToPrevSlide();
                        } else {
                            $el.goToNextSlide();
                        }
                        return false;
                    });
                }
            },
            initialStyle: function () {
                var $this = this;
                if (settings.mode === 'fade') {
                    settings.autoWidth = false;
                    settings.slideEndAnimation = false;
                }
                if (settings.auto) {
                    settings.slideEndAnimation = false;
                }
                if (settings.autoWidth) {
                    settings.slideMove = 1;
                    settings.item = 1;
                }
                if (settings.loop) {
                    settings.slideMove = 1;
                    settings.freeMove = false;
                }
                settings.onBeforeStart.call(this, $el);
                refresh.chbreakpoint();
                $el.addClass('lightSlider').wrap('<div class="lSSlideOuter ' + settings.addClass + '"><div class="lSSlideWrapper"></div></div>');
                $slide = $el.parent('.lSSlideWrapper');
                if (settings.rtl === true) {
                    $slide.parent().addClass('lSrtl');
                }
                if (settings.vertical) {
                    $slide.parent().addClass('vertical');
                    elSize = settings.verticalHeight;
                    $slide.css('height', elSize + 'px');
                } else {
                    elSize = $el.outerWidth();
                }
                $children.addClass('lslide');
                if (settings.loop === true && settings.mode === 'slide') {
                    refresh.calSW();
                    refresh.clone = function () {
                        if (refresh.calWidth(true) > elSize) {
                            /**/
                            var tWr = 0,
                                tI = 0;
                            for (var k = 0; k < $children.length; k++) {
                                tWr += (parseInt($el.find('.lslide').eq(k).width()) + settings.slideMargin);
                                tI++;
                                if (tWr >= (elSize + settings.slideMargin)) {
                                    break;
                                }
                            }
                            var tItem = settings.autoWidth === true ? tI : settings.item;

                            /**/
                            if (tItem < $el.find('.clone.left').length) {
                                for (var i = 0; i < $el.find('.clone.left').length - tItem; i++) {
                                    $children.eq(i).remove();
                                }
                            }
                            if (tItem < $el.find('.clone.right').length) {
                                for (var j = $children.length - 1; j > ($children.length - 1 - $el.find('.clone.right').length); j--) {
                                    scene--;
                                    $children.eq(j).remove();
                                }
                            }
                            /**/
                            for (var n = $el.find('.clone.right').length; n < tItem; n++) {
                                $el.find('.lslide').eq(n).clone().removeClass('lslide').addClass('clone right').appendTo($el);
                                scene++;
                            }
                            for (var m = $el.find('.lslide').length - $el.find('.clone.left').length; m > ($el.find('.lslide').length - tItem); m--) {
                                $el.find('.lslide').eq(m - 1).clone().removeClass('lslide').addClass('clone left').prependTo($el);
                            }
                            $children = $el.children();
                        } else {
                            if ($children.hasClass('clone')) {
                                $el.find('.clone').remove();
                                $this.move($el, 0);
                            }
                        }
                    };
                    refresh.clone();
                }
                refresh.sSW = function () {
                    length = $children.length;
                    if (settings.rtl === true && settings.vertical === false) {
                        gutter = 'margin-left';
                    }
                    if (settings.autoWidth === false) {
                        $children.css(property, slideWidth + 'px');
                    }
                    $children.css(gutter, settings.slideMargin + 'px');
                    w = refresh.calWidth(false);
                    $el.css(property, w + 'px');
                    if (settings.loop === true && settings.mode === 'slide') {
                        if (on === false) {
                            scene = $el.find('.clone.left').length;
                        }
                    }
                };
                refresh.calL = function () {
                    $children = $el.children();
                    length = $children.length;
                };
                if (this.doCss()) {
                    $slide.addClass('usingCss');
                }
                refresh.calL();
                if (settings.mode === 'slide') {
                    refresh.calSW();
                    refresh.sSW();
                    if (settings.loop === true) {
                        slideValue = $this.slideValue();
                        this.move($el, slideValue);
                    }
                    if (settings.vertical === false) {
                        this.setHeight($el, false);
                    }

                } else {
                    this.setHeight($el, true);
                    $el.addClass('lSFade');
                    if (!this.doCss()) {
                        $children.fadeOut(0);
                        $children.eq(scene).fadeIn(0);
                    }
                }
                if (settings.loop === true && settings.mode === 'slide') {
                    $children.eq(scene).addClass('active');
                } else {
                    $children.first().addClass('active');
                }
            },
            pager: function () {
                var $this = this;
                refresh.createPager = function () {
                    thumbWidth = (elSize - ((settings.thumbItem * (settings.thumbMargin)) - settings.thumbMargin)) / settings.thumbItem;
                    var $children = $slide.find('.lslide');
                    var length = $slide.find('.lslide').length;
                    var i = 0,
                        pagers = '',
                        v = 0;
                    for (i = 0; i < length; i++) {
                        if (settings.mode === 'slide') {
                            // calculate scene * slide value
                            if (!settings.autoWidth) {
                                v = i * ((slideWidth + settings.slideMargin) * settings.slideMove);
                            } else {
                                v += ((parseInt($children.eq(i).width()) + settings.slideMargin) * settings.slideMove);
                            }
                        }
                        var thumb = $children.eq(i * settings.slideMove).attr('data-thumb');
                        if (settings.gallery === true) {
                            pagers += '<li style="width:100%;' + property + ':' + thumbWidth + 'px;' + gutter + ':' + settings.thumbMargin + 'px"><a href="#"><img src="' + thumb + '" /></a></li>';
                        } else {
                            pagers += '<li><a href="#">' + (i + 1) + '</a></li>';
                        }
                        if (settings.mode === 'slide') {
                            if ((v) >= w - elSize - settings.slideMargin) {
                                i = i + 1;
                                var minPgr = 2;
                                if (settings.autoWidth) {
                                    pagers += '<li><a href="#">' + (i + 1) + '</a></li>';
                                    minPgr = 1;
                                }
                                if (i < minPgr) {
                                    pagers = null;
                                    $slide.parent().addClass('noPager');
                                } else {
                                    $slide.parent().removeClass('noPager');
                                }
                                break;
                            }
                        }
                    }
                    var $cSouter = $slide.parent();
                    $cSouter.find('.lSPager').html(pagers);
                    if (settings.gallery === true) {
                        if (settings.vertical === true) {
                            // set Gallery thumbnail width
                            $cSouter.find('.lSPager').css('width', settings.vThumbWidth + 'px');
                        }
                        pagerWidth = (i * (settings.thumbMargin + thumbWidth)) + 0.5;
                        $cSouter.find('.lSPager').css({
                            property: pagerWidth + 'px',
                            'transition-duration': settings.speed + 'ms'
                        });
                        if (settings.vertical === true) {
                            $slide.parent().css('padding-right', (settings.vThumbWidth + settings.galleryMargin) + 'px');
                        }
                        $cSouter.find('.lSPager').css(property, pagerWidth + 'px');
                    }
                    var $pager = $cSouter.find('.lSPager').find('li');
                    $pager.first().addClass('active');
                    $pager.on('click', function () {
                        if (settings.loop === true && settings.mode === 'slide') {
                            scene = scene + ($pager.index(this) - $cSouter.find('.lSPager').find('li.active').index());
                        } else {
                            scene = $pager.index(this);
                        }
                        $el.mode(false);
                        if (settings.gallery === true) {
                            $this.slideThumb();
                        }
                        return false;
                    });
                };
                if (settings.pager) {
                    var cl = 'lSpg';
                    if (settings.gallery) {
                        cl = 'lSGallery';
                    }
                    $slide.after('<ul class="lSPager ' + cl + '"></ul>');
                    var gMargin = (settings.vertical) ? 'margin-left' : 'margin-top';
                    $slide.parent().find('.lSPager').css(gMargin, settings.galleryMargin + 'px');
                    refresh.createPager();
                }

                setTimeout(function () {
                    refresh.init();
                }, 0);
            },
            setHeight: function (ob, fade) {
                var obj = null,
                    $this = this;
                if (settings.loop) {
                    obj = ob.children('.lslide ').first();
                } else {
                    obj = ob.children().first();
                }
                var setCss = function () {
                    var tH = obj.outerHeight(),
                        tP = 0,
                        tHT = tH;
                    if (fade) {
                        tH = 0;
                        tP = ((tHT) * 100) / elSize;
                    }
                    ob.css({
                        'height': tH + 'px',
                        'padding-bottom': tP + '%'
                    });
                };
                setCss();
                if (obj.find('img').length) {
                    if ( obj.find('img')[0].complete) {
                        setCss();
                        if (!interval) {
                            $this.auto();
                        }
                    }else{
                        obj.find('img').load(function () {
                            setTimeout(function () {
                                setCss();
                                if (!interval) {
                                    $this.auto();
                                }
                            }, 100);
                        });
                    }
                }else{
                    if (!interval) {
                        $this.auto();
                    }
                }
            },
            active: function (ob, t) {
                if (this.doCss() && settings.mode === 'fade') {
                    $slide.addClass('on');
                }
                var sc = 0;
                if (scene * settings.slideMove < length) {
                    ob.removeClass('active');
                    if (!this.doCss() && settings.mode === 'fade' && t === false) {
                        ob.fadeOut(settings.speed);
                    }
                    if (t === true) {
                        sc = scene;
                    } else {
                        sc = scene * settings.slideMove;
                    }
                    //t === true ? sc = scene : sc = scene * settings.slideMove;
                    var l, nl;
                    if (t === true) {
                        l = ob.length;
                        nl = l - 1;
                        if (sc + 1 >= l) {
                            sc = nl;
                        }
                    }
                    if (settings.loop === true && settings.mode === 'slide') {
                        //t === true ? sc = scene - $el.find('.clone.left').length : sc = scene * settings.slideMove;
                        if (t === true) {
                            sc = scene - $el.find('.clone.left').length;
                        } else {
                            sc = scene * settings.slideMove;
                        }
                        if (t === true) {
                            l = ob.length;
                            nl = l - 1;
                            if (sc + 1 === l) {
                                sc = nl;
                            } else if (sc + 1 > l) {
                                sc = 0;
                            }
                        }
                    }

                    if (!this.doCss() && settings.mode === 'fade' && t === false) {
                        ob.eq(sc).fadeIn(settings.speed);
                    }
                    ob.eq(sc).addClass('active');
                } else {
                    ob.removeClass('active');
                    ob.eq(ob.length - 1).addClass('active');
                    if (!this.doCss() && settings.mode === 'fade' && t === false) {
                        ob.fadeOut(settings.speed);
                        ob.eq(sc).fadeIn(settings.speed);
                    }
                }
            },
            move: function (ob, v) {
                if (settings.rtl === true) {
                    v = -v;
                }
                if (this.doCss()) {
                    if (settings.vertical === true) {
                        ob.css({
                            'transform': 'translate3d(0px, ' + (-v) + 'px, 0px)',
                            '-webkit-transform': 'translate3d(0px, ' + (-v) + 'px, 0px)'
                        });
                    } else {
                        ob.css({
                            'transform': 'translate3d(' + (-v) + 'px, 0px, 0px)',
                            '-webkit-transform': 'translate3d(' + (-v) + 'px, 0px, 0px)',
                        });
                    }
                } else {
                    if (settings.vertical === true) {
                        ob.css('position', 'relative').animate({
                            top: -v + 'px'
                        }, settings.speed, settings.easing);
                    } else {
                        ob.css('position', 'relative').animate({
                            left: -v + 'px'
                        }, settings.speed, settings.easing);
                    }
                }
                var $thumb = $slide.parent().find('.lSPager').find('li');
                this.active($thumb, true);
            },
            fade: function () {
                this.active($children, false);
                var $thumb = $slide.parent().find('.lSPager').find('li');
                this.active($thumb, true);
            },
            slide: function () {
                var $this = this;
                refresh.calSlide = function () {
                    if (w > elSize) {
                        slideValue = $this.slideValue();
                        $this.active($children, false);
                        if ((slideValue) > w - elSize - settings.slideMargin) {
                            slideValue = w - elSize - settings.slideMargin;
                        } else if (slideValue < 0) {
                            slideValue = 0;
                        }
                        $this.move($el, slideValue);
                        if (settings.loop === true && settings.mode === 'slide') {
                            if (scene >= (length - ($el.find('.clone.left').length / settings.slideMove))) {
                                $this.resetSlide($el.find('.clone.left').length);
                            }
                            if (scene === 0) {
                                $this.resetSlide($slide.find('.lslide').length);
                            }
                        }
                    }
                };
                refresh.calSlide();
            },
            resetSlide: function (s) {
                var $this = this;
                $slide.find('.lSAction a').addClass('disabled');
                setTimeout(function () {
                    scene = s;
                    $slide.css('transition-duration', '0ms');
                    slideValue = $this.slideValue();
                    $this.active($children, false);
                    plugin.move($el, slideValue);
                    setTimeout(function () {
                        $slide.css('transition-duration', settings.speed + 'ms');
                        $slide.find('.lSAction a').removeClass('disabled');
                    }, 50);
                }, settings.speed + 100);
            },
            slideValue: function () {
                var _sV = 0;
                if (settings.autoWidth === false) {
                    _sV = scene * ((slideWidth + settings.slideMargin) * settings.slideMove);
                } else {
                    _sV = 0;
                    for (var i = 0; i < scene; i++) {
                        _sV += (parseInt($children.eq(i).width()) + settings.slideMargin);
                    }
                }
                return _sV;
            },
            slideThumb: function () {
                var position;
                switch (settings.currentPagerPosition) {
                case 'left':
                    position = 0;
                    break;
                case 'middle':
                    position = (elSize / 2) - (thumbWidth / 2);
                    break;
                case 'right':
                    position = elSize - thumbWidth;
                }
                var sc = scene - $el.find('.clone.left').length;
                var $pager = $slide.parent().find('.lSPager');
                if (settings.mode === 'slide' && settings.loop === true) {
                    if (sc >= $pager.children().length) {
                        sc = 0;
                    } else if (sc < 0) {
                        sc = $pager.children().length;
                    }
                }
                var thumbSlide = sc * ((thumbWidth + settings.thumbMargin)) - (position);
                if ((thumbSlide + elSize) > pagerWidth) {
                    thumbSlide = pagerWidth - elSize - settings.thumbMargin;
                }
                if (thumbSlide < 0) {
                    thumbSlide = 0;
                }
                this.move($pager, thumbSlide);
            },
            auto: function () {
                if (settings.auto) {
                    clearInterval(interval);
                    interval = setInterval(function () {
                        $el.goToNextSlide();
                    }, settings.pause);
                }
            },
            pauseOnHover: function(){
                var $this = this;
                if (settings.auto && settings.pauseOnHover) {
                    $slide.on('mouseenter', function(){
                        $(this).addClass('ls-hover');
                        $el.pause();
                        settings.auto = true;
                    });
                    $slide.on('mouseleave',function(){
                        $(this).removeClass('ls-hover');
                        if (!$slide.find('.lightSlider').hasClass('lsGrabbing')) {
                            $this.auto();
                        }
                    });
                }
            },
            touchMove: function (endCoords, startCoords) {
                $slide.css('transition-duration', '0ms');
                if (settings.mode === 'slide') {
                    var distance = endCoords - startCoords;
                    var swipeVal = slideValue - distance;
                    if ((swipeVal) >= w - elSize - settings.slideMargin) {
                        if (settings.freeMove === false) {
                            swipeVal = w - elSize - settings.slideMargin;
                        } else {
                            var swipeValT = w - elSize - settings.slideMargin;
                            swipeVal = swipeValT + ((swipeVal - swipeValT) / 5);

                        }
                    } else if (swipeVal < 0) {
                        if (settings.freeMove === false) {
                            swipeVal = 0;
                        } else {
                            swipeVal = swipeVal / 5;
                        }
                    }
                    this.move($el, swipeVal);
                }
            },

            touchEnd: function (distance) {
                $slide.css('transition-duration', settings.speed + 'ms');
                if (settings.mode === 'slide') {
                    var mxVal = false;
                    var _next = true;
                    slideValue = slideValue - distance;
                    if ((slideValue) > w - elSize - settings.slideMargin) {
                        slideValue = w - elSize - settings.slideMargin;
                        if (settings.autoWidth === false) {
                            mxVal = true;
                        }
                    } else if (slideValue < 0) {
                        slideValue = 0;
                    }
                    var gC = function (next) {
                        var ad = 0;
                        if (!mxVal) {
                            if (next) {
                                ad = 1;
                            }
                        }
                        if (!settings.autoWidth) {
                            var num = slideValue / ((slideWidth + settings.slideMargin) * settings.slideMove);
                            scene = parseInt(num) + ad;
                            if (slideValue >= (w - elSize - settings.slideMargin)) {
                                if (num % 1 !== 0) {
                                    scene++;
                                }
                            }
                        } else {
                            var tW = 0;
                            for (var i = 0; i < $children.length; i++) {
                                tW += (parseInt($children.eq(i).width()) + settings.slideMargin);
                                scene = i + ad;
                                if (tW >= slideValue) {
                                    break;
                                }
                            }
                        }
                    };
                    if (distance >= settings.swipeThreshold) {
                        gC(false);
                        _next = false;
                    } else if (distance <= -settings.swipeThreshold) {
                        gC(true);
                        _next = false;
                    }
                    $el.mode(_next);
                    this.slideThumb();
                } else {
                    if (distance >= settings.swipeThreshold) {
                        $el.goToPrevSlide();
                    } else if (distance <= -settings.swipeThreshold) {
                        $el.goToNextSlide();
                    }
                }
            },



            enableDrag: function () {
                var $this = this;
                if (!isTouch) {
                    var startCoords = 0,
                        endCoords = 0,
                        isDraging = false;
                    $slide.find('.lightSlider').addClass('lsGrab');
                    $slide.on('mousedown', function (e) {
                        if (w < elSize) {
                            if (w !== 0) {
                                return false;
                            }
                        }
                        if ($(e.target).attr('class') !== ('lSPrev') && $(e.target).attr('class') !== ('lSNext')) {
                            startCoords = (settings.vertical === true) ? e.pageY : e.pageX;
                            isDraging = true;
                            if (e.preventDefault) {
                                e.preventDefault();
                            } else {
                                e.returnValue = false;
                            }
                            // ** Fix for webkit cursor issue https://code.google.com/p/chromium/issues/detail?id=26723
                            $slide.scrollLeft += 1;
                            $slide.scrollLeft -= 1;
                            // *
                            $slide.find('.lightSlider').removeClass('lsGrab').addClass('lsGrabbing');
                            clearInterval(interval);
                        }
                    });
                    $(window).on('mousemove', function (e) {
                        if (isDraging) {
                            endCoords = (settings.vertical === true) ? e.pageY : e.pageX;
                            $this.touchMove(endCoords, startCoords);
                        }
                    });
                    $(window).on('mouseup', function (e) {
                        if (isDraging) {
                            $slide.find('.lightSlider').removeClass('lsGrabbing').addClass('lsGrab');
                            isDraging = false;
                            endCoords = (settings.vertical === true) ? e.pageY : e.pageX;
                            var distance = endCoords - startCoords;
                            if (Math.abs(distance) >= settings.swipeThreshold) {
                                $(window).on('click.ls', function (e) {
                                    if (e.preventDefault) {
                                        e.preventDefault();
                                    } else {
                                        e.returnValue = false;
                                    }
                                    e.stopImmediatePropagation();
                                    e.stopPropagation();
                                    $(window).off('click.ls');
                                });
                            }

                            $this.touchEnd(distance);

                        }
                    });
                }
            },




            enableTouch: function () {
                var $this = this;
                if (isTouch) {
                    var startCoords = {},
                        endCoords = {};
                    $slide.on('touchstart', function (e) {
                        endCoords = e.originalEvent.targetTouches[0];
                        startCoords.pageX = e.originalEvent.targetTouches[0].pageX;
                        startCoords.pageY = e.originalEvent.targetTouches[0].pageY;
                        clearInterval(interval);
                    });
                    $slide.on('touchmove', function (e) {
                        if (w < elSize) {
                            if (w !== 0) {
                                return false;
                            }
                        }
                        var orig = e.originalEvent;
                        endCoords = orig.targetTouches[0];
                        var xMovement = Math.abs(endCoords.pageX - startCoords.pageX);
                        var yMovement = Math.abs(endCoords.pageY - startCoords.pageY);
                        if (settings.vertical === true) {
                            if ((yMovement * 3) > xMovement) {
                                e.preventDefault();
                            }
                            $this.touchMove(endCoords.pageY, startCoords.pageY);
                        } else {
                            if ((xMovement * 3) > yMovement) {
                                e.preventDefault();
                            }
                            $this.touchMove(endCoords.pageX, startCoords.pageX);
                        }

                    });
                    $slide.on('touchend', function () {
                        if (w < elSize) {
                            if (w !== 0) {
                                return false;
                            }
                        }
                        var distance;
                        if (settings.vertical === true) {
                            distance = endCoords.pageY - startCoords.pageY;
                        } else {
                            distance = endCoords.pageX - startCoords.pageX;
                        }
                        $this.touchEnd(distance);
                    });
                }
            },
            build: function () {
                var $this = this;
                $this.initialStyle();
                if (this.doCss()) {

                    if (settings.enableTouch === true) {
                        $this.enableTouch();
                    }
                    if (settings.enableDrag === true) {
                        $this.enableDrag();
                    }
                }

                $(window).on('focus', function(){
                    $this.auto();
                });

                $(window).on('blur', function(){
                    clearInterval(interval);
                });

                $this.pager();
                $this.pauseOnHover();
                $this.controls();
                $this.keyPress();
            }
        };
        plugin.build();
        refresh.init = function () {
            refresh.chbreakpoint();
            if (settings.vertical === true) {
                if (settings.item > 1) {
                    elSize = settings.verticalHeight;
                } else {
                    elSize = $children.outerHeight();
                }
                $slide.css('height', elSize + 'px');
            } else {
                elSize = $slide.outerWidth();
            }
            if (settings.loop === true && settings.mode === 'slide') {
                refresh.clone();
            }
            refresh.calL();
            if (settings.mode === 'slide') {
                $el.removeClass('lSSlide');
            }
            if (settings.mode === 'slide') {
                refresh.calSW();
                refresh.sSW();
            }
            setTimeout(function () {
                if (settings.mode === 'slide') {
                    $el.addClass('lSSlide');
                }
            }, 1000);
            if (settings.pager) {
                refresh.createPager();
            }
            if (settings.adaptiveHeight === true && settings.vertical === false) {
                $el.css('height', $children.eq(scene).outerHeight(true));
            }
            if (settings.adaptiveHeight === false) {
                if (settings.mode === 'slide') {
                    if (settings.vertical === false) {
                        plugin.setHeight($el, false);
                    }else{
                        plugin.auto();
                    }
                } else {
                    plugin.setHeight($el, true);
                }
            }
            if (settings.gallery === true) {
                plugin.slideThumb();
            }
            if (settings.mode === 'slide') {
                plugin.slide();
            }
            if (settings.autoWidth === false) {
                if ($children.length <= settings.item) {
                    $slide.find('.lSAction').hide();
                } else {
                    $slide.find('.lSAction').show();
                }
            } else {
                if ((refresh.calWidth(false) < elSize) && (w !== 0)) {
                    $slide.find('.lSAction').hide();
                } else {
                    $slide.find('.lSAction').show();
                }
            }
        };
        $el.goToPrevSlide = function () {
            if (scene > 0) {
                settings.onBeforePrevSlide.call(this, $el, scene);
                scene--;
                $el.mode(false);
                if (settings.gallery === true) {
                    plugin.slideThumb();
                }
            } else {
                if (settings.loop === true) {
                    settings.onBeforePrevSlide.call(this, $el, scene);
                    if (settings.mode === 'fade') {
                        var l = (length - 1);
                        scene = parseInt(l / settings.slideMove);
                    }
                    $el.mode(false);
                    if (settings.gallery === true) {
                        plugin.slideThumb();
                    }
                } else if (settings.slideEndAnimation === true) {
                    $el.addClass('leftEnd');
                    setTimeout(function () {
                        $el.removeClass('leftEnd');
                    }, 400);
                }
            }
        };
        $el.goToNextSlide = function () {
            var nextI = true;
            if (settings.mode === 'slide') {
                var _slideValue = plugin.slideValue();
                nextI = _slideValue < w - elSize - settings.slideMargin;
            }
            if (((scene * settings.slideMove) < length - settings.slideMove) && nextI) {
                settings.onBeforeNextSlide.call(this, $el, scene);
                scene++;
                $el.mode(false);
                if (settings.gallery === true) {
                    plugin.slideThumb();
                }
            } else {
                if (settings.loop === true) {
                    settings.onBeforeNextSlide.call(this, $el, scene);
                    scene = 0;
                    $el.mode(false);
                    if (settings.gallery === true) {
                        plugin.slideThumb();
                    }
                } else if (settings.slideEndAnimation === true) {
                    $el.addClass('rightEnd');
                    setTimeout(function () {
                        $el.removeClass('rightEnd');
                    }, 400);
                }
            }
        };
        $el.mode = function (_touch) {
            if (settings.adaptiveHeight === true && settings.vertical === false) {
                $el.css('height', $children.eq(scene).outerHeight(true));
            }
            if (on === false) {
                if (settings.mode === 'slide') {
                    if (plugin.doCss()) {
                        $el.addClass('lSSlide');
                        if (settings.speed !== '') {
                            $slide.css('transition-duration', settings.speed + 'ms');
                        }
                        if (settings.cssEasing !== '') {
                            $slide.css('transition-timing-function', settings.cssEasing);
                        }
                    }
                } else {
                    if (plugin.doCss()) {
                        if (settings.speed !== '') {
                            $el.css('transition-duration', settings.speed + 'ms');
                        }
                        if (settings.cssEasing !== '') {
                            $el.css('transition-timing-function', settings.cssEasing);
                        }
                    }
                }
            }
            if (!_touch) {
                settings.onBeforeSlide.call(this, $el, scene);
            }
            if (settings.mode === 'slide') {
                plugin.slide();
            } else {
                plugin.fade();
            }
            if (!$slide.hasClass('ls-hover')) {
                plugin.auto();
            }
            setTimeout(function () {
                if (!_touch) {
                    settings.onAfterSlide.call(this, $el, scene);
                }
            }, settings.speed);
            on = true;
        };
        $el.play = function () {
            $el.goToNextSlide();
            settings.auto = true;
            plugin.auto();
        };
        $el.pause = function () {
            settings.auto = false;
            clearInterval(interval);
        };
        $el.refresh = function () {
            refresh.init();
        };
        $el.getCurrentSlideCount = function () {
            var sc = scene;
            if (settings.loop) {
                var ln = $slide.find('.lslide').length,
                    cl = $el.find('.clone.left').length;
                if (scene <= cl - 1) {
                    sc = ln + (scene - cl);
                } else if (scene >= (ln + cl)) {
                    sc = scene - ln - cl;
                } else {
                    sc = scene - cl;
                }
            }
            return sc + 1;
        };
        $el.getTotalSlideCount = function () {
            return $slide.find('.lslide').length;
        };
        $el.goToSlide = function (s) {
            if (settings.loop) {
                scene = (s + $el.find('.clone.left').length - 1);
            } else {
                scene = s;
            }
            $el.mode(false);
            if (settings.gallery === true) {
                plugin.slideThumb();
            }
        };
        $el.destroy = function () {
            if ($el.lightSlider) {
                $el.goToPrevSlide = function(){};
                $el.goToNextSlide = function(){};
                $el.mode = function(){};
                $el.play = function(){};
                $el.pause = function(){};
                $el.refresh = function(){};
                $el.getCurrentSlideCount = function(){};
                $el.getTotalSlideCount = function(){};
                $el.goToSlide = function(){};
                $el.lightSlider = null;
                refresh = {
                    init : function(){}
                };
                $el.parent().parent().find('.lSAction, .lSPager').remove();
                $el.removeClass('lightSlider lSFade lSSlide lsGrab lsGrabbing leftEnd right').removeAttr('style').unwrap().unwrap();
                $el.children().removeAttr('style');
                $children.removeClass('lslide active');
                $el.find('.clone').remove();
                $children = null;
                interval = null;
                on = false;
                scene = 0;
            }

        };
        setTimeout(function () {
            settings.onSliderLoad.call(this, $el);
        }, 10);
        $(window).on('resize orientationchange', function (e) {
            setTimeout(function () {
                if (e.preventDefault) {
                    e.preventDefault();
                } else {
                    e.returnValue = false;
                }
                refresh.init();
            }, 200);
        });
        return this;
    };
}(jQuery));

   function openfilter(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
if($('*').prop('id')=='defaultOpen')
{
    document.getElementById("defaultOpen").click();
}
else
{
    //works your_id_name not exist (false part)
}

function openNav() {
  document.getElementById("mySidebar").style.width = "100%";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}

         function toggleIcon(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass('glyphicon-plus glyphicon-minus');
         }
         $('.panel-group').on('hidden.bs.collapse', toggleIcon);
         $('.panel-group').on('shown.bs.collapse', toggleIcon);

         (function($) {

         "use strict";

         var DEBUG = false, // make true to enable debug output
         PLUGIN_IDENTIFIER = "RangeSlider";

         var RangeSlider = function( element, options ) {
         this.element = element;
         this.options = options || {};
         this.defaults = {
            output: {
               prefix: 'Rs.', // function or string
               suffix: '', // function or string
               format: function(output){
                  return output;
               }
            },
            change: function(event, obj){}
         };
         // This next line takes advantage of HTML5 data attributes
         // to support customization of the plugin on a per-element
         // basis.
         this.metadata = $(this.element).data('options');
         };

         RangeSlider.prototype = {

         ////////////////////////////////////////////////////
         // Initializers
         ////////////////////////////////////////////////////

         init: function() {
            if(DEBUG && console) console.log('RangeSlider init');
            this.config = $.extend( true, {}, this.defaults, this.options, this.metadata );

            var self = this;
            // Add the markup for the slider track
            this.trackFull = $('<div class="track track--full"></div>').appendTo(self.element);
            this.trackIncluded = $('<div class="track track--included"></div>').appendTo(self.element);
            this.inputs = [];

            $('input[type="range"]', this.element).each(function(index, value) {
               var rangeInput = this;
               // Add the ouput markup to the page.
               rangeInput.output = $('<output>').appendTo(self.element);
               // Get the current z-index of the output for later use
               rangeInput.output.zindex = parseInt($(rangeInput.output).css('z-index')) || 1;
               // Add the thumb markup to the page.
               rangeInput.thumb = $('<div class="slider-thumb">').prependTo(self.element);
               // Store the initial val, incase we need to reset.
               rangeInput.initialValue = $(this).val();
               // Method to update the slider output text/position
               rangeInput.update = function() {
                  if(DEBUG && console) console.log('RangeSlider rangeInput.update');
                  var range = $(this).attr('max') - $(this).attr('min'),
                     offset = $(this).val() - $(this).attr('min'),
                     pos = offset / range * 100 + '%',
                     transPos = offset / range * -100 + '%',
                     prefix = typeof self.config.output.prefix == 'function' ? self.config.output.prefix.call(self, rangeInput) : self.config.output.prefix,
                     format = self.config.output.format($(rangeInput).val()),
                     suffix = typeof self.config.output.suffix == 'function' ? self.config.output.suffix.call(self, rangeInput) : self.config.output.suffix;

                  // Update the HTML
                  $(rangeInput.output).html(prefix + '' + format + '' + suffix);
                  $(rangeInput.output).css('left', pos);
                  $(rangeInput.output).css('transform', 'translate('+transPos+',0)');

                  // Update the IE hack thumbs
                  $(rangeInput.thumb).css('left', pos);
                  $(rangeInput.thumb).css('transform', 'translate('+transPos+',0)');

                  // Adjust the track for the inputs
                  self.adjustTrack();
               };

               // Send the current ouput to the front for better stacking
               rangeInput.sendOutputToFront = function() {
                  $(this.output).css('z-index', rangeInput.output.zindex + 1);
               };

               // Send the current ouput to the back behind the other
               rangeInput.sendOutputToBack = function() {
                  $(this.output).css('z-index', rangeInput.output.zindex);
               };

               ///////////////////////////////////////////////////
               // IE hack because pointer-events:none doesn't pass the
               // event to the slider thumb, so we have to make our own.
               ///////////////////////////////////////////////////
               $(rangeInput.thumb).on('mousedown', function(event){
                  // Send all output to the back
                  self.sendAllOutputToBack();
                  // Send this output to the front
                  rangeInput.sendOutputToFront();
                  // Turn mouse tracking on
                  $(this).data('tracking', true);
                  $(document).one('mouseup', function() {
                     // Turn mouse tracking off
                     $(rangeInput.thumb).data('tracking', false);
                     // Trigger the change event
                     self.change(event);
                  });
               });

               // IE hack - track the mouse move within the input range
               $('body').on('mousemove', function(event){
                  // If we're tracking the mouse move
                  if($(rangeInput.thumb).data('tracking')) {
                     var rangeOffset = $(rangeInput).offset(),
                        relX = event.pageX - rangeOffset.left,
                        rangeWidth = $(rangeInput).width();
                     // If the mouse move is within the input area
                     // update the slider with the correct value
                     if(relX <= rangeWidth) {
                        var val = relX/rangeWidth;
                        $(rangeInput).val(val * $(rangeInput).attr('max'));
                        rangeInput.update();
                     }
                  }
               });

               // Update the output text on slider change
               $(this).on('mousedown input change touchstart', function(event) {
                  if(DEBUG && console) console.log('RangeSlider rangeInput, mousedown input touchstart');
                  // Send all output to the back
                  self.sendAllOutputToBack();
                  // Send this output to the front
                  rangeInput.sendOutputToFront();
                  // Update the output
                  rangeInput.update();
               });

               // Fire the onchange event
               $(this).on('mouseup touchend', function(event){
                  if(DEBUG && console) console.log('RangeSlider rangeInput, change');
                  self.change(event);
               });

               // Add this input to the inputs array for use later
               self.inputs.push(this);
            });

            // Reset to set to initial values
            this.reset();

            // Return the instance
            return this;
         },

         sendAllOutputToBack: function() {
            $.map(this.inputs, function(input, index) {
               input.sendOutputToBack();
            });
         },

         change: function(event) {
            if(DEBUG && console) console.log('RangeSlider change', event);
            // Get the values of each input
            var values = $.map(this.inputs, function(input, index) {
               return {
                  value: parseInt($(input).val()),
                  min: parseInt($(input).attr('min')),
                  max: parseInt($(input).attr('max'))
               };
            });

            // Sort the array by value, if we have 2 or more sliders
            values.sort(function(a, b) {
               return a.value - b.value;
            });

            // call the on change function in the context of the rangeslider and pass the values
            this.config.change.call(this, event, values);
         },

         reset: function() {
            if(DEBUG && console) console.log('RangeSlider reset');
            $.map(this.inputs, function(input, index) {
               $(input).val(input.initialValue);
               input.update();
            });
         },

         adjustTrack: function() {
            if(DEBUG && console) console.log('RangeSlider adjustTrack');
            var valueMin = Infinity,
               rangeMin = Infinity,
               valueMax = 0,
               rangeMax = 0;

            // Loop through all input to get min and max
            $.map(this.inputs, function(input, index) {
               var val = parseInt($(input).val()),
                  min = parseInt($(input).attr('min')),
                  max = parseInt($(input).attr('max'));

               // Get the min and max values of the inputs
               valueMin = (val < valueMin) ? val : valueMin;
               valueMax = (val > valueMax) ? val : valueMax;
               // Get the min and max possible values
               rangeMin = (min < rangeMin) ? min : rangeMin;
               rangeMax = (max > rangeMax) ? max : rangeMax;
            });

            // Get the difference if there are 2 range input, use max for one input.
            // Sets left to 0 for one input and adjust for 2 inputs
            if(this.inputs.length > 1) {
               this.trackIncluded.css('width', (valueMax - valueMin) / (rangeMax - rangeMin) * 100 + '%');
               this.trackIncluded.css('left', (valueMin - rangeMin) / (rangeMax - rangeMin) * 100 + '%');
            } else {
               this.trackIncluded.css('width', valueMax / (rangeMax - rangeMin) * 100 + '%');
               this.trackIncluded.css('left', '0%');
            }
         }
         };

         RangeSlider.defaults = RangeSlider.prototype.defaults;

         $.fn.RangeSlider = function(options) {
         if(DEBUG && console) console.log('$.fn.RangeSlider', options);
         return this.each(function() {
            var instance = $(this).data(PLUGIN_IDENTIFIER);
            if(!instance) {
               instance = new RangeSlider(this, options).init();
               $(this).data(PLUGIN_IDENTIFIER,instance);
            }
         });
         };

         }
         )(jQuery);


         var rangeSlider = $('#facet-price-range-slider');
         if(rangeSlider.length > 0) {
         rangeSlider.RangeSlider({
         output: {
         format: function(output){
         return output.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
         },
         suffix: function(input){
         return parseInt($(input).val()) == parseInt($(input).attr('max')) ? this.config.maxSymbol : '';
         }
         }
         });
         }


  $(function() {

  var native_width = 0;
  var native_height = 0;
  var mouse = {x: 0, y: 0};
  var magnify;
  var cur_img;

  var ui = {
    magniflier: $('.magniflier')
  };

  // Add the magnifying glass
  if (ui.magniflier.length) {
    var div = document.createElement('div');
    div.setAttribute('class', 'glass');
    ui.glass = $(div);

    $('body').append(div);
  }


  // All the magnifying will happen on "mousemove"

  var mouseMove = function(e) {
    var $el = $(this);

    // Container offset relative to document
    var magnify_offset = cur_img.offset();

    // Mouse position relative to container
    // pageX/pageY - container's offsetLeft/offetTop
    mouse.x = e.pageX - magnify_offset.left;
    mouse.y = e.pageY - magnify_offset.top;

    // The Magnifying glass should only show up when the mouse is inside
    // It is important to note that attaching mouseout and then hiding
    // the glass wont work cuz mouse will never be out due to the glass
    // being inside the parent and having a higher z-index (positioned above)
    if (
      mouse.x < cur_img.width() &&
      mouse.y < cur_img.height() &&
      mouse.x > 0 &&
      mouse.y > 0
      ) {

      magnify(e);
    }
    else {
      ui.glass.fadeOut(100);
    }

    return;
  };

  var magnify = function(e) {

    // The background position of div.glass will be
    // changed according to the position
    // of the mouse over the img.magniflier
    //
    // So we will get the ratio of the pixel
    // under the mouse with respect
    // to the image and use that to position the
    // large image inside the magnifying glass

    var rx = Math.round(mouse.x/cur_img.width()*native_width - ui.glass.width()/2)*-1;
    var ry = Math.round(mouse.y/cur_img.height()*native_height - ui.glass.height()/2)*-1;
    var bg_pos = rx + "px " + ry + "px";

    // Calculate pos for magnifying glass
    //
    // Easy Logic: Deduct half of width/height
    // from mouse pos.

    // var glass_left = mouse.x - ui.glass.width() / 2;
    // var glass_top  = mouse.y - ui.glass.height() / 2;
    var glass_left = e.pageX - ui.glass.width() / 2;
    var glass_top  = e.pageY - ui.glass.height() / 2;
    //console.log(glass_left, glass_top, bg_pos)
    // Now, if you hover on the image, you should
    // see the magnifying glass in action
    ui.glass.css({
      left: glass_left,
      top: glass_top,
      backgroundPosition: bg_pos
    });

    return;
  };

  $('.magniflier').on('mousemove', function() {
    ui.glass.fadeIn(200);

    cur_img = $(this);

    var large_img_loaded = cur_img.data('large-img-loaded');
    var src = cur_img.data('large') || cur_img.attr('src');

    // Set large-img-loaded to true
    // cur_img.data('large-img-loaded', true)

    if (src) {
      ui.glass.css({
        'background-image': 'url(' + src + ')',
        'background-repeat': 'no-repeat'
      });
    }

    // When the user hovers on the image, the script will first calculate
    // the native dimensions if they don't exist. Only after the native dimensions
    // are available, the script will show the zoomed version.
    //if(!native_width && !native_height) {

      if (!cur_img.data('native_width')) {
        // This will create a new image object with the same image as that in .small
        // We cannot directly get the dimensions from .small because of the
        // width specified to 200px in the html. To get the actual dimensions we have
        // created this image object.
        var image_object = new Image();

        image_object.onload = function() {
          // This code is wrapped in the .load function which is important.
          // width and height of the object would return 0 if accessed before
          // the image gets loaded.
          native_width = image_object.width;
          native_height = image_object.height;

          cur_img.data('native_width', native_width);
          cur_img.data('native_height', native_height);

          //console.log(native_width, native_height);

          mouseMove.apply(this, arguments);

          ui.glass.on('mousemove', mouseMove);
        };


        image_object.src = src;

        return;
      } else {

        native_width = cur_img.data('native_width');
        native_height = cur_img.data('native_height');
      }
    //}
    //console.log(native_width, native_height);

    mouseMove.apply(this, arguments);

    ui.glass.on('mousemove', mouseMove);
  });

  ui.glass.on('mouseout', function() {
    ui.glass.off('mousemove', mouseMove);
  });

});;




function lazy_product_func()
{

	var lazyImages = [].slice.call(document.querySelectorAll("img.lazy_product"));

  if ("IntersectionObserver" in window) {
    let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          let lazyImage = entry.target;
          lazyImage.src = lazyImage.dataset.src;
		  var callfor = lazyImage.dataset.callfor;
		  var temp = lazyImage.dataset.page_count;
		  if(temp==5 && callfor != 'slider')
		  {
        console.log('test');
			  loadMoreProductFunc();
		  }
		  console.log(temp);
          lazyImage.classList.remove("lazy_product");
          lazyImageObserver.unobserve(lazyImage);
        }
      });
    });

    lazyImages.forEach(function(lazyImage) {
      lazyImageObserver.observe(lazyImage);
    });
  } else {
    // Possibly fall back to a more compatible method here
  }
}
lazy_product_func();




var offset=0;
function loadMoreProductFunc()
{

	//$(".loadMoreProduct").addClass('btn-primary').removeClass('no-more-pdts').html('Load More Products');
	/*offset = Number(offset)+Number(1);
	console.log("offset : "+offset);
	document.getElementById('offset').value = offset;*/
	var offset='';
	if(document.getElementById('offset'))
	{
	offset = document.getElementById('offset').value ;
		offset++;
		document.getElementById('offset').value = offset;
	}
	main_cat_search = document.getElementById('main_cat_search').value
	sub_cat_search = document.getElementById('sub_cat_search').value
	//if(Number($(".products_list_count").html())>Number($(".DisplayMoreProd .prodDiv").length))

	{
		//$(".loader").show();
		$("#list_loder").show();

		$.ajax({
			type: "POST",
			//url:$('.siteUrl').val()+'products/loadMoreProduct',

			url:$('.siteUrl').val()+'products/loadMoreProduct/'+main_cat_search+'/'+sub_cat_search,
			/*dataType : "json",*/
			data : $('#prd_search_form').serialize(),
			success : function(result){
				if(result=='NoMoreProducts')
				{
					//$(".loadMoreProduct").addClass('no-more-pdts').removeClass('btn-primary').html('No more products to display.');
					$(".loadMoreProductText").html('Thats all Folks...');
					showPOpOver("No more products to display." , 4000);
				}
				else
				{

					$(".loadMoreProduct").addClass('btn-primary').removeClass('no-more-pdts');
					$(".DisplayMoreProd").append(result);
					afterLoadProduct(offset);
				}
				lazy_product_func();
				//$(".loader").css("display","none");
				//$(".loader").hide();
				$("#list_loder").hide();

			}
		});
	}
	/*else
	{
		$(".loadMoreProduct").html('No More Products To Display.');
		showPOpOver("No More Products To Display." , 4000);
	}*/
}


var toClearTimeout='';
function showPOpOver(msg , time){

$('#fix-content').css("display","block");
//$('.message').slideDown(300).delay(4000).slideUp(300);
$('#popMsg').html(msg);
clearTimeout(toClearTimeout);
toClearTimeout = setTimeout(function(){ hidePOpOver(); }, time);
}
function hidePOpOver(){
$('#fix-content').css("display","none");
}

function afterLoadProduct(ids)
{
	ids = ids * 12;
	afterLoadProductById(ids);
}
function afterLoadProductById(ids)
{
	//$('[data-toggle="tooltip"]').tooltip()
	$(".addToCartListBTN"+ids).click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToCartList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});

	$(".addToWishlistListBTN"+ids).click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToWishlistList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});

	$(".incToCartListBTN"+ids).click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		AddToCart(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});
}

function searchProduct()
{
	main_cat_search = document.getElementById('main_cat_search').value;
	sub_cat_search = document.getElementById('sub_cat_search').value;
	p_search_by = document.getElementById('p_search_by').value;
	var is_max_price = false;
	if(document.getElementById('max_price').value == $("#c_max_final_price").val())
	{
		is_max_price = true;
		//document.getElementById('max_price').value = 0;
	}

	var is_min_price = false;
	if(document.getElementById('min_price').value == $("#r_min_final_price").val())
	{
		is_min_price = true;
		//document.getElementById('min_price').value = 0;
	}




	console.log(c_max_final_price + " : " +document.getElementById('max_price').value);
	console.log(r_min_final_price + " : " +document.getElementById('min_price').value);

	document.getElementById('offset').value = 0;
	$(".loadMoreProduct").addClass('btn-primary').removeClass('no-more-pdts').html('Load More Products');
	$(".loader").show();
	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'products/all_products_search/'+main_cat_search+'/'+sub_cat_search,
		/*dataType : "json",*/
		data : $('#prd_search_form').serialize(),
		success : function(result){
			$('#p_search_by').val('');
			$(".loader").css("display","none");
			$(".DisplayMoreProd").html(result);
			lazy_product_func();
			$(".loadMoreProductText").html('');
			if(result=='NoMoreProducts')
			{
				//$(".loadMoreProduct").addClass('no-more-pdts').removeClass('btn-primary').html('No more products to display.');
				//$(".loadMoreProductText").html('Thats all Folks...');
				//showPOpOver("No more products to display." , 3000);

			}

			if(is_max_price)
			{
				document.getElementById('max_price').value = c_max_final_price;
			}

			if(is_min_price)
			{
				document.getElementById('min_price').value = r_min_final_price;
			}

			$(".addToCartListBTN").click(function(){
				var ids = $(this).data('val');
				var idsarr = ids.split(',');
				addToCartList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
			});

			$(".addToWishlistListBTN").click(function(){
				var ids = $(this).data('val');
				var idsarr = ids.split(',');
				addToWishlistList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
			});

			$(".incToCartListBTN").click(function(){
				var ids = $(this).data('val');
				var idsarr = ids.split(',');
				AddToCart(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
			});
			//StarRatingJs();
			//setAllAnchorFunc();

		}
	});
}

window.addEventListener("load", function(){
	$(".addToCartListBTN").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToCartList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});

	$(".addToWishlistListBTN").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToWishlistList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});

	$(".addToNotifyMeListBTN").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToNotifyMeList(idsarr[0] , idsarr[1] , idsarr[2] )
	});

	$(".incToCartListBTN").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		AddToCartCK(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});
	$(".incToCartListBTNCk").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		AddToCartCK(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});

	$(".addToCartListBTNCART").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToCartList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3] , 'cart')
	});

	$(".addToWishlistListBTNCART").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToWishlistList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});

	$(".incToCartListBTNCART").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
    alert('asas');
		AddToCartCK(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3] , 'cart')
	});
	setWishlistBtn();
})

function addToCartList(pis_id, p_id , pc_id , task , page='')
{
	if($(".cart_increment_page_"+pis_id).html()=='undefined' || $(".cart_increment_page_"+pis_id).html()<=0)
	{
		alert("Please Enter Quantity");
		return false;
	}
	$('.productAddShow_'+pis_id).hide();
	$('.productInCartShow_'+pis_id).show();
	$(".qty_increDecre_"+pis_id).addClass('showing');
	$(".loader").show();

	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'products/cartTask',
		dataType : "json",
	   data : {'qty':$(".cart_increment_page_"+pis_id).html() , "pis_id":pis_id, "p_id":p_id, "pc_id":pc_id, "task":task },
	   success : function(result){
		$("body").append(result.script);
		   $('.sess_wishlist_count').html(result.in_wishlist);
		showPOpOver(result.msg , 3000 , result.message_alert_type);
		$(".cart_increment_"+pis_id).html(result.cart_qty);
		$(".cart_increment_"+pis_id).val(result.cart_qty);
		$(".sess_cart_count").html(result.getCartItemCount);
		update_head_cart();
		if(result.redirect!='')
		{
			window.location.href=result.redirect;
		}
		if(page=='cart')
		{
			//getCartPageDetail();
		}
		else
		{

		}
		getCartDetail();
		getCartPageDetail();
		//alert(result.cart_qty);
		if(result.cart_qty==0){$('.qty_increDecre_'+pis_id).hide();}
		if(result.cart_qty>=1){$('.qty_increDecre_'+pis_id).show();}
		//$(".cart_in_detail_"+pis_id).html(result.cart_qty + "  SQ. FT. In Cart")
		$(".cart_in_detail_"+pis_id).html(result.cart_qty_msg)

		$(".loader").css("display","none");
		setAllAnchorFunc();
		}
   });

}


function addToWishlistList(pis_id, p_id , pc_id , task , page='')
{
	$(".loader").show();
	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'products/wishlistTask',
		dataType : "json",
	   data : {'qty':$(".cart_increment_"+pis_id).val() , "pis_id":pis_id, "p_id":p_id, "pc_id":pc_id, "task":task},
	   success : function(result){
		showPOpOver(result.msg , 3000);
		$('.sess_wishlist_count').html(result.in_wishlist);
		$('.sess_cart_count').html(result.in_cart);
		if(result.status)
		{

			if(result.task==1)
			{
				$(".cart_wishlist_y_"+pis_id).show();
				$(".cart_wishlist_n_"+pis_id).hide();
			}
			else
			{
				$(".cart_wishlist_y_"+pis_id).hide();
				$(".cart_wishlist_n_"+pis_id).show();
			}
			if(result.task==3)
			{
				getCartPageDetail();
			}
		}
		getWishlistPageDetail();
		$(".loader").css("display","none");
		setAllAnchorFunc();
		}
   });
}


function addToNotifyMeList(pis_id, p_id , pc_id )
{
	$(".en_error_span"+pc_id).html('');
	var notify_email = $("#notify_email").val();
	if(notify_email=='')
	{
		$(".en_error_span"+pc_id).html('<div class="alert alert-warning"> <a href="'+ $('.siteUrl').val() +'sign-in">Register</a> with us to get updates.</div>');
		return false;
	}
	else if(!ValidateEmail(notify_email))
	{
		$(".en_error_span"+pc_id).html('<div class="alert alert-danger"><strong>Error!</strong> Please email Valid Email Id.</div>');
		return false;
	}

	$(".loader").show();
	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'Products/notifyMeTask',
		dataType : "json",
	   data : {'notify_email':notify_email , "pis_id":pis_id, "p_id":p_id, "pc_id":pc_id},
	   success : function(result){
		$(".en_error_span"+pc_id).html(result.msg);
		if(result.status){}
		$(".loader").css("display","none");

		setAllAnchorFunc();
		}
   });
}

function AddToCart(pis_id , p_id , pc_id , task , page='')
{

	//alert(input_obj.length);
	//alert($(".cart_increment_"+pis_id).val())
	if(task==1)
	{/*remove from cart*/
		$(".cart_increment_"+pis_id).html();
		if(Number($(".cart_increment_"+pis_id).val())-Number(1)==0)
		{
			$('.productAddShow_'+pis_id).show();
			$('.productInCartShow_'+pis_id).hide();
			$(".qty_increDecre_"+pis_id).removeClass('showing');
			//document.getElementById("cart_increment_"+pis_id).value=1;
		}
	}
	if(task==2)
	{/*add in cart*/
		/*$(".cart_increment_"+pis_id).html(Number($(".cart_increment_"+pis_id).html())+Number(1));*/
	}
	$(".loader").show();

	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'products/cartTask',
		dataType : "json",
   data : {'qty':$(".cart_increment_"+pis_id).val() , "pis_id":pis_id, "p_id":p_id, "pc_id":pc_id, "task":task},
   //data : {'qty':1 , "pis_id":pis_id, "p_id":p_id, "pc_id":pc_id, "task":task},
   success : function(result){
	   showPOpOver(result.msg , 3000 , result.message_alert_type);
	   $("body").append(result.script);
	   	$(".cart_increment_"+pis_id).html(result.cart_qty);
	   	$(".cart_increment_"+pis_id).val(result.cart_qty);
		$(".sess_cart_count").html(result.getCartItemCount);
		update_head_cart();
		if(page=='cart')
		{
			getCartPageDetail();
		}
		else
		{
			getCartDetail();
		}

		//alert(result.cart_qty);
		if(result.cart_qty==0){$('.qty_increDecre_'+pis_id).hide();}
		$(".loader").css("display","none");
		setAllAnchorFunc();
		}
   });
}
function AddToCartCK(pis_id , p_id , pc_id , task , page='')
{

	//alert(input_obj.length);
	//alert($(".cart_increment_"+pis_id).html())
	if(task==1)
	{/*remove from cart*/
    if($(".cart_increment_"+pis_id).html() == '1'){
      //alert('Atleast one Quantity Should be There');
      //return false;
      location.reload();
    }
		$(".cart_increment_"+pis_id).html();
		if(Number($(".cart_increment_"+pis_id).val())-Number(1)==0)
		{
			$('.productAddShow_'+pis_id).show();
			$('.productInCartShow_'+pis_id).hide();
			$(".qty_increDecre_"+pis_id).removeClass('showing');
			//document.getElementById("cart_increment_"+pis_id).value=1;
		}
	}
	if(task==2)
	{/*add in cart*/
		/*$(".cart_increment_"+pis_id).html(Number($(".cart_increment_"+pis_id).html())+Number(1));*/
	}
	$(".loader").show();

	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'products/cartTask',
		dataType : "json",
   data : {'qty':$(".cart_increment_"+pis_id).html() , "pis_id":pis_id, "p_id":p_id, "pc_id":pc_id, "task":task},
   //data : {'qty':1 , "pis_id":pis_id, "p_id":p_id, "pc_id":pc_id, "task":task},
   success : function(result){
	   showPOpOver(result.msg , 3000 , result.message_alert_type);
	   $("body").append(result.script);
	   	$(".cart_increment_"+pis_id).html(result.cart_qty);
	   	$(".cart_increment_"+pis_id).val(result.cart_qty);
		$(".sess_cart_count").html(result.getCartItemCount);
		update_head_cart();
		if(page=='cart')
		{
			getCartPageDetail();
		}
		else
		{
			getCartDetail();
		}

		//alert(result.cart_qty);
		if(result.cart_qty==0){$('.qty_increDecre_'+pis_id).hide();}
		$(".loader").css("display","none");
		setAllAnchorFunc();
    refreshCheckoutPrices();
		}
   });
}
function refreshCheckoutPrices(){
  $.ajax({
    type: "POST",
    url:$('.siteUrl').val()+'Payment_Checkout/refreshCheckoutPrices',
    dataType : "json",
    data : '',
    success : function(result){
      $(".loader").css("display","none");
      $('.summary-price').html(result.html);
      $('#pay-now').html(result.html2);
    }
  });
}
function getCartPageDetail(){
	if($("*").hasClass("cartPage"))
	{
		$(".loader").show();
		$.ajax({
			type: "POST",
			url:$('.siteUrl').val()+'products/my_cart_page_detail',
			/*dataType : "json",*/
			data : '',
			success : function(result){
				$(".cartPage").html(result);
				afterGetDetailCartPage();
				afterCartSlide();
				$(".loader").css("display","none");
				setAllAnchorFunc();
			}
		});
	}
}

function getCartDetail(){
	//$(".loader").show();
	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'products/getCartDetail',
		/*dataType : "json",*/
		data : '',
		success : function(result){
			$(".float_cart").html(result);
			$(".loader").hide();
			afterGetDetail();
			afterCartSlide();
			$(".loader").css("display","none");
			setAllAnchorFunc();
		}
	});
}

function addNoteToOrder(){
	$(".loader").show();
	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'products/addNoteToOrder',
		/*dataType : "json",*/
		data : {'customer_order_note':$("#customer_order_note_sc").val()},
		success : function(result){
			$(".loader").hide();
			$(".toast_title").html('Add note to order.');
			$(".toast_time").html('');
			$(".toast_message").html('Order note is updated successfully');
			$('#toast_id').toast('show');
		}
	});
}

function afterGetDetailCartPage()
{
	$(".addToCartListBTNCART").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToCartList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3] , 'cart')
	});

	$(".addToWishlistListBTNCART").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToWishlistList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});

	$(".incToCartListBTNCART").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
      alert('eee');
		AddToCart(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3] , 'cart')
	});
}

var anchor_class = 0;
function setAllAnchorFunc()
{
	//return true;
	//$('.aClick_'+anchor_class).unbind("click");
	$('a').removeClass('aClick_'+anchor_class);
	//$('a').unbind("click");
	anchor_class++;
	$('a').addClass('aClick_'+anchor_class);
	//$("a").bind("click", (function () {
	$('.aClick_'+anchor_class).click(function(){
			var $this = $(this);
			var location_href = ($this).attr('href');
			var title1 = ($this).attr('title');
			var title2 = $this.text().trim();
			var title3 = $('img', $this).attr('title');
				//console.log($this.text().trim());
				//console.log($($this+' img').attr('title'));
				//console.log($('img', $this).attr('title'));
			var tag_label='unknown';
			if(title1 != '' && title1 != undefined  && title1 != 'undefined' ){ var tag_label=title1; }
			else if(title3 != '' && title3 != undefined  && title3 != 'undefined' ){ var tag_label=title3; }
			if(title2 != '' && title2 != undefined  && title2 != 'undefined' ){ var tag_label=title2; }

			/*gtag('event', 'anchor_click', {
			  'event_label':tag_label,
			  //'event_category':location_href
			});*/

	});
	return true;
}
setAllAnchorFunc();

function afterGetDetail()
{
	$(".addToCartListBTNC").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToCartList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});

	$(".addToWishlistListBTNC").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToWishlistList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});

	$(".incToCartListBTNC").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		AddToCart(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});
}


function update_head_cart(){
	//$(".loader").show();
	return false;
	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'products/update_head_cart',
		/*dataType : "json",*/
		data : '',
		success : function(result){
			$(".head_dropdown_cart_d").html(result);
			lazy_images();
			//$(".loader").css("display","none");
			setAllAnchorFunc();
		}
	});
}

function afterCartSlide(){
	$('.cartSideOpen').click(function(){
		$('.cart-pop-p').addClass('right-display');
		$('.cart-overlay').addClass('bg-display');
		$('body').addClass('scroll-fixed');
	});
	$('.cart-p-head-icon').click(function(){
		$('.cart-pop-p').removeClass('right-display');
		$('.cart-overlay').removeClass('bg-display');
		$('body').removeClass('scroll-fixed');
	});
	$('.cart-overlay').click(function(){
		$('.cart-pop-p').removeClass('right-display');
		$(this).removeClass('bg-display');
	});
	$('[data-toggle="tooltip"]').tooltip()
}

function setWishlistBtn()
{
	$(".WishlistListBTN").click(function(){
		var ids = $(this).data('val');
		var idsarr = ids.split(',');
		addToWishlistList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
	});
}

function getWishlistPageDetail(){
	$(".loader").show();
	$.ajax({
		type: "POST",
		url:$('.siteUrl').val()+'Products/my_wishlist_page_detail',
		/*dataType : "json",*/
		data : '',
		success : function(result){
			$(".wishlistPage").html(result);
			setWishlistBtn();
			$(".loader").css("display","none");
			setAllAnchorFunc();
		}
	});
}



function product_quick_view_func(product_id , product_combination_id)
{
	$(".loader").css("display","block");
	$.ajax({
		type: "POST",
		//url:$('.siteUrl').val()+'products/loadMoreProduct',
		url:$('.siteUrl').val()+'products/product_detail_quick_view',
		/*dataType : "json",*/
		data : {'product_id':product_id , 'product_combination_id' : product_combination_id},
		success : function(result){
			$('#product_quick_view_body').html(result);

			$(".addToCartListBTN").click(function(){
				var ids = $(this).data('val');
				var idsarr = ids.split(',');
				addToCartList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
			});

			$(".addToWishlistListBTN").click(function(){
				var ids = $(this).data('val');
				var idsarr = ids.split(',');
				addToWishlistList(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
			});

			$(".incToCartListBTN").click(function(){
				var ids = $(this).data('val');
				var idsarr = ids.split(',');
				AddToCart(idsarr[0] , idsarr[1] , idsarr[2] , idsarr[3])
			});

			$('#product_quick_view').modal('show');
			$(".loader").css("display","none");
			//StarRatingJs();
			setAllAnchorFunc();
		}
	});

}
