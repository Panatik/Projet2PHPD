<?php

namespace App\Controller;

use App\Entity\Registration;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

final class RegistrationController extends AbstractController
{
    #[Route('/api/tournaments/{id}/registrations', name: 'get_all', methods: 'GET')]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $register = $em->getRepository(Registration::class)->findAll();
        return $this->json($register); //self.json
    }

    #[Route('/api/tournaments/{id}/registrations', name: 'create', methods: 'POST')]
    public function add_register(EntityManagerInterface $em): JsonResponse
    {
        $register = $em->getRepository(Registration::class)->findAll();
        return $this->json($register); //self.json
    }

    #[Route('/api/tournaments/{idTournament}/registrations/{idRegistration}', name: 'delete', methods: 'DELETE')]
    public function delete_register(EntityManagerInterface $em): JsonResponse
    {
        $register = $em->getRepository(Registration::class)->findAll();
        return $this->json($register); //self.json
    }
}
