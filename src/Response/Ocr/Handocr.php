<?php
namespace Tengxunai\Response\Ocr;

use Tengxunai\BaseResponse;

class Handocr extends BaseResponse {

    public function __construct(array $result=[])
    {
        parent::__construct();

        //注入数据
        if (is_array($result)) $this->data = $result;
    }


    /**
     * 获取 识别出的所有字段信息
     * @return string|null
     */
    public function itemList()
    {
        return $this->getData('item_list');
    }


    /**
     * 获取 识别出的字符串数组
     * @return array|null
     */
    public function strArr()
    {
        $itemList = $this->getData('item_list');
        if (!$itemList || !is_array($itemList)) return null;

        $str = [];
        foreach ($itemList as $val) {
            $str[] = $val['itemstring'];
        }
        return $str;
    }


    /**
     * 获取 识别出的全部字符串，使用 $split 组合
     * @return string|null
     */
    public function allStr($split = "\n")
    {
        $itemList = $this->getData('item_list');
        if (!$itemList || !is_array($itemList)) return null;

        $str = [];
        foreach ($itemList as $val) {
            $str[] = $val['itemstring'];
        }
        return implode($split , $str);
    }
}