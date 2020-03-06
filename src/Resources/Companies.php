<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK\Resources;

use Antenna\TeamleaderSDK\Connection;
use Antenna\TeamleaderSDK\Models\Company;
use Antenna\TeamleaderSDK\Models\CompanyId;
use function json_decode;
use function time;

class Companies
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getById(CompanyId $id) : Company
    {
        $response = $this->connection->makeV2Request('companies.info', ['id' => $id->toV2()]);

        $json = json_decode((string) $response->getBody(), true);

        return new Company($json['data']);
    }

    /**
     * @param array<mixed> $filter
     *
     * @return Company[]
     */
    public function list(array $filter = []) : array
    {
        $response = $this->connection->makeV2Request('companies.list', ['filter' => $filter]);

        $json = json_decode((string) $response->getBody(), true);

        $companies = [];
        foreach ($json['data'] as $companyData) {
            $companies[] = new Company($companyData);
        }

        return $companies;
    }

    public function addNote(CompanyId $companyId, string $title) : void
    {
        $this->connection->makeV1Request(
            'addNote.php',
            [
                'object_type' => 'company',
                'object_id' => $companyId->toV1(),
                'note_title' => $title,
                // 'note_extra_information' => '',
                // 'note_extra_information_type' => 'HTML',
                // 'disable_modification' => 1,
                'date' => time(),
            ]
        );
    }
}
