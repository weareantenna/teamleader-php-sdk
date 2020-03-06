<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use function array_merge;

final class Connection
{
    /** @var Client */
    private $client;

    /** @var string */
    private $apiV1Group;

    /** @var string */
    private $apiV1Secret;

    /** @var string */
    private $apiV2ClientId;

    /** @var string */
    private $apiV2ClientSecret;

    /** @var string */
    private $accessToken;

    public function __construct(
        string $apiV1Group,
        string $apiV1Secret,
        string $apiV2ClientId,
        string $apiV2ClientSecret
    ) {
        $this->apiV1Group        = $apiV1Group;
        $this->apiV1Secret       = $apiV1Secret;
        $this->apiV2ClientId     = $apiV2ClientId;
        $this->apiV2ClientSecret = $apiV2ClientSecret;
        $this->client            = new Client();
    }

    /**
     * @param array<mixed> $body
     */
    public function makeV1Request(string $uri, array $body = []) : ResponseInterface
    {
         $formParams = array_merge(
             [
                 'api_group' => $this->apiV1Group,
                 'api_secret' => $this->apiV1Secret,
             ],
             $body
         );

         return $this->client->request('POST', 'https://app.teamleader.eu/api/' . $uri, ['form_params' => $formParams]);
    }

    /**
     * @param array<mixed> $body
     */
    public function makeV2Request(string $uri, array $body = []) : ResponseInterface
    {
         return $this->client->request('POST', 'https://api.teamleader.eu/' . $uri, [
             'json' => $body,
             'headers' => [
                 'Authorization' => 'Bearer ' . $this->accessToken,
             ],
         ]);
    }

    public function setAccessToken(string $accessToken) : void
    {
        $this->accessToken = $accessToken;
    }
}
