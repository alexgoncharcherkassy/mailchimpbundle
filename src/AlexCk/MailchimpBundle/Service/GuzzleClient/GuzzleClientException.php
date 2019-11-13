<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Service\GuzzleClient;

use Symfony\Component\HttpKernel\Exception\HttpException;

class GuzzleClientException extends HttpException
{
    /**
     * @var string
     */
    protected $exceptionContents;

    public function __construct($code, $message = null, $contents = '')
    {
        parent::__construct($code, $message);

        $this->exceptionContents = $contents;
    }

    public function getExceptionContents(): string
    {
        return $this->exceptionContents;
    }

    public function setExceptionContents(string $exceptionContents): GuzzleClientException
    {
        $this->exceptionContents = $exceptionContents;
        return $this;
    }
}
