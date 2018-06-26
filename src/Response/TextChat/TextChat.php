<?php
namespace Tengxunai\Response\TextChat;

use Tengxunai\BaseResponse;

class TextChat extends BaseResponse {

    public function __construct(array $result=[])
    {
        parent::__construct();

        //注入数据
        if (is_array($result)) $this->data = $result;
    }


    /**
     * 获取 会话标识（应用内唯一）
     * @return string|null
     */
    public function session()
    {
        return $this->getData('session');
    }


    /**
     * 获取 回答文本数据
     * @return array|null
     */
    public function answer()
    {
        return $this->getData('answer');
    }
}