<?php

namespace App\Request;

class System
{
    public function __construct(private ?string $name = null)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
