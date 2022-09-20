<?php declare(strict_types = 1);

namespace App\Factory;

use App\Entity\PhoneNumber;
use App\Enum\PhoneNumberFields;

/**
 * @final
 */
class PhoneNumberFactory
{
    public function createFromRequestData(array $requestData): PhoneNumber
    {
        $phoneNumber = new PhoneNumber();
        $phoneNumber->setNumber($requestData[PhoneNumberFields::PHONE_NUMBER]);

        return $phoneNumber;
    }
}