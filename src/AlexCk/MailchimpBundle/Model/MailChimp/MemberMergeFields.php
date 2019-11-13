<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class MemberMergeFields implements \JsonSerializable
{
    /**
     * @var string
     */
    private $fName;

    /**
     * @var string
     */
    private $lName;

    public function jsonSerialize()
    {
        return [
            'FNAME' => $this->getFName(),
            'LNAME' => $this->getLName()
        ];
    }

    public function getFName(): string
    {
        return $this->fName;
    }

    public function setFName(string $fName): MemberMergeFields
    {
        $this->fName = $fName;
        return $this;
    }

    public function getLName(): string
    {
        return $this->lName;
    }

    public function setLName(s $lName): MemberMergeFields
    {
        $this->lName = $lName;
        return $this;
    }
}
