<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK;

use Antenna\TeamleaderSDK\Resources\Companies;

class Teamleader
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function companies() : Companies
    {
        return new Companies($this->connection);
    }

/*
    public function getCompanyById(string $companyId) : Company
    {
        $request = $this->client->get('https://api.teamleader.eu/companies.list', [
            'headers' => [
                'api_group' => getenv('TEAMLEADER_API_GROUP'),
                'api_secret' => getenv('TEAMLEADER_API_SECRET'),
            ],
            'form_params' => [
                'ids' => [$companyId]
            ],
        ]);

        return json_decode($request->getBody()->getContents());
    }

    public function addNoteToCompany(string $companyId, string $noteTitle, string $noteContent) : void
    {
        // Decode Teamleader company ID to Teamleader API V1 format
        $uuid      = Uuid::fromString($companyId);
        $companyId = $this->uuidifier->decode($uuid);

        $this->client->post('https://app.teamleader.eu/api/addNote.php', [
            'headers' => [
                'api_group' => getenv('TEAMLEADER_API_GROUP'),
                'api_secret' => getenv('TEAMLEADER_API_SECRET'),
            ],
            'form_params' => [
                'object_type' => 'company',
                'object_id' => $companyId,
                'note_title' => $noteTitle,
                'note_extra_information' => $noteContent,
                'note_extra_information_type' => 'HTML',
                'disable_modification' => '1',
                'date' => time(),
            ],
        ]);
    }*/
}
