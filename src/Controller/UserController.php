<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;


final class UserController extends AbstractController
{
    #[Route('/api/players', name: 'get_all', methods: 'GET')]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(User::class)->findAll();
        return $this->json($user); //self.json
    }

    #[Route('/register', name: 'create', methods: 'POST')]
    public function add_player(EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(User::class)->findAll();
        return $this->json($user); //self.json
    }

    #[Route('/api/players/{id}', name: 'get', methods: 'GET')]
    public function get_player(EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(User::class)->findAll();
        return $this->json($user); //self.json
    }
    
    #[Route('/api/players/{id}', name: 'edit', methods: 'PUT')]
    public function edit_player(EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(User::class)->findAll();
        return $this->json($user); //self.json
    }

    #[Route('/api/players/{id}', name: 'delete', methods: 'DELETE')]
    public function delete_player(EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(User::class)->findAll();
        return $this->json($user); //self.json
    }
}
