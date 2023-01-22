<?php

declare(strict_types=1);

namespace Oni4i\QQWorld\Service\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractQQClient
{
    public function __construct(
        protected readonly HttpClientInterface $client
    ) {
    }
}