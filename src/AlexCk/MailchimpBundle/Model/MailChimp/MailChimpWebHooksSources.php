<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class MailChimpWebHooksSources implements \JsonSerializable
{
    /**
     * @var bool
     */
    private $api;

    /**
     * @var bool
     */
    private $admin;

    /**
     * @var bool
     */
    private $subscriber;

    /**
     * MailChimpWebHooksSources constructor.
     */
    public function __construct()
    {
        $this->setApi(true);
        $this->setAdmin(true);
        $this->setSubscriber(true);
    }

    public function jsonSerialize()
    {
        return [
            'api' => $this->isApi(),
            'user' => $this->isSubscriber(),
            'admin' => $this->isAdmin()
        ];
    }

    public function isApi(): bool
    {
        return $this->api;
    }

    public function setApi(bool $api): MailChimpWebHooksSources
    {
        $this->api = $api;
        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): MailChimpWebHooksSources
    {
        $this->admin = $admin;
        return $this;
    }

    public function isSubscriber(): bool
    {
        return $this->subscriber;
    }

    public function setSubscriber(bool $subscriber): MailChimpWebHooksSources
    {
        $this->subscriber = $subscriber;
        return $this;
    }
}
