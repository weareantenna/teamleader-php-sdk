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
