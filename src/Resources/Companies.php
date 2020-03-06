<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK\Resources;

use Antenna\TeamleaderSDK\Connection;
use Antenna\TeamleaderSDK\Models\CompanyId;
use function time;

class Companies
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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
