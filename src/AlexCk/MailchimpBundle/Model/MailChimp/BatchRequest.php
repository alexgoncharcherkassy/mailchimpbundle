<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class BatchRequest implements \JsonSerializable
{
    /**
     * @var ArrayCollection
     */
    private $operations;

    /**
     * BatchRequest constructor.
     */
    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        return [
            'operations' => $this->getOperations()->getValues()
        ];
    }

    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(BatchOperation $operation): BatchRequest
    {
        $this->operations->add($operation);
        return $this;
    }

    public function removeOperation(BatchOperation $operation): BatchRequest
    {
        $this->operations->removeElement($operation);
        return $this;
    }
}
