<?php

declare(strict_types=1);

namespace AlexCk\MailchimpBundle\Service\GuzzleClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\Response;

class GuzzleClientImpl implements GuzzleClient
{
    const CLIENT_USERNAME_EXCEPTION = 'Username not found in config';
    const CLIENT_PASSWORD_EXCEPTION = 'Password not found in config';
    const CLIENT_BASE_URI_EXCEPTION = 'Base URI not found in config';
    const CLIENT_BASE_VERSION_EXCEPTION = 'Version not found in config';

    /** @var Client */
    private $client;

    public function baseAuthentication(GuzzleClientConfig $config): GuzzleClient
    {
        $this->checkConfigBaseAuthentication($config);

        try {
            $this->client = new Client([
                'base_uri' => $config->getBaseUri(),
                'auth' => [$config->getUsername(), $config->getPassword()],
                'headers' => [
                    'Accept' => $config->getAccept(),
                    'Content-Type' => $config->getContentType()
                ]
            ]);
        } catch (ClientException $exception) {
            throw new GuzzleClientException(
                $exception->getCode(),
                $exception->getMessage(),
                $exception->getResponse() ? $exception->getResponse()->getBody()->getContents() : ''
            );
        }

        return $this;
    }

    public function get(string $url, array $options = []): ResponseInterface
    {
        try {
            return $this->client->get($url, $options);
        } catch (ClientException $exception) {
            throw new GuzzleClientException(
                $exception->getCode(),
                $exception->getMessage(),
                $exception->getResponse() ? $exception->getResponse()->getBody()->getContents() : ''
            );
        } catch (Exception $exception) {
            throw new GuzzleClientException(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    public function post(string $url, array $data, array $options = []): ResponseInterface
    {
        try {
            return $this->client->post($url, array_merge([
                RequestOptions::JSON => $data
            ], $options));
        } catch (ClientException $exception) {
            throw new GuzzleClientException(
                $exception->getCode(),
                $exception->getMessage(),
                $exception->getResponse() ? $exception->getResponse()->getBody()->getContents() : ''
            );
        } catch (Exception $exception) {
            throw new GuzzleClientException(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    public function put(string $url, array $data, array $options = []): ResponseInterface
    {
        try {
            return $this->client->put($url, array_merge([
                RequestOptions::JSON => $data
            ], $options));
        } catch (ClientException $exception) {
            throw new GuzzleClientException(
                $exception->getCode(),
                $exception->getMessage(),
                $exception->getResponse() ? $exception->getResponse()->getBody()->getContents() : ''
            );
        } catch (Exception $exception) {
            throw new GuzzleClientException(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    public function delete(string $url, array $data, array $options = []): ResponseInterface
    {
        try {
            return $this->client->delete($url, array_merge([
                RequestOptions::JSON => $data
            ], $options));
        } catch (ClientException $exception) {
            throw new GuzzleClientException(
                $exception->getCode(),
                $exception->getMessage(),
                $exception->getResponse() ? $exception->getResponse()->getBody()->getContents() : ''
            );
        } catch (Exception $exception) {
            throw new GuzzleClientException(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    private function checkConfigBaseAuthentication(GuzzleClientConfig $config): void
    {
        if (!$config->getUsername()) {
            throw new GuzzleClientException(Response::HTTP_INTERNAL_SERVER_ERROR, self::CLIENT_USERNAME_EXCEPTION);
        } elseif (!$config->getPassword()) {
            throw new GuzzleClientException(Response::HTTP_INTERNAL_SERVER_ERROR, self::CLIENT_PASSWORD_EXCEPTION);
        } elseif (!$config->getBaseUri()) {
            throw new GuzzleClientException(Response::HTTP_INTERNAL_SERVER_ERROR, self::CLIENT_BASE_URI_EXCEPTION);
        } elseif (!$config->getVersion()) {
            throw new GuzzleClientException(Response::HTTP_INTERNAL_SERVER_ERROR, self::CLIENT_BASE_VERSION_EXCEPTION);
        }
    }
}
