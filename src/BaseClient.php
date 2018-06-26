<?php
namespace Tengxunai;
use Tengxunai\Config\Config;
use Tengxunai\Exception\TengxunaiException;


/**
 * 服务基类
 * Class BaseClient
 * @package Tengxunai
 */
class BaseClient {
    /**
     * @var array|Config 应用配置
     */
    protected $appConfig;

    /**
     * @var string 基础api前缀
     */
    protected $baseUrl = 'https://api.ai.qq.com/';


    public function __construct()
    {
        //绑定配置
        $this->appConfig = Config::instance();
    }



    /**
     * 创建api请求参数
     * @param array $params
     * @return array
     * @throws TengxunaiException
     */
    protected function createParams(array &$params = [])
    {
        if (!is_array($params)) $params = [];
        //组合基础参数
        $params = $this->getBaseParams($params);
        //生成sign
        $this->requestSign($params);
    }


    /**
     * 获取基础api参数
     * @param array $array
     * @return array
     */
    protected function getBaseParams(array $array = [])
    {
        //基础参数
        $params  =  [
            'app_id'      =>  (int)$this->appConfig->appId,
            'time_stamp'  =>  time(),
            'nonce_str'   =>  strval(rand()),
            'sign'        =>  ''
        ];

        if (!is_array($array)) return $params;
        return array_merge($params , $array);
    }


    /**
     * 根据 接口请求参数 和 应用密钥 计算 请求签名
     * @param array $params 接口请求参数 （特别注意：不同的接口，参数对一般不一样，请以具体接口要求为准）
     * @return string
     * @throws TengxunaiException
     */
    protected function requestSign(&$params=[])
    {
        if (trim($this->appConfig->appId) == '') {
            throw new TengxunaiException( 'appKey non-existent ~' );
        }

        // 1. 字典升序排序
        ksort($params);
        // 2. 拼按URL键值对
        $str = '';
        foreach ($params as $key => $value) {
            if ($value !== '') {
                $str .= $key . '=' . urlencode($value) . '&';
            }
        }

        // 3. 拼接app_key
        $str .= 'app_key=' . $this->appConfig->appKey;
        // 4. MD5运算+转换大写，得到请求签名
        $sign = strtoupper(md5($str));
        //组装
        $params['sign'] = $sign;
        return $sign;
    }
}