<?php

namespace App\Controller;

use App\Entity\SportMatch;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

final class SportMatchController extends AbstractController
{
    #[Route('/api/tournaments/{id}/sport-matchs', name: 'get_all', methods: 'GET')] 
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $match = $em->getRepository(SportMatch::class)->findAll();
        return $this->json($match); //self.json
    }

    #[Route('/api/tournaments/{id}/sport-matchs', name: 'create', methods: 'POST')] //crée un nv tournois
    public function create_match(EntityManagerInterface $em): JsonResponse
    {
        $match = $em->getRepository(SportMatch::class)->findAll();
        return $this->json($match); //self.json
    }
    
    #[Route('/api/tournaments/{idTournament}/sport-matchs/{idSportMatchs}', name: 'get', methods: 'GET')]
    public function get_match(EntityManagerInterface $em): JsonResponse
    {
        $match = $em->getRepository(SportMatch::class)->findAll();
        return $this->json($match); //self.jsonn
    }

    #[Route('/api/tournaments/{idTournament}/sport-matchs/{idSportMatchs}', name: 'edit', methods: 'PUT')]
    public function edit_match(EntityManagerInterface $em): JsonResponse
    {
        $match = $em->getRepository(SportMatch::class)->findAll();
        return $this->json($match); //self.json
    }

    #[Route('/api/tournaments/{idTournament}/sport-matchs/{idSportMatchs}', name: 'delete', methods: 'DELETE')]
    public function delete_match(EntityManagerInterface $em): JsonResponse
    {
        $match = $em->getRepository(SportMatch::class)->findAll();
        return $this->json($match); //self.json
    }
}
