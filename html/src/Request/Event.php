<?php

namespace App\Request;

use App\Request\ParamConverter\RequestBodyConverter;

class Event implements RequestInterface
{
    public function __construct(private ?string $id = null, private ?Payload $payload = null)
    {
    }

    public static function getParamConverterClass(): string
    {
        return RequestBodyConverter::class;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setPayload(?Payload $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    public function getPayload(): ?Payload
    {
        return $this->payload;
    }
}
