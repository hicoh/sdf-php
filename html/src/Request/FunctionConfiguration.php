<?php

namespace App\Request;

class FunctionConfiguration
{
    /**
     * @param string|null        $name
     * @param array<string>|null $settings
     * @param Key|null           $key
     */
    public function __construct(private ?string $name = null, private ?array $settings = null, private ?Key $key = null)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]|null
     */
    public function getSettings(): ?array
    {
        return $this->settings;
    }

    public function getKey(): ?Key
    {
        return $this->key;
    }
}
