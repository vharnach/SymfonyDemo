<?php

namespace App\Controller;

use App\Entity\PhoneNumber;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class PhoneNumberController extends AbstractController
{
    /**
     * @Route("/phone-numbers", name="phone_number_index", methods={"GET"})
     */
    public function index(): Response
    {
        $phoneNumbers = $this->getDoctrine()
            ->getRepository(PhoneNumber::class)
            ->findAll();

        $data = [];

        foreach ($phoneNumbers as $phoneNumber) {
            $data[] = [
                'id' => $phoneNumber->getId(),
                'code' => $phoneNumber->getCode(),
                'number' => $phoneNumber->getNumber(),
            ];
        }

        return $this->json($data);
    }


    /**
     * @Route("/phone-number", name="phone_number_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $phoneNumber = new PhoneNumber();
        $phoneNumber->setCode($request->request->get('code'));
        $phoneNumber->setNumber($request->request->get('number'));

        $entityManager->persist($phoneNumber);
        $entityManager->flush();

        return $this->json(
            sprintf('New phone number added: +%d %d', $phoneNumber->getCode(), $phoneNumber->getNumber())
        );
    }


    /**
     * @Route("/phone-number/{id}", name="phone_number_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $phoneNumber = $this->getDoctrine()
            ->getRepository(PhoneNumber::class)
            ->find($id);

        if (!$phoneNumber) {
            return $this->json('No phone number found for id' . $id, 404);
        }

        $data = [
            'id' => $phoneNumber->getId(),
            'code' => $phoneNumber->getCode(),
            'number' => $phoneNumber->getNumber(),
        ];

        return $this->json($data);
    }


    /**
     * @Route("/phone-number/{id}", name="phone_number_edit", methods={"PUT", "PATCH"})
     */
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $phoneNumber = $entityManager->getRepository(PhoneNumber::class)->find($id);

        if (!$phoneNumber) {
            return $this->json('No phone number found for id' . $id, 404);
        }

        $content = json_decode($request->getContent());

        $phoneNumber->setCode($content->code);
        $phoneNumber->setNumber($content->number);
        $entityManager->flush();

        $data = [
            'id' => $phoneNumber->getId(),
            'code' => $phoneNumber->getCode(),
            'number' => $phoneNumber->getNumber(),
        ];

        return $this->json($data);
    }


    /**
     * @Route("/phone-number/{id}", name="phone_number_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $phoneNumber = $entityManager->getRepository(PhoneNumber::class)->find($id);

        if (!$phoneNumber) {
            return $this->json('No phone number found for id' . $id, 404);
        }

        $entityManager->remove($phoneNumber);
        $entityManager->flush();

        return $this->json('Deleted a project successfully with id ' . $id);
    }
}
