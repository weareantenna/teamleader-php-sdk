<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK\Models;

final class Contact
{
    /** @var array<mixed> */
    private $data;

    /**
     * @param array<mixed> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function id() : ContactID
    {
        return ContactID::fromV2($this->data['id']);
    }

    public function firstName() : string
    {
        return $this->data['first_name'];
    }

    public function lastName() : string
    {
        return $this->data['last_name'];
    }
}
