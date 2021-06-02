<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK;

use Antenna\TeamleaderSDK\Resources\Companies;
use Antenna\TeamleaderSDK\Resources\Contacts;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use function array_merge;
use function http_build_query;

class Teamleader
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

        return $this->client->request('POST', 'https://focus.teamleader.eu/api/' . $uri, ['form_params' => $formParams]);
    }

    /**
     * @param array<mixed> $body
     */
    public function makeV2Request(string $uri, array $body = []) : ResponseInterface
    {
        return $this->client->request('POST', 'https://api.focus.teamleader.eu/' . $uri, [
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

    public function companies() : Companies
    {
        return new Companies($this);
    }

    public function contacts() : Contacts
    {
        return new Contacts($this);
    }

    public function getAuthorizationUrl(string $redirectUri, ?string $state = null) : string
    {
        $params = [
            'client_id' => $this->apiV2ClientId,
            'response_type' => 'code',
            'redirect_uri' => $redirectUri,
        ];

        if ($state) {
            $params['state'] = $state;
        }

        return 'https://focus.teamleader.eu/oauth2/authorize?'
            . http_build_query($params);
    }
}
