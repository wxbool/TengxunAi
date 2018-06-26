<?php
namespace Tengxunai\Exception;

/**
 * 异常抛出
 * Class TengxunaiException
 * @package Tengxunai\Exception
 */
class TengxunaiException extends \Exception
{
    public function __construct($message='', $code=305)
    {
        parent::__construct($message , $code);
    }

}