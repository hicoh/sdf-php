<?php

namespace App\Request;

use App\Request\ParamConverter\RequestBodyConverter;

class ContextRequest implements RequestInterface
{
    public function __construct(private System $system, private FunctionConfiguration $function_configuration, private ?Stream $stream, private ?Event $event)
    {
    }

    public static function getParamConverterClass(): string
    {
        return RequestBodyConverter::class;
    }

    public function getSystem(): System
    {
        return $this->system;
    }

    public function getFunctionConfiguration(): FunctionConfiguration
    {
        return $this->function_configuration;
    }

    public function getStream(): ?Stream
    {
        return $this->stream;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }
}
