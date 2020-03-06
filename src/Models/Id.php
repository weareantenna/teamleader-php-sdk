<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK\Models;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Teamleader\Uuidifier\Uuidifier;

abstract class Id
{
    /** @var UuidInterface */
    private $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    abstract protected static function getPrefix() : string;

    public static function fromV1(int $id) : self
    {
        return new static((new Uuidifier())->encode(static::getPrefix(), $id));
    }

    public static function fromV2(string $id) : self
    {
        return new static(Uuid::fromString($id));
    }

    public function toV1() : int
    {
        return (new Uuidifier())->decode($this->uuid);
    }

    public function toV2() : string
    {
        return $this->uuid->toString();
    }
}
