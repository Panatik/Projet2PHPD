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


use Symfony\Component\Validator\Validator\ValidatorInterface; //donc lui permet de validé des choses (tel que des tableaux, des obj et des valeurs) en fonct* de regle
// donc pour comparé tu utilises ca $validator->validate(...);
use Symfony\Component\Validator\Constraints as Assert; //permet de crée les contraites utilisé 



final class TournamentController extends AbstractController
{
    #[Route('/api/tournaments', name: 'get_all', methods: 'GET')] //aucune contrainte
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->findAll();
        return $this->json($tournament); //self.json
    }

    #[Route('/api/tournaments', name: 'create', methods: 'POST')] //faut crée un tournois
    public function createTournament(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true); //ca permet de lire les infos 

        //contraite
        $format_violation = $validator->validate($data, new Assert\Collection([ // donc ici tu listes les "comportements" a suivre
            'name' => [new Assert\NotBlank(), new Assert\Regex('/^[\p{L}\s\-]+$/u') ],//pas vide et champs
            'startDate' => [new Assert\NotBlank(), new Assert\DateTime() ], //format date
            'endDate' => [new Assert\NotBlank(), new Assert\DateTime() ],
            'description' => new Assert\NotBlank(),
        ]));

        if(count($format_violation) > 0){ //si la réponse retourne plus de 1 c'est qu'il y a des erreurs dans le format donc erreur
            $errors = [];
            foreach ($format_violation as $violation) {
                $errors[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
            }
            return new JsonResponse ([ 'errors' => $errors]); //ici tu sais au moins le probleme
        }

        //sinon on crée le tournois et on le remplis

        $tournament = new Tournament();
        $tournament->setName($data['name']);
        $tournament->setStartDate(new \DateTime($data['startDate']));
        $tournament->setEndDate(new \DateTime($data['endDate']));
        $tournament->setDescription($data['description']);

        $em ->persist($tournament);
        $em ->flush(); //on envoie eheheh

        return new JsonReponse ([ 'Etat' => 'Tournois crée']); //ici tu dis c'est ok

    }

    #[Route('/api/tournaments/{id}', name: 'get', methods: 'GET')] //avoir un tournois par son id
    public function get_tournament(EntityManagerInterface $em, int $id): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->find($id);

        if($tournament){
            return $this->json($tournament);
        }else{
            return new JsonReponse ([ 'errors' => 'Tournois non existant']);
        }
        
    }

    #[Route('/api/tournaments/{id}', name: 'edit', methods: 'PUT')]
    public function edit_tournament(Request $request, EntityManagerInterface $em, ValidatorInterface $validator, int $id): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->find($id);
        if (!$tournament) {
            return new JsonResponse(['error' => 'Tournoi non trouvé']);
        }
    
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
            return new JsonResponse(['error' => 'JSON invalide']);
        }
    
        if (isset($data['tournamentName'])) {
            $tournament->setTournamentName($data['tournamentName']);
        }
    
        if (isset($data['startDate'])) {
            $tournament->setStartDate(new \DateTime($data['startDate']));
        }
    
        if (isset($data['endDate'])) {
            $tournament->setEndDate(new \DateTime($data['endDate']));
        }
    
        if (isset($data['location'])) {
            $tournament->setLocation($data['location']);
        }
    
        if (isset($data['description'])) {
            $tournament->setDescription($data['description']);
        }
    
        if (isset($data['maxParticipants'])) {
            $tournament->setMaxParticipants((int) $data['maxParticipants']);
        }
    
        if (isset($data['sport'])) {
            $tournament->setSport($data['sport']);
        }
    
        $violations = $validator->validate($tournament);
    
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
    
            return new JsonResponse(['errors' => $errors]);
        }

        $em->flush();
        return new JsonResponse(['message' => 'Tournoi mis à jour']);

    
    }

    #[Route('/api/tournaments/{id}', name: 'delete', methods: 'DELETE')]
    public function delete_tournament(EntityManagerInterface $em, int $id): JsonResponse
    {
        $tournament = $em->getRepository(Tournament::class)->find($id);

        if (!$tournament) {
            return new JsonResponse(['error' => 'Tournoi non trouvé']);
        }

        $em ->remove($tournament);
        $em->flush();
        return new JsonResponse(['message' => 'Tournoi supprimé']);

    }
}
