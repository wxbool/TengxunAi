# Tengxunai

Tengxunai 是一个开源的 非官方 SDK。

Tengxunai 用于快速接入[`腾讯开发AI平台`](https://ai.qq.com/) 中的应用

# 1. 系统要求
* PHP version >= 5.4（推荐 7.1）
* PHP 组件: curl, json, mbstring, xml, zip

# 2. 安装

使用 composer:

$ composer require wxbool/tengxunai dev-master

# 3. 使用

## 获取全局实例
```
use Tengxunai\App;

$config = [
    'appId'  => 123456789,
    'appKey' => '6vIdsfasdIgVv58tv',
];

$app = App::instance($config);
```
$app 是所有应用对象的集合，全局统一使用 $app 进行获取应用实例。

## 调用示例

### a.基础文本分词
```
//获得 基础文本分词 应用
$textAnalysis = $app->textAnalysis;
//执行分词
$httpResult = $textAnalysis->wordSeg('侏罗纪世界2')

//输出分词文本
echo $httpResult->text();
//打印分词文本 混排词粒度分词列表
var_dump( $httpResult->mixTokens() );
//打印分词文本 基础词粒度分词列表
var_dump( $httpResult->baseTokens() );
```

### b.智能闲聊
```
//获得 智能闲聊 应用
$textChat = $app->textChat;
//执行 聊天
$httpResult = $textChat->textChat('你好啊');

//输出会话Id
echo $httpResult->session();
//输出回答文本
echo $httpResult->answer();
```