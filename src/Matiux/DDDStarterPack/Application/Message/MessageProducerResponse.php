<?php

namespace DDDStarterPack\Application\Message;

interface MessageProducerResponse
{
    public function isSuccess(): bool;

    public function sentMessages(): int;

    public function originalResponse();

    public function body();

    public function sentMessageId();
}
