<?php
namespace Tengxunai\Helper;

class Helper {

    /**
     * UTF-8编码 GBK编码相互转换/（支持数组）
     *
     * @param array/string  $str          字符串，支持数组传递
     * @param string $in_charset   原字符串编码
     * @param string $out_charset  输出的字符串编码
     * @return array/string
     */
    public static function arrayIconv($str, $in_charset="gbk", $out_charset="utf-8") {
        if(is_array($str)) {
            foreach($str as $k => $v) {
                $str[$k] = self::arrayIconv($v , $in_charset , $out_charset);
            }
            return $str;
        } else {
            if(is_string($str)) {
                return iconv($in_charset, $out_charset, $str);
            } else {
                return $str;
            }
        }
    }


    /**
     * 快速获取文件Base64编码数据
     * @param string $path
     * @param bool $http
     * @return null|string
     */
    public static function fileBase64Str($path='' , $http = false)
    {
        if (empty($path)) return null;
        if (!$http) {
            if (!is_file($path)) return null;
        }
        //返回
        return base64_encode( file_get_contents($path) );
    }


    /**
     * 获取base64大小[字节]
     * @param $base64
     * @return float|int
     */
    public static function getBase64FileSize($base64)
    {
        $slen = strlen($base64);
        return $slen - ($slen/8)*2;
    }
}