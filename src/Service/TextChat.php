<?php
namespace Tengxunai\Service;

use Tengxunai\BaseClient;
use Tengxunai\Config\Config;
use Tengxunai\Exception\TengxunaiException;
use Tengxunai\Helper\Http;
use Tengxunai\Helper\Helper;

/**
 * 腾讯AI开放平台 - 智能闲聊
 * Class TextChat
 * @package Tengxunai\Service
 */
class TextChat extends BaseClient {
    /**
     * @var string 智能闲聊Api
     * @describe
     */
    protected $baseTextChatApi = 'fcgi-bin/nlp/nlp_textchat';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 智能闲聊
     * @param string $question 用户输入的聊天内容，非空且长度上限300字节
     * @param string $session 会话标识（应用内唯一），非空且长度上限32字节
     * @return bool|\Tengxunai\Response\TextChat\TextChat
     *
     * @describe 基础闲聊接口提供基于文本的基础聊天能力，可以让您的应用快速拥有具备上下文语义理解的机器聊天功能。
     * @apiDoc https://ai.qq.com/doc/nlpchat.shtml
     * @throws TengxunaiException
     */
    public function textChat($question='' , $session='10000')
    {
        if (empty($question)) {
            return false;
        }
        $params = [
            'session'  => (string)$session,
            'question' => (string)$question
        ];
        //组装api参数
        $this->createParams($params);
        //开始请求
        $thisCurl = new Http();
        $thisCurl->url($this->baseUrl . $this->baseTextChatApi);
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
        return new \Tengxunai\Response\TextChat\TextChat($httpResult['data']);
    }
}