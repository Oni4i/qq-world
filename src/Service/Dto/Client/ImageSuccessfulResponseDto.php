<?php

declare(strict_types=1);

namespace Oni4i\QQWorld\Service\Dto\Client;

class ImageSuccessfulResponseDto extends AbstractResponseDto
{
    protected string $imgUrl;

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(string $imgUrl): void
    {
        $this->imgUrl = $imgUrl;
    }
}
