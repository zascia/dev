/* Minification failed. Returning unminified contents.
(230,5-6): run-time error JS1003: Expected ':': }
(2907,25-26): run-time error JS1003: Expected ':': }
 */

var jsHelper = function () {

    var isAnArray = function (arg) {
        if (Array.isArray) { return Array.isArray(arg); }
        else { return Object.prototype.toString.call(arg) === '[object Array]'; };
    };

    var isAString = function (arg) {
        return (typeof arg === 'string' || arg instanceof String);
    }

    var padLeft = function (value, minSize, padWith) {
        if (value.length >= minSize) { return value; }
        var result = value;
        while (result.length < minSize) { result = padWith + result; }
        if (result.length > minSize) { result = result.slice(-1 * minSize); }
        return result;
    };

    var formatDateDDMMYYYY = function (value, separador) {
        if (!value) { return ''; }
        try {
            if (!separador && separador !== '') { separador = '/'; }
            var dt = (Object.prototype.toString.call(value) === '[object Date]') ? value : new Date(value);
            return padLeft(dt.getDate().toString(), 2, '0') + separador + padLeft((dt.getMonth() + 1).toString(), 2, '0') + separador + dt.getFullYear();
        } catch (e) { /*console.log(e);*/ }
        return '';
    };

    // only changes url if '://' found ex: 'http://www.xpto.com/bla'
    // will NOT change if 'www.xpto.com/bla'
    var makeUrlRelative = function (url) {
        var patt = '://';
        var pos = url.indexOf(patt);
        if (pos < 0) { return url; }
        var slashPos = url.indexOf('/', pos + patt.length);
        if (slashPos >= 0) return url.substr(slashPos);
        var questionPos = url.indexOf('?', pos + patt.length);
        return '/' + (questionPos >= 0 ? url.substr(questionPos) : '');
    };



    return {
        isAnArray: isAnArray,
        isAString: isAString,
        padLeft: padLeft,
        formatDateDDMMYYYY: formatDateDDMMYYYY,
        makeUrlRelative: makeUrlRelative
    };
}();

// Object extensions

Object.defineProperty(Object.prototype, "updateFromThis", {
    value: function updateFromThis(obj) {
        if (!obj) return;
        var that = this;
        var theProperties = [];
        for (var propertyName in that) {
            if (that.hasOwnProperty(propertyName)) theProperties.push(propertyName);
        }
        for (var idx = 0; idx < theProperties.length; idx++) {
            if (obj[theProperties[idx]]) that[theProperties[idx]] = obj[theProperties[idx]];
        }
    }
});

Object.defineProperty(Object.prototype, "assignFromThis", {
    value: function updateFromThis(obj) {
        if (!obj) return;
        var that = this;
        var theProperties = [];
        for (var propertyName in obj) {
            if (obj.hasOwnProperty(propertyName)) that[propertyName] = obj[propertyName];
        }
    }
});

;
// ficheiro js para código de utilização da api json (ex: ver mais)
var dnSrv = function () {

    var _loadMoreProcessor = function () {
        var loaderDivSelector = '[data-name="load-more"]';
        var loaderSpinnerDivSelector = '[data-name="load-more-spinner"]';
        var loaderButtonDivSelector = '[data-name="load-more-button"]';
        var loaderTargetDivSelector = '[data-name="load-more-target"]';

        // <div data-name="load-more-container"></div>
        // data-name="load-more" data-op="load-more-home" data-container="load-more-container" data-path="/NewsGen/Edição/VE/Notícias|/NewsGen/Edição/VE/Programas" data-page="0"

        var _loadNextPage = function () {
            return new Promise(function (resolve, reject) {
                //console.log('next page requested!');
                try {
                    var loaderDiv = $(loaderDivSelector);
                    if (!loaderDiv || loaderDiv.length <= 0) { reject('load-more not found.'); return; }
                    var targetContainer = $('[data-name="' + loaderDiv.attr('data-container') + '"]');
                    if (!targetContainer || targetContainer.length <= 0) { reject('load-more target not found.'); return; }
                    var pg = loaderDiv.attr('data-page');
                    if (!pg || pg <= 0) pg = 1;
                    var maxPg = loaderDiv.attr('data-max-page');
                    if (!maxPg || maxPg <= 0) maxPg = 5;
                    maxPg = maxPg * 1;
                    pg = pg * 1;
                    if (pg > maxPg) { resolve(); return; }
                    loaderDiv.attr('data-page', pg + 1);
                    $(loaderSpinnerDivSelector).show();
                    var dataPayload = {
                        op: loaderDiv.attr('data-op'),
                        paths: loaderDiv.attr('data-path'),
                        authors: loaderDiv.attr('data-authors'),
                        tags: loaderDiv.attr('data-tags'),
                        tagsToExclude: loaderDiv.attr('data-tags-to-exclude'),
                        excludeIds: loaderDiv.attr('data-exclude-ids'),
                        page: pg,
                        pageSize: loaderDiv.attr('data-page-size')
                    };
                    $.ajax({
                        url: '/ajax/requests.aspx',
                        method: 'GET',
                        data: dataPayload,
                    }).done(function (data) {
                        $(loaderSpinnerDivSelector).hide();
                        if (!data || data.indexOf("<!-- no mediactors ") >= 0
                            || data.indexOf("<!-- Error:") >= 0) {
                            targetContainer.append("<!-- no more data -->");
                            $(loaderButtonDivSelector).hide();
                            return; // no more contents
                        }
                        targetContainer.append($(data));
                        Refresh_Pageview_VerMais();
                        jQuery(window).lazyLoadXT();
                        resolve();
                    }).fail(function (jqXHR) {
                        $(loaderSpinnerDivSelector).hide();
                        reject(jqXHR.responseText);
                    });
                } catch (e) {
                    reject(e);
                    $(loaderSpinnerDivSelector).hide();
                }
            });
        };

        var loadMoreBtnHandler = function (e) { e.preventDefault(); _loadNextPage(); };

        var _configure = function (config) {
            if (!config) { return; }
            if (jsHelper.isAString(config)) {
                if (config == '' || config == '{}') { return; }
                config = JSON.parse(config);
            };
            var loaderDiv = $(loaderDivSelector);
            if (!loaderDiv || loaderDiv.length <= 0) { return; }
            $(loaderButtonDivSelector).show();
            if (config.container) { loaderDiv.attr('data-container', config.container); }
            if (config.op) { loaderDiv.attr('data-op', config.op); }
            if (config.path) { loaderDiv.attr('data-path', config.path); }
            if (config.tags) { loaderDiv.attr('data-tags', config.tags); }
            if (config.tagsToExclude) { loaderDiv.attr('data-tags-to-exclude', config.tagsToExclude); }
            if (config.authors) { loaderDiv.attr('data-authors', config.authors); }
            if (config.excludeIds) { loaderDiv.attr('data-exclude-ids', config.excludeIds); }
            if (config.pageSize) { loaderDiv.attr('data-page-size', config.pageSize); }
            if (config.maxPage) { loaderDiv.attr('data-max-page', config.maxPage); }
        };

        var _startUp = function () {
            $(loaderSpinnerDivSelector).hide();
            $(loaderButtonDivSelector).off();
            $(loaderButtonDivSelector).hide();
            $(loaderButtonDivSelector).on('click', loadMoreBtnHandler);
        };

        $(function () { _startUp(); });

        return {
            configure: function (config) { _configure(config); return this; },
            hide: function () { $(loaderButtonDivSelector).hide(); return this; },
            loadNextPage: function () { return _loadNextPage(); }
        };
    }();


    var replaceContentDetailHtml = function (target) {
        return new Promise(function (resolve, reject) {
            if (!target) { resolve(); return; }
            var articleContentToReplaceSelector = '.js-a-content-rm-full';
            var targetArticle = $(target);
            var articleKey = targetArticle.attr('data-key');
            var articlePath = targetArticle.attr('data-path');
            var targetContainer = targetArticle.find(articleContentToReplaceSelector);
            if (targetContainer && targetContainer.length > 0 && articleKey.length > 0) {
                try {
                    var dataPayload = {
                        op: 'content-detail',
                        key: articleKey,
                        path: articlePath
                        //id: 0,
                        //type: '', //'mobile|desktop' 
                    };
                    $.ajax({
                        url: '/ajax/requests.aspx',
                        method: 'GET',
                        data: dataPayload
                    }).done(function (data) {
                        //console.log(JSON.stringify(data));
                        if (data && data.length > 0 && data.substr(0, '<article'.length) == "<article") {
                            targetContainer.children().remove();
                            targetContainer.append($(data).find(articleContentToReplaceSelector).children());
                        }
                        resolve();
                    }).fail(function (jqXHR) {
                        reject(jqXHR.responseText);
                    });
                } catch (e) {
                    console.log('[lwcdh]error:' + e);
                    reject(e);
                }
            }
            resolve();
        });
    };

    return {
        loadMoreProcessor: _loadMoreProcessor,
        replaceContentDetailHtml
    };

}();
;
function TopsJson() {
    var topsContainer = jQuery(".top");

    if (topsContainer.length > 0) {
        renderTops()
            .then(function (result) { topsContainer.append(result); })
            .catch(function (err) { topsContainer.appendTo('<!-- tops: ' + err + ' -->');});
    }

    var topsMMContainer = jQuery(".topmm");
    if (topsMMContainer.length > 0) {
        renderTopsMM()
            .then(function (result) { topsMMContainer.append(result); })
            .catch(function (err) { topsMMContainer.appendTo('<!-- tops: ' + err + ' -->'); });
    }
}

var getFirstMediaItem = function (jsonMediaItems, type, flagOrder) {
    if (!jsonMediaItems || !jsHelper.isAnArray(jsonMediaItems) || jsonMediaItems.length == 0) return null;
    var mOfType = jsonMediaItems.filter(function (item) { return item["media-type"] == "image"; });
    if (mOfType.length == 0) return null;
    if (mOfType.length == 1 || !flagOrder) return mOfType[0];
    var itemToReturn = null;
    flagOrder.some(function (flag) {
        if (flag == "*") { itemToReturn = mOfType[0]; return true; }
        var mOfFlag = null;
        if (flag == '') {
            mOfFlag = mOfType.filter(function (item) { return (item["flags"] == null || (jsHelper.isAnArray(item["flags"]) && item["flags"].length == 0)); });
        }
        else {
            mOfFlag = mOfType.filter(function (item) { return (jsHelper.isAnArray(item["flags"]) && item["flags"].some(function (fl) { return fl == flag })); });
        }
        if (mOfFlag.length > 0) { itemToReturn = mOfFlag[0]; return true; }
        return false;
    });
    return itemToReturn;
};

var renderTops = function (mobileVersion, overrideOptions, title) {
    return new Promise(function (resolve, reject) {
        //if (!mobileVersion) { reject("nom mobile version not implemented!"); }
        if (!title) title = 'Tops';
        var dtFrom = new Date();
        dtFrom.setDate(dtFrom.getDate() - 2); // one week back ?
        var payload = {
            from: dtFrom,
            to: new Date(),
            sections: [],
            properties: [],
            tags: [],
            parts: ["image","timestamp"],
            "max-items": 5
        };
        
        jsonContentApiProxy
            .post('api/dn/content/top', payload)
            .then(function (data) {
                if (!data || data.length == 0) { reject("Sem conteudo para mostrar");  }
                
                var topHtml = $('<header><h3><span>Não Perca</span></h3></header><div class="t-article-list-2-body"><ul></ul></div></aside>');
                var itemHtmlString = "<li><a href='' class='t-al2-pic' data-key='item-image'><figure><img alt='' src='' data-src='' class='lazy-hidden' /></figure></a><a href='' class='t-al2-kicker'><span data-key='item-section'></span></a><a href='' class='t-al2-text'><span data-key='item-title'></span></a></li>";
    
                if (data) {
                    data.forEach(function (item, index) {
                        var itemDate = formatDate(item.timestamp);
                        var topItem = $(itemHtmlString);

                        topItem.find("a").attr("href", jsHelper.makeUrlRelative(item.url));
                        topItem.find('[data-key="item-title"]').html(item.title);
                        topItem.find('[data-key="item-section"]').html(item.section.split('/').pop());

                        if (item.media.length > 0) {
                            topItem.find('figure').append($('<img alt="" class="lazy-hidden" />').attr('src', 'https://static.globalnoticias.pt/dn/common/images/blank-1.png').attr('data-src', item.media[0].url + '&w=73&h=73&t=' + itemDate));
                        } else {
                            topItem.find('[data-key="item-image"]').remove();
                        }

                        topItem.appendTo(topHtml.find("ul"));
                    });
                }

                resolve(topHtml);
            })
            .catch(function (err) { reject(err); console.log(err);});
    });
}

var renderTopsMM = function (mobileVersion, overrideOptions, title) {
    return new Promise(function (resolve, reject) {
        //if (!mobileVersion) { reject("nom mobile version not implemented!"); }
        if (!title) title = 'Tops';
        var dtFrom = new Date();
        dtFrom.setDate(dtFrom.getDate() - 2); // one week back ?
        var payload = {
            from: dtFrom,
            to: new Date(),
            sections: [],
            properties: [],
            tags: [],
            parts: ["image"],
            "max-items": 5
        };

        jsonContentApiProxy
            .post('api/dn/content/top', payload)
            .then(function (data) {
                if (!data || data.length == 0) { reject("Sem conteudo para mostrar"); }

                var topHtml = $('<div class="t-article-list-8-body"><ul></ul></div></aside>');
                var itemHtmlString = "<li><a href='' class='t-al8-pic' data-key='item-image'><figure><img alt='' src='' data-src='' class='lazy-hidden' /></figure></a><a href='' class='t-al8-kicker'><span data-key='item-section'></span></a><a href='' class='t-al8-text'><span data-key='item-title'></span></a></li>";

                if (data) {
                    data.forEach(function (item, index) {
                        var itemDate = formatDate(item.timestamp);
                        var topItem = $(itemHtmlString);

                        topItem.find("a").attr("href", jsHelper.makeUrlRelative(item.url));
                        topItem.find('[data-key="item-title"]').html(item.title);
                        topItem.find('[data-key="item-section"]').html(item.section.split('/').pop());

                        if (item.media.length > 0) {
                            topItem.find('figure').append($('<img alt="" class="lazy-hidden" />').attr('src', 'https://static.globalnoticias.pt/dn/common/images/blank-1.png').attr('data-src', item.media[0].url + '&w=73&h=73&t=' + itemDate));
                        } else {
                            topItem.find('[data-key="item-image"]').remove();
                        }

                        topItem.appendTo(topHtml.find("ul"));
                    });
                }

                resolve(topHtml);
            })
            .catch(function (err) { reject(err); console.log(err); });
    });
};
/*
    A simple jQuery modal (http://github.com/kylefox/jquery-modal)
    Version 0.7.0
*/
(function ($) {

    var modals = [],
        getCurrent = function () {
            return modals.length ? modals[modals.length - 1] : null;
        },
        selectCurrent = function () {
            var i,
                selected = false;
            for (i = modals.length - 1; i >= 0; i--) {
                if (modals[i].$blocker) {
                    modals[i].$blocker.toggleClass('current', !selected).toggleClass('behind', selected);
                    selected = true;
                }
            }
        };

    $.modal = function (el, options) {
        var remove, target;
        this.$body = $('body');
        this.options = $.extend({}, $.modal.defaults, options);
        this.options.doFade = !isNaN(parseInt(this.options.fadeDuration, 10));
        this.$blocker = null;
        if (this.options.closeExisting)
            while ($.modal.isActive())
                $.modal.close(); // Close any open modals.
        modals.push(this);
        if (el.is('a')) {
            target = el.attr('href');
            //Select element by id from href
            if (/^#/.test(target)) {
                this.$elm = $(target);
                if (this.$elm.length !== 1) return null;
                this.$body.append(this.$elm);
                this.open();
                //AJAX
            } else {
                this.$elm = $('<div>');
                this.$body.append(this.$elm);
                remove = function (event, modal) { modal.elm.remove(); };
                this.showSpinner();
                el.trigger($.modal.AJAX_SEND);
                $.get(target).done(function (html) {
                    if (!$.modal.isActive()) return;
                    el.trigger($.modal.AJAX_SUCCESS);
                    var current = getCurrent();
                    current.$elm.empty().append(html).on($.modal.CLOSE, remove);
                    current.hideSpinner();
                    current.open();
                    el.trigger($.modal.AJAX_COMPLETE);
                }).fail(function () {
                    el.trigger($.modal.AJAX_FAIL);
                    var current = getCurrent();
                    current.hideSpinner();
                    modals.pop(); // remove expected modal from the list
                    el.trigger($.modal.AJAX_COMPLETE);
                });
            }
        } else {
            this.$elm = el;
            this.$body.append(this.$elm);
            this.open();
        }
    };

    $.modal.prototype = {
        constructor: $.modal,

        open: function () {
            var m = this;
            this.block();
            if (this.options.doFade) {
                setTimeout(function () {
                    m.show();
                }, this.options.fadeDuration * this.options.fadeDelay);
            } else {
                this.show();
            }
            $(document).off('keydown.modal').on('keydown.modal', function (event) {
                var current = getCurrent();
                if (event.which == 27 && current.options.escapeClose) current.close();
            });
            if (this.options.clickClose)
                this.$blocker.click(function (e) {
                    if (e.target == this)
                        $.modal.close();
                });
        },

        close: function () {
            modals.pop();
            this.unblock();
            this.hide();
            if (!$.modal.isActive())
                $(document).off('keydown.modal');
        },

        block: function () {
            this.$elm.trigger($.modal.BEFORE_BLOCK, [this._ctx()]);
            this.$body.css('overflow', 'hidden');
            this.$blocker = $('<div class="jquery-modal blocker current"></div>').appendTo(this.$body);
            selectCurrent();
            if (this.options.doFade) {
                this.$blocker.css('opacity', 0).animate({ opacity: 1 }, this.options.fadeDuration);
            }
            this.$elm.trigger($.modal.BLOCK, [this._ctx()]);
        },

        unblock: function (now) {
            if (!now && this.options.doFade)
                this.$blocker.fadeOut(this.options.fadeDuration, this.unblock.bind(this, true));
            else {
                this.$blocker.children().appendTo(this.$body);
                this.$blocker.remove();
                this.$blocker = null;
                selectCurrent();
                if (!$.modal.isActive())
                    this.$body.css('overflow', '');
            }
        },

        show: function () {
            this.$elm.trigger($.modal.BEFORE_OPEN, [this._ctx()]);
            if (this.options.showClose) {
                this.closeButton = $('<a href="#close-modal" rel="modal:close" class="close-modal ' + this.options.closeClass + '">' + this.options.closeText + '</a>');
                this.$elm.append(this.closeButton);
            }
            this.$elm.addClass(this.options.modalClass).appendTo(this.$blocker);
            if (this.options.doFade) {
                this.$elm.css('opacity', 0).show().animate({ opacity: 1 }, this.options.fadeDuration);
            } else {
                this.$elm.show();
            }
            this.$elm.trigger($.modal.OPEN, [this._ctx()]);
        },

        hide: function () {
            this.$elm.trigger($.modal.BEFORE_CLOSE, [this._ctx()]);
            if (this.closeButton) this.closeButton.remove();
            var _this = this;
            if (this.options.doFade) {
                this.$elm.fadeOut(this.options.fadeDuration, function () {
                    _this.$elm.trigger($.modal.AFTER_CLOSE, [_this._ctx()]);
                });
            } else {
                this.$elm.hide(0, function () {
                    _this.$elm.trigger($.modal.AFTER_CLOSE, [_this._ctx()]);
                });
            }
            this.$elm.trigger($.modal.CLOSE, [this._ctx()]);
        },

        showSpinner: function () {
            if (!this.options.showSpinner) return;
            this.spinner = this.spinner || $('<div class="' + this.options.modalClass + '-spinner"></div>')
              .append(this.options.spinnerHtml);
            this.$body.append(this.spinner);
            this.spinner.show();
        },

        hideSpinner: function () {
            if (this.spinner) this.spinner.remove();
        },

        //Return context for custom events
        _ctx: function () {
            return { elm: this.$elm, $blocker: this.$blocker, options: this.options };
        }
    };

    $.modal.close = function (event) {
        if (!$.modal.isActive()) return;
        if (event) event.preventDefault();
        var current = getCurrent();
        current.close();
        return current.$elm;
    };

    // Returns if there currently is an active modal
    $.modal.isActive = function () {
        return modals.length > 0;
    }

    $.modal.defaults = {
        closeExisting: true,
        escapeClose: true,
        clickClose: true,
        closeText: 'Close',
        closeClass: '',
        modalClass: "modal",
        spinnerHtml: null,
        showSpinner: true,
        showClose: true,
        fadeDuration: null,   // Number of milliseconds the fade animation takes.
        fadeDelay: 1.0        // Point during the overlay's fade-in that the modal begins to fade in (.5 = 50%, 1.5 = 150%, etc.)
    };

    // Event constants
    $.modal.BEFORE_BLOCK = 'modal:before-block';
    $.modal.BLOCK = 'modal:block';
    $.modal.BEFORE_OPEN = 'modal:before-open';
    $.modal.OPEN = 'modal:open';
    $.modal.BEFORE_CLOSE = 'modal:before-close';
    $.modal.CLOSE = 'modal:close';
    $.modal.AFTER_CLOSE = 'modal:after-close';
    $.modal.AJAX_SEND = 'modal:ajax:send';
    $.modal.AJAX_SUCCESS = 'modal:ajax:success';
    $.modal.AJAX_FAIL = 'modal:ajax:fail';
    $.modal.AJAX_COMPLETE = 'modal:ajax:complete';

    $.fn.modal = function (options) {
        if (this.length === 1) {
            new $.modal(this, options);
        }
        return this;
    };

    // Automatically bind links with rel="modal:close" to, well, close the modal.
    $(document).on('click.modal', 'a[rel="modal:close"]', $.modal.close);
    $(document).on('click.modal', 'a[rel="modal:open"]', function (event) {
        event.preventDefault();
        $(this).modal();
    });
})(jQuery);;
!function(t,e,i){!function(){var s,a,n,h="2.2.3",o="datepicker",r=".datepicker-here",c=!1,d='<div class="datepicker"><i class="datepicker--pointer"></i><nav class="datepicker--nav"></nav><div class="datepicker--content"></div></div>',l={classes:"",inline:!1,language:"ru",startDate:new Date,firstDay:"",weekends:[6,0],dateFormat:"",altField:"",altFieldDateFormat:"@",toggleSelected:!0,keyboardNav:!0,position:"bottom left",offset:12,view:"days",minView:"days",showOtherMonths:!0,selectOtherMonths:!0,moveToOtherMonthsOnSelect:!0,showOtherYears:!0,selectOtherYears:!0,moveToOtherYearsOnSelect:!0,minDate:"",maxDate:"",disableNavWhenOutOfRange:!0,multipleDates:!1,multipleDatesSeparator:",",range:!1,todayButton:!1,clearButton:!1,showEvent:"focus",autoClose:!1,monthsField:"monthsShort",prevHtml:'<svg><path d="M 17,12 l -5,5 l 5,5"></path></svg>',nextHtml:'<svg><path d="M 14,12 l 5,5 l -5,5"></path></svg>',navTitles:{days:"MM, <i>yyyy</i>",months:"yyyy",years:"yyyy1 - yyyy2"},timepicker:!1,onlyTimepicker:!1,dateTimeSeparator:" ",timeFormat:"",minHours:0,maxHours:24,minMinutes:0,maxMinutes:59,hoursStep:1,minutesStep:1,onSelect:"",onShow:"",onHide:"",onChangeMonth:"",onChangeYear:"",onChangeDecade:"",onChangeView:"",onRenderCell:""},u={ctrlRight:[17,39],ctrlUp:[17,38],ctrlLeft:[17,37],ctrlDown:[17,40],shiftRight:[16,39],shiftUp:[16,38],shiftLeft:[16,37],shiftDown:[16,40],altUp:[18,38],altRight:[18,39],altLeft:[18,37],altDown:[18,40],ctrlShiftUp:[16,17,38]},m=function(t,a){this.el=t,this.$el=e(t),this.opts=e.extend(!0,{},l,a,this.$el.data()),s==i&&(s=e("body")),this.opts.startDate||(this.opts.startDate=new Date),"INPUT"==this.el.nodeName&&(this.elIsInput=!0),this.opts.altField&&(this.$altField="string"==typeof this.opts.altField?e(this.opts.altField):this.opts.altField),this.inited=!1,this.visible=!1,this.silent=!1,this.currentDate=this.opts.startDate,this.currentView=this.opts.view,this._createShortCuts(),this.selectedDates=[],this.views={},this.keys=[],this.minRange="",this.maxRange="",this._prevOnSelectValue="",this.init()};n=m,n.prototype={VERSION:h,viewIndexes:["days","months","years"],init:function(){c||this.opts.inline||!this.elIsInput||this._buildDatepickersContainer(),this._buildBaseHtml(),this._defineLocale(this.opts.language),this._syncWithMinMaxDates(),this.elIsInput&&(this.opts.inline||(this._setPositionClasses(this.opts.position),this._bindEvents()),this.opts.keyboardNav&&!this.opts.onlyTimepicker&&this._bindKeyboardEvents(),this.$datepicker.on("mousedown",this._onMouseDownDatepicker.bind(this)),this.$datepicker.on("mouseup",this._onMouseUpDatepicker.bind(this))),this.opts.classes&&this.$datepicker.addClass(this.opts.classes),this.opts.timepicker&&(this.timepicker=new e.fn.datepicker.Timepicker(this,this.opts),this._bindTimepickerEvents()),this.opts.onlyTimepicker&&this.$datepicker.addClass("-only-timepicker-"),this.views[this.currentView]=new e.fn.datepicker.Body(this,this.currentView,this.opts),this.views[this.currentView].show(),this.nav=new e.fn.datepicker.Navigation(this,this.opts),this.view=this.currentView,this.$el.on("clickCell.adp",this._onClickCell.bind(this)),this.$datepicker.on("mouseenter",".datepicker--cell",this._onMouseEnterCell.bind(this)),this.$datepicker.on("mouseleave",".datepicker--cell",this._onMouseLeaveCell.bind(this)),this.inited=!0},_createShortCuts:function(){this.minDate=this.opts.minDate?this.opts.minDate:new Date(-86399999136e5),this.maxDate=this.opts.maxDate?this.opts.maxDate:new Date(86399999136e5)},_bindEvents:function(){this.$el.on(this.opts.showEvent+".adp",this._onShowEvent.bind(this)),this.$el.on("mouseup.adp",this._onMouseUpEl.bind(this)),this.$el.on("blur.adp",this._onBlur.bind(this)),this.$el.on("keyup.adp",this._onKeyUpGeneral.bind(this)),e(t).on("resize.adp",this._onResize.bind(this)),e("body").on("mouseup.adp",this._onMouseUpBody.bind(this))},_bindKeyboardEvents:function(){this.$el.on("keydown.adp",this._onKeyDown.bind(this)),this.$el.on("keyup.adp",this._onKeyUp.bind(this)),this.$el.on("hotKey.adp",this._onHotKey.bind(this))},_bindTimepickerEvents:function(){this.$el.on("timeChange.adp",this._onTimeChange.bind(this))},isWeekend:function(t){return-1!==this.opts.weekends.indexOf(t)},_defineLocale:function(t){"string"==typeof t?(this.loc=e.fn.datepicker.language[t],this.loc||(console.warn("Can't find language \""+t+'" in Datepicker.language, will use "ru" instead'),this.loc=e.extend(!0,{},e.fn.datepicker.language.ru)),this.loc=e.extend(!0,{},e.fn.datepicker.language.ru,e.fn.datepicker.language[t])):this.loc=e.extend(!0,{},e.fn.datepicker.language.ru,t),this.opts.dateFormat&&(this.loc.dateFormat=this.opts.dateFormat),this.opts.timeFormat&&(this.loc.timeFormat=this.opts.timeFormat),""!==this.opts.firstDay&&(this.loc.firstDay=this.opts.firstDay),this.opts.timepicker&&(this.loc.dateFormat=[this.loc.dateFormat,this.loc.timeFormat].join(this.opts.dateTimeSeparator)),this.opts.onlyTimepicker&&(this.loc.dateFormat=this.loc.timeFormat);var i=this._getWordBoundaryRegExp;(this.loc.timeFormat.match(i("aa"))||this.loc.timeFormat.match(i("AA")))&&(this.ampm=!0)},_buildDatepickersContainer:function(){c=!0,s.append('<div class="datepickers-container" id="datepickers-container"></div>'),a=e("#datepickers-container")},_buildBaseHtml:function(){var t,i=e('<div class="datepicker-inline">');t="INPUT"==this.el.nodeName?this.opts.inline?i.insertAfter(this.$el):a:i.appendTo(this.$el),this.$datepicker=e(d).appendTo(t),this.$content=e(".datepicker--content",this.$datepicker),this.$nav=e(".datepicker--nav",this.$datepicker)},_triggerOnChange:function(){if(!this.selectedDates.length){if(""===this._prevOnSelectValue)return;return this._prevOnSelectValue="",this.opts.onSelect("","",this)}var t,e=this.selectedDates,i=n.getParsedDate(e[0]),s=this,a=new Date(i.year,i.month,i.date,i.hours,i.minutes);t=e.map(function(t){return s.formatDate(s.loc.dateFormat,t)}).join(this.opts.multipleDatesSeparator),(this.opts.multipleDates||this.opts.range)&&(a=e.map(function(t){var e=n.getParsedDate(t);return new Date(e.year,e.month,e.date,e.hours,e.minutes)})),this._prevOnSelectValue=t,this.opts.onSelect(t,a,this)},next:function(){var t=this.parsedDate,e=this.opts;switch(this.view){case"days":this.date=new Date(t.year,t.month+1,1),e.onChangeMonth&&e.onChangeMonth(this.parsedDate.month,this.parsedDate.year);break;case"months":this.date=new Date(t.year+1,t.month,1),e.onChangeYear&&e.onChangeYear(this.parsedDate.year);break;case"years":this.date=new Date(t.year+10,0,1),e.onChangeDecade&&e.onChangeDecade(this.curDecade)}},prev:function(){var t=this.parsedDate,e=this.opts;switch(this.view){case"days":this.date=new Date(t.year,t.month-1,1),e.onChangeMonth&&e.onChangeMonth(this.parsedDate.month,this.parsedDate.year);break;case"months":this.date=new Date(t.year-1,t.month,1),e.onChangeYear&&e.onChangeYear(this.parsedDate.year);break;case"years":this.date=new Date(t.year-10,0,1),e.onChangeDecade&&e.onChangeDecade(this.curDecade)}},formatDate:function(t,e){e=e||this.date;var i,s=t,a=this._getWordBoundaryRegExp,h=this.loc,o=n.getLeadingZeroNum,r=n.getDecade(e),c=n.getParsedDate(e),d=c.fullHours,l=c.hours,u=t.match(a("aa"))||t.match(a("AA")),m="am",p=this._replacer;switch(this.opts.timepicker&&this.timepicker&&u&&(i=this.timepicker._getValidHoursFromDate(e,u),d=o(i.hours),l=i.hours,m=i.dayPeriod),!0){case/@/.test(s):s=s.replace(/@/,e.getTime());case/aa/.test(s):s=p(s,a("aa"),m);case/AA/.test(s):s=p(s,a("AA"),m.toUpperCase());case/dd/.test(s):s=p(s,a("dd"),c.fullDate);case/d/.test(s):s=p(s,a("d"),c.date);case/DD/.test(s):s=p(s,a("DD"),h.days[c.day]);case/D/.test(s):s=p(s,a("D"),h.daysShort[c.day]);case/mm/.test(s):s=p(s,a("mm"),c.fullMonth);case/m/.test(s):s=p(s,a("m"),c.month+1);case/MM/.test(s):s=p(s,a("MM"),this.loc.months[c.month]);case/M/.test(s):s=p(s,a("M"),h.monthsShort[c.month]);case/ii/.test(s):s=p(s,a("ii"),c.fullMinutes);case/i/.test(s):s=p(s,a("i"),c.minutes);case/hh/.test(s):s=p(s,a("hh"),d);case/h/.test(s):s=p(s,a("h"),l);case/yyyy/.test(s):s=p(s,a("yyyy"),c.year);case/yyyy1/.test(s):s=p(s,a("yyyy1"),r[0]);case/yyyy2/.test(s):s=p(s,a("yyyy2"),r[1]);case/yy/.test(s):s=p(s,a("yy"),c.year.toString().slice(-2))}return s},_replacer:function(t,e,i){return t.replace(e,function(t,e,s,a){return e+i+a})},_getWordBoundaryRegExp:function(t){var e="\\s|\\.|-|/|\\\\|,|\\$|\\!|\\?|:|;";return new RegExp("(^|>|"+e+")("+t+")($|<|"+e+")","g")},selectDate:function(t){var e=this,i=e.opts,s=e.parsedDate,a=e.selectedDates,h=a.length,o="";if(Array.isArray(t))return void t.forEach(function(t){e.selectDate(t)});if(t instanceof Date){if(this.lastSelectedDate=t,this.timepicker&&this.timepicker._setTime(t),e._trigger("selectDate",t),this.timepicker&&(t.setHours(this.timepicker.hours),t.setMinutes(this.timepicker.minutes)),"days"==e.view&&t.getMonth()!=s.month&&i.moveToOtherMonthsOnSelect&&(o=new Date(t.getFullYear(),t.getMonth(),1)),"years"==e.view&&t.getFullYear()!=s.year&&i.moveToOtherYearsOnSelect&&(o=new Date(t.getFullYear(),0,1)),o&&(e.silent=!0,e.date=o,e.silent=!1,e.nav._render()),i.multipleDates&&!i.range){if(h===i.multipleDates)return;e._isSelected(t)||e.selectedDates.push(t)}else i.range?2==h?(e.selectedDates=[t],e.minRange=t,e.maxRange=""):1==h?(e.selectedDates.push(t),e.maxRange?e.minRange=t:e.maxRange=t,n.bigger(e.maxRange,e.minRange)&&(e.maxRange=e.minRange,e.minRange=t),e.selectedDates=[e.minRange,e.maxRange]):(e.selectedDates=[t],e.minRange=t):e.selectedDates=[t];e._setInputValue(),i.onSelect&&e._triggerOnChange(),i.autoClose&&!this.timepickerIsActive&&(i.multipleDates||i.range?i.range&&2==e.selectedDates.length&&e.hide():e.hide()),e.views[this.currentView]._render()}},removeDate:function(t){var e=this.selectedDates,i=this;if(t instanceof Date)return e.some(function(s,a){return n.isSame(s,t)?(e.splice(a,1),i.selectedDates.length?i.lastSelectedDate=i.selectedDates[i.selectedDates.length-1]:(i.minRange="",i.maxRange="",i.lastSelectedDate=""),i.views[i.currentView]._render(),i._setInputValue(),i.opts.onSelect&&i._triggerOnChange(),!0):void 0})},today:function(){this.silent=!0,this.view=this.opts.minView,this.silent=!1,this.date=new Date,this.opts.todayButton instanceof Date&&this.selectDate(this.opts.todayButton)},clear:function(){this.selectedDates=[],this.minRange="",this.maxRange="",this.views[this.currentView]._render(),this._setInputValue(),this.opts.onSelect&&this._triggerOnChange()},update:function(t,i){var s=arguments.length,a=this.lastSelectedDate;return 2==s?this.opts[t]=i:1==s&&"object"==typeof t&&(this.opts=e.extend(!0,this.opts,t)),this._createShortCuts(),this._syncWithMinMaxDates(),this._defineLocale(this.opts.language),this.nav._addButtonsIfNeed(),this.opts.onlyTimepicker||this.nav._render(),this.views[this.currentView]._render(),this.elIsInput&&!this.opts.inline&&(this._setPositionClasses(this.opts.position),this.visible&&this.setPosition(this.opts.position)),this.opts.classes&&this.$datepicker.addClass(this.opts.classes),this.opts.onlyTimepicker&&this.$datepicker.addClass("-only-timepicker-"),this.opts.timepicker&&(a&&this.timepicker._handleDate(a),this.timepicker._updateRanges(),this.timepicker._updateCurrentTime(),a&&(a.setHours(this.timepicker.hours),a.setMinutes(this.timepicker.minutes))),this._setInputValue(),this},_syncWithMinMaxDates:function(){var t=this.date.getTime();this.silent=!0,this.minTime>t&&(this.date=this.minDate),this.maxTime<t&&(this.date=this.maxDate),this.silent=!1},_isSelected:function(t,e){var i=!1;return this.selectedDates.some(function(s){return n.isSame(s,t,e)?(i=s,!0):void 0}),i},_setInputValue:function(){var t,e=this,i=e.opts,s=e.loc.dateFormat,a=i.altFieldDateFormat,n=e.selectedDates.map(function(t){return e.formatDate(s,t)});i.altField&&e.$altField.length&&(t=this.selectedDates.map(function(t){return e.formatDate(a,t)}),t=t.join(this.opts.multipleDatesSeparator),this.$altField.val(t)),n=n.join(this.opts.multipleDatesSeparator),this.$el.val(n)},_isInRange:function(t,e){var i=t.getTime(),s=n.getParsedDate(t),a=n.getParsedDate(this.minDate),h=n.getParsedDate(this.maxDate),o=new Date(s.year,s.month,a.date).getTime(),r=new Date(s.year,s.month,h.date).getTime(),c={day:i>=this.minTime&&i<=this.maxTime,month:o>=this.minTime&&r<=this.maxTime,year:s.year>=a.year&&s.year<=h.year};return e?c[e]:c.day},_getDimensions:function(t){var e=t.offset();return{width:t.outerWidth(),height:t.outerHeight(),left:e.left,top:e.top}},_getDateFromCell:function(t){var e=this.parsedDate,s=t.data("year")||e.year,a=t.data("month")==i?e.month:t.data("month"),n=t.data("date")||1;return new Date(s,a,n)},_setPositionClasses:function(t){t=t.split(" ");var e=t[0],i=t[1],s="datepicker -"+e+"-"+i+"- -from-"+e+"-";this.visible&&(s+=" active"),this.$datepicker.removeAttr("class").addClass(s)},setPosition:function(t){t=t||this.opts.position;var e,i,s=this._getDimensions(this.$el),a=this._getDimensions(this.$datepicker),n=t.split(" "),h=this.opts.offset,o=n[0],r=n[1];switch(o){case"top":e=s.top-a.height-h;break;case"right":i=s.left+s.width+h;break;case"bottom":e=s.top+s.height+h;break;case"left":i=s.left-a.width-h}switch(r){case"top":e=s.top;break;case"right":i=s.left+s.width-a.width;break;case"bottom":e=s.top+s.height-a.height;break;case"left":i=s.left;break;case"center":/left|right/.test(o)?e=s.top+s.height/2-a.height/2:i=s.left+s.width/2-a.width/2}this.$datepicker.css({left:i,top:e})},show:function(){var t=this.opts.onShow;this.setPosition(this.opts.position),this.$datepicker.addClass("active"),this.visible=!0,t&&this._bindVisionEvents(t)},hide:function(){var t=this.opts.onHide;this.$datepicker.removeClass("active").css({left:"-100000px"}),this.focused="",this.keys=[],this.inFocus=!1,this.visible=!1,this.$el.blur(),t&&this._bindVisionEvents(t)},down:function(t){this._changeView(t,"down")},up:function(t){this._changeView(t,"up")},_bindVisionEvents:function(t){this.$datepicker.off("transitionend.dp"),t(this,!1),this.$datepicker.one("transitionend.dp",t.bind(this,this,!0))},_changeView:function(t,e){t=t||this.focused||this.date;var i="up"==e?this.viewIndex+1:this.viewIndex-1;i>2&&(i=2),0>i&&(i=0),this.silent=!0,this.date=new Date(t.getFullYear(),t.getMonth(),1),this.silent=!1,this.view=this.viewIndexes[i]},_handleHotKey:function(t){var e,i,s,a=n.getParsedDate(this._getFocusedDate()),h=this.opts,o=!1,r=!1,c=!1,d=a.year,l=a.month,u=a.date;switch(t){case"ctrlRight":case"ctrlUp":l+=1,o=!0;break;case"ctrlLeft":case"ctrlDown":l-=1,o=!0;break;case"shiftRight":case"shiftUp":r=!0,d+=1;break;case"shiftLeft":case"shiftDown":r=!0,d-=1;break;case"altRight":case"altUp":c=!0,d+=10;break;case"altLeft":case"altDown":c=!0,d-=10;break;case"ctrlShiftUp":this.up()}s=n.getDaysCount(new Date(d,l)),i=new Date(d,l,u),u>s&&(u=s),i.getTime()<this.minTime?i=this.minDate:i.getTime()>this.maxTime&&(i=this.maxDate),this.focused=i,e=n.getParsedDate(i),o&&h.onChangeMonth&&h.onChangeMonth(e.month,e.year),r&&h.onChangeYear&&h.onChangeYear(e.year),c&&h.onChangeDecade&&h.onChangeDecade(this.curDecade)},_registerKey:function(t){var e=this.keys.some(function(e){return e==t});e||this.keys.push(t)},_unRegisterKey:function(t){var e=this.keys.indexOf(t);this.keys.splice(e,1)},_isHotKeyPressed:function(){var t,e=!1,i=this,s=this.keys.sort();for(var a in u)t=u[a],s.length==t.length&&t.every(function(t,e){return t==s[e]})&&(i._trigger("hotKey",a),e=!0);return e},_trigger:function(t,e){this.$el.trigger(t,e)},_focusNextCell:function(t,e){e=e||this.cellType;var i=n.getParsedDate(this._getFocusedDate()),s=i.year,a=i.month,h=i.date;if(!this._isHotKeyPressed()){switch(t){case 37:"day"==e?h-=1:"","month"==e?a-=1:"","year"==e?s-=1:"";break;case 38:"day"==e?h-=7:"","month"==e?a-=3:"","year"==e?s-=4:"";break;case 39:"day"==e?h+=1:"","month"==e?a+=1:"","year"==e?s+=1:"";break;case 40:"day"==e?h+=7:"","month"==e?a+=3:"","year"==e?s+=4:""}var o=new Date(s,a,h);o.getTime()<this.minTime?o=this.minDate:o.getTime()>this.maxTime&&(o=this.maxDate),this.focused=o}},_getFocusedDate:function(){var t=this.focused||this.selectedDates[this.selectedDates.length-1],e=this.parsedDate;if(!t)switch(this.view){case"days":t=new Date(e.year,e.month,(new Date).getDate());break;case"months":t=new Date(e.year,e.month,1);break;case"years":t=new Date(e.year,0,1)}return t},_getCell:function(t,i){i=i||this.cellType;var s,a=n.getParsedDate(t),h='.datepicker--cell[data-year="'+a.year+'"]';switch(i){case"month":h='[data-month="'+a.month+'"]';break;case"day":h+='[data-month="'+a.month+'"][data-date="'+a.date+'"]'}return s=this.views[this.currentView].$el.find(h),s.length?s:e("")},destroy:function(){var t=this;t.$el.off(".adp").data("datepicker",""),t.selectedDates=[],t.focused="",t.views={},t.keys=[],t.minRange="",t.maxRange="",t.opts.inline||!t.elIsInput?t.$datepicker.closest(".datepicker-inline").remove():t.$datepicker.remove()},_handleAlreadySelectedDates:function(t,e){this.opts.range?this.opts.toggleSelected?this.removeDate(e):2!=this.selectedDates.length&&this._trigger("clickCell",e):this.opts.toggleSelected&&this.removeDate(e),this.opts.toggleSelected||(this.lastSelectedDate=t,this.opts.timepicker&&(this.timepicker._setTime(t),this.timepicker.update()))},_onShowEvent:function(t){this.visible||this.show()},_onBlur:function(){!this.inFocus&&this.visible&&this.hide()},_onMouseDownDatepicker:function(t){this.inFocus=!0},_onMouseUpDatepicker:function(t){this.inFocus=!1,t.originalEvent.inFocus=!0,t.originalEvent.timepickerFocus||this.$el.focus()},_onKeyUpGeneral:function(t){var e=this.$el.val();e||this.clear()},_onResize:function(){this.visible&&this.setPosition()},_onMouseUpBody:function(t){t.originalEvent.inFocus||this.visible&&!this.inFocus&&this.hide()},_onMouseUpEl:function(t){t.originalEvent.inFocus=!0,setTimeout(this._onKeyUpGeneral.bind(this),4)},_onKeyDown:function(t){var e=t.which;if(this._registerKey(e),e>=37&&40>=e&&(t.preventDefault(),this._focusNextCell(e)),13==e&&this.focused){if(this._getCell(this.focused).hasClass("-disabled-"))return;if(this.view!=this.opts.minView)this.down();else{var i=this._isSelected(this.focused,this.cellType);if(!i)return this.timepicker&&(this.focused.setHours(this.timepicker.hours),this.focused.setMinutes(this.timepicker.minutes)),void this.selectDate(this.focused);this._handleAlreadySelectedDates(i,this.focused)}}27==e&&this.hide()},_onKeyUp:function(t){var e=t.which;this._unRegisterKey(e)},_onHotKey:function(t,e){this._handleHotKey(e)},_onMouseEnterCell:function(t){var i=e(t.target).closest(".datepicker--cell"),s=this._getDateFromCell(i);this.silent=!0,this.focused&&(this.focused=""),i.addClass("-focus-"),this.focused=s,this.silent=!1,this.opts.range&&1==this.selectedDates.length&&(this.minRange=this.selectedDates[0],this.maxRange="",n.less(this.minRange,this.focused)&&(this.maxRange=this.minRange,this.minRange=""),this.views[this.currentView]._update())},_onMouseLeaveCell:function(t){var i=e(t.target).closest(".datepicker--cell");i.removeClass("-focus-"),this.silent=!0,this.focused="",this.silent=!1},_onTimeChange:function(t,e,i){var s=new Date,a=this.selectedDates,n=!1;a.length&&(n=!0,s=this.lastSelectedDate),s.setHours(e),s.setMinutes(i),n||this._getCell(s).hasClass("-disabled-")?(this._setInputValue(),this.opts.onSelect&&this._triggerOnChange()):this.selectDate(s)},_onClickCell:function(t,e){this.timepicker&&(e.setHours(this.timepicker.hours),e.setMinutes(this.timepicker.minutes)),this.selectDate(e)},set focused(t){if(!t&&this.focused){var e=this._getCell(this.focused);e.length&&e.removeClass("-focus-")}this._focused=t,this.opts.range&&1==this.selectedDates.length&&(this.minRange=this.selectedDates[0],this.maxRange="",n.less(this.minRange,this._focused)&&(this.maxRange=this.minRange,this.minRange="")),this.silent||(this.date=t)},get focused(){return this._focused},get parsedDate(){return n.getParsedDate(this.date)},set date(t){return t instanceof Date?(this.currentDate=t,this.inited&&!this.silent&&(this.views[this.view]._render(),this.nav._render(),this.visible&&this.elIsInput&&this.setPosition()),t):void 0},get date(){return this.currentDate},set view(t){return this.viewIndex=this.viewIndexes.indexOf(t),this.viewIndex<0?void 0:(this.prevView=this.currentView,this.currentView=t,this.inited&&(this.views[t]?this.views[t]._render():this.views[t]=new e.fn.datepicker.Body(this,t,this.opts),this.views[this.prevView].hide(),this.views[t].show(),this.nav._render(),this.opts.onChangeView&&this.opts.onChangeView(t),this.elIsInput&&this.visible&&this.setPosition()),t)},get view(){return this.currentView},get cellType(){return this.view.substring(0,this.view.length-1)},get minTime(){var t=n.getParsedDate(this.minDate);return new Date(t.year,t.month,t.date).getTime()},get maxTime(){var t=n.getParsedDate(this.maxDate);return new Date(t.year,t.month,t.date).getTime()},get curDecade(){return n.getDecade(this.date)}},n.getDaysCount=function(t){return new Date(t.getFullYear(),t.getMonth()+1,0).getDate()},n.getParsedDate=function(t){return{year:t.getFullYear(),month:t.getMonth(),fullMonth:t.getMonth()+1<10?"0"+(t.getMonth()+1):t.getMonth()+1,date:t.getDate(),fullDate:t.getDate()<10?"0"+t.getDate():t.getDate(),day:t.getDay(),hours:t.getHours(),fullHours:t.getHours()<10?"0"+t.getHours():t.getHours(),minutes:t.getMinutes(),fullMinutes:t.getMinutes()<10?"0"+t.getMinutes():t.getMinutes()}},n.getDecade=function(t){var e=10*Math.floor(t.getFullYear()/10);return[e,e+9]},n.template=function(t,e){return t.replace(/#\{([\w]+)\}/g,function(t,i){return e[i]||0===e[i]?e[i]:void 0})},n.isSame=function(t,e,i){if(!t||!e)return!1;var s=n.getParsedDate(t),a=n.getParsedDate(e),h=i?i:"day",o={day:s.date==a.date&&s.month==a.month&&s.year==a.year,month:s.month==a.month&&s.year==a.year,year:s.year==a.year};return o[h]},n.less=function(t,e,i){return t&&e?e.getTime()<t.getTime():!1},n.bigger=function(t,e,i){return t&&e?e.getTime()>t.getTime():!1},n.getLeadingZeroNum=function(t){return parseInt(t)<10?"0"+t:t},n.resetTime=function(t){return"object"==typeof t?(t=n.getParsedDate(t),new Date(t.year,t.month,t.date)):void 0},e.fn.datepicker=function(t){return this.each(function(){if(e.data(this,o)){var i=e.data(this,o);i.opts=e.extend(!0,i.opts,t),i.update()}else e.data(this,o,new m(this,t))})},e.fn.datepicker.Constructor=m,e.fn.datepicker.language={ru:{days:["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],daysShort:["Вос","Пон","Вто","Сре","Чет","Пят","Суб"],daysMin:["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],months:["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],monthsShort:["Янв","Фев","Мар","Апр","Май","Июн","Июл","Авг","Сен","Окт","Ноя","Дек"],today:"Сегодня",clear:"Очистить",dateFormat:"dd.mm.yyyy",timeFormat:"hh:ii",firstDay:1}},e(function(){e(r).datepicker()})}(),function(){var t={days:'<div class="datepicker--days datepicker--body"><div class="datepicker--days-names"></div><div class="datepicker--cells datepicker--cells-days"></div></div>',months:'<div class="datepicker--months datepicker--body"><div class="datepicker--cells datepicker--cells-months"></div></div>',years:'<div class="datepicker--years datepicker--body"><div class="datepicker--cells datepicker--cells-years"></div></div>'},s=e.fn.datepicker,a=s.Constructor;s.Body=function(t,i,s){this.d=t,this.type=i,this.opts=s,this.$el=e(""),this.opts.onlyTimepicker||this.init()},s.Body.prototype={init:function(){this._buildBaseHtml(),this._render(),this._bindEvents()},_bindEvents:function(){this.$el.on("click",".datepicker--cell",e.proxy(this._onClickCell,this))},_buildBaseHtml:function(){this.$el=e(t[this.type]).appendTo(this.d.$content),this.$names=e(".datepicker--days-names",this.$el),this.$cells=e(".datepicker--cells",this.$el)},_getDayNamesHtml:function(t,e,s,a){return e=e!=i?e:t,s=s?s:"",a=a!=i?a:0,a>7?s:7==e?this._getDayNamesHtml(t,0,s,++a):(s+='<div class="datepicker--day-name'+(this.d.isWeekend(e)?" -weekend-":"")+'">'+this.d.loc.daysMin[e]+"</div>",this._getDayNamesHtml(t,++e,s,++a))},_getCellContents:function(t,e){var i="datepicker--cell datepicker--cell-"+e,s=new Date,n=this.d,h=a.resetTime(n.minRange),o=a.resetTime(n.maxRange),r=n.opts,c=a.getParsedDate(t),d={},l=c.date;switch(e){case"day":n.isWeekend(c.day)&&(i+=" -weekend-"),c.month!=this.d.parsedDate.month&&(i+=" -other-month-",r.selectOtherMonths||(i+=" -disabled-"),r.showOtherMonths||(l=""));break;case"month":l=n.loc[n.opts.monthsField][c.month];break;case"year":var u=n.curDecade;l=c.year,(c.year<u[0]||c.year>u[1])&&(i+=" -other-decade-",r.selectOtherYears||(i+=" -disabled-"),r.showOtherYears||(l=""))}return r.onRenderCell&&(d=r.onRenderCell(t,e)||{},l=d.html?d.html:l,i+=d.classes?" "+d.classes:""),r.range&&(a.isSame(h,t,e)&&(i+=" -range-from-"),a.isSame(o,t,e)&&(i+=" -range-to-"),1==n.selectedDates.length&&n.focused?((a.bigger(h,t)&&a.less(n.focused,t)||a.less(o,t)&&a.bigger(n.focused,t))&&(i+=" -in-range-"),a.less(o,t)&&a.isSame(n.focused,t)&&(i+=" -range-from-"),a.bigger(h,t)&&a.isSame(n.focused,t)&&(i+=" -range-to-")):2==n.selectedDates.length&&a.bigger(h,t)&&a.less(o,t)&&(i+=" -in-range-")),a.isSame(s,t,e)&&(i+=" -current-"),n.focused&&a.isSame(t,n.focused,e)&&(i+=" -focus-"),n._isSelected(t,e)&&(i+=" -selected-"),(!n._isInRange(t,e)||d.disabled)&&(i+=" -disabled-"),{html:l,classes:i}},_getDaysHtml:function(t){var e=a.getDaysCount(t),i=new Date(t.getFullYear(),t.getMonth(),1).getDay(),s=new Date(t.getFullYear(),t.getMonth(),e).getDay(),n=i-this.d.loc.firstDay,h=6-s+this.d.loc.firstDay;n=0>n?n+7:n,h=h>6?h-7:h;for(var o,r,c=-n+1,d="",l=c,u=e+h;u>=l;l++)r=t.getFullYear(),o=t.getMonth(),d+=this._getDayHtml(new Date(r,o,l));return d},_getDayHtml:function(t){var e=this._getCellContents(t,"day");return'<div class="'+e.classes+'" data-date="'+t.getDate()+'" data-month="'+t.getMonth()+'" data-year="'+t.getFullYear()+'">'+e.html+"</div>"},_getMonthsHtml:function(t){for(var e="",i=a.getParsedDate(t),s=0;12>s;)e+=this._getMonthHtml(new Date(i.year,s)),s++;return e},_getMonthHtml:function(t){var e=this._getCellContents(t,"month");return'<div class="'+e.classes+'" data-month="'+t.getMonth()+'">'+e.html+"</div>"},_getYearsHtml:function(t){var e=(a.getParsedDate(t),a.getDecade(t)),i=e[0]-1,s="",n=i;for(n;n<=e[1]+1;n++)s+=this._getYearHtml(new Date(n,0));return s},_getYearHtml:function(t){var e=this._getCellContents(t,"year");return'<div class="'+e.classes+'" data-year="'+t.getFullYear()+'">'+e.html+"</div>"},_renderTypes:{days:function(){var t=this._getDayNamesHtml(this.d.loc.firstDay),e=this._getDaysHtml(this.d.currentDate);this.$cells.html(e),this.$names.html(t)},months:function(){var t=this._getMonthsHtml(this.d.currentDate);this.$cells.html(t)},years:function(){var t=this._getYearsHtml(this.d.currentDate);this.$cells.html(t)}},_render:function(){this.opts.onlyTimepicker||this._renderTypes[this.type].bind(this)()},_update:function(){var t,i,s,a=e(".datepicker--cell",this.$cells),n=this;a.each(function(a,h){i=e(this),s=n.d._getDateFromCell(e(this)),t=n._getCellContents(s,n.d.cellType),i.attr("class",t.classes)})},show:function(){this.opts.onlyTimepicker||(this.$el.addClass("active"),this.acitve=!0)},hide:function(){this.$el.removeClass("active"),this.active=!1},_handleClick:function(t){var e=t.data("date")||1,i=t.data("month")||0,s=t.data("year")||this.d.parsedDate.year,a=this.d;if(a.view!=this.opts.minView)return void a.down(new Date(s,i,e));var n=new Date(s,i,e),h=this.d._isSelected(n,this.d.cellType);return h?void a._handleAlreadySelectedDates.bind(a,h,n)():void a._trigger("clickCell",n)},_onClickCell:function(t){var i=e(t.target).closest(".datepicker--cell");i.hasClass("-disabled-")||this._handleClick.bind(this)(i)}}}(),function(){var t='<div class="datepicker--nav-action" data-action="prev">#{prevHtml}</div><div class="datepicker--nav-title">#{title}</div><div class="datepicker--nav-action" data-action="next">#{nextHtml}</div>',i='<div class="datepicker--buttons"></div>',s='<span class="datepicker--button" data-action="#{action}">#{label}</span>',a=e.fn.datepicker,n=a.Constructor;a.Navigation=function(t,e){this.d=t,this.opts=e,this.$buttonsContainer="",this.init()},a.Navigation.prototype={init:function(){this._buildBaseHtml(),this._bindEvents()},_bindEvents:function(){this.d.$nav.on("click",".datepicker--nav-action",e.proxy(this._onClickNavButton,this)),this.d.$nav.on("click",".datepicker--nav-title",e.proxy(this._onClickNavTitle,this)),this.d.$datepicker.on("click",".datepicker--button",e.proxy(this._onClickNavButton,this))},_buildBaseHtml:function(){this.opts.onlyTimepicker||this._render(),this._addButtonsIfNeed()},_addButtonsIfNeed:function(){this.opts.todayButton&&this._addButton("today"),this.opts.clearButton&&this._addButton("clear")},_render:function(){var i=this._getTitle(this.d.currentDate),s=n.template(t,e.extend({title:i},this.opts));this.d.$nav.html(s),"years"==this.d.view&&e(".datepicker--nav-title",this.d.$nav).addClass("-disabled-"),this.setNavStatus()},_getTitle:function(t){return this.d.formatDate(this.opts.navTitles[this.d.view],t)},_addButton:function(t){this.$buttonsContainer.length||this._addButtonsContainer();var i={action:t,label:this.d.loc[t]},a=n.template(s,i);e("[data-action="+t+"]",this.$buttonsContainer).length||this.$buttonsContainer.append(a)},_addButtonsContainer:function(){this.d.$datepicker.append(i),this.$buttonsContainer=e(".datepicker--buttons",this.d.$datepicker)},setNavStatus:function(){if((this.opts.minDate||this.opts.maxDate)&&this.opts.disableNavWhenOutOfRange){var t=this.d.parsedDate,e=t.month,i=t.year,s=t.date;switch(this.d.view){case"days":this.d._isInRange(new Date(i,e-1,1),"month")||this._disableNav("prev"),this.d._isInRange(new Date(i,e+1,1),"month")||this._disableNav("next");break;case"months":this.d._isInRange(new Date(i-1,e,s),"year")||this._disableNav("prev"),this.d._isInRange(new Date(i+1,e,s),"year")||this._disableNav("next");break;case"years":var a=n.getDecade(this.d.date);this.d._isInRange(new Date(a[0]-1,0,1),"year")||this._disableNav("prev"),this.d._isInRange(new Date(a[1]+1,0,1),"year")||this._disableNav("next")}}},_disableNav:function(t){e('[data-action="'+t+'"]',this.d.$nav).addClass("-disabled-")},_activateNav:function(t){e('[data-action="'+t+'"]',this.d.$nav).removeClass("-disabled-")},_onClickNavButton:function(t){var i=e(t.target).closest("[data-action]"),s=i.data("action");this.d[s]()},_onClickNavTitle:function(t){return e(t.target).hasClass("-disabled-")?void 0:"days"==this.d.view?this.d.view="months":void(this.d.view="years")}}}(),function(){var t='<div class="datepicker--time"><div class="datepicker--time-current">   <span class="datepicker--time-current-hours">#{hourVisible}</span>   <span class="datepicker--time-current-colon">:</span>   <span class="datepicker--time-current-minutes">#{minValue}</span></div><div class="datepicker--time-sliders">   <div class="datepicker--time-row">      <input type="range" name="hours" value="#{hourValue}" min="#{hourMin}" max="#{hourMax}" step="#{hourStep}"/>   </div>   <div class="datepicker--time-row">      <input type="range" name="minutes" value="#{minValue}" min="#{minMin}" max="#{minMax}" step="#{minStep}"/>   </div></div></div>',i=e.fn.datepicker,s=i.Constructor;i.Timepicker=function(t,e){this.d=t,this.opts=e,this.init()},i.Timepicker.prototype={init:function(){var t="input";this._setTime(this.d.date),this._buildHTML(),navigator.userAgent.match(/trident/gi)&&(t="change"),this.d.$el.on("selectDate",this._onSelectDate.bind(this)),this.$ranges.on(t,this._onChangeRange.bind(this)),this.$ranges.on("mouseup",this._onMouseUpRange.bind(this)),this.$ranges.on("mousemove focus ",this._onMouseEnterRange.bind(this)),this.$ranges.on("mouseout blur",this._onMouseOutRange.bind(this))},_setTime:function(t){var e=s.getParsedDate(t);this._handleDate(t),this.hours=e.hours<this.minHours?this.minHours:e.hours,this.minutes=e.minutes<this.minMinutes?this.minMinutes:e.minutes},_setMinTimeFromDate:function(t){this.minHours=t.getHours(),this.minMinutes=t.getMinutes(),this.d.lastSelectedDate&&this.d.lastSelectedDate.getHours()>t.getHours()&&(this.minMinutes=this.opts.minMinutes)},_setMaxTimeFromDate:function(t){
this.maxHours=t.getHours(),this.maxMinutes=t.getMinutes(),this.d.lastSelectedDate&&this.d.lastSelectedDate.getHours()<t.getHours()&&(this.maxMinutes=this.opts.maxMinutes)},_setDefaultMinMaxTime:function(){var t=23,e=59,i=this.opts;this.minHours=i.minHours<0||i.minHours>t?0:i.minHours,this.minMinutes=i.minMinutes<0||i.minMinutes>e?0:i.minMinutes,this.maxHours=i.maxHours<0||i.maxHours>t?t:i.maxHours,this.maxMinutes=i.maxMinutes<0||i.maxMinutes>e?e:i.maxMinutes},_validateHoursMinutes:function(t){this.hours<this.minHours?this.hours=this.minHours:this.hours>this.maxHours&&(this.hours=this.maxHours),this.minutes<this.minMinutes?this.minutes=this.minMinutes:this.minutes>this.maxMinutes&&(this.minutes=this.maxMinutes)},_buildHTML:function(){var i=s.getLeadingZeroNum,a={hourMin:this.minHours,hourMax:i(this.maxHours),hourStep:this.opts.hoursStep,hourValue:this.hours,hourVisible:i(this.displayHours),minMin:this.minMinutes,minMax:i(this.maxMinutes),minStep:this.opts.minutesStep,minValue:i(this.minutes)},n=s.template(t,a);this.$timepicker=e(n).appendTo(this.d.$datepicker),this.$ranges=e('[type="range"]',this.$timepicker),this.$hours=e('[name="hours"]',this.$timepicker),this.$minutes=e('[name="minutes"]',this.$timepicker),this.$hoursText=e(".datepicker--time-current-hours",this.$timepicker),this.$minutesText=e(".datepicker--time-current-minutes",this.$timepicker),this.d.ampm&&(this.$ampm=e('<span class="datepicker--time-current-ampm">').appendTo(e(".datepicker--time-current",this.$timepicker)).html(this.dayPeriod),this.$timepicker.addClass("-am-pm-"))},_updateCurrentTime:function(){var t=s.getLeadingZeroNum(this.displayHours),e=s.getLeadingZeroNum(this.minutes);this.$hoursText.html(t),this.$minutesText.html(e),this.d.ampm&&this.$ampm.html(this.dayPeriod)},_updateRanges:function(){this.$hours.attr({min:this.minHours,max:this.maxHours}).val(this.hours),this.$minutes.attr({min:this.minMinutes,max:this.maxMinutes}).val(this.minutes)},_handleDate:function(t){this._setDefaultMinMaxTime(),t&&(s.isSame(t,this.d.opts.minDate)?this._setMinTimeFromDate(this.d.opts.minDate):s.isSame(t,this.d.opts.maxDate)&&this._setMaxTimeFromDate(this.d.opts.maxDate)),this._validateHoursMinutes(t)},update:function(){this._updateRanges(),this._updateCurrentTime()},_getValidHoursFromDate:function(t,e){var i=t,a=t;t instanceof Date&&(i=s.getParsedDate(t),a=i.hours);var n=e||this.d.ampm,h="am";if(n)switch(!0){case 0==a:a=12;break;case 12==a:h="pm";break;case a>11:a-=12,h="pm"}return{hours:a,dayPeriod:h}},set hours(t){this._hours=t;var e=this._getValidHoursFromDate(t);this.displayHours=e.hours,this.dayPeriod=e.dayPeriod},get hours(){return this._hours},_onChangeRange:function(t){var i=e(t.target),s=i.attr("name");this.d.timepickerIsActive=!0,this[s]=i.val(),this._updateCurrentTime(),this.d._trigger("timeChange",[this.hours,this.minutes]),this._handleDate(this.d.lastSelectedDate),this.update()},_onSelectDate:function(t,e){this._handleDate(e),this.update()},_onMouseEnterRange:function(t){var i=e(t.target).attr("name");e(".datepicker--time-current-"+i,this.$timepicker).addClass("-focus-")},_onMouseOutRange:function(t){var i=e(t.target).attr("name");this.d.inFocus||e(".datepicker--time-current-"+i,this.$timepicker).removeClass("-focus-")},_onMouseUpRange:function(t){this.d.timepickerIsActive=!1}}}()}(window,jQuery);;
;(function ($) { $.fn.datepicker.language['pt'] = {
    days: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
    daysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
    daysMin: ['Do', 'Se', 'Te', 'Qa', 'Qi', 'Sx', 'Sa'],
    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    today: 'Hoje',
    clear: 'Limpar',
    dateFormat: 'dd/mm/yyyy',
    timeFormat: 'hh:ii',
    firstDay: 1
}; })(jQuery);;
var contadorGaleria = 0;
var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    AndroidFirefox: function () {
        var is_android = navigator.userAgent.toLowerCase().indexOf('android') > -1;
        var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
        if (is_android && is_firefox) {
            return true;
        }
        else {
            return false;
        }
    },
    AndroidWebkit: function () {
        var is_android = navigator.userAgent.toLowerCase().indexOf('android') > -1;
        var is_webkit = navigator.userAgent.toLowerCase().indexOf('applewebkit') > -1;
        if (is_android && is_webkit) {
            return true;
        }
        else {
            return false;
        }
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

(function () {
    jQuery(function () {
        $(".t-s1-head-edition").find("span").html(moment().format("dddd, D [de] MMMM [de] YYYY"));
        moment.locale('pt');
        Tickers();
        TextElements();
        TopsJson();
        InitContactsPage();
        jQuery(".js-btn-comms").click(function () {
            jQuery('html, body').stop().animate({ scrollTop: jQuery('.t-af-comments-1').offset().top - 60 }, 3000);
            return false;

        });
        AdBlock();
        Search();
        SubsNewsletter();
        Newspaper();
        DesportoEstatisticas();
        setTimeout(function () { ClosePubAreas();}, 1500);
        

        jQuery(".t-form-1 input").focus(function () {
            jQuery(".t-form-msg-1 h6 span").html("");
            jQuery(".js-f-nl-cardside-2").css("display", "none");
        });

        jQuery(".t-btn-4").click(function () {
            RegisterNewsletter();
        });

        jQuery(".t-btn-7").click(function () {
            RegisterNewsletterDetalhe();
        });

        if (location.href.indexOf("/interior/") > -1 && location.href.indexOf("/interior/preview-") == -1) {
            //Insights();
            leiki.getData("popular1", drawLeikiSiteSlider, jQuery(".leikiContents[leikiwsiteslider]"), false, 1);
            leiki.getData("popular1", drawLeikiSite, jQuery(".leikiContents[leikiwsite]"), false, 0);
            leiki.getData("popular3", drawLeikiw, jQuery(".leikiContents[leikiw]"), false);
            NewsletterCapping();
        }

        TrackViews();

        LinksPagesMultimedia();

        Meteo();

        //LoginSession();

        try { newsletterSubscribeInGrid.hookEvents(); } catch (e) { console.log('[newsletter failed]' + e); }

    });
})(jQuery);




var articleReplaceDetailHtml = function () {
    var targetArticle = $('[rel="detalhe-artigo"]');
    var isTruncated = targetArticle.attr('data-truncated');
    if (isTruncated == 'true' && dnSrv && dnSrv.replaceContentDetailHtml && targetArticle.length > 0)
        dnSrv.replaceContentDetailHtml(targetArticle).then(function () {
            targetArticle.attr('data-truncated', false);
            setTimeout(function () { if (TextElements) TextElements(); }, 600);
        });
}



function SetMeteoSummary(city) {
    jQuery(".t-mb-forecast-name").html("<span title='" + city + "'>" + city + "</span>");

    jQuery(".meteo-summary").attr("title", jQuery(".js-meteobar-box .t-mb-forecast-today .t-mb-forecast-sky").attr("title"));
    jQuery(".meteo-summary i").attr("class", jQuery(".js-meteobar-box .t-mb-forecast-today .t-mb-forecast-sky i").attr("class"));
    jQuery(".meteo-summary em").html(jQuery(".js-meteobar-box .t-mb-forecast-today .t-mb-forecast-temp-now span").text());

    if (jQuery(".t-msb-meteobar").length) {
        jQuery(".t-msb-meteobar .t-msb-meteobar-condition").attr("title", jQuery(".js-meteobar-box .t-mb-forecast-today .t-mb-forecast-sky").attr("title"));
        jQuery(".t-msb-meteobar .t-msb-meteobar-condition i").attr("class", jQuery(".js-meteobar-box .t-mb-forecast-today .t-mb-forecast-sky i").attr("class"));
        jQuery(".t-msb-meteobar .t-msb-meteobar-condition em").html(jQuery(".js-meteobar-box .t-mb-forecast-today .t-mb-forecast-temp-now span").text());

        jQuery(".t-msb-meteobar .t-msb-meteobar-location em").attr("title", city);
        jQuery(".t-msb-meteobar .t-msb-meteobar-location em").html(city);

        if (location.href.toLowerCase().indexOf("/meteo.html") >= 0) {
            jQuery(".t-sf6-sb aside.t-meteobar").html(jQuery("aside.js-meteobar-box").html());
            jQuery(".t-sf6-sb aside.t-meteobar .t-mb-forecast-field select")[0].value = city;
            jQuery(".t-sf6-sb aside.t-meteobar .t-ico-btn-close-1").hide();
        }
    }
}

function Meteo() {
    city = LoadCookie("MeteoCityCookie");
    if (!city) city = "Lisboa";
    var data = {
        op: "meteo",
        city: city,
        init: 1,
        url: location.href

    }

    jQuery.ajax({
        url: "/ajax/requests.aspx",
        async: true,
        dataType: 'html',
        data: data,
        type: 'post',
        success: function (data) {
            jQuery(".js-meteobar-box").html(data);
            jQuery(".t-mb-forecast-field select")[0].value = city;
            SetMeteoSummary(city);
            jQuery(".meteo-summary").show();

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
        }
    });
}


function TextElements() {
    //console.log('[fn: TextElements ...]');

    loadFaceBookApi();

    setTimeout(function () { PubInRead();}, 1000);

    if (jQuery("div[id*='tweet']").length > 0) {
        TwitterHashTag();
    }

    if (jQuery("div[instagramid]").length > 0) {
        Instagram();
    }

    if (jQuery("div[id*='artigotexto_']").length > 0) {
        ArtigosTexto();
    }

    if (jQuery('.chapters-report').length > 0 && jQuery(".chapters-report").is(":hidden")) {
        jQuery('.chapters-report').show();
    }
    
    if (jQuery("[data-name='fb-post-embed']").length > 0 && typeof FB !== 'undefined') {
        FB.XFBML.parse();
    }

    try { Galeria(); } catch (e) { console.log('[fn: TextElements - erro (Galeria)]'); }
    try { MultimediaPlayers(); } catch (e) { console.log('[fn: TextElements - erro (MultimediaPlayers)]'); }
    try { YoutubePlayer(); } catch (e) { console.log('[fn: TextElements - erro (YoutubePlayer)]'); }

    setTimeout(function () { faceBookCommentsRefresh(); }, 100);

    jQuery('img.lazy-hidden').lazyLoadXT();

    //console.log('[fn: TextElements - done!]');
}

function MultimediaPlayers() {
    var video_autoplay = false;
    var guardaValorAdTime = 0;
    var guardaValorVideoTime = 0;
    var textPub;

    jQuery("div[type_multimedia]").each(function (index, value) {
        var id = jQuery(value).attr("id");
        var type_multimedia = jQuery(value).attr("type_multimedia");


        if (type_multimedia == "video") {

            var file_android = jQuery(value).attr("file_android");
            var file = jQuery(value).attr("file");
            var image = jQuery(value).attr("image");
            var width = jQuery(value).attr("width");
            var height = jQuery(value).attr("height");
            var aspectratio = jQuery(value).attr("aspectratio");
            var allowfullscreen = jQuery(value).attr("allowfullscreen");
            var video_type = jQuery(value).attr("video_type");
            var autostart = jQuery(value).attr("autostart");
            var vptags = jQuery(value).attr("vptags");
            var linkshare = jQuery(value).attr("linkshare");
            var fileid = jQuery(value).attr("fileid");
            var section = jQuery(value).attr("section");
            var path = jQuery(value).attr("path");
            var d = new Date();
            var timestamp = d.getTime();
            var url = location.protocol + "//" + location.host + location.pathname;
            var description_url = jsEncodeURI(url);

            if ((autostart == "true") || (location.href.indexOf("autoplay=true") > -1)) { video_autoplay = true; }

            if (location.href.indexOf("tag=proximoVideo") > -1) {
                ga('send', 'event', 'JW Player Video', 'Proximo', file_android);
            }

            var agent = navigator.userAgent.toLowerCase();
            var is_iphone = (agent.indexOf('iphone') != -1);
            var is_ipad = (agent.indexOf('ipad') != -1);
            var is_playstation = (agent.indexOf('playstation') != -1);
            var is_safari = (agent.indexOf('safari') != -1);
            var is_iemobile = (agent.indexOf('iemobile') != -1);
            var is_blackberry = (agent.indexOf('blackberry') != -1);
            var is_android = (agent.indexOf('android') != -1);
            var is_webos = (agent.indexOf('webos') != -1);

            if (isMobile.any()) {
                textPub = '';
            } else {
                textPub = 'PUB: O vídeo começa dentro de xx segundos';
            }

            jwplayer(id).setup({
                autostart: video_autoplay,
                image: image,
                height: height,
                aspectratio: aspectratio,
                allowfullscreen: allowfullscreen,
                width: width,
                playlist: [{
                    image: image,
                    sources: [{
                        file: file
                    }, {
                        file: file_android
                    }]
                }],
                hlshtml: true,
                ga: {},
                skin: {
                    name: "bekle"
                },
                sharing: {
                    heading: "Partilhar",
                    link: linkshare
                },
                related: {
                    file: "/ajax/requests.aspx?op=get-videos-rss&path=" + path + "&id=" + fileid,
                    onclick: "link"
                },
                localization: { related: "Vídeos Sugeridos" },
                advertising: {
                    client: "googima",
                    admessage: textPub,
                    locale: "PT-PT",
                    schedule: { "myAds": { "offset": "pre", "tag": "https://pubads.g.doubleclick.net/gampad/ads?sz=480x361|480x70|480x360|640x481|640x480&iu=/5268/dn.pt" + section + "&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=" + url + "&description_url=" + description_url + "&correlator=" + timestamp + "&cust_params=tag%3D" + escape(vptags) + "" } }
                },
                events: {
                    onComplete: function () {
                        var duration = jQuery('.jw-group.jw-controlbar-right-group.jw-reset')[0];
                        var spanText = jQuery(duration).children('.jw-text.jw-reset.jw-text-duration');
                        var VideoDuration = (jQuery(spanText).text());

                        if ((location.href.indexOf("/videos/interior/") > -1 || location.href.indexOf("/galerias/videos/") > -1) && titleNext != null && VideoDuration > "03:00") {
                            jQuery("#" + id).prepend("<div id='container'><p class='proximoContainer'>Próximo vídeo</p><p id='titleContainer'>" + titleNext + "</p><p class='numberContainer'></p><p class='btnContainer'>Cancelar</p></div>");
                            timeNextJwplayer();
                            jQuery('.jw-icon-display').hide();
                        }
                    }
                }
            });

            //console.log("https://pubads.g.doubleclick.net/gampad/ads?sz=480x361|480x70|480x360|640x481|640x480&iu=/5268/dn.pt" + section + "&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=" + url + "&description_url=" + description_url + "&correlator=" + timestamp + "&cust_params=tag%3D" + escape(vptags) + "");
        }

        jwplayer(id).on('adImpression', function (event) {
            ga('send', 'event', 'JW Player Video', 'PreRoll', file_android);
        });

        jwplayer(id).on('adTime', function (event) {
            var tempoTotal = Math.round(event.duration)
            var tempoPub = tempoTotal - Math.round(event.position);

            if (guardaValorAdTime != tempoPub) {
                var pubVista75 = Math.round(tempoTotal / 4);
                var pubVista50 = Math.round(tempoTotal / 2);
                var pubVista25 = pubVista75 * 3;

                if (pubVista25 == tempoPub) {
                    ga('send', 'event', 'JW Player Video', 'PreRoll25', file_android);
                }
                else if (pubVista50 == tempoPub) {
                    ga('send', 'event', 'JW Player Video', 'PreRoll50', file_android);
                }
                else if (pubVista75 == tempoPub) {
                    ga('send', 'event', 'JW Player Video', 'PreRoll75', file_android);
                }
                guardaValorAdTime = tempoPub;
            }

        });

        jwplayer(id).on('time', function (event) {
            var tempoTotal = Math.round(event.duration)
            var tempoPub = Math.round(tempoTotal - event.position);

            if (guardaValorVideoTime != tempoPub) {
                var pubVista75 = Math.round(tempoTotal / 4);
                var pubVista50 = Math.round(tempoTotal / 2);
                var pubVista25 = pubVista75 * 3;

                if (pubVista25 == tempoPub) {
                    ga('send', 'event', 'JW Player Video', 'Video25', file_android);
                }
                else if (pubVista50 == tempoPub) {
                    ga('send', 'event', 'JW Player Video', 'Video50', file_android);
                }
                else if (pubVista75 == tempoPub) {
                    ga('send', 'event', 'JW Player Video', 'Video75', file_android);
                }
                guardaValorVideoTime = tempoPub;
            }

        });

    });
}

function TwitterHashTag() {
    jQuery("div[id*='tweet']").each(function (index, value) {
        var tweet = document.getElementById(jQuery(this).attr("id"));
        var id = tweet.getAttribute("tweetid");
        var loaded = jQuery(this).attr("loaded");

        if (loaded != "true") {
            try {
                twttr.widgets.createTweet(
                    id, tweet,
                    {
                        conversation: 'none',
                        cards: 'visible',
                        linkColor: '#cc0000',
                        theme: 'light',
                        align: 'center',
                        size: 'large'
                    }).then(function (el) {
                        jQuery(value).attr("loaded", "true");
                    });
            }
            catch (err) { }
        }
    });
}

function Instagram() {
    jQuery("div[instagramid]").each(function (index, value) {
        var instagram_texto = jQuery(this).attr("instagramid");
        var loaded = jQuery(this).attr("loaded");

        if (loaded != "true") {
            jQuery.ajax({
                url: 'https://api.instagram.com/oembed?url=' + instagram_texto,
                type: 'GET',
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data.html) {
                        jQuery(value).html(data.html);
                        jQuery(value).attr("loaded", "true");
                    }
                }, error: function () {
                    console.log('error');
                }
            });
        }
    });
}

function ArtigosTexto() {
    var artigo_id = "";
    var elemObj = "";

    jQuery("div[id*='artigotexto_']").each(function (index, value) {
        var artigotexto = document.getElementById(jQuery(this).attr("id"));
        var artigoID = artigotexto.getAttribute("ArtigoID");
        var id_artigo = artigotexto.getAttribute("contentID");
        var estilo = artigotexto.getAttribute("Style");
        var loaded = jQuery(this).attr("loaded");

        if (loaded == "true")
            return;

        artigo_id = artigoID;

        var data = {
            op: "ArtigosTexto",
            artigoid: artigo_id,
            style: estilo,
            url: location.href
        }

        jQuery.ajax({
            url: "/ajax/requests.aspx",
            async: true,
            dataType: 'html',
            data: data,
            type: 'post',
            success: function (data) {
                jQuery(value).html(data);

                if (data.indexOf("galleria_") > -1) {
                    if (jQuery(".galleria_" + jQuery(value).attr("ArtigoID")).length > 0) {
                        Galleria.loadTheme('/common/scripts/galleria/themes/azur/galleria.azur.min.js?v=1.0');
                        Galleria.run('.galleria_' + jQuery(value).attr("ArtigoID"), {
                            imageCrop: false,
                            _showCaption: true,
                            height: 0.5625,
                            _locale: {
                                play: "Ver slideshow",
                                pause: "Pausar slideshow",
                                next: "Seguinte",
                                prev: "Anterior",
                                show_captions: "Mostrar Legenda",
                                hide_captions: "Esconder Legenda",
                                enter_fullscreen: "Ver em fullscreen",
                                exit_fullscreen: "Sair de fullscreen",
                                showing_image: "Imagem %s de %s"
                            }
                        });
                    }
                }

                jQuery(value).attr("loaded", "true");
                jQuery('img.lazy-hidden').lazyLoadXT();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
            }
        });
    });
}

function Galeria() {
    var isiPad = (navigator.userAgent.match(/iPad/i) != null);
    var firstLoad = true;

    var getImages = function (from, to) {
        var data = [];
        for (var i = from; i <= to; i++) {
            if (i != myObjectGalleria.length) {
                if (myObjectGalleria[i].title.length !== 0 || myObjectGalleria[i].description.length !== 0) {
                    data.push({
                        image: myObjectGalleria[i].image,
                        thumb: myObjectGalleria[i].thumb,
                        title: myObjectGalleria[i].title,
                        description: myObjectGalleria[i].description
                    });
                } else {
                    data.push({
                        image: myObjectGalleria[i].image,
                        thumb: myObjectGalleria[i].thumb
                    });

                }

            }
        }
        return data;
    }
    if ((!isMobile.any() && jQuery("div[class*='galleria_desktop']").length > 0) || (isiPad && jQuery("div[class*='galleria_desktop']").length > 0)) {
        Galleria.loadTheme('/common/scripts/galleria/themes/azur/galleria.azur.min.js?v=1.0');

        jQuery("div[class*='galleria_desktop']").each(function (index, value) {
            var galeria_class = jQuery(value).attr("class");
            var loaded = jQuery(value).attr("loaded");

            if (loaded != "true") {
                Galleria.run("." + galeria_class, {
                    dataSource: getImages(0, Math.min(9, myObjectGalleria.length)),
                    imageCrop: false,
                    _showCaption: false,
                    height: 0.6044,
                    _locale: {
                        play: "Ver slideshow",
                        pause: "Pausar slideshow",
                        next: "Seguinte",
                        prev: "Anterior",
                        show_captions: "Mostrar Legenda",
                        hide_captions: "Esconder Legenda",
                        enter_fullscreen: "Ver em fullscreen",
                        exit_fullscreen: "Sair de fullscreen",
                        showing_image: "Imagem %s de %s"
                    },
                    extend: function (options) {
                        this.bind('image', function (e) {
                            if (!firstLoad && !this._playing) {
                                if (contadorGaleria == 3) {
                                    //Refresh_Mrec();
                                    contadorGaleria = 0;
                                } else {
                                    contadorGaleria++;
                                }
                                Refresh_Pageview_Gallery();
                            }
                            else {
                                jQuery("." + galeria_class).attr("loaded", "true");
                            }
                            firstLoad = false;
                        });
                    }
                });
            }
        });

        Galleria.ready(function () {
            var galleria = this;
            if (jQuery(".galleria").find('.galleria-total').is(":visible")) {
                jQuery(".galleria").find('.galleria-total').after('<span>' + myObjectGalleria.length + '</span>');
                jQuery(".galleria").find('.galleria-total').hide();
            }
            galleria.bind('loadstart', function (e) {
                var size = galleria.getDataLength();
                if ((e.index + 6) >= size && size < myObjectGalleria.length) {
                    galleria.push(getImages(size, Math.min(size + 4, myObjectGalleria.length)));
                }
            })
        });
    }

    if (jQuery("div[class*='galleria_mobile']").length > 0 && isMobile.any()) {
        Galleria.loadTheme('/common/scripts/galleria/themes/azur/galleria.azur.min.js?v=1.0');

        jQuery("div[class*='galleria_mobile']").each(function (index, value) {
            var galeria_class = jQuery(value).attr("class");
            var loaded = jQuery(value).attr("loaded");

            if (loaded != "true") {
                Galleria.run("." + galeria_class, {
                    dataSource: myObjectGalleria,
                    preload: 1,
                    imageCrop: false,
                    _showCaption: false,
                    height: 0.5625,
                    _locale: {
                        play: "Ver slideshow",
                        pause: "Pausar slideshow",
                        next: "Seguinte",
                        prev: "Anterior",
                        show_captions: "Mostrar Legenda",
                        hide_captions: "Esconder Legenda",
                        enter_fullscreen: "Ver em fullscreen",
                        exit_fullscreen: "Sair de fullscreen",
                        showing_image: "Imagem %s de %s"
                    },
                    extend: function (options) {
                        this.bind('image', function (e) {
                            if (!firstLoad && !this._playing) {
                                if (contadorGaleria == 3) {
                                    //Refresh_Mrec();
                                    contadorGaleria = 0;
                                } else {
                                    contadorGaleria++;
                                }
                                Refresh_Pageview_Gallery();
                            }
                            else {
                                jQuery("." + galeria_class).attr("loaded", "true");
                            }
                            firstLoad = false;
                        });
                    }
                });
            }
        });
    }

    if (jQuery("div[class*='galleria_shortcode_']").length > 0) {
        Galleria.loadTheme('/common/scripts/galleria/themes/azur/galleria.azur.min.js?v=1.0');

        jQuery("div[class*='galleria_shortcode_']").each(function (index, value) {
            var firstLoad = true;
            var galeria_class = jQuery(value).attr("class");
            var loaded = jQuery(value).attr("loaded");
            var galeria_value = jQuery(value).attr("value");

            if (loaded != "true") {
                Galleria.run("." + galeria_class, {
                    dataSource: window['myObjectGalleria' + galeria_value],
                    preload: 1,
                    imageCrop: false,
                    _showCaption: false,
                    height: 0.5625,
                    _locale: {
                        play: "Ver slideshow",
                        pause: "Pausar slideshow",
                        next: "Seguinte",
                        prev: "Anterior",
                        show_captions: "Mostrar Legenda",
                        hide_captions: "Esconder Legenda",
                        enter_fullscreen: "Ver em fullscreen",
                        exit_fullscreen: "Sair de fullscreen",
                        showing_image: "Imagem %s de %s"
                    },
                    extend: function (options) {
                        this.bind('image', function (e) {
                            if (!firstLoad && !this._playing && jQuery(".galleria").length == 0 && index == 0) {
                                if (contadorGaleria == 3) {
                                    //Refresh_Mrec();
                                    contadorGaleria = 0;
                                } else {
                                    contadorGaleria++;
                                }
                                Refresh_Pageview_Gallery();

                                xaxisRefresh();
                            }
                            else {
                                jQuery("." + galeria_class).attr("loaded", "true");
                            }

                            firstLoad = false;
                        });
                    }
                });
            }
        });

    }
}

function YoutubePlayer() {
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var myPlayerState;
    jQuery(function () {
        var yt_int, yt_players = {},
            initYT = function () {
                jQuery("div[youtube_player]").each(function () {
                    yt_players[this.id] = new YT.Player(this.id, {
                        height: '100%',
                        width: '100%',
                        videoId: this.id/*,
                        events: {
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange,
                        }*/
                    });

                });
            };
        jQuery.getScript("//www.youtube.com/player_api", function () {
            yt_int = setInterval(function () {
                if (typeof YT === "object") {
                    initYT();
                    clearInterval(yt_int);
                }
            }, 500);
        });

    });
}

function InitContactsPage() {

    jQuery("input#name").blur();
    jQuery("input#email").blur();
    jQuery("input#name").focus(function () {
        jQuery("#name").parent().removeClass("t-form-3-field-error");
        jQuery(".t-form-msg-4 p").html("").hide();
    });

    jQuery("input#email").focus(function () {
        jQuery("#email").parent().removeClass("t-form-3-field-error");
        jQuery(".t-form-msg-4 p").html("").hide();
    });

    jQuery("select").blur();
    jQuery("select").focus(function () {
        var _default = jQuery(this).attr("default");
        jQuery(".t-form-3-field-2").removeClass("t-form-3-field-error");
        jQuery(".t-form-msg-4 p").html("").hide();
        if (!_default) _default = "";
        if (this.value == _default) this.value = "";
    });

    jQuery("textarea").blur();
    jQuery("textarea").focus(function () {
        jQuery("#message").parent().removeClass("t-form-3-field-error");
        jQuery(".t-form-msg-4 p").html("").hide();
    });

    jQuery("input#name").blur(function () {
        jQuery("#name").parent().removeClass("t-form-3-field-error");
        jQuery(".t-form-msg-4 p").html("").hide();
    });

    jQuery("input#email").blur(function () {
        jQuery("#email").parent().removeClass("t-form-3-field-error");
        jQuery(".t-form-msg-4 p").html("").hide();
    });

    jQuery("textarea").blur(function () {
        jQuery("#message").parent().removeClass("t-form-3-field-error");
        jQuery(".t-form-msg-4 p").html("").hide();
    });

    jQuery(".t-btn-9.btn-contactos").click(function () {

        var subject = jQuery("#subject").val();
        var name = jQuery("#name").val();
        var email = jQuery("#email").val();
        var message = jQuery("#message").val();

        if (subject == "" || subject == "Seleccione o assunto") {
            jQuery(".t-form-3-field-2").addClass("t-form-3-field-error");
            jQuery(".t-form-msg-4 p").html("Por favor escolha um assunto").show();
            return;
        }

        if (name == "" || name == "Nome") {
            jQuery("#name").parent().addClass("t-form-3-field-error");
            jQuery(".t-form-msg-4 p").html("Por favor, introduza o seu nome").show();
            return;
        }

        if (email == "" || email == "E-mail") {
            jQuery("#email").parent().addClass("t-form-3-field-error");
            jQuery(".t-form-msg-4 p").html("Por favor, introduza o seu email").show();
            return;
        }

        if (jQuery("#email").length > 0 && validateEmail(email) == false) {
            jQuery("#email").parent().addClass("t-form-3-field-error");
            jQuery(".t-form-msg-4 p").html("O email inserido não é válido.").show();
            return false;
        }

        if (message == "" || message == "A sua mensagem") {
            jQuery("#message").parent().addClass("t-form-3-field-error");
            jQuery(".t-form-msg-4 p").html("Por favor, introduza a sua mensagem").show();
            return;
        }

        var data = {
            op: "SendContact",
            subject: subject,
            name: name,
            email: email,
            message: message
        }

        jQuery(".t-form-3").hide();
        jQuery(".image-contacts-load").show();

        jQuery.ajax({
            url: "/ajax/requests.aspx",
            async: true,
            dataType: 'html',
            data: data,
            type: 'post',
            success: function (data) {
                jQuery(".image-contacts-load").hide();
                jQuery(".t-form-msg-3").css("display", "block");
                jQuery(".t-form-msg-3 p").html("Obrigado. A sua mensagem foi enviada com sucesso.").show();

            },
            error: function (xhr, ajaxOptions, thrownError) {
            }
        });
    });


}

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function Refresh_Pageview() {
    pp_gemius_hit('.R.gwuL0G6ZNplWPZrrpO9VqrmGZm9sWflU1AjL7nQf.W7', pp_gemius_extraparameters[0]);
    //pp_gemius_event('.R.gwuL0G6ZNplWPZrrpO9VqrmGZm9sWflU1AjL7nQf.W7', pp_gemius_extraparameters[0]);
    dataLayer.push({ 'event': 'articlereadmore' });
}

function Refresh_Pageview_Gallery() {
    pp_gemius_hit('.R.gwuL0G6ZNplWPZrrpO9VqrmGZm9sWflU1AjL7nQf.W7', pp_gemius_extraparameters[0]);
    //pp_gemius_event('.R.gwuL0G6ZNplWPZrrpO9VqrmGZm9sWflU1AjL7nQf.W7', pp_gemius_extraparameters[0]);
    dataLayer.push({
        'gallery': 'Galerias',
        'event': 'galleryslide'
    });
}

function Refresh_Pageview_VerMais() {
    pp_gemius_hit('.R.gwuL0G6ZNplWPZrrpO9VqrmGZm9sWflU1AjL7nQf.W7', pp_gemius_extraparameters[0]);
    //dataLayer.push({ 'event': 'loadmorearticles' });
}

function Refresh_Mrec() {
    googletag.pubads().refresh([mrec1]);
}

function xaxisRefresh() {
    var time = (new Date()).getTime()

    jQuery('#xaxis1').attr('src', '//pt-gmtdmp.mookie1.com/t/v2/learn?tagid=V2_79652&src.rand=' + time + '&src.id=Globalmedia_DN');
    jQuery('#xaxis2').attr('src', '//eu-gmtdmp.gd1.mookie1.com/tagr/v1/activity?acid=23&inst=EU&tagid=32182&src.rand=' + time + '&trb.clientID=522&trb.activityID=32182');
}

function AdBlock() {
    if (location.href.indexOf("/pesquisa.html") == -1) {
        window.setTimeout(function () {
            if (LoadCookie("__adblocker") == "true") {
                jQuery('#mrec1').css("display", "");

                var html = "<div id='AdBloquer'>";
                html += "<a href='https://www.dn.pt/dnpremium.html?utm_source=sitedn&utm_medium=mrecdn&utm_campaign=adblockdn'><img id='img_adblocker' src='https://static.globalnoticias.pt/dn/common/images/mrec_ad_blocker_dn.jpg?v1.0' alt='DN'/></a>";
                html += "</div>";
                jQuery("#mrec1").append(html);

            }
            else {
                jQuery("#AdBloquer").remove();
            }
        }, 1000);
    }
}

function LoadCookie(cookieName) {
    var tA, tempArray = document.cookie.split(";");
    for (tA = 0; tA < tempArray.length; tA++)
        if (tempArray[tA].indexOf(cookieName) > -1) {
            var val = tempArray[tA].split("=")
            if (val && val.length > 1) return val[1];
        }
    return null;
}

function Search() {
    jQuery("button[name='button_search']").click(function () {
        var search = jQuery("input[name='search']").val();

        if (search != "") {
            window.location.href = "/pesquisa.html?q=" + search;
            event.preventDefault();
        }
    });

    jQuery("input[name='search']").keypress(function (event) {
        var keycode = event.keycode ? event.keycode : event.which;
        var search = jQuery("input[name='search']").val();

        if (keycode == "13" && search != "") {
            window.location.href = "/pesquisa.html?q=" + search;
            event.preventDefault();
        }
    });

    if (jQuery("button[name='button_search_error']").length > 0) {
        jQuery("button[name='button_search_error']").click(function () {
            var search = jQuery("input[name='search_error']").val();

            if (search != "") {
                window.location.href = "/pesquisa.html?q=" + search;
                event.preventDefault();
            }
        });

        jQuery("input[name='search_error']").keypress(function (event) {
            var keycode = event.keycode ? event.keycode : event.which;
            var search = jQuery("input[name='search_error']").val();

            if (keycode == "13" && search != "") {
                window.location.href = "/pesquisa.html?q=" + search;
                event.preventDefault();
            }
        });
    }
}

function SubsNewsletter() {

    var nl_diaria = "SIM";
    var nl_almoco = "SIM";
    //var nl_escolhas = "SIM";

    jQuery(".t-nl-list-item-toggle-i.nl-diaria").click(function () {
        jQuery(".t-form-msg-4 p").html("");
        var btn_nl_diaria = jQuery(".t-nl-list-item-toggle-i.nl-diaria")["0"].innerText;
        if (btn_nl_diaria !== "SIM" && nl_diaria == "SIM") {
            nl_diaria = "NÃO";
        }
        else {
            nl_diaria = "SIM";
        }
    });

    jQuery(".t-nl-list-item-toggle-i.nl-almoco").click(function () {
        jQuery(".t-form-msg-4 p").html("");
        var btn_nl_almoco = jQuery(".t-nl-list-item-toggle-i.nl-almoco")["0"].innerText;
        if (btn_nl_almoco !== "SIM" && nl_almoco == "SIM") {
            nl_almoco = "NÃO";
        }
        else {
            nl_almoco = "SIM";
        }
    });

    jQuery(".t-nl-list-item-toggle-i.nl-escolhas").click(function () {
        jQuery(".t-form-msg-4 p").html("");
        var btn_nl_escolhas = jQuery(".t-nl-list-item-toggle-i.nl-escolhas")["0"].innerText;
        if (btn_nl_escolhas !== "SIM" && nl_escolhas == "SIM") {
            nl_escolhas = "NÃO";
        }
        else {
            nl_escolhas = "SIM";
        }
    });

    jQuery(".t-btn-9.btn-newsletter").click(function () {
        //if ((nl_diaria == "SIM") && (nl_almoco == "SIM") && (nl_escolhas == "SIM")) {
        //    PageSubsNewsletter("todas");
        //}
        if ((nl_diaria == "SIM") && (nl_almoco == "SIM")) {
            PageSubsNewsletter("diaria|almoco");
        }
        //else if ((nl_diaria == "SIM") && (nl_escolhas == "SIM")) {
        //    PageSubsNewsletter("diaria|escolhas");
        //}
        //else if ((nl_almoco == "SIM") && (nl_escolhas == "SIM")) {
        //    PageSubsNewsletter("almoco|escolhas");
        //}
        else if (nl_diaria == "SIM") {
            PageSubsNewsletter("diaria");
        }
        else if (nl_almoco == "SIM") {
            PageSubsNewsletter("almoco");
        }
        //else if (nl_escolhas == "SIM") {
        //    PageSubsNewsletter("escolhas");
        //}
        else {
            jQuery(".t-form-msg-4 p").html("Por favor escolha a uma das newsletters. Obrigado");
        }

    });

}

function PageSubsNewsletter(tipo_newsletter) {
    var newsletter;
    var email = jQuery("#email_newsletter").val();

    jQuery("input#email_newsletter").blur();
    jQuery("input#email_newsletter").focus(function () {
        jQuery("#email_newsletter").parent().removeClass("t-form-4-field-error");
        jQuery(".t-form-msg-4 p").html("").hide();
    });

    if (email != "") {
        if (validateEmail(email)) {
            var data = {
                op: "PageSubsNewsletter",
                email: email,
                tipo: tipo_newsletter
            }

            jQuery(".t-form-4").hide();
            jQuery(".load_newsletter").show();


            jQuery.ajax({
                url: "/ajax/requests.aspx",
                async: true,
                dataType: 'html',
                data: data,
                type: 'post',
                success: function (data) {
                    var json = JSON.parse(data);

                    if (data.indexOf("addSubscriber") > -1) {
                        if (json.Egoi_Api.addSubscriber.status == "success") {
                            jQuery(".load_newsletter").hide();
                            jQuery(".t-form-msg-3").css("display", "block");
                            jQuery(".t-form-msg-3 p").html("Muito obrigado pelo seu registo.").show();
                        }
                        else {
                            jQuery(".t-form-msg-3").css("display", "block");
                            jQuery(".t-form-msg-3 p").html(json.Egoi_Api.addSubscriber.ERROR).show().css("color", "#d94646");
                            jQuery(".load_newsletter").hide();
                            jQuery(".t-form-4").show();
                        }
                    }
                    else {
                        if (json.Egoi_Api.editSubscriber.status == "success") {
                            jQuery(".load_newsletter").hide();
                            jQuery(".t-form-msg-3").css("display", "block");
                            jQuery(".t-form-msg-3 p").html("Obrigado pelo seu registo.").show();
                        }
                        else {
                            jQuery(".load_newsletter").hide();
                            jQuery(".t-form-message-1").css("display", "");
                            jQuery(".t-form-msg-3 p").html(json.Egoi_Api.editSubscriber.ERROR).show().css("color", "#d94646");
                            jQuery(".t-form-4").show();
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                }
            });
        }
        else {
            jQuery("#email_newsletter").parent().addClass("t-form-4-field-error");
            jQuery(".t-form-msg-4 p").html("O email inserido não é válido.").show();;
            return false;
        }
    }
    else {
        jQuery("#email_newsletter").parent().addClass("t-form-4-field-error");
        jQuery(".t-form-msg-4 p").html("Por favor insira o email.").show();;
        return false;
    }
}

function Newspaper() {
    var type = "homepage";

    if ($("body").hasClass("t-body-home")) {
        type = "homepage";
    }
    else if ($("body").hasClass("t-body-section-edd")) {
        type = "section";
    }
    else if ($("body").hasClass("t-body-article-edd")) {
        type = "detail";
    }

    if ($("body").hasClass("t-body-home")) {

        if ($("article[feature='Newspaper']").length > 0) {

            var elem = $("article[feature='Newspaper']").first();

            var payload = {
                op: "NewspaperEdition",
                type: "editions"
            };

            jQuery.ajax({
                url: "/ajax/requests.aspx",
                async: true,
                dataType: 'json',
                data: payload,
                type: 'post',
                success: function (data) {
                    if (data && data.length > 0) {

                        var EditionDateToday = "";


                        $(data).each(function (i, v) {

                            var edition_date = "";
                            var edition_number = "";
                            var edition_image = "";

                            $(v.Properties).each(function (ip, vp) {
                                if (vp.PropertyTypeName == "newspaper_edition_date") {
                                    edition_date = vp.Value;
                                }

                                if (vp.PropertyTypeName == "newspaper_edition_number") {
                                    edition_number = vp.Value;
                                }

                                if (vp.PropertyTypeName == "images" && vp.Value != "" && vp.Value != undefined) {
                                    var images = JSON.parse(vp.Value);

                                    $(images).each(function (image_i, image_v) {
                                        if (image_i == 0)
                                            edition_image = image_v.url;
                                    });
                                }
                            });

                            if (v.FullName == $(elem).attr("section")) {

                                $("img[type='cover']").attr("src", edition_image + "&w=408&h=608").attr("data-src", edition_image + "&w=408&h=608");
                                $("img[type='cover']").parents("a").attr("href", "/edicao-do-dia/" + edition_date + ".html");

                                if (edition_number != "" && edition_number != undefined) {
                                    $(".t-s1-head-edition").find("span").append(", Nº " + edition_number);
                                }

                                if (edition_date != "" && edition_date != undefined) {
                                    $(".t-s10-g1-stamp-day").find("span").html(moment(edition_date).format("dddd"));
                                }


                                if ($(".t-s10-head-today.ed-mobile").length > 0) {
                                    if (moment().diff(edition_date, "days") == 0)
                                        $(".t-s10-head-link-1").find("span").html("Hoje " + moment(edition_date).format("DD[.]MM"));
                                    else if (moment().diff(edition_date, "days") == 1)
                                        $(".t-s10-head-link-1").find("span").html("Ontem " + moment(edition_date).format("DD[.]MM"));
                                    else
                                        $(".t-s10-head-link-1").find("span").html(moment(edition_date).format("ddd DD[.]MM"));

                                    $("a.t-s10-head-link-1").attr("href", "/edicao-do-dia/" + edition_date + ".html");
                                } else {
                                    if (moment().diff(edition_date, "days") == 0)
                                        $(".t-s10-head-today").find("span").html("Hoje " + moment(edition_date).format("DD[.]MM"));
                                    else if (moment().diff(edition_date, "days") == 1)
                                        $(".t-s10-head-today").find("span").html("Ontem " + moment(edition_date).format("DD[.]MM"));
                                    else
                                        $(".t-s10-head-today").find("span").html(moment(edition_date).format("ddd DD[.]MM"));

                                    $(".t-s10-head-today").find("a").attr("href", "/edicao-do-dia/" + edition_date + ".html");
                                }

                                $(".t-s10-head-title").css("cursor", "pointer").on("click", function (ev) {
                                    location.href = "/edicao-do-dia.html";
                                });

                                EditionDateToday = edition_date;
                            }
                            else {
                                var date_v = "";
                                if (moment().diff(edition_date, "days") == 0)
                                    date_v = "Hoje " + moment(edition_date).format("DD[.]MM");
                                else if (moment().diff(edition_date, "days") == 1)
                                    date_v = "Ontem " + moment(edition_date).format("DD[.]MM");
                                else
                                    date_v = moment(edition_date).format("ddd DD[.]MM");

                                if ($(".t-s10-head-today").find("select").length > 0) {
                                    $(".t-s10-head-today").find("select").append("<option value='" + edition_date + "'>" + date_v + "</option>");
                                }
                                else {
                                    var item = $("<div/>");
                                    item.addClass("item");
                                    item.attr("date", edition_date);
                                    item.css("display", "none");
                                    item.append($("<a/>").attr("href", "/edicao-do-dia/" + edition_date + ".html").append($("<span/>").html(date_v)));

                                    item.appendTo($(".t-s10-head-list"));
                                }
                            }
                        });

                        $(".t-s10-head-list .item").each(function (i, v) {
                            var dateItem = $(v).attr("date");
                            var diff = moment.duration(moment(EditionDateToday).diff(moment($(v).attr("date")))).asDays();

                            if (diff > -1 && i < 5) {
                                $(v).show();
                            }
                        });

                        //slidersInit();

                        if ($(".t-s10-head-today").find("select").length > 0) {
                            $(".t-s10-head-today").find("select").on("change", function (ev) {
                                location.href = "/edicao-do-dia/" + $(".t-s10-head-today").find("select").val() + ".html";
                            });
                        }
                    } else {
                        console.log("erro a ir buscar os paths");
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            });
        }
    }

    if ($("body").hasClass("t-body-section-edd") && $("section[path]").length > 0) {

        var paths = [];

        $("section[path]").each(function (i, v) {
            paths.push($(v).attr("path"));
        });

        var payload = {
            op: "NewspaperEdition",
            type: "section",
            data: JSON.stringify(paths)
        };

        jQuery.ajax({
            url: "/ajax/requests.aspx",
            async: true,
            dataType: 'json',
            data: payload,
            type: 'post',
            success: function (data) {
                //console.log(data);
                if (data && data.length > 0) {
                    $(data).each(function (i, v) {
                        var edition_date = "";
                        var edition_number = "";
                        var edition_image = "";

                        $(v.Properties).each(function (ip, vp) {
                            if (vp.PropertyTypeName == "newspaper_edition_date") {
                                edition_date = vp.Value;
                            }

                            if (vp.PropertyTypeName == "newspaper_edition_number") {
                                edition_number = vp.Value;
                            }

                            if (vp.PropertyTypeName == "images" && vp.Value != "" && vp.Value != undefined) {
                                var images = JSON.parse(vp.Value);

                                $(images).each(function (image_i, image_v) {
                                    if (images.length > 1) {
                                        if (image_i == 1)
                                            edition_image = image_v.url;
                                    }
                                    else {
                                        if (image_i == 0)
                                            edition_image = image_v.url;
                                    }
                                });
                            }
                        });

                        var elem = $("section[path='" + v.FullName + "']");

                        elem.find(".t-s13-col-1 img").attr("src", edition_image).attr("data-src", edition_image);
                        elem.find(".t-s13-col-1 a").attr("href", "#" + v.Id + "_big").attr("rel", "modal:open");
                        elem.find(".t-section-grid-head-4 h3 span").html(moment(edition_date).format("dddd"));

                        elem.find(".t-section-grid-head-4 h2 strong b").html(moment(edition_date).format("DD"));
                        elem.find(".t-section-grid-head-4 h2 strong span").html(v.Name.replace(moment(edition_date).format("DD"), ""));

                        if (edition_number != "" && edition_number != undefined) {
                            elem.find(".t-section-grid-head-4 h4 span").last().html(edition_number);
                        }
                        else
                            elem.find(".t-section-grid-head-4 h4").hide();

                        var imageModal = $("<div/>")
                            .attr("id", v.Id + "_big")
                            .css("display", "none")
                            .html("<img src='" + edition_image + "'/>")
                            .appendTo(elem);

                        var a_quiosque = $("<a/>");
                        a_quiosque.attr("href", "/quiosque/" + edition_date + ".html?target=conteudo_fechado");
                        a_quiosque.attr("class", "t-am-kicker");
                        a_quiosque.html("<h3 class='t-am-categ'><span class='link_quiosque'>Versão E-paper</span></h3>");
                        a_quiosque.appendTo(elem.find(".t-s13-col-1"));
                        var a_quiosquevm = $("<a/>");
                        a_quiosquevm.attr("href", "/quiosque/vm/" + edition_date + ".html?target=conteudo_fechado");
                        a_quiosquevm.attr("class", "t-am-kicker");
                        a_quiosquevm.html("<h3 class='t-am-categ'><span class='link_quiosque'>Versão E-paper Volta ao Mundo</span></h3>");
                        a_quiosquevm.appendTo(elem.find(".t-s13-col-1"));
                    });
                } else {
                    console.log("erro a ir buscar os paths");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    }

    if (type == "detail" && $("aside[path]").length > 0) {
        var payload = {
            op: "NewspaperEdition",
            type: "editions",
            page: 1,
            pageSize: 500
        };

        jQuery.ajax({
            url: "/ajax/requests.aspx",
            async: true,
            dataType: 'json',
            data: payload,
            type: 'post',
            success: function (data) {
                if (data && data.length > 0) {

                    $("aside[path]").data("editions", data);
                    $(data).each(function (i, v) {
                        if (v.FullName == $("aside[path]").attr("path")) {
                            var edition_date = "";
                            var edition_number = "";
                            var edition_image = "";

                            $(v.Properties).each(function (ip, vp) {
                                if (vp.PropertyTypeName == "newspaper_edition_date") {
                                    edition_date = vp.Value;
                                }

                                if (vp.PropertyTypeName == "newspaper_edition_number") {
                                    edition_number = vp.Value;
                                }

                                if (vp.PropertyTypeName == "images" && vp.Value != "" && vp.Value != undefined) {
                                    var images = JSON.parse(vp.Value);

                                    $(images).each(function (image_i, image_v) {
                                        if (images.length > 1) {
                                            if (image_i == 1)
                                                edition_image = image_v.url;
                                        }
                                        else {
                                            if (image_i == 0)
                                                edition_image = image_v.url;
                                        }
                                    });
                                }
                            });

                            $("<div/>")
                                .addClass("t-af-sb1-head")
                                .attr("edition_path", v.FullName)
                                .attr("position", i)
                                .append($("<h3/>").html("<span>" + v.Name + "</span>"))
                                .append($("<h4/>").html("<span>Nº</span><span>" + edition_number + "</span>"))
                                .appendTo($("aside[path]"));

                            var body = $("<div/>")
                                .addClass("t-af-sb1-body");
                            //.attr("edition_path", v.FullName)
                            //.attr("position", i);

                            var slider = $("<div/>")
                                .addClass("t-af-sb1-slider")
                                .append($("<div/>").addClass("item")
                                    .html("<figure class='t-af-sb1-pic'><img alt='' src='" + edition_image + "&w=300' data-src='" + edition_image + "&w=300' class='lazy-loaded'/></figure>")
                                );

                            if (data.length > 0) {

                                $("<div/>")
                                    .addClass("t-af-sb1-slider-nav")
                                    .append('<a href="javascript:;" class="t-af-sb1-slider-nav-prev"><span aria-label="Anterior">‹</span></a>')
                                    .append('<a href="javascript:;" class="t-af-sb1-slider-nav-next"><span aria-label="Próximo">›</span></a>')
                                    .appendTo(slider);
                            }

                            slider.appendTo(body);
                            body.appendTo($("aside[path]"));

                            NewspaperNews(v.FullName);

                            $(".t-af-sb1-slider-nav-prev").on("click", function () {
                                NewspaperNavigate("next");
                            });

                            $(".t-af-sb1-slider-nav-next").on("click", function () {
                                NewspaperNavigate("prev");
                            });
                        }
                    });
                } else {
                    console.log("erro a ir buscar os paths");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    }
}

function NewspaperNavigate(direction) {
    var data = $("aside[path]").data("editions");
    var currentPath = $("aside[path]").find(".t-af-sb1-head").attr("edition_path");
    var currentPosition = $("aside[path]").find(".t-af-sb1-head").attr("position");

    var drawPosition = 0;

    if (direction == "prev" && Number(currentPosition) > 0)
        drawPosition = Number(currentPosition) - 1;

    if (direction == "next" && Number(currentPosition) < data.length)
        drawPosition = Number(currentPosition) + 1;

    $(data).each(function (i, v) {
        if (i == drawPosition) {
            var edition_date = "";
            var edition_number = "";
            var edition_image = "";

            $(v.Properties).each(function (ip, vp) {
                if (vp.PropertyTypeName == "newspaper_edition_date") {
                    edition_date = vp.Value;
                }

                if (vp.PropertyTypeName == "newspaper_edition_number") {
                    edition_number = vp.Value;
                }

                if (vp.PropertyTypeName == "images" && vp.Value != "" && vp.Value != undefined) {
                    var images = JSON.parse(vp.Value);

                    $(images).each(function (image_i, image_v) {
                        if (image_i == 0)
                            edition_image = image_v.url;
                    });
                }
            });

            $("aside[path]").find(".t-af-sb1-head").attr("edition_path", v.FullName);
            $("aside[path]").find(".t-af-sb1-head").attr("position", drawPosition);
            $("aside[path]").find(".t-af-sb1-head").find("h3 span").html(v.Name);
            $("aside[path]").find(".t-af-sb1-head").find("h4 span").last().html(edition_number);
            $("aside[path]").find(".t-af-sb1-body").find("figure img").attr("src", edition_image + "&w=300").attr("data-src", edition_image + "&w=300");

            NewspaperNews(v.FullName);
        }
    });
}

function NewspaperNews(path) {
    if (path) {
        var payload = {
            op: "NewspaperNews",
            path: path
        };

        jQuery.ajax({
            url: "/ajax/requests.aspx",
            async: true,
            dataType: 'html',
            data: payload,
            type: 'post',
            success: function (data) {
                $("aside[path]").find(".item .t-article-list-6").remove();
                $("aside[path]").find(".item").append(data);

                $("aside[path]").find(".t-article-list-6").find("li").each(function (i, v) {
                    var a_link = $(v).find("a").attr("href");

                    if (location.href.indexOf(a_link) > -1) {
                        $(v).addClass("current");
                    }
                });

                contentShowMore();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    }
}

function RegisterNewsletter() {
    var email = jQuery(".t-form-1 input").val();

    if (email != "") {
        if (validateEmail(email)) {
            var data = {
                op: "PageSubsNewsletter",
                email: email,
                tipo: "diaria|almoco"
            }

            jQuery(".js-f-nl-cardside-1").hide();
            jQuery(".load_newsletter").show();

            jQuery.ajax({
                url: "/ajax/requests.aspx",
                async: true,
                dataType: 'html',
                data: data,
                type: 'post',
                success: function (data) {
                    var json = JSON.parse(data);

                    if (data.indexOf("addSubscriber") > -1) {
                        if (json.Egoi_Api.addSubscriber.status == "success") {
                            jQuery(".load_newsletter").hide();
                            jQuery(".js-f-nl-cardside-2").css("display", "");
                            jQuery(".t-form-msg-1 h6 span").html("Muito obrigado pelo seu registo.").show().css("color", "#8c8c8c");
                        }
                        else {
                            jQuery(".js-f-nl-cardside-2").css("display", "");
                            jQuery(".t-form-msg-1 h6 span").html(json.Egoi_Api.addSubscriber.ERROR).show().css("color", "#8c8c8c");
                            jQuery(".load_newsletter").hide();
                            jQuery(".js-f-nl-cardside-1").show();
                        }
                    }
                    else {
                        if (json.Egoi_Api.editSubscriber.status == "success") {
                            jQuery(".load_newsletter").hide();
                            jQuery(".js-f-nl-cardside-2").css("display", "");
                            jQuery(".t-form-msg-1 h6 span").html("Muito obrigado pelo seu registo.").show().css("color", "#8c8c8c");
                        }
                        else {
                            jQuery(".load_newsletter").hide();
                            jQuery(".js-f-nl-cardside-2").css("display", "");
                            jQuery(".t-form-msg-1 h6 span").html(json.Egoi_Api.editSubscriber.ERROR).show().css("color", "#d94646");
                            jQuery(".js-f-nl-cardside-1").show();
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                }
            });
        }
        else {
            jQuery(".js-f-nl-cardside-2").css("display", "");
            jQuery(".t-form-msg-1 h6 span").html("O email inserido não é válido.").css("color", "#d94646");
            return false;
        }
    }
    else {
        jQuery(".js-f-nl-cardside-2").css("display", "");
        jQuery(".t-form-msg-1 h6 span").html("Por favor insira o email.").css("color", "#d94646");
        return false;
    }
}

function RegisterNewsletterDetalhe() {
    var email = jQuery(".t-form-2 input").val();

    if (email != "") {
        if (validateEmail(email)) {
            var data = {
                op: "PageSubsNewsletter",
                email: email,
                tipo: "diaria|almoco"
            }

            jQuery(".js-content-nl-cardside-1").hide();
            jQuery(".load_newsletter").show();

            jQuery.ajax({
                url: "/ajax/requests.aspx",
                async: true,
                dataType: 'html',
                data: data,
                type: 'post',
                success: function (data) {
                    var json = JSON.parse(data);

                    if (data.indexOf("addSubscriber") > -1) {
                        if (json.Egoi_Api.addSubscriber.status == "success") {
                            jQuery(".load_newsletter").hide();
                            jQuery(".js-content-nl-cardside-2").css("display", "");
                            jQuery(".t-form-msg-2 h6 span").html("Muito obrigado pelo seu registo.").show().css("color", "#8c8c8c");
                        }
                        else {
                            jQuery(".js-f-nl-cardside-2").css("display", "");
                            jQuery(".t-form-msg-2 h6 span").html(json.Egoi_Api.addSubscriber.ERROR).show().css("color", "#8c8c8c");
                            jQuery(".load_newsletter").hide();
                            jQuery(".js-content-nl-cardside-1").show();
                        }
                    }
                    else {
                        if (json.Egoi_Api.editSubscriber.status == "success") {
                            jQuery(".load_newsletter").hide();
                            jQuery(".js-content-nl-cardside-2").css("display", "");
                            jQuery(".t-form-msg-2 h6 span").html("Muito obrigado pelo seu registo.").show().css("color", "#8c8c8c");
                        }
                        else {
                            jQuery(".load_newsletter").hide();
                            jQuery(".js-content-nl-cardside-2").css("display", "");
                            jQuery(".t-form-msg-2 h6 span").html(json.Egoi_Api.editSubscriber.ERROR).show().css("color", "#d94646");
                            jQuery(".js-content-nl-cardside-1").show();
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                }
            });
        }
        else {
            jQuery(".js-content-nl-cardside-2").css("display", "");
            jQuery(".t-form-msg-2 h6 span").html("O email inserido não é válido.").css("color", "#d94646");
            return false;
        }
    }
    else {
        jQuery(".js-content-nl-cardside-2").css("display", "");
        jQuery(".t-form-msg-2 h6 span").html("Por favor insira o email.").css("color", "#d94646");
        return false;
    }
}

function UnsubscribeNewsletter(email, tipo) {

    if (email != "") {

        var data = {
            op: "UnsubscribeNewsletter",
            email: email,
            tipo: tipo
        }

        jQuery.ajax({
            url: "/ajax/requests.aspx",
            async: true,
            dataType: 'html',
            data: data,
            type: 'post',
            success: function (data) {
                var json = JSON.parse(data);

                if (json.Egoi_Api.editSubscriber.status == "success") {

                    jQuery(".t-form-msg-3").css("display", "");
                    jQuery(".t-form-msg-3 p").html("Subscrição removida com sucesso.").show();
                    jQuery(".t-form-4").hide();

                }
                else {

                    jQuery(".t-form-msg-3").css("display", "");
                    jQuery(".t-form-msg-3 p").html(json.Egoi_Api.editSubscriber.ERROR).show().css("color", "red");

                }


            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
            }
        });



    }
    else {
        jQuery(".t-form-message-3").css("display", "");
        jQuery(".t-form-message-3 span").html("Ocorreu um erro. Por favor, tente mais tarde.").show().css("color", "red");

    }

}

function Insights(reader_type, access_level) {

    if (location.href.indexOf("/interior/") > -1 && location.href.indexOf("/interior/preview-") == -1) {

        var _maincontent;

        if (jQuery('*[class*="t-af1-"]').length > 0) {
            _maincontent = "h1.t-af1-head-title, div.t-af1-head-desc, div.t-af1-c1-body";
        } else {
            _maincontent = "h1.t-af2-head-title, div.t-af2-head-desc, div.t-af2-c1-body";
        }

        _ain = {
            id: "1812",
            postid: jQuery("meta[property='insights:contentID']").attr("content"),
            maincontent: _maincontent,
            pubdate: jQuery("meta[property='article:published_time']").attr("content"),
            authors: jQuery("meta[property='insights:authors']").attr("content"),
            sections: jQuery("meta[property='insights:sections']").attr("content").replace(/\//g, ">"),
            tags: jQuery("meta[property='insights:tags']").attr("content").replace(/'/g, ""),
            comments: "",
            reader_type: reader_type,
            access_level: access_level
        };

        //console.log(_ain);
        (function (d, s) {
            var sf = d.createElement(s);
            sf.type = 'text/javascript';
            sf.async = true;
            sf.src = (('https:' == d.location.protocol)
                ? 'https://d7d3cf2e81d293050033-3dfc0615b0fd7b49143049256703bfce.ssl.cf1.rackcdn.com'
                : 'http://t.contentinsights.com') + '/stf.js';
            var t = d.getElementsByTagName(s)[0];
            t.parentNode.insertBefore(sf, t);
        })(document, 'script');

    }
}

function TrackViews() {
    if (location.href.indexOf("/interior/") > -1) {
        try {
            Community.brand("DN");
            Community.track();
        }
        catch (err) { }
    }
}

function LinksPagesMultimedia() {
    if (jQuery(".t-body-section.t-body-section-multimedia .t-section-grid-path-1").length) {
        var path = window.location.href;
        jQuery('.t-section-grid-path-1 li a').each(function () {
            if (this.href === path) {
                jQuery(this).addClass('current');
                jQuery(this).removeAttr("href");
            }
        });
    }
}

var drawLeikiSiteSlider = function (data, element, test) {
    var grid = [
        ["DN", "DN", "DN", "DN"],
        ["DN", "DN", "DN", "DN"],
        ["DN", "DN", "DN", "DN"]
    ];

    //if (test)
    //    console.log(data);



    if (grid != null && data.length > 0) {
        var section = jQuery("<aside/>").addClass("t-sticky-article-related js-sticky-article-related");
        var body = jQuery("<div/>").addClass("t-sarelated-i");
        var div_group = jQuery("<div/>").addClass("t-sticky-article-slider owl-carousel owl-theme js-sticky-article-slider");

        jQuery(grid).each(function (i, v) {
            jQuery(v).each(function (item_i, value_i) {
                var brand = value_i;
                var processed = false;

                jQuery(data).each(function (leiki_i, leiki_v) {
                    if (leiki_v.processed != "true" && !processed) {

                        if (test)
                            console.log(leiki_v);

                        leiki_v.processed = "true";

                        if (typeof leiki_v.tags != "undefined") {
                            tags = leiki_v.tags.articleSection;
                        }
                        else {
                            tags = "";
                        }


                        var article = '<div class="item">' +
                            "<a href='" + leiki_v.actualUrl + "' onclick='window.leikiComLoader.Widget.onClick(this, \"" + leiki_v.url + "\");' class='t-saslider-item leiki_pop1_sticky'>" +
                            '<span class="t-saslider-pic">' +
                            '<img alt="" src="' + leiki_v.image + '"/>' +
                            '</span>' +
                            '<span class="t-saslider-text"><span>' + leiki_v.headline + '</span></span>' +
                            '</a>' +
                            '</div>';

                        jQuery(article).appendTo(div_group);
                        processed = true;

                        if (processed)
                            return true;
                    }
                });
            });
        });
        div_group.appendTo(body);
        body.appendTo(section);

        if (element != null && element != undefined) {
            section.appendTo(element);
        }
        slidersInit();
    }
}

var drawLeikiSite = function (data, element, test) {
    var grid = [
        ["DN", "DN", "DN", "DN"],
        ["DN", "DN", "DN", "DN"]
    ];

    //if (test)
    //    console.log(data2);

    if (grid != null && data.length > 0) {
        var id_class = "12";
        if (location.href.indexOf("/galerias/") > -1) id_class = "18";
        var section = jQuery("<section/>").addClass("t-section-" + id_class);
        var body = jQuery("<div/>").addClass("t-s" + id_class + "-i").html('<header class="t-section-grid-head-1"><h2><span class="t-sgh-1-title"><span>Mais notícias</span></span></h2></header>');
        var div_group = jQuery("<div/>").addClass("t-s" + id_class + "-body");
        var div_group_1 = jQuery("<div/>").addClass("t-s" + id_class + "-body-i");

        jQuery(grid).each(function (i, v) {
            jQuery(v).each(function (item_i, value_i) {
                var brand = value_i;
                var processed = false;

                jQuery(data).each(function (leiki_i, leiki_v) {
                    if (leiki_v.processed != "true" && !processed) {

                        if (test)
                            console.log(leiki_v);

                        leiki_v.processed = "true";

                        if (typeof leiki_v.tags != "undefined" || typeof leiki_v.tags != null) {
                            tags = leiki_v.tags.articleSection;
                        }
                        else {
                            tags = "";
                        }

                        var article = '<article class="t-s' + id_class + '-am1">' +
                            '<header class="t-am-head">' +
                            "<a href='" + leiki_v.actualUrl + "' onclick='window.leikiComLoader.Widget.onClick(this, \"" + leiki_v.url + "\");' class='t-am-pic leiki_pop1_after_article'>" +
                            '<figure><img alt="" src="https://static.globalnoticias.pt/dn/common/images/blank.gif" data-src="' + leiki_v.image + '" class="lazy-loaded"></figure>' +
                            '</a>' +
                            "<a href='" + leiki_v.actualUrl + "' onclick='window.leikiComLoader.Widget.onClick(this, \"" + leiki_v.url + "\");' class='t-am-kicker'>" +
                            '<h3 class="t-am-categ">' +
                            '<span>' + tags + '</span>' +
                            '</h3>' +
                            '</a>' +
                            "<a href='" + leiki_v.actualUrl + "' onclick='window.leikiComLoader.Widget.onClick(this, \"" + leiki_v.url + "\");' class='t-am-text leiki_pop1_after_article'>" +
                            '<h2 class="t-am-title">' +
                            '<span>' + leiki_v.headline + '</span>' +
                            '</h2>' +
                            '</a>' +
                            '</header>' +
                            '</article>';


                        jQuery(article).appendTo(div_group_1);
                        processed = true;

                        if (processed)
                            return true;
                    }
                });
            });


        });

        div_group_1.appendTo(div_group);
        div_group.appendTo(body);
        body.appendTo(section);

        if (element != null && element != undefined) {
            section.appendTo(element);
        }

        element.find("img").lazyLoadXT({ show: false });
    }
}

var drawLeikiw = function (data, element, test) {
    var grid;
    if (leiki.getGrid() != null && leiki.getGrid() != undefined) {
        grid = JSON.parse(leiki.getGrid());
    }

    if (test)
        console.log(data);

    if (grid != null && data.length > 0) {
        var id_class = "12";
        if (location.href.indexOf("/galerias/") > -1) id_class = "18";
        var section = jQuery("<section/>").addClass("t-section-" + id_class);
        var body = jQuery("<div/>").addClass("t-s" + id_class + "-i").html('<header class="t-section-grid-head-1"><h2><span class="t-sgh-1-title"><span>Outros conteúdos GM</span></span></h2></header>');
        var div_group = jQuery("<div/>").addClass("t-s" + id_class + "-body");
        var div_group_1 = jQuery("<div/>").addClass("t-s" + id_class + "-body-i");

        jQuery(grid).each(function (i, v) {
            jQuery(v).each(function (item_i, value_i) {
                var brand = value_i;
                var processed = false;

                jQuery(data).each(function (leiki_i, leiki_v) {
                    if (leiki_v.source == brand && (leiki_v.processed != "true") && !processed) {

                        if (test)
                            console.log(leiki_v);

                        leiki_v.processed = "true";

                        if (typeof leiki_v.tags != "undefined") {
                            tags = leiki_v.tags.articleSection;
                        }
                        else {
                            tags = "";
                        }

                        var article = '<article class="t-s' + id_class + '-am1">' +
                            '<header class="t-am-head">' +
                            "<a href='" + leiki_v.actualUrl + "' target='_blank' onclick='window.leikiComLoader.Widget.onClick(this, \"" + leiki_v.url + "\");' class='t-am-pic leiki_pop3_after_article'>" +
                            '<figure><img alt="" src="https://static.globalnoticias.pt/dn/common/images/blank.gif" data-src="' + leiki_v.image + '" class="lazy-loaded"></figure>' +
                            '</a>' +
                            "<a href='" + leiki_v.actualUrl + "' target='_blank' onclick='window.leikiComLoader.Widget.onClick(this, \"" + leiki_v.url + "\");' class='t-am-kicker'>" +
                            '<h3 class="t-am-categ">' +
                            '<span>' + tags + '</span>' +
                            '</h3>' +
                            '</a>' +
                            "<a href='" + leiki_v.actualUrl + "' target='_blank' onclick='window.leikiComLoader.Widget.onClick(this, \"" + leiki_v.url + "\");' class='t-am-text leiki_pop3_after_article'>" +
                            '<h2 class="t-am-title">' +
                            '<span>' + leiki_v.headline + '</span>' +
                            '</h2>' +
                            '</a>' +
                            '</header>' +
                            '</article>';


                        jQuery(article).appendTo(div_group_1);
                        processed = true;

                        if (processed)
                            return true;
                    }
                });
            });


        });

        div_group_1.appendTo(div_group);
        div_group.appendTo(body);
        body.appendTo(section);

        if (element != null && element != undefined) {
            section.appendTo(element);
        }

        element.find("img").lazyLoadXT({ show: false });
    }
}

function SaveCookie(cookieName, cookieVal, expireEndSection) {
    var expire = new Date();
    expire.setTime(expire.getTime() + (6000 * 24 * 3600000));
    expire = expire.toGMTString();

    if (expireEndSection != true) {
        var d = new Date();
        d.setTime(d.getTime() + (7 * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cookieName + "=" + cookieVal + ";" + expires + ";path=/";
    }
    else {
        document.cookie = cookieName + "=" + cookieVal + "; path=/" + (!expireEndSection ? "; expires=" + expire : "");
    }
}

function NewsletterCapping() {
    if (LoadCookie("NewsletterCapping") == null && (jQuery(".newslettercapping").length > 0)) {
        jQuery(".newslettercapping").show();
        SaveCookie("NewsletterCapping", 1, false);
    }
    else {
        if (LoadCookie("NewsletterCapping") < 3 && (jQuery(".newslettercapping").length > 0)) {
            jQuery(".newslettercapping").show();
            var newVal = parseInt(LoadCookie("NewsletterCapping")) + 1;
            SaveCookie("NewsletterCapping", newVal, false);
        }
        else {
            //esconde caixa
            if (jQuery(".newslettercapping").length > 0)
                jQuery(".newslettercapping").hide();
        }
    }
}

function DesportoEstatisticas() {

    if (jQuery(".t-sports-infotabs-1").length > 0) {
        jQuery("span[id='spanLigaPhase']").html(jQuery("#CurrentPhase ul").attr("name"));
        jQuery("span[id='spanLigaPhase']").attr('title', jQuery("#CurrentPhase ul").attr("name"));
        jQuery("span[id='spanLigaNextPhase']").html(jQuery("#NextPhase ul").attr("name"));
        jQuery("span[id='spanLigaCurrentPhase']").html(jQuery("#CurrentPhase ul").attr("name"));
    }
}

function comboStatsGrelha(type, obj, comboobj, results) {

    var data = {
        op: type,
        league: comboobj.options[comboobj.selectedIndex].value,
        next: results,
        url: location.href
    }

    jQuery(".t-sports-infotabs-1 .t-sports-it1-body-1").css("opacity", "0.2");
    jQuery(".t-sports-infotabs-1 .t-sports-it1-body-2").css("opacity", "0.2");
    jQuery(".load_estatisticas").show();

    jQuery.ajax({
        type: 'post',
        async: true,
        dataType: 'html',
        data: data,
        timeout: 5000,
        url: "/ajax/requests.aspx",
        success: function (data) {
            jQuery("#" + obj).html(data);
            jQuery("span[id='spanLigaNextName']").html(jQuery("#spanLigaName").text());
            jQuery("span[id='spanLigaCurrentName']").html(jQuery("#spanLigaName").text());
            jQuery("span[id='spanLigaPhase']").html(jQuery("#CurrentPhase ul").attr("name"));
            jQuery("span[id='spanLigaNextPhase']").html(jQuery("#NextPhase ul").attr("name"));
            jQuery("span[id='spanLigaCurrentPhase']").html(jQuery("#CurrentPhase ul").attr("name"));
            jQuery(".load_estatisticas").hide();
            jQuery(".t-sports-infotabs-1 .t-sports-it1-body-1").css("opacity", "1");
            jQuery(".t-sports-infotabs-1 .t-sports-it1-body-2").css("opacity", "1");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            jQuery(".load_estatisticas").hide();
        }
    });
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear(),
        hour = '' + d.getHours(),
        minute = '' + d.getMinutes(),
        second = '' + d.getSeconds();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    if (hour.length < 2) hour = '0' + hour;
    if (minute.length < 2) minute = '0' + minute;
    if (second.length < 2) second = '0' + second;

    return [year, month, day, hour, minute, second].join('');
}

function Tickers() {
    if (jQuery(".t-cticker-live").length > 0 && LoadCookie("TickerDireto") == null) {
        jQuery(".t-cticker-live").show();
    }
    if (jQuery(".t-cticker-jed").length > 0 && LoadCookie("JogosAoVivo") == null) {
        jQuery(".t-cticker-jed").show();
    }
    if (jQuery(".t-cticker-now").length > 0 && LoadCookie("UltimaHora") == null) {
        jQuery(".t-cticker-now").show();
    }
    appTickersInit();
}

function PubInRead() {
    if (jQuery(".js-pubinread").length > 0) {
        jQuery('.js-pubinread').each(function (i) {
            if (jQuery('.t-pubbox-ct-1-i', this).actual('outerHeight') <= 30) {
                jQuery(this).hide();
            }
        });
    }
}

function ClosePubAreas() {
    if (jQuery(".js-pub-billboard-1").length > 0) {
        jQuery('.js-pub-billboard-1').each(function (i) {
            if (jQuery('.t-pubbox-bb-1-i', this).actual('outerHeight') <= 30) {
                jQuery(this).hide();
            }
        });
    }
}

var LoginSession = function () {
    console.log("LoginSession");

    if (gy && gy.account.account) {
        var account = gy.account.account;

        var postData = {
            "op": "validateLoginSession",
            "uid": account.UID,
            "uidSignature": account.UIDSignature,
            "uidTimestamp": parseInt(account.signatureTimestamp),
            "loginToken": gigya.auth.loginToken.get()
        };

        $.post("/ajax/requests.aspx", postData, function (data) {
            console.log('%c' + data, 'background: #222; color: #bada55');
        });


        //console.log("login valido");
    }
    else {
        //console.log("login invalido");
    }
};

var newsletterSubscribeInGrid = function () {
    var modelsNewsletter;

    var btnSubscribeHandler = function (e) {
        e.preventDefault();
        validateNewsletterModel();
        if (modelsNewsletter == "" || modelsNewsletter == null) {
            jQuery('[data-name="register-newsletter-error"]').html("Por favor escolha a uma das newsletters. Obrigado").closest('div').show();
        }
        else {
            subscribeNewsletter(modelsNewsletter);
        }
    };

    var validateNewsletterModel = function () {
        var newsletterDiaria = jQuery("[data-name='nl-diaria']");
        var newsletterAlmoco = jQuery("[data-name='nl-almoco']");

        if (jQuery(newsletterDiaria).prop('checked') && jQuery(newsletterAlmoco).prop('checked')) {
            modelsNewsletter = "diaria|almoco";
        }
        else if (jQuery(newsletterDiaria).prop('checked')) {
            modelsNewsletter = "diaria";
        }
        else if (jQuery(newsletterAlmoco).prop('checked')) {
            modelsNewsletter = "almoco";
        }
        else {
            jQuery('[data-name="register-newsletter-error"]').html("Por favor escolha a uma das newsletters. Obrigado").closest('div').show();
        }
    };

    var subscribeNewsletter = function (tipo_newsletter) {
        var emailForm = jQuery('[data-key="subscribe-newsletter"]').closest('fieldset');
        var emailDiv = jQuery('[data-key="subscribe-newsletter"]').closest('div');
        var emailInput = emailDiv.find('input');
        var email = emailInput.val();

        if (email != "") {
            if (validateEmail(email)) {
                var data = {
                    op: "PageSubsNewsletter",
                    email: email,
                    tipo: tipo_newsletter
                }

                jQuery('[data-name="register-newsletter-error"]').html('').closest('div').hide();
                emailForm.hide();
                jQuery('[data-name="loader-nl"]').show();

                jQuery.ajax({
                    url: "/ajax/requests.aspx",
                    async: true,
                    dataType: 'html',
                    data: data,
                    type: 'post',
                    success: function (data) {
                        var json = JSON.parse(data);

                        if (data.indexOf("addSubscriber") > -1) {
                            if (json.Egoi_Api.addSubscriber.status == "success") {
                                jQuery('[data-name="loader-nl"]').hide();
                                jQuery('[data-name="register-newsletter-success"]').html("Muito obrigado pelo seu registo.").closest('div').show();
                            }
                            else {
                                jQuery('[data-name="loader-nl"]').hide();
                                jQuery('[data-name="register-newsletter-error"]').html(json.Egoi_Api.addSubscriber.ERROR).closest('div').show();
                                emailForm.show();
                            }
                        }
                        else {
                            if (json.Egoi_Api.editSubscriber.status == "success") {
                                jQuery('[data-name="loader-nl"]').hide();
                                jQuery('[data-name="register-newsletter-success"]').html("Muito obrigado pelo seu registo.").closest('div').show();
                            }
                            else {
                                jQuery('[data-name="loader-nl"]').hide();
                                jQuery('[data-name="register-newsletter-error"]').html(json.Egoi_Api.editSubscriber.ERROR).closest('div').show();
                                emailForm.show();
                            }
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                    }
                });
            }
            else {
                emailForm.addClass("t-form-field-error");
                jQuery('[data-name="register-newsletter-error"]').html("O email inserido não é válido.").closest('div').show();
                return false;
            }
        }
        else {
            emailForm.addClass("t-form-field-error");
            jQuery('[data-name="register-newsletter-error"]').html("Por favor insira o email.").closest('div').show();
            return false;
        }
    };

    var newsletterSelModel = function () {
        var newsletterSubs = jQuery(this);
        
        if (jQuery(newsletterSubs).prop('checked')) {
            modelsNewsletter = newsletterSubs.val();
            jQuery('[data-name="register-newsletter-error"]').html('').closest('div').hide();
        }
        else {
            modelsNewsletter = "";
         }
    };

    var hookEvents = function () {
        jQuery('[data-key="subscribe-newsletter"]').off();
        jQuery('[data-key="subscribe-newsletter"]').on('click', btnSubscribeHandler);

        jQuery('[data-type="model-nl"]').off();
        jQuery('[data-type="model-nl"]').on('click', newsletterSelModel);
    };
    return { hookEvents };
}();;
var _leikiw = _leikiw || [];
var leiki = function () {

    var _isLoaded = function () {
        var loaded = false;
        return {
            get: function () { return loaded; },
            set: function (value) { loaded = value; }
        };
    }();

    var _grid = function () {
        var grid = null;
        return {
            get: function () { return grid; },
            set: function (value) { grid = value; }
        };
    }();

    var _leikiwData = function () {
        var data = [];
        return {
            get: function () { return data; },
            //set: function (value) { data = value; },
            push: function (value) { data.push(value); }
        };
    }();

    var _init = function () {
        if (_grid.get() == null) {
            var srvUrl = "/ajax/requests.aspx";
            var payload = {
                op: "LeikiwGrid"
            };

            $.post(srvUrl, payload, function (data) {
                _grid.set(data);
            });
        }
    };

    var _getData = function (name, callback, element, test, tabPosition, fromElements) {
        _init();

        if (tabPosition == null || tabPosition == undefined)
            tabPosition = -1;

        if (fromElements == null || fromElements == undefined)
            fromElements = -1;

        if (name != "" && name != undefined) {

            var leiki_payload = {
                name: name,
                server: '//kiwi48.leiki.com/focus',
                isJson: true,
                jsonCallback: function (data) {
                    var ngData = [];
                    if (data && data.tabs.length > 1) {
                        $(data.tabs).each(function (i, v) {
                            if (tabPosition == -1) {
                                if (v.items.length > 0) {
                                    $(v.items).each(function (index_i, value_i) {
                                        ngData.push(value_i);
                                    });
                                }
                            }
                            else if (i == tabPosition) {
                                if (fromElements == -1) {
                                    if (v.items.length > 0) {
                                        $(v.items).each(function (index_i, value_i) {
                                            ngData.push(value_i);
                                        });
                                    }
                                }
                                else {
                                    var count = 0;
                                    if (v.items.length > 0) {
                                        $(v.items).each(function (index_i, value_i) {
                                            if (count > fromElements && count < v.items.length) {
                                                ngData.push(value_i);
                                            }
                                            count++;
                                        });
                                    }
                                }
                            }
                        });
                    }

                    if (test) {
                        console.log("Name:" + name);
                        console.log("Callback:" + callback.name);
                        console.log("Element:" + element);
                        console.log("TabPosition:" + tabPosition);
                        console.log("FromElements:" + fromElements);
                        console.log(ngData);
                    }

                    if (callback != null && callback != undefined) {
                        callback(ngData, element, test);
                    }
                },
                userid: (typeof gy.account != 'undefined' && gy.account.isLoggedIn()) ? gy.account.get('UID') : ''
            };

            if (test)
                leiki_payload.referer = "https://www.dn.pt/edicao-do-dia/12-ago-2018/interior/o-virus-informatico-que-paralisou-os-hospitais-cuf-9709054.html?target=conteudo_fechado";//location.href.replace("dn2018.dev", "dn").replace("qua2018.dn", "dn");

            _leikiw.push(leiki_payload);

            var t = new Date().getTime(); t -= t % (1000 * 60 * 60 * 24 * 30);
            var l = document.createElement('script'); l.type = 'text/javascript'; l.async = true;
            l.src = _leikiw_url + '?t=' + t;
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(l, s);
        }
    };

    return {
        getData: function (name, callback, element, test, tabPosition, fromElements) {
            _getData(name, callback, element, test, tabPosition, fromElements);
        },
        getGrid: function () {
            return _grid.get();
        }
    };
}();;
