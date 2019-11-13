<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Service\MailChimp;

use AlexCk\MailchimpBundle\Model\MailChimp\BatchOperation;
use AlexCk\MailchimpBundle\Model\MailChimp\BatchRequest;
use AlexCk\MailchimpBundle\Model\MailChimp\BatchResponse;
use AlexCk\MailchimpBundle\Model\MailChimp\ListItem;
use AlexCk\MailchimpBundle\Model\MailChimp\MailChimpResponse;
use AlexCk\MailchimpBundle\Model\MailChimp\MailChimpWebHook;
use AlexCk\MailchimpBundle\Model\MailChimp\MailChimpWebHooksEvent;
use AlexCk\MailchimpBundle\Model\MailChimp\MailChimpWebHooksSources;
use AlexCk\MailchimpBundle\Model\MailChimp\Member;
use AlexCk\MailchimpBundle\Service\GuzzleClient\GuzzleClient;
use AlexCk\MailchimpBundle\Service\GuzzleClient\GuzzleClientConfig;
use AlexCk\MailchimpBundle\Service\GuzzleClient\GuzzleClientException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class MailChimpClientImpl implements MailChimpClient, SerializerAwareInterface
{
    use SerializerAwareTrait;

    const MAIL_CHIMP_API_HOST = 'https://';
    const MAIL_CHIMP_API_DOMAIN = 'api.mailchimp.com/';

    /** @var GuzzleClient $client */
    private $guzzleClient;

    /** @var GuzzleClient $client */
    private $client;

    /**
     * MailChimpClient constructor.
     * @param GuzzleClient $guzzleClient
     */
    public function __construct(GuzzleClient $guzzleClient)
    {
       $this->guzzleClient = $guzzleClient;
    }

    public function configure(string $username, string $key, string $version): MailChimpClient
    {
        if (!$this->client) {
            $config = new GuzzleClientConfig();
            $config
                ->setUsername($username)
                ->setPassword($key)
                ->setBaseUri(self::MAIL_CHIMP_API_HOST . $this->getDCFromApiKey($key) . '.' . self::MAIL_CHIMP_API_DOMAIN . $version . '/')
                ->setAccept('application/json')
                ->setContentType('application/json');

            $this->client = $this->guzzleClient->baseAuthentication($config);
        }

        return $this;
    }

    private function getClient(): GuzzleClient
    {
        if (!$this->client) {
            throw new MailChimpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Mailchimp client should be configured");
        }

        return $this->client;
    }

    private function getDCFromApiKey(?string $key): string
    {
        if ($key) {
            $index = strrpos($key, '-');

            return $index ? trim(substr($key, $index + 1)) : '';
        }

        return '';
    }

    public function createList(ListItem $listItem): ListItem
    {
        $data = $this->serializer->normalize($listItem, 'json', []);

        try {
            $response = $this->getClient()->post('lists', $data);
        } catch (GuzzleClientException $e) {
            throw new MailChimpException($e->getStatusCode(), $e->getMessage(), $e->getExceptionContents());
        }

        return  $this->serializer->denormalize($response->getBody()->getContents(), ListItem::class, 'json', []);
    }

    public function getLists(): MailChimpResponse
    {
        try {
            $response = $this->getClient()->get('lists');
        } catch (GuzzleClientException $e) {
            throw new MailChimpException($e->getStatusCode(), $e->getMessage(), $e->getExceptionContents());
        }

        return $this->serializer->denormalize($response->getBody()->getContents(), MailChimpResponse::class, 'json', []);
    }

    public function createMember(Member $member, string $listId, ?string $unsubscribeUrl): Member
    {
        $data = $this->serializer->normalize($member, 'json', []);

        try {
            $response = $this->getClient()->post(
                'lists/' . $listId . '/members',
                $data
            );
        } catch (GuzzleClientException $e) {
            throw new MailChimpException($e->getStatusCode(), $e->getMessage(), $e->getExceptionContents());
        }

        if ($unsubscribeUrl) {
            $this->createWebHookEventUnsubscribe($listId, $unsubscribeUrl);
        }

        return $this->serializer->denormalize($response->getBody()->getContents(), Member::class, 'json', []);
    }

    public function updateMember(Member $member, string $listId, string $oldEmail, ?string $unsubscribeUrl): Member
    {
        $data = $this->serializer->normalize($member, 'json', []);

        try {
            $response = $this->getClient()->put(
                'lists/' . $listId . '/members/' . $this->getMemberHash($oldEmail),
                $data
            );
        } catch (GuzzleClientException $e) {
            throw new MailChimpException($e->getStatusCode(), $e->getMessage(), $e->getExceptionContents());
        }

        if ($unsubscribeUrl) {
            $this->createWebHookEventUnsubscribe($listId, $unsubscribeUrl);
        }

        return $this->serializer->denormalize($response->getBody()->getContents(), Member::class, 'json', []);
    }

    private function getMemberHash($email)
    {
        return md5(strtolower($email));
    }

    public function deleteMember(Member $member, string $listId): bool
    {
        try {
            $this->getClient()->delete(
                'lists/' . $listId . '/members/' . $this->getMemberHash($member->getEmail()),
                []
            );
        } catch (GuzzleClientException $e) {
            throw new MailChimpException($e->getStatusCode(), $e->getMessage(), $e->getExceptionContents());
        }

        return true;
    }

    public function listWebHookEvent(string $listId): MailChimpResponse
    {
        try {
            $response = $this->getClient()->get('lists/' . $listId . '/webhooks');
        } catch (GuzzleClientException $e) {
            throw new MailChimpException($e->getStatusCode(), $e->getMessage(), $e->getExceptionContents());
        }

        return $this->serializer->denormalize($response->getBody()->getContents(), MailChimpResponse::class, 'json', []);
    }

    public function createWebHookEventUnsubscribe(string $listId, string $unsubscribeUrl): MailChimpWebHook
    {
        $isFind = $this->checkIsExistsUnsubscribeWebhook($listId);

        if (!$isFind) {
            $webhookSources = new MailChimpWebHooksSources();

            $webhookEvent = new MailChimpWebHooksEvent();
            $webhookEvent
                ->setSubscribe(false)
                ->setUnsubscribe(true);

            $webhook = new MailChimpWebHook();
            $webhook
                ->setEvents($webhookEvent)
                ->setSources($webhookSources)
                ->setUrl($unsubscribeUrl);

            $data = $this->serializer->normalize($webhook, 'json', []);

            try {
                $response = $this->getClient()->post(
                    'lists/' . $listId . '/webhooks',
                    $data
                );
            } catch (GuzzleClientException $e) {
                throw new MailChimpException($e->getStatusCode(), $e->getMessage(), $e->getExceptionContents());
            }

            return $this->serializer->denormalize($response->getBody()->getContents(), MailChimpWebHook::class, 'json', []);
        }

        return new MailChimpWebHook();
    }

    private function checkIsExistsUnsubscribeWebhook(string $listId): bool
    {
        try {
            $mailChimpResponse = $this->listWebHookEvent($listId);
        } catch (GuzzleClientException $exception) {
            $mailChimpResponse = new MailChimpResponse();
        }

        $isFind = false;

        /** @var MailChimpWebHook $webhook */
        foreach ($mailChimpResponse->getWebhooks() as $webhook) {
            if ($webhook->getEvents() && $webhook->getEvents()->isUnsubscribe()) {
                $isFind = true;
            }
        }

        return $isFind;
    }

    public function createBatchMember(string $listId, iterable $members, ?string $unsubscribeUrl): BatchResponse
    {
        $batchReq = new BatchRequest();

        foreach ($members as $member) {
            if ($member instanceof Member) {
                $batchOperation = new BatchOperation();
                $batchOperation
                    ->setMethod("POST")
                    ->setPath('lists/' . $listId . '/members')
                    ->setBody(\GuzzleHttp\json_encode($this->serializer->normalize($member, 'json', [])));

                $batchReq->addOperation($batchOperation);
            }
        }

        $data = $this->serializer->normalize($batchReq, 'json', []);

        try {
            $response = $this->getClient()->post('batches', $data);
        } catch (GuzzleClientException $e) {
            throw new MailChimpException($e->getStatusCode(), $e->getMessage(), $e->getExceptionContents());
        }

        if ($unsubscribeUrl) {
            $this->createWebHookEventUnsubscribe($listId, $unsubscribeUrl);
        }

        return $this->serializer->denormalize($response->getBody()->getContents(), BatchResponse::class, 'json', []);
    }
}
