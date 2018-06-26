<?php

namespace Tengxunai\Config;

/**
 * 应用配置
 * Class Config
 *
 * @property $appId
 * @property $appKey
 * @package Tengxunai\Config
 */
class Config {
    /**
     * @var array 静态实例
     */
    protected static $instance = [];

    /**
     * @var array 应用默认配置
     */
    protected $config = [
        'appId'  => '',
        'appKey' => '',
    ];


    /**
     * 初始化配置
     * Config constructor.
     * @param array $config
     */
    protected function __construct(array $config=[])
    {
        //重组配置
        $this->config = array_merge($this->config , $config);
    }


    /**
     * 返回静态实例
     * @param array $config
     * @return array|Config
     */
    public static function instance(array $config=[])
    {
        if (empty(self::$instance)) {
            self::$instance =  new self($config);
        }
        return self::$instance;
    }


    /**
     * 获取配置
     * @param string $name
     * @return array|mixed|null
     */
    public function get($name='')
    {
        if ($name === '') {
            return $this->config;
        }
        return isset($this->config[$name]) ? $this->config[$name] : null;
    }


    /**
     * 设置单项配置
     * @param string $name
     * @param $value
     */
    public function set($name='' , $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }


    /**
     * 获取配置
     * @param string $name
     * @return array|mixed|null
     */
    public function __get($name='')
    {
        if ($name === '') {
            return $this->config;
        }
        return isset($this->config[$name]) ? $this->config[$name] : null;
    }
}