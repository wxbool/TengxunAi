<?php
use Tengxunai\App;

class Test {
    protected $app;

    public function __construct()
    {
        require_once '../vendor/autoload.php';

        $this->app = App::instance([
            'appId'  => '',
            'appKey' => '',
        ]);
    }
    
    //智能闲聊
    public function textChat()
    {
        $textChat = $this->app->textChat->textChat('你好啊');

        echo $textChat->session();
        echo $textChat->answer();
    }


    //文本分词
    public function textAnalysis()
    {
        $textAnalysis = $this->app->textAnalysis->wordSeg('侏罗纪世界2');

        echo $textAnalysis->text() . ' => ';
        var_dump($textAnalysis->mixTokens());
        var_dump($textAnalysis->baseTokens());
    }
}


$tengxunAi = new Test();
//智能闲聊
//$tengxunAi->textChat();

//文本分词
$tengxunAi->textAnalysis();