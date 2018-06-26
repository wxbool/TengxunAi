<?php
namespace Tengxunai;

use Tengxunai\Config\Config;


/**
 * 应用接口
 * Class App
 *
 * @property \Tengxunai\Service\TextAnalysis $textAnalysis
 * @property \Tengxunai\Service\TextChat     $textChat
 * @property \Tengxunai\Service\VoiceTts     $voiceTts
 * @property \Tengxunai\Service\VoiceTta     $voiceTta
 * @property \Tengxunai\Service\Ocr\Generalocr   $ocrGeneralocr
 * @package Tengxunai
 */
class App {
    protected static $thisInstance;

    /**
     * @var array 实例映射
     */
    protected $providers = [
        'textAnalysis' => '\\Tengxunai\\Service\\TextAnalysis',
        'textChat' => '\\Tengxunai\\Service\\TextChat',
        'voiceTts' => '\\Tengxunai\\Service\\VoiceTts',
        'voiceTta' => '\\Tengxunai\\Service\\VoiceTta',
        'ocrGeneralocr' => '\\Tengxunai\\Service\\Ocr\\Generalocr',
    ];

    /**
     * @var array 实例数据
     */
    protected $instance = [];


    /**
     * 应用初始化
     * App constructor.
     * @param array $config
     */
    protected function __construct(array $config = [])
    {
        //初始化配置
        Config::instance($config);
    }


    /**
     * 静态调用接口
     * @param array $config
     * @return App
     */
    public static function instance(array $config = [])
    {
        if (!self::$thisInstance) {
            self::$thisInstance = new self($config);
        }

        return self::$thisInstance;
    }


    /**
     * 获取实例
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (empty($name)) return null;
        if (!array_key_exists($name , $this->providers)) {
            return null;
        }
        //实例化
        if (!array_key_exists($name , $this->instance)) {
            $this->instance[$name] = new $this->providers[$name];
        }
        return $this->instance[$name];
    }
}