<?php

require '../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;

// create a log channel
date_default_timezone_set("Asia/Tokyo");
$log = new Logger('name');
$date_format = "Y年m月d日 H:i:s";
$format = "%datetime% > %level_name% > %message% %context% %extra%\n";
$formatter = new LineFormatter($format, $date_format);
$stream = new StreamHandler(__DIR__ . '/your.log', Logger::DEBUG);
$stream->setFormatter($formatter);
$log->pushHandler($stream);
$log->pushProcessor(new MemoryUsageProcessor);
$log->pushProcessor(new WebProcessor);

// add records to the log
$log->error('Bar');
