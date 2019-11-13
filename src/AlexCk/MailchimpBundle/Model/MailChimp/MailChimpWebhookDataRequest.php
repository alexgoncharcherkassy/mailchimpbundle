<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class MailChimpWebhookDataRequest
{
    /**
     * @var string
     */
    private $list_id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var MailChimpWebhookDataMergeFieldsRequest
     */
    private $merges;

    public function getListId(): string
    {
        return $this->list_id;
    }

    public function setListId(string $listId): MailChimpWebhookDataRequest
    {
        $this->list_id = $listId;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): MailChimpWebhookDataRequest
    {
        $this->email = $email;
        return $this;
    }

    public function getMerges(): MailChimpWebhookDataMergeFieldsRequest
    {
        return $this->merges;
    }

    public function setMerges(MailChimpWebhookDataMergeFieldsRequest $merges): MailChimpWebhookDataRequest
    {
        $this->merges = $merges;
        return $this;
    }
}
