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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



use Symfony\Component\Validator\Validator\ValidatorInterface; //donc lui permet de validé des choses (tel que des tableaux, des obj et des valeurs) en fonct* de regle
// donc pour comparé tu utilises ca $validator->validate(...);
use Symfony\Component\Validator\Constraints as Assert; //permet de crée les contraites utilisé 


final class UserController extends AbstractController
{
    #[Route('/api/players', name: 'get_all', methods: 'GET')]
    public function index(EntityManagerInterface $em): JsonResponse  //tout les joueurs
    {
        $user = $em->getRepository(User::class)->findAll();
        return $this->json($user); 
    }

    #[Route('/register', name: 'create', methods: 'POST')]
    public function add_player(Request $request, EntityManagerInterface $em, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $user_violation = $validator->validate($data, new Assert\Collection([
            'lastName' => [new Assert\NotBlank(), new Assert\Regex('/^[\p{L}\s\-]+$/u')],
            'firstName' => [new Assert\NotBlank(), new Assert\Regex('/^[\p{L}\s\-]+$/u')],
            'username' => [new Assert\NotBlank(), new Assert\Regex('/^[\p{L}\s\-]+$/u')],
            'email' => [new Assert\NotBlank(), new Assert\Email()],
            'password' => [new Assert\NotBlank()],
        ]));

        if (count($user_violation) > 0) {
            $errors = [];
            foreach ($user_violation as $violation) {
                $errors[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors]);
        }

        $user = new User();
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);

        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['Etat' => 'user créé']);
    }


    #[Route('/api/players/{id}', name: 'get', methods: 'GET')]
    public function get_player(EntityManagerInterface $em, int $id): JsonResponse
    {
        $user = $em->getRepository(User::class)->find($id);

        if($user){
            return $this->json($user);
        }else{
            return new JsonReponse ([ 'errors' => 'User non existant']);
        }
    }
    
    #[Route('/api/players/{id}', name: 'edit', methods: 'PUT')]
    public function edit_player( int $id,Request $request,EntityManagerInterface $em,ValidatorInterface $validator,UserPasswordHasherInterface $passwordHasher): JsonResponse {

    $user = $em->getRepository(User::class)->find($id);

    if (!$user) {
        return new JsonResponse(['error' => 'Joueur non trouvé']);
    }

    $data = json_decode($request->getContent(), true);

   
    if (isset($data['firstName'])) {
        $user->setFirstName($data['firstName']);
    }
    if (isset($data['lastName'])) {
        $user->setLastName($data['lastName']);
    }
    if (isset($data['username'])) {
        $user->setUsername($data['username']);
    }
    if (isset($data['emailAddress'])) {
        $user->setEmailAddress($data['emailAddress']);
    }
    if (isset($data['status'])) {
        $user->setStatus($data['status']);
    }

    if (isset($data['password'])) {
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);
    }

    
    $errors = $validator->validate($user);
    if (count($errors) > 0) {
        $messages = [];
        foreach ($errors as $error) {
            $messages[$error->getPropertyPath()] = $error->getMessage();
        }
        return new JsonResponse($messages, 400);
    }

    
    $em->flush();

  
    return new JsonResponse(['message' => 'Joueur mis à jour avec succès']);
    }

    #[Route('/api/players/{id}', name: 'delete', methods: 'DELETE')]
    public function delete_player(EntityManagerInterface $em, int $id): JsonResponse
    {
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'Tournoi non trouvé']);
        }

        $em ->remove($user);
        $em->flush();
        return new JsonResponse(['message' => 'Tournoi supprimé']);

    }
}
