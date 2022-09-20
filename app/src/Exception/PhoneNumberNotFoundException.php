<?php declare(strict_types = 1);

namespace App\Exception;

use Exception;

/**
 * @final
 */
class PhoneNumberNotFoundException extends Exception
{
    public static function byId(int $phoneNumberId): self
    {
        return new self(sprintf('Phone Number %d not found.', $phoneNumberId));
    }
}