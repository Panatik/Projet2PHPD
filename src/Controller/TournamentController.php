<?php

namespace App\Controller;

use App\Entity\Tournament;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

final class TournamentController extends AbstractController
{
    #[Route('/api/tournaments', name: 'get_all', methods: 'GET')]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->findAll();
        return $this->json($tournament); //self.json
    }

    #[Route('/api/tournaments', name: 'create', methods: 'POST')]
    public function add_tournament(EntityManagerInterface $em): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->findAll();
        return $this->json($tournament); //self.json
    }

    #[Route('/api/tournaments/{id}', name: 'get', methods: 'GET')]
    public function get_tournament(EntityManagerInterface $em): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->findAll();
        return $this->json($tournament); //self.json
    }

    #[Route('/api/tournaments/{id}', name: 'edit', methods: 'PUT')]
    public function edit_tournament(EntityManagerInterface $em): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->findAll();
        return $this->json($tournament); //self.json
    }

    #[Route('/api/tournaments/{id}', name: 'delete', methods: 'DELETE')]
    public function delete_tournament(EntityManagerInterface $em): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->findAll();
        return $this->json($tournament); //self.json
    }
}
