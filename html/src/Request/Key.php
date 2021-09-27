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

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string[]
     */
    public function getContent(): array
    {
        return $this->content;
    }

    public function getContentByKey(string $key = null): mixed
    {
        if (null !== $key) {
            return $this->content[$key];
        }

        return '';
    }
}
