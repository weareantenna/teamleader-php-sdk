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

    /**
     * @param array<mixed> $emails
     * @param array<mixed> $telephones
     * @param array<mixed> $addresses
     * @param array<mixed> $tags
     * @param array<mixed> $customFields
     */
    public function add(
        string $name,
        ?string $businessTypeId = null,
        ?string $vatNumber = null,
        ?string $nationalIdentificationNumber = null,
        ?array $emails = [],
        ?array $telephones = [],
        ?string $website = null,
        ?array $addresses = [],
        ?string $iban = null,
        ?string $bic = null,
        ?string $language = null,
        ?string $responsibleUserId = null,
        ?string $remarks = null,
        ?array $tags = [],
        ?array $customFields = [],
        bool $marketingMailsConsent = false
    ) : void {
        $this->connection->makeV2Request('companies.add', [
            'name' => $name,
            'business_type_id' => $businessTypeId,
            'vat_number' => $vatNumber,
            'national_identification_number' => $nationalIdentificationNumber,
            'emails' => $emails,
            'telephones' => $telephones,
            'website' => $website,
            'addresses' => $addresses,
            'iban' => $iban,
            'bic' => $bic,
            'language' => $language,
            'responsible_user_id' => $responsibleUserId,
            'remarks' => $remarks,
            'tags' => $tags,
            'custom_fields' => $customFields,
            'marketing_mails_consent' => $marketingMailsConsent,
        ]);
    }

    public function delete(CompanyId $companyId) : void
    {
        $this->connection->makeV2Request('companies.delete', [
            'id' => $companyId->toV2(),
        ]);
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
