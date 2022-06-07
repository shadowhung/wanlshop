<?php

namespace addons\alioss\controller;

use app\common\exception\UploadException;
use app\common\library\Upload;
use app\common\model\Attachment;
use OSS\Core\OssException;
use OSS\OssClient;
use think\addons\Controller;
use think\Config;

/**
 * 阿里OSS云储存
 *
 */
class Index extends Controller
{

    public function _initialize()
    {
        //跨域检测
        check_cors_request();

        parent::_initialize();
        Config::set('default_return_type', 'json');
    }

    public function index()
    {
        Config::set('default_return_type', 'html');
        $this->error("当前插件暂无前台页面");
    }

    /**
     * 获取签名
     */
    public function params()
    {
        $this->check();
        $name = $this->request->post('name');
        $md5 = $this->request->post('md5');
        $chunk = $this->request->post('chunk');

        $auth = new \addons\alioss\library\Auth();
        $params = $auth->params($name, $md5);
        $params['OSSAccessKeyId'] = $params['id'];
        $params['success_action_status'] = 200;
        $config = get_addon_config('alioss');

        if ($chunk) {
            $oss = new OssClient($config['accessKeyId'], $config['accessKeySecret'], $config['endpoint']);
            // 初始化
            $fileSize = $this->request->post('size');
            $chunkSize = $this->request->post('chunksize');
            $uploadId = $oss->initiateMultipartUpload($config['bucket'], $params['key']);
            $params['uploadId'] = $uploadId;
            $params['parts'] = $oss->generateMultiuploadParts($fileSize, $chunkSize);
            $params['partsAuthorization'] = [];
            $date = gmdate('D, d M Y H:i:s \G\M\T');
            foreach ($params['parts'] as $index => $part) {
                $partNumber = $index + 1;
                $signstr = "PUT\n\n\n{$date}\nx-oss-date:{$date}\n/{$config['bucket']}/{$params['key']}?partNumber={$partNumber}&uploadId={$uploadId}";
                $authorization = base64_encode(hash_hmac('sha1', $signstr, $config['accessKeySecret'], true));
                $params['partsAuthorization'][$index] = $authorization;
            }
            $params['date'] = $date;
        }

        $this->success('', null, $params);
        return;
    }

    /**
     * 服务器中转上传文件
     * 上传分片
     * 合并分片
     */
    public function upload()
    {
        $this->check();
        $config = get_addon_config('alioss');
        $oss = new OssClient($config['accessKeyId'], $config['accessKeySecret'], $config['endpoint']);

        $chunkid = $this->request->post("chunkid");
        if ($chunkid) {
            $action = $this->request->post("action");
            $chunkindex = $this->request->post("chunkindex/d");
            $chunkcount = $this->request->post("chunkcount/d");
            $filesize = $this->request->post("filesize");
            $filename = $this->request->post("filename");
            $method = $this->request->method(true);
            $key = $this->request->post("key");
            $uploadId = $this->request->post("uploadId");

            if ($action == 'merge') {
                //合并分片
                if ($config['uploadmode'] == 'server') {
                    $attachment = null;
                    //合并分片文件
                    try {
                        $upload = new Upload();
                        $attachment = $upload->merge($chunkid, $chunkcount, $filename);
                    } catch (UploadException $e) {
                        $this->error($e->getMessage());
                    }
                }

                $etags = $this->request->post("etags/a", []);
                if (count($etags) != $chunkcount) {
                    $this->error("分片数据错误");
                }
                $listParts = [];
                for ($i = 0; $i < $chunkcount; $i++) {
                    $listParts[] = array("PartNumber" => $i + 1, "ETag" => $etags[$i]);
                }
                try {
                    $ret = $oss->completeMultipartUpload($config['bucket'], $key, $uploadId, $listParts);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }

                $result = json_decode(json_encode(simplexml_load_string($ret['body'], "SimpleXMLElement", LIBXML_NOCDATA)), true);
                if (!isset($result['Key'])) {
                    $this->error("上传失败");
                } else {
                    $this->success("上传成功", '', ['url' => "/" . $key, 'fullurl' => cdnurl("/" . $key, true)]);
                }
            } else {
                //默认普通上传文件
                $file = $this->request->file('file');
                try {
                    $upload = new Upload($file);
                    $file = $upload->chunk($chunkid, $chunkindex, $chunkcount);
                } catch (UploadException $e) {
                    $this->error($e->getMessage());
                }
                try {
                    //上传分片到OSS
                    $ret = $oss->uploadPart($config['bucket'], $key, $uploadId, ['fileUpload' => $file->getRealPath(), 'partNumber' => $chunkindex + 1]);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }

                $this->success("上传成功", "", [], 3, ['ETag' => $ret]);
            }
        } else {
            $attachment = null;
            //默认普通上传文件
            $file = $this->request->file('file');
            try {
                $upload = new Upload($file);
                $attachment = $upload->upload();
            } catch (UploadException $e) {
                $this->error($e->getMessage());
            }

            //文件绝对路径
            $filePath = $upload->getFile()->getRealPath() ?: $upload->getFile()->getPathname();

            try {
                $ret = $oss->uploadFile($config['bucket'], ltrim($attachment->url, "/"), $filePath);
                //成功不做任何操作
            } catch (\Exception $e) {
                $attachment->delete();
                @unlink($filePath);
                $this->error("上传失败");
            }

            $this->success("上传成功", '', ['url' => $attachment->url, 'fullurl' => cdnurl($attachment->url, true)]);
        }
        return;
    }

    /**
     * 回调
     */
    public function notify()
    {
        $this->check();
        $size = $this->request->post('size');
        $name = $this->request->post('name');
        $md5 = $this->request->post('md5');
        $type = $this->request->post('type');
        $url = $this->request->post('url');
        $suffix = substr($name, stripos($name, '.') + 1);
        $attachment = Attachment::where('url', $url)->where('storage', 'alioss')->find();
        if (!$attachment) {
            $params = array(
                'admin_id'    => (int)session('admin.id'),
                'user_id'     => (int)cookie('uid'),
                'filesize'    => $size,
                'filename'    => $name,
                'imagewidth'  => 0,
                'imageheight' => 0,
                'imagetype'   => $suffix,
                'imageframes' => 0,
                'mimetype'    => $type,
                'url'         => $url,
                'uploadtime'  => time(),
                'storage'     => 'alioss',
                'sha1'        => $md5,
            );
            Attachment::create($params);
        }
        $this->success();
        return;
    }

    /**
     * 检查签名是否正确或过期
     */
    protected function check()
    {
        $aliosstoken = $this->request->post('aliosstoken', '', 'trim');
        if (!$aliosstoken) {
            $this->error("参数不正确");
        }
        $config = get_addon_config('alioss');
        list($accessKeyId, $sign, $data) = explode(':', $aliosstoken);
        if (!$accessKeyId || !$sign || !$data) {
            $this->error("参数不正确");
        }
        if ($accessKeyId !== $config['accessKeyId']) {
            $this->error("参数不正确");
        }
        if ($sign !== base64_encode(hash_hmac('sha1', base64_decode($data), $config['accessKeySecret'], true))) {
            $this->error("签名不正确");
        }
        $json = json_decode(base64_decode($data), true);
        if ($json['deadline'] < time()) {
            $this->error("请求已经超时");
        }
    }

}
