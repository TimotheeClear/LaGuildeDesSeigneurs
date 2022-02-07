<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Character;

class CharacterController extends AbstractController
{
    /**
     * @Route("/character/display", name="character_display")
     */
    public function display(){
        $character = new Character();
        // dump($character);
        // dd($character->toArray());
        return new JsonResponse($character->toArray());
    }

    // /**
    //  * @Route("/character", name="character")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('character/index.html.twig', [
    //         'controller_name' => 'CharacterController',
    //     ]);
    // }
}
