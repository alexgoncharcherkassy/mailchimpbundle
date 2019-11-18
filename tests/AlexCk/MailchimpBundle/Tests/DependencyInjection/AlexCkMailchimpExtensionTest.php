<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Tests\DependencyInjection;

use AlexCk\MailchimpBundle\Service\MailChimp\MailChimpClientImpl;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlexCkMailchimpExtensionTest extends WebTestCase
{
    /** @var MailChimpClientImpl */
    private $mailchimpClient;
    private $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->mailchimpClient = $this->client->getContainer()->get('alexck_mailchimp.client');
    }

    public function testLoad()
    {
        $this->assertInstanceOf(MailChimpClientImpl::class, $this->mailchimpClient);
    }
}