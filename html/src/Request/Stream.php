<?php

namespace App\Request;

class Stream
{
    public function __construct(private ?string $id = null)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
