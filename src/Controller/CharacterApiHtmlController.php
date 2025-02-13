<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\CharacterApiHtmlType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @Route("/character/api-html")
 */
class CharacterApiHtmlController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/", name="character_api_html_index", methods={"GET"})
     */
    public function index(): Response
    {
        $response = $this->client->request(
            'GET',
            'http://localhost/LaGuildeDesSeigneurs/public/character/index'
        );

        return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    /**
     * @Route("/new", name="character_api_html_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $character = array();
        $form = $this->createForm(CharacterApiHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $response = $this->client->request(
                'POST',
                'http://localhost/LaGuildeDesSeigneurs/public/character/create' ,
                [
                    'json' => $request->request->all()['character_api_html']
                ]
            );

            return $this->redirectToRoute('character_api_html_show', array(
                'identifier' => $response->toArray()['identifier'],
            ));
        }

        return $this->renderForm('character_api_html/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{identifier}", name="character_api_html_show", methods={"GET"})
     */
    public function show(string $identifier): Response
    {
        $response = $this->client->request(
            'GET',
            'http://localhost/LaGuildeDesSeigneurs/public/character/display/' . $identifier);

        return $this->render('character_api_html/show.html.twig', [
            'character' => $response->toArray(),
        ]);
    }


    #[Route('/show_min_intelligence/{minIntelligence}', name: 'app_character_api_html_show_min_intelligence', methods: ['GET'])]
    public function showMinIntelligence(int $minIntelligence) : Response
    {
        $response = $this->client->request(
            'GET',
            'http://localhost/LaGuildeDesSeigneurs/public/character/show_min_intelligence/' . $minIntelligence);
            
            return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    #[Route('/show_min_life/{minLife}', name: 'app_character_api_html_show_min_life', methods: ['GET'])]
    public function showMinLife(int $minLife) : Response
    {
        $response = $this->client->request(
            'GET',
            'http://localhost/LaGuildeDesSeigneurs/public/character/show_min_life/' . $minLife);
            
            return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    #[Route('/show_same_caste/{caste}', name: 'app_character_api_html_show_same_caste', methods: ['GET'])]
    public function showSameCaste(string $caste) : Response
    {
        $response = $this->client->request(
            'GET',
            'http://localhost/LaGuildeDesSeigneurs/public/character/show_same_caste/' . $caste);
            
            return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    #[Route('/show_same_knowledge/{knowledge}', name: 'app_character_api_html_show_same_knowledge', methods: ['GET'])]
    public function showSameKnowledge(string $knowledge) : Response
    {
        $response = $this->client->request(
            'GET',
            'http://localhost/LaGuildeDesSeigneurs/public/character/show_same_knowledge/' . $knowledge);
            
            return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    /**
     * @Route("/{identifier}/edit", name="character_api_html_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, string $identifier): Response
    {

        $response = $this->client->request(
            'GET',
            'http://localhost/LaGuildeDesSeigneurs/public/character/display/' . $identifier);
        $character = $response->toArray();

        $form = $this->createForm(CharacterApiHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->client->request(
                'PUT',
                'http://localhost/LaGuildeDesSeigneurs/public/character/modify/' . $identifier,
                [
                    'json' => $request->request->all()['character_api_html']
                ]
            );

            return $this->redirectToRoute('character_api_html_show', array(
                'identifier' => $identifier,
            ));
        }

        return $this->renderForm('character_api_html/edit.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{identifier}", name="character_api_html_delete", methods={"POST"})
     */
    public function delete(Request $request, string $identifier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$identifier, $request->request->get('_token'))) {
            $this->client->request(
                'DELETE',
                'http://localhost/LaGuildeDesSeigneurs/public/character/delete  /' . $identifier);
        }

        return $this->redirectToRoute('character_api_html_index', [], Response::HTTP_SEE_OTHER);
    }
}
