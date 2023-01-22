<?php

require_once __DIR__ . '/vendor/autoload.php';

use Oni4i\QQWorld\Service\Client\QQImageClient;
use Oni4i\QQWorld\Service\Image\ImageService;
use Oni4i\QQWorld\Service\Dto\Client\ImageSuccessfulResponseDto;
use Symfony\Component\HttpClient\HttpClient;

$img = file_get_contents('img.png');

$client = new QQImageClient(HttpClient::create());
$imageService = new ImageService($client);

/** @var ImageSuccessfulResponseDto $result */
$result = $imageService->generateImageByBuffer($img);

$filename = explode('?', basename($result->getImgUrl()))[0];
file_put_contents($filename, file_get_contents($result->getImgUrl()));

print_r('HERE IS FILE\'S URL' . PHP_EOL);
print_r($result->getImgUrl());
print_r(PHP_EOL . PHP_EOL . PHP_EOL);