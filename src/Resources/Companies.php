<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK\Resources;

use Antenna\TeamleaderSDK\Connection;
use Antenna\TeamleaderSDK\Models\Company;
use Antenna\TeamleaderSDK\Models\CompanyId;
use Exception;
use function count;
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
        $companies = $this->list(['ids' => [$id->toV2()]]);

        if (count($companies) === 1) {
            return $companies[0];
        }

        throw new Exception('uhoh');
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
        $response = $this->connection->makeV2Request('companies.add', [
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
