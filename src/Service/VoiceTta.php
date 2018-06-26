<?php
namespace Tengxunai\Service;

use Tengxunai\BaseClient;
use Tengxunai\Config\Config;
use Tengxunai\Exception\TengxunaiException;
use Tengxunai\Helper\Http;
use Tengxunai\Helper\Helper;

/**
 * 腾讯AI开放平台 - 语音合成 - 语音合成（优图）
 * Class VoiceTta
 * @package Tengxunai\Service
 */
class VoiceTta extends BaseClient {
    /**
     * @var string 语音合成（优图）
     * @describe
     */
    protected $baseVoiceTtaApi = 'fcgi-bin/aai/aai_tta';
    /**
     * @var int 发音模型。0女生，1女生纯英文，2男生，6喜道公子
     */
    protected $modelType = 0;
    /**
     * @var int 合成语音语速，取值范围[-2,2]，默认0。-2：0.6倍速，-1：0.8倍速，0：正常速度，1：1.2倍速，2：1.5倍速
     */
    protected $speed = 0;
    /**
     * @var string 待合成文本，最大300字节
     */
    protected $text = '';


    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 语音合成（优图）
     * @param string $text 待合成文本
     * @return bool|\Tengxunai\Response\VoiceSynth\VoiceTta
     *
     * @describe 将文字转换为语音，返回文字的语音数据。
     * @apiDoc https://ai.qq.com/doc/aaitts.shtml
     * @throws TengxunaiException
     */
    public function aaiTta($text='')
    {
        if (!empty($text)) {
            $this->text = $text;
        }
        if (empty($this->text)) {
            return false;
        }
        $params = [
            'model_type' => (int)$this->modelType,
            'speed'   => (int)$this->speed,
            'text'    => (string)$this->text
        ];
        //组装api参数
        $this->createParams($params);
        //开始请求
        $thisCurl = new Http();
        $thisCurl->url($this->baseUrl . $this->baseVoiceTtaApi);
        $thisCurl->params($params);
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
        return new \Tengxunai\Response\VoiceSynth\VoiceTta($httpResult['data']);
    }


    /**
     * @param int $modelType
     */
    public function modelType($modelType)
    {
        $this->modelType = $modelType;
    }

    /**
     * @param string $text
     */
    public function text($text)
    {
        $this->text = $text;
    }

    /**
     * @param int $speed
     */
    public function speed($speed)
    {
        $this->speed = $speed;
    }
}