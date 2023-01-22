<?php

declare(strict_types=1);

namespace Oni4i\QQWorld\Service\Dto\Client;

abstract class AbstractResponseDto
{
    protected int $code;
    protected string $msg;

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getMsg(): string
    {
        return $this->msg;
    }

    public function setMsg(string $msg): self
    {
        $this->msg = $msg;

        return $this;
    }
}
