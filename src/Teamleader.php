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
}
