<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class Member
{
    const MEMBER_STATUS_SUBSCRIBED = 'subscribed';
    const MEMBER_STATUS_UNSUBSCRIBED = 'unsubscribed';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $status;

    /**
     * @var MemberMergeFields
     */
    private $mergeFields;

    /**
     * Member constructor.
     */
    public function __construct()
    {
        $this->setStatus(self::MEMBER_STATUS_SUBSCRIBED);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Member
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Member
    {
        $this->email = $email;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): Member
    {
        $this->status = $status;
        return $this;
    }

    public function getMergeFields(): MemberMergeFields
    {
        return $this->mergeFields;
    }

    public function setMergeFields(MemberMergeFields $mergeFields): Member
    {
        $this->mergeFields = $mergeFields;
        return $this;
    }
}
