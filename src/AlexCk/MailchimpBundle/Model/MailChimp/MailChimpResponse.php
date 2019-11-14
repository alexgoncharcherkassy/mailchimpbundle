<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class MailChimpResponse
{
    /**
     * @var ArrayCollection<ListItem>
     */
    private $lists;

    /**
     * @var ArrayCollection<MailChimpWebHook>
     */
    private $webhooks;

    /**
     * MailChimpResponse constructor.
     */
    public function __construct()
    {
        $this->lists = new ArrayCollection();
        $this->webhooks = new ArrayCollection();
    }

    public function getLists(): Collection
    {
        return $this->lists;
    }

    public function addList(ListItem $list): MailChimpResponse
    {
        $this->getLists()->add($list);

        return $this;
    }

    public function removeList(ListItem $list): MailChimpResponse
    {
        $this->getLists()->removeElement($list);

        return $this;
    }

    public function getWebhooks(): Collection
    {
        return $this->webhooks;
    }

    public function addWebhook(MailChimpWebHook $webhook): MailChimpResponse
    {
        $this->webhooks->add($webhook);

        return $this;
    }

    public function removeWebhook(MailChimpWebHook $webhook): MailChimpResponse
    {
        $this->webhooks->removeElement($webhook);

        return $this;
    }
}
