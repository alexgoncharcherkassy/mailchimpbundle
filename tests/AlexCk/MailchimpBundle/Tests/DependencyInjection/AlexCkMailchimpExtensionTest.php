<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Tests\DependencyInjection;

use AlexCk\MailchimpBundle\Service\MailChimp\MailChimpClientImpl;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlexCkMailchimpExtensionTest extends WebTestCase
{
    public function testRegister()
    {
        $client = self::createClient();

        $mailchimp = $client->getContainer()->get('alexck_mailchimp.client');

        $this->assertInstanceOf(MailChimpClientImpl::class, $mailchimp);
    }
}