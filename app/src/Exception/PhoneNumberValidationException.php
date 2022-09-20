<?php declare(strict_types = 1);

namespace App\Exception;

use Exception;

/**
 * @final
 */
class PhoneNumberValidationException extends Exception
{
    public static function byValidationErrors(string $validationErrors): self
    {
        return new self($validationErrors);
    }
}