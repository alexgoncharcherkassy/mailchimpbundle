<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Service\GuzzleClient;

class GuzzleClientConfig
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var string
     */
    private $accept;

    /**
     * @var string
     */
    private $contentType;

    /**
     * GuzzleClientConfig constructor.
     */
    public function __construct()
    {
        $this->setContentType('application/json');
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): GuzzleClientConfig
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): GuzzleClientConfig
    {
        $this->password = $password;

        return $this;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function setBaseUri(string $baseUri): GuzzleClientConfig
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    public function getAccept(): string
    {
        return $this->accept;
    }

    public function setAccept(string $accept): GuzzleClientConfig
    {
        $this->accept = $accept;

        return $this;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function setContentType(string $contentType): GuzzleClientConfig
    {
        $this->contentType = $contentType;

        return $this;
    }
}
