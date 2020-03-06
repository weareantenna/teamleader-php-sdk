<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK\Resources;

use Antenna\TeamleaderSDK\Models\Contact;
use Antenna\TeamleaderSDK\Models\ContactId;
use Antenna\TeamleaderSDK\Teamleader;
use function json_decode;
use function time;

class Contacts
{
    /** @var Teamleader */
    private $teamleader;

    public function __construct(Teamleader $teamleader)
    {
        $this->teamleader = $teamleader;
    }

    public function getById(ContactId $id) : Contact
    {
        $response = $this->teamleader->makeV2Request('contacts.info', ['id' => $id->toV2()]);

        return new Contact(json_decode((string) $response->getBody(), true)['data']);
    }

    /**
     * @param array<mixed> $filter
     *
     * @return Contact[]
     */
    public function list(array $filter = []) : array
    {
        $response = $this->teamleader->makeV2Request('contacts.list', ['filter' => $filter]);

        $json = json_decode((string) $response->getBody(), true);

        $contacts = [];
        foreach ($json['data'] as $contactData) {
            $contacts[] = new Contact($contactData);
        }

        return $contacts;
    }

    /**
     * @param array<mixed> $emails
     * @param array<mixed> $telephones
     * @param array<mixed> $addresses
     * @param array<mixed> $tags
     * @param array<mixed> $custom_fields
     */
    public function add(
        string $lastName,
        ?string $first_name = null,
        ?array $emails = [],
        ?string $salutation = null,
        ?array $telephones = [],
        ?string $website = null,
        ?array $addresses = [],
        ?string $language = null,
        ?string $gender = null,
        ?string $birthdate = null,
        ?string $iban = null,
        ?string $bic = null,
        ?string $national_identification_number = null,
        ?string $remarks = null,
        ?array $tags = [],
        ?array $custom_fields = [],
        ?bool $marketing_mails_consent = false
    ) : void {
        $this->connection->makeV2Request('contacts.add', [
            'last_name' => $lastName,
            'first_name' => $first_name,
            'emails' => $emails,
            'salutation' => $salutation,
            'telephones' => $telephones,
            'website' => $website,
            'addresses' => $addresses,
            'language' => $language,
            'gender' => $gender,
            'birthdate' => $birthdate,
            'iban' => $iban,
            'bic' => $bic,
            'national_identification_number' => $national_identification_number,
            'remarks' => $remarks,
            'tags' => $tags,
            'custom_fields' => $custom_fields,
            'marketing_mails_consent' => $marketing_mails_consent
        ]);
    }

    public function delete(ContactId $contactId) : void
    {
        $this->connection->makeV2Request('contacts.delete', [
            'id' => $contactId->toV2(),
        ]);
    }

    public function addNote(ContactId $contactId, string $title) : void
    {
        $this->teamleader->makeV1Request(
            'addNote.php',
            [
                'object_type' => 'contact',
                'object_id' => $contactId->toV1(),
                'note_title' => $title,
                // 'note_extra_information' => '',
                // 'note_extra_information_type' => 'HTML',
                // 'disable_modification' => 1,
                'date' => time(),
            ]
        );
    }
}
