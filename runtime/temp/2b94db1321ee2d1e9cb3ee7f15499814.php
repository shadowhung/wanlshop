<?php if (!defined('THINK_PATH')) exit(); /*a:0:{}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <title><?php echo $config['title']; ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- Plugin CSS -->
        <link href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://cdn.staticfile.org/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style type="text/css">
            body {
                padding-top: 70px; margin-bottom: 15px;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                font-family: "Roboto", "SF Pro SC", "SF Pro Display", "SF Pro Icons", "PingFang SC", BlinkMacSystemFont, -apple-system, "Segoe UI", "Microsoft Yahei", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif;
                font-weight: 400;
            }
            h2        { font-size: 1.6em; }
            hr        { margin-top: 10px; }
            .tab-pane { padding-top: 10px; }
            .mt0      { margin-top: 0px; }
            .footer   { font-size: 12px; color: #666; }
            .label    { display: inline-block; min-width: 65px; padding: 0.3em 0.6em 0.3em; }
            .string   { color: green; }
            .number   { color: darkorange; }
            .boolean  { color: blue; }
            .null     { color: magenta; }
            .key      { color: red; }
            .popover  { max-width: 400px; max-height: 400px; overflow-y: auto;}
            .list-group.panel > .list-group-item {
            }
            .list-group-item:last-child {
                border-radius:0;
            }
            h4.panel-title a {
                font-weight:normal;
                font-size:14px;
            }
            h4.panel-title a .text-muted {
                font-size:12px;
                font-weight:normal;
                font-family: 'Verdana';
            }
            #sidebar {
                width: 220px;
                position: fixed;
                margin-left: -240px;
                overflow-y:auto;
            }
            #sidebar > .list-group {
                margin-bottom:0;
            }
            #sidebar > .list-group > a{
                text-indent:0;
            }
            #sidebar .child {
                border:1px solid #ddd;
                border-bottom:none;
            }
            #sidebar .child > a {
                border:0;
            }
            #sidebar .list-group a.current {
                background:#f5f5f5;
            }
            @media (max-width: 1620px){
                #sidebar {
                    margin:0;
                }
                #accordion {
                    padding-left:235px;
                }
            }
            @media (max-width: 768px){
                #sidebar {
                    display: none;
                }
                #accordion {
                    padding-left:0px;
                }
            }
            .label-primary {
                background-color: #248aff;
            }

        </style>
    </head>
    <body>
        <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="./" target="_blank"><?php echo $config['title']; ?></a>
                </div>
                <div class="navbar-collapse collapse">
                    <form class="navbar-form navbar-right">
                        <div class="form-group">
                            Token:
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" data-toggle="tooltip" title="<?php echo $lang['Tokentips']; ?>" placeholder="token" id="token" />
                        </div>
                        <div class="form-group">
                            Apiurl:
                        </div>
                        <div class="form-group">
                            <input id="apiUrl" type="text" class="form-control input-sm" data-toggle="tooltip" title="<?php echo $lang['Apiurltips']; ?>" placeholder="https://api.mydomain.com" value="<?php echo $config['apiurl']; ?>" />
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" title="<?php echo $lang['Savetips']; ?>" id="save_data">
                                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container">
            <!-- menu -->
            <div id="sidebar">
                <div class="list-group panel">
                    <?php if(is_array($docslist) || $docslist instanceof \think\Collection || $docslist instanceof \think\Paginator): if( count($docslist)==0 ) : echo "" ;else: foreach($docslist as $key=>$docs): ?>
                    <a href="#<?php echo $key; ?>" class="list-group-item" data-toggle="collapse" data-parent="#sidebar"><?php echo $key; ?>  <i class="fa fa-caret-down"></i></a>
                    <div class="child collapse" id="<?php echo $key; ?>">
                        <?php if(is_array($docs) || $docs instanceof \think\Collection || $docs instanceof \think\Paginator): if( count($docs)==0 ) : echo "" ;else: foreach($docs as $key=>$api): ?>
                        <a href="javascript:;" data-id="<?php echo $api['id']; ?>" class="list-group-item"><?php echo $api['title']; ?></a>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="panel-group" id="accordion">
                <?php if(is_array($docslist) || $docslist instanceof \think\Collection || $docslist instanceof \think\Paginator): if( count($docslist)==0 ) : echo "" ;else: foreach($docslist as $key=>$docs): ?>
                <h2><?php echo $key; ?></h2>
                <hr>
                <?php if(is_array($docs) || $docs instanceof \think\Collection || $docs instanceof \think\Paginator): if( count($docs)==0 ) : echo "" ;else: foreach($docs as $key=>$api): ?>
                <div class="panel panel-default">
                    <div class="panel-heading" id="heading-<?php echo $api['id']; ?>">
                        <h4 class="panel-title">
                            <span class="label <?php echo $api['method_label']; ?>"><?php echo strtoupper($api['method']); ?></span>
                            <a data-toggle="collapse" data-parent="#accordion<?php echo $api['id']; ?>" href="#collapseOne<?php echo $api['id']; ?>"> <?php echo $api['title']; ?> <span class="text-muted"><?php echo $api['route']; ?></span></a>
                        </h4>
                    </div>
                    <div id="collapseOne<?php echo $api['id']; ?>" class="panel-collapse collapse">
                        <div class="panel-body">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" id="doctab<?php echo $api['id']; ?>">
                                <li class="active"><a href="#info<?php echo $api['id']; ?>" data-toggle="tab"><?php echo $lang['Info']; ?></a></li>
                                <li><a href="#sandbox<?php echo $api['id']; ?>" data-toggle="tab"><?php echo $lang['Sandbox']; ?></a></li>
                                <li><a href="#sample<?php echo $api['id']; ?>" data-toggle="tab"><?php echo $lang['Sampleoutput']; ?></a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div class="tab-pane active" id="info<?php echo $api['id']; ?>">
                                    <div class="well">
                                        <?php echo $api['summary']; ?>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><strong><?php echo $lang['Headers']; ?></strong></div>
                                        <div class="panel-body">
                                            <?php if($api['headerslist']): ?>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $lang['Name']; ?></th>
                                                        <th><?php echo $lang['Type']; ?></th>
                                                        <th><?php echo $lang['Required']; ?></th>
                                                        <th><?php echo $lang['Description']; ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(is_array($api['headerslist']) || $api['headerslist'] instanceof \think\Collection || $api['headerslist'] instanceof \think\Paginator): if( count($api['headerslist'])==0 ) : echo "" ;else: foreach($api['headerslist'] as $key=>$header): ?>
                                                    <tr>
                                                        <td><?php echo $header['name']; ?></td>
                                                        <td><?php echo $header['type']; ?></td>
                                                        <td><?php echo !empty($header['required'])?'是':'否'; ?></td>
                                                        <td><?php echo $header['description']; ?></td>
                                                    </tr>
                                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                                </tbody>
                                            </table>
                                            <?php else: ?>
                                            无
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><strong><?php echo $lang['Parameters']; ?></strong></div>
                                        <div class="panel-body">
                                            <?php if($api['paramslist']): ?>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $lang['Name']; ?></th>
                                                        <th><?php echo $lang['Type']; ?></th>
                                                        <th><?php echo $lang['Required']; ?></th>
                                                        <th><?php echo $lang['Description']; ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(is_array($api['paramslist']) || $api['paramslist'] instanceof \think\Collection || $api['paramslist'] instanceof \think\Paginator): if( count($api['paramslist'])==0 ) : echo "" ;else: foreach($api['paramslist'] as $key=>$param): ?>
                                                    <tr>
                                                        <td><?php echo $param['name']; ?></td>
                                                        <td><?php echo $param['type']; ?></td>
                                                        <td><?php echo $param['required']?'是':'否'; ?></td>
                                                        <td><?php echo $param['description']; ?></td>
                                                    </tr>
                                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                                </tbody>
                                            </table>
                                            <?php else: ?>
                                            无
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><strong><?php echo $lang['Body']; ?></strong></div>
                                        <div class="panel-body">
                                            <?php echo (isset($api['body']) && ($api['body'] !== '')?$api['body']:'无'); ?>
                                        </div>
                                    </div>
                                </div><!-- #info -->

                                <div class="tab-pane" id="sandbox<?php echo $api['id']; ?>">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if($api['headerslist']): ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><strong><?php echo $lang['Headers']; ?></strong></div>
                                                <div class="panel-body">
                                                    <div class="headers">
                                                        <?php if(is_array($api['headerslist']) || $api['headerslist'] instanceof \think\Collection || $api['headerslist'] instanceof \think\Paginator): if( count($api['headerslist'])==0 ) : echo "" ;else: foreach($api['headerslist'] as $key=>$param): ?>
                                                        <div class="form-group">
                                                            <label class="control-label" for="<?php echo $param['name']; ?>"><?php echo $param['name']; ?></label>
                                                            <input type="<?php echo $param['type']; ?>" class="form-control input-sm" id="<?php echo $param['name']; ?>" <?php if($param['required']): ?>required<?php endif; ?> placeholder="<?php echo $param['description']; ?> - Ex: <?php echo $param['sample']; ?>" name="<?php echo $param['name']; ?>">
                                                        </div>
                                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><strong><?php echo $lang['Parameters']; ?></strong></div>
                                                <div class="panel-body">
                                                    <form enctype="application/x-www-form-urlencoded" role="form" action="<?php echo $api['route']; ?>" method="<?php echo $api['method']; ?>" name="form<?php echo $api['id']; ?>" id="form<?php echo $api['id']; ?>">
                                                        <?php if($api['paramslist']): if(is_array($api['paramslist']) || $api['paramslist'] instanceof \think\Collection || $api['paramslist'] instanceof \think\Paginator): if( count($api['paramslist'])==0 ) : echo "" ;else: foreach($api['paramslist'] as $key=>$param): ?>
                                                        <div class="form-group">
                                                            <label class="control-label" for="<?php echo $param['name']; ?>"><?php echo $param['name']; ?></label>
                                                            <input type="<?php echo $param['type']; ?>" class="form-control input-sm" id="<?php echo $param['name']; ?>" <?php if($param['required']): ?>required<?php endif; ?> placeholder="<?php echo $param['description']; if($param['sample']): ?> - 例: <?php echo $param['sample']; endif; ?>" name="<?php echo $param['name']; ?>">
                                                        </div>
                                                        <?php endforeach; endif; else: echo "" ;endif; else: ?>
                                                        <div class="form-group">
                                                            无
                                                        </div>
                                                        <?php endif; ?>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-success send" rel="<?php echo $api['id']; ?>"><?php echo $lang['Send']; ?></button>
                                                            <button type="reset" class="btn btn-info" rel="<?php echo $api['id']; ?>"><?php echo $lang['Reset']; ?></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><strong><?php echo $lang['Response']; ?></strong></div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12" style="overflow-x:auto">
                                                            <pre id="response_headers<?php echo $api['id']; ?>"></pre>
                                                            <pre id="response<?php echo $api['id']; ?>"></pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><strong><?php echo $lang['ReturnParameters']; ?></strong></div>
                                                <div class="panel-body">
                                                    <?php if($api['returnparamslist']): ?>
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo $lang['Name']; ?></th>
                                                                <th><?php echo $lang['Type']; ?></th>
                                                                <th><?php echo $lang['Description']; ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(is_array($api['returnparamslist']) || $api['returnparamslist'] instanceof \think\Collection || $api['returnparamslist'] instanceof \think\Paginator): if( count($api['returnparamslist'])==0 ) : echo "" ;else: foreach($api['returnparamslist'] as $key=>$param): ?>
                                                            <tr>
                                                                <td><?php echo $param['name']; ?></td>
                                                                <td><?php echo $param['type']; ?></td>
                                                                <td><?php echo $param['description']; ?></td>
                                                            </tr>
                                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                                        </tbody>
                                                    </table>
                                                    <?php else: ?>
                                                    无
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- #sandbox -->

                                <div class="tab-pane" id="sample<?php echo $api['id']; ?>">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <pre id="sample_response<?php echo $api['id']; ?>"><?php echo (isset($api['return']) && ($api['return'] !== '')?$api['return']:'无'); ?></pre>
                                        </div>
                                    </div>
                                </div><!-- #sample -->

                            </div><!-- .tab-content -->
                        </div>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>

            <hr>

            <div class="row mt0 footer">
                <div class="col-md-6" align="left">
                    Generated on <?php echo date('Y-m-d H:i:s'); ?>
                </div>
                <div class="col-md-6" align="right">
                    <a href="./" target="_blank"><?php echo $config['sitename']; ?></a>
                </div>
            </div>

        </div> <!-- /container -->

        <!-- jQuery -->
        <script src="https://cdn.staticfile.org/jquery/2.1.4/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script type="text/javascript">
            function syntaxHighlight(json) {
                if (typeof json != 'string') {
                    json = JSON.stringify(json, undefined, 2);
                }
                json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                    var cls = 'number';
                    if (/^"/.test(match)) {
                        if (/:$/.test(match)) {
                            cls = 'key';
                        } else {
                            cls = 'string';
                        }
                    } else if (/true|false/.test(match)) {
                        cls = 'boolean';
                    } else if (/null/.test(match)) {
                        cls = 'null';
                    }
                    return '<span class="' + cls + '">' + match + '</span>';
                });
            }

            function prepareStr(str) {
                try {
                    return syntaxHighlight(JSON.stringify(JSON.parse(str.replace(/'/g, '"')), null, 2));
                } catch (e) {
                    return str;
                }
            }
            var storage = (function () {
                var uid = new Date;
                var storage;
                var result;
                try {
                    (storage = window.localStorage).setItem(uid, uid);
                    result = storage.getItem(uid) == uid;
                    storage.removeItem(uid);
                    return result && storage;
                } catch (exception) {
                }
            }());

            $.fn.serializeObject = function ()
            {
                var o = {};
                var a = this.serializeArray();
                $.each(a, function () {
                    if (!this.value) {
                        return;
                    }
                    if (o[this.name] !== undefined) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                });
                return o;
            };

            $(document).ready(function () {

                if (storage) {
                    storage.getItem('token') && $('#token').val(storage.getItem('token'));
                    storage.getItem('apiUrl') && $('#apiUrl').val(storage.getItem('apiUrl'));
                }

                $('[data-toggle="tooltip"]').tooltip({
                    placement: 'bottom'
                });

                $(window).on("resize", function(){
                    $("#sidebar").css("max-height", $(window).height()-80);
                });

                $(window).trigger("resize");

                $(document).on("click", "#sidebar .list-group > .list-group-item", function(){
                    $("#sidebar .list-group > .list-group-item").removeClass("current");
                    $(this).addClass("current");
                });
                $(document).on("click", "#sidebar .child a", function(){
                    var heading = $("#heading-"+$(this).data("id"));
                    if(!heading.next().hasClass("in")){
                        $("a", heading).trigger("click");
                    }
                    $("html,body").animate({scrollTop:heading.offset().top-70});
                });

                $('code[id^=response]').hide();

                $.each($('pre[id^=sample_response],pre[id^=sample_post_body]'), function () {
                    if ($(this).html() == 'NA') {
                        return;
                    }
                    var str = prepareStr($(this).html());
                    $(this).html(str);
                });

                $("[data-toggle=popover]").popover({placement: 'right'});

                $('[data-toggle=popover]').on('shown.bs.popover', function () {
                    var $sample = $(this).parent().find(".popover-content"),
                            str = $(this).data('content');
                    if (typeof str == "undefined" || str === "") {
                        return;
                    }
                    var str = prepareStr(str);
                    $sample.html('<pre>' + str + '</pre>');
                });

                $('body').on('click', '#save_data', function (e) {
                    if (storage) {
                        storage.setItem('token', $('#token').val());
                        storage.setItem('apiUrl', $('#apiUrl').val());
                    } else {
                        alert('Your browser does not support local storage');
                    }
                });

                $('body').on('click', '.send', function (e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    //added /g to get all the matched params instead of only first
                    var matchedParamsInRoute = $(form).attr('action').match(/[^{]+(?=\})/g);
                    var theId = $(this).attr('rel');
                    //keep a copy of action attribute in order to modify the copy
                    //instead of the initial attribute
                    var url = $(form).attr('action');
                    var method = $(form).prop('method').toLowerCase() || 'get';

                    var formData = new FormData();

                    $(form).find('input').each(function (i, input) {
                        if ($(input).attr('type').toLowerCase() == 'file') {
                            formData.append($(input).attr('name'), $(input)[0].files[0]);
                            method = 'post';
                        } else {
                            formData.append($(input).attr('name'), $(input).val())
                        }
                    });

                    var index, key, value;

                    if (matchedParamsInRoute) {
                        var params = {};
                        formData.forEach(function(value, key){
                            params[key] = value;
                        });
                        for (index = 0; index < matchedParamsInRoute.length; ++index) {
                            try {
                                key = matchedParamsInRoute[index];
                                value = params[key];
                                if (typeof value == "undefined")
                                    value = "";
                                url = url.replace("\{" + key + "\}", value);
                                formData.delete(key);
                            } catch (err) {
                                console.log(err);
                            }
                        }
                    }

                    var headers = {};

                    var token = $('#token').val();
                    if (token.length > 0) {
                        headers['token'] = token;
                    }

                    $("#sandbox" + theId + " .headers input[type=text]").each(function () {
                        val = $(this).val();
                        if (val.length > 0) {
                            headers[$(this).prop('name')] = val;
                        }
                    });

                    $.ajax({
                        url: $('#apiUrl').val() + url,
                        data: method == 'get' ? $(form).serialize() : formData,
                        type: method,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        headers: headers,
                        xhrFields: {
                            withCredentials: true
                        },
                        success: function (data, textStatus, xhr) {
                            if (typeof data === 'object') {
                                var str = JSON.stringify(data, null, 2);
                                $('#response' + theId).html(syntaxHighlight(str));
                            } else {
                                $('#response' + theId).html(data || '');
                            }
                            $('#response_headers' + theId).html('HTTP ' + xhr.status + ' ' + xhr.statusText + '<br/><br/>' + xhr.getAllResponseHeaders());
                            $('#response' + theId).show();
                        },
                        error: function (xhr, textStatus, error) {
                            try {
                                var str = JSON.stringify($.parseJSON(xhr.responseText), null, 2);
                            } catch (e) {
                                var str = xhr.responseText;
                            }
                            $('#response_headers' + theId).html('HTTP ' + xhr.status + ' ' + xhr.statusText + '<br/><br/>' + xhr.getAllResponseHeaders());
                            $('#response' + theId).html(syntaxHighlight(str));
                            $('#response' + theId).show();
                        }
                    });
                    return false;
                });
            });
        </script>
    </body>
</html>
