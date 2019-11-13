<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Service\MailChimp;

use AlexCk\MailchimpBundle\Model\MailChimp\BatchResponse;
use AlexCk\MailchimpBundle\Model\MailChimp\ListItem;
use AlexCk\MailchimpBundle\Model\MailChimp\MailChimpResponse;
use AlexCk\MailchimpBundle\Model\MailChimp\MailChimpWebHook;
use AlexCk\MailchimpBundle\Model\MailChimp\Member;

interface MailChimpClient
{
    public function configure(string $username, string $key, string $version): MailChimpClient;

    public function createList(ListItem $listItem): ListItem;

    public function getLists(): MailChimpResponse;

    public function createMember(Member $member, string $listId, ?string $unsubscribeUrl);

    public function updateMember(Member $member, string $listId, string $oldEmail, ?string $unsubscribeUrl);

    public function deleteMember(Member $member, string $listId): bool ;

    public function listWebHookEvent(string $listId): MailChimpResponse;

    public function createWebHookEventUnsubscribe(string $listId, string $unsubscribeUrl): MailChimpWebHook;

    public function createBatchMember(string $listId, iterable $members, ?string $unsubscribeUrl): BatchResponse;
}