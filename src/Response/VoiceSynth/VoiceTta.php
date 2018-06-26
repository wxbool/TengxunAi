<?php
namespace Tengxunai\Response\VoiceSynth;

use Tengxunai\BaseResponse;

class VoiceTta extends BaseResponse {

    public function __construct(array $result=[])
    {
        parent::__construct();

        //注入数据
        if (is_array($result)) $this->data = $result;
    }


    /**
     * 获取 合成语音的base64编码数据
     * @return int|null
     */
    public function voice()
    {
        return $this->getData('voice');
    }


    /**
     * 获取合成的语音文件
     * @param string $fileName 文件名称
     * @return bool|int|string
     */
    public function getVoice($fileName='')
    {
        $voice = $this->getData('voice');
        if (is_null($voice) || empty($fileName)) {
            return false;
        }
        $prifx    = 'wav';
        $fileName = $fileName . '.' . $prifx;
        $base64   = base64_decode($voice);
        $resCode  = file_put_contents($fileName , $base64);
        if ($resCode) {
            return $fileName;
        }
        return $resCode;
    }
}