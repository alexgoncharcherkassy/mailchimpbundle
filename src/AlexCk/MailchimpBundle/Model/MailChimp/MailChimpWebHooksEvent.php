<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class MailChimpWebHooksEvent
{
    /**
     * @var bool
     */
    private $subscribe;

    /**
     * @var bool
     */
    private $unsubscribe;

    /**
     * @var bool
     */
    private $profile;

    public function isSubscribe(): bool
    {
        return $this->subscribe;
    }

    public function setSubscribe(bool $subscribe): MailChimpWebHooksEvent
    {
        $this->subscribe = $subscribe;
        return $this;
    }

    public function isUnsubscribe(): bool
    {
        return $this->unsubscribe;
    }

    public function setUnsubscribe(bool $unsubscribe): MailChimpWebHooksEvent
    {
        $this->unsubscribe = $unsubscribe;
        return $this;
    }

    public function isProfile(): bool
    {
        return $this->profile;
    }

    public function setProfile(bool $profile): MailChimpWebHooksEvent
    {
        $this->profile = $profile;
        return $this;
    }
}
