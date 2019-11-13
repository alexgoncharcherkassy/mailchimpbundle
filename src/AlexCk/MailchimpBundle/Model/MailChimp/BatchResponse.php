<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class BatchResponse
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $totalOperations;

    /**
     * @var int
     */
    private $finishedOperations;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): BatchResponse
    {
        $this->id = $id;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): BatchResponse
    {
        $this->status = $status;
        return $this;
    }

    public function getTotalOperations(): int
    {
        return $this->totalOperations;
    }

    public function setTotalOperations(int $totalOperations): BatchResponse
    {
        $this->totalOperations = $totalOperations;
        return $this;
    }

    public function getFinishedOperations(): int
    {
        return $this->finishedOperations;
    }

    public function setFinishedOperations(int $finishedOperations): BatchResponse
    {
        $this->finishedOperations = $finishedOperations;
        return $this;
    }
}
