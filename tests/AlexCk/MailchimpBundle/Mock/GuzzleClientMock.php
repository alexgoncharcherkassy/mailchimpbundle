<?php

namespace AlexCk\MailchimpBundle\Mock;

use AlexCk\MailchimpBundle\Service\GuzzleClient\GuzzleClientImpl;
use PHPUnit\Framework\TestCase;

class GuzzleClientMock extends TestCase
{
    public static function registry()
    {
        $mock = (new static())->getMockBuilder(GuzzleClientImpl::class)
            ->disableOriginalConstructor()
            ->setMethods(['get', 'post', 'put', 'delete'])
            ->getMock();

        return $mock;
    }
}