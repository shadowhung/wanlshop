define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'college/good/index' + location.search,
                    add_url: 'college/good/add',
                    edit_url: 'college/good/edit',
                    del_url: 'college/good/del',
                    multi_url: 'college/good/multi',
                    table: 'college_good',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'cate1.name', title: __('Category_id')},
                        {field: 'cate2.name', title: __('Category2_id')},
                        {field: 'title', title: __('Title')},
                        {field: 'teacher', title: __('Teacher')},
                        {field: 'qiniu_cover_image', title: __('Cover_image'), events: Table.api.events.image, formatter: Table.api.formatter.image, operate: false},
                        {field: 'qiniu_video_file', title: __('Video_file'), formatter: Table.api.formatter.url, operate: false},
                        {field: 'duration', title: __('Duration'), operate: false},
                        {field: 'size', title: __('Size'), operate: false},
                        {field: 'link_url', title: __('Link_url'), formatter: Table.api.formatter.url, operate: false},
                        // {field: 'pay_type', title: __('Pay_type'), searchList: {"0": __('Pay_type 0'), "1": __('Pay_type 1')}, formatter: Table.api.formatter.normal},
                        // {field: 'price', title: __('Price'), operate: 'BETWEEN'},
                        {field: 'impressions', title: __('Impressions'), operate: false},
                        // {field: 'likes', title: __('Likes')},
                        // {field: 'comments', title: __('Comments')},
                        {field: 'createtime', title: __('Createtime'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"1": __('Status 1'), "0": __('Status 0')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            $("#c-category2_id").data("params", function () {
                return {custom: {type: 'college', 'pid': $('#c-category_id').val()}};
            });

            require(['upload'], function (Upload) {
                var _onUploadResponse = Upload.events.onUploadResponse;
                Upload.events.onUploadResponse = function (response) {
                    try {
                        var ret = typeof response === 'object' ? response : JSON.parse(response);
                        if (ret.hasOwnProperty("code") && ret.hasOwnProperty("data")) {
                            return _onUploadResponse.call(this, response);
                        } else if (ret.hasOwnProperty("key") && !ret.hasOwnProperty("err_code")) {
                            ret.code = 1;
                            ret.data = {
                                url: '/' + ret.key
                            };
                            return _onUploadResponse.call(this, JSON.stringify(ret));
                        }
                    } catch (e) {
                    }
                    return _onUploadResponse.call(this, response);

                };
            });

            $('#c-video_file').change(function () {
                var video = $('#c-video_file').val()
                if (video == '') {
                    return false;
                }

                Fast.api.ajax({
                    url: 'ajax/getVideoInformation',
                    data: {'video': video}
                }, function (data) {
                    $('#c-duration').val(data.duration)
                    $('#c-size').val(data.size)

                    $('#c-cover_image').val(data.cover_image)
                    var preview = '<li class="col-xs-3" id="preview">' +
                        '<a href="' + Config.upload.cdnurl + data.cover_image + '" ' +
                        'data-url="' + data.cover_image + '" target="_blank" class="thumbnail">' +
                        '<img src="' + Config.upload.cdnurl + data.cover_image + '" ' +
                        'onerror="this.src=\'/ruler.php/ajax/icon?suffix=jpg\';this.onerror=null;" class="img-responsive"></a></li>'
                    $('#p-cover_image').html(preview)
                });
                return false;
            });
            Controller.api.bindevent();
        },
        edit: function () {
            $("#c-category2_id").data("params", function () {
                return {custom: {type: 'college', 'pid': $('#c-category_id').val()}};
            });

            require(['upload'], function (Upload) {
                var _onUploadResponse = Upload.events.onUploadResponse;
                Upload.events.onUploadResponse = function (response) {
                    try {
                        var ret = typeof response === 'object' ? response : JSON.parse(response);
                        if (ret.hasOwnProperty("code") && ret.hasOwnProperty("data")) {
                            return _onUploadResponse.call(this, response);
                        } else if (ret.hasOwnProperty("key") && !ret.hasOwnProperty("err_code")) {
                            ret.code = 1;
                            ret.data = {
                                url: '/' + ret.key
                            };
                            return _onUploadResponse.call(this, JSON.stringify(ret));
                        }
                    } catch (e) {
                    }
                    return _onUploadResponse.call(this, response);
                };
            });

            var t = 0;

            $('#c-video_file').change(function () {
                if (t == 0) {
                    t++;
                    return false;
                }
                var video = $('#c-video_file').val()
                if (video == '') {
                    return false;
                }

                $('#p-cover_image').html('')

                Fast.api.ajax({
                    url: 'ajax/getVideoInformation',
                    data: {'video': video}
                }, function (data) {
                    $('#c-duration').val(data.duration)
                    $('#c-size').val(data.size)

                    $('#c-cover_image').val(data.cover_image)
                    var preview = '<li class="col-xs-3" id="preview">' +
                        '<a href="' + Config.upload.cdnurl + data.cover_image + '" ' +
                        'data-url="' + data.cover_image + '" target="_blank" class="thumbnail">' +
                        '<img src="' + Config.upload.cdnurl + data.cover_image + '" ' +
                        'onerror="this.src=\'/ruler.php/ajax/icon?suffix=jpg\';this.onerror=null;" class="img-responsive"></a></li>'
                    $('#p-cover_image').html(preview)
                });
                return false;
            });

            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});