<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Model\MailChimp;

class ListItemContact
{
    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $address1;

    /**
     * @var string
     */
    private $address2;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $phone;

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setCompany(string $company): ListItemContact
    {
        $this->company = $company;
        return $this;
    }

    public function getAddress1(): string
    {
        return $this->address1;
    }

    public function setAddress1(string $address1): ListItemContact
    {
        $this->address1 = $address1;
        return $this;
    }

    public function getAddress2(): string
    {
        return $this->address2;
    }

    public function setAddress2(string $address2): ListItemContact
    {
        $this->address2 = $address2;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): ListItemContact
    {
        $this->city = $city;
        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): ListItemContact
    {
        $this->state = $state;
        return $this;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip(string $zip): ListItemContact
    {
        $this->zip = $zip;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): ListItemContact
    {
        $this->country = $country;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): ListItemContact
    {
        $this->phone = $phone;
        return $this;
    }
}
