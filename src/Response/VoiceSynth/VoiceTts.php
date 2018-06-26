<?php
namespace Tengxunai\Response\VoiceSynth;

use Tengxunai\BaseResponse;

class VoiceTts extends BaseResponse {

    public function __construct(array $result=[])
    {
        parent::__construct();

        //注入数据
        if (is_array($result)) $this->data = $result;
    }


    /**
     * 获取 API请求中的格式编码Id
     * @return int|null
     */
    public function format()
    {
        return $this->getData('format');
    }

    /**
     * 获取 合成语音的base64编码数据
     * @return string|null
     */
    public function speech()
    {
        return $this->getData('speech');
    }

    /**
     * 获取 合成语音的md5摘要（base64编码之前）
     * @return string|null
     */
    public function md5sum()
    {
        return $this->getData('md5sum');
    }


    /**
     * 获取合成的语音文件
     * @param string $fileName 文件名称
     * @return bool|int|string
     */
    public function getVoice($fileName='')
    {
        $speech = $this->getData('speech');
        $format = $this->getData('format');
        if (is_null($speech) || empty($fileName)) {
            return false;
        }
        //合成语音格式编码。1：PCM，2：WAV，3：MP3
        $prifx    = ['1'=>'pcm' , 2=>'wav' , 3=>'mp3'];
        $fileName = $fileName . '.' . $prifx[$format];
        $base64   = base64_decode($speech);
        $resCode  = file_put_contents($fileName , $base64);
        if ($resCode) {
            return $fileName;
        }
        return $resCode;
    }
}