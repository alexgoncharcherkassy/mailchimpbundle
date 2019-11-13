<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Tests\Service;

use AlexCk\MailchimpBundle\Service\GuzzleClient\GuzzleClientImpl;
use AlexCk\MailchimpBundle\Service\MailChimp\MailChimpClientImpl;
use PHPUnit\Framework\TestCase;

class MailChimpClientImplTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|GuzzleClientImpl
     */
    private $client;

    protected function setUp(): void
    {
        $this->client = $this->getMockBuilder(GuzzleClientImpl::class)
            ->disableOriginalConstructor()
            ->setMethods(['get', 'post', 'put', 'delete'])
            ->getMock();
    }

    public function testConfigure()
    {
        $mailchimp = new MailChimpClientImpl($this->client);

        $mailchimp->configure('test', 'test', '3.0');

        $this->assertNotEmpty($mailchimp);
    }
}