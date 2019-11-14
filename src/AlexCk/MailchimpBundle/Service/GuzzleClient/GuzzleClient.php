<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Service\GuzzleClient;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

interface GuzzleClient
{
    public function baseAuthentication(GuzzleClientConfig $config): GuzzleClient;

    public function get(string $url, array $options = []): ResponseInterface;

    public function post(string $url, array $data, array $options = []): ResponseInterface;

    public function put(string $url, array $data, array $options = []): ResponseInterface;

    public function delete(string $url, array $data, array $options = []): ResponseInterface;
}
