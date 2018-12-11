<?php
use Tengxunai\App;

class Test {
    protected $app;

    public function __construct()
    {
        require_once '../vendor/autoload.php';

        $this->app = App::instance([
            'appId'  => '1106919331',
            'appKey' => '6vIMj0oOIgVv58tv',
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


    public function imageText()
    {
        $imageTo = $this->app->ocrGeneralocr->generalocr('http://www.job001.cn/captcha/entinfo?id=52232&sourceType=1&type=3&t=1544438995930' , true);

        var_dump($imageTo->allStr());
    }

    public function handImageText()
    {
        $imageTo = $this->app->ocrGeneralocr->handocr('http://image.paiduoduoo.net/images/2018/12/10/f8686476e6a77aa29d81f32442a1b56c-800.png' , true);

        var_dump($imageTo);
        var_dump($imageTo->allStr());
    }
}

//mobile
//http://www.job001.cn/captcha/entinfo?id=1677579&sourceType=1&type=2&t=1544438995930
//phone
//http://www.job001.cn/captcha/entinfo?id=1677579&sourceType=1&type=3&t=1544438995930
//email
//http://www.job001.cn/captcha/entinfo?id=1677579&sourceType=1&type=4&t=1544438995930

$tengxunAi = new Test();
//智能闲聊
//$tengxunAi->textChat();

//文本分词
//$tengxunAi->textAnalysis();

//$tengxunAi->imageText();

$tengxunAi->handImageText();