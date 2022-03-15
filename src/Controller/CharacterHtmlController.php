<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterHtmlType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CharacterServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/character/html')]
class CharacterHtmlController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    #[Route('/', name: 'app_character_html_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('character_html/index.html.twig', [
            'characters' => $this->characterService->getAll(),
        ]);
    }

    #[Route('/new', name: 'app_character_html_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $character = new Character();
        $form = $this->createForm(CharacterHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->characterService->createFromHtml($character);
            
            return $this->redirectToRoute('app_character_html_show', array(
                'id' => $character->getId(),
            ));
        }

        return $this->renderForm('character_html/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_html_show', methods: ['GET'])]
    public function show(Character $character): Response
    {
        return $this->render('character_html/show.html.twig', [
            'character' => $character,
        ]);
    }

    #[Route('/show_min_intelligence/{minIntelligence}', name: 'app_character_html_show_min_intelligence', methods: ['GET'])]
    public function showMinIntelligence(int $minIntelligence) : Response
    {
        return $this->render('character_html/index.html.twig', [
            'characters' => $this->characterService->showMinIntelligence($minIntelligence),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_character_html_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Character $character, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CharacterHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_character_html_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('character_html/edit.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_html_delete', methods: ['POST'])]
    public function delete(Request $request, Character $character, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$character->getId(), $request->request->get('_token'))) {
            $entityManager->remove($character);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_character_html_index', [], Response::HTTP_SEE_OTHER);
    }
}
