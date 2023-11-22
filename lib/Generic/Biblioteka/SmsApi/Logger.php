<?php
namespace Generic\Biblioteka\SmsBm;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Logger implements LoggerInterface
{
    use LoggerTrait;

    public function log($level, $message, array $context = [])
    {
        //var_dump($level, $message, $context);
    }
};



