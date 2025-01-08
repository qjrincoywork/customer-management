<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * SortTarget class.
 * Represents the sort target options for sorting data.
 */
final class SortTarget extends Enum
{
    public const FIRST_NAME = 'first_name';
    public const LAST_NAME = 'last_name';
    public const EMAIL = 'email';
    public const DATE_CREATED = 'created_at';
}
