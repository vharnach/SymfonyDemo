<?php

namespace App\Controller;

use App\Entity\PhoneNumber;
use App\Enum\PhoneNumberFields;
use App\Enum\ResponseCodesEnum;
use App\Exception\PhoneNumberNotFoundException;
use App\Exception\PhoneNumberValidationException;
use App\Reader\PhoneNumberReader;
use App\Writer\PhoneNumberWriter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ProjectController extends AbstractController
{
    private PhoneNumberReader $phoneNumberReader;

    private PhoneNumberWriter $phoneNumberWriter;


    public function __construct(PhoneNumberReader $phoneNumberReader, PhoneNumberWriter $phoneNumberWriter)
    {
        $this->phoneNumberReader = $phoneNumberReader;
        $this->phoneNumberWriter = $phoneNumberWriter;
    }


    /**
     * @Route("/phone-number", name="project_index", methods={"GET"})
     */
    public function index(): Response
    {
        $phoneNumbers = $this->phoneNumberReader->getAll();

        $data = [];
        foreach ($phoneNumbers as $phoneNumber) {
            $data[] = $this->getPhoneNumberView($phoneNumber);
        }

        return $this->json($data);
    }


    /**
     * @Route("/phone-number", name="project_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        try {
            $phoneNumber = $this->phoneNumberWriter->create(json_decode($request->getContent(), true));
        } catch (PhoneNumberValidationException $exception) {
            return $this->json($exception->getMessage(), ResponseCodesEnum::BAD_REQUEST);
        }

        return $this->json(
            'Created new phone number successfully with id ' . $phoneNumber->getId(),
            ResponseCodesEnum::CREATED
        );
    }


    /**
     * @Route("/phone-number/{id}", name="project_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        try {
            $phoneNumber = $this->phoneNumberReader->getById($id);
        } catch (PhoneNumberNotFoundException $exception) {
            return $this->json($exception->getMessage(), ResponseCodesEnum::NOT_FOUND);
        }

        return $this->json($this->getPhoneNumberView($phoneNumber));
    }


    /**
     * @Route("/phone-number/{id}", name="project_edit", methods={"PUT", "PATCH"})
     */
    public function edit(Request $request, int $id): Response
    {
        try {
            $phoneNumber = $this->phoneNumberWriter->edit($id, json_decode($request->getContent(), true));
        } catch (PhoneNumberValidationException $exception) {
            return $this->json($exception->getMessage(), ResponseCodesEnum::BAD_REQUEST);
        } catch (PhoneNumberNotFoundException $exception) {
            return $this->json($exception->getMessage(), ResponseCodesEnum::NOT_FOUND);
        }

        return $this->json($this->getPhoneNumberView($phoneNumber));
    }


    /**
     * @Route("/phone-number/{id}", name="project_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        try {
            $this->phoneNumberWriter->delete($id);
        } catch (PhoneNumberNotFoundException $exception) {
            return $this->json($exception->getMessage(), ResponseCodesEnum::NOT_FOUND);
        }

        return $this->json('Deleted a phone number successfully with id ' . $id);
    }


    /**
     * TODO Could be extracted to separate class
     */
    private function getPhoneNumberView(PhoneNumber $phoneNumber): array
    {
        return [
            PhoneNumberFields::ID => $phoneNumber->getId(),
            PhoneNumberFields::PHONE_NUMBER => $phoneNumber->getNumber(),
        ];
    }
}