<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK\Resources;

use Antenna\TeamleaderSDK\Models\Company;
use Antenna\TeamleaderSDK\Models\CompanyId;
use Antenna\TeamleaderSDK\Teamleader;
use function json_decode;
use function time;

class Companies
{
    /** @var Teamleader */
    private $teamleader;

    public function __construct(Teamleader $teamleader)
    {
        $this->teamleader = $teamleader;
    }

    public function getById(CompanyId $id) : Company
    {
        $response = $this->teamleader->makeV2Request('companies.info', ['id' => $id->toV2()]);

        $json = json_decode((string) $response->getBody(), true);

        return new Company($json['data']);
    }

    /**
     * @return Company[]
     */
    public function list() : array
    {
        $response = $this->teamleader->makeV2Request('companies.list');

        $json = json_decode((string) $response->getBody(), true);

        $companies = [];
        foreach ($json['data'] as $companyData) {
            $companies[] = new Company($companyData);
        }

        return $companies;
    }

    public function addNote(CompanyId $companyId, string $title) : void
    {
        $this->teamleader->makeV1Request(
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
