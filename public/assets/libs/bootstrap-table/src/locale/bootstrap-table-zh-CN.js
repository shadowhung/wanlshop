/**
 * Bootstrap Table Chinese translation
 * Author: Zhixin Wen<wenzhixin2010@gmail.com>
 */
(function ($) {
    'use strict';

    $.fn.bootstrapTable.locales['zh-CN'] = {
        formatLoadingMessage: function () {
            return 'データを読み込もうとしています。しばらくお待ちください……';
        },
        formatRecordsPerPage: function (pageNumber) {
            return '每頁顯示 ' + pageNumber + ' 條記錄';
        },
        formatShowingRows: function (pageFrom, pageTo, totalRows) {
            return '顯示第 ' + pageFrom + ' 到第 ' + pageTo + ' 條記錄，總共 ' + totalRows + ' 條記錄';
        },
        formatSearch: function () {
            return '搜索';
        },
        formatNoMatches: function () {
            return '該当する記録が見つかりません';
        },
        formatPaginationSwitch: function () {
            return '隱藏/顯示分頁';
        },
        formatRefresh: function () {
            return '刷新';
        },
        formatToggle: function () {
            return '切換';
        },
        formatColumns: function () {
            return '列';
        },
        formatExport: function () {
            return '導出數據';
        },
        formatClearFilters: function () {
            return '清空過濾';
        }
    };

    $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales['zh-CN']);

})(jQuery);
