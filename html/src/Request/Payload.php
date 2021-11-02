<?php

namespace App\Request;

class Payload
{
    /**
     * @param string|null $url
     * @param string[]    $content
     */
    public function __construct(private ?string $url = null, private array $content = [])
    {
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * @param string[] $content
     *
     * @return $this
     */
    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }
}
