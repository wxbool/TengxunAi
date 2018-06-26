<?php
namespace Tengxunai\Response\TextAnalysis;

use Tengxunai\BaseResponse;

class WordSeg extends BaseResponse {

    public function __construct(array $result=[])
    {
        parent::__construct();

        //注入数据
        if (is_array($result)) $this->data = $result;
    }


    /**
     * 获取 分词原始Text
     * @return string|null
     */
    public function text()
    {
        return $this->getData('text');
    }

    /**
     * 获取 基础词粒度分词列表
     * @return array|null
     */
    public function baseTokens()
    {
        return $this->getData('base_tokens');
    }

    /**
     * 获取 混排词粒度分词列表
     * @return array|null
     */
    public function mixTokens()
    {
        return $this->getData('mix_tokens');
    }
}