<?php

namespace DDDStarterPack\Domain\Exception;

use Exception;
use Throwable;

abstract class DomainException extends Exception
{
    const MESSAGE = 'An error has occurred';

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        $message = $message ?: static::MESSAGE;

        parent::__construct($message, $code, $previous);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        $a['code'] = $this->getCode();
        $a['message'] = $this->getMessage();

        return $a;
    }
}
