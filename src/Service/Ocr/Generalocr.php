<?php
namespace Tengxunai\Service\Ocr;

use Tengxunai\BaseClient;
use Tengxunai\Config\Config;
use Tengxunai\Exception\TengxunaiException;
use Tengxunai\Helper\Http;
use Tengxunai\Helper\Helper;

/**
 * 腾讯AI开放平台 - 通用OCR识别
 * Class Generalocr
 * @package Tengxunai\Service\Ocr
 */
class Generalocr extends BaseClient {
    /**
     * @var string 通用OCRApi
     * @describe
     */
    protected $baseGeneralocrApi = 'fcgi-bin/ocr/ocr_generalocr';

    /**
     * @var 待识别的图片。原图大小上限1MB，支持JPG、PNG、BMP格式
     */
    protected $image;


    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 通用OCR识别
     * @param string $image 待识别的图片
     * @return bool|\Tengxunai\Response\Ocr\Generalocr
     *
     * @describe 根据用户上传的图像，返回识别出的字段信息。
     * @apiDoc https://ai.qq.com/doc/ocrgeneralocr.shtml
     * @throws TengxunaiException
     */
    public function generalocr($image='')
    {
        if (!empty($image)) {
            $this->image = $image;
        }
        if (empty($this->image)) {
            return false;
        }
        if (!is_file($this->image)) {
            throw new TengxunaiException('imageFile Non-existent !');
        }
        $imageBase64 = Helper::fileBase64Str($this->image);
        $params = [
            'image' => $imageBase64,
        ];
        //组装api参数
        $this->createParams($params);
        //开始请求
        $thisCurl = new Http();
        $thisCurl->url($this->baseUrl . $this->baseGeneralocrApi);
        $thisCurl->params($params);
        //Post
        $thisCurl->isPost(true);
        //请求
        $code = $thisCurl->request();
        if (!$code) {
            return false;
        }
        //结果转码
        $httpResult = $thisCurl->getJsonDecodeData();
        if ($httpResult['ret'] != 0) {
            throw new TengxunaiException( $httpResult['msg'] );
        }
        //注入数据并返回
        return new \Tengxunai\Response\Ocr\Generalocr($httpResult['data']);
    }


    /**
     * @param string 待识别的图片。原图大小上限1MB，支持JPG、PNG、BMP格式 $image
     */
    public function image($image)
    {
        $this->image = $image;
    }
}