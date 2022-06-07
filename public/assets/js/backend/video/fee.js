define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'video/fee/index' + location.search,
                    add_url: 'video/fee/add',
                    edit_url: 'video/fee/edit',
                    del_url: 'video/fee/del',
                    multi_url: 'video/fee/multi',
                    dragsort_url: 'ajax/weigh',
                    table: 'video',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'sort',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'type', title: __('Type'), searchList: {"1":__('Type 1'),"2":__('Type 2')}, formatter: Table.api.formatter.normal},
                        {field: 'user.mobile', title: __('User_id')},
                        {field: 'title', title: __('Title')},
                        {field: 'qiniu_cover_image', title: __('Cover_image'), events: Table.api.events.image, formatter: Table.api.formatter.image, operate: false},
                        {field: 'qiniu_video_file', title: __('Video_file'),formatter:Table.api.formatter.url},
                        {field: 'duration', title: __('Duration')},
                        {field: 'size', title: __('Size'), operate:'BETWEEN'},
                        {field: 'second', title: __('Second')},
                        {field: 'total', title: __('Total')},
                        {field: 'remain', title: __('Remain')},
                        // {field: 'like', title: __('Like')},
                        // {field: 'follow', title: __('Follow')},
                        {field: 'play', title: __('Play')},
                        {field: 'sort', title: __('Sort')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        // {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"1":__('Status 1'),"0":__('Status 0'),'2':__('Status 2')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
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