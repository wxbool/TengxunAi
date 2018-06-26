<?php
namespace Tengxunai\Service;

use Tengxunai\BaseClient;
use Tengxunai\Config\Config;
use Tengxunai\Exception\TengxunaiException;
use Tengxunai\Helper\Http;
use Tengxunai\Helper\Helper;
use Tengxunai\Response\TextAnalysis\WordSeg;

/**
 * 腾讯AI开放平台 - 基本文本分析
 * Class TextAnalysis
 * @package Tengxunai\Service
 */
class TextAnalysis extends BaseClient {
    /**
     * @var string 分词Api
     * @describe
     */
    protected $baseWordSegApi = 'fcgi-bin/nlp/nlp_wordseg';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 分词
     * @param string $text
     * @return bool|WordSeg
     *
     * @describe 对文本进行智能分词识别，支持基础词与混排词粒度
     * @apiDoc https://ai.qq.com/doc/nlpbase.shtml
     * @throws \Tengxunai\Exception\TengxunaiException
     */
    public function wordSeg($text='')
    {
        if (empty($text)) {
            return false;
        }
        $params = ['text' => (string)$text];
        //转码
        $params = Helper::arrayIconv($params , 'utf-8' , 'gbk');
        //组装api参数
        $this->createParams($params);
        //开始请求
        $thisCurl = new Http();
        $thisCurl->url($this->baseUrl . $this->baseWordSegApi);
        $thisCurl->params($params);
        //请求
        $code = $thisCurl->request();
        if (!$code) {
            return false;
        }
        //结果转码
        $thisCurl->httpResultDecode();
        $httpResult = $thisCurl->getJsonDecodeData();
        if ($httpResult['ret'] != 0) {
            throw new TengxunaiException( $httpResult['msg'] );
        }
        //注入数据并返回
        return new WordSeg($httpResult['data']);
    }
}