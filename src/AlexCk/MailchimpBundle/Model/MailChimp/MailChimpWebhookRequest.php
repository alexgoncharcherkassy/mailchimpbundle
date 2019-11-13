<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class MailChimpWebhookRequest
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var MailChimpWebhookDataRequest
     */
    private $data;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): MailChimpWebhookRequest
    {
        $this->type = $type;
        return $this;
    }

    public function getData(): MailChimpWebhookDataRequest
    {
        return $this->data;
    }

    public function setData(MailChimpWebhookDataRequest $data): MailChimpWebhookRequest
    {
        $this->data = $data;
        return $this;
    }
}
