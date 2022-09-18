<?php

namespace App\Controller;

use App\Entity\PhoneNumber;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/phone-number", name="project_index", methods={"GET"})
     */
    public function index(): Response
    {
        $phoneNumbers = $this->getDoctrine()
            ->getRepository(PhoneNumber::class)
            ->findAll();

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
        $entityManager = $this->getDoctrine()->getManager();

        $phoneNumber = new PhoneNumber();
        $phoneNumber->setNumber($request->request->get('phoneNumber'));

        $entityManager->persist($phoneNumber);
        $entityManager->flush();

        return $this->json('Created new phone number successfully with id ' . $phoneNumber->getId());
    }


    /**
     * @Route("/phone-number/{id}", name="project_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $phoneNumber = $this->getDoctrine()
            ->getRepository(PhoneNumber::class)
            ->find($id);

        if (!$phoneNumber) {
            return $this->sendNoPhoneNumberFound($id);
        }

        return $this->json($this->getPhoneNumberView($phoneNumber));
    }


    /**
     * @Route("/phone-number/{id}", name="project_edit", methods={"PUT", "PATCH"})
     */
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $phoneNumber = $entityManager->getRepository(PhoneNumber::class)->find($id);

        if (!$phoneNumber) {
            return $this->sendNoPhoneNumberFound($id);
        }

        $content = json_decode($request->getContent());

        $phoneNumber->setNumber($content->phoneNumber);
        $entityManager->flush();

        return $this->json($this->getPhoneNumberView($phoneNumber));
    }


    /**
     * @Route("/phone-number/{id}", name="project_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $phoneNumber = $entityManager->getRepository(PhoneNumber::class)->find($id);

        if (!$phoneNumber) {
            return $this->sendNoPhoneNumberFound($id);
        }

        $entityManager->remove($phoneNumber);
        $entityManager->flush();

        return $this->json('Deleted a phone number successfully with id ' . $id);
    }


    private function getPhoneNumberView(PhoneNumber $phoneNumber): array
    {
        return [
            'id' => $phoneNumber->getId(),
            'phoneNumber' => $phoneNumber->getNumber(),
        ];
    }


    private function sendNoPhoneNumberFound(int $id): JsonResponse
    {
        return $this->json('No phone number found for id' . $id, 404);
    }
}