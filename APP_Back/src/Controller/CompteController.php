<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    // /**
    //  * @Route("/api/user/users/{id}", 
    //  * methods={"delete"},
    //  *     defaults={
    //  *         "__controller"="\app\Controller\CompteController::bloquerCompte",
    //  *         "__api_resource_class"=Comptes::class,
    //  *     }
    //  * )
    //  */
    // public function bloquerCompte(CompteRepository $compterepos, EntityManagerInterface $manager,$id): Response
    // {
    //     $bloquerCompte=$compterepos->find($id);
    //     $bloquerCompte->setStatut(0);
    //     $manager->persist($bloquerCompte);
    //     $manager->flush();
    //     return $this->json($bloquerCompte,Response::HTTP_OK);
    // }
}
