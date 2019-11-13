<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class MailChimpWebhookDataMergeFieldsRequest
{
    /**
     * @var string
     */
    private $FNAME;

    /**
     * @var string
     */
    private $LNAME;

    public function getFNAME(): string
    {
        return $this->FNAME;
    }

    /**
     * @param string $FNAME
     * @return MailChimpWebhookDataMergeFieldsRequest
     */
    public function setFNAME(string $fName): MailChimpWebhookDataMergeFieldsRequest
    {
        $this->FNAME = $fName;
        return $this;
    }

    public function getLNAME(): string
    {
        return $this->LNAME;
    }

    public function setLNAME(string $lName): MailChimpWebhookDataMergeFieldsRequest
    {
        $this->LNAME = $lName;
        return $this;
    }
}

