<?php
namespace Tengxunai\Service;

use Tengxunai\BaseClient;
use Tengxunai\Config\Config;
use Tengxunai\Exception\TengxunaiException;
use Tengxunai\Helper\Http;
use Tengxunai\Helper\Helper;

/**
 * 腾讯AI开放平台 - 语音合成 - 语音合成（AI Lab）
 * Class VoiceTts
 * @package Tengxunai\Service
 */
class VoiceTts extends BaseClient {
    /**
     * @var string 语音合成（AI Lab）
     * @describe
     */
    protected $baseVoiceTtsApi = 'fcgi-bin/aai/aai_tts';
    /**
     * @var int 语音发音人编码。1普通话男声，5静琪女声，6欢馨女声，7碧萱女声
     */
    protected $speaker = 1;
    /**
     * @var int 合成语音格式编码。1：PCM，2：WAV，3：MP3
     */
    protected $format = 2;
    /**
     * @var int 合成语音音量，取值范围[-10, 10]，如-10表示音量相对默认值小10dB，0表示默认音量，10表示音量相对默认值大10dB
     */
    protected $volume = 0;
    /**
     * @var int 合成语音语速，取值范围[50, 200]，默认100
     */
    protected $speed = 100;
    /**
     * @var string 待合成文本，最大300字节
     */
    protected $text = '';
    /**
     * @var int 合成语音降低/升高半音个数，取值范围[-24, 24]，即改变音高，默认0
     */
    protected $aht = 0;
    /**
     * @var int 控制频谱翘曲的程度，取值范围[0, 100]，改变说话人的音色，默认58
     */
    protected $apc = 58;


    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 语音合成（AI Lab）
     * @param string $text 待合成文本
     * @return bool|\Tengxunai\Response\VoiceSynth\VoiceTts
     *
     * @describe 将文字转换为语音，返回文字的语音数据。
     * @apiDoc https://ai.qq.com/doc/aaitts.shtml
     * @throws TengxunaiException
     */
    public function aaiTts($text='')
    {
        if (!empty($text)) {
            $this->text = $text;
        }
        if (empty($this->text)) {
            return false;
        }
        $params = [
            'speaker' => (int)$this->speaker,
            'format'  => (int)$this->format,
            'volume'  => (int)$this->volume,
            'speed'   => (int)$this->speed,
            'text'    => (string)$this->text,
            'aht'  => (int)$this->aht,
            'apc'  => (int)$this->apc
        ];
        //组装api参数
        $this->createParams($params);
        //开始请求
        $thisCurl = new Http();
        $thisCurl->url($this->baseUrl . $this->baseVoiceTtsApi);
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
        return new \Tengxunai\Response\VoiceSynth\VoiceTts($httpResult['data']);
    }


    /**
     * @param int $volume
     */
    public function volume($volume)
    {
        $this->volume = $volume;
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

    /**
     * @param int $speaker
     */
    public function speaker($speaker)
    {
        $this->speaker = $speaker;
    }

    /**
     * @param int $format
     */
    public function format($format)
    {
        $this->format = $format;
    }

    /**
     * @param int $aht
     */
    public function aht($aht)
    {
        $this->aht = $aht;
    }

    /**
     * @param int $apc
     */
    public function apc($apc)
    {
        $this->apc = $apc;
    }
}