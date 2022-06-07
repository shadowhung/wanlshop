define(['fast', 'template', 'moment'], function (Fast, Template, Moment) {
    var Frontend = {
        api: Fast.api,
        init: function () {
            var si = {};
            //發送驗證碼
            $(document).on("click", ".btn-captcha", function (e) {
                var type = $(this).data("type") ? $(this).data("type") : 'mobile';
                var btn = this;
                Frontend.api.sendcaptcha = function (btn, type, data, callback) {
                    $(btn).addClass("disabled", true).text("發送中...");

                    Frontend.api.ajax({url: $(btn).data("url"), data: data}, function (data, ret) {
                        clearInterval(si[type]);
                        var seconds = 60;
                        si[type] = setInterval(function () {
                            seconds--;
                            if (seconds <= 0) {
                                clearInterval(si);
                                $(btn).removeClass("disabled").text("發送驗證碼");
                            } else {
                                $(btn).addClass("disabled").text(seconds + "秒後可再次發送");
                            }
                        }, 1000);
                        if (typeof callback == 'function') {
                            callback.call(this, data, ret);
                        }
                    }, function () {
                        $(btn).removeClass("disabled").text('發送驗證碼');
                    });
                };
                if (['mobile', 'email'].indexOf(type) > -1) {
                    var element = $(this).data("input-id") ? $("#" + $(this).data("input-id")) : $("input[name='" + type + "']", $(this).closest("form"));
                    var text = type === 'email' ? '郵箱' : '手機號碼';
                    if (element.val() === "") {
                        Layer.msg(text + "不能為空！");
                        element.focus();
                        return false;
                    } else if (type === 'mobile' && !element.val().match(/^1[3-9]\d{9}$/)) {
                        Layer.msg("請輸入正確的" + text + "！");
                        element.focus();
                        return false;
                    } else if (type === 'email' && !element.val().match(/^[\w\+\-]+(\.[\w\+\-]+)*@[a-z\d\-]+(\.[a-z\d\-]+)*\.([a-z]{2,4})$/)) {
                        Layer.msg("請輸入正確的" + text + "！");
                        element.focus();
                        return false;
                    }
                    element.isValid(function (v) {
                        if (v) {
                            var data = {event: $(btn).data("event")};
                            data[type] = element.val();
                            Frontend.api.sendcaptcha(btn, type, data);
                        } else {
                            Layer.msg("請確認已經輸入了正確的" + text + "！");
                        }
                    });
                } else {
                    var data = {event: $(btn).data("event")};
                    Frontend.api.sendcaptcha(btn, type, data, function (data, ret) {
                        Layer.open({title: false, area: ["400px", "430px"], content: "<img src='" + data.image + "' width='400' height='400' /><div class='text-center panel-title'>掃壹掃關註公眾號獲取驗證碼</div>", type: 1});
                    });
                }
                return false;
            });
            //tooltip和popover
            if (!('ontouchstart' in document.documentElement)) {
                $('body').tooltip({selector: '[data-toggle="tooltip"]'});
            }
            $('body').popover({selector: '[data-toggle="popover"]'});

            // 手機端左右滑動切換菜單欄
            if ('ontouchstart' in document.documentElement) {
                var startX, startY, moveEndX, moveEndY, relativeX, relativeY, element;
                element = $('body', document);
                element.on("touchstart", function (e) {
                    startX = e.originalEvent.changedTouches[0].pageX;
                    startY = e.originalEvent.changedTouches[0].pageY;
                });
                element.on("touchend", function (e) {
                    moveEndX = e.originalEvent.changedTouches[0].pageX;
                    moveEndY = e.originalEvent.changedTouches[0].pageY;
                    relativeX = moveEndX - startX;
                    relativeY = moveEndY - startY;

                    // 判斷標準
                    //右滑
                    if (relativeX > 45) {
                        if ((Math.abs(relativeX) - Math.abs(relativeY)) > 50) {
                            element.addClass("sidebar-open");
                        }
                    }
                    //左滑
                    else if (relativeX < -45) {
                        if ((Math.abs(relativeX) - Math.abs(relativeY)) > 50) {
                            element.removeClass("sidebar-open");
                        }
                    }
                });
            }
            $(document).on("click", ".sidebar-toggle", function () {
                $("body").toggleClass("sidebar-open");
            });
        }
    };
    Frontend.api = $.extend(Fast.api, Frontend.api);
    //將Template渲染至全局,以便於在子框架中調用
    window.Template = Template;
    //將Moment渲染至全局,以便於在子框架中調用
    window.Moment = Moment;
    //將Frontend渲染至全局,以便於在子框架中調用
    window.Frontend = Frontend;

    Frontend.init();
    return Frontend;
});
