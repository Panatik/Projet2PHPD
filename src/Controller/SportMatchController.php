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
    #[Route('/api/tournaments/{id}/sport-matchs', name: 'get_all_match', methods: 'GET')]
    public function get_matches(Tournament $tournament): JsonResponse
    {
        $matches = $tournament->getSportMatches();
        return $this->json($matches, 200, [], ['groups' => 'match:read']);
    }

    #[Route('/api/tournaments/{id}/sport-matchs', name: 'create_match', methods: 'POST')]
    public function create_match(Request $request, Tournament $tournament, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $player1 = $em->getRepository(User::class)->find($data['player1']);
        $player2 = $em->getRepository(User::class)->find($data['player2']);
    
        if (!$player1 || !$player2) {
            return $this->json(['error' => 'Player not found'], 404);
        }
    
        $repo = $em->getRepository(Registration::class);
        foreach ([$player1, $player2] as $player) {
            $registration = $repo->findOneBy(['player' => $player, 'tournament' => $tournament, 'status' => 'confirmée']);
            if (!$registration) {
                return $this->json(['error' => 'Player not registered to this tournament'], 403);
            }
        }
    
        $match = new SportMatch();
        $match->setTournament($tournament)
              ->setPlayer1($player1)
              ->setPlayer2($player2)
              ->setMatchDate(new \DateTime())
              ->setStatus('en attente');
    
        $em->persist($match);
        $em->flush();
    
        return $this->json(['message' => 'Match created'], 201);
    }
    
    #[Route('/api/tournaments/{idTournament}/sport-matchs/{idSportMatchs}', name: 'get_match', methods: 'GET')]
    public function get_match(Tournament $tournament, SportMatch $match): JsonResponse
    {
        if ($match->getTournament()->getId() !== $tournament->getId()) {
            return $this->json(['error' => 'Le match ne correspond pas à ce tournoi'], 400);
        }
    
        return $this->json($match, 200, [], ['groups' => 'match:read']);
    }

    #[Route('/api/tournaments/{idTournament}/sport-matchs/{idSportMatchs}', name: 'edit', methods: 'PUT')]
    public function edit_match(Request $request, UserInterface $user, Tournament $tournament, SportMatch $match, EntityManagerInterface $em, NotificationService $notificationService): JsonResponse
    {
        if ($match->getTournament()->getId() !== $tournament->getId()) {
            return $this->json(['error' => 'Match does not belong to this tournament'], 400);
        }
    
        // Vérifier que c'est un admin ou un des deux joueurs
        $isAdmin = in_array('ROLE_ADMIN', $user->getRoles());
        $isPlayer1 = $user === $match->getPlayer1();
        $isPlayer2 = $user === $match->getPlayer2();
    
        if (!$isAdmin && !$isPlayer1 && !$isPlayer2) {
            return $this->json(['error' => 'Unauthorized to modify this match'], 403);
        }
    
        $data = json_decode($request->getContent(), true);
    
        if ($isPlayer1 || $isAdmin) {
            if (array_key_exists('scorePlayer1', $data)) {
                $match->setScorePlayer1($data['scorePlayer1']);
                if (!$isAdmin && !$match->getScorePlayer2()) {
                    $notificationService->sendScoreReminder($match->getPlayer2(), $match);
                }
            }
        }
    
        if ($isPlayer2 || $isAdmin) {
            if (array_key_exists('scorePlayer2', $data)) {
                $match->setScorePlayer2($data['scorePlayer2']);
                if (!$isAdmin && !$match->getScorePlayer1()) {
                    $notificationService->sendScoreReminder($match->getPlayer1(), $match);
                }
            }
        }
    
        // Vérifier si les deux scores sont remplis
        if ($match->getScorePlayer1() !== null && $match->getScorePlayer2() !== null) {
            $match->setStatus('terminé');
        }
    
        $em->flush();
    
        return $this->json(['message' => 'Match updated'], 200);
    }

    #[Route('/api/tournaments/{idTournament}/sport-matchs/{idSportMatchs}', name: 'delete_match', methods: 'DELETE')]
    public function delete_match(Tournament $tournament, SportMatch $match, EntityManagerInterface $em): JsonResponse
    {
        if ($match->getTournament()->getId() !== $tournament->getId()) {
            return $this->json(['error' => 'Le match ne correspond pas à ce tournoi'], 400);
        }
    
        $em->remove($match);
        $em->flush();
    
        return $this->json(['message' => 'Match supprimé avec succès'], 200);
    }
}
