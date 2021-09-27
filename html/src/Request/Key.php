<?php

namespace App\Request;

class Key
{
    /**
     * @param string|null   $id
     * @param array<string> $content
     */
    public function __construct(private ?string $id = null, private array $content = [])
    {
    }
}
