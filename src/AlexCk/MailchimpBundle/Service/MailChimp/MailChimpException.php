<?php

declare(strict_types=1);

namespace AppBundle\Services\MailChimp;

namespace AlexCk\MailchimpBundle\Service\MailChimp;

use AlexCk\MailchimpBundle\Service\GuzzleClient\GuzzleClientException;

class MailChimpException extends GuzzleClientException
{
    /**
     * @var array
     */
    private $parsedContents;

    public function __construct($code, $message, $contents = '')
    {
        parent::__construct($code, $message, $contents);

        $this->parsedContents = $this->getExceptionContents() ? \GuzzleHttp\json_decode($this->getExceptionContents(), true) : '';
    }

    public function getTypeErr(): string
    {
        return isset($this->parsedContents['type']) ? $this->parsedContents['type'] : '';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return isset($this->parsedContents['title']) ? $this->parsedContents['title'] : '';
    }

    public function getDetail(): string
    {
        return isset($this->parsedContents['detail']) ? $this->parsedContents['detail'] : '';
    }

    public function getInstance(): string
    {
        return isset($this->parsedContents['instance']) ? $this->parsedContents['instance'] : '';
    }

    public function getStatusErr(): string
    {
        return isset($this->parsedContents['status']) ? $this->parsedContents['status'] : '';
    }

    public function getDetailsError(): string
    {
        $error = $this->getTitle();

        if (isset($this->parsedContents['errors']) && count($this->parsedContents['errors']) > 0) {
            $error = $this->parsedContents['errors'][0];

            if (is_array($error) && isset($error['message'])) {
                $error = $error['message'];
            }
        }

        return $error;
    }
}
