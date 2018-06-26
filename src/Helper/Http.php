<?php
namespace Tengxunai\Helper;

class Http {
    /**
     * @var bool 是否Post请求
     */
    protected $isPost = false;
    /**
     * @var string 请求Url
     */
    protected $url = '';
    /**
     * @var array 请求参数
     */
    protected $params = [];
    /**
     * @var bool 是否Https
     */
    protected $isHttps = false;
    /**
     * @var int 最长连接时间
     */
    protected $timeOut = 30;
    /**
     * @var int 最长请求时间
     */
    protected $connTimeOut = 30;
    /**
     * @var string UserAgent
     */
    protected $userAgent = '';
    /**
     * @var array Http Header 请求头
     */
    protected $httpHeader = [];

    /**
     * @var 请求结果原始数据
     */
    protected $httpResult;
    /**
     * @var 请求信息
     */
    protected $httpInfo;

    /**
     * 设置请求Url
     * @param string $url
     */
    public function url($url='')
    {
        $this->url = $url;
    }

    /**
     * 设置请求数据
     * @param array $params
     */
    public function params(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * @param bool $isPost
     */
    public function isPost($isPost = false)
    {
        $this->isPost = $isPost;
    }

    /**
     * @param string $userAgent
     */
    public function userAgent($userAgent = '')
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @param array $httpHeader
     */
    public function httpHeader($httpHeader = [])
    {
        $this->httpHeader = $httpHeader;
    }

    /**
     * @param int $timeOut
     */
    public function timeOut($timeOut)
    {
        $this->timeOut = $timeOut;
    }

    /**
     * @param bool $isHttps
     */
    public function isHttps($isHttps = false)
    {
        $this->isHttps = $isHttps;
    }

    /**
     * @param int $connTimeOut
     */
    public function connTimeOut($connTimeOut = 30)
    {
        $this->connTimeOut = $connTimeOut;
    }



    /**
     * 开始请求
     * @return bool
     */
    public function request()
    {
        if (empty($this->url)) {
            return false;
        }
        $params = $this->params;
        if ($params && is_array($params)) {
            $params = http_build_query($params);
        }

        //init
        $thisCurl = curl_init();
        if (!empty($this->userAgent)) {
            curl_setopt($thisCurl, CURLOPT_USERAGENT, $this->userAgent);
        }
        curl_setopt($thisCurl, CURLOPT_CONNECTTIMEOUT, $this->connTimeOut);
        curl_setopt($thisCurl, CURLOPT_TIMEOUT, $this->timeOut);
        //请求头
        if ($this->httpHeader && is_array($this->httpHeader)) {
            curl_setopt($thisCurl, CURLOPT_HTTPHEADER, $this->httpHeader);
        }
        //https
        if ($this->isHttps) {
            curl_setopt($thisCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($thisCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            //CURL_SSLVERSION_TLSv1
            curl_setopt($thisCurl, CURLOPT_SSLVERSION, 1);
        }
        curl_setopt($thisCurl, CURLOPT_RETURNTRANSFER, 1);
        //Post
        if ($this->isPost) {
            curl_setopt($thisCurl, CURLOPT_POST ,true);
            curl_setopt($thisCurl, CURLOPT_URL, $this->url);
            if ($params) {
                curl_setopt($thisCurl, CURLOPT_POSTFIELDS , $params);
            }
        } else {
            if ($params) {
                curl_setopt($thisCurl, CURLOPT_URL, $this->url . '?' . $params);
            } else {
                curl_setopt($thisCurl, CURLOPT_URL, $this->url);
            }
        }
        //执行
        $this->httpResult = curl_exec($thisCurl);
        $this->httpInfo   = curl_getinfo($thisCurl);
        @curl_close($thisCurl);
        if (intval($this->httpInfo["http_code"]) == 200) {
            return true;
        }
        return false;
    }


    /**
     * 获取原始结果数据
     * @return mixed
     */
    public function getOriginalText()
    {
        return $this->httpResult;
    }


    /**
     * 对Http返回的结果数据进行文本转码
     * @param string $in_charset
     * @param string $out_charset
     */
    public function httpResultDecode($in_charset="gbk", $out_charset="utf-8")
    {
        $this->httpResult = Helper::arrayIconv($this->httpResult , $in_charset, $out_charset);
    }


    /**
     * 获取转JSON数据
     * @return mixed|null
     */
    public function getJsonDecodeData()
    {
        if (!$this->httpResult) return null;

        return json_decode($this->httpResult , true);
    }

    /**
     * 获取Http请求信息
     * @return mixed
     */
    public function getHttpInfo()
    {
        return $this->httpInfo;
    }
}