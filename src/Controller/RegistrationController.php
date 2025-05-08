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
    #[Route('/api/tournaments/{id}/registrations', name: 'get_all_register', methods: 'GET')]
    public function get_register(Tournament $tournament, RegistrationRepository $registrationRepo): JsonResponse
    {
        $registrations = $registrationRepo->findBy(['tournament' => $tournament]);
        return $this->json($registrations, 200, [], ['groups' => 'registration:read']);
    }

    #[Route('/api/tournaments/{id}/registrations', name: 'create_register', methods: 'POST')]
    public function add_register(Request $request, Tournament $tournament, EntityManagerInterface $em, UserRepository $userRepo): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['playerId'])) {
            return $this->json(['error' => 'Missing playerId'], 400);
        }
    
        $player = $userRepo->find($data['playerId']);
        if (!$player) {
            return $this->json(['error' => 'User not found'], 404);
        }
    
        // Empêcher la double inscription
        $existing = $em->getRepository(Registration::class)->findOneBy([
            'player' => $player,
            'tournament' => $tournament
        ]);
        if ($existing) {
            return $this->json(['error' => 'Player already registered'], 409);
        }
    
        $registration = new Registration();
        $registration->setPlayer($player);
        $registration->setTournament($tournament);
        $registration->setRegistrationDate(new \DateTime());
        $registration->setStatus('en attente'); // ou 'confirmée'
    
        $em->persist($registration);
        $em->flush();
    
        return $this->json($registration, 201, [], ['groups' => 'registration:read']);
    }

    #[Route('/api/tournaments/{idTournament}/registrations/{idRegistration}', name: 'delete_register', methods: 'DELETE')]
    public function delete_register(Tournament $tournament, Registration $registration, EntityManagerInterface $em): JsonResponse
    {
        if ($registration->getTournament()->getId() !== $tournament->getId()) {
            return $this->json(['error' => 'Registration does not belong to this tournament'], 400);
        }
    
        $em->remove($registration);
        $em->flush();
    
        return $this->json(['message' => 'Registration deleted'], 200);
    }
}
