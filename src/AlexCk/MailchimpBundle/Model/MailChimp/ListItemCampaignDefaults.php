<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class ListItemCampaignDefaults
{
    /**
     * @var string
     */
    private $fromName;

    /**
     * @var string
     */
    private $fromEmail;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $language;

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function setFromName(string $fromName): ListItemCampaignDefaults
    {
        $this->fromName = $fromName;
        return $this;
    }

    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    public function setFromEmail(string $fromEmail): ListItemCampaignDefaults
    {
        $this->fromEmail = $fromEmail;
        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): ListItemCampaignDefaults
    {
        $this->subject = $subject;
        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): ListItemCampaignDefaults
    {
        $this->language = $language;
        return $this;
    }
}
