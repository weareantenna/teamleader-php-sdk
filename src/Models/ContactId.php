<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK\Models;

final class ContactId extends Id
{
    protected static function getPrefix(): string
    {
        return 'ContactId';
    }
}
