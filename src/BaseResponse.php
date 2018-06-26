<?php
namespace Tengxunai;
use Tengxunai\Exception\TengxunaiException;

/**
 * 响应基类
 * Class BaseResponse
 * @package Tengxunai
 */
class BaseResponse {
    /**
     * @var array 注入数据
     */
    protected $data = [];

    /**
     * BaseResponse constructor.
     */
    public function __construct(){}


    /**
     * 获取值
     * @param $data
     * @return null
     */
    protected function getData($data)
    {
        return isset($this->data[$data]) ? $this->data[$data] : null;
    }
}