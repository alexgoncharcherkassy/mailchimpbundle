<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Tests\Service\MailChimp;

use AlexCk\MailchimpBundle\Model\MailChimp\ListItem;
use AlexCk\MailchimpBundle\Model\MailChimp\ListItemCampaignDefaults;
use AlexCk\MailchimpBundle\Model\MailChimp\ListItemContact;
use AlexCk\MailchimpBundle\Model\MailChimp\MailChimpWebHook;
use AlexCk\MailchimpBundle\Model\MailChimp\Member;
use AlexCk\MailchimpBundle\Model\MailChimp\MemberMergeFields;
use AlexCk\MailchimpBundle\Service\GuzzleClient\GuzzleClientException;
use AlexCk\MailchimpBundle\Service\GuzzleClient\GuzzleClientImpl;
use AlexCk\MailchimpBundle\Service\MailChimp\MailChimpClientImpl;
use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class MailChimpClientImplTest extends WebTestCase
{
    /**
     * @var MockObject|GuzzleClientImpl
     */
    private $guzzleClient;
    private $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->guzzleClient = $this->client->getContainer()->get('alexck_mailchimp.guzzle');
    }

    public function testConfigure()
    {
        $mailchimpClient = new MailChimpClientImpl($this->guzzleClient);
        $mailchimpClient->setSerializer($this->client->getContainer()->get('serializer'));

        $mailchimpClient->configure('test', 'test', '3.0');

        $this->assertNotEmpty($mailchimpClient);
    }

    /**
     * @dataProvider failData
     * @param array $data
     */
    public function testFailConfigure(array $data)
    {
        $this->expectException(GuzzleClientException::class);
        $mailchimpClient = new MailChimpClientImpl($this->guzzleClient);
        $mailchimpClient->setSerializer($this->client->getContainer()->get('serializer'));

        $mailchimpClient->configure($data['username'], $data['key'], $data['version']);
    }

    public function failData()
    {
        return [
            [
                [
                    'username' => '',
                    'key' => 'key',
                    'version' => '3.0'
                ]
            ],
            [
                [
                    'username' => 'username',
                    'key' => '',
                    'version' => '3.0'
                ]
            ],
            [
                [
                    'username' => 'username',
                    'key' => 'key',
                    'version' => ''
                ]
            ]
        ];
    }

    public function testGetLists()
    {
        $mailchimpClient = new MailChimpClientImpl($this->guzzleClient);
        $mailchimpClient->setSerializer($this->client->getContainer()->get('serializer'));

        $resp = $this->createMockResponse('getLists.json');

        $this->guzzleClient
            ->expects($this->once())
            ->method('get')
            ->willReturn($resp);

        $mailchimpClient->configure('test', 'test', '3.0');

        $lists = $mailchimpClient->getLists();

        $this->assertEquals(1, $lists->getLists()->count());
        $this->assertEquals(1, $lists->getWebhooks()->count());
        /** @var ListItem $item */
        $item = $lists->getLists()->first();

        $this->assertEquals('name', $item->getName());
        $this->assertEquals('perm_rem', $item->getPermissionReminder());
        $this->assertEquals(true, $item->isEmailTypeOption());
        $this->assertEquals('id1', $item->getId());
        $this->assertEquals('comp', $item->getContact()->getCompany());
        $this->assertEquals('adr1', $item->getContact()->getAddress1());
        $this->assertEquals('adr2', $item->getContact()->getAddress2());
        $this->assertEquals('CK', $item->getContact()->getCity());
        $this->assertEquals('18000', $item->getContact()->getZip());
        $this->assertEquals('UA', $item->getContact()->getCountry());
        $this->assertEquals('123456789', $item->getContact()->getPhone());
        $this->assertEquals('CK', $item->getContact()->getState());
        $this->assertEquals('fromName', $item->getCampaignDefaults()->getFromName());
        $this->assertEquals('test@test.com', $item->getCampaignDefaults()->getFromEmail());
        $this->assertEquals('sub', $item->getCampaignDefaults()->getSubject());
        $this->assertEquals('en', $item->getCampaignDefaults()->getLanguage());
    }

    public function testCreateList()
    {
        $mailchimpClient = new MailChimpClientImpl($this->guzzleClient);
        $mailchimpClient->setSerializer($this->client->getContainer()->get('serializer'));

        $resp = $this->createMockResponse('createList.json');

        $this->guzzleClient
            ->expects($this->once())
            ->method('post')
            ->willReturn($resp);

        $mailchimpClient->configure('test', 'test', '3.0');

        /** @var ListItem $item */
        $item = $mailchimpClient->createList($this->createListItem());

        $this->assertEquals('name', $item->getName());
        $this->assertEquals('perm_rem', $item->getPermissionReminder());
        $this->assertEquals(true, $item->isEmailTypeOption());
        $this->assertEquals('id1', $item->getId());
        $this->assertEquals('comp', $item->getContact()->getCompany());
        $this->assertEquals('adr1', $item->getContact()->getAddress1());
        $this->assertEquals('adr2', $item->getContact()->getAddress2());
        $this->assertEquals('CK', $item->getContact()->getCity());
        $this->assertEquals('18000', $item->getContact()->getZip());
        $this->assertEquals('UA', $item->getContact()->getCountry());
        $this->assertEquals('123456789', $item->getContact()->getPhone());
        $this->assertEquals('CK', $item->getContact()->getState());
        $this->assertEquals('fromName', $item->getCampaignDefaults()->getFromName());
        $this->assertEquals('test@test.com', $item->getCampaignDefaults()->getFromEmail());
        $this->assertEquals('sub', $item->getCampaignDefaults()->getSubject());
        $this->assertEquals('en', $item->getCampaignDefaults()->getLanguage());
    }

    public function testCreateMember()
    {
        $mailchimpClient = new MailChimpClientImpl($this->guzzleClient);
        $mailchimpClient->setSerializer($this->client->getContainer()->get('serializer'));

        $resp = $this->createMockResponse('member.json');

        $this->guzzleClient
            ->expects($this->once())
            ->method('post')
            ->willReturn($resp);

        $mailchimpClient->configure('test', 'test', '3.0');

        /** @var Member $member */
        $member = $mailchimpClient->createMember($this->createMember(), '1');

        $this->assertEquals('id1', $member->getId());
        $this->assertEquals('good', $member->getStatus());
        $this->assertEquals('test@own.com', $member->getEmail());
    }

    public function testUpdateMember()
    {
        $mailchimpClient = new MailChimpClientImpl($this->guzzleClient);
        $mailchimpClient->setSerializer($this->client->getContainer()->get('serializer'));

        $resp = $this->createMockResponse('member.json');

        $this->guzzleClient
            ->expects($this->once())
            ->method('put')
            ->willReturn($resp);

        $mailchimpClient->configure('test', 'test', '3.0');

        /** @var Member $member */
        $member = $mailchimpClient->updateMember($this->createMember(), '1', 'test_old@own.com');

        $this->assertEquals('id1', $member->getId());
        $this->assertEquals('good', $member->getStatus());
        $this->assertEquals('test@own.com', $member->getEmail());
    }

    public function testDeleteMember()
    {
        $mailchimpClient = new MailChimpClientImpl($this->guzzleClient);
        $mailchimpClient->setSerializer($this->client->getContainer()->get('serializer'));

        $this->guzzleClient
            ->expects($this->once())
            ->method('delete')
            ->willReturn(new Response());

        $mailchimpClient->configure('test', 'test', '3.0');

        $result = $mailchimpClient->deleteMember($this->createMember(), '1');

        $this->assertTrue($result);
    }

    public function testListWebHookEvent()
    {
        $mailchimpClient = new MailChimpClientImpl($this->guzzleClient);
        $mailchimpClient->setSerializer($this->client->getContainer()->get('serializer'));

        $resp = $this->createMockResponse('getLists.json');

        $this->guzzleClient
            ->expects($this->once())
            ->method('get')
            ->willReturn($resp);

        $mailchimpClient->configure('test', 'test', '3.0');

        $lists = $mailchimpClient->getLists();
        /** @var MailChimpWebHook $webhook */
        $webhook = $lists->getWebhooks()->first();

        $this->assertEquals('https://test.com/webhook', $webhook->getUrl());
        $this->assertEquals('id2', $webhook->getId());
        $this->assertEquals(true, $webhook->getEvents()->isSubscribe());
        $this->assertEquals(false, $webhook->getEvents()->isUnsubscribe());
    }

    public function testCreateWebHookEventUnsubscribe()
    {
        $mailchimpClient = new MailChimpClientImpl($this->guzzleClient);
        $mailchimpClient->setSerializer($this->client->getContainer()->get('serializer'));

        $resp = $this->createMockResponse('webhook.json');

        $this->guzzleClient
            ->expects($this->once())
            ->method('post')
            ->willReturn($resp);

        $respGet = $this->createMockResponse('getLists.json');

        $this->guzzleClient
            ->expects($this->once())
            ->method('get')
            ->willReturn($respGet);

        $mailchimpClient->configure('test', 'test', '3.0');

        $webhook = $mailchimpClient->createWebHookEventUnsubscribe('1', 'test.com');

        $this->assertEquals('https://test.com/webhook', $webhook->getUrl());
        $this->assertEquals('id2', $webhook->getId());
        $this->assertEquals(true, $webhook->getEvents()->isSubscribe());
        $this->assertEquals(false, $webhook->getEvents()->isUnsubscribe());
    }

    public function testCreateBatchMember()
    {
        $mailchimpClient = new MailChimpClientImpl($this->guzzleClient);
        $mailchimpClient->setSerializer($this->client->getContainer()->get('serializer'));

        $resp = $this->createMockResponse('batchResponse.json');

        $this->guzzleClient
            ->expects($this->once())
            ->method('post')
            ->willReturn($resp);

        $mailchimpClient->configure('test', 'test', '3.0');

        $batchResp = $mailchimpClient->createBatchMember('listId', [$this->createMember()]);

        $this->assertEquals('id3', $batchResp->getId());
        $this->assertEquals('success', $batchResp->getStatus());
        $this->assertEquals(1, $batchResp->getTotalOperations());
        $this->assertEquals(1, $batchResp->getFinishedOperations());
    }

    private function createMockResponse(string $contentFile, int $status = 200): Response
    {
        $stream = new LazyOpenStream(__DIR__ . "/{$contentFile}", 'r');

        $resp = new Response(
            $status,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            $stream
        );

        return $resp;
    }

    private function createListItem(): ListItem
    {
        $contact = new ListItemContact();
        $contact
            ->setAddress1('adr1')
            ->setAddress2('adr2')
            ->setCity('CK')
            ->setCompany('comp')
            ->setCountry('UA')
            ->setPhone('123456789')
            ->setState('CK')
            ->setZip('18000');
        $campaign = new ListItemCampaignDefaults();
        $campaign
            ->setFromName('fromName')
            ->setFromEmail('test@test.com')
            ->setLanguage('en')
            ->setSubject('sub');
        $item = new ListItem();
        $item
            ->setId('id1')
            ->setName('name')
            ->setEmailTypeOption(true)
            ->setPermissionReminder('perm_rem')
            ->setContact($contact)
            ->setCampaignDefaults($campaign);

        return $item;
    }

    private function createMember(): Member
    {
        $mergedFields = new MemberMergeFields();
        $mergedFields
            ->setFName('fName')
            ->setLName('lName');

        $member = new Member();
        $member
            ->setId('id1')
            ->setStatus('good')
            ->setEmail('test@own.com')
            ->setMergeFields($mergedFields);

        return $member;
    }
}
