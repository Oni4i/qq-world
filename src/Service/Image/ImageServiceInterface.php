<?php

namespace Oni4i\QQWorld\Service\Image;

use Oni4i\QQWorld\Service\Dto\Client\AbstractResponseDto;

interface ImageServiceInterface
{
    public function generateImageByBuffer(string $buffer): AbstractResponseDto;
}
