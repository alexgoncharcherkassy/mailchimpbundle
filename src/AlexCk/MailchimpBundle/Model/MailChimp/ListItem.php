<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class ListItem
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ListItemContact
     */
    private $contact;

    /**
     * @var string
     */
    private $permissionReminder;

    /**
     * @var ListItemCampaignDefaults
     */
    private $campaignDefaults;

    /**
     * @var bool
     */
    private $emailTypeOption;

    /**
     * ListItem constructor.
     */
    public function __construct()
    {
        $this->setEmailTypeOption(false);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): ListItem
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ListItem
    {
        $this->name = $name;
        return $this;
    }

    public function getContact(): ListItemContact
    {
        return $this->contact;
    }

    public function setContact(ListItemContact $contact): ListItem
    {
        $this->contact = $contact;
        return $this;
    }

    public function getPermissionReminder(): string
    {
        return $this->permissionReminder;
    }

    public function setPermissionReminder(string $permissionReminder): ListItem
    {
        $this->permissionReminder = $permissionReminder;
        return $this;
    }

    public function getCampaignDefaults(): ListItemCampaignDefaults
    {
        return $this->campaignDefaults;
    }

    public function setCampaignDefaults(ListItemCampaignDefaults $campaignDefaults): ListItem
    {
        $this->campaignDefaults = $campaignDefaults;
        return $this;
    }

    public function isEmailTypeOption(): bool
    {
        return $this->emailTypeOption;
    }

    public function setEmailTypeOption(bool $emailTypeOption): ListItem
    {
        $this->emailTypeOption = $emailTypeOption;
        return $this;
    }
}
