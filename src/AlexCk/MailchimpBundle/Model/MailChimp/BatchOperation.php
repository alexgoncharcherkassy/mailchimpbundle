<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class BatchOperation implements \JsonSerializable
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $body;

    public function jsonSerialize()
    {
        return [
            'method' => $this->getMethod(),
            'path' => $this->getPath(),
            'body' => $this->getBody()
        ];
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): BatchOperation
    {
        $this->method = $method;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): BatchOperation
    {
        $this->path = $path;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): BatchOperation
    {
        $this->body = $body;
        return $this;
    }
}
