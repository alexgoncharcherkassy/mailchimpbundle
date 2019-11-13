<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class MailChimpWebHook
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var MailChimpWebHooksEvent
     */
    private $events;

    /**
     * @var MailChimpWebHooksSources
     */
    private $sources;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): MailChimpWebHook
    {
        $this->id = $id;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): MailChimpWebHook
    {
        $this->url = $url;
        return $this;
    }

    public function getEvents(): MailChimpWebHooksEvent
    {
        return $this->events;
    }

    public function setEvents(MailChimpWebHooksEvent $events): MailChimpWebHook
    {
        $this->events = $events;
        return $this;
    }

    public function getSources(): MailChimpWebHooksSources
    {
        return $this->sources;
    }

    public function setSources(MailChimpWebHooksSources $sources): MailChimpWebHook
    {
        $this->sources = $sources;
        return $this;
    }
}
