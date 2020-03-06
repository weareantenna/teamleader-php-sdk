<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK;

use Antenna\TeamleaderSDK\Resources\Companies;
use Antenna\TeamleaderSDK\Resources\Contacts;

class Teamleader
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function connection() : Connection
    {
        return $this->connection;
    }

    public function companies() : Companies
    {
        return new Companies($this->connection);
    }

    public function contacts() : Contacts
    {
        return new Contacts($this->connection);
    }
}
