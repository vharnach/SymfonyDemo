<?php declare(strict_types = 1);

namespace App\Validator;

use App\Enum\PhoneNumberFields;
use App\Exception\PhoneNumberValidationException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @final
 */
class PhoneNumberValidator
{
    private ValidatorInterface $validator;


    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }


    /**
     * @throws PhoneNumberValidationException
     */
    public function validate(array $phoneNumberData): void
    {
        $errors = $this->validator->validate($phoneNumberData, $this->getConstraints());

        if (count($errors) > 0) {
            throw PhoneNumberValidationException::byValidationErrors((string)$errors);
        }
    }


    /**
     * @return Constraint[]
     */
    private function getConstraints(): array
    {
        return [
            new Collection([
                PhoneNumberFields::PHONE_NUMBER => [
                    new Required(),
                    new Length(
                        null,
                        3,
                        9,
                        null,
                        null,
                        null,
                        'Phone number must be at least 3 digits long',
                        'Phone number must not be longer than 9 digits',
                    ),
                    new Type('digit')
                ]
            ]),
        ];
    }
}