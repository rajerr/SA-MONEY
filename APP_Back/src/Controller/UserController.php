<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user/users/{id}", 
     * methods={"delete"},
     *     defaults={
     *         "__controller"="\app\Controller\UserController::bloquerUser",
     *         "__api_resource_class"=User::class,
     *     }
     * )
     */
    public function bloquerUser(UserRepository $userrepos, EntityManagerInterface $manager,$id): Response
    {
        $bloquerUser=$userrepos->find($id);
        $bloquerUser->setStatut(0);
        $manager->persist($bloquerUser);
        $manager->flush();
        return $this->json($bloquerUser,Response::HTTP_OK);
    }

        /**
     * @Route(
     *     path="/api/user/users",
     *     methods={"POST"}
     * )
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        $user = json_decode($request->getContent(), true);
        $user = $serializer->denormalize($user, "User:class", true);
        $errors = $validator->validate($user);
        if ($errors){
            $errors = $serializer->serialize($errors, "json");
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
        $password = $user['password'];
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setStatut(1);
        dd($user);
        $manager->persist($user);
        $manager->flush();

        return  $this->json($user, Response::HTTP_CREATED);

        fclose($avatar);
    }

    
}
