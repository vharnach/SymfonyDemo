<?php

namespace App\Reader;

use App\Entity\PhoneNumber;
use App\Exception\PhoneNumberNotFoundException;
use App\Repository\NumberRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PhoneNumberReader
{
    private NumberRepository $phoneNumberRepository;

    public function __construct(NumberRepository $phoneNumberRepository)
    {
        $this->phoneNumberRepository = $phoneNumberRepository;
    }


    /**
     * @return PhoneNumber[]
     */
    public function getAll(): array
    {
        return $this->phoneNumberRepository
            ->findAll();
    }


    /**
     * @throws PhoneNumberNotFoundException
     */
    public function getById(int $id): PhoneNumber
    {
        $phoneNumber = $this->phoneNumberRepository
            ->find($id);

        if ($phoneNumber === null) {
           throw PhoneNumberNotFoundException::byId($id);
        }

        return $phoneNumber;
    }
}
