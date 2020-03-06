<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK\Models;

final class Company
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

    public function id() : CompanyId
    {
        return CompanyId::fromV2($this->data['id']);
    }

    public function name() : string
    {
        return $this->data['name'];
    }
}
