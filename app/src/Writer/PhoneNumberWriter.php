<?php declare(strict_types = 1);

namespace App\Writer;

use App\Entity\PhoneNumber;
use App\Enum\PhoneNumberFields;
use App\Exception\PhoneNumberNotFoundException;
use App\Exception\PhoneNumberValidationException;
use App\Factory\PhoneNumberFactory;
use App\Reader\PhoneNumberReader;
use App\Validator\PhoneNumberValidator;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * @final
 */
class PhoneNumberWriter
{
    private EntityManagerInterface $entityManager;

    private PhoneNumberReader $phoneNumberReader;

    private PhoneNumberValidator $phoneNumberValidator;

    private PhoneNumberFactory $phoneNumberFactory;

    private LoggerInterface $logger;


    public function __construct(
        EntityManagerInterface $entityManager,
        PhoneNumberReader $phoneNumberReader,
        PhoneNumberValidator $phoneNumberValidator,
        PhoneNumberFactory $phoneNumberFactory,
        LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->phoneNumberReader = $phoneNumberReader;
        $this->phoneNumberValidator = $phoneNumberValidator;
        $this->phoneNumberFactory = $phoneNumberFactory;
        $this->logger = $logger;
    }


    /**
     * @throws PhoneNumberValidationException
     */
    public function create(array $requestData): PhoneNumber
    {
        $this->phoneNumberValidator->validate($requestData);
        $phoneNumber = $this->phoneNumberFactory->createFromRequestData($requestData);

        $this->entityManager->persist($phoneNumber);
        $this->entityManager->flush();

        return $phoneNumber;
    }


    /**
     * @throws PhoneNumberValidationException
     * @throws PhoneNumberNotFoundException
     */
    public function edit(int $phoneNumberId, array $requestData): PhoneNumber
    {
        $this->phoneNumberValidator->validate($requestData);
        $phoneNumber = $this->phoneNumberReader->getById($phoneNumberId);

        $phoneNumber->setNumber($requestData[PhoneNumberFields::PHONE_NUMBER]);

        $this->entityManager->persist($phoneNumber);
        $this->entityManager->flush();

        return $phoneNumber;
    }


    /**
     * @throws PhoneNumberNotFoundException
     */
    public function delete(int $phoneNumberId): void
    {
        $phoneNumber = $this->phoneNumberReader->getById($phoneNumberId);

        $this->entityManager->remove($phoneNumber);
        $this->entityManager->flush();
    }
}